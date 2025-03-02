@extends('visitor.layout.master')
@section('title', 'VISITOR | FAMILY MEMBER')
@section('family_member', 'active')
@section('headerTitle', 'FAMILY MEMBER')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-2">
                    <a href="{{ route('visitor.family-member.form') }}" class="custom-btn-uni add-btn mb-3">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Add Member</a>
                </div>
            </div>
            <div class="row justify-content-center">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
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
                                                    <th>Full Name </th>
                                                    <th>Phone </th>
                                                    <th>Gender </th>
                                                    <th>Register at </th>
                                                    <th>KYC Status </th>
                                                    <th width="150px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">

                                                @forelse ($members as $data)
                                                    <tr id="trRow{{ $data->id }}">
                                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
                                                                {{ $loop->iteration }} </strong></td>

                                                        <td>
                                                            {{ $data->fullname }}
                                                        </td>

                                                        <td>
                                                            {{ $data->phone }}
                                                        </td>

                                                        <td>
                                                            {{ $data->gender }}
                                                        </td>

                                                        <td>
                                                            {{ \Carbon\Carbon::parse($data->registered_at)->format('d F Y') }}
                                                        </td>

                                                        <td>
                                                            @if ($data->kyc_status == 'Pending')
                                                                <span class="badge rounded-pill bg-success">Pending</span>
                                                            @elseif ($data->kyc_status == 'Approved')
                                                                <span class="badge rounded-pill bg-success">Approved</span>
                                                            @elseif ($data->kyc_status == 'Rejected')
                                                                <span class="badge rounded-pill bg-danger">Rejected</span><br>

                                                                <span class="badge rounded-pill bg-danger"><b>
                                                                        {{ $data->reason_kyc_rejected }}
                                                                    </b></span>
                                                            @else
                                                                <span class="badge rounded-pill bg-danger">Unknown</span>
                                                            @endif
                                                        </td>

                                                        <td>

                                                            @if ($data->kyc_status == 'Rejected')
                                                                <a href="{{ route('visitor.family-member.form', ['id' => hashid()->encode($data->id)]) }}"
                                                                    class="custom-btn-nnn edit-btn">
                                                                    <i class="fa fa-pencil mr-1" aria-hidden="true"></i>
                                                                    Edit</a>
                                                            @endif





                                                            {{-- <a href="{{route('admin.academic.designation.status',['id' => $data->id])}}"
                                                                        class="custom-btn status-btn"
                                                                        data-id="{{ $data->id }}">
                                                                        <i class="fa fa-bell-slash mr-1" aria-hidden="true"></i> Status</a> --}}


                                                            {{-- <a href="javascript:void(0)"
                                                                class="btn btn-warning btn-sm text-dark delete_item"
                                                                data-id="{{ $data->id }}">
                                                                <i class="fa fa-trash  mr-1" aria-hidden="true"></i> Delete</a> --}}
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

        </div>
        <!-- / Content -->

    @endsection

    @section('script')
        <script>
            $(document).ready(function() {
                let table = new DataTable('#data');


                $(document).on('click', '.delete_item', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('data-id');

                    swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover this data!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {

                                $.ajax({
                                    type: "GET",
                                    url: "{{ route('visitor.family-member.delete') }}",
                                    data: {
                                        id: id
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        if (response.success == true) {
                                            swal(response.message, {
                                                icon: "success",
                                            });

                                            // $("#trRow" + id).fadeOut(300, function() {
                                            //     $("#trRow" + id).remove();
                                            // });

                                            // location.reload();

                                            setTimeout(() => {
                                                location.reload();
                                            }, 1500);

                                        } else {
                                            alert(response.message);
                                        }
                                    }
                                });

                            }
                            // else {
                            //   swal("Your data is safe!");
                            // }
                        });
                });


            });
        </script>
    @endsection
