<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_GPC, $_W;
        //$GLOBALS['frames'] = $this->getNaveMenu();
        $weid = $_W['uniacid'];  
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'display') {
            if (!empty($_GPC['ssort'])) {
                foreach ($_GPC['ssort'] as $id => $ssort) {
                    pdo_update($this->table_area, array('ssort' => $ssort), array('id' => $id));
                }
                message('城市排序更新成功！', $this->createWebUrl('city', array('op' => 'display')), 'success');
            }
            $children = array();
            $city = pdo_fetchall("SELECT * FROM " . tablename($this->table_area) . " WHERE weid = '{$weid}' And type = 'city'  ORDER BY parentid ASC, ssort DESC");
            foreach ($city as $index => $row) {
                if (!empty($row['parentid'])) {
                    $children[$row['parentid']][] = $row;
                    unset($city[$index]);
                }
            }
        } elseif ($operation == 'post') {
            $parentid = intval($_GPC['parentid']);
            $id = intval($_GPC['id']);
            if (!empty($id)) {
                $city = pdo_fetch("SELECT * FROM " . tablename($this->table_area) . " WHERE id = '{$id}'");
            } else {
                $city = array(
                    'ssort' => 0,
                );
            }

            if (checksubmit('submit')) {
                if (empty($_GPC['catename'])) {
                    message('请输入城市名称！');
                }

                $data = array(
                    'weid' => $weid,
                    'name' => $_GPC['catename'],
                    'ssort' => intval($_GPC['ssort']),
                    'parentid' => intval($parentid),
					'type' => 'city',
                );


                if (!empty($id)) {
                    unset($data['parentid']);
                    pdo_update($this->table_area, $data, array('id' => $id));
                } else {
                    pdo_insert($this->table_area, $data);
                    $id = pdo_insertid();
                }
                message('更新城市成功！', $this->createWebUrl('city', array('op' => 'display')), 'success');
            }
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            $city = pdo_fetch("SELECT id, parentid FROM " . tablename($this->table_area) . " WHERE id = '{$id}'");
            if (empty($city)) {
                message('抱歉，城市不存在或是已经被删除！', $this->createWebUrl('city', array('op' => 'display')), 'error');
            }
            pdo_delete($this->table_area, array('id' => $id, 'parentid' => $id), 'OR');
            message('城市删除成功！', $this->createWebUrl('city', array('op' => 'display')), 'success');
        }
   include $this->template ( 'web/city' );
?>