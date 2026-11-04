import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';

import '../config/app_config.dart';

Future<void> openPrivacyPolicy(BuildContext context) =>
    _openPublicPage(context, 'Privacy policy', AppConfig.privacyPolicyUrl);

Future<void> openAccountDeletion(BuildContext context) =>
    _openPublicPage(context, 'Delete account', AppConfig.accountDeletionUrl);

Future<void> _openPublicPage(
  BuildContext context,
  String title,
  String url,
) async {
  try {
    if (await launchUrl(Uri.parse(url), mode: LaunchMode.externalApplication)) {
      return;
    }
  } catch (_) {
    // Show the address below if no browser is available.
  }

  if (!context.mounted) return;
  showDialog<void>(
    context: context,
    builder: (context) => AlertDialog(
      title: Text(title),
      content: SelectableText(url),
      actions: [
        TextButton(
          onPressed: () => Navigator.pop(context),
          child: const Text('Close'),
        ),
      ],
    ),
  );
}
