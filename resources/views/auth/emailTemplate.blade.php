<p>Dear <i>{{$user->name}}</i>,</p>

<p>Your account has been created. Welcome to the Affiliate program for the
    <strong>{{$product[0]->product_name}}</strong>
    product!</p>
<p>This your referral code <strong>{{$user['ref-code']}}</strong> to share with your customer when do register.</p>

From now on, please log in to your account using your email address and your password.
Please activate your account before login with click this <a href="
    {{ route('konfirmasiemail', ['email' => $user['email'], 'ref_code' => $user['ref-code']]) }}"
    class="text-info">Link</a>.
<p></p>
<p></p>
<p></p>
<p><i>Thankyou</i></p>
