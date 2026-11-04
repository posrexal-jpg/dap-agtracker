import 'package:flutter/material.dart';
import 'package:hive_ce_flutter/hive_flutter.dart';
import 'package:provider/provider.dart';

import 'screens/home_screen.dart';
import 'screens/login_screen.dart';
import 'screens/loading_screen.dart';
import 'state/app_state.dart';
import 'services/offline_map_service.dart';
import 'theme/cots_theme.dart';
import 'widgets/partnership_welcome.dart';

export 'theme/cots_theme.dart' show buildCotsTheme;

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Hive.initFlutter();
  await Hive.openBox<dynamic>('cots_data');
  await OfflineMapService.initialize();
  runApp(const CotsTrackerApp());
}

class CotsTrackerApp extends StatelessWidget {
  const CotsTrackerApp({super.key});

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (_) => AppState()..initialize(),
      child: MaterialApp(
        title: 'COTS Tracker',
        debugShowCheckedModeBanner: false,
        theme: buildCotsTheme(),
        home: Consumer<AppState>(
          builder: (context, state, _) {
            if (!state.initialized) {
              return const LoadingScreen();
            }
            return PartnershipWelcomeGate(
              child: state.isAuthenticated
                  ? const HomeScreen()
                  : const LoginScreen(),
            );
          },
        ),
      ),
    );
  }
}
