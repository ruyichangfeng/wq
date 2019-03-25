<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

        global $_GPC, $_W;
        //$GLOBALS['frames'] = $this->getNaveMenu();
		$weid = $_W['uniacid'];
		$action = 'comad';
		load()->func('tpl');
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'display') {
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_banners) . " WHERE weid = '{$weid}' AND leixing = 2 ORDER BY displayorder DESC");
		    
        } elseif ($operation == 'post') {

            $id = intval($_GPC['id']);
			
            if (checksubmit('submit')) {
                $data = array(
                    'weid' => intval($weid),
					'uniacid' => intval($weid),
                    'schoolid' => $schoolid,
                    'bannername' => $_GPC['bannername'],
                    'link' => $_GPC['link'],
                    'thumb' => $_GPC['thumb'],
                    'enabled' => intval($_GPC['enabled']),
					'begintime' => strtotime($_GPC['begintime']),
					'endtime' => strtotime($_GPC['endtime']),
					'arr' => implode(',',$_GPC['arr']),
                    'displayorder' => intval($_GPC['displayorder']),
					'leixing' => 2
                );
               
                if (!empty($id)) {
                    pdo_update($this->table_banners, $data, array('id' => $id));
					load()->func('file');
					file_delete($_GPC['thumb_old']);
					$thisid = $id;
                } else {
                    pdo_insert($this->table_banners, $data);
					$thisid = pdo_insertid();
                }
				 $arr = $_GPC ['arr'];
				 foreach($arr as $row){
					 pdo_update($this->table_index, array('is_showad' => $thisid), array('id' => $row));
				 }
                message('操作成功成功！', $this->createWebUrl('comad', array('op' => 'display')), 'success');
            }
            $banner = pdo_fetch("select * from " . tablename($this->table_banners) . " where id = :id And weid = :weid limit 1", array(":id" => $id, ":weid" => $weid));
			$school = pdo_fetchall("SELECT * FROM " . tablename($this->table_index) . " where weid = '{$weid}' ORDER BY ssort DESC", array(':weid' => $weid));
			$uniarr = explode(',',$banner['arr']);
			
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            $banner = pdo_fetch("SELECT id  FROM " . tablename($this->table_banners) . " WHERE id = '{$id}' AND weid='{$weid}'");
            if (empty($banner)) {
                message('抱歉，此信息不存在或是已经被删除！', $this->createWebUrl('comad', array('op' => 'display')), 'error');
            }
            pdo_delete($this->table_banners, array('id' => $id));
            message('删除成功！', $this->createWebUrl('comad', array('op' => 'display')), 'success');
        } else {
            message('请求方式不存在');
        }
		include $this->template('web/comad');
?>