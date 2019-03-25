<?php
defined ( 'IN_IA' ) or exit ( 'Access Denied' );

global $_GPC, $_W;

checklogin();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'list';

if ($operation == 'list') {
	global $_GPC, $_W;
	$rid = intval ( $_GPC ['rid'] );
	if (empty ( $rid )) {
		message ( '抱歉，传递的参数错误！', '', 'error' );
	}
	$reply = pdo_fetch("SELECT * FROM " . tablename ("cx_tcbd_form") . " WHERE rid = :rid ORDER BY `id` DESC", array (':rid' => $rid));
	$fields = json_decode(htmlspecialchars_decode($reply['fields']),true);
	$ths = "";
	$tds = "";
	foreach ($fields as $key => $col){
		$ths = $ths . "<th>{$col['title']}</th>";
		$tds = $tds . "<td></td>";
	};
	$where = '';
	$params = array (
			':rid' => $rid,
			':uniacid' => $_W ['uniacid'] 
	);
	$total = pdo_fetchcolumn ( "SELECT count(a.id) FROM " . tablename ( 'cx_tcbd_order' ) . " a WHERE a.rid = :rid and a.uniacid=:uniacid " . $where . "", $params );
	$pindex = max ( 1, intval ( $_GPC ['page'] ) );
	$psize = 12;
	$pager = pagination ( $total, $pindex, $psize );
	$start = ($pindex - 1) * $psize;
	$limit .= " LIMIT {$start},{$psize}";
	$list = pdo_fetchall ( "SELECT a.* FROM " . tablename ( 'cx_tcbd_order' ) . 
						   " a WHERE a.rid = :rid and a.uniacid=:uniacid " . $where . " ORDER BY a.id DESC " . $limit, $params );
	include $this->template ( 'list' );	
} elseif ($operation == 'post') {
} elseif ($operation == 'downloadmedias') {
	global $_GPC, $_W;
	$orderid = intval ( $_GPC['orderid'] );
	$field = $_GPC['field'];
	$mediaids = $_GPC['mediaids'];
	if (empty($orderid) || empty($field) || empty($mediaids)){
		message ( -1, '', 'ajax' );
	}
	$mediaids = explode(';',$mediaids);
	load()->classs('weixin.account');
	$account = WeAccount::create();
	$files = array();
	foreach ($mediaids as $v) {
		if (strlen($v) < 1) continue;
		$media = array('media_id' => $v, 'type'=>'image');
		$file = $account->downloadMedia($media);
		if(is_error($file)){
			//$files[] = "";
		}else{
			$files[] = $file;
		}
	}
	//更新数据
	$params = array (
			':id' => $orderid,
			':uniacid' => $_W ['uniacid'] 
	);	
	$value = pdo_fetchcolumn('SELECT fields FROM ' . tablename ( 'cx_tcbd_order' ) . "WHERE uniacid=:uniacid AND id=:id LIMIT 1",$params);
	$fields = @json_decode(htmlspecialchars_decode($value),true);
	foreach( $fields as $k => $d){
		if ($d['sn'] == $field){
			$v = @json_decode(htmlspecialchars_decode($d['value']),true);
			$v['images'] = join(";",$files);
			$fields[$k]['value'] = json_encode($v,JSON_UNESCAPED_UNICODE);
			$fields = json_encode($fields,JSON_UNESCAPED_UNICODE);
			pdo_update('bc_zhbd_order', array('fields' => $fields), array('id' => $orderid));
			break;
		}
	}
	//
	$return["code"]="1";
	$return["data"]=$v['images'];
	echo json_encode($return);
}
?>