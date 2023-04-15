<?php
$setting = \App\Models\GlobalSetting::select('id', 'app_name', 'website_title', 'primary_color', 'site_meta_keywords',
 'favicon', 'loader', 'site_meta_description', 'site_meta_title','whatsapp_show', 'whatsapp_number')->first() ?? [];
$storeSetting = \App\Models\StoreSetting::select('id','theader_bg_color','theader_font_color','last_banner')->first() ?? [];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ URL::to('/') }}" />
    <script>
        window.laravel = {
            csrfToken: '{{ csrf_token() }}',
            baseurl: '{{ URL::to('/') }}'
        }
    </script>
    <title>{{ !empty($setting) ? $setting->website_title : 'Myshop Ecommerce' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ !empty($setting) ? $setting->site_meta_description : '' }}" name="description">
    <meta name="title" content="{{ !empty($setting) ? $setting->site_meta_title : '' }}"/>
    <meta name="keywords" content="{{ !empty($setting) ? implode(',', $setting->site_meta_keywords) : '' }}">
    <meta name="robots" content="index, follow">

    <!-- App favicon -->
    <link href="{{ asset(!empty($setting) ? $setting->favicon : '') }}" rel="shortcut icon">
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/css/style.min.css') }}" rel="stylesheet">

    <!-- PWA  -->
    <meta name="theme-color" content="{{ !empty($setting) ? $setting->primary_color : '' }}">
    <link rel="apple-touch-icon" href="{{ asset('pwa-logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <style>

        :root {
            --vz-primary: {{ !empty($setting) ? $setting->primary_color : '' }};
        }
        .top-header-bg{
            background: {{ !empty($storeSetting) ? $storeSetting->theader_bg_color : '' }}  !important;
        }
        .top-header-color{
            color: {{ !empty($storeSetting) ? $storeSetting->theader_font_color : '' }} !important;
        }


        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 64px;
            height: 64px;
            margin: 8px;
            border-radius: 50%;
            border: 6px solid #fff;
            border-color: {{ !empty($setting) ? $setting->primary_color : '#000000' }} transparent {{ !empty($setting) ? $setting->primary_color : '#000000' }} transparent;
            animation: lds-dual-ring 1s linear infinite;
        }

        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        header.border-bottom {
            height: 40px;
        }

        /*User panel*/
        .user-panel a.list-group-item.active.router-link-active {
            background: transparent;
            color: #ff5722;
            border: 0;
            border-left: 3px solid #ff5722;
            border-radius: 0;
        }
        /* popup section */
        .popup_box{
            position: fixed;
            right: 40px;
            bottom: 40px;
            width: 420px;
            padding: 24px;
            font-family: "Open Sans", OpenSans, Helvetica, Arial;
            z-index: 999;
            background-color: rgb(255, 255, 255);
            border-radius: 16px;
            box-shadow: rgb(0 0 0 / 20%) 0px 2px 16px 0px;
            transition: transform 1000ms ease 0ms;
        }
        .popup_box .closeIcon{
            font-size: 27px;
            color: #2b2b2b;
            cursor: pointer;
        }
        .popup_box .close_icon_1{
            font-size: 24px;
        }
        .popup_box .pop_head{
            opacity: 0.9;
            font-size: 24px;
            font-weight: bold;
            color: rgb(0, 0, 0);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .popup_box .pop_desc{
            margin-bottom: 20px;
            opacity: 0.9;
            font-size: 18px;
            color: rgb(46, 46, 46);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .popup_box .pop_social_box{
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .popup_box .pop_social{
            display: flex;
            gap: 15px;
        }
        .popup_box .pop_btn{
            display: flex;
            align-items: center;
            justify-content: center;
            height: 36px;
            width: 150px;
            background-color: {{ !empty($setting) ? $setting->primary_color : '#ff5900' }} !important;
            border-radius: 18px;
            color: #fff;
            font-size: 16px;

        }

         /* popup section */
       .banner-bg-image{
           background-image: url({{ !empty($storeSetting) ? $storeSetting->last_banner:'' }})
       }
       .whatsapp_box{
            position: fixed;
            right: 1%;
            bottom: 6%;
       }
       .whatsapp_box .whatsapp_img{
            width: 70px;
            height: 70px;
       }
       .whatsapp_box .whatsapp_img img{
            width: 100%;
            height: 100%;
            object-fit: cover;
       }
       .has-error .help-block{
        color:#f85508 ;
    }
    #offer-popup .popup_img_box{
        max-width: 100%;
        width: 100%;
        height: auto;
        position: relative;
    }
    #offer-popup .popup_img_box img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }
    @media (max-width: 991px){
        #offer-popup .popup_img_box{
            height: auto !important;
        }
    }
    .custom_mobile_header{
        color: #fff !important;
        padding: 0.1rem 1.2rem !important;
    }
    #mobile_side_bar ul li a {
        font-size: 16px !important;
        color: #fff;
        transition: all 0.3s ease;
    }
    #mobile_side_bar ul li a:hover{
        color: #EF452C !important;
    }
    #mobile_side_bar ul li{
        border-bottom: 1px solid #d4d4d4;
        padding: 7px 20px !important;
        box-shadow: 0 1px 1px #fff;
    }
    #mobile_side_bar .offcanvas-body{
        padding: 0 !important;
    }
    #mobile_side_bar .offcanvas-body{
        background-color: #212529!important;
    }
    @media (max-width: 767px){
        .promotional_header{
            display: none !important;
        }
        #top_header{
            display: none !important;
        }
    }
    @media (max-width: 600px){
        .offcanvas{
            --vz-offcanvas-width: 350px !important;
        }
    }
    @media (max-width: 425px){
        .offcanvas{
            --vz-offcanvas-width: 320px !important;
        }
    }

    </style>
</head>

<body>
    <!-- Begin page -->
    <div id="frontend-app">
        <frontend-app></frontend-app>
    </div>
    <!-- END layout-wrapper -->


    <!--end back-to-top-->
    <div class="pre-loader" id="preloader">
        <div class="lds-dual-ring"></div>
    </div>
    <button onclick="topFunction()" class="btn bg-color text-white btn-icon" id="back-to-top" style="display: block;">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!-- Theme Settings -->
      <!--whatsapp-->

      @if(!empty($setting) && $setting->whatsapp_show == 1)
        <div class="whatsapp_box">
            <div class="whatsapp_img">
                <a href="https://wa.me/{{ $setting->whatsapp_number}}?text=Connect%20with%20us%20through%20Whatsapp%20messenger" target="_blank">
                    <img src="{{ asset('frontend/images/whatsapp.webp') }}" alt="whatsapp">
                </a>

            </div>
        </div>
    @endif
    <script type="text/javascript">
        // Initialize the service worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/serviceworker.js', {
                scope: '/'
            }).then(function (registration) {
                // Registration was successful
            }, function (err) {
                // registration failed :(
                console.log('Myshop: ServiceWorker registration failed: ', err);
            });
        }
    </script>
    <script src="{{ asset('js/frontend_app.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-1.12.4.min.js') }}"></script>
    <script>
        $(window).on('load',function(){
            setTimeout(function(){
                $('#sidePopUp').fadeIn('slow');
            }, 5000);
        });
        $(window).on('load',function(){
            setTimeout(function(){
                $('#sidePopUp2').fadeOut('slow');
            }, 1000000);
        });
        $("#close1").on('click', function(){
            $("#sidePopUp2").fadeOut("slow");
        });
    </script>
    <script>
        $(window).load(function() {
            $('#preloader').fadeOut('slow');
        });
        var mybutton = document.getElementById("back-to-top");
                    mybutton && (window.onscroll = function () {
                scrollFunction()
            });
        function scrollFunction() {
            600 < document.body.scrollTop || 600 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
        }

        function topFunction() {
            document.body.scrollTop = 0, document.documentElement.scrollTop = 0
        }
    </script>
</body>
</html>
