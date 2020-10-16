<p>Dear <i>{{$user->name}}</i>,</p>

<p>Your account has been created. Welcome to the Affiliate program for the <strong>{{$user->product_name}}</strong> product!</p>
<p>Here is your account detail : </p>

Full Name : {{$user->name}}
Email : {{$user->email}}
Phone : {{$user->phone}}
Product : {{$user->product_name}}
Address : {{$user->address}}, {{$user->city_name_full}}, {{$user->province_name}}
Password : {{$pass}}

Please click the link below to activate your account.

Thank you,

<p></p>
<p><a href="{{ route('emailConfirmation', ['email' => $user->email, 'ref_code' => $user->ref_code]) }}"
    class="text-info">Link</a>.</p>
<p></p>
<p></p>
