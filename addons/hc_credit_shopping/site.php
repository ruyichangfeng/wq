<?php
/**
 * 
 *
 * @author 火池网络
 * @url    http://weixiamen.cn/
 */
defined('IN_IA') or exit('Access Denied');
session_start();
include 'model.php';
class Hc_credit_shoppingModuleSite extends WeModuleSite {
	public function doWebCategory() {
		global $_GPC, $_W;
		load()->func('tpl');
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'display') {
			if (!empty($_GPC['displayorder'])) {
				foreach ($_GPC['displayorder'] as $id => $displayorder) {
					pdo_update('hc_credit_shopping_category', array('displayorder' => $displayorder), array('id' => $id));
				}
				message('分类排序更新成功！', $this->createWebUrl('category', array('op' => 'display')), 'success');
			}
			$children = array();
			$category = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_category') . " WHERE weid = '{$_W['uniacid']}' ORDER BY parentid ASC, displayorder DESC");
			foreach ($category as $index => $row) {
				if (!empty($row['parentid'])) {
					$children[$row['parentid']][] = $row;
					unset($category[$index]);
				}
			}
			include $this->template('category');
		} elseif ($operation == 'post') {
			$parentid = intval($_GPC['parentid']);
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				$category = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_category') . " WHERE id = '$id'");
			} else {
				$category = array(
					'displayorder' => 0,
				);
			}
			if (!empty($parentid)) {
				$parent = pdo_fetch("SELECT id, name FROM " . tablename('hc_credit_shopping_category') . " WHERE id = '$parentid'");
				if (empty($parent)) {
					message('抱歉，上级分类不存在或是已经被删除！', $this->createWebUrl('post'), 'error');
				}
			}
			if (checksubmit('submit')) {
				if (empty($_GPC['catename'])) {
					message('抱歉，请输入分类名称！');
				}
				$data = array(
					'weid' => $_W['uniacid'],
					'name' => $_GPC['catename'],
					'enabled' => intval($_GPC['enabled']),
					'displayorder' => intval($_GPC['displayorder']),
					'isrecommand' => intval($_GPC['isrecommand']),
					'description' => $_GPC['description'],
					'parentid' => intval($parentid),
					'thumb' => $_GPC['thumb']
				);
				if (!empty($id)) {
					unset($data['parentid']);
					pdo_update('hc_credit_shopping_category', $data, array('id' => $id));
					load()->func('file');
					file_delete($_GPC['thumb_old']);
				} else {
					pdo_insert('hc_credit_shopping_category', $data);
					$id = pdo_insertid();
				}
				message('更新分类成功！', $this->createWebUrl('category', array('op' => 'display')), 'success');
			}
			include $this->template('category');
		} elseif ($operation == 'delete') {
			$id = intval($_GPC['id']);
			$category = pdo_fetch("SELECT id, parentid FROM " . tablename('hc_credit_shopping_category') . " WHERE id = '$id'");
			if (empty($category)) {
				message('抱歉，分类不存在或是已经被删除！', $this->createWebUrl('category', array('op' => 'display')), 'error');
			}
			pdo_delete('hc_credit_shopping_category', array('id' => $id, 'parentid' => $id), 'OR');
			message('分类删除成功！', $this->createWebUrl('category', array('op' => 'display')), 'success');
		}
	}


	public function doWebbuy_log(){
		global $_W,$_GPC;
		$uniacid = $_W['uniacid'];
		$psize = 30;
		$pindex = max(1, intval($_GPC['page']));
		$list = pdo_fetchall( " SELECT o.from_user,o.price,o.goodsprice,m.nickname,o.createtime FROM ".tablename('hc_credit_shopping_order')." AS o LEFT JOIN ".tablename('hc_credit_shopping_member')." AS m ON o.from_user=m.openid WHERE o.paytype=9 AND o.status=9  ORDER BY o.createtime  DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}  " );
		$total =  pdo_fetchcolumn( " SELECT COUNT(id)  FROM ".tablename('hc_credit_shopping_order')." WHERE weid='".$uniacid."' AND paytype=9 AND status=9 " );
		$pager = pagination($total, $pindex, $psize);

		include $this->template('buy_log');
	}
	
	public function doWebChecked_log(){
		global $_W,$_GPC;
		$uniacid = $_W['uniacid'];
		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$psize = 30;
		$pindex = max(1, intval($_GPC['page']));
		if($op=='display'){
			$list = pdo_fetchall("SELECT o.*, og.* FROM ".tablename('hc_credit_shopping_order')." as o left join ".tablename('hc_credit_shopping_order_goods')." as og on o.id = og.orderid and o.weid = og.weid WHERE o.goodstype = 2 and o.ischeck = 1 and o.weid = ".$uniacid." order by o.createtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}  " );
			$total =  pdo_fetchcolumn("SELECT count(o.id) FROM ".tablename('hc_credit_shopping_order')." as o left join ".tablename('hc_credit_shopping_order_goods')." as og on o.id = og.orderid and o.weid = og.weid WHERE o.goodstype = 2 and o.ischeck = 1 and o.weid = ".$uniacid);
		}
		
		if($op=='unchecked'){
			$list = pdo_fetchall("SELECT o.*, og.* FROM ".tablename('hc_credit_shopping_order')." as o left join ".tablename('hc_credit_shopping_order_goods')." as og on o.id = og.orderid and o.weid = og.weid WHERE o.goodstype = 2 and o.ischeck = 0 and o.weid = ".$uniacid." order by o.createtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}  " );
			$total =  pdo_fetchcolumn("SELECT count(o.id) FROM ".tablename('hc_credit_shopping_order')." as o left join ".tablename('hc_credit_shopping_order_goods')." as og on o.id = og.orderid and o.weid = og.weid WHERE o.goodstype = 2 and o.ischeck = 0 and o.weid = ".$uniacid);
		}
		$address = pdo_fetchall("SELECT * FROM ".tablename('hc_credit_shopping_address')." WHERE weid = ".$uniacid);
		$addr = array();
		foreach($address as $as){
			$addr['realname'][$as['id']] = $as['realname'];
			$addr['mobile'][$as['id']] = $as['mobile'];
		}
		$goods = pdo_fetchall("SELECT id, title FROM ".tablename('hc_credit_shopping_goods')." WHERE weid = ".$uniacid);
		$good = array();
		foreach($goods as $gs){
			$good[$gs['id']] = $gs['title'];
		}
		
		$pager = pagination($total, $pindex, $psize);

		include $this->template('checked_log');
	}

	public function doWebSetGoodsProperty() {
		global $_GPC, $_W;
		$id = intval($_GPC['id']);
		$type = $_GPC['type'];
		$data = intval($_GPC['data']);
		if (in_array($type, array('new', 'hot', 'recommand', 'discount'))) {
			$data = ($data==1?'0':'1');
			pdo_update("hc_credit_shopping_goods", array("is" . $type => $data), array("id" => $id, "weid" => $_W['uniacid']));
			die(json_encode(array("result" => 1, "data" => $data)));
		}
		if (in_array($type, array('status'))) {
			$data = ($data==1?'0':'1');
			pdo_update("hc_credit_shopping_goods", array($type => $data), array("id" => $id, "weid" => $_W['uniacid']));
			die(json_encode(array("result" => 1, "data" => $data)));
		}
		if (in_array($type, array('type'))) {
			$data = ($data==1?'2':'1');
			pdo_update("hc_credit_shopping_goods", array($type => $data), array("id" => $id, "weid" => $_W['uniacid']));
			die(json_encode(array("result" => 1, "data" => $data)));
		}
		die(json_encode(array("result" => 0)));
	}
	public function doWebGoods() {
		global $_GPC, $_W;
		load()->func('tpl');

		$sql = 'SELECT * FROM ' . tablename('hc_credit_shopping_category') . ' WHERE `weid` = :weid ORDER BY `parentid`, `displayorder` DESC';
		$fenlei = pdo_fetchall( " SELECT * FROM ".tablename('hc_credit_shopping_category')." WHERE weid='".$_W['uniacid']."' AND parentid=0 ORDER BY displayorder DESC " );
		$category = pdo_fetchall($sql, array(':weid' => $_W['uniacid']), 'id');
		if (!empty($category)) {
			$parent = $children = array();
			foreach ($category as $cid => $cate) {
				if (!empty($cate['parentid'])) {
					$children[$cate['parentid']][] = $cate;
				} else {
					$parent[$cate['id']] = $cate;
				}
			}
		}

		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'post') {
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				$item = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_goods') . " WHERE id = :id", array(':id' => $id));
				if (empty($item)) {
					message('抱歉，商品不存在或是已经删除！', '', 'error');
				}
				$allspecs = pdo_fetchall("select * from " . tablename('hc_credit_shopping_spec')." where goodsid=:id order by displayorder asc",array(":id"=>$id));
				foreach ($allspecs as &$s) {
					$s['items'] = pdo_fetchall("select * from " . tablename('hc_credit_shopping_spec_item') . " where specid=:specid order by displayorder asc", array(":specid" => $s['id']));
				}
				unset($s);
				$params = pdo_fetchall("select * from " . tablename('hc_credit_shopping_goods_param') . " where goodsid=:id order by displayorder asc", array(':id' => $id));
				$piclist1 = unserialize($item['thumb_url']);
				$piclist = array();
				if(is_array($piclist1)){
					foreach($piclist1 as $p){
						$piclist[] = is_array($p)?$p['attachment']:$p;
					}
				}
				//var_dump($piclist);
				//处理规格项
				$html = "";
				$options = pdo_fetchall("select * from " . tablename('hc_credit_shopping_goods_option') . " where goodsid=:id order by id asc", array(':id' => $id));
				//排序好的specs
				$specs = array();
				//找出数据库存储的排列顺序
				if (count($options) > 0) {
					$specitemids = explode("_", $options[0]['specs'] );
					foreach($specitemids as $itemid){
						foreach($allspecs as $ss){
							$items = $ss['items'];
							foreach($items as $it){
								if($it['id']==$itemid){
									$specs[] = $ss;
									break;
								}
							}
						}
					}
					$html = '';
					$html .= '<table class="table table-bordered table-condensed">';
					$html .= '<thead>';
					$html .= '<tr class="active">';
					$len = count($specs);
					$newlen = 1; //多少种组合
					$h = array(); //显示表格二维数组
					$rowspans = array(); //每个列的rowspan
					for ($i = 0; $i < $len; $i++) {
						//表头
						$html .= "<th style='width:80px;'>" . $specs[$i]['title'] . "</th>";
						//计算多种组合
						$itemlen = count($specs[$i]['items']);
						if ($itemlen <= 0) {
							$itemlen = 1;
						}
						$newlen *= $itemlen;
						//初始化 二维数组
						$h = array();
						for ($j = 0; $j < $newlen; $j++) {
							$h[$i][$j] = array();
						}
						//计算rowspan
						$l = count($specs[$i]['items']);
						$rowspans[$i] = 1;
						for ($j = $i + 1; $j < $len; $j++) {
							$rowspans[$i]*= count($specs[$j]['items']);
						}
					}
					$html .= '<th class="info" style="width:130px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">库存</div><div class="input-group"><input type="text" class="form-control option_stock_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_stock\');"></a></span></div></div></th>';
					$html .= '<th class="success" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">销售价格</div><div class="input-group"><input type="text" class="form-control option_marketprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_marketprice\');"></a></span></div></div></th>';
					$html .= '<th class="warning" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">市场价格</div><div class="input-group"><input type="text" class="form-control option_productprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_productprice\');"></a></span></div></div></th>';
					$html .= '<th class="danger" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">成本价格</div><div class="input-group"><input type="text" class="form-control option_costprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_costprice\');"></a></span></div></div></th>';
					$html .= '<th class="info" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">重量（克）</div><div class="input-group"><input type="text" class="form-control option_weight_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_weight\');"></a></span></div></div></th>';
					$html .= '</tr></thead>';
					for ($m = 0; $m < $len; $m++) {
						$k = 0;
						$kid = 0;
						$n = 0;
						for ($j = 0; $j < $newlen; $j++) {
							$rowspan = $rowspans[$m];
							if ($j % $rowspan == 0) {
								$h[$m][$j] = array("html" => "<td rowspan='" . $rowspan . "'>" . $specs[$m]['items'][$kid]['title'] . "</td>", "id" => $specs[$m]['items'][$kid]['id']);
							} else {
								$h[$m][$j] = array("html" => "", "id" => $specs[$m]['items'][$kid]['id']);
							}
							$n++;
							if ($n == $rowspan) {
								$kid++;
								if ($kid > count($specs[$m]['items']) - 1) {
									$kid = 0;
								}
								$n = 0;
							}
						}
					}
					$hh = "";
					for ($i = 0; $i < $newlen; $i++) {
						$hh.="<tr>";
						$ids = array();
						for ($j = 0; $j < $len; $j++) {
							$hh.=$h[$j][$i]['html'];
							$ids[] = $h[$j][$i]['id'];
						}
						$ids = implode("_", $ids);
						$val = array("id" => "","title"=>"", "stock" => "", "costprice" => "", "productprice" => "", "marketprice" => "", "weight" => "");
						foreach ($options as $o) {
							if ($ids === $o['specs']) {
								$val = array(
									"id" => $o['id'],
									"title" =>$o['title'],
									"stock" => $o['stock'],
									"costprice" => $o['costprice'],
									"productprice" => $o['productprice'],
									"marketprice" => $o['marketprice'],
									"weight" => $o['weight']
								);
								break;
							}
						}
						$hh .= '<td class="info">';
						$hh .= '<input name="option_stock_' . $ids . '[]"  type="text" class="form-control option_stock option_stock_' . $ids . '" value="' . $val['stock'] . '"/></td>';
						$hh .= '<input name="option_id_' . $ids . '[]"  type="hidden" class="form-control option_id option_id_' . $ids . '" value="' . $val['id'] . '"/>';
						$hh .= '<input name="option_ids[]"  type="hidden" class="form-control option_ids option_ids_' . $ids . '" value="' . $ids . '"/>';
						$hh .= '<input name="option_title_' . $ids . '[]"  type="hidden" class="form-control option_title option_title_' . $ids . '" value="' . $val['title'] . '"/>';
						$hh .= '</td>';
						$hh .= '<td class="success"><input name="option_marketprice_' . $ids . '[]" type="text" class="form-control option_marketprice option_marketprice_' . $ids . '" value="' . $val['marketprice'] . '"/></td>';
						$hh .= '<td class="warning"><input name="option_productprice_' . $ids . '[]" type="text" class="form-control option_productprice option_productprice_' . $ids . '" " value="' . $val['productprice'] . '"/></td>';
						$hh .= '<td class="danger"><input name="option_costprice_' . $ids . '[]" type="text" class="form-control option_costprice option_costprice_' . $ids . '" " value="' . $val['costprice'] . '"/></td>';
						$hh .= '<td class="info"><input name="option_weight_' . $ids . '[]" type="text" class="form-control option_weight option_weight_' . $ids . '" " value="' . $val['weight'] . '"/></td>';
						$hh .= '</tr>';
					}
					$html .= $hh;
					$html .= "</table>";
				}
			}
			if (empty($category)) {
				message('抱歉，请您先添加商品分类！', $this->createWebUrl('category', array('op' => 'post')), 'error');
			}
			if (checksubmit('submit')) {
				if (empty($_GPC['goodsname'])) {
					message('请输入商品名称！');
				}
				/*
				if (empty($_GPC['category']['parentid'])) {
					message('请选择商品分类！');
				}
				*/
				if (empty($_GPC['pcate'])) {
					message('请选择商品分类！');
				}
				if(empty($_GPC['thumbs'])){
					$_GPC['thumbs'] = array();
				}
				$data = array(
					'weid' => intval($_W['uniacid']),
					'displayorder' => intval($_GPC['displayorder']),
					'title' => $_GPC['goodsname'],
					'pcate' => intval($_GPC['pcate']),
					'ccate' => intval($_GPC['ccate']),
					'thumb'=>$_GPC['thumb'],
					'type' => intval($_GPC['type']),
					'isrecommand' => intval($_GPC['isrecommand']),
					'ishot' => intval($_GPC['ishot']),
					'isnew' => intval($_GPC['isnew']),
					'isdiscount' => intval($_GPC['isdiscount']),
					'istime' => intval($_GPC['istime']),
					'timestart' => strtotime($_GPC['timestart']),
					'timeend' => strtotime($_GPC['timeend']),
					'description' => $_GPC['description'],
					'content' => htmlspecialchars_decode($_GPC['content']),
					'goodssn' => $_GPC['goodssn'],
					'unit' => $_GPC['unit'],
					'createtime' => TIMESTAMP,
					'total' => intval($_GPC['total']),
					'goods_status' => 0,
					'totalcnf' => intval($_GPC['totalcnf']),
					'marketprice' => $_GPC['marketprice'],
					'weight' => $_GPC['weight'],
					'costprice' => $_GPC['costprice'],
					'originalprice' => $_GPC['originalprice'],
					'productprice' => $_GPC['productprice'],
					'productsn' => $_GPC['productsn'],
					'checkcode' => trim($_GPC['checkcode']),
					'credit' => intval($_GPC['credit']),
					'stock_total' => intval($_GPC['total']),
					'maxbuy' => intval($_GPC['maxbuy']),
					'usermaxbuy' => intval($_GPC['usermaxbuy']),
					'hasoption' => intval($_GPC['hasoption']),
					'sales' => intval($_GPC['sales']),
					'status' => intval($_GPC['status']),
				);
				if ($data['total'] === -1) {
					$data['total'] = 0;
					$data['totalcnf'] = 2;
				}
				
				if(is_array($_GPC['thumbs'])){
					$data['thumb_url'] = serialize($_GPC['thumbs']);
				}
				if (empty($id)) {
					pdo_insert('hc_credit_shopping_goods', $data);
					$id = pdo_insertid();
				} else {
					unset($data['createtime']);
				//	unset($data['total']);
					pdo_update('hc_credit_shopping_goods', $data, array('id' => $id));
				}
				$totalstocks = 0;
				//处理自定义参数
				$param_ids = $_POST['param_id'];
				$param_titles = $_POST['param_title'];
				$param_values = $_POST['param_value'];
				$param_displayorders = $_POST['param_displayorder'];
				$len = count($param_ids);
				$paramids = array();
				for ($k = 0; $k < $len; $k++) {
					$param_id = "";
					$get_param_id = $param_ids[$k];
					$a = array(
						"title" => $param_titles[$k],
						"value" => $param_values[$k],
						"displayorder" => $k,
						"goodsid" => $id,
					);
					if (!is_numeric($get_param_id)) {
						pdo_insert("hc_credit_shopping_goods_param", $a);
						$param_id = pdo_insertid();
					} else {
						pdo_update("hc_credit_shopping_goods_param", $a, array('id' => $get_param_id));
						$param_id = $get_param_id;
					}
					$paramids[] = $param_id;
				}
				if (count($paramids) > 0) {
					pdo_query("delete from " . tablename('hc_credit_shopping_goods_param') . " where goodsid=$id and id not in ( " . implode(',', $paramids) . ")");
				}
				else{
					pdo_query("delete from " . tablename('hc_credit_shopping_goods_param') . " where goodsid=$id");
				}
//				if ($totalstocks > 0) {
//					pdo_update("hc_credit_shopping_goods", array("total" => $totalstocks), array("id" => $id));
//				}
				//处理商品规格
				$files = $_FILES;
				$spec_ids = $_POST['spec_id'];
				$spec_titles = $_POST['spec_title'];
				$specids = array();
				$len = count($spec_ids);
				$specids = array();
				$spec_items = array();
				for ($k = 0; $k < $len; $k++) {
					$spec_id = "";
					$get_spec_id = $spec_ids[$k];
					$a = array(
						"weid" => $_W['uniacid'],
						"goodsid" => $id,
						"displayorder" => $k,
						"title" => $spec_titles[$get_spec_id]
					);
					if (is_numeric($get_spec_id)) {
						pdo_update("hc_credit_shopping_spec", $a, array("id" => $get_spec_id));
						$spec_id = $get_spec_id;
					} else {
						pdo_insert("hc_credit_shopping_spec", $a);
						$spec_id = pdo_insertid();
					}
					//子项
					$spec_item_ids = $_POST["spec_item_id_".$get_spec_id];
					$spec_item_titles = $_POST["spec_item_title_".$get_spec_id];
					$spec_item_shows = $_POST["spec_item_show_".$get_spec_id];
					$spec_item_thumbs = $_POST["spec_item_thumb_".$get_spec_id];
					$spec_item_oldthumbs = $_POST["spec_item_oldthumb_".$get_spec_id];
					$itemlen = count($spec_item_ids);
					$itemids = array();
					for ($n = 0; $n < $itemlen; $n++) {
						$item_id = "";
						$get_item_id = $spec_item_ids[$n];
						$d = array(
							"weid" => $_W['uniacid'],
							"specid" => $spec_id,
							"displayorder" => $n,
							"title" => $spec_item_titles[$n],
							"show" => $spec_item_shows[$n],
							"thumb"=>$spec_item_thumbs[$n]
						);
						$f = "spec_item_thumb_" . $get_item_id;
						if (is_numeric($get_item_id)) {
							pdo_update("hc_credit_shopping_spec_item", $d, array("id" => $get_item_id));
							$item_id = $get_item_id;
						} else {
							pdo_insert("hc_credit_shopping_spec_item", $d);
							$item_id = pdo_insertid();
						}
						$itemids[] = $item_id;
						//临时记录，用于保存规格项
						$d['get_id'] = $get_item_id;
						$d['id']= $item_id;
						$spec_items[] = $d;
					}
					//删除其他的
					if(count($itemids)>0){
						 pdo_query("delete from " . tablename('hc_credit_shopping_spec_item') . " where weid={$_W['uniacid']} and specid=$spec_id and id not in (" . implode(",", $itemids) . ")");	
					}
					else{
						 pdo_query("delete from " . tablename('hc_credit_shopping_spec_item') . " where weid={$_W['uniacid']} and specid=$spec_id");	
					}
					//更新规格项id
					pdo_update("hc_credit_shopping_spec", array("content" => serialize($itemids)), array("id" => $spec_id));
					$specids[] = $spec_id;
				}
				//删除其他的
				if( count($specids)>0){
					pdo_query("delete from " . tablename('hc_credit_shopping_spec') . " where weid={$_W['uniacid']} and goodsid=$id and id not in (" . implode(",", $specids) . ")");
				}
				else{
					pdo_query("delete from " . tablename('hc_credit_shopping_spec') . " where weid={$_W['uniacid']} and goodsid=$id");
				}
				//保存规格
				$option_idss = $_POST['option_ids'];
				$option_productprices = $_POST['option_productprice'];
				$option_marketprices = $_POST['option_marketprice'];
				$option_costprices = $_POST['option_costprice'];
				$option_stocks = $_POST['option_stock'];
				$option_weights = $_POST['option_weight'];
				$len = count($option_idss);
				$optionids = array();
				for ($k = 0; $k < $len; $k++) {
					$option_id = "";
					$get_option_id = $_GPC['option_id_' . $ids][0];
					$ids = $option_idss[$k]; $idsarr = explode("_",$ids);
					$newids = array();
					foreach($idsarr as $key=>$ida){
						foreach($spec_items as $it){
							if($it['get_id']==$ida){
								$newids[] = $it['id'];
								break;
							}
						}
					}
					$newids = implode("_",$newids);
					$a = array(
						"title" => $_GPC['option_title_' . $ids][0],
						"productprice" => $_GPC['option_productprice_' . $ids][0],
						"costprice" => $_GPC['option_costprice_' . $ids][0],
						"marketprice" => $_GPC['option_marketprice_' . $ids][0],
						"stock" => $_GPC['option_stock_' . $ids][0],
						"weight" => $_GPC['option_weight_' . $ids][0],
						"goodsid" => $id,
						"specs" => $newids
					);
					$totalstocks+=$a['stock'];
					if (empty($get_option_id)) {
						pdo_insert("hc_credit_shopping_goods_option", $a);
						$option_id = pdo_insertid();
					} else {
						pdo_update("hc_credit_shopping_goods_option", $a, array('id' => $get_option_id));
						$option_id = $get_option_id;
					}
					$optionids[] = $option_id;
				}
				if (count($optionids) > 0) {
					pdo_query("delete from " . tablename('hc_credit_shopping_goods_option') . " where goodsid=$id and id not in ( " . implode(',', $optionids) . ")");
				}
				else{
					pdo_query("delete from " . tablename('hc_credit_shopping_goods_option') . " where goodsid=$id");
				}
				//总库存
				if ( ($totalstocks > 0) && ($data['totalcnf'] != 2) ) {
					pdo_update("hc_credit_shopping_goods", array("total" => $totalstocks), array("id" => $id));
				}
				message('商品更新成功！', $this->createWebUrl('goods', array('op' => 'display', 'id' => $id)), 'success');
			}
		} elseif ($operation == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 15;
			$condition = ' WHERE `weid` = :weid AND `deleted` = :deleted';
			$params = array(':weid' => $_W['uniacid'], ':deleted' => '0');
			if (!empty($_GPC['keyword'])) {
				$condition .= ' AND `title` LIKE :title';
				$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
			}
			if (!empty($_GPC['category']['childid'])) {
				$condition .= ' AND `ccate` = :ccate';
				$params[':ccate'] = intval($_GPC['category']['childid']);
			}
			if (!empty($_GPC['category']['parentid'])) {
				$condition .= ' AND `pcate` = :pcate';
				$params[':pcate'] = intval($_GPC['category']['parentid']);
			}
			if (isset($_GPC['status'])) {
				$condition .= ' AND `status` = :status';
				$params[':status'] = intval($_GPC['status']);
			}

			$sql = 'SELECT COUNT(*) FROM ' . tablename('hc_credit_shopping_goods') . $condition;
			$total = pdo_fetchcolumn($sql, $params);
			if (!empty($total)) {
				$sql = 'SELECT * FROM ' . tablename('hc_credit_shopping_goods') . $condition . ' ORDER BY `status` DESC, `displayorder` DESC,
						`id` DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
				$list = pdo_fetchall($sql, $params);
				$pager = pagination($total, $pindex, $psize);
			}
		} elseif ($operation == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT id, thumb FROM " . tablename('hc_credit_shopping_goods') . " WHERE id = :id", array(':id' => $id));
			if (empty($row)) {
				message('抱歉，商品不存在或是已经被删除！');
			}
//			if (!empty($row['thumb'])) {
//				file_delete($row['thumb']);
//			}
//			pdo_delete('hc_credit_shopping_goods', array('id' => $id));
			//修改成不直接删除，而设置deleted=1
			pdo_update("hc_credit_shopping_goods", array("deleted" => 1), array('id' => $id));
			message('删除成功！', referer(), 'success');
		} elseif ($operation == 'productdelete') {
			$id = intval($_GPC['id']);
			pdo_delete('hc_credit_shopping_product', array('id' => $id));
			message('删除成功！', '', 'success');
		}
		include $this->template('goods');
	}
	public function doWebOrder() {
		global $_W, $_GPC;
		load()->func('tpl');
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$status = $_GPC['status'];
			$sendtype = !isset($_GPC['sendtype']) ? 0 : $_GPC['sendtype'];
			$condition = " o.weid = :weid";
			$paras = array(':weid' => $_W['uniacid']);
			if (empty($starttime) || empty($endtime)) {
				$starttime = strtotime('-1 month');
				$endtime = time();
			}
			if (!empty($_GPC['time'])) {
				$starttime = strtotime($_GPC['time']['start']);
				$endtime = strtotime($_GPC['time']['end']) + 86399;
				$condition .= " AND o.createtime >= :starttime AND o.createtime <= :endtime ";
				$paras[':starttime'] = $starttime;
				$paras[':endtime'] = $endtime;
			}
			if (!empty($_GPC['paytype'])) {
				$condition .= " AND o.paytype = '{$_GPC['paytype']}'";
			} elseif ($_GPC['paytype'] === '0') {
				$condition .= " AND o.paytype = '{$_GPC['paytype']}'";
			}
			if (!empty($_GPC['keyword'])) {
				$condition .= " AND o.ordersn LIKE '%{$_GPC['keyword']}%'";
			}
			if (!empty($_GPC['member'])) {
				$condition .= " AND (a.realname LIKE '%{$_GPC['member']}%' or a.mobile LIKE '%{$_GPC['member']}%')";
			}
			if ($status != '') {
				$condition .= " AND o.status = '" . intval($status) . "'";
			}
			if (!empty($sendtype)) {
				$condition .= " AND o.sendtype = '" . intval($sendtype) . "' AND status != '3'";
			}
			$sql = "select o.* , a.realname,a.mobile from ".tablename('hc_credit_shopping_order')." o"
					." left join ".tablename('hc_credit_shopping_address')." a on o.addressid = a.id "
					. " where $condition AND remark !='bi_buy' ORDER BY o.status DESC, o.createtime DESC "
					. "LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql,$paras);
			$paytype = array (
					'0' => array('css' => 'default', 'name' => '未支付'),
					'1' => array('css' => 'danger','name' => '余额支付'),
					'2' => array('css' => 'info', 'name' => '在线支付'),
					'3' => array('css' => 'warning', 'name' => '货到付款'),
					'4' => array('css' => 'warning', 'name' => '积分支付')
			);
			$orderstatus = array (
					'-1' => array('css' => 'default', 'name' => '已取消'),
					'0' => array('css' => 'danger', 'name' => '待付款'),
					'1' => array('css' => 'info', 'name' => '待发货'),
					'2' => array('css' => 'warning', 'name' => '待收货'),
					'3' => array('css' => 'success', 'name' => '已完成')
			);
			foreach ($list as &$value) {
				$s = $value['status'];
				$value['statuscss'] = $orderstatus[$value['status']]['css'];
				$value['status'] = $orderstatus[$value['status']]['name'];
				if ($s < 1) {
					$value['css'] = $paytype[$s]['css'];
					$value['paytype'] = $paytype[$s]['name'];
					continue;
				}
				$value['css'] = $paytype[$value['paytype']]['css'];
				if ($value['paytype'] == 2) {
					if (empty($value['transid'])) {
						$value['paytype'] = '支付宝支付';
					} else {
						$value['paytype'] = '微信支付';
					}
				} else {
					$value['paytype'] = $paytype[$value['paytype']]['name'];
				}
			}
			$total = pdo_fetchcolumn(
						'SELECT COUNT(*) FROM ' . tablename('hc_credit_shopping_order') . " o "
						." left join ".tablename('hc_credit_shopping_address')." a on o.addressid = a.id "
						." WHERE $condition AND remark !='bi_buy'" , $paras);
			$pager = pagination($total, $pindex, $psize);
			if (!empty($list)) {
				foreach ($list as &$row) {
					// !empty($row['addressid']) && $addressids[$row['addressid']] = $row['addressid'];
					$row['dispatch'] = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_dispatch') . " WHERE id = :id", array(':id' => $row['dispatch']));
				}
				unset($row);
			}
//			if (!empty($addressids)) {
//				$address = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_address') . " WHERE id IN ('" . implode("','", $addressids) . "')", array(), 'id');
//			}
			}elseif($operation == 'export'){
				$starttime = TIMESTAMP;
				$endtime = $starttime + 86400*7;
				include $this->template('order_export');
				exit;
			} elseif ($operation == 'detail') {
			$id = intval($_GPC['id']);
			$item = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_order') . " WHERE id = :id", array(':id' => $id));
			if (empty($item)) {
				message("抱歉，订单不存在!", referer(), "error");
			}
			if (checksubmit('confirmsend')) {
				if (!empty($_GPC['isexpress']) && empty($_GPC['expresssn'])) {
					message('请输入快递单号！');
				}
				$item = pdo_fetch("SELECT transid FROM " . tablename('hc_credit_shopping_order') . " WHERE id = :id", array(':id' => $id));
				if (!empty($item['transid'])) {
					$this->changeWechatSend($id, 1);
				}
				pdo_update(
					'hc_credit_shopping_order',
					array(
						'status' => 2,
						'remark' => $_GPC['remark'],
						'express' => $_GPC['express'],
						'expresscom' => $_GPC['expresscom'],
						'expresssn' => $_GPC['expresssn'],
					),
					array('id' => $id)
				);
				message('发货操作成功！', referer(), 'success');
			}
			if (checksubmit('cancelsend')) {
				$item = pdo_fetch("SELECT transid FROM " . tablename('hc_credit_shopping_order') . " WHERE id = :id", array(':id' => $id));
				if (!empty($item['transid'])) {
					$this->changeWechatSend($id, 0, $_GPC['cancelreson']);
				}
				pdo_update(
					'hc_credit_shopping_order',
					array(
						'status' => 1,
						'remark' => $_GPC['remark'],
					),
					array('id' => $id)
				);
				message('取消发货操作成功！', referer(), 'success');
			}
			if (checksubmit('finish')) {
				pdo_update('hc_credit_shopping_order', array('status' => 3, 'remark' => $_GPC['remark']), array('id' => $id));
				message('订单操作成功！', referer(), 'success');
			}
			if (checksubmit('send')) {
				pdo_update('hc_credit_shopping_order', array('status' => 2, 'remark' => $_GPC['remark']), array('id' => $id));
				message('订单操作成功！', referer(), 'success');
			}

			if (checksubmit('cancel')) {
				pdo_update('hc_credit_shopping_order', array('status' => 1, 'remark' => $_GPC['remark']), array('id' => $id));
				message('取消完成订单操作成功！', referer(), 'success');
			}
			if (checksubmit('cancelpay')) {
				pdo_update('hc_credit_shopping_order', array('status' => 0, 'remark' => $_GPC['remark']), array('id' => $id));
				//设置库存
				$this->setOrderStock($id, false);
				//减少积分
				$this->setOrderCredit($id, false);

				message('取消订单付款操作成功！', referer(), 'success');
			}
			if (checksubmit('confrimpay')) {
				pdo_update('hc_credit_shopping_order', array('status' => 1, 'paytype' => 2, 'remark' => $_GPC['remark']), array('id' => $id));
				//设置库存
				$this->setOrderStock($id);
				//增加积分
				$this->setOrderCredit($id);
				message('确认订单付款操作成功！', referer(), 'success');
			}
			if (checksubmit('close')) {
				$item = pdo_fetch("SELECT transid FROM " . tablename('hc_credit_shopping_order') . " WHERE id = :id", array(':id' => $id));
				if (!empty($item['transid'])) {
					$this->changeWechatSend($id, 0, $_GPC['reson']);
				}
				pdo_update('hc_credit_shopping_order', array('status' => -1, 'remark' => $_GPC['remark']), array('id' => $id));
				message('订单关闭操作成功！', referer(), 'success');
			}
			if (checksubmit('open')) {
				pdo_update('hc_credit_shopping_order', array('status' => 0, 'remark' => $_GPC['remark']), array('id' => $id));
				message('开启订单操作成功！', referer(), 'success');
			}
			$dispatch = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_dispatch') . " WHERE id = :id", array(':id' => $item['dispatch']));
			if (!empty($dispatch) && !empty($dispatch['express'])) {
				$express = pdo_fetch("select * from " . tablename('hc_credit_shopping_express') . " WHERE id=:id limit 1", array(":id" => $dispatch['express']));
			}
			$item['user'] = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_address') . " WHERE id = {$item['addressid']}");
			$goods = pdo_fetchall("SELECT g.*, o.total,g.type,o.optionname,o.optionid,o.price as orderprice FROM " . tablename('hc_credit_shopping_order_goods') .
					" o left join " . tablename('hc_credit_shopping_goods') . " g on o.goodsid=g.id " . " WHERE o.orderid='{$id}'");
			$item['goods'] = $goods;
		} elseif ($operation == 'delete') {
			/*订单删除*/
			$orderid = intval($_GPC['id']);
			if (pdo_delete('hc_credit_shopping_order', array('id' => $orderid))) {
				message('订单删除成功', $this->createWebUrl('order', array('op' => 'display')), 'success');
			} else {
				message('订单不存在或已被删除', $this->createWebUrl('order', array('op' => 'display')), 'error');
			}
		}
		include $this->template('order');
	}
	//设置订单商品的库存 minus  true 减少  false 增加
	private function setOrderStock($id = '', $minus = true) {
		$goods = pdo_fetchall("SELECT g.id, g.title, g.thumb, g.unit, g.marketprice,g.total as goodstotal,o.total,o.optionid,g.sales FROM " . tablename('hc_credit_shopping_order_goods') . " o left join " . tablename('hc_credit_shopping_goods') . " g on o.goodsid=g.id "
				. " WHERE o.orderid='{$id}'");
		foreach ($goods as $item) {
			if ($minus) {
				//属性
				if (!empty($item['optionid'])) {
					pdo_query("update " . tablename('hc_credit_shopping_goods_option') . " set stock=stock-:stock where id=:id", array(":stock" => $item['total'], ":id" => $item['optionid']));
				}
				$data = array();
				if (!empty($item['goodstotal']) && $item['goodstotal'] != -1) {
					$data['total'] = $item['goodstotal'] - $item['total'];
				}
				$data['sales'] = $item['sales'] + $item['total'];
				pdo_update('hc_credit_shopping_goods', $data, array('id' => $item['id']));
			} else {
				//属性
				if (!empty($item['optionid'])) {
					pdo_query("update " . tablename('hc_credit_shopping_goods_option') . " set stock=stock+:stock where id=:id", array(":stock" => $item['total'], ":id" => $item['optionid']));
				}
				$data = array();
				if (!empty($item['goodstotal']) && $item['goodstotal'] != -1) {
					$data['total'] = $item['goodstotal'] + $item['total'];
				}
				$data['sales'] = $item['sales'] - $item['total'];
				pdo_update('hc_credit_shopping_goods', $data, array('id' => $item['id']));
			}
		}
	}


	//订单导出
	public function doWeborder_export(){
		global $_W,$_GPC;
		$time = $_GPC['starttime'];
		$starttime = strtotime($time['start']);
		$endtime = strtotime($time['end']);


		$list = pdo_fetchall( " SELECT o.*, g.goods_name, a.address, a.realname, a.mobile FROM ".tablename('hc_credit_shopping_order')." AS o LEFT JOIN ".tablename('hc_credit_shopping_address')." AS a ON o.addressid = a.id LEFT JOIN ".tablename('hc_credit_shopping_order_goods')." AS g ON o.id=g.orderid   WHERE o.createtime >='".$starttime."' AND o.createtime<='".$endtime."' " );
		
		$paytype = array (
				'0' => array('css' => 'default', 'name' => '未支付'),
				'1' => array('css' => 'danger','name' => '余额支付'),
				'2' => array('css' => 'info', 'name' => '在线支付'),
				'3' => array('css' => 'warning', 'name' => '货到付款'),
				'4' => array('css' => 'warning', 'name' => '积分支付')
		);
		$orderstatus = array (
				'-1' => array('css' => 'default', 'name' => '已取消'),
				'0' => array('css' => 'danger', 'name' => '待付款'),
				'1' => array('css' => 'info', 'name' => '待发货'),
				'2' => array('css' => 'warning', 'name' => '待收货'),
				'3' => array('css' => 'success', 'name' => '已完成')
		);
		foreach ($list as &$value) {
			$s = $value['status'];
			$value['statuscss'] = $orderstatus[$value['status']]['css'];
			$value['status'] = $orderstatus[$value['status']]['name'];
			if ($s < 1) {
				$value['css'] = $paytype[$s]['css'];
				$value['paytype'] = $paytype[$s]['name'];
				continue;
			}
			$value['css'] = $paytype[$value['paytype']]['css'];
			if ($value['paytype'] == 2) {
				if (empty($value['transid'])) {
					$value['paytype'] = '支付宝支付';
				} else {
					$value['paytype'] = '微信支付';
				}
			} else {
				$value['paytype'] = $paytype[$value['paytype']]['name'];
			}
		}

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		if (PHP_SAPI == 'cli')  die('This example should only be run from a Web Browser');
	
		require_once '../addons/hc_credit_shopping/hc_public/Classes/PHPExcel.php';

					
		 
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("火池网络")
									 ->setLastModifiedBy("火池网络")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");


		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', '订单号')
		            ->setCellValue('B1', '姓名')
		            ->setCellValue('C1', '电话')
		            ->setCellValue('D1', '支付方式')
		            ->setCellValue('E1', '花费积分')
		            ->setCellValue('F1', '状态')
		            ->setCellValue('G1', '下单时间')
		            ->setCellValue('H1', '商品名称')
		            ->setCellValue('I1', '地址');
		$i=2;
		$ii = 1;

		foreach($list as $item){
		$objPHPExcel->setActiveSheetIndex(0)			
		            ->setCellValue('A'.$i, $item['ordersn'])
		            ->setCellValue('B'.$i, $item['realname'])
		            ->setCellValue('C'.$i, $item['mobile'])
		            ->setCellValue('D'.$i, $item['paytype'])
		            ->setCellValue('E'.$i, $item['price'])
		            ->setCellValue('F'.$i, $item['status'])
		            ->setCellValue('G'.$i, date('Y-m-d H:i:s',$item['createtime']))
		            ->setCellValue('H'.$i, $item['goods_name'])
		            ->setCellValue('I'.$i, $item['address']);
		$i++;		
		$ii++;
		}					
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
		// Rename worksheet
		//$time=time();
		$objPHPExcel->getActiveSheet()->setTitle('积分商城订单：'.$time['start'].'————'.$time['end']);


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="积分商城订单：'.$time['start'].'————'.$time['end'].'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		exit;


	


		

	}




	public function doWebNotice() {
		global $_GPC, $_W;
		load()->func('tpl');
		$operation = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		$operation = in_array($operation, array('display')) ? $operation : 'display';
		$pindex = max(1, intval($_GPC['page']));
		$psize = 50;
		if (!empty($_GPC['date'])) {
			$starttime = strtotime($_GPC['date']['start']);
			$endtime = strtotime($_GPC['date']['end']) + 86399;
		} else {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}
		$where = " WHERE `weid` = :weid AND `createtime` >= :starttime AND `createtime` < :endtime";
		$paras = array(
			':weid' => $_W['uniacid'],
			':starttime' => $starttime,
			':endtime' => $endtime
		);
		$keyword = $_GPC['keyword'];
		if (!empty($keyword)) {
			$where .= " AND `feedbackid`=:feedbackid";
			$paras[':feedbackid'] = $keyword;
		}
		$type = empty($_GPC['type']) ? 0 : $_GPC['type'];
		$type = intval($type);
		if ($type != 0) {
			$where .= " AND `type`=:type";
			$paras[':type'] = $type;
		}
		$status = empty($_GPC['status']) ? 0 : intval($_GPC['status']);
		$status = intval($status);
		if ($status != -1) {
			$where .= " AND `status` = :status";
			$paras[':status'] = $status;
		}
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('hc_credit_shopping_feedback') . $where, $paras);
		$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_feedback') . $where . " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $paras);
		$pager = pagination($total, $pindex, $psize);
		$transids = array();
		foreach ($list as $row) {
			$transids[] = $row['transid'];
		}
		if (!empty($transids)) {
			$sql = "SELECT * FROM " . tablename('hc_credit_shopping_order') . " WHERE weid='{$_W['uniacid']}' AND transid IN ( '" . implode("','", $transids) . "' )";
			$orders = pdo_fetchall($sql, array(), 'transid');
		}
		$addressids = array();
		if(is_array($orders)){
			foreach ($orders as $transid => $order) {
				$addressids[] = $order['addressid'];
			}
		}
		$addresses = array();
		if (!empty($addressids)) {
			$sql = "SELECT * FROM " . tablename('hc_credit_shopping_address') . " WHERE weid='{$_W['uniacid']}' AND id IN ( '" . implode("','", $addressids) . "' )";
			$addresses = pdo_fetchall($sql, array(), 'id');
		}
		foreach ($list as &$feedback) {
			$transid = $feedback['transid'];
			$order = $orders[$transid];
			$feedback['order'] = $order;
			$addressid = $order['addressid'];
			$feedback['address'] = $addresses[$addressid];
		}
		include $this->template('notice');
	}
	
	public function getCartTotal() {
		global $_W;
		$cartotal = pdo_fetchcolumn("select sum(total) from " . tablename('hc_credit_shopping_cart') . " where weid = '{$_W['uniacid']}' and from_user='{$_W['fans']['from_user']}'");
		return empty($cartotal) ? 0 : $cartotal;
	}
	
	
	
	
	private function getFeedbackType($type) {
		$types = array(1 => '维权', 2 => '告警');
		return $types[intval($type)];
	}
	private function getFeedbackStatus($status) {
		$statuses = array('未解决', '用户同意', '用户拒绝');
		return $statuses[intval($status)];
	}
	public function doMobilelist() {
		global $_GPC, $_W;
		
		$this->check_bowser();
		$this->check_follow();
		$member = $this->check_member();
		$pindex = max(1, intval($_GPC['page']));
		$psize = 4;
		$condition = '';
		if (!empty($_GPC['ccate'])) {
			$cid = intval($_GPC['ccate']);
			$condition .= " AND ccate = '{$cid}'";
			$_GPC['pcate'] = pdo_fetchcolumn("SELECT parentid FROM " . tablename('hc_credit_shopping_category') . " WHERE id = :id", array(':id' => intval($_GPC['ccate'])));
		} elseif (!empty($_GPC['pcate'])) {
			$cid = intval($_GPC['pcate']);
			$condition .= " AND pcate = '{$cid}'";
		}
		if (!empty($_GPC['keyword'])) {
			$condition .= " AND title LIKE '%{$_GPC['keyword']}%'";
		}
		$children = array();
		$category = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_category') . " WHERE weid = '{$_W['uniacid']}' and enabled=1 ORDER BY parentid ASC, displayorder DESC", array(), 'id');
		foreach ($category as $index => $row) {
			if (!empty($row['parentid'])) {
				$children[$row['parentid']][$row['id']] = $row;
				unset($category[$index]);
			}
		}
		$recommandcategory = array();
		foreach ($category as &$c) {
			if ($c['isrecommand'] == 1) {
				$c['list'] = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_goods') . " WHERE weid = '{$_W['uniacid']}' and deleted=0 AND status = '1'  and pcate='{$c['id']}'  ORDER BY displayorder DESC, sales DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
				$c['total'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hc_credit_shopping_goods') . " WHERE weid = '{$_W['uniacid']}'  and deleted=0  AND status = '1' and pcate='{$c['id']}'");
				$c['pager'] = pagination($c['total'], $pindex, $psize, $url = '', $context = array('before' => 0, 'after' => 0, 'ajaxcallback' => ''));
				$recommandcategory[] = $c;
			}
			if (!empty($children[$c['id']])) {
				foreach ($children[$c['id']] as &$child) {
					if ($child['isrecommand'] == 1) {
						$child['list'] = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_goods') . " WHERE weid = '{$_W['uniacid']}'  and deleted=0 AND status = '1'  and pcate='{$c['id']}' and ccate='{$child['id']}'  ORDER BY displayorder DESC, sales DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
						$child['total'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hc_credit_shopping_goods') . " WHERE weid = '{$_W['uniacid']}'  and deleted=0  AND status = '1' and pcate='{$c['id']}' and ccate='{$child['id']}' ");
						$child['pager'] = pagination($child['total'], $pindex, $psize, $url = '', $context = array('before' => 0, 'after' => 0, 'ajaxcallback' => ''));
						$recommandcategory[] = $child;
					}
				}
				unset($child);
			}
		}
		unset($c);
		$carttotal = $this->getCartTotal();
		//幻灯片
		$advs = pdo_fetchall("select * from " . tablename('hc_credit_shopping_adv') . " where enabled=1 and weid= '{$_W['uniacid']}' ORDER BY `displayorder` DESC ");
		foreach ($advs as &$adv) {
			if (substr($adv['link'], 0, 5) != 'http:') {
				$adv['link'] = "http://" . $adv['link'];
			}
		}
		unset($adv);
		//首页推荐
		$rpindex = max(1, intval($_GPC['rpage']));
		$rpsize = 40;
		$condition = ' and isrecommand=1';
		$rlist = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_goods') . " WHERE weid = '{$_W['uniacid']}'  and deleted=0 AND status = '1' AND goods_status=0 $condition ORDER BY displayorder DESC, sales DESC LIMIT " . ($rpindex - 1) * $rpsize . ',' . $rpsize);
		$rhot = pdo_fetchall( " SELECT * FROM ".tablename('hc_credit_shopping_goods')." WHERE weid=".$_W['uniacid']." AND deleted=0 AND isnew =1 AND status =1 order by rand() LIMIT 3 " );
		$piclist = pdo_fetchall("select * from " . tablename('hc_credit_shopping_adv') . " where enabled=1 and weid= '{$_W['uniacid']}' ORDER BY `displayorder` DESC ");
		//寻找倒计时商品
		$setting = $this->module['config'];
		$temp = TIMESTAMP - $setting['countdown'] * 60;
		$countdown = pdo_fetchall( " SELECT * FROM " . tablename('hc_credit_shopping_goods') . " WHERE weid = '{$_W['uniacid']}'  and deleted=0 AND status = '1' AND goods_status=1 AND ticket_time > $temp LIMIT 6 " );
		
		
	//	include $this->template('list-bak');
		include $this->template('list');
	}
	
	//倒计时商品到期查询
	public function doMobilecountdown_query(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		
		$ret = array(
			'success' => true,
		);
		if(empty($id)){
			$ret['error'] = 'error';
			$ret['message'] ='查询商品id为空，查询失败' ;
		}else{
			$setting = $this->module['config'];
			$query = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_goods')." WHERE id='".$id."' " );
			$temp = $query['ticket_time'] + $setting['countdown'] * 60;
			if($temp > TIMESTAMP){
				$ret['error'] = 'error';
				$ret['message'] ='还未到商品开奖时间' ;
			}else{
				$ret['nickname'] = $query['ticket_nickname'];
			}
		}
		 echo json_encode($ret);
         exit();
		
	}
	//倒计时商品到期查询
	public function doMobiledetail_countdown_query(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		
		$ret = array(
			'success' => true,
		);
		if(empty($id)){
			$ret['error'] = 'error';
			$ret['message'] ='查询商品id为空，查询失败' ;
		}else{
			$setting = $this->module['config'];
			$query = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_goods')." WHERE id='".$id."' " );
			$temp = $query['ticket_time'] + $setting['countdown'] * 60;
			if($temp > TIMESTAMP){
				$ret['error'] = 'error';
				$ret['message'] ='还未到商品开奖时间' ;
			}else{
				$award_openid = pdo_fetchcolumn( " SELECT openid FROM ".tablename('hc_credit_shopping_ticket')." WHERE ticket = '".$query['ticket']."' " );
				$award_member = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_member')." WHERE openid='".$award_openid."' AND weid=".$_W['uniacid']." " );
				$award_total = pdo_fetchcolumn( " SELECT COUNT(id) FROM ".tablename('hc_credit_shopping_ticket')." WHERE openid='".$award_openid."' AND goodsid='".$id."' "  );
				$createtime = date('Y-m-d H:i:s',$temp);
				$ret['nickname'] = $query['ticket_nickname'];
				$ret['ticket'] = $query['ticket'];
				$ret['createtime'] = $createtime;
				$ret['province'] = $award_member['province'];
				$ret['headimg'] = $award_member['headimg'];
				$ret['city'] = $award_member['city'];
				$ret['award_total'] = $award_total;
			}
		}
		 echo json_encode($ret);
         exit();
		
	}
	
	
	public function doMobilelistmore_rec() {
		global $_GPC, $_W;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 4;
		$condition = ' and isrecommand=1 ';
		$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_goods') . " WHERE weid = '{$_W['uniacid']}'  and deleted=0 AND status = '1' $condition ORDER BY displayorder DESC, sales DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		include $this->template('list_more');
	}
	public function doMobilelistmore() {
		global $_GPC, $_W;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 4;
		$condition = '';
		$params = array(':weid' => $_W['uniacid']);
		$cid = intval($_GPC['ccate']);
		if (empty($cid)) {
			return NULL;
		}

		$catePid = $_GPC['pcate'];
		if (empty($catePid)) {
			$condition .= ' AND `pcate` = :pcate';
			$params[':pcate'] = $cid;
		} else {
			$condition .= ' AND `ccate` = :ccate';
			$params[':ccate'] = $cid;
		}


		$sql = 'SELECT * FROM ' . tablename('hc_credit_shopping_goods') . ' WHERE `weid` = :weid AND `deleted` = :deleted AND `status` = :status ' . $condition .
				' ORDER BY `displayorder` DESC, `sales` DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$params[':deleted'] = 0;
		$params[':status'] = 1;
		$list = pdo_fetchall($sql, $params);

		include $this->template('list_more');

	}
	public function doMobilelist2() {
		global $_GPC, $_W;
		$pindex = max(1, intval($_GPC["page"]));
		$psize = 10;
		$condition = '';
		if (!empty($_GPC['ccate'])) {
			$cid = intval($_GPC['ccate']);
			$condition .= " AND ccate = '{$cid}'";
			$_GPC['pcate'] = pdo_fetchcolumn("SELECT parentid FROM " . tablename('hc_credit_shopping_category') . " WHERE id = :id", array(':id' => intval($_GPC['ccate'])));
		} elseif (!empty($_GPC['pcate'])) {
			$cid = intval($_GPC['pcate']);
			$condition .= " AND pcate = '{$cid}'";
		}
		if (!empty($_GPC['keyword'])) {
			$condition .= " AND title LIKE '%{$_GPC['keyword']}%'";
		}
		$sort = empty($_GPC['sort']) ? 0 : $_GPC['sort'];
		$sortfield = "displayorder asc";
		$sortb0 = empty($_GPC['sortb0']) ? "desc" : $_GPC['sortb0'];
		$sortb1 = empty($_GPC['sortb1']) ? "desc" : $_GPC['sortb1'];
		$sortb2 = empty($_GPC['sortb2']) ? "desc" : $_GPC['sortb2'];
		$sortb3 = empty($_GPC['sortb3']) ? "asc" : $_GPC['sortb3'];
		if ($sort == 0) {
			$sortb00 = $sortb0 == "desc" ? "asc" : "desc";
			$sortfield = "createtime " . $sortb0;
			$sortb11 = "desc";
			$sortb22 = "desc";
			$sortb33 = "asc";
		} else if ($sort == 1) {
			$sortb11 = $sortb1 == "desc" ? "asc" : "desc";
			$sortfield = "sales " . $sortb1;
			$sortb00 = "desc";
			$sortb22 = "desc";
			$sortb33 = "asc";
		} else if ($sort == 2) {
			$sortb22 = $sortb2 == "desc" ? "asc" : "desc";
			$sortfield = "viewcount " . $sortb2;
			$sortb00 = "desc";
			$sortb11 = "desc";
			$sortb33 = "asc";
		} else if ($sort == 3) {
			$sortb33 = $sortb3 == "asc" ? "desc" : "asc";
			$sortfield = "marketprice " . $sortb3;
			$sortb00 = "desc";
			$sortb11 = "desc";
			$sortb22 = "desc";
		}
		$sorturl = $this->createMobileUrl('list2', array("keyword" => $_GPC['keyword'], "pcate" => $_GPC['pcate'], "ccate" => $_GPC['ccate']), true);
		if (!empty($_GPC['isnew'])) {
			$condition .= " AND isnew = 1";
			$sorturl.="&isnew=1";
		}
		if (!empty($_GPC['ishot'])) {
			$condition .= " AND ishot = 1";
			$sorturl.="&ishot=1";
		}
		if (!empty($_GPC['isdiscount'])) {
			$condition .= " AND isdiscount = 1";
			$sorturl.="&isdiscount=1";
		}
		if (!empty($_GPC['istime'])) {
			$condition .= " AND istime = 1 and " . time() . ">=timestart and " . time() . "<=timeend";
			$sorturl.="&istime=1";
		}




		if($_GPC['ajax'] == 'ajax'){
			$page = intval($_GPC['page']);
			$page = $page * $psize;
			$ret = array(
			'success' => true,
			'page' => $page,
			'sql' =>$page ,
			);
			$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_goods') . " WHERE weid = '{$_W['uniacid']}'  and deleted=0 AND status = '1' AND goods_status !=1 $condition ORDER BY $sortfield LIMIT " . $page . ",".$psize );
			$ret['goods'] = $list;
			if(empty($list)){
				$ret['emp'] = 5;
			}
		 echo json_encode($ret);
         exit();
		}









		$children = array();
		$category = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_category') . " WHERE weid = '{$_W['uniacid']}' and enabled=1 ORDER BY parentid ASC, displayorder DESC", array(), 'id');
		foreach ($category as $index => $row) {
			if (!empty($row['parentid'])) {
				$children[$row['parentid']][$row['id']] = $row;
				unset($category[$index]);
			}
		}
		$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_goods') . " WHERE weid = '{$_W['uniacid']}'  and deleted=0 AND status = '1' AND goods_status !=1 $condition ORDER BY $sortfield LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		foreach ($list as &$r) {
			if ($r['istime'] == 1) {
				$arr = $this->time_tran($r['timeend']);
				$r['timelaststr'] = $arr[0];
				$r['timelast'] = $arr[1];
			}
		}
		unset($r);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hc_credit_shopping_goods') . " WHERE weid = '{$_W['uniacid']}'  and deleted=0  AND status = '1' $condition");
		$pager = pagination($total, $pindex, $psize, $url = '', $context = array('before' => 0, 'after' => 0, 'ajaxcallback' => ''));
		$carttotal = $this->getCartTotal();
		include $this->template('list2');
	}
	function time_tran($the_time) {
		$timediff = $the_time - time();
		$days = intval($timediff / 86400);
		if (strlen($days) <= 1) {
			$days = "0" . $days;
		}
		$remain = $timediff % 86400;
		$hours = intval($remain / 3600);
		;
		if (strlen($hours) <= 1) {
			$hours = "0" . $hours;
		}
		$remain = $remain % 3600;
		$mins = intval($remain / 60);
		if (strlen($mins) <= 1) {
			$mins = "0" . $mins;
		}
		$secs = $remain % 60;
		if (strlen($secs) <= 1) {
			$secs = "0" . $secs;
		}
		$ret = "";
		if ($days > 0) {
			$ret.=$days . " 天 ";
		}
		if ($hours > 0) {
			$ret.=$hours . ":";
		}
		if ($mins > 0) {
			$ret.=$mins . ":";
		}
		$ret.=$secs;
		return array("倒计时 " . $ret, $timediff);
	}
	public function doMobileMyCart() {
		global $_W, $_GPC;
		$this->checkAuth();
		$op = $_GPC['op'];
		if ($op == 'add') {
			$goodsid = intval($_GPC['id']);
			$total = intval($_GPC['total']);
			$total = empty($total) ? 1 : $total;
			$optionid = intval($_GPC['optionid']);
			$goods = pdo_fetch("SELECT id, type, total,marketprice,maxbuy FROM " . tablename('hc_credit_shopping_goods') . " WHERE id = :id", array(':id' => $goodsid));
			if (empty($goods)) {
				$result['message'] = '抱歉，该商品不存在或是已经被删除！';
				message($result, '', 'ajax');
			}
			$marketprice = $goods['marketprice'];
			if (!empty($optionid)) {
				$option = pdo_fetch("select marketprice from " . tablename('hc_credit_shopping_goods_option') . " where id=:id limit 1", array(":id" => $optionid));
				if (!empty($option)) {
					$marketprice = $option['marketprice'];
				}
			}
			$row = pdo_fetch("SELECT id, total FROM " . tablename('hc_credit_shopping_cart') . " WHERE from_user = :from_user AND weid = '{$_W['uniacid']}' AND goodsid = :goodsid  and optionid=:optionid", array(':from_user' => $_W['fans']['from_user'], ':goodsid' => $goodsid,':optionid'=>$optionid));
			if ($row == false) {
				//不存在
				$data = array(
					'weid' => $_W['uniacid'],
					'goodsid' => $goodsid,
					'goodstype' => $goods['type'],
					'marketprice' => $marketprice,
					'from_user' => $_W['fans']['from_user'],
					'total' => $total,
					'optionid' => $optionid
				);
				pdo_insert('hc_credit_shopping_cart', $data);
			} else {
				//累加最多限制购买数量
				$t = $total + $row['total'];
				if (!empty($goods['maxbuy'])) {
					if ($t > $goods['maxbuy']) {
						$t = $goods['maxbuy'];
					}
				}
				//存在
				$data = array(
					'marketprice' => $marketprice,
					'total' => $t,
					'optionid' => $optionid
				);
				pdo_update('hc_credit_shopping_cart', $data, array('id' => $row['id']));
			}
			//返回数据
			$carttotal = $this->getCartTotal();
			$result = array(
				'result' => 1,
				'total' => $carttotal
			);
			die(json_encode($result));
		} else if ($op == 'clear') {
			pdo_delete('hc_credit_shopping_cart', array('from_user' => $_W['fans']['from_user'], 'weid' => $_W['uniacid']));
			die(json_encode(array("result" => 1)));
		} else if ($op == 'remove') {
			$id = intval($_GPC['id']);
			pdo_delete('hc_credit_shopping_cart', array('from_user' => $_W['fans']['from_user'], 'weid' => $_W['uniacid'], 'id' => $id));
			die(json_encode(array("result" => 1, "cartid" => $id)));
		} else if ($op == 'update') {
			$id = intval($_GPC['id']);
			$num = intval($_GPC['num']);
			$sql = "update " . tablename('hc_credit_shopping_cart') . " set total=$num where id=:id";
			pdo_query($sql, array(":id" => $id));
			die(json_encode(array("result" => 1)));
		} else {
			$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_cart') . " WHERE  weid = '{$_W['uniacid']}' AND from_user = '{$_W['fans']['from_user']}'");
			$totalprice = 0;
			if (!empty($list)) {
				foreach ($list as &$item) {
					$goods = pdo_fetch("SELECT  title, thumb, marketprice, unit, total,maxbuy FROM " . tablename('hc_credit_shopping_goods') . " WHERE id=:id limit 1", array(":id" => $item['goodsid']));
					//属性
					$option = pdo_fetch("select title,marketprice,stock from " . tablename("hc_credit_shopping_goods_option") . " where id=:id limit 1", array(":id" => $item['optionid']));
					if ($option) {
						$goods['title'] = $goods['title'];
						$goods['optionname'] = $option['title'];
						$goods['marketprice'] = $option['marketprice'];
						$goods['total'] = $option['stock'];
					}
					$item['goods'] = $goods;
					$item['totalprice'] = (floatval($goods['marketprice']) * intval($item['total']));
					$totalprice += $item['totalprice'];
				}
				unset($item);
			}
			include $this->template('cart');
		}
	}
	public function doMobileConfirm() {
		global $_W, $_GPC;
		checkauth();
		$totalprice = 0;
		$allgoods = array();
		$id = intval($_GPC['id']);
		$optionid = intval($_GPC['optionid']);
		$total = intval($_GPC['total']);
		if ( (empty($total)) || ($total < 1) ) {
			$total = 1;
		}
		$direct = false; //是否是直接购买
		$returnurl = ""; //当前连接
		if (!empty($id)) {
			$sql = 'SELECT `id`, `thumb`, `title`, `weight`, `marketprice`, `total`, `type`, `totalcnf`, `sales`, `unit`, `istime`, `timeend`, `usermaxbuy`
					FROM ' .tablename('hc_credit_shopping_goods') . ' WHERE `id` = :id';
			$item = pdo_fetch($sql, array(':id' => $id));

			if (empty($item)) {
				message('商品不存在或已经下架', $this->createMobileUrl('detail', array('id' => $id)), 'error');
			}
			if ($item['istime'] == 1) {
				if (time() > $item['timeend']) {
					$backUrl = $this->createMobileUrl('detail', array('id' => $id));
					$backUrl = $_W['siteroot'] . 'app' . ltrim($backUrl, '.');
					message('抱歉，商品限购时间已到，无法购买了！', $backUrl, "error");
				}
			}
			if ($item['total'] - $total < 0) {
				message('抱歉，[' . $item['title'] . ']库存不足！', $this->createMobileUrl('confirm'), 'error');
			}

			if (!empty($optionid)) {
				$option = pdo_fetch("select title,marketprice,weight,stock from " . tablename("hc_credit_shopping_goods_option") . " where id=:id limit 1", array(":id" => $optionid));
				if ($option) {
					$item['optionid'] = $optionid;
					$item['title'] = $item['title'];
					$item['optionname'] = $option['title'];
					$item['marketprice'] = $option['marketprice'];
					$item['weight'] = $option['weight'];
				}
			}
			$item['stock'] = $item['total'];
			$item['total'] = $total;
			$item['totalprice'] = $total * $item['marketprice'];
			$allgoods[] = $item;
			$totalprice += $item['totalprice'];
			if ($item['type'] == 1) {
				$needdispatch = true;
			}
			$direct = true;

			// 检查用户最多购买数量
			$sql = 'SELECT SUM(`og`.`total`) AS `orderTotal` FROM ' . tablename('hc_credit_shopping_order_goods') . ' AS `og` JOIN ' . tablename('hc_credit_shopping_order') .
				' AS `o` ON `og`.`orderid` = `o`.`id` WHERE `og`.`goodsid` = :goodsid AND `o`.`from_user` = :from_user';
			$params = array(':goodsid' => $id, ':from_user' => $_W['fans']['from_user']);
			$orderTotal = pdo_fetchcolumn($sql, $params);
			if ( (($orderTotal + $item['total']) > $item['usermaxbuy']) && (!empty($item['usermaxbuy']))) {
				message('您已经超过购买数量了', $this->createMobileUrl('detail', array('id' => $id)), 'error');
			}

			$returnurl = $this->createMobileUrl("confirm", array("id" => $id, "optionid" => $optionid, "total" => $total));
		}
		if (!$direct) {
			//如果不是直接购买（从购物车购买）
			$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_cart') . " WHERE  weid = '{$_W['uniacid']}' AND from_user = '{$_W['fans']['from_user']}'");
			if (!empty($list)) {
				foreach ($list as &$g) {
					$item = pdo_fetch("select id,thumb,title,weight,marketprice,total,type,totalcnf,sales,unit from " . tablename("hc_credit_shopping_goods") . " where id=:id limit 1", array(":id" => $g['goodsid']));
					//属性
					$option = pdo_fetch("select title,marketprice,weight,stock from " . tablename("hc_credit_shopping_goods_option") . " where id=:id limit 1", array(":id" => $g['optionid']));
					if ($option) {
						$item['optionid'] = $g['optionid'];
						$item['title'] = $item['title'];
						$item['optionname'] = $option['title'];
						$item['marketprice'] = $option['marketprice'];
						$item['weight'] = $option['weight'];
					}
					$item['stock'] = $item['total'];
					$item['total'] = $g['total'];
					$item['totalprice'] = $g['total'] * $item['marketprice'];
					$allgoods[] = $item;
					$totalprice += $item['totalprice'];
					if ($item['type'] == 1) {
						$needdispatch = true;
					}
				}
				unset($g);
			}
			$returnurl = $this->createMobileUrl("confirm");
		}
		if (count($allgoods) <= 0) {
		//	header("location: " . $this->createMobileUrl('myorder'));
		//	exit();
		}

		//配送方式
		$dispatch = pdo_fetchall("select id,dispatchname,dispatchtype,firstprice,firstweight,secondprice,secondweight from " . tablename("hc_credit_shopping_dispatch") . " WHERE weid = {$_W['uniacid']} order by displayorder desc");
		foreach ($dispatch as &$d) {
			$weight = 0;
			foreach ($allgoods as $g) {
				$weight += $g['weight'] * $g['total'];
			}
			$price = 0;
			if ($weight <= $d['firstweight']) {
				$price = $d['firstprice'];
			} else {
				$price = $d['firstprice'];
				$secondweight = $weight - $d['firstweight'];
				if ($secondweight % $d['secondweight'] == 0) {
					$price += (int)($secondweight / $d['secondweight']) * $d['secondprice'];
				} else {
					$price += (int)($secondweight / $d['secondweight'] + 1) * $d['secondprice'];
				}
			}
			$d['price'] = $price;
		}
		unset($d);

		if (checksubmit('submit')) {
			// 是否自提
			$sendtype = 1;
			$address = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_address') . " WHERE id = :id", array(':id' => intval($_GPC['address'])));
			if (empty($address)) {
				message('抱歉，请您填写收货地址！');
			}
			// 商品价格
			$goodsprice = 0;
			foreach ($allgoods as $row) {
				$goodsprice += $row['total'];
			}
			// 运费
			$dispatchid = intval($_GPC['dispatch']);
			$dispatchprice = 0;
			foreach ($dispatch as $d) {
				if ($d['id'] == $dispatchid) {
					$dispatchprice = $d['price'];
					$sendtype = $d['dispatchtype'];
				}
			}

			$data = array(
				'weid' => $_W['uniacid'],
				'from_user' => $_W['fans']['from_user'],
				'ordersn' => date('md') . random(4, 1),
				'price' => $goodsprice,
				'dispatchprice' => $dispatchprice,
				'goodsprice' => $goodsprice,
				'status' => 0,
				'sendtype' => intval($sendtype),
				'dispatch' => $dispatchid,
				'goodstype' => intval($item['type']),
				'remark' => $_GPC['remark'],
				'addressid' => $address['id'],
				'createtime' => TIMESTAMP
			);

			pdo_insert('hc_credit_shopping_order', $data);
			$orderid = pdo_insertid();
			//插入订单商品
			foreach ($allgoods as $row) {
				if (empty($row)) {
					continue;
				}
				$d = array(
					'weid' => $_W['uniacid'],
					'goodsid' => $row['id'],
					'from_user' => $_W['fans']['from_user'],
					'orderid' => $orderid,
					'total' => $row['total'],
					'price' => $row['marketprice'],
					'createtime' => TIMESTAMP,
					'optionid' => $row['optionid']
				);
				$o = pdo_fetch("select title from " . tablename('hc_credit_shopping_goods_option') . " where id=:id limit 1", array(":id" => $row['optionid']));
				if (!empty($o)) {
					$d['optionname'] = $o['title'];
				}
				pdo_insert('hc_credit_shopping_order_goods', $d);
			}
			// 清空购物车
			if (!$direct) {
				pdo_delete("hc_credit_shopping_cart", array("weid" => $_W['uniacid'], "from_user" => $_W['fans']['from_user']));
			}
			// 变更商品库存
			if (empty($item['totalcnf'])) {
				$this->setOrderStock($orderid);
			}
			message('提交订单成功,现在跳转到付款页面...', $this->createMobileUrl('pay', array('orderid' => $orderid)), 'success');
		}
		$carttotal = $this->getCartTotal();
		$profile = fans_search($_W['fans']['from_user'], array('resideprovince', 'residecity', 'residedist', 'address', 'realname', 'mobile'));
		$row = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_address') . " WHERE isdefault = 1 and openid = :openid limit 1", array(':openid' => $_W['fans']['from_user']));
		include $this->template('confirm');
	}
	
	

	//设置订单积分
	public function setOrderCredit($orderid, $add = true) {
		global $_W;
		$order = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_order') . " WHERE id = :id limit 1", array(':id' => $orderid));
		if (empty($order)) {
			return false;
		}
		$sql = 'SELECT `goodsid`, `total` FROM ' . tablename('hc_credit_shopping_order_goods') . ' WHERE `orderid` = :orderid';
		$orderGoods = pdo_fetchall($sql, array(':orderid' => $orderid));
		if (!empty($orderGoods)) {
			$credit = 0;
			$sql = 'SELECT `credit` FROM ' . tablename('hc_credit_shopping_goods') . ' WHERE `id` = :id';
			foreach ($orderGoods as $goods) {
				$goodsCredit = pdo_fetchcolumn($sql, array(':id' => $goods['goodsid']));
				$credit += $goodsCredit * $goods['total'];
			}
		}
		//增加积分
		if (!empty($credit)) {
			load()->model('mc');
			load()->func('compat.biz');
			$uid = mc_openid2uid($order['from_user']);
			$fans = fans_search($uid, array("credit1"));
			if (!empty($fans)) {
				if (!empty($add)) {
					mc_credit_update($_W['member']['uid'], 'credit1', $credit, array('0' => $_W['member']['uid'], '购买商品赠送'));
				} else {
					mc_credit_update($_W['member']['uid'], 'credit1', 0 - $credit, array('0' => $_W['member']['uid'], '微商城操作'));
				}
			}
		}
	}
	public function doMobilePay() {
		global $_W, $_GPC;
		$this->checkAuth();
		$orderid = intval($_GPC['orderid']);
		$order = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_order') . " WHERE id = :id", array(':id' => $orderid));
		if ($order['status'] != '0') {
			message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', $this->createMobileUrl('myorder'), 'error');
		}
		if (checksubmit('codsubmit')) {
			$ordergoods = pdo_fetchall("SELECT goodsid, total,optionid FROM " . tablename('hc_credit_shopping_order_goods') . " WHERE orderid = '{$orderid}'", array(), 'goodsid');
			if (!empty($ordergoods)) {
				$goods = pdo_fetchall("SELECT id, title, thumb, marketprice, unit, total,credit FROM " . tablename('hc_credit_shopping_goods') . " WHERE id IN ('" . implode("','", array_keys($ordergoods)) . "')");
			}
			//邮件提醒
			if (!empty($this->module['config']['noticeemail'])) {
				$address = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_address') . " WHERE id = :id", array(':id' => $order['addressid']));
				$body = "<h3>购买商品清单</h3> <br />";
				if (!empty($goods)) {
					foreach ($goods as $row) {
						//属性
						$option = pdo_fetch("select title,marketprice,weight,stock from " . tablename("hc_credit_shopping_goods_option") . " where id=:id limit 1", array(":id" => $ordergoods[$row['id']]['optionid']));
						if ($option) {
							$row['title'] = "[" . $option['title'] . "]" . $row['title'];
						}
						$body .= "名称：{$row['title']} ，数量：{$ordergoods[$row['id']]['total']} <br />";
					}
				}
				$paytype = $order['paytype']=='3'?'货到付款':'已付款';
				$body .= "<br />总金额：{$order['price']}元 （{$paytype}）<br />";
				$body .= "<h3>购买用户详情</h3> <br />";
				$body .= "真实姓名：$address[realname] <br />";
				$body .= "地区：$address[province] - $address[city] - $address[area]<br />";
				$body .= "详细地址：$address[address] <br />";
				$body .= "手机：$address[mobile] <br />";
				load()->func('communication');
				ihttp_email($this->module['config']['noticeemail'], '微商城订单提醒', $body);
			}
			pdo_update('hc_credit_shopping_order', array('status' => '1', 'paytype' => '3'), array('id' => $orderid));
			message('订单提交成功，请您收到货时付款！', $this->createMobileUrl('myorder'), 'success');
		}
		if (checksubmit()) {
			if ($order['paytype'] == 1 && $_W['fans']['credit2'] < $order['price']) {
				message('抱歉，您帐户的余额不够支付该订单，请充值！', create_url('mobile/module/charge', array('name' => 'member', 'weid' => $_W['uniacid'])), 'error');
			}
			if ($order['price'] == '0') {
				$this->payResult(array('tid' => $orderid, 'from' => 'return', 'type' => 'credit2'));
				exit;
			}
		}
		// 商品编号
		$sql = 'SELECT `goodsid` FROM ' . tablename('hc_credit_shopping_order_goods') . " WHERE `orderid` = :orderid";
		$goodsId = pdo_fetchcolumn($sql, array(':orderid' => $orderid));
		// 商品名称
		$sql = 'SELECT `title` FROM ' . tablename('hc_credit_shopping_goods') . " WHERE `id` = :id";
		$goodsTitle = pdo_fetchcolumn($sql, array(':id' => $goodsId));

		$params['tid'] = $orderid;
		$params['user'] = $_W['fans']['from_user'];
		$params['fee'] = $order['price'];
		$params['title'] = $goodsTitle;
		$params['ordersn'] = $order['ordersn'];
		$params['virtual'] = $order['goodstype'] == 2 ? true : false;

		include $this->template('pay');
	}
	public function doMobileContactUs() {
		global $_W;
		$cfg = $this->module['config'];
		include $this->template('contactus');
	}

	public function doMobileMyOrder() {
		global $_W, $_GPC;
		$this->checkAuth();
		$op = $_GPC['op'];
		
		if(empty($op) || $op == 2){
			$op = 2;
			$order = pdo_fetchall( " SELECT * FROM ".tablename('hc_credit_shopping_order')." WHERE from_user='".$_W['openid']."' AND weid='".$_W['uniacid']."' AND paytype !=9 AND status >=1 AND status <=2 group by createtime desc" );
		}
		if($op == 1){
			$order = pdo_fetchall( " SELECT * FROM ".tablename('hc_credit_shopping_order')." WHERE from_user='".$_W['openid']."' AND weid='".$_W['uniacid']."' AND paytype !=9 group by createtime desc" );
		}
		if($op == 3){
			$order = pdo_fetchall( " SELECT * FROM ".tablename('hc_credit_shopping_order')." WHERE from_user='".$_W['openid']."' AND weid='".$_W['uniacid']."' AND paytype !=9 AND status=3 group by createtime desc" );
		}


		$goods_detail = array();
		if(!empty($order)){
			foreach ($order as $key => $value) {
				$order_detail = pdo_fetchall( " SELECT * FROM ".tablename('hc_credit_shopping_order_goods')." WHERE orderid='".$value['id']."' " );
				$goods_detail[$value['id']] = $order_detail;
				
			}

		}
		
		$order_goods = pdo_fetchall( " SELECT distinct orderid, id, goodsid FROM ".tablename('hc_credit_shopping_order_goods')." WHERE from_user='".$_W['openid']."' AND weid=".$_W['uniacid']);
		$order_good = array();
		foreach($order_goods as $ogs){
			$order_good[$ogs['orderid']] = $ogs['goodsid'];
		}
		
		if($op == 'finish_order'){
			$order_id = intval($_GPC['orderid']);
			$order = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_order')." WHERE id='".$order_id."' AND from_user='".$_W['openid']."' " );
			if(!empty($order)){
				pdo_update('hc_credit_shopping_order',array('status'=>3),array('id'=>$order['id']));
				message('收货成功',$this->createMobileUrl('myorder',array('op'=>3)),'success');
			}
		}


		include $this->template('test_order');
	//	include $this->template('order');
	}

	public function doMobiletestOrder() {
		global $_W, $_GPC;
		$this->checkAuth();
		$op = $_GPC['op'];
		if ($op == 'confirm') {
			$orderid = intval($_GPC['orderid']);
			$order = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_order') . " WHERE id = :id AND from_user = :from_user", array(':id' => $orderid, ':from_user' => $_W['fans']['from_user']));
			if (empty($order)) {
				message('抱歉，您的订单不存或是已经被取消！', $this->createMobileUrl('myorder'), 'error');
			}
			pdo_update('hc_credit_shopping_order', array('status' => 3), array('id' => $orderid, 'from_user' => $_W['fans']['from_user']));
			message('确认收货完成！', $this->createMobileUrl('myorder'), 'success');
		} else if ($op == 'detail') {
			$orderid = intval($_GPC['orderid']);
			$item = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_order') . " WHERE weid = '{$_W['uniacid']}' AND from_user = '{$_W['fans']['from_user']}' and id='{$orderid}' limit 1");
			if (empty($item)) {
				message('抱歉，您的订单不存或是已经被取消！', $this->createMobileUrl('myorder'), 'error');
			}
			$goodsid = pdo_fetch("SELECT goodsid,total FROM " . tablename('hc_credit_shopping_order_goods') . " WHERE orderid = '{$orderid}'", array(), 'goodsid');
			$goods = pdo_fetchall("SELECT g.id, g.title, g.thumb, g.unit, g.marketprice, o.total,o.optionid FROM " . tablename('hc_credit_shopping_order_goods')
					. " o left join " . tablename('hc_credit_shopping_goods') . " g on o.goodsid=g.id " . " WHERE o.orderid='{$orderid}'");
			foreach ($goods as &$g) {
				//属性
				$option = pdo_fetch("select title,marketprice,weight,stock from " . tablename("hc_credit_shopping_goods_option") . " where id=:id limit 1", array(":id" => $g['optionid']));
				if ($option) {
					$g['title'] = "[" . $option['title'] . "]" . $g['title'];
					$g['marketprice'] = $option['marketprice'];
				}
			}
			unset($g);
			$dispatch = pdo_fetch("select id,dispatchname from " . tablename('hc_credit_shopping_dispatch') . " where id=:id limit 1", array(":id" => $item['dispatch']));
			//var_dump($item);
			include $this->template('order_detail');
		} else {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$status = intval($_GPC['status']);
			$where = " weid = '{$_W['uniacid']}' AND from_user = '{$_W['fans']['from_user']}'";
			if ($status == 2) {
				$where.=" and ( status=1 or status=2 )";
			} else {
				$where.=" and status=$status";
			}
			$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_order') . " WHERE $where ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(), 'id');
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hc_credit_shopping_order') . " WHERE weid = '{$_W['uniacid']}' AND from_user = '{$_W['fans']['from_user']}'");
			$pager = pagination($total, $pindex, $psize);
			if (!empty($list)) {
				foreach ($list as &$row) {
					$goodsid = pdo_fetchall("SELECT goodsid,total FROM " . tablename('hc_credit_shopping_order_goods') . " WHERE orderid = '{$row['id']}'", array(), 'goodsid');
					$goods = pdo_fetchall("SELECT g.id, g.title, g.thumb, g.unit, g.marketprice,o.total,o.optionid FROM " . tablename('hc_credit_shopping_order_goods') . " o left join " . tablename('hc_credit_shopping_goods') . " g on o.goodsid=g.id "
							. " WHERE o.orderid='{$row['id']}'");
					foreach ($goods as &$item) {
						//属性
						$option = pdo_fetch("select title,marketprice,weight,stock from " . tablename("hc_credit_shopping_goods_option") . " where id=:id limit 1", array(":id" => $item['optionid']));
						if ($option) {
							$item['title'] = "[" . $option['title'] . "]" . $item['title'];
							$item['marketprice'] = $option['marketprice'];
						}
					}
					unset($item);
					$row['goods'] = $goods;
					$row['total'] = $goodsid;
					$row['dispatch'] = pdo_fetch("select id,dispatchname from " . tablename('hc_credit_shopping_dispatch') . " where id=:id limit 1", array(":id" => $row['dispatch']));
				}
			}
		
		//	include $this->template('test_order');
			include $this->template('order');
		}
	}




	public function doMobileDetail() {
		global $_W, $_GPC;
		$op = $_GPC['op'];
		$goodsid = intval($_GPC['id']);
		$goods = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_goods') . " WHERE id = :id", array(':id' => $goodsid));
		if (empty($goods)) {
			message('抱歉，商品不存在或是已经被删除！');
		}
		if ($goods['istime'] == 1) {
			$backUrl = $this->createMobileUrl('list');
			$backUrl = $_W['siteroot'] . 'app' . ltrim($backUrl, '.');
			if (time() < $goods['timestart']) {
				message('抱歉，还未到购买时间, 暂时无法购物哦~', $backUrl, "error");
			}
			if (time() > $goods['timeend']) {
				message('抱歉，商品限购时间已到，不能购买了哦~', $backUrl, "error");
			}
		}
		
		if($op=='check'){
			$orderid = intval($_GPC['orderid']);
			$order = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_order') . " WHERE id = :orderid", array(':orderid' => $orderid));
		}
		if($op=='checked'){
			$checkcode = trim($_GPC['checkcode']);
			if(empty($checkcode)){
				echo -1;
				exit;
			}
			if($checkcode!=$goods['checkcode']){
				echo -2;
				exit;
			}
			if($checkcode==$goods['checkcode']){
				$orderid = intval($_GPC['orderid']);
				pdo_update('hc_credit_shopping_order', array('ischeck'=>1, 'status'=>3, 'checkedtime'=>time()), array('id'=>$orderid));
				echo 1;
				exit;
			}
		}
		
		$title = $goods['title'];
		//浏览量
		pdo_query("update " . tablename('hc_credit_shopping_goods') . " set viewcount=viewcount+1 where id=:id and weid='{$_W['uniacid']}' ", array(":id" => $goodsid));
		$piclist1 = array(array("attachment" => $goods['thumb']));
		$piclist = array();
		if (is_array($piclist1)) {
			foreach($piclist1 as $p){
				$piclist[] = is_array($p)?$p['attachment']:$p;
			}
		}
		if ($goods['thumb_url'] != 'N;') {
			$urls = unserialize($goods['thumb_url']);
			if (is_array($urls)) {
				foreach($urls as $p){
					$piclist[] = is_array($p)?$p['attachment']:$p;
				}
			}
		}
		$marketprice = $goods['marketprice'];
		$productprice= $goods['productprice'];
		$originalprice = $goods['originalprice'];
		$stock = $goods['total'];
		//规格及规格项
		$allspecs = pdo_fetchall("select * from " . tablename('hc_credit_shopping_spec') . " where goodsid=:id order by displayorder asc", array(':id' => $goodsid));
		foreach ($allspecs as &$s) {
			$s['items'] = pdo_fetchall("select * from " . tablename('hc_credit_shopping_spec_item') . " where  `show`=1 and specid=:specid order by displayorder asc", array(":specid" => $s['id']));
		}
		unset($s);
		//处理规格项
		$options = pdo_fetchall("select id,title,thumb,marketprice,productprice,costprice, stock,weight,specs from " . tablename('hc_credit_shopping_goods_option') . " where goodsid=:id order by id asc", array(':id' => $goodsid));
		//排序好的specs
		$specs = array();
		//找出数据库存储的排列顺序
		if (count($options) > 0) {
			$specitemids = explode("_", $options[0]['specs'] );
			foreach($specitemids as $itemid){
				foreach($allspecs as $ss){
					$items = $ss['items'];
					foreach($items as $it){
						if($it['id']==$itemid){
							$specs[] = $ss;
							break;
						}
					}
				}
			}
		}
		$params = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_goods_param') . " WHERE goodsid=:goodsid order by displayorder asc", array(":goodsid" => $goods['id']));
		$carttotal = $this->getCartTotal();
		
		//$iplist = pdo_fetchall( " SELECT o.orderid,o.total,o.createtime as ip_time, t.* FROM ".tablename('hc_credit_shopping_member')." AS t LEFT JOIN ".tablename('hc_credit_shopping_order_goods')." AS o ON o.from_user=t.openid WHERE o.goodsid='".$goodsid."' " );
		
		$iplist = pdo_fetchall( "  SELECT m.*, COUNT(t.id) AS total FROM ".tablename('hc_credit_shopping_ticket')." AS t LEFT JOIN ".tablename('hc_credit_shopping_member')." AS m ON t.openid=m.openid WHERE t.goodsid='".$goodsid."'  ");
	
		$check_buy = pdo_fetchcolumn( " SELECT COUNT(id) FROM ".tablename('hc_credit_shopping_ticket')." WHERE goodsid='".$goodsid."' AND openid='".$_W['openid']."' " );
		
		if(!empty($check_buy)){
			$ticket_list = pdo_fetchall( " SELECT ticket FROM ".tablename('hc_credit_shopping_ticket')." WHERE goodsid='".$goodsid."' AND openid='".$_W['openid']."' " );
		}
		if($goods['goods_status'] == 1){
			$award_openid = pdo_fetchcolumn( " SELECT openid FROM ".tablename('hc_credit_shopping_ticket')." WHERE ticket = '".$goods['ticket']."' " );
			$award_list = pdo_fetchall( " SELECT ticket FROM ".tablename('hc_credit_shopping_ticket')." WHERE openid='".$award_openid."' AND goodsid='".$goodsid."' " );
			$award_total = pdo_fetchcolumn( " SELECT COUNT(id) FROM ".tablename('hc_credit_shopping_ticket')." WHERE openid='".$award_openid."' AND goodsid='".$goodsid."' "  );
			$award_member = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_member')." WHERE openid='".$award_openid."' AND weid=".$_W['uniacid']." " );
		}
		
		
		//寻找倒计时商品
		$setting = $this->module['config'];
		$temp = TIMESTAMP - $setting['countdown'] * 60;
		$check_countdown = pdo_fetchcolumn( " SELECT id FROM " . tablename('hc_credit_shopping_goods') . " WHERE weid = '{$_W['uniacid']}'  and deleted=0 AND status = '1' AND goods_status=1 AND ticket_time > $temp LIMIT 6 " );
		
		include $this->template('detail');
	}
	
	
	public function doMobileDetail2(){
		global $_W,$_GPC;
		$goodsid = intval($_GPC['goodsid']);
		if(empty($goodsid)){
			message('查看失败，该商品没有图文详情');
		}
		$goods = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_goods')." WHERE id='".$goodsid."' AND weid=".$_W['uniacid']." " );
		if($goods['status'] == 0){
			message('该商品已经下架');
		}
		include $this->template('detail2');
	}
	
	
	public function doMobileAddress() {
		global $_W, $_GPC;
		$from = $_GPC['from'];
		$returnurl = urldecode($_GPC['returnurl']);
		$this->checkAuth();
		// $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'post';
		$operation = $_GPC['op'];
		if ($operation == 'post') {
			$id = intval($_GPC['id']);
			$data = array(
				'weid' => $_W['uniacid'],
				'openid' => $_W['fans']['from_user'],
				'realname' => $_GPC['realname'],
				'mobile' => $_GPC['mobile'],
				'province' => $_GPC['province'],
				'city' => $_GPC['city'],
				'area' => $_GPC['area'],
				'address' => $_GPC['address'],
			);
			if (empty($_GPC['realname']) || empty($_GPC['mobile']) || empty($_GPC['address'])) {
				message('请输完善您的资料！');
			}
			if (!empty($id)) {
				unset($data['weid']);
				unset($data['openid']);
				pdo_update('hc_credit_shopping_address', $data, array('id' => $id));
				message($id, '', 'ajax');
			} else {
				pdo_update('hc_credit_shopping_address', array('isdefault' => 0), array('weid' => $_W['uniacid'], 'openid' => $_W['fans']['from_user']));
				$data['isdefault'] = 1;
				pdo_insert('hc_credit_shopping_address', $data);
				$id = pdo_insertid();
				if (!empty($id)) {
					message($id, '', 'ajax');
				} else {
					message(0, '', 'ajax');
				}
			}
		} elseif ($operation == 'default') {
			$id = intval($_GPC['id']);
			$address = pdo_fetch("select isdefault from " . tablename('hc_credit_shopping_address') . " where id='{$id}' and weid='{$_W['uniacid']}' and openid='{$_W['fans']['from_user']}' limit 1 ");
			if(!empty($address) && empty($address['isdefault'])){
				pdo_update('hc_credit_shopping_address', array('isdefault' => 0), array('weid' => $_W['uniacid'], 'openid' => $_W['fans']['from_user']));
				pdo_update('hc_credit_shopping_address', array('isdefault' => 1), array('weid' => $_W['uniacid'], 'openid' => $_W['fans']['from_user'], 'id' => $id));
			}
			message(1, '', 'ajax');
		} elseif ($operation == 'detail') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT id, realname, mobile, province, city, area, address FROM " . tablename('hc_credit_shopping_address') . " WHERE id = :id", array(':id' => $id));
			message($row, '', 'ajax');
		} elseif ($operation == 'remove') {
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				$address = pdo_fetch("select isdefault from " . tablename('hc_credit_shopping_address') . " where id='{$id}' and weid='{$_W['uniacid']}' and openid='{$_W['fans']['from_user']}' limit 1 ");
				if (!empty($address)) {
					//pdo_delete("hc_credit_shopping_address", array('id'=>$id, 'weid' => $_W['uniacid'], 'openid' => $_W['fans']['from_user']));
					//修改成不直接删除，而设置deleted=1
					pdo_update("hc_credit_shopping_address", array("deleted" => 1, "isdefault" => 0), array('id' => $id, 'weid' => $_W['uniacid'], 'openid' => $_W['fans']['from_user']));
					if ($address['isdefault'] == 1) {
						//如果删除的是默认地址，则设置是新的为默认地址
						$maxid = pdo_fetchcolumn("select max(id) as maxid from " . tablename('hc_credit_shopping_address') . " where weid='{$_W['uniacid']}' and openid='{$_W['fans']['from_user']}' limit 1 ");
						if (!empty($maxid)) {
							pdo_update('hc_credit_shopping_address', array('isdefault' => 1), array('id' => $maxid, 'weid' => $_W['uniacid'], 'openid' => $_W['fans']['from_user']));
							die(json_encode(array("result" => 1, "maxid" => $maxid)));
						}
					}
				}
			}
			die(json_encode(array("result" => 1, "maxid" => 0)));
		} else {
			$profile = fans_search($_W['fans']['from_user'], array('resideprovince', 'residecity', 'residedist', 'address', 'realname', 'mobile'));
			$address = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_address') . " WHERE deleted=0 and openid = :openid", array(':openid' => $_W['fans']['from_user']));
			$carttotal = $this->getCartTotal();
			include $this->template('address');
		}
	}
	private function checkAuth() {
		global $_W;
		checkauth();
	}
	private function changeWechatSend($id, $status, $msg = '') {
		global $_W;
		$paylog = pdo_fetch("SELECT plid, openid, tag FROM " . tablename('core_paylog') . " WHERE tid = '{$id}' AND status = 1 AND type = 'wechat'");
		if (!empty($paylog['openid'])) {
			$paylog['tag'] = iunserializer($paylog['tag']);
			$acid = $paylog['tag']['acid'];
			$account = account_fetch($acid);
			$payment = uni_setting($account['uniacid'], 'payment');
			if ($payment['payment']['wechat']['version'] == '2') {
				return true;
			}
			$send = array(
					'appid' => $account['key'],
					'openid' => $paylog['openid'],
					'transid' => $paylog['tag']['transaction_id'],
					'out_trade_no' => $paylog['plid'],
					'deliver_timestamp' => TIMESTAMP,
					'deliver_status' => $status,
					'deliver_msg' => $msg,
			);
			$sign = $send;
			$sign['appkey'] = $payment['payment']['wechat']['signkey'];
			ksort($sign);
			$string = '';
			foreach ($sign as $key => $v) {
				$key = strtolower($key);
				$string .= "{$key}={$v}&";
			}
			$send['app_signature'] = sha1(rtrim($string, '&'));
			$send['sign_method'] = 'sha1';
			$account = WeAccount::create($acid);
			$response = $account->changeOrderStatus($send);
			if (is_error($response)) {
				message($response['message']);
			}
		}
	}

	public function payResult($params) {
		global $_W;
		$fee = intval($params['fee']);
		$data = array('status' => $params['result'] == 'success' ? 1 : 0);
		$paytype = array('credit' => '1', 'wechat' => '2', 'alipay' => '2', 'delivery' => '3');
		//微信支付成功
		//因为支付完成通知有两种方式 notify，return,notify为后台通知,return为前台通知，需要给用户展示提示信息
		//return做为通知是不稳定的，用户很可能直接关闭页面，所以状态变更以notify为准
		if ($params['result'] == 'success' && $params['from'] == 'notify') {
			WeUtility::logging("支付完成", $out);
			$order = pdo_fetch(" SELECT * FROM ".tablename('hc_credit_shopping_order')." WHERE id='".$params['tid']."' ");
			if(!empty($order)){		
				WeUtility::logging("进入order", $out);
				if($order['remark'] == 'bi_buy'){		
					WeUtility::logging("进入remark", $params['tid']);
					$bi_rate = $this->module['config']['bi_rate'];
					$uid = pdo_fetchcolumn( " SELECT uid FROM ".tablename('mc_mapping_fans')." WHERE openid='".$order['from_user']."' AND uniacid='".$_W['uniacid']."' " );		
						WeUtility::logging("uid", $uid);
					if(!empty($uid)){
						$fans = pdo_fetch( " SELECT * FROM ".tablename('mc_members')." WHERE uid='".$uid."' " );
						$fans['credit1'] = $fans['credit1'] + $order['price'] * $bi_rate;		
						WeUtility::logging("积分", $fans['credit1']);
						pdo_update('mc_members',$fans,array('uid'=>$uid));
						//完成订单
						$order['status'] = 9;
						pdo_update('hc_credit_shopping_order',$order,array('id'=>$order['id']));
						WeUtility::logging("更改订单", $order['id']);

					}
				}
			}
	
		
		}
		
		
		// 卡券代金券备注
		if (!empty($params['is_usecard'])) {
			$cardType = array('1' => '微信卡券', '2' => '系统代金券');
			$data['paydetail'] = '使用' . $cardType[$params['card_type']] . '支付了' . ($params['fee'] - $params['card_fee']);
			$data['paydetail'] .= '元，实际支付了' . $params['card_fee'] . '元。';
		}

		$data['paytype'] = $paytype[$params['type']];
		if ($params['type'] == 'wechat') {
			$data['transid'] = $params['tag']['transaction_id'];
			
			
			
		}
		if ($params['type'] == 'delivery') {
			$data['status'] = 1;
		}


		if ($params['from'] == 'return') {
			//积分变更
			$this->setOrderCredit($params['tid']);
			$setting = uni_setting($_W['uniacid'], array('creditbehaviors'));
			$credit = $setting['creditbehaviors']['currency'];
			if ($params['type'] == $credit) {
				message('支付成功！', $this->createMobileUrl('list'), 'success');
			} 
			else {
				
				//message('支付成功！', '../../app/' . $this->createMobileUrl('myorder'), 'success');
				message('支付成功！', '../../app/' . $this->createMobileUrl('list'), 'success');
			}
		}
	}

	public function doMobilemy_log(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();
		$openid = $_W['openid'];
		$member = $this->check_member();
		$setting = $this->module['config'];
		$temp = $setting['countdown'] * 60;
		$temp2 = TIMESTAMP - $temp;
		$op = $_GPC['op'];
		if($op == 'doing' ){
			$goods = pdo_fetchall( " SELECT t.createtime as t_createtime, COUNT(t.id) AS my_total , g.* FROM  ".tablename('hc_credit_shopping_goods')." as g LEFT JOIN ".tablename('hc_credit_shopping_ticket')." AS t ON  g.id=t.goodsid WHERE t.openid='".$openid."' AND g.goods_status !=1 AND t.weid=".$_W['weid']."  GROUP BY t.goodsid ORDER BY t.createtime DESC " );
		
		}elseif($op == 'done' ){
			$goods = pdo_fetchall( " SELECT t.createtime as t_createtime, COUNT(t.id) AS my_total , g.* FROM  ".tablename('hc_credit_shopping_goods')." as g LEFT JOIN ".tablename('hc_credit_shopping_ticket')." AS t ON  g.id=t.goodsid WHERE t.openid='".$openid."' AND g.goods_status !=0 AND t.weid=".$_W['weid']."  GROUP BY t.goodsid ORDER BY t.createtime DESC " );		
			}
		else{
			$goods = pdo_fetchall( " SELECT t.createtime as t_createtime, COUNT(t.id) AS my_total , g.* FROM  ".tablename('hc_credit_shopping_goods')." as g LEFT JOIN ".tablename('hc_credit_shopping_ticket')." AS t ON  g.id=t.goodsid WHERE t.openid='".$openid."' AND t.weid=".$_W['weid']." GROUP BY t.goodsid ORDER BY t.createtime DESC " );
		}

		
		include $this->template('my_log');
		
	}
	
	//查看中奖纪录
	public function doMobilemy_award(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();
		$member = $this->check_member();
		$goods = pdo_fetchall( " SELECT g.*,t.openid FROM ".tablename('hc_credit_shopping_goods')." AS g LEFT JOIN ".tablename('hc_credit_shopping_ticket')." AS t ON g.id = t.goodsid AND g.ticket=t.ticket WHERE t.openid='".$_W['openid']."' AND g.goods_status=1 " );

		include $this->template('my_award');
	}
	
	public function doMObiletestimg(){
		global $_W,$_GPC;
		
		include $this->template('testimg');
	}
	
	//我要晒单
	public function doMobilemy_shai(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();
		$member = $this->check_member();
		$temp = $this->module['config']['countdown'];
		$temp2 = TIMESTAMP - $temp *60;
		$goods = pdo_fetchall( " SELECT g.*,t.openid FROM ".tablename('hc_credit_shopping_goods')." AS g LEFT JOIN ".tablename('hc_credit_shopping_ticket')." AS t ON g.id = t.goodsid AND g.ticket=t.ticket WHERE t.openid='".$_W['openid']."' AND g.goods_status=1 AND g.ticket_time<".$temp2." " );

		
		include $this->template('my_shai');
	}
	
	//晒单编辑
	public function doMobileshai_edit(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();
		$member = $this->check_member();
		$goodsid = $_GPC['goodsid'];
		$openid = $_W['openid'];
		$check = pdo_fetchcolumn(" SELECT id FROM ".tablename('hc_credit_shopping_shai')." WHERE goodsid=".$goodsid." AND openid='".$_W['openid']."' ");
		if(!empty($check)){
			message('您已经晒过这件商品了');
		}
		
		if(empty($goodsid)){
		//	message('您选择的商品无效');
		}
		$goods = pdo_fetchall( " SELECT g.*,t.openid FROM ".tablename('hc_credit_shopping_goods')." AS g LEFT JOIN ".tablename('hc_credit_shopping_ticket')." AS t ON g.id = t.goodsid AND g.ticket=t.ticket WHERE t.openid='".$_W['openid']."' AND g.goods_status=1 AND goodsid='".$goodsid."' " );
		if(empty($goods)){
		//	message('您不是这件商品的中奖者，不能晒单');
		}
		
		include $this->template('shai_edit');
		
	}
	
	//晒单保存
	public function doMobileshai_save(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();
		$openid = $_W['openid'];
		$member = $this->check_member();		
		$goodsid = $_GPC['goodsid']; 
		if(empty($goodsid)){
		//	message('您选择的商品无效');
		}
		$goods = pdo_fetchall( " SELECT g.*,t.openid FROM ".tablename('hc_credit_shopping_goods')." AS g LEFT JOIN ".tablename('hc_credit_shopping_ticket')." AS t ON g.id = t.goodsid AND g.ticket=t.ticket WHERE t.openid='".$_W['openid']."' AND g.goods_status=1 AND goodsid='".$goodsid."' " );
		

		if(empty($goods)){
		//	message('您不是这件商品的中奖者，不能晒单');
		}
		
		if(empty($_GPC['content']) || empty($_GPC['title'])  ){
			message('必须填写标题和内容才可以提交');
		}
		
		$insert = array(
			'weid' => $_W['uniacid'],
			'openid' => $openid,
			'createtime' => TIMESTAMP,
			'goodsid' => $goodsid,
			'content' => $_GPC['content'],
			'title' => $_GPC['title'],
		);
		if(!empty($_GPC['img'])){
			$imgs = $_GPC['img'];
			foreach($imgs as $k=>$v){
				if($v == 'undefined'){
					unset($imgs[$k]);
				}
			}
			$img = implode('|',$imgs);
			$insert['img'] = $img;
			$insert['img1'] = $_GPC['img'][0];
		}

		pdo_insert('hc_credit_shopping_shai',$insert);
		message('保存成功',$this->createMobileUrl('home'),'success');
		
	}
	
	//晒单查看
	public function doMobileshai_view(){
		global $_W,$_GPC;
		$list = pdo_fetchall( " SELECT m.headimg,m.nickname,s.title,s.img,s.img1,s.id,s.createtime,s.goodsid FROM ".tablename('hc_credit_shopping_member')." AS m LEFT JOIN ".tablename('hc_credit_shopping_shai')." AS s ON m.openid=s.openid AND s.weid=m.weid WHERE s.weid=".$_W['uniacid']." " );
		
		
		
		include $this->template('shai_view');
	}
	
	public function doMobileshai_detail(){
		global $_W,$_GPC;
		$this->check_bowser();
		$shaiid = $_GPC['shaiid'];
		if(empty($shaiid)){
			message('查看的晒单不存在');
		}
		$list = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_shai')." WHERE id='".$shaiid."' " );
		$goods = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_goods')." WHERE id='".$list['goodsid']."' " );
		$member = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_member')." WHERE openid='".$list['openid']."' AND weid='".$_W['uniacid']."' " );
		$total = pdo_fetchcolumn(" SELECT COUNT(id) FROM ".tablename('hc_credit_shopping_ticket')." WHERE goodsid='".$goods['id']."' AND openid='".$member['openid']."' ");
		if(!empty($list['img'])){
			$imgs = explode('|',$list['img']);
		}
		include $this->template('shai_detail');
		
	}
	
	
	//个人中心
	public function doMobileHome(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();
		$openid = $_W['openid'];
		$member = $this->check_member();
		$credit_shoppingbi = $this->get_credit_shoppingbi();
		include $this->template('home');
	}
	
	
	//直接购买订单页
	public function doMobilebi_order(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();
		$member = $this->check_member();
		$setting = $this->module['config'];

		include $this->template('buy_order');
	}
	
	//提交直接购买订单
	public function doMobilesubmit_buy_order(){
		global $_W, $_GPC;
		$this->checkAuth();
		$this->check_bowser();
		$this->check_follow();
		$total = intval($_GPC['total']);
		if(!is_numeric($total)){
			message('请输入数字!');
		}if($total == 0){
			message('购买数量不能为0！');
		}
		$setting = $this->module['config'];
		$order = array(
			'weid' =>  $_W['uniacid'],
			'from_user' =>  $_W['openid'],
			'ordersn' =>  date('md') . random(4, 1),
			'price' =>  $total,
			'status' =>  0,
			'sendtype' =>  2,
			'paytype' =>  9,
			'goodstype' =>  1,
			'remark' =>  'bi_buy',
			'addressid' =>  0,
			'expresscom' =>  0,
			'goodsprice' =>  $setting['bi_rate'],
			'dispatchprice' =>  0,
			'dispatch' =>  0,
			'createtime' =>  TIMESTAMP,
		);
		pdo_insert('hc_credit_shopping_order',$order);
		$orderid = pdo_InsertId();
		$params['tid'] = $orderid;
		$params['user'] = $_W['fans']['from_user'];
		$params['fee'] = $total;
		$params['title'] = '积分购买';
		$params['ordersn'] = $order['ordersn'];
		$params['virtual'] = $order['goodstype'] == 2 ? true : false;

		include $this->template('pay');
	}
	
	//购买返回结果
	public function bi_pay_result($orderid){
		global $_W,$_GPC;
		$order = pdo_fetch(" SELECT * FROM ".tablename('hc_credit_shopping_order')." WHERE id='".$orderid."' ");
		if(!empty($order)){
			$openid = $order['from_user'];
		}
		$setting = $this->module['config'];
		$member = pdo_fetch(" SELECT * FROM ".tablename('hc_credit_shopping_member')." WHERE openid='".$openid."' AND weid='".$_W['uniacid']."' ");
		$bi = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_bi')." WHERE openid='".$openid."' AND weid='".$_W['uniacid']."'  " );
		WeUtility::logging("bid", $bi['id']);
		$bi_total = intval($setting['bi_rate']) * $order['price'];
		if(empty($bi)){
			$insert = array(
			'weid' => $_W['uniacid'],
			'openid' => $openid,
			'mid' => $member['id'],
			'nickname' => $member['nickname'],
			'headimg' => $member['headimg'],
			'bi' => $bi_total,
			'createtime' => TIMESTAMP,
			'updatetime' => TIMESTAMP,
			);
		pdo_insert('hc_credit_shopping_bi',$insert);
		$bi = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_bi')." WHERE openid='".$openid."' AND weid='".$_W['uniacid']."'  " );
		}else{
			$bi['bi'] = intval($bi['bi']) + $bi_total;
			$bi['updatetime'] = TIMESTAMP;
			pdo_update('hc_credit_shopping_bi',$bi,array('id'=>$bi['id']));
		}
		$insert2 = array(
			'weid' => $_W['uniacid'],
			'openid' => $openid,
			'bid' => $bi_total,
			'bi' => $order['price'],
			'mid' => $member['id'],
			'type' => 2,
			'createtime' => TIMESTAMP,
		);
		pdo_insert('hc_credit_shopping_bi_log',$insert2);
		
		
		
	}
	
	public function doWebOption() {
		$tag = random(32);
		global $_GPC;
		include $this->template('option');
	}
	public function doWebSpec() {
		global $_GPC;
		$spec = array(
			"id" => random(32),
			"title" => $_GPC['title']
		);
		include $this->template('spec');
	}
	public function doWebSpecItem() {
		global $_GPC;
		load()->func('tpl');
		$spec = array(
			"id" => $_GPC['specid']
		);
		$specitem = array(
			"id" => random(32),
			"title" => $_GPC['title'],
			"show" => 1
		);
		include $this->template('spec_item');
	}
	public function doWebParam() {
		$tag = random(32);
		global $_GPC;
		include $this->template('param');
	}
	public function doWebExpress() {
		global $_W, $_GPC;
		// pdo_query('DROP TABLE ims_hc_credit_shopping_express');
		//pdo_query("CREATE TABLE IF NOT EXISTS `ims_hc_credit_shopping_express` ( `id` int(10) unsigned NOT NULL AUTO_INCREMENT, `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',  `express_name` varchar(50) NOT NULL COMMENT '分类名称',  `express_price` varchar(10) NOT NULL DEFAULT '0',  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',  `express_area` varchar(50) NOT NULL COMMENT '配送区域',  `enabled` tinyint(1) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 ");
		//pdo_query("ALTER TABLE  `ims_hc_credit_shopping_order` ADD  `expressprice` VARCHAR( 10 ) NOT NULL AFTER  `totalnum` ;");
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'display') {
			$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_express') . " WHERE weid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
		} elseif ($operation == 'post') {
			$id = intval($_GPC['id']);
			if (checksubmit('submit')) {
				if (empty($_GPC['express_name'])) {
					message('抱歉，请输入物流名称！');
				}
				$data = array(
					'weid' => $_W['uniacid'],
					'displayorder' => intval($_GPC['displayorder']),
					'express_name' => $_GPC['express_name'],
					'express_url' => $_GPC['express_url'],
					'express_area' => $_GPC['express_area'],
				);
				if (!empty($id)) {
					unset($data['parentid']);
					pdo_update('hc_credit_shopping_express', $data, array('id' => $id));
				} else {
					pdo_insert('hc_credit_shopping_express', $data);
					$id = pdo_insertid();
				}
				message('更新物流成功！', $this->createWebUrl('express', array('op' => 'display')), 'success');
			}
			//修改
			$express = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_express') . " WHERE id = '$id' and weid = '{$_W['uniacid']}'");
		} elseif ($operation == 'delete') {
			$id = intval($_GPC['id']);
			$express = pdo_fetch("SELECT id  FROM " . tablename('hc_credit_shopping_express') . " WHERE id = '$id' AND weid=" . $_W['uniacid'] . "");
			if (empty($express)) {
				message('抱歉，物流方式不存在或是已经被删除！', $this->createWebUrl('express', array('op' => 'display')), 'error');
			}
			pdo_delete('hc_credit_shopping_express', array('id' => $id));
			message('物流方式删除成功！', $this->createWebUrl('express', array('op' => 'display')), 'success');
		} else {
			message('请求方式不存在');
		}
		include $this->template('express', TEMPLATE_INCLUDEPATH, true);
	}
	public function doWebDispatch() {
		global $_W, $_GPC;
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'display') {
			$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_dispatch') . " WHERE weid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
		} elseif ($operation == 'post') {
			$id = intval($_GPC['id']);
			if (checksubmit('submit')) {
				$data = array(
					'weid' => $_W['uniacid'],
					'displayorder' => intval($_GPC['displayorder']),
					'dispatchtype' => intval($_GPC['dispatchtype']),
					'dispatchname' => $_GPC['dispatchname'],
					'express' => $_GPC['express'],
					'firstprice' => $_GPC['firstprice'],
					'firstweight' => $_GPC['firstweight'],
					'secondprice' => $_GPC['secondprice'],
					'secondweight' => $_GPC['secondweight'],
					'description' => $_GPC['description']
				);
				if (!empty($id)) {
					pdo_update('hc_credit_shopping_dispatch', $data, array('id' => $id));
				} else {
					pdo_insert('hc_credit_shopping_dispatch', $data);
					$id = pdo_insertid();
				}
				message('更新配送方式成功！', $this->createWebUrl('dispatch', array('op' => 'display')), 'success');
			}
			//修改
			$dispatch = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_dispatch') . " WHERE id = '$id' and weid = '{$_W['uniacid']}'");
			$express = pdo_fetchall("select * from " . tablename('hc_credit_shopping_express') . " WHERE weid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
		} elseif ($operation == 'delete') {
			$id = intval($_GPC['id']);
			$dispatch = pdo_fetch("SELECT id FROM " . tablename('hc_credit_shopping_dispatch') . " WHERE id = '$id' AND weid=" . $_W['uniacid'] . "");
			if (empty($dispatch)) {
				message('抱歉，配送方式不存在或是已经被删除！', $this->createWebUrl('dispatch', array('op' => 'display')), 'error');
			}
			pdo_delete('hc_credit_shopping_dispatch', array('id' => $id));
			message('配送方式删除成功！', $this->createWebUrl('dispatch', array('op' => 'display')), 'success');
		} else {
			message('请求方式不存在');
		}
		include $this->template('dispatch', TEMPLATE_INCLUDEPATH, true);
	}
	public function doWebAdv() {
		global $_W, $_GPC;
			load()->func('tpl');
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'display') {
			$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_adv') . " WHERE weid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
		} elseif ($operation == 'post') {
			$id = intval($_GPC['id']);
			if (checksubmit('submit')) {
				$data = array(
					'weid' => $_W['uniacid'],
					'advname' => $_GPC['advname'],
					'link' => $_GPC['link'],
					'enabled' => intval($_GPC['enabled']),
					'displayorder' => intval($_GPC['displayorder']),
					'thumb'=>$_GPC['thumb']
				);
				if (!empty($id)) {
					pdo_update('hc_credit_shopping_adv', $data, array('id' => $id));
				} else {
					pdo_insert('hc_credit_shopping_adv', $data);
					$id = pdo_insertid();
				}
				message('更新幻灯片成功！', $this->createWebUrl('adv', array('op' => 'display')), 'success');
			}
			$adv = pdo_fetch("select * from " . tablename('hc_credit_shopping_adv') . " where id=:id and weid=:weid limit 1", array(":id" => $id, ":weid" => $_W['uniacid']));
		} elseif ($operation == 'delete') {
			$id = intval($_GPC['id']);
			$adv = pdo_fetch("SELECT id FROM " . tablename('hc_credit_shopping_adv') . " WHERE id = '$id' AND weid=" . $_W['uniacid'] . "");
			if (empty($adv)) {
				message('抱歉，幻灯片不存在或是已经被删除！', $this->createWebUrl('adv', array('op' => 'display')), 'error');
			}
			pdo_delete('hc_credit_shopping_adv', array('id' => $id));
			message('幻灯片删除成功！', $this->createWebUrl('adv', array('op' => 'display')), 'success');
		} else {
			message('请求方式不存在');
		}
		include $this->template('adv', TEMPLATE_INCLUDEPATH, true);
	}
	public function doMobileAjaxdelete() {
		global $_GPC;
		$delurl = $_GPC['pic'];
		if (file_delete($delurl)) {
			echo 1;
		} else {
			echo 0;
		}
	}
		
	/*	
	//参与人员查看
	public function doWebmember(){
		global $_W,$_GPC;
		$psize = 30;
		$pindex = max(1, intval($_GPC['page']));
		$list = pdo_fetchall( " SELECT * FROM ".tablename('hc_credit_shopping_member')." ORDER BY createtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize} " );
		$total = sizeof($list);
		$pager = pagination($total, $pindex, $psize);

		include $this->template('member_index');
		
	}
	*/
	
	//作弊功能
	public function doWebgoods_cheat(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		if(empty($id)){
			message("查看的商品不存在");
		}
		$goods = pdo_fetchall(" SELECT * FROM ".tablename('hc_credit_shopping_goods')." WHERE id=".$id." ");
		var_dump($goods);
		include $this->template('cheat_index');
	}
	
	//中奖人员查看
	public function doWebwinner(){
		global $_W,$_GPC;
		$psize = 30;
		$pindex = max(1, intval($_GPC['page']));
		$list = pdo_fetchall( " SELECT g.id, g.title, g.ticket_nickname, g.ticket_time, g.ticket,a.address, a.mobile, a.realname FROM ".tablename('hc_credit_shopping_goods')." AS g LEFT JOIN ".tablename('hc_credit_shopping_address')." AS a ON g.ticket_openid = a.openid WHERE g.goods_status=1 AND g.weid='".$_W['unaicid']."' ORDER BY ticket_time  DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}  " );
		$total = sizeof($list);
		$pager = pagination($total, $pindex, $psize);

		include $this->template('winner_index');
		
	}

	
	//中奖详情
		
	public function doWebwinner_detail(){
		global $_W,$_GPC;
		$goodsid = $_GPC['goodsid'];
		if(empty($goodsid)){
			message("查看的数据不存在");
		}
		$item = pdo_fetch( " SELECT g.id, g.title, g.ticket_nickname, g.ticket_time, g.ticket,a.address, a.mobile, a.realname FROM ".tablename('hc_credit_shopping_goods')." AS g LEFT JOIN ".tablename('hc_credit_shopping_address')." AS a ON g.ticket_openid = a.openid WHERE g.id='".$goodsid."' ORDER BY ticket_time  DESC   " );
		
		include $this->template('winner_detail');
		
	}
	//中奖人员查看
	public function doWebwinner_search(){
		global $_W,$_GPC;
		$keyword = $_GPC['keyword'];
		$key = $_GPC['key'];
		$psize = 30;
		$pindex = max(1, intval($_GPC['page']));
		if(empty($key)){
			message('请选择查询条件');
		}
		if($key == '昵称'){
			$list = pdo_fetchall( " SELECT g.id, g.title, g.ticket_nickname, g.ticket_time, g.ticket,a.address, a.mobile, a.realname FROM ".tablename('hc_credit_shopping_goods')." AS g LEFT JOIN ".tablename('hc_credit_shopping_address')." AS a ON g.ticket_openid = a.openid WHERE g.goods_status=1 AND g.ticket_nickname like '%".$keyword."%' ORDER BY ticket_time  DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}  " );
		}
		if($key == '姓名'){
			$list = pdo_fetchall( " SELECT g.id, g.title, g.ticket_nickname, g.ticket_time, g.ticket,a.address, a.mobile, a.realname FROM ".tablename('hc_credit_shopping_goods')." AS g LEFT JOIN ".tablename('hc_credit_shopping_address')." AS a ON g.ticket_openid = a.openid WHERE g.goods_status=1 AND a.realname like '%".$keyword."%' ORDER BY ticket_time  DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}  " );
		}
		if($key == '联系方式'){
			$list = pdo_fetchall( " SELECT g.id, g.title, g.ticket_nickname, g.ticket_time, g.ticket,a.address, a.mobile, a.realname FROM ".tablename('hc_credit_shopping_goods')." AS g LEFT JOIN ".tablename('hc_credit_shopping_address')." AS a ON g.ticket_openid = a.openid WHERE g.goods_status=1 AND a.mobile like '%".$keyword."%' ORDER BY ticket_time  DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}  " );
		}
		
	
		$total = sizeof($list);
		$pager = pagination($total, $pindex, $psize);
		include $this->template('winner_index');
	}
	
	
	
	public function doMobilebuy(){
		global $_W,$_GPC;
			$goodsid = intval($_GPC['goodsid']);
			$total = intval($_GPC['total']);
			$total = empty($total) ? 1 : $total;
			$optionid = intval($_GPC['optionid']);
			$goods = pdo_fetch("SELECT id, type, total,marketprice,maxbuy FROM " . tablename('hc_credit_shopping_goods') . " WHERE id = :id", array(':id' => $goodsid));
			if (empty($goods)) {
				//$result['message'] = '抱歉，该商品不存在或是已经被删除！';
				message("抱歉，该商品不存在或是已经被删除！");
			}
			$marketprice = $goods['marketprice'];
			if (!empty($optionid)) {
				$option = pdo_fetch("select marketprice from " . tablename('hc_credit_shopping_goods_option') . " where id=:id limit 1", array(":id" => $optionid));
				if (!empty($option)) {
					$marketprice = $option['marketprice'];
				}
			}
			//$row = pdo_fetch("SELECT id, total FROM " . tablename('hc_credit_shopping_cart') . " WHERE from_user = :from_user AND weid = '{$_W['uniacid']}'", array(':from_user' => $_W['fans']['from_user']));
			pdo_delete('hc_credit_shopping_cart', array('weid'=>$_W['uniacid'], 'from_user'=>$_W['fans']['from_user']));
			if (1) {
				//不存在
				$data = array(
					'weid' => $_W['uniacid'],
					'goodsid' => $goodsid,
					'goodstype' => $goods['type'],
					'marketprice' => $marketprice,
					'from_user' => $_W['fans']['from_user'],
					'total' => $total,
					'optionid' => $optionid
				);
				pdo_insert('hc_credit_shopping_cart', $data);
			}
			//返回数据
			$carttotal = $this->getCartTotal();
			$result = array(
				'result' => 1,
				'total' => $carttotal
			);
		$url = $this->createMobileUrl('check_order');
		header("location:$url");
	}
	
	//收货地址
	public function doMobilemyaddress(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();

		$return_url = $_GPC['return_url'];
		if(empty($return_url)){
			$url = $this->createMobileUrl('home');
		}else{
			$url = $this->createMobileUrl($return_url);
		}

		$address = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_address')." WHERE openid='".$_W['openid']."' AND weid='".$_W['uniacid']."' " );
		if($_GPC['op'] == 'submit'){

		if(empty($_GPC['realname']) || empty($_GPC['mobile']) || empty($_GPC['address'])){
			message('请把所有信息填写完整');
		}
			
			if(empty($address)){
				$insert = array(
					'openid' => $_W['openid'],
					'weid' => $_W['uniacid'],
					'realname' => $_GPC['realname'],
					'address' => $_GPC['address'],
					'mobile' => $_GPC['mobile'],
					'realname' => $_GPC['realname'],
				);
				pdo_insert('hc_credit_shopping_address',$insert);
				message("保存成功",$url,'success');
			}else{
				$address['realname'] = $_GPC['realname'];
				$address['mobile'] = $_GPC['mobile'];
				$address['address'] = $_GPC['address'];
				pdo_update('hc_credit_shopping_address',$address,array('id'=>$address['id']));
				message("保存成功",$url,'success');
			}
			
		}
		include $this->template('address');
	}
	
	public function doMobilepay_way(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();
		$this->check_member();
		$openid = $_W['openid'];
		//$goods = pdo_fetchall( " SELECT * FROM ".tablename('hc_credit_shopping_cart')." WHERE from_user='".$openid."' AND weid=".$_W['uniacid']." " );
		
		//检查有没有填写地址
		$address = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_address')." WHERE openid='".$_W['openid']."' AND weid='".$_W['uniacid']."' " );
		
		if(empty($address)){
			message("请先填写收货地址",$this->createMobileUrl('address',array('return_url'=>'pay_way')),'success');
		}
		
		$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_cart') . " WHERE  weid = '{$_W['uniacid']}' AND from_user = '{$_W['fans']['from_user']}'");
		
			$totalprice = 0;
			if (!empty($list)) {
				foreach ($list as &$item) {
					$goods = pdo_fetch("SELECT  * FROM " . tablename('hc_credit_shopping_goods') . " WHERE id=:id limit 1", array(":id" => $item['goodsid']));
					
					$goodsid = $goods['id'];
					$key = "goods_".$goodsid;
					$edit_total = $_GPC[$key];
					if(!empty($edit_total)){
						$item['total'] = intval($edit_total);
						
						//检查购买数量有没有超过商品剩余数量
						$remain_goods_total = $goods['total'] - $goods['ticket_total'];
						if($item['total'] > $remain_goods_total){
							message('购买数量超过商品剩余数量！',$this->createMobileUrl('check_order'),'success');
						}
						pdo_update('hc_credit_shopping_cart',$item,array('id'=>$item['id']));
					}
					

					$item['goods'] = $goods;
					$item['totalprice'] = (floatval($goods['marketprice']) * intval($item['total']));
					$totalprice += $item['totalprice'];
				}
				unset($item);
			}
		$credit_shoppingbi = $this->get_credit_shoppingbi();
		if(empty($credit_shoppingbi)) $credit_shoppingbi=0;
		include $this->template('pay_way');
	}
	
	//积分兑换积分
	public function doMobilecredit_order(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();
		$member = $this->check_member();
		$setting = $this->module['config'];
		$fans = pdo_fetch( " SELECT * FROM ".tablename('mc_mapping_fans')." WHERE openid='".$_W['openid']."' AND uniacid='".$_W['uniacid']."' " );
		$credit = pdo_fetchcolumn(" SELECT credit1 FROM ".tablename('mc_members')." WHERE uid='".$fans['uid']."' ");
		include $this->template('credit_order');
	}
	

	public function doMobilesubmit_credit_order(){
		global $_W,$_GPC;
		$this->checkAuth();
		$this->check_bowser();
		$this->check_follow();
		$total = intval($_GPC['total']);
		$openid = $_W['openid'];
		$setting = $this->module['config'];
		if(!is_numeric($total)){
			message('请输入数字!');
		}if($total == 0){
			message('购买数量不能为0！');
		}
		$fans = pdo_fetch( " SELECT * FROM ".tablename('mc_mapping_fans')." WHERE openid='".$_W['openid']."' AND uniacid='".$_W['uniacid']."' " );
		$member = pdo_fetch(" SELECT * FROM ".tablename('mc_members')." WHERE uid='".$fans['uid']."' ");
		$credit = $member['credit1'];
		if($credit == 0 || empty($credit)){
			message("您的积分不足");
		}
		$cost_credit = $total * $setting['credit_rate'];
		$result_ticket = $credit - $cost_credit;
		if($result_ticket <0){
			message("您的积分不足");
		}else{
			$member['credit1'] = $result_ticket;
			//pdo_update('mc_members',$member,array('uid'=>$member['uid']));
			mc_credit_update($member['uid'],'credit1',-$cost_credit,array(1=>'积分兑换积分'.$huode));
			//写入到积分兑换记录
			$bi = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_bi')." WHERE openid='".$openid."' AND weid='".$_W['uniacid']."'  " );
			WeUtility::logging("bid", $bi['id']);
			if(empty($bi)){
				$insert = array(
				'weid' => $_W['uniacid'],
				'openid' => $openid,
				'mid' => $member['id'],
				'nickname' => $member['nickname'],
				'headimg' => $member['headimg'],
				'bi' => $total,
				'createtime' => TIMESTAMP,
				'updatetime' => TIMESTAMP,
				);
			pdo_insert('hc_credit_shopping_bi',$insert);
			$bi = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_bi')." WHERE openid='".$openid."' AND weid='".$_W['uniacid']."'  " );
			}else{
				$bi['bi'] = intval($bi['bi']) + intval($total);
				$bi['updatetime'] = TIMESTAMP;
				pdo_update('hc_credit_shopping_bi',$bi,array('id'=>$bi['id']));
			}
			$insert2 = array(
				'weid' => $_W['uniacid'],
				'openid' => $openid,
				'bid' => $bi['id'],
				'bi' => $order['price'],
				'mid' => $member['id'],
				'type' => 3,
				'createtime' => TIMESTAMP,
			);
			pdo_insert('hc_credit_shopping_bi_log',$insert2);
			message("积分兑换成功！",$this->createMobileUrl('home'),'success');
		}
		
		
		
	}
	
	
	
	public function doMobilecheck_order(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();
		$openid = $_W['openid'];
		//$goods = pdo_fetchall( " SELECT * FROM ".tablename('hc_credit_shopping_cart')." WHERE from_user='".$openid."' AND weid=".$_W['uniacid']." " );
		
		$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_cart') . " WHERE  weid = '{$_W['uniacid']}' AND from_user = '{$_W['fans']['from_user']}'");
		
			$totalprice = 0;
			if (!empty($list)) {
				foreach ($list as &$item) {
					$goods = pdo_fetch("SELECT  * FROM " . tablename('hc_credit_shopping_goods') . " WHERE id=:id limit 1", array(":id" => $item['goodsid']));
					//属性
					$option = pdo_fetch("select title,marketprice,stock from " . tablename("hc_credit_shopping_goods_option") . " where id=:id limit 1", array(":id" => $item['optionid']));
					if ($option) {
						$goods['title'] = $goods['title'];
						$goods['optionname'] = $option['title'];
						$goods['marketprice'] = $option['marketprice'];
						$goods['total'] = $option['stock'];
					}
					$item['goods'] = $goods;
					$item['totalprice'] = (floatval($goods['marketprice']) * intval($item['total']));
					$totalprice += $item['totalprice'];
				}
				unset($item);
			}
		//var_dump($list);
		//$credit_shoppingbi = pdo_fetchcolumn( " SELECT bi FROM ".tablename('hc_credit_shopping_bi')." WHERE openid='".$_W['openid']."' AND weid='".$_W['uniacid']."' " );
		$credit_shoppingbi = $this->get_credit_shoppingbi();
		if(empty($credit_shoppingbi)) $credit_shoppingbi=0;
		include $this->template('buy');
	}
	
	public function doMobilesubmit_order(){
		global $_W,$_GPC;
		checkauth();
		$this->check_bowser();
		$this->check_follow();
		$totalprice = 0;
		$allgoods = array();
		$id = intval($_GPC['id']);
		$optionid = intval($_GPC['optionid']);
		$total = intval($_GPC['total']);
		if ( (empty($total)) || ($total < 1) ) {
			$total = 1;
		}
		$direct = false; //是否是直接购买
		$returnurl = ""; //当前连接
		if (!$direct) {
			//如果不是直接购买（从购物车购买）
			$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_cart') . " WHERE  weid = '{$_W['uniacid']}' AND from_user = '{$_W['fans']['from_user']}'");
			if (!empty($list)) {
				foreach ($list as &$g) {
					$item = pdo_fetch("select id,goods_status,thumb,title,weight,marketprice,total,type,totalcnf,sales,unit from " . tablename("hc_credit_shopping_goods") . " where id=:id limit 1", array(":id" => $g['goodsid']));
					if($item['goods_status'] == 1){
						message("商品已过期，无法购买");
					}
					//属性
					$option = pdo_fetch("select title,marketprice,weight,stock from " . tablename("hc_credit_shopping_goods_option") . " where id=:id limit 1", array(":id" => $g['optionid']));
					if ($option) {
						$item['optionid'] = $g['optionid'];
						$item['title'] = $item['title'];
						$item['optionname'] = $option['title'];
						$item['marketprice'] = $option['marketprice'];
						$item['weight'] = $option['weight'];
					}
					$item['stock'] = $item['total'];
					$item['total'] = $g['total'];
					$item['totalprice'] = $g['total'] * $item['marketprice'];
					$allgoods[] = $item;
					$totalprice += $item['totalprice'];
					if ($item['type'] == 1) {
						$needdispatch = true;
					}
				}
				unset($g);
			}
			$returnurl = $this->createMobileUrl("confirm");
		}
		if (count($allgoods) <= 0) {
		//	header("location: " . $this->createMobileUrl('myorder'));
		//	exit();
		}

		//配送方式
		$dispatch = pdo_fetchall("select id,dispatchname,dispatchtype,firstprice,firstweight,secondprice,secondweight from " . tablename("hc_credit_shopping_dispatch") . " WHERE weid = {$_W['uniacid']} order by displayorder desc");
		foreach ($dispatch as &$d) {
			$weight = 0;
			foreach ($allgoods as $g) {
				$weight += $g['weight'] * $g['total'];
			}
			$price = 0;
			if ($weight <= $d['firstweight']) {
				$price = $d['firstprice'];
			} else {
				$price = $d['firstprice'];
				$secondweight = $weight - $d['firstweight'];
				if ($secondweight % $d['secondweight'] == 0) {
					$price += (int)($secondweight / $d['secondweight']) * $d['secondprice'];
				} else {
					$price += (int)($secondweight / $d['secondweight'] + 1) * $d['secondprice'];
				}
			}
			$d['price'] = $price;
		}
		unset($d);
			// 是否自提
			$sendtype = 1;
			$address = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_address') . " WHERE id = :id", array(':id' => intval($_GPC['address'])));
			if (empty($address)) {
				//message('抱歉，请您填写收货地址！');
			}
			// 商品价格
			$goodsprice = 0;
			foreach ($allgoods as $row) {
				$goodsprice += $row['totalprice'];
			}
			// 运费
			$dispatchid = intval($_GPC['dispatch']);
			$dispatchprice = 0;
			foreach ($dispatch as $d) {
				if ($d['id'] == $dispatchid) {
					$dispatchprice = $d['price'];
					$sendtype = $d['dispatchtype'];
				}
			}
			$price = $goodsprice + $dispatchprice;
			//如果交易币不够直接跳转到个人中心
			$check_bi = pdo_fetchcolumn(" SELECT bi FROM ".tablename('hc_credit_shopping_bi')." WHERE openid='".$_W['openid']."' AND weid='".$_W['uniacid']."'  ");
			if(empty($check_bi)){
				message("您的积分不足，马上为您跳转到充值页面",$this->createMobileUrl('bi_order'),'success');
			}else{
				if($check_bi == 0 || $check_bi < $price ){
				message("您的积分不足，马上为您跳转到充值页面",$this->createMobileUrl('bi_order'),'success');
				}
			}
			
			$data = array(
				'weid' => $_W['uniacid'],
				'from_user' => $_W['fans']['from_user'],
				'ordersn' => date('md') . random(4, 1),
				'price' => $goodsprice + $dispatchprice,
				'dispatchprice' => $dispatchprice,
				'goodsprice' => $goodsprice,
				'status' => 0,
				'sendtype' => intval($sendtype),
				'dispatch' => $dispatchid,
				'goodstype' => intval($item['type']),
				'remark' => $_GPC['remark'],
				'addressid' => $address['id'],
				'createtime' => TIMESTAMP
			);

			pdo_insert('hc_credit_shopping_order', $data);
			$orderid = pdo_insertid();
			//插入订单商品
			foreach ($allgoods as $row) {
				if (empty($row)) {
					continue;
				}
				$d = array(
					'weid' => $_W['uniacid'],
					'goodsid' => $row['id'],
					'orderid' => $orderid,
					'total' => $row['total'],
					'price' => $row['total'],
					'from_user' => $_W['openid'],
					'createtime' => TIMESTAMP,
					'optionid' => $row['optionid']
				);
				$o = pdo_fetch("select title from " . tablename('hc_credit_shopping_goods_option') . " where id=:id limit 1", array(":id" => $row['optionid']));
				if (!empty($o)) {
					$d['optionname'] = $o['title'];
				}
				pdo_insert('hc_credit_shopping_order_goods', $d);
			}
			// 清空购物车
			if (!$direct) {
				pdo_delete("hc_credit_shopping_cart", array("weid" => $_W['uniacid'], "from_user" => $_W['fans']['from_user']));
			}
			// 变更商品库存
			if (empty($item['totalcnf'])) {
				$this->setOrderStock($orderid,true);
			}

			//直接在这里使用积分支付
			$credit_shoppingbi = $this->get_credit_shoppingbi();
			$order = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_order')." WHERE id='".$orderid."' " );
			if($credit_shoppingbi < $order['price']){
				message("您的交易币不足，马上为您跳转到充值页面",$this->createMobileUrl('home'),'success');
			}else{
				$credit_shoppingbi = $credit_shoppingbi - $order['price'];
				if($credit_shoppingbi < 0){
					message("您的交易币不足，马上为您跳转到充值页面",$this->createMobileUrl('home'),'success');
				}else{
					//更新回fans表
					$uid = pdo_fetchcolumn(" SELECT uid FROM ".tablename('mc_mapping_fans')." WHERE openid='".$_W['openid']."' AND uniacid='".$_W['uniacid']."' ");
					$flag = pdo_update('mc_members',array('credit1'=>$credit_shoppingbi),array('uid'=>$uid));


					$order['status'] =1;
					pdo_update('hc_credit_shopping_order',$order,array('id'=>$order['id']));
					
					$memberid = pdo_fetchcolumn( " SELECT id FROM ".tablename('hc_credit_shopping_member')." WHERE openid='".$order['from_user']."' AND weid=".$_W['uniacid']." " );
					$all_goods = pdo_fetchall( " SELECT * FROM ".tablename('hc_credit_shopping_order_goods')." WHERE orderid = '".$orderid."' AND weid=".$_W['uniacid']."  " );
					foreach($all_goods as $goods){
						$total = intval($goods['total']);
						$n=0;
						for($n;$n<$total;$n++){
							$ticket = pdo_fetchcolumn( " SELECT max(`ticket`) FROM ".tablename('hc_credit_shopping_ticket')." WHERE goodsid='".$goods['goodsid']."' AND weid=".$_W['uniacid']." " );
							if(empty($ticket)){
								//如果为空，第一次插入
								$ticket = intval($goods['goodsid']) * 100000;
							}else{
								$ticket = intval($ticket) + 1;
							}
							$insert = array(
								'weid' => $_W['uniacid'],
								'openid' => $order['from_user'],
								'createtime' => TIMESTAMP,
								'memberid' => $memberid,
								'orderid' => $orderid,
								'goodsid' => $goods['goodsid'],
								'ticket' => $ticket,
							);
							pdo_insert('hc_credit_shopping_ticket',$insert);
							//插入完后商品已购买数量+1
							$gods = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_goods')." WHERE id='".$goods['goodsid']."'  " );

							WeUtility::logging("商品gods['ticket_total']", $gods['ticket_total']);

							$gods['ticket_total'] = intval($gods['ticket_total']) + 1;					
							if($gods['ticket_total'] >= $gods['total']){
								$gods['goods_status'] = 1;
								//随机抽取ticket
								$ticket_id = intval($goods['goodsid']) * 100000;
								$max_ticket = pdo_fetchcolumn( " SELECT max(ticket) FROM ".tablename('hc_credit_shopping_ticket')." WHERE goodsid=".$goods['goodsid']." AND weid=".$_W['uniacid']." " );
								$max = $max_ticket - $ticket_id;
								WeUtility::logging("max_ticket", $max_ticket);
								WeUtility::logging("max", $max);
							//	$random_ticket = $this->get_award_ticket($max);
							//	$check_result = $this->check_ticket($random_ticket,$goods['goodsid']);
								$result_ticket = $this->get_result_ticket($max,$goods['goodsid']);
								$member_openid = pdo_fetchcolumn( " SELECT openid FROM ".tablename('hc_credit_shopping_ticket')." WHERE ticket='".$result_ticket."' " );
								$member_nickname = pdo_fetchcolumn( " SELECT nickname FROM ".tablename('hc_credit_shopping_member')." WHERE openid='".$member_openid."' AND weid='".$_W['uniacid']."' " );
								$gods['ticket'] = $result_ticket;
								$gods['ticket_time'] = TIMESTAMP;
								$gods['ticket_nickname'] = $member_nickname;
								$gods['ticket_openid'] = $member_openid;
								$gods['ticket_msg'] = 1;
							}
							pdo_update('hc_credit_shopping_goods',$gods,array('id'=>$gods['id']));

							
						}
					}
							
					
					
					
					
					
					message('购买成功',$this->createMobileUrl('my_log'),'success');
				}
			}
		//	message('提交订单成功,现在跳转到付款页面...', $this->createMobileUrl('pay', array('orderid' => $orderid)), 'success');

	}
	//使用微信支付
	public function doMobilepay_weixin(){
		global $_W,$_GPC;
		checkauth();
		$this->check_bowser();
		$this->check_follow();
		$totalprice = 0;
		$allgoods = array();
		$id = intval($_GPC['id']);
		$optionid = intval($_GPC['optionid']);
		$total = intval($_GPC['total']);
		if ( (empty($total)) || ($total < 1) ) {
			$total = 1;
		}
		$direct = false; //是否是直接购买
		$returnurl = ""; //当前连接
		if (!$direct) {
			//如果不是直接购买（从购物车购买）
			$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_cart') . " WHERE  weid = '{$_W['uniacid']}' AND from_user = '{$_W['fans']['from_user']}'");
			if (!empty($list)) {
				foreach ($list as &$g) {
					$item = pdo_fetch("select id,goods_status,thumb,title,weight,marketprice,total,type,totalcnf,sales,unit from " . tablename("hc_credit_shopping_goods") . " where id=:id limit 1", array(":id" => $g['goodsid']));
					if($item['goods_status'] == 1){
						message("商品已过期，无法购买");
					}
					//属性
					$option = pdo_fetch("select title,marketprice,weight,stock from " . tablename("hc_credit_shopping_goods_option") . " where id=:id limit 1", array(":id" => $g['optionid']));
					if ($option) {
						$item['optionid'] = $g['optionid'];
						$item['title'] = $item['title'];
						$item['optionname'] = $option['title'];
						$item['marketprice'] = $option['marketprice'];
						$item['weight'] = $option['weight'];
					}
					$item['stock'] = $item['total'];
					$item['total'] = $g['total'];
					$item['totalprice'] = $g['total'] * $item['marketprice'];
					$allgoods[] = $item;
					$totalprice += $item['totalprice'];
					if ($item['type'] == 1) {
						$needdispatch = true;
					}
				}
				unset($g);
			}
			$returnurl = $this->createMobileUrl("confirm");
		}
		if (count($allgoods) <= 0) {
		//	header("location: " . $this->createMobileUrl('myorder'));
		//	exit();
		}

		//配送方式
		$dispatch = pdo_fetchall("select id,dispatchname,dispatchtype,firstprice,firstweight,secondprice,secondweight from " . tablename("hc_credit_shopping_dispatch") . " WHERE weid = {$_W['uniacid']} order by displayorder desc");
		foreach ($dispatch as &$d) {
			$weight = 0;
			foreach ($allgoods as $g) {
				$weight += $g['weight'] * $g['total'];
			}
			$price = 0;
			if ($weight <= $d['firstweight']) {
				$price = $d['firstprice'];
			} else {
				$price = $d['firstprice'];
				$secondweight = $weight - $d['firstweight'];
				if ($secondweight % $d['secondweight'] == 0) {
					$price += (int)($secondweight / $d['secondweight']) * $d['secondprice'];
				} else {
					$price += (int)($secondweight / $d['secondweight'] + 1) * $d['secondprice'];
				}
			}
			$d['price'] = $price;
		}
		unset($d);
			// 是否自提
			$sendtype = 1;
			$address = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_address') . " WHERE id = :id", array(':id' => intval($_GPC['address'])));
			if (empty($address)) {
				//message('抱歉，请您填写收货地址！');
			}
			// 商品价格
			$goodsprice = 0;
			foreach ($allgoods as $row) {
				$goodsprice += $row['totalprice'];
			}
			// 运费
			$dispatchid = intval($_GPC['dispatch']);
			$dispatchprice = 0;
			foreach ($dispatch as $d) {
				if ($d['id'] == $dispatchid) {
					$dispatchprice = $d['price'];
					$sendtype = $d['dispatchtype'];
				}
			}
			$price = $goodsprice + $dispatchprice;
			
			$data = array(
				'weid' => $_W['uniacid'],
				'from_user' => $_W['fans']['from_user'],
				'ordersn' => date('md') . random(4, 1),
				'price' => $goodsprice + $dispatchprice,
				'dispatchprice' => $dispatchprice,
				'goodsprice' => $goodsprice,
				'status' => 0,
				'sendtype' => intval($sendtype),
				'dispatch' => $dispatchid,
				'goodstype' => intval($item['type']),
				'remark' => $_GPC['remark'],
				'addressid' => $address['id'],
				'createtime' => TIMESTAMP
			);

			pdo_insert('hc_credit_shopping_order', $data);
			$orderid = pdo_insertid();
			//插入订单商品
			foreach ($allgoods as $row) {
				if (empty($row)) {
					continue;
				}
				$d = array(
					'weid' => $_W['uniacid'],
					'goodsid' => $row['id'],
					'orderid' => $orderid,
					'total' => $row['total'],
					'price' => $row['total'],
					'from_user' => $_W['openid'],
					'createtime' => TIMESTAMP,
					'optionid' => $row['optionid']
				);
				$o = pdo_fetch("select title from " . tablename('hc_credit_shopping_goods_option') . " where id=:id limit 1", array(":id" => $row['optionid']));
				if (!empty($o)) {
					$d['optionname'] = $o['title'];
				}
				pdo_insert('hc_credit_shopping_order_goods', $d);
			}
			// 清空购物车
			if (!$direct) {
				pdo_delete("hc_credit_shopping_cart", array("weid" => $_W['uniacid'], "from_user" => $_W['fans']['from_user']));
			}
			// 变更商品库存
			if (empty($item['totalcnf'])) {
				$this->setOrderStock($orderid);
			}


			
			message('提交订单成功,现在跳转到付款页面...', $this->createMobileUrl('pay', array('orderid' => $orderid)), 'success');

	}
	
	//使用积分支付
	public function doMobilepay_credit_shoppingbi(){
		global $_W,$_GPC;
		checkauth();
		$this->check_bowser();
		$this->check_follow();
		$totalprice = 0;
		$allgoods = array();
		$id = intval($_GPC['id']);
		$optionid = intval($_GPC['optionid']);
		$total = intval($_GPC['total']);
		if ( (empty($total)) || ($total < 1) ) {
			$total = 1;
		}
		$direct = false; //是否是直接购买
		$returnurl = ""; //当前连接

		$addressid = pdo_fetchcolumn(" SELECT id FROM ".tablename('hc_credit_shopping_address')." WHERE openid='".$_W['openid']."' AND weid='".$_W['uniacid']."' ");
		if(empty($addressid)){
			message('您尚未填写收获地址',$this->createMobileUrl('myaddress',array('return_url'=>'pay_credit_shoppingbi')),'success');
		}
		if (!$direct) {
			//如果不是直接购买（从购物车购买）
			$list = pdo_fetchall("SELECT * FROM " . tablename('hc_credit_shopping_cart') . " WHERE  weid = '{$_W['uniacid']}' AND from_user = '{$_W['fans']['from_user']}'");
			if (!empty($list)) {
				foreach ($list as &$g) {
					$item = pdo_fetch("select id,title,goods_status,thumb,title,weight,marketprice,total,type,totalcnf,sales,unit from " . tablename("hc_credit_shopping_goods") . " where id=:id limit 1", array(":id" => $g['goodsid']));
					if($item['goods_status'] == 1){
						message("商品已过期，无法购买");
					}
					//属性
					$option = pdo_fetch("select title,marketprice,weight,stock from " . tablename("hc_credit_shopping_goods_option") . " where id=:id limit 1", array(":id" => $g['optionid']));
					if ($option) {
						$item['optionid'] = $g['optionid'];
						$item['title'] = $item['title'];
						$item['optionname'] = $option['title'];
						$item['marketprice'] = $option['marketprice'];
						$item['weight'] = $option['weight'];
					}
					$item['stock'] = $item['total'];
					$item['total'] = $g['total'];
					$item['totalprice'] = $g['total'] * $item['marketprice'];
					$allgoods[] = $item;
					$totalprice += $item['totalprice'];
					if ($item['type'] == 1) {
						$needdispatch = true;
					}
				}
				unset($g);
			}
			$returnurl = $this->createMobileUrl("confirm");
		}
		if (count($allgoods) <= 0) {
		//	header("location: " . $this->createMobileUrl('myorder'));
		//	exit();
		}
		
		//如果没有商品，返回到商品首页
		if(empty($allgoods)){
			message("不能提交空的订单，正在为您返回到首页",$this->createMobileUrl('list'),'success');
		}

		//配送方式
		$dispatch = pdo_fetchall("select id,dispatchname,dispatchtype,firstprice,firstweight,secondprice,secondweight from " . tablename("hc_credit_shopping_dispatch") . " WHERE weid = {$_W['uniacid']} order by displayorder desc");
		foreach ($dispatch as &$d) {
			$weight = 0;
			foreach ($allgoods as $g) {
				$weight += $g['weight'] * $g['total'];
			}
			$price = 0;
			if ($weight <= $d['firstweight']) {
				$price = $d['firstprice'];
			} else {
				$price = $d['firstprice'];
				$secondweight = $weight - $d['firstweight'];
				if ($secondweight % $d['secondweight'] == 0) {
					$price += (int)($secondweight / $d['secondweight']) * $d['secondprice'];
				} else {
					$price += (int)($secondweight / $d['secondweight'] + 1) * $d['secondprice'];
				}
			}
			$d['price'] = $price;
		}
		unset($d);
			// 是否自提
			$sendtype = 1;
			$address = pdo_fetch("SELECT * FROM " . tablename('hc_credit_shopping_address') . " WHERE id = :id", array(':id' => intval($_GPC['address'])));
			if (empty($address)) {
				//message('抱歉，请您填写收货地址！');
			}
			// 商品价格
			$goodsprice = 0;
			foreach ($allgoods as $row) {
				$goodsprice += $row['totalprice'];
			}
			// 运费
			$dispatchid = intval($_GPC['dispatch']);
			$dispatchprice = 0;
			foreach ($dispatch as $d) {
				if ($d['id'] == $dispatchid) {
					$dispatchprice = $d['price'];
					$sendtype = $d['dispatchtype'];
				}
			}
			$price = $goodsprice + $dispatchprice;
			//如果交易币不够直接跳转到个人中心
			$check_bi = $this->get_credit_shoppingbi();
			if(empty($check_bi)){
				message("您的交易币不足，马上为您跳转到充值页面",$this->createMobileUrl('home'),'success');
			}else{
				if($check_bi == 0 || $check_bi < $price ){
				message("您的交易币不足，马上为您跳转到充值页面",$this->createMobileUrl('home'),'success');
				}
			}
			
			//检查商品有没有超过数量显示
			$check_limit = $this->check_goods_limit($allgoods);
			

			$data = array(
				'weid' => $_W['uniacid'],
				'from_user' => $_W['fans']['from_user'],
				'ordersn' => date('md') . random(4, 1),
				'price' => $goodsprice + $dispatchprice,
				'dispatchprice' => $dispatchprice,
				'goodsprice' => $goodsprice,
				'status' => 0,
				'sendtype' => intval($sendtype),
				'dispatch' => $dispatchid,
				'goodstype' => intval($item['type']),
				'remark' => $_GPC['remark'],
				'addressid' => $address['id'],
				'createtime' => TIMESTAMP
			);
			$address['realname'] = $_GPC['realname'];
			$address['mobile'] = $_GPC['mobile'];
			$address['address'] = $_GPC['address'];
			pdo_update('hc_credit_shopping_address',$address,array('id'=>$addressid));
			pdo_insert('hc_credit_shopping_order', $data);
			$orderid = pdo_insertid();
			//插入订单商品
			foreach ($allgoods as $row) {
				if (empty($row)) {
					continue;
				}
				$d = array(
					'weid' => $_W['uniacid'],
					'goodsid' => $row['id'],
					'orderid' => $orderid,
					'total' => $row['total'],
					'price' => $row['total'],
					'from_user' => $_W['openid'],
					'createtime' => TIMESTAMP,
					'optionid' => $row['optionid'],
					'goods_name' => $row['title'],
					'goods_img' => $row['thumb'],
				);
				$o = pdo_fetch("select title from " . tablename('hc_credit_shopping_goods_option') . " where id=:id limit 1", array(":id" => $row['optionid']));
				if (!empty($o)) {
					$d['optionname'] = $o['title'];
				}
				pdo_insert('hc_credit_shopping_order_goods', $d);
			}
			// 清空购物车
			if (!$direct) {
				pdo_delete("hc_credit_shopping_cart", array("weid" => $_W['uniacid'], "from_user" => $_W['fans']['from_user']));
			}
			// 变更商品库存
			if (!empty($item['totalcnf'])) {
				$this->setOrderStock($orderid);
				
			}

			//直接在这里使用积分支付
			$credit_shoppingbi = $this->get_credit_shoppingbi();
			$order = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_order')." WHERE id='".$orderid."' " );
			if($credit_shoppingbi < $order['price']){
				message("您的交易币不足，马上为您跳转到充值页面",$this->createMobileUrl('home'),'success');
			}else{
				$credit_shoppingbi = $credit_shoppingbi - $order['price'];
				if($credit_shoppingbi < 0){
					message("您的交易币不足，马上为您跳转到充值页面",$this->createMobileUrl('home'),'success');
				}else{
					//更新回fans表
					$uid = pdo_fetchcolumn(" SELECT uid FROM ".tablename('mc_mapping_fans')." WHERE openid='".$_W['openid']."' AND uniacid='".$_W['uniacid']."' ");
					$fans = pdo_fetch( " SELECT * FROM ".tablename('mc_members')." WHERE uid='".$uid."' " );
					$fans['credit1'] = $credit_shoppingbi;
					$flag = pdo_update('mc_members',$fans,array('uid'=>$uid));

					$order['status'] =1;
					$order['paytype'] =4;
					$order['addressid'] =$addressid;
					
				
					pdo_update('hc_credit_shopping_order',$order,array('id'=>$order['id']));
					
					message('购买成功',$this->createMobileUrl('myorder',array('status'=>2)),'success');
				}
			}
		//	message('提交订单成功,现在跳转到付款页面...', $this->createMobileUrl('pay', array('orderid' => $orderid)), 'success');

	}
	
//支付完成后改变商品状态
	public function after_pay($all_goods,$order,$memberid,$orderid){
		global $_W,$_GPC;
		

		
			
	}









	//检测是否注册，未注册的人先注册
	public function check_member(){
		global $_W,$_GPC;
		$openid = $_W['openid'];
		$setting = $this->module['config'];
		$url = $setting['guanzhu_url'];
		if(empty($openid)){
			//message( " 必须先关注公众号才能进行游戏 ", $setting['guanzhu_url'], 'success' );
						$this->error_tpl("必须先关注公众号才能进行游戏",$url);

		}
		$member = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_member')." WHERE weid=".$_W['uniacid']." AND openid='".$openid."' " );
		if(empty($member)){
			load()->classs('weixin.account');
			$accObj= WeixinAccount::create($_W['uniacid']);
			$access_token = $accObj->fetch_token();
			$ACCESS_TOKEN = $access_token;
			$OPENID = $_W['openid'];
			$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$ACCESS_TOKEN}&openid={$OPENID}&lang=zh_CN";
			$json = ihttp_get($url);
			$userInfo = @json_decode($json['content'], true);
			$ip = $_SERVER["REMOTE_ADDR"];
			$insert = array(
				'weid' => $_W['uniacid'],
				'nickname' => $userInfo['nickname'],
				'headimg' => $userInfo['headimgurl'],
				'createtime' => TIMESTAMP,
				'openid' => $openid,
				'ip' => $ip,
				'province' => $userInfo['province'],
				'city' => $userInfo['city'],
			);
			pdo_insert('hc_credit_shopping_member',$insert);
			$member = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_member')." WHERE weid=".$_W['uniacid']." AND openid='".$openid."' " );
		}
			return $member;
	}
	
	//错误消息模板
	public function error_tpl($msg,$url){
		global $_W;

			
			$msg = array(
				'type' => 1,
				'msg' => $msg,
				'title' => $_W['account']['name'],
				'text' => '确定',
				'url' => $url,
			);


		include $this->template('error_template');
		exit;
	}

	
	//检测是否关注，关注的人是否已注册
	public function check_follow(){
		global $_W,$_GPC;
		$openid = $_W['openid'];
		$setting = $this->module['config'];
		$url = $setting['guanzhu_url'];


		if(empty($openid)){
			//message( " 必须先关注本公众号才能进行游戏 ", $setting['guanzhu_url'], 'success' );

			$this->error_tpl("必须先关注本公众号才能进行游戏",$url);
		}
		$fans = pdo_fetch( " SELECT * FROM ".tablename('mc_mapping_fans')." WHERE openid='".$openid."' AND uniacid=".$_W['uniacid']." " );
		if(empty($fans) || $fans['follow'] == 0){
			//message( " 必须先关注本公众号才能进行游戏 ", $setting['guanzhu_url'], 'success' );
			$this->error_tpl("必须先关注本公众号才能进行游戏",$url);
		}
		
		//为已关注没有uid的用户添加uid

		  $openid = $_W['openid'];
          $uid = $_W['member']['uid'];
          if(!empty($openid) && empty($uid)){
               $default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['uniacid']));
                    $row = array(
                         'uniacid' => $_W['uniacid'],
                         'nickname'=>$info['nickname'],
                         'avatar'=>$info['headimgurl'],
                         'realname'=>$info['nickname'],
                         'groupid' => $default_groupid,
                         'email'=>random(32).'@we7.cc',
                         'salt'=>random(8),
                         'createtime'=>time()
                    );
                    pdo_insert('mc_members', $row);
                    $user['uid'] = pdo_insertid();
                    $fan = mc_fansinfo($_W['openid']);
                    //pdo_update('mc_mapping_fans', array('uid'=>$uid), array('openid'=>$_W['openid'], 'uniacid'=>$_W['uniacid']));
                    pdo_update('mc_mapping_fans', array('uid'=>$user['uid']), array('fanid'=>$fan['fanid']));
                    _mc_login($user);
          }
		
		
	}

	
	//查看计算详情
	public function doMobileview_ticket_total(){
		global $_W,$_GPC;
		$this->check_bowser();
		$this->check_follow();
		$goodsid = intval($_GPC['goodsid']);
		if(empty($goodsid)){
			message('查看的商品不存在');
		}
		$goods = pdo_fetch(" SELECT * FROM ".tablename('hc_credit_shopping_goods')." WHERE id='".$goodsid."' ");
		if($goods['goods_status'] !=1 ){
			message('查看的商品还未到开奖时间');
		}
		
		$award_openid = pdo_fetchcolumn( " SELECT openid FROM ".tablename('hc_credit_shopping_ticket')." WHERE ticket = '".$goods['ticket']."' " );
		$award_total = pdo_fetchcolumn( " SELECT COUNT(id) FROM ".tablename('hc_credit_shopping_ticket')." WHERE  goodsid='".$goodsid."' "  );
		$award_member = pdo_fetch( " SELECT * FROM ".tablename('hc_credit_shopping_member')." WHERE openid='".$award_openid."' AND weid=".$_W['uniacid']." " );
		$award_member_total =pdo_fetchcolumn( " SELECT COUNT(id) FROM ".tablename('hc_credit_shopping_ticket')." WHERE openid='".$award_openid."' AND goodsid='".$goodsid."' "  );
		
		$award_list = pdo_fetchall( " SELECT t.createtime,t.ticket,m.nickname FROM ".tablename('hc_credit_shopping_ticket')." AS t LEFT JOIN ".tablename('hc_credit_shopping_member')." AS m ON t.openid=m.openid WHERE t.goodsid='".$goodsid."' " );
		include $this->template('ticket_total');
	}
	
	
	//检测用户浏览器
	public function check_bowser(){
		$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
		if(strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false ){
		//	echo "请使用微信打开";
		//	exit;
		}
	}
	
	//随机中奖卡券
	public function get_award_ticket($max){
		$award = rand(0,$max);
		return $award;
	}
	//

	
	public function get_result_ticket($max,$goodsid){
		$award = rand(0,$max);
		$result_ticket = intval($goodsid) * 100000 + $award;
		$check_ticket = pdo_fetchcolumn( " SELECT id FROM ".tablename('hc_credit_shopping_ticket')." WHERE ticket=".$result_ticket." " );
		WeUtility::logging("抽奖award", $award);
		if(!empty($check_ticket)){
				//不为空说明有人中奖
						WeUtility::logging("result_ticket", $result_ticket);
						WeUtility::logging("asdfsdfsd", "sdfgasfdgadg");
			return $result_ticket;
			}else{
				//空说明无人中奖,调用自己
				WeUtility::logging("未中奖，当时的ticket是", $result_ticket);
				$this->get_result_ticket($max,$goodsid);
				
			}
	
		}
	
	//模板消息ajax
	public function doMobilesend_msg(){
		global $_W,$_GPC;
		$setting = $this->module['config'];
		$temp = $setting['countdown'] * 60;
		$all_msg = pdo_fetchall( " SELECT * FROM ".tablename('hc_credit_shopping_goods')." WHERE goods_status=1 AND ticket_msg !=3 AND weid='".$_W['uniacid']."' " );
		if(!empty($all_msg)){
				foreach($all_msg as $aaa){
					
				if($aaa['ticket_time'] + $temp < TIMESTAMP){
						$content = $this->sendMobilePayMsg($aaa);
					$info = @json_decode($content['content'], true);
					WeUtility::logging("模板消息返回码", $info['errcode']);
					WeUtility::logging("模板消息返回信息", $info['errmsg']);
					if($info['errcode'] == 0){
					//发送成功
					$aaa['ticket_msg'] = 3;
					pdo_update('hc_credit_shopping_goods',$aaa,array('id'=>$aaa['id']));
					}
			
				}
			}
		}

		exit;
	}
	
	
	 //模板消息函数
     public function sendMobilePayMsg($aaa) {
	 global $_W,$_GPC;
     $body = "";
     $template_id=$this->module['config']['template_id'];//消息模板id 微信的模板id
     $goodsname = $aaa['title'];
	 $first = "恭喜您参与的活动中奖了";
	 $remark = "请前往个人中心填写您的收货地址，方便我们与您联系";
	 $keyword1 = $_W['account']['name']."————积分商城";
	 $keyword2 = $goodsname;
     if (!empty($template_id)) {
            
      $datas=array(
                                   'first'=>array('value'=>$first,'color'=>'#173177'),
                                   'keyword1'=>array('value'=>$keyword1,'color'=>'#173177'),
                                   'keyword2'=> array('value'=>$keyword2,'color'=>'#173177'),
                                   'remark'=> array('value'=>$remark,'color'=>'#173177'),
               );
              
               $data=json_encode($datas); //发送的消息模板数据
          }
         
    if (!empty($template_id))
    {
      //$this->sendtempmsg($template_id, '', $data, '#FF0000');
     // $this->tempmsg($template_id, '', $data, '#FF0000');
       $appid = $_W['account']['key'];
		$appSecret = $_W['account']['secret'];
       $url = $_W['siteroot'].'app/'.$this->createMobileUrl('home',array(),true);
       $sendopenid = $aaa['ticket_openid'];
       $topcolor = "#FF0000";
    
       $callback = $this->tempmsg($template_id, $url, $data, $topcolor, $sendopenid, $appid, $appSecret);
	   return $callback;
    
    }
  }



     public function tempmsg($template_id, $url, $data, $topcolor, $sendopenid, $appid, $appSecret){
     global $_W,$_GPC;
          load()->func('communication');
     if ($data->expire_time < time()) {    
       $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appSecret."";
      $res = json_decode($this->httpGet($url));
      $tokens = $res->access_token;
    
    
          if(empty($tokens))
          {
          return;
          }
         
          $postarr = '{"touser":"'.$sendopenid.'","template_id":"'.$template_id.'","url":"","topcolor":"'.$topcolor.'","data":'.$data.'}';
          $res2 = ihttp_post('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$tokens,$postarr);

		return $res2;
    
     }
}


       private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }

	
	
	
	
	
	
	//获得积分
  public function get_credit_shoppingbi(){
  	global $_W;

  	$uid = pdo_fetchcolumn(" SELECT uid FROM ".tablename('mc_mapping_fans')." WHERE openid='".$_W['openid']."' AND uniacid='".$_W['uniacid']."' ");
  	if(!empty($uid)){
  		$fans = pdo_fetch(" SELECT * FROM ".tablename('mc_members')." WHERE uid='".$uid."' ");
  		if(!empty($uid)){
  			return $fans['credit1'];
  		}
  	}

  }
	
	
  //检查有没有超过商品数量限制
  public function check_goods_limit($allgoods){
  	global $_W;
  	$openid = $_W['openid'];
  	foreach ($allgoods as $key => $value) {
  		$goodsid = $value['id'];
  		$total = $value['total'];
  		$goods = pdo_fetch(" SELECT * FROM ".tablename('hc_credit_shopping_goods')." WHERE id='".$goodsid."' ");
  		if(empty($goods)){
  			message('商品不存在');
  		}else{
  			$maxbuy = $goods['maxbuy'];						//单次最多购买
  			$usermaxbuy = $goods['usermaxbuy'];				//用户最多购买
  			if($maxbuy !=0){
  				if($total > $maxbuy){
  					message("商品".$goods['title']."单次最多购买".$maxbuy."，您购买了".$total."，超过数量限制  ",$this->createMobileUrl('check_order'),'success');
  				}
  			}
  			if($usermaxbuy !=0){
  				$history_total = pdo_fetchcolumn(" SELECT SUM(`total`) FROM ".tablename('hc_credit_shopping_order_goods')." WHERE from_user='".$openid."' AND weid='".$_W['uniacid']."' AND goodsid='".$goodsid."' ");
  				if($history_total + $total > $usermaxbuy){
  					message("商品".$goods['title']."用户最多购买".$usermaxbuy."，您已经购买了".$history_total."，再次购买".$total."超过数量限制  ",$this->createMobileUrl('check_order'),'success');
  				}
  			}
  		}
  	}

  }
	
	
  public function doMobiletest_follow(){
  	global $_W;
  	echo 233;
  	echo "openid:";
  	var_dump($_W['openid']);
  	echo "<br/>";
	load()->classs('weixin.account');
  	$accObj= WeixinAccount::create($_W['uniacid']);
  	$access_token = $accObj->fetch_token();
  	$ACCESS_TOKEN = $access_token;
  	$OPENID = $_W['openid'];
  	$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$ACCESS_TOKEN}&openid={$OPENID}&lang=zh_CN";
  	$json = ihttp_get($url);
  	$userInfo = @json_decode($json['content'], true);

  	var_dump($userInfo);

  }











}
