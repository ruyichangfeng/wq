<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');