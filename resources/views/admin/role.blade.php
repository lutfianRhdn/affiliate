@extends('layouts.app', ['activePage' => 'role', 'titlePage' => __('Role Management')])

@section('content')
<div id="preloaders" class="preloader"></div>
<div class="content">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Role Management</h4>
                </div>
                <div class="card-body">
                    @can('role.create')
                    <div class="col-12 text-right">
                        <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModal">Add
                            Role</a>
                    </div>
                    @endcan
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th style="width: 10%">ID</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->company->name}}</td>
                                    @can('role.delete')
                                    <td class="text-right">
                                        <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="Delete" data-toggle="modal"
                                            data-target="#deleteModal{{$role->id}}">
                                            <i class="material-icons">delete</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @endcan
                                        @can('role.edit')
                                        <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round" href=""
                                            data-original-title="" data-placement="bottom" title="Edit"
                                            data-toggle="modal" data-target="#editModal{{$role->id}}">
                                            <i class="material-icons">edit</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>

                                {{-- edit modal --}}
                                <div class="modal fade bd-example-modal-lg" id="editModal{{$role->id}}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content mx-auto">
                                            <form action="{{route('admin.role.update',[$role->id])}}" method="POST">
                                                @method('patch')
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div
                                                        class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                        <div class="form-group pl-2 d-flex">
                                                            <label for="name " class="w-100">Role Name</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Reseller" name="name"
                                                                value="{{ $role->name }}">
                                                        </div>
                                                        @if ($errors->has('name'))
                                                        <div id="name-error" class="error text-danger" for="name"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @include('pages.role_management_table',$roleNames )
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
                                <div class="modal fade" id="deleteModal{{$role->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{route('admin.role.destroy',$role->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Role</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="h5">Are you sure want to permanently remove this role?
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
<div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.role.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <div class="form-group pl-2 d-flex align-items-center">
                            <label for="name" class="w-25">Role Name</label>
                            <input type="text" class="form-control" placeholder="Reseller" name="name"
                                value="{{ old('name') }}">

                        </div>
                        @if ($errors->has('name'))
                        <div id="name-error" class="error text-danger" for="name" style="display: block;">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                        @endif
                        @role('super-admin')
                        <div class="form-group pl-2 d-flex align-items-center">
                            <label for="company" class="w-25">Company Name</label>
                            <select class="form-control custom-select-2" style="width: 100%" placeholder="Reseller"
                                name="company">
                                <option value="" selected disabled> Select Company</option>
                                @foreach ($companies as $company)
                                <option value="{{ $company->id }}"> {{$company->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endrole
                        @include('pages.role_management_table',$roleNames)
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
        $('.permission-edit').select2();
        $('#permission-create').select2();
        $('.custom-select-2').select2();
        $("#preloaders").fadeOut(1000);
        // if user management view is checked
        $('input[name=user-management-view]').on('click', () => {
            const company = $('input[name=permission-company-view')
            const admin = $('input[name=permission-admin-view')
            const reseller = $('input[name=permission-reseller-view')

            if (company.prop('checked') == true) {
                company.prop('checked', false)
            } else {
                company.prop('checked', true)
            }
            if (admin.prop('checked') == true) {
                admin.prop('checked', false)
            } else {
                admin.prop('checked', true)
            }
            if (reseller.prop('checked') == true) {
                reseller.prop('checked', false)
            } else {
                reseller.prop('checked', true)
            }
        })
        // if user management create is checked
        $('input[name=user-management-create]').on('click', () => {
            const company = $('input[name=permission-company-create')
            const admin = $('input[name=permission-admin-create')
            const reseller = $('input[name=permission-reseller-create')

            if (company.prop('checked') == true && $(this).prop('checked') === true) {
                company.prop('checked', false)
            } else {
                company.prop('checked', true)
            }
            if (admin.prop('checked') == true && $(this).prop('checked') === true) {
                admin.prop('checked', false)
            } else {
                admin.prop('checked', true)
            }
            if (reseller.prop('checked') == true && $(this).prop('checked') === true) {
                reseller.prop('checked', false)
            } else {
                reseller.prop('checked', true)
            }
        })
        // if user management edit is checked
        $('input[name=user-management-edit]').on('click', () => {
            const company = $('input[name=permission-company-edit')
            const admin = $('input[name=permission-admin-edit')
            const reseller = $('input[name=permission-reseller-edit')

            if (company.prop('checked') == true) {
                company.prop('checked', false)
            } else {
                company.prop('checked', true)
            }
            if (admin.prop('checked') == true) {
                admin.prop('checked', false)
            } else {
                admin.prop('checked', true)
            }
            if (reseller.prop('checked') == true) {
                reseller.prop('checked', false)
            } else {
                reseller.prop('checked', true)
            }
        })
        // if user management delete is checked
        $('input[name=user-management-delete]').on('click', () => {
            const company = $('input[name=permission-company-delete')
            const admin = $('input[name=permission-admin-delete')
            const reseller = $('input[name=permission-reseller-delete')

            if (company.prop('checked') == true) {
                company.prop('checked', false)
            } else {
                company.prop('checked', true)
            }
            if (admin.prop('checked') == true) {
                admin.prop('checked', false)
            } else {
                admin.prop('checked', true)
            }
            if (reseller.prop('checked') == true) {
                reseller.prop('checked', false)
            } else {
                reseller.prop('checked', true)
            }
        })

    });

</script>
@endpush
