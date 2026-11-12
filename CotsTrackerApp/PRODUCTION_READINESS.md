# COTS Tracker Android release record

## Source and build

- Android application ID: `com.cotstracker.app`.
- Version: `1.3.0+8` (`versionCode` 8).
- Android target SDK: 36 through Flutter's Android Gradle extension.
- Production API: `https://cotstracker.com/api/v1`; release builds do not use
  saved custom development URLs or allow cleartext HTTP.
- Android App Bundle is signed with the project's upload key. The key and
  `android/key.properties` are excluded from Git.
- Build: `flutter pub get`, then `flutter build appbundle --release`.
- The app links to `/privacy` before sign-in and from Settings; Settings also
  links to `/account-deletion`.

## Data and maps

- The public privacy policy names SLSU-BONTOC Digital Technology and gives
  `privacy@cotstracker.com` as the contact for privacy and deletion requests.
- The app has no ads SDK or declared Android `AD_ID` permission.
- Google sign-in can create accounts. The app and public website provide a
  deletion request path; an administrator must verify and fulfill requests.
- Report photo files are removed when their report is deleted through the app
  or when an administrator deletes the associated account.
- Maps display linked OpenStreetMap contributor attribution and identify the
  app in tile requests. Only user-viewed tiles are cached; bulk downloads from
  the public OSM tile server are disabled.

## External release steps

1. Push the source commit to the repository with an account that has write
   access; verify the production deployment exposes `/privacy` and
   `/account-deletion` over HTTPS without login or a 404.
2. Confirm `privacy@cotstracker.com` receives mail and that account deletion
   requests are monitored and processed.
3. Verify the production `/api/v1/google/config` endpoint and Google OAuth
   client configuration if Google sign-in will be offered.
4. In Play Console, use `https://cotstracker.com/privacy` for the privacy policy
   and `https://cotstracker.com/account-deletion` for account deletion. Complete
   Data safety, app access, content rating, target audience, and other App
   content declarations according to the actual production behavior.
5. Upload the signed AAB, run required Play testing and review, and confirm
   the release on physical Android devices. Keep the upload keystore and Play
   signing records secure.

This document records technical checks and remaining release actions. It is
not an assertion that Google Play has approved the app or that IPOPHL has
determined copyright ownership.

Official references: [Google Play app review preparation](https://support.google.com/googleplay/android-developer/answer/9859455),
[account deletion](https://support.google.com/googleplay/android-developer/answer/13327111),
[target API levels](https://support.google.com/googleplay/android-developer/answer/11926878),
and the [OpenStreetMap tile policy](https://operations.osmfoundation.org/policies/tiles/).
