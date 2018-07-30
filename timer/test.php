<?php

$dbhost = 'localhost';
$dbuser  = 'root';
$dbpwd   = 'weiwei9527';
$dbname  = 'payment2';

$conn = mysql_connect($dbhost,$dbuser,$dbpwd);
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbname,$conn);
mysql_query("SET NAMES UTF8");
//清空限额
/*
$sql = "delete from pay_xiane where id>2";
mysql_query($sql);
*/

//清空所有现存子商户
/*
$sql = "delete from pay_userbankaccount where id>0";
mysql_query($sql);
*/

//删除三天前的订单记录
$time = strtotime('-3 day');

$sql = "delete from pay_order where pay_applydate<= {$time}";
$res = mysql_query($sql);
echo mysql_error();
echo mysql_affected_rows();
//清除微信特约商户的收款金额
$sql = "update pay_userbankaccount set maxmoney=0,enable=1 where id>0";
$res = mysql_query($sql);
echo mysql_error();
echo mysql_affected_rows();
?>
