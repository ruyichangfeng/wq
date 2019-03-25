<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W ['uniacid'];
$schoolid = intval($_GPC['schoolid']);
$openid = $_W['openid'];

if (!empty($_GPC['userid'])){
    $_SESSION['user'] = $_GPC['userid'];
}

$it = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where openid = :openid ", array(':openid' => $openid));

$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));

$kb = pdo_fetch("SELECT * FROM " . tablename($this->table_kcbiao) . " where id = :id ", array(':id' => $_GPC['kbid']));

$flow  = pdo_fetch("SELECT * FROM " . tablename($this->table_flow) . " where id = :id ", array(':id' => $_GPC['flowid']));

$op = $_GPC ['op'] == 'POST' ? $_GPC ['op'] : 'display';
if($op == 'POST'){
    if(!empty($kb)){

        if(date('Y-m-d') != date('Y-m-d',$kb['date'])){
            die(json_encode(array('result' => false,'msg' => '请注意本节课日期,目前不能签到!')));
        }
        if($kb['status'] == 2){
            die(json_encode(array('result' => false,'msg' => '本节课已完成考勤!')));
        }
        //检查是够已经签到
        $checkLog = pdo_fetch("SELECT * FROM " . tablename($this->table_newchecklog) . " where flowid = :flowid And schoolid = :schoolid And weid = :weid And kbid = :kbid", array(':flowid' => $_GPC['flowid'],':schoolid' => $schoolid,':weid' => $weid,':kbid' => $_GPC['kbid']));
        if($checkLog){
            die(json_encode(array('result' => false,'msg' => '当前环节已经考勤完毕,不可重复!')));
        }
        //log插入数据
        $data = array(
            'weid' =>  $weid,
            'schoolid' => $_GPC ['schoolid'],
            'tid' => $_GPC ['tid'],
            'sid' => $_GPC ['sid'],
            'flowid' => $_GPC ['flowid'],
            'kbid'  => $_GPC['kbid'],
            'content' => trim($_GPC ['content']),
            'pic' => trim($_GPC['pic']),
            'createtime' => time(),
        );
        $in_result = pdo_insert($this->table_newchecklog,$data);
        //更新数据
        if(!empty($in_result)){
            $nextFlow = pdo_fetch("SELECT * FROM " . tablename($this->table_flow) . " where parentid = :id ", array(':id' => $_GPC['flowid']));

            if($flow['nodeType'] == 3){
                //如果流程结束则更新为考勤完毕
                $updateData = array(
                    'status' => 2
                );
            }else{
                $updateData = array(
                    'flow_id' => $nextFlow['id'],
                    'status' => 1
                );
            }
            $u_result = pdo_update($this->table_kcbiao,$updateData,array('id' => $_GPC['kbid']));
            if(!empty($u_result)){
                if($flow['picType'] == 1 && !empty($_GPC ['sid'])){
                    //更新成功,如果是学生考勤,则微信通知

                }
                die(json_encode(
                    array(
                        'result' => true,
                        'msg'    => '更新成功'
                    )
                ));
            }
        }
        die(json_encode(
            array(
                'result' => false,
                'msg'    => '更新失败'
            )
        ));
    }else{
        die(json_encode(
            array(
                'result' => false,
                'msg'    => '未查询到课表'
            )
        ));
    }
}else{
    //获取学生list
    $students = pdo_fetchall("SELECT sorder.sid,student.s_name FROM " . tablename($this->table_order) . " sorder left join ".tablename($this->table_students)." student on sorder.sid = student.id
    where sorder.weid = :weid And sorder.schoolid = :schoolid And sorder.kcid = :kcid And sorder.status = :status ", array(':weid' => $weid,':schoolid' => $schoolid,':kcid' => $kb['kcid'],':status' => 2));
//    $students = array(
//        array('name' => 'test1','id'=> 11),
//        array('name' => 'test2','id' => 22),
//        array('name' => 'test3','id' => 33),
//        array('name' => 'test4','id' => 44),
//    );
    include $this->template(''.$school['style3'].'/newchecklog');
}

?>