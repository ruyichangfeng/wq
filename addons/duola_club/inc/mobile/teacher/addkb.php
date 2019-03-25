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
$course = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " where :schoolid = schoolid And :weid = weid And :id = id order By id DESC", array(
    ':weid' => $weid,
    ':schoolid' => $schoolid,
    ':id'=> $_GPC['kcid']
), 'id');
$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
$xueqi = $km = $districtCenter = $xq = $sd = $courseCats = $classSize = array();
$week = array();
foreach($category as $key => $value){
    switch($value['type']){
        case 'semester':
            $xueqi[] = $value;
            break;
        case 'subject':
            $km[] = $value;
            if($course['km_id'] == $value['sid']){
                $course['km_name'] = $value['sname'];
            }
            break;
        case 'districtCenter':
            $districtCenter[] = $value;
            break;
        case 'week':
            $xq[] = $value;
            switch($value['sname']){
                case "星期一":
                    $week[1] = $value['sid'];
                    break;
                case "星期二":
                    $week[2] = $value['sid'];
                    break;
                case "星期三":
                    $week[3] = $value['sid'];
                    break;
                case "星期四":
                    $week[4] = $value['sid'];
                    break;
                case "星期五":
                    $week[5] = $value['sid'];
                    break;
                case "星期六":
                    $week[6] = $value['sid'];
                    break;
                case "星期日":
                    $week[0] = $value['sid'];
                    break;
                default:
                    break;
            }
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
    if (! $_GPC ['schoolid'] || ! $_W ['openid'] || !$_GPC['kcid']) {
        die ( json_encode ( array (
            'result' => false,
            'msg' => '非法请求！'
        ) ) );
    }
   $kb =  pdo_fetch("SELECT coalesce((max(nub)+1),1) as nub  FROM " . tablename($this->table_kcbiao) . " where :schoolid = schoolid And :weid = weid And :kcid = kcid ", array(
        ':weid' => $weid,
        ':schoolid' => $schoolid,
        ':kcid'=> $_GPC['kcid']
    ));
    $data = array(
        'schoolid' => $schoolid,
        'weid' => $weid,
        'tid' => $_GPC['tid'],
        'kcid' => $_GPC['kcid'],
        'nub' => $kb['nub'],
        'km_id' => $_GPC['km_id'],
        'xq_id' => $week[date('w',strtotime($_GPC['date']))],
        'sd_id' => $_GPC['sd_id'],
        'date' => strtotime($_GPC['date']),
    );
    $res = pdo_insert($this->table_kcbiao,$data);
    if(!empty($res)){
        die(json_encode(array('result' => true,'msg' => '添加成功!')));
    }else{
        die(json_encode(array('result' => false,'msg' => '添加失败!')));
    }
}else{
    include $this->template(''.$school['style3'].'/addkb');
}
?>