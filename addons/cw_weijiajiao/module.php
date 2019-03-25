<?php
/**
 * 微家教模块定义
 *
 * @author CW
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Cw_weijiajiaoModule extends WeModule {
	public $weid;

	public $orgreply='jj_org_reply';
	public $teacher='jj_tec';
	public $res='jj_result';

    public function __construct() {
        global $_W;
        $this->weid = IMS_VERSION<0.6?$_W['weid']:$_W['uniacid'];
    }
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
		global $_W;
		if (!empty($rid)) {
			$reply = pdo_fetch("SELECT * FROM ".tablename($this->orgreply)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		}
        if(IMS_VERSION>=0.6){
            load()->func('tpl');
        }				
		include $this->template('form');
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		global $_GPC;
		//此处服务端验证表单数据的完整性，直接返回错误信息。
		if (empty($_GPC['title'])) {
			return '请填写标题';
		}
		if (empty($_GPC['picurl'])) {
			return '请填写封面图片';
		}
		if (empty($_GPC['department'])) {
			return '请填写机构名称';
		}
		if (empty($_GPC['info_picurl'])) {
			return '请填写顶部图片1';
		}
		if (empty($_GPC['info_picurl2'])) {
			return '请填写顶部图片2';
		}
		if (empty($_GPC['cosmtment_phone'])) {
			return '请填写联系电话';
		}
		if (empty($_GPC['address'])) {
			return '请填写机构地址';
		}
		if (empty($_GPC['cosmtment_info'])) {
			return '请填写机构简介';
		}
		if (empty($_GPC['order_picurl'])) {
			return '请填写预定家教页头部图片';
		}
		if (empty($_GPC['order_info'])) {
			return '请填写家教预约说明';
		}
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
		global $_W,$_GPC;	
		$data = array(
			'rid'             => $rid,
			'weid'            => $_W['weid'],
			'title'           => $_GPC['title'],
			'department'      => $_GPC['department'],
			'picurl'          => $_GPC['picurl'],
			'info_picurl'     => $_GPC['info_picurl'],
			'info_picurl2'     => $_GPC['info_picurl2'],
			'order_picurl'     => $_GPC['order_picurl'],
			'order_info'      => htmlspecialchars_decode($_GPC['order_info']),
			'cosmtment_phone' => $_GPC['cosmtment_phone'],
			'address'         => $_GPC['address'],
			'cosmtment_info'  => htmlspecialchars_decode($_GPC['cosmtment_info']),
			'lng' => $_GPC['baidumap']['lng'],
			'lat' => $_GPC['baidumap']['lat'],				
		);
		if ($_W['ispost']) {
			if (empty($_GPC['reply_id'])) {
				pdo_insert($this->orgreply,$data);
			}else{
				pdo_update($this->orgreply,$data,array('id' => $_GPC['reply_id']));
			}
		}
		
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
		global $_W;
		$replies = pdo_fetchall("SELECT *  FROM ".tablename($this->orgreply)." WHERE rid = '$rid'");
		$deleteid = array();
		load()->func('file');
		if (!empty($replies)) {
			foreach ($replies as $index => $row) {
				file_delete($row['picurl']);
				file_delete($row['info_picurl']);
				file_delete($row['info_picurl2']);
				file_delete($row['order_picurl']);
				$deleteid[] = $row['id'];
			}
		}
		pdo_delete($this->orgreply, "id IN ('".implode("','", $deleteid)."')");
		return true;
	}


}