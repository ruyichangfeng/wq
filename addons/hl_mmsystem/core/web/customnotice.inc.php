<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');