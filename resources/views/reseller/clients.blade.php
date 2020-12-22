@extends('layouts.app', ['activePage' => 'client', 'titlePage' => __('Client Management')])

@section('content')
<div id="preloaders" class="preloader"></div>
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Clients</h4>
                <p class="category">Clients Management</p>
            </div>
            <div class="card-body">
                @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{Session::get('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{Session::get('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if (Cookie::get('reseller'))
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-success " data-toggle="modal" data-target="#modalCreate">
                        Add Client
                    </button>
                </div>
                @endif
                <table class="table">
                    <thead>
                        <tr class="text-primary">
                            <th>#</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Unique Id</th>
                            <th>desc</th>
                            @if (Cookie::get('reseller'))                                
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)

                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$client->name}}</td>
                            <td>{{$client->company}}</td>
                            <td>{{$client->unic_code}}</td>
                            <td>{{ $client->description }} </td>
                            @if (Cookie::get('reseller'))
                            <td>
                                    <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round" href=""
                                        
                                    @if ($client->transactions->count() != 0)
                                    style="pointer-events:none; background:gray"
                                    @endif
                                    data-placement="bottom" title="Delete"data-toggle="modal"
                                    data-target="#modalDelete-{{$loop->index+1}}">
                                    <i class="material-icons">delete</i>
                                    <div class="ripple-container"></div>
                                    </a>
                                    <a rel="tooltip" class="btn btn-warning btn-fab btn-fab-mini btn-round" href=""
                                    
                                    data-placement="bottom" title="Delete"data-toggle="modal"
                                    data-target="#modalEdit-{{$loop->index+1}}">
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                </a>
                            </td>
                            @endif
                           
                        </tr>
                        <!-- Modal delete -->
                        <div class="modal fade" id="modalDelete-{{$loop->index+1}}" tabindex="-1" role="dialog"
                            aria-labelledby="modalDeleteLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalDeleteLabel">Modal Delete</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('reseller.client.destroy',$client->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
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
                        <!-- Modal edit -->
                        <div class="modal fade" id="modalEdit-{{$loop->index+1}}" tabindex="-1" role="dialog"
                            aria-labelledby="modalEditLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditLabel">Modal Edit {{ $client->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('reseller.client.update',$client->id)}}" method="post">
                                        @method('PUT')
                                        @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="Name">Name</label>
                                            <input type="text" class="form-control" id="Name" name="name" placeholder="" value="{{$client->name}}">
                                          </div>
                                        <div class="form-group">
                                            <label for="Company">Company</label>
                                            <input type="text" class="form-control" id="Company" name="company" placeholder="" value="{{$client->company}}">
                                          </div>
                                        <div class="form-group">
                                            <label for="uniqueCode">Unique Code</label>
                                            <input type="text" class="form-control" id="uniqueCode" name="unic_code" placeholder="" value="{{$client->unic_code }}">
                                          </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-warning">Update</button>
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

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCreateLabel">Modal Create</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('reseller.client.store')}}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="Name">Name</label>
                    <input type="text" class="form-control" id="Name" name="name" placeholder="Enter Client Name..." value="{{ old('name')}}">
                  </div>
                <div class="form-group">
                    <label for="Company">Company</label>
                    <input type="text" class="form-control" id="Company" name="company" placeholder="Enter Client Company..." value="{{old('company')}}">
                  </div>
                <div class="form-group">
                    <label for="uniqueCode">Unique Code</label>
                    <input type="text" class="form-control" id="uniqueCode" name="unic_code" placeholder="Enter Client Unique code" value="{{old('unic_code') }}">
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
    // Javascript method's body can be found in assets/js/demos.js
    $('.table').DataTable();
    $("#preloaders").fadeOut(1000);
    md.initDashboardPageCharts();

</script>
@endpush
