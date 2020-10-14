@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('Affiliate
Program'), 'titlePage' => 'Registration'])

@section('content')
<div class="container" style="height: auto;">
    <div class="row align-items-center">
        <div class="col-lg-5 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action="/registration">
                @csrf
                <div class="card card-login card-hidden mb-3">
                    <div class="card-header card-header-primary text-center">
                        <h4 class="card-title"><strong>{{ __('Register') }}</strong></h4>
                    </div>
                    <div class="card-body mt-3">
                        <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="name">Name</label>
                            <input type="text" class="form-control pt-3" id="name" placeholder="Full Name" name="name"
                                value="{{ old('name') }}">
                            @if ($errors->has('name'))
                            <div id="name-error" class="error text-danger" for="name" style="display: block;">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group mt-2 {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label for="email">Email Address</label>
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
                            <select class="form-control selectpicker" data-style="btn btn-link" id="country"
                                name="country">
                                <option selected>Indonesia</option>
                            </select>
                            @if ($errors->has('country'))
                            <div id="country-error" class="error text-danger" for="country" style="display: block;">
                                <strong>{{ $errors->first('country') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group mt-2 {{ $errors->has('state') ? ' has-danger' : '' }}">
                            <label for="state">State/Province</label>
                            <select class="form-control selectpicker" data-style="btn btn-link" id="state" name="state">
                                @foreach ($provinces as $prov)
                                <option value="{{$prov->id}}">{{$prov->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('state'))
                            <div id="state-error" class="error text-danger" for="state" style="display: block;">
                                <strong>{{ $errors->first('state') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('city') ? ' has-danger' : '' }}">
                            <label for="city">City</label>
                            <select class="form-control selectpicker" data-style="btn btn-link" id="city" name="city">
                                <option value="">Region/City</option>
                            </select>
                            @if ($errors->has('city'))
                            <div id="city-error" class="error text-danger" for="city" style="display: block;">
                                <strong>{{ $errors->first('city') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group mt-2 {{ $errors->has('address') ? ' has-danger' : '' }}">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" rows="2" value="{{ old('address') }}"
                                placeholder="jl.xxx no xxx"></textarea>
                            @if ($errors->has('address'))
                            <div id="address-error" class="error text-danger" for="address" style="display: block;">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group mt-2 {{ $errors->has('Product_id') ? ' has-danger' : '' }}">
                            <label for="Product_id">Category Product</label>
                            <select class="form-control custom-select" data-style="btn btn-link" id="Product_id"
                                name="Product_id">
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{$product->product_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('Product_id'))
                            <div id="Product_id-error" class="error text-danger" for="Product_id"
                                style="display: block;">
                                <strong>{{ $errors->first('Product_id') }}</strong>
                            </div>
                            @endif
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

@push('js')
<script>
    $(document).ready(function () {
        
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