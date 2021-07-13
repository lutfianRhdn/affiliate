<p>Dear <i>{{$user->name}}</i>,</p>

<p>Your account has been created. Welcome to the Affiliate program for the <strong>{{$user->product_name}}</strong> product!</p>
<p>Here is your account detail : </p>

Full Name : {{$user->name}}<br>
Email : {{$user->email}}<br>
Phone : {{$user->phone}}<br>
Product : {{$user->product_name}}<br>
Address : {{$user->address}}, {{$user->city_name_full}}, {{$user->province_name}}<br>
Password : {{$pass}}<br>

<p>Please click the link below to activate your account.</p>

<p>Thank you,</p>

<p></p>
<p><a href="{{ route('emailConfirmation', ['email' => $user->email, 'ref_code' => $user->ref_code]) }}" class="text-info">Confirm your email</a>.</p>
<p></p>