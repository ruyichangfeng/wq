<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
