<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

global $_GPC, $_W;

$weid              = $_W['uniacid'];
$action            = 'checklog';
$this1             = 'no5';
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'], $action);
$schoolid          = intval($_GPC['schoolid']);
$logo              = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
load()->func('tpl');
load()->func('file');
load()->func('communication');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($operation == 'display'){
    $pindex    = max(1, intval($_GPC['page']));
    $psize     = 20;
    $condition = '';
    if($_GPC['type'] == 1){
        $type      = intval($_GPC['type']);
        $condition .= " AND leixing = '{$type}' ";
    }
    if($_GPC['type'] == 2){
        $type      = intval($_GPC['type']);
        $condition .= " AND leixing = '{$type}' ";
    }
    if($_GPC['type'] == 3){
        $type      = intval($_GPC['type']);
        $condition .= " AND leixing = '{$type}' ";
    }
    if($_GPC['shenfen'] == 1){
        $condition .= " AND sid > 0 ";
    }
    if($_GPC['shenfen'] == 2){
        $condition .= " AND tid > 0 ";
    }
    if(!empty($_GPC['bj_id'])){
        $condition .= " AND bj_id = '{$_GPC['bj_id']}' ";
    }
    if(!empty($_GPC['createtime'])){
        $starttime = strtotime($_GPC['createtime']['start']);
        $endtime   = strtotime($_GPC['createtime']['end']) + 86399;
        $condition .= " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
    }else{
        $starttime = strtotime('-30 day');
        $endtime   = TIMESTAMP;
    }
    $params[':start'] = $starttime;
    $params[':end']   = $endtime;
    if(!empty($_GPC['sname'])){
        $students  = pdo_fetch("SELECT id FROM " . tablename($this->table_students) . " WHERE schoolid = :schoolid And s_name = :s_name ", array(':schoolid' => $schoolid, ':s_name' => $_GPC['sname']));
        $condition .= " AND sid = '{$students['id']}'";
    }
    if(!empty($_GPC['tname'])){
        $teachers  = pdo_fetch("SELECT id FROM " . tablename($this->table_teachers) . " WHERE schoolid = :schoolid And tname = :tname ", array(':schoolid' => $schoolid, ':tname' => $_GPC['tname']));
        $condition .= " AND tid = '{$teachers['id']}'";
    }
    $allbj = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND weid = '{$weid}' AND type = 'theclass' ORDER BY ssort DESC");

    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	$checkpic = pdo_fetchall("SELECT id FROM " . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND (pic LIKE '%wmpickq%' Or pic2 LIKE '%wmpickq%')");
	$checkpicsl = count($checkpic);
    foreach($list as $index => $row){
        $student                 = pdo_fetch("SELECT s_name FROM " . tablename($this->table_students) . " WHERE id = '{$row['sid']}' ");
        $teacher                 = pdo_fetch("SELECT tname FROM " . tablename($this->table_teachers) . " WHERE id = '{$row['tid']}' ");
        $qdtid                   = pdo_fetch("SELECT tname FROM " . tablename($this->table_teachers) . " WHERE id = '{$row['qdtid']}' ");
        $idcard                  = pdo_fetch("SELECT pname FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$row['cardid']}' ");
        $mac                     = pdo_fetch("SELECT name FROM " . tablename($this->table_checkmac) . " WHERE schoolid = '{$row['schoolid']}' And id = '{$row['macid']}' ");
        $banji                   = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = '{$row['bj_id']}' ");
        $list[$index]['s_name']  = $student['s_name'];
        $list[$index]['tname']   = $teacher['tname'];
        $list[$index]['qdtname'] = $qdtid['tname'];
        $list[$index]['mac']     = $mac['name'];
        $list[$index]['pname']   = $idcard['pname'];
        $list[$index]['bj_name'] = $banji['sname'];
		if (preg_match('/(http:\/\/)|(https:\/\/)/i', $row['pic'])) {
			if (preg_match('/wmpickq/i', $row['pic'])) {
				$img = getImg($row['pic']);
				if(!empty($img)){
					$path = "images/fm_jiaoyu/check_pic/". date('Y/m/d/');
					if (!is_dir(IA_ROOT."/attachment/". $path)) {
						mkdirs(IA_ROOT."/attachment/". $path, "0777");
					}
					$picurl = $path.random(30).".jpg";
					file_write($picurl,$img);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}				
			}else{
				$path = "images/fm_jiaoyu/check/". date('Y/m/d/');
				if (!is_dir(IA_ROOT."/attachment/". $path)) {
					mkdirs(IA_ROOT."/attachment/". $path, "0777");
				}
				$picurl = $path.random(30) .".jpg";
				$pic_data = getimg_form_oss($row['pic']);
				file_write($picurl,$pic_data);
				if (!empty($_W['setting']['remote']['type'])) {
					$remotestatus = file_remote_upload($picurl);
					if (is_error($remotestatus)) {
						message('远程附件上传失败，请检查配置并重新上传');
					}
				}
			}
			pdo_update($this->table_checklog, array('pic' => $picurl), array('id' => $row['id']));
			$list[$index]['img1']     = $picurl;			
		}else{
			$list[$index]['img1']     = $row['pic'];
		}
		if (preg_match('/(http:\/\/)|(https:\/\/)/i', $row['pic2'])) {
			if (preg_match('/wmpickq/i', $row['pic2'])) {
				$img = getImg($row['pic2']);
				if(!empty($img)){
					$path = "images/fm_jiaoyu/check_pic/". date('Y/m/d/');
					if (!is_dir(IA_ROOT."/attachment/". $path)) {
						mkdirs(IA_ROOT."/attachment/". $path, "0777");
					}
					$picurl2 = $path.random(30).".jpg";
					file_write($picurl2,$img);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl2); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}				
			}else{
				$path = "images/fm_jiaoyu/check/". date('Y/m/d/');
				if (!is_dir(IA_ROOT."/attachment/". $path)) {
					mkdirs(IA_ROOT."/attachment/". $path, "0777");
				}
				$picurl2 = $path.random(30) .".jpg";
				$pic_data = getimg_form_oss($row['pic2']);
				file_write($picurl2,$pic_data);
				if (!empty($_W['setting']['remote']['type'])) {
					$remotestatus = file_remote_upload($picurl2);
					if (is_error($remotestatus)) {
						message('远程附件上传失败，请检查配置并重新上传');
					}
				}
			}
			pdo_update($this->table_checklog, array('pic2' => $picurl2), array('id' => $row['id']));
			$list[$index]['img2']     = $picurl2;			
		}else{
			$list[$index]['img2']     = $row['pic2'];
		}
    }
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} $condition");

    $pager = pagination($total, $pindex, $psize);
    //////////导出数据/////////////////
    if($_GPC['out_put'] == 'output'){
        $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} $condition ORDER BY id DESC");
        $ii   = 0;
        foreach($list as $index => $row){
            $student             = pdo_fetch("SELECT s_name FROM " . tablename($this->table_students) . " WHERE id = '{$row['sid']}' ");
            $teacher             = pdo_fetch("SELECT tname FROM " . tablename($this->table_teachers) . " WHERE id = '{$row['tid']}' ");
            $idcard              = pdo_fetch("SELECT pname FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$row['cardid']}' ");
            $mac                 = pdo_fetch("SELECT name FROM " . tablename($this->table_checkmac) . " WHERE schoolid = '{$row['schoolid']}' And id = '{$row['macid']}' ");
            $banji               = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = '{$row['bj_id']}' ");
            $arr[$ii]['kqjname'] = $mac['name'];
            if(!empty($row['sid'])){
                $arr[$ii]['skname'] = $student['s_name'];
            }else{
                $arr[$ii]['skname'] = $teacher['tname'];
            }
            if(!empty($row['pard'])){
                $pard = $row['pard'];
                include '../addons/fm_jiaoyu/inc/func/pard.php';
                $arr[$ii]['sf'] = empty($jsr) ? '本人' : $jsr;
            }
            if($row['checktype'] == 1){
                $arr[$ii]['idcard'] = $row['cardid'];
            }else{
                $arr[$ii]['idcard'] = '微信端签到';
            }
            $arr[$ii]['bjnanme'] = empty($row['bj_id']) ? '教师组' : $banji['sname'];
            $arr[$ii]['jczt']    = $row['type'];
            $arr[$ii]['pnames']  = $row['pname'];
            $arr[$ii]['sktime']  = date('Y年m月d日 h:i:s', $row['createtime']);
            $arr[$ii]['temper']  = empty($row['temperature']) ? '未测' : $row['temperature'];
            $arr[$ii]['pic']     = empty($row['pic']) ? '无' : '有';
            $ii++;
        }
        //echo "<pre>";print_r($arr);exit;
        $this->exportexcel($arr, array('考勤机', '刷卡人', '身份', '卡号', '班级', '进出状态', '持卡人姓名', '刷卡时间', '体温', '是否拍照'), '考勤记录');
        exit();
    }
    ////////////////////////////////
	if($_GPC['download'] == 'download'){
		$listss = pdo_fetchall("SELECT id,pic,pic2 FROM " . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid ='{$schoolid}'  ORDER BY createtime DESC");
		$rowcount    = 0;
		$notrowcount = 0;		
		foreach($listss as $key =>$r){
			if (preg_match('/(http:\/\/)|(https:\/\/)/i', $r['pic'])) {
				$img = getImg($r['pic']);
				if(!empty($img)){
					$path = "images/fm_jiaoyu/check_pic/". date('Y/m/d/');
					if (!is_dir(IA_ROOT."/attachment/". $path)) {
						mkdirs(IA_ROOT."/attachment/". $path, "0777");
					}
					$picurl = $path.random(30).".jpg";
					file_write($picurl,$img);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl); //
							if (is_error($remotestatus)) {
								$this->imessage('远程附件上传失败，请检查配置并重新上传', $this->createWebUrl('checklog', array('op' => 'display', 'schoolid' => $schoolid)), 'error');
							}
						}
					pdo_update($this->table_checklog, array('pic' => $picurl), array('id' => $r['id']));
					$rowcount++;
				}else{
					$notrowcount++;
				}
			}
			if (preg_match('/(http:\/\/)|(https:\/\/)/i', $r['pic2'])) {
				$img2 = getImg($r['pic2']);
				if(!empty($img2)){
					$path = "images/fm_jiaoyu/check_pic/". date('Y/m/d/');
					if (!is_dir(IA_ROOT."/attachment/". $path)) {
						mkdirs(IA_ROOT."/attachment/". $path, "0777");
					}
					$picurl2 = $path.random(30).".jpg";
					file_write($picurl2,$img2);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl2); //
							if (is_error($remotestatus)) {
								$this->imessage('远程附件上传失败，请检查配置并重新上传', $this->createWebUrl('checklog', array('op' => 'display', 'schoolid' => $schoolid)), 'error');
							}
						}
					pdo_update($this->table_checklog, array('pic2' => $picurl2), array('id' => $r['id']));
					$rowcount++;
				}else{
					$notrowcount++;
				}
			}			
		}
		$this->imessage("共同步{$rowcount}张图片,{$notrowcount}张同步失败!", $this->createWebUrl('checklog', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
	}
}elseif($operation == 'delete'){
    $id       = intval($_GPC['id']);
    $checklog = pdo_fetch("SELECT id  FROM " . tablename($this->table_checklog) . " WHERE id = '$id' ");
    if(empty($checklog)){
        $this->imessage('抱歉，不存在或是已经被删除！', $this->createWebUrl('checklog', array('op' => 'display', 'schoolid' => $schoolid)), 'error');
    }
    pdo_delete($this->table_checklog, array('id' => $id));
    $this->imessage('删除成功！', $this->createWebUrl('checklog', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
}elseif($operation == 'deleteall'){
    $rowcount    = 0;
    $notrowcount = 0;
    foreach($_GPC['idArr'] as $k => $id){
        $id = intval($id);
        if(!empty($id)){
            $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " WHERE id = :id", array(':id' => $id));
            if(empty($goods)){
                $notrowcount++;
                continue;
            }
            pdo_delete($this->table_checklog, array('id' => $id, 'weid' => $weid));
            $rowcount++;
        }
    }
	$message = "操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!";

	$data ['result'] = true;

	$data ['msg'] = $message;

	die (json_encode($data));
}else{
    $this->imessage('请求方式不存在');
}
include $this->template('web/checklog');
?>