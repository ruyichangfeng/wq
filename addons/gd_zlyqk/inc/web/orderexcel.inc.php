<?php
//倒出数据,按应用导出
global $_GPC,$_W;
$where .=" uniacid={$_W['uniacid']} ";
if(!isset($_GPC['status'])){
    $_GPC['status']=-1;
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
if(!empty($_GPC['app_id'])){
    $where .= " and app_id={$_GPC['app_id']} ";
}
if(!empty($_GPC['order_sn'])){
    $where .=" and order_sn like '%{$_GPC['order_sn']}%' ";
}
if($_GPC['status']!=-1){
    $where .= " and pay_status={$_GPC['status']} ";
}

$page =empty($_GPC['page'])?1:intval($_GPC['page']);
$csvName = empty($_GPC['table'])?rand(10000,99999).".csv":$_GPC['table'];
$file=ATTACHMENT_ROOT."excel/".$csvName;

$listLen=500;
$total = pdo_fetchcolumn("select count(*) from ".tablename("gd_order")." where $where");
$totalPage=ceil($total/$listLen);

if($page==1) {
    $dataHeader = array("单号", "应用", "用户", "金额", "状态", "下单时间", "支付时间");

    if (!is_dir(ATTACHMENT_ROOT . "excel")) {
        @mkdirs(ATTACHMENT_ROOT . "excel");
    }
    file_put_contents($file, implode(",", $dataHeader) . "," . "\r\n");
}

if($page>$totalPage){
    $time=date("Y-m-d",time());
    $msg['csv']="支付列表({$_GPC['start']}到{$_GPC['end']}).csv";
    $msg['page']=0;
    $msg['code']=1;
    $msg['table']=$csvName;
    echo json_encode($msg);
    exit;
}

$sql = "select * from ".tablename("gd_order"). " where ".$where." order by id desc limit ".($page-1)*$listLen ." ,$listLen";
$dataList =pdo_fetchall($sql);

$dataList = $this->afterOrderList($dataList);
$dataList=$dataList['dataList'];
$data="";
foreach($dataList as $recorder){
    $item=array();
    $item[]=$recorder['order_sn']."\t";
    $item[]=$recorder['app_name']."\t";
    $item[]=$recorder['member_name']."\t";
    $item[]=$recorder['money']."\t";
    $item[]=($recorder['pay_status']==0)?"未支付":"已支付"."\t";
    $item[]=date("Y-m-d H:i:s",$recorder['create_time'])."\t";
    $item[]=(($recorder['pay_time']>0)?date("Y-m-d H:i:s",$recorder['pay_time']):"")."\t";
    $data .= implode(",",$item).","."\r\n";
}
file_put_contents($file,$data,FILE_APPEND);

$msg['page']=$page+1;
$msg['total']=$totalPage;
$msg['code']=0;
$msg['table']=$csvName;
echo json_encode($msg);
exit();