<?php 
$IASTRURL =  str_replace("\\", '/', dirname(dirname(__FILE__)));
if(is_dir($IASTRURL."/zsk_market")){
    define('IA_ROOT', str_replace("\\", '/', dirname(dirname(__FILE__)))."/zsk_market");
}else{
    define('IA_ROOT', str_replace("\\", '/', dirname(dirname(__FILE__))));
}
include IA_ROOT."/template.func.php";
class WeModuleSite{
   function template($filename) {
	$source = ZSK_PATH . "template/{$filename}/.html";
	$compile = ZSK_PATH . "data/web/{$filename}.tpl.php";
	if(!is_file($source)) {
		$source = ZSK_PATH . "template/{$filename}.html";
		$compile = ZSK_PATH . "data/web/{$filename}.tpl.php";
	}
	if(!is_file($source)) {
		echo "template source '{$filename}' is not exist!";
		return '';
	}
	if(DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile)) {
		template_compile($source, $compile);
	}
     return $compile;
	}
}
/**
 * 
 */
class WeModuleWxapp
{
	
	
}