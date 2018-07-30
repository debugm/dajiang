<?php
$dbhost = 'localhost';
$dbuser  = 'root';
$dbpwd   = 'weiwei9527';
$dbname  = 'payment1';

$conn = mysql_connect($dbhost,$dbuser,$dbpwd);
if (!$conn) {
        die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbname,$conn);
mysql_query("SET NAMES UTF8");

$result = array();

// 获取现存所有子商户id

$sql = "select accountid from pay_userbankaccount where enable=1";

$res = mysql_query($sql);
$subidl = array();
while($ret = mysql_fetch_assoc($res))
{
	$subidl[$ret['accountid']]['subid'] = $ret['accountid'];
}




//获取子商户的订单统计,按时间维度，获取当前时间十分钟内的订单 


$endtime = time();
$starttime = strtotime(date('Y-m-d H:00:00',$endtime));
//$starttime = $endtime - 300;
// 获取总订单数

foreach($subidl as $item => $v)
{
    //获取总订单数
    $sql = "select count(pay_orderid) from pay_order where pay_applydate>{$starttime} and pay_applydate<{$endtime} and pay_reserved1='{$item}'";

    $res = mysql_query($sql);
    $ret = mysql_fetch_assoc($res);
    $subidl[$item]['sum_orders'] = $ret['count(pay_orderid)'];

    // 获取成功订单数
    $sql = "select count(pay_orderid) from pay_order where pay_applydate>{$starttime} and pay_applydate<{$endtime} and pay_reserved1='{$item}' and pay_status>0";

    $res = mysql_query($sql);
    $ret = mysql_fetch_assoc($res);
    $subidl[$item]['cg_orders'] = $ret['count(pay_orderid)'];
	
    
    $subidl[$item]['cgl'] = round($subidl[$item]['cg_orders'] / $subidl[$item]['sum_orders'] , 2) * 100 ."%";
    $cgl = round($subidl[$item]['cg_orders'] / $subidl[$item]['sum_orders'] , 2);	
    if($subidl[$item]['sum_orders'] > 5)
    {
 	      if($cgl < 0.30) 
	      {
	          $sql = "update pay_userbankaccount set enable=0 where accountid='{$item}'";
                  mysql_query($sql);

		
		  $str = date('H:i:s',$starttime)."--".date('H:i:s',$endtime)."------"."删除子商户：".$item."，成功率：".$cgl." ,提交：".$subidl[$item]['sum_orders']."，成功：".$subidl[$item]['cg_orders'];
                  file_put_contents(__DIR__."/fstj/".date('Y-m-d').".log.del",$str.PHP_EOL,FILE_APPEND);

	      }
    }

}

$str = date('H:i:s',$starttime)."-----".date('H:i:s',$endtime)."------:";
file_put_contents(__DIR__."/fstj/".date('Y-m-d').".log",$str.json_encode($subidl).PHP_EOL.PHP_EOL.PHP_EOL."-----------------------------------".PHP_EOL.PHP_EOL,FILE_APPEND);


?>
