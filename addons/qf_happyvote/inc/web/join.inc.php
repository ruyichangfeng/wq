<?php
global $_GPC, $_W;
load()->func('tpl');
load()->func('logging');

require_once MODULE_ROOT . '/common/config.php';
require_once MODULE_ROOT . '/model/vote.class.php';
require_once MODULE_ROOT . '/model/join.class.php';

$vote = new Vote();
$join = new Join();

$uniacid = $_W["uniacid"];
$ops = array('list', 'add', 'update');
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'list';

$voteid = $_GPC["voteid"];

switch ($op) {
    case 'list':
        //处理分页参数
        $currpage = 1;
        $total = 0;
        $pagesize = LIST_PAGE_SIZE;

        if(is_numeric($_GPC['page'])){
            $currpage = $_GPC['page'];
        }

        //当前标签 0全部 1待审核 2通过 3未通过
        $tabindex = empty($_GPC['checkstate']) ? 0 : $_GPC['checkstate'];

        //处理查询条件
        $condition = array();    
        if(!empty($_GPC['checkstate'])){    //审核状态
            $condition = array(':checkstate' => $_GPC['checkstate']);
        }   
        if(!empty($_GPC['username'])){      //用户姓名
            $condition = array(':username' => $_GPC['username']);
        }
        
        $qbtgtotal = $join -> getjoincount($voteid, array());
        $dshtotal = $join -> getjoincount($voteid, array(':checkstate' => 1));
        $tgtotal = $join -> getjoincount($voteid, array(':checkstate' => 2));
        $wtgtotal = $join -> getjoincount($voteid, array(':checkstate' => 3));


        //分页信息
        $pagedata = $join -> getpagejoin($voteid, $condition, $currpage, $pagesize);

        $total = $pagedata['total'];
        $listdata = $pagedata['data'];
        
        include $this->template('joinmanage');
    break;
    case 'add':
        if(checksubmit("submit")){
            $data = array(
               'vote_id' => $voteid,
               'open_id' => "",
               'uid' => "",
               'username' => $_GPC['username'],
               'image' => $_GPC['image'],
               'resume' => $_GPC['resume'],
               'telephone' => $_GPC['telephone'],
               'add_poll_count' => $_GPC['addpollcount'],
               'check_state' => $_GPC['checkstate'],
               'ip' => CLIENT_IP,
               'poll_count' => 0,
               'create_time' => date("Y-m-d H:i:s"),
            );
        
            $result = $join -> addjoin($data, $voteid);
            logging_run("uniacid:" . $uniacid . ",结果：" . $result . " 新增参与者用户", 'trace', MODULE_ID);
        
            if ($result != 0) {
                message('新增参与者用户成功！', $this->createWebUrl('join',array('voteid' => $voteid),'success'));
            }else{
                message('新增参与者用户失败','','error');
            }
        }
        
        include $this->template('joinadd');
    break;
    case 'update':
        $id = $_GPC['id'];
        
        //绑定参与者信息
        $data = $join -> getjoin($voteid, $id);
        
        //修改参与者信息
        if(checksubmit("submit")){
            $formdata = array(
                'username' => $_GPC['username'],
                'image' => $_GPC['image'],
                'resume' => $_GPC['resume'],
                'telephone' => $_GPC['telephone'],
                'add_poll_count' => $_GPC['addpollcount'],
                'check_state' => $_GPC['checkstate'],
            );
        
            $join -> updatejoin($voteid, $id, $formdata);

            logging_run("uniacid:" . $uniacid . ",结果：" . $result . " 修改参与者用户", 'trace', MODULE_ID);      
            message('修改参与者用户成功！', $this->createWebUrl('join',array('voteid' => $voteid),'success'));
        }
        include $this->template('joinupdate');
    break;
}
