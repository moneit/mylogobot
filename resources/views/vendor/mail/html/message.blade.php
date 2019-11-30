@component('mail::layout')

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
<p style="margin-bottom:0;">This email was sent to you as a registered member of logo.bot.</p>
<span>Use of the service and website is subject to our </span><a href="{{ route('terms_of_service') }}">Terms of Use</a><span> and </span><a href="{{ route('privacy_policy') }}">Privacy Statement.</a>
<p>© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')</p>
        @endcomponent
    @endslot
@endcomponent
