<?php

global $_GPC,$_W;
parse_str($_GPC['post'],$post);
$memberInfo =$this->getMemberInfo();
$sort=$post['sort'];
$info = pdo_get("gd_member_ext",array("uniacid"=>$_W['uniacid'],'sort'=>$sort));
unset($post['sort']);
if(empty($info['table'])){
    $this->msg['msg']="请先完善注册信息";
    $this->echoAjax();
}
//添加数据到数据库
$where=array("uniacid"=>$_W['uniacid'],'member_id'=>$memberInfo['id']);
$table= str_replace($this->getTablePre(),"",$info['table']);
$memberIf = pdo_get($table,$where);
//检查是否下一个节点是否需要完善
$nextStep = pdo_fetch("select * from ".tablename("gd_member_ext")." where sort >$sort order by sort asc limit 1");
if(empty($nextStep)){
    $this->msg['data']=$this->createMobileUrl("member");
}else{
    $this->msg['data']=$this->createMobileUrl("SaveStep")."&sort=".$nextStep['sort'];
}
if(empty($memberIf)){
    $post['member_id']=$memberInfo['id'];
    $post['uniacid']=$_W['uniacid'];
    $post['create_time']=time();
    if(pdo_insert($table,$post)){
        $this->msg['code']=1;
        $this->msg['msg']="保存成功";
        $this->echoAjax();
    }
}else{
    if(pdo_update($table,$post,$where)){
        $this->msg['code']=1;
        $this->msg['msg']="信息更新成功";
        $this->echoAjax();
    }
}
$this->msg['msg']="保存失败";
$this->echoAjax();