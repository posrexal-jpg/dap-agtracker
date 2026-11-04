import 'dart:convert';

import 'package:flutter/services.dart';

/// Bundled location choices are available before the first successful sync.
class LocationCatalog {
  const LocationCatalog.empty() : _barangays = const {};

  const LocationCatalog._(this._barangays);

  final Map<String, List<String>> _barangays;

  static Future<LocationCatalog> load({AssetBundle? bundle}) async {
    final source = await (bundle ?? rootBundle).loadString(
      'assets/data/southern_leyte_locations.json',
    );
    return LocationCatalog.fromJson(jsonDecode(source) as Map<String, dynamic>);
  }

  factory LocationCatalog.fromJson(Map<String, dynamic> data) {
    final locations = <String, List<String>>{};
    for (final row in data['municipalities'] as List) {
      final name = row['name'] as String;
      final barangays =
          (row['barangays'] as List).cast<String>().toSet().toList()..sort();
      locations[name] = List.unmodifiable(barangays);
    }
    return LocationCatalog._(Map.unmodifiable(locations));
  }

  List<String> get municipalities => mergeMunicipalities(const []);

  String canonicalName(String name) {
    final trimmed = name.trim();
    final normalized = trimmed.toLowerCase();
    final lookup = const {'maasin', 'maasin city'}.contains(normalized)
        ? 'city of maasin'
        : normalized;
    for (final name in _barangays.keys) {
      if (name.toLowerCase() == lookup) return name;
    }
    return trimmed;
  }

  List<String> barangaysFor(String? municipality) => municipality == null
      ? const []
      : _barangays[canonicalName(municipality)] ?? const [];

  /// Empty or partial server lists must not remove the offline choices.
  List<String> mergeMunicipalities(Iterable<String> additional) {
    final names = {
      ..._barangays.keys,
      ...additional.map(canonicalName).where((name) => name.isNotEmpty),
    }.toList()..sort();
    return names;
  }
}
