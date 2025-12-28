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
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 90%;
            max-height: 90vh;
        }
        .left-panel {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            /* height: 100%; */
        }
        .left-panel h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .left-panel p {
            font-size: 1.1rem;
            margin-bottom: 30px;
        }
        .logos {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }
        .logo {
            max-width: 80px;
            height: auto;
        }
        .right-panel {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-login {
            background: linear-gradient(135deg, #1e3a8a 0%, #60a5fa 100%);
            border: none;
            padding: 12px;
            border-radius: 50px;
            width: 100%;
            font-weight: 600;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        }
        .btn-google {
            border: 2px solid #dadce0;
            background: white;
            color: #3c4043;
            border-radius: 50px;
            padding: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-google:hover {
            background: #f8f9fa;
            border-color: #c4c7c5;
            color: #202124;
            text-decoration: none;
        }
        .alert {
            border-radius: 10px;
        }
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
                max-height: none;
            }
            .left-panel {
                padding: 20px;
                height: auto;
            }
            .right-panel {
                height: auto;
            }
            .left-panel h1 {
                font-size: 2rem;
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
    </style>
</head>
<body>
    <div class="login-container row">
                    <!-- Left Panel -->
                    <div class="col-lg-6 left-panel">
                        <h1>
                            <img src="{{ asset('images/logo.png') }}" alt="Dag-ag Tracker Logo" style="height: 50px; width: auto; margin-right: 15px;">
                            Dag-ag Tracker
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
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
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
        // Show modal if there are errors
        document.addEventListener('DOMContentLoaded', function() {
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
                const modal = new bootstrap.Modal(document.getElementById('errorModal'));
                modal.show();
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
