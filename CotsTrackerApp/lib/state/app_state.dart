import 'dart:async';

import 'package:connectivity_plus/connectivity_plus.dart';
import 'package:flutter/foundation.dart';
import 'package:google_sign_in/google_sign_in.dart';

import '../models/sighting.dart';
import '../services/api_service.dart';
import '../services/local_store.dart';
import '../services/location_catalog.dart';

class AppState extends ChangeNotifier {
  final LocalStore _store = LocalStore();
  StreamSubscription<List<ConnectivityResult>>? _connectivitySubscription;

  late ApiService _api;
  bool initialized = false;
  bool isOnline = true;
  bool isSyncing = false;
  String? syncMessage;
  Map<String, dynamic>? user;
  List<Sighting> sightings = [];
  List<String> municipalities = [];
  LocationCatalog _locationCatalog = const LocationCatalog.empty();
  int totalSightings = 0;
  int userSightings = 0;
  int outbreakThreshold = 15;

  bool get isAuthenticated => user != null;
  int get pendingCount =>
      sightings.where((item) => item.syncStatus != SyncStatus.synced).length;
  int get mySightings => sightings
      .where(
        (item) =>
            item.serverId == null ||
            item.observerName == user?['name'] ||
            item.clientUuid.isNotEmpty,
      )
      .length;
  String get apiBaseUrl => _store.apiBaseUrl;
  String get rememberedEmail => _store.rememberedEmail;

  List<String> barangaysFor(String? municipality) =>
      _locationCatalog.barangaysFor(municipality);

  String canonicalMunicipality(String name) =>
      _locationCatalog.canonicalName(name);

  Future<void> loadLocationCatalog() async {
    _locationCatalog = await LocationCatalog.load();
    municipalities = _locationCatalog.mergeMunicipalities([
      ..._store.municipalities,
      ...municipalities,
    ]);
    notifyListeners();
  }

  Future<void> initialize() async {
    final startupStarted = DateTime.now();
    _api = ApiService(_store.apiBaseUrl);
    user = _store.user;
    sightings = _store.getSightings();
    await loadLocationCatalog();
    final connectivity = Connectivity();
    final result = await connectivity.checkConnectivity();
    isOnline = !result.contains(ConnectivityResult.none);
    if (user != null && isOnline) {
      try {
        user = await _api.me();
        await _store.saveUser(user);
      } catch (error) {
        if (ApiService.isUnauthorized(error)) {
          user = null;
          await _api.clearToken();
          await _store.clearSession();
        }
      }
    }
    _connectivitySubscription = connectivity.onConnectivityChanged.listen((
      results,
    ) {
      final wasOffline = !isOnline;
      isOnline = !results.contains(ConnectivityResult.none);
      notifyListeners();
      if (wasOffline && isOnline && isAuthenticated) synchronize();
    });
    final elapsed = DateTime.now().difference(startupStarted);
    const minimumLoadingTime = Duration(milliseconds: 2200);
    if (elapsed < minimumLoadingTime) {
      await Future<void>.delayed(minimumLoadingTime - elapsed);
    }
    initialized = true;
    notifyListeners();
    if (isAuthenticated && isOnline) unawaited(synchronize());
  }

  Future<String?> login(
    String email,
    String password, {
    bool rememberEmail = true,
  }) async {
    try {
      user = await _api.login(email.trim(), password);
      await _store.saveUser(user);
      await _store.saveRememberedEmail(rememberEmail ? email.trim() : null);
      notifyListeners();
      await synchronize();
      return null;
    } catch (error) {
      return ApiService.messageFor(error);
    }
  }

  Future<String?> loginWithGoogle() async {
    try {
      final google = GoogleSignIn.instance;
      await google.initialize(serverClientId: await _api.googleClientId());
      final account = await google.authenticate();
      final idToken = account.authentication.idToken;
      if (idToken == null) return 'Google did not return an identity token.';
      user = await _api.googleLogin(idToken);
      await _store.saveUser(user);
      notifyListeners();
      await synchronize();
      return null;
    } on GoogleSignInException catch (error) {
      if (error.code == GoogleSignInExceptionCode.canceled) return null;
      return error.description ?? 'Google Sign-In failed.';
    } catch (error) {
      return ApiService.messageFor(error);
    }
  }

  Future<void> logout() async {
    if (isOnline) {
      try {
        await _api.logout();
      } catch (_) {
        await _api.clearToken();
      }
    } else {
      await _api.clearToken();
    }
    user = null;
    await _store.clearSession();
    notifyListeners();
  }

  Future<void> addSighting(Sighting sighting) async {
    sightings.insert(0, sighting);
    await _store.saveSightings(sightings);
    notifyListeners();
    if (isOnline) unawaited(synchronize());
  }

  Future<void> synchronize() async {
    if (!isOnline || !isAuthenticated || isSyncing) return;
    isSyncing = true;
    syncMessage = null;
    notifyListeners();

    try {
      for (var i = 0; i < sightings.length; i++) {
        final local = sightings[i];
        if (local.syncStatus == SyncStatus.synced) continue;
        sightings[i] = local.copyWith(syncStatus: SyncStatus.syncing);
        notifyListeners();
        try {
          final remote = await _api.upload(local);
          sightings[i] = remote.copyWith(syncStatus: SyncStatus.synced);
          await _store.saveSightings(sightings);
        } catch (_) {
          sightings[i] = local.copyWith(syncStatus: SyncStatus.failed);
          await _store.saveSightings(sightings);
        }
      }

      final data = await _api.bootstrap();
      final stats = Map<String, dynamic>.from(data['stats'] as Map? ?? {});
      totalSightings = int.tryParse('${stats['total_sightings'] ?? 0}') ?? 0;
      userSightings = int.tryParse('${stats['user_sightings'] ?? 0}') ?? 0;
      outbreakThreshold =
          int.tryParse('${data['outbreak_threshold'] ?? 15}') ?? 15;
      final serverMunicipalities = (data['municipalities'] as List? ?? const [])
          .map((value) => value is Map ? value['name'] : value)
          .whereType<String>();
      municipalities = _locationCatalog.mergeMunicipalities([
        ...municipalities,
        ...serverMunicipalities,
      ]);
      await _store.saveMunicipalities(municipalities);
      final remote = (data['sightings'] as List? ?? [])
          .map((value) => Sighting.fromMap(value as Map))
          .toList();
      final unsynced = sightings
          .where((item) => item.syncStatus != SyncStatus.synced)
          .toList();
      final remoteIds = remote.map((item) => item.clientUuid).toSet();
      sightings = [
        ...unsynced.where((item) => !remoteIds.contains(item.clientUuid)),
        ...remote,
      ];
      await _store.saveSightings(sightings);
      syncMessage = pendingCount == 0
          ? 'All data is up to date'
          : '$pendingCount pending';
    } catch (error) {
      syncMessage = ApiService.messageFor(error);
    } finally {
      isSyncing = false;
      notifyListeners();
    }
  }

  Future<String?> updateProfile(String name) async {
    try {
      user = await _api.updateProfile(name.trim());
      await _store.saveUser(user);
      notifyListeners();
      return null;
    } catch (error) {
      return ApiService.messageFor(error);
    }
  }

  Future<String?> updatePassword(String current, String password) async {
    try {
      await _api.updatePassword(current, password);
      return null;
    } catch (error) {
      return ApiService.messageFor(error);
    }
  }

  Future<String?> deleteSighting(Sighting sighting) async {
    if (sighting.serverId != null && !isOnline) {
      return 'Connect to the internet before deleting a synchronized report.';
    }
    try {
      if (sighting.serverId != null) {
        await _api.deleteSighting(sighting.serverId!);
      }
      sightings.removeWhere((item) => item.clientUuid == sighting.clientUuid);
      await _store.saveSightings(sightings);
      userSightings = (userSightings - 1).clamp(0, 1 << 31);
      totalSightings = (totalSightings - 1).clamp(0, 1 << 31);
      notifyListeners();
      return null;
    } catch (error) {
      return ApiService.messageFor(error);
    }
  }

  Future<void> deleteUnsyncedSightings() async {
    sightings.removeWhere((item) => item.syncStatus != SyncStatus.synced);
    await _store.saveSightings(sightings);
    syncMessage = 'Unsynced reports removed';
    notifyListeners();
  }

  Future<void> updateApiBaseUrl(String value) async {
    await _store.saveApiBaseUrl(value);
    _api = ApiService(_store.apiBaseUrl);
    syncMessage = 'API address updated';
    notifyListeners();
  }

  @override
  void dispose() {
    _connectivitySubscription?.cancel();
    super.dispose();
  }
}
