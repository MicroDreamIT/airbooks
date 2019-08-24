<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    <link href="/admin2/img/favi.svg" rel="shortcut icon" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/admin2/lib/perfect-scrollbar/css/perfect-scrollbar.min.css"/>
    <link rel="stylesheet" type="text/css" href="/admin2/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css"/>
    {{--<link rel="stylesheet" type="text/css" href="/admin2/lib/datetimepicker/css/bootstrap-datetimepicker.min.css"/>--}}
    <link rel="stylesheet" href="{{asset('admin2/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('admin2/css/font-all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin2/lib/material-design-icons/css/material-design-iconic-font.min.css')}}">
    <link href="{{ asset('css/perfect-scrollbar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('css/admin.css')}}">
 
</head>
<body>
@if(session()->has('type'))
    <div class="alert alert-{{ session()->get('type')?session()->get('type'):'info'}} alert-dismissible"
         role="alert">
        <button class="close" type="button" data-dismiss="alert" aria-label="Close" @click="closeAlert()">
            <span class="mdi mdi-close" aria-hidden="true"></span>
        </button>
        <div class="icon"><span class="mdi mdi-check"></span></div>
        <div class="message">
            <strong>Error! </strong>
            {{ session()->get('message')}}
        </div>
    </div>

@endif
<div id="app" :class="'be-wrapper be-collapsible-sidebar be-collapsible-sidebar-hide-logo ' + navTogglar">
    
    {{--<div class="notif-container">--}}
        {{--<my-notification></my-notification>--}}
    {{--</div>--}}

    <global-media v-if="$root.$data.showMedia"></global-media>
    <alert :alert="alert"></alert>
    {{--@include('MediaManager::_manager')--}}
    @yield('content')
    
</div>
{{--<script src="//cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script>--}}
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ mix('js/admin.js') }}"></script>
<script src="{{ asset('js/themeDefault.js') }}"></script>
<script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{ asset('js/jquery.sparkline.min.js') }}"></script>


{{--<script src="{{asset('admin2/lib/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>--}}

</body>
</html>
