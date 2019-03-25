<?php
//获取报名数据
//加载视图
global $_W,$_GPC;

$module='qiandao';
$module_chinese="签到";
require_once dirname(__FILE__).'/common_mobile.php';

if(checksubmit('status')){
	$qiandaostatus = "qiandao";
}else{
	$qiandaostatus=null;
}	
if($qiandaostatus){
	$data_players=pdo_fetch("SELECT * FROM ".tablename('wactivity_players')." WHERE `openid`=:openid AND `uniacid`=:uniacid",array(':openid'=>$_W['fans']['openid'],':uniacid'=>$_W['uniacid']));
    $matchid=$_GPC['matchid'];    
    $price=$_GPC['price'];    
	if($data_players){
		if($data_players['img'] !== $_W['fans']['headimgurl']) {
            $data_players['img']=$_W['fans']['headimgurl'];
            $data_players['create_time']=date('y-m-d h:i:s',time());
            $result=pdo_update('wactivity_players', $data_players, array('openid' => $_W['fans']['openid'],'uniacid'=>$_W['uniacid']));            
            if($result){                 
                echo '<script type="text/javascript">alert("更新会员表头像成功！");</script>';
            }else{
                echo '<script type="text/javascript">alert("更新会员表头像失败！");</script>';
            }
        }	

        $data_groups_ticketsnum=pdo_fetch("SELECT * FROM ".tablename('wactivity_groups')." WHERE `uniacid`=:uniacid AND `groupname`=:groupname",array(':uniacid'=>$_W['uniacid'],':groupname'=>$data_players['groupname']));
		$data_groups=pdo_fetchall("SELECT * FROM ".tablename('wactivity_groups')." WHERE `uniacid`=:uniacid",array(':uniacid'=>$_W['uniacid']));
		foreach($data_groups as $index_groups=>$item_groups){	
			$str="num".$index_groups;					
			// $data_groups[$index_groups]['havebaomingnum']=$_GPC[$str];
			if($item_groups['groupname'] == $data_players['groupname']){
				$haveqiandaonum = $_GPC[$str];
			}
		}


        $data_baoming=pdo_fetch("SELECT * FROM ".tablename('wactivity_baoming')." WHERE `matchid`=:matchid AND `id`=:id AND `uniacid`=:uniacid",array(':matchid'=>$matchid,':id'=>$data_players['id'],':uniacid'=>$_W['uniacid']));        
		
        if($data_baoming['qiandaostatus'] == 'qiandao'){        	
        	message('请勿重复签到！',$this->createMobileUrl('qiandao',array()),'error');
        } elseif($data_baoming['baomingstatus'] != "baoming"){		    
		    message('您没有报名本场活动，签到无效！',$this->createMobileUrl('qiandao',array()),'error');		    
		} elseif($data_baoming['baomingstatus'] == "baoming" && $data_baoming['paystatus'] != 1){			
			message('您没有交费，签到无效，请先点击报名交费！',$this->createMobileUrl('baoming',array()),'error');
		}elseif($data_groups_ticketsnum['expect_qiandaonum'] <= $haveqiandaonum){
			message('没有票了，请下次活动尽早来签到！', $this->createMobileUrl('qiandao', array()), 'error');
		} else{	
			$data_matches=pdo_fetch("SELECT * FROM ".tablename('wactivity_matches')." WHERE `uniacid`=:uniacid AND `matchid`=:matchid",array(':uniacid'=>$_W['uniacid'],':matchid'=>$matchid));			
			include $this->template('distance');						
		}			
	}else{
		header('location:' . $this->createMobileUrl('addusers', array()));
	}
}else{
	list($data_matches_new,$data_total_group)=displaydetails($module,$module_chinese);
	include $this->template("qiandao");
}
