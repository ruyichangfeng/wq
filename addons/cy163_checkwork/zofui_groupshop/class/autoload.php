<?php
	function zofuiGroupshop_autoLoad($class_name){
		$file = ZOFUI_GROUPSHOP . 'class/' . $class_name . '.class.php';	
		if(is_file($file)){
			require_once $file;
		}
		return false;
	}

	spl_autoload_register('zofuiGroupshop_autoLoad');

?>