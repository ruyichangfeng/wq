<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$uniname = $_W['uniaccount']['name'];
$unilogo =  $_W['uniaccount']['logo'];
$outurl = $_W['siteroot'].$_W['script_name']."?c=home&a=welcome&do=platform&";


$conf = pdo_get('xc_sysconfig',array('uniacid'=>$_W['uniacid']));
$bill = $conf['unit'];	
$title = $conf['title'];


if(empty($conf)) {
    pdo_insert('xc_sysconfig',array('uniacid'=>$_W['uniacid']));
    $conf = pdo_get('xc_sysconfig',array('uniacid'=>$_W['uniacid']));
}

 if(checksubmit()) {          
        $data['uniacid'] = $_W['uniacid'];
		$data['tokens'] = $_GPC['tokens'];
		$data['apiurl'] = $_GPC['apiurl'];
		$data['ishttps'] = $_GPC['ishttps'];
		$data['appid'] = $_GPC['appid'];
		$data['appsecrect'] = $_GPC['appsecrect'];
		$data['mchid'] = $_GPC['mchid'];
		$data['wxkey'] = $_GPC['wxkey'];
        pdo_update('xc_sysconfig',$data,array('uniacid'=>$_W['uniacid']));
        echo "<script>alert('配置保存成功！');window.location.href='".$this->createWeburl('sysconfig')."'</script>";
    }




include $this->template('sysconfig');


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


