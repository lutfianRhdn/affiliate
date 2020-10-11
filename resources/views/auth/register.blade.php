@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('Affiliate
Program'), 'titlePage' => 'Registration'])

@section('content')
<div class="container" style="height: auto;">
    <div class="row align-items-center">
        <div class="col-lg-5 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action="/register">
                @csrf
                <div class="card card-login card-hidden mb-3">
                    <div class="card-header card-header-primary text-center pb-4 pt-3">
                        <h4 class="card-title"><strong>{{ __('Register') }}</strong></h4>
                    </div>
                    <div class="card-body ">
                        <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }} pl-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-grounp-text">
                                        <i class="material-icons">face</i>
                                    </span>
                                </div>
                                <input type="text" name="name" class="form-control ml-3"
                                    placeholder="{{ __('Full Name') }}" value="{{ old('name') }}" required>
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
                                <input type="email" name="email" class="form-control" placeholder="{{ __('name@example.com') }}"
                                    value="{{ old('email') }}" required>
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
                                    placeholder="{{ __('Phone Number') }}" value="{{ old('phone') }}" required>
                            </div>
                            @if ($errors->has('phone'))
                            <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="bmd-form-group{{ $errors->has('product_id') ? ' has-danger' : '' }} mt-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">content_paste</i>
                                    </span>
                                </div>
                                <select class="selectpicker" data-style="btn btn-primary" name="product_id">
                                    <option disabled selected>Product Category</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{$product->product_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($errors->has('product_id'))
                            <div id="role-error" class="error text-danger pl-3" for="product_id"
                                style="display: block;">
                                <strong>{{ $errors->first('product_id') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="{{ __('Password') }}" required>
                                <small class="text-secondary ml-5 pl-2">Password must be contain 8 character, uppercase
                                    and lowercase letter, number and special character. Ex: Password23!</small>
                            </div>
                            @if ($errors->has('password'))
                            <div id="password-error" class="error text-danger pl-3" for="password"
                                style="display: block;">
                                <span></span>
                            </div>
                            @endif
                        </div>
                        <div
                            class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="{{ __('Confirm Password') }}" required>
                            </div>
                            @if ($errors->has('password_confirmation'))
                            <div id="password_confirmation-error" class="error text-danger pl-3"
                                for="password_confirmation" style="display: block;">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </div>
                            @endif
                        </div>
                        <input type="hidden" name="role" value="2">
                        <div class="form-check text-center mt-4">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="policy" name="policy"
                                    {{ old('policy') ? 'checked' : '' }}>
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                                {{ __('I agree with the ') }} <a href="#" data-toggle="modal"
                                    data-target="#policyModal">{{ __('Privacy Policy') }}</a>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit"
                            class="btn btn-primary btn-link btn-lg">{{ __('Create account') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="policyModal" tabindex="-1" role="dialog" aria-labelledby="policyModalTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="policyModalTitle">Privacy and Policy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="material-icons">
                        close
                    </span>
                </button>
            </div>
            <div class="modal-body text-secondary">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab iusto illum delectus quia possimus
                    provident repudiandae vel expedita ut atque? Cupiditate deserunt, magni minima quo facere magnam
                    quia obcaecati praesentium!
                    Officia dicta incidunt in deserunt eius. Culpa rem ut at, perspiciatis quis facilis doloribus
                    nostrum ducimus iusto, dolore distinctio a corrupti fugiat, reprehenderit quasi totam unde similique
                    aliquam cum doloremque!
                    Inventore eligendi sint blanditiis perferendis delectus! Repudiandae nam labore, autem sapiente
                    officiis accusantium consectetur doloribus aperiam iste dolor sit beatae eligendi! Velit cumque id
                    incidunt inventore nostrum rem architecto officia!</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab iusto illum delectus quia possimus
                    provident repudiandae vel expedita ut atque? Cupiditate deserunt, magni minima quo facere magnam
                    quia obcaecati praesentium!
                    Officia dicta incidunt in deserunt eius. Culpa rem ut at, perspiciatis quis facilis doloribus
                    nostrum ducimus iusto, dolore distinctio a corrupti fugiat, reprehenderit quasi totam unde similique
                    aliquam cum doloremque!
                    Inventore eligendi sint blanditiis perferendis delectus! Repudiandae nam labore, autem sapiente
                    officiis accusantium consectetur doloribus aperiam iste dolor sit beatae eligendi! Velit cumque id
                    incidunt inventore nostrum rem architecto officia!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Agree</button>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Password must be contain 8 character, uppercase and lowercase letter, number and special character. Exp: Password23! --}}
