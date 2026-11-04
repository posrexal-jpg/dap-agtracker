import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:provider/provider.dart';

import '../models/sighting.dart';
import '../state/app_state.dart';
import '../theme/cots_theme.dart';
import '../widgets/app_brand.dart';
import '../widgets/partnership_welcome.dart';

class DashboardScreen extends StatelessWidget {
  const DashboardScreen({required this.onReport, super.key});

  final VoidCallback onReport;

  @override
  Widget build(BuildContext context) {
    final state = context.watch<AppState>();
    final recent = state.sightings.take(5).toList();
    return RefreshIndicator(
      onRefresh: state.synchronize,
      child: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          Container(
            padding: const EdgeInsets.all(20),
            decoration: BoxDecoration(
              gradient: const LinearGradient(
                colors: [CotsColors.primaryDark, CotsColors.primary],
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
              ),
              borderRadius: BorderRadius.circular(24),
              boxShadow: [
                BoxShadow(
                  color: CotsColors.primaryDark.withValues(alpha: 0.22),
                  blurRadius: 20,
                  offset: const Offset(0, 8),
                ),
              ],
            ),
            child: Row(
              children: [
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'FIELD OVERVIEW',
                        style: Theme.of(context).textTheme.labelMedium
                            ?.copyWith(
                              color: CotsColors.primaryContainer,
                              fontWeight: FontWeight.w800,
                              letterSpacing: 1.1,
                            ),
                      ),
                      const SizedBox(height: 7),
                      Text(
                        'Hello, ${state.user?['name'] ?? 'Observer'}',
                        style: Theme.of(context).textTheme.headlineSmall
                            ?.copyWith(
                              fontWeight: FontWeight.w800,
                              color: Colors.white,
                            ),
                      ),
                      const SizedBox(height: 5),
                      const Text(
                        'Every verified sighting strengthens reef protection.',
                        style: TextStyle(color: CotsColors.primaryContainer),
                      ),
                    ],
                  ),
                ),
                const SizedBox(width: 12),
                const CotsMark(size: 76),
              ],
            ),
          ),
          const SizedBox(height: 14),
          Card(
            child: ListTile(
              contentPadding: const EdgeInsets.symmetric(
                horizontal: 16,
                vertical: 4,
              ),
              leading: const Icon(
                Icons.handshake_outlined,
                color: CotsColors.primary,
              ),
              title: const Text(
                'Science for healthier reefs',
                style: TextStyle(fontWeight: FontWeight.w700),
              ),
              subtitle: const Text('SLSU Bontoc × DOST'),
              trailing: const Icon(Icons.chevron_right),
              onTap: () => showPartnershipWelcome(context),
            ),
          ),
          const SizedBox(height: 22),
          Row(
            children: [
              Expanded(
                child: Text(
                  'Monitoring summary',
                  style: Theme.of(context).textTheme.titleMedium?.copyWith(
                    fontWeight: FontWeight.w800,
                    color: CotsColors.ink,
                  ),
                ),
              ),
              IconButton.filledTonal(
                onPressed: state.isOnline ? state.synchronize : null,
                icon: state.isSyncing
                    ? const SizedBox.square(
                        dimension: 19,
                        child: CircularProgressIndicator(strokeWidth: 2),
                      )
                    : const Icon(Icons.sync),
                tooltip: 'Sync now',
              ),
            ],
          ),
          const SizedBox(height: 12),
          LayoutBuilder(
            builder: (context, constraints) {
              final columns = constraints.maxWidth >= 640
                  ? 3
                  : constraints.maxWidth >= 340
                  ? 2
                  : 1;
              final width =
                  (constraints.maxWidth - (columns - 1) * 12) / columns;
              return Wrap(
                spacing: 12,
                runSpacing: 12,
                children: [
                  _Metric(
                    width: width,
                    icon: Icons.public,
                    label: 'Cached sightings',
                    value:
                        '${state.totalSightings == 0 ? state.sightings.length : state.totalSightings}',
                    color: CotsColors.primary,
                  ),
                  _Metric(
                    width: width,
                    icon: Icons.schedule_send,
                    label: 'Pending sync',
                    value: '${state.pendingCount}',
                    color: const Color(0xFFE17A24),
                  ),
                  _Metric(
                    width: width,
                    icon: state.isOnline ? Icons.wifi : Icons.wifi_off,
                    label: 'Connection',
                    value: state.isOnline ? 'Online' : 'Offline',
                    color: state.isOnline
                        ? const Color(0xFF268A4B)
                        : const Color(0xFFB75C20),
                  ),
                ],
              );
            },
          ),
          const SizedBox(height: 22),
          FilledButton.icon(
            onPressed: onReport,
            style: FilledButton.styleFrom(
              minimumSize: const Size.fromHeight(56),
            ),
            icon: const Icon(Icons.add_location_alt),
            label: const Text('Report a COTS sighting'),
          ),
          const SizedBox(height: 28),
          Text(
            'Recent sightings',
            style: Theme.of(
              context,
            ).textTheme.titleLarge?.copyWith(fontWeight: FontWeight.w700),
          ),
          const SizedBox(height: 12),
          if (recent.isEmpty)
            const _EmptyState()
          else
            ...recent.map((item) => _RecentSighting(item: item)),
        ],
      ),
    );
  }
}

class _Metric extends StatelessWidget {
  const _Metric({
    required this.icon,
    required this.label,
    required this.value,
    required this.color,
    required this.width,
  });

  final IconData icon;
  final String label;
  final String value;
  final Color color;
  final double width;

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: width,
      child: Card(
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Icon(icon, color: color),
              const SizedBox(height: 12),
              Text(
                value,
                style: Theme.of(context).textTheme.titleLarge?.copyWith(
                  fontWeight: FontWeight.w800,
                  color: color,
                ),
              ),
              Text(label),
            ],
          ),
        ),
      ),
    );
  }
}

class _RecentSighting extends StatelessWidget {
  const _RecentSighting({required this.item});

  final Sighting item;

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.only(bottom: 10),
      child: ListTile(
        leading: CircleAvatar(
          backgroundColor: Theme.of(context).colorScheme.primaryContainer,
          child: Text('${item.total}'),
        ),
        title: Text(
          item.locationName,
          style: const TextStyle(fontWeight: FontWeight.w700),
        ),
        subtitle: Text(
          '${item.barangay}${item.municipality?.isNotEmpty == true ? ', ${item.municipality}' : ''}\n'
          '${DateFormat.yMMMd().format(item.createdAt)}',
        ),
        isThreeLine: true,
        trailing: Icon(
          item.syncStatus == SyncStatus.synced
              ? Icons.cloud_done
              : item.syncStatus == SyncStatus.failed
              ? Icons.cloud_off
              : Icons.schedule,
          color: item.syncStatus == SyncStatus.synced
              ? Colors.green
              : Colors.orange,
        ),
      ),
    );
  }
}

class _EmptyState extends StatelessWidget {
  const _EmptyState();

  @override
  Widget build(BuildContext context) {
    return const Card(
      child: Padding(
        padding: EdgeInsets.all(28),
        child: Column(
          children: [
            Icon(Icons.travel_explore, size: 48),
            SizedBox(height: 10),
            Text('No sightings cached yet.'),
          ],
        ),
      ),
    );
  }
}
