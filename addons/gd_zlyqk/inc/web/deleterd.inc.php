<?php
//删除消息记录操作

global $_GPC;
$id =$_GPC['id'];
$appInfo =$this->getAppInfo($_GPC['app_id']);
$table =str_replace($this->getTablePre(),"",$appInfo['table']);
if(strstr($id,",")){
    $ids = explode(",",$id);
    foreach($ids as $id){
        if(empty($id)){
            continue;
        }
        pdo_delete($table,array("id"=>$id));
    }
    $this->msg['code']=1;
    $this->msg['msg']="删除成功";
    $this->echoAjax();
}
if(pdo_delete($table,array("id"=>$id))){
    $this->msg['code']=1;
    $this->msg['msg']="删除成功";
    $this->echoAjax();
}
$this->msg['msg']="删除失败";
echo $this->echoAjax();