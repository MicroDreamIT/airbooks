@component('mail::message')
Hi Airbook, <br>
This is {{auth()->user()->contact->first_name}}<br>
I am suggesting this information below in <span style="background: #1b63a0; color: white; padding: 2px 12px">{{$entity_type}}</span>:<br><br>
Category name: {{$category}}<br>
Manufacturer name : {{$manufacturer}}<br>
Type name : {{$type}}<br>
Model name : {{$model}}<br>
<p>
    Thank you,
    <br> {{auth()->user()->contact->first_name}}
    <br>{{auth()->user()->email}}
</p>
@endcomponent