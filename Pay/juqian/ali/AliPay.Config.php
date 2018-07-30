<?php
/**

 */
/**
* 	配置账号信息
*/

define('D_ALI_NOTIFY_URL', "http://103.230.240.33:10068/testnotify/notify");
define('D_ALI_JUMP_URL', "https://www.baidu.com");
define('D_GATEWAY_URL', "http://api.haoalipay.com/pay/gateway");

class AliPayConfig
{
	//=======【curl代理设置】===================================
	/**
	 * TODO：这里设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
	 * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
	 * 默认CURL_PROXY_HOST=0.0.0.0和CURL_PROXY_PORT=0，此时不开启代理（如有需要才设置）
	 * @var unknown_type
	 */
	const CURL_PROXY_HOST = "0.0.0.0";//
	const CURL_PROXY_PORT = 0;//8080;
	
	const NOTIFY_URL = D_ALI_NOTIFY_URL;

	const GATEWAY_URI = D_GATEWAY_URL;
	const VERSION = "2.0.0";  //支付接口版本号
	const TEST_MCH_ID = "";  //测试商户号
	const TEST_MCH_APPID = "";  //测试商户appid
	const TEST_MCH_KEY = "";  //测试商户key
}
