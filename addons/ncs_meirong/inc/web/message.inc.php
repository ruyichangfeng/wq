<?php
defined('IN_IA') or exit('Access Denied');

$ops=array('list','edit','delete','statuschange','reply');

global $_GPC, $_W;
$uniacid = $_W['uniacid'];

$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'list';

switch($op){
    case 'list':
        $condition=array();
        $condition['uniacid']=$uniacid;
        if(!empty($_GPC['xname'])){
            $xname=$_GPC['xname'];
            $condition['name LIKE']='%'.$_GPC['xname']."%";
        }
        if(!empty($_GPC['mobile'])){
            $mobile=$_GPC['mobile'];
            $condition['mobile LIKE']="%".$_GPC['mobile']."%";
        }
        if(!empty($_GPC['status'])){
            $status=$_GPC['status'];
            $condition['status']=$_GPC['status'];
        }
        $request=pdo_getall("wq_message",$condition);

        $total = count($request);
        if (!isset($_GPC['page'])) {
            $pageindex = 1;
        } else {
            $pageindex = intval($_GPC['page']);
        }
        $pagesize = 15;
        $pager = pagination($total, $pageindex, $pagesize);
        $list=pdo_getall("wq_message",$condition,array() , '' , "createtime DESC" , array($pageindex,$pagesize));
        if($list){
            $active=pdo_getall('wq_message',array('uniacid'=>$uniacid));
            $activelist=array();
            foreach($active as $x){
                $activelist[$x['id']]=$x['name'];
            }
            foreach($list as &$y){
                $y['activename']=$activelist[$y['pid']];
                $y['reply']=json_decode($y['reply'],true);
            }
        }
        include $this->template("Message/list");
        break;
    case 'edit':
        $request=pdo_get("wq_message",array("id"=>$_GPC['id']));
        $list=json_decode($request['reply'],true);
        $list['id']=$request['id'];
        include $this->template("Message/edit");
        break;
    case 'statuschange':
        $request=pdo_update('wq_message',array("status"=>$_GPC['status']),array("id"=>$_GPC['id'],'uniacid'=>$uniacid));
        if($request){
            $json=array('status'=>1,'msg'=>'操作成功');
            echo json_encode($json);
        }else{
            $json=array('status'=>0,'msg'=>'操作失败');
            echo json_encode($json);
        }
        break;
    case 'delete':
        $request=pdo_delete('wq_message',array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        if($request){
            $json=array('status'=>1,'msg'=>'操作成功');
            echo json_encode($json);
        }else{
            $json=array('status'=>0,'msg'=>'操作失败');
            echo json_encode($json);
        }
        break;
}