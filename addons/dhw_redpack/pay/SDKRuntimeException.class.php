<?php
/**
 * @author 木兰东 http://mulandong.duapp.com/
 */
class  SDKRuntimeException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}

}

?>