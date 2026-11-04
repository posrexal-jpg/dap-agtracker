import 'dart:io';

import 'package:cots_tracker_app/main.dart';
import 'package:cots_tracker_app/screens/loading_screen.dart';
import 'package:cots_tracker_app/screens/login_screen.dart';
import 'package:cots_tracker_app/screens/settings_screen.dart';
import 'package:cots_tracker_app/services/local_store.dart';
import 'package:cots_tracker_app/state/app_state.dart';
import 'package:cots_tracker_app/widgets/partnership_welcome.dart';
import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:hive_ce/hive.dart';
import 'package:package_info_plus/package_info_plus.dart';
import 'package:provider/provider.dart';

void main() {
  late Directory directory;
  late Box<dynamic> box;

  setUpAll(() async {
    directory = await Directory.systemTemp.createTemp('cots_partnership_test_');
    Hive.init(directory.path);
    box = await Hive.openBox<dynamic>('cots_data');
    PackageInfo.setMockInitialValues(
      appName: 'COTS Tracker',
      packageName: 'cots_tracker_app',
      version: '1.2.0',
      buildNumber: '4',
      buildSignature: '',
    );
  });

  setUp(() => box.delete('partnership_welcome_v1_seen'));

  tearDownAll(() async {
    await Hive.close();
    await Hive.deleteBoxFromDisk('cots_data');
    await directory.delete();
  });

  testWidgets(
    'welcome appears once and remembers dismissal across app entries',
    (tester) async {
      final welcomeStore = _MemoryWelcomeStore();
      await tester.pumpWidget(
        MaterialApp(
          theme: buildCotsTheme(),
          home: PartnershipWelcomeGate(
            store: welcomeStore,
            child: const Scaffold(body: Text('Application content')),
          ),
        ),
      );
      await tester.pumpAndSettle();
      expect(find.text('Our shared mission'), findsOneWidget);
      expect(find.bySemanticsLabel('SLSU logo'), findsOneWidget);
      expect(find.bySemanticsLabel('DOST logo'), findsOneWidget);

      await tester.ensureVisible(find.text('Get started'));
      await tester.pumpAndSettle();
      await tester.tap(find.text('Get started'));
      await tester.pumpAndSettle();
      expect(welcomeStore.hasSeenPartnershipWelcome, isTrue);

      await tester.pumpWidget(const SizedBox());
      await tester.pumpWidget(
        MaterialApp(
          theme: buildCotsTheme(),
          home: PartnershipWelcomeGate(
            store: welcomeStore,
            child: const Scaffold(body: Text('Application content')),
          ),
        ),
      );
      await tester.pumpAndSettle();
      expect(find.text('Our shared mission'), findsNothing);
      expect(find.text('Application content'), findsOneWidget);
      expect(tester.takeException(), isNull);
    },
  );

  test('signing out does not reset the partnership introduction', () async {
    final store = LocalStore();
    await store.markPartnershipWelcomeSeen();
    await store.clearSession();
    expect(store.hasSeenPartnershipWelcome, isTrue);
  });

  testWidgets('privacy policy is reachable before and after sign-in', (
    tester,
  ) async {
    final state = AppState()..isOnline = false;
    Widget app(Widget screen) => ChangeNotifierProvider.value(
      value: state,
      child: MaterialApp(theme: buildCotsTheme(), home: screen),
    );

    await tester.pumpWidget(app(const LoginScreen()));
    expect(find.text('Privacy policy'), findsOneWidget);
    await tester.pumpWidget(app(const Scaffold(body: SettingsScreen())));
    expect(find.text('Privacy policy'), findsOneWidget);
    expect(find.text('Request account deletion'), findsOneWidget);
    await tester.pumpWidget(const SizedBox());
    state.dispose();
  });

  testWidgets(
    'Settings can reopen the partnership after the welcome was seen',
    (tester) async {
      await tester.runAsync(() => LocalStore().markPartnershipWelcomeSeen());
      final state = AppState()..isOnline = false;
      await tester.pumpWidget(
        ChangeNotifierProvider.value(
          value: state,
          child: MaterialApp(
            theme: buildCotsTheme(),
            home: const Scaffold(body: SettingsScreen()),
          ),
        ),
      );
      await tester.pumpAndSettle();
      await tester.tap(find.text('SLSU × DOST partnership'));
      await tester.pumpAndSettle();
      expect(find.text('Our shared mission'), findsOneWidget);
      await tester.tap(find.byTooltip('Close welcome'));
      await tester.pumpAndSettle();
      expect(find.text('Our shared mission'), findsNothing);
      expect(tester.takeException(), isNull);
      await tester.pumpWidget(const SizedBox());
      state.dispose();
    },
  );

  for (final scenario in [
    ('compact portrait', const Size(360, 800), 1.0),
    ('landscape', const Size(740, 360), 1.0),
    ('large text', const Size(360, 800), 1.6),
  ]) {
    testWidgets('partnership welcome remains usable in ${scenario.$1}', (
      tester,
    ) async {
      tester.view.physicalSize = scenario.$2;
      tester.view.devicePixelRatio = 1;
      addTearDown(tester.view.resetPhysicalSize);
      addTearDown(tester.view.resetDevicePixelRatio);
      await tester.pumpWidget(
        MaterialApp(
          theme: buildCotsTheme(),
          builder: (context, child) => MediaQuery(
            data: MediaQuery.of(
              context,
            ).copyWith(textScaler: TextScaler.linear(scenario.$3)),
            child: child!,
          ),
          home: Builder(
            builder: (context) => Scaffold(
              body: Center(
                child: TextButton(
                  onPressed: () => showPartnershipWelcome(context),
                  child: const Text('Show partnership'),
                ),
              ),
            ),
          ),
        ),
      );
      await tester.tap(find.text('Show partnership'));
      await tester.pumpAndSettle();
      expect(tester.takeException(), isNull);
      await tester.ensureVisible(find.text('Get started'));
      await tester.pumpAndSettle();
      await tester.tap(find.text('Get started'));
      await tester.pumpAndSettle();
      expect(find.text('Our shared mission'), findsNothing);
      expect(tester.takeException(), isNull);
    });
  }

  testWidgets('branded loading screen fits landscape', (tester) async {
    tester.view.physicalSize = const Size(740, 360);
    tester.view.devicePixelRatio = 1;
    addTearDown(tester.view.resetPhysicalSize);
    addTearDown(tester.view.resetDevicePixelRatio);
    await tester.pumpWidget(
      MaterialApp(theme: buildCotsTheme(), home: const LoadingScreen()),
    );
    await tester.pump(const Duration(milliseconds: 300));
    expect(tester.takeException(), isNull);
    await tester.pumpWidget(const SizedBox());
  });
}

class _MemoryWelcomeStore extends LocalStore {
  bool seen = false;

  @override
  bool get hasSeenPartnershipWelcome => seen;

  @override
  Future<void> markPartnershipWelcomeSeen() async {
    seen = true;
  }
}
