<?php
/**
 * 附近门店 | 小程序模块微站定义
 *
 * @author 刘靜
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Jliu_shopModuleSite extends WeModuleSite {

	public $table_shop = 'jliu_shop';

	public function doWebLists()
	{
		global $_W,$_GPC;
        load()->func('tpl');
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'display') {
            $pindex = max(1, intval($_GPC['page']));
            $psize = 20;
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_shop) . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY displayorder DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
            $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_shop) . " WHERE uniacid = '{$_W['uniacid']}'");
            $pager = pagination($total, $pindex, $psize);
        } elseif ($operation == 'post') {
            $id = intval($_GPC['id']);
            if (checksubmit('submit')) {
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'enabled' => intval($_GPC['enabled']),
                    'recommend' => intval($_GPC['recommend']),
                    'content' => htmlspecialchars_decode($_GPC['content']),
                    'shop_name' => $_GPC['shop_name'],
                    'shop_logo' => $_GPC['shop_logo'],
                    'shop_des' => $_GPC['shop_des'],
                    'shop_address' => $_GPC['shop_address'],
                    'shop_tel' => $_GPC['shop_tel'],
                    'shop_time' => $_GPC['shop_time'],
                    'shop_lng' => $_GPC['location']['lng'],
                    'shop_lat' => $_GPC['location']['lat'],
                    'coupon_name' => $_GPC['coupon_name'],
                    'coupon_price' => $_GPC['coupon_price'],
                    'coupon_num' => intval($_GPC['coupon_num']),
                    'coupon_limit' => intval($_GPC['coupon_limit']),
                    'displayorder' => intval($_GPC['displayorder']),
                    'createtime' => TIMESTAMP,
                );
                // 百度坐标转换为腾讯坐标
                load()->func('communication');
                $url = 'http://apis.map.qq.com/ws/coord/v1/translate?locations='.$article['shop_lat'].','.$article['shop_lng'].'&type=3&key=R2IBZ-3KOWO-OBWWY-SXICZ-4WOGH-WUFKO';
                $res = ihttp_get($url);
                $content = json_decode($res['content'], true);
                if ($content['status'] === 0) {
                    $data['shop_lng_t'] = $content['locations'][0]['lng'];
                    $data['shop_lat_t'] = $content['locations'][0]['lat'];
                } else {
                    $data['shop_lng_t'] = $data['shop_lng'];
                    $data['shop_lat_t'] = $data['shop_lat'];
                }
                if (!empty($id)) {
                    unset($data['createtime']);
                    pdo_update($this->table_shop, $data, array('id' => $id));
                } else {
                    pdo_insert($this->table_shop, $data);
                    $id = pdo_insertid();
                }
                message('更新成功！', $this->createWebUrl('lists', array('op' => 'display')), 'success');
            }
            $shop = pdo_fetch("select * from " . tablename($this->table_shop) . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $id, ":uniacid" => $_W['uniacid']));
            if (empty($shop)) {
                $shop['displayorder'] = 0;
                $shop['enabled'] = 1;
            }
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            $shop = pdo_fetch("SELECT id FROM " . tablename($this->table_shop) . " WHERE id = '$id' AND uniacid=" . $_W['uniacid'] . "");
            if (empty($shop)) {
                message('抱歉，不存在或是已经被删除！', $this->createWebUrl('lists', array('op' => 'display')), 'error');
            }
            pdo_delete($this->table_shop, array('id' => $id));
			message('删除成功', referer(), 'success');
        }
        include $this->template('shop');
	}
}