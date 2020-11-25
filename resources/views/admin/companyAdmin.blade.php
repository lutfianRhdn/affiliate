@extends('layouts.app', ['activePage' => 'company', 'titlePage' => __('Company Management')])

@section('content')
<div id="preloaders" class="preloader"></div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Company</h4>
                    <p class="card-category"> Company management tabels</p>
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
                        @can('user.create')
                        <div class="col-12 text-right">
                            <a href="" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#createcompanyModal">Add new Company</a>
                        </div>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="table_reseller">
                            <thead class=" text-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Phone</th>
                                    <th class="no-sort">Status</th>
                                    <th>Create Date</th>
                                    <th class="text-right no-sort">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                <tr>
                                    <td>{{$company->name}}</td>
                                    <td>{{$company->email}} <span
                                        class="ml-2 badge badge-{{$company->register_status == '1' ? 'success' : 'warning'}}">{{$company->is_active == '1' ? 'Activated' : 'Not Activated'}}</span>
                                    </td>
                                    <td>{{$company->company_name}}</td>
                                    <td>{{$company->phone}}</td>
                                    <td>
                                        <div class="togglebutton">
                                            <label id="status">
                                                <input type="checkbox" data-id="{{$company->id}}" id="change-status"
                                                    {{ ($company->is_active == 1) ? 'checked' : ''}}>
                                                <span class="toggle"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{  Carbon\Carbon::parse($company->created_at)->format('d/m/Y')}}</td>
                                    <td class="td-actions text-right">
                                        @if($company->approve == 1)
                                        <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="Approved">
                                            <i class="material-icons">check_circle</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        
                                        @elseif( $company->approve == 0 )
                                        <a rel="tooltip"
                                            class="btn btn-warning btn-fab btn-fab-mini btn-round approvalForm" href=""
                                            data-id="{{$company->id}}" data-placement="bottom" title="Approval"
                                            data-toggle="modal" data-target="#approvalModal{{$company->id}}">
                                            <i class="material-icons">approval</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @endif
                                        @can('user.delete')
                                        <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="Delete" data-toggle="modal"
                                            data-target="#deleteModal{{$company->id}}">
                                            <i class="material-icons">delete</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @endcan
                                        @can('user.edit')
                                        <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="Edit" data-toggle="modal"
                                            data-target="#editcompanyModal{{$company->id}}">
                                            <i class="material-icons">edit</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>

                                {{-- modal approval --}}
                                <div class="modal fade " id="approvalModal{{$company->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="/admin/approval/{{$company->id}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" id="company-id" value="{{$company->id}}">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Approval company</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="h5">Approve this company {{$company->company_name}} ?</p>
                                                    <textarea name="approve_note" class="form-control approve_note"
                                                        id="approve-{{$company->id}}" placeholder="Reason"></textarea>
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
                                <div class="modal fade" id="deleteModal{{$company->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <form action="{{ route('admin.company.destroy',$company->id) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete company</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="h5">Are you sure want to permanently remove
                                                        {{$company->name}}?
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
                                <div class="modal fade" id="editcompanyModal{{$company->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <form action="{{ route('admin.company.update',$company->id) }}" method="POST">
                                                @method('patch')
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Company
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
                                                            value="{{ $company->name }}">
                                                        @if ($errors->has('name'))
                                                        <div id="name-error" class="error text-danger" for="name"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                                                        <label for="email">Email <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control pt-3" id="email"
                                                            placeholder="Full email" name="email"
                                                            value="{{ $company->email }}">
                                                        @if ($errors->has('email'))
                                                        <div id="email-error" class="error text-danger" for="email"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="form-group {{ $errors->has('company') ? ' has-danger' : '' }}">
                                                        <label for="company">Company <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control pt-3" id="company"
                                                            placeholder="Company Name" name="company"
                                                            value="{{ $company->company_name }}">
                                                        @if ($errors->has('company'))
                                                        <div id="name-error" class="error text-danger" for="name"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('company') }}</strong>
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
                                                            value="{{ $company->phone }}">
                                                        @if ($errors->has('phone'))
                                                        <div id="phone-error" class="error text-danger" for="phone"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('phone') }}</strong>
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
<div class="modal fade createcompanyModal-modal-lg" id="createcompanyModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.company.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Company</h5>
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
                    <div class="form-group {{ $errors->has('company') ? ' has-danger' : '' }}">
                        <label for="company">Company <span class="text-danger">*</span></label>
                        <input type="text" class="form-control pt-3" id="company" placeholder="Company name" name="company"
                            value="{{ old('company') }}">
                        @if ($errors->has('company'))
                        <div id="company-error" class="error text-danger" for="company" style="display: block;">
                            <strong>{{ $errors->first('company') }}</strong>
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
        $(".preloader").fadeOut(1000);

        $('#table_reseller').DataTable();
        var options = "";
        $('#edit-company').tooltip(options);

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
                url: '{{route("approveCompany")}}',
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
                error: function (status) {
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
