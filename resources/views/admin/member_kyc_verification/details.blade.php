<div class="container-fluid">
    <div class="row">
        <i> Date:- {{ \Carbon\Carbon::parse($details->registered_at)->format('d F Y') }}</i>
        {{-- <i> Visitor Name:- {{ $details->visitor_id }}</i>
        <i> Jail Name:- {{ $details->jail->name }}</i> --}}

        <div class="col-md-12 mt-3">
            <table class="table table-bordered" style="border-color: #4c535a;">
                <tbody>
                    <tr>
                        <td>Fullname</td>
                        <td>{{ $details->fullname }}</td>
                    </tr>

                    <tr>
                        <td>Phone</td>
                        <td>{{ $details->phone }}</td>
                    </tr>

                    {{-- <tr>
                            <td>Email</td>
                            <td>{{ $details->email}}</td>
                        </tr> --}}

                    <tr>
                        <td>Gender</td>
                        <td>{{ $details->gender }}</td>
                    </tr>

                    <tr>
                        <td>Date of Registration</td>
                        <td>{{ \Carbon\Carbon::parse($details->registered_at)->format('d F Y') }}</td>
                    </tr>

                    <tr>
                        <td>Aadhar Number</td>
                        <td>{{ $details->aadhar_number }}</td>
                    </tr>

                    <tr>
                        <td>Voter Id</td>
                        <td>{{ $details->voter_id }}</td>
                    </tr>

                    <tr>
                        <td>Aadhar Proof</td>
                        <td>
                            <a href="{{ isset($details) ? asset('storage/backend_images/upload/members/kyc/' . $details->aadhar_proof) : '' }}"
                                target="_blank">View File</a>
                        </td>
                    </tr>

                    <tr>
                        <td>Voter Proof </td>
                        <td>
                            <a href="{{ isset($details) ? asset('storage/backend_images/upload/members/kyc/' . $details->voter_proof) : '' }}"
                                target="_blank">View File</a>
                        </td>
                    </tr>


                </tbody>
            </table>



        </div>
    </div>
</div>

<input type="hidden" name="id" id="id" value="{{$details->id}}">
<input type="hidden" name="visitor_id" id="visitor_id" value="{{$details->visitor_id}}">

<div class="container bg-info py-3 rounded">
    <div class="row">
        <div class="mb-2 col-md-12">
            <label for="kyc_status" class="form-label">Update KYC Status <span>*</span></label>
            <select class="form-control select2" id="kyc_status" name="kyc_status">
                <option value="" disabled selected>Update Status</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </select>
            <span class="text-danger" id="kyc_status_error"></span>
        </div>

        <div class="mb-2 col-md-12">
            <label class="form-label">Reason KYC Rejected </label>
            <textarea id="reason_kyc_rejected" name="reason_kyc_rejected" class="form-control" placeholder="Reason KYC Rejected"
                rows="3"></textarea>
            <span class="text-danger" id="reason_kyc_rejected_error"></span>
        </div>

    </div>

    <button type="submit" id="btnSubmit" name="submit" class="custom-btn add-btn mt-2 w-100">
        Update KYC Status</button>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function toggleReasonField() {
            var status = $("#kyc_status").val();
            if (status === "Rejected") {
                $("#reason_kyc_rejected").parent().show();
            } else {
                $("#reason_kyc_rejected").parent().hide();
                $("#reason_kyc_rejected").val(""); // Clear reason field when hidden
            }
        }

        // Run on page load in case of pre-filled value
        toggleReasonField();

        // Run when dropdown changes
        $("#kyc_status").change(function() {
            toggleReasonField();
        });


        $("#kyc_verification_details_status_update_form").submit(function(e) {
            e.preventDefault();

            const fd = new FormData(this);

            $.ajax({
                url: "{{ route('admin.pending-members-kyc-verification-status-update') }}",
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
                    $("#btnSubmit").html("Update KYC Status");
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


                    $("#btnSubmit").html("Update KYC Status");
                    $('#btnSubmit').attr('disabled', false);
                },
                success: function(data) {
                    console.log(data);
                    $("#btnSubmit").html("Update KYC Status");
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
