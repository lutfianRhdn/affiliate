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
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Time</th>
                                        <th>Subject</th>
                                        <th>User Id</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($logs->count())
                                    @foreach ($logs as $key => $log)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{ $log->created_at }}</td>
                                        <td>{{ $log->subject }}</td>
                                        <td>{{ $log->user_id }}</td>
                                        <td class="td-actions text-right">
                                            <form action="/admin/log/{{$log->id}}" method="POST" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button rel="tooltip"
                                                    class="btn btn-danger btn-fab btn-fab-mini btn-round mr-2"
                                                    data-placement="bottom" title="Erase">
                                                    <i class="material-icons">delete</i>
                                                    <div class="ripple-container"></div>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
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

            }

</script>
@endpush
