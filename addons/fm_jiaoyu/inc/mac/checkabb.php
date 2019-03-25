<?php
/**
 * By 高贵血迹
 */

global $_GPC, $_W;

$operation = in_array($_GPC ['op'], array('default', 'login', 'classinfo', 'check', 'shexiangtou', 'banner', 'video', 'start', 'info','info_report','online','report')) ? $_GPC ['op'] : 'default';
$weid      = trim($_GPC['i']);
$schoolid  = trim($_GPC['schoolid']);
$macids    = trim($_GPC['macid']);
$macid     = !empty($macids) ? $macids :trim($_GPC['mac']);
$ckmac     = pdo_fetch("SELECT * FROM " . tablename($this->table_checkmac) . " WHERE macid = '{$macid}' And weid = '{$weid}' And schoolid = '{$schoolid}' ");
$school    = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}' ");

if($operation == 'default'){
    echo("你是SB吗?");
    exit();
}

if(empty($school)){
    $result['error']    = true;
    $result['errormsg'] = "找不到本校，设备未关联学校";
    echo json_encode($result);
}
if(empty($ckmac)){
    $result['error']    = true;
    $result['errormsg'] = "没找到设备,请添加设备";
    echo json_encode($result);
}

if($school['is_recordmac'] == 2){
    $result['error']    = true;
    $result['errormsg'] = "本校无权使用设备,请联系管理员";
    echo json_encode($result);
}
if($ckmac['is_on'] == 2){
    $result['error']    = true;
    $result['errormsg'] = "本设备已关闭,请在管理后台打开";
    echo json_encode($result);
}
if(empty($_W['setting']['remote']['type'])){
    $urls = $_W['SITEROOT'] . $_W['config']['upload']['attachdir'] . '/';
}else{
    $urls = $_W['attachurl'];
}

//查询园所
if($operation == 'start'){
    if(!empty($ckmac)){
		$sxt             = unserialize($ckmac['macset']);
        $result['data'] = array(
            array(
                'school_name'     => $school['title'],
                'weather_id'      => $sxt['weather_id'],
                'apikey'          => $sxt['apikey'],
				'oss'      	      => empty($sxt['accessKeySecret']) ? false :true,
				'endpoint'        => $sxt['endpoint'],//初始化外网域名
				'bucket'          => $sxt['bucket'],
				'rootUrl'     	  => $sxt['oss'],
				'accessKeyId'  	  => $sxt['accessKeyId'],
				'accessKeySecret' => $sxt['accessKeySecret'],
				'online_url'  	  => $_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&schoolid=' . $schoolid . '&do=checkabb&op=online&m=fm_jiaoyu',
				'check_url'       => $_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&schoolid=' . $schoolid . '&do=checkabb&op=check&m=fm_jiaoyu',
				'report_url'      => $_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&schoolid=' . $schoolid . '&do=checkabb&op=report&m=fm_jiaoyu',
				
            )
        );
        echo json_encode($result);
    }
}

//获取界面上相关的文字信息
if($operation == 'info'){
	$banner          = unserialize($ckmac['banner']);
    if($banner['pop']){
        $result['data']['position4']['content'] = $banner['pop'];
    }else{
        $result['error']    = true;
        $result['errormsg'] = "无校园公告,请先设置";
    }
    echo json_encode($result);
}

//获取最新图片信息
if($operation == 'banner'){
    if($ckmac['banner']){
        $banner          = unserialize($ckmac['banner']);
		if($banner['pic1']){
			$pictures        = array(tomedia($banner['pic1']));
		}
		if($banner['pic1'] && $banner['pic2']){
			$pictures        = array(tomedia($banner['pic1']),tomedia($banner['pic2']));
		}
		if($banner['pic1'] && $banner['pic2'] && $banner['pic3']){
			$pictures        = array(tomedia($banner['pic1']),tomedia($banner['pic2']),tomedia($banner['pic3']));
		}
		if($banner['pic1'] && $banner['pic2'] && $banner['pic3'] && $banner['pic4']){
			$pictures        = array(tomedia($banner['pic1']),tomedia($banner['pic2']),tomedia($banner['pic3']),tomedia($banner['pic4']));
		}
		if($banner['pic1'] && $banner['pic2'] && $banner['pic3'] && $banner['pic4']  && $banner['pic5']){		
			$pictures        = array(tomedia($banner['pic1']),tomedia($banner['pic2']),tomedia($banner['pic3']),tomedia($banner['pic4']),tomedia($banner['pic5']));
		}
        $result['data']  = array(
            'position1' => tomedia($banner['bgimg']),
            'position2' => tomedia($banner['qrcode']),
        );
		$result['data']['position3']['picture'] = $pictures;
        $temp = array(
            'isflow' => 2,
			'pop'  	 	 		=> $banner['pop'],
            'bgimg'  			=> $banner['bgimg'],
            'qrcode'			=> $banner['qrcode'],
            'pic1'  			=> $banner['pic1'],
            'pic2'  			=> $banner['pic2'],
            'pic3'   			=> $banner['pic3'],
            'pic4'  			=> $banner['pic4'],
            'pic5'   			=> $banner['pic5'],
        );
        $data['banner'] = serialize($temp);
        pdo_update($this->table_checkmac, $data, array('id' => $ckmac['id']));
    }else{
        $result['error']    = true;
        $result['errormsg'] = "无法获取幻灯片,请先设置";
    }
    echo json_encode($result);
}

//外置摄像头
if($operation == 'shexiangtou'){
    if(!empty($ckmac['macset'])){
        $sxt            = unserialize($ckmac['macset']);
		if(!empty($sxt['accessKeySecret'])){
		   $result['data'] = array(
				array(
					'device_id'   => $sxt['device_id'],
					'user_id'     => $sxt['user_id'],
					'pwd'         => $sxt['pwd'],
					'school_id'   => $school['id'],
					'school_name' => $school['title'],
				)
			);
		}else{
		   $result['data'] = array(

			);			
		}
    }else{
        $result['error']    = true;
        $result['errormsg'] = "无法获取外接云摄像头,请先设置";
    }
    echo json_encode($result);
}

//查询某学校的卡号信息
if($operation == 'classinfo'){
    $classid = $_GPC['classId'];
    if(!empty($ckmac)){
        $times = TIMESTAMP;
		if($_GPC['near_date']){
			$near_time .= " AND createtime > '{$_GPC['near_date']}' ";
		}
        $users = pdo_fetchall("SELECT idcard as card_id, sid as baby_id, bj_id as CLASS_ID, usertype as USERTYPE, sid as SID, tid as TID, pard as PARD FROM " . tablename($this->table_idcard) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And is_on = 1 And severend > '{$times}' $near_time ORDER BY createtime DESC");
        if($users){
            foreach($users as $key => $row){
                if($row['USERTYPE'] == 1){
                    $teacher                           = pdo_fetch("SELECT tname,thumb,sex,birthdate  FROM " . tablename($this->table_teachers) . " WHERE id = '{$row['TID']}' ");
                    $users[$key]['baby_id']            = "02" . $row['TID'];
                    $users[$key]['card_name']         = "老师卡";
                    $users[$key]['avatar']            = empty($teacher['thumb']) ? tomedia($school['tpic']) : tomedia($teacher['thumb']);
                    $users[$key]['owner_name']         = $teacher['tname'] . "老师";
                    $users[$key]['update_date']        = '';
                    $users[$key]['baby_name']          = '';
                    $users[$key]['baby_name_for_read'] = '';
                    $users[$key]['baby_avatar']        = tomedia($teacher['thumb']);
                    $users[$key]['baby_birthday']      = date('Y-m-d', $teacher['birthdate']);
                    if($row['sex'] == 1){
                        $users[$key]['baby_sex'] = 'male';
                    }else{
                        $users[$key]['baby_sex'] = 'female';
                    }
                    $users[$key]['baby_class'] = "老师";
					$users[$key]['family']     = [];
                }else{
                    $student                   = pdo_fetch("SELECT s_name,icon,sex,birthdate  FROM " . tablename($this->table_students) . " WHERE id = '{$row['SID']}' ");
                    $bjinfo                    = pdo_fetch("SELECT sname  FROM " . tablename($this->table_classify) . " WHERE sid = '{$row['CLASS_ID']}' ");
                    $users[$key]['baby_id']    = $row['baby_id'];
                    $users[$key]['card_name'] = getpardforkqj($row['PARD']) . "卡";
                    $users[$key]['avatar']    = empty($student['icon']) ? tomedia($school['spic']) : tomedia($student['icon']);;
                    if($row['PARD'] == 1){
                        $users[$key]['owner_name'] = $student['s_name'];
                    }else{
                        $users[$key]['owner_name'] = $student['s_name'] . getpardforkqj($row['PARD']);
                    }
                    $users[$key]['update_date']        = '';
                    $users[$key]['baby_name']          = $student['s_name'];
                    $users[$key]['baby_name_for_read'] = '';
                    $users[$key]['baby_avatar']        = tomedia($student['icon']);
                    $users[$key]['baby_birthday']      = date('Y-m-d', $student['birthdate']);
                    if($row['sex'] == 1){
                        $users[$key]['baby_sex'] = 'male';
                    }else{
                        $users[$key]['baby_sex'] = 'female';
                    }
                    $users[$key]['baby_class'] = $bjinfo['sname'];
					$parter = pdo_fetchall("SELECT idcard,pname,pard,spic FROM " . tablename($this->table_idcard) . " WHERE weid = '{$weid}' And schoolid = {$schoolid} And sid = {$row['SID']} And is_on = 1 ORDER BY id DESC");
					foreach($parter as $k => $r){
						if($row['card_id'] != $r['idcard']){
							$parter[$k]['name']   = $r['pname'] . getpardforkqj($r['pard']);
							$parter[$k]['avatar'] = tomedia($r['spic']);
						}
					}
					$users[$key]['family']            = $parter;
				}
                $result['data']['insertorupdate'] = $users;
				$lasttime = pdo_fetch("SELECT createtime FROM " . tablename($this->table_idcard) . " WHERE weid = '{$weid}' And schoolid = '{$school['id']}' And is_on = 1 And severend > '{$times}' $near_time ORDER BY createtime DESC LIMIT 0,1");
				$result['data']['last_time'] = date('Y-m-d H:i:s', $lasttime['createtime']);
            }
        }else{
            $result['error']    = true;
            $result['errormsg'] = "拉取数据失败,或卡库无新增卡";
        }
        echo json_encode($result);
    }
}
//接收刷卡信息
if ($operation == 'check') {
	$fstype = false;
	$ckuser = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$_GPC['card_id']}' And weid = '{$weid}' And schoolid = '{$schoolid}' ");
	$bj = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = '{$ckuser['sid']}' ");
	if(!empty($ckuser)){
		$times = TIMESTAMP;
		$nowtime = date('H:i',$times);
		if($ckmac['type'] !=0){
			include 'checktime2.php';	
		}else{
			include 'checktime.php';
		}
		$signTime = strtotime($_GPC['swipe_time']);
		if(empty($_GPC['oss_img_url1'])){ //如果oss_img_url1为空取file
			$upfile = $_FILES;
			$files_image = reset($upfile);
			$path = "images/fm_jiaoyu/check/". date('Y/m/d/');
			if(!empty($files_image)) {
				load()->func('file');
				$path = "images/fm_jiaoyu/check/". date('Y/m/d/');
				$picurl = $path.random(30) .".jpg";
				move_uploaded_file($files_image['tmp_name'], ATTACHMENT_ROOT .$picurl);
					if (!empty($_W['setting']['remote']['type'])) { 
						$remotestatus = file_remote_upload($picurl);
						if (is_error($remotestatus)) {
							$result['errormsg'] = "远程附件上传失败，请检查配置并重新上传";
						}
					}
			}else{
				$result['errormsg'] = "未接收到考勤图片";
			}
		}else{
			$picurl = trim($_GPC['oss_img_url1']);
		}	
		$picurl2 = trim($_GPC['oss_img_url2']);//第二张图		
		if(!empty($ckuser['sid'])){
			if($school['is_cardpay'] == 1){				
				if($ckuser['severend'] > $times){					
					$data = array(
						'weid' => $weid,
						'schoolid' => $schoolid,
						'macid' => $ckmac['id'],
						'cardid' => $_GPC ['card_id'],
						'sid' => $ckuser['sid'],
						'bj_id' => $bj['bj_id'],
						'type' => $type,
						'pic' => $picurl,
						'pic2' => $picurl2,
						'temperature' => $_GPC['signTemp'],
						'leixing' => $leixing,
						'pard' => $ckuser['pard'],
						'createtime' => $signTime
					);
					pdo_insert($this->table_checklog, $data);
					$checkid = pdo_insertid();
					if($school['send_overtime'] == -1){
						$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
					}else{
						$overtime = $school['send_overtime']*60;
						$timecha = $times - $signTime;
						if($overtime >= $timecha){
							$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
						}							
					}
					$fstype = true;	
				}else{
					$result['errormsg'] = "抱歉！本卡已过期";	
				}					
			}else{
				$data = array(
					'weid' => $weid,
					'schoolid' => $schoolid,
					'macid' => $ckmac['id'],
					'cardid' => $_GPC ['card_id'],
					'sid' => $ckuser['sid'],
					'bj_id' => $bj['bj_id'],
					'type' => $type,
					'pic' => $picurl,
					'pic2' => $picurl2,
					'temperature' => $_GPC ['signTemp'],
					'leixing' => $leixing,
					'pard' => $ckuser['pard'],
					'createtime' => $signTime
				);
				pdo_insert($this->table_checklog, $data);
				$checkid = pdo_insertid();
				if($school['send_overtime'] == -1){
					$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
				}else{
					$overtime = $school['send_overtime']*60;
					$timecha = $times - $signTime;
					if($overtime >= $timecha){
						$this->sendMobileJxlxtz($schoolid, $weid, $bj['bj_id'], $ckuser['sid'], $type, $leixing, $checkid, $ckuser['pard']);
					}
				}					
				$fstype = true;
			}
		}
		if(!empty($ckuser['tid'])){
			$data = array(
				'weid' => $weid,
				'schoolid' => $schoolid,
				'macid' => $ckmac['id'],
				'cardid' => $_GPC ['card_id'],
				'tid' => $ckuser['tid'],
				'type' => $type,
				'leixing' => $leixing,
				'pic' => $picurl,
				'pic2' => $picurl2,
				'pard' => 1,
				'createtime' => $signTime
			);
			pdo_insert($this->table_checklog, $data);
			$fstype = true;		
		}	
	}else{	
		$result['errormsg'] = "抱歉！本卡尚未绑定";
	}		
	if ($fstype == false){
		$result['error']    = true;
	}else{
		$result['result'] = "ok";
	}
	echo json_encode($result);	
}
if ($operation == 'info_report') {
	$result['result'] = "ok";
	echo json_encode($result);
}
if ($operation == 'online') {
	$checkorder = pdo_fetch("SELECT * FROM " . tablename($this->table_online) . " WHERE macid = '{$ckmac['id']}' And result = 2 And isread = 2 ");
	$nowtimes = time();
	$nowtime = date('Y-m-d H:i:s',$nowtimes);
	if($checkorder){
		if(!empty($checkorder['dotime'])){
			if($checkorder['dotime'] < $nowtimes){
				$result['data'] = array(
					array(
						'server_time' => $nowtime,
						'commond'     => $checkorder['commond'],
						'commond_id'  => $checkorder['id']
					)
				);
				pdo_update($this->table_online, array('isread' => 2), array('id' => $checkorder['id']));
			}else{
				$result['data'] = array(
					array(
						'server_time' => $nowtime,
						'commond'     => 0,
						'commond_id'  => ''
					)
				);
			}
		}else{
			$result['data'] = array(
				array(
					'server_time' => $nowtime,
					'commond'     => $checkorder['commond'],
					'commond_id'  => $checkorder['id']
				)
			);
			pdo_update($this->table_online, array('isread' => 2), array('id' => $checkorder['id']));
		}
	}else{
        $result['data'] = array(
            array(
                'server_time' => $nowtime,
                'commond'     => 0,
				'commond_id'  => ''
            )
        );		
	}
	echo json_encode($result);
}
if ($operation == 'report') {
	$order = pdo_fetch("SELECT id,result FROM " . tablename($this->table_online) . " WHERE :id = id", array(':id' => trim($_GPC['commond_id'])));
	if($order){
		if($order['result'] == 2){
			$data = array(
				'result' => trim($_GPC['result']),
				'dotime' => time()
			);
			pdo_update($this->table_online, $data, array('id' => $order['id']));
			$result['result'] = "ok";
		}else{
			$result['error']    = true;
			$result['errormsg'] = "此任务已执行";			
		}
	}else{
		$result['error']    = true;
		$result['errormsg'] = "本条命令已不存在或已被删除";
	}
	echo json_encode($result);
}
?>