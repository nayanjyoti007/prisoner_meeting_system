@extends('visitor.layout.master')
@section('title', 'VISITOR | DASHBOARD')
@section('dashboard', 'active')
@section('headerTitle', 'DASHBOARD')
@section('mycss')
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        .kyc-card-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .kyc-card {
            background: white;
            padding: 25px;
            width: 350px;
            border-radius: 12px;
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .kyc-tick-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 70px;
            height: 70px;
            background: #2ecc71;
            border-radius: 50%;
            margin: 0 auto 15px;
            position: relative;
        }

        .kyc-tick-container svg {
            width: 40px;
            height: 40px;
            stroke: white;
            stroke-width: 5;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            stroke-dasharray: 50;
            stroke-dashoffset: 50;
            animation: kyc-draw 0.6s forwards ease-out;
        }

        @keyframes kyc-draw {
            from {
                stroke-dashoffset: 50;
            }

            to {
                stroke-dashoffset: 0;
            }
        }

        .kyc-card-title {
            color: #333;
            margin: 15px 0 5px;
            font-weight: 700;
            font-family: 'Lato', sans-serif;
        }

        .kyc-card-text {
            color: #555;
            font-size: 16px;
            margin: 5px 0;
            font-family: 'Lato', sans-serif;
        }

        .kyc-date {
            background: rgba(0, 0, 0, 0.05);
            display: inline-block;
            padding: 8px 12px;
            border-radius: 5px;
            font-weight: 600;
            color: #333;
            margin-top: 10px;
            font-family: 'Lato', sans-serif;
        }

        .kyc-bottom-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: #2ecc71;
        }
    </style>
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">

                <a href="{{ route('visitor.notification') }}">
                    <div class="notifications-container top-0 end-0">
                        <div class="col-md-3 order-4 notification-card bottom-0 end-0">
                            @forelse ($notifications as $item)
                                <div class="bs-toast toast fade show bg-success mb-3" role="alert" aria-live="assertive"
                                    aria-atomic="true">
                                    <div class="toast-header">
                                        <i class="bx bx-bell me-2"></i>
                                        <div class="me-auto fw-semibold">Notification</div>
                                        <small>{{ $item->time_date }}</small>
                                        <button type="button" class="btn-close" data-bs-dismiss="toast"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="toast-body">
                                        {{ $item->title }}
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </a>



                @php
                    $visitor_kyc_approved = Auth::guard('visitor')->user()->kyc_status;
                @endphp

                @php
                    $visitor_kyc_update = Auth::guard('visitor')->user()->kyc_update;
                @endphp

                <!-- Bootstrap Table with Header - Dark -->
                {{-- <div class="col-md-5">
                    <div class="card">
                        <div class="card-body" style="padding:0px;">
                            <h6 class="card-header" style="padding-bottom: 0px;">
                                Distrct:- {{ $distData->dist_name }} </h6>

                            <h6 class="card-header" style="padding-bottom: 0px;">
                                @if ($check_first_password && Auth::guard('district')->user())
                                    Inspector Name:- {{ Auth::guard('district')->user()->inspector_name }}
                                @endif
                            </h6>

                            <h6 class="card-header">
                                @if ($check_first_password && Auth::guard('district')->user())
                                    Inspector Mobile Number:- {{ Auth::guard('district')->user()->inspector_mobile }}
                                @endif
                            </h6>


                        </div>
                    </div>
                </div> --}}

                {{-- @if ($check_first_password == 1)
                    <div class="col-md-2">
                        <a href="{{ route('district.external.form') }}" class="custom-btn status-btn mb-3"
                           style="padding: 8px;">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            Add New External</a>
                    </div>
                @endif --}}


                @if ($visitor_kyc_approved == 'Pending' || $visitor_kyc_approved == 'Rejected')
                    <div class="offset-md-2 col-md-7">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif


                        <div class="card mb-4">
                            <h4 class="card-header mb-3"> Please Complete Your KYC </h4>

                            <div class="card-body">
                                <form id="visitorKycForm" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id"
                                        value="{{ isset($visitorData) ? $visitorData->id : '' }}">


                                    <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <label class="form-label">Full Name </label>
                                            <input type="text" class="form-control" id="fullname" name="fullname"
                                                placeholder="Full Name"
                                                value="{{ isset($visitorData) ? $visitorData->fullname : old('fullname') }}"
                                                readonly>

                                            <div class="text-danger" id="fullname_error"></div>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label class="form-label">Mobile Number </label>
                                            <input type="text" class="form-control" id="phone"
                                                placeholder="Mobile Number" name="phone" maxlength="10" minlength="10"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                                value="{{ isset($visitorData) ? $visitorData->phone : old('phone') }}"
                                                readonly>

                                            <div class="text-danger" id="phone_error"></div>
                                        </div>
                                    </div>





                                    <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <div class="form-password-toggle">
                                                <div class="d-flex justify-content-between">
                                                    <label class="form-label">Aadhar Card Number</label>
                                                </div>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" id="aadhar_number" class="form-control"
                                                        name="aadhar_number" placeholder="Aadhar Number"
                                                        value="{{ isset($visitorData) ? $visitorData->aadhar_number : old('aadhar_number') }}" />
                                                    <span class="input-group-text cursor-pointer"><i
                                                            class="bx bx-hide"></i></span>
                                                </div>
                                            </div>
                                            <div class="text-danger" id="aadhar_number_error"></div>
                                        </div>


                                        <div class="mb-4 col-md-6">
                                            <div class="form-password-toggle">
                                                <div class="d-flex justify-content-between">
                                                    <label class="form-label">Voter Id Number</label>
                                                </div>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" id="voter_id" class="form-control"
                                                        value="{{ isset($visitorData) ? $visitorData->voter_id : old('voter_id') }}"
                                                        name="voter_id" placeholder="Voter Id Number" />
                                                    <span class="input-group-text cursor-pointer"><i
                                                            class="bx bx-hide"></i></span>
                                                </div>
                                            </div>
                                            <div class="text-danger" id="voter_id_error"></div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="mb-4 col-md-7">
                                            <label class="form-label">Aadhar Card Image : </label>
                                            <input type="file" name="aadhar_proof" id="aadhar_proof"
                                                class="form-control">
                                            <div class="text-danger" id="aadhar_proof_error"></div>
                                        </div>

                                        <div class="mb-4 col-md-5">
                                            <img src="{{ isset($visitorData) ? asset('storage/backend_images/upload/visitor/kyc/' . $visitorData->aadhar_proof) : '' }}"
                                                alt="" width="100px" id="viewImage">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="mb-4 col-md-7">
                                            <label class="form-label">Voter Id Image : </label>
                                            <input type="file" name="voter_proof" id="voter_proof"
                                                class="form-control">
                                            <div class="text-danger" id="voter_proof_error"></div>
                                        </div>

                                        <div class="mb-4 col-md-5">
                                            <img src="{{ isset($visitorData) ? asset('storage/backend_images/upload/visitor/kyc/' . $visitorData->voter_proof) : '' }}"
                                                alt="" width="100px" id="viewImage">
                                        </div>
                                    </div>



                                    <button type="submit" id="btnSubmit" name="submit"
                                        class="custom-btn submit-btn mt-3 w-100">
                                        Complete Your KYC
                                    </button>

                                    {{-- <a href="" class="custom-btn back-btn mt-3"> <i class="fa fa-arrow-left"
                                        aria-hidden="true"></i>
                                    Back</a> --}}
                                </form>

                            </div>
                        </div>
                    </div>
                @elseif ($visitor_kyc_approved == 'Update KYC')
                    <div class="offset-md-2 col-md-7">
                        <div class="kyc-card-wrapper">
                            <div class="kyc-card">
                                <div class="kyc-tick-container">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M5 12l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h2 class="kyc-card-title">KYC Submitted</h2>
                                <p class="kyc-card-text">Waiting for Approval...</p>
                                <p class="kyc-date">Submitted on: <span
                                        id="kycSubmittedDate">{{ $visitorData->kyc_update_date }}</span></p>
                                <div class="kyc-bottom-bar"></div>
                            </div>
                        </div>

                    </div>
                @elseif ($visitor_kyc_approved == 'Approved')
                    @if ($approved_qr->qr_code)
                       <div class="row">
                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-body" style="text-align: center;">
                                    <h5>Meeting QR Code</h5>
                                    <img src="{{ asset('storage/' . $approved_qr->qr_code) }}" alt="Meeting QR Code"
                                        class="img-fluid" style="width: 80%">
                                </div>
                            </div>
                        </div>
                       </div>
                    @endif
                @endif


            </div>





            <!--/ Bootstrap Table with Header Dark -->
        </div>

        <!-- / Content -->
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            $("#visitorKycForm").submit(function(e) {
                e.preventDefault();

                const fd = new FormData(this);

                $.ajax({
                    url: "{{ route('visitor.kyc-update') }}",
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
                        $("#btnSubmit").html("Complete Your KYC");
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


                        $("#btnSubmit").html("Complete Your KYC");
                        $('#btnSubmit').attr('disabled', false);
                    },
                    success: function(data) {
                        console.log(data);
                        $("#btnSubmit").html("Complete Your KYC");
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

    <script>
        $(document).ready(function() {
            @if ($notifications->isNotEmpty())
                playSound();
            @endif

            setTimeout(() => {
                $('.notifications-container').fadeOut(500, function() {
                    // This function runs after the fadeOut completes
                    runAjaxAfterFadeOut();
                });
            }, 3000);
        });

        function playSound() {
            var audio = new Audio('https://thedentalsquare.org.in/sounds/notification.wav');
            audio.play();
        }

        function runAjaxAfterFadeOut() {
            $.ajax({
                url: "{{ route('visitor.notification-remove-form-dashboard') }}",
                method: 'GET',
                data: {}, // Assuming fd is not required; else pass the data here
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                error: function(xhr) {
                    console.log(xhr);
                },
                success: function(data) {
                    console.log(data);
                    if (data.success == true) {
                        console.log("Removed successfully notification");
                    } else {
                        console.log("Notification Removed failed");
                    }
                }
            });
        }
    </script>
@endsection
