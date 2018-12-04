<?php

namespace Qcloud\Sms\Demo;

require_once "SmsSender.php";
require_once  "SmsVoiceSender.php";

use Qcloud\Sms\SmsSingleSender;
use Qcloud\Sms\SmsMultiSender;
use Qcloud\Sms\SmsVoicePromtSender;
use Qcloud\Sms\SmsVoiceVeriryCodeSender;

$appid = "1400054729";
    $appkey = "d4a13246b5aba6d59c736541d2abc2c7";
    $phoneNumber1 = "15665531231";
    $phoneNumber2 = "14755336339";    
    $templId = "64659";


    $singleSender = new SmsSingleSender($appid, $appkey);

    $params = array(rand(1231,5555));
    //$params =rand(1231,5555);
   // $templId=31149;
    $result = $singleSender->sendWithParam("86", $phoneNumber1, $templId,  $params, "", "", "");

    $rsp = json_decode($result);
    echo $result;
    echo "<br>";
