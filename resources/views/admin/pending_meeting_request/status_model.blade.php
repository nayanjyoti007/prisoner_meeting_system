<form method="post" id="meeting_details_status_update_form">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ $meeting->meeting_id }}">
    <input type="hidden" name="visitor_id" id="visitor_id" value="{{ $meeting->visitor_id }}">

<div class="container-fluid">
    <div class="row">
        <div class="mb-2 col-md-12">
            <label for="meeting_status" class="form-label">Update Meeting Status <span>*</span></label>
            <select class="form-control select2" id="meeting_status" name="meeting_status">
                <option value="" disabled selected>Update Status</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </select>
            <span class="text-danger" id="meeting_status_error"></span>
        </div>

        <div class="mb-2 col-md-12">
            <label class="form-label">Reason Rejected </label>
            <textarea id="rejected_reason" name="rejected_reason" class="form-control" placeholder="Reason Rejected"
                rows="3"></textarea>
            <span class="text-danger" id="rejected_reason_error"></span>
        </div>

    </div>

    <button type="submit" id="btnSubmit" name="submit" class="custom-btn add-btn mt-2 w-100" style="position: relative; left: -6px;">
        Update Status</button>

</div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function toggleReasonField() {
            var status = $("#meeting_status").val();
            if (status === "Rejected") {
                $("#rejected_reason").parent().show();
            } else {
                $("#rejected_reason").parent().hide();
                $("#rejected_reason").val(""); // Clear reason field when hidden
            }
        }

        // Run on page load in case of pre-filled value
        toggleReasonField();

        // Run when dropdown changes
        $("#meeting_status").change(function() {
            toggleReasonField();
        });


        $("#meeting_details_status_update_form").submit(function(e) {
            e.preventDefault();

            const fd = new FormData(this);

            $.ajax({
                url: "{{ route('admin.pending-meeting-request-status-update') }}",
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
                    $("#btnSubmit").html("Update Status");
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


                    $("#btnSubmit").html("Update Status");
                    $('#btnSubmit').attr('disabled', false);
                },
                success: function(data) {
                    console.log(data);
                    $("#btnSubmit").html("Update Status");
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
