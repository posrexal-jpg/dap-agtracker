<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</head>
<body>
    <div class="login-container row">
                    <!-- Left Panel -->
                    <div class="col-lg-6 left-panel">
                        <h1><i class="fas fa-crown"></i> Dag-ag Tracker</h1>
                        <p>Monitor and track dag-ag (Crown-of-Thorns Starfish) infestations to protect our coral reefs. Join us in preserving marine biodiversity.</p>
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
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <!-- Display validation errors -->
                        @if($errors->any())
                            <div class="alert alert-danger">
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

                        <div class="text-center mt-3">
                            <a href="/" class="text-decoration-none">← Back to Home</a>
                        </div>
                    </div>
                </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
