@extends('layouts.app', ['activePage' => 'reseller', 'titlePage' => __('Reseller Management')])

@section('content')
<div id="preloaders" class="preloader"></div>
<div id="preloaders-approve" class="preloader"></div>
<div id="preloaders-status" class="preloader"></div>
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
                        @can('reseller.create')
                        <div class="col-12 text-right">
                            <a href="" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#createUserModal">Add new Reseller</a>
                        </div>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="table_reseller">
                            <thead class=" text-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Product Category</th>
                                    <th>Refferal Code</th>
                                    <th class="no-sort">Status</th>
                                    <th>Create Date</th>
                                    <th class="text-right no-sort">Actions</th>
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
                                    <td>{{$user->address}}</td>
                                    <td>{{$user->product->product_name}}</td>
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
                                    <td>{{  Carbon\Carbon::parse($user->created_at)->format('d/m/Y')}}</td>
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
                                        @can('reseller.delete')
                                        <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="Delete" data-toggle="modal"
                                            data-target="#deleteModal{{$user->id}}">
                                            <i class="material-icons">delete</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @endcan
                                        @can('reseller.edit')
                                        <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="Edit" data-toggle="modal"
                                            data-target="#editUserModal{{$user->id}}">
                                            <i class="material-icons">edit</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @endcan
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.reseller.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Reseller</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control pt-3" id="name" placeholder="Full Name" name="name"
                            value="{{ old('name') }}">
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
                            class="form-control pt-3" id="phone-reseller" placeholder="08xx-xxxx-xxxxx" name="phone"
                            value="{{ old('phone') }}">
                        @if ($errors->has('phone'))
                        <div id="phone-error" class="error text-danger" for="phone" style="display: block;">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                        @endif
                    </div>
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
                        <select class="form-control custom-select" data-style="btn btn-link" id="prouct-reseller"
                            name="product_id">
                            <option value="" selected disabled>Select Product</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{$product->product_name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('product_id'))
                        <div id="product_id-error" class="error text-danger" for="product_id" style="display: block;">
                            <strong>{{ $errors->first('product_id') }}</strong>
                        </div>
                        @endif
                    </div>
                    <input type="hidden" name="role" value="2">
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
        $('#table_reseller').DataTable({
            // "responsive": true,
            // "scrollX": true,
            columnDefs: [{
                'targets': 4,
                type: 'date-euro'
            }],
            "order": [
                [7, "desc"]
            ],
            "order": [
                [7, "desc"]
            ],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': ['no-sort']
            }]
        });
        $("#preloaders").fadeOut(1000);
        var options = "";
        $('#edit-user').tooltip(options);
        $('#preloaders-status').hide();
        $('#change-status').change(function () {
        $('#preloaders-status').show();
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
                    $("#preloaders-status").fadeOut(1000);
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

        $('#preloaders-approve').hide();
        $('.submitApproved').click(function () {
            $('#preloaders-approve').show();
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
                    // $("#preloaders").fadeOut(1000);
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
    });

</script>
@endpush
