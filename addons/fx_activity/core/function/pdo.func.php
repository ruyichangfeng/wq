<?php
/**
 * [fxy] Copyright (c) 2016
 * 数据库查询方法
 */
defined('IN_IA') or exit('Access Denied');

//全局记录统计，关联方法：my_implode()
function pdo_count($tablename, $params = array()){
	$condition = my_implode($params, 'AND');
	$sql = 'SELECT COUNT(*) AS total FROM ' . tablename($tablename) . (!empty($condition['fields']) ? " WHERE {$condition['fields']}" : '') . " LIMIT 1";
	$result = pdo_fetch($sql, $condition['params']);
	
	if (empty($result)) {
		return 0;
	}
	
	return intval($result['total']);
}
function my_implode($params, $glue = ',') {
	//多条件参数处理
	$result = array('fields' => ' 1 ', 'params' => array());
	$split = '';
	$suffix = '';
	if (in_array(strtolower($glue), array('and', 'or'))) {
		$suffix = '__';
	}
	if (!is_array($params)) {
		$result['fields'] = $params;
		return $result;
	}
	if (is_array($params)) {
		$result['fields'] = '';
		foreach ($params as $fields => $value) {
			if (is_array($value)) {
				$result['fields'] .= $split . "`$fields` IN ('".implode("','", $value)."')";
				$split = ' ' . $glue . ' ';
			} else {
				$result['fields'] .= $split . "`$fields` =  :{$suffix}$fields";
				$split = ' ' . $glue . ' ';
				$result['params'][":{$suffix}$fields"] = is_null($value) ? '' : $value;
			}
		}
	}
	return $result;
}
