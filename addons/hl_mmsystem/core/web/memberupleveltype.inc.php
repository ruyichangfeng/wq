<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');