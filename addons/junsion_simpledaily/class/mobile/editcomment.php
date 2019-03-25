<?php
global $_W,$_GPC;
$wid = base64_decode($_GPC['wid']);

if ($_W['isajax']){
	$list = pdo_fetchall("select * from ".tablename($this->modulename.'_comment')." where wid='{$wid}' order by createtime desc");
	foreach ($list as $k =>$item){
		$list[$k]['createtime'] = $this->sub_day($item['createtime']);
	}
	die(json_encode($list));
}

$work = pdo_fetch("select id,psw,title from ".tablename($this->modulename.'_works')." where id='{$wid}'");
if (empty($work)) MSG("简记不存在");
load()->model('mc');
$info = mc_oauth_userinfo();
if (checksubmit()){
	$data = array(
			'avatar' => $info['avatar'],
			'nickname' => $info['nickname'],
			'content' => $_GPC['content'],
			'createtime' => time(),
			'wid' => $wid,
			'weid' => $_W['uniacid']
	);
	pdo_insert($this->modulename.'_comment',$data);
	header("location: ".$this->createMobileUrl('myworks',array('wid'=>base64_encode($wid))));
}

include $this->template('edit_comment');