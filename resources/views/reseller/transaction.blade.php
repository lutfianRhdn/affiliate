@extends('layouts.app', ['activePage' => 'transaction', 'titlePage' => __('Client Management')])

@section('content')
<div id="preloaders" class="preloader"></div>
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Transaction</h4>
                <p class="category">Status transaction</p>
            </div>
            <div class="card-body">
                <div class="form-group d-flex">
                    <div class="d-flex flex-column mr-3">
                        <label for="startedAt">Started at:</label>
                        <input type="date" name="startedAt" id="startedAt">
                    </div>
                    <div class="d-flex flex-column mr-3">
                        <label for="endedAt">endedAt</label>
                        <input type="date" name="endedAt" id="endedAt">
                    </div>
                </div>
                <table class="table datatable">
                    <thead>
                        <tr class="text-primary">
                            <th>No</th>
                            <th>Client Name</th>
                            <th>Company</th>
                            <th>Total Payment</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$transaction->client->name}}</td>
                            <td>{{$transaction->client->company}}</td>
                            <td>Rp.{{$transaction->total_payment == null ?'0':$transaction->total_payment}}</td>
                            <td>{{date('d-m-Y', strtotime($transaction->payment_date))}}</td>
                            <td>{{$transaction->status ==false ?"hasn't paid" :'has paid '}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
      $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var min = $('#startedAt').val().split('-');
                var max = $('#endedAt').val().split('-');
                var dateData = data[4].split('-') ; // use data for the age column
                const minDate = new Date( min[0], min[1] , min[2]).getTime();
                const date = new Date( dateData[2], dateData[1], dateData[0]).getTime();
                const maxDate = new Date( max[0], max[1] , max[2]).getTime();

                if ((isNaN(minDate) && isNaN(maxDate)) ||
                    (isNaN(minDate) && date <= maxDate) ||
                    (minDate <= date && isNaN(maxDate)) ||
                    (minDate <= date && date <= maxDate)) {
                    return true;
                }
                return false;
            }
        );
    $(document).ready(function () {
        const table = $('.datatable').DataTable()
      $('#startedAt').change(()=>{
        table.draw();
      })
      $('#endedAt').change(()=>{
        table.draw();
      })
        // Javascript method's body can be found in assets/js/demos.js
        
        $("#preloaders").fadeOut(1000);
        md.initDashboardPageCharts();

    });

</script>
@endpush
