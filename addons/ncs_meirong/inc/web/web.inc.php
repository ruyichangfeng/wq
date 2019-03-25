<?php
defined('IN_IA') or exit('Access Denied');

$ops=array('edit','savemodel','login');

global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'edit';
switch($op){
    case 'edit':
        $xtitle='系统配置';
        $xkey='web';
        $url= $this->createWebUrl('web',['op'=>'savemodel']);
        $list = [];
        $res=pdo_getall('wq_config',array('xkey'=>'web','uniacid'=>$uniacid));
        foreach ($res as $key=>$val){
            $list[$val['name']] = $val['content'];
        }

        include $this->template("Web/edit");
        break;
    case 'savemodel':
        $filed = ['site_name','m_status','amap_key','qqmap_key'];
        //m_status 默认为1开启，2为关闭
        $condition=array();
        $condition['uniacid']=$uniacid;
        $condition['xkey']='web';
        foreach ($_POST as $key=>$val){
            if(!in_array($key,$filed)){
                continue;
            }
            $condition['name']=$key;
            if(pdo_get('wq_config', $condition)){
                $request=pdo_update('wq_config',['content'=>$val],$condition);
            }
            else{
                $condition['content']=$val;
                $request=pdo_insert('wq_config',$condition);
            }
        }
            message('操作成功',$this->createWebUrl('web'));
        break;
}