<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prisoner Meeting System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Lato -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* General Body Styling */
        body {
            background: #a4b3261f;
            font-family: 'Lato', sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        /* Form Container Styling */
        .form-container {
            text-align: center;
            margin-bottom: 1.5rem;
            margin-top: 70px;
        }

        .form-container img {
            max-width: 100px;
        }

        .form-container h1 {
            font-size: 1.7rem;
            font-weight: bold;
            color: #084298;
            margin: 20px;
        }

        /* Login Form Styling */
        .login-form {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 500px;
            max-width: 90%;
            margin: 40px auto;
            position: relative;
            z-index: 2;
        }

        /* Input Field Styling */
        .form-control {
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            border: 1px solid black;
        }

        /* Submit Button Styling */
        .btn-login {
            display: inline-block;
            background: linear-gradient(90deg, #084298, #051d4d);
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 30px;
            padding: 0.8rem 2rem;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            /* margin-top: 1rem; */
        }

        .btn-login:hover {
            background: linear-gradient(90deg, #051d4d, #084298);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            color: wheat;
        }

        /* Eye Icon Styling */
        .password-container {
            position: relative;
        }

        .password-container i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }

        /* Footer Links */
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .form-footer a {
            color: #084298;
            font-weight: 600;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .form-footer a:hover {
            color: #051d4d;
        }
    </style>
</head>

<body>
    <div>
        <!-- Logo and Header -->
        <div class="form-container">
            <img src="{{ asset('assam_police_logo.png') }}" alt="School Logo" style="width: 100px;">
            <h1>Assam State Inmate Visitation System <br> Visitor Panel Login</h1>
            {{-- <h4>Meeting Request Portal</h4> --}}
        </div>



        <!-- Login Form -->
        <div class="login-form">

            <div class="msg">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <form action="{{route('visitor.login-submit')}}" method="POST" autocomplete="off">
                @csrf
                <div class="row mb-3">
                    <!-- Phone Number -->
                    <div class="col-md-12 mb-4">
                        <label for="phone" class="form-label">Phone Number <span>*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" maxlength="10" minlength="10"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                            placeholder="Enter Your Phone Number" required>

                        @if ($errors->has('phone'))
                            <div class="text-danger">{{ $errors->first('phone') }}</div>
                        @enderror

                </div>

                <!-- Date of Birth -->
                {{-- <div class="col-md-12 mb-4">
                        <label for="dob" class="form-label">Date of Birth <span>*</span></label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div> --}}

                <!-- Password -->
                <div class="col-md-12 mb-4">
                    <label for="password" class="form-label">Password <span>*</span></label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter Your Password" required>
                        <i class="bi bi-eye-slash" id="togglePassword"></i>
                    </div>
                    @if ($errors->has('password'))
                        <div class="text-danger">{{ $errors->first('password') }}</div>
                    @enderror
            </div>
        </div>

        <!-- Login Button -->
        <button type="submit" class="btn-login w-100">Login</button>
    </form>

    <!-- Footer Links -->
    <div class="form-footer">
        <a href="">Forgot Login Details?</a><br>
        <a href="{{ route('register') }}">Don't have an account? Register a new account</a>
    </div>
</div>
</div>

<!-- JavaScript -->
<script>
    // Toggle Password Visibility
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');

    togglePassword.addEventListener('click', () => {
        // Toggle the input type between 'password' and 'text'
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle the eye icon
        togglePassword.classList.toggle('bi-eye');
        togglePassword.classList.toggle('bi-eye-slash');
    });
</script>
</body>

</html>
