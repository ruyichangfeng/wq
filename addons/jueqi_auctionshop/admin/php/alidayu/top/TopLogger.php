<?php
class TopLogger
{
	public $conf = array(
		"separator" => "\t",
		"log_file" => ""
	);
	private $fileHandle;
	protected function getFileHandle(){}
	public function log($logData){}
	
}
?>