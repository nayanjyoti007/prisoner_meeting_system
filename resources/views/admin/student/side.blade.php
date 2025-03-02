@extends('admin.layout.master')
@section('title', 'Admin | ASSED EXAM')
@section('student-side', 'active')
@section('headerTitle', 'Student | Search Student')
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
                            Search Student
                        </h5>
                        <div class="card-body">
                            <form action="{{ route('admin.student-side') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3">
                                        <div class="form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label">Registration Number:</label>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" id="" class="form-control"
                                                               name="registration" placeholder="Ex: 123456" maxlength="6" required />
                                                    </div>
                                                    <div class="col-md-1">/</div>
                                                    <div class="col-md-4">
                                                        <select name="session" class="form-control" required>
                                                            <option value=""> Session</option>
                                                            <option value="2024-25"> 2024-25</option>
                                                            <option value="2023-24"> 2023-24</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        @if ($errors->has('registration'))
                                            <small class="text-danger"> {{ $errors->first('registration') }}</small>
                                        @endif
                                    </div>



                                    <div class="mb-3">
                                        <div class="form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label">Academic Session:</label>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <select name="acc_session" class="form-control" required>
                                                    <option value="">Select Session</option>
                                                    @foreach($session as $s)
                                                        <option value="{{$s->id}}">{{$s->year_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if ($errors->has('session'))
                                            <small class="text-danger"> {{ $errors->first('session') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <button type="submit" id="submit" name="submit" class="btn btn-primary btn-sm mt-3">
                                    Search </button>
                            </form>

                        </div>
                    </div>



                </div>

            </div>

        </div>
        <!-- / Content -->

@endsection
