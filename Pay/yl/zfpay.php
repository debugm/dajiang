<?php


//var_dump($_REQUEST);exit();

header("Content-type: text/html; charset=utf-8");
$pay_memberid = "10104";   //商户ID
$pay_orderid = $_REQUEST['pay_orderid'];    //订单号
$pay_amount = $_REQUEST['pay_amount'];    //交易金额
$pay_applydate = date("Y-m-d H:i:s");  //订单时间
$pay_bankcode = "907";
//echo $pay_bankcode;
//print_r($_POST);exit();
$pay_notifyurl = "http://www.hkboart.com/zf/notify.php";   //服务端返回地址
$pay_callbackurl = $_REQUEST['pickupUrl'];  //页面跳转返回地址
$Md5key = "blqsgya1gnc1xwgmi2m3ophb3bjof17m";   //密钥
$gateway = "https://www.paycv.com/Pay_Index.html";   //提交地址


$jsapi = array(
    "pay_memberid" => $pay_memberid,
    "pay_orderid" => $pay_orderid,
    "pay_amount" => $pay_amount,
    "pay_applydate" => $pay_applydate,
    "pay_bankcode" => $pay_bankcode,
    "pay_notifyurl" => $pay_notifyurl,
    "pay_callbackurl" => $pay_callbackurl,
);

ksort($jsapi);
$md5str = "";
foreach ($jsapi as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
//echo($md5str . "key=" . $Md5key."<br>");
$sign = strtoupper(md5($md5str . "key=" . $Md5key));
$jsapi["pay_md5sign"] = $sign;
//$jsapi["pay_tongdao"] = "Hfbwy"; //通道
$jsapi['pay_reserved1'] = $_REQUEST['pay_reserved1'];

$jsapi["pay_productname"] = '话费充值100元'; //商品名称
$jsapi["pay_bankname"] = $_REQUEST['pay_bankcode'];
//print_r($jsapi);exit();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>支付Demo</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<style>
.tabPages{
margin-top:150px;text-align:center;display:block; border:3px solid #d9d9de; padding:30px; font-size:14px;
}
</style>
<body onLoad="document.dinpayForm.submit();">
<div id="Content">
  <div class="tabPages">我们正在为您连接银行，请稍等......</div>
</div>
<div class="container">
    <div class="row" style="margin:15px;0;">

 <div class="col-md-12">

            <form class="form-inline" name="dinpayForm" method="post" action="<?php echo $gateway; ?>">
                <?php
                foreach ($jsapi as $key => $val) {
                    echo '<input type="hidden" name="' . $key . '" value="' . $val . '">';
                }
                ?>
            </form>
        </div>
    </div>

</div>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>

