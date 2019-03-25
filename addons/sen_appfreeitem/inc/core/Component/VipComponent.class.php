<?php
/*
会员表
主要包括会员等级配置
会员权限配置
会员权限校验
*/

class VipComponent
{
	public $openid;

	function __construct($openid)
	{
		$this->openid = $openid;
	}

	/*
	校验会员身份
	*/
	public function isVip()
	{
		global $_W,$_GPC;
		$info = MemberModel::info($this->openid);
		if($info['vip_level'])
		{
			// 校验身份是否过期
			if(strtotime($info['vip_end_time']) <= time())
			{
				// 已过期，将会员身份置为0
				$this->dropVip($this->openid);
				return false;
			}
			return true;
		}
		return false;
	}

	// 升级为会员身份
	public function updateToVip()
	{
		global $_GPC,$_W;
		
		// 已经是会员了
		if($this->isVip())
		{
			return false;
		}

		$data = array();
		$data['vip_level'] = 1;
		$data['vip_add_time'] = date("Y-m-d H:i:s");
		$data['vip_end_time'] = date("Y-m-d H:i:s",strtotime('+1 months'));

		$where = array('uniacid'=>$_W['uniacid'],'openid'=>$this->openid);

		return MemberModel::update($data,$where);
	}

	// 非会员状态重置
	public function dropVip($openid)
	{
		global $_W;

		$data = array();
		$data['vip_level'] = 0;

		$where['uniacid'] = $_W['uniacid'];
		$where['openid'] = $openid;
		return MemberModel::update($data,$where);
	}

}