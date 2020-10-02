@extends('layouts.app', ['activePage' => 'product', 'titlePage' => __('Add Product')])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="container-fluid bg bg-white rounded pt-3 pb-3">
                <form class="form" method="POST" action="/admin/product">
                    @csrf
                    <div class="bmd-form-group{{ $errors->has('product_name') ? ' has-danger' : '' }}">
                        <div class="form-group pl-2">
                            <label for="product_name">Product Type</label>
                            <input type="text" class="form-control" placeholder="nama product" name="product_name" value="{{ old('product_name') }}">
                        </div>
                        @if ($errors->has('product_name'))
                        <div id="product_name-error" class="error text-danger" for="product_name"
                            style="display: block;">
                            <strong>{{ $errors->first('product_name') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="mt-2 bmd-form-group{{ $errors->has('desc') ? ' has-danger' : '' }}">
                        <div class="form-group pl-2">
                            <label for="desc">Description</label>
                            <textarea class="form-control" id="desc" rows="3" name="description" value="{{ old('product_name') }}"></textarea>
                        </div>
                        @if ($errors->has('desc'))
                        <div id="desc-error" class="error text-danger" for="desc" style="display: block;">
                            <strong>{{ $errors->first('desc') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <a class="btn btn-secondary" href="/admin/product">Cancel</a>
                                <button type="submit" class="btn btn-primary ml-3">Save</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
