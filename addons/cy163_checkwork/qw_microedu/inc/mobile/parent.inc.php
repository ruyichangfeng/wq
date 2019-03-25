<?php
defined('IN_IA') or exit('Access Denied');

include MODULE_ROOT . '/models/parents.php';

global $_W, $_GPC;
load()->func('tpl');
// 获取家长基本信息
$sql = "SELECT * FROM " . tablename('qw_microedu_parents') . " WHERE uniacid=:uniacid AND id=:parent_id";
$params = array(
    ':uniacid' => $_W['uniacid'],
    ':parent_id' => $user['role_id'],  // 能进入此脚本的只有家长
);
$parent = pdo_fetch($sql, $params);

//page 页面部分
$page = $_GPC['page'];
switch ($page) {
    //首页
    case 'index':
        $user = user();
        //查询顾问
        $sql = "SELECT u.* FROM "
        . tablename('qw_microedu_parents') .
        " AS p LEFT JOIN "
        . tablename('qw_microedu_users') .
        " AS u ON p.consultant_id=u.role_id ".
        " WHERE p.id=:role_id ";

        $params = array(
            ':role_id' => $user['role_id']
        );

        $consultant = pdo_fetch($sql,$params);

        //获取家长信息
        $user = user();

        if ($user) {
            //获取孩子信息
            $childrens = childrens($user['role_id']);

            //当前选中孩子id
            empty($_GPC['children_id']) ? $child_id = $childrens[0]['id'] : $child_id = $_GPC['children_id'];

            //查询快到期的合同时间
            $sql = "SELECT min(contract_enddate) as min_time FROM "
                .tablename('qw_microedu_parentscontracts').
                "WHERE uniacid=:uniacid AND parent_id=:parent_id AND status=:status AND contract_enddate > :contract_enddate ";
            $params = array(
                ':uniacid' => $_W['uniacid'], //微信公众平台的id
                ':parent_id' => $user['id'], //家长id parent_id
                ':status' => '1', //合同购买状态 status
                ':contract_enddate' => date('Y-m-d H:i:s') //结束时间 contract_enddate
            );
            $contract_time = pdo_fetch($sql,$params);

            if(!empty($contract_time['min_time']))
            {
                $min_time = $contract_time['min_time'].'结束';
            }
            else
            {
                $min_time = '暂无合同';
            }

            $message = pdo_get('qw_microedu_messages', array('uniacid' => $_W['uniacid'],'read' => '1','to_user' => $user['id']));

            include $this->template('parent/home');
        } else {
            header("Location: " . $this->createMobileUrl('parent', array('page' => 'settings')));
            return false;
        }
        break;
    //个人资料填写页
    case 'settings':
        include $this->template('parent/settings');
        break;
    //个人资料编辑页
    case 'settings_edit':
        //获取用户信息
        $user = user();

        include $this->template('parent/settings_edit');
        break;
    //跳转
    case 'tiao':
        $user = user();

        if($user['role_type'] == 'parents')
        {
            if($user['mobile'])
            {
                header("Location: " . $this->createMobileUrl('parent', array('page' => 'index')));
            }
            else
            {
                header("Location: " . $this->createMobileUrl('parent', array('page' => 'settings')));
            }
        }
        elseif($user['role_type'] == 'consultants')
        {
            header("Location: " . $this->createMobileUrl('consultant', array('page' => 'index')));
        }
        elseif($user['role_type'] == 'tutors')
        {
            header("Location: " . $this->createMobileUrl('tutor', array('page' => 'index')));
        }
        else
        {
            header("Location: " . $this->createMobileUrl('parent', array('page' => 'settings')));
        }
        break;
    //管理子女页
    case 'managezn':
        //获取家长信息
        $user = user();
        //获取孩子信息
        $childrens = childrens($user['role_id']);

        include $this->template('parent/managezn');
        break;
    //子女详情编辑页
    case 'editzn':
        //获取孩子信息
        $children = children($_GET['children']);

        include $this->template('parent/editzn');
        break;
    //子女作品页
    case 'zuopin':
        if ($_GPC['schedule_id'])
        {
            $sql = "SELECT p.pics,p.description,s.timeslot,c.class_name FROM ".
                tablename("qw_microedu_projects")
                ." as p left join ".
                tablename('qw_microedu_schedules')
                ." as s on p.schedule_id=s.id left join ".
                tablename('qw_microedu_contractsclasses')
                ." as c on s.contractclass_id=c.id WHERE p.uniacid=:uniacid AND p.schedule_id=:schedule_id order by s.timeslot desc";

            $params = array(
                ':uniacid' => $_W['uniacid'],
                ':schedule_id' => $_GPC['schedule_id']
            );

            $projects = pdo_fetchall($sql,$params);
        }
        else
        {
            $sql = "SELECT p.pics,p.description,s.timeslot,c.class_name FROM ".
                tablename("qw_microedu_projects")
                ." as p left join ".
                tablename('qw_microedu_schedules')
                ." as s on p.schedule_id=s.id left join ".
                tablename('qw_microedu_contractsclasses')
                ." as c on s.contractclass_id=c.id WHERE p.uniacid=:uniacid AND p.child_id=:child_id order by s.timeslot desc";

            $params = array(
                ':uniacid' => $_W['uniacid'],
                ':child_id' => $_GPC['children_id']
            );

            $projects = pdo_fetchall($sql,$params);
        }

        include $this->template('parent/zuopin');
    break;
    //成长记录页
    case 'record':
        //获取孩子信息
        $children = children($_GET['children_id']);

        //查看上了几节课
        $sql = "SELECT count(id) as class_count FROM " . tablename('qw_microedu_attendance') . " WHERE uniacid=:uniacid AND child_id=:child_id AND (status = 1 or status = 2 or status = 3)";
        $params = array(
            ':uniacid' => $_W['uniacid'], //微信公众平台的id
            ':child_id' => $_GET['children_id'] //手机号 mobile
        );
        $class = pdo_fetch($sql,$params);

        //查看成长记录
        $sql = "SELECT * FROM " . tablename('qw_microedu_timeline') . " WHERE uniacid=:uniacid AND child_id=:child_id order by timeline_date desc";
        $params = array(
            ':uniacid' => $_W['uniacid'], //微信公众平台的id
            ':child_id' => $_GET['children_id'] //手机号 mobile
        );
        $record = pdo_fetchall($sql,$params);

        include $this->template('parent/record');
    break;
    //消息中心页
    case 'zixun':
        $user = user();

        $sql = "SELECT * FROM "
        . tablename('qw_microedu_messages') .
        " WHERE from_user=:from_user AND to_user=:to_user AND uniacid=:uniacid ORDER BY sendtime DESC";
        $params = array(
            ':from_user' => '0',
            ':to_user' => $user['id'],
            ':uniacid' => $_W['uniacid']
        );
        $xitong = pdo_fetch($sql,$params);

        $sql = "SELECT u.avatar,u.id as uid,u.fullname,u.role_type,u.role_id FROM "
        . tablename('qw_microedu_messages') .
        " AS m LEFT JOIN "
        . tablename('qw_microedu_users') .
        " AS u ON m.from_user = u.id WHERE m.uniacid=:uniacid AND m.to_user=:to_user GROUP BY m.from_user ORDER BY MAX(m.sendtime) DESC";
        $params = array(
            ':uniacid' => $_W['uniacid'],
            ':to_user' => $user['id']
        );

        $xinxis = pdo_fetchall($sql,$params);

        include $this->template('parent/zixun');
    break;
    //系统通知页
    case 'tongzhi':
        $user = user();

        $sql = "SELECT * FROM "
            . tablename('qw_microedu_messages') .
            " WHERE from_user=:from_user AND to_user=:to_user AND uniacid=:uniacid ORDER BY sendtime ASC";
        $params = array(
            ':from_user' => '0',
            ':to_user' => $user['id'],
            ':uniacid' => $_W['uniacid']
        );
        $xinxis = pdo_fetchall($sql,$params);

        include $this->template('parent/tongzhi');
    break;
    //消息详情页
    case 'message':
        $user = user();
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

        include $this->template('parent/message');
    break;
    //合同管理列表页
    case 'hetong_list':
        $user = user();
        $sql = "SELECT s.id,c.contract_name FROM "
            .tablename('qw_microedu_parentscontracts').
            " as s LEFT JOIN "
            .tablename('qw_microedu_contracts').
            " as c on s.contract_id = c.id WHERE s.uniacid=:uniacid AND s.parent_id=:parent_id AND s.contract_enddate > :contract_enddate AND s.status in (1,2) GROUP BY s.contract_id ORDER BY s.id DESC";

        $params = array(
            ':uniacid' => $_W['uniacid'], //微信公众平台的id
            ':parent_id' => $user['id'], //家长id parent_id
            ':contract_enddate' => date('Y-m-d H:i:s') //结束时间 contract_enddate
        );
        $contracts = pdo_fetchall($sql,$params);

        include $this->template('parent/hetong_list');
    break;
    //合同管理页
    case 'hetong':
        $id = $_GPC['id'];

        if($id)
        {
            $user = user();
            $sql = "SELECT s.status,c.* FROM "
                .tablename('qw_microedu_parentscontracts').
                " as s LEFT JOIN "
                .tablename('qw_microedu_contracts').
                " as c on s.contract_id = c.id WHERE s.uniacid=:uniacid AND s.parent_id=:parent_id AND s.status in (1,2) AND s.id=:id";

            $params = array(
                ':uniacid' => $_W['uniacid'], //微信公众平台的id
                ':parent_id' => $user['id'], //家长id parent_id
                ':id' => $id //id
            );
            $contract = pdo_fetch($sql,$params);
        }
        else
        {
            message('未找到此合同', $this->createMobileUrl('parent', array('page'=>'index')), 'error');
        }

        include $this->template('parent/hetong');
    break;
    //订购合同页
    case 'dinggou':
        $yan = empty($_GPC['yan'])? '0' : '1' ;
        $user = user();
        if($yan)
        {
            $sql = "SELECT c.* FROM "
            . tablename('qw_microedu_parentscontracts') .
            " AS pc LEFT JOIN "
            . tablename('qw_microedu_contracts') .
            " AS c ON pc.contract_id=c.id WHERE pc.uniacid=:uniacid AND pc.parent_id=:parent_id AND pc.status=:status order by pc.id asc ";
            $params = array(
                ':uniacid' => $_W['uniacid'],
                ':parent_id' => $user['id'],
                ':status' => '1'
            );

            $contracts = pdo_fetchall($sql,$params);
        }
        else
        {
            $sql = "SELECT * FROM "
            . tablename('qw_microedu_contracts') .
            " WHERE uniacid=:uniacid ";

            $params = array(
                ':uniacid' => $_W['uniacid']
            );

            $contracts = pdo_fetchall($sql,$params);
        }

        foreach($contracts as $key => $value)
        {
            $sql = "SELECT cc.amount,c.classhour_name FROM "
            . tablename('qw_microedu_contractsclasshours') .
            " AS cc LEFT JOIN "
            . tablename('qw_microedu_classhours') .
            " AS c ON cc.classhour_id=c.id WHERE cc.uniacid=:uniacid AND cc.contract_id=:contract_id ORDER BY c.id ASC ";
            $params = array(
                ':uniacid' => $_W['uniacid'],
                ':contract_id' => $value['id']
            );

            $type = pdo_fetchall($sql,$params);

            $contracts[$key]['type'] = $type;
        }

        include $this->template('parent/dinggou');
    break;
    //已上课程页
    case 'finished':
        //查看上了几节课
        $sql = "SELECT count(id) as class_count FROM " . tablename('qw_microedu_attendance') . " WHERE uniacid=:uniacid AND child_id=:child_id AND status in (1,2,3)";
        $params = array(
            ':uniacid' => $_W['uniacid'], //微信公众平台的id
            ':child_id' => $_GET['children_id'] //手机号 mobile
        );
        $count = pdo_fetch($sql,$params);
        //如果count不大于0就不需要再次查询了
        if($count)
        {
            $sql = "SELECT c.class_name,s.timeslot,s.id,ca.name,s.classroom,u.fullname FROM "
                .tablename(qw_microedu_attendance).
                " as a LEFT JOIN "
                .tablename(qw_microedu_schedules).
                " as s on a.schedule_id=s.id LEFT JOIN "
                .tablename(qw_microedu_contractsclasses).
                " as c on s.contractclass_id=c.id LEFT JOIN "
                .tablename(qw_microedu_campuses).
                " as ca on s.campus_id=ca.id LEFT JOIN "
                .tablename(qw_microedu_users).
                " as u on s.tutor_id=u.role_id WHERE a.uniacid=:uniacid AND a.child_id=:child_id AND a.status in (1,2,3) AND u.role_type=:role_type order by s.timeslot desc";
            $params = array(
                ':uniacid' => $_W['uniacid'],
                ':child_id' => $_GPC['children_id'],
                ':role_type' => 'tutors'
            );

            $course = pdo_fetchall($sql,$params);
        }
        else
        {
            echo '暂时没上过课';die;
        }

        include $this->template('parent/finished');
    break;
    //剩余课程页
    case 'remainder':
        $user = user();

        $sql = "SELECT parentsremainingclasshours.amount FROM "
            .tablename('qw_microedu_parentscontracts').
            " as parentscontracts LEFT JOIN "
            .tablename('qw_microedu_parentsremainingclasshours').
            " as parentsremainingclasshours ON parentscontracts.id=parentsremainingclasshours.parentscontract_id WHERE parentscontracts.uniacid=:uniacid AND parentscontracts.parent_id=:parent_id";
        $params = array(
            ':uniacid' => $_W['uniacid'],
            ':parent_id' => $user['id']
        );
        $amount = pdo_fetchall($sql,$params);
        if($amount)
        {
            $classhour = 0;
            foreach($amount as $key => $value)
            {
                $classhour = $classhour + $value['amount'];
            }
        }
        else
        {
            $classhour = 0;
        }

        //查看上了几节课
        $sql = "SELECT count(id) as class_count FROM " . tablename('qw_microedu_attendance') . " WHERE uniacid=:uniacid AND child_id=:child_id AND status in (1,2,3)";
        $params = array(
            ':uniacid' => $_W['uniacid'], //微信公众平台的id
            ':child_id' => $_GET['children_id'] //手机号 mobile
        );
        $count = pdo_fetch($sql,$params);

        include $this->template('parent/remainder');
    break;
    //打卡记录页
    case 'signin':
        $children_id = $_GET['children_id'];
        $children = children($children_id);

        $year = date('Y');
        $years = array(
            $year.'-01',
            $year.'-02',
            $year.'-03',
            $year.'-04',
            $year.'-05',
            $year.'-06',
            $year.'-07',
            $year.'-08',
            $year.'-09',
            $year.'-10',
            $year.'-11',
            $year.'-12'
        );

        //如果没有传过来值 那就获取一下时间
        if($_GPC['time'])
        {
            $time_one = $_GPC['time'];
        }
        else
        {
            //获取本月时间
            $time_one = date('Y-m');
        }
        $time_two = date('Y-m-d H:i:s');

        $sql = "SELECT a.status,s.timeslot,c.class_name FROM "
            .tablename('qw_microedu_attendance').
            " as a LEFT JOIN "
            .tablename('qw_microedu_schedules').
            " as s ON a.schedule_id=s.id LEFT JOIN "
            .tablename('qw_microedu_contractsclasses').
            " as c ON s.contractclass_id=c.id WHERE a.child_id=:child_id AND a.uniacid=:uniacid AND s.timeslot >= :time_one AND s.timeslot < :time_two order by s.timeslot desc";

        $params = array(
            ':child_id' => $children_id,
            ':uniacid' => $_W['uniacid'],
            ':time_one' => $time_one,
            ':time_two' => $time_two
        );

        $punch_cards = pdo_fetchall($sql,$params);

        //查询早退等数量
        $sql = "SELECT count(a.status) as count FROM "
            .tablename('qw_microedu_attendance').
            " as a LEFT JOIN "
            .tablename('qw_microedu_schedules').
            " as s ON a.schedule_id=s.id WHERE a.child_id=:child_id AND a.uniacid=:uniacid AND s.timeslot >= :time_one AND s.timeslot < :time_two AND status=:status";
        //查询迟到
        $params = array(
            ':child_id' => $children_id,
            ':uniacid' => $_W['uniacid'],
            ':time_one' => $time_one,
            ':time_two' => $time_two,
            ':status' => 2
        );
        $chidao = pdo_fetch($sql,$params);
        //查询早退
        $params = array(
            ':child_id' => $children_id,
            ':uniacid' => $_W['uniacid'],
            ':time_one' => $time_one,
            ':time_two' => $time_two,
            ':status' => 3
        );
        $zaotui = pdo_fetch($sql,$params);
        //查询请假
        $params = array(
            ':child_id' => $children_id,
            ':uniacid' => $_W['uniacid'],
            ':time_one' => $time_one,
            ':time_two' => $time_two,
            ':status' => 4
        );
        $qingjia = pdo_fetch($sql,$params);

        include $this->template('parent/signin');
    break;
    //请假管理页
    case 'leave':
        //加时间判断
        $sql = "SELECT c.class_name,s.timeslot,s.id,ca.name,s.classroom,u.fullname,a.status,a.id FROM "
            .tablename(qw_microedu_attendance).
            " as a LEFT JOIN "
            .tablename(qw_microedu_schedules).
            " as s on a.schedule_id=s.id LEFT JOIN "
            .tablename(qw_microedu_contractsclasses).
            " as c on s.contractclass_id=c.id LEFT JOIN "
            .tablename(qw_microedu_campuses).
            " as ca on s.campus_id=ca.id LEFT JOIN "
            .tablename(qw_microedu_users).
            " as u on s.tutor_id=u.role_id WHERE a.uniacid = :uniacid AND a.child_id = :child_id AND u.role_type = :role_type AND s.timeslot >= :timeslot order by s.timeslot asc";
        $params = array(
            ':uniacid' => $_W['uniacid'],
            ':child_id' => $_GPC['children_id'],
            ':role_type' => 'tutors',
            ':timeslot' => date('Y-m-d H:i:s')
        );

        $classhours = pdo_fetchall($sql,$params);

        include $this->template('parent/leave');
    break;
    //老师评价页
    case 'evaluate':
        $children_id = $_GPC['children_id'];
        $sql = "SELECT u.fullname, t.comment, s.timeslot, co.class_name FROM "
            . tablename('qw_microedu_tutorcomments') .
            " AS t LEFT JOIN "
            . tablename('qw_microedu_users') .
            " AS u ON t.tutor_id=u.role_id LEFT JOIN "
            . tablename('qw_microedu_attendance') .
            " AS a ON t.attendance_id=a.id LEFT JOIN "
            . tablename('qw_microedu_schedules') .
            " AS s ON a.schedule_id=s.id LEFT JOIN "
            . tablename('qw_microedu_contractsclasses') .
            " AS co ON s.contractclass_id=co.id "
            ." WHERE t.uniacid=:uniacid AND a.child_id=:child_id AND u.role_type='tutors' ";

        $params = array(
            ':uniacid' => $_W['uniacid'],
            ':child_id' => $children_id,
        );

        $appraise = pdo_fetchall($sql,$params);

        include $this->template('parent/evaluate');
    break;
}

//action 程序处理部分
$action = $_GPC['action'];
switch ($action)
{
    //处理资料编辑
    case 'postSettings':
        postSettings();
    break;
    //处理子女资料添加
    case 'children_add':
        //获取家长信息
        $user = user();
        //传过来的孩子的信息
        $data = array(
            'uniacid' => $_W['uniacid'],//公众账号id uniacid
            'fullname' => $_GPC['name'],//姓名 fullname
            'gender' => $_GPC['sex'],//性别 gender
            'age' => $_GPC['age'],//年龄 age
            //'avatar' => $_GPC['avatar'],//头像 avatar
            'parent_id' => $user['role_id'],//用户组 parent_id
        );
        $file = "/addons/qw_microedu/assets/img/children";
        $picname = time().rand(100,200).".jpg";
        $data['avatar'] = getmedia($_GPC['loadsrc'],$file,$picname);
        //插入数据库
        if (pdo_insert("qw_microedu_children",$data))
        {
            //返回值
            echo json_encode(array('status' => 'success',));
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
    break;
    //处理子女资料编辑修改
    case 'children_edit':
        //传过来的孩子的信息
        $data = array(
            'fullname' => $_GPC['name'],//姓名 fullname
            'gender' => $_GPC['sex'],//性别 gender
            'age' => $_GPC['age'],//年龄 age
            //'avatar' => $_GPC['avatar'],//头像 avatar
        );
        $file = "/addons/qw_microedu/assets/img/children";
        $picname = time().rand(100,200).".jpg";
        $data['avatar'] = getmedia($_GPC['loadsrc'],$file,$picname);
        //修改数据
        if (!empty(pdo_update('qw_microedu_children', $data, array('id' => $_GPC['id'],'uniacid' => $_W['uniacid']))))
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
    break;
    //处理用户资料编辑修改
    case 'user_edit':
        $user = user();

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
    break;
    //验证手机号的 ajax one
    case 'ajax_mobile_one':
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
            //返回值
            echo json_encode(array(
                'status' => 'error',
            ));
            return false;
        }
    break;
    //验证手机号的 ajax two
    case 'ajax_mobile_two':
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
    break;
    //请假
    case 'leave':
        if($_GPC['id'])
        {
            $data = array(
                'status' => '4',
            );

            $where = array(
                'uniacid' => $_W['uniacid'],
                'id' => $_GPC['id']
            );

            if (!empty(pdo_update('qw_microedu_attendance', $data, $where)))
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
        else
        {
            //返回值
            echo json_encode(array(
                'status' => 'error',
            ));
            return false;
        }
    break;
    //取消请假
    case 'quxiao_leave':
        if($_GPC['id'])
        {
            $data = array(
                'status' => '0',
            );

            $where = array(
                'uniacid' => $_W['uniacid'],
                'id' => $_GPC['id']
            );

            if (!empty(pdo_update('qw_microedu_attendance', $data, $where)))
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
        else
        {
            //返回值
            echo json_encode(array(
                'status' => 'error',
            ));
            return false;
        }
    break;
    //暂停合同ajax
    case 'hetong_ajax_zanting':
        $id = $_GPC['id'];

        if($id)
        {
            $data = array(
                'contract_pausedate' => date('Y-m-d'),
                'status' => '2'
            );

            $where = array(
                'id' => $id,
                'uniacid' => $_W['uniacid']
            );

            if(!empty(pdo_update('qw_microedu_parentscontracts', $data, $where)))
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
        else
        {
            echo json_encode(array(
                'status' => 'error',
            ));
            return false;
        }
    break;
    //恢复合同ajax
    case 'hetong_ajax_huifu':
        $id = $_GPC['id'];
        if($id)
        {
            //需要调整

            $sql = "SELECT contract_enddate,contract_pausedate FROM " . tablename('qw_microedu_parentscontracts') . "WHERE uniacid=:uniacid AND id=:id";

            $params = array(
                ':uniacid' => $_W['uniacid'],
                ':id' => $id
            );

            $pausedate = pdo_fetch($sql,$params);

            $contract_enddate = strtotime($pausedate['contract_enddate']);
            $contract_pausedate = strtotime($pausedate['contract_pausedate']);

            $contract_enddate = date('Y-m-d',$contract_enddate + ($contract_enddate - $contract_pausedate));

            $data = array(
                'contract_enddate' => $contract_enddate,
                'status' => '1'
            );

            $where = array(
                'id' => $id,
                'uniacid' => $_W['uniacid']
            );

            if(!empty(pdo_update('qw_microedu_parentscontracts', $data, $where)))
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
        else
        {
            echo json_encode(array(
                'status' => 'error',
            ));
            return false;
        }
    break;
    //发送信息
    case 'send_message':
        $user = user();
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
    break;
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
        if($user['openid'])
        {
            return $user;die;
        }
        else
        {
            return '0';die;
        }
    }
    else
    {
        //没查到返回0
        return '0';die;
    }
}

//查询用户的方法
function user()
{
    global $_W;
    $sql = "SELECT * FROM " . tablename('qw_microedu_users') . " WHERE uniacid=:uniacid AND openid=:openid ";
    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':openid' => $_W['openid'],
    );

    return pdo_fetch($sql,$params);
}

//通过父级查询孩子的方法
function childrens($parent_id)
{
    global $_W;

    $sql = "SELECT * FROM " . tablename('qw_microedu_children') . " WHERE uniacid=:uniacid AND parent_id=:parent_id";
    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':parent_id' => $parent_id,
    );

    return pdo_fetchall($sql,$params);
}

//通过id查询孩子的方法
function children($id)
{
    global $_W;

    $sql = "SELECT * FROM " . tablename('qw_microedu_children') . " WHERE uniacid=:uniacid AND id=:id";
    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':id' => $id,
    );

    return pdo_fetch($sql,$params);
}

//资料编辑方法
function postSettings()
{
    global $_W, $_GPC;
    // 检查验证码
    if ($_GPC['captcha'] != '123456')
    {
        echo json_encode(array(
            'status' => 'failed',
            'message' => '验证码错误',
        ));
        return false;
    }

    //查询现在是否有这个潜在用户
    $where = array(
        'uniacid' => $_W['uniacid'],//公众账号id uniacid
        'mobile' => $_GPC['mobile'],//手机号 mobile
    );

    $user = pdo_get('qw_microedu_users', $where, array('id'));

    if(!empty($user))
    {
        $uid = $user['id'];
        $user_data = array(
            'openid' => $_W['openid'],//用户在微信的唯一id openid
            'created_at' => date('Y-m-d H:i:s') //创建时间 created_at
        );

        $result = pdo_update('qw_microedu_users', $user_data, array('id' => $uid));
        if (!empty($result))
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
    else
    {
        //查询现在是否有这个潜在用户
        $where = array(
            'uniacid' => $_W['uniacid'],//公众账号id uniacid
            'openid' => $_W['openid'],//手机号 mobile
        );

        $user_two = pdo_get('qw_microedu_users', $where, array('id'));
        if(!empty($user_two))
        {
            $user = $user_two;
            $uid = $user['id'];
            $user_data = array(
                'mobile' => $_GPC['mobile'],//手机号 mobile
                'created_at' => date('Y-m-d H:i:s') //创建时间 created_at
            );

            $result = pdo_update('qw_microedu_users', $user_data, array('id' => $uid));
            if (!empty($result))
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
        else
        {
            // 家长数据
            $user_data = array(
                'fullName' => $_GPC['fullName'],//性别 fullName
                'mobile' => $_GPC['mobile'],//手机号 mobile
                'gender' => $_GPC['gender'],//性别 gender
                'uniacid' => $_W['uniacid'],//公众账号id uniacid
                'openid' => $_W['openid'],//用户在微信的唯一id openid
                'created_at' => date('Y-m-d H:i:s'),//创建时间 created_at
                'role_type' => 'parents',//用户组 role_type
            );

            //插入数据库(users)
            if(pdo_insert('qw_microedu_users', $user_data))
            {
                $uid = pdo_insertid();
                //准备数据(patents)
                $parent_data = array(
                    'uniacid' => $_W['uniacid'],//公众账号id uniacid
                );

                //插入数据库(parents)
                if(pdo_insert('qw_microedu_parents', $parent_data))
                {
                    $parents_id = pdo_insertid();

                    $data = array(
                        'role_id' => $parents_id,
                    );

                    pdo_update('qw_microedu_users', $data, array('id' => $uid));

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
}

//保存微信音频/图片等
 function getmedia($media_id,$file,$picname){
     global $_GPC, $_W;
     load() -> classs('weixin.account');
     load() -> func('communication');
    $access_token = WeAccount::token();
    $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;
    if (!file_exists($file)) {
        mkdir($file, 0777, true);
    }
    $targetName = '..'.$file.'/'.$picname;
    $ch = curl_init($url); // 初始化
    $fp = fopen($targetName, 'wb'); // 打开写入
    curl_setopt($ch, CURLOPT_FILE, $fp); // 设置输出文件的位置，值是一个资源类型
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    return $file.'/'.$picname;
}
