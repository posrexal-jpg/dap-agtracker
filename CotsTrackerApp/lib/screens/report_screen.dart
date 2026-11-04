import 'dart:typed_data';

import 'package:flutter/material.dart';
import '../widgets/map_attribution.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:geolocator/geolocator.dart';
import 'package:image_picker/image_picker.dart';
import 'package:intl/intl.dart';
import 'package:latlong2/latlong.dart';
import 'package:provider/provider.dart';
import 'package:uuid/uuid.dart';

import '../models/sighting.dart';
import '../state/app_state.dart';
import '../services/offline_map_service.dart';

class ReportScreen extends StatefulWidget {
  const ReportScreen({required this.onSaved, super.key});

  final VoidCallback onSaved;

  @override
  State<ReportScreen> createState() => _ReportScreenState();
}

class _ReportScreenState extends State<ReportScreen> {
  final _formKey = GlobalKey<FormState>();
  final _location = TextEditingController();
  final _barangay = TextEditingController();
  final _observer = TextEditingController();
  final _description = TextEditingController();
  final _latitude = TextEditingController();
  final _longitude = TextEditingController();
  final _counts = List.generate(5, (_) => TextEditingController(text: '0'));
  final MapController _mapController = MapController();

  String? _municipality;
  String? _activity;
  String? _observerCategory;
  String _language = 'en';
  DateTime _date = DateTime.now();
  TimeOfDay _time = TimeOfDay.now();
  List<Uint8List> _photos = [];
  bool _locating = false;
  bool _saving = false;
  bool _locationConfirmed = false;
  double? _gpsAccuracy;

  static const activities = [
    'Fishing',
    'Recreational diving',
    'Research',
    'Cots collection',
    'Other',
  ];
  static const observerCategories = [
    'Fisherfolks',
    'Barangay residents',
    'Local government',
    'Advocacy groups',
    'Researcher',
    'Other',
  ];

  @override
  void dispose() {
    _location.dispose();
    _barangay.dispose();
    _observer.dispose();
    _description.dispose();
    _latitude.dispose();
    _longitude.dispose();
    for (final controller in _counts) {
      controller.dispose();
    }
    super.dispose();
  }

  Future<void> _useCurrentLocation() async {
    setState(() => _locating = true);
    try {
      if (!await Geolocator.isLocationServiceEnabled()) {
        throw Exception('Enable location services first.');
      }
      var permission = await Geolocator.checkPermission();
      if (permission == LocationPermission.denied) {
        permission = await Geolocator.requestPermission();
      }
      if (permission == LocationPermission.denied ||
          permission == LocationPermission.deniedForever) {
        throw Exception('Location permission was not granted.');
      }
      final position = await Geolocator.getCurrentPosition();
      _latitude.text = position.latitude.toStringAsFixed(7);
      _longitude.text = position.longitude.toStringAsFixed(7);
      _gpsAccuracy = position.accuracy;
      _locationConfirmed = false;
      _mapController.move(LatLng(position.latitude, position.longitude), 17);
    } catch (error) {
      if (mounted) {
        ScaffoldMessenger.of(
          context,
        ).showSnackBar(SnackBar(content: Text('$error')));
      }
    } finally {
      if (mounted) setState(() => _locating = false);
    }
  }

  Future<void> _pickPhotos() async {
    final selected = await ImagePicker().pickMultiImage(
      imageQuality: 82,
      limit: 5,
    );
    final photos = <Uint8List>[];
    for (final image in selected.take(5)) {
      photos.add(await image.readAsBytes());
    }
    if (mounted) setState(() => _photos = photos);
  }

  int _count(int index) => int.tryParse(_counts[index].text) ?? 0;

  Future<void> _save() async {
    if (!_formKey.currentState!.validate()) return;
    if (!_locationConfirmed) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Review the map and confirm the report location.'),
        ),
      );
      return;
    }
    setState(() => _saving = true);
    final state = context.read<AppState>();
    final sighting = Sighting(
      clientUuid: const Uuid().v4(),
      locationName: _location.text.trim(),
      latitude: double.parse(_latitude.text),
      longitude: double.parse(_longitude.text),
      barangay: _barangay.text.trim(),
      municipality: _municipality,
      observerName: _observer.text.trim().isEmpty
          ? '${state.user?['name']}'
          : _observer.text.trim(),
      description: _description.text.trim(),
      language: _language,
      activityType: _activity,
      observerCategory: _observerCategory,
      earlyJuvenile: _count(0),
      juvenile: _count(1),
      subAdult: _count(2),
      adult: _count(3),
      lateAdult: _count(4),
      dateOfSighting: DateFormat('yyyy-MM-dd').format(_date),
      timeOfSighting:
          '${_time.hour.toString().padLeft(2, '0')}:${_time.minute.toString().padLeft(2, '0')}',
      photoBytes: _photos,
    );
    await state.addSighting(sighting);
    if (!mounted) return;
    setState(() => _saving = false);
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(
          state.isOnline
              ? 'Report saved. Synchronizing now…'
              : 'Report saved offline. It will sync automatically later.',
        ),
      ),
    );
    _reset();
    widget.onSaved();
  }

  void _reset() {
    _formKey.currentState?.reset();
    for (final controller in [
      _location,
      _barangay,
      _observer,
      _description,
      _latitude,
      _longitude,
    ]) {
      controller.clear();
    }
    for (final controller in _counts) {
      controller.text = '0';
    }
    setState(() {
      _municipality = null;
      _activity = null;
      _observerCategory = null;
      _photos = [];
      _date = DateTime.now();
      _time = TimeOfDay.now();
      _gpsAccuracy = null;
      _locationConfirmed = false;
    });
  }

  LatLng? get _selectedPoint {
    final latitude = double.tryParse(_latitude.text);
    final longitude = double.tryParse(_longitude.text);
    return latitude == null || longitude == null
        ? null
        : LatLng(latitude, longitude);
  }

  void _selectPoint(LatLng point) {
    setState(() {
      _latitude.text = point.latitude.toStringAsFixed(7);
      _longitude.text = point.longitude.toStringAsFixed(7);
      _gpsAccuracy = null;
      _locationConfirmed = false;
    });
  }

  String? _required(String? value) =>
      value == null || value.trim().isEmpty ? 'Required' : null;

  bool get _isBisaya => _language == 'bis';

  String _text(String english, String bisaya) => _isBisaya ? bisaya : english;

  @override
  Widget build(BuildContext context) {
    final state = context.watch<AppState>();
    final barangays = state.barangaysFor(_municipality);
    return Form(
      key: _formKey,
      child: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          Text(
            _text('Report a sighting', 'Pagreport og nakit-an'),
            style: Theme.of(
              context,
            ).textTheme.headlineSmall?.copyWith(fontWeight: FontWeight.w800),
          ),
          const SizedBox(height: 4),
          Text(
            state.isOnline
                ? _text(
                    'This report is saved locally first, then synchronized.',
                    'I-save una ang report sa device, dayon i-synchronize.',
                  )
                : _text(
                    'You are offline. This report will stay safely on this device.',
                    'Walay internet. Luwas nga i-save ang report niini nga device.',
                  ),
          ),
          const SizedBox(height: 16),
          SegmentedButton<String>(
            segments: const [
              ButtonSegment(
                value: 'en',
                icon: Icon(Icons.language),
                label: Text('English'),
              ),
              ButtonSegment(
                value: 'bis',
                icon: Icon(Icons.translate),
                label: Text('Binisaya'),
              ),
            ],
            selected: {_language},
            onSelectionChanged: (value) =>
                setState(() => _language = value.first),
          ),
          const SizedBox(height: 6),
          Text(
            _text(
              'Choose the language used for field instructions.',
              'Pilia ang pinulongan nga gamiton sa mga giya sa porma.',
            ),
            textAlign: TextAlign.center,
            style: Theme.of(context).textTheme.bodySmall,
          ),
          const SizedBox(height: 20),
          _Section(
            title: _text('Location', 'Lokasyon'),
            icon: Icons.place_outlined,
            help: _text(
              'Identify the nearest named place, choose its municipality and barangay, then position and confirm the map pin.',
              'Ilha ang labing duol nga lugar, pilia ang munisipyo ug barangay, dayon ibutang ug kumpirmaha ang pin sa mapa.',
            ),
            children: [
              TextFormField(
                controller: _location,
                validator: _required,
                decoration: InputDecoration(
                  labelText: _text('Location name *', 'Ngalan sa lokasyon *'),
                  helperText: _text(
                    'Enter the reef, coast, landmark, or local site name.',
                    'Isulat ang ngalan sa bahura, baybayon, timaan, o lugar.',
                  ),
                ),
              ),
              _gap,
              DropdownButtonFormField<String>(
                key: ValueKey('municipality-$_municipality'),
                isExpanded: true,
                initialValue: state.municipalities.contains(_municipality)
                    ? _municipality
                    : null,
                items: state.municipalities
                    .map(
                      (name) =>
                          DropdownMenuItem(value: name, child: Text(name)),
                    )
                    .toList(),
                validator: _required,
                onChanged: (value) => setState(() {
                  _municipality = value;
                  _barangay.clear();
                }),
                decoration: InputDecoration(
                  labelText: _text('Municipality *', 'Munisipyo *'),
                  helperText: _text(
                    'Choose a Southern Leyte municipality or city. Available offline.',
                    'Pilia ang munisipyo o siyudad sa Southern Leyte, bisan walay internet.',
                  ),
                  hintText: state.municipalities.isEmpty
                      ? 'Loading municipalities…'
                      : _text('Select municipality', 'Pilia ang munisipyo'),
                ),
              ),
              _gap,
              if (_municipality != null && barangays.isEmpty)
                TextFormField(
                  key: ValueKey('barangay-manual-$_municipality'),
                  controller: _barangay,
                  validator: _required,
                  decoration: InputDecoration(
                    labelText: _text('Barangay *', 'Barangay *'),
                    helperText: _text(
                      'Enter the barangay closest to the sighting.',
                      'Isulat ang barangay nga labing duol sa nakit-an.',
                    ),
                  ),
                )
              else
                DropdownButtonFormField<String>(
                  key: ValueKey('barangay-$_municipality'),
                  isExpanded: true,
                  initialValue: barangays.contains(_barangay.text)
                      ? _barangay.text
                      : null,
                  items: barangays
                      .map(
                        (name) =>
                            DropdownMenuItem(value: name, child: Text(name)),
                      )
                      .toList(),
                  validator: _required,
                  onChanged: _municipality == null
                      ? null
                      : (value) => _barangay.text = value ?? '',
                  decoration: InputDecoration(
                    labelText: 'Barangay *',
                    hintText: _municipality == null
                        ? _text(
                            'Select a municipality first',
                            'Pilia una ang munisipyo',
                          )
                        : _text('Select barangay', 'Pilia ang barangay'),
                    helperText: _text(
                      'Barangays are available online and offline.',
                      'Makapili og barangay bisan walay internet.',
                    ),
                  ),
                ),
              _gap,
              ClipRRect(
                borderRadius: BorderRadius.circular(16),
                child: SizedBox(
                  height: 290,
                  child: Stack(
                    children: [
                      FlutterMap(
                        mapController: _mapController,
                        options: MapOptions(
                          initialCenter:
                              _selectedPoint ?? const LatLng(10.3, 125.0),
                          initialZoom: _selectedPoint == null ? 7 : 17,
                          backgroundColor: const Color(0xFFDDEBED),
                          onTap: (_, point) => _selectPoint(point),
                        ),
                        children: [
                          TileLayer(
                            urlTemplate: OfflineMapService.urlTemplate,
                            userAgentPackageName: 'com.cotstracker.app',
                            tileProvider: OfflineMapService.tileProvider(),
                          ),
                          if (_selectedPoint != null && _gpsAccuracy != null)
                            CircleLayer(
                              circles: [
                                CircleMarker(
                                  point: _selectedPoint!,
                                  radius: _gpsAccuracy!,
                                  useRadiusInMeter: true,
                                  color: const Color(
                                    0xFF258CF4,
                                  ).withValues(alpha: 0.17),
                                  borderColor: const Color(0xFF258CF4),
                                  borderStrokeWidth: 1.5,
                                ),
                              ],
                            ),
                          if (_selectedPoint != null)
                            MarkerLayer(
                              markers: [
                                Marker(
                                  point: _selectedPoint!,
                                  width: 54,
                                  height: 54,
                                  alignment: Alignment.topCenter,
                                  child: const Icon(
                                    Icons.location_pin,
                                    color: Color(0xFFFF4F4F),
                                    size: 50,
                                    shadows: [
                                      Shadow(
                                        blurRadius: 8,
                                        color: Colors.black38,
                                      ),
                                    ],
                                  ),
                                ),
                              ],
                            ),
                        ],
                      ),
                      Positioned(
                        left: 10,
                        right: 10,
                        top: 10,
                        child: IgnorePointer(
                          child: Container(
                            padding: const EdgeInsets.symmetric(
                              horizontal: 12,
                              vertical: 9,
                            ),
                            decoration: BoxDecoration(
                              color: Colors.white.withValues(alpha: 0.94),
                              borderRadius: BorderRadius.circular(12),
                              boxShadow: const [
                                BoxShadow(
                                  blurRadius: 10,
                                  color: Colors.black12,
                                ),
                              ],
                            ),
                            child: Row(
                              children: [
                                Icon(
                                  state.isOnline
                                      ? Icons.touch_app_outlined
                                      : Icons.map_outlined,
                                  size: 18,
                                  color: Theme.of(context).colorScheme.primary,
                                ),
                                const SizedBox(width: 8),
                                Expanded(
                                  child: Text(
                                    state.isOnline
                                        ? 'Tap the map to adjust the report pin'
                                        : 'Offline · previously viewed map tiles remain available',
                                    style: Theme.of(
                                      context,
                                    ).textTheme.bodySmall,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ),
                      ),
                      Positioned(
                        right: 8,
                        bottom: 8,
                        child: const MapAttribution(),
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(height: 10),
              Row(
                children: [
                  Expanded(
                    child: TextFormField(
                      controller: _latitude,
                      validator: _coordinate,
                      keyboardType: const TextInputType.numberWithOptions(
                        decimal: true,
                        signed: true,
                      ),
                      onChanged: (_) =>
                          setState(() => _locationConfirmed = false),
                      decoration: InputDecoration(
                        labelText: _text('Latitude *', 'Latitude *'),
                        helperText: _text(
                          'North–south GPS coordinate.',
                          'GPS coordinate paamihanan–pahabagatan.',
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: TextFormField(
                      controller: _longitude,
                      validator: _coordinate,
                      keyboardType: const TextInputType.numberWithOptions(
                        decimal: true,
                        signed: true,
                      ),
                      onChanged: (_) =>
                          setState(() => _locationConfirmed = false),
                      decoration: InputDecoration(
                        labelText: _text('Longitude *', 'Longitude *'),
                        helperText: _text(
                          'East–west GPS coordinate.',
                          'GPS coordinate pasidlakan–pakasadpan.',
                        ),
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 10),
              OutlinedButton.icon(
                onPressed: _locating ? null : _useCurrentLocation,
                icon: _locating
                    ? const SizedBox.square(
                        dimension: 18,
                        child: CircularProgressIndicator(strokeWidth: 2),
                      )
                    : const Icon(Icons.my_location),
                label: const Text('Use current location'),
              ),
              if (_gpsAccuracy != null) ...[
                const SizedBox(height: 8),
                Text(
                  'GPS accuracy: approximately '
                  '${_gpsAccuracy!.round()} meters. The blue circle shows the '
                  'possible accuracy area.',
                  style: Theme.of(context).textTheme.bodySmall?.copyWith(
                    color: const Color(0xFF42666A),
                  ),
                ),
              ],
              const SizedBox(height: 10),
              FilledButton.tonalIcon(
                onPressed: _selectedPoint == null
                    ? null
                    : () => setState(() => _locationConfirmed = true),
                icon: Icon(
                  _locationConfirmed
                      ? Icons.verified
                      : Icons.add_location_alt_outlined,
                ),
                label: Text(
                  _locationConfirmed
                      ? 'Location confirmed'
                      : 'Confirm this location',
                ),
              ),
            ],
          ),
          _sectionGap,
          _Section(
            title: _text('COTS size counts', 'Ihap sumala sa gidak-on'),
            icon: Icons.straighten,
            help: _text(
              'Count the COTS in each measured size group. Enter zero when none were observed in a group.',
              'Ihap ang dap-ag sa matag grupo sa gidak-on. Isulat ang zero kon walay nakita sa usa ka grupo.',
            ),
            children: [
              Wrap(
                spacing: 10,
                runSpacing: 10,
                children: [
                  _CountField(
                    label: '1–5 cm',
                    controller: _counts[0],
                    helper: _text(
                      'Number seen in this size.',
                      'Pila ang nakita niini nga gidak-on.',
                    ),
                  ),
                  _CountField(
                    label: '6–15 cm',
                    controller: _counts[1],
                    helper: _text(
                      'Number seen in this size.',
                      'Pila ang nakita niini nga gidak-on.',
                    ),
                  ),
                  _CountField(
                    label: '15–25 cm',
                    controller: _counts[2],
                    helper: _text(
                      'Number seen in this size.',
                      'Pila ang nakita niini nga gidak-on.',
                    ),
                  ),
                  _CountField(
                    label: '26–35 cm',
                    controller: _counts[3],
                    helper: _text(
                      'Number seen in this size.',
                      'Pila ang nakita niini nga gidak-on.',
                    ),
                  ),
                  _CountField(
                    label: '>35 cm',
                    controller: _counts[4],
                    helper: _text(
                      'Number seen in this size.',
                      'Pila ang nakita niini nga gidak-on.',
                    ),
                  ),
                ],
              ),
            ],
          ),
          _sectionGap,
          _Section(
            title: _text('Observation details', 'Mga detalye sa obserbasyon'),
            icon: Icons.assignment_outlined,
            help: _text(
              'Record who observed the COTS, what activity was underway, and the actual date and time of observation.',
              'Irekord kinsa ang nakakita, unsang kalihokan ang gihimo, ug ang tinuod nga petsa ug oras sa pagkakita.',
            ),
            children: [
              DropdownButtonFormField<String>(
                key: ValueKey('activity-$_activity'),
                isExpanded: true,
                initialValue: _activity,
                validator: _required,
                items: activities
                    .map(
                      (value) => DropdownMenuItem(
                        value: value,
                        child: Text(_activityLabel(value)),
                      ),
                    )
                    .toList(),
                onChanged: (value) => setState(() => _activity = value),
                decoration: InputDecoration(
                  labelText: _text('Activity type *', 'Matang sa kalihokan *'),
                  helperText: _text(
                    'What were you doing when COTS was seen?',
                    'Unsay imong gibuhat sa dihang nakita ang dap-ag?',
                  ),
                ),
              ),
              _gap,
              DropdownButtonFormField<String>(
                key: ValueKey('observer-$_observerCategory'),
                isExpanded: true,
                initialValue: _observerCategory,
                validator: _required,
                items: observerCategories
                    .map(
                      (value) => DropdownMenuItem(
                        value: value,
                        child: Text(_observerLabel(value)),
                      ),
                    )
                    .toList(),
                onChanged: (value) => setState(() => _observerCategory = value),
                decoration: InputDecoration(
                  labelText: _text(
                    'Observer category *',
                    'Klase sa tig-obserbar *',
                  ),
                  helperText: _text(
                    'Select the group that best describes the observer.',
                    'Pilia ang grupo nga labing naghulagway sa tig-obserbar.',
                  ),
                ),
              ),
              _gap,
              TextFormField(
                controller: _observer,
                decoration: InputDecoration(
                  labelText: _text(
                    'Observer name (optional)',
                    'Ngalan sa tig-obserbar (opsyonal)',
                  ),
                  helperText: _text(
                    'Name of the person who made the observation.',
                    'Ngalan sa tawo nga nakakita sa dap-ag.',
                  ),
                ),
              ),
              _gap,
              TextFormField(
                controller: _description,
                maxLines: 3,
                decoration: InputDecoration(
                  labelText: _text(
                    'Notes (optional)',
                    'Dugang nga nota (opsyonal)',
                  ),
                  helperText: _text(
                    'Add reef condition, behavior, weather, or other useful details.',
                    'Idugang ang kahimtang sa bahura, lihok, panahon, o ubang detalye.',
                  ),
                ),
              ),
              _gap,
              Text(
                _text(
                  'Choose the actual date and time when the COTS was observed.',
                  'Pilia ang tinuod nga petsa ug oras sa pagkakita sa dap-ag.',
                ),
                style: Theme.of(context).textTheme.bodySmall,
              ),
              const SizedBox(height: 8),
              Row(
                children: [
                  Expanded(
                    child: OutlinedButton.icon(
                      onPressed: () async {
                        final value = await showDatePicker(
                          context: context,
                          initialDate: _date,
                          firstDate: DateTime(2000),
                          lastDate: DateTime.now(),
                        );
                        if (value != null) setState(() => _date = value);
                      },
                      icon: const Icon(Icons.calendar_today),
                      label: Text(DateFormat.yMMMd().format(_date)),
                    ),
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: OutlinedButton.icon(
                      onPressed: () async {
                        final value = await showTimePicker(
                          context: context,
                          initialTime: _time,
                        );
                        if (value != null) setState(() => _time = value);
                      },
                      icon: const Icon(Icons.schedule),
                      label: Text(_time.format(context)),
                    ),
                  ),
                ],
              ),
            ],
          ),
          _sectionGap,
          _Section(
            title: _text('Photos', 'Mga litrato'),
            icon: Icons.photo_camera_outlined,
            help: _text(
              'Attach up to five clear photos that show the COTS and enough surrounding reef for context.',
              'I-attach ang kutob lima ka klarong litrato nga nagpakita sa dap-ag ug sa palibot nga bahura.',
            ),
            children: [
              OutlinedButton.icon(
                onPressed: _pickPhotos,
                icon: const Icon(Icons.add_photo_alternate_outlined),
                label: Text(
                  _photos.isEmpty
                      ? 'Choose up to 5 photos'
                      : '${_photos.length} photo(s) selected',
                ),
              ),
              const SizedBox(height: 6),
              Text(
                _text(
                  'Add clear photos of the COTS and surrounding reef (maximum 5).',
                  'Pagdugang og klarong litrato sa dap-ag ug palibot nga bahura (kutob 5).',
                ),
                style: Theme.of(context).textTheme.bodySmall,
              ),
              if (_photos.isNotEmpty) ...[
                const SizedBox(height: 10),
                SizedBox(
                  height: 82,
                  child: ListView.separated(
                    scrollDirection: Axis.horizontal,
                    itemCount: _photos.length,
                    separatorBuilder: (_, _) => const SizedBox(width: 8),
                    itemBuilder: (_, index) => ClipRRect(
                      borderRadius: BorderRadius.circular(8),
                      child: Image.memory(
                        _photos[index],
                        width: 82,
                        height: 82,
                        fit: BoxFit.cover,
                      ),
                    ),
                  ),
                ),
              ],
            ],
          ),
          const SizedBox(height: 22),
          FilledButton.icon(
            onPressed: _saving ? null : _save,
            style: FilledButton.styleFrom(
              minimumSize: const Size.fromHeight(56),
            ),
            icon: _saving
                ? const SizedBox.square(
                    dimension: 20,
                    child: CircularProgressIndicator(
                      strokeWidth: 2,
                      color: Colors.white,
                    ),
                  )
                : Icon(state.isOnline ? Icons.cloud_upload : Icons.save),
            label: Text(
              state.isOnline ? 'Save and synchronize' : 'Save offline',
            ),
          ),
          const SizedBox(height: 24),
        ],
      ),
    );
  }

  static String? _coordinate(String? value) =>
      double.tryParse(value ?? '') == null ? 'Enter a valid coordinate' : null;

  static const _gap = SizedBox(height: 12);
  static const _sectionGap = SizedBox(height: 14);

  String _activityLabel(String value) {
    if (!_isBisaya) return value;
    return const {
          'Fishing': 'Pagpangisda',
          'Recreational diving': 'Recreational diving',
          'Research': 'Panukiduki',
          'Cots collection': 'Pagkolekta og dap-ag',
          'Other': 'Uban pa',
        }[value] ??
        value;
  }

  String _observerLabel(String value) {
    if (!_isBisaya) return value;
    return const {
          'Fisherfolks': 'Mga mangingisda',
          'Barangay residents': 'Mga residente sa barangay',
          'Local government': 'Lokal nga panggamhanan',
          'Advocacy groups': 'Mga advocacy group',
          'Researcher': 'Tigpanukiduki',
          'Other': 'Uban pa',
        }[value] ??
        value;
  }
}

class _Section extends StatelessWidget {
  const _Section({
    required this.title,
    required this.icon,
    required this.children,
    required this.help,
  });

  final String title;
  final IconData icon;
  final List<Widget> children;
  final String help;

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            Row(
              children: [
                Icon(icon, color: Theme.of(context).colorScheme.primary),
                const SizedBox(width: 8),
                Text(
                  title,
                  style: Theme.of(context).textTheme.titleMedium?.copyWith(
                    fontWeight: FontWeight.w700,
                  ),
                ),
                const Spacer(),
                IconButton(
                  tooltip: 'Help',
                  icon: const Icon(Icons.help_outline),
                  onPressed: () => showDialog<void>(
                    context: context,
                    builder: (dialogContext) => AlertDialog(
                      icon: Icon(icon),
                      title: Text(title),
                      content: Text(help),
                      actions: [
                        FilledButton(
                          onPressed: () => Navigator.pop(dialogContext),
                          child: const Text('OK'),
                        ),
                      ],
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 16),
            ...children,
          ],
        ),
      ),
    );
  }
}

class _CountField extends StatelessWidget {
  const _CountField({
    required this.label,
    required this.controller,
    required this.helper,
  });

  final String label;
  final TextEditingController controller;
  final String helper;

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      width: 125,
      child: TextFormField(
        controller: controller,
        keyboardType: TextInputType.number,
        validator: (value) {
          final number = int.tryParse(value ?? '');
          return number == null || number < 0 ? 'Invalid' : null;
        },
        decoration: InputDecoration(labelText: label, helperText: helper),
      ),
    );
  }
}
