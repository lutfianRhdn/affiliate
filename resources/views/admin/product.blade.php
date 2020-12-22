@extends('layouts.app', ['activePage' => 'product', 'titlePage' => __('Product')])


@section('content')
<div id="preloaders" class="preloader"></div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
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
                        @can('product.create')

                        <div class="col-12 text-right">
                            <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModal">Add
                                Product</a>
                        </div>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="tableProduct">
                            <thead class="text-primary">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Product Code</th>
                                    <th>Redirect</th>
                                    <th>Permission Url</th>
                                    <th class="no-sort">Code</th>
                                    <th class="text-right no-sort">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product as $product)
                                <tr>
                                    <td>{{$product->product_name}}</td>
                                    <td>{{$product->description}}</td>
                                    <td>{{$product->regex}}</td>
                                    <td>{{$product->url}}</td>
                                    <td>{{$product->permission_ip}}</td>
                                    <td><a rel="tooltip" class="btn btn-info btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="See & Edit Code" data-toggle="modal"
                                            data-target="#codeModal{{$product->id}}">
                                            <i class="material-icons">notes</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </td>

                                    <td class="td-actions text-right">
                                        <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round" href=""
                                            data-original-title="" data-placement="bottom" title="Docs Api"
                                            data-toggle="modal" data-target="#docsApiModal{{$product->id}}">
                                            <i class="material-icons">http</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @can('product.delete')
                                        <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="Delete" data-toggle="modal"
                                            data-target="#deleteModal{{$product->id}}">
                                            <i class="material-icons">delete</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @endcan

                                        @can('product.edit')
                                        <a rel="tooltip" class="btn btn-warning btn-fab btn-fab-mini btn-round" href=""
                                            data-original-title="" data-placement="bottom" title="Edit"
                                            data-toggle="modal" data-target="#editModal{{$product->id}}">
                                            <i class="material-icons">edit</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @endcan

                                    </td>
                                </tr>



                                {{-- modal edit --}}
                                <div class="modal fade" id="editModal{{$product->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.product.update', [$product->id])}}"
                                                method="POST">
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
                                                            <label for="product_name">Product Name</label>
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
                                                        class="bmd-form-group{{ $errors->has('regex') ? ' has-danger' : '' }}">
                                                        <div class="form-group pl-2">
                                                            <label for="regex">Product Code</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="nama product" name="regex"
                                                                oninput="this.value = this.value.toUpperCase()"
                                                                value="{{ $product->regex }}">
                                                        </div>
                                                        @if ($errors->has('regex'))
                                                        <div id="regex-error" class="error text-danger pl-3" for="regex"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('regex') }}</strong>
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
                                                        <div id="desc-error" class="error text-danger pl-3" for="desc"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('desc') }}</strong>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="bmd-form-group {{ $errors->has('permissionUrl') ? ' has-danger' : '' }}">
                                                        <div class="form-group pl-2">
                                                            <label for="product_name">Permission Url</label>
                                                            <input type="text" class="form-control pl-2"
                                                                placeholder="https://sample.com" name="permissionUrl"
                                                                value="{{ $product->permission_ip }}">
                                                        </div>
                                                        @if ($errors->has('permissionUrl'))
                                                        <div id="permissionUrl-error" class="error text-danger"
                                                            for="permissionUrl" style="display: block;">
                                                            <strong>{{ $errors->first('permissionUrl') }}</strong>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="bmd-form-group">
                                                        <div class="form-group pl-2">
                                                            <label for="product_name">URL</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="https://pagii.co/" name="urlProduct"
                                                                value="{{ $product->url }}">
                                                        </div>
                                                        @if ($errors->has('urlProduct'))
                                                        <div id="permissionUrl-error" class="error text-danger"
                                                            for="permissionUrl" style="display: block;">
                                                            <strong>{{ $errors->first('permissionUrl') }}</strong>
                                                        </div>
                                                        @endif
                                                    </div>

                                                    {{-- <div class="mt-2 bmd-form-group">
                                                        <div class="form-group pl-2">
                                                            <textarea class="form-control" id="codeInput" rows="20"
                                                                placeholder="{{ !empty($product->code) ? '' : 'Product Code' }}"
                                                    name="code">{{ !empty($product->code) ? $product->code : ''}}</textarea>
                                                </div>
                                        </div> --}}
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

                <!-- Modal docs Api -->
                @php
                $hashId = Hashids::encode($product->id);
                @endphp
                <div class="modal fade" id="docsApiModal{{$product->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="docsApiModal{{$product->id}}Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="docsApiModal{{$product->id}}Label">Docs Api</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                              {{-- create client --}}
                        <div class="my-2">
                            <h5>Create Clients </h5>
                            <div class=" p-1 px-3 d-flex justify-content-between align-items-center border-0 rounded"
                                style="background:#e9ecef">
                                <p class=" apiCreateClients my-auto" id="apiCreateClients-{{$hashId}}">
                                    {{url('/')}}/api/client/register/{{$hashId}} </p>
                                <button class="copyTextButtonClients btn btn-sm btn-default"
                                    id="buttonClients-{{$hashId}}" rel="tooltip" data-original-title=""
                                    data-placement="bottom" title="copy">Copy</button>
                            </div>
                            {{-- required field --}}
                            <div class="mt-3">
                                <p>The Field must be sent with <b>POST</b> Method</p>
                                {{-- table --}}
                                <div class="mx-3">
                                    <b>
                                        <div class="row text-center border-bottom border-dark ">
                                            <div class="col-4 py-1">Name</div>
                                            <div class="col-4 py-1">Type</div>
                                            <div class="col-4 py-1">Desc</div>
                                        </div>
                                    </b>
                                    <div class="row text-center " style="background:#e9ecef">
                                        <div class="col-4 py-1">name</div>
                                        <div class="col-4 py-1">String</div>
                                        <div class="col-4 py-1">Required</div>
                                    </div>
                                    <div class="row text-center ">
                                        <div class="col-4 py-1">ref_code</div>
                                        <div class="col-4 py-1">String</div>
                                        <div class="col-4 py-1">Ref Code Reseller</div>
                                    </div>
                                    <div class="row text-center " style="background:#e9ecef">
                                        <div class="col-4 py-1">unic_code</div>
                                        <div class="col-4 py-1">String</div>
                                        <div class="col-4 py-1">unic Id from client</div>
                                    </div>
                                    <div class="row text-center ">
                                        <div class="col-4 py-1">company</div>
                                        <div class="col-4 py-1">string</div>
                                        <div class="col-4 py-1">Optional</div>
                                    </div>
                                    <div class="row text-center ">
                                        <div class="col-4 py-1">description</div>
                                        <div class="col-4 py-1">string</div>
                                        <div class="col-4 py-1">Optional</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- transaction client --}}
                        <div class="my-2">
                            <h5>Transaction Clients </h5>
                            <div class=" p-1 px-3 d-flex justify-content-between align-items-center border-0 rounded"
                                style="background:#e9ecef">
                                <p class=" apiTransactionClients my-auto" id="apiTransactionClients-{{$hashId}}">
                                    {{url('/')}}/api/client/transaction/{{$hashId}} </p>
                                <button class="copyTextButtonTransaction btn btn-sm btn-default"
                                    id="buttonApiTransaction-{{$hashId}}" rel="tooltip" data-original-title=""
                                    data-placement="bottom" title="copy">Copy</button>
                            </div>
                             {{-- required field --}}
                             <div class="mt-3">
                                <p>The Field must be sent with <b>POST</b> Method</p>
                                {{-- table --}}
                                <div class="mx-3">
                                    <b>
                                        <div class="row text-center border-bottom border-dark ">
                                            <div class="col-4 py-1">name</div>
                                            <div class="col-4 py-1">Type</div>
                                            <div class="col-4 py-1">Desc</div>
                                        </div>
                                    </b>
                                   
                                    <div class="row text-center ">
                                        <div class="col-4 py-1">payment_date</div>
                                        <div class="col-4 py-1">date</div>
                                        <div class="col-4 py-1">format : Y-m-d</div>
                                    </div>
                                    <div class="row text-center " style="background:#e9ecef">
                                        <div class="col-4 py-1">unic_code</div>
                                        <div class="col-4 py-1">String</div>
                                        <div class="col-4 py-1">unic Id from client</div>
                                    </div>
                                    <div class="row text-center ">
                                        <div class="col-4 py-1">total_payment</div>
                                        <div class="col-4 py-1">number</div>
                                        <div class="col-4 py-1">required</div>
                                    </div>
                                    <div class="row text-center ">
                                        <div class="col-4 py-1">ref_code</div>
                                        <div class="col-4 py-1">string</div>
                                        <div class="col-4 py-1">Ref Code Reseller</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- delete client --}}
                        <div class="my-2">
                            <h5>Delete Clients </h5>
                            <div class=" p-1 px-3 d-flex justify-content-between align-items-center border-0 rounded"
                                style="background:#e9ecef">
                                <p class=" apiTransactionClients my-auto" id="apiTransactionClients-{{$hashId}}">
                                    {{url('/')}}/api/client/delete/{{$hashId}} </p>
                                <button class="copyTextButtonTransaction btn btn-sm btn-default"
                                    id="buttonApiTransaction-{{$hashId}}" rel="tooltip" data-original-title=""
                                    data-placement="bottom" title="copy">Copy</button>
                            </div>
                             {{-- required field --}}
                             <div class="mt-3">
                                <p>The Field must be sent with <b>DELETE</b> Method</p>
                                {{-- table --}}
                                <div class="mx-3">
                                    <b>
                                        <div class="row text-center border-bottom border-dark ">
                                            <div class="col-4 py-1">name</div>
                                            <div class="col-4 py-1">Type</div>
                                            <div class="col-4 py-1">Desc</div>
                                        </div>
                                    </b>
                                   
                                 
                                    <div class="row text-center " style="background:#e9ecef">
                                        <div class="col-4 py-1">unic_code</div>
                                        <div class="col-4 py-1">String</div>
                                        <div class="col-4 py-1">unic Id from client</div>
                                    </div>
                          
                                    <div class="row text-center ">
                                        <div class="col-4 py-1">ref_code</div>
                                        <div class="col-4 py-1">string</div>
                                        <div class="col-4 py-1">Ref Code Reseller</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- edit client --}}
                        <div class="my-2">
                            <h5>Edit Clients </h5>
                            <div class=" p-1 px-3 d-flex justify-content-between align-items-center border-0 rounded"
                                style="background:#e9ecef">
                                <p class=" apiTransactionClients my-auto" id="apiTransactionClients-{{$hashId}}">
                                    {{url('/')}}/api/client/update/{{$hashId}} </p>
                                <button class="copyTextButtonTransaction btn btn-sm btn-default"
                                    id="buttonApiTransaction-{{$hashId}}" rel="tooltip" data-original-title=""
                                    data-placement="bottom" title="copy">Copy</button>
                            </div>
                             {{-- required field --}}
                             <div class="mt-3">
                                <p>The Field must be sent with <b>PUT</b> Method</p>
                                {{-- table --}}
                                <div class="mx-3">
                                    <b>
                                        <div class="row text-center border-bottom border-dark ">
                                            <div class="col-4 py-1">name</div>
                                            <div class="col-4 py-1">Type</div>
                                            <div class="col-4 py-1">Desc</div>
                                        </div>
                                    </b>
                                    <div class="row text-center " style="background:#e9ecef">
                                        <div class="col-4 py-1">unic_code</div>
                                        <div class="col-4 py-1">String</div>
                                        <div class="col-4 py-1">unic Id from client</div>
                                    </div>
                                    <div class="row text-center ">
                                        <div class="col-4 py-1">ref_code</div>
                                        <div class="col-4 py-1">string</div>
                                        <div class="col-4 py-1">Ref Code Reseller</div>
                                    </div>
                                    <div class="row text-center ">
                                        <div class="col-4 py-1">new_unic_code</div>
                                        <div class="col-4 py-1">string</div>
                                        <div class="col-4 py-1">new unic_code</div>
                                    </div>
                                    <div class="row text-center ">
                                        <div class="col-4 py-1">name</div>
                                        <div class="col-4 py-1">string</div>
                                        <div class="col-4 py-1"></div>
                                    </div>
                                    <div class="row text-center ">
                                        <div class="col-4 py-1">company</div>
                                        <div class="col-4 py-1">string</div>
                                        <div class="col-4 py-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Code -->
        <div class="modal fade" id="codeModal{{$product->id}}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 bmd-form-group">
                            <div class="form-group pl-2">
                                <textarea class="form-control" id="codeInput" rows="20"
                                    placeholder="{{ !empty($product->code) ? '' : 'Product Code' }}" name="code"
                                    readonly>{{ !empty($product->code) ? $product->code : ''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="btnCopy" data-dismiss="modal">Copy
                            code</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal delete --}}
        <div class="modal fade" id="deleteModal{{$product->id}}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.product.destroy', $product->id)}}" method="POST">
                        @method('delete')
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete items</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="h5">Are you sure want to permanently remove this item?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
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

{{-- modal create --}}
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.product.store')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="bmd-form-group{{ $errors->has('product_name') ? ' has-danger' : '' }}">
                        <div class="form-group pl-2">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control pl-2" placeholder="Name" name="product_name"
                                value="{{ old('product_name') }}">
                        </div>
                        @if ($errors->has('product_name'))
                        <div id="product_name-error" class="error text-danger" for="product_name"
                            style="display: block;">
                            <strong>{{ $errors->first('product_name') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="bmd-form-group{{ $errors->has('regex') ? ' has-danger' : '' }}">
                        <div class="form-group pl-2">
                            <label for="regex">Product Code</label>
                            <input type="text" class="form-control pl-2" placeholder="ABCD" name="regex"
                                value="{{ old('regex') }}" oninput="this.value = this.value.toUpperCase()">
                        </div>
                        @if ($errors->has('regex'))
                        <div id="regex-error" class="error text-danger" for="regex" style="display: block;">
                            <strong>{{ $errors->first('regex') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="mt-2 bmd-form-group{{ $errors->has('desc') ? ' has-danger' : '' }}">
                        <div class="form-group pl-2">
                            <label for="desc">Description</label>
                            <textarea class="form-control pl-2" id="desc" rows="2" name="description"
                                placeholder="Type your product description here"
                                value="{{ old('product_name') }}"></textarea>
                        </div>
                        @if ($errors->has('desc'))
                        <div id="desc-error" class="error text-danger" for="desc" style="display: block;">
                            <strong>{{ $errors->first('desc') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="bmd-form-group {{ $errors->has('permissionUrl') ? ' has-danger' : '' }}">
                        <div class="form-group pl-2">
                            <label for="product_name">Permission Url</label>
                            <input type="text" class="form-control pl-2" placeholder="https://sample.com"
                                name="permissionUrl" value="{{ old('permissionUrl') }}">
                        </div>
                        @if ($errors->has('permissionUrl'))
                        <div id="permissionUrl-error" class="error text-danger" for="permissionUrl"
                            style="display: block;">
                            <strong>{{ $errors->first('permissionUrl') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="bmd-form-group">
                        <div class="form-group pl-2">
                            <label for="product_name">Thank You Page </label>
                            <input type="text" class="form-control pl-2" placeholder="https://sample.com/thanksyou"
                                name="urlProduct" value="{{ old('url') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@push('js')
<script>
    $(document).ready(function () {
        $('.custom-select-2').select2();
        $('#tableProduct').DataTable({
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': ['no-sort']
            }]
        });
        $('.custom-select').selectpicker();
        $("#preloaders").fadeOut(1000);
        $(document).on('click', '#btnCopy', function () {
            copytext($('#codeInput').val(), this);
        });
        $(document).on('click', '.copyTextButton', function () {
            console.log(this);
            const target = `#apiCreateReseller-${this.id.split('-')[1]}`
            copytext($(target).html(), this);
            // target.css('background','gray')
            $('#' + this.id)
                .addClass('btn-success')
                .removeClass('btn-default')
                .html("copied")
            setTimeout(() => {
                $(this).removeClass('btn-success').addClass('btn-default').html('copy')
            }, 1500)
        });
        $(document).on('click', '.copyTextButtonClients', function () {
            console.log(this);
            const target = `#apiCreateClients-${this.id.split('-')[1]}`
            copytext($(target).html(), this);
            // target.css('background','gray')
            $('#' + this.id)
                .addClass('btn-success')
                .removeClass('btn-default')
                .html("copied")
            setTimeout(() => {
                $(this).removeClass('btn-success').addClass('btn-default').html('copy')
            }, 1500)
        });
        $(document).on('click', '.copyTextButtonTransaction', function () {
            console.log(this);
            const target = `#apiTransactionClients-${this.id.split('-')[1]}`
            copytext($(target).html(), this);
            // target.css('background','gray')
            $('#' + this.id)
                .addClass('btn-success')
                .removeClass('btn-default')
                .html("copied")
            setTimeout(() => {
                $(this).removeClass('btn-success').addClass('btn-default').html('copy')
            }, 1500)
        });

    });

    function copytext(text, context) {
        var textField = document.createElement('textarea');
        textField.innerText = text;

        if (context) {
            context.parentNode.insertBefore(textField, context);
        } else {
            document.body.appendChild(textField);
        }

        textField.select();
        document.execCommand('copy');
        // Let `.remove()` also work with older IEs
        textField.parentNode.removeChild(textField);
    }

</script>
@endpush
