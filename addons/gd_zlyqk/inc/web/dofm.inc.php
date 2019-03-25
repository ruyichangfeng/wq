<?php
//电脑端数据处理

global $_GPC,$_W;
//数据解析
$post=array();
$orderData=array();
parse_str($_GPC['data'],$post);

$sourcePost=$post;
$memberInfo = $this->findMemberInfo();
if(empty($memberInfo)){
    $this->msg['msg']="请用微信绑定此账号";
    $this->echoAjax();
}
$appId =$post['app_id'];
$appInfo = $this->getAppInfo($appId);

$ext=array();

//解析数据
$nodeInfo = $this->getNodeInfo($post['node_id']);
$table = str_replace($this->getTablePre(),"",$appInfo['table']);
$recorderInfo = pdo_get($table,array("id"=>$post['recorder_id']));
$formList=json_decode($nodeInfo['form_list'],true);
$flowInfo=$this->getFlowInfo($appInfo['flow_id']);
$lines =json_decode($flowInfo['line'],true);
$taskList = json_decode($flowInfo['task'],true);

//获取表单信息
$lineInfo = pdo_get("gd_preline",array("flow_id"=>$flowInfo['id'],"line_id"=>$post['line_id']));
if(!empty($lineInfo) && !empty($lineInfo['form_list'])){
    $formList = json_decode($lineInfo['form_list'],true);
}
//联动菜单处理
foreach($formList as $nd){
    $nameStr="";
    if($nd['type']=='ld'){
        $col =$nd['py'];
        if(isset($post[$col])){
            if(empty($post[$col]) || $post[$col]==","){
                $this->msg['msg']="请选择联动结构";
                $this->echoAjax();
            }
        }
        $ldArr=explode(",",$post[$col]);
        foreach($ldArr as $val){
            if(empty($val)) continue;
            $ldInfo = pdo_get("gd_ld",array("id"=>$val));
            if(empty($ldInfo)) continue;
            $nameStr .= empty($nameStr)?$ldInfo['name']:",".$ldInfo['name'];
        }
        $post[$col]=$nameStr;
    }
    //附件处理
    if($nd['type']=='file'){
        $ext[$nd['py']]['url']=$post[$nd['py']];
        $ext[$nd['py']]['b']=$post[$nd['py']."_b"];
        $ext[$nd['py']]['lb']=$post[$nd['py']."_lb"];
        unset($post[$nd['py']."_b"]);
        unset($post[$nd['py']."_lb"]);
    }
    //如果是照片
    if($nd['type']=="photo"){
        if(!empty($post[$nd['py']])){
            $photo =explode(",",$post[$nd['py']]);
            $urlList=$this->adminFileUpload($photo);
            $post[$nd['py']]=json_encode($urlList);
        }
    }
}
//获取上一节点支付信息
$poolInfo =pdo_get("gd_pool",array("recorder_id"=>$recorderInfo['id'],'table'=>$appInfo['table']));

//获取当前操作线路信息
$this->parseNodeStatus($lines[$post['line_id']],$taskList,$lines,$nodeInfo['id']);
$std = isset($this->statusLine[0])?$this->statusLine[0]:array();

if($poolInfo['before_node']==0 && empty($recorderInfo['start_time'])){
    $update['start_time']=time();
    $pool['recorder_status']=1;
}
if($std['act']==0){
    $update['is_end']=1;
    $update['end_time']=time();
    $pool['end_time']=time();
    $pool['recorder_status']=6;
    $update['next_act']=0;
    $pool['is_abort']=1;
    $update['status_id']=$std['act'];
    $update['status_name']=$std['name'];
}else if($std['act']==1){
    $pool['end_time']=time();
    $pool['recorder_status']=2;
    $update['is_end']=1;
    $update['end_time']=time();
    $update['status_id']=$std['act'];
    $update['status_name']=$std['name'];
}else{
    //自动跑到处理下一个节
    $lin=isset($lines[$post['line_id']])?$lines[$post['line_id']]:array();
    if(empty($lin)){
        $this->msg['msg']="连接先没找到";
        $this->echoAjax();
    }
    $target = $lin['targetRef'];
    $whr['ship']=2;
    $whr['xml_id']=$target;
    $whr['flow_id']=$flowInfo['id'];
    $nextNode =pdo_get("gd_node",$whr);
    if(empty($nextNode)){
        $this->msg['msg']="流程节点不闭合";
        $this->echoAjax();
    }
    $update['next_act']=$nextNode['who_list'];
    $update['node_id']=$nextNode['id'];
    $update['node_name']=$nextNode['name'];

    if($nextNode['who']==1 ){
        $pool['is_mark']=0;
        $pool['mark_time']=0;
    }
}
if(isset($payInfo['money']) && $payInfo['money']>0){
    $item=array();
    $item['act']="u";
    $item['table']=$table;
    $item['data']=$update;
    $item['where']=array("id"=>$recorderInfo['id']);
    $orderData[]=$item;
}else{
    $result = pdo_update($table,$update,array("id"=>$recorderInfo['id']));
}
$pool['node_id']=$nodeInfo['id'];
$pool['node_name']=$nodeInfo['name'];
$pool['node_name_status']=$std['name'];
$pool['node_status']=$std['act'];
$pool['staff_id']=$_W['member']['uid'];
$pool['staff_name']=$memberInfo['name'];
$pool['who']=!empty($nextNode['who'])?$nextNode['who']:0;
$pool['before_node']=$nodeInfo['id'];
$pool['before_line']=$post['line_id'];
$whoList="";
if($pool['who']==1){
    $whoList=json_decode($nextNode['who_list'],true);
    $whoList=implode(",",$whoList).",";
}
if($nodeInfo['who']==1){
    //获取消息记录
    $adminInfo=$this->isAdmin();
    $pool['staff_list'] =$poolInfo['staff_list'].$adminInfo['id']."-".$nodeInfo['id'].",";
}
$pool['group_list']=$whoList;
$pool['who_list']=$whoList;
//处理消息池的消息状态
if(isset($payInfo['money']) && $payInfo['money']>0){
    $item=array();
    $item['act']="u";
    $item['table']="gd_pool";
    $item['data']=$pool;
    $item['where']=array("recorder_id"=>$recorderInfo['id']);
    $orderData[]=$item;
}else{
    pdo_update("gd_pool",$pool,array("recorder_id"=>$recorderInfo['id'],'table'=>$appInfo['table']));
}

$poInfo=pdo_get("gd_pool",array("recorder_id"=>$recorderInfo['id'],'table'=>$appInfo['table']));

//保存节点操作数据
$log['flow_id']=$post['flow_id'];
$log['node_id']=$post['node_id'];
$log['recorder_id']=$post['recorder_id'];
$log['status_id']=$std['act'];
$log['status_name']=$std['name'];
$log['deal_time']=time();
$log['deal_role']=$nodeInfo['who'];
$log['deal_msg']=json_encode($post);
$log['member_id']=$memberInfo['id'];
$log['member_name']=$memberInfo['name'];
$log['app_id']=$appId;
$log['line_id']=$post['line_id'];
if(isset($payInfo['money']) && $payInfo['money']>0){
    $item=array();
    $item['act']="i";
    $item['table']="gd_deal";
    $item['data']=$log;
    $item['where']="";
    $orderData[]=$item;
}else{
    $result = pdo_insert("gd_deal",$log);
    if(!$result){
        $this->msg['msg']="写入数据日志失败(请检查当前是否是独立后台登录,或选择操作员工)";
        $this->echoAjax();
    }
}
//处理支付逻辑
if(!empty($payInfo) && $payInfo['money']>0){
    $payInfo['uniacid']=$_W['uniacid'];
    $payInfo['pay_status']=0;
    $payInfo['create_time']=time();
    $payInfo['member_id']=$memberInfo['id'];
    $payInfo['fms']=2;
    $payInfo['who_list']=$whoList;
    $orderSn = $payInfo['order_sn']=$this->createOrderSn();
    $payInfo['pool_id']=$poInfo['id'];
    //写入预存操作数据
    $payInfo['data']=json_encode($orderData);
    pdo_insert("gd_order",$payInfo);
    $orderId = pdo_insertid();

    //修改pool支付信息
    $poUp['need_pay']=1;
    $poUp['pay_money']=$payInfo['money'];
    $poUp['order_id']=$orderId;
    pdo_update("gd_pool",$poUp,array("id"=>$poInfo['id']));
}

//获取当前的处理节点
$this->msg['data']=$this->createMobileUrl("detail",array("id"=>$post['recorder_id']));
if(!empty($orderId)){
    $this->msg['data']=$this->createMobileUrl("pay",array("order_id"=>$orderId));
}
if($appInfo['menu']==0){
    $this->msg['data'] .="&app_id=".$appInfo['id'];
}
//取消第一个几点的数据
pdo_update("gd_deal",array("member_id"=>0),array("recorder_id"=>$post['recorder_id'],'from'=>1));

//发送模板消息通知
$statusStr=empty($status_name)?"":"($status_name)";
$node_name=$nodeInfo['name'];
$data = array(
    "first" => array(
        "value" => "处理通知",
    ),
    "keyword1" => array(
        "value" => $node_name.$statusStr
    ),
    "keyword2" => array(
        "value" => $appInfo['name']."\n提交:  ".$poolInfo['name']."\n单号:  ".$poolInfo['gd_sn']."\n提交时间:  ".date("Y-m-d H:i:s",$poolInfo['create_time'])
    ),
    "keyword3" => array(
        "value" => date("Y-m-d H:i:s",time())
    ),
    "remark" => array(
        "value" => "查看详情"
    )
);
$sMsg=array();
$mMsg=array();
$url = $_W['siteroot']."/".$this->createMobileUrl('detail',array("id"=>$post['recorder_id'],'app_id'=>$appInfo['id']));
if($nextNode['who']==1){//员工处理
    if($appInfo['mods']==0) {
        $groupList = json_decode($nextNode['who_list'], true);
        if (!empty($groupList)) {
            $groupStr = implode(",", $groupList);
            $sql = " select * from " . tablename("gd_admin") . " where department in ($groupStr) ";
            $adminList = pdo_fetchall($sql);
            if (isset($orderId)) {
                foreach ($adminList as $admin) {
                    $item = array();
                    $item['open_id'] = $admin['open_id'];
                    $item['data'] = $data;
                    $item['url'] = $url;
                    $sMsg[] = $item;
                }
            } else {
                foreach ($adminList as $admin) {
                    $this->sendMsg($admin['open_id'], $data, $url);
                }
            }
        }
    }
}else{ //客人处理
    $memberId =$recorderInfo['member_id'];
    $memberInfo=pdo_get("gd_member",array("id"=>$memberId));
    if(!empty($memberInfo)){
        if(isset($orderId)){
            $item=array();
            $item['open_id']=$memberInfo['open_id'];
            $item['data']=$data;
            $item['url']=$url;
            $mMsg[]=$item;
        }else{
            $this->sendMsg($memberInfo['open_id'],$data,$url);
        }
    }
}
if(isset($orderId)) {
    $sg['staff_msg'] = json_encode($sMsg);
    $sg['member_msg'] = json_encode($mMsg);
    pdo_update("gd_order", $sg, array("id" => $orderId));
}
//处理附件内容
if(!empty($ext)){
    foreach($ext as $item){
        $insert['name']=$item['lb'];
        $insert['url']=	$item['url'];
        $insert['label']=$item['b'].",";
        $insert['uniacid']=$_W['uniacid'];
        $insert['gd_sn']=$poolInfo['gd_sn'];
        $insert['pool_id']=$poolInfo['id'];
        $insert['create_time']=time();
        $insert['up_id']=$memberInfo['id'];
        $insert['up_name']=$memberInfo['name'];
        $insert['app_id']=$appId;
        pdo_insert("gd_fj",$insert);
    }
}
$this->msg['code']=1;
$this->msg['msg']="操作成功";
$this->echoAjax();