@component('mail::message')
Dear {{$name}},<br>

{{$content}}

@component('mail::button', ['url' => url($url)])
    View
@endcomponent

<br>
Thank you,<br> The Airbook Team <br>XBS | Aviation City - Dubai World Central<br>Dubai South, United Arab Emirates <br>https://airbook.aero | support@airbook.aero
@endcomponent
