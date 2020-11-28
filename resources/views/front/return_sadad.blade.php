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

function encrypt_pkcs7($str, $key)
{
    $key = base64_decode($key);
    $ciphertext = OpenSSL_encrypt($str, "DES-EDE3", $key, OPENSSL_RAW_DATA);
    return base64_encode($ciphertext);
}
function CallAPI($url, $data = false)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}
$key = "1JyJhGHnj2bZFoo3i5GnRdkm2wFMqvRk";

$OrderId = $_POST["OrderId"];
$Token = $_POST["token"];
$ResCode = $_POST["ResCode"];

if ($ResCode == -1) {

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


} else if ($ResCode == 0) {

$verifyData = array('Token' => $Token, 'SignData' => encrypt_pkcs7($Token, $key));
$str_data = json_encode($verifyData);
$res = CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Advice/Verify', $str_data);
$arrres = json_decode($res);

//if ($arrres->ResCode != -1 && $ResCode == 0) {
if (true) {
    
//session()->put('order_id', $arrres->OrderId);
session()->put('order_id', $_POST["OrderId"]);
session()->put('refid', $arrres->RetrivalRefNo);
session()->put('authority', $OrderId);

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
                {{$arrres->RetrivalRefNo}}
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
}
?>

</body>

</html>
