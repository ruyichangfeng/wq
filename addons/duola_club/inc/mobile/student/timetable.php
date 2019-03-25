<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$schoolid = intval($_GPC['schoolid']);
$userss = intval($_GPC['userid']);
$openid = $_W['openid'];
//查询是否用户登录


include $this->template('students/timetable');