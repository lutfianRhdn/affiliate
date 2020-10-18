<p>Dear <i>{{$user->name}}</i>,</p>
@if($user->approve == 1)

<p>Your account has been approved. </p>
<p><center>{{$user->ref_code}}</center></p>
<p>This is your Referral code and send it to your customer to register with the referral code.</p>

@else

<p>Your account has been disapproved. Because, {{$user->approve_note}}.</p>

@endif

<p></p>
<p>Thank you,</p>