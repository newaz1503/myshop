<?php
$setting = \App\Models\GlobalSetting::select('id', 'app_name', 'website_title', 'primary_color', 'site_meta_keywords', 'favicon', 'loader', 'site_meta_description', 'site_meta_title')->first() ?? [];
?>
    <!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ URL::to('/') }}"/>
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
    <script src="{{ asset('admin/js/layout.js') }}"></script>
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('admin/js/fontawesome.js') }}" crossorigin="anonymous"></script>
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/css/custom.min.css') }}" rel="stylesheet" type="text/css"/>
</head>

<body class="authentication-bg">
<div id="app">
    <login/>
</div>

<script src="{{ asset('js/login_app.js') }}" defer></script>
<script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
