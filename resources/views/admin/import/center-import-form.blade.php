@extends('admin.layout.master')
@section('title', 'Admin | School Management System')
@section('student_regn', 'active')
@section('headerTitle', 'Center || Center Import')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="row justify-content-center">
                <div class="col-md-5">


                    @isset($message)
                        <small class="text-danger"> {{ $message }}</small>
                    @else
                    @endisset


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
                                Center Import
                            @else
                                Center Import
                            @endif



                        </h5>
                        <div class="card-body">
                            <form action="{{ route('admin.import-submit-center') }}" enctype="multipart/form-data"
                                method="POST">
                                @csrf
                                <div class="row">

                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                            <a href="{{ asset('ERP Excel Import/student_register.xlsx') }}" download>Demo
                                                Excel File</a></label><br>

                                        <label class="form-label">
                                            Select Your Excel</label>

                                        <input type="file" name="file" id="file" class="form-control"
                                            placeholder="Student Name" value="">
                                        {{-- @if ($errors->has('file'))
                                            <small class="text-danger"> {{ $errors->first('file') }}</small>
                                        @endif --}}

                                        @isset($message)
                                            <small class="text-danger"> {{ $message }}</small>
                                        @else
                                        @endisset


                                        @if ($errors->any())
                                            <div class="mt-2">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li class="text-danger">{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">

                                        <button type="submit" id="btnSubmit" name="submit"
                                            class="btn btn-sm btn-primary mt-3">
                                            Student Import </button>

                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- / Content -->

    @endsection

    @section('script')
        <script src="{{ asset('backend_assets/ckeditor4/ckeditor.js') }}"></script>
        <script src="{{ asset('backend_assets/vendor/libs/select2/select2.min.js') }}"></script>
        <script src="{{ asset('backend_assets/vendor/libs/tagify/tagify.js') }}"></script>


        <script>
            $(document).ready(function() {

            });
        </script>



    @endsection
