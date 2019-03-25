<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
} 
class Xuan_js_goods {
	public function getone($id){
		global $_W;
		$sql = "SELECT * FROM " . tablename('xuan_js_fabu') . " where id=:id and uniacid=:uniacid";
        //获取点赞
        $count = pdo_fetch($sql, ['id'=>$id,'uniacid'=>$_W['uniacid']]);
        return $count;
	}
	public function getpinglun($id){
		global $_W;
		$sql = "SELECT * FROM " . tablename('xuan_js_pinglun') . " where fid=:fid order by id desc";
        //获取点赞
        $count = pdo_fetchall($sql, ['fid'=>$id]);
        return $count;
	}
}