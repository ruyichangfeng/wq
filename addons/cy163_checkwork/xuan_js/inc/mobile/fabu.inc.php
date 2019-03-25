<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
//获取用户uid
$uidopenid=m('member')->get_uidopenid();
$cid=intval($_GPC['cid']);
$cate=m('category')->getCategoryByid($cid);
$cateinfo=unserialize($cate['sheding']);
//获取子分类
$categorychild=m('category')->getList(array('parentid'=>$cid,'enabled'=>1,'order'=>' displayorder asc'));
//获取资料信息
$ziliao=m('user')->getziliao($uidopenid['uid']);


include $this->template('fabu/fabu');