<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
   global $_W, $_GPC;
   $operation = in_array ( $_GPC ['op'], array ('default', 'binding_for_students', 'binding_for_teachers', 'make_code') ) ? $_GPC ['op'] : 'default';

    if ($operation == 'default') {
	   die ( json_encode ( array (
			 'result' => false,
			 'msg' => '你是傻逼吗！'
			) ) );		
    }
	if ($operation == 'make_code') {
		mload()->model('sms');
		$weid = trim($_GPC['weid']);
		$mobile = trim($_GPC['mobile']);
		$schoolid = intval($_GPC['schoolid']);
		$bdset = get_weidset($weid,'bd_set');
		$smsset = get_weidset($weid,'sms_acss');	
		$resttime = empty($bdset['code_time']) ? 1800 : intval($bdset['code_time']);
		$sql = 'DELETE FROM ' . tablename('uni_verifycode') . ' WHERE `createtime`<' . (TIMESTAMP - $resttime);
		pdo_query($sql);
		$sql = 'SELECT * FROM ' . tablename('uni_verifycode') . ' WHERE `receiver`=:receiver AND `uniacid`=:uniacid';
		$pars = array();
		$pars[':receiver'] = $mobile;
		$pars[':uniacid'] = $weid;
		$row = pdo_fetch($sql, $pars);
		$record = array();
		if(!empty($row)) {
			if($row['total'] >= 5) {
				$data ['result'] = false;
				$data ['msg'] = '发送失败,请联系管理员';
			}
			$code = $row['verifycode'];
			$record['total'] = $row['total'] + 1;
		} else {
			$code = random(6, true);
			$record['uniacid'] = $weid;
			$record['receiver'] = $mobile;
			$record['verifycode'] = $code;
			$record['total'] = 1;
			$record['createtime'] = TIMESTAMP;
		}
		if(!empty($row)) {
			pdo_update('uni_verifycode', $record, array('id' => $row['id']));
		} else {
			pdo_insert('uni_verifycode', $record);
		}
		$content = array(
			'code' => $code
		);
		$result = sms_send($mobile, $content, $bdset['sms_SignName'], $bdset['sms_Code'], 'code', $weid, $schoolid);
		//print_r($result);
		if($result['Code'] == 'OK') {
			$data ['result'] = true;
			$data ['msg'] = '验证码发送成功, 请注意查收';
		}else{
			$data ['result'] = false;
			if($smsset['show_res'] == 1){
				$data ['msg'] = "发送失败,原因".$result['Message'];	
			}else{
				$data ['msg'] = "发送失败,请联系管理员";	
			}
		}
		die ( json_encode ( $data ) );		
	}
	if ($operation == 'binding_for_students') {
		$subjectId = trim($_GPC['subjectId']);
		$weid = trim($_GPC['weid']);
		$code = trim($_GPC['code']);
		$mobilecode = trim($_GPC['mobilecode']);
		$xuehao = trim($_GPC['xuehao']);
		$s_name = trim($_GPC['s_name']);
		$uid = trim($_GPC['uid']);
		$openid = trim($_GPC['openid']);
		$mobile = trim($_GPC['mobile']);
		$bdset = get_weidset($weid,'bd_set');
		if ($bdset['bd_type'] ==1 || $bdset['bd_type'] ==3){
			$condition .= " AND code = '{$code}'";
		}
		if ($bdset['bd_type'] ==2 || $bdset['bd_type'] ==3){
			$condition .= " AND numberid = '{$xuehao}'";
		}
		if ($bdset['binding_sms'] ==1){
			$status = check_verifycode($mobile, $mobilecode, $weid);
			if(!$status) {
			     die ( json_encode ( array (
                 'result' => false,
                 'msg' => '短信验证码错误！' 
		          ) ) );
			}
		}		
		$student = pdo_fetch("SELECT id,schoolid,mom,dad,own,other FROM " . tablename($this->table_students) . " where :weid = weid And :s_name = s_name $condition", array(
		         ':weid' => $weid,
				 ':s_name'=>$s_name
				  ));
		$user = pdo_fetch("SELECT id FROM " . tablename($this->table_user) . " where weid = :weid And :schoolid = schoolid And sid = :sid And uid = :uid ", array(
		         ':weid' => $weid,
                 ':schoolid' => $student['schoolid'],				 
		         ':sid' => $student['id'],
				 ':uid' => $uid,
	           	  ));
		if(!empty($user)){
			     die ( json_encode ( array (
                 'result' => false,
                 'msg' => '您已绑定本学生,不可重复绑定！' 
		          ) ) );
		}				  
		if(empty($student)){
			     die ( json_encode ( array (
                 'result' => false,
                 'msg' => '没有找到该生信息,或信息输入有误！' 
		          ) ) );
		}
		if($subjectId == 2){	
			if (!empty($student['mom'])){
				  die ( json_encode ( array (
                 'result' => false,
                 'msg' => '绑定失败，此学生母亲已经绑定了其他微信号！' 
		          ) ) );
			}	  
        }
		if($subjectId == 3){
			if (!empty($student['dad'])){
				  die ( json_encode ( array (
                 'result' => false,
                 'msg' => '绑定失败，此学生父亲已经绑定了其他微信号！' 
		          ) ) );
			}
        }
		if($subjectId == 4){
			if (!empty($student['own'])){
				  die ( json_encode ( array (
                 'result' => false,
                 'msg' => '绑定失败，此学生本人已经绑定了其他微信号！' 
		          ) ) );
			}
        }
		if($subjectId == 5){
			if (!empty($student['other'])){
				  die ( json_encode ( array (
                 'result' => false,
                 'msg' => '绑定失败，此学生家长已经绑定了其他微信号！' 
		          ) ) );
			}
        }		
		if (empty($openid)) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
			$userdata = array(
				'sid' => $student['id'],
				'weid' =>  $weid,
				'schoolid' => $student['schoolid'],
				'openid' => $openid,
				'pard' => $subjectId,
				'uid' => $uid		
			);
			if(!empty($_GPC['moblie'])){
				$userinfo = array(
					'name' => $s_name.get_guanxi($subjectId),
					'mobile' => $_GPC['moblie']
				);
				$userdata['userinfo'] = iserializer($userinfo);
			}			
			pdo_insert($this->table_user, $userdata);			
			$userid = pdo_insertid();
			if($subjectId == 2){
				$temp = array( 
				    'mom' => $openid,
					'muserid' => $userid,
					'muid'=> $uid
				    );
			}
			if($subjectId == 3){
				$temp = array(
				    'dad' => $openid,
					'duserid' => $userid,
					'duid'=> $uid
				    );
			}
			if($subjectId == 4){
				$temp = array(
				    'own' => $openid,
					'ouserid' => $userid,
					'ouid'=> $uid
				    );
			}
			if($subjectId == 5){
				$temp = array(
				    'other' => $openid,
					'otheruserid' => $userid,
					'otheruid'=> $uid
				    );
			}
            pdo_update($this->table_students, $temp, array('id' => $student['id'])); 		   			
			$data ['result'] = true;
			$data ['schoolid'] = $student['schoolid'];
			$data ['msg'] = '绑定成功！';
		}
		die ( json_encode ( $data ) );
    }
	
	if ($operation == 'binding_for_teachers') {
		$weid = trim($_GPC['weid']);
		$code = trim($_GPC['code']);
		$tname = trim($_GPC['tname']);
		$uid = trim($_GPC['uid']);
		$openid = trim($_GPC['openid']);
		$mobile = trim($_GPC['mobile']);
		$mobilecode = trim($_GPC['mobilecode']);
		$bdset = get_weidset($weid,'bd_set');
		if ($bdset['binding_sms'] == 1){
			$status = check_verifycode($mobile, $mobilecode, $weid);
			if(!$status) {
			     die ( json_encode ( array (
                 'result' => false,
                 'msg' => '无效验证码或已过期' 
		          ) ) );
			}
		}
		$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where :weid = weid And :tname = tname And :code = code ", array(
		         ':weid' => $weid,
				 ':tname'=>$tname,
				 ':code'=>$code
				  ));
		$user = pdo_fetch("SELECT id FROM " . tablename($this->table_teachers) . " where :schoolid = schoolid And :weid = weid And :openid = openid", array(
		         ':weid' => $weid,
				 ':schoolid' => $teacher['schoolid'],
				 ':openid'=>$openid
				  ));

		if ($user['id']) {
			  die ( json_encode ( array (
				'result' => false,
				'msg' => '抱歉,你已经绑定了本校其他教师！' 
				   ) ) );
		}				  
				  
		if (empty($openid)) {
			  die ( json_encode ( array (
				'result' => false,
				'msg' => '非法请求！' 
				   ) ) );
		}
		
		if(empty($teacher)){
			 die ( json_encode ( array (
			 'result' => false,
			 'msg' => '姓名,绑定码或手机号有误' 
			  ) ) );
		}
		if(!empty($teacher['openid'])){
			  die ( json_encode ( array (
			 'result' => false,
			 'msg' => '绑定失败，此教师已经绑定了其他微信号！' 
			  ) ) );
        }else{	   
		    pdo_insert($this->table_user, array (
					'tid' => trim($teacher['id']),
					'weid' =>  $weid,
					'schoolid' => $teacher['schoolid'],
					'openid' => $openid,
					'uid' => $uid
			));
			$userid = pdo_insertid();
			$temp = array('openid' => $openid, 'uid' => $uid, 'userid' => $userid);
			if(!empty($mobile)){
				$temp['mobile']= $mobile;
			}			
		    pdo_update($this->table_teachers, $temp, array('id' => $teacher['id']));
			$data ['result'] = true;
			$data ['schoolid'] = $teacher['schoolid'];
			$data ['msg'] = '绑定成功！';
		 die ( json_encode ( $data ) );
		}
    }	
?>