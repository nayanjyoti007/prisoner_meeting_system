@extends('admin.layout.master')
@section('title', 'ADMIN | CENTER LIST')
@section('admin_centetr_list', 'active')
@section('headerTitle', 'CENTER LIST')
{{-- @section('academic_open', 'open') --}}
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row justify-content-center">


                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="result">

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


                                <table class="table table-bordered pt-3" id="data">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>SL NO</th>
                                        <th>District</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Subject</th>
                                        <th>Total Appointed External</th>
                                        {{-- <th width="150px;">Action</th> --}}
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">

                                    @forelse ($centers as $item)
                                        <tr id="trRow{{ $item->id }}">
                                            <td>
                                                <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
                                                    {{ $loop->iteration }} </strong>
                                            </td>
                                            <td>
                                                {{$item->district->dist_name}} ({{$item->district->dist_code}})
                                            </td>
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td>
                                                {{ $item->code }}
                                            </td>
                                            <td>
                                                @php
                                                    $subcount = count($item->subject_code) - 1;
                                                @endphp

                                                @foreach ($item->subject_code as $key => $sub)
                                                    {{ $sub }}

                                                    @if ($subcount != $key)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </td>

                                            <td>
                                                {{\App\Models\ExternalAppointment::where('center_id',$item->id)->count()}}
                                            </td>
                                            {{-- <td>
                                        @if ($item->status == 1)
                                        <span class="badge rounded-pill bg-success">Active</span>
                                        @else
                                        <span class="badge rounded-pill bg-danger">In active</span>
                                        @endif
                                    </td> --}}

                                            {{-- <td> --}}
                                            {{-- <a href="{{ route('district.external.form', ['center_id' => $item->id]) }}"
                                                class="custom-btn export-btn" data-id="{{ $item->id }}">
                                                <i class="fa fa-plus mr-1" aria-hidden="true"></i> Add
                                                External</a> --}}

                                            {{-- <a href="{{route('district.external.list', ['center_id' => $item->id])}}" class="custom-btn details-btn"
                                                data-id="{{ $item->id }}">
                                                <i class="fa fa-eye mr-1" aria-hidden="true"></i> View
                                                External</a> --}}

                                            {{-- </td> --}}
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- / Content -->

        @endsection

        @section('script')
            <script>
                $(document).ready(function () {
                    // let table = new DataTable('#data');


                    let table = new DataTable('#data', {
                        pageLength: 30, // Initial number of rows to display
                        lengthMenu: [30], // Options for number of rows to display
                        searching: true // Disable search functionality
                    });

                });
            </script>
@endsection
