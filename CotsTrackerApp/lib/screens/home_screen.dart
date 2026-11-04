import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../state/app_state.dart';
import '../theme/cots_theme.dart';
import '../widgets/app_brand.dart';
import '../widgets/partnership_welcome.dart';
import 'dashboard_screen.dart';
import 'account_screen.dart';
import 'report_screen.dart';
import 'settings_screen.dart';
import 'sightings_screen.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  int _index = 0;

  static const _destinations = [
    NavigationDestination(
      icon: Icon(Icons.dashboard_outlined),
      selectedIcon: Icon(Icons.dashboard),
      label: 'Dashboard',
    ),
    NavigationDestination(
      icon: Icon(Icons.map_outlined),
      selectedIcon: Icon(Icons.map),
      label: 'Sightings',
    ),
    NavigationDestination(
      icon: Icon(Icons.add_location_alt_outlined),
      selectedIcon: Icon(Icons.add_location_alt),
      label: 'Report',
    ),
    NavigationDestination(
      icon: Icon(Icons.person_outline),
      selectedIcon: Icon(Icons.person),
      label: 'Account',
    ),
    NavigationDestination(
      icon: Icon(Icons.settings_outlined),
      selectedIcon: Icon(Icons.settings),
      label: 'Settings',
    ),
  ];

  @override
  Widget build(BuildContext context) {
    final state = context.watch<AppState>();
    final pages = [
      DashboardScreen(onReport: () => setState(() => _index = 2)),
      const SightingsScreen(),
      ReportScreen(onSaved: () => setState(() => _index = 0)),
      const AccountScreen(),
      const SettingsScreen(),
    ];
    final wide = MediaQuery.sizeOf(context).width >= 800;

    final content = Column(
      children: [
        Padding(
          padding: const EdgeInsets.fromLTRB(20, 12, 12, 12),
          child: Row(
            children: [
              const CotsMark(size: 44),
              const SizedBox(width: 12),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      'COTS Tracker',
                      style: Theme.of(context).textTheme.titleMedium?.copyWith(
                        fontWeight: FontWeight.w800,
                        color: CotsColors.ink,
                      ),
                    ),
                    Text(
                      'Southern Leyte reef monitoring',
                      style: Theme.of(
                        context,
                      ).textTheme.bodySmall?.copyWith(color: CotsColors.muted),
                    ),
                  ],
                ),
              ),
              IconButton(
                tooltip: 'About our partnership',
                onPressed: () => showPartnershipWelcome(context),
                icon: const Icon(
                  Icons.handshake_outlined,
                  color: CotsColors.primary,
                ),
              ),
            ],
          ),
        ),
        Material(
          color: state.isOnline
              ? const Color(0xFFE2F5EC)
              : const Color(0xFFFFE8C8),
          child: InkWell(
            onTap: state.isOnline ? state.synchronize : null,
            child: Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 7),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(
                    state.isOnline ? Icons.cloud_done : Icons.cloud_off,
                    size: 17,
                  ),
                  const SizedBox(width: 8),
                  Flexible(
                    child: Text(
                      state.isOnline
                          ? state.isSyncing
                                ? 'Synchronizing…'
                                : state.pendingCount > 0
                                ? '${state.pendingCount} waiting to sync · Tap to retry'
                                : 'Online · Data synchronized'
                          : 'Offline · New reports will be saved on this device',
                      textAlign: TextAlign.center,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
        Expanded(
          child: IndexedStack(index: _index, children: pages),
        ),
      ],
    );

    return Scaffold(
      body: SafeArea(
        child: wide
            ? Row(
                children: [
                  NavigationRail(
                    selectedIndex: _index,
                    onDestinationSelected: (value) =>
                        setState(() => _index = value),
                    labelType: NavigationRailLabelType.all,
                    leading: const Padding(
                      padding: EdgeInsets.symmetric(vertical: 18),
                      child: CotsMark(size: 58),
                    ),
                    destinations: _destinations
                        .map(
                          (item) => NavigationRailDestination(
                            icon: item.icon,
                            selectedIcon: item.selectedIcon,
                            label: Text(item.label),
                          ),
                        )
                        .toList(),
                  ),
                  const VerticalDivider(width: 1),
                  Expanded(child: content),
                ],
              )
            : content,
      ),
      bottomNavigationBar: wide
          ? null
          : NavigationBar(
              selectedIndex: _index,
              onDestinationSelected: (value) => setState(() => _index = value),
              destinations: _destinations,
            ),
    );
  }
}
