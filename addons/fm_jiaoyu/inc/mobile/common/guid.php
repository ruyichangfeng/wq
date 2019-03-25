<?php
/**
 * 微教育模块
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$schoolid = intval($_GPC['schoolid']);
$guid = intval($_GPC['guid']);
$banner = pdo_fetch("select * from " . tablename($this->table_banners) . " where id = :id ", array(":id" => $guid));
$imgs = explode(',',$banner['thumb']);
$stopurl = $_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&m=fm_jiaoyu'.'&schoolid='.$schoolid.'&do='.$_GPC['place'];
//print_r($imgs);
$school = pdo_fetch("SELECT style1,title FROM " . tablename($this->table_index) . " where weid = :weid AND id= :id", array(':weid' => $weid, ':id' => $schoolid));
$title = $school['title'];
if (empty($school)) {
	message('参数错误');
}
include $this->template(''.$school['style1'].'/guid');
?>