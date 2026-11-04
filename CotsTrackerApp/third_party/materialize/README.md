# Materialize 1.0.0

Downloaded from the official Materialize getting-started page:
https://materializecss.com/getting-started.html

Release archive:
https://github.com/Dogfalo/materialize/releases/download/1.0.0/materialize-v1.0.0.zip

Archive SHA-256:
`8a155da2648fcc37daed20dcc6ef99ffdd6b57a67ba4d99bf7992ebbae3c6c1f`

The ZIP and extracted CSS/JavaScript distribution are kept here with the MIT
license. The files inside `materialize/` are unmodified upstream files.

## Flutter integration

Materialize is a browser CSS/JavaScript framework, not a Flutter package.
Linking its stylesheet in `web/index.html` cannot style Flutter widgets or
native Android/iOS apps. The distribution is a local design reference and is
not bundled into the app or loaded at runtime.

The native adaptation lives in `lib/theme/cots_theme.dart` and is applied by
`MaterialApp` in `lib/main.dart`. The current visual refresh extends that
native adaptation with an ocean palette, rounded white cards, outlined
inputs, ripple feedback, charcoal snackbars and pill-shaped chips. Flutter's
touch target sizes and Material 3 navigation are retained. Materialize remains
a design reference rather than a runtime dependency.

Change `CotsColors` and `buildCotsTheme()` to customize the appearance.
The login, loading, dashboard, account, settings and sightings screens use
the shared colors where they previously had fixed blue styling. Other
controls inherit the theme, including the report form and dialogs.
