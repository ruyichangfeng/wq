<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
