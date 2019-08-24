@component('mail::message')
    @if($name)
        dear {{$name}}, <br>
    @endif
    {{$data}}

@if($url)
    @component('mail::button', ['url' => $url])
    View
    @endcomponent
@endif
Thank you,<br> The Airbook Team <br>XBS | Aviation City - Dubai World Central<br>Dubai South, United Arab Emirates <br>https://airbook.aero | support@airbook.aero @endcomponent

