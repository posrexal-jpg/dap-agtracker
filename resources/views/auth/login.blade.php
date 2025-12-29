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
    <title>Dag-ag Tracker - Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-modal .modal-dialog {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }

        .login-modal .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-modal .modal-body {
            padding: 0;
        }

        .login-modal {
            z-index: 1055; /* Standard Bootstrap modal z-index */
        }

        .left-panel {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            color: white;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 400px;
        }

        .left-panel h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .left-panel h1 img {
            height: 50px;
            width: auto;
        }

        .left-panel p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .logos {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .logo {
            max-width: 80px;
            height: auto;
        }

        .right-panel {
            background: white;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 400px;
        }

        .right-panel h3 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
        }

        .right-panel > p {
            font-size: 0.95rem;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            width: 100%;
            font-weight: 600;
            font-size: 1rem;
            min-height: 48px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        }

        .btn-google {
            border: 2px solid #dadce0;
            background: white;
            color: #3c4043;
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            min-height: 48px;
            font-size: 1rem;
        }

        .btn-google:hover {
            background: #f8f9fa;
            border-color: #c4c7c5;
            color: #202124;
            text-decoration: none;
        }

        .alert {
            border-radius: 10px;
            font-size: 0.9rem;
        }

        .text-center.mt-3 a {
            color: #1e3a8a;
            font-weight: 500;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #374151;
        }

        /* Modal responsiveness */
        @media (max-width: 991.98px) {
            .login-modal .modal-dialog {
                max-width: 95vw;
            }

            .left-panel,
            .right-panel {
                padding: 20px;
            }

            .left-panel h1 {
                font-size: 2rem;
            }

            .left-panel h1 img {
                height: 40px;
            }
        }

        @media (max-width: 767.98px) {
            body {
                padding: 10px;
            }

            .login-modal .modal-dialog {
                max-width: 100vw;
                margin: 0;
            }

            .login-modal .modal-content {
                border-radius: 10px;
            }

            .left-panel {
                padding: 20px 15px;
                min-height: 250px;
            }

            .left-panel h1 {
                font-size: 1.8rem;
                flex-direction: column;
            }

            .left-panel h1 img {
                height: 35px;
                margin-bottom: 10px;
            }

            .left-panel p {
                font-size: 0.95rem;
                margin-bottom: 20px;
            }

            .logos {
                gap: 15px;
                margin-top: 20px;
            }

            .logo {
                max-width: 50px;
            }

            .right-panel {
                padding: 20px 15px;
                min-height: 300px;
            }

            .right-panel h3 {
                font-size: 1.5rem;
                margin-bottom: 8px;
            }

            .right-panel > p {
                font-size: 0.9rem;
                margin-bottom: 20px;
            }

            .form-control {
                padding: 10px 14px;
                font-size: 16px; /* Prevents zoom on iOS */
                min-height: 44px;
            }

            .btn-login,
            .btn-google {
                padding: 12px 20px;
                min-height: 48px;
                font-size: 16px;
            }
        }

        /* Landscape phones */
        @media (max-height: 500px) and (orientation: landscape) {
            .login-modal .modal-dialog {
                margin: 5px auto;
            }

            .left-panel,
            .right-panel {
                min-height: 200px;
                padding: 15px;
            }

            .left-panel h1 {
                font-size: 1.5rem;
                margin-bottom: 10px;
            }

            .left-panel p {
                font-size: 0.85rem;
                margin-bottom: 15px;
            }

            .logos {
                margin-top: 15px;
            }

            .logo {
                max-width: 40px;
            }
        }
    </style>
    <style>
        #errorModal ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        #errorModal li {
            margin-bottom: 5px;
        }
        #errorModal .modal-content {
            border-radius: 15px;
        }
        #errorModal .modal-dialog {
            /* Removed margin to allow proper centering */
        }
        #errorModal {
            z-index: 1060; /* Higher than default Bootstrap modal z-index */
        }

        /* Modal responsiveness */
        @media (max-width: 575.98px) {
            #errorModal .modal-dialog {
                margin: 1rem;
                max-width: none;
            }
            #errorModal .modal-content {
                border-radius: 10px;
            }
            #errorModal .modal-body {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Login Modal -->
    <div class="modal fade login-modal show" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="false" style="display: block;" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Left Panel -->
                        <div class="col-lg-6 left-panel">
                            <h1>
                                <img src="{{ asset('images/logo.png') }}" alt="Dag-ag Tracker Logo">
                                <span>Dag-ag Tracker</span>
                            </h1>
                            <p>Monitor and track Crown-of-Thorns Starfish (COTS), locally known as Dap-ag, infestations to protect our coral reefs. Join us in preserving marine biodiversity.</p>
                            <div class="logos">
                                <img src="{{ asset('images/logo1.png') }}" alt="DOST Logo" class="logo">
                                <img src="{{ asset('images/logo3.png') }}" alt="SLSU Bontoc Logo" class="logo">
                            </div>
                        </div>

                        <!-- Right Panel -->
                        <div class="col-lg-6 right-panel">
                            <h3 class="text-center mb-4">Welcome Back</h3>
                            <p class="text-center text-muted mb-4">Please sign in to your account</p>

                            <!-- Display login error message if available -->
                            @if(session('error'))
                                <div class="alert alert-danger" id="session-error">{{ session('error') }}</div>
                            @endif

                            <!-- Display validation errors -->
                            @if($errors->any())
                                <div class="alert alert-danger" id="validation-errors">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autocomplete="email">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-login">Login</button>
                            </form>

                            <div class="text-center my-3">
                                <span class="text-muted">or</span>
                            </div>

                            <a href="{{ route('google.login') }}" class="btn btn-outline-secondary btn-google w-100 mb-3">
                                <i class="fab fa-google me-2"></i>Continue with Google
                            </a>

                            <div class="text-center mt-3">
                                <a href="/" class="text-decoration-none">← Back to Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title" id="errorModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Authentication Failed
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4" id="errorModalBody">
                    <!-- Error message will be inserted here -->
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Try Again
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize and show the login modal
        document.addEventListener('DOMContentLoaded', function() {
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'), {
                backdrop: 'static',
                keyboard: false
            });
            loginModal.show();

            // Show error modal if there are errors
            const sessionError = document.getElementById('session-error');
            const validationErrors = document.getElementById('validation-errors');

            let errorMessage = '';

            if (sessionError) {
                errorMessage = sessionError.innerHTML;
                sessionError.style.display = 'none';
            } else if (validationErrors) {
                errorMessage = validationErrors.innerHTML;
                validationErrors.style.display = 'none';
            }

            if (errorMessage) {
                document.getElementById('errorModalBody').innerHTML = errorMessage;
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            }
        });
    </script>
    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('Service Worker registered:', registration);
                    })
                    .catch(error => {
                        console.log('Service Worker registration failed:', error);
                    });
            });
        }
    </script>
</body>
</html>
