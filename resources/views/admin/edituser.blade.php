@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('Edit User')])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="container-fluid bg bg-white rounded pt-3 pb-3">
                <form class="form" method="POST" action="/admin/{{ $user->id }}">
                    @method('patch')
                    @csrf
                    <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">face</i>
                                </span>
                            </div>
                            <input type="text" name="name" class="form-control" placeholder="{{ __('Name...') }}"
                                value="{{$user->name}}" required>
                        </div>
                        @if ($errors->has('name'))
                        <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">email</i>
                                </span>
                            </div>
                            <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}"
                                value="{{$user->email}}" required>
                        </div>
                        @if ($errors->has('email'))
                        <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="bmd-form-group{{ $errors->has('phone') ? ' has-danger' : '' }} mt-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">phone</i>
                                </span>
                            </div>
                            <input type="number" name="phone" class="form-control"
                                placeholder="{{ __('081231923479...') }}" value="{{$user->phone}}" required>
                        </div>
                        @if ($errors->has('phone'))
                        <div id="phone-error" class="error text-danger pl-3" for="phone" style="display: block;">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                        @endif
                    </div>
                    {{-- <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">lock_outline</i>
                            </span>
                        </div>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="{{ __('Password...') }}" value="" required>
                    </div>
                    @if ($errors->has('password'))
                    <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                    @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">lock_outline</i>
                        </span>
                    </div>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        placeholder="{{ __('Confirm Password...') }}" required>
                </div>
                @if ($errors->has('password_confirmation'))
                <div id="password_confirmation-error" class="error text-danger pl-3" for="password_confirmation"
                    style="display: block;">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
                @endif
            </div> --}}
            <div class="bmd-form-group{{ $errors->has('role') ? ' has-danger' : '' }} mt-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">assignment_ind</i>
                        </span>
                    </div>
                    <select class="selectpicker" data-style="btn btn-primary" name="role">
                        <option disabled selected>Role</option>
                        <option value="1" {{$user->role == '1' ? 'selected' : ''}}>Admin</option>
                        <option value="2" {{$user->role == '2' ? 'selected' : ''}}>Reseller</option>
                    </select>
                </div>

                @if ($errors->has('role'))
                <div id="role-error" class="error text-danger pl-3" for="role" style="display: block;">
                    <strong>{{ $errors->first('role') }}</strong>
                </div>
                @endif
            </div>
            <div class="mt-5">
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <a class="btn btn-secondary" href="{{ route('admin.user') }}">Cancel</a>
                        <button type="submit" class="btn btn-primary ml-3">Save</button>
                    </div>
                </div>

            </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
