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
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .navbar-brand img {
            height: 40px;
            width: auto;
            margin-right: 10px;
        }

        /* Animated background elements */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 20%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .shape:nth-child(4) {
            width: 40px;
            height: 40px;
            bottom: 10%;
            right: 20%;
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .error-404-container {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .error-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 600px;
            width: 100%;
            padding: 3rem 2rem;
            text-align: center;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-icon {
            font-size: 5rem;
            color: #1e3a8a;
            margin-bottom: 1.5rem;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .error-number {
            font-size: 8rem;
            font-weight: 900;
            color: #1e3a8a;
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.1); }
            to { text-shadow: 3px 3px 20px rgba(30, 58, 138, 0.3); }
        }

        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .error-description {
            color: #6b7280;
            font-size: 1.2rem;
            line-height: 1.7;
            margin-bottom: 2.5rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border: none;
            border-radius: 50px;
            padding: 14px 32px;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-primary-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary-custom:hover::before {
            left: 100%;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-secondary-custom {
            border: 2px solid #e5e7eb;
            background: white;
            color: #6b7280;
            border-radius: 50px;
            padding: 14px 32px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .btn-secondary-custom:hover {
            border-color: #d1d5db;
            background: #f9fafb;
            color: #374151;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .quick-links {
            background: rgba(30, 58, 138, 0.05);
            border-radius: 16px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .quick-links h5 {
            color: #1e3a8a;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .link-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 0.75rem;
        }

        .link-item {
            background: white;
            border-radius: 12px;
            padding: 1rem 0.75rem;
            text-decoration: none;
            color: #4b5563;
            font-weight: 500;
            font-size: 0.9rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(30, 58, 138, 0.1);
        }

        .link-item:hover {
            background: #1e3a8a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
            text-decoration: none;
        }

        .link-item i {
            display: block;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #60a5fa;
        }

        .link-item:hover i {
            color: white;
        }

        .footer-note {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .coral-emoji {
            font-size: 2rem;
            margin: 1rem 0;
            animation: wave 2s ease-in-out infinite;
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .error-content {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }

            .error-number {
                font-size: 6rem;
            }

            .error-title {
                font-size: 2rem;
            }

            .error-description {
                font-size: 1.1rem;
            }

            .action-buttons {
                gap: 0.75rem;
            }

            .btn-primary-custom,
            .btn-secondary-custom {
                padding: 12px 24px;
                font-size: 1rem;
            }

            .link-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }

            .link-item {
                padding: 0.75rem 0.5rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .error-number {
                font-size: 5rem;
            }

            .error-title {
                font-size: 1.75rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-primary-custom,
            .btn-secondary-custom {
                width: 100%;
            }

            .link-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .error-content {
                background: rgba(17, 24, 39, 0.95);
                color: #f9fafb;
            }

            .error-title {
                color: #f9fafb;
            }

            .error-description {
                color: #d1d5db;
            }

            .btn-secondary-custom {
                background: #374151;
                border-color: #4b5563;
                color: #f9fafb;
            }

            .btn-secondary-custom:hover {
                background: #4b5563;
                border-color: #6b7280;
                color: #f9fafb;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute top-0 start-0 w-100" style="z-index: 10;">
        <div class="container">
            <a class="navbar-brand text-white" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Dag-ag Tracker Logo">
                <span class="fw-bold">Dag-ag Tracker</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/sightings">COTS Sightings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/#partners">Partners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="error-404-container">
        <div class="error-content">
            <!-- Error Icon -->
            <div class="error-icon">
                <i class="fas fa-compass"></i>
            </div>

            <!-- Error Number -->
            <div class="error-number">404</div>

            <!-- Error Title -->
            <h1 class="error-title">Lost in the Reef?</h1>

            <!-- Error Description -->
            <p class="error-description">
                The page you're looking for seems to have drifted away with the ocean currents.
                But don't worry – our coral reefs are still safe and our mission continues!
            </p>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ url('/') }}" class="btn-primary-custom">
                    <i class="fas fa-home"></i>
                    Back to Home
                </a>
                <button onclick="history.back()" class="btn-secondary-custom">
                    <i class="fas fa-arrow-left"></i>
                    Go Back
                </button>
            </div>

            <!-- Quick Links -->
            <div class="quick-links">
                <h5><i class="fas fa-link me-2"></i>Quick Navigation</h5>
                <div class="link-grid">
                    <a href="/sightings" class="link-item">
                        <i class="fas fa-map-marker-alt"></i>
                        View Map
                    </a>
                    <a href="/login" class="link-item">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </a>
                    <a href="/download" class="link-item">
                        <i class="fas fa-download"></i>
                        Install App
                    </a>
                    <a href="/#about" class="link-item">
                        <i class="fas fa-info-circle"></i>
                        About
                    </a>
                </div>
            </div>

            <!-- Fun Element -->
            <div class="coral-emoji">
                🐠🌊
            </div>

            <!-- Footer Note -->
            <div class="footer-note">
                <p class="mb-0">
                    <strong>Dag-ag Tracker</strong> - Protecting coral reefs, one sighting at a time.
                    <br>
                    <small>Developed in partnership with DOST and SLSU Bontoc</small>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Interactive Elements -->
    <script>
        // Add some interactive fun
        document.addEventListener('DOMContentLoaded', function() {
            // Random coral emoji animation
            const coralEmoji = document.querySelector('.coral-emoji');
            const emojis = ['🐠', '🦀', '🐟', '🪸', '🐙', '🦑', '🐡', '🐠🌊'];

            setInterval(() => {
                const randomEmoji = emojis[Math.floor(Math.random() * emojis.length)];
                coralEmoji.textContent = randomEmoji;
            }, 3000);

            // Add click effect to buttons
            const buttons = document.querySelectorAll('.btn-primary-custom, .btn-secondary-custom');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Add ripple effect
                    const ripple = document.createElement('span');
                    ripple.style.position = 'absolute';
                    ripple.style.borderRadius = '50%';
                    ripple.style.background = 'rgba(255, 255, 255, 0.3)';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'ripple 0.6s linear';
                    ripple.style.left = (e.offsetX - 10) + 'px';
                    ripple.style.top = (e.offsetY - 10) + 'px';
                    ripple.style.width = '20px';
                    ripple.style.height = '20px';

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
