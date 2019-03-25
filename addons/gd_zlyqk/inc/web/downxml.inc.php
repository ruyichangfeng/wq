<?php
//下载xml文件

global $_GPC,$_W;
$id = $_GPC['id'];
if(empty($id)){
    $this->msg['msg']="非法数据";
    $this->echoAjax();
}
$post['id']="$id";
$url =$this->apiUrl."api/share/downLoad";
$post=$this->createSign($post);
$result = $this->post($url,$post);
if(empty($result) || $result['code']==0){
    $this->msg['msg']="下载错误";
    $this->echoAjax();
}
//写入记录表
$xmlInfo=$result['data'];
if(empty($xmlInfo)){
    $this->msg['msg']="流程文件不完善";
    $this->echoAjax();
}
//创建流程应用表
$xml = base64_decode($xmlInfo['xml']);
$formList =base64_decode($xmlInfo['form_list']);
$appSource =base64_decode($xmlInfo['app_source']);

//创建流程
$appName =$xmlInfo['title']."(下载)";
//添加流程
$fl['name']=$appName;
$fl['uniacid']=$_W['uniacid'];
$fl['create_time']=time();
$fl['status']=1;
if(!pdo_insert("gd_flow",$fl)){
    $this->msg['msg']="下载处理错误";
    $this->echoAjax();
}
$flowId=pdo_insertid();

//添加预处理表单
$formList = json_decode($formList,true);
foreach($formList as $val){
    $sid = $val['node_sid'];
    $formList=$val['form_list'];
    $nodeInfo = pdo_get("gd_prenode",array("node_sid"=>$sid,'flow_id'=>$flowId));
    if(empty($nodeInfo)){
        $insert['uniacid']=$_W['uniacid'];
        $insert['who']=1;
        $insert['who_list']="";
        $insert['form_list']=$formList;
        $insert['create_time']=time();
        $insert['node_sid']=$sid;
        $insert['flow_id']=$flowId;
        pdo_insert("gd_prenode",$insert);
    }
}
//添加xml 文件配置
$xmls['uniacid']=$_W['uniacid'];
$xmls['flow_id']=$flowId;
$xmls['xml']=$xml;
$xmls['create_time']=time();
if(!pdo_insert("gd_xml",$xmls)){
    $this->msg['msg']="下载处理错误";
    $this->echoAjax();
}

$appSource = json_decode($appSource,true);
$table = $this->createTable($appSource);
//创建首页表单
$index['uniacid']=$_W['uniacid'];
$index['name']=$appName;
$index['create_time']=time();
$index['status']=1;
$index['is_default']=0;
$index['flow_id']=$flowId;
$index['category']=0;
$index['property']="";
$index['table']=$table;
$index['cover']="";
$index['cover_name']="自己修改";
$index['cover_desc']="自己修改";
$index['is_show']=0;
if(!pdo_insert("gd_app",$index)){
    $this->msg['msg']="下载处理错误";
    $this->echoAjax();
}
$appId = pdo_insertid();

$source['source']=json_encode($appSource);
$source['app_id']=$appId;
$source['table']=$table;
$source['create_time']=time();
pdo_insert("gd_source_form",$source);

$this->msg['code']=1;
$this->msg['msg']="下载成功";
$this->echoAjax();