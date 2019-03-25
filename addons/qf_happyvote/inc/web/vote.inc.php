<?php
global $_GPC, $_W;
load()->func('tpl');
load()->func('logging');

require_once MODULE_ROOT . '/common/config.php';
require_once MODULE_ROOT . '/model/vote.class.php';

$vote = new Vote();

$uniacid = $_W["uniacid"];
$ops = array('list', 'update', 'delete');
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'list';

switch ($op) {
    case 'list':
        //处理分页参数
        $currpage = 1;
        $total = 0;
        $pagesize = LIST_PAGE_SIZE;

        if(is_numeric($_GPC['page'])){
            $currpage = $_GPC['page'];
        }

        //处理查询条件
        $txttitle = "";        
        if(!empty($_GPC['title'])){
            $txttitle = $_GPC['title'];
        }
        $condition = array(':title' => $txttitle);
        
        $pagedata = $vote -> getpagevote($uniacid, $condition, $currpage, $pagesize);

        $total = $pagedata['total'];
        $listdata = $pagedata['data'];
        
        include $this->template('votemanage');
    break;
    case 'update':
        $id = $_GPC['id'];
        
        //绑定活动信息
        $data = $vote -> getvote($id);
        
        //修改活动信息
        if(checksubmit("submit")){
            $formdata = array(
                'title' => $_GPC['title'],
                'picture' => $_GPC['picture'],
                'introduce' => $_GPC['introduce'],
                'start_time' => $_GPC['votetime']['start'],
                'end_time' => $_GPC['votetime']['end'],
                'max_count' => $_GPC['maxcount'],
                'single_max_count' => $_GPC['singlemaxcount'],
                'ip_max_count' => $_GPC['ipmaxcount'],
                'join_integral' => $_GPC['joinintegral'],
                'vote_integral' => $_GPC['voteintegral'],
                'add_access_count' => $_GPC['addaccesscount'],
                'add_join_count' => $_GPC['addjoincount'],
                'add_vote_count' => $_GPC['addvotecount'],
                'is_check' => $_GPC['ischeck'] == 'on' ? 1:0,
            );
        
            $vote -> updatevote($id, $formdata);

            logging_run("uniacid:" . $uniacid . ",结果：" . $result . " 修改投票", 'trace', MODULE_ID);
        
            message('修改成功！', $this->createWebUrl('vote',array()),'success');
        }
        include $this->template('voteupdate');
    break;
    case 'delete':
        $id = $_GPC["id"];

        $result = $vote -> deletevote($id);
        logging_run("uniacid:" . $uniacId . ",结果：" . $result . " 删除投票活动", 'trace', MODULE_ID);

        if (!empty($result)) {
            message('删除成功！',$this->createweburl('vote',array()),'success'); 
        }else{
            message('删除失败！','','error');
        }
    break;
}
