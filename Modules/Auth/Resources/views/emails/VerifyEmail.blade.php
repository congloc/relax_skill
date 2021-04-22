@component('mail::message')
# Verify Your Email

Please click the button below to verify your email address.

@component('mail::button', ['url' => url('api/auth/verify-email?token='.$code)])
    Verify
@endcomponent

If you can't open link on the button. Please connect to below link 
<div class="w-100">
    <a href="{{ url('api/auth/verify-email?token='.$code) }}" target="_blank">{{ url('api/auth/verify-email?token='.$code) }}</a>
</div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent