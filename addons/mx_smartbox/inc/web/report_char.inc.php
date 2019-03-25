<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$uniname = $_W['uniaccount']['name'];
$unilogo =  $_W['uniaccount']['logo'];
$outurl = $_W['siteroot'].$_W['script_name']."?c=home&a=welcome&do=platform&";


include $this->template('report_char');


function replace_var($url,$string,$new_value){  
    while(substr($url,0,1)=="&")  
    {  
            $url=substr($url,1);  
    }  
    if($url!="")  
    {  
        $url_array=explode("&",$url);  
        $new_url='';  
        $string_len=strlen($string)+1;  
        $i=0;  
        while($url_array[$i])  
        {  
            if(substr($url_array[$i],0,$string_len)==$string."=")  
            {  
                $url_array[$i]=$string."=".$new_value;  
            }  
            if($i>0) $url_array[$i]="&".$url_array[$i];  
                $new_url=$new_url.$url_array[$i];  
                $i++;  
        }  
    }  
    else $new_url=$_SERVER['PHP_SELF'];  
    return $new_url;  
}


