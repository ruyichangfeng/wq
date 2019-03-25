<?php
/**
 * Created by IntelliJ IDEA.
 * User: wanglu
 * Date: 2017/8/6
 * Time: 14:55
 */
/**
 * Created by wanglu on 2017/8/6.
 */
defined('IN_IA') or exit('Access Denied');
$where = ' weid =:weid';
$params = array();
$params[':weid'] = $this->weid;

$redid = $_GPC['redid'];
$uid = $_GPC['uid'];
$red = DBUtil::findById(DBUtil::$TABLE_URLREDIRECT, $redid);
$red_url = DBUtil::findById(DBUtil::$TABLE_URLREDIRECT_URL, $uid);

$where.= " and redid=:redid and uid=:uid";
$params[':redid'] = $redid;
$params[':uid'] = $uid;

$tj = $_GPC['tj'];

if (empty($tj)) {
    $tj = 1;
}


switch($tj) {
    case 1:
        $tjtitle = '近24小时访问统计';
        $sql = "select FROM_UNIXTIME(createtime,'%Y-%m-%d-%H:00:00') mtime, count(id) vcount from ".tablename(DBUtil::$TABLE_URLREDIRECT_RECORD)."
         where ".$where." group by mtime limit 0, 24";
        break;
    case 2:
        $tjtitle = '近7日访问统计';
        $sql = "select FROM_UNIXTIME(createtime,'%Y-%m-%d') mtime, count(id) vcount from ".tablename(DBUtil::$TABLE_URLREDIRECT_RECORD)."
       where ".$where." group by mtime limit 0, 7";
        break;
    case 3:
        $tjtitle = '近2周访问统计';
        $sql = "select FROM_UNIXTIME(createtime,'%Y-%m-%d') mtime, count(id) vcount from ".tablename(DBUtil::$TABLE_URLREDIRECT_RECORD)."
where ".$where." group by mtime limit 0, 14";
        break;
    case 4:
        $tjtitle = '近一个月访问统计';
        $sql = "select FROM_UNIXTIME(createtime,'%Y-%m-%d') mtime, count(id) vcount from ".tablename(DBUtil::$TABLE_URLREDIRECT_RECORD)."
where ".$where." group by mtime limit 0, 30";
        break;
}

$time_data = pdo_fetchall($sql, $params);




$time_str="[";
$time_count_str="[";
$index=0;
    foreach($time_data as $value){
        $time_str.="'".$value['mtime']."'";
        $time_count_str.=$value['vcount'];
        if($index<count($time_data)-1){
            $time_str.=",";
            $time_count_str.=",";
        }
        $index++;
    }

$time_str.="]";
$time_count_str.="]";

include $this->template("web/tj_chart");
