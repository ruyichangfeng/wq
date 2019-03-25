<?php
defined('IN_IA') or exit('Access Denied');

$ops=array('edit','savemodel');

global $_GPC, $_W;
$uniacid = $_W['uniacid'];

$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'edit';

switch($op){
    case 'edit':
        $xtitle='公司简介';
        $xkey='company';
        $url='company';
        $list=pdo_get('wq_config',array('xkey'=>'company','uniacid'=>$uniacid));
        include $this->template("Config/edit");
        break;
    case 'savemodel':
        $condition=array();
        $condition['uniacid']=$uniacid;
        $condition['xkey']='company';
        $condition['name']=$_GPC['name'];
        $condition['content']=$_GPC['content'];
        if(empty($_GPC['id'])){
            $request=pdo_insert('wq_config',$condition);
        }else{
            $request=pdo_update('wq_config',$condition,array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        }
        if(!empty($request)){
            message('操作成功',$this->createWebUrl('company'));
        }else{
            message('操作失败','',"warning");
        }
        break;
}