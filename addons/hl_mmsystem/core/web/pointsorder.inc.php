<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');