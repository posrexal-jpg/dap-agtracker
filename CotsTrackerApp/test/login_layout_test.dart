import 'dart:io';

import 'package:cots_tracker_app/main.dart';
import 'package:cots_tracker_app/screens/login_screen.dart';
import 'package:cots_tracker_app/screens/report_screen.dart';
import 'package:cots_tracker_app/state/app_state.dart';
import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:hive_ce/hive.dart';
import 'package:provider/provider.dart';

void main() {
  late Directory hiveDirectory;

  setUpAll(() async {
    hiveDirectory = await Directory.systemTemp.createTemp('cots_ui_test_');
    Hive.init(hiveDirectory.path);
    await Hive.openBox<dynamic>('cots_data');
  });

  tearDownAll(() async {
    await Hive.close();
    await hiveDirectory.delete(recursive: true);
  });

  testWidgets('professional login fits a compact mobile viewport', (
    tester,
  ) async {
    tester.view.physicalSize = const Size(412, 915);
    tester.view.devicePixelRatio = 1;
    addTearDown(tester.view.resetPhysicalSize);
    addTearDown(tester.view.resetDevicePixelRatio);

    await tester.pumpWidget(
      MaterialApp(theme: buildCotsTheme(), home: const LoginScreen()),
    );
    await tester.pumpAndSettle();

    expect(find.bySemanticsLabel('COTS Tracker logo'), findsOneWidget);
    expect(find.text('Marine field monitoring'), findsOneWidget);
    expect(find.text('Sign in'), findsOneWidget);
    final layoutException = tester.takeException();
    if (layoutException is FlutterError) {
      debugPrint(layoutException.toStringDeep());
    }
    expect(layoutException, isNull);
  });

  testWidgets('offline report includes map confirmation controls', (
    tester,
  ) async {
    tester.view.physicalSize = const Size(412, 915);
    tester.view.devicePixelRatio = 1;
    addTearDown(tester.view.resetPhysicalSize);
    addTearDown(tester.view.resetDevicePixelRatio);
    final state = AppState()..isOnline = false;

    await tester.pumpWidget(
      ChangeNotifierProvider.value(
        value: state,
        child: MaterialApp(
          theme: buildCotsTheme(),
          home: ReportScreen(onSaved: () {}),
        ),
      ),
    );
    await tester.pump();

    expect(
      find.text('Offline · previously viewed map tiles remain available'),
      findsOneWidget,
    );
    expect(find.text('Use current location'), findsOneWidget);
    expect(find.text('Confirm this location'), findsOneWidget);
    expect(tester.takeException(), isNull);
  });
}
