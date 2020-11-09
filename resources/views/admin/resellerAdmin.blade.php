@extends('layouts.app', ['activePage' => 'reseller', 'titlePage' => __('Reseller Management')])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Reseller</h4>
                    <p class="card-category"> Reseller management tabels</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 col-sm-4 alert-approval">
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
                        <table class="table" id="table_reseller">
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
                                                <input type="checkbox" data-id="{{$user->id}}" id="change-status"
                                                    {{ ($user->status == 1) ? 'checked' : ''}}>
                                                <span class="toggle"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{  Carbon\Carbon::parse($user->created_at)->format('d-m-Y')}}</td>
                                    <td class="td-actions text-right">
                                        @if($user->approve == 1)
                                        <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="Approved">
                                            <i class="material-icons">check_circle</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @elseif($user->approve == 0 && !empty($user->approve_note))
                                        <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round"
                                            data-placement="bottom" title="{{$user->approve_note}}">
                                            <i class="material-icons">disabled_by_default</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @elseif($user->status == 0 && $user->approve == 0 && empty($user->approve_note))
                                        <a rel="tooltip"
                                            class="btn btn-warning btn-fab btn-fab-mini btn-round approvalForm" href=""
                                            data-id="{{$user->id}}" data-placement="bottom" title="Approval"
                                            data-toggle="modal" data-target="#approvalModal{{$user->id}}">
                                            <i class="material-icons">approval</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @endif
                                        <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="Delete" data-toggle="modal"
                                            data-target="#deleteModal{{$user->id}}">
                                            <i class="material-icons">delete</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="Edit" data-toggle="modal"
                                            data-target="#editUserModal{{$user->id}}">
                                            <i class="material-icons">edit</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </td>
                                </tr>

                                {{-- modal approval --}}
                                <div class="modal fade " id="approvalModal{{$user->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="/admin/approval/{{$user->id}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" id="user-id" value="{{$user->id}}">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Approval user</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="h5">Approve this user {{$user->name}} ?</p>
                                                    <textarea name="approve_note" class="form-control approve_note"
                                                        id="approve-{{$user->id}}" placeholder="Reason"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn btn-secondary ejectApproval">No</button>
                                                    <button type="button" class="btn btn-danger submitEject"
                                                        data-dismiss="modal">Submit Eject</button>
                                                    <button type="button" class="btn btn-primary submitApproved"
                                                        data-dismiss="modal">Yes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

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
                                                        class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                                        <label for="name">Name <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control pt-3" id="name"
                                                            placeholder="Full Name" name="name"
                                                            value="{{ $user->name }}">
                                                        @if ($errors->has('name'))
                                                        <div id="name-error" class="error text-danger" for="name"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="form-group mt-2 {{ $errors->has('phone') ? ' has-danger' : '' }}">
                                                        <label for="phone">Phone Number</label>
                                                        <input type="text"
                                                            oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                                            class="form-control pt-3" id="phone-reseller-edit"
                                                            placeholder="08xx-xxxx-xxxxx" name="phone"
                                                            value="{{ $user->phone }}">
                                                        @if ($errors->has('phone'))
                                                        <div id="phone-error" class="error text-danger" for="phone"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('phone') }}</strong>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="form-group mt-2 {{ $errors->has('country') ? ' has-danger' : '' }}">
                                                        <label for="country">Country <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control" data-style="btn btn-link"
                                                            id="country2" name="country">
                                                            <option selected value="Indonesia">Indonesia</option>
                                                        </select>
                                                        @if ($errors->has('country'))
                                                        <div id="country-error" class="error text-danger" for="country"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('country') }}</strong>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="row ml-1">
                                                        <div class="col-lg-6 col-sm-12" style="margin-left: -1rem">
                                                            <div
                                                                class="form-group mt-2 {{ $errors->has('state') ? ' has-danger' : '' }}">
                                                                <label for="state">State/Province <span
                                                                        class="text-danger">*</span></label>
                                                                <select class="form-control" data-style="btn btn-link"
                                                                    id="state-edit" name="state"
                                                                    title="Select your province">
                                                                    @foreach ($provinces as $province)
                                                                    <option value="{{$province->id}}"
                                                                        {{ $user->state == $province->province_name ? 'selected' : '' }}>
                                                                        {{$province->province_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('state'))
                                                                <div id="state-error" class="error text-danger"
                                                                    for="state" style="display: block;">
                                                                    <strong>{{ $errors->first('state') }}</strong>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-12">
                                                            <div
                                                                class="form-group {{ $errors->has('city') ? ' has-danger' : '' }}">
                                                                <label for="city">City <span
                                                                        class="text-danger">*</span></label>
                                                                <select class="form-control" data-style="btn btn-link"
                                                                    id="city-reseller-edit" name="city"
                                                                    value="{{ $user->region }}"
                                                                    title="Select your city">
                                                                </select>
                                                                @if ($errors->has('city'))
                                                                <div id="city-error" class="error text-danger"
                                                                    for="city" style="display: block;">
                                                                    <strong>{{ $errors->first('city') }}</strong>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="form-group mt-2 {{ $errors->has('address') ? ' has-danger' : '' }}">
                                                        <label for="address">Address <span
                                                                class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="address" rows="2"
                                                            placeholder="Your Address"
                                                            name="address">{{ $user->address }}</textarea>
                                                        @if ($errors->has('address'))
                                                        <div id="address-error" class="error text-danger" for="address"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('address') }}</strong>
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
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control pt-3" id="name" placeholder="Full Name"
                                    name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                <div id="name-error" class="error text-danger" for="name" style="display: block;">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="form-group mt-2 {{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label for="email">Email Address <span class="text-danger">*</span></label>
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
                                <input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                    class="form-control pt-3" id="phone-reseller" placeholder="08xx-xxxx-xxxxx"
                                    name="phone" value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                <div id="phone-error" class="error text-danger" for="phone" style="display: block;">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="form-group mt-2 {{ $errors->has('country') ? ' has-danger' : '' }}">
                                <label for="country">Country <span class="text-danger">*</span></label>
                                <select class="form-control" data-style="btn btn-link" id="country2" name="country">
                                    <option selected value="Indonesia">Indonesia</option>
                                </select>
                                @if ($errors->has('country'))
                                <div id="country-error" class="error text-danger" for="country" style="display: block;">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="row ml-1">
                                <div class="col-lg-6 col-sm-12" style="margin-left: -1rem">
                                    <div class="form-group mt-2 {{ $errors->has('state') ? ' has-danger' : '' }}">
                                        <label for="state">State/Province <span class="text-danger">*</span></label>
                                        <select class="form-control" data-style="btn btn-link" id="state" name="state"
                                            value="{{ old('state') }}">
                                            <option value="" selected disabled>Select your province</option>
                                            @foreach ($provinces as $province)
                                            <option value="{{$province->id}}"
                                                {{ old('state') == $province->id ? 'selected' : '' }}>
                                                {{$province->province_name}}</option>
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
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group {{ $errors->has('city') ? ' has-danger' : '' }}">
                                        <label for="city">City <span class="text-danger">*</span></label>
                                        <select class="form-control" data-style="btn btn-link" id="city-reseller"
                                            name="city" value="{{ old('city') }}">
                                            <option value="" selected disabled>Select your city</option>
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
                                <label for="address">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="address" rows="2" placeholder="Your Address"
                                    name="address">{{ old('address') }}</textarea>
                                @if ($errors->has('address'))
                                <div id="address-error" class="error text-danger" for="address" style="display: block;">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="form-group mt-2 {{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                <label for="product_id">Category Product <span class="text-danger">*</span></label>
                                <select class="form-control custom-select" data-style="btn btn-link"
                                    id="prouct-reseller" name="product_id">
                                    <option value="" selected disabled>Select Product</option>
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
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control pt-3" id="password_reseller"
                                    placeholder="Your Password" name="password">
                                <span class="form-check-sign-register" id="check_reseller">
                                    <i class="material-icons password-icon text-secondary" aria-hidden="true"
                                        id="icon-pass-reseller">remove_red_eye</i>
                                </span>
                                <small class="text-danger" id="hint_reseller">Password must be contain 8 character,
                                    uppercase
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
                                <label for="password">Password Confirmation <span class="text-danger">*</span></label>
                                <input type="password" class="form-control pt-3" id="password_confirmation"
                                    placeholder="Re Password" name="password_confirmation">
                                <span class="form-check-sign-register" id="check3">
                                    <i class="material-icons password-icon text-secondary" aria-hidden="true"
                                        id="icon-pass3">remove_red_eye</i>
                                </span>
                                <span id="confirm-message3" class="confirm-message"></span>
                                @if ($errors->has('password_confirmation'))
                                <div id="password-error" class="error text-danger" for="password_confirmation"
                                    style="display: block;">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </div>
                                @endif
                            </div>

                            <input type="hidden" name="role" value="2">
                        </div>
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

{{-- 

    <select class="form-control custom-select"
                                                                data-style="btn btn-link" id="prouct-reseller-edit"
                                                                name="product_id">
                                                                <option value="" selected disabled>Select Product
                                                                </option>
                                                                @foreach ($products as $product)
                                                                <option value="{{$product->id}}"
{{$product->id == $user->product_id ? 'selected' : ''}}>
{{$product->product_name}}</option>
@endforeach
</select>

--}}


@push('js')
<script>
    $(document).ready(function () {
        $('#table_reseller').DataTable({
            // "responsive": true,
            "scrollX": true,
            "order": [[ 7, "desc" ]]
        });
        var options = "";
        $('#edit-user').tooltip(options);

        $('#change-status').change(function () {
            $.ajax({
                url: '{{route("getStatus")}}',
                type: 'GET',
                data: {
                    id: $(this).attr("data-id"),
                },
                dataType: 'json',
                success: function (data) {
                    $('.alert-approval').append(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        data.success +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                    );
                },
                error: function (xhr, status) {
                    console.log(status);
                },
                complete: function () {
                    alreadyloading = false;
                }
            });
        });

        // $(".togglebutton").bootstrapSwitch();
        $('.approvalForm').click(function () {
            $("input[name='id']").val($(this).attr("data-id")),
                $('.submitEject').hide();
            $('.approve_note').hide();
            $('.ejectApproval').show();
        });

        $(".ejectApproval").click(function () {
            $('.approve_note').attr('required', 'true');
            $('.approve_note').show();
            $('.ejectApproval').hide();
            $('.submitEject').show();
        });

        $('.submitApproved').click(function () {
            $.ajax({
                url: '{{route("getApproval")}}',
                type: 'POST',
                data: {
                    _token: $("input[name='_token']").val(),
                    id: $("input[name='id']").val(),
                },
                dataType: 'json',
                success: function (data) {
                    $('.alert-approval').append(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        data.success +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                    );
                    location.reload();
                },
                error: function (xhr, status) {
                    console.log(status);
                },
                complete: function () {
                    alreadyloading = false;
                }
            });
        });

        $('.submitEject').click(function () {
            $.ajax({
                url: '{{route("getApproval")}}',
                type: 'POST',
                data: {
                    _token: $("input[name='_token']").val(),
                    id: $("input[name='id']").val(),
                    approve_note: $("#approve-" + $("input[name='id']").val()).val(),
                },
                dataType: 'json',
                success: function (data) {
                    $('.alert-approval').append(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        data.success +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                    );
                    location.reload();
                },
                error: function (xhr, status) {
                    console.log(status);
                },
                complete: function () {
                    alreadyloading = false;
                }
            });
        });
        $("#hint_reseller").hide();
        $("#agree-required").hide();
        $("#password_reseller").focus(function () {
            $("#hint_reseller").show();
        });
        $("#password_reseller").blur(function () {
            $("#hint_reseller").hide();
        });
        $('#prouct-reseller').selectpicker();
        $('.custom-select').selectpicker();
        $('#prouct-reseller-edit').selectpicker();
        // $('#country2').select2();
        $('#state').select2({
            placeholder: "Select your province",
        });
        $('#city-reseller').select2({
            placeholder: "Select City",
            ajax: {
                url: '/admin/get-city',
                dataType: 'json',
                type: 'GET',
                data: function (term) {
                    return {
                        term: term,
                        state: $('#state').val(),
                    };
                },
            },
        });
        //field phone just numbers
        $("#phone-reseller").on("keypress keyup blur", function (event) {
            $(this).val($(this).val().replace(/(\d{4})\-?(\d{4})\-?(\d{4})/, '$1-$2-$3'));
        });
        //function to chained city
        $('#state').on('change', function () {
            $('#city-reseller').select2({
                placeholder: "Select City",
                ajax: {
                    url: '/admin/get-city',
                    dataType: 'json',
                    type: 'GET',
                    data: function (term) {
                        return {
                            term: term,
                            state: $('#state').val(),
                        };
                    },
                },
            });
        });

        // edit
        $('#city-reseller-edit').select2({
             placeholder: "Select City",
                ajax: {
                    url: '/admin/get-city-edit',
                    dataType: 'json',
                    type: 'GET',
                    data: function (term) {
                        return {
                            term: term,
                            stateEdit: $('#state-edit').val(),
                        };
                    },
                },
        });

        //function to chained city
        $('#state-edit').select2();
        $('#state-edit').on('change', function () {
            $('#city-reseller-edit').select2({
                placeholder: "Select City",
                ajax: {
                    url: '/admin/get-city-edit',
                    dataType: 'json',
                    type: 'GET',
                    data: function (term) {
                        return {
                            term: term,
                            stateEdit: $('#state-edit').val(),
                        };
                    },
                },
            });
        });

        $('#check_reseller').click(function () {
            input = '#password_reseller';
            icon = '#icon-pass-reseller';
            if ($(input).attr('type') == 'password') {
                $(input).prop('type', 'text');
                $(icon).removeClass('text-secondary')
                $(icon).addClass('text-info');
            } else {
                $(icon).removeClass('text-info');
                $(icon).addClass('text-secondary');
                $(input).prop('type', 'password');
            }
        });

        $('#check3').click(function () {
            input = '#password_confirmation';
            icon = '#icon-pass3';
            if ($(input).attr('type') == 'password') {
                $(input).prop('type', 'text');
                $(icon).removeClass('text-secondary')
                $(icon).addClass('text-info');
            } else {
                $(icon).removeClass('text-info');
                $(icon).addClass('text-secondary');
                $(input).prop('type', 'password');
            }
        });

        //function for check password confirmation
        $("#password_confirmation").on("keyup", function () {
            //Store the password field objects into variables ...
            var password = document.getElementById('password_reseller');
            var confirm = document.getElementById('password_confirmation');
            var message = document.getElementById('confirm-message3');
            //Set the colors we will be using ...
            var good_color = "#66cc66";
            var bad_color = "#ff6666";
            //Compare the values in the password field 
            //and the confirmation field
            if (password.value == confirm.value) {
                //The passwords match. 
                //Set the color to the good color and inform
                //the user that they have entered the correct password 
                confirm.style.borderColor = good_color;
                message.style.color = good_color;
                message.innerHTML = 'Match <i class="fa fa-check"></i>';
            } else {
                //The passwords do not match.
                //Set the color to the bad color and
                //notify the user.
                confirm.style.borderColor = bad_color;
                message.style.color = bad_color;
                message.innerHTML = 'Not Match <i class="fa fa-close"></i>';
            }
        });



    });

</script>
@endpush
