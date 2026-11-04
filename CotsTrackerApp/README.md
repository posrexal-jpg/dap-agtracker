# COTS Tracker Flutter

COTS Tracker mobile client for the Laravel sighting service at
`https://cotstracker.com`. The project owner identified for this repository is
SLSU-BONTOC Digital Technology. See [DEVELOPMENT_PROVENANCE.md](DEVELOPMENT_PROVENANCE.md)
for the dated source import and AI assistance record.

## What works

- Laravel Sanctum token authentication
- Cached dashboard, map, and sighting list
- Offline sighting reports with up to five locally stored photos
- GPS coordinates or manual coordinate entry
- Bundled Southern Leyte municipality/city and dependent barangay dropdowns,
  available online and offline without a prior sync
- Automatic synchronization when connectivity returns
- Manual synchronization and visible per-record sync state
- Android release target; Flutter scaffolding for other platforms is included

## Server setup

From the DADASD Laravel root:

```powershell
php artisan migrate
php artisan storage:link
php artisan serve --host=0.0.0.0 --port=8000
```

The app uses the `/api/v1` endpoints in `routes/api.php`. Existing approved
website accounts can sign in.

## API address

Release builds use `https://cotstracker.com/api/v1` over HTTPS. Debug builds
can use the app's Settings screen or a build-time override:

```powershell
flutter run --dart-define=API_BASE_URL=https://cotstracker.com/api/v1
```

For local development on an Android emulator, use
`http://10.0.2.2:8000/api/v1`.

Authentication, Google sign-in, account updates, synchronization and sighting
uploads all use the shared API base address in `lib/config/app_config.dart`.
Saved settings for the previous production hosts automatically resolve to the
new production address; custom development servers remain configurable.

The refreshed app mark is based on the logo from `https://cotstracker.com/`.
It is bundled locally alongside the project's SLSU and DOST logos for offline
use, launcher icons, splash screens and partnership information.

## Run

```powershell
flutter pub get
flutter run
```

## Materialize styling

The official Materialize 1.0.0 CSS/JavaScript distribution is downloaded in
`third_party/materialize/`, including its release ZIP and MIT license.
Since CSS cannot style Flutter widgets, the app applies a native adaptation
through `lib/theme/cots_theme.dart`: ocean colors, rounded cards and buttons,
outlined form fields, ripple feedback, chips and charcoal snackbars.
The styling works without downloading CSS, fonts or JavaScript at runtime.
See `third_party/materialize/README.md` for the source and integration details.

## Partnership welcome

The SLSU Bontoc–DOST welcome pop-up appears once after startup on new and
existing installations. Users can reopen it from Settings, the dashboard,
the app header or sign-in page. Its content and logos work offline.
See `assets/images/BRANDING.md` for asset sources and the logo generation prompt.

The first sign-in requires connectivity. After authentication, cached data and
new report capture continue to work offline. The app caches map tiles a user
views; it does not offer bulk offline map downloads from OpenStreetMap.

The privacy policy and account deletion request page are linked from the app's
login/settings screens and hosted by the Laravel website. See
[PRODUCTION_READINESS.md](PRODUCTION_READINESS.md) for the verified release
checks and remaining Play Console and server steps.
