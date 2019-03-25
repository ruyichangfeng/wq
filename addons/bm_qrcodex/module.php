<?php
/**
 * 扫码会议报名模块定义
 *
 * @author QQ:513316788
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
include '../addons/bm_qrcodex/phpqrcode.php';
class Bm_qrcodexModule extends WeModule {
    public $weid;
    public function __construct() {
        global $_W;
        $this->weid = IMS_VERSION<0.6?$_W['weid']:$_W['uniacid'];
    }
	
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
		global $_W;
		if (!empty($rid)) {
			$reply = pdo_fetch("SELECT * FROM ".tablename('bm_qrcodex_reply')." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
			if (empty($reply['qrcode'])) {
				$value = $_W['siteroot'] . 'app/' . $this->createmobileurl('show',array('rid' => $rid));
				$errorCorrectionLevel = 'H';
				$matrixPointSize = '16';
				$rand_file = random(6, 1) . '.png';
				$att_target_file = 'qrs-' . $rand_file;
				$target_file = '../addons/bm_qrcodex/tmppic/' . $att_target_file;
				QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);
				$reply['qrcode'] = $target_file;					
			}
		}
		load()->func('tpl');
		include $this->template('form');		
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$data = array(
			'rid'         => $rid,
			'weid'        => $weid,
			'desc'        => $_GPC['desc'],
			'pictype'     => $_GPC['pictype'],
			'picurl'      => $_GPC['picurl'],
			'urlx'        => $_GPC['urlx'],
			'title'       => $_GPC['title'],
			'starttime'   => $_GPC['starttime'],
			'endtime'     => $_GPC['endtime'],
			'qrcode'      => $_GPC['qrcode'],
			'urly'        => $_GPC['urly'],
			'url1'        => $_GPC['url1'],
			'url2'        => $_GPC['url2'],
			'memo1'       => $_GPC['memo1'],
			'memo2'       => $_GPC['memo2'],
			'memo'        => $_GPC['memo'],
			'templateid'  => $_GPC['templateid'],
			'picture'     => $_GPC['picture'],
		);
		if ($_W['ispost']) {
			if (empty($_GPC['reply_id'])) {
				pdo_insert('bm_qrcodex_reply',$data);
			}else{
				pdo_update('bm_qrcodex_reply',$data,array('id' => $_GPC['reply_id']));
			}
			message('更新成功',referer(),'success');
		}
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
		global $_W;
		$replies = pdo_fetchall("SELECT *  FROM ".tablename('bm_qrcodex_reply')." WHERE rid = '$rid'");
		$deleteid = array();
		
		if (!empty($replies)) {
			foreach ($replies as $index => $row) {
				//file_delete($row['picurl']);
				//file_delete($row['info_picurl']);
				//file_delete($row['order_picurl']);
				$deleteid[] = $row['id'];
			}
		}
		pdo_delete('bm_qrcodex_reply', "id IN ('".implode("','", $deleteid)."')");
		return true;
	}


}
?>