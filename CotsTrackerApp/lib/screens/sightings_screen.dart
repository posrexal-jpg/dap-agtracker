import 'package:flutter/material.dart';
import '../widgets/map_attribution.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart';
import 'package:provider/provider.dart';

import '../models/sighting.dart';
import '../state/app_state.dart';
import '../services/offline_map_service.dart';
import '../theme/cots_theme.dart';

class SightingsScreen extends StatefulWidget {
  const SightingsScreen({super.key});

  @override
  State<SightingsScreen> createState() => _SightingsScreenState();
}

class _SightingsScreenState extends State<SightingsScreen> {
  bool _showMap = true;
  String _query = '';
  String? _municipality;

  @override
  Widget build(BuildContext context) {
    final state = context.watch<AppState>();
    final municipalities = {
      ...state.municipalities,
      ...state.sightings
          .map((item) => item.municipality)
          .whereType<String>()
          .where((value) => value.isNotEmpty)
          .map(state.canonicalMunicipality),
    }.toList()..sort();
    final items = state.sightings.where((item) {
      final haystack =
          '${item.locationName} ${item.barangay} ${item.municipality ?? ''} ${item.observerName ?? ''}'
              .toLowerCase();
      return (_municipality == null ||
              state.canonicalMunicipality(item.municipality ?? '') ==
                  _municipality) &&
          haystack.contains(_query.toLowerCase());
    }).toList();
    return Column(
      children: [
        Padding(
          padding: const EdgeInsets.fromLTRB(20, 18, 20, 12),
          child: Row(
            children: [
              Expanded(
                child: Text(
                  'COTS sightings',
                  style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                    fontWeight: FontWeight.w800,
                  ),
                ),
              ),
              SegmentedButton<bool>(
                segments: const [
                  ButtonSegment(
                    value: true,
                    icon: Icon(Icons.map),
                    label: Text('Map'),
                  ),
                  ButtonSegment(
                    value: false,
                    icon: Icon(Icons.list),
                    label: Text('List'),
                  ),
                ],
                selected: {_showMap},
                onSelectionChanged: (value) =>
                    setState(() => _showMap = value.first),
              ),
            ],
          ),
        ),
        Padding(
          padding: const EdgeInsets.fromLTRB(20, 0, 20, 12),
          child: Row(
            children: [
              Expanded(
                child: TextField(
                  onChanged: (value) => setState(() => _query = value),
                  decoration: const InputDecoration(
                    hintText: 'Search place or observer',
                    prefixIcon: Icon(Icons.search),
                    isDense: true,
                  ),
                ),
              ),
              const SizedBox(width: 10),
              PopupMenuButton<String?>(
                tooltip: 'Filter municipality',
                icon: Badge(
                  isLabelVisible: _municipality != null,
                  child: const Icon(Icons.filter_list),
                ),
                onSelected: (value) => setState(() => _municipality = value),
                itemBuilder: (_) => [
                  const PopupMenuItem(
                    value: null,
                    child: Text('All municipalities'),
                  ),
                  ...municipalities.map(
                    (value) => PopupMenuItem(value: value, child: Text(value)),
                  ),
                ],
              ),
            ],
          ),
        ),
        Expanded(
          child: _showMap
              ? _MapView(
                  items: items,
                  online: state.isOnline,
                  outbreakThreshold: state.outbreakThreshold,
                )
              : _ListView(items: items),
        ),
      ],
    );
  }
}

class _MapView extends StatelessWidget {
  const _MapView({
    required this.items,
    required this.online,
    required this.outbreakThreshold,
  });

  final List<Sighting> items;
  final bool online;
  final int outbreakThreshold;

  @override
  Widget build(BuildContext context) {
    return Stack(
      children: [
        FlutterMap(
          options: MapOptions(
            initialCenter: items.isEmpty
                ? const LatLng(10.3, 125.0)
                : LatLng(items.first.latitude, items.first.longitude),
            initialZoom: items.isEmpty ? 7 : 12,
          ),
          children: [
            TileLayer(
              urlTemplate: OfflineMapService.urlTemplate,
              userAgentPackageName: 'com.cotstracker.app',
              tileProvider: OfflineMapService.tileProvider(),
            ),
            MarkerLayer(
              markers: items
                  .where((item) => item.latitude != 0 || item.longitude != 0)
                  .map(
                    (item) => Marker(
                      point: LatLng(item.latitude, item.longitude),
                      width: 58,
                      height: 58,
                      child: Tooltip(
                        message: '${item.locationName} · ${item.total} COTS',
                        child: _SightingPin(
                          outbreak: item.outbreakCount > outbreakThreshold,
                          synchronized: item.syncStatus == SyncStatus.synced,
                        ),
                      ),
                    ),
                  )
                  .toList(),
            ),
          ],
        ),
        Positioned(right: 8, bottom: 8, child: const MapAttribution()),
        Positioned(
          left: 12,
          bottom: 12,
          child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 7),
            decoration: BoxDecoration(
              color: Colors.white.withValues(alpha: 0.92),
              borderRadius: BorderRadius.circular(10),
              boxShadow: const [
                BoxShadow(color: Colors.black12, blurRadius: 8),
              ],
            ),
            child: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                const Icon(
                  Icons.location_on,
                  color: Color(0xFFD32F2F),
                  size: 20,
                ),
                const SizedBox(width: 5),
                Text(
                  'Blinking = outbreak (>$outbreakThreshold adult + senescence)',
                  style: Theme.of(context).textTheme.bodySmall,
                ),
              ],
            ),
          ),
        ),
        if (!online)
          Positioned(
            top: 12,
            left: 12,
            right: 12,
            child: Card(
              color: const Color(0xFFFFE8C8),
              child: Padding(
                padding: const EdgeInsets.all(12),
                child: Text(
                  'Offline map: previously viewed areas and all saved markers '
                  'remain available.',
                  textAlign: TextAlign.center,
                  style: Theme.of(context).textTheme.bodySmall,
                ),
              ),
            ),
          ),
      ],
    );
  }
}

class _SightingPin extends StatefulWidget {
  const _SightingPin({required this.outbreak, required this.synchronized});

  final bool outbreak;
  final bool synchronized;

  @override
  State<_SightingPin> createState() => _SightingPinState();
}

class _SightingPinState extends State<_SightingPin>
    with SingleTickerProviderStateMixin {
  late final AnimationController _controller;
  late final Animation<double> _pulse;

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 850),
    );
    _pulse = Tween<double>(
      begin: 0.62,
      end: 1,
    ).animate(CurvedAnimation(parent: _controller, curve: Curves.easeInOut));
    if (widget.outbreak) _controller.repeat(reverse: true);
  }

  @override
  void didUpdateWidget(covariant _SightingPin oldWidget) {
    super.didUpdateWidget(oldWidget);
    if (widget.outbreak == oldWidget.outbreak) return;
    if (widget.outbreak) {
      _controller.repeat(reverse: true);
    } else {
      _controller.stop();
      _controller.value = 1;
    }
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final color = widget.outbreak
        ? const Color(0xFFD32F2F)
        : widget.synchronized
        ? CotsColors.primary
        : const Color(0xFFF59E0B);
    final pin = Stack(
      alignment: Alignment.center,
      children: [
        if (widget.outbreak)
          FadeTransition(
            opacity: _pulse,
            child: ScaleTransition(
              scale: Tween<double>(begin: 0.8, end: 1.25).animate(_controller),
              child: Container(
                width: 38,
                height: 38,
                decoration: BoxDecoration(
                  shape: BoxShape.circle,
                  color: color.withValues(alpha: 0.28),
                ),
              ),
            ),
          ),
        Icon(Icons.location_on, size: 42, color: color),
      ],
    );
    return widget.outbreak ? FadeTransition(opacity: _pulse, child: pin) : pin;
  }
}

class _ListView extends StatelessWidget {
  const _ListView({required this.items});

  final List<Sighting> items;

  @override
  Widget build(BuildContext context) {
    if (items.isEmpty) {
      return const Center(child: Text('No sightings have been cached yet.'));
    }
    return ListView.separated(
      padding: const EdgeInsets.fromLTRB(20, 4, 20, 24),
      itemCount: items.length,
      separatorBuilder: (_, _) => const SizedBox(height: 10),
      itemBuilder: (context, index) {
        final item = items[index];
        return Card(
          child: ExpansionTile(
            leading: CircleAvatar(child: Text('${item.total}')),
            title: Text(
              item.locationName,
              style: const TextStyle(fontWeight: FontWeight.w700),
            ),
            subtitle: Text('${item.barangay}, ${item.municipality ?? ''}'),
            trailing: Icon(
              item.syncStatus == SyncStatus.synced
                  ? Icons.cloud_done
                  : Icons.schedule,
              color: item.syncStatus == SyncStatus.synced
                  ? Colors.green
                  : Colors.orange,
            ),
            childrenPadding: const EdgeInsets.fromLTRB(16, 0, 16, 16),
            children: [
              Align(
                alignment: Alignment.centerLeft,
                child: Text(
                  'Coordinates: ${item.latitude.toStringAsFixed(6)}, '
                  '${item.longitude.toStringAsFixed(6)}\n'
                  'Activity: ${item.activityType ?? 'Not specified'}\n'
                  'Observer: ${item.observerCategory ?? 'Not specified'}\n'
                  'Sizes — 1–5 cm: ${item.earlyJuvenile}, 6–15 cm: ${item.juvenile}, '
                  '15–25 cm: ${item.subAdult}, 26–35 cm: ${item.adult}, '
                  '>35 cm: ${item.lateAdult}',
                ),
              ),
              if (item.serverId == null ||
                  item.observerName == context.read<AppState>().user?['name'])
                Align(
                  alignment: Alignment.centerRight,
                  child: TextButton.icon(
                    icon: const Icon(Icons.delete_outline),
                    label: const Text('Delete report'),
                    style: TextButton.styleFrom(
                      foregroundColor: Theme.of(context).colorScheme.error,
                    ),
                    onPressed: () async {
                      final confirmed =
                          await showDialog<bool>(
                            context: context,
                            builder: (dialogContext) => AlertDialog(
                              title: const Text('Delete report?'),
                              content: Text(
                                'Remove the report for ${item.locationName}? This cannot be undone.',
                              ),
                              actions: [
                                TextButton(
                                  onPressed: () =>
                                      Navigator.pop(dialogContext, false),
                                  child: const Text('Cancel'),
                                ),
                                FilledButton(
                                  onPressed: () =>
                                      Navigator.pop(dialogContext, true),
                                  child: const Text('Delete'),
                                ),
                              ],
                            ),
                          ) ??
                          false;
                      if (!confirmed || !context.mounted) {
                        return;
                      }
                      final error = await context
                          .read<AppState>()
                          .deleteSighting(item);
                      if (context.mounted) {
                        ScaffoldMessenger.of(context).showSnackBar(
                          SnackBar(content: Text(error ?? 'Report deleted.')),
                        );
                      }
                    },
                  ),
                ),
            ],
          ),
        );
      },
    );
  }
}
