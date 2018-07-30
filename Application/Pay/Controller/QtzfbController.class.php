<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;

class QtzfbController extends PayController
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
        $notifyurl = $this->_site . 'Pay_Qtzfb_notifyurl.html'; //异步通知
        $callbackurl = $this->_site . 'Pay_Qtzfb_callbackurl.html'; //返回通知
        $parameter = array(
            'PayName' => 'Qtzfb', // 通道名称
            'zh_PayName' => '支付宝扫码',
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

                $str_arr = array('application' => 'ZFBScanOrder',
                 'version' => '1.0.1',
                 'merchantId' => '1008618',
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

                if($arr['respCode'] == "0")
                {
                    import("Vendor.phpqrcode.phpqrcode",'',".php");
                    $url = urldecode($arr['codeUrl']);
                    $QR = "Uploads/codepay/". $return["orderid"] . ".png";//已经生成的原始二维码图
                    \QRcode::png($url, $QR, "L", 20);



                    $this->assign("imgurl", $this->_site.$QR);
                    $this->assign('title',$body);
                    $this->assign('msg',"请通过支付宝 [扫一扫] 扫描二维码进行支付");
                    $this->assign("ddh", $return["orderid"]);
                    $this->assign("money", $return["amount"]);
                    $this->assign("web_title","支付宝支付");
                    $this->assign("logo","logo-alipay.png");
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
            $this->EditMoney($_REQUEST['orderid'], 'Qtzfb', 1);
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
        $this->EditMoney($order_no, 'Qtzfb', 0);
    }

}