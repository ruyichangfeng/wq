<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');