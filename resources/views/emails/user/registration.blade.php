
@component('mail::message', ['test', 'testing'])
    @slot('header')

            {{ 'Airbook' }}

    @endslot

Dear {{$contact->first_name}} {{$contact->last_name}}, please click button below to verify email.

@component('mail::button', ['url' => request()->getHttpHost().'/email-verification?'.$url])
verify now
@endcomponent

Thanks,<br>
{{ 'Airbook, Zulqar Boss' }}
@endcomponent
