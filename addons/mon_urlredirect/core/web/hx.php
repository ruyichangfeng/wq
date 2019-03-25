<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2016/12/18
 * Time: 21:45
 */
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$cid = $_GPC['cid'];
$res = $this -> hx($cid);

if ($res['code'] == 200) {
	message('兑换成功！', referer(), 'success');
} else {
	message('兑换失败！'.$resp , referer(), 'warning');
}