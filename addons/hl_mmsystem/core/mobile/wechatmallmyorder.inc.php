<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
