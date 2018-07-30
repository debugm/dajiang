<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;

class QhwxsmController extends PayController
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
            'PayName' => 'Qhwxsm', // 通道名称
            'zh_PayName' => 'Wx扫码-qh',
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
                $acclist = M('Userbankaccount')->where(array("userid" => $userid+10000,"enable" => 1,"bankcode" => "qh"))->select();
                $max = count($acclist) - 1;
                $sd = rand(0,$max);
                $mid = $acclist[$sd]['accountid'];
                $key = $acclist[$sd]['skid'];
		header("Content-type: text/html; charset=utf-8");
$pay_memberid = $mid;   //商户ID
$pay_orderid = $return['orderid'];    //订单号
$pay_amount = $return['amount'];    //交易金额
$pay_applydate = date("Y-m-d H:i:s");  //订单时间
$pay_notifyurl = $return['notifyurl'];   //服务端返回地址
$pay_callbackurl = $return['notifyurl'];  //页面跳转返回地址
$Md5key = $key;   //密钥
$tjurl = "http://xxpay.dhdz578.com/Pay_Index.html";   //提交地址
$pay_bankcode = "902";   //银行编码
//扫码
$native = array(
    "pay_memberid" => $pay_memberid,
    "pay_orderid" => $pay_orderid,
    "pay_amount" => $pay_amount,
    "pay_applydate" => $pay_applydate,
    "pay_bankcode" => $pay_bankcode,
    "pay_notifyurl" => $pay_notifyurl,
    "pay_callbackurl" => $pay_callbackurl,
);
ksort($native);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
//echo($md5str . "key=" . $Md5key);
$sign = strtoupper(md5($md5str . "key=" . $Md5key));
$native["pay_md5sign"] = $sign;
$native['pay_attach'] = "1234|456";
$native['pay_productname'] ='VIP基础服务';
	$sHtml = "<form id='mobaopaysubmit' name='mobaopaysubmit' action='".$tjurl."' method='post'>";
			foreach($native as $key=>$val) {
	            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
			}
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
            $this->EditMoney($_REQUEST['orderid'], 'IntQQ', 1);
            echo "success";
        }     

    }



    //服务器通知
    public function notifyurl()
    {
	
	$returnArray = array( // 返回字段
            "memberid" => $_REQUEST["memberid"], // 商户ID
            "orderid" =>  $_REQUEST["orderid"], // 订单号
            "amount" =>  $_REQUEST["amount"], // 交易金额
            "datetime" =>  $_REQUEST["datetime"], // 交易时间
            "transaction_id" =>  $_REQUEST["transaction_id"], // 流水号
            "returncode" => $_REQUEST["returncode"]
        );

	ksort($returnArray);
        reset($returnArray);
        $md5str = "";
        foreach ($returnArray as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }

	
	$mchid = $returnArray['memberid'];	
	$acclist = M('Userbankaccount')->where(array("accountid" => $mchid))->find();
	$key = $acclist['skid'];
        $sign = strtoupper(md5($md5str . "key=" . $key)); 
 	if ($sign == $_REQUEST["sign"]) {	
         $this->EditMoney2($_REQUEST['orderid'], 'Qhwxsm', 0,1);
    }
}
}
