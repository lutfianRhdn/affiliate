@extends('layouts.app', ['activePage' => 'setting', 'titlePage' => __('Settings')])

@section('content')
<div class="content h-100">
    <div class="row h-100 justify-content-center">
        @foreach ($setting as $product_id => $setting_list)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-text card-header-primary">
                    <h4 class="card-title">@foreach ($products as $prod)
                        {{$product_id == $prod->id ? $prod->product_name : ''}}
                        @endforeach</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        @foreach ($setting_list as $setting)
                        <tr>
                            <td class="h5" style="width: 30%">{{$setting->label}}</td>
                            <td style="width: 10%">:</td>
                            <td class="text-center">{{$setting->value}}</td>
                            <td class="text-right">
                                <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round" href=""
                                    data-placement="left" title="Edit Settings" id="edit-setting" data-toggle="modal"
                                    data-target="#editSettingModal{{$setting->id}}">
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                </a>
                            </td>
                        </tr>

                        {{-- edit modal --}}
                        <div class="modal fade" id="editSettingModal{{$setting->id}}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="/admin/setting/{{$setting->id}}" method="POST">
                                        @method('patch')
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Setting</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="bmd-form-group{{ $errors->has('key') ? ' has-danger' : '' }}">
                                                <div class="form-group pl-2">
                                                    <label for="key">Name</label>
                                                    <input type="text" class="form-control" name="key"
                                                        value="{{ $setting->key }}" required>
                                                </div>
                                                @if ($errors->has('key'))
                                                <div id="key-error" class="error text-danger pl-3" for="key"
                                                    style="display: block;">
                                                    <strong>{{ $errors->first('key') }}</strong>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="bmd-form-group{{ $errors->has('label') ? ' has-danger' : '' }}">
                                                <div class="form-group pl-2">
                                                    <label for="label">Label</label>
                                                    <input type="text" class="form-control" name="label"
                                                        value="{{ $setting->label }}" required>
                                                </div>
                                                @if ($errors->has('label'))
                                                <div id="label-error" class="error text-danger pl-3" for="label"
                                                    style="display: block;">
                                                    <strong>{{ $errors->first('label') }}</strong>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="bmd-form-group{{ $errors->has('value') ? ' has-danger' : '' }}">
                                                <div class="form-group pl-2">
                                                    <label for="value">Value</label>
                                                    <input type="text" class="form-control" name="value"
                                                        value="{{ $setting->value }}" required>
                                                </div>
                                                @if ($errors->has('value'))
                                                <div id="value-error" class="error text-danger pl-3" for="value"
                                                    style="display: block;">
                                                    <strong>{{ $errors->first('value') }}</strong>
                                                </div>
                                                @endif
                                            </div>
                                            <div
                                                class="form-group mt-2 {{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                                <label for="product_id">Product Name</label>
                                                <div class="row mx-2">
                                                    <select class="form-control productIdSetting col-12 "
                                                        data-style="btn btn-link" id="product_id_setting"
                                                        name="product_id">
                                                        @foreach ($products as $prd)
                                                        <option value="{{$prd->id}}"
                                                            {{$setting->product_id == $prd->id ? 'selected' : ''}}>
                                                            {{$prd->product_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @if ($errors->has('product_id'))
                                                <div id="product_id-error" class="error text-danger" for="product_id"
                                                    style="display: block;">
                                                    <strong>{{ $errors->first('product_id') }}</strong>
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
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('.productIdSetting').select2();
        // $('#edit-setting').tooltip();
    });

</script>
@endpush
