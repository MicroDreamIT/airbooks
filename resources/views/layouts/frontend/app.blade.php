
<!DOCTYPE html>
<html>
<head>
    @include('frontendPartial.metaHead')
    <link href="/frontend/css/normalize.css" rel="stylesheet" type="text/css">
    <link href="/frontend/css/webflow.css" rel="stylesheet" type="text/css">
    <link href="/frontend/css/airbook.webflow.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js" type="text/javascript"></script>
    <link href="/siddiqueAssets/images/32x32-web-icon-new.png" rel="icon">
    <link rel="stylesheet" type="text/css" href="{{asset('admin2/lib/material-design-icons/css/material-design-iconic-font.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{mix('css/app.css')}}">
    <script type="text/javascript">
        WebFont.load({
            google: {
                families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"]
            }
        });
    </script>
    <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
    <script type="text/javascript">
        ! function(o, c) {
            var n = c.documentElement,
                t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
        }(window, document);
    </script>
    <link href="images/32x32-web-icon-new.png" rel="shortcut icon" type="image/x-icon">
    <link href="images/ab-256x256.png" rel="apple-touch-icon">
    <script type="text/javascript">
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
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
    
        #alert_component .alert.alert-dismissible {
            position: fixed;
            margin:0 auto;
            left: 0;
            right: 0;
            max-width: 521px;
            top: 0;
            z-index: 100000;
        }
        .alert-success {
            background-color: #33a451;
        }
        .alert-danger {
            background-color: #ea3f30;
        }
        .alert-info {
            background-color: #66a1ff;
        }
        .alert-warning {
            background-color: #f7b904;
        }
        .alert-dismissible.alert-success .close, .alert-dismissible.alert-danger .close, .alert-dismissible.alert-warning .close {
            color: #f9f9f9;
            float: right;
            background: 0;
        }
        .alert .icon {
            width: 55px;
            font-size: 1.846rem;
            vertical-align: middle;
            text-align: center;
            line-height: 22px;
            display: table-cell;
            cursor: default;
            padding-top: 1px;
        }
        .alert .message {
            display: table-cell;
            padding: 1.385rem 2.1542rem 1.385rem 0.231rem;
            border-left-width: 0;
        }
        .alert {
            padding: 0;
            position: relative;
            line-height: 25px;
            border-width: 0;
            margin-bottom: 18px;
            color: #FFFFFF!important;
        }
        .alert .close{
            top: -13px;
            right: 0.785rem;
            opacity: 1!important;
        }
        .alert-dismissible.alert-danger .close{
            color: #FFFFFF!important;
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
<body class="body">

<div id="app">



    @if(session()->has('blade-alert'))

        <div class="alert alert-success alert-dismissible" role="alert">
            <div class="alert alert-warning alert-dismissible"
                 role="alert">
                <button class="close" type="button" data-dismiss="alert" aria-label="Close" @click="closeAlert()">
                    <span class="mdi mdi-close" aria-hidden="true"></span>
                </button>
                <div class="icon"><span class="mdi mdi-check"></span></div>
                <div class="message">
                    <strong>Alert! </strong>
                    Please verify your email address to get full advantages of Airbook.
                    @if(auth()->check())

                            <a href="#" id="click-verify-email">
                                Resend email verification
                            </a>

                    @endif
                </div>
            </div>
        </div>

    @endif


    <alert :alert="alert"></alert>
    @include('layouts.frontend.essentialPartial.header')

        <div style="
    background: white;
    position: fixed;
    bottom: 0;
    right: 0;
    left: 0;
    top: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1"
        v-if="isLoading">
            <div style="width: 30%;">
                <content-placeholders>
                    <content-placeholders-heading :img="true" />
                    <content-placeholders-text />
                </content-placeholders>
                <br>
                <content-placeholders>
                    <content-placeholders-text />
                    <content-placeholders-text />
                    <content-placeholders-text />
                    <content-placeholders-text />
                    <content-placeholders-text />
                </content-placeholders>
            </div>
        </div>

       @yield('content')
    @include('layouts.frontend.essentialPartial.footer')
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="/frontend/js/webflow.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script>
<script src="{{mix('js/app.js')}}"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-92936541-1"></script>
<script>

    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-92936541-1');

    $(document).ready(function(){
        $('#click-logout').click(function () {
            document.getElementById('logout-form').submit();
        });
        $('#click-verify-email').click(function () {
            document.getElementById('verify-form').submit();
        });

        $('#post-cookies').click(function(){
            document.getElementById('cookie-form').submit()
        });
    })
</script>

</body>
</html>
