<?php
defined ( 'IN_IA' ) or exit ( 'Access Denied' );

global $_GPC, $_W;

checklogin();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'manage';

if ($operation == 'manage') {
	load ()->model ( 'reply' );
	$pindex = max ( 1, intval ( $_GPC ['page'] ) );
	$psize = 20;
	$sql = "uniacid = :uniacid AND `module` = :module";
	$params = array ();
	$params [':uniacid'] = $_W ['uniacid'];
	$params [':module'] = 'cx_tcbd';
	
	if (isset ( $_GPC ['keywords'] )) {
		$sql .= ' AND `name` LIKE :keywords';
		$params [':keywords'] = "%{$_GPC['keywords']}%";
	}
	$list = reply_search ( $sql, $params, $pindex, $psize, $total );
	$pager = pagination ( $total, $pindex, $psize );
	
	if (! empty ( $list )) {
		foreach ( $list as &$item ) {
			$condition = "`rid`={$item['id']}";
			$item ['keywords'] = reply_keywords_search ( $condition );
			$bigwheel = pdo_fetch ( "SELECT fansnum, viewnum,valid_time_start as starttime,valid_time_end as endtime FROM " . tablename ( 'cx_tcbd_form' ) . " WHERE rid = :rid ", array (
					':rid' => $item ['id'] 
			) );
			$item ['fansnum'] = $bigwheel ['fansnum'];
			$item ['viewnum'] = $bigwheel ['viewnum'];
			$item ['starttime'] = date ( 'Y-m-d H:i', $bigwheel ['starttime'] );
			$endtime = $bigwheel ['endtime'] + 86399;
			$item ['endtime'] = date ( 'Y-m-d H:i', $endtime );
		}
	}
	include $this->template ( 'index' );	
} elseif ($operation == 'post') {
} elseif ($operation == 'delete') {
	$rid = intval ( $_GPC ['rid'] );
	$rule = pdo_fetch ( "SELECT id, module FROM " . tablename ( 'rule' ) . " WHERE id = :id and uniacid=:uniacid", array (
			':id' => $rid,
			':uniacid' => $_W ['uniacid'] 
	) );
	if (empty ( $rule )) {
		message ( '抱歉，要修改的规则不存在或是已经被删除！' );
	}
	if (pdo_delete ( 'rule', array ('id' => $rid) )) {
		pdo_delete ( 'rule_keyword', array (
				'rid' => $rid 
		) );
		// 删除统计相关数据
		pdo_delete ( 'stat_rule', array (
				'rid' => $rid 
		) );
		pdo_delete ( 'stat_keyword', array (
				'rid' => $rid 
		) );
		// 调用模块中的删除
		$module = WeUtility::createModule ( $rule ['module'] );
		if (method_exists ( $module, 'ruleDeleted' )) {
			$module->ruleDeleted ( $rid );
		}
	}
	message ( '规则操作成功！', referer (), 'success' );	
} elseif ($operation == 'deleteall') {
	global $_GPC, $_W;

	foreach ( $_GPC ['idArr'] as $k => $rid ) {
		$rid = intval ( $rid );
		if ($rid == 0)
			continue;
		$rule = pdo_fetch ( "SELECT id, module FROM " . tablename ( 'rule' ) . " WHERE id = :id and uniacid=:weid", array (
				':id' => $rid,
				':weid' => $_W ['uniacid'] 
		) );
		if (empty ( $rule )) {
			$this->webmessage ( '抱歉，要修改的规则不存在或是已经被删除！' );
		}
		if (pdo_delete ( 'rule', array (
				'id' => $rid 
		) )) {
			pdo_delete ( 'rule_keyword', array (
					'rid' => $rid 
			) );
			// 删除统计相关数据
			pdo_delete ( 'stat_rule', array (
					'rid' => $rid 
			) );
			pdo_delete ( 'stat_keyword', array (
					'rid' => $rid 
			) );
			// 调用模块中的删除
			$module = WeUtility::createModule ( $rule ['module'] );
			if (method_exists ( $module, 'ruleDeleted' )) {
				$module->ruleDeleted ( $rid );
			}
		}
	}
	$this->webmessage ( '规则操作成功！', '', 0 );	
}
?>