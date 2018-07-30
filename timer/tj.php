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

//生成统计报告

$sql = "select * from pay_xiane";

$res = mysql_query($sql);

while($ret = mysql_fetch_assoc($res))
{
    $result[$ret['subid']] = array();

    $result[$ret['subid']]['subid'] = $ret['subid'];
    $result[$ret['subid']]['sum_money'] = $ret['money'];
}

//获取子商户的订单统计

$starttime = mktime(0,0,0,date('m'),date('d'),date('Y'));
// 获取总订单数
$sql = "select pay_reserved1,count(pay_orderid),sum(pay_amount) from pay_order where pay_applydate>{$starttime} group by pay_reserved1";
$res = mysql_query($sql);

while($ret = mysql_fetch_assoc($res))
{
    $result[$ret['pay_reserved1']]['sum_orders'] = $ret['count(pay_orderid)'];
}

$sql = "select pay_reserved1,count(pay_orderid),sum(pay_amount) from pay_order where pay_applydate>{$starttime} and pay_status>0 group by pay_reserved1";
$res = mysql_query($sql);

while($ret = mysql_fetch_assoc($res))
{
    $result[$ret['pay_reserved1']]['cg_orders'] = !empty($ret['count(pay_orderid)']) ? $ret['count(pay_orderid)'] : 0;
}

file_put_contents(__DIR__."/chtj/".date('Y-m-d').".log",json_encode($result));


?>
