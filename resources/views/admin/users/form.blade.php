@extends('admin.layout.master')
@section('title', 'Admin | ASSED EXAM')
@section('gallery', 'active')
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

                            @if(isset($data) && !empty($data))
                        Update Gallery Image
                    @else
                        Add Gallery Image
                    @endif



                        </h5>
                        <div class="card-body">
                             <form action="{{route('admin.academic.department.submit')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ isset($data) ? $data->id : '' }}">



                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Name </label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ isset($data) ? $data->name : old('name') }}">
                                        @if ($errors->has('name'))
                                            <small class="text-danger"> {{ $errors->first('name') }}</small>
                                        @endif
                                    </div>
                                </div>




                                <button type="submit" id="submit" name="submit" class="custom-btn submit-btn mt-3">
                                    Submit </button>

                                <a href="{{ route('admin.academic.department.list') }}"
                                    class="custom-btn back-btn mt-3"> <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    Back</a>
                            </form>

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
        $("#image").change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#viewImage").attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
@endsection



