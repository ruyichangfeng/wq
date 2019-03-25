<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->dh_weid;
$action = 'task_review';
$GLOBALS['frames'] = $this->getMainMenu($storeid,$action);
$title = $this->actions_titles[$action];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $condition = '';
    $username = null;
    $task_title = null;
    if (!empty($_GPC['username'])) {
        $username = trim($_GPC['username']);
        $condition .= " AND username LIKE '%{$username}%'";
    }
    if (!empty($_GPC['task_title'])) {
        $task_title = trim($_GPC['task_title']);
        $condition .= " AND task_title LIKE '%{$task_title}%'";
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;

    $start = ($pindex - 1) * $psize;
    $limit = "";
    $limit .= " LIMIT {$start},{$psize}";
    $receiveList = pdo_fetchall("SELECT ims_dh_task_receive.id, ims_dh_task_receive.user_id, ims_dh_task_receive.task_id, ims_dh_task_receive.status, ims_dh_task_receive.receive_time, ims_dh_task_receive.prove, ims_dh_task_receive.evaluate, ims_dh_task_receive.points,ims_dh_task_receive.image, ims_dh_task_fans.username, ims_dh_task_task.task_title FROM ims_dh_task_receive LEFT JOIN ims_dh_task_fans ON ims_dh_task_fans.id = ims_dh_task_receive.user_id LEFT JOIN ims_dh_task_task ON ims_dh_task_task.id = ims_dh_task_receive.task_id  WHERE  ims_dh_task_receive.weid = :weid {$condition} ORDER BY ims_dh_task_receive.id DESC" . $limit, array(':weid' => $weid));
    $total = pdo_fetchcolumn("SELECT count(1) FROM ims_dh_task_receive LEFT JOIN ims_dh_task_fans ON ims_dh_task_fans.id = ims_dh_task_receive.user_id LEFT JOIN ims_dh_task_task ON ims_dh_task_task.id = ims_dh_task_receive.task_id  WHERE  ims_dh_task_receive.weid = :weid {$condition}", array(':weid' => $weid));

    // 设置领取人名称
    $userList = pdo_fetchall("SELECT * FROM " . tablename($this->table_fans) . " WHERE weid = :weid", array(':weid' => $weid));
    // 设置任务名称
    $taskList = pdo_fetchall("SELECT * FROM " . tablename($this->table_task) . " WHERE weid = :weid", array(':weid' => $weid));
	for($i=0;$i<count($receiveList);$i++) {
		foreach ($userList as $user) {
            if ($receiveList[$i]['user_id'] == $user['id']) {
                $receiveList[$i]['user_id'] = $user['username']?$user['username']:$user['nickname'];
            }
        }
        foreach ($taskList as $task) {
            if ($receiveList[$i]['task_id'] == $task['id']) {
                $receiveList[$i]['task_id'] = $task['task_title'];
            }
        }
	}
	
    $pager = pagination($total, $pindex, $psize);

} else if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename($this->table_receive) . " WHERE id = :id AND weid = :weid", array(':id' => $id, ':weid' => $weid));
    if($item['field']){
        $item['field'] = json_decode($item['field'],true);
    }
    if($item['image']){
        //对image字段处理前后的兼容处理
        if(strstr($item['image'],"[") && strstr($item['image'],"]")){
            $item['image'] = json_decode($item['image'],ture);
        }else{
            $item['image'] = array(0=>$item['image']);
        }
    }

    $userInfo = pdo_fetch("SELECT * FROM ". tablename($this->table_fans) . " WHERE weid = :weid AND id=:id", array('weid' => $weid,':id'=>$item['user_id']));
    $taskinfo = pdo_fetch("SELECT * FROM " . tablename($this->table_task) . " WHERE weid = :weid AND id=:id", array('weid' => $weid,':id'=>$item['task_id']));

    if (checksubmit()) {
        $data = array(
			'id' => $id,
            'status' => trim($_GPC['status']),
            'prove' => htmlspecialchars($_GPC['prove']),
            'evaluate' => trim($_GPC['evaluate']),
            'points' => intval($_GPC['points'])
        );

        //审核成功
        if(trim($_GPC['status']) == 1) {
            //设置用户积分 总获得积分 = 任务设定积分 + 手动设置奖励积分
            $this->changePoints($item['user_id'], intval($taskinfo['task_points']), "完成任务-" . $taskinfo['task_title']);
            if (!empty($data['points']) && intval($data['points'] != 0)) {
                $this->changePoints($item['user_id'], intval($data['points']), "审核-" . $taskinfo['task_title']);
            }
            $user_level = intval($taskinfo['user_level']);
            if($user_level > 0) {
                pdo_query("update " . tablename($this->table_fans) . " set level=level+{$user_level} WHERE id = :id AND weid=:weid",array(":id"=>$userInfo['id'],':weid'=>$weid));
            }
            //如果开启推广奖励，分发奖励
            $setting = $this->getSetting();
            if($setting['share_taskid'] == 0 || $setting['share_taskid'] == $taskinfo['id']){
                $username = $userInfo['username']?$userInfo['username']:$userInfo['nickname'];
                if($userInfo['uid'] && $setting['is_commission'] && $setting['manner'] == 2 && $setting['share_point']>0){
                    $where = "";
                    if($setting['share_taskid'] != 0){
                        $where .= " AND task_id={$setting['share_taskid']}";
                    }
                    $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_receive) . " WHERE weid=:weid AND user_id=:userid AND status=1".$where, array(':weid' => $weid,':userid'=>$userInfo['id']));
                    if($total == 0){
                        $this->changePoints($userInfo['uid'],$setting['share_point'],"推广奖励-".$username);
                        pdo_query("update " . tablename($this->table_fans) . " set is_commission=1 WHERE id = :id",array(":id"=>$userInfo['id']));
                    }
                }
            }
            $this->sendTaskTempMsgToUser($userInfo['from_user'],$taskinfo['id'],2);
            
        }else{
            $this->sendTaskTempMsgToUser($userInfo['from_user'],$taskinfo['id'],3);
        }

        if (!empty($item)) {
            pdo_update($this->table_receive, $data, array('id' => $id, 'weid' => $weid));
            message('操作成功!', $this->createWebUrl('task_review', array('op' => 'display', 'storeid' => $storeid)), 'success');
        } else {
            message('操作失败，该任务不存在', $this->createWebUrl('task_review', array('op' => 'display', 'storeid' => $storeid)), 'error');
        }
        
    }


    $item['user_id'] = $userInfo['username'] . " (用户id：". $userInfo['id'] .")";
    
    $item['task_id'] = $taskinfo['task_title'] . " id：". $taskinfo['id'];
}
include $this->template('web/task_review');