<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
