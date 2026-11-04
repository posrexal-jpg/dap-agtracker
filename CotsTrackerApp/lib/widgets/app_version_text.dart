import 'package:flutter/material.dart';
import 'package:package_info_plus/package_info_plus.dart';

import '../theme/cots_theme.dart';

class AppVersionText extends StatelessWidget {
  const AppVersionText({this.style, super.key});

  final TextStyle? style;
  static final Future<String> _version = PackageInfo.fromPlatform().then(
    (info) => 'Version ${info.version} (${info.buildNumber})',
    onError: (_) => 'Version unavailable',
  );

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<String>(
      future: _version,
      builder: (context, snapshot) => AnimatedSwitcher(
        duration: const Duration(milliseconds: 250),
        child: Text(
          snapshot.data ?? 'Loading version…',
          key: ValueKey(snapshot.data),
          textAlign: TextAlign.center,
          style:
              style ??
              Theme.of(context).textTheme.bodySmall?.copyWith(
                color: CotsColors.muted,
                fontWeight: FontWeight.w600,
              ),
        ),
      ),
    );
  }
}
