@component('mail::message')
Dear {{$values[0]['contact']['first_name']}}&nbsp;{{$values[0]['contact']['last_name']}},
<p>You have new RFQ from {{auth()->user()->contact->first_name}}&nbsp;{{auth()->user()->contact->last_name}} ({{auth()->user()->email}})</p>
<p>Message: {{$message}}</p>
<p>Part Number:</p>
@foreach($values as $data)
<a href="{{url('/user/parts/'.$data['id'].'-'.$data['title'])}}">
    <span style="padding-left: 15px;">{{$data['part_number']}}</span>
</a>
<br>
@endforeach
<br>
<p>
    Thank you,
    <br> The Airbook Team
    <br>XBS | Aviation City - Dubai World Central
    <br>Dubai South, United Arab Emirates
    <br>https://airbook.aero | support@airbook.aero
</p>
@endcomponent
