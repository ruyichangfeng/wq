<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_GPC, $_W;
$weid              = $_W['uniacid'];
$action1           = 'template';
$this1             = 'no1';
$action            = 'semester';
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'], $action);
$schoolid          = intval($_GPC['schoolid']);
$logo              = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$operation         = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($operation == 'display'){
    if(checksubmit('submit')){
        $data = array(
            'style1'    => trim($_GPC['style1']),
            'style2'    => trim($_GPC['style2']),
            'style3'    => trim($_GPC['style3']),
            'userstyle' => trim($_GPC['userstyle']),
            'bjqstyle'  => trim($_GPC['bjqstyle']),
        );

        pdo_update($this->table_index, $data, array('id' => $schoolid, 'weid' => $weid));
        $this->imessage('修改前端模板成功!', referer(), 'success');
    }
}elseif($operation == 'display1'){
    $icons = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid And place = :place ORDER by ssort ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':place' => 1));
    if(checksubmit('submit')){
        $titles         = $_GPC['iconname'];
        $url            = $_GPC['url'];
        $icon           = $_GPC['iconurl'];
        $ssort          = $_GPC['ssort'];
        $filter         = array();
        $filter['weid'] = $_W['uniacid'];
        foreach($titles as $key => $t){
            $id           = intval($key);
            $filter['id'] = intval($id);
            if(!empty($t)){
                $rec = array(
                    'name'  => $t,
                    'icon'  => trim($icon[$id]),
                    'url'   => trim($url[$id]),
                    'ssort' => intval($ssort[$id])
                );
                pdo_update($this->table_icon, $rec, $filter);
            }
        }
        $this->imessage('修改成功!', referer(), 'success');
    }
}elseif($operation == 'display2'){
    $icons1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid And place = :place ORDER by id ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':place' => 3));
    $icons2 = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid And place = :place ORDER by id ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':place' => 4));
    $icons3 = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid And place = :place ORDER by id ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':place' => 5));
    $lastid = pdo_fetch("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid ORDER by id DESC LIMIT 0,1", array(':weid' => $weid, ':schoolid' => $schoolid));
    if(checksubmit('submit')){
        $type               = $_GPC['type'];//类型 1覆盖 2新建
        $btnname            = $_GPC['btnname'];//按钮名称
        $mfbzs              = $_GPC['mfbzs'];//魔方小字
        $bzcolor            = $_GPC['bzcolor'];//魔方按钮颜色
        $iconpics           = $_GPC['iconpics']; //图标地址
        $url                = $_GPC['url']; //链接地址
        $place              = $_GPC['place'];//位置 3顶部 4魔方 5底部
        $filter             = array();
        $filter['weid']     = $_W['uniacid'];
        $filter['schoolid'] = $_W['schoolid'];
        foreach($type as $key => $t){
            $id           = intval($key);
            $filter['id'] = intval($id);
            if($t == 1){
                $rec = array(
                    'name'   => trim($btnname[$id]),
                    'beizhu' => trim($mfbzs[$id]),
                    'color'  => trim($bzcolor[$id]),
                    'icon'   => trim($iconpics[$id]),
                    'url'    => trim($url[$id]),
                    'place'  => intval($place[$id])
                );
                pdo_update($this->table_icon, $rec, array('id' => $id));
            }else{
                $data = array(
                    'weid'     => trim($_GPC['weid']),
                    'schoolid' => trim($_GPC['schoolid']),
                    'name'     => trim($btnname[$id]),
                    'beizhu'   => trim($mfbzs[$id]),
                    'color'    => trim($bzcolor[$id]),
                    'icon'     => trim($iconpics[$id]),
                    'url'      => trim($url[$id]),
                    'place'    => intval($place[$id]),
                    'status'   => 1,
                );
                pdo_insert($this->table_icon, $data);
            }
        }
        $this->imessage('操作成功!', referer(), 'success');
    }
}elseif($operation == 'display3'){
    $icons1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid And place = :place ORDER by ssort ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':place' => 6));
    $icons2 = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid And place = :place ORDER by ssort ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':place' => 7));
    $icons22 = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid And place = :place And status = :status ORDER by ssort ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':place' => 7, ':status' => 1));	
    $icons3 = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid And place = :place ORDER by ssort ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':place' => 8));
    $icons4 = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid And place = :place ORDER by ssort ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':place' => 9));
    $icons44 = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid And place = :place And status = :status ORDER by ssort ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':place' => 9, ':status' => 1));	
    if(checksubmit('submit')){
        $titles         = $_GPC['iconname'];
        $url            = $_GPC['url'];
		$dos             = $_GPC['dos'];
		$bzcolor        = $_GPC['bzcolor'];//魔方按钮颜色
        $icon           = $_GPC['iconurl'];
		$icon2          = $_GPC['iconurl2'];
		$place          = $_GPC['place'];
        $ssort          = $_GPC['ssort'];
        $filter         = array();
        $filter['weid'] = $_W['uniacid'];
        foreach($titles as $key => $t){
            $id           = intval($key);
            $filter['id'] = intval($id);
            if(!empty($t)){
                $rec = array(
                    'name'  => $t,
					'color' => trim($bzcolor[$id]),
                    'icon'  => trim($icon[$id]),
					'icon2' => trim($icon2[$id]),
                    'url'   => trim($url[$id]),
					'do'    => $dos[$id],
					'place' => intval($place[$id]),
                    'ssort' => intval($ssort[$id])
                );
                pdo_update($this->table_icon, $rec, $filter);
            }
        }
        $this->imessage('操作成功!', referer(), 'success');
    }
}elseif($operation == 'reset'){
	//6学生底部 7学生弹框 8教师底部 9教师弹框
	pdo_delete($this->table_icon, array('schoolid' => $schoolid,'place' => 6));
	pdo_delete($this->table_icon, array('schoolid' => $schoolid,'place' => 7));
	pdo_delete($this->table_icon, array('schoolid' => $schoolid,'place' => 8));
	pdo_delete($this->table_icon, array('schoolid' => $schoolid,'place' => 9));
	//学生底部
	$icon1 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'校园','do' => 'detail','color' => '#06c1ae','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon1_noSelect.png','icon2' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon1_Select.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('detail', array('schoolid' => $schoolid)),'place' => 6,'ssort' => 1,'status' => 1,);
	$icon2 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'班级圈','do' => 'sbjq','color' => '#06c1ae','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon2_noSelect.png','icon2' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon2_Select.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('sbjq', array('schoolid' => $schoolid)),'place' => 6,'ssort' => 2,'status' => 1,);
	$icon3 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'通讯录','do' => 'callbook','color' => '#06c1ae','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon3_noSelect.png','icon2' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon3_Select.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('callbook', array('schoolid' => $schoolid)),'place' => 6,'ssort' => 4,'status' => 1,);
	$icon4 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'我的','do' => 'user','color' => '#06c1ae','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon4_noSelect.png','icon2' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon4_Select.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('user', array('schoolid' => $schoolid)),'place' => 6,'ssort' => 5,'status' => 1,);	
	//学生弹框
	$icon5 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'请假','color' => '#EAEAEA','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/ionc_1.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('xsqj', array('schoolid' => $schoolid)),'place' => 7,'ssort' => 1,'status' => 1,);
	$icon6 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'留言','color' => '#F6F4F4','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/ionc_2.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('slylist', array('schoolid' => $schoolid)),'place' => 7,'ssort' => 2,'status' => 1,);
	$icon7 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'发动态','color' => '#EAEAEA','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/ionc_3.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('sbjqfabu', array('schoolid' => $schoolid)),'place' => 7,'ssort' => 3,'status' => 1,);
	$icon8 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'传照片','color' => '#F6F4F4','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/ionc_4.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('sxcfb', array('schoolid' => $schoolid)),'place' => 7,'ssort' => 4,'status' => 1,);
	//教师底部
	$icon9 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'校园','do' => 'detail','color' => '#06c1ae','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon1_noSelect.png','icon2' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon1_Select.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('detail', array('schoolid' => $schoolid)),'place' => 8,'ssort' => 1,'status' => 1,);
	$icon10 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'班级圈','do' => 'bjq','color' => '#06c1ae','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon2_noSelect.png','icon2' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon2_Select.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('bjq', array('schoolid' => $schoolid)),'place' => 8,'ssort' => 2,'status' => 1,);
	$icon11 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'通讯录','do' => 'tongxunlu','color' => '#06c1ae','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon3_noSelect.png','icon2' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon3_Select.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('tongxunlu', array('schoolid' => $schoolid)),'place' => 8,'ssort' => 4,'status' => 1,);
	$icon12 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'我的','do' => 'myschool','color' => '#06c1ae','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon4_noSelect.png','icon2' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/bottom_menu_icon4_Select.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('myschool', array('schoolid' => $schoolid)),'place' => 8,'ssort' => 5,'status' => 1,);	
	//教师弹框
	$icon13 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'发布作业','color' => '#EAEAEA','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/ionc_1.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('zfabu', array('schoolid' => $schoolid)),'place' => 9,'ssort' => 1,'status' => 1,);
	$icon14 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'发通知','color' => '#F6F4F4','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/ionc_2.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('fabu', array('schoolid' => $schoolid)),'place' => 9,'ssort' => 2,'status' => 1,);
	$icon15 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'发动态','color' => '#EAEAEA','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/ionc_3.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('bjqfabu', array('schoolid' => $schoolid)),'place' => 9,'ssort' => 3,'status' => 1,);
	$icon16 = array('weid' => $weid,'schoolid' => $schoolid,'name' =>'传照片','color' => '#F6F4F4','icon' => 'http://weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/public/mobile/img/ionc_4.png','url' => $_W['siteroot'] .'app/'.$this->createMobileUrl('xcfb', array('schoolid' => $schoolid)),'place' => 9,'ssort' => 4,'status' => 1,);	
	pdo_insert($this->table_icon, $icon1);
	pdo_insert($this->table_icon, $icon2);
	pdo_insert($this->table_icon, $icon3);
	pdo_insert($this->table_icon, $icon4);
	pdo_insert($this->table_icon, $icon5);
	pdo_insert($this->table_icon, $icon6);
	pdo_insert($this->table_icon, $icon7);
	pdo_insert($this->table_icon, $icon8);
	pdo_insert($this->table_icon, $icon9);
	pdo_insert($this->table_icon, $icon10);
	pdo_insert($this->table_icon, $icon11);
	pdo_insert($this->table_icon, $icon12);	
	pdo_insert($this->table_icon, $icon13);
	pdo_insert($this->table_icon, $icon14);
	pdo_insert($this->table_icon, $icon15);
	pdo_insert($this->table_icon, $icon16);	
	$this->imessage('操作成功!', referer(), 'success');
}elseif($operation == 'change'){
    $status = trim($_GPC['status']);
    $id     = trim($_GPC['id']);
    $data   = array('status' => $status);
    pdo_update($this->table_icon, $data, array('id' => $id));
}elseif($operation == 'icons22'){
	$status = trim($_GPC['status']);
	$data   = array('status' => $status);
	pdo_update($this->table_icon, $data, array('schoolid' => $schoolid,'place' => 7));
}elseif($operation == 'icons44'){
	$status = trim($_GPC['status']);
	$data   = array('status' => $status);
	pdo_update($this->table_icon, $data, array('schoolid' => $schoolid,'place' => 9));	
}elseif($operation == 'delclass'){
    $id   = trim($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_icon) . " where weid = :weid And schoolid = :schoolid And id = :id", array(':weid' => $weid, ':schoolid' => $_GPC['schoolid'], ':id' => $id));
    if($item){
        pdo_delete($this->table_icon, array('id' => $id));
        $message         = "删除操作成功！";
        $data ['result'] = true;
        $data ['msg']    = $message;
    }else{
        $message         = "删除失败请重刷新页面重试!";
        $data ['result'] = false;
        $data ['msg']    = $message;
    }
    die (json_encode($data));
}
include $this->template('web/template');
?>