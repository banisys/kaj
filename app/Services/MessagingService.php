<?php

namespace App\Services;

use SoapClient;
use App\Models\Cart;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Services\SMS_IR\UltraFastSend;

class MessagingService
{
    public static function sendCustomerSms($mobile, $code)
    {
        Log::info('CustomerSMS, mobile:'.$mobile);

        $result = static::sendFastSms($mobile, [
            "code" => $code
            ], 36183);

        Log::info('result:'.$result);

        return $result;
    }

    public static function sendAdminSms($factor_num, $price)
    {
        // // $mobile = "09901453875";

        // $mobile = "09199969350";

        // $time = Verta::now()->format('Y/m/d H:i');

        // return static::sendFastSms($mobile, [
        //     "factor_num" => $factor_num,
        //     "time" => $time,
        //     "price" => $price
        //     ], 30149);
    }

    public static function replaceNumbersPersianWithLatin($string)
    {
        if (trim($string) == '') return "";
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $num = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($persian, $num, $string);
    }

    protected static function sendFastSms($mobile, $params, $templateid)
    {
        try {

            $parameters = [];

            foreach ($params as $key => $value)
            {
                 $parameters[] = [
                     "Parameter"=>$key,
                     "ParameterValue"=>$value
                    ];
            }

        	date_default_timezone_set("Asia/Tehran");

        	// your sms.ir panel configuration
        	$APIKey = "f890ea3647875c20163cf4c9";
        	$SecretKey = "it66)%#trBC!@*&";

        	// message data
        	$data = [
        	    "ParameterArray" => $parameters,
        		"Mobile" => static::replaceNumbersPersianWithLatin($mobile),
        		"TemplateId" => $templateid
        	];

        	$ultraFastSend = new UltraFastSend($APIKey,$SecretKey);
        	$UltraFastSend = $ultraFastSend->UltraFastSend($data);

        	return ($UltraFastSend);

        } catch (Exeption $e) {
        	return 'Error UltraFastSend : '.$e->getMessage();
        }
    }

    // public static function send($mobile, $text)
    // {
    //     $text = urlencode($text);

    //     $url = "http://sms.parsgreen.ir/UrlService/sendSMS.ashx?from=10001398&to=" . $mobile . "&&text=" . $text . "&signature=71DA12E0-D231-437A-87F3-C29FAFCA4BFB";

    //     $opts = array(
    //         'http' => array(
    //             'method' => "GET",
    //             'header' => "Accept-language: fa\r\n" .
    //                 "Cookie: foo=bar\r\n" .
    //                 "User-agent: BROWSER-DESCRIPTION-HERE\r\n" .
    //                 "Content-Type: text/html; charset=utf-8\r\n"
    //         )
    //     );

    //     $context = stream_context_create($opts);

    //     return file_get_contents($url, false, $context);

    // }

    public static function SendGroupSms($Mobiles, $textMessage)
    {
         $Mobiles = collect($Mobiles)->filter(function ($value, $key) {
                return $value !=null;
            })->unique()->all();
        $webServiceURL  = "http://sms.parsgreen.ir/Api/SendSMS.asmx?WSDL";
        $webServiceSignature = "71DA12E0-D231-437A-87F3-C29FAFCA4BFB";
        $webServiceNumber   = "10001398"; //Message Sende Number
        // $Mobiles      = array ("09---------");
        mb_internal_encoding("utf-8");
        //  $textMessage="hello World";
             $textMessage= mb_convert_encoding($textMessage,"UTF-8");
             $parameters['signature'] = $webServiceSignature;
             $parameters['from' ]= $webServiceNumber;
             $parameters['to' ]  = $Mobiles;
             $parameters['text' ]=$textMessage;
             $parameters[ 'isFlash'] = false;
             $parameters['udh' ]= "";
        try
        {
            $con = new SoapClient($webServiceURL);
            $responseSTD = (array) $con ->SendGroupSmsSimple($parameters);
            // echo 'OutPut Method Value.............................=>';
            // echo '</br>';
            return  [
                'result' => 'OK' ,
                'message' => $responseSTD['SendGroupSmsSimpleResult']
            ];
        }
        catch (SoapFault $ex)
        {
            return [
                'result' => 'KO',
                'message' => $ex->faultstring
                ];
        }
    }

    public static function sendCartNotification($mobiles)
    {
        $message = "مشتری گرامی فرآیند خرید شما تکمیل نشده است. لطفا از لینک زیر اقدام به تکمیل فرآیند نمایید:\r\n ";
        $message .= '"https://termetan.ir/cart"';


        Log::info('Sending notifications, mobiles count:'.count($mobiles));
        // ->map(function ($item) {
        //     return strtoupper($item->user->mobile);
        // });
        $result = [
                'result' => 'KO',
                'message' => 'کاربری موجود نیست!'
                ];

        // dd($mobiles->all());

        if (is_array($mobiles) && count($mobiles))
            $result = static::SendGroupSms($mobiles, $message );

        Log::info(json_encode($result));
        return $result;
    }

    public static function sendCartMessages()
    {

        $query = Cart::orderBy('created_at','DESC')
                    ->with('user')
                    ->with('order_values');

        $query->where('created_at', '>=', Carbon::now()->subMinutes(16)->toDateTimeString());

        $query->where('created_at', '<', Carbon::now()->subMinutes(15)->toDateTimeString());

        $query->doesntHave('order_values');

        $query->whereHas('user');

        $mobiles = $query->get()->pluck('user.mobile')->all();

        return static::sendCartNotification($mobiles);
    }


}
