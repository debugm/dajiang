<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;

class TfbqqController extends PayController
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
        $notifyurl = $this->_site . 'Pay_Tfbqq_notifyurl.html'; //异步通知
        $callbackurl = $this->_site . 'Pay_Tfbqq_callbackurl.html'; //返回通知
        $parameter = array(
            'PayName' => 'Tfbqq', // 通道名称
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

         

                $msg = array(
                    'spid' => '1800776625',
                    'notify_url' => $return["notifyurl"],
                    'sp_billno' => $return['orderid'],
                    'spbill_create_ip' => '172.18.92.121',
                    'pay_type' => '800201',
                    'tran_amt' => $return["amount"] * 100,
                    'cur_type' => 'CNY',
                    'item_name' => "paysomething",
                    'out_channel' => 'qqpay',
                    'tran_time' => date('YmdHis')

                );

                ksort($msg);
                $str = "";
                foreach($msg as $k => $v)
                {
                    $str .= $k."=".$v."&";
                }
                $str = substr ( $str, 0, strlen ( $str ) - 1 );
                $sign_str = $str."&key=12345";
                $sign = md5($sign_str);

                $msg = $str."&sign=".$sign;


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://apitest.tfb8.com/cgi-bin/v2.0/api_wx_pay_apply.cgi?".$msg);
                //curl_setopt($ch, CURLOPT_POST, true);
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);


              
                 $array_data = json_decode(json_encode(simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
               
                if($array_data['retcode'] == "00")
                {
                    import("Vendor.phpqrcode.phpqrcode",'',".php");
                    $url = urldecode($array_data['qrcode']);
                    $QR = "Uploads/codepay/". $return["orderid"] . ".png";//已经生成的原始二维码图
                    \QRcode::png($url, $QR, "L", 20);
                    $this->assign("imgurl", $this->_site.$QR);
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
            $this->EditMoney($_REQUEST['orderid'], 'Tfbqq', 1);
            echo "success";
        }     

    }



    //服务器通知
    public function notifyurl()
    {
        
        $param = $_POST;
        $str = "";
        /*
        foreach($param as $k => $v)
        {
            $param[$k] = mb_convert_encoding($v, 'UTF-8' ,'GBK');
        }
        */


        $sign = $param['sign'];
        unset($param['sign']);
        unset($param['sign_type']);
        unset($param['input_charset']);
        unset($param['retcode']);
        unset($param['retmsg']);

        ksort($param);
        $str = "";
        foreach($param as $k => $v)
        {
            $str .= $k."=".$v."&";
        }
        $str = substr ( $str, 0, strlen ( $str ) - 1 );
        $sign_str = $str."&key=12345";
        $new_sign = md5($sign_str);

        if($sign == $new_sign)
        {
            
            $order_no = $param['sp_billno'];

            $this->EditMoney($order_no, 'Tfbqq', 0);
            echo "SUCCESS";
            exit();
        }
        else
        {
            foreach($param as $k => $v)
            {   
                $param[$k] = mb_convert_encoding($v, 'UTF-8' ,'GBK');
            }
            file_put_contents("./log.txt", "tfbqq_error_return: ".json_encode($param)."\n",FILE_APPEND);
        }

        
    }

}