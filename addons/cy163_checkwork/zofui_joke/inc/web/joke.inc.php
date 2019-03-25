<?php 
	global $_W,$_GPC;
	$_GPC['do'] = 'joke';
	$_GPC['op'] = empty($_GPC['op'])? 'list' : $_GPC['op'];

	initJoke();

	// 创建新活动
	if(checkSubmit('create')){
		$_GPC = Util::trimWithArray($_GPC);
		
		$data = array(
			'uniacid' => $_W['uniacid'],
			'title' => $_GPC['title'],
			'desc' => $_GPC['desc'],
			'falsenum' => $_GPC['falsenum'],
			'thumb' => $_GPC['thumb'],
			'pic' => $_GPC['pic'],
			'sharetitle' => $_GPC['sharetitle'],
			'sharedesc' => $_GPC['sharedesc'],
		);

		if(intval($_GPC['id']) > 0){
			$res = pdo_update('zofui_joke_joke',$data,array('id'=>intval($_GPC['id']),'uniacid'=>$_W['uniacid']));
		}else{
			$res = pdo_insert('zofui_joke_joke',$data);
		}
		if($res){
			Util::deleteCache('joke','all'); // 删除缓存
			message('操作成功','referer','success');
		}else{
			message('操作失败','referer','error');
		}
	}
 	
	// 批量删除
	if( checkSubmit('deleteall') ){
		$res = WebCommon::deleteDataInWeb($_GPC['checkall'],'zofui_joke_joke');
		if($res){
			message('删除成功','referer','success');
		}else{
			message('删除失败','referer','error');
		}
	}


	



	if($_GPC['op'] == 'add'){
		$info = pdo_get('zofui_joke_joke',array('id'=>intval($_GPC['id']),'uniacid'=>$_W['uniacid']));
	}
	
	// 列表
	if($_GPC['op'] == 'list'){
		$where = array('uniacid'=>$_W['uniacid']);

		$info = Util::getAllDataInSingleTable('zofui_joke_joke',$where,$_GPC['page'],10,$order='`id` DESC');
		$list = $info[0];
		$pager = $info[1];
	}




	// 删除单个
	if($_GPC['op'] == 'delete'){
		$id = intval($_GPC['id']);
		$res = WebCommon::deleteSingleData($id,'zofui_joke_joke');
		if($res){
			message('删除成功','referer','success');
		}else{
			message('删除失败','referer','error');
		}
	}

	
	
	function initJoke(){
		global $_W;
		$temp = array(
			array(
				'title'=> '人人都想涨姿势',
				'desc' => '冷知识：一次性交多长时间才算是真男人呢？',
				'pic' => 'trcik07_content_url07.png',
				'thumb' => 'trick07_title.png',
			),
			array(
				'title'=> '污力滔滔！',
				'desc' => '北京某高校女学生激情4分钟，赶紧看！（快要被屏蔽了）',
				'pic' => 'trcik08_content_url.png',
				'thumb' => 'trick08_title.png',
			),
			array(
				'title'=> '只要有爱，就会有伤害',
				'desc' => '如何识别愚人节告白的真假？',
				'pic' => 'trcik05_content_url05.png',
				'thumb' => 'trick05_title.png',
			),array(
				'title'=> '身高已经是男人的第二张脸了吗',
				'desc' => '男生身高170 如何穿出180的既视感',
				'pic' => 'trcik13_content_url13_01.png',
				'thumb' => 'trick13_title_01.jpg',
			),array(
				'title'=> '此时无声胜有声',
				'desc' => '我定制了一份礼物要送给你，点击领取',
				'pic' => 'trcik07_content_url45.png',
				'thumb' => 'trick04_title.jpg',
			),array(
				'title'=> '知乎体，最吸引',
				'desc' => '第一次开房是一种什么体验？？？',
				'pic' => 'trcik11_content_url11.png',
				'thumb' => 'trick03_title.jpg',
			),array(
				'title'=> '说好的星座宝典呢？',
				'desc' => '天呐！原来白羊座都有这种迷人的气质！！',
				'pic' => 'trcik01_content_url.png',
				'thumb' => 'trick01_title.png',
			),array(
				'title'=> '柯南，8090的共同回忆',
				'desc' => '惊人!名侦探柯南的结局公布了!出乎全世界人的意料!',
				'pic' => 'trcik12_content_url12.png',
				'thumb' => 'trick12_title12_01.jpg',
			),array(
				'title'=> '我八卦说明我关心别人',
				'desc' => '内幕！你所不知道的TFboys背后的故事！',
				'pic' => 'trcik06_content_url06.png',
				'thumb' => 'trick06_title.png',
			),array(
				'title'=> '民以食为天，天天就知道吃！',
				'desc' => '哪些美食只有海淘才能买到？',
				'pic' => 'trcik02_content_url02.png',
				'thumb' => 'trick02_title.png',
			),

		);

			$joke = pdo_get('zofui_joke_joke',array('uniacid'=>$_W['uniacid']));
			if( empty( $joke ) ){

				foreach ($temp as $v) {
					$data = $v;
					$data['uniacid'] = $_W['uniacid'];
					$data['thumb'] = MODULE_URL.'public/images/'.$v['thumb'];
					$data['pic'] = MODULE_URL.'public/images/'.$v['pic'];
					if( !empty( $data['radio'] ) ) $data['radio'] = MODULE_URL.'public/images/'.$v['radio'];
					pdo_insert('zofui_joke_joke',$data);
				}
				Util::deleteCache('joke','all');
			}

	}

	include $this->template('web/joke');