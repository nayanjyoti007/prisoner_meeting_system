@extends('admin.layout.master')
@section('title', 'Admin | Assam State Inmate Visitation System')
@section('admin_external_list', 'active')
@section('headerTitle', 'Visitor Account KYC Verification')
@section('mycss')
<style>
    .custom-btn{
        padding: 6px 10px;
    }
</style>
@endsection
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            {{-- <div class="row">
                <div class="col-md-2" style="position: relative; left: -3px;">
                    <a href="{{ route('district.external.form') }}"
                        class="custom-btn status-btn mb-3">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Add New External</a>
                </div>
            </div> --}}


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

                                {{-- <h4>{{ $centerData->name }}</h4> --}}


                                <div class="table-responsive text-nowrap mt-4">
                                    <table class="table table-bordered pt-3" id="data">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>SL NO</th>
                                                <th>Full Name </th>
                                                <th>Phone </th>
                                                <th>KYC Update Date </th>
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
                                                        {{ $item->fullname }}
                                                    </td>

                                                    <td>
                                                        {{ $item->phone }}
                                                    </td>


                                                    <td>
                                                        {{ $item->kyc_update_date }}
                                                    </td>

                                                    <td>
                                                        {{ $item->kyc_status }}
                                                    </td>


                                                    <td>
                                                        <a href="javascript:void(0)" data-id="{{$item->id}}" title="DETAILS" data-toggle="modal" data-bs-toggle="modal" data-bs-target="#kycVerificationDetails" class="custom-btn search-btn"" target="_blank">
                                                            <i class="fa fa-eye-slash mr-1" aria-hidden="true"></i>
                                                            Details</a>
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
            </div>

        </div>
        <!-- / Content -->



        {{-- KYC Verification Details Start  --}}
        <div class="col-lg-4 col-md-3">
            <div>
                <div class="modal fade" id="kycVerificationDetails" data-bs-backdrop="static" tabindex="-1">
                    <div class="modal-dialog modal-md">
                        <form class="modal-content" id="kyc_verification_details_status_update_form" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title" id="kycVerificationDetailsTitle">KYC Verification Details</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body" id="details-modal-body-content">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- KYC Verification Details End  --}}



    @endsection

    @section('script')
        <script>
            $(document).ready(function() {
                let table = new DataTable('#data');


                $(document).on('click', "a[data-bs-target='#kycVerificationDetails']", function() {
                    var id = $(this).data('id');

                    var formUrl = "{{ url('admin/pending-visitor-account-kyc-verification-details') }}" + "/" + id;

                    // Use AJAX to load the form content into the modal body
                    $.get(formUrl, function(data) {
                        $("#details-modal-body-content").html(data);
                    });
                });


            });
        </script>
    @endsection
