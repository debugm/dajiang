<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;

class IntQQController extends PayController
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
        $notifyurl = $this->_site . 'Pay_IntQQ_notifyurl.html'; //异步通知
        $callbackurl = $this->_site . 'Pay_IntQQ_callbackurl.html'; //返回通知
        $parameter = array(
            'PayName' => 'IntQQ', // 通道名称
            'zh_PayName' => 'QQ扫码',
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
		/*
                $str_arr = array('application' => 'QQScanOrder',
                 'version' => '1.0.1',
                 'merchantId' => '1008658',
                 'merchantOrderId' => $return['orderid'],
                 'merchantOrderAmt' => $return["amount"] * 100,
                 'merchantOrderDesc' => "wxtest",
                 'userName' => 'Test',
                 'timestamp' => time(),
                 'merchantPayNotifyUrl' => $return["notifyurl"]);
                $xml = $this->arrToXml($str_arr);
                $strMD5 =  MD5($xml,true);
                $base64_src=base64_encode($xml);
                $strsign =  $this->sign($strMD5);
                $msg = $base64_src."|".$strsign;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://www.qtongpay.com/pay/pay.htm");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                $tmp = explode("|", $result);
                $resp_xml = base64_decode($tmp[0]);

                file_put_contents('./log.txt',$resp_xml,FILE_APPEND);

                 $array_data = json_decode(json_encode(simplexml_load_string($resp_xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
                $arr = $array_data["@attributes"];
		*/

		$url = "http://payment.shopping98.com/scan/pay/gateway";

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
	'service' =>'v1_scan_pay',
	'version' =>'1.0',
	'mch_no' =>$mch_id,
	'charset' =>'UTF-8',
	'req_time' =>date('YmdHis'),
	'nonce_str' =>time(),
	'out_trade_no' =>$return['orderid'],
	'order_subject' =>'充值',
	'acquirer_type' =>'qq',
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
$s = "";
ksort($p);
foreach($p as $k => $v)
{
	$s .= $k . "=" .$v . "&";
}
$s = substr($s,0,strlen($s)-1); 
//print_r($s);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $s);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);

$result = json_decode($result,true);
//print_r($result);
    $url = $result['code_url'];
                if($result['resp_code'] == "0000")
                {
                    import("Vendor.phpqrcode.phpqrcode",'',".php");
                    //$url = urldecode($url);
                    $QR = "Uploads/codepay/". $return["orderid"] . ".png";//已经生成的原始二维码图
                    \QRcode::png($url, $QR, "L", 20);

                    $this->assign("imgurl", $QR);
                    $this->assign('title',$body);
                    $this->assign('msg',"请通过QQ [扫一扫] 扫描二维码进行支付");
                    $this->assign("ddh", $return["orderid"]);
                    $this->assign("money", $return["amount"]);
                    $this->assign("web_title","QQ支付");
                    $this->assign("logo","logo-qqpay.png");
                    $this->display("WeiXin/Pay");
                }
                else
                {
		    file_put_contents("./log.txt",date('Y-m-d H:i:s').json_encode($result)."\n",FILE_APPEND);
                    echo "服务异常，请稍后再试...";
                    exit();
                }
            }
    }

    //页面通知
    public function callbackurl()
    {
        $Order = M("Order");
        $pay_status = $Order->where("pay_orderid = '".$_REQUEST['orderid']."'")->getField("pay_status");
        if($pay_status <> 0) {
            $this->EditMoney($_REQUEST['orderid'], 'IntQQ', 1);
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
	
         $this->EditMoney($_POST['out_trade_no'], 'IntQQ', 0);
    }
}
}
