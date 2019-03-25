<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:21
 */

defined('IN_IA') or exit('Access Denied');

//$GLOBALS['frames'] = $this->getMainMenu();

  $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
   if ($operation == 'display') {

			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$list = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWKJ) . " WHERE weid =:weid  ORDER BY index_sort asc LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(':weid' => $this->weid));
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ) . " WHERE weid =:weid ", array(':weid' => $this->weid));
			$pager = pagination($total, $pindex, $psize);
  } else if ($operation == 'delete') {
			$id = $_GPC['kid'];
			pdo_delete(DBUtil::$TABLE_XKWJK_ORDER, array("kid" => $id));
			pdo_delete(DBUtil::$TABLE_XKWKJ_FIREND, array("kid" => $id));
			pdo_delete(DBUtil::$TABLE_XKWKJ_USER, array("kid" => $id));
			pdo_delete(DBUtil::$TABLE_XKWKJ, array('id' => $id));
			message('删除成功！', referer(), 'success');
  }

include $this->template("xkwkj_manage");