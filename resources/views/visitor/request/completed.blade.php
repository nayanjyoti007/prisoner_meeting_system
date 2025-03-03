@extends('visitor.layout.master')
@section('title', 'VISITOR | MEETING REQUEST COMPLETED')
@section('meeting_completed', 'active')
@section('manage_request_open', 'open')
@section('headerTitle', 'MEETING REQUEST COMPLETED')
@section('mycss')
    <style>
        .custom-btn {
            padding: 6px 10px;
        }
    </style>
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


                                <div class="table-responsive text-nowrap">
                                    <table class="table table-bordered pt-3" id="data">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>SL NO</th>
                                                <th>Visitor </th>
                                                <th>Prisoner </th>
                                                <th>Status </th>
                                                <th width="150px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">

                                            @forelse ($data as $item)
                                                <tr id="trRow{{ $item->id }}">
                                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
                                                            {{ $loop->iteration }} </strong></td>

                                                    <td>
                                                        {{ $item->visitor_name }}
                                                    </td>


                                                    <td>
                                                        {{ $item->prisoner_name }}
                                                    </td>

                                                    <td>
                                                        @if ($item->status == 'Completed')
                                                            <span class="badge rounded-pill bg-primary">Completed</span>
                                                        @elseif ($item->status == 'Approved')
                                                            <span class="badge rounded-pill bg-success">Approved</span>
                                                        @elseif ($item->status == 'Rejected')
                                                            <span class="badge rounded-pill bg-danger">Rejected</span>
                                                        @elseif ($item->status == 'Pending')
                                                            <span
                                                                class="badge rounded-pill bg-warning text-dark">Pending</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-secondary">Unknown</span>
                                                        @endif

                                                    </td>

                                                    <td>

                                                        <a href="javascript:void(0)" class="btn btn-primary-ssn btn-sm"
                                                            data-id="{{ $item->id }}" title="Student Details"
                                                            data-toggle="modal" data-bs-toggle="modal"
                                                            data-bs-target="#requestDetailModel">
                                                            <i class="fa fa-eye mr-1" aria-hidden="true"></i> Details</a>

                                                    </td>
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

                {{-- Details Model Start  --}}
                <div class="col-lg-4 col-md-3">
                    <div>
                        <div class="modal fade" id="requestDetailModel" data-bs-backdrop="static" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <form class="modal-content">
                                    <div class="modal-header">
                                        {{-- <h4 class="modal-title" id="requestDetailModelTitle">Request Details</h4> --}}
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body" id="detail-modal-body-content">

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Details Model End  --}}



            </div>
        </div>
        <!-- / Content -->

    @endsection

    @section('script')
        <script>
            $(document).ready(function() {

                let table = new DataTable('#data', {
                    pageLength: 31, // Initial number of rows to display
                    lengthMenu: [31], // Options for number of rows to display
                    searching: true // Disable search functionality
                });


                $(document).on('click', "a[data-bs-target='#requestDetailModel']", function() {
                    var id = $(this).data('id');
                    var formUrl =
                        "{{ url('/sending-meeting-request/details') }}" + "/" +
                        id;

                    // Use AJAX to load the form content into the modal body
                    $.get(formUrl, function(data) {
                        $("#detail-modal-body-content").html(data);
                    });
                });



            });
        </script>
    @endsection
