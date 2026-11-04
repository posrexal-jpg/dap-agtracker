import 'package:cots_tracker_app/models/sighting.dart';
import 'package:flutter_test/flutter_test.dart';

void main() {
  test('computes total COTS count and survives local serialization', () {
    final original = Sighting(
      clientUuid: '6c0ae732-88b6-4fc6-97b8-a24341dc8d45',
      locationName: 'Test reef',
      latitude: 10.25,
      longitude: 125.01,
      barangay: 'San Roque',
      dateOfSighting: '2026-07-23',
      timeOfSighting: '11:30',
      earlyJuvenile: 1,
      juvenile: 2,
      subAdult: 3,
      adult: 4,
      lateAdult: 5,
    );

    expect(original.total, 15);
    final restored = Sighting.fromMap(original.toLocalMap());
    expect(restored.clientUuid, original.clientUuid);
    expect(restored.locationName, 'Test reef');
    expect(restored.total, 15);
  });
}
