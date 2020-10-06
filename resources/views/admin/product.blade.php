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
                                <a href="" class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#createModal">Add Product</a>
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
                                            <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round mr-2"
                                                href="" data-placement="bottom" title="Delete" data-toggle="modal"
                                                data-target="#deleteModal{{$product->id}}">
                                                <i class="material-icons">delete</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round"
                                                href="" data-original-title="" data-placement="bottom" title="Edit"
                                                data-toggle="modal" data-target="#editModal{{$product->id}}">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                        </td>
                                    </tr>

                                    {{-- modal create --}}
                                    <div class="modal fade" id="createModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="/admin/product" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete items</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div
                                                            class="bmd-form-group{{ $errors->has('product_name') ? ' has-danger' : '' }}">
                                                            <div class="form-group pl-2">
                                                                <label for="product_name">Product Type</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="nama product" name="product_name"
                                                                    value="{{ old('product_name') }}">
                                                            </div>
                                                            @if ($errors->has('product_name'))
                                                            <div id="product_name-error" class="error text-danger"
                                                                for="product_name" style="display: block;">
                                                                <strong>{{ $errors->first('product_name') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="mt-2 bmd-form-group{{ $errors->has('desc') ? ' has-danger' : '' }}">
                                                            <div class="form-group pl-2">
                                                                <label for="desc">Description</label>
                                                                <textarea class="form-control" id="desc" rows="3"
                                                                    name="description"
                                                                    value="{{ old('product_name') }}"></textarea>
                                                            </div>
                                                            @if ($errors->has('desc'))
                                                            <div id="desc-error" class="error text-danger" for="desc"
                                                                style="display: block;">
                                                                <strong>{{ $errors->first('desc') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- modal edit --}}
                                    <div class="modal fade" id="editModal{{$product->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="/admin/product/{{$product->id}}" method="POST">
                                                    @method('patch')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div
                                                            class="bmd-form-group{{ $errors->has('product_name') ? ' has-danger' : '' }}">
                                                            <div class="form-group pl-2">
                                                                <label for="product_name">Product Type</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="nama product" name="product_name"
                                                                    value="{{ $product->product_name }}">
                                                            </div>
                                                            @if ($errors->has('product_name'))
                                                            <div id="product_name-error" class="error text-danger pl-3"
                                                                for="product_name" style="display: block;">
                                                                <strong>{{ $errors->first('product_name') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="mt-2 bmd-form-group{{ $errors->has('desc') ? ' has-danger' : '' }}">
                                                            <div class="form-group pl-2">
                                                                <label for="desc">Description</label>
                                                                <textarea class="form-control" id="desc" rows="3"
                                                                    name="description">{{ $product->description }}</textarea>
                                                            </div>
                                                            @if ($errors->has('desc'))
                                                            <div id="desc-error" class="error text-danger pl-3"
                                                                for="desc" style="display: block;">
                                                                <strong>{{ $errors->first('desc') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- modal delete --}}
                                    <div class="modal fade" id="deleteModal{{$product->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="/admin/product/{{$product->id}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete items</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="h5">Are you sure want to permanently remove this item?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

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


@push('js')
<script>
    $(document).ready(function () {

    }
    });

</script>
@endpush
