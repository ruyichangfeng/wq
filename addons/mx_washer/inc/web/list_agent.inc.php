<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'index';
$uniname = $_W['uniaccount']['name'];
$unilogo =  $_W['uniaccount']['logo'];
$outurl = $_W['siteroot'].$_W['script_name']."?c=home&a=welcome&do=platform&";
$cfg = pdo_get('xc_config',array('uniacid'=>$_W['uniacid'],'aid'=>$_GPC['aid']));

//获取代理商列表
$agentlist = "select *  from ".tablename('xc_agent')." where uniacid=".$_W['uniacid']." order by id desc";
$all_list = pdo_fetchall($agentlist);
$total_count = count($all_list);
$page_size = 6;
$page_count = ceil($total_count/$page_size);
if($cfg['ishttps'] == 1){
					$http = 'https';
		}else{
					$http = 'http';
}
if(array_key_exists('page',$_GPC)) {
	$url= $http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
} else {
	$url= $http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'] . "&page=1";
}
$pages = array();
for($i=0; $i<$page_count; $i++) {			
	$url=replace_var($url,"page",($i+1));
	$data['index'] = $i+1;
	$data['url'] = $url;
	array_push($pages,$data);
}		
$page = !empty($_GPC['page']) ? $_GPC['page'] : 1;
		
$sql = $agentlist . " LIMIT " . ($page-1)*$page_size . "," . $page_size;
$list = pdo_fetchall($sql);	


//设备统计
foreach($list as $k=>$v){		
	$dev_total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xc_device')." where aid=".$v['id']);
	$list[$k]['num_count'] = $dev_total;
}




//删除代理
if($op == 'del'){
	$id = intval($_GPC['id']);
	$wheres =[
		'id' => $id,
		'uniacid' => $_W['uniacid']
	];
	$result = pdo_delete('xc_agent',$wheres);
	if($result){
			echo "<script>alert('操作成功！');window.location.href='".$this->createWeburl('list_agent')."'</script>";
	}else{
			echo "<script>alert('操作失败！');window.history.back();</script>";
	}
}
		






include $this->template('list_agent');






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


