@extends('layouts.app', ['activePage' => 'log', 'titlePage' => __('Log Activities')])

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Log Actvities</h4>
                        <p class="card-category"> Log Actvities tabel</p>
                    </div>
                    <div class="card-body">
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
                        <div class="table-responsive">
                            <table class="table" id="table_log">
                                <thead class=" text-primary">
                                    <tr>
                                        <th style="width: 10%">No.</th>
                                        <th style="width: 20%">Time</th>
                                        <th>Subject</th>
                                        <th class="text-right" style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($logs->count())
                                    @foreach ($logs as $key => $log)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{ $log->created_at }}</td>
                                        <td>{{ $log->subject }}</td>
                                        <td class="td-actions text-right">
                                            <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round mr-2"
                                                href="" data-placement="bottom" title="Delete" data-toggle="modal"
                                        data-target="#deleteModal{{$log->id}}">
                                                <i class="material-icons">delete</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                        </td>
                                    </tr>
                                    {{-- modal delete --}}
                                    <div class="modal fade" id="deleteModal{{$log->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="/admin/log/{{$log->id}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete log</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="h5">Are you sure want to permanently remove this log?
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
                                    @endif
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
        $('#table_log').DataTable();
        $('.custom-select').selectpicker();
    });

</script>
@endpush
