<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');