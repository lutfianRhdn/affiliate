@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('User Management')])

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Users</h4>
                        <p class="card-category"> User management tabels</p>
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
                                <a href="/admin/user/create" class="btn btn-sm btn-primary">Add
                                    user</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Product Type</th>
                                        <th>Role</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->product_id}}</td>
                                        <td>
                                            {{$user->role == '1' ? ' Admin' : 'Reseller'}}
                                            <span
                                                class="ml-2 badge badge-{{$user->register_status == '1' ? 'success' : 'warning'}}">{{$user->register_status == '1' ? 'Activated' : 'Not Activated'}}</span>
                                        </td>
                                        <td class="td-actions text-right">
                                            <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round mr-2"
                                                href="" data-placement="bottom" title="Delete" data-toggle="modal"
                                                data-target="#deleteModal">
                                                <i class="material-icons">delete</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round"
                                                href="/admin/user/{{$user->id}}/edit" data-original-title=""
                                                data-placement="bottom" title="Edit">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                        </td>
                                    </tr>

                                    {{-- modal delete --}}
                                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="/admin/user/{{$user->id}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="h5">Are you sure want to permanently remove this user?
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
        // Javascript method's body can be found in assets/js/demos.js
        md.initDashboardPageCharts();
        $('#edit-user').tooltip(options);
        $('.selectpicker').selectpicker();
    }
    });

</script>
@endpush
