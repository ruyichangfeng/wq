<?php
/**
 *
 *
 * @author  codeMonkey
 * qq:2463619823
 * @url
 */
defined('IN_IA') or exit('Access Denied');

define("MON_XKWKJ", "mon_xkwkj");
define("MON_XKWKJ_RES", "../addons/" . MON_XKWKJ . "/");
require_once IA_ROOT . "/addons/" . MON_XKWKJ . "/dbutil.class.php";
require_once IA_ROOT . "/addons/" . MON_XKWKJ . "/monUtil.class.php";

class Mon_XKWkjModule extends WeModule
{

    public $weid;

    public function __construct()
    {
        global $_W;
        $this->weid = IMS_VERSION < 0.6 ? $_W['weid'] : $_W['uniacid'];
    }


    public function fieldsFormDisplay($rid = 0)
    {
        global $_W;

        if (!empty($rid)) {
            $reply = DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_REPLY, array(":rid" => $rid));
            if (!empty($reply)) {
                $xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $reply['kid']);
                $reply['kjtitle'] = $xkwkj['title'];
            }
        }


        load()->func('tpl');
        include $this->template('form');


    }

    public function fieldsFormValidate($rid = 0)
    {
        global $_GPC, $_W;
        return '';
    }

    public function fieldsFormSubmit($rid)
    {
        global $_GPC, $_W;
        $data = array(
            'rid'=> $rid,
            'kid' => $_GPC['kid'],
            'new_title' => $_GPC['new_title'],
            'new_icon' => $_GPC['new_icon'],
            'new_content' => $_GPC['new_content'],
        );

        $reply = pdo_fetch("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ_REPLY) . " WHERE rid = :rid", array(':rid' => $rid));
        if($reply) {
            DBUtil::updateById(DBUtil::$TABLE_XKWKJ_REPLY, $data, $reply['id']);
        } else {
            DBUtil::create(DBUtil::$TABLE_XKWKJ_REPLY, $data);
        }
        return true;
    }

    public function ruleDeleted($rid)
    {
        pdo_delete(DBUtil::$TABLE_XKWKJ_REPLY, array("rid" => $rid));
    }
}