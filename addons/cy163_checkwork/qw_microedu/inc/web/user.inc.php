<?php
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
include MODULE_ROOT."/inc/function/function.php";
$action = $_GPC['action'];
$uniacid = $_W['uniacid'];
$page = isset($_GPC['page']) ? $_GPC['page'] : 'index';
if($_W['isajax']){
    $caozuo = $_GPC['caozuo'];
    if($caozuo=='parentxq'){
        $id = $_GPC['id'];//家长id
        $parent_xq = pdo_fetch("SELECT a.*,b.fullname,b.mobile,b.address,b.gender FROM ".tablename("qw_microedu_parents")." as a left join ".tablename("qw_microedu_users")." as b on a.id=b.role_id  WHERE a.uniacid='$uniacid' and a.id='$id' and b.role_type='parents'");
        $stulist = pdo_fetchall("SELECT a.*,b.fullname as pfullname,b.mobile as pmobile FROM ".tablename("qw_microedu_children")." as a left join ".tablename("qw_microedu_users")." as b on a.parent_id=b.role_id WHERE a.uniacid='$uniacid' and role_type='parents' and a.parent_id='$id'");
        $con_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_users")." WHERE uniacid='$uniacid' AND role_id= ".$parent_xq['consultant_id']." AND role_type='consultants'");
        $parent_xq['con_fullname'] = $con_xq['fullname'];
        $parent_xq['con_mobile'] = $con_xq['mobile'];
        if($parent_xq){
            echo json_encode(array("error"=>1,"message"=>"成功",'parent_xq'=>$parent_xq,'stulist'=>$stulist));
            return false;
        }else{
            echo json_encode(array("error"=>-1,"message"=>"失败"));
            return false;
        }
    }
    else if($caozuo=='distri'){
        $pid = $_GPC['pid'];
        $con_id = $_GPC['con_id'];
        if(intval($con_id)<1){
            echo json_encode(array("error"=>-1,"message"=>"请选择顾问"));
            return false;
        }
        $parent_xq = pdo_fetch("SELECT * FROM ".tablename('qw_microedu_parents')." WHERE uniacid='$uniacid' and id='$pid'");
        if($parent_xq['consultant_id']){
            echo json_encode(array("error"=>-1,"message"=>"失败"));
            return false;
        }else{
            pdo_update("qw_microedu_parents",array("consultant_id"=>$con_id),array("id"=>$pid));
            echo json_encode(array("error"=>1,"message"=>"成功"));
            return false;
        }
    }
    else if ($caozuo=='timeline'){
        $child_id = $_GPC['sid'];
        $date = $_GPC['date'];
        $desc = $_GPC['desc'];
        $type = $_GPC['type'];
        $data = array(
            "timeline_date"=>$_GPC['date'],
            "timeline_description"=>$_GPC['desc'],
            "timeline_type"=>$_GPC['type'],
            "child_id"=>$child_id,
            "uniacid"=>$uniacid
        );
        $res = pdo_insert("qw_microedu_timeline",$data);
        $newid = pdo_insertid();
        if($res){
            echo json_encode(array("error"=>1,"message"=>"成功","time_linexq"=>$data,'newid'=>$newid));
            return false;
        }else{
            echo json_encode(array("error"=>-1,"message"=>"失败"));
            return false;
        }
    }

    else if($caozuo=='purchasecontracts'){
        //ajax购买合同操作
        $allid = $_GPC['allid'];
        $pid = intval($_GPC['pid']);
        $error = "";
        $current_arr = pdo_fetchall("SELECT contract_id FROM ".tablename("qw_microedu_parentscontracts")." WHERE uniacid='$uniacid' and parent_id='$pid'");
        //查找当前家长的顾问
        //当前家长的信息
        $parent_xq = pdo_fetch("SELECT a.*,b.fullname,b.mobile,b.address,b.gender FROM ".tablename("qw_microedu_parents")." as a left join ".tablename("qw_microedu_users")." as b on a.id=b.role_id  WHERE a.uniacid='$uniacid' and a.id='$pid' and b.role_type='parents'");
        $con_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_parents")." as a left join ".tablename("qw_microedu_consultants")." as b on a.consultant_id = b.id WHERE a.uniacid= '$uniacid' and a.id = '$pid'");
        $arr = array();
        foreach($current_arr as $v){
            $arr[] = $v['contract_id'];
        }
        foreach($allid as $key=>$vo){
            if(!in_array($vo,$arr)){
                //不存在就添加
                $contract_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_contracts")." WHERE uniacid='$uniacid' and id='$vo' ");
                $classhours = pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_contractsclasshours")." WHERE uniacid='$uniacid' and contract_id=".$contract_xq['id']);//合同课时
                if($contract_xq) {
                    $duration = $contract_xq['contract_duration'];
                    $data = array(
                        "uniacid" => $uniacid,
                        "parent_id" => $pid,
                        "contract_id"=>$contract_xq['id'],
                        "contract_price"=>$contract_xq['contract_price'],
                        "contract_startdate"=>date("Y-m-d",time()),
                        "contract_enddate"=>date("Y-m-d",strtotime("+ $duration days")),
                        "status"=>1
                    );
                    //插入家长合同表//
                    pdo_insert("qw_microedu_parentscontracts",$data);
                    $newpcid = pdo_insertid();
                    $inv_data = array(
                        "uniacid"=>$uniacid,
                        "parent_id"=>$pid,
                        "item_name"=>$contract_xq['contract_name'],
                        "item_price"=>$contract_xq['contract_price']
                    );
                    pdo_insert("qw_microedu_invoices",$inv_data);
                    $new_invid = pdo_insertid();
                    $comm_data = array(
                        "uniacid"=>$uniacid,
                        "consultant_id"=>$contract_xq['id'],
                        "invoice_id"=>$new_invid,
                        "amount"=>round($contract_xq['contract_price']*$con_xq['rate']*0.01,2),
                    );
                    pdo_insert("qw_microedu_commissions",$comm_data);
                    foreach ($classhours as $k=>$item) {
                        $rdata = array();
                        $rdata = array(
                            "uniacid" => $uniacid,
                            "parentscontract_id" => $newpcid,
                            "classhour_id"=>$item['classhour_id'],
                            "amount"=>$item['amount']
                        );
                        //插入家长剩余课时表
                        pdo_insert("qw_microedu_parentsremainingclasshours",$rdata);
                        unset($rdata);
                    }

                }
            }
        }
        //发送模板消息
        $templid = $set['purch_tplid'];
        $tplurl = "";
        $content = array(

            "first"=>array("value"=>"您已成功购买合同"),
            "keyword1"=>array("value"=>"后台管理操作"),
            "keyword2"=>array("value"=>"购买合同成功"),
            "value"=>array("value"=>"谢谢")
        );
        sendtpl($parent_xq['openid'],$tplurl,$templid,$content);
        echo json_encode(array("error"=>1,"message"=>"成功","contract_xq"=>$contract_xq,"con_xq"=>$con_xq));
        return false;
    }
    else if ($caozuo='upload-photo'){
        $desc = trim($_GPC['desc']);
        $pics = json_encode(explode(",",$_GPC['pics']));
        $schedule_id = $_GPC["xuanze"];
        $sid = $_GPC['sid'];
        $data = array(
            "uniacid"=>$uniacid,
            "child_id"=>$sid,
            "description"=>$desc,
            "pics"=>$pics,
            "schedule_id"=>$schedule_id,
        );
       $res =  pdo_insert("qw_microedu_projects",$data);

        $parentid = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_children")." WHERE uniacid='$uniacid' and id='$sid'");
        $parent_xq = pdo_fetch("SELECT a.*,b.fullname,b.mobile,b.address,b.gender FROM ".tablename("qw_microedu_parents")." as a left join ".tablename("qw_microedu_users")." as b on a.id=b.role_id  WHERE a.uniacid='$uniacid' and a.id= ".$parentid['parent_id']."  and b.role_type='parents'");
        if($res){
            //查找当前家长的信息,然后发布模板消息

            //发送模板消息
            $templid = $set['purch_tplid'];
            $tplurl = "";
            $content = array(

                "first"=>array("value"=>"您已成功上传作品"),
                "keyword1"=>array("value"=>"后台管理操作"),
                "keyword2"=>array("value"=>"上传作品成功"),
                "remark"=>array("value"=>"谢谢")
            );
            sendtpl($parent_xq['openid'],$tplurl,$templid,$content);
            echo json_encode(array("error"=>1,"message"=>"成功"));
            return false;
        }else{
            echo json_encode(array("error"=>-1,"message"=>"失败"));
            return false;
        }
    }

}
if ($page == 'index') {
    $mobile = trim($_GPC['mobile']);
    $fullname = trim($_GPC['xm']);
    $conn="";
    if($mobile){
        $conn.=" AND b.mobile LIKE '%$mobile%' ";
    }
    if($fullname){
        $conn .=" AND b.fullname  LIKE '%$fullname%' ";
    }
    $parentlist = pdo_fetchall("SELECT a.*,b.fullname,b.mobile,b.address,b.gender FROM ".tablename("qw_microedu_parents")." as a  left join ".tablename("qw_microedu_users")." as b on a.id=b.role_id  WHERE a.uniacid='$uniacid' and b.role_type='parents' ".$conn."    group by a.id");
    foreach($parentlist as $key=>$v){
        if($v['consultant_id']){
            $con_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_users")." WHERE uniacid='$uniacid' AND role_id= ".$v['consultant_id']." AND role_type='consultants'");
            $parentlist[$key]['con_id'] = $con_xq['id'];
            $parentlist[$key]['con_fullname'] = $con_xq['fullname'];
        }
    }
    include $this->template('web/user/index');
} elseif ($page == 'followup') {
    //跟进管理
    $mobile = trim($_GPC['mobile']);
    $fullname = trim($_GPC['xm']);
    $conn="";
    if($mobile){
        $conn.=" AND b.mobile LIKE '%$mobile%' ";
    }
    if($fullname){
        $conn .=" AND b.fullname  LIKE '%$fullname%' ";
    }
    $parentlist = pdo_fetchall("SELECT a.*,b.fullname,b.mobile,b.address,b.gender FROM ".tablename("qw_microedu_parents")." as a  left join ".tablename("qw_microedu_users")." as b on a.id=b.role_id  WHERE a.uniacid='$uniacid' and b.role_type='parents' ".$conn." group by a.id");
    foreach($parentlist as $key=>$v){
        if($v['consultant_id']){
            $con_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_users")." WHERE uniacid='$uniacid' AND role_id= ".$v['consultant_id']." AND role_type='consultants'");
            $parentlist[$key]['count_child'] = count(pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_children")." WHERE uniacid='$uniacid' and parent_id= ".$v['id']));
            $parentlist[$key]['count_contracts'] = count(pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_parentscontracts")." WHERE uniacid='$uniacid' and parent_id= ".$v['id']." and status=1"));
            $parentlist[$key]['con_id'] = $con_xq['id'];
            $parentlist[$key]['con_fullname'] = $con_xq['fullname'];
        }
        //剩余课时
        $remainingsclasshours = pdo_fetchall("SELECT a.id,a.parent_id,a.contract_id,c.contract_price,c.contract_name,c.contract_description, SUM(b.amount) as amount_hours FROM ".tablename("qw_microedu_parentscontracts")." as a left join ".tablename("qw_microedu_parentsremainingclasshours")." as b on a.id= b.parentscontract_id left join ".tablename("qw_microedu_contracts")." as c on a.contract_id = c.id WHERE a.uniacid='$uniacid' and a.parent_id=".$v['id']." group by a.contract_id");
        $parentlist[$key]['remain'] = $remainingsclasshours;
    }
    //p($parentlist);
    $conlist = pdo_fetchall("SELECT a.*,b.fullname FROM ".tablename("qw_microedu_consultants")." as a  left join ".tablename("qw_microedu_users")." as b on a.id=b.role_id  WHERE  a.uniacid='$uniacid' and b.role_type='consultants' group by a.id");
    include $this->template('web/user/followup');
}elseif ($page == 'buy') {
    //进入购买合同的页面
    $pid = $_GPC['pid'];
    $contract_list = pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_contracts")."  WHERE uniacid='$uniacid'");
    $current_arr = pdo_fetchall("SELECT contract_id FROM ".tablename("qw_microedu_parentscontracts")." WHERE uniacid='$uniacid' and parent_id='$pid'");
    $arr = array();
    foreach($current_arr as $v){
        $arr[] = $v['contract_id'];
    }
    foreach ($contract_list as $key=>$vo){
        if(in_array($vo['id'],$arr)){
            $contract_list[$key]['status']=1;
        }
    }
    include $this->template('web/user/buy');
}elseif ($page == 'student') {
    $mobile = trim($_GPC['mobile']);
    $fullname = trim($_GPC['xm']);
    $conn="";
    if($mobile){
        $conn.=" AND b.mobile LIKE '%$mobile%' ";
    }
    if($fullname){
        $conn .=" AND a.fullname  LIKE '%$fullname%' ";
    }
    $stulist = pdo_fetchall("SELECT a.*,b.fullname as pfullname,b.mobile as pmobile FROM ".tablename("qw_microedu_children")." as a left join ".tablename("qw_microedu_users")." as b on a.parent_id=b.role_id WHERE a.uniacid='$uniacid' and role_type='parents' ".$conn);
    include $this->template('web/user/student');
} elseif ($page == 'recorder') {
        $idd = $_GPC['idd'];
        $timeline_list = pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_timeline")." WHERE uniacid='$uniacid' and child_id='$idd'");
    include $this->template('web/user/recorder');
}elseif ($page == 'upload') {
    //上传产品页面
    if (empty($starttime) || empty($endtime)) {
        $starttime = strtotime('-1 month');
        $endtime = TIMESTAMP;
    }
    if (!empty($_GPC['time'])) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']) + 86399;
        $condition .= " AND o.createtime >= :starttime AND o.createtime <= :endtime ";
        $paras[':starttime'] = $starttime;
        $paras[':endtime'] = $endtime;
    }
    $sid = $_GPC['sid'];
    $schedulist = pdo_fetchall("SELECT a.*,b.class_name FROM ".tablename("qw_microedu_schedules")." as a left join ".tablename("qw_microedu_contractsclasses")." as b on a.contractclass_id=b.id left join ".tablename("qw_microedu_attendance")." as c on a.id = c.schedule_id WHERE a.uniacid='$uniacid' and c.status in (1,2,3) and c.child_id='$sid' ");
    include $this->template('web/user/upload');
}elseif ($page == 'product') {
    $sid = $_GPC['sid'];
    $prolist = pdo_fetchall("SELECT a.*,b.timeslot,c.class_name FROM ".tablename("qw_microedu_projects")." as a left join ".tablename("qw_microedu_schedules")." as b on a.schedule_id=b.id left join ".tablename("qw_microedu_contractsclasses")." as c on b.contractclass_id = c.id WHERE a.uniacid='$uniacid' and a.child_id='$sid'");
    //p($prolist);
    include $this->template('web/user/product');
}elseif ($page == 'create') {
    if(checksubmit('submit')) {
        $id = $_GPC['id']; //修改时的id
        $fullname = trim($_GPC['fullname']);
        $mobile = trim($_GPC['mobile']);
        $gender = trim($_GPC['gender']);
        $address = trim($_GPC['address']);
        if(!checkmobile($mobile)){
            message("请输入正确的手机号码",$this->createWeburl('user',array('page'=>'create')),"error");
            die;
        }
        if($id){
            $editdata = array(
                "fullname"=>$fullname,
                "gender"=>$gender,
                "address"=>$address,
            );
            $res = pdo_update("qw_microedu_users",$editdata,array("role_id"=>$id,"role_type"=>"parents","uniacid"=>$uniacid));
            if($res){
                message("成功修改",$this->createWeburl("user",array('page'=>'index')),"success");
            }else{
                message("失败",$this->createWeburl("user",array('page'=>'index')),"error");
            }
        }
        //插入数据
        $cdata = array(
            "uniacid"=>$uniacid,
        );
        pdo_insert("qw_microedu_parents",$cdata);
        $cnewid = pdo_insertid();
        $udata = array(
            "fullname"=>$fullname,
            "gender"=>$gender,
            "mobile"=>$mobile,
            "address"=>$address,
            "role_id"=>$cnewid,
            "role_type"=>'parents',
            "uniacid"=>$uniacid
        );
        $r = pdo_insert("qw_microedu_users",$udata);
        if($r){
            message("成功添加",$this->createWeburl("user",array('page'=>'create')),"success");
        }else{
            message("失败,请重试",$this->createWeburl("user",array('page'=>'create')),"success");
        }
    }
    $idd = $_GPC['idd']; //详细情况的id
    if($idd){
        $parent_xq = pdo_fetch("SELECT a.*,b.fullname,b.mobile,b.address,b.gender FROM ".tablename("qw_microedu_parents")." as a left join ".tablename("qw_microedu_users")." as b on a.id=b.role_id  WHERE a.uniacid='$uniacid' and a.id='$idd' and b.role_type='parents'");
        if(empty($parent_xq)){
            message("不存在此顾问",'',"error");
            die;
        }
    }
    include $this->template('web/user/create');
}elseif ($page == 'add') {
    $parent_id = $_GPC['pid'];
    if(checksubmit('submit')) {
        $id = $_GPC['id']; //修改时的id
        $fullname = trim($_GPC['fullname']);
        if(!$fullname){
            if($id){
                message("姓名不得为空",$this->createWeburl('user',array('page'=>'add','idd'=>$id)),'error');
            }else{
                message("姓名不得为空",$this->createWeburl('user',array('page'=>'create')),'error');
            }
        }
        $gender = trim($_GPC['gender']);
        $age = intval($_GPC['age']);
        if($id){
            $editdata = array(
                "fullname"=>$fullname,
                "gender"=>$gender,
            );
            $res = pdo_update("qw_microedu_children",$editdata,array("id"=>$id,"uniacid"=>$uniacid));
            if($res){
                message("成功修改",$this->createWeburl("user",array('page'=>'index')),"success");
            }else{
                message("失败",$this->createWeburl("user",array('page'=>'index')),"error");
            }
        }
        $udata = array(
            "fullname"=>$fullname,
            "gender"=>$gender,
            "age"=>$age,
            "uniacid"=>$uniacid,
            "parent_id"=>$parent_id,
            "created_time"=>date('Y-m-d H:i:s',time())
        );
        $r = pdo_insert("qw_microedu_children",$udata);
        if($r){
            message("成功添加",$this->createWeburl("user",array('page'=>'index')),"success");
        }else{
            message("失败,请重试",$this->createWeburl("user",array('page'=>'index')),"success");
        }
    }
    $idd = $_GPC['idd']; //详细情况的id
    if($idd){
        $stu_xq = pdo_fetch("SELECT a.*,b.fullname as pfullname,b.mobile as pmobile FROM ".tablename("qw_microedu_children")." as a left join ".tablename("qw_microedu_users")." as b on a.parent_id=b.role_id WHERE a.uniacid='$uniacid' and role_type='parents' and a.id='$idd'");
        if(empty($stu_xq)){
            message("不存在此学生",'',"error");
            die;
        }
    }
    include $this->template('web/user/add');
}else if($page=='del'){
    $op = $_GPC['op'];
    if($op=='parent'){
            $parent_id = $_GPC['pid'];
            //查询下面是否有子女,如果有提示不可以删除
            $children_count= count(pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_children")." WHERE uniacid ='$uniacid' and parent_id = '$parent_id' "));
            if($children_count>0){
                message("下面还有子女,请删除后再删除本家长",$this->createWeburl("user",array("page"=>"index"),"success"));
                die;
            }
        //先删除家长表,然后删除users表数据
            pdo_delete("qw_microedu_parents",array("id"=>$parent_id,"uniacid"=>$uniacid));
            pdo_delete("qw_microedu_users",array("role_type"=>"parents","role_id"=>$parent_id,"uniacid"=>$uniacid));
            message("成功删除",$this->createWeburl("user",array('page'=>'index')),"success");
    }else if($op=='student'){
        $stu_id = $_GPC['stu_id'];
        $res = pdo_delete("qw_microedu_children",array("id"=>$stu_id,"uniacid"=>$uniacid));
        if($res){
            message("成功删除",$this->createWeburl("user",array('page'=>'student')),"success");
        }else{
            message("删除失败请重试",$this->createWeburl("user",array('page'=>'student')),"error");
        }
    }
}
//funciton
function classhoursamount($contract_id){
    global $_W,$_GPC;
    $uniacid = $_W['uniacid'];
    $contractclass_xq = pdo_fetchall("SELECT *,SUM(amount) as sumamount FROM ".tablename("qw_microedu_contractsclasshours")." WHERE uniacid='$uniacid' and contract_id='$contract_id'");
    return $contractclass_xq['sumamount'];
}