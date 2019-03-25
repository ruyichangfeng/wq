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
    if($_W['isajax']){
        $pindex = max(1, intval($_GPC['page']));
        $psize = 100;
        $sql = "select * from " . tablename("xcommunity_wnotice") . " where uniacid='{$_W['uniacid']}' order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
        $row = pdo_fetchall($sql);
        $list = array();
        foreach ($row as $key => $value) {
            if ($value['regionid'] != 'N;') {
                $regions = unserialize($value['regionid']);
                $arr = pdo_getall('xcommunity_pstyle_content',array('wid' => $value['id']),array('title','thumb','id'));
                foreach ($arr as $k => $val){
                    $arr[$k]['durl'] = $this->createMobileUrl('pstyle',array('op' => 'det','id' => $val[id]));
                }
                if (@in_array($member['regionid'], $regions)) {
                    $list[] = array(
                        'id' => $value['id'],
                        'createtime' => $value['createtime'],
                        'content' => $value['content'],
                        'title' => $value['title'],
                        'thumb' => $value['thumb'],
                        'url' => $this->createMobileUrl('wnotice',array('op' => 'detail','id' => $value[id])),
                        'arr' => $arr

                    );
                }
            }
        }
        $data = array();
        $data['list'] = $list;
        die(json_encode($data));
    }
    include $this->template($this->xqtpl('wnotice/list'));
}
elseif ($op == 'detail') {
    $item = pdo_fetch("select * from " . tablename("xcommunity_wnotice") . "where uniacid='{$_W['uniacid']}' and id =:id", array(':id' => $id));


    include $this->template($this->xqtpl('wnotice/detail'));
}

