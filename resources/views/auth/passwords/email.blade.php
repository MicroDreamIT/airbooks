<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <meta content="Register" property="og:title">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Webflow" name="generator">
    <link href="/siddiqueAssets/css/normalize.css" rel="stylesheet" type="text/css">
    <link href="/siddiqueAssets/css/main.css" rel="stylesheet" type="text/css">
    <link href="/siddiqueAssets/css/airbook.main.css" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js" type="text/javascript"></script>
    <script type="text/javascript">
        WebFont.load({
            google: {
                families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"]
            }
        });
    </script>
    <!-- [if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"
            type="text/javascript"></script><![endif] -->
    <script type="text/javascript">
        !function (o, c) {
            var n = c.documentElement,
                t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
        }(window, document);
    </script>
    <link href="images/32x32-web-icon-new.png" rel="shortcut icon" type="image/x-icon">
    <link href="images/ab-256x256.png" rel="apple-touch-icon">
    <script type="text/javascript">
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.agent = 'plwebflow';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '931018743715763');
        fbq('track', 'PageView');
    </script>
    <style type="text/css">
        .errorGuard{
            position: relative;
            width: 100%;
            top: -11px;
            line-height: 1.4;
            font-size: 13px;
            text-transform: capitalize;
            font-weight: 600;
            color: rgba(255, 0, 0, 0.788235294117647);
        }
        .alert-success{
            padding-bottom: 20px;
            color: green;
        }

        @media screen and (min-width: 1200px) {
            .w-container {
                max-width: 1170px;
            }
        }
    </style>
    <meta name="theme-color" content="#2173b9">
    <meta name="yandex-verification" content="139220324c5d5f8f">
    <meta name="msvalidate.01" content="51E9D2582B62C9692E9A40F2CB7ED9D4">
    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "Organization",
        "url": "https://airbook.aero",
        "logo": "https://uploads-ssl.webflow.com/5b844c4c40f0e1d11c012194/5b845087a5d419ae6a55c9fc_Airbook_svg_logo.svg",
        "name": "Airbook",
        "alternateName": "Airbook Aviation Asset Re-Marketing",
        "sameAs": [
          "https://www.facebook.com/airbook.aero/",
          "https://twitter.com/airbookaero",
          "https://www.linkedin.com/company/airbook/"
        ],
        "contactPoint": {
          "@type": "ContactPoint",
          "telephone": "+971-55-991-9393",
          "contactType": "Help & Support"
        }
      }

    </script>
    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "name": "Airbook",
        "alternateName": "Airbook Aviation Asset Re-Marketing",
        "url": "https://airbook.aero"
      }

    </script>
</head>
<body class="body sign-in-page">
<div class="sign-in-block-wrapper"><a href="/" class="airbook-login-brand w-inline-block">
        <img src="/siddiqueAssets/images/Airbook_svg_logo.svg" width="140" alt="Airbook Password Recovery"></a>
    <div class="sign-page-title">Password Reset</div>
    <div class="sign-form-block w-form">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form id="wf-form-Password-Reset" name="wf-form-Password-Reset" data-name="Password Reset" class="sign-form" method="POST" action="{{ route('password.email') }}">
            @csrf
            <input type="email" class="sign-field w-input" maxlength="256" name="email" data-name="Email" placeholder="Email" id="Email" >
            @if ($errors->has('email'))
                <div class="errorGuard">
                       <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('email') }}</strong>
                      </span>
                </div>
           
            @endif
            <input type="submit" value="Reset" data-wait="Please wait..." class="login-button w-button">
        </form>
        <div class="success-message w-form-done">
            <div>Success!<br>Please check your email for further instructions</div>
        </div>
        <div class="error-message w-form-fail">
            <div>Oops! The email address you entered does not exists.</div>
        </div>
    </div>
    <div class="sign-links-block"><a href="/login" class="sign-link">Log In to my account</a></div>
    <div class="sign-copyright">© Airbook</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="js/airbook.js" type="text/javascript"></script>
<!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>
</html>


















{{--@extends('layouts.app')--}}
{{--@section('content')--}}
    {{--<div class="loginSection">--}}
        {{--<form method="POST" action="{{ route('login') }}">--}}
            {{--@csrf--}}
            {{--<div class="loginBar">--}}
                {{--<img src="/images/logo.svg" class="adminLogo"  alt="">--}}
                {{--<div class="sign-page-title">Password Reset</div>--}}
                {{--<div class="signInBlock">--}}
                    {{--<input id="email" type="email" name="email" class="input-control" placeholder="Email" value="" required autofocus>--}}
                    {{--@if ($errors->has('email'))--}}
                        {{--<span class="invalid-feedback" role="alert">--}}
                       {{--<strong>{{ $errors->first('email') }}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                {{--</div>--}}
                {{--<button class="d-block login-button">Reset</button>--}}
                {{--<div class="text-alignment">--}}
                    {{--<a class="registerText" href="{{ url('/login') }}">Log In to my account</a>--}}
                {{--</div>--}}
                {{--<div class="sign-copyright">© Airbook</div>--}}
            {{--</div>--}}
        {{--</form>--}}
    {{--</div>--}}
  {{----}}
    {{--@endsection--}}
