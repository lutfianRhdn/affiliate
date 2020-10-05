@extends('layouts.app', ['activePage' => 'setting', 'titlePage' => __('Settings')])

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Setting</h4>
                        <p class="card-category">Admin Setting default</p>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            @foreach ($setting as $setting)
                            <tr>
                                <td class="h5" style="width: 30%">{{$setting->label}}</td>
                                <td style="width: 10%">:</td>
                                <td class="text-left">{{$setting->value}}</td>
                                <td class="text-right">
                                    <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round"
                                        href="/admin/setting/{{$setting->id}}/edit" data-original-title=""
                                        data-placement="left" title="Edit Settings" id="edit-setting">
                                        <i class="material-icons">edit</i>
                                        <div class="ripple-container"></div>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
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
        $('#edit-setting').tooltip(options);
    }

    });

</script>
@endpush
