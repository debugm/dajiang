<?php
    header("Content-type:text/html;charset=utf-8");
    include_once("config.php");
    include_once("ali/AliPay.Data.php");
    include_once("ali/AliPay.Api.php");

    $url = $_SERVER['SERVER_NAME'];
   
    $notify_url = $_GET['nurl'];
    $return_url = 'http://'.$url.'result.php';

    $body= '小卖部';
    $total_fee=$_GET['amt']*100;
    $user_ip = "";
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $user_ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $user_ip = $_SERVER['REMOTE_ADDR'];
    }

    $out_trade_no=$_GET['oid'];

    function genRandomStr($length = 8, $is_num=false)
    {
        $randomStr = "";
        if ($is_num) {
            $oriStr = "1234567890";
        } else {
            $oriStr = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
        }
        $oriStrLen = strlen($oriStr);
        for ($i=0;$i<$length;$i++) {
            $randomStr .= $oriStr[mt_rand(0, $oriStrLen - 1)];
        }
        return $randomStr;
    }

    $input = new AliPayWapOrder($mch_config['mch_key']);

    $input->SetAppid($mch_config['mch_appid']);
    $input->SetMch_id($mch_config['mch_id']);
    $input->SetMethod("mbupay.alipay.sqm");
    $input->SetBody($body);
    $input->SetVersion('2.0.0');
    $input->SetOut_trade_no($out_trade_no);
    $input->SetTotal_fee($total_fee);
    $input->SetNotify_url($notify_url);
    $input->SetReturn_url($return_url);
    $order = AliPayApi::jswap($input);
if (isset($order['return_code'])&&isset($order['result_code'])&&$order['return_code'] == 'SUCCESS'
        && $order['result_code'] == 'SUCCESS'
        ) {
    $url=$order['code_url']; 
	header("Location:".$url);
}

?>
