@extends('layouts.app', ['activePage' => 'product', 'titlePage' => __('Product')])


@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Products</h4>
                        <p class="card-category"> Product tabel</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-sm-4">
                                @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{session('status')}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif
                            </div>
                            <div class="col-12 text-right">
                                <a href="/admin/product/create" class="btn btn-sm btn-primary">Add Product</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>Product Type</th>
                                        <th>Description</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product as $product)
                                    <tr>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{$product->description}}</td>
                                        <td class="td-actions text-right">
                                            <form action="/admin/product/{{$product->id}}" method="POST"
                                                class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button rel="tooltip"
                                                    class="btn btn-danger btn-fab btn-fab-mini btn-round mr-2"
                                                    data-placement="bottom" title="Erase">
                                                    <i class="material-icons">delete</i>
                                                    <div class="ripple-container"></div>
                                                </button>
                                            </form>
                                            <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round"
                                                href="/admin/product/{{$product->id}}/edit" data-original-title=""
                                                data-placement="bottom" title="Edit">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
