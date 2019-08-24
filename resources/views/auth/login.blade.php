<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Login</title>
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
        "logo": "/images/Airbook_svg_logo.svg",
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
<div class="sign-in-block-wrapper"><a href="/" class="airbook-login-brand w-inline-block"><img
                src="/siddiqueAssets/images/Airbook_svg_logo.svg" width="140" alt="Airbook Login"></a>
    <div class="sign-page-title">Log into my account</div>
    <div style="text-align: center; color: red;">
        {{ $errors->has('message')?$errors->first('message'):'' }}
    </div>
    <div class="sign-form-block w-form">



        <form id="wf-form-Sign-In-Form" name="wf-form-Sign-In-Form" data-name="Sign In Form" class="sign-form"  method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" class="sign-field w-input" maxlength="256" name="email" data-name="Email" placeholder="Email" id="Email" >
            @if ($errors->has('email'))
                        <div class="errorGuard">
                            <span class="own-error-message" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                             </span>
                        </div>
            @endif
            <input type="password" class="sign-field w-input"  maxlength="256" name="password"  data-name="Password" placeholder="Password"  id="Password" >
            @if ($errors->has('password'))
                <div class="errorGuard">
                <span class="own-error-message" role="alert">
                          <strong>{{ $errors->first('password') }}</strong>
                </span>
                </div>
            @endif
            <input type="submit" value="Log In"  data-wait="Please wait..." class="login-button w-button">
        </form>
        <div class="success-message w-form-done">
            <div>Log In Successful!<br>Taking you into your account</div>
        </div>
        <div class="error-message w-form-fail">
            <div>Oops! Your username of password didn&#x27;t match! Please try again.</div>
        </div>
    </div>
    <div class="sign-links-block"><a href="/register" class="sign-link">Register for free account</a>
        <a href="/password/reset" class="sign-link">Forgot password?</a></div>
    <div class="sign-copyright">© Airbook</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="js/airbook.js" type="text/javascript"></script>
<!-- [if lte IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>
</html>




{{--@extends('layouts.app')--}}
{{--@section('content')--}}
 {{--<div class="loginSection">--}}
     {{--<form method="POST" action="{{ route('login') }}">--}}
         {{--@csrf--}}
       {{--<div class="loginBar">--}}
           {{--<img src="/images/logo.svg" class="adminLogo"  alt="">--}}

           {{--<div class="sign-page-title">Log into my account</div>--}}
           {{--<div class="signInBlock">--}}
               {{--<input id="email" type="email" name="email" class="input-control {{ $errors->has('email') ? ' own-error-message' : '' }}" placeholder="Email" value="{{ old('email') }}" required autofocus>--}}
               {{--@if ($errors->has('email'))--}}
                   {{--<span class="own-error-message" role="alert">--}}
                       {{--<strong>{{ $errors->first('email') }}</strong>--}}
                   {{--</span>--}}
               {{--@endif--}}
           {{--</div>--}}
           {{--<div class="signInBlock">--}}
               {{--<input id="password" name="password" type="password" class="input-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="Password" >--}}
               {{--@if ($errors->has('password'))--}}
                   {{--<span class="own-error-message" role="alert">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
               {{--@endif--}}
           {{--</div>--}}

           {{--<button class="d-block login-button">Log in</button>--}}
           {{--<div class="text-alignment">--}}
               {{--<a class="registerText" href="{{ url('/register') }}">Register for free account</a>--}}
               {{--<a class="registerText" href="{{ route('password.request') }}">Forgot password</a>--}}
           {{--</div>--}}
           {{--<div class="sign-copyright">© Airbook</div>--}}
       {{--</div>--}}
     {{--</form>--}}
 {{--</div>--}}
 {{--<style scoped>--}}
	{{----}}
	 {{--@import url('https://fonts.googleapis.com/css?family=Montserrat');--}}
    {{----}}
     {{--@media only screen and (max-device-width: 425px){--}}
         {{--.loginBar{--}}
             {{--width:auto!important;--}}
         {{--}--}}
         {{--.loginSection{--}}
             {{--padding: 9% 7%;--}}
         {{--}--}}
         {{----}}
     {{--}--}}
	 {{----}}
     {{--.sign-copyright {--}}
         {{--position: absolute;--}}
         {{--left: 0px;--}}
         {{--right: 0px;--}}
         {{--bottom: 0px;--}}
         {{--padding-bottom: 15px;--}}
         {{---webkit-box-pack: center;--}}
         {{---webkit-justify-content: center;--}}
         {{---ms-flex-pack: center;--}}
         {{--justify-content: center;--}}
         {{---webkit-box-align: center;--}}
         {{---webkit-align-items: center;--}}
         {{---ms-flex-align: center;--}}
         {{--align-items: center;--}}
         {{--color: #c2c2c2;--}}
         {{--font-size: 12px;--}}
         {{--line-height: 18px;--}}
         {{--font-weight: 400;--}}
         {{--text-align: center;--}}
     {{--}--}}
     {{--.registerText{--}}
         {{--padding-top: 5px;--}}
         {{--padding-bottom: 5px;--}}
         {{---webkit-transition: all 100ms ease;--}}
         {{--transition: all 100ms ease;--}}
         {{--color: #999;--}}
         {{--font-weight: 500;--}}
         {{--text-decoration: none;--}}
	     {{--text-shadow: 0 0 1px #80808082;--}}
	     {{--font-size: 14px;--}}
     {{--}--}}
     {{--.registerText:hover{--}}
         {{--color:#2173B9;--}}
     {{--}--}}
     {{--.text-alignment{--}}
         {{--margin-top: 20px;--}}
         {{--display: flex;--}}
         {{--flex-direction: column;--}}
         {{--align-items: flex-end;--}}
         {{--width: 100%;--}}
     {{--}--}}
     {{--.login-button {--}}
         {{--width: 100%;--}}
         {{--min-height: 50px;--}}
         {{--margin-top: 24px;--}}
         {{--border-radius: 2px;--}}
         {{--background-color: #2173b9;--}}
         {{--box-shadow: inset 0 -4px 0 0 #2c9eff;--}}
         {{---webkit-transition: all 50ms ease;--}}
         {{--transition: all 50ms ease;--}}
         {{--font-weight: 600;--}}
         {{--color: #fff;--}}
         {{--outline: none;--}}
         {{--font-size: 14px;--}}
         {{--border: 0;--}}
	     {{--cursor:pointer;--}}
     {{--}--}}
     {{--.login-button:hover{--}}
	     {{--background-color: #1b87e4;--}}
     {{--}--}}
     {{--.input-control{--}}
         {{--min-height: 34px;--}}
         {{--margin-bottom: 7px;--}}
         {{--border: 1px solid silver;--}}
         {{--border-radius: 2px;--}}
         {{--box-shadow: inset 0 0 8px 0 #f3f3f3;--}}
         {{--font-size: 16px;--}}
         {{--line-height: 22px;--}}
         {{--font-weight: 500;--}}
         {{--padding: 8px 12px;--}}
         {{--outline: none;--}}
         {{--color: #333;--}}
     {{--}--}}
     {{--.input-control:focus{--}}
         {{--border: 1px solid #068DFF;--}}
     {{--}--}}
     {{--.signInBlock{--}}
         {{--display: flex;--}}
         {{--flex-direction: column;--}}
         {{--width: 100%;--}}
	     {{--margin-top: 12px;--}}
     {{--}--}}
     {{--.adminLogo{--}}
         {{--margin-bottom: 20px;--}}
         {{--width: 140px;--}}
     {{--}--}}
     {{--body{--}}
         {{--margin: 0; padding: 0;--}}
         {{--font-family: Montserrat, sans-serif;--}}
     {{--}--}}
     {{--.sign-page-title {--}}
         {{--color: #BBBBBB;--}}
         {{--font-size: 16px;--}}
         {{--line-height: 22px;--}}
         {{--font-weight: 400;--}}
         {{--text-align: center;--}}
     {{--}--}}
     {{--.loginSection{--}}
         {{--display: flex;--}}
         {{--justify-content: center;--}}
         {{--align-items: center;--}}
         {{--height: 100vh;--}}
         {{--background: #068DFF;--}}
         {{--background-image: -webkit-linear-gradient(270deg, rgba(33, 115, 185, .95), rgba(33, 115, 185, .95)), url(/images/Airbook-background-art.svg);--}}
         {{--background-position: 0px 0px, 50% 50%;--}}
         {{--background-size: auto, 500px;--}}
	     {{--font-family: 'Montserrat', sans-serif;--}}
     {{--}--}}
     {{--.loginBar{--}}
         {{--position: relative;--}}
         {{--display: flex;--}}
         {{--flex-direction: column;--}}
         {{--justify-content: flex-start;--}}
         {{--width: 363px;--}}
         {{--min-height: 457px;--}}
         {{--/* margin-top: 80px; */--}}
         {{--margin-bottom: 60px;--}}
         {{--padding: 40px 30px 30px;--}}
         {{--align-items: center;--}}
         {{--border-radius: 4px;--}}
         {{--background-color: #fff;--}}
         {{--box-shadow: inset 0 0 6px 0 #bbb;--}}
     {{--}--}}
 {{--</style>--}}

{{--<div class="container">--}}
    {{--<div class="row justify-content-center">--}}
        {{--<div class="col-md-8">--}}
            {{--<div class="card">--}}
                {{--<div class="card-header">{{ __('Login') }}</div>--}}
                {{--<div class="card-body">--}}
                    {{--<form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">--}}
                        {{--@csrf--}}
                        {{--<div class="form-group row">--}}
                            {{--<label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>--}}

                                {{--@if ($errors->has('email'))--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>--}}

                                {{--@if ($errors->has('password'))--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<div class="col-md-6 offset-md-4">--}}
                                {{--<div class="checkbox">--}}
                                    {{--<label>--}}
                                        {{--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row mb-0">--}}
                            {{--<div class="col-md-8 offset-md-4">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--{{ __('Login') }}--}}
                                {{--</button>--}}

                                {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                                    {{--{{ __('Forgot Your Password?') }}--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
{{--@endsection--}}
