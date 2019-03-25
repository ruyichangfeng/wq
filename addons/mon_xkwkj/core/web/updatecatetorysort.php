<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:27
 */
defined('IN_IA') or exit('Access Denied');

		foreach ($_GPC['sortArray'] as $sortString) {
			$sortEn = explode("|", $sortString);
			$cid = $sortEn[0];
			$sort = $sortEn[1];
			DBUtil::updateById(DBUtil::$TABLE_XKWKJ_CATEGORY,
				array("display_sort"=>$sort), $cid);
		}
		echo json_encode(array('code' => 200));