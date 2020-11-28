<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/plugins/font-awesome/css/fontawesome-free-5.6.1-web/css/all.css">
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/dist/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="/dist/css/custom-style.css">
    @yield('style')
    <style>
        .sidebar .nav-link.active {
            background-color: #3490dc !important;
            font-weight: 10 !important;
            border-radius: 0 5px 5px 0 !important;
        }

        .main-sidebar, .main-sidebar:before {
            width: 220px
        }

        .nav-pills .nav-link:not(.active):hover {
            color: white;
        }

        .nav-pills .nav-link {
            color: #c2c7d0;
        }

        .nav-sidebar .fa {
            color: #ababab
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include('layouts.admin.nav')
    @include('layouts.admin.aside')
    <div class="content-wrapper">
        <div class="content-header" style="padding: 0">
            <div class="container-fluid" style="padding: 0">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @yield('content')
    </div>
    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script src="{{ asset('/js/app.js')}}"></script>
@yield('script')
<script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('dist/js/demo.js')}}"></script>
</body>
</html>
