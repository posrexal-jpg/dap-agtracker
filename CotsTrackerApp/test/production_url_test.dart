import 'dart:io';

import 'package:cots_tracker_app/config/app_config.dart';
import 'package:cots_tracker_app/services/local_store.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:hive_ce/hive.dart';

void main() {
  late Directory directory;
  late Box<dynamic> box;

  setUpAll(() async {
    directory = await Directory.systemTemp.createTemp('cots_production_test_');
    Hive.init(directory.path);
    box = await Hive.openBox<dynamic>('cots_data');
  });

  setUp(() => box.clear());

  tearDownAll(() async {
    await Hive.close();
    await Hive.deleteBoxFromDisk('cots_data');
    await directory.delete();
  });

  test('fresh installations use the production API', () {
    expect(LocalStore().apiBaseUrl, 'https://cotstracker.com/api/v1');
  });

  test(
    'upgrades replace saved legacy hosts without losing local reports',
    () async {
      for (final host in ['dap-ad.slsubc.com', 'dap-ag.slsubc.com']) {
        await box.put('api_base_url', 'https://$host/api/v1');
        await box.put('sightings', [
          {'client_uuid': 'pending-report'},
        ]);

        expect(LocalStore().apiBaseUrl, AppConfig.productionApiBaseUrl);
        expect(
          (box.get('sightings') as List).single['client_uuid'],
          'pending-report',
        );
      }
    },
  );

  test('custom development endpoints remain configurable', () async {
    final store = LocalStore();
    await store.saveApiBaseUrl('http://10.0.2.2:8000/');
    expect(store.apiBaseUrl, 'http://10.0.2.2:8000/api/v1');
  });
}
