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
			$kid = $sortEn[0];
			$sort = $sortEn[1];
			DBUtil::updateById(DBUtil::$TABLE_XKWKJ,
				array("index_sort"=>$sort), $kid);
		}
		echo json_encode(array('code' => 200));