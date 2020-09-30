@component('mail::message')

    Thank you for registering as Request Host ! Please click the link below to complete the member registration

@component('mail::button', ['url' => $verifyUrl])
    Verify
@endcomponent
<br>
<p>If your computer cannot click the button, please copy the URL and paste it into the browser
    <a href="{{ $verifyUrl }}">{{ $verifyUrl }}</a></p>

@endcomponent
