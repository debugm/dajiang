<?php
class AliPayException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
