@extends('layouts.app')

@section('content')
    <div class="wrongPage">

        <div class="inerItem">
            <div class="mainText"><span class="error_404">Oops</span>
                <p> Access Forbiden</p> </div>
            <h1>Uh Oh! Looks like some Typing mistake</h1>
            {{--<a href="{{url()->previous()}}">--}}
                {{--<button style="background: #4B8BF4;" >Take Me Away!</button>--}}
            {{--</a>--}}
        </div>
    </div>
@endsection
