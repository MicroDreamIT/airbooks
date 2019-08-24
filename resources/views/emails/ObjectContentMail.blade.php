@component('mail::message')
Dear, {{$name}}

{{$body}}
@if($url)
@component('mail::button', ['url' => $url])
Button Text
@endcomponent
@endif
<p>&nbsp;</p> Thanks you,<br> The Airbook Team <br>XBS | Aviation City - Dubai World Central<br>Dubai South, United Arab Emirates <br>https://airbook.aero | support@airbook.aero @endcomponent


