<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC,$_W;

if(empty($_GPC['type'])){ $type="display"; }else{ $type=$_GPC['type']; }

if($type == 'display'){

	$sql = 'select * from '.tablename('index_page_list').' where uniacid=:uniacid ';

	$result = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));

	foreach ($result as &$settings) {

		$qrcodeurl = 'http://pan.baidu.com/share/qrcode?w=150&h=150&url=';

   		$qrcodeurl.=urlencode($_W['siteroot'].'app' . str_replace('./', '/', $this->createMobileUrl('index',array('id'=>$settings['id']))));

   		$settings['qrcodeurl'] = $qrcodeurl;

   		//统计浏览量

   		$sql = 'select SUM(readed) from '.tablename('index_page_readed').' where moduleid=:moduleid ';

   		$settings['readed'] = pdo_fetchcolumn($sql,array(':moduleid'=>$settings['id']));
	}

	unset($settings);

}else if($type == 'add'){

	if(checksubmit()){

		$_GPC['images'] = serialize($_GPC['images']);

		$array = array(

					'uniacid'=>$_W['uniacid'],

					'name'=>$_GPC['name'],

					'url'=>$_GPC['url'],

					'status'=>$_GPC['status'],

					'weixin'=>$_GPC['weixin'],

					'images'=>$_GPC['images'],

			);

		pdo_insert('index_page_list',$array);

		message('已经成功添加');

	}

}else if($type == 'edit'){

	$sql = 'select * from '.tablename('index_page_list').' where uniacid=:uniacid and id=:id';

	$settings = pdo_fetch($sql,array(':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));

	$settings['images'] = unserialize($settings['images']);

	$qrcodeurl = 'http://pan.baidu.com/share/qrcode?w=150&h=150&url=';

    $qrcodeurl.=urlencode($_W['siteroot'].'app' . str_replace('./', '/', $this->createMobileUrl('index',array('id'=>$settings['id']))));

	if(checksubmit()){

		$_GPC['images'] = serialize($_GPC['images']);

		$array = array(

					'uniacid'=>$_W['uniacid'],

					'name'=>$_GPC['name'],

					'url'=>$_GPC['url'],

					'status'=>$_GPC['status'],

					'weixin'=>$_GPC['weixin'],

					'images'=>$_GPC['images'],

			);
	

		pdo_update('index_page_list',$array,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

		message('已经成功更新');
	}
}else if($type=='del'){

	pdo_delete('index_page_list',array('id'=>$_GPC['id']));

	message('删除成功');
}else if($type=='addwxshare'){
	
	$sql = 'select * from '.tablename('index_page_wxshare').' where uniacid=:uniacid and moduleid=:moduleid';
	
	$settings = pdo_fetch($sql,array(':moduleid'=>$_GPC['moduleid'],':uniacid'=>$_W['uniacid']));
	
	if(checksubmit()){

		if($settings){
			$array = array(

					'share'=>$_GPC['share'],

					'share_title'=>$_GPC['share_title'],

					'share_image'=>$_GPC['share_image'],

					'share_desc'=>$_GPC['share_desc'],

					'updatetime'=>time(),

				);
		

			pdo_update('index_page_wxshare',$array,array('moduleid'=>$_GPC['moduleid'],'uniacid'=>$_W['uniacid']));

			message('已经成功更新');

		}else{

			$array = array(

					'share'=>$_GPC['share'],

					'moduleid'=>$_GPC['moduleid'],

					'uniacid'=>$_W['uniacid'],

					'share_title'=>$_GPC['share_title'],

					'share_image'=>$_GPC['share_image'],

					'share_desc'=>$_GPC['share_desc'],

					'updatetime'=>time(),

				);
		

			pdo_insert('index_page_wxshare',$array);

			message('已经成功添加');

		}
		
	}
}else if($type=='read'){
	$condition = '';
	if(!empty($_GPC['name'])){
		$condition = " AND b.nickname LIKE '%".$_GPC['name']."%'";
	}
	$pindex    = max(1, intval($_GPC['page']));
	$psize     = 20;
	$sql = 'select a.readed,b.nickname,b.avatar from '.tablename('index_page_readed').' as a left join '.tablename('index_page_member').' as b on a.openid=b.openid where a.moduleid=:moduleid'.$condition.' group by a.openid';
	$sql .= " limit " . ($pindex - 1) * $psize . ',' . $psize;
	$list = pdo_fetchall($sql,array(':moduleid'=>$_GPC['id']));
	$total           = pdo_fetchcolumn("select count(*) from" . tablename('index_page_readed') . " where moduleid=:moduleid ",array(':moduleid'=>$_GPC['id']));
	$pager           = pagination($total, $pindex, $psize);
}

include $this->template('index_page');

?>