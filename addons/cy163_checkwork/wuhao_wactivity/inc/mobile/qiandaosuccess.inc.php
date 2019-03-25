<?php
//获取baoming数据
//加载视图
global $_W,$_GPC;
require_once dirname(__FILE__).'/common_mobile.php';


$matchid=$_GPC['matchid'];   
$id=$_GPC['id']; 

// logger("matchid :\n".$matchid);
// logger("id :\n".$id);
// logger("uniacid :\n".$_W['uniacid']);


$result=pdo_update('wactivity_baoming', array('qiandaostatus'=>'qiandao'), array('matchid'=>$matchid,'id'=>$id,'uniacid'=>$_W['uniacid']));
if($result){
	//echo '<script type="text/javascript">alert("qiandao成功！");</script>';
	//message('qiandao成功！',$this->createMobileUrl('qiandao',array()),'success');
	$data_players=pdo_fetch("SELECT * FROM ".tablename('wactivity_players')." WHERE `openid`=:openid AND `uniacid`=:uniacid",array(':openid'=>$_W['fans']['openid'],':uniacid'=>$_W['uniacid']));
	$data_players['joinnum']+=1;
	$data_players['chuqinratio']=$data_players['joinnum']/$data_players['totalnum']*100;
	updatejoinnum($data_players);

	echo "签到成功";
	//echo json_encode($data_baoming);
}else{		                    
    //echo '<script type="text/javascript">alert("qiandao失败，请重新操作一次！");</script>';
    //message('qiandao失败，请重新操作一次！',$this->createMobileUrl('qiandao',array()),'error');    
    echo "签到失败，请重新操作一次！";
}			
		
// function logger($content){
//     $logsize=100000;
//     $log="log.txt";
//     if(file_exists($log)&&filesize($log)>$logsize){
//         unlink($log);
//     }
//     file_put_contents($log,date('H:i:s')." ".$content."\n",FILE_APPEND);
// }
