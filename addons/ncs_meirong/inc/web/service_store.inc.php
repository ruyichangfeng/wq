<?php
defined('IN_IA') or exit('Access Denied');

$ops=array('list','edit','savemodel','delete','statuschange','codeqr');

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
        $request=pdo_getall("wq_service_class",$condition);

        $total = count($request);
        if (!isset($_GPC['page'])) {
            $pageindex = 1;
        } else {
            $pageindex = intval($_GPC['page']);
        }
        $pagesize = 15;
        $pager = pagination($total, $pageindex, $pagesize);
        $list=pdo_getall("wq_service_store",$condition,array() , '' , "sort DESC,createtime DESC" , array($pageindex,$pagesize));
        include $this->template("Service_store/list");
        break;
    case 'edit':
        if(!empty($_GPC['id'])){
            $list=pdo_get('wq_service_store',array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        }else{
            $list['status']=1;
        }
        $res=pdo_get('wq_config',array('xkey'=>'web','uniacid'=>$uniacid,'name'=>'amap_key'));
        $amapKey = $res['content'];
        include $this->template("Service_store/edit");
        break;
    case 'savemodel':
        $condition=array();
        $condition['uniacid']=$uniacid;
        $condition['name']=$_GPC['name'];
        $condition['simg']=$_GPC['simg'];
        $condition['bimg']=$_GPC['bimg'];
        $condition['status']=$_GPC['status'];
        $condition['content']=$_GPC['content'];
        $condition['address']=$_GPC['address'];
        $condition['address_id']=$_GPC['address_id'];
        if(empty($_GPC['sort'])){
            $condition['sort']=0;
        }else{
            $condition['sort']=$_GPC['sort'];
        }
        if(empty($_GPC['id'])){
            $request=pdo_insert('wq_service_store',$condition);
        }else{
            $request=pdo_update('wq_service_store',$condition,array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        }
        if(!empty($request)){
            message('操作成功',$this->createWebUrl('service_store'));
        }else{
            message('操作失败','',"warning");
        }
        break;
    case 'statuschange':
        $request=pdo_update('wq_service_store',array("status"=>$_GPC['status']),array("id"=>$_GPC['id'],'uniacid'=>$uniacid));
        if($request){
            $json=array('status'=>1,'msg'=>'操作成功');
            echo json_encode($json);
        }else{
            $json=array('status'=>0,'msg'=>'操作失败');
            echo json_encode($json);
        }
        break;
    case 'delete':
        $request=pdo_delete('wq_service_store',array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
        if($request){
            $json=array('status'=>1,'msg'=>'操作成功');
            echo json_encode($json);
        }else{
            $json=array('status'=>0,'msg'=>'操作失败');
            echo json_encode($json);
        }
        break;

    case 'codeqr':
        //获取店铺二维码
        $storeId = $_GPC['id'];
        $scene = "store-{$storeId}";
        load()->classs('wxapp.account');
        $accObj= new WxappAccount(['key'=>$_W['uniaccount']['key'],'secret'=>$_W['uniaccount']['secret']]);
        $appTokey = $accObj->getAccessToken();
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$appTokey}";
        $data = array(
            'scene' => urlencode($scene),//店铺id
        );
        load()->func('communication');
        //var_export($_W);
        $response = ihttp_post($url, json_encode($data));

        header('content-type:image/jpg;');
        echo $response['content'];

        break;
}