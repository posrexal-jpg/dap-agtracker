import 'package:hive_ce/hive.dart';

import '../models/sighting.dart';
import '../config/app_config.dart';

class LocalStore {
  final Box<dynamic> _box = Hive.box<dynamic>('cots_data');

  List<Sighting> getSightings() {
    final values = (_box.get('sightings', defaultValue: <dynamic>[]) as List);
    return values
        .map((value) => Sighting.fromMap(Map<dynamic, dynamic>.from(value)))
        .toList();
  }

  Future<void> saveSightings(List<Sighting> sightings) =>
      _box.put('sightings', sightings.map((e) => e.toLocalMap()).toList());

  Map<String, dynamic>? get user {
    final value = _box.get('user');
    return value == null ? null : Map<String, dynamic>.from(value as Map);
  }

  Future<void> saveUser(Map<String, dynamic>? user) =>
      user == null ? _box.delete('user') : _box.put('user', user);

  List<String> get municipalities =>
      List<String>.from(_box.get('municipalities', defaultValue: <String>[]));

  Future<void> saveMunicipalities(List<String> values) =>
      _box.put('municipalities', values);

  List<String> get activityTypes =>
      List<String>.from(_box.get('activity_types', defaultValue: <String>[]));

  Future<void> saveActivityTypes(List<String> values) =>
      _box.put('activity_types', values);

  bool get hasSeenPartnershipWelcome =>
      _box.get('partnership_welcome_v1_seen', defaultValue: false) as bool;

  Future<void> markPartnershipWelcomeSeen() =>
      _box.put('partnership_welcome_v1_seen', true);

  String get apiBaseUrl =>
      AppConfig.resolveApiBaseUrl(_box.get('api_base_url') as String?);

  Future<void> saveApiBaseUrl(String value) {
    var v = value.trim().replaceAll(RegExp(r'/$'), '');
    // If the user provided a host only (no /api segment), append /api/v1
    if (!v.contains('/api')) {
      v = '$v/api/v1';
    }
    return _box.put('api_base_url', v);
  }

  String get rememberedEmail =>
      _box.get('remembered_email', defaultValue: '') as String;

  Future<void> saveRememberedEmail(String? email) =>
      email == null || email.isEmpty
      ? _box.delete('remembered_email')
      : _box.put('remembered_email', email);

  Future<void> clearSession() async {
    await _box.delete('user');
  }
}
