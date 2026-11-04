import 'package:flutter_map/flutter_map.dart';
import 'package:flutter_map_tile_caching/flutter_map_tile_caching.dart';

class OfflineMapService {
  static const _store = FMTCStore('southern_leyte');
  static const urlTemplate = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';

  static Future<void> initialize() async {
    await FMTCObjectBoxBackend().initialise();
    if (!await _store.manage.ready) {
      await _store.manage.create(maxLength: 15000);
    }
  }

  static TileProvider tileProvider() => FMTCTileProvider(
    stores: const {'southern_leyte': BrowseStoreStrategy.readUpdateCreate},
    loadingStrategy: BrowseLoadingStrategy.cacheFirst,
  );
}
