<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;

class QtbankController extends PayController
{

    public function __construct()
    {
        parent::__construct();
     
    }

    //支付
    public function Pay(){
        $orderid = I("request.pay_orderid", "");
        $paymethod = I('post.pay_tradetype');
        $body = I('request.pay_productname','');
        $notifyurl = $this->_site . 'Pay_Qtbank_notifyurl.html'; //异步通知
        $callbackurl = $this->_site . 'Pay_Qtbank_callbackurl.html'; //返回通知
        $parameter = array(
            'PayName' => 'Qtbank', // 通道名称
            'zh_PayName' => '网银支付',
            'moneyratio' => 1, // 金额比例
            'tjurl' => '',
            'orderid' => $orderid,
            'body'=>$body,
        );
        // 订单号，可以为空，如果为空，由系统统一的生成
        $return = $this->orderadd($parameter);
        if ($return["status"] == "error") {
            $this->ErrorReturn($return["errorcontent"]);
        }else{
            

                 $str_arr = array('application' => 'SubmitOrder',
                 'version' => '1.0.1',
                 'merchantId' => '1008618',
                 'merchantOrderId' => $return['orderid'],
                 'merchantOrderAmt' => $return["amount"] * 100,              
                 'accountType' => '0',
                 'orderTime' => date('YmdHis'),
                 'rptType' => '1',
                 'payMode' => '0',
                 'bankId' => $return['bankcode'],
                 'merchantPayNotifyUrl' => $return["notifyurl"]);


                $xml = $this->arrToXml($str_arr);
                $strMD5 =  MD5($xml,true);
                $base64_src=base64_encode($xml);
                $strsign =  $this->sign($strMD5);
                $msg = $base64_src."|".$strsign;

                /*
                $def_url =  '<div style="text-align:center">';
                $def_url .= '<body onLoad="//document.ipspay.submit();">网银订单确认';
                $def_url .= '<form name="ipspay" action="https://www.qtongpay.com/pay/pay.htm" method="post">';
                $def_url .= '<input name="msg" type="hidden" value="'.$msg.'" /><input type="submit" value="提交"/>';
                $def_url .= '</form></div>';
                echo $def_url;
                */
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://www.qtongpay.com/pay/pay.htm");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);

                echo $result;
                
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                $tmp = explode("|", $result);
                $resp_xml = base64_decode($tmp[0]);
                 $array_data = json_decode(json_encode(simplexml_load_string($resp_xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
                $arr = $array_data["@attributes"];
                

        }
    }

    //页面通知
    public function callbackurl()
    {
        $Order = M("Order");
        $pay_status = $Order->where("pay_orderid = '".$_REQUEST['orderid']."'")->getField("pay_status");
        if($pay_status <> 0) {
            $this->EditMoney($_REQUEST['orderid'], 'Qtbank', 1);
            echo "success";
        }     
    }


    //服务器通知
    public function notifyurl()
    {
        $result=file_get_contents('php://input', 'r');
        $tmp = explode("|", $result);
        $resp_xml = base64_decode($tmp[0]);
        $resp_sign = $tmp[1];
        $array_data = json_decode(json_encode(simplexml_load_string($resp_xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $arr = $array_data["@attributes"];

        $order_no = $arr['merchantOrderId'];

        //file_put_contents("./log.txt","notify-----".$order_no."\n",FILE_APPEND);
        $this->EditMoney($order_no, 'Qtbank', 0);
    }
}