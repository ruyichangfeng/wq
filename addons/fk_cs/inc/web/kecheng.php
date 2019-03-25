<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_GPC, $_W;
       
        $weid = $_W['uniacid'];
        $action = 'kecheng';
		$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$action);
	    $schoolid = intval($_GPC['schoolid']);
		$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where id = :id ", array(':id' => $schoolid));

		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $sid));
        $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
        $xueqi = $km = $districtCenter = $xq = $sd = $courseCats = $qh = $classSize = array();
        foreach($category as $key => $value){
            switch($value['type']){
                case 'semester':
                    $xueqi[] = $value;
                    break;
                case 'subject':
                    $km[] = $value;
                    break;
                case 'districtCenter':
                    $districtCenter[] = $value;
                    break;
                case 'subject':
                    $km[] = $value;
                    break;
                case 'week':
                    $xq[] = $value;
                    break;
                case 'timeframe':
                    $sd[] = $value;
                    break;
                case 'courseClassification':
                    $courseCats[] = $value;
                    break;
                case 'score':
                    $qh[] = $value;
                    break;
                case 'classSize':
                    $classSize[] = $value;
                    break;
                default:
                    break;
            }
        }
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'post') {
            load()->func('tpl');
            $id = intval($_GPC['id']);
			$payweid = pdo_fetchall("SELECT * FROM " . tablename('account_wechats') . " where level = 4 ORDER BY acid ASC");
            if (!empty($id)) {
                $item = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id ", array(':id' => $id));
				$teachers = pdo_fetchall("SELECT * FROM " . tablename ($this->table_teachers) . " where weid = :weid And schoolid = :schoolid ", array(
					':weid' => $weid,
					':schoolid' => $schoolid
				));
                if (empty($item)) {   
                    message('抱歉，本条信息不存在在或是已经删除！', '', 'error');
                }
            }
            if (checksubmit('submit')) {
                $data = array(
				    'weid' => $weid,
					'schoolid' => $schoolid,
					'tid' => intval($_GPC['tid']),
					'xq_id' => trim($_GPC['xq']),
					'km_id' => trim($_GPC['km']),
					'bj_id' => trim($_GPC['bj']),
					'name' => trim($_GPC['name']),
					'minge' => trim($_GPC['minge']),
					'yibao' => trim($_GPC['yibao']),
					'cose' => trim($_GPC['cose']),
					'dagang' => trim($_GPC['dagang']),
					'adrr' => trim($_GPC['adrr']),
					'is_hot' => intval($_GPC['is_hot']),
					'is_show' => intval($_GPC['is_show']),
                    'is_weekend' => intval($_GPC['is_weekend']),
                    'is_drop_in' => intval($_GPC['is_drop_in']),
                    'class_size' => intval($_GPC['class_size']),
                    'class_hour' => trim($_GPC['class_hour']),
                    'district_center_id' => intval($_GPC['district_center_id']),
                    'is_welfare' => intval($_GPC['is_welfare']),
                    'thumb' => trim($_GPC['thumb']),
					'ssort' => intval($_GPC['ssort']),
					'start' => strtotime($_GPC['start']),
					'end' => strtotime($_GPC['end']),
                    'video' => trim($_GPC['video']),
                    'video1' => trim($_GPC['video1']),
                    'videostart' => trim($_GPC['videostart']),
                    'videoend' => trim($_GPC['videoend']),
                    'class_describe' => trim($_GPC['class_describe']),
					'payweid' => empty($_GPC['payweid']) ? $weid : intval($_GPC['payweid']),
                );
                if (empty($id)) {
                    message('抱歉，本条信息不存在在或是已经删除！', '', 'error');
                } else {
                    pdo_update($this->table_tcourse, $data, array('id' => $id));
                }
                message('修改成功！', $this->createWebUrl('kecheng', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
            }
        } elseif ($operation == 'display') {
            if (checksubmit('submit')) { //排序
                if (is_array($_GPC['ssort'])) {
                    foreach ($_GPC['ssort'] as $id => $val) {
                        $data = array('ssort' => intval($_GPC['ssort'][$id]));
                        pdo_update($this->table_tcourse, $data, array('id' => $id));
                    }
                }
                message('批量修排序成功!', $url);
            }			

            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;
            $condition = '';
			
		    if (!empty($_GPC['name'])) {
                $condition .= " AND name LIKE '%{$_GPC['name']}%' ";
            }
						
            if (!empty($_GPC['bj_id'])) {
                $cid = intval($_GPC['bj_id']);
                $condition .= " AND bj_id = '{$cid}'";
            }	
						
            if (!empty($_GPC['km_id'])) {
                $cid = intval($_GPC['km_id']);
                $condition .= " AND km_id = '{$cid}'";
            }

            if (!empty($_GPC['district_center_id'])) {
                $district_center_id = $_GPC['district_center_id'];
                $condition .= " AND district_center_id = {$district_center_id}";
            }

            if (!empty($_GPC['lb_id'])) {
                $kms = array_filter($km,function($item) use ($_GPC){
                    if($item['parentid'] == $_GPC['lb_id']){
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
            }

            $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
				foreach($list as $key => $row){
					$teacher = pdo_fetch("SELECT * FROM " . tablename ($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
					$list[$key]['tname'] = $teacher['tname'];
				}
            $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_tcourse) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} $condition");

            $pager = pagination($total, $pindex, $psize);
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if (empty($id)) {
                message('抱歉，本条信息不存在在或是已经被删除！');
            }
            pdo_delete($this->table_tcourse, array('id' => $id));
            message('删除成功！', referer(), 'success');
        } elseif ($operation == 'deleteall') {
            $rowcount = 0;
            $notrowcount = 0;
            foreach ($_GPC['idArr'] as $k => $id) {
                $id = intval($id);
                if (!empty($id)) {
                    $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id", array(':id' => $id));
                    if (empty($goods)) {
                        $notrowcount++;
                        continue;
                    }
                    pdo_delete($this->table_tcourse, array('id' => $id, 'weid' => $weid));
                    $rowcount++;
                }
            }
            message("操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!", '', 0);
        } elseif ($operation == 'add') {
			load()->func('tpl');
            $id = intval($_GPC['id']);
           // $row = pdo_fetch("SELECT id, thumb FROM " . tablename($this->table_tcourse) . " WHERE id = :id", array(':id' => $id));
            if (!empty($id)) {
                $item = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id", array(':id' => $id));	
				$teachers = pdo_fetch("SELECT * FROM " . tablename ($this->table_teachers) . " where id = :id ", array(':id' => $item['tid']));				
                if (empty($item)) {
                    message('抱歉，教师不存在或是已经删除！', '', 'error');
                }
            }
			if (checksubmit('submit')) {
                $data = array(
				    'weid' => $weid,
					'schoolid' => $schoolid,
					'tid' => intval($_GPC['tid']),
					'kcid' => trim($_GPC['kcid']),
					'bj_id' => trim($_GPC['bj_id']),
					'km_id' => trim($_GPC['km_id']),					
					'sd_id' => trim($_GPC['sd']),
					'xq_id' => trim($_GPC['xq']),					
					'nub' => trim($_GPC['nub']),
					'isxiangqing' => trim($_GPC['isxiangqing']),
					'content' => trim($_GPC['content']),
					'date' => strtotime($_GPC['date']),
                );

                if (istrlen($data['nub']) == 0) {
                    message('没有输入编号.', '', 'error');
                }	
										
				pdo_insert($this->table_kcbiao, $data);
					message('操作成功', $this->createWebUrl('kecheng', array('op' => 'display', 'schoolid' => $schoolid)), 'success');    
            }
		}	
        include $this->template ( 'web/kecheng' );
?>