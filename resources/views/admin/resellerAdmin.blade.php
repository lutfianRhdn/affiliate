@extends('layouts.app', ['activePage' => 'reseller', 'titlePage' => __('Reseller Management')])

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Reseller</h4>
                        <p class="card-category"> Reseller management tabels</p>
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
                                    data-target="#createUserModal">Add new Reseller</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th class="text-center">Product Category</th>
                                        <th>Refferal Code</th>
                                        <th>Status</th>
                                        <th>Create Date</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}} <span
                                                class="ml-2 badge badge-{{$user->register_status == '1' ? 'success' : 'warning'}}">{{$user->register_status == '1' ? 'Activated' : 'Not Activated'}}</span>
                                        </td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->address. ', '. $user->region.', '.$user->state.', '.$user->country}}
                                        </td>
                                        <td class="text-center">{{$user->product_name}}</td>
                                        <td>{{$user->ref_code }}</td>
                                        <td>
                                            <div class="togglebutton">
                                                <label id="status">
                                                    <input type="checkbox" {{ !empty($user->regex) ? 'checked' : ''}}>
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{  Carbon\Carbon::parse($user->created_at)->format('d-m-Y')}}</td>
                                        <td class="td-actions text-right">
                                            <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round"
                                                href="" data-placement="bottom" title="Delete" data-toggle="modal"
                                                data-target="#deleteModal{{$user->id}}">
                                                <i class="material-icons">delete</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round"
                                                href="" data-placement="bottom" title="Edit" data-toggle="modal"
                                                data-target="#editUserModal{{$user->id}}">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                        </td>
                                    </tr>



                                    {{-- modal delete --}}
                                    <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="/admin/reseller/{{$user->id}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$user->id}}">
                                                    <input type="hidden" name="email" value="{{$user->email}}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="h5">Are you sure want to permanently remove
                                                            {{$user->name}}?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">No</button>
                                                        <button type="submit" class="btn btn-danger">Yes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- modal edit --}}
                                    <div class="modal fade" id="editUserModal{{$user->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="/admin/reseller/{{$user->id}}" method="POST">
                                                    @method('patch')
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$user->id}}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Reseller
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div
                                                            class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="material-icons">face</i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" name="name" class="form-control"
                                                                    placeholder="{{ __('Name...') }}"
                                                                    value="{{$user->name}}" required>
                                                            </div>
                                                            @if ($errors->has('name'))
                                                            <div id="name-error" class="error text-danger pl-3"
                                                                for="name" style="display: block;">
                                                                <strong>{{ $errors->first('name') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="bmd-form-group{{ $errors->has('phone') ? ' has-danger' : '' }} mt-3">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="material-icons">phone</i>
                                                                    </span>
                                                                </div>
                                                                <input type="number" name="phone" class="form-control"
                                                                    placeholder="{{ __('081231923479...') }}"
                                                                    value="{{$user->phone}}" required>
                                                            </div>
                                                            @if ($errors->has('phone'))
                                                            <div id="phone-error" class="error text-danger pl-3"
                                                                for="phone" style="display: block;">
                                                                <strong>{{ $errors->first('phone') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="bmd-form-group{{ $errors->has('product_id') ? ' has-danger' : '' }} mt-3 mb-3">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="material-icons">content_paste</i>
                                                                    </span>
                                                                </div>
                                                                <select class="custom-select"
                                                                    id="selectpicker-productID"
                                                                    data-style="btn btn-primary" name="product_id"
                                                                    required>
                                                                    <option disabled selected>Product Category</option>
                                                                    @foreach ($products as $product)
                                                                    <option value="{{$product->id}}"
                                                                        {{$product->id == $user->product_id ? 'selected' : ''}}>
                                                                        {{$product->product_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            @if ($errors->has('product_id'))
                                                            <div id="role-error" class="error text-danger pl-3"
                                                                for="product_id" style="display: block;">
                                                                <strong>{{ $errors->first('product_id') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <input type="hidden" name="role" value="2">
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

{{-- modal create --}}
<div class="modal fade createUserModal-modal-lg" id="createUserModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="/admin/reseller" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Reseller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label for="name">Name</label>
                                <input type="text" class="form-control pt-3" id="name" placeholder="Full Name"
                                    name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                <div id="name-error" class="error text-danger" for="name" style="display: block;">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="form-group mt-2 {{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label for="email">Email Address</label>
                                <input type="text" class="form-control pt-3" id="email" placeholder="email@example.com"
                                    name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                <div id="email-error" class="error text-danger" for="email" style="display: block;">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="form-group mt-2 {{ $errors->has('phone') ? ' has-danger' : '' }}">
                                <label for="phone">Phone Number</label>
                                <input type="number" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                    class="form-control pt-3" id="phone" placeholder="081xxx" name="phone"
                                    value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                <div id="phone-error" class="error text-danger" for="phone" style="display: block;">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="form-group mt-2 {{ $errors->has('country') ? ' has-danger' : '' }}">
                                <label for="country">Country</label>
                                <select class="form-control" data-style="btn btn-link" id="country" name="country">
                                    <option selected value="Indonesia">Indonesia</option>
                                </select>
                                @if ($errors->has('country'))
                                <div id="country-error" class="error text-danger" for="country" style="display: block;">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="row ml-1">
                                <div class="col-6" style="margin-left: -1rem">
                                    <div class="form-group mt-2 {{ $errors->has('state') ? ' has-danger' : '' }}">
                                        <label for="state">State/Province</label>
                                        <select class="form-control" data-style="btn btn-link" id="state" name="state">
                                            @foreach ($provinces as $prov)
                                            <option value="{{$prov->name}}">{{$prov->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('state'))
                                        <div id="state-error" class="error text-danger" for="state"
                                            style="display: block;">
                                            <strong>{{ $errors->first('state') }}</strong>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group {{ $errors->has('city') ? ' has-danger' : '' }}">
                                        <label for="city">City</label>
                                        <select class="form-control" data-style="btn btn-link" id="city" name="city">
                                            <option value="Bandung">Bandung</option>
                                        </select>
                                        @if ($errors->has('city'))
                                        <div id="city-error" class="error text-danger" for="city"
                                            style="display: block;">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mt-2 {{ $errors->has('address') ? ' has-danger' : '' }}">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" rows="2" value="{{ old('address') }}"
                                    placeholder="jl.xxx no xxx" name="address"></textarea>
                                @if ($errors->has('address'))
                                <div id="address-error" class="error text-danger" for="address" style="display: block;">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="form-group mt-2 {{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                <label for="product_id">Category Product</label>
                                <select class="form-control custom-select" data-style="btn btn-link" id="product_id"
                                    name="product_id">
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{$product->product_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('product_id'))
                                <div id="product_id-error" class="error text-danger" for="product_id"
                                    style="display: block;">
                                    <strong>{{ $errors->first('product_id') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="form-group mt-2 {{ $errors->has('password') ? ' has-danger' : '' }}">
                                <label for="password">Password</label>
                                <input type="password" class="form-control pt-3" id="password"
                                    placeholder="Password123!" name="password">
                                <small class="text-danger">Password must be contain 8 character, uppercase
                                    and lowercase letter, number and special character. Ex: Password23!</small>
                                @if ($errors->has('password'))
                                <div id="password-error" class="error text-danger" for="password"
                                    style="display: block;">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div
                                class="form-group mt-3 {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                <label for="password">Password Confirmation</label>
                                <input type="password" class="form-control pt-3" id="password"
                                    placeholder="Password123!" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                <div id="password-error" class="error text-danger" for="password_confirmation"
                                    style="display: block;">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="role" value="2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Regist</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#table_admin').DataTable({
            'info': false,
            'lengthMenu': [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ]
        });
        $('#edit-user').tooltip(options);
        $('.selectpicker').selectpicker();
        $('#selectpicker-role').selectpicker();
        $('#selectpicker-productID').selectpicker();

        $(".togglebutton").bootstrapSwitch();
    });

</script>
@endpush
