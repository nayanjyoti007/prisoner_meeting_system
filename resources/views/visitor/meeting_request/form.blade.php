@extends('visitor.layout.master')
@section('title', 'VISITOR | MEETING REQUEST')
@section('meeting_request', 'active')
@section('headerTitle', 'MEETING REQUEST')
@section('mycss')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <a href="{{ route('visitor.sending-meeting-request.list') }}" class="custom-btn-nnn details-btn mb-3"
                        style="margin-left: -1px; padding: 8px 10px;"> <i class="fa fa-id-card" aria-hidden="true"></i>
                        Show My Request</a>


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
                            <form id="meetingRequestForm" method="post" enctype="multipart/form-data">
                                @csrf

                                {{-- <input type="hidden" name="id" value="{{ isset($data) ? $data->id : '' }}"> --}}

                                <input type="hidden" id="jail_id" name="jail_id"
                                    value="{{ isset($jailer) ? $jailer->id : old('jail_id') }}">
                                <input type="hidden" id="visitor_id" name="visitor_id"
                                    value="{{ isset($visitor_data) ? $visitor_data->id : old('visitor_id') }}">

                                <div class="row">
                                    <!-- Select Family Members (Multiple Selection) -->
                                    <div class="mb-4 col-md-6">
                                        <label for="family_members" class="form-label">Select Family Members
                                            <span>*</span></label>
                                        <select name="family_members[]" id="family_members" class="form-control" multiple>
                                            @foreach ($family_members as $member)
                                                <option value="{{ $member->id }}">{{ $member->fullname }} -
                                                    {{ $member->phone }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="family_members_error"></span>
                                    </div>

                                    <!-- Select Prisoner -->
                                    <div class="mb-4 col-md-6">
                                        <label for="prisoner" class="form-label">Select Prisoner <span>*</span></label>
                                        <select name="prisoner_id" id="prisoner_id" class="form-control">
                                            <option selected>Select Prisoner</option>
                                            @foreach ($prisoners as $item)
                                                <option value="{{ $item->id }}" data-jail="{{ $item->jail_id }}">
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="prisoner_id_error"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Select Jail (Auto-selected based on Prisoner) -->
                                    <div class="mb-4 col-md-6">
                                        <label for="jail" class="form-label">Jail Name <span>*</span></label>
                                        <input type="text" class="form-control" id="jail_name" name="jail_name"
                                            value="{{ isset($jailer) ? $jailer->name : old('jail_name') }}" readonly>
                                        <span class="text-danger" id="jail_name_error"></span>
                                    </div>

                                    <!-- Visitor Phone Number -->
                                    <div class="mb-4 col-md-6">
                                        <label class="form-label">Phone Number <span>*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            placeholder="Enter your phone number" value="{{ old('phone') }}">
                                        <span class="text-danger" id="phone_error"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Meeting Date -->
                                    <div class="mb-4 col-md-6">
                                        <label class="form-label">Meeting Date <span>*</span></label>
                                        <input type="date" class="form-control" id="meeting_date" name="meeting_date">
                                        <span class="text-danger" id="meeting_date_error"></span>
                                    </div>

                                    <!-- Meeting Time -->
                                    <div class="mb-4 col-md-6">
                                        <label class="form-label">Meeting Time <span>*</span></label>
                                        <input type="time" class="form-control" id="meeting_time" name="meeting_time">
                                        <span class="text-danger" id="meeting_time_error"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Visitor Attendance Checkbox -->
                                    <div class="mb-4 col-md-6">
                                        <label class="form-label">Do You Want to Attend?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="include_visitor"
                                                name="include_visitor" value="1">
                                            <label class="form-check-label" for="include_visitor">Yes, I want to attend
                                                the meeting.</label>
                                        </div>
                                    </div>

                                    <!-- Group Image Upload -->
                                    <div class="mb-4 col-md-6">
                                        <label class="form-label">Upload Group Image <span>*</span></label>
                                        <input type="file" class="form-control" id="group_image" name="group_image"
                                            accept="image/*">
                                        <span class="text-danger" id="group_image_error"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Confirmation Checkbox -->
                                    <div class="mb-1 mt-3 col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="confirm"
                                                name="confirm" value="1" required>
                                            <label class="form-check-label" for="confirm">
                                                I confirm that all details are correct, and I understand the meeting rules.
                                            </label>
                                        </div>
                                        <span class="text-danger" id="confirm_error"></span>
                                    </div>
                                </div>

                                <button type="submit" id="btnSubmit" name="submit"
                                    class="custom-btn submit-btn mt-3 w-100">
                                    Submit Meeting Request
                                </button>
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
                $("#prisoner_id").select2();
                $("#family_members").select2();
            });

            $(document).ready(function() {
                $("#meetingRequestForm").submit(function(e) {
                    e.preventDefault();

                    const fd = new FormData(this);

                    $.ajax({
                        url: "{{ route('visitor.sending-meeting-request.submit') }}",
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
