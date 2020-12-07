@extends('layouts.app', ['activePage' => 'setting', 'titlePage' => __('Settings')])

@section('content')
<div class="content h-100">
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Settings</h4>
            <p class="category">Setting Tables</p>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>

                    <tr class="text-primary">
                        <th class="text-center">#</th>
                        <th class="text-center">Products</th>
                        <th class="text-center">Persentage</th>
                        <th class="text-center">Day of Settelment</th>
                        @can('setting.edit' )

                        <th class="text-center">Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                @foreach ($settings as $productId=> $setting)

                    <tr>
                        <td>{{$loop->index+1}}</td>
                        @php
                            $productName =\App\Models\Product::find($productId)->product_name;
                        @endphp
                        <td class="text-center">{{ $productName }}</td>
                        @foreach ($setting as $settingLabel)
                        <td class="text-center">{{$settingLabel->value}}</td>
                        @endforeach
                        @can('setting.edit' )
                            
                        <td class="td-actions text-center">
                            
                            <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-target="#EditModal-{{$loop->index}}">
                                <i class="material-icons">edit</i>
                            </button>
                        </td>
                        @endcan
                    </tr>

                    {{-- edit Modal --}}
                    <div class="modal fade" id="EditModal-{{$loop->index}}" tabindex="-1" role="dialog" aria-labelledby="EditModal-{{$loop->index}}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="EditModal-{{$loop->index}}Label">Edit Setting {{$productName}}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="{{route('admin.setting.update',$productId)}}" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="modal-body">
                                    @foreach ($setting as $settingLabel)

                                    <div class="bmd-form-group{{ $errors->has($settingLabel->key) ? ' has-danger' : '' }}">
                                        <div class="form-group pl-2">
                                            <label for="Persentage">{{$settingLabel->label}}</label>
                                            <input type="text" class="form-control" name="{{$settingLabel->key}}"
                                                value="{{ $settingLabel->value }}" required>
                                        </div>
                                        @if ($errors->has($settingLabel->key))
                                        <div id="key-error" class="error text-danger pl-3" for="key"
                                            style="display: block;">
                                            <strong>{{ $errors->first($settingLabel->key) }}</strong>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                @endforeach

                </tbody>
            </table>
              {{-- The place is close to Barceloneta Beach and bus stop just 2 min by walk and near to "Naviglio" where you can enjoy the main night life in Barcelona... --}}
        </div>
    </div>
</div>
@endsection
{{-- <div class="modal fade" id="editSettingModal{{$setting->id}}" tabindex="-1" role="dialog"
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
</div> --}}
@push('js')
<script>
    $(document).ready(function () {
        $('.table').DataTable()
        $('.productIdSetting').select2();
        // $('#edit-setting').tooltip();
    });

</script>
@endpush
