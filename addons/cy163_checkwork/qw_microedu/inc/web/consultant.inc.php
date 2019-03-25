<?php
defined('IN_IA') or exit('Access Denied');
include MODULE_ROOT."/inc/function/function.php";
global $_W, $_GPC;
session_start();
$action = $_GPC['action'];
$uniacid = $_W['uniacid'];
$page = isset($_GPC['page']) ? $_GPC['page'] : 'index';
//if ($action == 'index') {
//
//} elseif ($action == 'store') {
//
//} elseif ($action == 'update') {
//
//} elseif ($action == 'destroy') {
//
//}
//ajax修改
if($_W['isajax']){
    $caozuo = $_GPC['caozuo'];
    if($caozuo=='team'){
        $id = $_GPC['id'];
        $group = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_consultantgroups")." WHERE uniacid='$uniacid' and id='$id'");
        $conlist = pdo_fetchall("SELECT a.*,b.fullname FROM ".tablename("qw_microedu_consultants")." as a  left join ".tablename("qw_microedu_users")." as b on a.id=b.role_id  WHERE  a.uniacid='$uniacid' and b.role_type='consultants' group by a.id");
        foreach ($conlist as $key=>$v){
            if($v['consultantgroup_id']){
                //if($group['id']==$v['consultantgroup_id']){
                    unset($conlist[$key]);
               // }
            }
        }
        $group_list = pdo_fetchall("SELECT a.*,b.fullname FROM ".tablename("qw_microedu_consultants")." as a  left join ".tablename("qw_microedu_users")." as b on a.id=b.role_id  WHERE a.uniacid='$uniacid' and b.role_type='consultants' and a.consultantgroup_id='$id' group by a.id");
        echo json_encode(array("error"=>1,"message"=>"成功","group"=>$group,"conlist"=>$conlist,"group_list"=>$group_list));
        return false;
    }
    else if($caozuo=='addgw'){
        $xzid = intval($_GPC['xzid']);
        $idd = intval($_GPC['idd']);  //组的id
        $res = pdo_update("qw_microedu_consultants",array("consultantgroup_id"=>$idd),array("id"=>$xzid));
        $con_xq = pdo_fetch("SELECT a.*,b.fullname FROM ".tablename("qw_microedu_consultants")." as a left join ".tablename("qw_microedu_users")." as b on a.id = b.role_id  WHERE a.uniacid='$uniacid' and a.id='$xzid' and b.role_type='consultants'");
        if($res){
            echo json_encode(array("error"=>1,"message"=>"成功","con_xq"=>$con_xq));
            return false;
        }else{
            echo json_encode(array("error"=>-1,"message"=>"失败"));
            return false;
        }
    }
    else if($caozuo=='uprate'){
        $idd = intval($_GPC['idd']);//组的id
        $oorate = intval($_GPC['oorate']);
        $group = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_consultantgroups")." WHERE uniacid='$uniacid' and id='$idd'");
        if($oorate<1){
            echo json_encode(array("error"=>-1,"message"=>"比率不能小于1"));
            return false;
        }
        //批量修改rate
       $res =  pdo_query("update ims_qw_microedu_consultants set rate='$oorate' where uniacid='$uniacid' and consultantgroup_id='$idd' and id !=".$group['leader_id']);
        if($res){
            echo json_encode(array("error"=>1,"message"=>"成功修改比率"));
            return false;
        }else{
            echo json_encode(array("error"=>-1,"message"=>"失败"));
            return false;
        }
    }else if ($caozuo=='delgw'){
        $idd = intval($_GPC['idd']);//组的id
        $delid = intval($_GPC['delid']);
        $group = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_consultantgroups")." WHERE uniacid='$uniacid' and id='$idd'");
        if($delid==$group['leader_id']){
            echo json_encode(array("error"=>-1,"message"=>"不能删除组长"));
            return false;
        }
        $con_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_consultants")." WHERE uniacid='$uniacid' and id='$delid'");
//        if($con_xq['consultantgroup_id']!=$idd){
//            echo json_encode(array("error"=>-1,"message"=>"您不是本组成员"));
        // return false;
//        }
        $res = pdo_query("update `ims_qw_microedu_consultants` set `consultantgroup_id`=null , `rate`=0 where `id`='$delid'");
        if($res){
            echo json_encode(array("error"=>1,"message"=>"成功删除"));
            return false;
        }else{
            echo json_encode(array("error"=>-1,"message"=>"失败"));
            return false;
        }
    }else if($caozuo=='delgroup'){
        $delgroupid = intval($_GPC['delgroupid']);
        $conlist = pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_consultants")." WHERE uniacid='$uniacid' and consultantgroup_id='$delgroupid'");
        $count = intval(count($conlist));
        if($count>1){
            echo json_encode(array("error"=>-1,"message"=>"请删除组员后再删除本组"));
            return false;
        }else{
            //删除组,先把组长删除,再删除组
            $group_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_consultantgroups")." WHERE uniacid='$uniacid' and id='$delgroupid'");
            pdo_delete("qw_microedu_consultants",array("id"=>$group_xq['leader_id'],"uniacid"=>$uniacid));
            pdo_delete("qw_microedu_users",array("uniacid"=>$uniacid,"role_id"=>$group_xq['leader_id'],"role_type"=>"consultants"));
            pdo_delete("qw_microedu_consultantgroups",array("uniacid"=>$uniacid,"id"=>$delgroupid));
            echo json_encode(array("error"=>1,"message"=>"成功删除"));  
            return false;
        }
    }//
    else if($caozuo=='editcash'){
        $cid = $_GPC['cid'];
        $rate = $_GPC['cash'];
        //检测是否组长
        $group = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_consultantgroups")." WHERE uniacid='$uniacid' and leader_id='$cid'");
        if($group){
            pdo_update("qw_microedu_consultantgroups",array("leader_rate"=>$rate),array("uniacid"=>$uniacid,"leader_id"=>$cid));
            pdo_update("qw_microedu_consultants",array("rate"=>$rate),array("uniacid"=>$uniacid,"id"=>$cid));
            echo json_encode(array("error"=>1,"message"=>"成功修改"));
            return false;
        }else{
            pdo_update("qw_microedu_consultants",array("rate"=>$rate),array("uniacid"=>$uniacid,"id"=>$cid));
            echo json_encode(array("error"=>-1,"message"=>"成功修改"));
            return false;
        }
    }
}
//顾问列表
if ($page == 'index') {
    $sex = trim($_GPC['sex']);
    $mobile = trim($_GPC['mobile']);
    $fullname = trim($_GPC['xm']);
    $conn="";
    if($sex||$sex==0){
        $conn.=" AND b.gender = '$sex' ";
    }
    if($mobile){
        $conn.=" AND b.mobile LIKE '%$mobile%' ";
    }
    if($fullname){
        $conn .=" AND b.fullname  LIKE '%$fullname%' ";
    }
    $conlist = pdo_fetchall("SELECT a.*,b.fullname,b.mobile,b.address,b.gender,b.ic,b.dob FROM ".tablename("qw_microedu_consultants")." AS a  LEFT JOIN  ".tablename("qw_microedu_users")." AS b ON a.id=b.role_id  WHERE a.uniacid='$uniacid' AND b.role_type='consultants' ".$conn." group by a.id");
    include $this->template('web/consultant/index');
    //顾问修改
} elseif ($page == 'edit') {
    if(checksubmit('submit')) {
        $id = $_GPC['id']; //修改时的id
        $fullname = trim($_GPC['fullname']);
        $mobile = trim($_GPC['mobile']);
        $gender = trim($_GPC['gender']);
        $dob = trim($_GPC['dob']);
        $address = trim($_GPC['address']);
        $ic = trim($_GPC['ic']);
        if(!checkmobile($mobile)){
            message("请输入正确的手机号码",$this->createWeburl('consultant',array('page'=>'edit')),"error");
            die;
        }
        if($id){
            $editdata = array(
                "fullname"=>$fullname,
                "gender"=>$gender,
                "dob"=>strtotime($dob),
                "address"=>$address,
                "ic"=>$ic,
            );
            $res = pdo_update("qw_microedu_users",$editdata,array("role_id"=>$id,"role_type"=>"consultants","uniacid"=>$uniacid));
            if($res){
                message("成功修改",$this->createWeburl("consultant",array('page'=>'index')),"success");
            }else{
                message("失败",$this->createWeburl("consultant",array('page'=>'index')),"error");
            }
        }
        //插入数据
        $cdata = array(
            "uniacid"=>$uniacid,
        );
        pdo_insert("qw_microedu_consultants",$cdata);
        $cnewid = pdo_insertid();
        $udata = array(
            "fullname"=>$fullname,
            "gender"=>$gender,
            "dob"=>strtotime($dob),
            "mobile"=>$mobile,
            "address"=>$address,
            "ic"=>$ic,
            "role_id"=>$cnewid,
            "role_type"=>'consultants',
            "uniacid"=>$uniacid
        );
        $r = pdo_insert("qw_microedu_users",$udata);
        if($r){
            message("成功添加",$this->createWeburl("consultant",array('page'=>'edit')),"success");
        }else{
            message("失败,请重试",$this->createWeburl("consultant",array('page'=>'edit')),"success");
        }
    }
    $idd = $_GPC['idd']; //详细情况的id
    if($idd){
        $consultant_xq = pdo_fetch("SELECT a.*,b.fullname,b.mobile,b.address,b.gender,b.ic,b.dob FROM ".tablename("qw_microedu_consultants")." as a left join ".tablename("qw_microedu_users")." as b on a.id=b.role_id  WHERE a.uniacid='$uniacid' and a.id='$idd' and b.role_type='consultants'");
        if(empty($consultant_xq)){
            message("不存在此顾问",'',"error");
            die;
        }
    }
    include $this->template('web/consultant/edit');
}
//顾问组管理
elseif ($page == 'team') {
    $teamname = trim($_GPC['teamname']);
    $teamcap = trim($_GPC['teamcap']);
    $con = "";
    if($teamname){
        $con.=" AND a.group_name LIKE '%$teamname%' ";
    }
    if($teamcap){
        $con .=" AND c.fullname LIKE '%$teamcap%'";
    }
    $glist = pdo_fetchall("SELECT a.*,b.id as conid,c.fullname FROM ".tablename("qw_microedu_consultantgroups")." as a left join ".tablename("qw_microedu_consultants")." as b on a.leader_id = b.id left join ".tablename("qw_microedu_users")." as c on b.id=c.role_id where c.role_type='consultants' ".$con." group by b.id");
   // p($glist);
    include $this->template('web/consultant/team');
    //顾问组修改
}elseif ($page == 'team-edit') {
    if(checksubmit('submit')){
        $id = $_GPC['id']; //修改时的id
        $group_name = trim($_GPC['group_name']);
        $leader_id = $_GPC['leader_id'];
        $leader_rate = intval($_GPC['leader_rate']);
        $comments = trim($_GPC['comments']);
        if(empty($group_name)){
            message("请输入顾问组名","","error");
            die;
        }
        $con_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_consultants")." WHERE uniacid='$uniacid' and id='$leader_id'" );
        if(!$con_xq){
            message("不存在此顾问","","error");
            die;
        }
        $group_data = array(
            "group_name"=>$group_name,
            "leader_id"=>$leader_id,
            "leader_rate"=>$leader_rate,
            "comments"=>$comments,
            "uniacid"=>$uniacid
        );
        //检测此id是否存在,并修改
        $group_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_consultantgroups")." WHERE uniacid='$uniacid' and id='$id'");
        if($id){
            if (!$group_xq) {
                message("不存在此顾问组", '', "error");
                die;
            }
            //执行修改顾问组的详细内容
            if($group_xq['leader_id']!=$leader_id){
                //修改当前组长的id,
               // pdo_update("qw_microedu_consultants",array("consultantgroup_id"=>'\n',"rate"=>0),array("id"=>$group_xq['leader_id']));
                pdo_query("update `ims_qw_microedu_consultants` set `consultantgroup_id`=null , `rate`=0 where `id`=".$group_xq['leader_id']);
                //修改成新的组长的内容
                pdo_update("qw_microedu_consultants",array("consultantgroup_id"=>$id,"rate"=>$leader_rate),array("id"=>$leader_id));
            }
                unset($group_data['uniacid']);
                $rr =    pdo_update("qw_microedu_consultantgroups",$group_data,array("uniacid"=>$uniacid,"id"=>$id));
            if($rr){
                message("成功修改",$this->createWeburl("consultant",array('page'=>'team')),"success");
            }else{
                message("失败,请重试",$this->createWeburl("consultant",array('page'=>'team-edit')),"error");
            }
        }
        //更新id内容结束
        $r = pdo_insert("qw_microedu_consultantgroups",$group_data);
        $gnewid = pdo_insertid();
            if($r){
                pdo_update("qw_microedu_consultants",array("consultantgroup_id"=>$gnewid,"rate"=>$leader_rate),array("id"=>$leader_id));
                message("成功添加",$this->createWeburl("consultant",array('page'=>'team')),"success");
            }else{
                message("失败,请重试",$this->createWeburl("consultant",array('page'=>'team-edit')),"error");
            }
        }
        $idd = $_GPC['idd'];
        $conlist = pdo_fetchall("SELECT a.*,b.fullname FROM ".tablename("qw_microedu_consultants")." as a  left join ".tablename("qw_microedu_users")." as b on a.id=b.role_id  WHERE  a.uniacid='$uniacid' and b.role_type='consultants' group by a.id");
        if($idd){
            $group = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_consultantgroups")." WHERE uniacid='$uniacid' and id='$idd'");
            if(empty($group)){
                message("不存在该顾问组",'',"error");
                die;
            }
        }
        foreach ($conlist as $key=>$v){
            if($v['consultantgroup_id']){
                if($group['id']!=$v['consultantgroup_id']){
                    unset($conlist[$key]);
                }
            }
        }
        include $this->template('web/consultant/team-edit');
    //
}
//删除操作
else if ($page=='del'){
    $op =$_GPC['op'];
    if($op=='consultant'){
        //删除组员
        $con_id = $_GPC['con_id'];
        $group_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_consultantgroups")." WHERE uniacid='$uniacid' and leader_id='$con_id'");
        if($group_xq){
            message("此人为组长,请到顾问组里删除",$this->createWeburl('consultant',array('page'=>'index')),"error");
            die;
        }
        pdo_delete("qw_microedu_consultants",array("id"=>$con_id,"uniacid"=>$uniacid));
        pdo_delete("qw_microedu_users",array("uniacid"=>$uniacid,"role_id"=>$con_id,"role_type"=>"consultants"));
        message("删除成功",$this->createWeburl('consultant',array('page'=>'index')),"success");

    }else if($op =='group'){
        //删除组
        $group_id = $_GPC['group_id'];
        $conlist = pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_consultants")." WHERE uniacid='$uniacid' and consultantgroup_id='$group_id'");
        $count = intval(count($conlist));
        if($count>0){
            message("此组下面有成员",$this->createWeburl('consultant',array('page'=>'team')),"error");
            die;
        }
        //删除组,先把组长删除,再删除组
        $group_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_consultantgroups")." WHERE uniacid='$uniacid' and id='$group_id'");
        pdo_delete("qw_microedu_consultants",array("id"=>$group_xq['leader_id'],"uniacid"=>$uniacid));
        pdo_delete("qw_microedu_users",array("uniacid"=>$uniacid,"role_id"=>$group_xq['leader_id'],"role_type"=>"consultants"));
        pdo_delete("qw_microedu_consultantgroups",array("uniacid"=>$uniacid,"id"=>$group_id));
    }
}
