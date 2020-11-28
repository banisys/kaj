<!doctype html>
<html class="no-js" lang="fa">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>ترمه تن</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('/js/dress/app.js')}}"></script>
    <link rel="stylesheet" href="/dress/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/dress/assets/css/animate.css">
    <link rel="stylesheet" href="/dress/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/dress/assets/css/chosen.min.css">
    <link rel="stylesheet" href="/dress/assets/css/easyzoom.css">
    <link rel="stylesheet" href="/dress/assets/css/themify-icons.css">
    <link rel="stylesheet" href="/dress/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="/dress/assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="/dress/assets/css/bundle.css">
    <link rel="stylesheet" href="/dress/assets/css/style.css">
    <link rel="stylesheet" href="/dress/assets/css/rtl.css">
    <link rel="stylesheet" href="/dress/assets/css/responsive.css">
    <script src="/dress/assets/js/vendor/modernizr-2.8.3.min.js"></script>
    @yield('style')

</head>
<body>

<style>
    body {
        height: 100vh !important;
    }

    #xxx > li {
        margin-left: 30px;
    }

    #xxx > li > a {
        font-size: 14px;
        color: #828282;
    }
</style>

<br><br>
<?php
$MerchantID = '7e0c3e5e-77d3-421d-ae62-f8e64310c080';
$Amount2 = session()->get('sum_final');




$Authority = $_GET['Authority'];
if ($_GET['Status'] == 'OK') {
$client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
$result = $client->PaymentVerification([
    'MerchantID' => $MerchantID,
    'Authority' => $Authority,
    'Amount' => $Amount2,
]);

if ($result->Status == 100) {
    
// if (100 == 100) {

session()->put('refid', $result->RefID);
session()->put('authority', $Authority);

// session()->put('refid', 333333);
// session()->put('authority', 44444);


(new App\Http\Controllers\Front\PanelController())->storeOrder();



?>

<div class="container">
    <div class="row" style="height:150px">
        <div class="col-sm-12" id="content" style="margin-top: 30px;">
            <div class="alert alert-success" role="alert">
                پرداخت شما با موفقیت انجام شد.
                <br>
                شناسه پرداخت شما:
                <br>
                {{$result->RefID}}
            </div>
            <div class="buttons" style="float: left">
                <div class="pull-right">
                    <a href="{{url('/panel/orders')}}" class="btn btn-primary">ادامه ثبت سفارش</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
} else {
?>
<div class="container">
    <div class="row" style="height:150px">
        <div class="col-sm-12" id="content" style="margin-top: 30px;">
            <div class="alert alert-danger" role="alert">
                پرداخت انجام نشد.
            </div>
            <div class="buttons" style="float: left">
                <div class="pull-right">
                    <a href="{{url('/')}}" class="btn btn-primary">بازگشت به صفحه اصلی</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
} else {
?>
<div class="container">
    <div class="row" style="height:150px">
        <div class="col-sm-12" id="content" style="margin-top: 30px;">

            <div class="alert alert-danger" role="alert">
                پرداخت توسط شما لغو گردید.
            </div>
            <div class="buttons" style="float: left">
                <div class="pull-right">
                    <a href="{{url('/')}}" class="btn btn-primary">بازگشت به صفحه اصلی</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>

</body>

</html>
