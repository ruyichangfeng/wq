<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');