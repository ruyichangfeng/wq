<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $this->weid;
        $from_user = $this->_fromuser;
        $id = intval($_GPC['schoolid']);
        $schoolid = intval($_GPC['schoolid']);
        $school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $id));
        $title = $school['title'];

        if (empty($school)) {
            message('参数错误');
        }
        $links = $_W['siteroot'] .'app/'.$this->createMobileUrl('jianjie', array('schoolid' => $schoolid));
        $imgsUrl = $_W['siteroot'].'attachment/images/9/2017/01/logo_5.png';
        include $this->template(''.$school['style1'].'/jianjie');
?>