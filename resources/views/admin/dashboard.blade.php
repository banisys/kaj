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
    <link rel="stylesheet" href="/dist/css/custom-style.css">
    <style>
        .nav-link.active {
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
        .fa-tachometer-alt{color: white!important;}
    </style>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                data: [{
                    type: "column",
                    showInLegend: true,
                    dataPoints: [
                        {y: @if(isset($farvardin)){{$farvardin}} @else 0  @endif, label: "فروردین"},
                        {y: @if(isset($ordibehesht)){{$ordibehesht}} @else 0  @endif, label: "اردیبهشت"},
                        {y: @if(isset($khordad)){{$khordad}} @else 0  @endif, label: "خرداد"},
                        {y: @if(isset($tir)){{$tir}} @else 0  @endif, label: "تیر"},
                        {y: @if(isset($mordad)){{$mordad}} @else 0  @endif, label: "مرداد"},
                        {y: @if(isset($shahrivar)){{$shahrivar}} @else 0  @endif, label: "شهریور"},
                        {y: @if(isset($mehr)){{$mehr}} @else 0  @endif, label: "مهر"},
                        {y: @if(isset($aban)){{$aban}} @else 0  @endif, label: "آبان"},
                        {y: @if(isset($azar)){{$azar}} @else 0  @endif, label: "آذر"},
                        {y: @if(isset($dey)){{$dey}} @else 0  @endif, label: "دی"},
                        {y: @if(isset($bahman)){{$bahman}} @else 0  @endif, label: "بهمن"},
                        {y: @if(isset($esfand)){{$esfand}} @else 0  @endif, label: "اسفند"}
                    ]
                }]
            });
            chart.render();
        }
    </script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <style>
        .nav {
            text-align: right
        }
    </style>
    @include('layouts.admin.nav')
    @include('layouts.admin.aside')
    <div class="content-wrapper" style="text-align: right;">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2" style="direction: rtl">
                    <div class="col-sm-12">
                        <h1 class="m-0 text-dark">
                            داشبورد
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row my-3">
                <div class="col-12">
                    <span>آمار فروش ماهانه سال 1399</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
        </div>
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
</div>
<script src="{{ asset('/js/app.js')}}"></script>

<script src="/js/chart.js"></script>
<script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('dist/js/demo.js')}}"></script>
<script>

    $("#side_dashboard").addClass("active");
</script>
</body>
</html>
