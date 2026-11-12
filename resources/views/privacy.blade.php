<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Privacy policy for the COTS Tracker app and cotstracker.com service.">
    <title>Privacy Policy | COTS Tracker</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; color: #14323c; background: #f3f7f8; }
        * { box-sizing: border-box; }
        body { margin: 0; line-height: 1.65; }
        a { color: #006d77; text-underline-offset: 3px; }
        a:focus-visible { outline: 3px solid #c75749; outline-offset: 3px; }
        header { background: linear-gradient(120deg, #073747, #006d77); color: white; }
        .wrap { width: min(100% - 32px, 820px); margin-inline: auto; }
        header .wrap { padding: 26px 0 40px; }
        .brand { color: white; text-decoration: none; font-weight: 800; letter-spacing: .02em; }
        h1 { font-size: clamp(2rem, 5vw, 3rem); line-height: 1.12; margin: 28px 0 8px; }
        header p { margin: 0; color: #d8f2ef; }
        main { background: white; border: 1px solid #dde8eb; border-radius: 18px; box-shadow: 0 10px 30px #07374710; margin-block: -18px 36px; padding: clamp(24px, 5vw, 48px); position: relative; }
        h2 { font-size: 1.2rem; line-height: 1.3; margin: 34px 0 8px; color: #073747; }
        p, ul { margin: 0 0 16px; }
        ul { padding-left: 22px; }
        li + li { margin-top: 7px; }
        .updated { color: #5b727d; font-size: .95rem; }
        .contact { background: #def2f0; border-radius: 12px; padding: 16px 20px; overflow-wrap: anywhere; }
        footer { color: #5b727d; padding-bottom: 34px; font-size: .9rem; }
    </style>
</head>
<body>
    <header>
        <div class="wrap">
            <a class="brand" href="{{ route('home') }}">COTS Tracker</a>
            <h1>Privacy Policy</h1>
            <p>How COTS Tracker handles account and crown-of-thorns starfish sighting information.</p>
        </div>
    </header>
    <div class="wrap">
        <main>
            <p class="updated">Effective November 4, 2026</p>
            <p><strong>SLSU-BONTOC Digital Technology</strong> operates the COTS Tracker mobile app and its associated service at <a href="https://cotstracker.com/">cotstracker.com</a>. This policy explains the information we handle when you use the app or website.</p>

            <h2>Information we handle</h2>
            <ul>
                <li><strong>Account details:</strong> your name, email address, sign-in credentials, and account approval status. If you choose Google sign-in, we may receive your Google account name, email address, and account identifier to sign you in.</li>
                <li><strong>Sighting reports:</strong> the location name, municipality, barangay, precise coordinates, observation date and time, crown-of-thorns starfish counts and size classes, activity and observer categories, survey status, optional observation duration, survey dimensions and area, depth, water visibility, weather or sea conditions, optional observer name and notes, and any photos you attach.</li>
                <li><strong>On-device data:</strong> reports waiting to sync, cached sightings and map tiles, an email address if you select “Remember email,” and app settings. The app stores its sign-in token using the device’s secure storage.</li>
            </ul>
            <p>Location access is used when you choose to obtain your current position for a report. You can instead enter coordinates or place the map pin manually. Photo access is used when you choose to attach images.</p>

            <h2>Why we use it</h2>
            <p>We use account details to authenticate and support users. We use sighting reports to record, map, review, and study crown-of-thorns starfish observations for marine monitoring. The app keeps reports on the device when offline and sends them to the COTS Tracker service when synchronization is available.</p>

            <h2>Who can see the information</h2>
            <p>The public sightings map may show a report’s precise coordinates, location name, municipality, barangay, observation date and time, and starfish count. Other signed-in users and authorized project administrators may see additional report details, including observer information and photo links. Uploaded photo files are stored at web-accessible URLs; anyone who has a direct photo URL may be able to view that image. Please avoid including private information in report text or photos that you do not want shared in this way.</p>
            <p>We use service providers to host and operate the app and website. Map views request tiles from OpenStreetMap infrastructure, which may receive your network address and the map area viewed. If you choose Google sign-in, Google processes the sign-in request under its own privacy practices. We do not use the Android advertising ID for ads.</p>

            <h2>Storage, security, and deletion</h2>
            <p>The production app sends account and report data to the service over HTTPS. Access to account and report functions is limited by sign-in and account permissions. Offline reports and cached data remain on your device until you remove them or uninstall the app. Signing out does not automatically erase saved reports on the device.</p>
            <p>There is no fixed automatic expiry for account and submitted sighting records. We retain them while needed to operate the service and support the monitoring project, unless they are deleted or a valid deletion request is fulfilled, subject to applicable legal or research retention needs. You can delete your own report in the app. Deleting a synchronized report removes its database record and associated uploaded photos. Contact us to request removal of an account or other associated data.</p>
            <p>To request access, correction, or deletion of your account or information, email the address below. Include the email linked to your COTS Tracker account and describe your request. We may verify your identity before acting and will explain if any information must be retained. You can also use our <a href="{{ route('account-deletion') }}">account deletion request page</a> without signing in.</p>

            <h2>Changes and contact</h2>
            <p>We may update this policy when the app or its data practices change. The effective date at the top of this page will show the latest version.</p>
            <div class="contact">
                <strong>SLSU-BONTOC Digital Technology</strong><br>
                Privacy and deletion requests: <a href="mailto:privacy@cotstracker.com">privacy@cotstracker.com</a>
            </div>
        </main>
        <footer><a href="{{ route('home') }}">Back to COTS Tracker</a></footer>
    </div>
</body>
</html>
