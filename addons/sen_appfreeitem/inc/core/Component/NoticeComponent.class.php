<?php
/*
封装好的发送模板消息的类
*/
class NoticeComponent
{
	private $obj;

	function __construct()
	{
		global $_W;
		
		load()->classs('weixin.account');
		//$this->obj = new WeiXinAccount($_W['uniacid']);
		load()->model('account');
		$acid = uni_fetch($_W['uniacid']);
		$this->obj = WeiXinAccount::create($acid);
		// $this->obj = mc_notice_init();
		$this->set = intelligent_kindergartenModuleSite::$_SET;
		WeUtility::logging('huayue_payresult_sendToRewardTpl_uniacid', var_export($_W['uniacid'], true));
		WeUtility::logging('huayue_payresult_sendToRewardTpl_obj', var_export($this->obj, true));
	}
	
	
	// 新消息提醒
	function sendNewNoticeTpl($touser,$name,$content,$url,$first = '')
	{
		
		// $touser	string	粉丝openid
		// $tpl_id_short	string	模板id
		// $postdata	array	根据模板规则完善消息
		// $url	string	详情页链接
		// $topcolor	string	

		$first = $first ? $first : $this->set['notice_first'];
		$remark = $this->set['notice_remark'];
		$key = $this->set['notice_key'];
		$tpl_id_short = $this->set['notice_approve_tpl_id'];

		if($key != 'open')
		{
			// close or ''
			return false;
		}

		$postdata['first'] = array('value'=>$first,'color'=>'');
		$postdata['keyword1'] =  array('value'=>$name,'color'=>'#459ae9');
		$postdata['keyword2'] =  array('value'=>date("Y-m-d H:i:s"),'color'=>'#459ae9');
		$postdata['keyword3'] =  array('value'=>$content,'color'=>'#459ae9');
		$postdata['remark'] =  array('value'=>$remark,'color'=>'');

		$r = $this->obj->sendTplnotice($touser,$tpl_id_short,$postdata,$url);
	}
	// 审核消息模板发送
	function sendApproveTpl($touser,$first,$key_1,$remark,$url)
	{
		$key = $this->set['notice_key'];
		$tpl_id_short = $this->set['approve_tpl_id'];
		if($key != 'open')
		{
			// close or ''
			return false;
		}
		$postdata['first'] = array('value'=>$first,'color'=>'');
		$postdata['keyword1'] =  array('value'=>$key_1,'color'=>'#459ae9'); // 审核结果
		$postdata['keyword2'] =  array('value'=>date("Y-m-d H:i:s"),'color'=>'#459ae9'); // 审核时间
		$postdata['remark'] =  array('value'=>$remark,'color'=>'');

		$r = $this->obj->sendTplnotice($touser,$tpl_id_short,$postdata,$url);
	}

	/*
	打赏通知
	被打赏人
	*/
	function sendToRewardTpl($touser,$name,$content,$url)
	{
		
		// $touser	string	粉丝openid
		// $tpl_id_short	string	模板id
		// $postdata	array	根据模板规则完善消息
		// $url	string	详情页链接
		// $topcolor	string	

		$first = '您收到了新的打赏';
		$remark = '点击查看';
		$key = $this->set['notice_key'];
		$tpl_id_short = $this->set['notice_approve_tpl_id'];
		if($key != 'open')
		{
			// close or ''
			return false;
		}

		$postdata['first'] = array('value'=>$first,'color'=>'');
		$postdata['keyword1'] =  array('value'=>$name,'color'=>'#459ae9');
		$postdata['keyword2'] =  array('value'=>date("Y-m-d H:i:s"),'color'=>'#459ae9');
		$postdata['keyword3'] =  array('value'=>$content,'color'=>'#459ae9');
		$postdata['remark'] =  array('value'=>$remark,'color'=>'');

		$r = $this->obj->sendTplnotice($touser,$tpl_id_short,$postdata,$url);
		return $r;
	}

	/*
	打赏通知
	发起打赏的人
	*/
	function sendRewardTpl($touser,$name,$content,$url)
	{
		
		// $touser	string	粉丝openid
		// $tpl_id_short	string	模板id
		// $postdata	array	根据模板规则完善消息
		// $url	string	详情页链接
		// $topcolor	string	

		$first = '您的打赏已经成功发送给了对方';
		$remark = '点击查看';
		$key = $this->set['notice_key'];
		$tpl_id_short = $this->set['notice_approve_tpl_id'];
		if($key != 'open')
		{
			// close or ''
			return false;
		}

		$postdata['first'] = array('value'=>$first,'color'=>'');
		$postdata['keyword1'] =  array('value'=>$name,'color'=>'#459ae9');
		$postdata['keyword2'] =  array('value'=>date("Y-m-d H:i:s"),'color'=>'#459ae9');
		$postdata['keyword3'] =  array('value'=>$content,'color'=>'#459ae9');
		$postdata['remark'] =  array('value'=>$remark,'color'=>'');

		$r = $this->obj->sendTplnotice($touser,$tpl_id_short,$postdata,$url);
		return $r;

	}

	/*
	提现通知
	*/
	function sendWaitDrawTpl($touser,$first,$key_1,$key_2,$key_3,$key_4,$remark,$url) {

		$tpl_id_short = $this->set['draw_wait_tpl_id'];

		$postdata['first'] = array('value'=>$first,'color'=>'');
		$postdata['keyword1'] =  array('value'=>$key_1.'元','color'=>'#459ae9'); // 申请提现金额
		$postdata['keyword2'] =  array('value'=>$key_2.'元','color'=>'#459ae9'); // 取提现手续费
		$postdata['keyword3'] =  array('value'=>$key_3.'元','color'=>'#459ae9'); // 实际到账金额
		$postdata['keyword4'] =  array('value'=>$key_4,'color'=>'#459ae9'); // 提现渠道
		$postdata['remark'] =  array('value'=>$remark,'color'=>'');

		$r = $this->obj->sendTplnotice($touser,$tpl_id_short,$postdata,$url);
	}

}