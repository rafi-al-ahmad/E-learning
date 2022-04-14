@component('mail::message')

{{ config('app.name') }} | {{trans('app.mail.closed-account-title')}}


{{trans('app.mail.closed-account-message')}}



<br>
@endcomponent
