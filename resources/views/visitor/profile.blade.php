@extends('district.layout.master')
@section('title', 'DISTRICT | PROFILE')
@section('district_profile', 'active')
@section('headerTitle', 'PROFILE')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row justify-content-center">
                <div class="col-md-5">

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


                    <div class="card">
                        <h5 class="card-header">
                            Profile Update
                        </h5>


                        <div class="card-body">
                            <form action="{{route('district.profile.submit')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ isset($data) ? $data->id : '' }}">

                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">Inspector Name: </label>
                                            <input type="text" name="inspector_name" id="inspector_name" class="form-control"
                                                placeholder="Enter Inspector Name" required="" value="{{ $data->inspector_name }}">
                                            @if ($errors->has('inspector_name'))
                                                <small class="text-danger"> {{ $errors->first('inspector_name') }}</small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">Inspector Mobile: </label>
                                            <input type="number" name="inspector_mobile" id="inspector_mobile" class="form-control"
                                                placeholder="Inspector Mobile" required="" value="{{ $data->inspector_mobile }}">
                                            @if ($errors->has('inspector_mobile'))
                                                <small class="text-danger"> {{ $errors->first('inspector_mobile') }}</small>
                                            @endif
                                        </div>
                                    </div>

                                </div>


                                <button type="submit" id="submit" name="submit"
                                    class="btn btn-primary w-100 btn-sm mt-3">
                                    Update Profile </button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- / Content -->

    @endsection


    @section('script')

        <script>
            $(document).ready(function() {

                $("#profile").change(function(e) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("#viewImage").attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                });

                $("a[data-bs-target='#changePassword']").click(function() {

                    var userID = $(this).data('id');

                    // alert("User");

                    // You may need to adjust the URL based on your project structure
                    var formUrl = "{{ url('profile/change-password') }}" + "/" + userID;

                    // Use AJAX to load the form content into the modal body
                    $.get(formUrl, function(data) {
                        $("#modal-body-content").html(data);
                    });


                });
            });
        </script>
    @endsection
