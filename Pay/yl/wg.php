<?php

$url = "https://p.orangepay.cn/openapi/trade/pay";

$amt = $_REQUEST['amt'];
$oid = $_REQUEST['oid'];
$nurl = $_REQUEST['nurl'];
$bc = $_REQUEST['bc'];


$p = array(

	'version' => '1.0',
	'appid' => '100818365845',
	'appkey' => 'ee7f72148e318778a671953ab3e3957a',
	'pay_type' => '1022',
	'issuer_code' => $bc,
	'commodity_name' => '联发超市购物',
	'amount' => $amt,
	'back_end_url' => $nurl,
	'return_url' => 'http://www.baidu.com',
	'merchant_no' => $oid,
);


ksort($p);

$s = "";
foreach($p as $k => $v)
{
    $s .= $k ."=". $v ."&";
}

$s = substr($s,0,strlen($s) - 1);

unset($p['appkey']);
$p['sign'] = md5($s);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($p));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
$res = json_decode($result,true);

if($res['retcode'] == '0000')
{
    $url = $res['retmsg'];
    header('Location:'.$url);
}
else
{
    exit("服务器异常，请稍后再试");
}

?>
