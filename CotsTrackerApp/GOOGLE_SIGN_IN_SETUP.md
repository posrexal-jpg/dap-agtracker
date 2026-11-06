# COTS Tracker Google Sign-In setup

Google Sign-In requires a Web OAuth client for the Laravel API and a separate
Android OAuth client for every certificate that can sign the Android app. Keep
all of these clients in the same Google Cloud project.

## Application identity

- Android package/application ID: `com.cotstracker.app`
- Backend client ID: the **Web application** OAuth client ID
- Production configuration endpoint:
  `https://cotstracker.com/api/v1/google/config`

The Laravel production environment must set `GOOGLE_CLIENT_ID` to the Web
client ID. `GOOGLE_CLIENT_SECRET` remains server-only and must never be added to
Flutter or committed to Git.

## Android OAuth clients

Create an Android OAuth 2.0 client for each package and SHA-1 pair below.

### Local debug builds

- Package: `com.cotstracker.app`
- SHA-1: `DC:8B:A9:EC:1A:F0:61:59:32:A3:2F:88:C1:D6:A4:B8:AC:5F:61:07`

### Directly installed release builds

- Package: `com.cotstracker.app`
- Upload/release SHA-1:
  `F6:5B:80:19:10:F3:72:A5:B7:57:6E:16:4B:1C:1F:E9:6F:38:65:93`

### Google Play builds

Google Play signs downloaded builds with the **app signing certificate**, not
the upload certificate. The certificate was verified from the Play-installed
`1.2.2` APK on the connected TECNO CLA5:

- Package: `com.cotstracker.app`
- Play app-signing SHA-1:
  `A1:3C:DA:69:CF:6E:B3:39:F9:99:45:0F:2B:CD:13:FA:4C:6A:43:6B`
- Play app-signing SHA-256:
  `2A:00:96:0A:84:3B:25:DA:37:C9:28:25:E0:B2:B2:A4:AF:6E:18:AB:26:07:36:A0:19:3F:82:80:DF:5C:E1:EE`

Create the Android OAuth client with this package and Play SHA-1 pair, then
confirm the value against **Play Console > Setup > App integrity**.

Do not substitute the upload certificate SHA-1 for this Play certificate.

## OAuth consent screen

If the Google OAuth app is still in testing, add every tester's Google account
as a test user. For production, complete the consent-screen branding and publish
the OAuth app as appropriate for the selected audience.

After changing OAuth clients, allow several minutes for Google configuration to
propagate, then uninstall and reinstall the test build before trying again.
