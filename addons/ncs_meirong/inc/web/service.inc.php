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
        if(!empty($_GPC['cid'])){
            $cid=$_GPC['cid'];
            $condition['cid']=$_GPC['cid'];
        }
        $request=pdo_getall("wq_service",$condition);

        $total = count($request);
        if (!isset($_GPC['page'])) {
            $pageindex = 1;
        } else {
            $pageindex = intval($_GPC['page']);
        }
        $pagesize = 15;
        $pager = pagination($total, $pageindex, $pagesize);
        $list=pdo_getall("wq_service",$condition,array() , '' , "sort DESC,createtime DESC" , array($pageindex,$pagesize));
        if($list){
            $class=pdo_getall("wq_service_class",array('uniacid'=>$uniacid),array(),'','sort DESC,createtime DESC');
            $classlist=array();
            foreach($class as $x){
                $classlist[$x['id']]=$x['name'];
            }
            foreach($list as &$y){
                $y['cidname']=$classlist[$y['cid']];
            }
        }
        include $this->template("Service/list");
        break;
    case 'edit':
        $class=pdo_getall("wq_service_class",array('uniacid'=>$uniacid),array(),'','sort DESC,createtime DESC');
        $technician=pdo_getall("wq_service_technician",array('uniacid'=>$uniacid),array(),'','sort DESC,createtime DESC');
        if(!empty($_GPC['id'])){
            $list=pdo_get('wq_service',array('id'=>$_GPC['id']));
            $list['imgs']=explode(",",$list['imgs']);
        }else{
            $list['status']=1;
        }
        include $this->template("Service/edit");
        break;
    case 'savemodel':
        $condition=array();
        $condition['uniacid']=$uniacid;
        $condition['name']=$_GPC['name'];
        $condition['cid']=$_GPC['cid'];
        $condition['bimg']=$_GPC['bimg'];
        $condition['imgs']=$_GPC['imgs'];
        $condition['content']=$_GPC['content'];
        $condition['status']=$_GPC['status'];
        $condition['recommend']=$_GPC['recommend'];
        $condition['price']=$_GPC['price'];
        $condition['min_title']=$_GPC['min_title'];
        $condition['t_id']=$_GPC['t_id'];
        if(empty($_GPC['sort'])){
            $condition['sort']=0;
        }else{
            $condition['sort']=$_GPC['sort'];
        }
        if(empty($_GPC['id'])){
            $request=pdo_insert('wq_service',$condition);
        }else{
            $request=pdo_update('wq_service',$condition,array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        }
        if(!empty($request)){
            message('操作成功',$this->createWebUrl('service'));
        }else{
            message('操作失败','',"warning");
        }
        break;
    case 'statuschange':
        $request=pdo_update('wq_service',array("status"=>$_GPC['status']),array("id"=>$_GPC['id'],'uniacid'=>$uniacid));
        if($request){
            $json=array('status'=>1,'msg'=>'操作成功');
            echo json_encode($json);
        }else{
            $json=array('status'=>0,'msg'=>'操作失败');
            echo json_encode($json);
        }
        break;
    case 'delete':
        $request=pdo_delete('wq_service',array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        if($request){
            $json=array('status'=>1,'msg'=>'操作成功');
            echo json_encode($json);
        }else{
            $json=array('status'=>0,'msg'=>'操作失败');
            echo json_encode($json);
        }
        break;
}