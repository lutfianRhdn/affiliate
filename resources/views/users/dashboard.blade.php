@extends('users.layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Reseller Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush