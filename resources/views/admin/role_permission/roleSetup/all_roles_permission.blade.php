@extends('admin.layout.master')
@section('title', 'Admin | ASSED EXAM | All Role in Permission')
@section('allrolepermission', 'active')
@section('open', 'open')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row justify-content-center">

                <div class="col-md-8">
                    <div id="result">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                        <th style="width:10%">SL NO</th>
                                        <th>Role Name </th>
                                        <th>Action</th>
                                        <th>Permissions </th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                    @forelse ($roles as $item)
                                        <tr id="trRow{{ $item->id }}">
                                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>
                                                    {{ $loop->iteration }} </strong></td>
                                            <td>
                                                {{$item->name}}
                                            </td>

                                            <td>

                                                <a href="{{ route('admin.editRolePermission', ['id' => $item->id]) }}"
                                                    class="btn btn-primary-ssn btn-sm">
                                                    <i class="fa fa-pencil mr-1" aria-hidden="true"></i> Edit</a>



                                                <a href="javascript:void(0)"
                                                    class="btn btn-warning btn-sm text-dark delete_item"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fa fa-trash  mr-1" aria-hidden="true"></i> Delete</a>
                                            </td>

                                            <td>
                                                @forelse ($item->permissions as $permission)
                                                <span class="badge bg-danger">{{$permission->name}}</span>
                                                @empty

                                                @endforelse
                                            </td>


                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.addRolePermission') }}" class="btn btn-primary">Add Role in Permission</a>
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
                    // alert(id);

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
                                    url: "{{ route('admin.deleteRolePermission') }}",
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
