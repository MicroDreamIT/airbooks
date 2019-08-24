@component('mail::message')
Dear {{$data['user']['contact']['first_name']}}&nbsp;{{$data['user']['contact']['last_name']}},

<p>You have new  {{$data['modelType']==='contact'? 'message from': 'lead from'}} {{$user['contact']['first_name']}}&nbsp;{{$user['contact']['last_name']}} ( {{$user['email']}} ).</p>
<p>
    {{$message}}
</p>
@if($data['modelType']==='apu' || $data['modelType']==='aircraft' || $data['modelType']==='engine' || $data['modelType']==='wanted' || $data['modelType']==='contact')
 {{$data['modelType']==='contact'? 'Contact Link:': 'Asset Link:'}} <a href="{{url($data['modelType'].'/'.$data['linkify'])}}">
    {{url($data['modelType'].'/'.$data['linkify'])}}
</a>
<br><br>
@endif
<a href="{{url('/user/lead')}}">
    View my leads
</a>
{{--@component( 'mail::button', ['url' => url('/user/lead') ] )--}}
{{--View my leads--}}
{{--@endcomponent--}}

<p>&nbsp;</p> Thank you,<br> The Airbook Team <br>XBS | Aviation City - Dubai World Central<br>Dubai South, United Arab Emirates <br>https://airbook.aero | support@airbook.aero
@endcomponent
