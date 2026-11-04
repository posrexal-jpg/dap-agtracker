import 'package:flutter/foundation.dart';

/// Shared production address for authentication, account and sighting requests.
abstract final class AppConfig {
  static const productionApiBaseUrl = 'https://cotstracker.com/api/v1';
  static const privacyPolicyUrl = 'https://cotstracker.com/privacy';
  static const accountDeletionUrl = 'https://cotstracker.com/account-deletion';
  static const defaultApiBaseUrl = String.fromEnvironment(
    'API_BASE_URL',
    defaultValue: productionApiBaseUrl,
  );

  static const _previousProductionHosts = {
    'dap-ad.slsubc.com',
    'dap-ag.slsubc.com',
  };

  /// Existing installations should follow the production domain change while
  /// retaining intentional local development or organization server settings.
  static String resolveApiBaseUrl(String? savedUrl) {
    if (kReleaseMode) return productionApiBaseUrl;
    if (savedUrl == null || savedUrl.trim().isEmpty) {
      return defaultApiBaseUrl;
    }
    final host = Uri.tryParse(savedUrl.trim())?.host.toLowerCase();
    return _previousProductionHosts.contains(host)
        ? defaultApiBaseUrl
        : savedUrl;
  }
}
