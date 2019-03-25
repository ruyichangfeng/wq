<?php
	if($op=='display'){
		if(checksubmit('submit')){
			$id = $_GPC['id'];
			$listorder = $_GPC['listorder'];
			foreach($id as $key=>$i){
				pdo_update('hc_chips_chip', array('listorder'=>intval($listorder[$key])), array('id'=>$i));
			}
			message('批量更新成功！', $this->createWebUrl('chip'), 'success');
		}
		$chips = pdo_fetchall("select * from ".tablename('hc_chips_chip')." where uniacid = ".$uniacid." order by listorder desc, id desc");
	}

	if($op=='post'){
		$id = $_GPC['id'];
		if(checksubmit('submit')){
			$title = !empty($_GPC['title']) ? $_GPC['title'] : message('请填写标题！');
			$picture = !empty($_GPC['picture']) ? $_GPC['picture'] : message('请上传图片！');
			$description = !empty($_GPC['description']) ? $_GPC['description'] : message('请填写简介！');
			if(empty($_GPC['price'])){
				$price = 0;
			} else {
				$price = is_numeric($_GPC['price']) ? $_GPC['price'] : message('请输入合法奖品价值！');
			}
			if(empty($_GPC['chipmoney'])){
				$chipmoney = '';
			} else {
				$chipmoney = is_numeric($_GPC['chipmoney']) ? $_GPC['chipmoney'] : message('请输入合法众筹值！');
			}
			if(empty($_GPC['view'])){
				$view = 0;
			} else {
				$view = is_numeric($_GPC['view']) ? $_GPC['view'] : message('请输入合法浏览量！');
			}
			if(empty($_GPC['share'])){
				$share = 0;
			} else {
				$share = is_numeric($_GPC['share']) ? $_GPC['share'] : message('请输入合法分享量！');
			}
			$datelimit = $_GPC['datelimit'];
			$chip = array(
				'uniacid'=>$uniacid,
				'title'=>$title,
				'picture'=>$picture,
				'url'=>$_GPC['url'],
				'description'=>$description,
				'detail'=>htmlspecialchars_decode(trim($_GPC['detail'])),
				'rule'=>htmlspecialchars_decode(trim($_GPC['rule'])),
				'type'=>intval($_GPC['type']),
				'price'=>$price,
				'chipmoney'=>$chipmoney,
				'listorder'=>intval($_GPC['listorder']),
				'view'=>$view,
				'share'=>$share,
				'starttime'=>strtotime($datelimit['start']),
				'endtime'=>strtotime($datelimit['end']),
				'isopen'=>$_GPC['isopen'],
				'createtime'=>time()
			);
			if(intval($id)){
				unset($chip['createtime']);
				pdo_update('hc_chips_chip', $chip, array('id'=>$id));
			} else {
				pdo_insert('hc_chips_chip', $chip);
			}
			message('添加成功！', $this->createWebUrl('chip'), 'success');
		}
		if(intval($id)){
			$chip = pdo_fetch("select * from ".tablename('hc_chips_chip')." where id = ".$id);
		} else {
			$chip = array(
				'starttime'=>time(),
				'endtime'=>time()+3600*24*7,
				'isopen'=>1
			);
		}
		include $this->template('web/chip_post');
		exit;
	}
	
	if($op=='delete'){
		$id = $_GPC['id'];
		pdo_delete('hc_chips_chip', array('id'=>$id));
		message('删除成功！', $this->createWebUrl('chip'), 'success');
	}
	
	include $this->template('web/chip_list');

?>