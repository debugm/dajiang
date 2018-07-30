<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;

class Hmh5Controller extends PayController
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
            'PayName' => 'Hmh5', // 通道名称
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
		$acclist = M('Userbankaccount')->where(array("userid" => $userid+10000,"enable" => 1,"bankcode" => "pawxwap"))->select();		
		

		$max = count($acclist) - 1;
		
		/*
	
		 for($i = 0;$i <= $max; $i++)
                {
                        if($acclist[$i]['floating'] == 1)
                        {
                            $sub_mchid = $acclist[$i]['accountid'];
                            $jumpurl = $acclist[$i]['url'];
                            $skid = $acclist[$i]['skid'];
                            M('Userbankaccount')->where(array("accountid" => $sub_mchid,"userid" => $userid+10000))->save(array('floating' => 0));

                            if($i == $max)
                            {
                                M('Userbankaccount')->where(array("accountid" => $acclist[0]['accountid'],"userid" => $userid+10000))->save(array('floating' => 1));
                            }
                            else
                                M('Userbankaccount')->where(array("accountid" => $acclist[$i+1]['accountid'],"userid" => $userid+10000))->save(array('floating' => 1));
                            break;
                        }
                }
		*/
		//如果游标丢失
		//if(count($acclist) != 0 && !isset($sub_mchid))
		//{
			$sd = rand(0,$max);

                        $sub_mchid = $acclist[$sd]['accountid'];
                	$jumpurl = $acclist[$sd]['url'];
                	$skid = $acclist[$sd]['skid'];
		

		//}

		//file_put_contents("./log.hmh5.txt",date('Y-m-d H:i:s')."--".$sub_mchid.'--'.$userid.'---'.PHP_EOL,FILE_APPEND);
		//$sd = rand(0,$max);
		//var_dump($acclist);exit();
		
		//$sub_mchid = $acclist[$sd]['accountid'];
		//$jumpurl = $acclist[$sd]['url'];
		//$skid = $acclist[$sd]['skid'];
		//$mm = $acclist[$sd]['maxmoney'];
		//$sub_m =  M('Order')->where(array('pay_status'=>1,'pay_reserved1' => $sub_mchid,'pay_successdate'=>array('between',array(strtotime('today'),strtotime('tomorrow')))))->sum('pay_amount');
		//$sub_m +=  M('Order')->where(array('pay_status'=>2,'pay_reserved1' => $sub_mchid,'pay_successdate'=>array('between',array(strtotime('today'),strtotime('tomorrow')))))->sum('pay_amount');
		/*
		if($sub_m > intval($mm))
		{
		    $i++;
		    continue;
		}*/
		//else
		//{
		$amt = $return['amount'];
		$oid = $return['orderid'];
		$nurl = $return['notifyurl'];
		
		M('Order')->where(array('pay_orderid' => $oid))->save(array('pay_reserved1' => $sub_mchid,'pay_reserved2' => $skid));


		$ip = $realip = $_SERVER['REMOTE_ADDR'];
		$tjurl = "http://vip.ziyubaihuo.com/Pay/hm/wxh5.php?amt=".$amt.'&oid='.$oid.'&url='.$nurl."&subid=".$sub_mchid."&skid=".$skid."&jumpurl=".$jumpurl."&clip=".$ip;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $tjurl);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		//var_dump($result);
		if($result != "failed")
		{
			if($result == 'subiddongjie')
			{
			    M('Userbankaccount')->where(array("accountid" => $sub_mchid))->save(array('enable' => 0));
			    M('Subidinfo')->where(array("subid" => $sub_mchid))->save(array('status' => 2));
			    //echo json_encode(array('status' => -1,'msg' => '子商户被冻结'));
			    exit();
			}
			//M('Order')->where(array('pay_orderid' => $oid))->save(array('pay_reserved1' => $sub_mchid));		
			//var_dump($result);exit();


			//检查限额
			
		
			

			header("Location:".$result);
			exit();
		}
		//}

		//}
		
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
	$oid = explode("_",$oid)[0];
	$order = M('Order')->where(array('pay_orderid' => $oid))->find();
	$amt = $order['pay_amount'];
	$sub_mchid = $order['pay_reserved1'];
	$uid = $order['pay_memberid'];

	
	if($order['pay_status'] != 0)
	{
		exit('SUCCESS');
	}



	//检查限额
                                $rest = M('Xiane')->where(array('subid' => $sub_mchid))->find();
                        if(!$rest)
                        {
                                $data = array('subid'=>$sub_mchid,'money'=>$amt,'userid' => $uid);
                                M('Xiane')->add($data);

                        }
                        else
                        {
                                $max_m = floatval($rest['money']);
                                $new = $rest['money'] + $amt;
                                M('Xiane')->where(array('subid' => $sub_mchid))->save(array('money' => $new));
				if($sub_mchid == '204238640')
				{
					if($max_m > 69000)
	                                {
       		                                 M('Userbankaccount')->where(array("accountid" => $sub_mchid))->save(array('enable' => 0));
               		                 }

				}
				else
				{
                                if($max_m > 100000)
                                {
                                        M('Userbankaccount')->where(array("accountid" => $sub_mchid))->save(array('enable' => 0));
                                }
				}
                        }

                        $endtime = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
                        $now_time = time();

                        if($now_time >= $endtime)
                        {
                                M('Xiane')->where("status=1")->setField(array('money' => 0));
                        }







        //file_put_contents("./log.txt.hm",date('Y-m-d H:i:s')."notify-----".json_encode($_POST)."\n",FILE_APPEND);
        $this->EditMoney2($oid, 'Hmh5', 0,1);
	echo 'SUCCESS';
    }

}
