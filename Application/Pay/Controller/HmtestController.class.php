<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;

class HmtestController extends PayController
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
            'PayName' => 'Hmtest', // 通道名称
            'zh_PayName' => '微信H5支付－海马',
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
		

		//获取用户的账户进行轮询
		$userid = $return['userid'];
		$acclist = M('Userbankaccount')->where(array("enable" => 1,"bankcode" => "pawxwap"))->select();		
		$max = count($acclist) - 1;
		
		for($i = 0;$i <= $max; $i++)
		{
			    $sub_mchid = $acclist[$i]['accountid'];
                	    $jumpurl = $acclist[$i]['url'];
                            $skid = $acclist[$i]['skid'];
		

		
				$amt = $return['amount'];
		//$oid = $return['orderid'];
		$oid = date('YmdHis').rand(1111,9999);
		$nurl = $return['notifyurl'];

		$ip = $realip = $_SERVER['REMOTE_ADDR'];
		$tjurl = "http://vip.ziyubaihuo.com/Pay/hm/wxh5.php?amt=".$amt.'&oid='.$oid.'&url='.$nurl."&subid=".$sub_mchid."&skid=".$skid."&jumpurl=".$jumpurl."&clip=".$ip;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $tjurl);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		if($result != "failed" && $result != 'dongjie')
		{
			
			echo $sub_mchid."<br>";

			//M('Order')->where(array('pay_orderid' => $oid))->save(array('pay_reserved1' => $sub_mchid));		
			//var_dump($result);exit();
			//header("Location:".$result);
			//exit();
		}
		else 
		{
			if($result == 'dongjie')
			M('Userbankaccount')->where(array('accountid' => $sub_mchid))->save(array('enable' => 0,'floating' => 0));
		}

		}
		
        }
    }

    //页面通知
    public function callbackurl()
    {
        $Order = M("Order");
        $pay_status = $Order->where("pay_orderid = '".$_REQUEST['orderid']."'")->getField("pay_status");
        if($pay_status <> 0) {
            $this->EditMoney($_REQUEST['orderid'], 'Qtwx', 1);
            echo "success";
        }     

    }



    //服务器通知
    public function notifyurl()
    {	
	$oid = $_POST['out_trade_no'];
	
        file_put_contents("./log.txt.hm",date('Y-m-d H:i:s')."notify-----".json_encode($_POST)."\n",FILE_APPEND);
        $this->EditMoney2($oid, 'Hmh5', 0,1);
	echo 'SUCCESS';
    }

}
