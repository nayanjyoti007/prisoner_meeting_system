@extends('admin.layout.master')
@section('title', 'Admin | ASSEB EXAM')
@section('student-side', 'active')
@section('headerTitle', 'Student | Student Details')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row justify-content">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">
                            Personal Details
                        </h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Name:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <b>{{$data->candidate_name}}</b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Registration No.:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <b>{{$data->reg_no}}</b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Father Name:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <b>{{$data->fathers_name}}</b>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>School:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <b>{{$data->school_college_name}}</b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Gender:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <b>{{strtoupper($data->gender)}}</b>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Mother Name:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <b>{{$data->mothers_name}}</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($first != NULL)
                <div class="row justify-content">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <h5 class="card-header">
                                HS 1st Year
                            </h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Stream:</label>
                                            </div>
                                            <div class="col-md-9">
                                                <b>{{$data->stream}}</b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label>Subjects:</label>
                                            </div>
                                            <div class="col-md-9">
                                                @php
                                                    $subjects = json_decode($data->subjects, true);
                                                @endphp
                                                <b>
                                                    @foreach($subjects as $key=>$sub)
                                                        {{$sub}}
                                                        @if(!$loop->last),&nbsp;&nbsp;@endif
                                                    @endforeach
                                                </b>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if($second != NULL)
                <div class="row justify-content">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <h5 class="card-header">
                                HS 2nd Year
                            </h5>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


@endsection
