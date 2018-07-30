<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-07-19
 * Time: 19:54
 */
namespace Pay\Controller;


class RSA {
    
    /**
     * 自定义错误处理
     */
    private function _error($msg) {
        die ( 'RSA Error:' . $msg ); // TODO
    }
    /**
     * 构造函数
     *
     * @param
     *          string 公钥文件（验签和加密时传入）
     * @param
     *          string 私钥文件（签名和解密时传入）
     */
    public function __construct() {
        $this->_getGCPublicKey ('/tmp/RSAKEY/gczf_rsa_public_dev.pem' );
        $this->_getPrivateKey ( '/tmp/RSAKEY/rsa_private_key_68.pem' );
    }
    
    /**
     * 生成签名
     *
     * @param
     *          string 签名材料
     * @param
     *          string 签名编码（base64/hex/bin）
     * @return 签名值
     */
    function sign($data, $padding = OPENSSL_PKCS1_PADDING) {
        $ret = false;
        if (! $this->_checkPadding ( $padding, 'en' ))
            $this->_error ( 'padding error' );
        if (openssl_private_encrypt ( $data, $result, $this->priKey, $padding )) {
            $ret = $this->_encode ( $result, "base64" );
        }
        return $ret;
    }
    
    /**
     * 验证签名
     *
     * @param
     *          string 签名材料
     * @param
     *          string 签名值
     * @param
     *          string 签名编码（base64/hex/bin）
     * @return bool
     */
    public function verify($data, $sign, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING) {
        $digest = sha1 ( $data, true );
        $sign = $this->_decode ( $sign, $code );
        if (openssl_public_decrypt ( $sign, $result, $this->gcPubKey, $padding )) {
            if ($digest == $result) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    /**
     * 加密
     *
     * @param
     *          string 明文
     * @param
     *          string 密文编码（base64/hex/bin）
     * @param
     *          int 填充方式（貌似php有bug，所以目前仅支持OPENSSL_PKCS1_PADDING）
     * @return string 密文
     */
    public function encrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING) {
        if (! $this->_checkPadding ( $padding, 'en' ))
            $this->_error ( 'padding error' );
        $len = "117";
        $strArray = str_split ( $data, $len );
        $ret = false;
        foreach ( $strArray as $cip ) {
            if (openssl_public_encrypt ( $cip, $result, $this->gcPubKey, $padding )) {
                $ret .= $result;
            }
        }
        $s = $ret;
        $hex = $this->_encode ( $s, "hex" );
        $ret = $this->_encode ( $ret, "base64" );
        return $ret;
    }
    
    /**
     * 解密
     *
     * @param
     *          string 密文
     * @param
     *          string 密文编码（base64/hex/bin）
     * @param
     *          int 填充方式（OPENSSL_PKCS1_PADDING / OPENSSL_NO_PADDING）
     * @param
     *          bool 是否翻转明文（When passing Microsoft CryptoAPI-generated RSA cyphertext, revert the bytes in the block）
     * @return string 明文
     */
    public function decrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING, $rev = false) {
        $ret = false;
        $data = $this->_decode ( $data, $code );
        if (! $this->_checkPadding ( $padding, 'de' ))
            $this->_error ( 'padding error' );
        if ($data != false) {
            $len = "128";
            $strArray = str_split ( $data, $len );
            foreach ( $strArray as $cip ) {
                if (openssl_private_decrypt ( $cip, $result, $this->priKey, $padding )) {
                    $ret .= $result;
                }
            }
        }
        return $ret;
    }
    
    /**
     * 检测填充类型
     * 加密只支持PKCS1_PADDING
     * 解密支持PKCS1_PADDING和NO_PADDING
     *
     * @param
     *          int 填充模式
     * @param
     *          string 加密en/解密de
     * @return bool
     */
    private function _checkPadding($padding, $type) {
        if ($type == 'en') {
            switch ($padding) {
                case OPENSSL_PKCS1_PADDING :
                    $ret = true;
                    break;
                default :
                    $ret = false;
            }
        } else {
            switch ($padding) {
                case OPENSSL_PKCS1_PADDING :
                case OPENSSL_NO_PADDING :
                    $ret = true;
                    break;
                default :
                    $ret = false;
            }
        }
        return $ret;
    }
    private function _encode($data, $code) {
        switch (strtolower ( $code )) {
            case 'base64' :
                $data = base64_encode ( $data );
                break;
            case 'hex' :
                $data = bin2hex ( $data );
                break;
            case 'bin' :
            default :
        }
        return $data;
    }
    private function _decode($data, $code) {
        switch (strtolower ( $code )) {
            case 'base64' :
                $data = base64_decode ( $data );
                break;
            case 'hex' :
                $data = $this->_hex2bin ( $data );
                break;
            case 'bin' :
            default :
        }
        return $data;
    }
    private function _getPublicKey($file) {
        $key_content = $this->_readFile ( $file );
        if ($key_content) {
            $this->pubKey = openssl_get_publickey ( $key_content );
        }
    }
    private function _getGCPublicKey($file) {
        $key_content = $this->_readFile ( $file );
        if ($key_content) {
            $this->gcPubKey = openssl_get_publickey ( $key_content );
        }
    }
    private function _getPrivateKey($file) {
        $key_content = $this->_readFile ( $file );
        if ($key_content) {
            $this->priKey = openssl_get_privatekey ( $key_content );
        }
    }
    private function _readFile($file) {
        $ret = false;
        if (! file_exists ( $file )) {
            $this->_error ( "The file {$file} is not exists" );
        } else {
            $ret = file_get_contents ( $file );
        }
        return $ret;
    }
    private function _hex2bin($hex = false) {
        $ret = $hex !== false && preg_match ( '/^[0-9a-fA-F]+$/i', $hex ) ? pack ( "H*", $hex ) : false;
        return $ret;
    }
}

class RequestHandler {
    
    /**
     * 网关url地址
     */
    var $gateUrl;
    
    /**
     * 密钥
     */
    var $key;
    
    /**
     * 请求的参数
     */
    var $parameters;
    
    /**
     * debug信息
     */
    var $debugInfo;
    function __construct() {
        $this->RequestHandler ();
    }
    function RequestHandler() {
        $this->gateUrl = "";
        $this->key = "";
        $this->parameters = array ();
        $this->debugInfo = "";
    }
    
    /**
     * 初始化函数。
     */
    function init() {
        // nothing to do
    }
    
    /**
     * 获取入口地址,不包含参数值
     */
    function getGateURL() {
        return $this->gateUrl;
    }
    
    /**
     * 设置入口地址,不包含参数值
     */
    function setGateURL($gateUrl) {
        $this->gateUrl = $gateUrl;
    }
    
    /**
     * 获取密钥
     */
    function getKey() {
        return $this->key;
    }
    
    /**
     * 设置密钥
     */
    function setKey($key) {
        $this->key = $key;
    }
    
    /**
     * 获取参数值
     */
    function getParameter($parameter) {
        return $this->parameters [$parameter];
    }
    
    /**
     * 设置参数值
     */
    function setParameter($parameter, $parameterValue) {
        $this->parameters [$parameter] = $parameterValue;
    }
    
    /**
     * 获取所有请求的参数
     *
     * @return array
     */
    function getAllParameters() {
        return $this->parameters;
    }
    
    /**
     * 获取带参数的请求URL
     */
    function getRequestURL() {
        $this->createSign ();
        
        $reqPar = "";
        ksort ( $this->parameters );
        foreach ( $this->parameters as $k => $v ) {
            if ("" != $v) {
                $reqPar .= $k . "=" . mb_convert_encoding ( $v, 'GBK', 'UTF-8' ) . "&";
            }
        }
        
        // 去掉最后一个&
        $reqPar = substr ( $reqPar, 0, strlen ( $reqPar ) - 1 );
        $m = new RSA ();
        $reqPar = $m->encrypt ( $reqPar );
        $reqPar = urlencode ( mb_convert_encoding ( $reqPar, 'GBK', 'UTF-8' ) );
        $requestURL = $this->getGateURL () . "?" . "cipher_data=" . $reqPar;
        return $requestURL;
    }
    
    /**
     * 获取debug信息
     */
    function getDebugInfo() {
        return $this->debugInfo;
    }
    
    /**
     * 重定向到国采付支付
     */
    function doSend() {
        header ( "Location:" . $this->getRequestURL () );
        exit ();
    }
    
    /**
     * 规则是:按参数名称a-z排序,遇到空值的参数不参加签名。
     */
    function createSign() {
        // 参数原串
        $signPars = "";
        // 按照键名排序
        ksort ( $this->parameters );
        // 生成原串
        foreach ( $this->parameters as $k => $v ) {
            // 值不为空或键不是sign
            if ("" != $v && "sign" != $k) {
                $signPars .= $k . "=" . mb_convert_encoding ( $v, 'GBK', 'UTF-8' ) . "&";
            }
        }
        
        // md5签名
        // 再拼接key字段
        $signPars .= "key=" . $this->getKey ();
        $sign = md5 ( $signPars );
        $this->setParameter ( "sign", $sign );
        
        // debug信息
        $this->_setDebugInfo ( $signPars . " => sign:" . $sign );
    }
    
    /**
     * 设置debug信息
     */
    function _setDebugInfo($debugInfo) {
        $this->debugInfo = $debugInfo;
    }
}




class TfbbankController extends PayController
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
        $notifyurl = $this->_site . 'Pay_Tfbbank_notifyurl.html'; //异步通知
        $callbackurl = $this->_site . 'Pay_Tfbbank_callbackurl.html'; //返回通知
        $parameter = array(
            'PayName' => 'Tfbbank', // 通道名称
            'zh_PayName' => '网银支付',
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

         
                $reqHandler = new RequestHandler ();
                // // 通信对象
                // $httpClient = new HttpClient ();
                // // 应答对象
                // $resHandler = new ClientResponseHandler ();

                // -----------------------------
                // 设置请求参数
                // -----------------------------
                $reqHandler->init ();
                $reqHandler->setKey ("12345");
                $reqHandler->setGateUrl ('http://apitest.tfb8.com/cgi-bin/v2.0/api_cardpay_apply.cgi');

                
                // ----------------------------------------
                // 设置请求参数
                // ----------------------------------------
                $reqHandler->setParameter ( "spid",'1800071515');
                $reqHandler->setParameter ( "sp_userid",$return['orderid']);
                $reqHandler->setParameter ( "spbillno", $return['orderid']);
                $reqHandler->setParameter ( "money", 1);
                $reqHandler->setParameter ( "cur_type", "1" );
                $reqHandler->setParameter ( "notify_url", $return["notifyurl"] );
                $reqHandler->setParameter ( "return_url", $return["notifyurl"] );
                //$reqHandler->setParameter ( "errpage_url", $errpage_url );
                $reqHandler->setParameter ( "memo", "test" );
                //$reqHandler->setParameter ( "expire_time", $expire_time );
                //$reqHandler->setParameter ( "attach", $_POST ["attach"] );
                $reqHandler->setParameter ( "card_type", 1 );
                $reqHandler->setParameter ( "bank_segment", "6666" );
                $reqHandler->setParameter ( "user_type", 1 );
                $reqHandler->setParameter ( "channel", 1 );
                $reqHandler->setParameter ( "encode_type", "MD5" );
                //$reqHandler->setParameter ( "risk_ctrl", "" );

                // 获取debug信息,建议把请求和debug信息写入日志，方便定位问题
                $reqUrl = $reqHandler->getRequestURL ();

                header("Location:{$reqUrl}");

                /*
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $reqUrl);
                //curl_setopt($ch, CURLOPT_POST, true);
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);

                */
                /*
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
                }*/
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