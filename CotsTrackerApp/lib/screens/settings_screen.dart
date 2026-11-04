import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:package_info_plus/package_info_plus.dart';

import '../state/app_state.dart';
import '../theme/cots_theme.dart';
import '../config/app_config.dart';
import '../widgets/partnership_welcome.dart';
import '../widgets/privacy_policy_link.dart';

class SettingsScreen extends StatefulWidget {
  const SettingsScreen({super.key});

  @override
  State<SettingsScreen> createState() => _SettingsScreenState();
}

class _SettingsScreenState extends State<SettingsScreen> {
  late final TextEditingController _url;
  String _version = '';

  @override
  void initState() {
    super.initState();
    _url = TextEditingController(text: context.read<AppState>().apiBaseUrl);
    _loadVersion();
  }

  Future<void> _loadVersion() async {
    try {
      final info = await PackageInfo.fromPlatform();
      if (mounted) {
        setState(() => _version = '${info.version}+${info.buildNumber}');
      }
    } catch (_) {
      // ignore errors and leave version blank
    }
  }

  @override
  void dispose() {
    _url.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final state = context.watch<AppState>();
    return ListView(
      padding: const EdgeInsets.all(20),
      children: [
        Text(
          'Settings',
          style: Theme.of(
            context,
          ).textTheme.headlineSmall?.copyWith(fontWeight: FontWeight.w800),
        ),
        const SizedBox(height: 20),
        Card(
          child: ListTile(
            contentPadding: const EdgeInsets.symmetric(
              horizontal: 18,
              vertical: 10,
            ),
            leading: const Icon(
              Icons.handshake_outlined,
              color: CotsColors.primary,
            ),
            title: const Text(
              'SLSU × DOST partnership',
              style: TextStyle(fontWeight: FontWeight.w700),
            ),
            subtitle: const Text('About the people behind COTS Tracker'),
            trailing: const Icon(Icons.chevron_right),
            onTap: () => showPartnershipWelcome(context),
          ),
        ),
        const SizedBox(height: 14),
        Card(
          child: ListTile(
            leading: const Icon(Icons.privacy_tip_outlined),
            title: const Text('Privacy policy'),
            subtitle: const Text('How your account and reports are handled'),
            trailing: const Icon(Icons.open_in_new),
            onTap: () => openPrivacyPolicy(context),
          ),
        ),
        const SizedBox(height: 14),
        Card(
          child: ListTile(
            leading: const Icon(Icons.person_remove_outlined),
            title: const Text('Request account deletion'),
            subtitle: const Text('Delete your account and associated data'),
            trailing: const Icon(Icons.open_in_new),
            onTap: () => openAccountDeletion(context),
          ),
        ),
        const SizedBox(height: 14),
        if (!kReleaseMode)
          Card(
            child: Padding(
              padding: const EdgeInsets.all(18),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  Text(
                    'API integration',
                    style: Theme.of(context).textTheme.titleLarge,
                  ),
                  const SizedBox(height: 8),
                  const Text(
                    'Development API address. Release builds use the production server.',
                  ),
                  const SizedBox(height: 14),
                  TextField(
                    controller: _url,
                    keyboardType: TextInputType.url,
                    decoration: const InputDecoration(
                      labelText: 'API base URL',
                      hintText: AppConfig.productionApiBaseUrl,
                      prefixIcon: Icon(Icons.link),
                    ),
                  ),
                  const SizedBox(height: 12),
                  FilledButton(
                    onPressed: () async {
                      await state.updateApiBaseUrl(_url.text.trim());
                      if (context.mounted) {
                        ScaffoldMessenger.of(context).showSnackBar(
                          const SnackBar(content: Text('API address saved.')),
                        );
                      }
                    },
                    child: const Text('Save API address'),
                  ),
                ],
              ),
            ),
          ),
        if (!kReleaseMode) const SizedBox(height: 14),
        Card(
          child: Padding(
            padding: const EdgeInsets.all(18),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Container(
                      width: 42,
                      height: 42,
                      decoration: BoxDecoration(
                        color: CotsColors.primaryContainer,
                        borderRadius: BorderRadius.circular(2),
                      ),
                      child: const Icon(
                        Icons.offline_pin_outlined,
                        color: CotsColors.primary,
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            'Offline map readiness',
                            style: Theme.of(context).textTheme.titleMedium
                                ?.copyWith(fontWeight: FontWeight.w800),
                          ),
                          const Text('Automatic cache is active'),
                        ],
                      ),
                    ),
                    const Icon(Icons.verified, color: Color(0xFF268A4B)),
                  ],
                ),
                const SizedBox(height: 14),
                const Text(
                  'Map tiles you view online are cached for later visits. '
                  'GPS, coordinates, pins, and saved reports work offline.',
                ),
                const SizedBox(height: 12),
                Container(
                  padding: const EdgeInsets.all(12),
                  decoration: BoxDecoration(
                    color: const Color(0xFFFFF4E5),
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: const Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Icon(
                        Icons.info_outline,
                        size: 19,
                        color: Color(0xFF9A5A12),
                      ),
                      SizedBox(width: 9),
                      Expanded(
                        child: Text(
                          'Full regional downloads require an approved offline '
                          'tile provider or an organization-hosted tile server.',
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
        const SizedBox(height: 14),
        Card(
          child: Column(
            children: [
              ListTile(
                leading: const Icon(Icons.account_circle_outlined),
                title: Text('${state.user?['name'] ?? ''}'),
                subtitle: Text('${state.user?['email'] ?? ''}'),
              ),
              const Divider(height: 1),
              ListTile(
                leading: const Icon(Icons.info_outline),
                title: const Text('App version'),
                subtitle: Text(_version.isEmpty ? 'Unknown' : _version),
              ),
              const Divider(height: 1),
              ListTile(
                leading: const Icon(Icons.sync),
                title: const Text('Synchronize now'),
                subtitle: Text(
                  state.syncMessage ??
                      '${state.pendingCount} report(s) waiting',
                ),
                onTap: state.isOnline && !state.isSyncing
                    ? state.synchronize
                    : null,
              ),
              if (state.pendingCount > 0) ...[
                const Divider(height: 1),
                ListTile(
                  leading: Icon(
                    Icons.delete_sweep_outlined,
                    color: Theme.of(context).colorScheme.error,
                  ),
                  title: const Text('Delete unsynced data'),
                  subtitle: Text(
                    '${state.pendingCount} local report(s) will be permanently removed',
                  ),
                  onTap: () async {
                    final confirmed = await showDialog<bool>(
                      context: context,
                      builder: (dialogContext) => AlertDialog(
                        title: const Text('Delete unsynced data?'),
                        content: const Text(
                          'These reports have not reached the server and cannot be recovered after deletion.',
                        ),
                        actions: [
                          TextButton(
                            onPressed: () =>
                                Navigator.pop(dialogContext, false),
                            child: const Text('Cancel'),
                          ),
                          FilledButton(
                            onPressed: () => Navigator.pop(dialogContext, true),
                            child: const Text('Delete'),
                          ),
                        ],
                      ),
                    );
                    if (confirmed == true && context.mounted) {
                      await context.read<AppState>().deleteUnsyncedSightings();
                    }
                  },
                ),
              ],
              const Divider(height: 1),
              ListTile(
                leading: const Icon(Icons.logout, color: Colors.red),
                title: const Text('Sign out'),
                onTap: state.logout,
              ),
            ],
          ),
        ),
      ],
    );
  }
}
