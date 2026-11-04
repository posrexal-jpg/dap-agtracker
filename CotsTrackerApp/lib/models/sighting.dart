import 'dart:typed_data';

class Sighting {
  Sighting({
    required this.clientUuid,
    required this.locationName,
    required this.latitude,
    required this.longitude,
    required this.barangay,
    required this.dateOfSighting,
    required this.timeOfSighting,
    this.serverId,
    this.observerName,
    this.municipality,
    this.description,
    this.language = 'en',
    this.activityType,
    this.observerCategory,
    this.earlyJuvenile = 0,
    this.juvenile = 0,
    this.subAdult = 0,
    this.adult = 0,
    this.lateAdult = 0,
    this.photoBytes = const [],
    this.remotePhotos = const [],
    this.syncStatus = SyncStatus.pending,
    DateTime? createdAt,
  }) : createdAt = createdAt ?? DateTime.now();

  final String clientUuid;
  final int? serverId;
  final String locationName;
  final double latitude;
  final double longitude;
  final String barangay;
  final String? municipality;
  final String? observerName;
  final String? description;
  final String language;
  final String? activityType;
  final String? observerCategory;
  final int earlyJuvenile;
  final int juvenile;
  final int subAdult;
  final int adult;
  final int lateAdult;
  final String dateOfSighting;
  final String timeOfSighting;
  final List<Uint8List> photoBytes;
  final List<String> remotePhotos;
  final SyncStatus syncStatus;
  final DateTime createdAt;

  int get total => earlyJuvenile + juvenile + subAdult + adult + lateAdult;

  Sighting copyWith({
    int? serverId,
    List<String>? remotePhotos,
    SyncStatus? syncStatus,
  }) {
    return Sighting(
      clientUuid: clientUuid,
      serverId: serverId ?? this.serverId,
      locationName: locationName,
      latitude: latitude,
      longitude: longitude,
      barangay: barangay,
      municipality: municipality,
      observerName: observerName,
      description: description,
      language: language,
      activityType: activityType,
      observerCategory: observerCategory,
      earlyJuvenile: earlyJuvenile,
      juvenile: juvenile,
      subAdult: subAdult,
      adult: adult,
      lateAdult: lateAdult,
      dateOfSighting: dateOfSighting,
      timeOfSighting: timeOfSighting,
      photoBytes: photoBytes,
      remotePhotos: remotePhotos ?? this.remotePhotos,
      syncStatus: syncStatus ?? this.syncStatus,
      createdAt: createdAt,
    );
  }

  Map<String, dynamic> toLocalMap() => {
    'client_uuid': clientUuid,
    'server_id': serverId,
    'location_name': locationName,
    'latitude': latitude,
    'longitude': longitude,
    'barangay': barangay,
    'municipality': municipality,
    'name': observerName,
    'description': description,
    'language': language,
    'activity_type': activityType,
    'observer_category': observerCategory,
    'early_juvenile': earlyJuvenile,
    'juvenile': juvenile,
    'sub_adult': subAdult,
    'adult': adult,
    'late_adult': lateAdult,
    'date_of_sighting': dateOfSighting,
    'time_of_sighting': timeOfSighting,
    'photo_bytes': photoBytes,
    'remote_photos': remotePhotos,
    'sync_status': syncStatus.name,
    'created_at': createdAt.toIso8601String(),
  };

  Map<String, dynamic> toApiMap() => {
    'client_uuid': clientUuid,
    'location_name': locationName,
    'latitude': latitude,
    'longitude': longitude,
    'barangay': barangay,
    'municipality': municipality,
    'name': observerName,
    'description': description,
    'language': language,
    'activity_type': activityType,
    'observer_category': observerCategory,
    'early_juvenile': earlyJuvenile,
    'juvenile': juvenile,
    'sub_adult': subAdult,
    'adult': adult,
    'late_adult': lateAdult,
    'number_of_cots': total.toString(),
    'date_of_sighting': dateOfSighting,
    'time_of_sighting': timeOfSighting,
  };

  factory Sighting.fromMap(Map<dynamic, dynamic> map) {
    int integer(String key) => int.tryParse('${map[key] ?? 0}') ?? 0;
    final uuid = '${map['client_uuid'] ?? ''}';
    return Sighting(
      clientUuid: uuid.isEmpty ? 'server-${map['id']}' : uuid,
      serverId: integerOrNull(map['server_id'] ?? map['id']),
      locationName: '${map['location_name'] ?? map['name'] ?? 'Unknown site'}',
      latitude: double.tryParse('${map['latitude']}') ?? 0,
      longitude: double.tryParse('${map['longitude']}') ?? 0,
      barangay: '${map['barangay'] ?? ''}',
      municipality: map['municipality']?.toString(),
      observerName: map['name']?.toString(),
      description: map['description']?.toString(),
      language: '${map['language'] ?? 'en'}',
      activityType: map['activity_type']?.toString(),
      observerCategory: map['observer_category']?.toString(),
      earlyJuvenile: integer('early_juvenile'),
      juvenile: integer('juvenile'),
      subAdult: integer('sub_adult'),
      adult: integer('adult'),
      lateAdult: integer('late_adult'),
      dateOfSighting: '${map['date_of_sighting'] ?? ''}',
      timeOfSighting: '${map['time_of_sighting'] ?? ''}'.substring(
        0,
        '${map['time_of_sighting'] ?? ''}'.length.clamp(0, 5),
      ),
      photoBytes: (map['photo_bytes'] as List? ?? [])
          .map((e) => Uint8List.fromList(List<int>.from(e as List)))
          .toList(),
      remotePhotos: List<String>.from(
        map['remote_photos'] ?? map['photos'] ?? const [],
      ),
      syncStatus: SyncStatus.values.firstWhere(
        (value) => value.name == map['sync_status'],
        orElse: () =>
            map['id'] != null ? SyncStatus.synced : SyncStatus.pending,
      ),
      createdAt:
          DateTime.tryParse('${map['created_at'] ?? ''}') ?? DateTime.now(),
    );
  }

  static int? integerOrNull(dynamic value) =>
      value == null ? null : int.tryParse('$value');
}

enum SyncStatus { pending, syncing, synced, failed }
