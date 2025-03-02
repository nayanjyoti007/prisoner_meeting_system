@extends('visitor.layout.master')
@section('title', 'VISITOR | CHANGE PASSWORD')
@section('changepassword', 'active')
@section('headerTitle', 'CHANGE PASSWORD')
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



                    <div class="card mb-4">
                        <h5 class="card-header">
                            Change Password Form
                        </h5>
                        <div class="card-body">
                            <form action="{{ route('visitor.changePasswordSubmit') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="mb-3">
                                        <div class="form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label">Current Password:</label>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="current_password" class="form-control"
                                                    name="current_password" placeholder="Current Password" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('current_password'))
                                            <small class="text-danger"> {{ $errors->first('current_password') }}</small>
                                        @endif
                                    </div>



                                    <div class="mb-3">
                                        <div class="form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label">New Password:</label>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="new_password" class="form-control"
                                                    name="new_password" placeholder="New Password" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('new_password'))
                                            <small class="text-danger"> {{ $errors->first('new_password') }}</small>
                                        @endif
                                    </div>



                                    <div class="mb-3">
                                        <div class="form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label">Re Enter Password:</label>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="confirm_password" class="form-control"
                                                    name="confirm_password" placeholder="Re Enter New Password" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('confirm_password'))
                                            <small class="text-danger"> {{ $errors->first('confirm_password') }}</small>
                                        @endif
                                    </div>




                                </div>


                                {{-- <button type="submit" id="submit" name="submit" class="btn btn-primary btn-sm mt-3">
                                    Submit </button> --}}

                                    <button type="submit" id="submit" name="submit"
                                    class="custom-btn-uni submit-btn mt-3 w-100">
                                    Update Password </button>


                            </form>

                        </div>
                    </div>



                </div>

            </div>

        </div>
        <!-- / Content -->

    @endsection
