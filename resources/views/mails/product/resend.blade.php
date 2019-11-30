@component('mail::message')

<img src="{{ asset('/img/logo-email.png') }}" />
<br>

<h1>Hi, {{ $user->name }}</h1>

<h1>You requested to resend you the files of your logo, and here it is! Just click on the button bellow to download it.</h1>

@component('mail::button', ['url' => $url, 'color' => 'green'])
    DOWNLOAD LOGO PACKAGE
@endcomponent

This link is available today.

Regards,<br>Logo Bot
@endcomponent
