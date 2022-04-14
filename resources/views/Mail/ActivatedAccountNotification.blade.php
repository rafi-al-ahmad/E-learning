@component('mail::message')

{{ config('app.name') }} | {{trans('app.mail.activate-account-title')}}


{{trans('app.mail.activate-account-message')}}



<br>
@endcomponent
