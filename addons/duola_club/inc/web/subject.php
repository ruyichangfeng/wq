<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

        global $_GPC, $_W;
        $weid = $_W['uniacid'];		
		$action = 'subject';
		$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$action);
		$schoolid = intval($_GPC['schoolid']);
		$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $courseCats = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And type = 'courseClassification' And schoolid = {$schoolid} ORDER BY sid ASC, ssort DESC");
        if ($operation == 'display') {
            if (!empty($_GPC['ssort'])) {
                foreach ($_GPC['ssort'] as $sid => $ssort) {
                    pdo_update($this->table_classify, array('ssort' => $ssort), array('sid' => $sid));
                }
                message('批量更新排序成功', $this->createWebUrl('subject', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
            }
            $subject = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = '{$weid}' And type = 'subject' And schoolid = {$schoolid} ORDER BY sid ASC, ssort DESC");
            foreach($courseCats as $key => $value){
                unset($courseCats[$key]);
                $courseCats[$value['sid']] = $value;
            }
        } elseif ($operation == 'post') {
            $parentid = intval($_GPC['parentid']);
            $sid = intval($_GPC['sid']);
            if (!empty($sid)) {
                $subject = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = '$sid'");
            } else {
                $subject = array(
                    'ssort' => 0,
                );
            }
            if (checksubmit('submit')) {
                if (empty($_GPC['catename'])) {
                    message('抱歉，请输入名称！');
                }

                $data = array(
                    'weid' => $weid,
					'schoolid' => $_GPC['schoolid'],
                    'sname' => $_GPC['catename'],
                    'ssort' => intval($_GPC['ssort']),
                    'type' => 'subject',
					'parentid' => intval($parentid),
                );
				
                /** 添加科目 */
                if (!empty($sid)) {
                    //unset($data['parentid']);
                    pdo_update($this->table_classify, $data, array('sid' => $sid));
                } else {
                    pdo_insert($this->table_classify, $data);
                    $sid = pdo_insertid();
                }

                message('更新科目成功！', $this->createWebUrl('subject', array('op' => 'display', 'schoolid' => $schoolid)), 'success');

            }

        } elseif ($operation == 'delete') {

            /** 删除科目 */
            $sid = intval($_GPC['sid']);
            $subject = pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " WHERE sid = '$sid'");
            if (empty($subject)) {
                message('抱歉，科目不存在或是已经被删除！', $this->createWebUrl('subject', array('op' => 'display', 'schoolid' => $schoolid)), 'error');
            }
            pdo_delete($this->table_classify, array('sid' => $sid), 'OR');
            message('科目删除成功！', $this->createWebUrl('subject', array('op' => 'display', 'schoolid' => $schoolid)), 'success');

        }
   include $this->template ( 'web/subject' );
?>