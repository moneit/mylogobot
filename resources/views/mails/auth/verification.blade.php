@component('mail::message')

<img src="{{ asset('/img/logo-email.png') }}" /><br>
<h1>Hi, {{ $user->name }}</h1>
<h1>In order to start using Logo.Bot, you need to verify your account. Your temporary password is {{ $user->temp_pwd }}, but you can change it in My Account after verification.</h1>

@component('mail::button', ['url' => $url, 'color' => 'green'])
VERIFY YOUR ACCOUNT
@endcomponent

<p>If you did not sign up for this account you can ignore this email and the account will be deleted automatically after 5 days.</p>
<span>Regards,</span><br>Logo Bot
@endcomponent
