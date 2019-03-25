<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/
 class WxHongBaoException extends Exception { private $error_message; private $error_code; public function __construct($error_message, $error_code) { goto Ut4N9; CEqsE: $this->error_code = $error_code; goto lhY1I; cNwyP: $this->code = $error_code; goto AqYwB; lhY1I: $this->message = $error_message; goto cNwyP; Ut4N9: $this->error_message = $error_message; goto CEqsE; AqYwB: } public function getErrorCode() { return $this->error_code; } public function setErrorCode($error_code) { $this->error_code = $error_code; } public function getErrorMessage() { return $this->error_message; } public function setErrorMessage($error_message) { $this->error_message = $error_message; } }
