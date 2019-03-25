<?php
//倒出数据,综合导出

global $_W,$_GPC;

$where = " uniacid={$_W['uniacid']} ";
if($_GPC['name']){
    $where .= " and name like '%{$_GPC['name']}%' ";
}
if($_GPC['mobile']){
    $where .= " and mobile like '%{$_GPC['mobile']}%' ";
}
if($_GPC['gd_sn']){
    $where .= " and gd_sn like '%{$_GPC['gd_sn']}%' ";
}
if($_GPC['app']){
    $where .= " and app_id={$_GPC['app']} ";
}
if($_GPC['category']){
    $where .= " and category={$_GPC['category']} ";
}
if(!isset($_GPC['start'])){
    $startTime=strtotime(date("Y-m-d",time()));
    $start = strtotime("-1 year",$startTime);
    $end = strtotime("+1 day",$startTime);
}else{
    $start = strtotime($_GPC['start']);
    $end = strtotime($_GPC['end']);
}
$_GPC['start']=date("Y-m-d ",$start);
$_GPC['end']=date("Y-m-d ",$end);
$where .= " and create_time>$start and create_time<$end ";

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

$page =empty($_GPC['page'])?1:intval($_GPC['page']);
$csvName = empty($_GPC['table'])?rand(10000,99999).".csv":$_GPC['table'];
$file=ATTACHMENT_ROOT."excel/".$csvName;

$listLen=500;
$total = pdo_fetchcolumn("select count(*) from ".tablename("gd_pool")." where $where");
$totalPage=ceil($total/$listLen);

if($page==1) {
    $dataHeader = array("工单号", "应用", "状态", "耗时(分钟)", "客户", "电话", "提交时间", "节点", "节点状态", "操作状态", "处理时间", "处理人", "完成时间", "取消时间", "退回时间", "转单时间");

    if (!is_dir(ATTACHMENT_ROOT . "excel")) {
        @mkdirs(ATTACHMENT_ROOT . "excel");
    }
    file_put_contents($file, implode(",", $dataHeader) . "," . "\r\n");
}

if($page>$totalPage){
    $time=date("Y-m-d",time());
    $msg['csv']="综合导出($time).csv";
    $msg['page']=0;
    $msg['code']=1;
    $msg['table']=$csvName;
    echo json_encode($msg);
    exit;
}

$sql = "select * from ".tablename("gd_pool"). " where ".$where." order by id desc limit ".($page-1)*$listLen ." ,$listLen";
$dataList =pdo_fetchall($sql);

$dataList = $this->afterPoolList($dataList);
$dataList=$dataList['dataList'];
$data="";
foreach($dataList as $recorder){
    $item=array();
    $item[]=$recorder['gd_sn']."\t";
    $item[]=$recorder['app_name']."\t";
    $item[]=$recorder['recorder_status']."\t";
    if($recorder['end_time']>0){
        $item[]=$this->format_date($recorder['end_time']-$recorder['create_time'])."\t";
    }else{
        $item[]=$this->format_date(time()-$recorder['create_time'])."\t";
    }
    $item[]=$recorder['name']."\t";
    $item[]=$recorder['mobile']."\t";
    $item[]=date("Y-m-d H:i:s",$recorder['create_time'])."\t";
    $item[]=$recorder['node_name']."\t";
    $item[]=$recorder['node_name_status']."\t";
    $item[]=$recorder['node_status']."\t";
    $item[]=(($recorder['mark_time']>0) ? date("Y-m-d H:i:s",$recorder['mark_time']) : "")."\t";
    $item[]=$recorder['staff_name']."\t";
    $item[]=(($recorder['source_status']==2)?date("Y-m-d H:i:s",$recorder['end_time']):"")."\t";
    $item[]=(($recorder['cancel_time']>0)?date("Y-m-d H:i:s",$recorder['cancel_time']):"")."\t";
    $item[]=(($recorder['back_time']>0)?date("Y-m-d H:i:s",$recorder['back_time']):"")."\t";
    $item[]=(($recorder['pull_time']>0)?date("Y-m-d H:i:s",$recorder['pull_time']):"")."\t";
    $data .= implode(",",$item).","."\r\n";
}
file_put_contents($file,$data,FILE_APPEND);

$msg['page']=$page+1;
$msg['total']=$totalPage;
$msg['code']=0;
$msg['table']=$csvName;
echo json_encode($msg);
exit();