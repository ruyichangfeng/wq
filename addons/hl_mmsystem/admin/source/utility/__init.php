<?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='http://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"http://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('F360EEBF4756C0C0AAQAAAAXAAAABJAAAACABAAAAAAAAAD/amltTAA4QrGVKvfFdsqn6P6XxZHzyv0THzLU1nyuX6LQ7fOcIsVb1KZveSUACeduF9PY2hSyQ9YZ6t0oLPj5Q7+eYQ05gn5Kmt3Xjp0SWlM5mEO10tcltsPZrtVHIHY2YtCUccGjD+hoBcKKK7pKvy/PaQE3gp5GgqTnRvFh9uXma0zXvTwGB+60VYMmjedMNwAAANAAAAAapN3WkIsz4UJdC4mlBwXrIAfA9xpPAobengtgfRsgks33tiAafED8OdQ66wGveDuL35RbjuOV6KSZIxnyLB3NOaL1d8qgQxE6tjN9SoOgJDvYFJSoGluCAp873MwZUCLhW/tFADvUynD4Af8w7Rer2HmDIBFo4FXzRKyqbRgTGxh4XDK1+pncqO+Dslmy+0AURuNviC4iGVt6NZb9zdPD12g/lwsdlYC3OXpaf2mXIPlti8Sk8UplxRyltqvo2/cbHeQsDYNvCZ7oYfYpLiKSOAAAANgAAACkoobAO2E3iCXDL41wQcM9xlyxFJR6yVg2NAc6B7qbgtDt3bzInNNHNnqc2mFeil6/5VnJLPbHG8sAB+cY0NzttWlKZg3O0wd2IKaBaausO2g/g1C2T0b8xs4uD+ppj2m8voTaVsmXibcp+4lZAO6ZH7hZ9YlqAUqEQyFTybbIPvXB6uRpXBsp44qwhdIW/hL2jz4aAi1iUEe4vfF6tvLsHHqJnmeKk8ovHMBY6Svmc4sw3iIMeORg+u4mc+lBylltGR0XUbuOwPDDtH6vMTIhSpqGZRSuoI0HAAAAwAAAANVyIEF60oG0uaCw8qN9rsUHrx+0rymYRDv5vn0bDbhH8uQeuWlPWwcW0WHERJRhzjnI+H1+x+O0XG+e0+07PHdZY9Ti9qXm/pcxeLR+PhyPHJqQaTtlwoBcZYQU636vDIHyaRP2HpnQmyTQTebJYuau7XPzR9Bg6nL4hOmIOdqcC+7M3N5PJz4+EdBhuls0UhPEK4saEyNSDbeQz2EmYwK2jjAuskpaEcn/tcE6nU8E92ajz+tQ6OYFQruwzpGezkcAAADAAAAAF7DRkZJBDf2UuWqRw184gVPiqD6uNRn3SglHfnjPTwaDvY14kF+QeqrBTlwH+Qx+RMZ6aAJgLQR6htRNM8p+s+FectxRF+f6Q6wG1yUb2VmoH/cOkVmXScFik3fX/pS1xpiFHbynBMn3ToWj+jgUedDzCCKb7sepf9cPUYL3avtIhLEEENqzpJFkr7sO5TQQKcYpYLwhCHdj1kZ8I10XHHreHkyToQHcQTuoR1yNAXAfFuzbxS0ggTaPj4h18fHbSAAAAMgAAACUtEGUbz8zU+emSdQMA/NZvcOANBimzZHUv9m+FzRja9mxPjE0QDER5El4XeoYbHbSij9RMSGrGiPlPx3L2Shh+thxzMZAt2cDy+580xIGVY32aHdCtmVyfGz9Q+vKNVz6jVsPQ2i4JdzRhrwibNjlsKFTfQ1sxcCNjiIB94yx5pDXZKdX9NpShH7GdVA7D+7AXn9KP/15g4pIqtT67NvGJ5o6XT20C+PzWXthqxWrDyVELQySkz+339aTVCZDN4rlC2b55g7F/QAAAAA=');