<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */global $_W, $_GPC;
   $operation = in_array ( $_GPC ['op'], array ('default','addchild','useredit','jiaoliu','bdxs','bdls','unboundls','qingjia','agree','defeid','sagree','sdefeid','savemsg','xsqingjia','savesmsg','getbjlist','signup','txshbm','xgxsinfo','tgsq','jjsq', 'bangdingcardjl', 'jbidcard', 'changeimg', 'changePimg', 'changeimgt','showchecklog') ) ? $_GPC ['op'] : 'default';

     if ($operation == 'default') {
	           die ( json_encode ( array (
			         'result' => false,
			         'msg' => '你是傻逼吗！'
	                ) ) );
     }			
     if ($operation == 'useredit') {
	     $data = explode ( '|', $_GPC ['json'] );
	      
            if (empty($_GPC ['schoolid'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	         }
	       	       
		   $user = pdo_fetch ( 'SELECT * FROM ' . tablename ( $this->table_user ) . ' WHERE id = :id ', array (':id' => $_GPC ['userid']));
	       	      
           if (empty($user)) {
		        die ( json_encode ( array (
				  'result' => false,
				  'msg' => '非法请求！' 
		              ) ) );
	        } else {
		        		         
				if ($user ['status'] == 1) {
		     	     
					$data ['result'] = false; // 
					 
			        $data ['msg'] = '抱歉您的帐号被锁定，请联系校方！';
		         
				} else {
					
					$info = array ('name' => $_GPC ['name'],'mobile' => $_GPC ['mobile']);
			        
                    $temp['userinfo'] = iserializer($info);					
					
			        pdo_update ( $this->table_user, $temp, array ('id' => $user ['id']) );

					if(!empty($_GPC['parentid'])){
						pdo_update ( $this->table_parents, $temp, array ('id' => $_GPC['parentid']) );
					}
			        $data ['result'] = true;
			
			        $data ['msg'] = '修改成功！';
		        }
		      die ( json_encode ( $data ) );
	        }
    }
	if ($operation == 'bdxs') {
		//变更为家长注册
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_W ['openid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	         }
	    // $s_name = trim($_GPC['s_name']);
         $mobile = trim($_GPC['mobile']);
//		$subjectId = trim($_GPC['subjectId']);

		$pid = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where :schoolid = schoolid And :weid = weid And :mobile = mobile", array(
		         ':weid' => $_GPC ['weid'],
				 ':schoolid' => $_GPC ['schoolid'],
				 ':mobile'=>$_GPC ['mobile']
				  ));
//		$user = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And weid = :weid AND sid=:sid And uid =:uid ", array(
//		         ':weid' => $_GPC ['weid'],
//                 ':schoolid' => $_GPC ['schoolid'],
//		         ':sid' => $pid['id'],
//				 ':uid' => $_GPC['uid'],
//	           	  ));
//        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where :schoolid = schoolid And weid = :weid AND id=:id ", array(
//		         ':weid' => $_GPC ['weid'],
//                 ':schoolid' => $_GPC ['schoolid'],
//		         ':id' => $sid['id']
//	           	  ));
		if(!empty($pid)){
			     die ( json_encode ( array (
                 'result' => false,
                 'msg' => '手机号码已经注册过,不可重复注册！'
		          ) ) );
		}				  
//		if(empty($sid['id'])){
//			     die ( json_encode ( array (
//                 'result' => false,
//                 'msg' => '没有找到该生信息！'
//		          ) ) );
//		}
//		if($subjectId == 2){
//			if (!empty($item['mom'])){
//				  die ( json_encode ( array (
//                 'result' => false,
//                 'msg' => '绑定失败，此学生母亲已经绑定了其他微信号！'
//		          ) ) );
//			}
//        }
//		if($subjectId == 3){
//			if (!empty($item['dad'])){
//				  die ( json_encode ( array (
//                 'result' => false,
//                 'msg' => '绑定失败，此学生父亲已经绑定了其他微信号！'
//		          ) ) );
//			}
//        }
//		if($subjectId == 4){
//			if (!empty($item['own'])){
//				  die ( json_encode ( array (
//                 'result' => false,
//                 'msg' => '绑定失败，此学生本人已经绑定了其他微信号！'
//		          ) ) );
//			}
//        }
//		if($subjectId == 5){
//			if (!empty($item['other'])){
//				  die ( json_encode ( array (
//                 'result' => false,
//                 'msg' => '绑定失败，此学生家长已经绑定了其他微信号！'
//		          ) ) );
//			}
//        }
		if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
//		   pdo_insert($this->table_user, array (
//					'sid' => trim($sid['id']),
//					'weid' =>  $_GPC ['weid'],
//					'schoolid' => $_GPC ['schoolid'],
//					'openid' => $_W ['openid'],
//					'pard' => $subjectId,
//					'uid' => $_GPC['uid']
//			));
//			$userid = pdo_insertid();
//			if($subjectId == 2){
//				$temp = array(
//				    'mom' => $_GPC['openid'],
//					'muserid' => $userid,
//					'muid'=> $_GPC['uid']
//				    );
//			}
//			if($subjectId == 3){
//				$temp = array(
//				    'dad' => $_GPC['openid'],
//					'duserid' => $userid,
//					'duid'=> $_GPC['uid']
//				    );
//			}
//			if($subjectId == 4){
//				$temp = array(
//				    'own' => $_GPC['openid'],
//					'ouserid' => $userid,
//					'ouid'=> $_GPC['uid']
//				    );
//			}
//			if($subjectId == 5){
//				$temp = array(
//				    'other' => $_GPC['openid'],
//					'otheruserid' => $userid,
//					'otheruid'=> $_GPC['uid']
//				    );
//			}

			$temp = array(
				    'schoolid' => $_GPC['schoolid'],
					'weid' => $_GPC['weid'],
					'uid' => $_GPC['uid'],
				    'name' => trim($_GPC['name']),
					'mobile' => $_GPC['mobile'],
					'openid' => trim($_GPC['openid']),
					'area_addr' => trim($_GPC['home_address']),
					'area_addr_location' => json_encode(array('lng' => trim($_GPC['lng']),'lat' => trim($_GPC['lat']))),
					'createdate' => time()
				    );
            $result = pdo_insert($this->table_parents, $temp);
            if(!empty($result)){
				$info = array ('name' => $_GPC['name'],'mobile' => $_GPC['mobile'],'lng' => trim($_GPC['lng']),'lat' => trim($_GPC['lat']));
				pdo_insert($this->table_user, array (
					'pid' => pdo_insertid(),
					'weid' =>  $_GPC ['weid'],
					'schoolid' => $_GPC ['schoolid'],
					'openid' => $_W ['openid'],
					'uid' => $_GPC['uid'],
					'userinfo' => iserializer($info)
				));

				$data ['result'] = true;

				$data ['msg'] = '注册成功！';
			}else{
				$data ['result'] = false;

				$data ['msg'] = '注册失败！';
			}

		 die ( json_encode ( $data ) );
		}
    }
	
	if ($operation == 'bdls') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_W ['openid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	         }
		
		$tid = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where :schoolid = schoolid And :weid = weid  And :mobile = mobile", array(
		         ':weid' => $_GPC ['weid'],
				 ':schoolid' => $_GPC ['schoolid'],
//				 ':tname'=>$_GPC ['tname'],
				 ':mobile'=>$_GPC ['mobile']
				  ), 'id');
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id ORDER BY id DESC", array(
		         ':weid' => $_GPC ['weid'], 
		         ':id' => $tid['id']
	           	  ));

		$user = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where :schoolid = schoolid And :weid = weid And :openid = openid", array(
		         ':weid' => $_GPC ['weid'],
				 ':schoolid' => $_GPC ['schoolid'],
				 ':openid'=>$_GPC ['openid']
				  ), 'id');

		if ($user['id']) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '抱歉,注册失败，您已注册过！'
		               ) ) );
		}
				  
		if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}
		
//		if(empty($tid['id'])){
//			     die ( json_encode ( array (
//                 'result' => false,
//                 'msg' => '姓名或绑定码输入有误！'
//		          ) ) );
//		}
		if(!empty($item['openid'])){
		   
				  die ( json_encode ( array (
                 'result' => false,
                 'msg' => '注册失败，您已注册过！'
		          ) ) );
		    
        }else{
  	        $temp = array(
				'weid' =>  $_GPC ['weid'],
				'schoolid' => $_GPC ['schoolid'],
				'openid' => $_W ['openid'],
				'uid' => $_GPC['uid'],
				'tname' => trim($_GPC['tname']),
				'mobile' => $_GPC['mobile'],
				'sex' => $_GPC['sex'],
				'jiontime' => time(),
				'area_addr' => trim($_GPC['home_address']),
				'area_addr_location' => json_encode(array('lng' => trim($_GPC['lng']),'lat' => trim($_GPC['lat']))),
				'sort' => 0,

			);
			$res = pdo_insert($this->table_teachers,$temp);
			$tid = pdo_insertid();
			if(!empty($res)){
				$info = array ('name' => $_GPC['name'],'mobile' => $_GPC['mobile'],'lng' => trim($_GPC['lng']),'lat' => trim($_GPC['lat']));
				pdo_insert($this->table_user, array (
					'tid' => $tid,
					'weid' =>  $_GPC ['weid'],
					'schoolid' => $_GPC ['schoolid'],
					'openid' => $_W ['openid'],
					'uid' => $_GPC['uid'],
					'userinfo' => iserializer($info)
				));
				$userid = pdo_insertid();
				$temp = array('userid' => $userid);
				pdo_update($this->table_teachers, $temp, array('id' => $tid));
				$data ['result'] = true;
				$data ['msg'] = '注册成功！';
			}else{
				$data ['result'] = false;
				$data ['msg'] = '注册失败！';
			}

		 die ( json_encode ( $data ) );
		}
    }	

	if ($operation == 'unboundls') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	         }
		
		$user = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where :schoolid = schoolid And :weid = weid And :openid = openid", array(
		         ':weid' => $_GPC ['weid'],
				 ':schoolid' => $_GPC ['schoolid'],
				 ':openid'=>$_GPC ['openid']
				  ), 'id');

		if (empty($user['id'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求，没找你的老师信息！' 
		               ) ) );
		}				  
				  
		if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
			
			$temp = array(
			        'openid' => '',
		           	'uid'    => 0
			       );
           pdo_update($this->table_teachers, $temp, array('id' => $_GPC['tid']));			   
           pdo_delete($this->table_user, array('id' => $_GPC['user']));	
			
			$data ['result'] = true;
			
			$data ['msg'] = '解绑成功！';

		 die ( json_encode ( $data ) );
		}
    }

	if ($operation == 'qingjia') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	         }
		
		$user = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where :schoolid = schoolid And :weid = weid And :openid = openid", array(
		         ':weid' => $_GPC ['weid'],
				 ':schoolid' => $_GPC ['schoolid'],
				 ':openid'=>$_GPC ['openid']
				  ), 'id');
				  
        $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid'])); 
		
		$leave = pdo_fetch("SELECT * FROM " . tablename($this->table_leave) . " where :schoolid = schoolid And :weid = weid And :tid = tid ORDER BY id DESC LIMIT 1", array(
		         ':weid' => $_GPC['weid'],
				 ':schoolid' => $_GPC ['schoolid'],
				 ':tid' => $_GPC ['tid']
				 )); 
				 
		if ((time() - $leave['createtime']) <  200) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '您请假太频繁了，请待会再试！' 
		               ) ) );
		}		 
		 
		if (empty($user['id'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求，没找你的老师信息！' 
		               ) ) );
		}				  
				  
		if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
			
			$schoolid = $_GPC['schoolid'];
			
			$weid = $_GPC['weid'];
			
			$toopenid = trim($_GPC['toopenid']);
			
			$data = array(
					'weid' =>  $_GPC ['weid'],
					'schoolid' => $_GPC ['schoolid'],
					'openid' => $_GPC ['openid'],
					'tid' => $_GPC ['tid'],
					'type' => $_GPC ['type'],
					'startime' => $_GPC ['startTime'],
					'endtime' => $_GPC ['endTime'],
					'conet' => $_GPC ['content'],
					'uid' => $_GPC['uid'],
					'createtime' => time(),
			);
				
			pdo_insert($this->table_leave, $data);
   
			$leave_id = pdo_insertid();
			
			if ($setting['istplnotice'] == 1 && $setting['jsqingjia']) {
				
				$this->sendMobileJsqj($leave_id, $schoolid, $weid, $toopenid);
				
			}else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			}
			
			$data ['result'] = true;
			
			$data ['msg'] = '申请成功，请勿重复申请！';

		 die ( json_encode ( $data ) );
		}
    }

	if ($operation == 'agree') {
		$data = explode ( '|', $_GPC ['json'] );
			
            $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid']));
			
			$schoolid = $_GPC['schoolid'];
			
			$weid = $_GPC['weid'];
			
			$leaveid = $_GPC['id'];
			
			$shname = trim($_GPC['shname']);
			
			$data = array(
			        'cltime' =>  time(),
					'status' =>  1,
			);
				
            pdo_update($this->table_leave, $data, array('id' => $leaveid));	

			if ($setting['istplnotice'] == 1 && $setting['jsqjsh']) {
				
				$this->sendMobileJsqjsh($leaveid, $schoolid, $weid, $shname);
				
			}else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			}			
						
			$data ['result'] = true;
			
			$data ['msg'] = '审核成功！';
			
		 die ( json_encode ( $data ) );
		
    }

	if ($operation == 'defeid') {
		$data = explode ( '|', $_GPC ['json'] );
			
            $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid']));
			
			$schoolid = $_GPC['schoolid'];
			
			$weid = $_GPC['weid'];
			
			$leaveid = $_GPC['id'];
			
			$shname = trim($_GPC['shname']);
			
			$data = array(
			        'cltime' =>  time(),
					'status' =>  2,
			);
				
            pdo_update($this->table_leave, $data, array('id' => $leaveid));	

			if ($setting['istplnotice'] == 1 && $setting['jsqjsh']) {
				
				$this->sendMobileJsqjsh($leaveid, $schoolid, $weid, $shname);
				
			}else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			}			
						
			$data ['result'] = true;
			
			$data ['msg'] = '审核成功！';
			
		 die ( json_encode ( $data ) );
		
    }

	if ($operation == 'sagree') {
		$data = explode ( '|', $_GPC ['json'] );
			
            $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid']));
			
			$schoolid = $_GPC['schoolid'];
			
			$weid = $_GPC['weid'];
			
			$leaveid = $_GPC['id'];
			
			$tname = $_GPC['tname'];
			
			$data = array(
			        'cltime' =>  time(),
					'status' =>  1,
			);
				
            pdo_update($this->table_leave, $data, array('id' => $leaveid));	

			if ($setting['istplnotice'] == 1 && $setting['xsqjsh']) {
				
				$this->sendMobileXsqjsh($leaveid, $schoolid, $weid, $tname);
				
			}else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			}			
						
			$data ['result'] = true;
			
			$data ['msg'] = '审核成功！';
			
		 die ( json_encode ( $data ) );
		
    }

	if ($operation == 'sdefeid') {
		$data = explode ( '|', $_GPC ['json'] );
			
            $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid']));
			
			$schoolid = $_GPC['schoolid'];
			
			$weid = $_GPC['weid'];
			
			$leaveid = $_GPC['id'];
			
			$tname = $_GPC['tname'];
			
			$data = array(
			        'cltime' =>  time(),
					'status' =>  2,
			);
				
            pdo_update($this->table_leave, $data, array('id' => $leaveid));	

			if ($setting['istplnotice'] == 1 && $setting['xsqjsh']) {
				
				$this->sendMobileXsqjsh($leaveid, $schoolid, $weid, $tname);
				
			}else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			}			
						
			$data ['result'] = true;
			
			$data ['msg'] = '审核成功！';
			
		 die ( json_encode ( $data ) );
		
    }	

	if ($operation == 'savemsg') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	         }
						  
        $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid'])); 
		
		$leave = pdo_fetch("SELECT * FROM " . tablename($this->table_leave) . " where :schoolid = schoolid And :weid = weid And :sid = sid  And :openid = openid And :isliuyan = isliuyan And :uid = uid And :tid = tid ORDER BY createtime ASC LIMIT 1", array(
		         ':weid' => $_GPC['weid'],
				 ':schoolid' => $_GPC ['schoolid'],
				 ':openid' => $_GPC ['openid'],
				 ':uid' => $_GPC ['uid'],
				 ':isliuyan' => 1,
				 ':sid' => $_GPC ['sid'],
			     ':tid' => $_GPC['tid']
				 )); 
				 
		$time = pdo_fetch("SELECT * FROM " . tablename($this->table_leave) . " where :schoolid = schoolid And :weid = weid And :sid = sid And :uid = uid And :tid = tid ORDER BY createtime DESC LIMIT 1", array(
		         ':weid' => $_GPC['weid'],
				 ':schoolid' => $_GPC ['schoolid'],
//				 ':bj_id' => $_GPC ['bj_id'],
				 ':uid' => $_GPC ['uid'],
				 ':sid' => $_GPC ['sid'],
			     ':tid' => $_GPC['tid']
				 ));				 
		  
		if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else if (!empty($leave['id'])) {
			$schoolid = $_GPC['schoolid'];
			
			$weid = $_GPC['weid'];
			
			$uid = $_GPC['uid'];
			
			$bj_id = $_GPC['bj_id'];
			
			$sid = $_GPC['sid'];
			
			$tid = $_GPC['tid'];
			
			$data = array(
					'weid' =>  $_GPC ['weid'],
					'schoolid' => $_GPC ['schoolid'],
					'openid' => $_GPC ['openid'],
					'sid' => $_GPC ['sid'],
					'conet' => $_GPC ['content'],
					'bj_id' => $_GPC['bj_id'],
					'uid' => $_GPC['uid'],
				    'tid' => $_GPC['tid'],
					'leaveid'=>$leave['id'],
					'isliuyan'=>1,
					'createtime' => time(),
			);
				
			pdo_insert($this->table_leave, $data);
   
			$leave_id = pdo_insertid();
			
			if ($setting['istplnotice'] == 1 && $setting['liuyan']) {
				
				$this->sendMobileJzly($leave_id, $schoolid, $weid, $uid, $bj_id, $sid, $tid);
				
			}else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			}
			
			$data ['result'] = true;
			
			$data ['msg'] = '成功发送留言信息，请勿重复发送！';
          die ( json_encode ( $data ) );
		  
		}else{
			
			$schoolid = $_GPC['schoolid'];
			
			$weid = $_GPC['weid'];
			
			$uid = $_GPC['uid'];
			
			$bj_id = $_GPC['bj_id'];
			
			$sid = $_GPC['sid'];
			
			$tid = $_GPC['tid'];
			
			$data = array(
					'weid' =>  $_GPC ['weid'],
					'schoolid' => $_GPC ['schoolid'],
					'openid' => $_GPC ['openid'],
					'sid' => $_GPC ['sid'],
					'conet' => $_GPC ['content'],
					'bj_id' => $_GPC['bj_id'],
					'tid'  => $_GPC['tid'],
					'uid' => $_GPC['uid'],
					'leaveid'=>$leave['id'],
					'isliuyan'=>1,
					'isfrist'=>1,
					'createtime' => time(),
			);
				
			pdo_insert($this->table_leave, $data);
   
			$leave_id = pdo_insertid();
			
			$data1 = array(
					'leaveid'=>$leave_id,
			);
			
			pdo_update($this->table_leave, $data1, array('id' => $leave_id));	
			
			if ($setting['istplnotice'] == 1 && $setting['liuyan']) {
				
				$this->sendMobileJzly($leave_id, $schoolid, $weid, $uid, $bj_id, $sid, $tid);
				
			}else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			}
			
			$data ['result'] = true;
						
			$data ['msg'] = '成功发送留言信息，请勿重复发送！';

		 die ( json_encode ( $data ) );
		}
    }

	if ($operation == 'xsqingjia') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	         }
				  
        $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid'])); 
		
		$leave = pdo_fetch("SELECT * FROM " . tablename($this->table_leave) . " where :schoolid = schoolid And :weid = weid And :sid = sid And :tid = tid And :isliuyan = isliuyan ORDER BY id DESC LIMIT 1", array(
		         ':weid' => $_GPC['weid'],
				 ':schoolid' => $_GPC ['schoolid'],
				 ':tid' => $_GPC ['tid'],
				 ':isliuyan' => 0,
				 ':sid' => $_GPC ['sid']
				 )); 
				 
		if ((time() - $leave['createtime']) <  100) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '您请假太频繁了，请待会再试！' 
		               ) ) );
		}		 
		 			  
		if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
			
			$schoolid = $_GPC['schoolid'];
			
			$weid = $_GPC['weid'];
			
			$tid = $_GPC['tid'];
			
			$data = array(
					'weid' =>  $_GPC ['weid'],
					'schoolid' => $_GPC ['schoolid'],
					'openid' => $_GPC ['openid'],
					'sid' => $_GPC ['sid'],
				    'tid' => $tid,
					'type' => $_GPC ['type'],
					'startime' => $_GPC ['startTime'],
					'endtime' => $_GPC ['endTime'],
					'conet' => $_GPC ['content'],
					'uid' => $_GPC['uid'],
					'bj_id' => $_GPC['bj_id'],
					'createtime' => time(),
			);
				
			pdo_insert($this->table_leave, $data);
   
			$leave_id = pdo_insertid();
			
			if ($setting['istplnotice'] == 1 && $setting['xsqingjia']) {
				
				$this->sendMobileXsqj($leave_id, $schoolid, $weid, $tid);
				
			}
			
			$data ['result'] = true;
			
			$data ['msg'] = '申请成功，请勿重复申请！';

		 die ( json_encode ( $data ) );
		}
    }

	if ($operation == 'savesmsg') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }
						  
        $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid'])); 
		 		 			  				  
		if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
			$schoolid = $_GPC['schoolid'];
			
			$topenid = $_GPC['topenid'];
			
			$weid = $_GPC['weid'];
			
			$uid = $_GPC['uid'];
			
			$tuid = $_GPC['tuid'];
			
			$bj_id = $_GPC['bj_id'];
			
			$sid = $_GPC['sid'];
			
			$tid = $_GPC['tid'];
			
			$itemid = $_GPC['itemid'];
			
			$tname = $_GPC['tname'];
			
			$leaveid = $_GPC['leaveid'];
			
			$data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'openid' => $topenid,
					'sid' => $_GPC ['sid'],
					'conet' => $_GPC ['content'],
					'bj_id' => $bj_id,
					'uid' => $uid,
					'tid' => $tid,
					'teacherid' => $tid,
					'tuid' => $tuid,
					'leaveid'=>$leaveid,
					'isliuyan'=>1,
					'createtime' => time(),
					'status' =>  2,
			);
			
			$data1 = array(
			        'cltime' =>  time(),
					'status' =>  2,
			);			
				
			pdo_insert($this->table_leave, $data);
			
			$leave_id = pdo_insertid();
			
			pdo_update($this->table_leave, $data1, array('id' => $itemid));	
   
			if ($setting['istplnotice'] == 1 && $setting['liuyanhf']) {
				
				$this->sendMobileJzlyhf($leave_id, $schoolid, $weid, $topenid, $sid, $tname);
				
			}else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			}
			
			$data ['result'] = true;
			
			$data ['msg'] = '成功发送留言信息，请勿重复发送！';	
			
          die ( json_encode ( $data ) );
		  
		}
    }
	if ($operation == 'getbjlist')  {
		if (! $_GPC ['schoolid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			$data = array();
			$bjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$_GPC['schoolid']}' And weid = '{$_W['uniacid']}' And parentid = '{$_GPC['gradeId']}' And type = 'theclass' ORDER BY ssort ASC");
   			$data ['bjlist'] = $bjlist;
			$data ['result'] = true;
			$data ['msg'] = '成功获取！';
			
          die ( json_encode ( $data ) );
		  
		}
    }
	if ($operation == 'signup')  {
		if (empty($_GPC ['schoolid'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }
		$check1 = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE :weid = weid And :schoolid = schoolid And :s_name = s_name And :mobile = mobile", array(
				':weid' => $_GPC['weid'],
				':schoolid' => $_GPC['schoolid'],
				':s_name' => trim($_GPC['s_name']),
//				':xq_id' => $_GPC['njid'],不用年级id校验
				':mobile' => $_GPC['mobile']
				)); 
		if (!empty($check1)){
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '该生已录入学校,无需重复报名！' 
		               ) ) );			
		}		
		$check2 = pdo_fetch("SELECT * FROM " . tablename($this->table_signup) . " WHERE :weid = weid And :schoolid = schoolid And :name = name And :mobile = mobile And :sex = sex", array(
				':weid' => $_GPC['weid'],
				':schoolid' => $_GPC['schoolid'],
				':name' => trim($_GPC['s_name']),
				':sex' => $_GPC['sex'],
//				':nj_id' => $_GPC['njid'],不用年级id校验
				':mobile' => $_GPC['mobile']
				));
		if (!empty($check2)){
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '该生已通过微信端报名,请勿重复报名！' 
		               ) ) );			
		}	
		if (empty($_GPC ['openid']))  {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			//$iscost = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE :sid = sid ", array(':sid' => $_GPC['bjid']));
			
			//$njinfo = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE :sid = sid ", array(':sid' => $_GPC['njid']));
			
			//$njzr = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE :id = id ", array(':id' => $njinfo['tid']));

			//审核变更为客服审核
			$kf = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE :weid = weid And type = 'customerService' And :schoolid = schoolid ORDER BY sid DESC, ssort DESC",array(':weid' => $_GPC['weid'],':schoolid' => $_GPC['schoolid']));
			$setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid']));
			$school = pdo_fetch("SELECT signset FROM " . tablename($this->table_index) . " WHERE :id = id ", array(':id' => $_GPC['schoolid']));
			$sign = unserialize($school['signset']);
			$temp = array(
				'weid' => $_GPC['weid'],
				'schoolid' => $_GPC['schoolid'],
				'name' => trim($_GPC['s_name']),
				'sex' => $_GPC['sex'],
				'mobile' => $_GPC['mobile'],
				'nj_id' => $_GPC['njid'],
				'bj_id' => $_GPC['bjid'],
				'idcard' => $_GPC['idcard'],
				'birthday' => strtotime($_GPC['birthday']),
				'uid' => $_GPC['uid'],
				'openid' => $_GPC['openid'],
				'createtime' => time(),
				'cost' => $iscost['cost'],
				'pard' => $_GPC['pard'],
				'home_address' => trim($_GPC['home_address']),
				'home_location' => json_encode(array('lng' => trim($_GPC['lng']),'lat' => trim($_GPC['lat']))),
				'status' => 1,
			);
			pdo_insert($this->table_signup, $temp);
			$signup_id = pdo_insertid();
			if (!empty($iscost['cost'])){
				$temp1 = array(
								'weid' =>  $_GPC['weid'],
								'schoolid' => $_GPC['schoolid'],
								'type' => 4,
								'status' => 1,
								'uid' => $_GPC['uid'],
								'cose' => $iscost['cost'],
								'orderid' => time(),
								'signid' => $signup_id,
								'payweid' => $sign['payweid'],
								'createtime' => time(),
							);
				pdo_insert($this->table_order, $temp1);
				$order_id = pdo_insertid();
				pdo_update($this->table_signup, array('orderid' => $order_id), array('id' =>$signup_id));
			}

			if ($setting['istplnotice'] == 1 && $setting['bjqshtz']) {
				$this->sendMobileBmshtz($signup_id, $_GPC['schoolid'], $_GPC['weid'], $kf['openid'], $_GPC['s_name']);
			}			
			
			$data ['result'] = true;
			$data ['msg'] = '提交成功！';
			
          die ( json_encode ( $data ) );
		  
		}
    }
	if ($operation == 'addchild')  {
		if (empty($_GPC ['schoolid'])) {
			die ( json_encode ( array (
				'result' => false,
				'msg' => '非法请求！'
			) ) );
		}
		$check1 = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE :weid = weid And :schoolid = schoolid And :s_name = s_name And :mobile = mobile", array(
			':weid' => $_GPC['weid'],
			':schoolid' => $_GPC['schoolid'],
			':s_name' => trim($_GPC['s_name']),
	//				':xq_id' => $_GPC['njid'],不用年级id校验
			':mobile' => $_GPC['mobile']
		));
		if (!empty($check1)){
			die ( json_encode ( array (
				'result' => false,
				'msg' => '该生已录入学校,无需重复报名！'
			) ) );
		}
		$check2 = pdo_fetch("SELECT * FROM " . tablename($this->table_signup) . " WHERE :weid = weid And :schoolid = schoolid And :name = name And :mobile = mobile And :sex = sex", array(
			':weid' => $_GPC['weid'],
			':schoolid' => $_GPC['schoolid'],
			':name' => trim($_GPC['s_name']),
			':sex' => $_GPC['sex'],
	//				':nj_id' => $_GPC['njid'],不用年级id校验
			':mobile' => $_GPC['mobile']
		));
		if (!empty($check2)){
			die ( json_encode ( array (
				'result' => false,
				'msg' => '申请信息正在审核中,请勿重复报名！'
			) ) );
		}
		if (empty($_GPC ['openid']))  {
			die ( json_encode ( array (
				'result' => false,
				'msg' => '非法请求！'
			) ) );
		}else{
			//$iscost = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE :sid = sid ", array(':sid' => $_GPC['bjid']));

			//$njinfo = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE :sid = sid ", array(':sid' => $_GPC['njid']));

			//$njzr = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE :id = id ", array(':id' => $njinfo['tid']));

			//审核变更为客服审核
			$kf = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE :weid = weid And type = 'customerService' And :schoolid = schoolid ORDER BY sid DESC, ssort DESC",array(':weid' => $_GPC['weid'],':schoolid' => $_GPC['schoolid']));
			$setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid']));
			$school = pdo_fetch("SELECT signset FROM " . tablename($this->table_index) . " WHERE :id = id ", array(':id' => $_GPC['schoolid']));
			$sign = unserialize($school['signset']);
			$temp = array(
				'weid' => $_GPC['weid'],
				'schoolid' => $_GPC['schoolid'],
				'name' => trim($_GPC['s_name']),
				'sex' => $_GPC['sex'],
				'mobile' => $_GPC['mobile'],
				'nj_id' => $_GPC['njid'],
				'bj_id' => $_GPC['bjid'],
				'idcard' => $_GPC['idcard'],
				'birthday' => strtotime($_GPC['birthday']),
				'uid' => $_GPC['uid'],
				'openid' => $_GPC['openid'],
				'createtime' => time(),
				'cost' => $iscost['cost'],
				'pard' => $_GPC['pard'],
				'home_address' => trim($_GPC['home_address']),
				'home_location' => json_encode(array('lng' => trim($_GPC['lng']),'lat' => trim($_GPC['lat']))),
				'status' => 1,
			);
			pdo_insert($this->table_signup, $temp);
			$signup_id = pdo_insertid();
			if (!empty($iscost['cost'])){
				$temp1 = array(
					'weid' =>  $_GPC['weid'],
					'schoolid' => $_GPC['schoolid'],
					'type' => 4,
					'status' => 1,
					'uid' => $_GPC['uid'],
					'cose' => $iscost['cost'],
					'orderid' => time(),
					'signid' => $signup_id,
					'payweid' => $sign['payweid'],
					'createtime' => time(),
				);
				pdo_insert($this->table_order, $temp1);
				$order_id = pdo_insertid();
				pdo_update($this->table_signup, array('orderid' => $order_id), array('id' =>$signup_id));
			}

			if ($setting['istplnotice'] == 1 && $setting['bjqshtz']) {
				$this->sendMobileBmshtz($signup_id, $_GPC['schoolid'], $_GPC['weid'], $kf['openid'], $_GPC['s_name']);
			}

			$data ['result'] = true;
			$data ['msg'] = '提交成功！';

			die ( json_encode ( $data ) );

		}
	}
	if ($operation == 'txshbm')  {
		if (empty($_GPC ['schoolid'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }
		$signup_id = $_GPC['id'];
		$check1 = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE :weid = weid And :schoolid = schoolid And :s_name = s_name And :mobile = mobile ", array(
				':weid' => $_GPC['weid'],
				':schoolid' => $_GPC['schoolid'],
				':s_name' => trim($_GPC['s_name']),
				':mobile' => $_GPC['mobile']
				));
		$order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where signid = :signid ", array(':signid' => $signup_id));
		$iscost = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE :sid = sid ", array(':sid' => $_GPC['bjid']));
		$item = pdo_fetch("SELECT * FROM " . tablename($this->table_signup) . " where :id = id", array(':id' => $signup_id));
		$nowtime = time();
		$lasttime = $nowtime - $item['lasttime'];
		
		if ($lasttime <= 180){
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '抱歉,您提醒的频率过高,请稍后再试!' 
		               ) ) );			
		}
		if (!empty($check1)){
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '该生已录入学校系统,无需重复报名!' 
		               ) ) );			
		}
		if (!empty($iscost['cost'])){
			if ($order['status'] == 1){
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '抱歉!您尚未付费,请您先支付报名费!' 
		               ) ) );				
			}	
		}		
		if (empty($_GPC ['openid']))  {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE :id = id ", array(':id' => $_GPC['schoolid']));
			$setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid']));
			$kf = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE :weid = weid And type = 'customerService' And :schoolid = schoolid ORDER BY sid DESC, ssort DESC",array(':weid' => $_GPC['weid'],':schoolid' => $_GPC['schoolid']));
			pdo_update($this->table_signup, array('lasttime' => time()), array('id' => $signup_id));
			if ($setting['istplnotice'] == 1 && $setting['bjqshtz']) {
				$this->sendMobileBmshtz($signup_id, $_GPC['schoolid'], $_GPC['weid'], $kf['openid'], $_GPC['s_name']);
			}			
				
			$data ['result'] = true;
			$data ['msg'] = '提醒成功,请勿频繁操作！';
			
          die ( json_encode ( $data ) );
		  
		}
    }
	
	if ($operation == 'xgxsinfo')  {
		if (empty($_GPC ['schoolid'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }
		$check = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE :weid = weid And :schoolid = schoolid And :s_name = s_name And :mobile = mobile", array(
				':weid' => $_GPC['weid'],
				':schoolid' => $_GPC['schoolid'],
				':s_name' => trim($_GPC['s_name']),
//				':xq_id' => $_GPC['njid'],
				':mobile' => $_GPC['mobile']
				)); 
		if (!empty($check)){
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '该生已录入学校,无需重复审核！' 
		               ) ) );			
		}			
		if (empty($_GPC ['openid']))  {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{ 	
			
			$iscost = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE :sid = sid ", array(':sid' => $_GPC['bjid']));
			
//			$njinfo = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE :sid = sid ", array(':sid' => $_GPC['njid']));
			
//			$njzr = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE :id = id ", array(':id' => $njinfo['tid']));
						
			$item = pdo_fetch("SELECT * FROM " . tablename($this->table_signup) . " WHERE :id = id", array(':id' => $_GPC['id'])); 
			
			$order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE :id = id", array(':id' => $item['orderid']));
			
			$temp = array(
				'weid' => $_GPC['weid'],
				'schoolid' => $_GPC['schoolid'],
				'name' => trim($_GPC['s_name']),
				'numberid' => $_GPC['numberid'],
				'sex' => $_GPC['sex'],
				'mobile' => $_GPC['mobile'],
				'nj_id' => $_GPC['njid'],
				'bj_id' => $_GPC['bjid'],
				'idcard' => $_GPC['idcard'],
				'pard' => $_GPC['pard'],
				'birthday' => strtotime($_GPC['birthday']),
				'home_address'  => trim($_GPC['home_address']),
				'home_location' => json_encode(array('lng' => trim($_GPC['lng']),'lat' => trim($_GPC['lat']))),
				'cost' => $iscost['cost'],
			);
				
			pdo_update($this->table_signup, $temp, array('id' => $_GPC['id']));

			if (!empty($iscost['cost'])){
				if (empty($order)) {
					$temp1 = array(
									'weid' =>  $_GPC['weid'],
									'schoolid' => $_GPC['schoolid'],
									'type' => 4,
									'status' => 1,
									'uid' => $item['uid'],
									'cose' => $iscost['cost'],
									'orderid' => time(),
									'signid' => $_GPC['id'],
									'createtime' => time(),
								);
					pdo_insert($this->table_order, $temp1);
					$order_id = pdo_insertid();
					pdo_update($this->table_signup, array('orderid' => $order_id), array('id' =>$_GPC['id']));
					$this->sendMobileBmshjg($_GPC['id'], $_GPC['schoolid'], $_GPC['weid'], $item['openid'], $_GPC['s_name']);
				}else{
					$this->sendMobileBmshjg($_GPC['id'], $_GPC['schoolid'], $_GPC['weid'], $item['openid'], $_GPC['s_name']);
				}
			}else{
				$this->sendMobileBmshjg($_GPC['id'], $_GPC['schoolid'], $_GPC['weid'], $item['openid'], $_GPC['s_name']);
			}	
			
			$data ['result'] = true;
			$data ['msg'] = '信息修改成功！';
			
          die ( json_encode ( $data ) ); 
		}
    }

	if ($operation == 'tgsq')  {
		if (empty($_GPC ['openid'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			$item = pdo_fetch("SELECT * FROM " . tablename($this->table_signup) . " WHERE :id = id", array(':id' => $_GPC['id']));
			
			$temp = array(
				'weid' => $item['weid'],
				'schoolid' => $item['schoolid'],
				's_name' => $item['name'],
				'sex' => $item['sex'],
				'numberid' => $item['numberid'],
				'mobile' => $item['mobile'],
				'xq_id' => $item['nj_id'],
				'bj_id' => $item['bj_id'],
				'note' => $item['idcard'],
				'birthdate' => $item['birthday'],
				'area_addr' => $item['home_address'],
				'area_addr_location' => $item['home_location'],
				'seffectivetime' => time(),
				'createdate' => time()
			);			
			
		    pdo_insert($this->table_students, $temp);
		   
		    $studentid = pdo_insertid();
					  
		   if(!empty($item['pard'])){
				if($item['pard'] == 2){
					$data = array( 
						'mom' => $item['openid'],
						'muid'=> $item['uid']
						);
				}
				if($item['pard'] == 3){
					$data = array(
						'dad' => $item['openid'],
						'duid'=> $item['uid']
						);
				}
				if($item['pard'] == 4){
					$data = array(
						'own' => $item['openid'],
						'ouid'=> $item['uid']
						);
				}
				pdo_update($this->table_students, $data, array('id' => $studentid));

			   	$info = array ('name' => $item['name'],'mobile' => $item['mobile']);
				pdo_insert($this->table_user, array (
						'sid' => $studentid,
						'weid' =>  $item ['weid'],
						'schoolid' => $item ['schoolid'],
						'openid' => $item ['openid'],
						'pard' => $item['pard'],
						'uid' => $item['uid'],
						'userinfo' => iserializer($info)
				));			   
		   }

			$temp1 = array(
				'status' => 2,
				'passtime' => time()
			);
			
			pdo_update($this->table_signup, $temp1, array('id' => $_GPC['id']));			
			$this->sendMobileBmshjgtz($_GPC['id'], $item['schoolid'], $item['weid'], $item['openid'], $item['name']);
			$data ['result'] = true;
			$data ['msg'] = '审核成功,已录入学生系统！';
			
          die ( json_encode ( $data ) );
		  
		}
    }

	if ($operation == 'jjsq')  {
		if (empty($_GPC ['openid'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			$item = pdo_fetch("SELECT * FROM " . tablename($this->table_signup) . " WHERE :id = id", array(':id' => $_GPC['id']));
						
			$temp = array(
				'status' => 3,
				'passtime' => time()
			);			
			
			pdo_update($this->table_signup, $temp, array('id' => $_GPC['id']));		
			$this->sendMobileBmshjgtz($_GPC['id'], $item['schoolid'], $item['weid'], $item['openid'], $item['name']);
			$data ['result'] = true;
			$data ['msg'] = '已拒绝该生申请,您还可以执行通过操作！';
			
          die ( json_encode ( $data ) );
		  
		}
    }
	if ($operation == 'bangdingcardjl')  {
		if (empty($_GPC ['openid'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }		
		$checkcard = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE :weid = weid And :schoolid = schoolid And :idcard = idcard", array(
			':weid' => $_GPC['weid'],
			':schoolid' => $_GPC['schoolid'],
			':idcard' => $_GPC['idcard']
		));
		if (empty($_GPC['username'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '请输入持卡人姓名！' 
		               ) ) );
	    }		
		if (!empty($checkcard['pard'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '本卡已被绑定！' 
		               ) ) );
	    }
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE id = :id ", array(':id' => $_GPC['schoolid']));
		if ($school['is_cardlist'] ==1){
			if (empty($checkcard)) {
				   die ( json_encode ( array (
						'result' => false,
						'msg' => '抱歉,本校无此卡号！' 
						   ) ) );
			}
		}
		$pard = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE :weid = weid And :schoolid = schoolid And :idcard = idcard And :sid = sid And :pard = pard", array(
			':weid' => $_GPC['weid'],
			':schoolid' => $_GPC['schoolid'],
			':idcard' => $_GPC['idcard'],
			':sid' => $_GPC['sid'],
			':pard' => $_GPC['pard']
		));		
		if (!empty($pard)) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '你选择的关系已经绑定其他卡！' 
		               ) ) );
	    }else{	
			if($school['is_cardpay'] == 1){
				$card = unserialize($school['cardset']);
					if($card['cardtime'] == 1){
						$severend = $card['endtime1'] * 86400 + time();
					}else{
						$severend = $card['endtime2'];
					}
					$temp = array(
						'weid' => $_GPC['weid'],
						'schoolid' => $_GPC['schoolid'],
						'idcard' => $_GPC['idcard'],
						'sid' => $_GPC['sid'],
						'bj_id' => $_GPC['bj_id'],
						'pname' => $_GPC['username'],
						'pard' => $_GPC['pard'],
						'usertype' => 0,
						'is_on' => 1,
						'createtime' => time(),
						'severend' => $severend,
					);
					if ($school['is_cardlist'] ==1){
					    pdo_update($this->table_idcard, $temp, array('id' =>$checkcard['id']));
					}else{
						pdo_insert($this->table_idcard, $temp);
					}			
			}else{
				$temp2 = array(
					'weid' => $_GPC['weid'],
					'schoolid' => $_GPC['schoolid'],
					'idcard' => $_GPC['idcard'],
					'sid' => $_GPC['sid'],
					'pard' => $_GPC['pard'],
					'pname' => $_GPC['username'],
					'usertype' => 0,
					'is_on' => 1,
					'createtime' => time()
				);
				if ($school['is_cardlist'] ==1){
					pdo_update($this->table_idcard, $temp2, array('id' =>$checkcard['id']));
				}else{
					pdo_insert($this->table_idcard, $temp2);
				}
			}		
			
			$data ['result'] = true;
			$data ['msg'] = '绑定成功！';
			
          die ( json_encode ( $data ) );
		  
		}
    }	
	if ($operation == 'jbidcard')  {
		$item = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE :id = id", array(':id' => $_GPC['id']));
		if (empty($item)) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '无此卡！' 
		               ) ) );
	    }else{
			$temp = array(
			        'sid' => 0,
		           	'tid' => 0,
					'pard'=> 0,
					'bj_id'=> 0,
					'is_on'=> 0,
					'usertype'=> 3,
					'createtime'=> '',
					'pname'=> '',
					'severend'=> '',
					'spic'=> '',
					'tpic'=> '',
			       );
			pdo_update($this->table_idcard, $temp, array('id' => $_GPC['id']));						
			$data ['result'] = true;
			$data ['msg'] = '解绑成功！';
			
          die ( json_encode ( $data ) );
		  
		}
    }
	
	if ($operation == 'changeimg') {
		load()->func('communication');
		load()->classs('weixin.account');
		load()->func('file');
		$accObj= WeixinAccount::create($_W['account']['acid']);
		$access_token = $accObj->fetch_token();
		$token2 =  $access_token;
		$photoUrl = $_GPC ['bigImage'];
		$data = explode ( '|', $_GPC ['json'] );
		$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE :id = id", array(':id' => $_GPC['sid']));

		
		if (empty($student)) {
			die ( json_encode ( array (
				'result' => false,
				'msg' => '没找到本学生！' 
			) ) );
		}else{
			
			if(!empty($photoUrl)) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrl;
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl = $path.random(30) .".jpg";
				file_write($picurl,$pic_data['content']);
				if (!empty($_W['setting']['remote']['type'])) { // 
					$remotestatus = file_remote_upload($picurl); //
					if (is_error($remotestatus)) {
						message('远程附件上传失败，请检查配置并重新上传');					
					}
				}
			}
				
			pdo_update($this->table_students, array('icon' => $picurl), array('id' => $student['id']));	
			$data ['result'] = true;
			$data ['msg'] = '修改头像成功';

			die ( json_encode ( $data ) );

		}
    }

	if ($operation == 'changeimgt') {
		load()->func('communication');
		load()->classs('weixin.account');
		load()->func('file');
		$accObj= WeixinAccount::create($_W['account']['acid']);
		$access_token = $accObj->fetch_token();
		$token2 =  $access_token;
		$photoUrl = $_GPC ['bigImage'];
		$data = explode ( '|', $_GPC ['json'] );
		$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE :id = id", array(':id' => $_GPC['tid']));

		
		if (empty($teacher)) {
			die ( json_encode ( array (
				'result' => false,
				'msg' => '没找到该教师信息！' 
			) ) );
		}else{			
			if(!empty($photoUrl)) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrl;
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl = $path.random(30) .".jpg";
				file_write($picurl,$pic_data['content']);
				if (!empty($_W['setting']['remote']['type'])) { // 
					$remotestatus = file_remote_upload($picurl); //
					if (is_error($remotestatus)) {
						message('远程附件上传失败，请检查配置并重新上传');					
					}
				}
			}			
			pdo_update($this->table_teachers, array('thumb' => $picurl), array('id' => $_GPC['tid']));	
			$data ['result'] = true;
			$data ['msg'] = '修改头像成功';

			die ( json_encode ( $data ) );

		}
    }
	
	if ($operation == 'changePimg') {
		load()->func('communication');
		load()->classs('weixin.account');
		load()->func('file');
		$accObj= WeixinAccount::create($_W['account']['acid']);
		$access_token = $accObj->fetch_token();
		$token2 =  $access_token;
		$photoUrl = $_GPC ['bigImage'];
		$data = explode ( '|', $_GPC ['json'] );
		$user = pdo_fetch("SELECT id FROM " . tablename($this->table_idcard) . " WHERE :id = id", array(':id' => $_GPC['id']));

		
		if (empty($user['id'])) {
			die ( json_encode ( array (
				'result' => false,
				'msg' => '没找到本学生！' 
			) ) );
		}else{
			
			if(!empty($photoUrl)) {	
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrl;
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl = $path.random(30) .".jpg";
				file_write($picurl,$pic_data['content']);
				if (!empty($_W['setting']['remote']['type'])) { // 
					$remotestatus = file_remote_upload($picurl); //
					if (is_error($remotestatus)) {
						message('远程附件上传失败，请检查配置并重新上传');					
					}
				}
			}
				
			pdo_update($this->table_idcard, array('spic' => $picurl), array('id' => $user['id']));	
			$data ['result'] = true;
			$data ['msg'] = '修改头像成功';

			die ( json_encode ( $data ) );

		}
    }
	
	if ($operation == 'showchecklog') {
		
		$data = explode ( '|', $_GPC ['json'] );
		
		$log = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " WHERE :id = id", array(':id' => $_GPC['id']));
		
		$mac = pdo_fetch("SELECT * FROM " . tablename($this->table_checkmac) . " WHERE schoolid = '{$log['schoolid']}' And id = '{$log['macid']}' ");

		// if($mac['macname'] == 3)	{
			// if (preg_match('/(http:\/\/)|(https:\/\/)/i', $log['pic'])) {
				// if(!empty($log['pic'])) {
					// load()->func('file');
					// load()->func('communication');
					// $pic_data = file_get_contents($log['pic']);
					// $path = "images/";
					// $picurl = $path.random(30) .".jpg";
					// $pic_data = $this->getImg($log['pic'],$picurl);
					// file_write($picurl,$pic_data);
						// if (!empty($_W['setting']['remote']['type'])) { // 
							// $remotestatus = file_remote_upload($picurl); //
							// if (is_error($remotestatus)) {
								// message('远程附件上传失败，请检查配置并重新上传');
							// }
						// }
				// pdo_update($this->table_checklog, array('pic' => $picurl), array('id' => $_GPC['id']));			
				// }	
			// }
		// }
		if (empty($log)) {
			die ( json_encode ( array (
				'result' => false,
				'msg' => 'no data' 
			) ) );
		}else{
							
			$data ['result'] = true;
			$data ['ret']['code'] = 200;
			$data ['data'] = $log;
			//$data ['data']['picurl'] = $log['pic'];
			$data ['data']['macname'] = $mac['name'];
			$data ['data']['mactype'] = $mac['macname'];
			$data ['data']['msg'] = '获取记录成功';

			die ( json_encode ( $data ) );

		}
    }	
	
	
?>