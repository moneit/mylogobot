@component('mail::message')

<img src="{{ asset('/img/logo-email.png') }}" />
<br>

<h1>Hi, {{ $user->name }}</h1>

<h1>Thank you for purchasing from Logo.Bot!</h1>

<h1>Here are your logo files, just click on the button below to download it.</h1>

@component('mail::button', ['url' => $url, 'color' => 'green'])
    DOWNLOAD LOGO PACKAGE
@endcomponent

This link is available today.

Regards,<br>Logo Bot
@endcomponent
