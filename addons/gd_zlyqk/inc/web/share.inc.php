<?php
//分享应用

global $_GPC,$_W;
$id=$_GPC['id'];
$type=$_GPC['type'];
$recorder = $this->getAppInfo($id);
if($this->isAjax){
    //获取流程图
    if(empty($_GPC['in']['cover'])){
        $this->msg['msg']="请添加流程图";
        $this->echoAjax();
    }
    $att=ATTACHMENT_ROOT.str_replace("attachment/","",$_GPC['in']['cover']);
    $cover=file_get_contents($att);
    $post['flow_cover']="";
    if(!empty($cover)){
        $post['flow_cover']=base64_encode($cover);
    }
    $post['name']=$_GPC['in']['name'];
    $post['desc']=$_GPC['in']['desc'];
    $post['user']=$_GPC['in']['share'];
    $post['category']=$_GPC['in']['category'];
    //获取入口表单
    $source = pdo_get("gd_source_form",array("app_id"=>$id));
    if(empty($source['source'])){
        $this->msg['msg']="表单内容不能为空";
        $this->echoAjax();
    }
    $post['source']=base64_encode($source['source']);
    //获取流程xml文件
    if(empty($recorder['flow_id'])){
        $this->msg['msg']="请先绑定流程";
        $this->echoAjax();
    }
    $xmlInfo= pdo_get("gd_xml",array("flow_id"=>$recorder['flow_id']));
    if(empty($xmlInfo['xml'])){
        $this->msg['msg']="流程不存在";
        $this->echoAjax();
    }
    $post['xml']=base64_encode($xmlInfo['xml']);
    //获取预处理节点
    $nodeList=pdo_getall("gd_prenode",array("flow_id"=>$recorder['flow_id']));
    $post['node_list']="";
    $node=array();
    if(!empty($nodeList)){
        foreach($nodeList as $key=>$val){
            $node[$key]['node_sid']=$val['node_sid'];
            $node[$key]['form_list']=$val['form_list'];
        }
        $post['node_list']=base64_encode(json_encode($node));
    }
    //提交数据到api接口
    $url =$this->apiUrl."api/share/add";
    $post=$this->createSign($post);
    $result = $this->post($url,$post);
    if(isset($result['code']) && $result['code']==1 ){
        $this->msg['code']=1;
        $this->msg['msg']="分享成功";
        $this->echoAjax();
    }
    $this->msg['msg']="分享失败";
    $this->echoAjax();
}
//获取官方分类
$url =$this->apiUrl."api/share/category";
$post['shas']="1";
$post=$this->createSign($post);
$result = $this->post($url,$post);
$category = isset($result['data'])?$result['data']:array();
include $this->template("share");
