@component('mail::message')
# Verify Your Email

Code below to verify your account.

{{--  @component('mail::button', ['url' => url('api/auth/verify-email?token='.$code)])
    Verify
@endcomponent  --}}
@endcomponent

{{$code}}

{{--  If you can't open link on the button. Please connect to below link 
<div class="w-100">
    <a href="{{ url('api/auth/verify-email?token='.$code) }}" target="_blank">{{ url('api/auth/verify-email?token='.$code) }}</a>
</div>  --}}
@component('mail::message')
If you did not operating this, please contact us at support@relaxx.me

Thanks,<br>
{{ config('app.name') }}
@endcomponent