@extends('admin.layout.master')
@section('title', 'Admin | Assam State Inmate Visitation System')
@section('dashboard', 'active')
@section('headerTitle', 'Dashboard')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-3 col-12 mb-4">
                     <a href="{{route('admin.pending-visitor-account-kyc-verification')}}">
                        <div class="card">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-primary mb-3">Pending Visitor <br> Account KYC Verify</h5>
                                <div class="card-title mb-0 d-flex">
                                    <h4 class="new-bage text-success fw-bolder">{{$pending_account}}</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-12 mb-4">
                     <a href="{{route('admin.pending-members-kyc-verification')}}">
                        <div class="card">
                            <div class="card-body pb-0">
                                <h5 class="card-title text-primary mb-3">Pending Members <br> KYC Verify </h5>
                                <div class="card-title mb-0 d-flex">
                                    <h4 class="new-bage text-success fw-bolder">{{$pending_members}}</h4>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-12 mb-4">
                    <a href="{{route('admin.pending-request')}}">
                       <div class="card">
                           <div class="card-body pb-0">
                               <h5 class="card-title text-primary mb-3">All Meeting <br> Request </h5>
                               <div class="card-title mb-0 d-flex">
                                   <h4 class="new-bage text-success fw-bolder">{{$pending_request}}</h4>
                               </div>
                           </div>
                       </div>
                   </a>
               </div>

            </div>
        </div>
        <!-- / Content -->



        {{-- <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Bootstrap Table with Header - Dark -->
            <div class="card mb-4">
                <h5 class="card-header"><span></span> Recent Bilty Create </h5>
                <div class="card-body">
                    <div class="mb-4">
                        <form>
                            <div class="row align-items-center">
                                <div class="col-md-3 pb-1">
                                    <input type="text" class="form-control" placeholder="Search By Bilty">
                                </div>
                                <div class="col-md-2 pb-1">
                                    <button class="btn btn-primary-ssn btn-sm w-100">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
            <!--/ Bootstrap Table with Header Dark -->
        </div> --}}







        <div class="content-backdrop fade"></div>
    </div>
@endsection


@section('script')

@endsection
