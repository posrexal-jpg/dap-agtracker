import 'dart:io';

import 'package:cots_tracker_app/main.dart';
import 'package:cots_tracker_app/screens/report_screen.dart';
import 'package:cots_tracker_app/services/location_catalog.dart';
import 'package:cots_tracker_app/state/app_state.dart';
import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:hive_ce/hive.dart';
import 'package:provider/provider.dart';

void main() {
  TestWidgetsFlutterBinding.ensureInitialized();
  late Directory directory;
  late Box<dynamic> box;
  late LocationCatalog catalog;

  setUpAll(() async {
    directory = await Directory.systemTemp.createTemp('cots_locations_test_');
    Hive.init(directory.path);
    box = await Hive.openBox<dynamic>('cots_data');
    catalog = await LocationCatalog.load();
  });

  tearDownAll(() async {
    await Hive.close();
    await Hive.deleteBoxFromDisk('cots_data');
    await directory.delete();
  });

  test('bundled catalog includes all 19 localities and 500 barangays', () {
    expect(catalog.municipalities, hasLength(19));
    expect(
      catalog.municipalities,
      containsAll(['Bontoc', 'City of Maasin', 'Limasawa']),
    );
    expect(
      catalog.municipalities.fold<int>(
        0,
        (total, municipality) =>
            total + catalog.barangaysFor(municipality).length,
      ),
      500,
    );
    expect(catalog.barangaysFor('Bontoc'), hasLength(40));
    expect(catalog.barangaysFor('Bontoc'), contains('Baugo'));
    expect(catalog.barangaysFor('Anahawan'), isNot(contains('Baugo')));
  });

  test('empty server lists and legacy Maasin names retain offline choices', () {
    expect(catalog.mergeMunicipalities(const []), hasLength(19));
    expect(
      catalog.mergeMunicipalities(['Maasin City', 'Bontoc', '']),
      hasLength(19),
    );
    expect(
      catalog.barangaysFor('Maasin City'),
      catalog.barangaysFor('City of Maasin'),
    );
    expect(
      catalog.mergeMunicipalities(['Custom municipality']),
      contains('Custom municipality'),
    );
  });

  for (final online in [false, true]) {
    test(
      'location choices load with no cached sync while online=$online',
      () async {
        await box.delete('municipalities');
        final state = AppState()..isOnline = online;
        await state.loadLocationCatalog();
        expect(state.municipalities, hasLength(19));
        expect(state.barangaysFor('Bontoc'), contains('Baugo'));
        state.dispose();
      },
    );
  }

  testWidgets(
    'offline barangays follow municipality and clear stale selections',
    (tester) async {
      tester.view.physicalSize = const Size(412, 915);
      tester.view.devicePixelRatio = 1;
      addTearDown(tester.view.resetPhysicalSize);
      addTearDown(tester.view.resetDevicePixelRatio);
      final state = AppState()..isOnline = false;
      await tester.runAsync(state.loadLocationCatalog);

      await tester.pumpWidget(
        ChangeNotifierProvider.value(
          value: state,
          child: MaterialApp(
            theme: buildCotsTheme(),
            home: Scaffold(body: ReportScreen(onSaved: () {})),
          ),
        ),
      );
      await tester.pump();

      final initialBarangay = tester.widget<DropdownButtonFormField<String>>(
        find.byKey(const ValueKey('barangay-null')),
      );
      expect(initialBarangay.onChanged, isNull);

      final municipality = find.byKey(const ValueKey('municipality-null'));
      Finder dropdownButton(Finder field) => find.descendant(
        of: field,
        matching: find.byType(DropdownButton<String>),
      );
      await tester.ensureVisible(dropdownButton(municipality));
      await tester.pumpAndSettle();
      await tester.tap(dropdownButton(municipality));
      await tester.pumpAndSettle();
      await tester.tap(find.text('Bontoc').last);
      await tester.pumpAndSettle();

      final bontocBarangay = find.byKey(const ValueKey('barangay-Bontoc'));
      expect(
        tester
            .widget<DropdownButton<String>>(
              find.descendant(
                of: bontocBarangay,
                matching: find.byType(DropdownButton<String>),
              ),
            )
            .items,
        hasLength(40),
      );
      await tester.ensureVisible(dropdownButton(bontocBarangay));
      await tester.pumpAndSettle();
      await tester.tap(dropdownButton(bontocBarangay));
      await tester.pumpAndSettle();
      await tester.tap(find.text('Baugo').last);
      await tester.pumpAndSettle();
      expect(
        tester.state<FormFieldState<String>>(bontocBarangay).value,
        'Baugo',
      );

      final selectedMunicipality = find.byKey(
        const ValueKey('municipality-Bontoc'),
      );
      await tester.ensureVisible(dropdownButton(selectedMunicipality));
      await tester.pumpAndSettle();
      await tester.tap(dropdownButton(selectedMunicipality));
      await tester.pumpAndSettle();
      await tester.scrollUntilVisible(
        find.text('Anahawan'),
        -80,
        scrollable: find.byType(Scrollable).last,
      );
      await tester.pumpAndSettle();
      await tester.tap(find.text('Anahawan').last);
      await tester.pumpAndSettle();

      final anahawanBarangay = find.byKey(const ValueKey('barangay-Anahawan'));
      expect(
        tester.state<FormFieldState<String>>(anahawanBarangay).value,
        isNull,
      );
      final options = tester
          .widget<DropdownButton<String>>(
            find.descendant(
              of: anahawanBarangay,
              matching: find.byType(DropdownButton<String>),
            ),
          )
          .items!;
      expect(options.map((option) => option.value), contains('Amagusan'));
      expect(options.map((option) => option.value), isNot(contains('Baugo')));
      expect(tester.takeException(), isNull);

      await tester.pumpWidget(const SizedBox());
      state.dispose();
    },
  );
}
