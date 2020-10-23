@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => '', 'title' => __('Affiliate Program'),
'titlePage' => 'Welcome'])

@section('content')
<div class="vertical-center jumbotron-fluid">
    <div class="container">
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{session('error')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <h1 class="text-white text-center">{{ __('Welcome to Affiliate.') }}</h1>
    </div>
</div>

@endsection
