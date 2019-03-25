<?php
global $_W,$_GPC;
$rid = $_GPC['rid'];
$menu = pdo_fetch('select * from '.tablename('wxz_wzb_live_menu').' where rid='.$rid.' and type=7 and isshow=1 order by sort desc');
$mch_ids = iunserializer($menu['settings']);

if(isset($mch_ids['mch_id']) && $mch_ids['mch_id']>0){
	$goodslist = pdo_fetchall("SELECT market_price as costprice,shop_price as price,goods_img as img,goods_id,goods_name as title,mch_id FROM " . tablename('wxz_lzl_goods') . " WHERE weid = '{$_W['uniacid']}' and is_delete=0 AND is_on_sale = '1' and mch_id = ".$mch_ids['mch_id']." ORDER BY sort_order DESC, sales DESC LIMIT 50");
}else{
	$goodslist = pdo_fetchall("SELECT market_price as costprice,shop_price as price,goods_img as img,goods_id,goods_name as title,mch_id FROM " . tablename('wxz_lzl_goods') . " WHERE weid = '{$_W['uniacid']}' and is_delete=0 AND is_on_sale = '1' ORDER BY sort_order DESC, sales DESC LIMIT 50");
}


foreach($goodslist as $key => $v){
	$goodslist[$key]['img'] = tomedia($v['img']);
	$goodslist[$key]['link'] = murl('entry//goods',array('m'=>'wxz_store', 'id' => $v['goods_id'], 'mch_id' => $v['mch_id'], 'mfrom' => 'wzb', 'wrid' => $rid),true);
}
$result = array('s'=>'1','msg'=>$goodslist);
echo json_encode($result);exit;

?>