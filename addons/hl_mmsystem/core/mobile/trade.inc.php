<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
