@component('mail::message')
# Verify Your Email
<div class="w-100">
Code below to reset your password.<br>
</div>

{{$code}}

<div class="w-100">
If you did not operating this, please contact us at support@relaxx.me

Thanks,<br>
{{ config('app.name') }}
@endcomponent
</div>