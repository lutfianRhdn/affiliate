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
                                            {{-- <form action="/admin/product/{{$product->id}}" method="POST"
                                            class="d-inline" id="form-delete">
                                            @method('delete')
                                            @csrf
                                            <button rel="tooltip"
                                                class="btn btn-danger btn-fab btn-fab-mini btn-round mr-2"
                                                data-placement="bottom" title="Erase">
                                                <i class="material-icons">delete</i>
                                                <div class="ripple-container"></div>
                                            </button>
                                            </form> --}}
                                            <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round mr-2"
                                                href="" data-placement="bottom" title="Delete" data-toggle="modal"
                                        data-target="#deleteModal{{$product->id}}">
                                                <i class="material-icons">delete</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round"
                                                href="/admin/product/{{$product->id}}/edit" data-original-title=""
                                                data-placement="bottom" title="Edit">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                        </td>
                                    </tr>

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
