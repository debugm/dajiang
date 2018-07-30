<?php


file_put_contents("./log.txt",date('Y-m-d H:i:s').json_encode($_REQUEST)."\r\n", FILE_APPEND);

$url = $_REQUEST['reserved1'];

$oid = $_REQUEST['orderid'];
$amt = $_REQUEST['amount'];

echo "OK";

$p = array(

	'signType' => 'MD5',
	'orderNo' => $oid,
	'orderAmount' => $amt,
	'orderCurrency' => 'CNY',
	'transactionId' => date('YmdHis'),
	'status' => 'success'
);

$key = '523417';

$str = "";

foreach($p as $k => $v)
{
	$str .= $v;
}

$str .= $key;

$p['sign'] = md5($str);

$str = http_build_query($p);

$url .= "?" . $str;

header("Location:".$url);
?>