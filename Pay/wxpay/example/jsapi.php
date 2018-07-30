<?php 
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';


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


$mchid = $_GET['mchid'];

$sql = "select * from pay_wxapp where mchid='{$mchid}'";

$res = mysql_query($sql);

$res = mysql_fetch_assoc($res);

if($res)
{
     $arr = array();
     $arr['appid'] = $res['appid'];
     $arr['mchid'] = $res['mchid'];
     $arr['key'] = $res['mchkey'];
     $arr['appkey'] = $res['appkey'];

     WxPayConfig::setConfig($arr);
    
}
else
{
    exit('商户账号异常');
}



//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();


//echo $openId;exit();

$oid = $_GET['oid'];
$amt = floatval($_GET['amt']) * 100;
$subid = $_GET['subid'];



//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("Charge");
$input->SetAttach("attach");


$input->SetOut_trade_no($oid);
$input->SetTotal_fee($amt);
$input->SetSubmchid($subid);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://qq.ziyubaihuo.com/Pay/wxpay/example/testnotify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);

//var_dump($order);exit();

$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
			function(res){
				var value1 = res.proviceFirstStageName;
				var value2 = res.addressCitySecondStageName;
				var value3 = res.addressCountiesThirdStageName;
				var value4 = res.addressDetailInfo;
				var tel = res.telNumber;
				
			}
		);
	}
	
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
		}
	};
	
	</script>
</head>
<body onload="callpay();">
</body>
</html>
