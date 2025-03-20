<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:image" content="{{ asset('assam_police_logo.png') }}">
    <title>Assam State Inmate Visitation System || Control Panel Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .lato-thin {
            font-family: "Lato", system-ui;
            font-weight: 100;
            font-style: normal;
        }

        .lato-light {
            font-family: "Lato", system-ui;
            font-weight: 300;
            font-style: normal;
        }

        .lato-regular {
            font-family: "Lato", system-ui;
            font-weight: 400;
            font-style: normal;
        }

        .lato-bold {
            font-family: "Lato", system-ui;
            font-weight: 700;
            font-style: normal;
        }

        .lato-black {
            font-family: "Lato", system-ui;
            font-weight: 900;
            font-style: normal;
        }

        .lato-thin-italic {
            font-family: "Lato", system-ui;
            font-weight: 100;
            font-style: italic;
        }

        .lato-light-italic {
            font-family: "Lato", system-ui;
            font-weight: 300;
            font-style: italic;
        }

        .lato-regular-italic {
            font-family: "Lato", system-ui;
            font-weight: 400;
            font-style: italic;
        }

        .lato-bold-italic {
            font-family: "Lato", system-ui;
            font-weight: 700;
            font-style: italic;
        }

        .lato-black-italic {
            font-family: "Lato", system-ui;
            font-weight: 900;
            font-style: italic;
        }

        /* Full-Screen Background Image */
        .bg-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://www.feeregulatoryassam.com/assets/images/login-bg-school.png') no-repeat center center/cover;
            filter: brightness(0.6);
            /* Darken the image for better text visibility */
            z-index: -1;
        }

        /* Card Styling */
        .login-card {
            background-color: rgba(255, 255, 255, 0.9);
            /* Semi-transparent background */
            border-radius: 15px;
            animation: fadeIn 1.5s ease-in-out;
        }

        /* Input Styling */
        .form-control {
            height: 45px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        /* Button Styling */
        .login-btn {
            background-color: #6a11cb;
            border: none;
            height: 45px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background-color: #2575fc;
            transform: scale(1.05);
        }

        /* Link Styling */
        .forget-link,
        .register-link {
            color: #6a11cb;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forget-link:hover,
        .register-link:hover {
            color: #2575fc;
        }

        /* Animation */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="bg-image"></div> <!-- Background Image -->

    <div class="container lato-regular">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-4">

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-lg p-4 login-card">
                    <h4 class="text-center mb-4">Assam State Inmate Visitation System <br>
                        Control Panel Login</h4>
                    <form id="loginForm" action="{{ route('admin.login.submit') }}" method="POST">
                        @csrf
                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" placeholder="Enter your email">
                            @if ($errors->has('email'))
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                            @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter your password">
                        @if ($errors->has('password'))
                            <div class="text-danger">{{ $errors->first('password') }}</div>
                        @enderror
                </div>

                <!-- Login Button -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary login-btn">Login</button>
                </div>

            </form>
        </div>
    </div>
</div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
</body>

</html>
