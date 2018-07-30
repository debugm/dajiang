<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */

namespace Pay\Controller;

class Ylh5Controller extends PayController
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
            'PayName' => 'Ylh5', // 通道名称
            'zh_PayName' => '银联H5',
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
		

		$amt = $return['amount'];
		$oid = $return['orderid'];
		$userid = $return['userid'] + 10000;
		
		$nurl = $return['notifyurl'];
		

		$url = "http://".$_SERVER['SERVER_NAME']."/Pay/yl/h5.php?amt=".$amt."&oid=".$oid."&nurl=".$nurl;

		header("Location:".$url);
        }
    }


    public function callbackurl()
    {
	//exit("支付成功，如未到账，请联系网站客服，谢谢");
        $Order = M("Order");
        $pay_status = $Order->where("pay_orderid = '".$_REQUEST['orderid']."'")->getField("pay_status");
        if($pay_status <> 0) {
            $this->EditMoney2($_REQUEST['orderid'], 'Pawxsm', 1);
            echo "success";
        } 

    }

    
    public function notifyurl1()
    {
	

	
	$oid = $_GET['oid'];
	$this->EditMoney2($oid, 'Pawxsm', 0,1);
    }



    //服务器通知
    public function notifyurl()
    {	
	$res = $GLOBALS['HTTP_RAW_POST_DATA'];
	
	$res = json_decode($res,true);
	$oid = $res['out_trade_no'];
	
	$this->EditMoney2($res['out_trade_no'], 'Ylh5', 0,1);	
	echo 'success';
    }

}
