<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

        global $_GPC, $_W;
		$weid = $_W['uniacid'];
		$action = 'guid';
		load()->func('tpl');
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'display') {
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_banners) . " WHERE weid = '{$weid}' AND leixing = 4 ORDER BY displayorder DESC"); 
        } elseif ($operation == 'post') {
            $id = intval($_GPC['id']);
            if (checksubmit('submit')) {
                $data = array(
                    'weid' => intval($weid),
					'uniacid' => intval($weid),
                    'schoolid' => $schoolid,
                    'bannername' => $_GPC['bannername'],
                    'thumb' => !empty($_GPC['thumb']) ? implode(',',$_GPC['thumb']) : $_GPC['old_thumb'],
                    'enabled' => intval($_GPC['enabled']),
					'begintime' => strtotime($_GPC['begintime']),
					'endtime' => strtotime($_GPC['endtime']),
					'arr' => implode(',',$_GPC['arr']),
					'place' => intval($_GPC['place']),
					'leixing' => 4
                );
				if($_GPC['thumb']){
					$thumb = implode(',',$_GPC['thumb']);
					$thumbs = explode(',',$thumb);
					if(count($thumbs) >= 10){
						message('抱歉，引导图组不能大于9张', $this->createWebUrl('guid', array('op' => 'display')), 'error');
					}
				}else{
					if(empty($_GPC['old_thumb'])){
						message('抱歉，图片不能为空！', $this->createWebUrl('guid', array('op' => 'display')), 'error');
					}
				}
                if (!empty($id)) {
                    pdo_update($this->table_banners, $data, array('id' => $id));
                } else {
                    pdo_insert($this->table_banners, $data);
                }
                message('更新成功！', $this->createWebUrl('guid', array('op' => 'display')), 'success');
            }
            $banner = pdo_fetch("select * from " . tablename($this->table_banners) . " where id = :id And weid = :weid limit 1", array(":id" => $id, ":weid" => $weid));
			$school = pdo_fetchall("SELECT * FROM " . tablename($this->table_index) . " where weid = '{$weid}' ORDER BY ssort DESC", array(':weid' => $weid));
			$uniarr = explode(',',$banner['arr']);
			$imgsss = explode(',',$banner['thumb']);
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            $banner = pdo_fetch("SELECT id  FROM " . tablename($this->table_banners) . " WHERE id = '{$id}' AND weid='{$weid}'");
            if (empty($banner)) {
                message('抱歉，不存在或是已经被删除！', $this->createWebUrl('guid', array('op' => 'display')), 'error');
            }
            pdo_delete($this->table_banners, array('id' => $id));
            message('删除成功！', $this->createWebUrl('guid', array('op' => 'display')), 'success');
        } else {
            message('请求方式不存在');
        }
		include $this->template('web/guid');
?>