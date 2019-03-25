<?php
defined('IN_IA') or exit('Access Denied');

$ops=array('edit','savemodel');

global $_GPC, $_W;
$uniacid = $_W['uniacid'];

$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'edit';

switch($op){
    case 'edit':
        $xtitle='地图';
        $xkey='map';
        $url='map';
        $list=pdo_get('wq_config',array('xkey'=>'map','uniacid'=>$uniacid));
        $list['content']=json_decode($list['content'],true);
        include $this->template("Map/edit");
        break;
    case 'savemodel':
        $condition=array();
        $condition['uniacid']=$uniacid;
        $condition['xkey']='map';
        $condition['name']=$_GPC['name'];
        $data['longitude']=$_GPC['longitude'];
        $data['latitude']=$_GPC['latitude'];
        $data['name']=$_GPC['search'];
        $condition['content']=json_encode($data);
        if(empty($_GPC['id'])){
            $request=pdo_insert('wq_config',$condition);
        }else{
            $request=pdo_update('wq_config',$condition,array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        }
        if(!empty($request)){
            message('操作成功',$this->createWebUrl('map'));
        }else{
            message('操作失败','',"warning");
        }
        break;
}