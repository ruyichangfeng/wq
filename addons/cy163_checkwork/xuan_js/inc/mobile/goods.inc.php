<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
//获取系统配置
$config =m('member')->getconfig();
$id=$_GPC['id'];
$uidopenid=m('member')->get_uidopenid();
if ($id) { 
	//获取商品
	$goods=m('goods')->getone($id);
	//相册拆分
	$imgk=explode('@',$goods['img']);
	//获取用户
	$user=m('member')->getinfo($goods['uid'],'avatar,gender,nickname,residecity,uid,createtime');
	//获取评论
	$pinglun=m('goods')->getpinglun($id);
	//获取点赞总数
	$sql = "SELECT count(*) FROM " . tablename('xuan_js_zan') . " where fid=:fid";
	$zancount = pdo_fetchcolumn($sql, ['fid'=>$id]);
	//本人是否点赞
	$mezan= m('member')->getzan($uidopenid['uid'],$id);
	//获取前六个点赞头像
	$sql = "SELECT img FROM " . tablename('xuan_js_zan') . " where fid=:fid order by id desc limit 6";
	$zanimg = pdo_fetchall($sql, ['fid'=>$id]);
	//增加view
	$data = array(
    'view' => $goods['view']+1,
	);

    pdo_update('xuan_js_fabu', $data, array('id' => $id));
    /******获取用户收藏********/
	$shoucang = pdo_fetch("SELECT id FROM ".tablename('xuan_js_shoucang')." WHERE fid = :fid and uid=:uid", array(':fid' => $goods['id'],':uid'=>$uidopenid['uid']));
	$shoucang=$shoucang?1:0;
}

include $this->template('goods');