<?php
/**
 *微信端口提交数据
 * 首页提交数据
 * 操作页提交数据
 */

global $_GPC,$_W;
$selctUser=0;
$sumAdmin=array();
$post=array();
$gdSn = "";
$this->selectApps();
parse_str($_GPC['post'],$post);
$sourcePost=$post;

$location=array();

$memberInfo = $this->getMemberInfo();
if(empty($memberInfo)){
    $this->msg['msg']="请使用微信打开使用";
    $this->echoAjax();
}
$appId =$post['app_id'];
$appInfo = $this->getAppInfo($appId);

$flowInfo =$this->getFlowInfo($appInfo['flow_id']);
$lines =json_decode($flowInfo['line'],true);
$taskList = json_decode($flowInfo['task'],true);

$onlyForm=intval($appInfo['flow_id'])>0 ? false : true;
if(empty($appInfo) || empty($appInfo['table'])){
    $this->msg['msg']="表单数据未找到";
    $this->echoAjax();
}

//验证码处理
if(isset($post['sms_code'])){
    $smCode=$post['sms_code'];
    $info = pdo_get("gd_sms",array("code"=>$smCode));
    if(empty($info) || $info['end_time']<time()){
        $this->msg['msg']="验证码错误";
        $this->echoAjax();
    }
    unset($post['sms_code']);
}
$pagePay=0;
$hbId=array();
if(isset($post['page_pay'])){
    $pagePay=$payInfo['money']=$post['page_pay'];
    $payInfo['node_id']=0;
    $payInfo['status_id']=0;
    $payInfo['from']=1;
}
unset($post['page_pay']);

//积分处理
if(isset($post['points'])){
    $point=$post['points'];
    $memberInfo = pdo_get("mc_members",array("uid"=>$_W['member']['uid']));
    pdo_update("mc_members",array("credit1"=>$memberInfo['credit1']+intval($point)),array("uid"=>$_W['member']['uid']));

    //写入积分日志
    $log['uid']=$_W['member']['uid'];
    $log['uniacid']=$_W['uniacid'];
    $log['credittype']="credit1";
    $log['num']= $point;
    $log['operator']=0;
    $log['module']=0;
    $log['clerk_id']=0;
    $log['store_id']=0;
    $log['clerk_type']=1;
    $log['createtime']=time();
    $log['remark']="智慧应用赠送";
    pdo_insert("mc_credits_record",$log);
    unset($post['points']);
}

//首页数据提交
if(isset($post['_fm']) && $post['_fm']=='index'){
    $num=0;
    $wList="";
    //检查提交次数
    $cond=$appInfo['cond'];
    $adminInfo =$this->isAdmin();
    $condNum=$appInfo['cond_num'];
    $perNum=($appInfo['per_num']>0)?$appInfo['per_num']:1;
    $endTime=$this->paseTime($cond,$perNum);

    //如果开启提交限制,检查是否合法
    if($cond>0 ){
        $where['uid']=$_W['member']['uid'];
        $where['uniacid']=$_W['uniacid'];
        $where['app_id']=$appInfo['id'];
        $list=pdo_getall("gd_pool",$where);
        foreach($list as $val){
            if(time()-$val['create_time']<$endTime)
                $num ++;
        }
        if($num>=$condNum){
            $this->msg['msg']="提交次数超过了限制";
            $this->echoAjax();
        }
    }
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
        if($nd['type']=='hb'){
            $hbId[]=$nd['pl'];
        }
        if($nd['type']=='doadm'){
            $selctUser=$post[$nd['py']];
            $adminInfo = pdo_get("gd_admin",array("id"=>$$selctUser));
            if(!empty($adminInfo)){
                $post[$nd['py']]=$adminInfo['name'];
            }
        }
        //处理签字图片
        if($nd['type']=='sg'){
            $fileName=date("YmdHis").rand(1000,9999).".png";
            $dir="gd_sign";
            $fileName =$dir."/".$fileName;
            $filePath=ATTACHMENT_ROOT.$fileName;
            //检查目录是否存在
            if(!is_dir(ATTACHMENT_ROOT.$dir)){
                @mkdir(ATTACHMENT_ROOT.$dir);
            }
            //媒体文件保存在本地
            $img = str_replace('data:image/png;base64,', '', $post[$nd['py']]);
            @file_put_contents($filePath,base64_decode($img));
            $post[$nd['py']]=$fileName;
        }
        if($nd['type']=='dogroup'){
            //更改会员组
            $groupId = $post[$nd['py']];
            $groupInfo = pdo_get("mc_groups",array("groupid"=>$groupId));
            pdo_update("mc_members",array("groupid"=>$groupId),array("uid"=>$_W['member']['uid']));
            if(!empty($groupInfo)){
                $post[$nd['py']]=$groupInfo['title'];
                pdo_update("gd_member",array('group_id'=>$groupId,'group_name'=>$groupInfo['title']),array("uid"=>$_W['member']['uid']));
                cache_build_memberinfo($_W['member']['uid']);
            }
        }
        if($nd['type']=='doser'){
            $id = $post[$nd['py']];
            $have = pdo_get("gd_code",array("uniacid"=>$_W['uniacid'],'status'=>0,'label'=>$id));
            if(!empty($have)){
                $post[$nd['py']]=$have['sn'];
                $mg =pdo_update("gd_code",array("member_id"=>$memberInfo['id'],'member_name'=>$memberInfo['name'],'use_time'=>time(),'status'=>1),array("id"=>$have['id']));
            }else{
                $post[$nd['py']]="请联系员工获取";
            }
        }
        if($nd['type']=='inku'){
            $cols=$nd['py'];
            $storeIfo = explode("-",$post['ku_info']);
            unset($post['ku_info']);
            $num = $post[$cols];
            $goods=$storeIfo[0];
            $store =$storeIfo[1];

            $dbInfo = pdo_get("gd_zlk",array("id"=>$store));
            $colInfo =json_decode($dbInfo['xml'],true);
            $nameCol="";
            foreach($colInfo as $val) {
                if ($val['type'] == "inku") {
                    $nameCol = $val['py'];
                }
            }
            //获取现有库存
            $saveInfo =pdo_get($dbInfo['table'],array("id"=>$goods));
            pdo_update($dbInfo['table'],array($nameCol=>$saveInfo[$nameCol]+$num),array("id"=>$goods));
        }
        if($nd['type']=='outku'){
            $cols=$nd['py'];
            $storeIfo = explode("-",$post['ku_info']);
            unset($post['ku_info']);
            $num = $post[$cols];
            $goods=$storeIfo[0];
            $store =$storeIfo[1];

            $dbInfo = pdo_get("gd_zlk",array("id"=>$store));
            $colInfo =json_decode($dbInfo['xml'],true);
            $nameCol="";
            foreach($colInfo as $val) {
                if ($val['type'] == "inku") {
                    $nameCol = $val['py'];
                }
            }
            //获取现有库存
            $saveInfo =pdo_get($dbInfo['table'],array("id"=>$goods));
            pdo_update($dbInfo['table'],array($nameCol=>$saveInfo[$nameCol]-$num),array("id"=>$goods));
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
        //如果是照片,需要上传云
        if($nd['type']=='photo'){
            $col =$nd['py'];
            $photo =json_decode($post[$col],true);
            $urlList = $this->media($photo,true);
            $post[$col]=json_encode($urlList);
        }
        //是语音需要上传云
        if($nd['type']=='voice'){
            $col =$nd['py'];
            $voList =explode(",",$post[$col]);
            if(isset($voList[0])){
                $voice = $this->media($voList[0],false);
                $post[$col]=$voice;
            }
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
    $post['app_pay']=$pagePay;
    $post['next_act']=0;
    $post['category']=$appInfo['category'];
    $post['property']=isset($post['property'])?intval($post['property']):0;
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
        $location = $post['address'];
        unset($post['address']);
    }
    if(isset($post['pay'])){
        $post[$post['pay']]=1;
        unset($post['pay']);
    }
    unset($post['_fm']);
    $post['uniacid']=$_W['uniacid'];
    $post['create_time']=time();
    $post['member_id']=$memberInfo['id'];
    $post['member_name']=$memberInfo['name'];
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
    $gdSn = $pool['gd_sn']=$this->createOrderSn("gd_sn");
    $pool['uid']=$_W['member']['uid'];
    $pool['name']=$memberInfo['name'];
    $pool['mobile']=$memberInfo['mobile'];
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
    //检查是否存在选择管理员
    if(!empty($firstRNode['adm_list'])){
        $fmArray=json_decode($firstRNode['adm_list'],true);
        foreach($fmArray as $vl){
            $sumAdmin[$vl]=$vl;
        }
    }
    //如果有客户选择管理员
    if($selctUser){
        $sumAdmin[$selctUser]=$selctUser;
    }
    $pool['adm_list']=empty($sumAdmin)?"":implode("-",$sumAdmin)."-";
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
    if($poolId){
        foreach($formSource as $nd) {
            if ($nd['type'] == "lastdate") {
                $infos = pdo_get("gd_gq",array("id"=>$nd['pl']));
                if(!$infos){
                    continue;
                }
                if($infos['unit']==1){
                    $exp = strtotime("+{$infos['num']} month");
                }else if($infos['unit']==2){
                    $exp = strtotime("+{$infos['num']} year");
                }else{
                    $exp = strtotime("+{$infos['num']} day");
                }
                $dt['open_id']=$_W['openid'];
                $dt['url']=$infos['url'];
                $dt['title']=$infos['title'];
                $dt['remark']=$infos['remark'];
                $dt['type']=1;
                //保存提醒信息
                $remind['uniacid']=$_W['uniacid'];
                $remind['pool_id']=$poolId;
                $remind['send_num']=0;
                $remind['create_time']=time();
                $remind['remind_time']=$exp;
                $remind['msg_info']=json_encode(array($dt));
                $remind['node_id']=$firstRNode['id'];
                $remind['status_str']="已到期";
                $remind['status']=1;
                pdo_insert("gd_remind",$remind);
            }
        }
    }
    if($isInsert && $res){
        //添加位置日志
        if(!empty($location)){
            $lct['uniacid']=$_W['uniacid'];
            $lct['app_id']=$appInfo['id'];
            $lct['name']=$location['value'];
            $lct['lat']=$location['lat'];
            $lct['lnt']=$location['lnt'];
            $lct['create_time']=time();
            $lct['r_id']=$poolId;
            $lct['gd_sn']=$gdSn;
            $lct['s_id']=$osn;
            pdo_insert("gd_lct",$lct);
        }
        //处理支付逻辑
        if(!empty($payInfo) && $payInfo['money']>0){
            $payInfo['uniacid']=$_W['uniacid'];
            $payInfo['pay_status']=0;
            $payInfo['create_time']=time();
            $payInfo['member_id']=$memberInfo['id'];
            $payInfo['fms']=1;
            $payInfo['who_list']=$onlyForm ? $pool['who_list'] : $wList;
            $gdSn=$orderSn = $payInfo['order_sn']=$this->createOrderSn();
            $payInfo['recorder_id']=$osn;
            $payInfo['pool_id']=$poolId;
            pdo_insert("gd_order",$payInfo);
            $orderId = pdo_insertid();
        }
        $statusStr=$saveStatus=$firstRNode['name']."(待处理)";
        //发送模板消息通知
        $data = array(
            "first" => array(
                "value" => "提交成功",
            ),
            "keyword1" => array(
                "value" => $firstRNode['name']."(待处理)"
            ),
            "keyword2" => array(
                "value" => $appInfo['name']."\n提交:  ".$memberInfo['name']."\n单号:  ".$pool['gd_sn']
            ),
            "keyword3" => array(
                "value" => date("Y-m-d H:i:s",time())
            ),
            "remark" => array(
                "value" => "查看详情"
            )
        );
        $sms['name']=$memberInfo['name'];
        $sms['order']=$pool['gd_sn'];
        $sms['status']=$firstRNode['name']."-待处理";
        $sms['time']=date("Y-m-d H:i");
        $sms['mobile']=$memberInfo['mobile'];
        if($onlyForm){
            $data = array(
                "first" => array(
                    "value" => "欢迎提交",
                ),
                "keyword1" => array(
                    "value" => "提交成功"
                ),
                "keyword2" => array(
                    "value" => $appInfo['name']."\n提交:  ".$memberInfo['name']."\n单号:  ".$pool['gd_sn']
                ),
                "keyword3" => array(
                    "value" => date("Y-m-d H:i:s",time())
                ),
                "remark" => array(
                    "value" => "查看详情"
                )
            );
            $sms['name']=$memberInfo['name'];
            $sms['order']=$pool['gd_sn'];
            $sms['status']=$firstRNode['name']."-提交成功";
            $sms['time']=date("Y-m-d H:i");
            $sms['mobile']=$memberInfo['mobile'];
        }
        $mMsg=array();
        $sMsg=array();
        $nMsg=array();
        $url = $_W['siteroot']."/".$this->createMobileUrl('pdetail',array("id"=>$osn,'app_id'=>$appInfo['id']));
        //支付暂时存储模板消息
        $item=array();
        $item['open_id']=$_W['openid'];
        $item['data']=$data;
        $item['url']=$url;
        $mMsg[]=$item;
        if(isset($orderId)){
            $data['keyword1']['value']="支付成功";
            $nMsg[]=$sms;
        }else{
            $this->sendMsg($_W['openid'],$data,$url);
            $this->sendFlowMsg($sms);
        }
        //检查是否需要缓存提醒
        $checkCols = json_decode($firstRNode['form_list'],true);
        $needRemind=0;
        foreach($checkCols as $cl){
            if($cl['type']=="remind"){
                $gsList =explode("*",$cl['pl']);
                if(count($gsList)!=0){
                    $needRemind = 1;
                    foreach($gsList as $val){
                        $needRemind = $needRemind * intval($val);
                    }
                }
            }
        }
        if(intval($needRemind)>0){
            if($firstRNode['who']==2){
                //保存提醒信息
                $remind['uniacid']=$_W['uniacid'];
                $remind['pool_id']=$poolId;
                $remind['send_num']=0;
                $remind['create_time']=time();
                $remind['remind_time']=time()+$needRemind;
                $remind['msg_info']=json_encode($mMsg);
                $remind['node_id']=$firstRNode['id'];
                $remind['status_str']=$statusStr;
                if(isset($orderId)){
                    $remind['status']=0;
                    $remind['order_id']=$orderId;
                }else{
                    $remind['status']=1;
                }
                pdo_insert("gd_remind",$remind);
            }
        }
        $url1 = $_W['siteroot'].$this->createMobileUrl('sdetail',array("id"=>$osn,'app_id'=>$appInfo['id']));
        $data['first']['value']="待处理通知";
        if($firstRNode['who']==1){//员工处理
            $groupList = json_decode($firstRNode['who_list'],true);
            if(!empty($groupList) || !empty($sumAdmin)){
                //如果员工组不为空
                if(!empty($groupList)){
                    $groupStr=implode(",",$groupList);
                    $sql = " select * from ".tablename("gd_admin")." where department in ($groupStr) ";
                    $adminList=pdo_fetchall($sql);
                    foreach($adminList as $val){
                        $sumAdmin[$val['id']]=$val['id'];
                    }
                }
                $adminStr=implode(",",$sumAdmin);
                //重新获取新的管理员
                $sql = " select * from ".tablename("gd_admin")." where id in ($adminStr) ";
                $adminList=pdo_fetchall($sql);
                if(isset($orderId)){
                    foreach($adminList as $admin){
                        $item=array();
                        $item['open_id']=$admin['open_id'];
                        $item['data']=$data;
                        $item['url']=$url1;
                        $sms['name']=$admin['name'];
                        $sms['mobile']=$admin['mobile'];
                        $sMsg[]=$item;
                        $nMsg[]=$sms;
                    }
                    $remind['status']=0;
                    $remind['order_id']=$orderId;
                }else{
                    foreach($adminList as $admin){
                        $item=array();
                        $item['open_id']=$admin['open_id'];
                        $item['data']=$data;
                        $item['url']=$url1;
                        $sMsg[]=$item;
                        $this->sendMsg($admin['open_id'],$data,$url1);

                        $sms['name']=$admin['name'];
                        $sms['mobile']=$admin['mobile'];
                        $this->sendFlowMsg($sms);
                    }
                    $remind['status']=1;
                }
                if(intval($needRemind)>0){
                    //保存提醒信息
                    $remind['uniacid']=$_W['uniacid'];
                    $remind['pool_id']=$poolId;
                    $remind['send_num']=0;
                    $remind['create_time']=time();
                    $remind['remind_time']=time()+$needRemind;
                    $remind['msg_info']=json_encode($sMsg);
                    $remind['node_id']=$firstRNode['id'];
                    $remind['status_str']=$statusStr;
                    pdo_insert("gd_remind",$remind);
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
                        $sms['name']=$admin['name'];
                        $sms['mobile']=$admin['mobile'];
                        $nMsg[]=$sms;
                    }
                }else{
                    foreach($adminList as $admin){
                        $this->sendMsg($admin['open_id'],$data,$url);
                        $sms['name']=$admin['name'];
                        $sms['mobile']=$admin['mobile'];
                        $this->sendFlowMsg($sms);
                    }
                }
            }
        }
        //处理模板消息存储
        if(isset($orderId)){
            $up['staff_msg']=json_encode($sMsg);
            $up['member_msg']=json_encode($mMsg);
            $up['sms_msg']=json_encode($nMsg);
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
        //发送红包,如果需要
        if(!empty($hbId)){
            $this->sendHb($hbId,$memberInfo,$appInfo,$gdSn);
        }
        $this->msg['code']=1;
        $this->msg['msg']="保存成功";
        $this->echoAjax();
    }
    $this->msg['msg']="保存失败";
    $this->echoAjax();

}else if(isset($post['_fm']) && $post['_fm']=='mark'){
    $pool=array();
    $orderData=array();
    //解析数据
    $nodeInfo = $this->getNodeInfo($post['node_id']);
    $table = str_replace($this->getTablePre(),"",$appInfo['table']);
    $recorderInfo = pdo_get($table,array("id"=>$post['recorder_id']));
    $formList=json_decode($nodeInfo['form_list'],true);

    //获取表单信息
    $lineInfo = pdo_get("gd_preline",array("flow_id"=>$flowInfo['id'],"line_id"=>$post['line_id']));
    if(!empty($lineInfo) && !empty($lineInfo['form_list'])){
        $formList = json_decode($lineInfo['form_list'],true);
    }
    $needPay=false;
    foreach($formList as $vls){
        if($vls['type']=="pay"){
            $needPay=true;
        }
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
        //红包处理
        if($nd['type']=='hb'){
            $hbId[]=$nd['pl'];
        }
        //如果是照片,需要上传云
        if($nd['type']=='photo'){
            $col =$nd['py'];
            $photo =json_decode($post[$col],true);
            $urlList = $this->media($photo,true);
            $post[$col]=json_encode($urlList);
        }
        //处理签字图片
        if($nd['type']=='sg'){
            $fileName=date("YmdHis").rand(1000,9999).".png";
            $dir="gd_sign";
            $fileName =$dir."/".$fileName;
            $filePath=ATTACHMENT_ROOT.$fileName;
            //检查目录是否存在
            if(!is_dir(ATTACHMENT_ROOT.$dir)){
                @mkdir(ATTACHMENT_ROOT.$dir);
            }
            //媒体文件保存在本地
            $img = str_replace('data:image/png;base64,', '', $post[$nd['py']]);
            @file_put_contents($filePath,base64_decode($img));
            $post[$nd['py']]=$fileName;
        }
        if($nd['type']=='doadm'){
            $selctUser=$post[$nd['py']];
            $adminInfo = pdo_get("gd_admin",array("id"=>$$selctUser));
            if(!empty($adminInfo)){
                $post[$nd['py']]=$adminInfo['name'];
            }
        }
        if($nd['type']=='doser'){
            $id = $post[$nd['py']];
            $have = pdo_get("gd_code",array("uniacid"=>$_W['uniacid'],'status'=>0,'label'=>$id));
            if($have){
                $post[$nd['py']]=$have['sn'];
                pdo_update("gd_code",array("member_id"=>$memberInfo['id'],'member_name'=>$memberInfo['name'],'use_time'=>time(),'status'=>1),array("id"=>$have['id']));
            }else{
                $post[$nd['py']]="请联系员工获取";
            }
        }
        if($nd['type']=='dogroup'){
            //更改会员组
            $groupId = $post[$nd['py']];
            $groupInfo = pdo_get("mc_groups",array("groupid"=>$groupId));
            $rInfo = pdo_get("gd_member",array("id"=>$recorderInfo['member_id']));
            pdo_update("mc_members",array("groupid"=>$groupId),array("uid"=>$rInfo['uid']));
            if(!empty($groupInfo) && !empty($rInfo)){
                $post[$nd['py']]=$groupInfo['title'];
                pdo_update("gd_member",array('group_id'=>$groupId,'group_name'=>$groupInfo['title']),array("uid"=>$rInfo['uid']));
                cache_build_memberinfo($rInfo['uid']);
            }
        }
        //是语音需要上传云
        if($nd['type']=='voice'){
            $col =$nd['py'];
            $voList =explode(",",$post[$col]);
            if(isset($voList[0])){
                $voice = $this->media($voList[0],false);
                $post[$col]=$voice;
            }
        }
    }
    //获取上一节点支付信息
    $poolInfo =pdo_get("gd_pool",array("recorder_id"=>$recorderInfo['id'],'table'=>$appInfo['table']));
    pdo_update("gd_remind",array("status"=>2),array("node_id"=>$nodeInfo['id'],'pool_id'=>$poolInfo['id']));
    //添加位置日志
    if(isset($post['address'])){
        $lct['uniacid']=$_W['uniacid'];
        $lct['app_id']=$appInfo['id'];
        $lct['name']=$post['address']['value'];
        $lct['lat']=$post['address']['lat'];
        $lct['lnt']=$post['address']['lnt'];
        $lct['create_time']=time();
        $lct['r_id']=$poolInfo['id'];
        $lct['gd_sn']=$poolInfo['gd_sn'];
        $lct['s_id']=$post['recorder_id'];
        pdo_insert("gd_lct",$lct);
    }
    if($needPay){
        if(!empty($poolInfo['before_node'])){
            $nodeIf=$this->getNodeInfo($poolInfo['before_node']);
            $formList=json_decode($nodeIf['form_list'],true);
            if(!empty($poolInfo['before_line'])){
                $lineInfo =pdo_get("gd_preline",array("line_id"=>$poolInfo['before_line'],"flow_id"=>$flowInfo['id']));
                if(!empty($lineInfo) && !empty($lineInfo['form_list'])){
                    $formList = json_decode($lineInfo['form_list'],true);
                }
            }
        }
        if(isset($formList)){
            foreach($formList as $key=>$vl){
                if($vl['type']=="price"){
                    $colName = $vl['py'];
                }
            }
        }
        //上一节点存在报价
        if(isset($colName)){
            $where['app_id']=$appId;
            $where['node_id']=$poolInfo['before_node'];
            $where['recorder_id']=$post['recorder_id'];
            $preInfo=pdo_get("gd_deal",$where);
            if(!empty($preInfo)){
                $inInfo = json_decode($preInfo['deal_msg'],true);
                if(isset($inInfo[$colName])){
                    if(empty($payInfo)){
                        $payInfo['money']=$inInfo[$colName];
                        $payInfo['app_id']=$appId;
                        $payInfo['node_id']=$nodeInfo['id'];
                        $payInfo['status_id']=$post['status_id'];
                        $payInfo['from']=2;
                        $payInfo['recorder_id']=$post['recorder_id'];
                    }else{
                        $payInfo['money'] +=$inInfo[$colName];
                        $payInfo['from']=2;
                    }
                }
            }
        }
    }
    //获取当前操作线路信息
    $this->parseNodeStatus($lines[$post['line_id']],$taskList,$lines,$nodeInfo['id']);
    $std = isset($this->statusLine[0])?$this->statusLine[0]:array();
    $status_name = isset($std['name'])?$std['name']:"";
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
    if($nodeInfo['who']==1){
        $pool['is_mark']=0;
        $pool['mark_time']=0;
        //获取消息记录
        $adminInfo=$this->isAdmin();
        $pool['staff_list'] =$poolInfo['staff_list'].$adminInfo['id']."-".$nodeInfo['id'].",";
    }
    if($nextNode['who']==1){
        $whoList=json_decode($nextNode['who_list'],true);
        $whoList=implode(",",$whoList).",";
    }else if($nextNode['who']==3){
        $whoList=json_decode($nextNode['who_list'],true);
        $whoList=implode(",",$whoList).",";
        $pool['mark_time']=time();
        $pool['is_mark']=1;
    }
    $pool['group_list']=$whoList;
    $pool['who_list']=$whoList;
    //检查是否存在选择管理员
    if(!empty($nextNode['adm_list'])){
        $fmArray=json_decode($nextNode['adm_list'],true);
        foreach($fmArray as $vl){
            $sumAdmin[$vl]=$vl;
        }
    }
    //如果有客户选择管理员
    if($selctUser){
        $sumAdmin[$selctUser]=$selctUser;
    }
    $pool['adm_list']=empty($sumAdmin)?"":implode("-",$sumAdmin)."-";
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
    $log=array();
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
            $this->msg['msg']="写入数据日志失败";
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
        $gdSn=$orderSn = $payInfo['order_sn']=$this->createOrderSn();
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
    $status_name=empty($status_name)?"未知":"$status_name";
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
    $sms['name']=$memberInfo['name'];
    $sms['order']=$poolInfo['gd_sn'];
    $sms['status']=$node_name."-".$status_name;
    $sms['time']=date("Y-m-d H:i");
    $sms['mobile']=$memberInfo['mobile'];

    $sMsg=array();
    $mMsg=array();
    $nMsg=array();
    $url1 = $_W['siteroot'].$this->createMobileUrl('sdetail',array("id"=>$post['recorder_id'],'app_id'=>$appInfo['id']));
    //检查是否需要缓存提醒
    $checkCols = json_decode($nextNode['form_list'],true);
    $needRemind=0;
    foreach($checkCols as $cl){
        if($cl['type']=="remind"){
            $gsList =explode("*",$cl['pl']);
            if(count($gsList)!=0){
                $needRemind = 1;
                foreach($gsList as $val){
                    $needRemind = $needRemind * intval($val);
                }
            }
        }
    }

    if($nextNode['who']==1){
        $groupList = json_decode($nextNode['who_list'], true);
        if(!empty($groupList) || !empty($sumAdmin) || $selctUser){
            if(!empty($groupList)){
                $groupStr = implode(",", $groupList);
                $sql = " select * from " . tablename("gd_admin") . " where department in ($groupStr) ";
                $adminList = pdo_fetchall($sql);
                foreach($adminList as $val){
                    $sumAdmin[$val['id']]=$val['id'];
                }
            }
            $adminStr=implode(",",$sumAdmin);
            //重新获取新的管理员
            $sql = " select * from ".tablename("gd_admin")." where id in ($adminStr) ";
            $adminList=pdo_fetchall($sql);
            if (isset($orderId)) {
                foreach ($adminList as $admin) {
                    $item = array();
                    $item['open_id'] = $admin['open_id'];
                    $item['data'] = $data;
                    $item['url'] = $url1;
                    $sMsg[] = $item;

                    $sms['name']=$admin['name'];
                    $sms['mobile']=$admin['mobile'];
                    $nMsg[]=$sms;
                }
            } else {
                foreach ($adminList as $admin) {
                    $item = array();
                    $item['open_id'] = $admin['open_id'];
                    $item['data'] = $data;
                    $item['url'] = $url1;
                    $sMsg[] = $item;

                    $sms['name']=$admin['name'];
                    $sms['mobile']=$admin['mobile'];
                    $this->sendMsg($admin['open_id'], $data, $url1);
                    $this->sendFlowMsg($sms);
                }
            }
            $remind['msg_info']=json_encode($sMsg);
        }
    }else if($nextNode['who']==3){ //同一个人处理
        if(!empty($poolInfo['mark_admin'])){
            $preAdmin=$this->getAdminInfo($poolInfo['mark_admin']);
            if(!empty($preAdmin)){
                $item=array();
                $item['open_id']=$preAdmin['open_id'];
                $item['data']=$data;
                $item['url']=$url1;
                $mMsg[]=$item;
                if(isset($orderId)){
                    $sms['name']=$preAdmin['name'];
                    $sms['mobile']=$preAdmin['mobile'];
                    $nMsg[]=$sms;
                }else{
                    $this->sendMsg($preAdmin['open_id'],$data,$url1);
                    $sms['name']=$preAdmin['name'];
                    $sms['mobile']=$preAdmin['mobile'];
                    $this->sendFlowMsg($sms);
                }
                $remind['msg_info']=json_encode($mMsg);
            }
        }
    }
    //客人处理
    $memberId =$recorderInfo['member_id'];
    $memberInfo=pdo_get("gd_member",array("id"=>$memberId));
    $url = $_W['siteroot'].$this->createMobileUrl('pdetail',array("id"=>$post['recorder_id'],'app_id'=>$appInfo['id']));
    if(!empty($memberInfo)){
        $item=array();
        $item['open_id']=$memberInfo['open_id'];
        $item['data']=$data;
        $item['url']=$url;
        $mMsg[]=$item;
        if(isset($orderId)){
            $sms['name']=$memberInfo['name'];
            $sms['mobile']=$memberInfo['mobile'];
            $nMsg[]=$sms;
        }else{
            $this->sendMsg($memberInfo['open_id'],$data,$url);
            $sms['name']=$memberInfo['name'];
            $sms['mobile']=$memberInfo['mobile'];
            $this->sendFlowMsg($sms);
        }
        $remind['msg_info']=json_encode($mMsg);
    }
    if(intval($needRemind)>0){
        //保存提醒信息
        $remind['uniacid']=$_W['uniacid'];
        $remind['pool_id']=$poolInfo['id'];
        $remind['send_num']=0;
        $remind['create_time']=time();
        $remind['remind_time']=time()+$needRemind*60;
        $remind['node_id']=$nextNode['id'];
        $remind['status_str']=$nextNode['name']."(待处理)";
        if(isset($orderId)){
            $remind['status']=0;
            $remind['order_id']=$orderId;
        }else{
            $remind['status']=1;
        }
        pdo_insert("gd_remind",$remind);
    }
    foreach($formList as $nd) {
        if ($nd['type'] == "lastdate") {
            $infos = pdo_get("gd_gq",array("id"=>$nd['pl']));
            if(!$infos){
                continue;
            }
            if($infos['unit']==1){
                $exp = strtotime("+{$infos['num']} month");
            }else if($infos['unit']==2){
                $exp = strtotime("+{$infos['num']} year");
            }else{
                $exp = strtotime("+{$infos['num']} day");
            }
            $mInfo = pdo_get("gd_member",array("uid"=>$poolInfo['uid']));
            if(!$mInfo){
                continue;
            }
            $dt['open_id']=$mInfo['openid'];
            $dt['url']=$infos['url'];
            $dt['title']=$infos['title'];
            $dt['remark']=$infos['remark'];
            $dt['type']=1;
            //保存提醒信息
            $remind['uniacid']=$_W['uniacid'];
            $remind['pool_id']=$poolInfo['id'];
            $remind['send_num']=0;
            $remind['create_time']=time();
            $remind['remind_time']=$exp;
            $remind['msg_info']=json_encode(array($dt));
            $remind['node_id']=$post['node_id'];
            $remind['status_str']="已到期";
            $remind['status']=1;
            pdo_insert("gd_remind",$remind);
        }
    }
    if(isset($orderId)) {
        $sg['staff_msg'] = json_encode($sMsg);
        $sg['member_msg'] = json_encode($mMsg);
        $sg['sms_msg']=json_encode($nMsg);
        pdo_update("gd_order", $sg, array("id" => $orderId));
    }
    //发送红包,如果需要
    if(!empty($hbId)){
        $this->sendHb($hbId,$memberInfo,$appInfo,$gdSn);
    }
    $this->msg['code']=1;
    $this->msg['msg']="操作成功";
    $this->echoAjax();
}else{
    $this->msg['msg']="数据异常提交";
    $this->echoAjax();
}