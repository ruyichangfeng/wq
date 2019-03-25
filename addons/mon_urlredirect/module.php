<?php
/**
 *
 *
 * @author  codeMonkey
 * qq:2463619823
 * @url
 */
defined('IN_IA') or exit('Access Denied');
require IA_ROOT. '/addons/mon_urlredirect/core/defines.php';

require MON_URLREDIRECT_CORE. "util/dbutil.class.php";
require MON_URLREDIRECT_CORE. "util/monUtil.class.php";

class Mon_urlredirectModule extends WeModule {

	public $weid;

	public function __construct()
	{
		global $_W;
		$this->weid = IMS_VERSION < 0.6 ? $_W['weid'] : $_W['uniacid'];
	}

	public function fieldsFormDisplay($rid = 0) {
		global $_W, $_GPC;

		if (!empty($rid)) {
			$reply = DBUtil::findUnique(DBUtil::$TABLE_URLREDIRECT_REPLY, array(":rid" => $rid));

			if (!empty($reply)) {
				$redirect = DBUtil::findById(DBUtil::$TABLE_URLREDIRECT, $reply['redid']);
				$reply['rname'] = $redirect['rname'];
			}
		}



		load()->func('tpl');
		include $this->template('web/form');

   }

	public function fieldsFormValidate($rid = 0)
	{

	}

	public function fieldsFormSubmit($rid) {
		global $_GPC, $_W;
		$data = array(
			'rid'=> $rid,
			'redid' => $_GPC['redid'],
			'new_title' => $_GPC['new_title'],
			'new_icon' => $_GPC['new_icon'],
			'new_content' => $_GPC['new_content'],
		);

		$reply = pdo_fetch("SELECT * FROM " . tablename(DBUtil::$TABLE_URLREDIRECT_REPLY) . " WHERE rid = :rid", array(':rid' => $rid));
		if($reply) {
			DBUtil::updateById(DBUtil::$TABLE_URLREDIRECT_REPLY, $data, $reply['id']);
		} else {
			DBUtil::create(DBUtil::$TABLE_URLREDIRECT_REPLY, $data);
		}
		return true;

	}

	public function ruleDeleted($rid) {
		pdo_delete(DBUtil::$TABLE_URLREDIRECT_REPLY, array("rid" => $rid));
	}


}