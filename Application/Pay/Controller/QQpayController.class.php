<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */

namespace Pay\Controller;

define("EXPIRETIME",300);
class QQpayController extends PayController
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
            'PayName' => 'QQpay', // 通道名称
            'zh_PayName' => 'QQ扫码支付',
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
		
		$ret = $this->getQrcode($amt,$oid,$userid);
		if($ret)
		{


                    $this->assign("imgurl", $ret['imgurl']);
                    $this->assign('title',$body);
                    $this->assign('msg',"请通过微信 [扫一扫] 扫描二维码进行支付");
                    $this->assign("ddh", $return["orderid"]);
                    $this->assign("amt", $return["amount"]);
                    $this->assign("web_title","QQ支付");
                    $this->assign("logo","logo-wxpay.png");
                    $this->display("WeiXin/QQ");
		}
		
        }
    }


    public function grmNotify()
    {
	
	file_put_contents("./wx.txt",date('Y-m-d H:i:s').json_encode($_POST)."-----".time().PHP_EOL,FILE_APPEND);
	

	$amt = $_POST['amount'];
	$wn = $_POST['login_wechat_name'];
	$paytime = $_POST['timestamp'];
	$msgid = $_POST['msgsvrid'];
	$remark = $_POST['remark'];
	$data = array();
	$data['wxname'] = $wn;
	$data['paytime'] = $paytime;
	$data['wxmsgid'] = $msgid;
	$data['remark'] = $remark;
	$data['amt'] = sprintf('%1.2f',$amt);
	
	M('Wxa')->add($data);

	$is_same = M('Wxo')->where(array('wxmsgid' => $msgid))->find();
	if($is_same)
	{
		exit('ok');
	}
	
	//todo ,此处要做来源验证 md5

	{

		
	
	}


	//var_dump($_POST);


	//查找微信订单表，看该金额是否存在
	$amt = sprintf("%1.2f",$amt);
	$ord = M('Wxo')->where(array('wxname' => $wn,'fee' => $amt,'status' => 0))->find();
	//var_dump($ord);
	//如果用户支付的金额是不存在的，则加入补单表

	
	
	if(!$ord)
	{
	    $data = array();
	    $data['wxname'] = $wn;
	    $data['fee'] = $amt;
	    $data['paytime'] = $paytime;
	    $data['wxmsgid'] = $msgid;
	    M('Wxe')->add($data);
	}
	//如果存在，则支付订单到账，释放该金额对应的图片 
	else
	{
		$remark = $ord['remark'];
		$ret = $this->autosf($remark,$amt);
		$data = array();
		$data['remark'] = $remark;
		$data['amt'] = $amt;
		$data['paytime'] = time();
		if($ret)
		{
		//上分记录
			$data['status'] = 1;
		}
		else
			$data['status'] = 2;

		M('Sf')->add($data);

	    M('Wxo')->where(array('id' => $ord['id']))->save(array('status' => 1,'wxmsgid' => $msgid));
	    
	    //查看该金额是不是固定金额
	    $wxq = M('Wxq')->where(array('wxname' => $wn,'subfee' => $amt))->find();
            if($wxq)
	    {
		//是，则释放
		M('Wxq')->where(array('id' => $wxq['id']))->save(array('lockstatus' => 0));
	    }
	    // 自动上分

	    

	    $this->EditMoney2($ord['oid'], 'Pawxsm', 0,1);

	    
	}
    }
	

    public function getQrcode($amt,$oid,$userid)
    {
	//$amt = number_format($amt,2);
	$amt = sprintf("%1.2f",$amt);
	//获取该用户对应的微信号
	$ret = array();
	$wxlist = M('Userbankaccount')->where(array('userid' => $userid,'bankcode' => 'qqgrm','enable' => 1))->select();
	
	$max = count($wxlist) - 1;
	$sd = rand(0,$max);
	$wx = $wxlist[$sd];
	//达到限额
	if(!$wx)
	{
    	    return false;
	}

	$wxname = $wx['accountid'];
	//$remark = explode("_",$oid)[1];
	//获取该微信号对应金额的图片，看是否锁定

	$q_list = M('Wxq')->where(array('wxname' => $wxname,'fee' => $amt))->select();
	//如果有该提交金额对应的码 
	if($q_list)
	{
		$find = 0;
		$id = -1;
		$min = 3533220279; //最早被锁定的
		foreach($q_list as $v)
		{
			if($v['lockstatus'] == 0)
			{
			    $find = 1;
			    //找到了当前金额对应的一个子金额图片
			    //$subfee = $ret['amt'] = $v['subfee'];
			    $remark = $v['remark'];
			    $pngname = str_replace('#','_',$remark);
			    $ret['imgurl'] = "Uploads/{$wxname}/{$pngname}.png";


			   //进行锁定，并写入微信订单表
			    $data = array();
			
			    $data['lockstatus'] = 1;
			    $data['locktime'] = time() + EXPIRETIME ; //锁定5分钟
			    $data['lock_oid'] = $oid;
			    M('Wxq')->where(array('id' => $v['id']))->save($data);    
			
			    $data = array();
			    //写入订单表
		            $data['wxname'] = $wxname;		    
		            $data['userid'] = $userid;		    
		            $data['oid'] = $oid;		    
		            $data['fee'] = $amt;		    
		            $data['oidtime'] = time();		    
		            $data['exptime'] = time() + EXPIRETIME ;		    
		            $data['type'] = 0;		
		            $data['status'] = 0;		
		            $data['remark'] = $remark;		
			    M('Wxo')->add($data); 

			    return $ret;
			
			}
			else
			{   
			    // 此处找到最早被锁定的那张码
		 	    if($v['locktime'] < $min)
			    {
 				$min = $v['locktime'];
				$id = $v['id'];
			    }    
			}
		}
		//如果当前金额图片都被锁定，则把最早锁定的那个图片给解除锁定，同时解除对应订单 
		if($find == 0)
		{
			if($id != -1)
			{
				//判断当前图片是否可以释放
				$imginfo = M('Wxq')->where("id=".$id)->find();
				//var_dump($imginfo);
				if($imginfo['locktime'] < time())
				{
					//M('Wxq')->where("id=".$id)->save(array('lockstatus' => 0));
					
					M('Wxo')->where("oid=".$imginfo['lock_oid'])->save(array("status" => 2));

					$remark = $imginfo['remark'];
                            		$pngname = str_replace('#','_',$remark);
                            		$ret['imgurl'] = "Uploads/{$wxname}/{$pngname}.png";


					$data['lockstatus'] = 1;
                            		$data['locktime'] = time() + EXPIRETIME ; //锁定5分钟
                            		$data['lock_oid'] = $oid;
                            		M('Wxq')->where(array('id' => $id))->save($data);   

                            		$data = array();
                            //写入订单表
                            		$data['wxname'] = $wxname;
                            		$data['userid'] = $userid;
                            		$data['oid'] = $oid;
                            		$data['fee'] = $amt;
                            		$data['oidtime'] = time();
                            		$data['exptime'] = time() + EXPIRETIME ;
                            		$data['type'] = 0;
                            		$data['status'] = 0;
                            		$data['remark'] = $remark;
                            		M('Wxo')->add($data);


					return $ret;


				}
				
			}
			return false;
		}
	}
	//如果没有该金额对应的图片，则显示默认图片
	else
	{	
	    /*
	    $ret['amt'] = $amt;
	    $ret['imgurl'] = "Uploads/{$wxname}/default.jpg";

	    //入订单
	    $data = array();
                            //写入订单表
            $data['wxname'] = $wxname;
            $data['userid'] = $userid;
            $data['oid'] = $oid;      
            $data['fee'] = $amt;
            $data['oidtime'] = time(); 
            $data['exptime'] = time() + EXPIRETIME ;
            $data['status'] = 0;		
            $data['type'] = 1;  // 类型为非固定金额码产生的订单      
            $data['remark'] = $remark;		
            M('Wxo')->add($data); 
	    
            return $ret;
	    */
	    return false;
	}

    }

    public function qqnotify()
    {
	$p = file_get_contents("php://input");
	file_put_contents("./qq.log.txt",date('Y-m-d H:i:s').$p.PHP_EOL,FILE_APPEND);
	$p = json_decode($p,true);
	if(!isset($p['summary2']))
	{
		exit("bad message!");
	}
	
	$msgurl = parse_url($p['msgUrl']);
	parse_str($msgurl['query'],$arr);
	
	$tranid = $arr['transId'];
	
	$remark = explode("：",$p['summary4'])[1];
	$amt = explode("：",$p['summary5'])[1];
	$pay_qq = preg_match("/\((.*)\)/",$p['summary2'],$matchs);
	$pay_qq = $matchs[1];
	$paytime = intval($p["time"]);
	

	//根据remark进行回调
	M('Wxq')->where(array('remark' => $remark))->save(array("lockstatus" => 0));
	M('Wxo')->where(array('remark' => $remark,'status' => 0))->save(array('paytime' => $paytime,"wxmsgid" => $tranid,"status" => 1,"payer" => $pay_qq));
	
	$oid = M('Wxo')->where(array('wxmsgid' => $tranid))->getField("oid");
	$this->EditMoney2($oid, 'QQpay', 0,1);
    }

    //页面通知
    public function cscallbackurl()
    {
    
	exit("订单超时，已关闭，请重新下单，谢谢");
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
	$p = $_POST;
        $sub_mch_id = $p['sub_mch_id'];
        $amt = intval($p['total_fee']) / 100;
	
	$m1 = M('Userbankaccount')->where("skid=".$sub_mch_id)->getField("maxmoney");
	
	$m2 = $m1 + $amt;
	
	M('Userbankaccount')->where("skid=".$sub_mch_id)->save(array("maxmoney" => $m2));
	if($m2 > 2500)
	{
		M('Userbankaccount')->where("skid=".$sub_mch_id)->save(array("enable" => 0));
	}

	$oid = $_GET['oid'];
	$pwd = $_POST['pwd'];
	if($pwd == 'miaomiao')
        	$this->EditMoney2($oid, 'Pawxsm', 0,1);
    }

}
