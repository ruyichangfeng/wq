<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');