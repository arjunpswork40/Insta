@component('mail::message')
# Welcome to Insta..

This is a machine test.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
