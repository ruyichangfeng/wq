<?php
/**
 * 微情书模块定义
 *
 * @author junsion
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class junsion_catchModule extends WeModule {
	public function fieldsFormDisplay($rid = 0) {
		global $_W,$_GPC;
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
		$rule = pdo_fetch('select * from '.tablename($this->modulename."_rule")." where rid='{$rid}'");
		$prize = pdo_fetchall('select * from '.tablename($this->modulename."_prize")." where rid='{$rid}' order by id");
		$slider = pdo_fetchall('select * from '.tablename($this->modulename."_slider")." where rid='{$rid}' order by displayorder desc");
		//FIXME 券和物品 需要选择 适用所有会员和足够数量的
		$coupons = pdo_fetchall('select * from '.tablename('activity_coupon')." where uniacid={$_W['uniacid']}");
		$exchanges = pdo_fetchall('select * from '.tablename('activity_exchange')." where uniacid={$_W['uniacid']}");
		if (!empty($rule)){
			$limit = explode(',',$rule['love_limit']);
			if (count($limit) == 2){
				$rule['love_limit1'] = $limit[0];
				$rule['love_limit2'] = $limit[1];
				$rule['love_limit'] = 0;
			}
			$places = array('province'=>$rule['province'],'city'=>$rule['city'],'district'=>$rule['area']);
			$objs = unserialize($rule['morebirds']);
		}
		include $this->template('form');
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		global $_W,$_GPC;
		if (empty($_GPC['title'])){
			return '请输入活动名称';
		}
		if (!empty($_GPC['limit_type'])){
			if ($_GPC['love_limit1'] >= $_GPC['love_limit2']) return '朋友助力的下限不能大于上限！';
		}
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号global $_W,$_GPC;
		global $_W,$_GPC;
		$lovelimit = $_GPC['love_limit'];
		if (!empty($_GPC['limit_type'])){
			$lovelimit = $_GPC['love_limit1'].",".$_GPC['love_limit2'];
		}
		$fsize = getimagesize(toimage($_GPC['fthumb']));
		$gsize = getimagesize(toimage($_GPC['gun']));
		$data = array(
			'rid'=>$rid,
			'weid'=>$_W['weid'],
			'title'=>$_GPC['title'],
			'thumb'=>$_GPC['thumb'],
			'description'=>$_GPC['description'],
			'starttime'=>strtotime($_GPC['datelimit']['start']),
			'endtime'=>strtotime($_GPC['datelimit']['end']),
			'describe_limit'=>$_GPC['describe_limit'],
			'describe_limit2'=>$_GPC['describe_limit2'],
			'love_limit'=>$lovelimit,
			'content'=>htmlspecialchars_decode($_GPC['content']),
			'sharetitle'=>$_GPC['sharetitle'],
			'sharethumb'=>$_GPC['sharethumb'],
			'sharedesc'=>$_GPC['sharedesc'],
			'frame'=>intval($_GPC['frame']),
			'fname'=>$_GPC['fname'],
			'frameW'=>$fsize[0],
			'frameH'=>$fsize[1],
			'rank'=>intval($_GPC['rank']),
			'fthumb'=>$_GPC['fthumb'],
			'fthumb2'=>$_GPC['fthumb2'],
			'net'=>$_GPC['net'],
			'gun'=>$_GPC['gun'],
			'gunW'=>$gsize[0],
			'gunH'=>$gsize[1],
			'bg'=>$_GPC['bg'],
			'ftotal'=>intval($_GPC['ftotal']),
			'fspeed2'=>intval($_GPC['fspeed2']),
			'fspeed1'=>intval($_GPC['fspeed1']),
			'nspeed'=>intval($_GPC['nspeed']),
			'netuseless'=>intval($_GPC['netuseless']),
			'score'=>intval($_GPC['score']),
			'free_times'=>intval($_GPC['free_times']),
			'more_type'=>intval($_GPC['more_type']),
			'more_num'=>intval($_GPC['more_num']),
			'more_time'=>intval($_GPC['more_time']),
			'more_times'=>intval($_GPC['more_times']),
			'isinfo'=>$_GPC['isinfo'],
			'awardtips'=>$_GPC['awardtips'],
			'isrealname'=>$_GPC['isrealname'],
			'ismobile'=>$_GPC['ismobile'],
			'isqq'=>$_GPC['isqq'],
			'isemail'=>$_GPC['isemail'],
			'isaddress'=>$_GPC['isaddress'],
			'province'=>$_GPC['place']['province'],
			'city'=>$_GPC['place']['city'],
			'area'=>$_GPC['place']['district'],
		);
		
		$birds = array();
		$fthumb_os = $_GPC['fthumb_o'];
		foreach ($fthumb_os as $key => $value) {
			if($key > 0){
				$fsize = getimagesize(toimage($value));
				$birds[] = array(
					'frame'=>intval($_GPC['frame_o'][$key]),
					'fname'=>$_GPC['fname_o'][$key],
					'frameW'=>$fsize[0],
					'frameH'=>$fsize[1],
					'fthumb'=>$value,
					'fthumb2'=>$_GPC['fthumb2_o'][$key],
					'ftotal'=>intval($_GPC['ftotal_o'][$key]),
					'fspeed2'=>intval($_GPC['fspeed2_o'][$key]),
					'fspeed1'=>intval($_GPC['fspeed1_o'][$key]),
					'score'=>intval($_GPC['score_o'][$key]),
				);
			}
		}
		$data['morebirds'] = serialize($birds);
		
		$rule = pdo_fetch('select * from '.tablename($this->modulename."_rule")." where rid='{$rid}'");
		if (!empty($rule)){
			pdo_update($this->modulename."_rule",$data,array('id'=>$rule['id']));
		}else{
			pdo_insert($this->modulename."_rule",$data);
		}
		pdo_delete($this->modulename."_prize",array('rid'=>$rid));
		pdo_delete($this->modulename."_slider",array('rid'=>$rid));
		$prizename = $_GPC['prizename'];
		if (!empty($prizename)){
			foreach ($prizename as $key => $value) {
				if (!empty($value)){
					pdo_insert($this->modulename."_prize",array(
							'rid'=>$rid,
							'prizetype'=>$_GPC['prizetype'][$key],
							'prizetotal'=>floatval($_GPC['prizetotal'][$key]),
							'prizename'=>$value,
							'prizepro'=>$_GPC['prizepro'][$key],
							'prizepic'=>$_GPC['prizepic'][$key],
					));
				}
			}
		}
		
		$picurl = $_GPC['picurl'];
		if (!empty($picurl)){
			foreach ($picurl as $key => $value) {
				if (!empty($value)){
					pdo_insert($this->modulename."_slider",array(
							'rid'=>$rid,
							'picurl'=>$value,
							'displayorder'=>$_GPC['displayorder'][$key],
							'link'=>$_GPC['link'][$key],
					));
				}
			}
		}
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
		pdo_delete($this->modulename."_rule",array('rid'=>$rid));
		pdo_delete($this->modulename."_prize",array('rid'=>$rid));
		pdo_delete($this->modulename."_slider",array('rid'=>$rid));
	}

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			//字段验证, 并获得正确的数据$dat
			$dat = array(
				'describeurl'=>$_GPC['describeurl'],
				'address'=>$_GPC['address'],
				'location_p'=>$_GPC['location_p'],
				'location_c'=>$_GPC['location_c'],
				'location_a'=>$_GPC['location_a'],
				'lat'=>$_GPC['lat'],
				'lng'=>$_GPC['lng'],
				'name'=>$_GPC['name'],
				'desc'=>$_GPC['desc'],
			);
			if($this->saveSettings($dat)){
				message('保存成功','refresh');
			}
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}

}