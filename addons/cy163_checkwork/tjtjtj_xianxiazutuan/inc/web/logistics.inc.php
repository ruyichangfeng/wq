<?php
/*
*
*   物流管理
*
*
*/

/*物流列表*/

$page = intval($_GPC['page']);
$pagesize = 10;
$page = $page == '0' ? 1 : $page;
$count = pdo_fetchcolumn('select count(*) from'.tablename('tjtjtj_xxzt_logistics'));
//echo $count;
$pager = pagination($count,$page,$pagesize);

$records = pdo_fetchall(' select * from '.tablename('tjtjtj_xxzt_logistics').' order by uid ASC limit '.(($page-1)*$pagesize).','.$pagesize);


/*物流添加*/

if(isset($_GPC['submit'])){

	$data = array(

		'sid' => $_GPC['sid'],
		'name' => $_GPC['name'],
		'area' => implode('$',$_GPC['area']),
		'yesfee' => $_GPC['yesfee'],
		'nofee' => $_GPC['nofee']

		);

		$result = pdo_insert('tjtjtj_xxzt_logistics',$data);
		if(!empty($result)){

			message('添加成功',$this->createWebUrl('logistics',array('action' => 'add')),'success');
		}
}


/*删除物流*/
if(isset($_GPC['action']) && $_GPC['action'] == 'delete'){

	$v = pdo_query('DELETE FROM'.tablename('tjtjtj_xxzt_logistics').' WHERE uid ='.$_GPC['uid']);
    if($v){

		message('删除成功',$this->createWebUrl('logistics',array('action' => '')),'success');
	}
}


/*物流编辑*/
if(isset($_GPC['update'])){

	$new_data = array(

		'name' => $_GPC['name'],
		'area' => implode('$',$_GPC['area']),
		'yesfee' => $_GPC['yesfee'],
		'nofee' => $_GPC['nofee']
		);

		$res = pdo_update('tjtjtj_xxzt_logistics',$new_data,array('uid' => $_GPC['uid']));
		if(!empty($res)){
			message('修改成功',$this->createWebUrl('logistics',array('action' => '')),'success');
		}
}

if(isset($_GPC['action']) && $_GPC['action'] == 'update'){

	$re = pdo_fetch('select * from '.tablename('tjtjtj_xxzt_logistics').' where uid = '.$_GPC['uid']);
	if(empty($re)){
		message('数据为空',$this->createWebUrl('goods',array('action' => '')),'success');
	}
}

include $this->template('logisticsmanage');
