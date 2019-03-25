<?php
/**
 * By 高贵血迹
 */

	global $_GPC, $_W;
	

	$operation = in_array ( $_GPC ['op'], array ('default', 'login', 'classinfo', 'check', 'gps', 'banner', 'video', 'start') ) ? $_GPC ['op'] : 'default';
	$weid = $_GPC['i'];
	$schoolid = $_GPC['schoolid'];
	$macid = $_GPC['macid'];
	$ckmac = pdo_fetch("SELECT * FROM " . tablename($this->table_checkmac) . " WHERE macid = '{$macid}' And weid = {$weid} And schoolid = {$schoolid} ");
	$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE id = {$schoolid} ");
	if ($operation == 'default') {
		echo("你是SB吗");
		exit();
    }
	if(empty($school)){
		echo("找不到本校，设备未关联学校");
		exit();		
	}
	if(empty($ckmac)){
		echo("没找到设备,请添加设备");
		exit();		
	}	
	if($school['is_recordmac'] == 2){
		echo("本校无权使用设备,请联系管理员");
		exit();		
	}	
	if ($ckmac['is_on'] == 2){
		echo("本设备已关闭,请在管理后台打开");
		exit();
	}
	if (empty($_W['setting']['remote']['type'])) { 
		$urls = $_W['SITEROOT'].$_W['config']['upload']['attachdir'].'/'; 
	} else {
		$urls = $_W['attachurl'];
	}
	if ($operation == 'start') {
		if(!empty($ckmac)){			
			$result['returnCode'] = "000";
			$result['insertKqConfig'] = array(
				array(
					'COLNUM' => "1"
				)
			);
			$result['getBasic'] = array(
				array(
					'TENANT_ID' => '',
					'ORG_ID' => '',
					'ORG_NAME' => $school['title'],
					'ST1' => $school['jxstart'],
					'ST2' => $school['jxend'],
					'ET1' => $school['lxstart'],
					'ET2' => $school['lxend'],
					'SBTIME' => $school['jxend'],
					'XBTIME' => $school['lxstart'],
				)			
			);
			echo json_encode($result);
		}
    }
	if ($operation == 'login') {
		if(!empty($ckmac)){
			$banner = unserialize($ckmac['banner']);
			$result['returnCode'] = "000";
			$result['getBasic'] = array(
				array(
					'INPRE' => "尊敬的家长您好,您的孩子#name#于#datatime#执卡[#cardId#]进入[设备(#devId#)]区域",
					'VOICEPRE' => $banner['VOICEPRE'],
					'NOTICE' => $banner['pop'],
					'TENANT_ID' => '',
					'ORG_ID' => '',						
					'ORG_NAME' => $school['title'],				
					'ST1' => $school['jxstart'],
					'ST2' => $school['jxend'],
					'ET1' => $school['lxstart'],
					'ET2' => $school['lxend'],
					'SBTIME' => $school['jxend'],
					'XBTIME' => $school['lxstart'],
				)			
			);
			$p1 = explode('/',$banner['pic1']);
			$p2 = explode('/',$banner['pic2']);
			$p3 = explode('/',$banner['pic3']);
			$p4 = explode('/',$banner['pic4']);
			$p5 = explode('/',$school['logo']);
			if(!empty($banner['video'])){
				$result['getVideoAndImages'] = array(	
						array(
							'FILE_NAME' => $banner['video'],
							'FILE_PATH' => $banner['video'],
						),	
						array(
							'FILE_NAME' => $p1[4],
							'FILE_PATH' => $banner['pic1'],
						),
						array(
							'FILE_NAME' => $p2[4],
							'FILE_PATH' => $banner['pic2'],
						),
						array(					
							'FILE_NAME' => $p3[4],
							'FILE_PATH' => $banner['pic3'],
						),
						array(					
							'FILE_NAME' => $p4[4],
							'FILE_PATH' => $banner['pic4'],
						),
						array(					
							'FILE_NAME' => $p5[4],
							'FILE_PATH' => $school['logo'],
						),						
				);
			}else{
				$result['getVideoAndImages'] = array(	
						array(					
							'FILE_NAME' => $p1[4],
							'FILE_PATH' => $banner['pic1'],
						),
						array(					
							'FILE_NAME' => $p2[4],
							'FILE_PATH' => $banner['pic2'],
						),
						array(					
							'FILE_NAME' => $p3[4],
							'FILE_PATH' => $banner['pic3'],
						),
						array(					
							'FILE_NAME' => $p4[4],
							'FILE_PATH' => $banner['pic4'],
						),
						array(					
							'FILE_NAME' => $p5[4],
							'FILE_PATH' => $school['logo'],
						),						
				);				
			}
			$temp = array(
				'isflow' => 2,
				'pop' => $banner['pop'],
				'video' => $banner['video'],
				'pic1' => $banner['pic1'],
				'pic1' => $banner['pic1'],
				'pic2' => $banner['pic2'],
				'pic3' => $banner['pic3'],
				'pic4' => $banner['pic4'],
				'VOICEPRE' => $banner['VOICEPRE'],
			);
			$temp1['banner'] = serialize($temp);
			pdo_update($this->table_checkmac, $temp1, array('id' => $ckmac['id']));				
			echo json_encode($result);
		}
    }

	if ($operation == 'classinfo') {
		$classid = $_GPC['classId'];
		if(!empty($ckmac)){
			$result['returnCode'] = "000";			                  
			$users = pdo_fetchall("SELECT idcard as CARD_ID, sid as USERID, bj_id as CLASS_ID, usertype as USERTYPE, sid as SID, tid as TID FROM " . tablename($this->table_idcard) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} And is_on = 1 ORDER BY id DESC");
				foreach($users as $key =>$row) {
					if($row['USERTYPE'] == 1){
						$teacher = pdo_fetch("SELECT tname,thumb  FROM " . tablename($this->table_teachers) . " WHERE id = '{$row['TID']}' ");
						$users[$key]['USER_ID'] = "02" .$row['TID'];
						$users[$key]['NAME'] = $teacher['tname'];
						$users[$key]['PIC_SRC'] = empty($teacher['thumb']) ? $school['tpic'] : $teacher['thumb'];//未设置头像，取默认头像
						$users[$key]['USERNAME'] = "02" .$row['TID'];
						$users[$key]['CLASS_NAME'] = "老师";					
					}else{
						$student = pdo_fetch("SELECT s_name,icon  FROM " . tablename($this->table_students) . " WHERE id = '{$row['SID']}' ");
						$bjinfo = pdo_fetch("SELECT sname  FROM " . tablename($this->table_classify) . " WHERE sid = '{$row['CLASS_ID']}' ");
						$users[$key]['USER_ID'] = $row['USERID'];
						$users[$key]['NAME'] = $student['s_name'];	
						$users[$key]['PIC_SRC'] = empty($student['icon']) ? $school['spic'] : $student['icon'];
						$users[$key]['USERNAME'] = $row['SID'];
						$users[$key]['CLASS_NAME'] = $bjinfo['sname'];
					}
				}
			$result['getTeachersAndStudents'] = $users;			    
			$parter = pdo_fetchall("SELECT pname as PNAME, id as ID, sid as STUDENT_CUID, spic as PIC_SRC, pard as PARD, usertype as UTYPE FROM " . tablename($this->table_idcard) . " WHERE weid = '{$weid}' And schoolid = {$school['id']} And is_on = 1 ORDER BY id DESC");
				foreach($parter as $key =>$row) {
					$parter[$key]['USERNAME'] = "01" . $row['ID'];
					if($row['UTYPE'] ==1){
						$parter[$key]['PTITLE'] = "老师";
					}else{
						if($row['PARD'] == 1){
							$pard = "本人";	
						}
						if($row['PARD'] == 2){
							$pard = "妈妈";	
						}
						if($row['PARD'] == 3){
							$pard = "爸爸";	
						}
						if($row['PARD'] == 4){
							$pard = "爷爷";	
						}
						if($row['PARD'] == 5){
							$pard = "奶奶";	
						}
						if($row['PARD'] == 6){
							$pard = "外公";	
						}
						if($row['PARD'] == 7){
							$pard = "外婆";	
						}
						if($row['PARD'] == 8){
							$pard = "叔叔";	
						}
						if($row['PARD'] == 9){
							$pard = "阿姨";	
						}
						if($row['PARD'] == 10){
							$pard = "家长";	
						}
						$parter[$key]['PTITLE'] = $pard;
					}
				}			
			$result['getParents'] = $parter;
			echo json_encode($result);
		}
    }
	if ($operation == 'check') {	
		$fstype = false;
		$ckuser = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$_GPC['signId']}' And weid = '{$weid}' And schoolid = '{$schoolid}' ");
		$bj = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = '{$ckuser['sid']}' ");
		if(!empty($ckuser)){
			$times = TIMESTAMP;
			$pic = $_GPC['picurl'];
			$nowtime = date('H:i',$times);
			if($ckmac['type'] !=0){
				include 'checktime2.php';	
			}else{
				include 'checktime.php';	
			}
			$signTime = strtotime($_GPC['signTime']);
			if(!empty($ckuser['sid'])){
				if($school['is_cardpay'] == 1){					
					if($ckuser['severend'] > $times){
						$data = array(
						'weid' => $weid,
						'schoolid' => $schoolid,
						'macid' => $ckmac['id'],
						'cardid' => $_GPC ['signId'],
						'sid' => $ckuser['sid'],
						'bj_id' => $bj['bj_id'],
						'type' => $type,
						'pic' => $pic,
						'temperature' => $_GPC ['signTemp'],
						'leixing' => $leixing,
						'pard' => $ckuser['pard'],
						'createtime' => $signTime
						);
						pdo_insert($this->table_checklog, $data);
						$checkid = pdo_insertid();
						$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
						$fstype = true;
					}					
				}else{
					$data = array(
					'weid' => $weid,
					'schoolid' => $schoolid,
					'macid' => $ckmac['id'],
					'cardid' => $_GPC ['signId'],
					'sid' => $ckuser['sid'],
					'bj_id' => $bj['bj_id'],
					'type' => $type,
					'pic' => $pic,
					'temperature' => $_GPC ['signTemp'],
					'leixing' => $leixing,
					'pard' => $ckuser['pard'],
					'createtime' => $signTime
					);
					pdo_insert($this->table_checklog, $data);
					$checkid = pdo_insertid();
					$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
					$fstype = true;
				}
			}
			if(!empty($ckuser['tid'])){
				$data = array(
				'weid' => $weid,
				'schoolid' => $schoolid,
				'macid' => $ckmac['id'],
				'cardid' => $_GPC ['signId'],
				'tid' => $ckuser['tid'],
				'type' => $type,
				'leixing' => $leixing,
				'pic' => $pic,
				'pard' => 1,
				'createtime' => $signTime
				);
				pdo_insert($this->table_checklog, $data);
				$fstype = true;		
			}	
		}		
		if ($fstype !=false){
			$result['returnCode'] = "000";
			$result['insertKqInfo'] = array(
				array(
					'COLNUM' => "1"
				)
			);
			echo json_encode($result);
        }else{
			$result['returnCode'] = "222";
			$result['insertKqInfo'] = array(
				array(
					'COLNUM' => "2"
				)
			);
			echo json_encode($result);
		}	
	}
?>