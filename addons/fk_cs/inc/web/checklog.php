<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

        global $_GPC, $_W;
		
		$weid = $_W['uniacid'];
		$action = 'checklog';
		$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$action);
		$schoolid = intval($_GPC['schoolid']);
		$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
		load()->func('tpl');
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'display') {
            $pindex = max(1, intval($_GPC['page']));
            $psize = 20;
            $condition = '';
			if ($_GPC['type'] ==1) {
				$type = intval($_GPC['type']);
				$condition .= " AND leixing = '{$type}' ";
			}
			if ($_GPC['type'] ==2) {
				$type = intval($_GPC['type']);
				$condition .= " AND leixing = '{$type}' ";
			}
			if ($_GPC['type'] ==3) {
				$type = intval($_GPC['type']);
				$condition .= " AND leixing = '{$type}' ";
			}
			if ($_GPC['shenfen'] ==1) {
				$condition .= " AND sid > 0 ";
			}
			if ($_GPC['shenfen'] ==2) {
				$condition .= " AND tid > 0 ";
			}			
			if(!empty($_GPC['bj_id'])) {
				$condition .= " AND bj_id = '{$_GPC['bj_id']}' ";
			}	
			if(!empty($_GPC['createtime'])) {
				$starttime = strtotime($_GPC['createtime']['start']);
				$endtime = strtotime($_GPC['createtime']['end']) + 86399;
				$condition .= " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
			} else {
				$starttime = strtotime('-30 day');
				$endtime = TIMESTAMP;
			}
			$params[':start'] = $starttime;
			$params[':end'] = $endtime;	
			
			$allbj = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND weid = '{$weid}' AND type = 'theclass' ORDER BY ssort DESC");
			
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);

			foreach($list as $index =>$row){
				$student = pdo_fetch("SELECT s_name FROM " . tablename($this->table_students) . " WHERE id = '{$row['sid']}' ");
				$teacher = pdo_fetch("SELECT tname FROM " . tablename($this->table_teachers) . " WHERE id = '{$row['tid']}' ");
				$idcard = pdo_fetch("SELECT pname FROM " . tablename($this->table_idcard) . " WHERE idcard = '{$row['cardid']}' ");
				$mac = pdo_fetch("SELECT name FROM " . tablename($this->table_checkmac) . " WHERE schoolid = '{$row['schoolid']}' And id = '{$row['macid']}' ");
				$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = '{$row['bj_id']}' ");
					$list[$index]['s_name'] = $student['s_name'];
					$list[$index]['tname'] = $teacher['tname'];
					$list[$index]['mac'] = $mac['name'];
					$list[$index]['pname'] = $idcard['pname'];
					$list[$index]['bj_name'] = $banji['sname'];
			}	
            $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_checklog) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} $condition");

            $pager = pagination($total, $pindex, $psize);
			
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            $checklog = pdo_fetch("SELECT id  FROM " . tablename($this->table_checklog) . " WHERE id = '$id' ");
            if (empty($checklog)) {
                message('抱歉，不存在或是已经被删除！', $this->createWebUrl('checklog', array('op' => 'display', 'schoolid' => $schoolid)), 'error');
            }
            pdo_delete($this->table_checklog, array('id' => $id));
            message('删除成功！', $this->createWebUrl('checklog', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
        } elseif ($operation == 'deleteall') {
            $rowcount = 0;
            $notrowcount = 0;
            foreach ($_GPC['idArr'] as $k => $id) {
                $id = intval($id);
                if (!empty($id)) {
                    $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " WHERE id = :id", array(':id' => $id));
                    if (empty($goods)) {
                        $notrowcount++;
                        continue;
                    }
                    pdo_delete($this->table_checklog, array('id' => $id, 'weid' => $weid));
                    $rowcount++;
                }
            }
            message("操作成功！");
        } else {
            message('请求方式不存在');
        }
		include $this->template('web/checklog');
?>