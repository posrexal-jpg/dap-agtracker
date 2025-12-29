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
    <title>Page Not Found - Dag-ag Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
            margin-right: 10px;
        }
    .error-404-container {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .error-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: none;
        max-width: 500px;
        width: 100%;
    }

    .error-number {
        font-size: 8rem;
        font-weight: 700;
        color: #1e3a8a;
        line-height: 1;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .error-title {
        font-size: 2rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 1rem;
    }

    .error-description {
        color: #6b7280;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .btn-go-home {
        background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 1.1rem;
        color: white;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
    }

    .btn-go-home:hover {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-go-back {
        border: 2px solid #d1d5db;
        background: white;
        color: #6b7280;
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        margin-left: 10px;
    }

    .btn-go-back:hover {
        border-color: #9ca3af;
        background: #f9fafb;
        color: #374151;
        text-decoration: none;
    }

    .logo-404 {
        max-width: 100px;
        height: auto;
        margin-bottom: 2rem;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
    }

    .fun-element {
        margin-top: 3rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .fun-element p {
        color: #374151;
        font-weight: 500;
        margin: 0;
    }

    @media (max-width: 768px) {
        .error-number {
            font-size: 6rem;
        }

        .error-title {
            font-size: 1.5rem;
        }

        .btn-go-home,
        .btn-go-back {
            padding: 10px 20px;
            font-size: 1rem;
            margin-left: 0;
            margin-top: 10px;
        }

        .logo-404 {
            max-width: 80px;
        }
    }

    @media (max-width: 576px) {
        .error-404-container {
            padding: 10px;
        }

        .error-card .card-body {
            padding: 2rem 1.5rem;
        }

        .error-number {
            font-size: 5rem;
        }

        .btn-go-home,
        .btn-go-back {
            width: 100%;
            margin-left: 0;
        }
    }
</style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Dag-ag Tracker Logo">
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

<div class="error-404-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Dag-ag Tracker Logo" class="logo-404">
                </div>

                <!-- Error Card -->
                <div class="error-card">
                    <div class="card-body text-center">
                        <div class="error-number">404</div>
                        <h2 class="error-title">Oops! Page Not Found</h2>
                        <p class="error-description">
                            The page you're looking for seems to have wandered off into the coral reefs.
                            Don't worry, let's get you back on track!
                        </p>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-2">
                            <a href="{{ url('/') }}" class="btn-go-home">
                                <i class="fas fa-home me-2"></i>Go Home
                            </a>
                            <button onclick="history.back()" class="btn-go-back">
                                <i class="fas fa-arrow-left me-2"></i>Go Back
                            </button>
                        </div>

                        <!-- Help Text -->
                        <div class="mt-4 pt-3 border-top border-light">
                            <p class="text-muted small mb-1">Need assistance?</p>
                            <p class="text-muted small">
                                If you believe this is an error, please contact our support team or try navigating from the home page.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fun Element -->
                <div class="fun-element text-center">
                    <p>🐠 Help protect our coral reefs by reporting COTS sightings with Dag-ag Tracker!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p>&copy; 2025 Dag-ag Tracker. All rights reserved.</p>
        <p>Developed in partnership with DOST and SLSU Bontoc.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
