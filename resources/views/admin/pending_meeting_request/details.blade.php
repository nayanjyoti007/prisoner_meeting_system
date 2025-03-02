<div class="container-fluid">
    <div class="row">

        <div class="col-md-7">
            <h5>Meeting Infomation</h5>
            <table class="table table-bordered" style="border-color: #4c535a;">
                <tbody>
                    <tr>
                        <td>Meeting Date</td>
                        <td>{{ $meeting->meeting_date }}</td>
                    </tr>
                    <tr>
                        <td>Meeting Time</td>
                        <td>{{ $meeting->meeting_time }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{ $meeting->status }}</td>
                    </tr>
                    <tr>
                        <td>Visitor Name</td>
                        <td>{{ $meeting->visitor_name }}</td>
                    </tr>
                    <tr>
                        <td>Prisoner Name</td>
                        <td>{{ $meeting->prisoner_name }}</td>
                    </tr>
                    <tr>
                        <td>Jail Name</td>
                        <td>{{ $meeting->jail_name }}</td>
                    </tr>
                </tbody>
            </table>

            @if ($meeting->qr_code)
            <h4>Meeting QR Code</h4>
            <img src="{{ asset('storage/' . $meeting->qr_code) }}" alt="Meeting QR Code" class="img-fluid"  style="width: 30%; margin-bottom: 20px;">
        @endif
        </div>

        <div class="col-md-5">
            {{-- <img src="{{ asset('storage/backend_images/upload/students/profile/' . $data->profile) }}" alt=""
                srcset="" style="width: 30%; margin-bottom: 20px; border: 3px solid #222d39;"> --}}
            @foreach ($participants as $item)
                <h5>Members Details</h5>
                <table class="table table-bordered" style="border-color: #4c535a;">
                    <tbody>
                        <tr>
                            <td>Participant Name</td>
                            <td>{{ $item->participant_name }}</td>
                        </tr>
                        <tr>
                            <td>Is Visitor</td>
                            <td>
                                @if ($item->is_visitor == 1)
                                    <span class="badge rounded-pill bg-primary">Own</span>
                                @else
                                    <span class="badge rounded-pill bg-secondary">Member</span>
                                @endif


                            </td>
                        </tr>
                    </tbody>
                </table>
            @endforeach


        </div>

    </div>
</div>




@section('script')
@endsection
