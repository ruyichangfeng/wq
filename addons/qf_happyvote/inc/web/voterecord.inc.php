<?php
global $_GPC, $_W;
load()->func('tpl');
load()->func('logging');

require_once MODULE_ROOT . '/common/config.php';
require_once MODULE_ROOT . '/model/voterecord.class.php';


$voterecord = new VoteRecord();

$uniacid = $_W["uniacid"];
$voteid = $_GPC["voteid"];
$joinid = $_GPC["joinid"];

//处理分页参数
$currpage = 1;
$total = 0;
$pagesize = LIST_PAGE_SIZE;

if(is_numeric($_GPC['page'])){
    $currpage = $_GPC['page'];
}

$condition = array();
$pagedata = $voterecord -> getpagevoterecord($voteid, $joinid, $condition, $currpage, $pagesize);

$total = $pagedata['total'];
$listdata = $pagedata['data'];

include $this->template('voterecord');