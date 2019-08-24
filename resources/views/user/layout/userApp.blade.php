<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Dashboard</title>
    <link href="admin2/img/favi.svg" rel="shortcut icon" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/admin2/lib/perfect-scrollbar/css/perfect-scrollbar.min.css"/>
    <link rel="stylesheet" type="text/css" href="/admin2/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css"/>
    <link rel="stylesheet" href="{{asset('admin2/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('admin2/css/font-all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin2/lib/material-design-icons/css/material-design-iconic-font.min.css')}}">
    <link href="{{ asset('css/perfect-scrollbar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('css/user.css')}}">
    <link rel="stylesheet" href="https://www.paytabs.com/theme/express_checkout/css/express.css">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
</head>
<body>

@if(session()->has('type'))
    <div class="alert alert-{{ session()->get('type')?session()->get('type'):'info'}} alert-dismissible"
         role="alert" style="z-index: 9999; position: fixed; width: 100%;">
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
<div id="app" :class="'be-wrapper be-collapsible-sidebar be-collapsible-sidebar-hide-logo ' + navTogglar" v-cloak>


    <user-media v-if="$root.$data.showMedia"></user-media>

    <alert :alert="alert"></alert>

    <div >
        @yield('content')
    </div>
    <div class="d-flex justify-content-center"
         style="align-items: center; position: absolute; top: 0; left: 0; width: 100%;height: 100vh; background:#ffffffd6; z-index: 1111;"
         v-if="totalLoading">
        <span style="position: absolute; font-size: 22px; color: darkred; margin-top: 17px; text-transform: capitalize;">
            payment processing...
        </span>
        <fingerprint-spinner
                :animation-duration="1500"
                :size="200"
                color="#4285f4"
        ></fingerprint-spinner>
    </div>



</div>
<script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{ mix('js/user.js') }}"></script>
<script src="{{ asset('js/themeDefault.js') }}"></script>
<script src="{{ asset('js/jquery.sparkline.min.js') }}"></script>
<script src="https://www.paytabs.com/theme/express_checkout/js/jquery-1.11.1.min.js"></script>
<script src="https://www.paytabs.com/express/express_checkout_v3.js"></script>



<script type="text/javascript">

</script>
<script type="text/javascript">

</script>

</body>
</html>
