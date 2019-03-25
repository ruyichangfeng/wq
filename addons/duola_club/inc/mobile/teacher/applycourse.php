<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$schoolid = intval($_GPC['schoolid']);
$openid = $_W['openid'];

//查询是否用户登录

$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where :schoolid = schoolid And :weid = weid And :openid = openid order By id DESC", array(
    ':weid' => $weid,
    ':schoolid' => $schoolid,
    ':openid'=> $openid
), 'id');
$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
$xueqi = $km = $districtCenter = $xq = $sd = $courseCats = $classSize = array();
foreach($category as $key => $value){
    switch($value['type']){
        case 'semester':
            $xueqi[] = $value;
            break;
        case 'subject':
            $km[] = $value;
            if($user['km_id1'] == $value['sid']){
                $user['km1_name'] = $value['sname'];
            }
            if($user['km_id2'] == $value['sid']){
                $user['km2_name'] = $value['sname'];
            }
            if($user['km_id3'] == $value['sid']){
                $user['km3_name'] = $value['sname'];
            }
            break;
        case 'districtCenter':
            $districtCenter[] = $value;
            if($user['district_center_id'] == $value['sid']){
                $user['centerName'] = $value['sname'];
            }
            break;
        case 'week':
            $xq[] = $value;
            break;
        case 'timeframe':
            $sd[] = $value;
            break;
        case 'courseClassification':
            $courseCats[] = $value;
            break;
        case 'classSize':
            $classSize[] = $value;
            break;
        default:
            break;
    }
}
$op = $_GPC['op'] ? $_GPC['op'] : 'display';
if($op == 'POST'){
    if (! $_GPC ['schoolid'] || ! $_W ['openid'] || !$_GPC['tid']) {
        die ( json_encode ( array (
            'result' => false,
            'msg' => '非法请求！'
        ) ) );
    }
    $data = array(
        'schoolid' => $schoolid,
        'weid' => $weid,
        'tid' => $_GPC['tid'],
        'name' => trim($_GPC['name']),
        'dagang' => trim($_GPC['dagang']),
        'start' => strtotime($_GPC['start']),
        'end' => strtotime($_GPC['end']),
        'district_center_id' => $_GPC['district_center_id'],
        'minge' => $_GPC['minge'],
        'cose' => $_GPC['cose'],
        'cose2' => $_GPC['cose2'],
        'cose3' => $_GPC['cose3'],
        'adrr' => trim($_GPC['addr']),
        'km_id' => $_GPC['km_id'],
        'is_show' => 0,
        'is_hot' => $_GPC['is_hot'],
        'is_weekend' => $_GPC['is_weekend'],
        'is_drop_in' => $_GPC['is_drop_in'],
        'class_hour' => $_GPC['class_hour'],
        'class_size' => $_GPC['class_size'],
        'class_describe' => $_GPC['class_size'],
        'is_welfare' => $_GPC['is_welfare'],
        'videostart' => $_GPC['videostart'],
        'videoend' => $_GPC['videoend'],
        'max_distance' => $_GPC['max_distance']
    );
    $res = pdo_insert($this->table_tcourse,$data);
    if(!empty($res)){
        die(json_encode(array('result' => true,'msg' => '申请成功!')));
    }else{
        die(json_encode(array('result' => false,'msg' => '申请失败!')));
    }
}else{
    include $this->template(''.$school['style3'].'/applycourse');
}
?>