<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W ['uniacid'];
$openid = $_W['openid'];
$schoolid = intval($_GPC['schoolid']);
$obid = 1;

$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
$parents = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where weid = :weid AND schoolid = :schoolid And openid=:openid And userType=:userType", array(':weid' => $weid, ':schoolid' => $schoolid,':openid' => $openid,':userType'=> 'parents'));
if(!empty($parents['area_addr_location'])){
	$parents['area_addr_location'] = json_decode($parents['area_addr_location'],true);
}
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
if(!empty($it)){
	$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $it['sid']));
	$leaves = pdo_fetchall("SELECT * FROM " . tablename($this->table_leave) . " where :schoolid = schoolid And :weid = weid And :sid = sid And :uid = uid  And :isliuyan = isliuyan ORDER BY createtime ASC ", array(
		':weid' => $weid,
		':schoolid' => $schoolid,
		':uid' => $it['uid'],
		':isliuyan' => 1,
		':sid' => $it['sid']
	));
	$orderList = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " where :schoolid = schoolid And :weid = weid And :sid = sid ORDER BY createtime DESC", array(
		':weid' => $weid,
		':schoolid' => $schoolid,
		':sid' => $it['sid']
	));
	$kc_ids = array();
	foreach($orderList as $list){
		if($list['type'] == 2 || ($list['type'] == 1 && $list['status'] == 2)){
			$kc_ids[$list['kcid']] = $list['kcid'];
		}
	}
	if(count($kc_ids) > 0){
		$c_id = join(',',$kc_ids);
		$courses = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND id in ({$c_id})  ORDER BY tid ASC, ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid));

		$tid = $_GPC['tid'] ? $_GPC['tid'] : $courses[0]['tid'];

		$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE weid =  '{$_W['uniacid']}' AND schoolid ={$schoolid} AND id = {$tid} ORDER BY id ASC, id DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');

		$list = array();

		foreach ($leaves as $index => $row) {
			if($row['tid'] == $teacher['id']){
				$member = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid'], ':uid' => $row['uid']));
				$members = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid'], ':uid' => $row['tuid']));
//					$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $row['tid']));
				$list[$index] = $row;
				$list[$index]['tlogo'] = $teacher['thumb'];
				$list[$index]['tname'] = $teacher['tname'];
				$list[$index]['avatar'] = $member['avatar'];
				$list[$index]['nickname'] = $member['nickname'];
				$list[$index]['tavatar'] = $members['avatar'];
				$list[$index]['tnickname'] = $members['nickname'];
			}
		}

		$item = pdo_fetch("SELECT * FROM " . tablename($this->table_leave) . " WHERE id = :id ", array(':id' => $id));

		$this->checkobjiect($schoolid, $students['id'], $obid);
	}
	include $this->template(''.$school['style2'].'/jiaoliu');
}else{
//	session_destroy();
//	include $this->template('bangding');
	include $this->template(''.$school['style2'].'/addchild');
}
?>