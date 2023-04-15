<?php
$setting = \App\Models\GlobalSetting::select('id', 'app_name', 'website_title', 'primary_color', 'site_meta_keywords', 'favicon', 'loader', 'site_meta_description', 'site_meta_title')->first() ?? [];
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="img-4" data-preloader="disable" data-layout-mode="light" data-layout-width="fluid"
    data-layout-position="fixed" data-layout-style="default">

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
    <meta name="title" content="{{ !empty($setting) ? $setting->site_meta_title : '' }}" />
    <meta name="keywords" content="{{ !empty($setting) ? implode(',', $setting->site_meta_keywords) : '' }}">
    <meta name="robots" content="index, follow">
    <!-- App favicon -->
    <link href="{{ asset(!empty($setting) ? $setting->favicon : '') }}" rel="shortcut icon">
    <script src="{{ asset('admin/js/layout.js') }}"></script>
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('admin/js/fontawesome.js') }}" crossorigin="anonymous"></script>
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- PWA  -->
    <meta name="theme-color" content="{{ !empty($setting) ? $setting->primary_color : '' }}">
    <link rel="apple-touch-icon" href="{{ asset('pwa-logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <style>
        :root {
            --vz-primary: {{ !empty($setting) ? $setting->primary_color : '' }};
        }

        #scrollbar {
            overflow: auto;
            height: 90vh;
        }

        #scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        #scrollbar::-webkit-scrollbar-track {
            background: #f1f1f100;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }

        #scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 14px;
            display: none;
        }

        #scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        #scrollbar:hover #scrollbar::-webkit-scrollbar-thumb {
            display: block;
        }
    </style>
</head>
<body>
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <header-component></header-component>
            </div>
        </header>
        <div class="app-menu navbar-menu">
            <sidebar-header></sidebar-header>
            <div id="scrollbar">
                <div class="container-fluid">
                    <sidebar-navigation></sidebar-navigation>
                </div>
            </div>
            <div class="sidebar-background"></div>
        </div>
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
        <div class="main-content">
            <app></app>
        </div>
        <!-- end main content-->
    </div>
    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!-- JAVASCRIPT -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery-1.12.4.min.js') }}"></script>
    <script>
        $(window).load(function() {
            $('#preloader').fadeOut('slow');
        });
    </script>
</body>
</html>
