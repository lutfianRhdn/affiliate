@extends('layouts.BaseApp', ['class' => 'off-canvas-sidebar', 'activePage' => '', 'title' => __('Affiliate Program'), 'titlePage' => 'Welcome'])

@section('content')
<div class="container" style="height: auto;">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-8">
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
</div>
@endsection
