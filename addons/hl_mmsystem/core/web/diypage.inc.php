<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
