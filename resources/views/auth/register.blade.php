@extends('layouts.BaseApp', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('Affiliate
Program'), 'titlePage' => 'Registration'])

@section('content')
<div class="container" style="height: auto;">
    <div class="row align-items-center">
        <div class="col-lg-6 col-sm-12 ml-auto mr-auto">
            <form class="form" method="POST" action="{{ route('register') }}" id="register-form"
                onsubmit="return checkForm(this);">
                @csrf
                <div class="card card-login card-hidden">
                    <div class="card-header card-header-primary text-center pb-4 pt-4">
                        <h4 class="card-title"><strong>{{ __('Register') }}</strong></h4>
                    </div>
                    <div class="card-body mt-3">
                        <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control pt-3" id="name" placeholder="Full Name" name="name"
                                value="{{ old('name') }}">
                            @if ($errors->has('name'))
                            <div id="name-error" class="error text-danger" for="name" style="display: block;">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group mt-2 {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control pt-3" id="email" placeholder="email@example.com"
                                name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                            <div id="email-error" class="error text-danger" for="email" style="display: block;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group mt-2 {{ $errors->has('phone') ? ' has-danger' : '' }}">
                            <label for="phone">Phone Number</label>
                            <input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                class="form-control pt-3" id="phone" placeholder="08xx-xxxx-xxxxx" name="phone"
                                value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                            <div id="phone-error" class="error text-danger" for="phone" style="display: block;">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group mt-2 {{ $errors->has('address') ? ' has-danger' : '' }}">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" rows="2" placeholder="Your Address"
                                name="address">{{ old('address') }}</textarea>
                            @if ($errors->has('address'))
                            <div id="address-error" class="error text-danger" for="address" style="display: block;">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group mt-2 {{ $errors->has('product_id') ? ' has-danger' : '' }}">
                            <label for="product_id">Category Product <span class="text-danger">*</span></label>
                            <select class="form-control custom-select" data-style="btn btn-link" id="product_id"
                                name="product_id">
                                <option value="" selected disabled>Select Product</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{$product->product_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('product_id'))
                            <div id="product_id-error" class="error text-danger" for="product_id"
                                style="display: block;">
                                <strong>{{ $errors->first('product_id') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group mt-2 {{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control pt-3" id="password" placeholder="Your Password"
                                name="password">
                            <span class="form-check-sign-register" id="check">
                                <i class="material-icons password-icon text-secondary" aria-hidden="true"
                                    id="icon-pass">remove_red_eye</i>
                            </span>
                            <small class="text-danger" id="hint">Password must be contain 8 character, uppercase
                                and lowercase letter, number and special character. Ex: Password23!</small>
                            @if ($errors->has('password'))
                            <div id="password-error" class="error text-danger" for="password" style="display: block;">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group mt-3 {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                            <label for="password">Password Confirmation <span class="text-danger">*</span></label>
                            <input type="password" class="form-control pt-3" id="password_confirmation"
                                placeholder="Re Password" name="password_confirmation">
                            <span class="form-check-sign-register" id="check2">
                                <i class="material-icons password-icon text-secondary" aria-hidden="true"
                                    id="icon-pass2">remove_red_eye</i>
                            </span>
                            <span id="confirm-message2" class="confirm-message"></span>
                            @if ($errors->has('password_confirmation'))
                            <div id="password-error" class="error text-danger" for="password_confirmation"
                                style="display: block;">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </div>
                            @endif
                        </div>

                        <input type="hidden" name="role" value="2">

                        <div class="form-check mt-4 justify-content-center {{ $errors->has('policy') ? ' has-danger' : '' }}">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="policy" name="policy"
                                    {{ old('policy') ? 'checked' : '' }}>
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                                {{ __('I agree with the ') }}
                            </label>
                            <a href="#" data-toggle="modal" data-target="#policyModal">{{ __('Privacy Policy') }}</a>
                            @if ($errors->has('policy'))
                            <div id="policy-error" class="error text-danger ml-4" for="policy" style="display: block;">
                                <strong>Provacy Policy is required</strong>
                            </div>
                            @endif
                        </div>
                    </div>
                <div class="card-footer justify-content-center">
                    <button type="submit" class="btn btn-primary btn-link btn-lg">Create account</button>
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
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Password must be contain 8 character, uppercase and lowercase letter, number and special character. Exp: Password23! --}}

@push('js')
<script>
    $(document).ready(function () {
        $("#hint").hide();
        $("#agree-required").hide();
        $("#password").focus(function () {
            $("#hint").show();
        });
        $("#password").blur(function () {
            $("#hint").hide();
        });
        $('#product_id').selectpicker();
        $('#country').select2();
        $('#province').select2();
        $('#city').select2({
            placeholder: "Select City",
            ajax: {
                url: '/registration/get-city',
                dataType: 'json',
                type: 'GET',
                data: function (term) {
                    return {
                        term: term,
                        province: $('#province').val(),
                    };
                },
            },
        });
        //field phone just numbers
        $("#phone").on("keypress keyup blur", function (event) {
            $(this).val($(this).val().replace(/(\d{4})\-?(\d{4})\-?(\d{4})/, '$1-$2-$3'));
        });


        //function to chained city
        $('#province').on('change', function () {
            $('#city').select2({
                placeholder: "Select City",
                ajax: {
                    url: '/registration/get-city',
                    dataType: 'json',
                    type: 'GET',
                    data: function (term) {
                        return {
                            term: term,
                            province: $('#province').val(),
                        };
                    },
                },
            });
        })

        $('#check').click(function () {
            input = '#password';
            icon = '#icon-pass';
            if ($(input).attr('type') == 'password') {
                $(input).prop('type', 'text');
                $(icon).removeClass('text-secondary')
                $(icon).addClass('text-info');
            } else {
                $(icon).removeClass('text-info');
                $(icon).addClass('text-secondary');
                $(input).prop('type', 'password');
            }
        });
        $('#check2').click(function () {
            input = '#password_confirmation';
            icon = '#icon-pass2';
            if ($(input).attr('type') == 'password') {
                $(input).prop('type', 'text');
                $(icon).removeClass('text-secondary')
                $(icon).addClass('text-info');
            } else {
                $(icon).removeClass('text-info');
                $(icon).addClass('text-secondary');
                $(input).prop('type', 'password');
            }
        });

        //function for check password confirmation
        $("#password_confirmation").on("keyup", function () {
            //Store the password field objects into variables ...
            var password = document.getElementById('password');
            var confirm = document.getElementById('password_confirmation');
            var message = document.getElementById('confirm-message2');
            //Set the colors we will be using ...
            var good_color = "#66cc66";
            var bad_color = "#ff6666";
            //Compare the values in the password field 
            //and the confirmation field
            if (password.value == confirm.value) {
                //The passwords match. 
                //Set the color to the good color and inform
                //the user that they have entered the correct password 
                confirm.style.borderColor = good_color;
                message.style.color = good_color;
                message.innerHTML = 'Match <i class="fa fa-check"></i>';
            } else {
                //The passwords do not match.
                //Set the color to the bad color and
                //notify the user.
                confirm.style.borderColor = bad_color;
                message.style.color = bad_color;
                message.innerHTML = 'Not Match <i class="fa fa-close"></i>';
            }
        });
    });

    function checkForm(form) {
        if (!form.policy.checked) {
            $("#policy-error").show();
            form.policy.focus();
            return false;
        }
        return true;
    }

</script>
@endpush

{{-- 
$('#state').on('change', function () {
             axios.post('{{ route('registrations.store') }}', {id: $(this).val()})
.then(function (response) {
$('#city').empty();

$.each(response.data, function (id, name) {
$('#city').append(new Option(name, id))
})
});
});
--}}
