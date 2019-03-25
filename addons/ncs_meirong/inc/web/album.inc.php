<?php
defined('IN_IA') or exit('Access Denied');

$ops=array('edit','savemodel');

global $_GPC, $_W;
$uniacid = $_W['uniacid'];

$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'edit';

switch($op){
    case 'edit':
        $xtitle='公司相册';
        $xkey='album';
        $url='album';
        $list=pdo_get('wq_config',array('xkey'=>'album','uniacid'=>$uniacid));
        if($list){
            $list['imgs']=explode(",",$list['imgs']);
        }
        include $this->template("Album/edit");
        break;
    case 'savemodel':
        $condition=array();
        $condition['uniacid']=$uniacid;
        $condition['xkey']='album';
        $condition['name']=$_GPC['name'];
        $condition['imgs']=$_GPC['imgs'];
        $condition['content']=$_GPC['content'];
        if(empty($_GPC['id'])){
            $request=pdo_insert('wq_config',$condition);
        }else{
            $request=pdo_update('wq_config',$condition,array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        }
        if(!empty($request)){
            message('操作成功',$this->createWebUrl('album'));
        }else{
            message('操作失败','',"warning");
        }
        break;
}