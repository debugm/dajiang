<?php

 $xml = file_get_contents('php://input');
 libxml_disable_entity_loader(true);
 $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
 //file_put_contents("./log.txt",date('Y-m-d H:i:s').json_encode($values).PHP_EOL,FILE_APPEND);
$oid = $values['out_trade_no'];
$values['pwd'] = "miaomiao";
$url = $_SERVER['SERVER_NAME'].'/Pay_Pawxsm_notifyurl.html?oid='.$oid;
 //file_put_contents("./log.txt",date('Y-m-d H:i:s').$url.PHP_EOL,FILE_APPEND);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $values);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);


 $ret = '<xml>
   <return_code><![CDATA[SUCCESS]]></return_code>
   <return_msg><![CDATA[OK]]></return_msg>
</xml>';

echo $ret;


?>

