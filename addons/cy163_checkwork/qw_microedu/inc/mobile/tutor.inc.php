<?php
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$uniacid = $_W['uniacid'];
$settings = pdo_fetchcolumn("SELECT settings FROM".tablename('uni_account_modules')."WHERE uniacid='$uniacid' and module='qw_microedu'");
$set =iunserializer($settings);

// 判断当前用户是否为教师，否则跳转至其所属的页面
$user = pdo_get('qw_microedu_users', array(
    'openid' => $_W['openid'],
    'uniacid' => $_W['uniacid'],
), array());

if ($user)
{
    if ($user['role_type'] == 'parents')
    {
        header("Location: " . $this->createMobileUrl('parent', array(
                'page' => 'index',
            )));
    }
    elseif
    ($user['role_type'] == 'consultants')
    {
        header("Location: " . $this->createMobileUrl('consultant', array(
                'page' => 'index',
            )));
    }
}
else
{  // 用户不存在于用户表中，跳转至家长设置页
    header("Location: " . $this->createMobileUrl('parent', array(
            'page' => 'settings',
        )));
}

//程序部分
$action = $_GPC['action'];
if ($action == 'postSettings')
{
    postSettings($user, $_GPC['fullname'], $_GPC['mobile'], $_GPC['captcha'], $_GPC['gender']);
    return false;
}
elseif ($action == 'postAttendance')
{
    postAttendance($_GPC['attendanceId'], $_GPC['status'], $set);
    return false;
}
//验证手机号的 ajax two
elseif ($action == 'ajax_mobile_two')
{
    $ajax = ajax_mobile($_GPC['mobile']);

    if($ajax == 0)
    {
        //返回值
        echo json_encode(array(
            'status' => 'success',
        ));
        return false;
    }
    else
    {
        //判断查到的用户的openid和微信用户的openid是否相等
        if($_W['openid'] == $ajax['openid'])
        {
            //返回值
            echo json_encode(array(
                'status' => 'success',
            ));
            return false;
        }
        else
        {
            //返回值
            echo json_encode(array(
                'status' => 'error',
            ));
            return false;
        }
    }
}
//处理用户资料编辑修改
elseif ($action == 'user_edit')
{
    //传过来的用户的信息
    $data = array(
        'fullName' => $_GPC['fullName'],//姓名 fullname
        'mobile' => $_GPC['mobile'],//手机号 mobile
        'gender' => $_GPC['gender'] //性别 gender
    );

    //修改数据
    if (!empty(pdo_update('qw_microedu_users', $data, array('id' => $user['id'],'uniacid' => $_W['uniacid']))))
    {
        //返回值
        echo json_encode(array(
            'status' => 'success',
        ));
        return false;
    }
    else
    {
        //返回值
        echo json_encode(array(
            'status' => 'error',
        ));
        return false;
    }
}
//发送信息
elseif ($action == 'send_message')
{
    $from_user = $user['id'];
    $to_user = $_GPC['id'];
    $content = $_GPC['val'];

    //插入数据库
    $data = array(
        'uniacid' => $_W['uniacid'],
        'from_user' => $from_user,
        'to_user' => $to_user,
        'content' => $content,
        'read' => 0,
        'sendtime' => date('Y-m-d H:i:s')
    );
    //插入数据库
    $result = pdo_insert('qw_microedu_messages', $data);
    //插入判断
    if (!empty($result))
    {
        echo json_encode(array(
            'status' => 'success',
        ));
        return false;
    }
    else
    {
        echo json_encode(array(
            'status' => 'error',
        ));
        return false;
    }
}
//评价
elseif ($action == 'pingjian')
{
    $tutor_id = $_GPC['tutor_id'];
    $attendance_id = $_GPC['attendance_id'];
    $comment = $_GPC['val'];

    //插入数据库
    $data = array(
        'tutor_id' => $tutor_id,
        'attendance_id' => $attendance_id,
        'comment' => $comment,
        'uniacid' => $_W['uniacid']
    );
    //插入数据库
    $result = pdo_insert('qw_microedu_tutorcomments', $data);

    //插入判断
    if (!empty($result))
    {
        $sql = "SELECT u.openid FROM "
            . tablename('qw_microedu_attendance') .
            " as a LEFT JOIN "
            . tablename('qw_microedu_children') .
            " as c ON a.child_id = c.id LEFT JOIN "
            . tablename('qw_microedu_users') .
            "as u ON c.parent_id = u.role_id "
            ."WHERE a.uniacid=:uniacid AND a.id=:id AND u.role_type=:role_type";

        $params = array(
            ':uniacid' => $_W['uniacid'],
            ':id' => $attendance_id,
            ':role_type' => 'parents'
        );
        $res = pdo_fetch($sql,$params);

        if(!empty($res))
        {
            //发送模板消息
            $templid = $set['purch_tplid'];
            $tplurl = "";
            $openid = $res['openid'];
            $content = array
            (
                "first"=>array("value"=>"您已成功评价"),
                "keyword1"=>array("value"=>"教师评价操作"),
                "keyword2"=>array("value"=>"评价成功"),
                "remark"=>array("value"=>"谢谢")
            );

            global $_GPC, $_W;
            load() -> classs('weixin.account');
            load() -> func('communication');
            $obj = new WeiXinAccount();
            $access_token = $obj -> fetch_available_token();
            $data = array(
                'touser' => $openid,
                'template_id' => $templid,
                'url' => $tplurl,
                'topcolor' => "#FF0000",
                'data' => $content,
            );
            $json = json_encode($data);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;
            $ret = ihttp_post($url, $json);

        }

        echo json_encode(array(
            'status' => 'success',
        ));
        return false;
    }
    else
    {
        echo json_encode(array(
            'status' => 'error',
        ));
        return false;
    }
}
//上传作品
elseif ($action == 'project')
{
    $description = $_GPC['val'];
    $schedule_id = $_GPC['schedule_id'];
    $child_id = $_GPC['child_id'];
    $pic = $_GPC['uploadsrc'];//图片的
    $pics = array();
    foreach ($pic as $key=>$v){
        $file = "/addons/qw_microedu/assets/img/children";
        $picname = time().rand(100,200).".jpg";
        $pics[] = getmedia($v,$file,$picname);
    }
    //插入数据库
    $data = array(
        'uniacid' => $_W['uniacid'],
        'child_id' => $child_id,
        'description' => $description,
        'schedule_id' => $schedule_id,
        'pics' => json_encode($pics),//图片的
    );
    //插入数据库
    $result = pdo_insert('qw_microedu_projects', $data);
    //插入判断
    if (!empty($result))
    {
        $sql = "SELECT u.openid FROM "
            . tablename('qw_microedu_children') .
            " as c LEFT JOIN "
            . tablename('qw_microedu_users') .
            "as u ON c.parent_id = u.role_id "
            ."WHERE c.uniacid=:uniacid AND c.id=:id AND u.role_type=:role_type";

        $params = array(
            ':uniacid' => $_W['uniacid'],
            ':id' => $child_id,
            ':role_type' => 'parents'
        );
        $res = pdo_fetch($sql,$params);

        if(!empty($res))
        {
            //发送模板消息
            $templid = $set['purch_tplid'];
            $tplurl = "";
            $openid = $res['openid'];
            $content = array
            (
                "first"=>array("value"=>"您已成功上传作品"),
                "keyword1"=>array("value"=>"教师上传作品操作"),
                "keyword2"=>array("value"=>"上传成功"),
                "remark"=>array("value"=>"谢谢")
            );

            global $_GPC, $_W;
            load() -> classs('weixin.account');
            load() -> func('communication');
            $obj = new WeiXinAccount();
            $access_token = $obj -> fetch_available_token();
            $data = array(
                'touser' => $openid,
                'template_id' => $templid,
                'url' => $tplurl,
                'topcolor' => "#FF0000",
                'data' => $content,
            );
            $json = json_encode($data);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;
            $ret = ihttp_post($url, $json);
        }

        echo json_encode(array(
            'status' => 'success',
        ));
        return false;
    }
    else
    {
        echo json_encode(array(
            'status' => 'error',
        ));
        return false;
    }
}


//页面部分
$page = empty($_GPC['page']) ? 'index' : $_GPC['page'];
if ($page == 'index')
{
    $message = pdo_get('qw_microedu_messages', array('uniacid' => $_W['uniacid'],'read' => '1','to_user' => $user['id']));

    include $this->template('tutor/index');
}
elseif ($page == 'settings')
{
    include $this->template('tutor/settings');
}
//我的课程
elseif ($page == 'schedules')
{
    // 若 URL 不包含日期，则赋值当天日期
    $date = empty($_GPC['date']) ? date('Y-m-d') : $_GPC['date'];

    $sql = '
        SELECT schedules.*, contractsclasses.class_name, campus.name AS location
        FROM ' . tablename('qw_microedu_schedules') . ' AS schedules
        JOIN ' . tablename('qw_microedu_contractsclasses') . ' AS contractsclasses
            ON schedules.contractclass_id = contractsclasses.id
        JOIN ' . tablename('qw_microedu_campuses') . ' AS campus
            ON schedules.campus_id = campus.id
        WHERE schedules.uniacid=:uniacid AND schedules.tutor_id=:tutor_id
            AND schedules.timeslot >= :today AND schedules.timeslot < :tomorrow
        ORDER BY schedules.timeslot ASC';

    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':tutor_id' => $user['role_id'],
        ':today' => date('Y-m-d'),
        ':tomorrow' => date('Y-m-d', strtotime('+1 day')),
    );
    $today = pdo_fetchall($sql, $params);

    $params[':today'] = date('Y-m-d', strtotime('-1 day'));
    $params[':tomorrow'] = date('Y-m-d');
    $yesterday = pdo_fetchall($sql, $params);

    $params[':today'] = date('Y-m-d', strtotime('+1 day'));
    $params[':tomorrow'] = date('Y-m-d', strtotime('+2 days'));
    $tomorrow = pdo_fetchall($sql, $params);

    include $this->template('tutor/schedules');

}
elseif ($page == 'class-details')
{
    $schedule_id = $_GPC['schedule_id'];

    // 查询课程基本信息和需要上本次课的儿童
    $sql = '
        SELECT attendance.id AS attendance_id, attendance.child_id,attendance.status as attendance_status , children.fullname,children.age, children.avatar, users.fullname AS parent_name,users.mobile AS parent_mobile,campus.name AS campus, schedules.classroom, schedules.timeslot,contractsclasses.class_name,parentscontracts.id as parentscontracts_id
        FROM ' . tablename('qw_microedu_schedules') . ' AS schedules
        JOIN ' . tablename('qw_microedu_attendance') . ' AS attendance
            ON schedules.id = attendance.schedule_id
        JOIN ' . tablename('qw_microedu_children') . ' AS children
            ON attendance.child_id = children.id
        JOIN ' . tablename('qw_microedu_users') . ' AS users
            ON children.parent_id = users.role_id AND users.role_type=:role
        JOIN ' . tablename('qw_microedu_campuses') . ' AS campus
            ON schedules.campus_id = campus.id
        JOIN ' . tablename('qw_microedu_contractsclasses') . ' AS contractsclasses
            ON schedules.contractclass_id = contractsclasses.id
        JOIN ' . tablename('qw_microedu_parentscontracts') . ' AS parentscontracts
            ON contractsclasses.contract_id = parentscontracts.contract_id AND children.parent_id = parentscontracts.parent_id
        WHERE schedules.id = :schedule_id AND schedules.uniacid = :uniacid group by attendance.child_id
    ';

    $params = array(
        ':schedule_id' => $schedule_id,
        ':uniacid' => $_W['uniacid'],
        ':role' => 'parents'
    );

    $attendance = pdo_fetchall($sql, $params);

    foreach ($attendance as $key => $value)
    {
        $sql = " SELECT SUM(amount) as remaining_hours FROM "
            . tablename('qw_microedu_parentsremainingclasshours') .
            " WHERE parentscontract_id=:id AND uniacid=:uniacid";

        $res = pdo_fetch($sql,array(
            ':id' => $value['parentscontracts_id'],
            ':uniacid' => $_W['uniacid']
        ));

        $attendance[$key]['remaining_hours'] = $res['remaining_hours'];
    }

    include $this->template('tutor/unattended-classes');
}
//已上课程
elseif ($page == 'listed')
{
    $sql = " SELECT id,duration,timeslot,contractclass_id,campus_id,classroom FROM "
        . tablename('qw_microedu_schedules') ." WHERE uniacid=:uniacid AND tutor_id=:tutorid ORDER BY timeslot DESC ";
    $schedules = pdo_fetchall($sql,array(
        ':uniacid' => $_W['uniacid'],
        ':tutorid' => $user['role_id']
    ));

    $attendance = array();

    foreach($schedules as $key => $value)
    {
        $timeslot = strtotime($value['timeslot']) + $value['duration']*60;

        //如果课时加完之后的时间比当前时间要小   那就说明这节课已经上完了  然后就可以去查询这节课的信息数据了
        if($timeslot < time())
        {
            $sql = " SELECT campuses.name,contractsclasses.class_name FROM " . tablename('qw_microedu_campuses') ." as campuses , " . tablename('qw_microedu_contractsclasses') . " as contractsclasses WHERE campuses.id=:campus_id AND contractsclasses.id=:contractclass_id ";
            $res = pdo_fetch($sql,array(
                ':campus_id' => $value['campus_id'],
                ':contractclass_id' => $value['contractclass_id']
            ));

            $res['name'] = $res['name'].'&nbsp;'.$value['classroom'];
            $res['time'] = $value['timeslot'];
            $res['id'] = $value['id'];
            $attendance[] = $res;
        }
    }

    include $this->template('tutor/listed');
}
//已上课程详情
elseif ($page == 'listed-details')
{
    $schedule_id = $_GPC['schedule_id'];

    // 查询课程基本信息和需要上本次课的儿童
    $sql = '
        SELECT attendance.id AS attendance_id, attendance.child_id,attendance.status as attendance_status , children.fullname,children.age, children.avatar, users.fullname AS parent_name,users.mobile AS parent_mobile,campus.name AS campus, schedules.classroom, schedules.timeslot,contractsclasses.class_name,parentscontracts.id as parentscontracts_id,schedules.tutor_id,schedules.id as schedule_id
        FROM ' . tablename('qw_microedu_schedules') . ' AS schedules
        JOIN ' . tablename('qw_microedu_attendance') . ' AS attendance
            ON schedules.id = attendance.schedule_id
        JOIN ' . tablename('qw_microedu_children') . ' AS children
            ON attendance.child_id = children.id
        JOIN ' . tablename('qw_microedu_users') . ' AS users
            ON children.parent_id = users.role_id AND users.role_type=:role
        JOIN ' . tablename('qw_microedu_campuses') . ' AS campus
            ON schedules.campus_id = campus.id
        JOIN ' . tablename('qw_microedu_contractsclasses') . ' AS contractsclasses
            ON schedules.contractclass_id = contractsclasses.id
        JOIN ' . tablename('qw_microedu_parentscontracts') . ' AS parentscontracts
            ON contractsclasses.contract_id = parentscontracts.contract_id AND children.parent_id = parentscontracts.parent_id
        WHERE schedules.id = :schedule_id AND schedules.uniacid = :uniacid group by attendance.child_id
    ';

    $params = array(
        ':schedule_id' => $schedule_id,
        ':uniacid' => $_W['uniacid'],
        ':role' => 'parents'
    );

    $attendance = pdo_fetchall($sql, $params);

    foreach ($attendance as $key => $value)
    {
        //
        $sql = " SELECT SUM(amount) as remaining_hours FROM "
            . tablename('qw_microedu_parentsremainingclasshours') .
            " WHERE parentscontract_id=:id AND uniacid=:uniacid";

        $res = pdo_fetch($sql,array(
            ':id' => $value['parentscontracts_id'],
            ':uniacid' => $_W['uniacid']
        ));

        $attendance[$key]['remaining_hours'] = $res['remaining_hours'];

        $sql = " SELECT * FROM "
            . tablename('qw_microedu_tutorcomments') .
            " WHERE tutor_id=:tutor_id AND attendance_id=:attendance_id AND uniacid=:uniacid ";

        $params = array(
            ':tutor_id' => $value['tutor_id'],
            ':attendance_id' => $value['attendance_id'],
            ':uniacid' => $_W['uniacid']
        );
        $comment_res = pdo_fetch($sql,$params);

        if(!empty($comment_res))
        {
            $attendance[$key]['comment_status'] = 1;
        }
        else
        {
            $attendance[$key]['comment_status'] = 0;
        }

        //
        $sql = " SELECT pics,description FROM "
            . tablename('qw_microedu_projects') .
            " WHERE schedule_id=:schedule_id AND child_id=:child_id AND uniacid=:uniacid ";
        $project = pdo_fetch($sql,array(
            ':schedule_id' => $value['schedule_id'],
            ':child_id' => $value['child_id'],
            ':uniacid' => $_W['uniacid']
        ));

        if(!empty($project))
        {
            if($project['pics'] || $project['description'])
            {
                $attendance[$key]['project_status'] = 1;
            }
            else
            {
                $attendance[$key]['project_status'] = 0;
            }
        }
        else
        {
            $attendance[$key]['project_status'] = 0;
        }

    }

//    echo '<pre>';var_dump($attendance);die;

    include $this->template('tutor/listed-details');
}
//评价已上课程
elseif ($page == 'pingjia')
{
    $tutor_id = $_GPC['tutor_id'];
    $attendance_id = $_GPC['attendance_id'];

    include $this->template('tutor/pingjia');
}
//上传作品
elseif ($page == 'upload-zuopin')
{
    $schedule_id = $_GPC['schedule_id'];
    $child_id = $_GPC['child_id'];

    include $this->template('tutor/upload-zuopin');
}
//未上课程
elseif ($page == 'listun')
{
    $sql = " SELECT id,duration,timeslot,contractclass_id,campus_id,classroom FROM "
        . tablename('qw_microedu_schedules') ." WHERE uniacid=:uniacid AND tutor_id=:tutorid ORDER BY timeslot DESC ";
    $schedules = pdo_fetchall($sql,array(
        ':uniacid' => $_W['uniacid'],
        ':tutorid' => $user['role_id']
    ));

    $attendance = array();

    foreach($schedules as $key => $value)
    {
        $timeslot = strtotime($value['timeslot']);

        //如果课时加完之后的时间比当前时间要小   那就说明这节课还没上  然后就可以去查询这节课的信息数据了
        if($timeslot > time())
        {
            $sql = " SELECT campuses.name,contractsclasses.class_name FROM " . tablename('qw_microedu_campuses') ." as campuses , " . tablename('qw_microedu_contractsclasses') . " as contractsclasses WHERE campuses.id=:campus_id AND contractsclasses.id=:contractclass_id ";
            $res = pdo_fetch($sql,array(
                ':campus_id' => $value['campus_id'],
                ':contractclass_id' => $value['contractclass_id']
            ));

            $res['name'] = $res['name'].'&nbsp;'.$value['classroom'];
            $res['time'] = $value['timeslot'];
            $res['id'] = $value['id'];
            $attendance[] = $res;
        }
    }

    include $this->template('tutor/listun');
}
//家长反馈
elseif ($page == 'jiazhang')
{
    $sql = "SELECT u.avatar,u.id as uid,u.fullname,u.role_type,u.role_id,m.sendtime,m.content,m.read FROM "
        . tablename('qw_microedu_messages') .
        " AS m LEFT JOIN "
        . tablename('qw_microedu_users') .
        " AS u ON m.from_user = u.id WHERE m.uniacid=:uniacid AND m.to_user=:to_user GROUP BY m.from_user ORDER BY m.read,MAX(m.sendtime) DESC";
    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':to_user' => $user['id']
    );

    $xinxis = pdo_fetchall($sql,$params);

    include $this->template('tutor/jiazhang');
}
//家长反馈 详情
elseif ($page == 'message')
{
    $user_id = $user['id'];

    $from_user = $_GPC['id'];
    $uniacid = $_W['uniacid'];
    $message_list = pdo_fetchall("SELECT from_user,to_user,content,sendtime FROM ims_qw_microedu_messages WHERE uniacid='$uniacid' and from_user in ('$from_user','$user_id') and to_user in ('$from_user','$user_id') order by unix_timestamp(`sendtime`) asc ");

    foreach($message_list as $key => $value)
    {
        if($value['from_user'] != $user_id)
        {
            $user_two = pdo_get('qw_microedu_users', array('id' => $value['from_user'], 'uniacid' => $_W['uniacid']));
            $message_list[$key]['avatar'] = $user_two['avatar'];
        }
    }

    //把信息改为已读
    $data = array(
        'read' => '0'
    );
    $where = array(
        'from_user' => $from_user,
        'to_user' => $user_id
    );
    pdo_update('qw_microedu_messages', $data, $where);

    include $this->template('tutor/message');
}
//查看报表
elseif ($page == 'sheet')
{
    //总排课量
    $sql = " SELECT count(id) as zong FROM "
        . tablename('qw_microedu_schedules') .
        " WHERE uniacid=:uniacid AND tutor_id=:tutor_id AND timeslot < :timeslot";
    $schedule_params = array(
        ':uniacid' => $_W['uniacid'],
        ':tutor_id' => $user['role_id'],
        ':timeslot' => date('Y-m-d H:is')
    );

    $zong_paike = pdo_fetch($sql,$schedule_params);

    //总课时
    $sql = " SELECT sum(duration) as zong FROM "
        . tablename('qw_microedu_schedules') .
        " WHERE uniacid=:uniacid AND tutor_id=:tutor_id AND timeslot < :timeslot";
    $duration_params = array(
        ':uniacid' => $_W['uniacid'],
        ':tutor_id' => $user['role_id'],
        ':timeslot' => date('Y-m-d H:is')
    );

    $classover_zong = pdo_fetch($sql,$duration_params);
    $zong_classover = round($classover_zong['zong'] / 60,2);

    //本月排课量
    $sql = " SELECT count(id) as yue FROM "
        . tablename('qw_microedu_schedules') .
        " WHERE uniacid=:uniacid AND tutor_id=:tutor_id AND timeslot > :timeslot AND timeslot < :timeslottwo";
    $schedule_params = array(
        ':uniacid' => $_W['uniacid'],
        ':tutor_id' => $user['role_id'],
        ':timeslot' => date('Y-m').'-00 00:00:00',
        ':timeslottwo' => date('Y-m-d H:i:s')
    );

    $month_paike = pdo_fetch($sql,$schedule_params);

    //本月课时
    $sql = " SELECT sum(duration) as zong FROM "
        . tablename('qw_microedu_schedules') .
        " WHERE uniacid=:uniacid AND tutor_id=:tutor_id AND timeslot > :timeslot AND timeslot < :timeslottwo";
    $duration_params = array(
        ':uniacid' => $_W['uniacid'],
        ':tutor_id' => $user['role_id'],
        ':timeslot' => date('Y-m').'-00 00:00:00',
        ':timeslottwo' => date('Y-m-d H:i:s')
    );

    $classover = pdo_fetch($sql,$duration_params);
    $class_over = round($classover['zong'] / 60,2);

    include $this->template('tutor/sheet');
}


//通过手机号查找用户
function ajax_mobile($mobile)
{
    global $_W;
    //查找数据
    $sql = "SELECT * FROM " . tablename('qw_microedu_users') . " WHERE uniacid=:uniacid AND mobile=:mobile";
    $params = array(
        ':uniacid' => $_W['uniacid'], //微信公众平台的id
        ':mobile' => $mobile //手机号 mobile
    );

    $user = pdo_fetch($sql,$params);
    if (!empty($user))
    {
        //查到返回1
        return $user;die;
    }
    else
    {
        //没查到返回0
        return '0';die;
    }
}

function postSettings($user, $fullname, $mobile, $captcha, $gender)
{
    global $_W;

    if (empty($fullname))
    {
        echo json_encode(array(
            'status' => 'failed',
            'message' => '请输入姓名',
        ));
        return false;
    }

    if (empty($mobile))
    {
        echo json_encode(array(
            'status' => 'failed',
            'message' => '请输入手机号',
        ));
        return false;
    }

    if (strlen($mobile) != 11)
    {
        echo json_encode(array(
            'status' => 'failed',
            'message' => '手机号码错误',
        ));
        return false;
    }

    if (empty($captcha))
    {
        echo json_encode(array(
            'status' => 'failed',
            'message' => '请输入验证码',
        ));
        return false;
    }

    $result = pdo_update('qw_microedu_users', array(
        'fullname' => $fullname,
        'mobile' => $mobile,
        'gender' => $gender,
    ), array(
        'uniacid' => $_W['uniacid'],
        'id' => $user['id'],
    ));

    if (!empty($result))
    {
        echo json_encode(array(
            'status' => 'success',
        ));
        return false;
    }
    else
    {
        echo json_encode(array(
            'status' => 'failed',
            'message' => '保存失败，请重试',
        ));
        return false;
    }
}

function postAttendance($attendance_id, $status, $set)
{
    global $_W;

    $result = pdo_update('qw_microedu_attendance', array(
        'status' => $status,
    ), array(
        'uniacid' => $_W['uniacid'],
        'id' => $attendance_id,
    ));

    $sql = "SELECT u.openid FROM "
        . tablename('qw_microedu_attendance') .
        " as a LEFT JOIN "
        . tablename('qw_microedu_children') .
        " as c ON a.child_id = c.id LEFT JOIN "
        . tablename('qw_microedu_users') .
        "as u ON c.parent_id = u.role_id "
        ."WHERE a.uniacid=:uniacid AND a.id=:id AND u.role_type=:role_type";

    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':id' => $attendance_id,
        ':role_type' => 'parents'
    );
    $res = pdo_fetch($sql,$params);

    if (!empty($result))
    {
        if(!empty($res))
        {
            //发送模板消息
            $templid = $set['purch_tplid'];
            $tplurl = "";
            $openid = $res['openid'];
            $content = array
            (
                "first"=>array("value"=>"您已成功签到"),
                "keyword1"=>array("value"=>"教师签到操作"),
                "keyword2"=>array("value"=>"签到成功"),
                "remark"=>array("value"=>"谢谢")
            );

            global $_GPC, $_W;
            load() -> classs('weixin.account');
            load() -> func('communication');
            $obj = new WeiXinAccount();
            $access_token = $obj -> fetch_available_token();
            $data = array(
                'touser' => $openid,
                'template_id' => $templid,
                'url' => $tplurl,
                'topcolor' => "#FF0000",
                'data' => $content,
            );
            $json = json_encode($data);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;
            $ret = ihttp_post($url, $json);
        }

        echo json_encode(array(
            'status' => 'success',
        ));
        return false;
    }
    else
    {
        echo json_encode(array(
            'status' => 'failed',
        ));
        return false;
    }
}