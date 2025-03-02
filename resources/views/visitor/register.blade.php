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
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            margin-top: 20px;
        }

        .form-container img {
            max-width: 100px;
            /* margin-bottom: 0.5rem; */
        }

        .form-container h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #084298;
            margin: 20px;
        }

        /* Registration Form Styling */
        .registration-form {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 800px;
            max-width: 90%;
            margin: 20px auto;
            position: relative;
            z-index: 2;
        }

        /* Input and Select Field Styling */
        .form-control,
        .select2-container--default .select2-selection--single {
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            border: 1px solid black;
        }

        /* Submit Button Styling */
        .btn-next {
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
        }

        .btn-next:hover {
            background: linear-gradient(90deg, #051d4d, #084298);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            color: wheat;
        }

        /* Label and Asterisk Styling */
        label span {
            color: red;
        }

        .select2-container .select2-selection--single {
            height: 38px;
            /* Match Bootstrap form control height */
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
        }

        .form-control,
        .select2-container--default .select2-selection--single {
            border: 1px solid #00000052;
        }

        /* Flying Icons */
        .floating-icons {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .floating-icons i {
            position: absolute;
            font-size: 3rem;
            color: rgba(108, 117, 125, 0.2);
            animation: float 10s infinite ease-in-out;
        }

        @keyframes float {
            0% {
                transform: translateY(100%);
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100%);
                opacity: 0;
            }
        }

        .floating-icons i:nth-child(1) {
            left: 10%;
            animation-duration: 9s;
        }

        .floating-icons i:nth-child(2) {
            left: 30%;
            animation-duration: 11s;
        }

        .floating-icons i:nth-child(3) {
            left: 60%;
            animation-duration: 7s;
        }

        .floating-icons i:nth-child(4) {
            left: 85%;
            animation-duration: 10s;
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

    <!-- Floating Background Icons -->
    <div class="floating-icons">
        <i class="bi bi-book"></i>
        <i class="bi bi-book-half"></i>
        <i class="bi bi-mortarboard-fill"></i>
        <i class="bi bi-journal"></i>
    </div>

    <div>
        <!-- Logo and Header -->
        <div class="form-container">
            <img src="{{ asset('assam_police_logo.png') }}" alt="School Logo" style="width: 100px;">
            <h1>Register Yourself for the Assam State <br> Inmate Visitation System.</h1>
            {{-- <h4>Register Your Self</h4> --}}
        </div>

        <div class="registration-form">
            <form id="visitorRegisterForm" method="POST" autocomplete="off">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6 mb-4">
                        <label for="jailer_id" class="form-label">Select Jail <span>*</span></label>
                        <select class="form-control select2" id="jailer_id" name="jailer_id">
                            <option value="" disabled selected>Select Jail</option>
                            @foreach ($jails as $jail)
                                <option value="{{ $jail->id }}">
                                    {{ $jail->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="jailer_id_error"></span>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="fullname" class="form-label">Full Name (Candidate name)<span>*</span></label>
                        <input type="text" class="form-control" id="fullname" name="fullname"
                            placeholder="Enter your full name">
                        <span class="text-danger" id="fullname_error"></span>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="phone" class="form-label">Mobile Number <span>*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            placeholder="Enter your phone number" maxlength="10" minlength="10"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                        <span class="text-danger" id="phone_error"></span>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="gender" class="form-label">Gender <span>*</span></label>
                        <select class="form-control select2" id="gender" name="gender">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <span class="text-danger" id="gender_error"></span>
                    </div>


                    <div class="col-md-6 mb-4">
                        <label for="password" class="form-label">Password <span>*</span></label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter your Password">
                            <span class="text-danger" id="password_error"></span>
                    </div>


                    <div class="col-md-6 mb-4">
                        <label for="confirm_password" class="form-label">Confirm Password <span>*</span></label>
                        <input type="password" class="form-control" id="confirm_password"
                            name="confirm_password" placeholder="Enter your Confirm Password">
                            <span class="text-danger" id="confirm_password_error"></span>
                    </div>



                    <button type="submit" class="btn btn-next mt-3" id="btnSubmit">Submit</button>
                    {{-- <a href="{{ route('register-step-1') }}" class="btn btn-next mt-3">Submit</a> --}}
            </form>

            <!-- Footer Links -->
            <div class="form-footer">
                <a href="">Forgot Login Details?</a><br>
                <a href="{{ route('login') }}">I'm already signed up. Go to Login</a>
            </div>
        </div>
    </div>

    <!-- jQuery and Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        // Initialize Select2
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });


            $("#visitorRegisterForm").submit(function(e) {
                e.preventDefault();

                const fd = new FormData(this);

                $.ajax({
                    url: "{{ route('register-submit') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#btnSubmit").html("Please Wait ...");
                        $('#btnSubmit').attr('disabled', true);
                    },
                    error: function(xhr) {
                        // console.log(xhr);
                        $("[id$='_error']").html('');
                        $("#btnSubmit").html("Submit");
                        $('#btnSubmit').attr('disabled', false);

                        $.each(xhr.responseJSON.errors, function(key, value) {
                            console.log(key);
                            // alert(key);
                            if (key.includes('.')) {
                                // Replace dots with underscores in the key
                                let modifiedKey = key.replace(/\./g, '_');

                                // Construct the error field ID
                                let errorFieldId = modifiedKey + '_error';

                                $('#' + errorFieldId).html(
                                    '<span style="color:red">' + value +
                                    '</span');
                            } else {
                                // For non-array fields
                                $('#' + key + '_error').html(
                                    '<span style="color:red">' + value +
                                    '</span');
                            }
                        });


                        $("#btnSubmit").html("Submit");
                        $('#btnSubmit').attr('disabled', false);
                    },
                    success: function(data) {
                        console.log(data);
                        $("#btnSubmit").html("Submit");
                        $('#btnSubmit').attr('disabled', false);
                        if (data.success == true) {
                            swal(data.message, {
                                icon: "success",
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1500);

                        } else if (data.success == false) {
                            swal(data.message, {
                                icon: "warning",
                            });

                        } else {
                            alert(data.message);
                        }
                    }

                });
            });


        });
    </script>

</body>

</html>
