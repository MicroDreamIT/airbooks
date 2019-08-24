<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Register</title>
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
     @media (max-width: 768px){
         .sign-in-block-wrapper.register-form{
             padding: 30px;
         }
     }
    
    @media(max-width: 425px){
        .sign-in-block-wrapper.register-form{
            width: 392px!important;
            padding: 30px!important;
        }
    }
    @media(max-width: 375px){
        .sign-in-block-wrapper.register-form{
            width: 333px!important;
            padding: 21px!important;
        }
    }
    @media(max-width: 320px){
        .sign-in-block-wrapper.register-form{
            width: 300px!important;
        }
    }
        #registerStep .selected-tag {
            width: 84%;
            overflow: hidden;
        }
        [v-cloak] {
            display: none;
        }
        .maleCheck,.femaleCheck{
            display: none;
        }

        .w-row  {
            margin-left: 0;
            margin-right: 0;
        }
 
        .innerGender{
            display: flex;
            flex: 2;
        }
      
        .maleCheck:checked ~ label img{
            background:#DDDDDD;
            border-radius: 3px;
        }
        .femaleCheck:checked ~ label img {
            background:#DDDDDD;
            border-radius: 3px;
        }
        
        .femaleCheck:not(:checked) ~ label img {
            background:transparent;
        }

        .sign-field:focus {
            border-color: #068dff;
            background-color: #ecf6ff;
        }

       .common img{
           width: 40px;
           padding: 5px;
           
       }
        .bottomPanel{
            display: flex;
            width: 100%;
        }
        .bottomPanel .items{
            flex:1;
            margin: 10px;
            text-transform: capitalize;
        }
        .upload-photo{
            -webkit-appearance: none;
            opacity: 0;
            display: none;
        }
        .UploadFile{
            margin-top: 20px;
            padding-top: 4px;
            padding-bottom: 4px;
            border: 1px solid #2173b9;
            border-radius: 3px;
            background-color: #fff;
            -webkit-transition: all 150ms ease;
            transition: all 150ms ease;
            color: #999;
            font-size: 12px;
            line-height: 18px;
            font-weight: 500;
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .profile-wrapper{
            max-width:960px;
        }
        .profile-page-section{
            margin:20px auto;
        }
        @media (max-width: 425px) {
            .profile-wrapper{
                padding: 10px!important;
            }

        }
        @media (max-width: 768px) {
            .airbook-login-brand{
                margin:17px auto;
            }
            .profile-info-block{
               text-align: center!important;
            }
            .create-profile-heading {
                text-align: center;
                width: 100%;
            }

        }
        @media (max-width: 991px){
            .sign-in-block-wrapper {
                width: 100%;
                padding-right: 15px;
                padding-left: 15px;
            }
            .create-profile-sub-title {
                text-align: center;
            }
            .create-profile-heading {
                text-align: center;
            }
            .profile-info-block {
                margin-bottom: 20px;
                -webkit-box-align: center;
                -webkit-align-items: center;
                -ms-flex-align: center;
                align-items: center;
            }
            .profile-flex-column {
                padding-top: 0;
            }
            .profile-form-flex-wrapper {
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -webkit-flex-direction: column;
                -ms-flex-direction: column;
                flex-direction: column;
            }
           
        }
        .profile-image-upload {
            width: 150px;
            height: 150px;
            margin-top: 30px;
            border-radius: 100%;
            background-image: url(/siddiqueAssets/images/Airbook-User-Icon.svg);
            background-repeat: no-repeat;
            color: #333;
            text-decoration: none;
            transform: scale(1);
            background-size: cover!important;
            border: 2px solid #ddd;
        }
        .gender {
            margin-left: 10px;
            padding: 5px 10px;
            border-radius: 2px;
            -webkit-transition: all 200ms ease;
            transition: all 200ms ease;
            font-family: 'Fa solid 900', sans-serif;
            color: #999;
            font-size: 30px;
            line-height: 30px;
            text-decoration: none;
        }
        .gender:hover {
            background-color: #ddd;
            color: #068dff;
        }
        .gender:focus {
            background-color: #ddd;
            color: #068dff;
        }
        .text-block {
            color: #999;
            font-size: 20px;
            line-height: 26px;
            font-weight: 500;
            
        }
        .upload-photo {
            margin-top: 20px;
            padding-top: 4px;
            padding-bottom: 4px;
            border: 1px solid #2173b9;
            border-radius: 3px;
            background-color: #fff;
            -webkit-transition: all 150ms ease;
            transition: all 150ms ease;
            color: #999;
            font-size: 12px;
            line-height: 18px;
            font-weight: 500;
        }
        .profile-flex-column.rightcolumn {
            padding-top: 0px;
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
        }
        .profile-flex-column {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            padding: 20px;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: start;
            -webkit-justify-content: flex-start;
            -ms-flex-pack: start;
            justify-content: flex-start;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-flex: 0.2;
            -webkit-flex: 0.2 auto;
            -ms-flex: 0.2 auto;
            flex: 0.2 auto;
        }
        .sign-form-block {
            width: 100%;
            padding-top: 30px;
        }
        .w-form {
            margin: 0 0 15px;
        }
        .profile-wrapper {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            min-height: 300px;
            padding: 40px;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            background-color: #fff;
            box-shadow: inset 0 0 6px 0 #bbb;
        }
        .profile-info-block {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 40px;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: start;
            -webkit-align-items: flex-start;
            -ms-flex-align: start;
            align-items: flex-start;
        }
        .profile-flex-column {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            padding-top: 33px;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: start;
            -webkit-justify-content: flex-start;
            -ms-flex-pack: start;
            justify-content: flex-start;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-flex: 0.2;
            -webkit-flex: 0.2 auto;
            -ms-flex: 0.2 auto;
            flex: 0.2 auto;
        }
        .profile-form-flex-wrapper {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }
        .create-profile-sub-title {
            color: #999;
            font-size: 16px;
            line-height: 25px;
            font-weight: 400;
        }
        .create-profile-heading {
            color: #172b4d;
            font-size: 38px;
            line-height: 44px;
            font-weight: 300;
        }
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
        .is-danger{
         color:red;
            font-size: 12px;
        }
        .errorGard{
            margin-top: -17px;
            font-size: 12px;
            padding-left: 5px;
            padding-bottom: 5px;
            text-transform: inherit;
            line-height: 15px;
        }
        .registerAdjust{
            display: flex;
        }

        @media only screen and (max-width:425px) {
            .registerAdjust{
                flex-direction: column;
            }
        }

        .error-adjustment{
            display: flex;    margin-top: -15px;    padding-left: 5px;    padding-bottom: 10px;
        }
        .dropdown-toggle{
            border: none!important;
        }
        .error-message-reg{
            color: red;
            position: absolute;
            font-size: 12px;
            top: 52px;color:red;
            font-size: 12px
        }

        .dropdown-toggle input::placeholder{
            color:#bbbbbb;
        }
        .hint-message{
            font-size: 10px;
            color:blue;
        }
        @media screen and (min-width: 1200px) {
            .w-container {
                max-width: 1170px;
            }
        }
         @media screen and (max-width: 767px) {
             .hint-message{
                 margin-left: 10px;
             }
         }
     @media screen and (max-width: 424px) {
         .hint-message{
             margin-left: 9px;
             font-size: 7px!important;
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
<body class="body sign-in-page" >

<form  id="register" name="wf-form-Register-Form" data-name="Register Form" data-redirect="/profile"
      redirect="/profile" class="sign-form" method="POST" action="{{ route('register') }}"  enctype="multipart/form-data" v-cloak>
    @csrf
     <div class="sign-in-block-wrapper register-form" v-show="registerStep1">
    <a href="/" class="airbook-login-brand w-inline-block">
          <img src="/siddiqueAssets/images/Airbook_svg_logo.svg" width="140" alt="Airbook Registration">
    </a>
            <div class="sign-page-title">Register for free account</div>
                    <div class="sign-form-block w-form">

                            <div class="step-1" v-show="registerStep1">
                                @include('auth.register.step1')
                                <button data-wait="Please wait..." sty class="login-button w-button "
                                   @click="step1Validation()">
                                    Next
                                </button>
                            </div>
                    </div>
         <div class="sign-links-block"><a href="/login" class="sign-link">Log in to my account</a></div>
         <div class="register-form-message">By clicking Register, you agree to the Airbook<br>
             <a href="/terms" target="_blank" class="register-form-page-link">Terms of Service</a> and
             <a href="/policy" target="_blank" class="register-form-page-link">Privacy Policy</a>
         </div>
         <div class="sign-copyright">© Airbook</div>
   </div>
    <div class="step-2" v-show="!registerStep1">
        @include('auth.register.step2')
    </div>


 </form>
        {{--<div class="success-message w-form-done">--}}
            {{--<div>Registration Successful!<br>Taking you into your account</div>--}}
        {{--</div>--}}
        {{--<div class="error-message w-form-fail">--}}
            {{--<div>Oops! The email address you entered is already registered.</div>--}}
        {{--</div>--}}



<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="/siddiqueAssets/js/airbook.js" type="text/javascript"></script>
<!-- [if lte IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
<script src="/js/app.js"></script>
</body>
</html>


