@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('Affiliate
Program'), 'titlePage' => 'Registration'])

@section('content')
<div class="container" style="height: auto;">
    <div class="row align-items-center">
        <div class="col-lg-9 col-md-8 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="card card-login card-hidden">
                    <div class="card-header card-header-primary text-center pb-4 pt-4">
                        <h4 class="card-title"><strong>{{ __('Register') }}</strong></h4>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control pt-3" id="name" placeholder="Full Name"
                                        name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                    <div id="name-error" class="error text-danger" for="name" style="display: block;">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group mt-2 {{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label for="email">Email Address</label>
                                    <input type="text" class="form-control pt-3" id="email"
                                        placeholder="email@example.com" name="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                    <div id="email-error" class="error text-danger" for="email" style="display: block;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group mt-2 {{ $errors->has('phone') ? ' has-danger' : '' }}">
                                    <label for="phone">Phone Number</label>
                                    <input type="number" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                        class="form-control pt-3" id="phone" placeholder="081xxx" name="phone"
                                        value="{{ old('phone') }}">
                                    @if ($errors->has('phone'))
                                    <div id="phone-error" class="error text-danger" for="phone" style="display: block;">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group mt-2 {{ $errors->has('country') ? ' has-danger' : '' }}">
                                    <label for="country">Country</label>
                                    <select class="form-control" data-style="btn btn-link" id="country" name="country">
                                        <option selected value="Indonesia">Indonesia</option>
                                    </select>
                                    @if ($errors->has('country'))
                                    <div id="country-error" class="error text-danger" for="country"
                                        style="display: block;">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div class="row ml-1">
                                <div class="col-6" style="margin-left: -1rem">
                                    <div class="form-group mt-2 {{ $errors->has('state') ? ' has-danger' : '' }}">
                                        <label for="state">State/Province</label>
                                        <select class="form-control" data-style="btn btn-link" id="province" name="state">
                                            <option value="" selected disabled>Select your province</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{$province->province_id}}">{{$province->province_name}}</option> 
                                            @endforeach
                                        </select>
                                        @if ($errors->has('state'))
                                        <div id="state-error" class="error text-danger" for="state"
                                            style="display: block;">
                                            <strong>{{ $errors->first('state') }}</strong>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group {{ $errors->has('city') ? ' has-danger' : '' }}">
                                        <label for="city">City</label>
                                        <select class="form-control" data-style="btn btn-link" id="city" name="city">
                                            <option value="" selected disabled>Select your city</option>
                                        </select>
                                        @if ($errors->has('city'))
                                        <div id="city-error" class="error text-danger" for="city"
                                            style="display: block;">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mt-2 {{ $errors->has('address') ? ' has-danger' : '' }}">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" rows="2" value="{{ old('address') }}"
                                        placeholder="jl.xxx no xxx" name="address"></textarea>
                                    @if ($errors->has('address'))
                                    <div id="address-error" class="error text-danger" for="address"
                                        style="display: block;">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group mt-2 {{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label for="product_id">Category Product</label>
                                    <select class="form-control custom-select" data-style="btn btn-link" id="product_id"
                                        name="product_id">
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
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control pt-3" id="password"
                                        placeholder="Password123!" name="password">
                                <span class="form-check-sign" id="check">
                                    <i class="fa fa-eye text-secondary" aria-hidden="true" id="icon-pass"></i>
                                </span>
                                    @if ($errors->has('password'))
                                    <div id="password-error" class="error text-danger" for="password"
                                        style="display: block;">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div
                                    class="form-group mt-3 {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                    <label for="password">Password Confirmation</label>
                                    <input type="password" class="form-control pt-3" id="password_confirmation"
                                        placeholder="Password123!" name="password_confirmation">
                                        <span id="check2"><i class="fa fa-eye text-secondary" aria-hidden="true" id="icon-pass2"></i></span>
                                        <span id="confirm-message2" class="confirm-message"></span>
                                    @if ($errors->has('password_confirmation'))
                                    <div id="password-error" class="error text-danger" for="password_confirmation"
                                        style="display: block;">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </div>
                                    @endif
                                </div>

                                <input type="hidden" name="role" value="2">
                            </div>

                            <div class="form-check mt-4 ml-auto mr-auto">
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
                <button type="button" class="btn btn-primary">Agree</button>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Password must be contain 8 character, uppercase and lowercase letter, number and special character. Exp: Password23! --}}

@push('js')
<script>
    $(document).ready(function () {
        
        $('#country').select2();
        $('#city').select2();
        $('#province').select2();
        //field phone just numbers
        $("#phone").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if (event.which > 31 && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });


        //function to chained city
        $('#province').on('change',function(){
            $('#city').select2({
                placeholder: "Select City",
                ajax: {
                    url: '/registration/get-city',
                    dataType: 'json',
                    type : 'GET',
                    data: {
                        province: $('#province').val()
                    },
                },
            });
        })
        
        $('#check').click(function () {
            if ('password' == $('#password').attr('type')) {
                $('#password').prop('type', 'text');
                $('#icon-pass').removeClass("fa fa-eye");
                $('#icon-pass').addClass("fa fa-eye-slash");
            } else {
                $('#password').prop('type', 'password');
                $('#icon-pass').removeClass("fa fa-eye-slash");
                $('#icon-pass').addClass("fa fa-eye");
            }
        });
        
        $('#check2').click(function () {
            if ('password' == $('#password_confirmation').attr('type')) {
                $('#password_confirmation').prop('type', 'text');
                $('#icon-pass2').removeClass("fa fa-eye");
                $('#icon-pass2').addClass("fa fa-eye-slash");
            } else {
                $('#password_confirmation').prop('type', 'password');
                $('#icon-pass2').removeClass("fa fa-eye-slash");
                $('#icon-pass2').addClass("fa fa-eye");
            }
        });

        //function for check password confirmation
        $("#password_confirmation").on("keyup", function(){
            //Store the password field objects into variables ...
            var password = document.getElementById('password');
            var confirm  = document.getElementById('password_confirmation');
            var message = document.getElementById('confirm-message2');
            //Set the colors we will be using ...
            var good_color = "#66cc66";
            var bad_color  = "#ff6666";
            //Compare the values in the password field 
            //and the confirmation field
            if(password.value == confirm.value){
                //The passwords match. 
                //Set the color to the good color and inform
                //the user that they have entered the correct password 
                confirm.style.borderColor   = good_color;
                message.style.color         = good_color;
                message.innerHTML           = 'Match <i class="fa fa-check"></i>';
            }else{
                //The passwords do not match.
                //Set the color to the bad color and
                //notify the user.
                confirm.style.borderColor   = bad_color;
                message.style.color         = bad_color;
                message.innerHTML           = 'Not Match <i class="fa fa-close"></i>';
            }
        });
    });

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
