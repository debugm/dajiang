<?php

$url = "http://pay.zlf168game.com/wzpah5/PerPay.php";

$p = array(

	'mchid' => '5103',
	'fee' => 100,
	'order_sn' => rand(1000000,999999)."_".date('YmdHis'),
	'create_ip' => '192.168.1.1',
	'notify_url' => "http://pay.ziyubaihuo.com/wftnotify.php"

);

$p['sign'] = md5($p['mchid'].'&'.$p['fee'].'&'.$p['order_sn'].'&'.'eef36709235acdc7f524272de2f84968');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($p));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);

echo $result;

?>
