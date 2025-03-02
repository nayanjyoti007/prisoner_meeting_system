<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered" style="border-color: #4c535a;">
                <tbody>
                    <tr>
                        <td>Title</td>
                        <td>{{ $details->title }}</td>
                    </tr>
                    @if ($details->description != null)
                        <tr>
                            <td>Description</td>
                            <td>{{ $details->description }}</td>
                        </tr>
                    @endif

                    <tr>
                        <td>Time & Date</td>
                        <td>{{ $details->time_date }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
