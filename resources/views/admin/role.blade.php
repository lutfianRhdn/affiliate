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
                    <div class="col-12 text-right">
                        <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModal">Add
                            Role</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th style="width: 10%">ID</th>
                                    <th>Name</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>
                                    <td class="text-right">
                                        <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round" href=""
                                            data-placement="bottom" title="Delete" data-toggle="modal"
                                            data-target="#deleteModal{{$role->id}}">
                                            <i class="material-icons">delete</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round" href=""
                                            data-original-title="" data-placement="bottom" title="Edit"
                                            data-toggle="modal" data-target="#editModal{{$role->id}}">
                                            <i class="material-icons">edit</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                    </td>
                                </tr>

                                {{-- edit modal --}}
                                <div class="modal fade" id="editModal{{$role->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
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
                                                    <div class="bmd-form-group">
                                                        <div class="form-group pl-2 d-flex">
                                                            <div class="form-group w-100">
                                                                <div class="row">
                                                                    {{-- text --}}
                                                                    <div class="col-4">
                                                                        <p>#</p>
                                                                        @foreach ($permissions as $permission)
                                                                        <p class="text-capitalize">{{$permission}}
                                                                            Management</p>
                                                                        @endforeach

                                                                    </div>
                                                                    {{-- view --}}
                                                                    <div class="col-2 m">
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center align-items-center">
                                                                            <p>View</p>
                                                                            @foreach ($permissions as $permission)
                                                                            <input type="checkbox"
                                                                                name="permission-{{$permission}}-view"
                                                                                class="mt-2 mb-3" id="" 
                                                                                @if($role->hasPermissionTo($permission.'.view'))
                                                                            checked
                                                                            @endif>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    {{-- create --}}
                                                                    <div class="col-2">
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center align-items-center">
                                                                            <p>Create</p>
                                                                            @foreach ($permissions as $permission)
                                                                            <input type="checkbox"
                                                                                name="permission-{{$permission}}-create"
                                                                                class="mt-2 mb-3" id="" 
                                                                                @if($role->hasPermissionTo($permission.'.create'))
                                                                            checked
                                                                            @endif
                                                                            >
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    {{-- update --}}
                                                                    <div class="col-2">
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center align-items-center">
                                                                            <p>Update</p>
                                                                            @foreach ($permissions as $permission)
                                                                            <input type="checkbox"
                                                                                name="permission-{{$permission}}-edit"
                                                                                class="mt-2 mb-3" id="" 
                                                                                @if($role->hasPermissionTo($permission.'.edit'))
                                                                            checked
                                                                            @endif>

                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    {{-- delete --}}
                                                                    <div class="col-2">
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center align-items-center">
                                                                            <p>Delete</p>
                                                                            @foreach ($permissions as $permission)
                                                                            <input type="checkbox"
                                                                                name="permission-{{$permission}}-delete"
                                                                                class="mt-2 mb-3" id="" 
                                                                                @if($role->hasPermissionTo($permission.'.delete'))
                                                                            checked
                                                                            @endif
                                                                            >
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

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

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                        <div class="form-group pl-2">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" placeholder="Reseller" name="name"
                                value="{{ old('name') }}">

                        </div>
                        @if ($errors->has('name'))
                        <div id="name-error" class="error text-danger" for="name" style="display: block;">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                        @endif
                        <div class="bmd-form-group">
                            <div class="form-group pl-2 d-flex">
                                <div class="form-group w-100">
                                    <div class="row">
                                        {{-- text --}}
                                        <div class="col-4">
                                            <p>#</p>
                                            @foreach ($permissions as $permission)
                                            <p class="text-capitalize">{{$permission}} Management</p>
                                            @endforeach

                                        </div>
                                        {{-- view --}}
                                        <div class="col-2 m">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <p>View</p>
                                                @foreach ($permissions as $permission)
                                                <input type="checkbox" name="permission-{{$permission}}-view"
                                                    class="mt-2 mb-3" id="" 
                                                    @if($role->hasPermissionTo($permission.'.view'))
                                                checked
                                                @endif>
                                                @endforeach
                                            </div>
                                        </div>
                                        {{-- create --}}
                                        <div class="col-2">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <p>Create</p>
                                                @foreach ($permissions as $permission)
                                                <input type="checkbox" name="permission-{{$permission}}-create"
                                                    class="mt-2 mb-3" id="" 
                                                    @if($role->hasPermissionTo($permission.'.create'))
                                                checked
                                                @endif
                                                >
                                                @endforeach
                                            </div>
                                        </div>
                                        {{-- update --}}
                                        <div class="col-2">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <p>Update</p>
                                                @foreach ($permissions as $permission)
                                                <input type="checkbox" name="permission-{{$permission}}-edit"
                                                    class="mt-2 mb-3" id="" 
                                                    @if($role->hasPermissionTo($permission.'.edit'))
                                                checked
                                                @endif>

                                                @endforeach
                                            </div>
                                        </div>
                                        {{-- delete --}}
                                        <div class="col-2">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <p>Delete</p>
                                                @foreach ($permissions as $permission)
                                                <input type="checkbox" name="permission-{{$permission}}-delete"
                                                    class="mt-2 mb-3" id="" 
                                                    @if($role->hasPermissionTo($permission.'.delete'))
                                                checked
                                                @endif
                                                >
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
        $('.permission-edit').select2()
        $('#permission-create').select2()
        $("#preloaders").fadeOut(1000);
    });

</script>
@endpush
