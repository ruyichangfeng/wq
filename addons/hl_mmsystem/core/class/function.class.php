<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');