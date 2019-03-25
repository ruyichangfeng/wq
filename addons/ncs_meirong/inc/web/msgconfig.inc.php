<?php
defined('IN_IA') or exit('Access Denied');

$ops=array('edit','savemodel','test_send');
$funcName = 'msgconfig';
$funcTemplate = 'Msg';
$xkey='msg';
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'edit';
switch($op){
    case 'edit':
        $xtitle='短信配置';
        $url= $this->createWebUrl($funcName,['op'=>'savemodel']);
        $list = [];
        $res=pdo_getall('wq_config',array('xkey'=>$xkey,'uniacid'=>$uniacid));
        foreach ($res as $key=>$val){
            $list[$val['name']] = $val['content'];
        }

        $msgList = ['关闭','阿里云短信'];
        $testUrl = $url= $this->createWebUrl($funcName,['op'=>'test_send']);

        include $this->template("$funcTemplate/edit");
        break;
    case 'savemodel':
        $filed = ['msg_id','msg_key','msg_secret','msg_sign','msg_template_id','msg_test_phone'];
        //m_status 默认为1开启，2为关闭
        $condition=array();
        $condition['uniacid']=$uniacid;
        $condition['xkey']=$xkey;
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
        message('操作成功',$this->createWebUrl($funcName));
        break;
    case 'test_send':
        if(!$_W['ispost']){
            echo json_encode(array("status"=>0,'msg'=>'提交姿势不对',"data"=>[]));
            break;
        }
        $phone = $_GPC['phone'];
        if(empty($phone)){
            echo json_encode(array("status"=>0,'msg'=>'手势不对',"data"=>[]));
            break;
        }
        $res=pdo_getall('wq_config',array('xkey'=>$xkey,'uniacid'=>$uniacid));
        foreach ($res as $key=>$val){
            $conf[$val['name']] = $val['content'];
        }

        $dd = new msg\aliyun\sendSms();
        $res = $dd->send($conf['msg_key'],$conf['msg_secret'],$phone,$conf['msg_sign'],$conf['msg_template_id'],array('name'=>'测试名称','time'=>date('Y-m-d H:i:s')));
        if($res->Code =='OK'){
            echo json_encode(array("status"=>1,'msg'=>'发送成功',"data"=>[]));
            break;
        }
       echo  json_encode(array("status"=>0,'msg'=>'发送出错'.$res['code'],"data"=>[]));
        break;
}