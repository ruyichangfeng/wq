<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$openid = $_W['openid'];
$schoolid = intval($_GPC['schoolid']);
$userss = intval($_GPC['userid']);
$user = pdo_fetchall("SELECT * FROM " . tablename($this->table_user) . " where :weid = weid And :openid = openid And :schoolid = schoolid", array(
    ':weid' => $weid,
    ':openid' => $openid,
    ':schoolid' => $schoolid
));
$num = count($user);
$flag = 1;
if ($num > 1){
    $flag = 2;
}
$tid = 0;
foreach($user as $key => $row){
    if($row['tid'] == 0){
        $student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id=:id ", array(':id' => $row['sid']));
        $bajinam = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid=:sid ", array(':sid' => $student['bj_id']));
        $user[$key]['s_name'] = $student['s_name'];
        $user[$key]['bjname'] = $bajinam['sname'];
        $user[$key]['sid'] = $student['id'];
        $user[$key]['schoolid'] = $student['schoolid'];
    }
    if($row['tid'] != 0){
        $tid = $row['tid'];
    }
}
if(!empty($userss)){
    $ite = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And weid = :weid AND id=:id ", array(':schoolid' => $schoolid,':weid' => $weid, ':id' => $userss));
    if(!empty($ite)){
        $_SESSION['user'] = $ite['id'];
    }
}else{
    if(empty($_SESSION['user'])){
        $userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :tid != tid LIMIT 0,1 ", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':tid' => 0), 'id');
        if(!empty($userid)){
            $_SESSION['user'] = $userid['id'];
        }
    }
}
$it = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $sid));
$leixing = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " WHERE weid = :weid ORDER BY id ASC, ssort DESC", array(':weid' => $weid), 'id');
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid  AND tid = :tid ORDER BY ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid,':tid' => $tid));
$item = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id ", array(':id' => $id));
$title = $item['title'];
$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid = :schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
$km = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));

$list1 = $list2 = $list3 = array();
//list1:已开课,list2:已成班未开课,list3:已发布未成班
$timeStamp = strtotime(date('Y-m-d'));
foreach($list as $key => $value){
    if($value['start'] <= $timeStamp && $value['end'] >= $timeStamp){
        $list1[] = $value;
    }elseif($value['start'] > $timeStamp && $value['minge'] == $value['yibao']){
        $list2[] = $value;
    }elseif($value['minge'] != $value['yibao'] && $value['start'] > $timeStamp){
        $list3[] = $value;
    }else{
        continue;
    }
}
if (empty($schoolid)) {
    message('没有找到该学校，请联系管理员！');
}

include $this->template(''.$school['style3'].'/mykclist');
?>