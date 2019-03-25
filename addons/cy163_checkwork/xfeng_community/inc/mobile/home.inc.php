<?php
/**
 * 微小区模块
 *
 * [晓锋] Copyright (c) 2013 qfinfo.cn
 */
/**
 * 微信端首页
 */

global $_GPC, $_W;
$regionid = intval($_GPC['regionid']);
$type = trim($_GPC['type']);
$member = $this->changemember($type,$regionid);
//print_r($member);exit();
$region = $this->mreg();

// 分享
$_share = array(
    'title'  => $this->module['config']['share_title'],
    'desc'   => $this->module['config']['share_desc'],
    'imgUrl' => tomedia($this->module['config']['share_imgurl']),
    'link'   => $this->module['config']['share_link'] ? $this->module['config']['share_link'] : $_W['siteroot'] . 'app' . substr($this->createMobileUrl('home'), 1)
);
$slide = pdo_fetchall("SELECT * FROM" . tablename('xcommunity_slide') . "WHERE weid=:uniacid", array(':uniacid' => $_W['uniacid']));
if ($slide) {
    $slides = array();
    foreach ($slide as $key => $value) {
        $regions = unserialize($value['regionid']);
        if (@in_array($member['regionid'], $regions)) {
            $slides[] = array(
                'id'    => $value['id'],
                'title' => $value['title'],
                'thumb' => $value['thumb'],
                'url'   => $value['url']
            );
        }
    }
}

//一级菜单数据
$menu = pdo_get('xcommunity_nav', array('uniacid' => $_W['uniacid'], 'status' => 1, 'pcate' => 0, 'isshow' => 1), array('title'));
//$list = pdo_getall('xcommunity_nav', array('uniacid' => $_W['uniacid'], 'status' => 1, 'pcate' => 0), array('title', 'id', 'regionid', 'enable'));
$list = pdo_fetchall("SELECT * FROM".tablename('xcommunity_nav')."WHERE uniacid = :uniacid AND status = 1 AND pcate = 0 order by displayorder asc",array(":uniacid" => $_W['uniacid']));
$g = array();
foreach ($list as $key => $value) {
    $regions = unserialize($value['regionid']);
    if ($value['enable'] == 1) {
        $g[] = array(
            'id'    => $value['id'],
            'title' => $value['title'],
        );
    }
    else {
        if (@in_array($member['regionid'], $regions)) {
            $g[] = array(
                'id'    => $value['id'],
                'title' => $value['title'],
            );
        }
    }
}
//二级菜单数据
$children = array();
foreach ($g as $k => $val) {
    //$childs = pdo_getall('xcommunity_nav', array('pcate' => $val['id'], 'uniacid' => $_W['uniacid'], 'status' => 1, 'isshow' => 1), array('id', 'title', 'enable', 'thumb', 'url', 'icon', 'bgcolor', 'view', 'regionid'));
    $childs = pdo_fetchall("SELECT * FROM".tablename('xcommunity_nav')." WHERE pcate =:pcate AND uniacid = :uniacid AND status = 1  AND isshow = 1 order by displayorder asc",array(":pcate"=> $val['id'],'uniacid' => $_W['uniacid']));
    $navs = array();
    foreach ($childs as $k => $v) {
            $regions = unserialize($v['regionid']);
            if ($v['enable'] == 1) {
                $navs[] = array(
                    'title'   => $v['title'],
                    'id'      => $v['id'],
                    'thumb'   => $v['thumb'],
                    'url'     => $v['url'],
                    'icon'    => $v['icon'],
                    'bgcolor' => $v['bgcolor'],
                    'view'    => $v['view']
                );
            }
            else {
                if (@in_array($member['regionid'], $regions)) {
                    $navs[] = array(
                        'title'   => $v['title'],
                        'id'      => $v['id'],
                        'thumb'   => $v['thumb'],
                        'url'     => $v['url'],
                        'icon'    => $v['icon'],
                        'bgcolor' => $v['bgcolor'],
                        'view'    => $v['view']
                    );
                }
            }
    }
    $children[$val['id']] = $navs;
}
$page = intval($_GPC['page']);
$good = @$this->goods($member['regionid'],$page);
//首页推荐商品
if ($_W['isajax']) {
    $page = intval($_GPC['page']);
    $goods = @$this->goods($member['regionid'],$page);
    $data = array();
    $data['list'] = $goods;
    die(json_encode($data));

}

//获取购物车数量
$carttotal = $this->getCartTotal();
//最新公告
$notice = notice($member['regionid']);
//最新公告
$activities = activity($member['regionid']);
//菜单;
$menus = pdo_fetchall('select * from'.tablename('xcommunity_nav').'where uniacid =:uniacid and status = 1 and isshow = 1 order by displayorder asc ',array(':uniacid' => $_W['uniacid']));
$n =array();
foreach ($menus as $k => $v) {
    if($v['pcate']){
        $regions = unserialize($v['regionid']);
        if ($v['enable'] == 1) {
            $n[] = array(
                'title'   => $v['title'],
                'id'      => $v['id'],
                'thumb'   => $v['thumb'],
                'url'     => $v['url'],
                'view'    => $v['view']
            );
        }
        else {
            if (@in_array($member['regionid'], $regions)) {
                $n[] = array(
                    'title'   => $v['title'],
                    'id'      => $v['id'],
                    'thumb'   => $v['thumb'],
                    'url'     => $v['url'],
                    'view'    => $v['view']
                );
            }
        }
    }
}
$s = json_encode($n);
$categories = pdo_fetchall("SELECT * FROM".tablename('xcommunity_category')."WHERE weid=:weid AND isshow =1 AND parentid = 0 AND type=5 order by displayorder desc ",array('weid' => $_W['uniacid']));
$count = readnotice($member['regionid']);
include $this->template($this->xqtpl('home/home'));
















