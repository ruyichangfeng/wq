<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $this->weid;
        $from_user = $this->_fromuser;
        $do = 'rest';
		$cityid = intval($_GPC['cityid']);
        $areaid = intval($_GPC['areaid']);
        $typeid = intval($_GPC['typeid']);
        $sortid = intval($_GPC['sortid']);
        $lat = trim($_GPC['lat']);
        $lng = trim($_GPC['lng']);

        
        if ($areaid != 0) {
            $strwhere .= " AND areaid = '{$areaid}' ";
        }

        if ($typeid != 0) {
            $strwhere .= " AND typeid= '{$typeid}' ";
        }
		
        if ($cityid != 0) {
            $strwhere .= " AND cityid= '{$cityid}' ";
        }		
        //所属城市
        $citys = pdo_fetchall("SELECT * FROM " . tablename($this->table_area) . " where weid = '{$weid}' And type = 'city' ORDER BY ssort DESC");
		//print_r($city);
		if ($citys){
        //所属区域
        $area = pdo_fetchall("SELECT * FROM " . tablename($this->table_area) . " where weid = '{$weid}' And parentid = '{$cityid}' ORDER BY ssort DESC");
        $curarea = "全部";
			if (!empty($area[$areaid]['name'])) {
				$curarea = $area[$areaid]['name'];
			}
		}else{
			$area = pdo_fetchall("SELECT * FROM " . tablename($this->table_area) . " where weid = '{$weid}' And type = '' ORDER BY ssort DESC");
			$curarea = "全部";
			if (!empty($area[$areaid]['name'])) {
				$curarea = $area[$areaid]['name'];
			}			
		}
        //学校类型
        $shoptypes = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " where weid = :weid ORDER BY ssort DESC", array(':weid' => $weid));

		if ($sortid == 1) {
			$restlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_index) . " where weid = '{$weid}' and is_show=1 $strwhere ORDER BY is_show DESC,ssort DESC, id DESC");
		} else if ($sortid == 2) {
			$restlist = pdo_fetchall("SELECT *,(lat-'{$lat}') * (lat-'{$lat}') + (lng-'{$lng}') * (lng-'{$lng}') as dist FROM " . tablename($this->table_index) . " WHERE weid = '{$weid}' and is_show = 1 $strwhere ORDER BY dist, ssort DESC,id DESC");
		} else {
			$restlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_index) . " where weid = '{$weid}' and is_show=1 $strwhere ORDER BY is_show DESC,ssort DESC");
		}
		    foreach($restlist as $key => $row){
				$shoptype = pdo_fetch("SELECT name FROM " . tablename($this->table_type) . " where weid = :weid And id = :id", array(':weid' => $weid,':id' => $row['typeid']));
				$city = pdo_fetch("SELECT name FROM " . tablename($this->table_area) . " where weid = :weid And id = :id", array(':weid' => $weid,':id' => $row['cityid']));
				$quyu = pdo_fetch("SELECT name FROM " . tablename($this->table_area) . " where weid = :weid And id = :id", array(':weid' => $weid,':id' => $row['areaid']));
				$restlist[$key]['leixing'] = $shoptype['name'];
				$restlist[$key]['city'] = $city['name'];
				$restlist[$key]['quyu'] = $quyu['name'];
			}

        include $this->template('wapindex');
?>