<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;

class DpbankController extends PayController
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
        $this->merchant_private_key = 'MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBANg3C6XLoX/T8OuHG6unoa2qBu0TA5E4iwyDAA6nP2bYsMYUasnphaVEItLwU5SUcPmEgETUwYk151HlDrA8A5wejLfCw294/Iyd2ipyeLitbqV50GDZSyMrkBs5fUT8mOwvOch4VBcdLOjlQJ2dkUvPCu1HdTXpqMBI+bwHHZaLAgMBAAECgYEAy/wyyvqwpS7JjwvquSnvyS4uVqCnruyPkwBMn4Z+tIMfU+GTVmcwpVkBGc2OrRDW/TFa6pVm+hKW6JaYIwCbzYP4wqGP3BRMz+HFeBkok/5eXmtQzgeymouLJ1qcTX1lu3EkoldCqhDlkdyDZjUjGY68fmb9LNITbGCFAeDcTHECQQD5mQ3pn82gDeWxI5QlPAGzk0LTQLtJtxaSkyPWq73w4ZGFydjqNOGOi3KZ216glXKaci0yVQHTHOTreiSNn3wnAkEA3cLJsdhLlgDcV2wC065Sd+fFJtVdf+AXK+pDwJMjyRFJwdciAqUN2CpbTIIX4DxejSapVEB5c25Cccnxbdt8/QJAdPd8xZbVzcO1eCWsLybHxVelYUpcelcKhPXfPaKOCGwsvf2xYVAWw64lrmRXG/ntEuOeuo+Lo1tPC+rZZmTu0QJATrZ7HPMnMSExFJ60CirP/tt3cSc+vsrtrprCXbJce1v1kCYqXkHzvgyax3dNvjvvW66jX9JayYwTbYw+c736iQJARX4n1y+OTyZW/EagJSWupDly7+tdsWAPiSOKlBxso3PSXo0XlqAaWFceavlslwG3VqAYDVQRbv8oxWZn898y8Q==';
        $this->merchant_public_key = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDYNwuly6F/0/Drhxurp6GtqgbtEwOROIsMgwAOpz9m2LDGFGrJ6YWlRCLS8FOUlHD5hIBE1MGJNedR5Q6wPAOcHoy3wsNvePyMndoqcni4rW6ledBg2UsjK5AbOX1E/JjsLznIeFQXHSzo5UCdnZFLzwrtR3U16ajASPm8Bx2WiwIDAQAB';
        $this->dinpay_public_key = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCq4NNfo2/cGGkmCgHe8kNaJSVx60PqKof37hMYJmZUawWVgWccWteJrJhAm/7PD2651l9enIzPQAd1qn1noWO3eUbFPNnj0cJJnlJgHLLTnYXHPPF7oQUT9TumcpYa/fCNEqCU68Sm21B2PPRNRXoaenh88NCtsbH3RDyeviqOiQIDAQAB';
    }

    //支付
    public function Pay(){
        $orderid = I("request.pay_orderid", "");
        $paymethod = I('post.pay_tradetype');
        $body = I('request.pay_productname','');
        $notifyurl = 'http://pay.yunshi44.top/Pay_ Dpbank_notifyurl.html'; //异步通知
        $callbackurl = 'http://pay.yunshi44.top/Pay_ Dpbank_callbackurl.html'; //返回通知
        $parameter = array(
            'PayName' => 'Dpbank', // 通道名称
            'zh_PayName' => '智付网银',
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
            $merchant_code = $return['sid'];//商户号，1118004517是测试商户号，线上发布时要更换商家自己的商户号！
            $service_type ="direct_pay";
            $interface_version ="V3.0";
            $sign_type ="RSA-S";
            $input_charset = "UTF-8";
            $notify_url = $notifyurl;
            $order_no = $return['orderid'];
            $order_time = date( 'Y-m-d H:i:s' );
            $order_amount = $return['amount'];
            $product_name =$body;

            //以下参数为可选参数，如有需要，可参考文档设定参数值
            $return_url ="";
            $pay_type = "";
            $redo_flag = "";
            $product_code = "";
            $product_desc = "";
            $product_num = "";
            $show_url = "";
            $client_ip ="" ;
            $bank_code = I('request.pay_bankcode');
            $extend_param = "";
            $extra_return_param = "";

            //参数组装
            /**
            除了sign_type参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
             */
            $signStr= "";

            if($bank_code != ""){
                $signStr = $signStr."bank_code=".$bank_code."&";
            }
            if($client_ip != ""){
                $signStr = $signStr."client_ip=".$client_ip."&";
            }
            if($extend_param != ""){
                $signStr = $signStr."extend_param=".$extend_param."&";
            }
            if($extra_return_param != ""){
                $signStr = $signStr."extra_return_param=".$extra_return_param."&";
            }
            $signStr = $signStr."input_charset=".$input_charset."&";
            $signStr = $signStr."interface_version=".$interface_version."&";
            $signStr = $signStr."merchant_code=".$merchant_code."&";
            $signStr = $signStr."notify_url=".$notify_url."&";
            $signStr = $signStr."order_amount=".$order_amount."&";
            $signStr = $signStr."order_no=".$order_no."&";
            $signStr = $signStr."order_time=".$order_time."&";
            if($pay_type != ""){
                $signStr = $signStr."pay_type=".$pay_type."&";
            }
            if($product_code != ""){
                $signStr = $signStr."product_code=".$product_code."&";
            }
            if($product_desc != ""){
                $signStr = $signStr."product_desc=".$product_desc."&";
            }
            $signStr = $signStr."product_name=".$product_name."&";
            if($product_num != ""){
                $signStr = $signStr."product_num=".$product_num."&";
            }
            if($redo_flag != ""){
                $signStr = $signStr."redo_flag=".$redo_flag."&";
            }
            if($return_url != ""){
                $signStr = $signStr."return_url=".$return_url."&";
            }
            $signStr = $signStr."service_type=".$service_type;
            if($show_url != ""){
                $signStr = $signStr."&show_url=".$show_url;
            }
            //echo $signStr."<br>";

            //获取sign值（RSA-S加密）
            $merchant_private_key = "-----BEGIN PRIVATE KEY-----"."\r\n".wordwrap(trim($this->merchant_private_key),64,"\r\n",true)."\r\n"."-----END PRIVATE KEY-----";
            $merchant_private_key= openssl_get_privatekey($merchant_private_key);
            openssl_sign($signStr,$sign_info,$merchant_private_key,OPENSSL_ALGO_MD5);
            $sign = base64_encode($sign_info);

            echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body onLoad="document.dinpayForm.submit();">';
            echo '<form name="dinpayForm" method="post" action="https://pay.dinpay.com/gateway?input_charset=UTF-8">';
            echo '<input type="hidden" name="sign"		  value="'.$sign.'">
			<input type="hidden" name="merchant_code" value="'.$merchant_code.'">
			<input type="hidden" name="bank_code"     value="'.$bank_code.'">
			<input type="hidden" name="order_no"      value="'.$order_no.'">
			<input type="hidden" name="order_amount"  value="'.$order_amount.'">
			<input type="hidden" name="service_type"  value="'.$service_type.'">
			<input type="hidden" name="input_charset" value="'.$input_charset.'">
			<input type="hidden" name="notify_url"    value="'.$notify_url.'">
			<input type="hidden" name="interface_version" value="'.$interface_version.'">
			<input type="hidden" name="sign_type"     value="'.$sign_type.'">
			<input type="hidden" name="order_time"    value="'.$order_time.'">
			<input type="hidden" name="product_name"  value="'.$product_name.'">
			<input Type="hidden" Name="client_ip"     value="'.$client_ip.'">
			<input Type="hidden" Name="extend_param"  value="'.$extend_param.'">
			<input Type="hidden" Name="extra_return_param" value="'.$extra_return_param.'">
			<input Type="hidden" Name="pay_type"  value="'.$pay_type.'">
			<input Type="hidden" Name="product_code"  value="'.$product_code.'">
			<input Type="hidden" Name="product_desc"  value="'.$product_desc.'">
			<input Type="hidden" Name="product_num"   value="'.$product_num.'">
			<input Type="hidden" Name="return_url"    value="'.$return_url.'">
			<input Type="hidden" Name="show_url"      value="'.$show_url.'">
			<input Type="hidden" Name="redo_flag"     value="'.$redo_flag.'">';
            echo '</form></body></html>';

        }
    }

    //页面通知
    public function callbackurl()
    {
        file_put_contents('d3.txt',file_get_contents('php://input'));
        $Order = M("Order");
        $pay_status = $Order->where("pay_orderid = '".$_REQUEST['orderid']."'")->getField("pay_status");
        if($pay_status <> 0) {
            $this->EditMoney($_REQUEST['orderid'], 'Dpbank', 1);
            echo "success";
        }

    }

    //服务器通知
    public function notifyurl()
    {
        file_put_contents('d.txt',serialize($_POST));
        $merchant_code	= $_POST["merchant_code"];
        $interface_version = $_POST["interface_version"];
        $sign_type = $_POST["sign_type"];
        $dinpaySign = base64_decode($_POST["sign"]);
        $notify_type = $_POST["notify_type"];
        $notify_id = $_POST["notify_id"];
        $order_no = $_POST["order_no"];
        $order_time = $_POST["order_time"];
        $order_amount = $_POST["order_amount"];
        $trade_status = $_POST["trade_status"];
        $trade_time = $_POST["trade_time"];
        $trade_no = $_POST["trade_no"];
        $bank_seq_no = $_POST["bank_seq_no"];
        $extra_return_param = $_POST["extra_return_param"];

        //参数组装  /////////////////////////////////
        /**
        除了sign_type dinpaySign参数，其他非空参数都要参与组装，组装顺序是按照a~z的顺序，下划线"_"优先于字母
         */

        $signStr = "";
        if($bank_seq_no != ""){
            $signStr = $signStr."bank_seq_no=".$bank_seq_no."&";
        }
        if($extra_return_param != ""){
            $signStr = $signStr."extra_return_param=".$extra_return_param."&";
        }
        $signStr = $signStr."interface_version=".$interface_version."&";
        $signStr = $signStr."merchant_code=".$merchant_code."&";
        $signStr = $signStr."notify_id=".$notify_id."&";
        $signStr = $signStr."notify_type=".$notify_type."&";
        $signStr = $signStr."order_amount=".$order_amount."&";
        $signStr = $signStr."order_no=".$order_no."&";
        $signStr = $signStr."order_time=".$order_time."&";
        $signStr = $signStr."trade_no=".$trade_no."&";
        $signStr = $signStr."trade_status=".$trade_status."&";
        $signStr = $signStr."trade_time=".$trade_time;

        //echo $signStr;
        ///////////////////////////////   RSA-S验证  /////////////////////////////////
        $dinpay_public_key = "-----BEGIN PUBLIC KEY-----"."\r\n".wordwrap(trim($this->dinpay_public_key),62,"\r\n",true)."\r\n"."-----END PUBLIC KEY-----";
        $dinpay_public_key = openssl_get_publickey($dinpay_public_key);
        $flag = openssl_verify($signStr,$dinpaySign,$dinpay_public_key,OPENSSL_ALGO_MD5);
        //响应"SUCCESS"
        if($flag){
            $this->EditMoney($order_no, 'Dpbank', 0);
            echo"SUCCESS";
        }else{
            echo"Verification Error";
        }

    }
}