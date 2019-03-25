<?php
//倒出数据,按应用导出

global $_GPC,$_W;
$appInfo=$this->getAppInfo($_GPC['app']);
$where = " p.uniacid={$_W['uniacid']} ";
if(!isset($_GPC['start'])){
    $start = strtotime(date("Y-m-d",time()));
    $end = strtotime("+1 day",$start);
}else{
    $start = strtotime($_GPC['start']);
    $end = strtotime($_GPC['end']);
}
$where .= " and p.app_id={$_GPC['app']} ";
$where.= " and p.create_time>$start and p.create_time<$end ";
if(!empty($_GPC['name'])){
    $where .= " and p.member_name like '%{$_GPC['name']}%' ";
}

if(empty($_GPC['status'])){
    $_GPC['status']=-1;
}
if($_GPC['status']==5){
    $_GPC['status']=0;
}

$whList[5]=" and is_mark=1 and node_status=2 and (recorder_status=0 or recorder_status=1) and cancel_time=0 and is_abort=0 and is_form=0 ";
$whList[10]=" and recorder_status!=0 and recorder_status!=2 and is_form=0 ";
$whList[1]= " and recorder_status=1 and is_form=0 ";
$whList[6]=" and recorder_status!=3 and is_abort=1 and is_form=0 ";
$whList[2]=" and recorder_status=2 and cancel_time=0 and is_abort=0 and is_form=0 ";
$whList[3]=" and recorder_status=3 and cancel_time>0 and is_abort=1 and is_form=0 ";
$whList[0]=" and is_mark=0 and is_abort=0 and is_form=0 and  recorder_status=0 ";
$whList[100]=" and is_form=1 ";

$where .= $whList[$_GPC['status']];

$status =$this->getRdStatus();

$page =empty($_GPC['page'])?1:intval($_GPC['page']);
$csvName = empty($_GPC['table'])?rand(10000,99999).".csv":$_GPC['table'];
$file=ATTACHMENT_ROOT."excel/".$csvName;

$form=pdo_get("gd_source_form",array("app_id"=>$appInfo['id']));
$form =json_decode($form['source'],true);
if($page==1){
    //获取flow信息
    $nodeList=pdo_getall("gd_node",array("flow_id"=>$appInfo['flow_id'],'ship'=>2));
    $dataHeader=array("工单号","应用","状态","耗时(分钟)","客户","电话","提交时间","完成时间","取消时间","终止时间","节点","节点状态","处理人");
    foreach($form as $val){
        if($val['type']!="photo" && $val['type']!="voice" ){
            $dataHeader[]=$val['label'];
        }
    }
    foreach($nodeList as $node){
        $dataHeader[]=$node['name'];
    }
    if(!is_dir(ATTACHMENT_ROOT."excel")){
        @mkdirs(ATTACHMENT_ROOT."excel");
    }
    file_put_contents($file, implode(",",$dataHeader). ","."\r\n");
}

//获取总共数据数量
$listLen=500;
$total = pdo_fetchcolumn("select count(*) from ".tablename("gd_pool")." as p where $where");
$totalPage=ceil($total/$listLen);
if($page>$totalPage){
    $time=date("Y-m-d",time());
    $msg['csv']=$appInfo['name']."($time).csv";
    $msg['page']=0;
    $msg['code']=1;
    $msg['table']=$csvName;
    echo json_encode($msg);
    exit;
}

$sql=" select p.gd_sn,p.create_time p_create_time,p.end_time p_end_time,p.recorder_status,p.name p_name,p.app_name p_app_name,p.mobile,p.node_name p_node_name,p.node_name_status as p_node_name_status,p.node_status p_name_status,p.staff_name,p.cancel_time p_cancel_time,p.back_time,p.pull_time ,r.*";
$sql .= " from ".tablename("gd_pool")." as p left join ".$appInfo['table']." as r on p.recorder_id=r.id where $where order by id desc limit ".($page-1)*$listLen ." , $listLen";
$recorderList = pdo_fetchall($sql);

foreach($recorderList as $key=>$recorder){
    $recorderList[$key]['std']=isset($status[$recorder['recorder_status']])?$status[$recorder['recorder_status']]:"";
    if($recorder['p_end_time']>0){
        $recorderList[$key]['p_use_time']=$this->format_date($recorder['end_time']-$recorder['create_time']);
    }else{
        $recorderList[$key]['p_use_time']=$this->format_date(time()-$recorder['create_time']);
    }
    $sourceStatus = array(0=>'待处理',1=>'处理中',2=>'已完成',3=>'已撤销',4=>'已转单',5=>'被退回',6=>'已终止','7'=>"待支付");
    $recorderList[$key]['success_time']="";
    $recorderList[$key]['cancel_time']="";
    $recorderList[$key]['abort_time']="";
    if($recorder['recorder_status']==2){
        $recorderList[$key]['success_time']=date("Y-m-d H:i:s",$recorder['end_time']);
    }else if($recorder['recorder_status']==3){
        $recorderList[$key]['cancel_time']=date("Y-m-d H:i:s",$recorder['end_time']);
    }else if($recorder['recorder_status']==6){
        $recorderList[$key]['abort_time']=date("Y-m-d H:i:s",$recorder['end_time']);
    }
}

foreach($recorderList as $recorder){
    $item=array();
    $item[]=$recorder['gd_sn']."\t";
    $item[]=$recorder['p_app_name']."\t";
    $item[]=$recorder['std']."\t";
    $item[]=$recorder['p_use_time']."\t";
    $item[]=$recorder['p_name']."\t";
    $item[]=$recorder['mobile']."\t";
    $item[]=date("Y-m-d H:i:s",$recorder['create_time'])."\t";
    $item[]=$recorder['success_time']."\t";
    $item[]=$recorder['cancel_time']."\t";
    $item[]=$recorder['abort_time']."\t";
    $item[]=$recorder['p_node_name']."\t";
    $item[]=$recorder['p_node_name_status']."\t";
    $item[]=$recorder['staff_name']."\t";
    foreach($form as $fm){
        if($fm['type']!="photo" && $fm['type']!="voice") {
            $item[] = isset($recorder[$fm['py']]) ? "\"".$recorder[$fm['py']]."\"\t" : "";
        }
    }
    foreach($nodeList as $node){
        $ifo="\"";
        $nodeCon="";
        //获取节点的配置信息
        $dealMsg = pdo_getall("gd_deal",array("recorder_id"=>$recorder['id'],'from'=>0,'app_id'=>$appInfo['id'],'node_id'=>$node['id']));
        $acMsg = $this->parseAcForm($dealMsg,0);
        foreach($acMsg as $key=>$val){
            if(isset($val[0]) && !in_array($key,array("labSigAc","labComAc","labVoiceAc","labPhotoAc"))){
                foreach($val[0] as $items){
                    $nodeCon .=$items['name'].':'.$items['val']."\t\n";
                }
            }
            if($key=='labComAc'){
                $info =$val[0];
                if(!empty($info['status_name'])){
                    $ifo .= "操作".':'.$info['status_name']."\t\n";
                }
                if(!empty($info['member_name'])){
                    $ifo .= "处理人".':'.$info['member_name']."\t\n";
                }
                if(!empty($info['create_time'])){
                    $ifo .= "处理时间".':'.$info['create_time']."\t\n";
                }
            }
        }
        $item[]=$ifo.$nodeCon."\"";
    }
    file_put_contents($file, implode(",",$item).","."\r\n",FILE_APPEND);
}
$msg['page']=$page+1;
$msg['total']=$totalPage;
$msg['code']=0;
$msg['table']=$csvName;
echo json_encode($msg);
exit();