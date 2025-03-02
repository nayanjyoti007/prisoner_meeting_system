@extends('visitor.layout.master')
@section('title', 'VISITOR | FAMILY MEMBER')
@section('family_member', 'active')
@section('headerTitle', 'FAMILY MEMBER')
@section('mycss')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    <div class="card mb-4">
                        <h5 class="card-header">

                            @if (isset($data) && !empty($data))
                                Update Member
                            @else
                                Add Member
                            @endif



                        </h5>
                        <div class="card-body">
                            <form id="membersKycForm" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="visitor_id" value="{{ $visitor_id }}">

                                <input type="hidden" name="id" value="{{ isset($data) ? $data->id : '' }}">


                                <div class="row">
                                    <div class="mb-4 col-md-5">
                                        <label class="form-label">Full Name </label>
                                        <input type="text" class="form-control" id="fullname" name="fullname"
                                            placeholder="Full Name"
                                            value="{{ isset($data) ? $data->fullname : old('fullname') }}">

                                        <div class="text-danger" id="fullname_error"></div>
                                    </div>

                                    <div class="mb-4 col-md-4">
                                        <label class="form-label">Mobile Number </label>
                                        <input type="text" class="form-control" id="phone"
                                            placeholder="Mobile Number" name="phone" maxlength="10" minlength="10"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                            value="{{ isset($data) ? $data->phone : old('phone') }}">

                                        <div class="text-danger" id="phone_error"></div>
                                    </div>

                                    <div class="mb-4 col-md-3">
                                        <label for="gender" class="form-label">Gender <span>*</span></label>
                                        <select class="form-control select2" id="gender" name="gender">
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="Male"
                                                {{ isset($data) && $data->gender == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female"
                                                {{ isset($data) && $data->gender == 'Female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="Other"
                                                {{ isset($data) && $data->gender == 'Other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        <span class="text-danger" id="gender_error"></span>
                                    </div>

                                </div>





                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <div class="form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label">Aadhar Card Number</label>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="aadhar_number" class="form-control"
                                                    name="aadhar_number" placeholder="Aadhar Number"
                                                    value="{{ isset($data) ? $data->aadhar_number : old('aadhar_number') }}" />
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
                                                <input type="password" id="voter_id" class="form-control" name="voter_id"
                                                    placeholder="Voter Id Number"
                                                    value="{{ isset($data) ? $data->voter_id : old('voter_id') }}" />
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
                                        <img src="{{ isset($data) ? asset('storage/backend_images/upload/members/kyc/' . $data->aadhar_proof) : '' }}"
                                            alt="" width="100px" id="viewImage">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-7">
                                        <label class="form-label">Voter Id Image : </label>
                                        <input type="file" name="voter_proof" id="voter_proof" class="form-control">
                                        <div class="text-danger" id="voter_proof_error"></div>
                                    </div>

                                    <div class="mb-4 col-md-5">
                                        <img src="{{ isset($data) ? asset('storage/backend_images/upload/members/kyc/' . $data->voter_proof) : '' }}"
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

            </div>

        </div>
        <!-- / Content -->

    @endsection

    @section('script')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="{{ asset('backend_assets/vendor/libs/select2/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {

                $("#gender").select2();

                $("#image").change(function(e) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("#viewImage").attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                });
            });

            $(document).ready(function() {
                $("#membersKycForm").submit(function(e) {
                    e.preventDefault();

                    const fd = new FormData(this);

                    $.ajax({
                        url: "{{ route('visitor.family-member.submit') }}",
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
    @endsection
