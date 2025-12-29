<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1e3a8a" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="apple-mobile-web-app-title" content="Dag-ag Tracker" />
    <link rel="manifest" href="/manifest.json" />
    <link rel="apple-touch-icon" href="/images/logo.png" />
    <title>Download - Dag-ag Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .download-container {
            padding: 80px 0;
        }

        .download-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
        }

        .download-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .download-body {
            padding: 2rem;
        }

        .download-item {
            background: #f8fafc;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .download-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .download-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .btn-download {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-download:hover {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 58, 138, 0.3);
            color: white;
            text-decoration: none;
        }

        .back-link {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: #60a5fa;
            text-decoration: none;
            transform: translateX(-5px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Dag-ag Tracker Logo" style="height: 40px; width: auto; margin-right: 10px;">
                Dag-ag Tracker
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sightings">COTS Sightings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#partners">Partners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Download Section -->
    <section class="download-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <a href="/" class="back-link">
                        <i class="fas fa-arrow-left"></i>
                        Back to Home
                    </a>

                    <div class="download-card">
                        <div class="download-header">
                            <h1 class="mb-2">Download Center</h1>
                            <p class="mb-0">Get the COTS Tracker mobile application</p>
                        </div>
                        <div class="download-body">
                            <div class="download-item text-center">
                                <div class="download-icon">
                                    <i class="fab fa-android"></i>
                                </div>
                                <h4>COTS Tracker Mobile App</h4>
                                <p class="text-muted mb-4">Android application for COTS sighting reporting and reef monitoring</p>
                                <a href="https://github.com/Yajzkie/Android-Cots-Tracker-app.git" class="btn-download" target="_blank">
                                    <i class="fas fa-download"></i>
                                    Download APK
                                </a>
                            </div>

                            <div class="text-center">
                                <p class="text-muted">
                                    <small>Having trouble downloading? Visit our GitHub repository for installation instructions.</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>