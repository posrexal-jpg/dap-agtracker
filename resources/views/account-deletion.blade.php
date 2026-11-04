<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Request deletion of a COTS Tracker account and associated data.">
    <title>Delete Your Account | COTS Tracker</title>
    <style>
        :root { font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; color: #14323c; background: #f3f7f8; }
        * { box-sizing: border-box; }
        body { margin: 0; line-height: 1.65; }
        a { color: #006d77; text-underline-offset: 3px; }
        a:focus-visible { outline: 3px solid #c75749; outline-offset: 3px; }
        header { background: linear-gradient(120deg, #073747, #006d77); color: white; padding: 26px 0 54px; }
        .wrap { width: min(100% - 32px, 820px); margin-inline: auto; }
        .brand { color: white; text-decoration: none; font-weight: 800; }
        h1 { font-size: clamp(2rem, 5vw, 3rem); line-height: 1.12; margin: 28px 0 8px; }
        header p { margin: 0; color: #d8f2ef; }
        main { background: white; border: 1px solid #dde8eb; border-radius: 18px; box-shadow: 0 10px 30px #07374710; margin-top: -22px; padding: clamp(24px, 5vw, 48px); position: relative; }
        h2 { font-size: 1.2rem; color: #073747; margin: 30px 0 8px; }
        p, ol { margin: 0 0 16px; }
        ol { padding-left: 23px; }
        li + li { margin-top: 8px; }
        .contact { background: #def2f0; border-radius: 12px; padding: 16px 20px; overflow-wrap: anywhere; }
        footer { color: #5b727d; padding: 28px 0; font-size: .9rem; }
    </style>
</head>
<body>
    <header><div class="wrap">
        <a class="brand" href="{{ route('home') }}">COTS Tracker</a>
        <h1>Delete your account</h1>
        <p>Request removal of your COTS Tracker account and associated data.</p>
    </div></header>
    <div class="wrap">
        <main>
            <p><strong>SLSU-BONTOC Digital Technology</strong> handles COTS Tracker account deletion requests. You can make a request here even if you no longer have the app or cannot sign in.</p>
            <h2>How to request deletion</h2>
            <ol>
                <li>Email <a href="mailto:privacy@cotstracker.com?subject=COTS%20Tracker%20account%20deletion%20request">privacy@cotstracker.com</a> with the subject <strong>COTS Tracker account deletion request</strong>.</li>
                <li>Include the email address used for your COTS Tracker account. You may also ask us to remove particular reports or uploaded photos.</li>
                <li>We may verify that you control the account before deleting it. We will reply about the result or explain any information we must retain for a legal or research obligation.</li>
            </ol>
            <div class="contact"><strong>Deletion request address:</strong><br><a href="mailto:privacy@cotstracker.com?subject=COTS%20Tracker%20account%20deletion%20request">privacy@cotstracker.com</a></div>
            <h2>What happens to your data</h2>
            <p>On a verified account deletion request, we remove the account and its associated personal information, submitted reports, and uploaded report photos, except information we must retain for a legitimate legal or research obligation. Removing the app also erases its locally stored data on that device. See our <a href="{{ route('privacy') }}">privacy policy</a> for details.</p>
        </main>
        <footer><a href="{{ route('home') }}">Back to COTS Tracker</a></footer>
    </div>
</body>
</html>
