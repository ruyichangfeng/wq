<?php
if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');
global $_GPC,$_W;
$kid= intval($_GPC['kid']);
if(empty($kid)){
    message('抱歉，传递的参数错误！','', 'error');              
}
$xkwkj=DBUtil::findById(DBUtil::$TABLE_XKWKJ,$kid);

$goods = DBUtil::findById(DBUtil::$TABLE_XKWKJ_GOODS, $xkwkj['gid']);

$where = '';
$params = array(
	':kid' => $kid
);

$status = $_GPC['status'];
if ($status != '') {
	$where .= ' and status =:status';
	$params[':status'] = $_GPC['status'];
}

$list = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_XKWJK_ORDER) . " WHERE kid =:kid " . $where . "  ORDER BY createtime DESC ", $params);

$title = array(
	'商品',
	'款式',
	'用户openid',
	'订单编号',
	'微信支付单号',
	'收货人',
	'电话',
	'省份',
	'城市',
	'县区',
	'收货地址',
	'商品原价',
	'砍后价格',
	'运费',
	'交易金额',
	'状态',
	'下单时间',
	'支付时间'
);

$arraydata[] = iconv("UTF-8","GB2312//IGNORE", implode("\t", $title )) ;

foreach ($list as &$value) {
	$tmp_value =  array(
		$goods['p_name'],
		$value['p_model'],
		$value['openid'],
		$value["order_no"],
		$value["wxorder_no"],
		$value["uname"],
		$value["tel"],
		$value["privnce"],
		$value["city"],
		$value["town"],
		$value["address"],
		$value["y_price"],
		$value["kh_price"],
		$value["yf_price"],
		$value["total_price"],
		$this->getStatusText($value["status"]),
		date('Y-m-d H:i:s',$value['createtime']),
		date('Y-m-d H:i:s',$value['notifytime'])

	);

	$arraydata[] = iconv("UTF-8","GB2312//IGNORE", implode("\t", $tmp_value )) ;
}

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/vnd.ms-execl");
header("Content-Type: application/force-download");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=".$xkwkj['title']." 订单数据.xls");
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 0");
echo  implode("\t\n",$arraydata);
exit();
