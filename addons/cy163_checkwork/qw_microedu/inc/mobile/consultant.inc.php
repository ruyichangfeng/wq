<?php
/**
 * Created by PhpStorm.
 * User: sks
 * Date: 16/9/1
 * Time: 上午10:17
 */
    defined("IN_IA") or exit("Access Denied");
    session_start();
    //include MODULE_ROOT."/inc/mobile/init.php";
    include MODULE_ROOT."/inc/common.php";
    include MODULE_ROOT."/inc/function/function.php";
global $_W, $_GPC;
    load()->model("mc");
    $userinfo =mc_oauth_userinfo();
$settings = pdo_fetchcolumn("SELECT settings FROM".tablename('uni_account_modules')."WHERE uniacid='$uniacid' and module='qw_microedu'");
$set =iunserializer($settings);
    //检测是否有,如果有就查询,没有就自动注册
    $uniacid = $_W['uniacid'];
    $openid = $userinfo['openid'];
    $users_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_users")." WHERE uniacid='$uniacid' and openid='$openid' ");
    if($users_xq){
        $is_in=1;
    }else{
        $is_in=0;
    }
if($_W['isajax']){
    $caozuo = $_GPC['caozuo'];
    //获取验证码
    if($caozuo=='yanzhengma'){
        $mobile = $_GPC['mobile'];
        $code = rand(1000,2000);
        $_SESSION['code']=$code;
        echo json_encode(array("error"=>1,"message"=>$code));
        return false;
    }
    //添加用户信息
    else if($caozuo=='mobileadd'){
        $mobile=$_GPC['mobile'];
        $code = $_GPC['code'];
        $username = $_GPC['usename'];
        $sex = $_GPC['sex'];
        if(empty($_SESSION['code']) or $code!=$_SESSION['code']){
           echo  json_encode(array('error' => -1, 'message' => "请求超时，@请重试".$code."!!".$_SESSION['code']));
           return false;
        }
        //查询此电话users里面的数据
        $users_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_users")." WHERE uniacid='$uniacid' and mobile='$mobile'");
        if(!$users_xq){
            echo  json_encode(array('error' => -1, 'message' => "不存在此用户"));
            return false;
        }
        switch ($users_xq['role_type']){
            case 'consultants':
                    $rdata = array(
                        "mobile"=>$mobile,
                        "uniacid"=>$uniacid,
                        "avatar"=>$userinfo['headimgurl'],
                        "gender"=>$sex,
                        "openid"=>$openid
                    );
                break;
            case 'parents':
                break;
            default:
                break;
        }
        //暂时先不判断来自哪里
        $r = pdo_update("qw_microedu_users",$rdata,array("mobile"=>$mobile,"uniacid"=>$uniacid));
        if($r){
            echo json_encode(array('error' => 1, 'message' => "修改成功"));
            return false;
            $_SESSION['code']=="";
        }else{
            echo json_encode(array('error' => -1, 'message' => "请求超时，请重试"));
            return false;
        }
    }
    //修改用户信息
    else if($caozuo=='mobileedit'){
        $sex = $_GPC['sex'];
        $rdata = array(
            "gender"=>$sex,
        );
        $r = pdo_update("qw_microedu_users",$rdata,array("uniacid"=>$uniacid,"openid"=>$openid));
        if($r){
            echo json_encode(array('error' => 1, 'message' => "修改成功"));
            return false;
        }else{
            echo json_encode(array('error' => -1, 'message' => "请求超时，请重试"));
            return false;
        }
    }
    //增加课程学员
   else if($caozuo =='addmember'){
        $child = $_GPC['xuanze'];
        $schedule_id = $_GPC['schedule_id'];
       $student_exists = pdo_fetchall("SELECT * FROM ims_qw_microedu_attendance WHERE uniacid ='$uniacid' and schedule_id='$schedule_id' ");
       $arr = array();
       foreach($student_exists as $key=>$v){
           $arr[]=$v['child_id'];
       }
       $num = 0;
       foreach ($child as $key=>$item){
           if(!in_array($item,$arr)){
                $data = array(
                    "uniacid"=>$uniacid,
                    "schedule_id"=>$schedule_id,
                    "child_id"=>$item,
                    "status"=>5,
                );
               pdo_insert("qw_microedu_attendance",$data);
               $num+=1;
           }
       }
       if($num<1){
           echo json_encode(array('error' => -1, 'message' =>"已经加过这些学员"));
           return false;
       }else{
           echo json_encode(array('error' => 1, 'message' =>"成功"));
           return false;
       }
    }
    //发送信息
    else if ($caozuo =='sendmessage'){
        $to_user = $_GPC['to_user'];
        $content = $_GPC['content'];
        $cf = pdo_fetch("SELECT * FROM ims_qw_microedu_messages WHERE uniacid='$uniacid' and to_user='$to_user' and from_user = ".$users_xq['id']." order by unix_timestamp(`sendtime`) desc limit 1");
        if(time()-strtotime($cf['sendtime'])<10){
            echo json_encode(array('error' => -1, 'message' =>"请不要重复发送"));
            return false;
        }
        $yu = time()-strtotime($cf['sendtime']);
        $data = array(
            "content"=>$content,
            "to_user"=>$to_user,
            "from_user"=>$users_xq['id'],
            "sendtime"=>date('Y-m-d H:i:s',time()),
            "uniacid"=>$uniacid,
        );
        $res =pdo_insert("qw_microedu_messages",$data);
        if($res){
            echo json_encode(array('error' => 1, 'message' =>"成功"));
            return false;
        }else{
            echo json_encode(array('error' => -1, 'message' =>"请重试"));
            return false;
        }
    }
    else if ($caozuo == 'getcodeimg'){
        $res = createqrcode($openid);
        if($res[0]==1){
            echo json_encode(array('error' => 1, 'message' =>$res[1],'imgurl'=>$res[2]));
            return false;
        }else{
            echo json_encode(array('error' => -1, 'message' =>$res[1]));
            return false;
        }
    }
}
    $arr = array("display","detail","index","settings","member","student","feedback","message","paike","paike_detail","add_member","qrcode","sheet");
    $page = $_GPC['page'];
    if(!in_array($page,$arr)){
        $page = "index";
    }
    if($page == "index"){
        if(!$users_xq){
            $url = $this->createMobileurl("consultant",array("page"=>"settings"));
            header("Location: $url");
            die;
        }
        $imgerweima = createqrcode($openid);
        include $this->template("consultant/index");
    }
    else if ($page == "settings"){
       // $users_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_users")." WHERE uniacid='$uniacid' and openid='$openid' ");
        include $this->template("consultant/settings");
    }
    else if($page == 'member'){
        //我的会员
        //检测是否注册过
        echo $users_xq['role_id'];
        $parent = pdo_fetchall("SELECT a.*,b.fullname,b.mobile FROM ".tablename("qw_microedu_parents")." as a left join ".tablename("qw_microedu_users") ." as b on a.id = b.role_id  WHERE b.role_type = 'parents' and a.uniacid='$uniacid' and a.consultant_id=".$users_xq['role_id']);
        $num =0;
        $member_list = array();
        foreach($parent as $key=>$item){
            $child_list = pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_children")." WHERE uniacid='$uniacid' and parent_id=".$item['id']);
            foreach ($child_list as $k=>$v){
                //查询是否试听
                $listen_test = pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_attendance")." WHERE uniacid='$uniacid' and status in (1,2,3,5,6) and child_id=".$v['id']);
                if($listen_test){
                    $child_list[$k]['attend_status'] = 1;
                }else{
                    $child_list[$k]['attend_status'] = 0;
                }
                $child_list[$k]['parent_fullname'] = $item['fullname'];
                $child_list[$k]['parent_mobile'] = $item['mobile'];
            }
            $num+=count($child_list);
            $member_list =array_merge($member_list,$child_list);
        }
        include $this->template("consultant/member");
    }
    else if($page == 'student'){
        //我的学员
        $parent = pdo_fetchall("SELECT a.*,b.fullname,b.mobile FROM ".tablename("qw_microedu_parents")." as a left join ".tablename("qw_microedu_users") ." as b on a.id = b.role_id  WHERE b.role_type = 'parents' and a.uniacid='$uniacid' and a.consultant_id=".$users_xq['role_id']);
        $num =0;
        $listen_num=0;
        $member_list = array();
        foreach($parent as $key=>$item){
            $child_list = pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_children")." WHERE uniacid='$uniacid' and parent_id=".$item['id']);
            foreach ($child_list as $k=>$v){
                //查询是否试听
                $listen_test = pdo_fetchall("SELECT * FROM ".tablename("qw_microedu_attendance")." WHERE uniacid='$uniacid' and status in (1,2,3,5,6) and child_id=".$v['id']);
                if($listen_test){
                    $child_list[$k]['attend_status'] = 1;
                    $listen_num+=1;
                }else{
                    $child_list[$k]['attend_status'] = 0;
                }
                $child_list[$k]['parent_fullname'] = $item['fullname'];
                $child_list[$k]['parent_mobile'] = $item['mobile'];
            }
            $num+=count($child_list);
            $member_list =array_merge($member_list,$child_list);
        }
        include $this->template("consultant/student");
    }
    //家长反馈
    else if($page == 'feedback'){
        //当前users的id
        $user_con_id = $users_xq['id'];
        $p_list = pdo_fetchall("SELECT from_user FROM ims_qw_microedu_messages  WHERE uniacid='$uniacid' and to_user='$user_con_id' and `read`=1 group by `read`,`from_user`");
        $arr = array();
        foreach ($p_list as $k=>$v){
            $arr[]=$v['from_user'];
        }
        $parent_list = pdo_fetchall("SELECT * FROM ims_qw_microedu_messages  WHERE uniacid='$uniacid' and to_user='$user_con_id' group by `read`,`from_user` order by `read` desc ,unix_timestamp(`sendtime`) desc ");
        foreach($parent_list as $key=>$vo){
            //查询名字
            $parent_xq = pdo_fetch("SELECT * FROM ims_qw_microedu_users WHERE uniacid='$uniacid' and id=".$vo['from_user']);
            $parent_list[$key]['fullname'] = $parent_xq['fullname'];
            $parent_list[$key]['mobile'] = $parent_xq['mobile'];
            if((in_array($vo['from_user'],$arr))&&($vo['read']!=1)){
                unset($parent_list[$key]);
            }
        }
       // p($parent_list);    //
        include $this->template("consultant/feedback");
    }
   //发送信息
    else if($page == 'message'){
        $from_user = $_GPC['from_user'];
        $to_user = $users_xq['id'];
        $from_user_xq = pdo_fetch("SELECT * FROM ".tablename("qw_microedu_users")." WHERE uniacid = '$uniacid' and role_id='$to_user'");
        $message_list = pdo_fetchall("SELECT * FROM ims_qw_microedu_messages WHERE uniacid='$uniacid' and from_user in ('$from_user',$to_user) and to_user in ('$from_user','$to_user') order by unix_timestamp(`sendtime`) asc ");
        include $this->template("consultant/message");
    }
    //排课列表
    else if ($page == 'paike'){
        $start_today = strtotime(date('Y-m-d',time()));
        $end_today = $start_today+60*24*60-1;
        $start_yes = $start_today-60*60*24;
        $end_tom = $end_today+60*60*24;
        $op = isset($_GPC['op'])?$_GPC['op']:'today';
        if($op =='today'){
            $where  = " and unix_timestamp(a.timeslot)  between '$start_today' and '$end_today' ";
        }
        else if ($op =='yes'){
            $where = " and unix_timestamp(a.timeslot) between '$start_yes' and '$start_today' ";
        }
        else if($op =='tom'){
            $where = " and unix_timestamp(a.timeslot) between '$end_today' and '$end_tom' ";
        }
        $sql = "SELECT a.*,b.name AS campus_name,b.address AS campus_address,d.class_name,e.fullname AS tutor_fullname FROM ims_qw_microedu_schedules AS a  LEFT JOIN ims_qw_microedu_campuses AS b ON a.campus_id = b.id   LEFT JOIN ims_qw_microedu_contractsclasses AS d on a.contractclass_id= d.id LEFT JOIN ims_qw_microedu_users AS e on a.tutor_id = e.role_id  WHERE e.role_type='tutors' and a.trialable=1 ".$where." ;";
        $class_list = pdo_fetchall($sql);
        include  $this->template('consultant/paike');
    }
    //排课详细
    else if ($page =='paike_detail'){
        $schedule_id = $_GPC['schedule_id'];
        $class = pdo_fetch("SELECT a.*,b.name AS campus_name,b.address AS campus_address,d.class_name,e.fullname AS tutor_fullname FROM ims_qw_microedu_schedules AS a  LEFT JOIN ims_qw_microedu_campuses AS b ON a.campus_id = b.id   LEFT JOIN ims_qw_microedu_contractsclasses AS d on a.contractclass_id= d.id LEFT JOIN ims_qw_microedu_users AS e on a.tutor_id = e.role_id  WHERE a.id = '$schedule_id' and e.role_type='tutors' and a.trialable=1 ".$where);
        $student_list = pdo_fetchall("SELECT a.*,b.id as child_id,b.fullname as child_fullname,b.avatar as child_avatar,b.age as child_age,c.fullname as tutor_fullname,c.mobile as tutor_mobile FROM ".tablename("qw_microedu_attendance")." as a left join ".tablename("qw_microedu_children")." as b on a.child_id = b.id  left join ".tablename("qw_microedu_users")." as c on b.parent_id = c.role_id  WHERE a.uniacid ='$uniacid' and a.schedule_id= '$schedule_id' and c.role_type='parents'");
        include $this->template('consultant/paike_detail');
    }
    else if ($page =='add_member'){
        $schedule_id = $_GPC['schedule_id'];
        $student_exists = pdo_fetchall("SELECT * FROM ims_qw_microedu_attendance WHERE uniacid ='$uniacid' and schedule_id='$schedule_id' ");
        $arr = array();
        foreach($student_exists as $key=>$v){
            $arr[]=$v['child_id'];
        }
        $child_rand = implode(",",$arr);
        $student_list = pdo_fetchall("SELECT a.*,b.fullname as tutor_fullname,b.mobile as tutor_mobile FROM ims_qw_microedu_children as a left join ims_qw_microedu_users as b on a.parent_id = b.role_id WHERE a.uniacid = '$uniacid' and role_type='parents' and a.id NOT IN ($child_rand)");
        include $this->template('consultant/add_member');
    }
    else if($page =='qrcode'){
        $res = createqrcode($openid);
        if($res[0]==1){
            //成功

        }else{
            //失败
        }
        //检测结果
    }
    else if($page =='sheet'){
        $numstudent = pdo_fetch("select count(*) as numstudent from ims_qw_microedu_children where date_format(created_time,'%Y-%m')=date_format(now(),'%Y-%m') ");
        $addnumstudent = $numstudent['numstudent'];//新增学员
        $numparent = pdo_fetch("SELECT count(*) as numparent FROM ims_qw_microedu_users WHERE uniacid ='$uniacid' and role_type ='parents' and date_format(created_at,'%Y-%m')=date_format(now(),'%Y-%m')");
        $addnumparnt = $numparent['numparent'];//新增家长
        include $this->template('consultant/sheet');
    }

