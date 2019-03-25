<?php
/**
 * 附近门店 | 小程序模块小程序接口定义
 *
 * @author 刘靜
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Jliu_shopModuleWxapp extends WeModuleWxapp {
	
	public $table_shop = 'jliu_shop';

	public function doPageList(){
		global $_GPC, $_W;
		$keyword = $_GPC['keyword'];
		$longitude = $_GPC['longitude'];
		$latitude = $_GPC['latitude'];

		$condition = '';
		if (!empty($keyword)) {
			$condition .= " AND shop_name LIKE '%{$keyword}%'";
		}

		$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_shop) . " WHERE uniacid = '{$_W['uniacid']}' " . $condition . " ORDER BY displayorder DESC limit 100");

		$i = 0;
		if (!empty($list)) foreach ($list as &$value) {
			$value['shop_id'] = $value['id'];
			$value['id'] = $i;
			$value['shop_lat'] = (double)$value['shop_lat_t'];
            $value['shop_lng'] = (double)$value['shop_lng_t'];
            $value['shop_logo'] = tomedia($value['shop_logo']);
            $value['distance'] = sprintf('%.2f', $this->getDistance($latitude, $longitude, $value['shop_lat_t'], $value['shop_lng_t']));
            $i ++;
		}

		return $this->result(0, 'success', $list);
	}

	private function getDistance($lat1, $lng1, $lat2, $lng2, $miles = true) 
	{
		$pi80 = M_PI / 180;
		$lat1 *= $pi80;
		$lng1 *= $pi80;
		$lat2 *= $pi80;
		$lng2 *= $pi80;
		$r = 6372.797; // mean radius of Earth in km
		$dlat = $lat2 - $lat1;
		$dlng = $lng2 - $lng1;
		$a = sin($dlat/2)*sin($dlat/2)+cos($lat1)*cos($lat2)*sin($dlng/2)*sin($dlng/2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$km = $r * $c;
		return ($miles ? ($km * 0.621371192) : $km);
	}
}