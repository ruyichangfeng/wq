<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$uniname = $_W['uniaccount']['name'];
$unilogo =  $_W['uniaccount']['logo'];
$outurl = $_W['siteroot'].$_W['script_name']."?c=home&a=welcome&do=platform&";


//代理商添加处理
if(checksubmit()) {
  		$data['uniacid'] = $_W['uniacid'];
		$data['user'] = $_GPC['user'];
		$data['pwd'] = md5($_GPC['pwd']);
		$data['true_name'] = $_GPC['true_name'];	
		$data['tel'] = $_GPC['tel'];
		$data['reg_time'] = time();	
		$data['ispay'] = $_GPC['ispay'];			
		$result = pdo_insert('xc_agent',$data);		
		 if($result){
			echo "<script>alert('操作成功！');window.location.href='".$this->createWeburl('list_agent')."'</script>";
		 }else{
			echo "<script>alert('操作失败！');window.history.back();</script>";
		 }
}




///////////////////
include $this->template('add_agent');


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


