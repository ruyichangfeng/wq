<?php
//添加流程表

global $_GPC,$_W;
$post="";
parse_str($_GPC['post'],$post);

$memberInfo = pdo_get("gd_member",array("id"=>$post['member_id']));
$appId =$post['app_id'];
$appInfo = $this->getAppInfo($appId);
$name = $post['name'];
$mobile = $post['mobile'];
unset($post['member_id']);
unset($post['mobile']);
unset($post['name']);
unset($post['app_name']);

$flowInfo =$this->getFlowInfo($appInfo['flow_id']);
$lines =json_decode($flowInfo['line'],true);
$taskList = json_decode($flowInfo['task'],true);
$onlyForm=intval($appInfo['flow_id'])>0 ? false : true;
if(empty($appInfo) || empty($appInfo['table'])){
    $this->msg['msg']="表单数据未找到";
    $this->echoAjax();
}

$wList="";
$ext=array();
//检查提交次数
//获取请当前表单是否需要支付
$where=array("app_id"=>$appId);
$formInfo = pdo_get("gd_source_form",$where);
$formSource = json_decode($formInfo['source'],true);
foreach($formSource as $nd){
    //处理支付
    if($nd['type']=="price"){
        if(empty($payInfo)){
            $payInfo['money']=$nd['pl'];
            $payInfo['app_id']=$appId;
            $payInfo['node_id']=0;
            $payInfo['status_id']=0;
            $payInfo['from']=1;
        }else{
            $payInfo['money'] +=$nd['pl'];
        }
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
    //处理联动菜单
    if($nd['type']=='ld'){
        $nameStr="";
        $col =$nd['py'];
        if(isset($post[$col]) && (empty($post[$col]) || $post[$col]==",")){
            $this->msg['msg']="请选择联动结构";
            $this->echoAjax();
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
}
//获取第一个节点
if($onlyForm==0){
    $startNode = pdo_get("gd_node",array("flow_id"=>$flowInfo['id'],'ship'=>1));
    if(empty($startNode)){
        $this->msg['msg']="请添加开始节点";
        $this->echoAjax();
    }
    //获取第一个节点
    $startId = $startNode['xml_id'];
    $line = isset($taskList[$startId])?$taskList[$startId]:"";
    if(empty($line)){
        $this->msg['msg']="请添加开始节点";
        $this->echoAjax();
    }
    $outLine=isset($taskList[$startId]['outgoing'])?$taskList[$startId]['outgoing']:"";
    if(empty($outLine)){
        $this->msg['msg']="请添开始节点引导线";
        $this->echoAjax();
    }
    //查找开始节点线
    $lineInfo = $lines[$outLine];
    $firstNodeId=$lineInfo['targetRef'];
    $firstNode = isset($taskList[$firstNodeId])?$taskList[$firstNodeId]:"";
    $firstRNode=$this->getNodeInfoByXml($firstNode['id']);
    if(empty($firstNode)){
        $this->msg['msg']="请添加一个节点";
        $this->echoAjax();
    }
}
$post['app_pay']=0;
$post['next_act']=0;
$post['category']=$appInfo['category'];
$post['property']=isset($post['property'])?intval($post['property']):0;
if($post['property']>0){
    $proInfo = pdo_get("gd_property",array("id"=>$post['property']));
    if(!empty($proInfo)){
        $post['app_pay']+=$proInfo['pay'];
        if(empty($payInfo)){
            $payInfo['money']=$proInfo['pay'];
            $payInfo['app_id']=$appId;
            $payInfo['node_id']=0;
            $payInfo['status_id']=0;
            $payInfo['from']=1;
        }else{
            $payInfo['money'] +=$proInfo['pay'];
        }
    }
}
if(!empty($firstNode)){
    $post['node_id']=$firstRNode['id'];
    $post['node_name']=$firstRNode['name'];
    if($firstNode['who']==1){
        $post['next_act']=$firstRNode['who_list'];
    }
}
//解析如果存在地址信息
if(isset($post['address'])){
    $post['lc_lat']=$post['address']['lat'];
    $post['lc_lnt']=$post['address']['lnt'];
    $post[$post['address']['name']]=$post['address']['value'];
    unset($post['address']);
}
if(isset($post['sign'])){
    $post['sig_lat']=$post['sign']['lat'];
    $post['sig_lnt']=$post['sign']['lnt'];
    $post[$post['sign']['name']]=$post['sign']['value'];
    unset($post['sign']);
}
if(isset($post['pay'])){
    $post[$post['pay']]=1;
    unset($post['pay']);
}
if(isset($post['photo'])){
    $photo =json_decode($post['photo']['url'],true);
    $urlList = $this->media($photo,true);
    $post[$post['photo']['name']]=json_encode($urlList);
    unset($post['photo']);
}
if(isset($post['voice'])){
    $voice = $this->media($post['voice']['url'],false);
    $post[$post['voice']['name']]=$voice;
    $post["voice_time"]=$post['voice']['time'];
    unset($post['voice']);
}
unset($post['_fm']);
$post['uniacid']=$_W['uniacid'];
$post['create_time']=time();
$post['member_id']=empty($memberInfo['id'])?0:$memberInfo['id'];
$post['member_name']=empty($memberInfo['name'])?0:$memberInfo['name'];
$table = str_replace($this->getTablePre(),"",$appInfo['table']);
//如果是普通的表单
if($onlyForm){
    if(isset($payInfo)){
        $post['node_name']="提交";
        $post['do_status']=2;
        $post['status_name']="待支付";

        $pool['node_name']="提交";
        $pool['node_name_status']="待支付";
        $pool['node_status']=2;
        $pool['recorder_status']=7;
    }else{
        $post['node_name']="提交";
        $post['status_name']="已支付";
        $post['do_status']=1;
        $post['is_end']=1;
        $post['end_time']=time();

        $pool['node_name']="提交";
        $pool['node_name_status']="成功";
        $pool['node_status']=3;
        $pool['recorder_status']=2;
        $pool['end_time']=time();
    }
}
$isInsert=pdo_insert($table,$post);
$osn = pdo_insertid();
//写入订单池子
$pool['uniacid']=$_W['uniacid'];
$pool['app_id']=$appId;
$pool['app_name']=$appInfo['name'];
$pool['gd_sn']=$this->createOrderSn("gd_sn");
$pool['uid']=empty($memberInfo['uid'])?0:$memberInfo['uid'];
$pool['name']=empty($memberInfo['name'])?$name:$memberInfo['name'];
$pool['mobile']=empty($memberInfo['mobile'])?$mobile:$memberInfo['mobile'];
$pool['create_time']=time();
if(!$onlyForm){
    $pool['node_id']=$firstRNode['id'];
    $pool['node_name']=$firstRNode['name'];
    $pool['node_status']=0;
    $pool['recorder_status']=0;
}
$pool['do_list']="";
$pool['table']=$appInfo['table'];
$pool['recorder_id']=$osn;
$pool['is_form']=$onlyForm?1:0;
$pool['group_list']="";
$pool['who_list']="";
$pool['who']=intval($firstRNode['who']);
$pool['category']=$post['category'];
$pool['property']=$post['property'];
$pool['app_pay']=$post['app_pay'];
if($firstRNode['who']==1){
    $group=json_decode($firstRNode['who_list'],true);
    if(isset($payInfo) && $payInfo['money']>0){
        $pool['who_list']="";
        $wList=implode(",",$group).",";
    }else{
        $pool['who_list']=implode(",",$group).",";
    }
}
if($onlyForm){
    $department=json_decode($appInfo['department'],true);
    $groupStr=implode(",",$department);
    $pool['who_list']=$groupStr;
}
$res =pdo_insert("gd_pool",$pool);
$poolId =pdo_insertid();
if($isInsert && $res){
    //处理支付逻辑
    if(!empty($payInfo) && $payInfo['money']>0){
        $payInfo['uniacid']=$_W['uniacid'];
        $payInfo['pay_status']=0;
        $payInfo['create_time']=time();
        $payInfo['member_id']=$memberInfo['id'];
        $payInfo['fms']=1;
        $payInfo['who_list']=$onlyForm ? $pool['who_list'] : $wList;
        $orderSn = $payInfo['order_sn']=$this->createOrderSn();
        $payInfo['recorder_id']=$osn;
        $payInfo['pool_id']=$poolId;
        pdo_insert("gd_order",$payInfo);
        $orderId = pdo_insertid();
    }
    //发送模板消息通知
    $data = array(
        "first" => array(
            "value" => "提交成功",
        ),
        "keyword1" => array(
            "value" => $firstRNode['name']."(待处理)"
        ),
        "keyword2" => array(
            "value" => $appInfo['name']."\n提交:  ".(empty($memberInfo['name'])?$name:$memberInfo['name'])."\n单号:  ".$pool['gd_sn']
        ),
        "keyword3" => array(
            "value" => date("Y-m-d H:i:s",time())
        ),
        "remark" => array(
            "value" => "查看详情"
        )
    );
    if($onlyForm){
        $data = array(
            "first" => array(
                "value" => "欢迎提交",
            ),
            "keyword1" => array(
                "value" => "提交成功"
            ),
            "keyword2" => array(
                "value" => $appInfo['name']."\n提交:  ".(empty($memberInfo['name'])?$name:$memberInfo['name'])."\n单号:  ".$pool['gd_sn']
            ),
            "keyword3" => array(
                "value" => date("Y-m-d H:i:s",time())
            ),
            "remark" => array(
                "value" => "查看详情"
            )
        );
    }
    $mMsg=array();
    $sMsg=array();
    $url = $_W['siteroot']."/".$this->createMobileUrl('detail',array("id"=>$osn,'app_id'=>$appInfo['id']));
    //支付暂时存储模板消息
    if(isset($orderId)){
        $data['keyword1']['value']="支付成功";
        $item=array();
        $item['open_id']=$memberInfo['openid'];
        $item['data']=$data;
        $item['url']=$url;
        $mMsg[]=$item;
    }else{
        $this->sendMsg($memberInfo['openid'],$data,$url);
    }
    $data['first']['value']="待处理通知";
    if($firstRNode['who']==1){//员工处理
        if($appInfo['mods']==0){
            $groupList = json_decode($firstRNode['who_list'],true);
            if(!empty($groupList)){
                $groupStr=implode(",",$groupList);
                $sql = " select * from ".tablename("gd_admin")." where department in ($groupStr) ";
                $adminList=pdo_fetchall($sql);
                if(isset($orderId)){
                    foreach($adminList as $admin){
                        $item=array();
                        $item['open_id']=$admin['open_id'];
                        $item['data']=$data;
                        $item['url']=$url;
                        $sMsg[]=$item;
                    }
                }else{
                    foreach($adminList as $admin){
                        $this->sendMsg($admin['open_id'],$data,$url);
                    }
                }
            }
        }
    }
    if($onlyForm){
        if(!empty($groupStr)){
            $sql = " select * from ".tablename("gd_admin")." where department in ($groupStr) ";
            $adminList=pdo_fetchall($sql);
            if(isset($orderId)){
                $data['first']['value']="提交通知";
                $data['keyword1']['value']="支付成功";
                foreach($adminList as $admin){
                    $item=array();
                    $item['open_id']=$admin['open_id'];
                    $item['data']=$data;
                    $item['url']=$url;
                    $sMsg[]=$item;
                }
            }else{
                foreach($adminList as $admin){
                    $this->sendMsg($admin['open_id'],$data,$url);
                }
            }
        }
    }
    //给接收者发送提交信息
    if( !empty($memberInfo['open_id']) && $memberInfo['uid']>0 ){
        $data1 = array(
            "first" => array(
                "value" => "欢迎提交",
            ),
            "keyword1" => array(
                "value" => "提交成功"
            ),
            "keyword2" => array(
                "value" => $appInfo['name']."\n提交:  ".(empty($memberInfo['name'])?$name:$memberInfo['name'])."\n单号:  ".$pool['gd_sn']
            ),
            "keyword3" => array(
                "value" => date("Y-m-d H:i:s",time())
            ),
            "remark" => array(
                "value" => "查看详情"
            )
        );
        $urls = $_W['siteroot']."/".$this->createMobileUrl('pdetail',array("id"=>$osn,'app_id'=>$appInfo['id']));
        $this->sendMsg($memberInfo['open_id'],$data1,$urls);
    }
    //处理模板消息存储
    if(isset($orderId)){
        $up['staff_msg']=json_encode($sMsg);
        $up['member_msg']=json_encode($mMsg);
        pdo_update("gd_order",$up,array("id"=>$orderId));
        //在pool表处理需要支付的订单,金额状态
        $pup['need_pay']=1;
        $pup['pay_money']=$payInfo['money'];
        $pup['order_id']=$orderId;
        pdo_update("gd_pool",$pup,array("id"=>$poolId));
    }
    $this->msg['data']=$this->createMobileUrl("index");
    if(!empty($orderId)){
        $this->msg['data']=$this->createMobileUrl("pay",array("order_id"=>$orderId));
    }else{
        $this->msg['data']=$this->createMobileUrl("category");
    }
    if($appInfo['menu']==0){
        $this->msg['data'] .="&app_id=".$appInfo['id'];
    }
    //处理附件内容
    if(!empty($ext)){
        foreach($ext as $item){
            $insert['name']=$item['lb'];
            $insert['url']=	$item['url'];
            $insert['label']=$item['b'].",";
            $insert['uniacid']=$_W['uniacid'];
            $insert['gd_sn']=$pool['gd_sn'];
            $insert['pool_id']=$poolId;
            $insert['create_time']=time();
            $insert['up_id']=$memberInfo['id'];
            $insert['up_name']=$memberInfo['name'];
            $insert['app_id']=$appId;
            pdo_insert("gd_fj",$insert);
        }
    }
    $this->msg['code']=1;
    $this->msg['msg']="保存成功";
    $this->echoAjax();
}
$this->msg['msg']="保存失败";
$this->echoAjax();