@extends('layouts.app', ['activePage' => 'setting', 'titlePage' => __('Settings')])

@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Setting</h4>
                        <p class="card-category">Admin Setting Edit</p>
                    </div>
                    <div class="card-body">
                        <form class="form" method="POST" action="/admin/setting/{{$setting->id}}">
                            @method('patch')
                            @csrf
                            <div class="bmd-form-group{{ $errors->has('key') ? ' has-danger' : '' }}">
                                <div class="form-group pl-2">
                                    <label for="key">Key</label>
                                    <input type="text" class="form-control" name="key" value="{{ $setting->key }}"
                                        required>
                                </div>
                                @if ($errors->has('key'))
                                <div id="key-error" class="error text-danger pl-3" for="key" style="display: block;">
                                    <strong>{{ $errors->first('key') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('label') ? ' has-danger' : '' }}">
                                <div class="form-group pl-2">
                                    <label for="label">Label</label>
                                    <input type="text" class="form-control" name="label" value="{{ $setting->label }}"
                                        required>
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
                                    <input type="text" class="form-control" name="value" value="{{ $setting->value }}"
                                        required>
                                </div>
                                @if ($errors->has('value'))
                                <div id="value-error" class="error text-danger pl-3" for="value"
                                    style="display: block;">
                                    <strong>{{ $errors->first('value') }}</strong>
                                </div>
                                @endif
                            </div>
                            <div class="mt-5 text-right">
                                <a class="btn btn-secondary d-inline" href="/admin/setting">Cancel</a>
                                <button type="submit" class="btn btn-primary ml-2">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
