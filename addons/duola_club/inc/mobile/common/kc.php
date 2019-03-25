<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $openid = $_W['openid'];
        $schoolid = intval($_GPC['schoolid']);
		$userss = intval($_GPC['userid']);
		if (empty($schoolid)) {
			message('没有找到该学校，请联系管理员！');
		}
		$user = pdo_fetchall("SELECT * FROM " . tablename($this->table_user) . " where :weid = weid And :openid = openid And :tid = tid", array(
				':weid' => $weid,
				':openid' => $openid,
				':tid' => 0
				));
		$num = count($user);
		$flag = 1;
		if ($num > 1){
			$flag = 2;
		}
		foreach($user as $key => $row){
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id=:id ", array(':id' => $row['sid']));
			$bajinam = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid=:sid ", array(':sid' => $student['bj_id']));
			$user[$key]['s_name'] = $student['s_name'];
			$user[$key]['bjname'] = $bajinam['sname'];
			$user[$key]['sid'] = $student['id'];
			$user[$key]['schoolid'] = $student['schoolid'];
		}
		if(!empty($userss)){
			$ite = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And weid = :weid AND id=:id ", array(':schoolid' => $schoolid,':weid' => $weid, ':id' => $userss));
			if(!empty($ite)){
				$_SESSION['user'] = $ite['id'];
			}			
		}else{
			if(empty($_SESSION['user'])){
				$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :tid = tid LIMIT 0,1 ", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':tid' => 0), 'id');
				if(!empty($userid)){
					$_SESSION['user'] = $userid['id'];
				}							
			}
		}
		$leixing = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " WHERE weid = :weid ORDER BY id ASC, ssort DESC", array(':weid' => $weid), 'id');
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));

        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id ", array(':id' => $id));
        $title = $item['title'];
        $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid = :schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
//		$km = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));
		$xueqi = $km = $districtCenter = $xq = $sd = $courseCats = $menu = array();
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
					case 'navBar':
						$menu[] = $cate;
						break;
					default:
						break;
				}
			}
		}
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $sid));
		$condition = '';
		if(!empty($_GPC['typeName'])){
			switch($_GPC['typeName']){
				case 'km':
					$cid = intval($_GPC['typeId']);
					$condition .= " AND km_id = '{$cid}'";
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
					if(count($km_ids) > 0){
						$condition .= " AND km_id in (".join(',',$km_ids).")";
					}
					break;
				case 'center':
					$district_center_id = $_GPC['typeId'];
					$condition .= " AND district_center_id = {$district_center_id}";
					break;
				case 'keyword':
					$name = trim($_GPC['typeId']);
					$condition .= " AND name LIKE '%{$name}%' ";
					break;
				case 'menu':
					$courses = array_filter($courseCats,function($item) use ($_GPC){
						if($item['parentid'] == $_GPC['typeId']){
							return true;
						}
						return false;
					});
					if($courses){
						//查找科目
						$kms = array();
						foreach($courses as $course){
							foreach($km as $item){
								if($item['parentid'] == $course['sid']){
									$kms[] = $item;
								}
							}
						}
						$km_ids = array_column($kms,'sid');
					}else{
						$km_ids = array();
					}
					if(count($km_ids) > 0){
						$condition .= " AND km_id in (".join(',',$km_ids).")";
					}
					break;
				default:
					break;
			}
		}
		$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND is_show = :is_show AND start > :start  $condition ORDER BY ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_show' => 1,':start' => strtotime(date('Y-m-d'))));

		include $this->template(''.$school['style1'].'/kc');
?>