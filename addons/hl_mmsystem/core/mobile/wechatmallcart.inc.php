<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');