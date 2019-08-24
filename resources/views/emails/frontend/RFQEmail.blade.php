@component('mail::message')
Dear {{$data['user']['contact']['first_name']}}&nbsp;{{$data['user']['contact']['last_name']}},

<p>You have new RFQ from {{$user['contact']['first_name']}}&nbsp;{{$user['contact']['last_name']}} ( {{$user['email']}} ) .</p>
<p>{{$message}}</p>
<a href="{{url('/user/parts/'.$data['id'].'-'.$data['title'])}}">
    Part Number: {{$data['part_number']}}
</a>
<br>
<p>
    Thank you,
    <br> The Airbook Team
    <br>XBS | Aviation City - Dubai World Central
    <br>Dubai South, United Arab Emirates
    <br>https://airbook.aero | support@airbook.aero
</p>
@endcomponent
