<?php
/**

 */
require_once "AliPay.Api.php";
class AliPayNotify extends AliPayNotifyReply
{
	/**
	 * 
	 * 回调入口
	 * @param bool $needSign  是否需要签名输出
	 */
	final public function Handle($needSign = true)
	{
	    
		//当返回false的时候，表示notify中调用NotifyCallBack回调失败获取签名校验失败，此时直接回复失败
		$result = $this->notify(array($this, 'NotifyCallBack'), $msg);
		if($result == false){
		    
			$this->SetReturn_code("FAIL");
			$this->SetReturn_msg("FAIL");
			$this->ReplyNotify(false);
			return;
		} else {
			//该分支在成功回调到NotifyCallBack方法，处理完成之后流程
			$this->SetReturn_code("SUCCESS");
			$this->SetReturn_msg("OK");
		}
		
		$this->ReplyNotify($needSign);
	}
	
	/**
	 *
	 * 支付结果通用通知
	 * @param function $callback
	 * 直接回调函数使用方法: notify(you_function);
	 * 回调类成员函数方法:notify(array($this, you_function));
	 * $callback  原型为：function function_name($data){}
	 */
	private function notify($callback, &$msg)
	{
		//获取通知的数据
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];

		//如果返回成功则验证签名
		try {
			$obj = new AliPayDataBase('');
			$obj->FromXml($xml);
			$values = $obj->GetValues();
			
			if($values['return_code'] != 'SUCCESS'
				|| $values['result_code'] != 'SUCCESS'
			){
				$result = $obj->GetValues();
			}else 
			{
			   
				$out_trade_no = $values['out_trade_no'];
				$key = $this->queryKey($out_trade_no);
				$this->SetKey($key);
				//$result = AliPayResults::Init($xml,$key);
				$result = $obj->GetValues();
			}

			return call_user_func($callback, $result);
			
		} catch (AliPayException $e){
			$msg = $e->errorMessage();

		}
	
		return false;
		
	}
	
	public function queryKey($out_trade_no)
	{
		return '';
	}
	
	/**
	 * 
	 * 回调方法入口，子类可重写该方法
	 * 注意：
	 * 1、微信回调超时时间为2s，建议用户使用异步处理流程，确认成功之后立刻回复微信服务器
	 * 2、微信服务器在调用失败或者接到回包为非确认包的时候，会发起重试，需确保你的回调是可以重入
	 * @param array $data 回调解释出的参数
	 * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
	 * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
	 */
	public function NotifyProcess($data, &$msg)
	{
		//TODO 用户基础该类之后需要重写该方法，成功的时候返回true，失败返回false
		return true;
	}
	
	/**
	 * 
	 * notify回调方法，该方法中需要赋值需要输出的参数,不可重写
	 * @param array $data
	 * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
	 */
	final public function NotifyCallBack($data)
	{

	    
		$result = $this->NotifyProcess($data, $msg);
		
		if($result == true){
			$this->SetReturn_code("SUCCESS");
			$this->SetReturn_msg("OK");
		} else {
			$this->SetReturn_code("FAIL");
			$this->SetReturn_msg("FAIL");
		}
		return $result;
	}
	
	/**
	 * 
	 * 回复通知
	 * @param bool $needSign 是否需要签名输出
	 */
	final private function ReplyNotify($needSign = true)
	{
	    
		//如果需要签名
		if($needSign == true && 
			$this->GetReturn_code() == "SUCCESS")
		{
			$this->SetSign();
		}
		$this->SetVersion(AliPayConfig::VERSION);
		
		AliPayApi::replyNotify($this->ToXml());
	}
}