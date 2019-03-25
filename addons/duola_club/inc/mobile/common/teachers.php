<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $this->weid;
        $from_user = $this->_fromuser;
		$schoolid = intval($_GPC['schoolid']);
        $i = intval($_GPC['i']);
        $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$_W['uniacid']}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'sid');
        $xueqi = $km = $districtCenter = $xq = $sd = $courseCats = array();
        if (!empty($category)) {
            $children = '';
            foreach ($category as $cid => $cate) {
                if (!empty($cate['parentid'])) {
                    $children[$cate['parentid']][$cate['id']] = array($cate['id'], $cate['name']);
                }
                switch($cate['type']){
                    case 'semester':
                        $xueqi[] = $cate;
                        break;
                    case 'subject':
                        $km[] = $cate;
                        break;
                    case 'districtCenter':
                        $districtCenter[] = $cate;
                        break;
                    case 'subject':
                        $km[] = $cate;
                        break;
                    case 'week':
                        $xq[] = $cate;
                        break;
                    case 'timeframe':
                        $sd[] = $cate;
                        break;
                    case 'courseClassification':
                        $courseCats[] = $cate;
                        break;
                    default:
                        break;
                }
            }
        }
        $condition = '';
        if(!empty($_GPC['typeName'])){
            switch($_GPC['typeName']){
                case 'km':
                    $km_id = intval($_GPC['typeId']);
                    $condition .= " AND (km_id1 = '{$km_id}' or km_id2 = '{$km_id}' or km_id3 = '{$km_id}')";
                    break;
                case 'lb':
                    $kms = array_filter($km,function($item) use ($_GPC){
                        if($item['parentid'] == $_GPC['typeId']){
                            return true;
                        }
                        return false;
                    });
                    if($kms){
                        $km_ids = array_column($kms,'sid');
                    }else{
                        $km_ids = array();
                    }
                    if(count($km_ids > 0)){
                        $condition .= " AND (km_id1 in (".join(',',$km_ids).") or km_id2 in (".join(',',$km_ids).") or km_id3 in (".join(',',$km_ids)."))";
                    }
                    break;
                case 'center':
                    $district_center_id = $_GPC['typeId'];
                    $condition .= " AND district_center_id = {$district_center_id}";
                    break;
                case 'sex':
                    $sex = intval($_GPC['typeId']);
                    $condition .= " AND sex = {$sex}";
                    break;
                case 'keyword':
                    $name = trim($_GPC['typeId']);
                    $condition .= " AND tname LIKE '%{$name}%' ";
                    break;
                default:
                    break;
            }
        }
		//教师列表按教师入职时间先后顺序排列，先入职再前
		$leixing = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " WHERE weid = '{$_W['uniacid']}' ORDER BY id ASC, ssort DESC", array(':weid' => $_W['uniacid']), 'id');
        $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE weid = '{$_W['uniacid']}' AND schoolid ={$schoolid} AND is_show = 0  $condition ORDER BY jiontime ASC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_show' => 0));
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE schoolid = :schoolid ", array(':schoolid' => $schoolid));
        $school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
        include $this->template(''.$school['style1'].'/teachers');
?>