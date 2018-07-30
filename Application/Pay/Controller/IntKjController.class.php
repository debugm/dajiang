<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;

class IntKjController extends PayController
{
    //商户私钥
    private $merchant_private_key;
    //商户公钥
    private $merchant_public_key;
    //智付公钥
    private $dinpay_public_key;
    public function __construct()
    {
        parent::__construct();

    }

    //支付
    public function Pay(){
        $orderid = I("request.pay_orderid", "");
        $paymethod = I('post.pay_tradetype');
        $body = I('request.pay_productname','');
        $notifyurl = $this->_site . 'Pay_IntKj_notifyurl.html'; //异步通知
        $callbackurl = $this->_site . 'Pay_IntKj_callbackurl.html'; //返回通知
        $parameter = array(
            'PayName' => 'IntKj', // 通道名称
            'zh_PayName' => '快捷支付',
            'moneyratio' => 1, // 金额比例
            'tjurl' => '',
            'orderid' => $orderid,
            'body'=>$body,
        );
        // 订单号，可以为空，如果为空，由系统统一的生成
        //file_put_contents('./log.txt','fff\n',FILE_APPEND);
        $return = $this->orderadd($parameter);
        if ($return["status"] == "error") {
            $this->ErrorReturn($return["errorcontent"]);
        }else{
		
		$url = "http://paytest.shopping98.com/scan/pay/gateway";

$mch_id = "688544019374055424";
$key = "5ed95554b08845568a793d4c3171d911";

/*
 wechat	微信
alipay	支付宝
qq	Qq钱包
jd	京东钱包
baidu	百度钱包


*/

//var_dump($_GET);exit();

$p = array(
	'service' =>'v1_quick_pay',
	'version' =>'1.0',
	'mch_no' =>$mch_id,
	'user_id' => "10081",
	'charset' =>'UTF-8',
	'req_time' =>date('YmdHis'),
	'nonce_str' =>time(),
	'out_trade_no' =>$return['orderid'],
	'order_subject' =>'充值',
	'total_fee' =>floatval($return['amount']) * 100,
	'notify_url' =>$return["notifyurl"],
	'client_ip' => '122.114.184.166',
	'order_time' => date('YmdHis'),
);

$amt = $p['total_fee'] / 100;
$ddh = $p['out_trade_no'];
$s = "";
ksort($p);

foreach($p as $k => $v)
{
	$s .= $k . "=" .$v . "&";
}

$s = substr($s,0,strlen($s)-1); 

$s .= $key;
//echo $s.'<br>';
$sign = md5($s);
//echo $sign;exit();
$p['sign'] = $sign;
$p['sign_type'] = 'MD5';
//print_r($p);exit();
//print_r($s);
		$url = "http://payment.shopping98.com/quick/pay/gateway";
		$sHtml = "<form id='mobaopaysubmit' name='mobaopaysubmit' action='".$url."' method='post'>";
foreach($p as $key => $val ){
	$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
}

//echo $sHtml;exit();
$sHtml.= "</form>";
$sHtml.= "<script>document.forms['mobaopaysubmit'].submit();</script>";
			
echo $sHtml;

                            }
    }

    //页面通知
    public function callbackurl()
    {
        $Order = M("Order");
        $pay_status = $Order->where("pay_orderid = '".$_REQUEST['orderid']."'")->getField("pay_status");
        if($pay_status <> 0) {
            $this->EditMoney($_REQUEST['orderid'], 'Qtqq', 1);
            echo "success";
        }     

    }



    //服务器通知
    public function notifyurl()
    {
	 $sign = $_POST['sign'];
         unset($_POST['sign']);
unset($_POST['sign_type']);

ksort($_POST);
$s = "";

foreach($_POST as $k => $v)
{
    $s .= $k ."=". $v . "&";
}

$s = substr($s,0,strlen($s)-1); 
$key = "5ed95554b08845568a793d4c3171d911";
$s .= $key;

if($sign == md5($s))
{
	
         $this->EditMoney($_POST['out_trade_no'], 'IntKj', 0);
    }
}
}
