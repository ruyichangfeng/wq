<?php	
	global $_W,$_GPC;
	load()->func('tpl');
	if( checksubmit('join') ){
		//var_dump($_GPC);exit;
		if( empty($_GPC['username']) ){
			message('姓名为空',$this->createMobileUrl('join'),'error');
		}elseif ( empty($_GPC['mobile']) ) {
			message('电话为空',$this->createMobileUrl('join'),'error');
		}elseif ( !( preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",$_GPC['mobile']) ) ) {
			    message( '手机号码格式错误',$this->createMobileUrl('join'), 'error');
		}elseif ( empty($_GPC['thumb']) ) {
			message('照片为空',$this->createMobileUrl('join'),'error');
		}else{
				$fm['uniacid'] = $_W['uniacid'];
				$fm['openid'] = $_W['openid'];
				$fm['name'] = $_GPC['username'];
				$fm['gender'] = $_GPC['gender'];
				$fm['mobile'] = $_GPC['mobile'];
				$fm['pic'] = $_GPC['thumb'];
				$fm['msg'] = $_GPC['msg'];
				//var_dump($fm);exit;
				$res = pdo_insert('activity_signup_recording',$fm);
				if($res){
					message('保存成功',$this->createMobileUrl('join'),'success');
				}else{
					message('保存失败','','error');
				}
			}
	}
	$sql = "SELECT * FROM ".tablename('activity_signup_recording')." WHERE `uniacid`=:uniacid";
	$param = array(':uniacid'=>$_W['uniacid']);
	$res = pdo_fetchall($sql,$param);
	$total_num = count($res);
	$_SESSION['total_num'] = $total_num;
	include $this->template('join');