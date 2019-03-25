<?php
defined('IN_IA') or exit('Access Denied');

$ops=array('list','edit','savemodel','delete','statuschange');

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
        $request=pdo_getall("wq_service_technician",$condition);

        $total = count($request);
        if (!isset($_GPC['page'])) {
            $pageindex = 1;
        } else {
            $pageindex = intval($_GPC['page']);
        }
        $pagesize = 15;
        $pager = pagination($total, $pageindex, $pagesize);
        $list=pdo_getall("wq_service_technician",$condition,array() , '' , "sort DESC,createtime DESC" , array($pageindex,$pagesize));
        include $this->template("Service_technician/list");
        break;
    case 'edit':
        $store=pdo_getall("wq_service_store",array('uniacid'=>$uniacid),array(),'','sort DESC,createtime DESC');
        if(!empty($_GPC['id'])){
            $list=pdo_get('wq_service_technician',array('id'=>$_GPC['id']));
        }else{
            $list['status']=1;
        }
        include $this->template("Service_technician/edit");
        break;
    case 'savemodel':
        $condition=array();
        $condition['uniacid']=$uniacid;
        $condition['name']=$_GPC['name'];
        $condition['simg']=$_GPC['simg'];
        $condition['bimg']=$_GPC['bimg'];
        $condition['status']=$_GPC['status'];
        $condition['content']=$_GPC['content'];
        $condition['store_id']=$_GPC['store_id'];
        $condition['min_title']=$_GPC['min_title'];
        if(empty($_GPC['sort'])){
            $condition['sort']=0;
        }else{
            $condition['sort']=$_GPC['sort'];
        }
        if(empty($_GPC['id'])){
            $request=pdo_insert('wq_service_technician',$condition);
        }else{
            $request=pdo_update('wq_service_technician',$condition,array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        }
        if(!empty($request)){
            message('操作成功',$this->createWebUrl('service_technician'));
        }else{
            message('操作失败','',"warning");
        }
        break;
    case 'statuschange':
        $request=pdo_update('wq_service_technician',array("status"=>$_GPC['status']),array("id"=>$_GPC['id'],'uniacid'=>$uniacid));
        if($request){
            $json=array('status'=>1,'msg'=>'操作成功');
            echo json_encode($json);
        }else{
            $json=array('status'=>0,'msg'=>'操作失败');
            echo json_encode($json);
        }
        break;
    case 'delete':
        $request=pdo_delete('wq_service_technician',array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        if($request){
            $json=array('status'=>1,'msg'=>'操作成功');
            echo json_encode($json);
        }else{
            $json=array('status'=>0,'msg'=>'操作失败');
            echo json_encode($json);
        }
        break;
}