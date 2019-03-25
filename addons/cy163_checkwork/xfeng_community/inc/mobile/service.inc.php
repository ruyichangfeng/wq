<?php
/**
 * 微小区模块
 *
 * [晓锋] Copyright (c) 2013 qfinfo.cn
 */
/**
 * 微信端公告页面
 */
global $_GPC, $_W;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
$id = intval($_GPC['id']);
$member = $this->changemember();
$region = $this->mreg();
if ($op == 'list') {
    $categories = pdo_fetchall("SELECT * FROM" . tablename('xcommunity_category') . "WHERE weid='{$_W['weid']}' AND type=8");
    foreach ($categories as $key => $val){
        $categories[$key]['url'] = $this->createMobileUrl('service',array('op' => 'list','cid' => $val['id']));
    }
    $data = json_encode($categories);
    if($_W['isajax']){
        $pindex = max(1, intval($_GPC['page']));
        $psize = 100;
        $condition ='';
        if($_GPC['cid']){
            $condition .=" and cid =:cid";
            $param[':cid'] = intval($_GPC['cid']);
        }
        $sql = "select * from " . tablename("xcommunity_service") . " where uniacid='{$_W['uniacid']}' $condition order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
        $row = pdo_fetchall($sql,$param);
        $list = array();
        foreach ($row as $key => $value) {
            if ($value['regionid'] != 'N;') {
                $regions = unserialize($value['regionid']);
                if (@in_array($member['regionid'], $regions)) {
                    $list[] = array(
                        'id' => $value['id'],
                        'createtime' => $value['createtime'],
                        'content' => $value['content'],
                        'title' => $value['title'],
                        'thumb' => $value['thumb'],
                        'description' => $value['description'],
                        'url' => $this->createMobileUrl('service',array('op' => 'detail','id' => $value['id']))
                    );
                }
            }
        }
        $data = array();
        $data['list'] = $list;
        die(json_encode($data));
    }
    include $this->template($this->xqtpl('service/list'));
}
elseif ($op == 'detail') {
    $item = pdo_fetch("select * from " . tablename("xcommunity_service") . "where uniacid='{$_W['uniacid']}' and id =:id", array(':id' => $id));


    include $this->template($this->xqtpl('service/detail'));
}

