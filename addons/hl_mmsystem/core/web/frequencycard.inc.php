<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
