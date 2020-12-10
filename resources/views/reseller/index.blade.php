@extends('layouts.app', ['activePage' => 'client', 'titlePage' => __('Client Management')])

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
                <table class="table datatable">
                    <thead>
                    <tr class="text-primary">
                        <th>No</th>
                        <th>Client Name</th>
                        <th>Total Payment</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$client->name}}</td>
                          <td>Rp.{{$client->total_payment == null ?'0':$client->total_payment}}</td>
                            <td>{{$client->status ==false ?"hasn't paid" :'has paid '}}</td>
                        </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>    </div>
  </div>

@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      $("#preloaders").fadeOut(1000);
      md.initDashboardPageCharts();

      $('.datatable').DataTable()
    });
  </script>
@endpush