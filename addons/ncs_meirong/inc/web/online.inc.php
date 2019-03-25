<?php
defined('IN_IA') or exit('Access Denied');

$ops=array('list','delete','statuschange','detail');

global $_GPC, $_W;
$uniacid = $_W['uniacid'];

$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'list';

$statusArray = ['待接单','已接单','服务中','已完成','已拒绝'];

switch($op){
    case 'list':
        $onlineTable = $_W['config']['db']['tablepre'] .'wq_online';
        $serviceTable = $_W['config']['db']['tablepre'] . 'wq_service';
        $condition=array();
        $condition['uniacid']=$uniacid;

        if(!empty($_GPC['out_trade_no'])){
            $out_trade_no=$_GPC['out_trade_no'];
            $where =" AND o.out_trade_no = '{$out_trade_no}'";
        }
        if(!empty($_GPC['uname'])){
            $user_name=$_GPC['uname'];
            $where .=" AND o.name LIKE '%{$user_name}%'";
        }
        if($_GPC['online_status']>-1){
            $online_status=$_GPC['online_status'];
            $where .=" AND o.status =" . $online_status ;
        }

        $sqlcount = "SELECT o.* FROM {$onlineTable} AS o WHERE o.uniacid = $uniacid {$where} GROUP BY o.id ORDER BY o.createtime DESC";


        $request = pdo_fetchall($sqlcount);

        $total = count($request);
        if (!isset($_GPC['page'])) {
            $pageindex = 1;
        } else {
            $pageindex = intval($_GPC['page']);
        }
        $pagesize = 15;
        $start = ((int)$pageindex - 1) * $pagesize;
        $pager = pagination($total, $pageindex, $pagesize);

        $sql = "SELECT o.id AS id ,o.out_trade_no AS out_trade_no ,o.name AS user_name ,o.createtime AS create_time ,o.plan_date AS p_time ,o.status AS status , s.name AS service_name
                FROM {$onlineTable} AS o
                    LEFT JOIN {$serviceTable} AS s ON o.pid = s.id
                    WHERE o.uniacid = $uniacid {$where} GROUP BY o.id ORDER BY o.createtime DESC LIMIT $start,$pagesize";

        $list = pdo_fetchall($sql);

        foreach ($list as $key =>$val){
            $list[$key]['status_name'] = $statusArray[$val['status']];
        }
        if(!isset($online_status)){
            $online_status = '-1';
        }
        include $this->template("Online/list");
        break;
    case 'statuschange':
        $request=pdo_update('wq_online',array("status"=>$_GPC['status']),array("id"=>$_GPC['id'],'uniacid'=>$uniacid));
        if($request){
            $onlie = pdo_get("wq_online",array("id"=>$_GPC['id']));
            $res=pdo_getall('wq_config',array('xkey'=>'msg','uniacid'=>$uniacid));
            foreach ($res as $key=>$val){
                $conf[$val['name']] = $val['content'];
            }

            if($_GPC['status'] > 0 && $conf['msg_id']>0){

                $dd = new msg\aliyun\sendSms();
                $res = $dd->send($conf['msg_key'],$conf['msg_secret'],$onlie['mobile'],$conf['msg_sign'],$conf['msg_template_id'],array('name'=>$onlie['name'],'status'=>$statusArray[$_GPC['status']],'time'=>date('Y-m-d H:i:s')));
                if($res->Code =='OK'){
                    //记录短信发送状态
                }
            }
            $json=array('status'=>1,'msg'=>'操作成功');
            echo json_encode($json);
        }else{
            $json=array('status'=>0,'msg'=>'操作失败');
            echo json_encode($json);
        }
        break;
    case 'delete':
        $request=pdo_delete('wq_online',array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        if($request){
            $json=array('status'=>1,'msg'=>'操作成功');
            echo json_encode($json);
        }else{
            $json=array('status'=>0,'msg'=>'操作失败');
            echo json_encode($json);
        }
        break;
    case 'detail':
        $list=pdo_get("wq_online",array("id"=>$_GPC['id']));
        $product=pdo_get("wq_service",array("id"=>$list['pid']));
        $list['pname']=$product['name'];
        $list['statusname']=$statusArray[$list['status']];
        include $this->template("Online/detail");
        break;
}