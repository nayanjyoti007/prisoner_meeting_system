@extends('admin.layout.master')
@section('title', 'Admin | Assam State Inmate Visitation System')
@section('admin_external_list', 'active')
@section('headerTitle', 'Meeting Request')
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

                                            @forelse ($kyc_pending as $item)
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

                                                        <a href="javascript:void(0)" class="custom-btn-nnn add-btn"
                                                            data-id="{{ $item->id }}" title="Student Details"
                                                            data-toggle="modal" data-bs-toggle="modal"
                                                            data-bs-target="#requestDetailModel"> Details</a>

                                                        <a href="javascript:void(0)" class="custom-btn-nnn status-btn"
                                                            data-id="{{ $item->id }}" title="Student Details"
                                                            data-toggle="modal" data-bs-toggle="modal"
                                                            data-bs-target="#requestStatusUpdateModel"> Status</a>

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


                {{-- Status Model Start  --}}
                <div class="col-lg-4 col-md-3">
                    <div>
                        <div class="modal fade" id="requestStatusUpdateModel" data-bs-backdrop="static" tabindex="-1">
                            <div class="modal-dialog modal-sm">
                                <form class="modal-content">
                                    <div class="modal-header">
                                        {{-- <h4 class="modal-title" id="requestStatusUpdateModelTitle">Request Details</h4> --}}
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body" id="status-modal-body-content" style="padding-top: 0; padding-left: 0; padding-right: 0;">

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Status Model End  --}}





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
                        "{{ url('/admin/pending-request/details') }}" + "/" +
                        id;

                    // Use AJAX to load the form content into the modal body
                    $.get(formUrl, function(data) {
                        $("#detail-modal-body-content").html(data);
                    });
                });




                $(document).on('click', "a[data-bs-target='#requestStatusUpdateModel']", function() {
                    var id = $(this).data('id');
                    var formUrl =
                        "{{ url('/admin/pending-request/status-update-model') }}" + "/" +
                        id;

                    // Use AJAX to load the form content into the modal body
                    $.get(formUrl, function(data) {
                        $("#status-modal-body-content").html(data);
                    });
                });



            });
        </script>
    @endsection
