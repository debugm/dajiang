<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;

class XmqqsmController extends PayController
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
            'PayName' => 'Xmqqsm', // 通道名称
            'zh_PayName' => 'QQsm-Xm',
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
	 	$userid = $return['userid'];
                $acclist = M('Userbankaccount')->where(array("userid" => $userid+10000,"enable" => 1))->select();
                $max = count($acclist) - 1;
                $sd = rand(0,$max);
		$mid = $acclist[$sd]['accountid'];
		$key = $acclist[$sd]['skid'];
	
		
		


	$url = "http://pay.xinmaozhifu.com/bank/index.aspx";

$p = array(

                'parter' => $mid,
                'type' => '1008',
                'value' => number_format($return['amount'],2),
                'orderid' => $return['orderid'],

                'callbackurl' => $return['notifyurl'],

        );

$str = "";
foreach($p as $k => $v)
{
        $str .= $k ."=" .$v. "&";
}

$str1 = substr($str,0,strlen($str)-1);



$str1 .= $key;

$p['sign'] = md5($str1);
$p['attach'] = $key;
$str = "";
foreach($p as $k => $v)
{
        $str .= $k ."=" .$v. "&";
}

$str = substr($str,0,strlen($str)-1);

$url .= "?".$str;

header("Location:".$url);
	
	




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
        file_put_contents("./log_esd.txt.xm",date('Y-m-d H:i:s')."notify-----".json_encode($_REQUEST)."\n",FILE_APPEND);
	$opstate = $_REQUEST['opstate'];
        $oid = $_REQUEST['orderid'];
	$ovalue = $_REQUEST['ovalue'];
	$attach = $_REQUEST['attach'];
	$str = "orderid=".$oid."&opstate=".$opstate."&ovalue=".$ovalue.$attach;

	$sign = md5($str);
	if($sign == $_REQUEST['sign'])
	{
        	echo 'opstate=0';	
        	$this->EditMoney2($oid, 'Xmqqsm', 0,1);
	}
    }

}
