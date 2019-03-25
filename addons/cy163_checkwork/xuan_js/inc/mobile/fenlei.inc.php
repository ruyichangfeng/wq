<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;

$category=m('category')->getList(array('parentid'=>'0','enabled'=>1,'order'=>' displayorder asc'));
$uidopenid=m('member')->get_uidopenid();
$xiaoxi=m('chat')->allnoread($uidopenid['uid']);
include $this->template('fenlei');