<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/
 class WechatBrowserException extends Exception { const ERROR_MESSAGE = "\xe8\xaf\267\xe5\x9c\xa8\345\xbe\xae\344\xbf\xa1\xe6\xb5\217\xe8\xa7\x88\345\x99\250\344\xb8\xad\xe6\x89\223\xe5\xbc\200"; const ERROR_CODE = 5040; private $error_message; private $error_code; public function __construct() { $this->error_message = ERROR_MESSAGE; $this->error_code = ERROR_CODE; } public function getErrorMessage() { return $this->error_message; } public function setErrorMessage($error_message) { $this->error_message = $error_message; } public function getErrorCode() { return $this->error_code; } public function setErrorCode($error_code) { $this->error_code = $error_code; } }
