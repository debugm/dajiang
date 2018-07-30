<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;

class EsdqqwapController extends PayController
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
        $notifyurl = $this->_site . 'Pay_Qtwx_notifyurl.html'; //异步通知
        $callbackurl = $this->_site . 'Pay_Qtwx_callbackurl.html'; //返回通知
        $parameter = array(
            'PayName' => 'Esdqqwap', // 通道名称
            'zh_PayName' => 'QQwap-ESD',
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
		
		$mid = "1183";
$key = "E0D0ABDBC1064933B42C0E60612E7F71";

$url = "http://www.szsflwkj.com/pay/payment";

$p = array(

                "service" => "HFQQWAP", // yinlian .qq: HFQQWAP
                //"service" => "HFYLWAP", // yinlian .qq: HFQQWAP
                "version" => "v1.0",
                "signtype" => "MD5",
                "merchantid" => $mid,
                "shoporderId" => $return['orderid'],
                "totalamount" => number_format($return['amount'],2),
                "productname" => "charge",
                "notify_url" => $return['notifyurl'],
                "callback_url" => $return['callbackurl'],
                "nonce_str" => date('YmdHis'),

        );

$str = "";
ksort($p);
foreach($p as $k => $v)
{
        $str .= $k . "=" . $v . "&";
}
$str .= "key=".$key;
$p['sign'] = strtoupper(md5($str));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($p));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
$res = json_decode($result,true);
$jump = $res['code_url'];
header("Location:".$jump);

	}
    }

    //页面通知
    public function callbackurl()
    {
         echo 'SUCCESS'; 

    }



    //服务器通知
    public function notifyurl()
    {	
	$p = file_get_contents("php://input");
        file_put_contents("./log_esd.txt.hm",date('Y-m-d H:i:s')."notify-----".$p."\n",FILE_APPEND);
        $p = json_decode($p,true);
        $oid = $p['shoporderId'];
	
        echo 'SUCCESS';	
        $this->EditMoney2($oid, 'Esdqqwap', 0,1);
    }

}
