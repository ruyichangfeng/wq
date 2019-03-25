<?php
/**
 * 模块微站定义
 *
 * @author wujinxin
 * @url http://bbs.we7.cc/
 **/
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

$srdb = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));

//导出CSV
$str = "Id\tUID\t".iconv('utf-8','gb2312','公司名称')."\t".iconv('utf-8','gb2312','联系人')."\t".iconv('utf-8','gb2312','联系电话').
"\t".iconv('utf-8','gb2312', $srdb['a1']).
"\t".iconv('utf-8','gb2312', $srdb['a2']).
"\t".iconv('utf-8','gb2312', $srdb['a3']).
"\t".iconv('utf-8','gb2312', $srdb['a4']).
"\t".iconv('utf-8','gb2312', $srdb['a5']).
"\t".iconv('utf-8','gb2312', $srdb['a6']).
"\t".iconv('utf-8','gb2312', $srdb['a7']).
"\t".iconv('utf-8','gb2312', $srdb['a8']).
"\t".iconv('utf-8','gb2312', $srdb['a9']).
"\t".iconv('utf-8','gb2312', $srdb['a10']).
"\t".iconv('utf-8','gb2312', $srdb['a11']).
"\t".iconv('utf-8','gb2312', $srdb['a12']).
"\t".iconv('utf-8','gb2312', $srdb['a13']).
"\t".iconv('utf-8','gb2312', $srdb['a14']).
"\t".iconv('utf-8','gb2312', $srdb['a15']).
"\t".iconv('utf-8','gb2312', $srdb['a16']).
"\t".iconv('utf-8','gb2312', $srdb['a17']).
"\t".iconv('utf-8','gb2312', $srdb['a18']).
"\t".iconv('utf-8','gb2312', $srdb['a19']).
"\t".iconv('utf-8','gb2312', $srdb['a20']).
"\t".iconv('utf-8','gb2312', $srdb['a21']).
"\t".iconv('utf-8','gb2312', $srdb['a22']).
"\t".iconv('utf-8','gb2312', $srdb['a23']).
"\t".iconv('utf-8','gb2312', $srdb['a24']).
"\t".iconv('utf-8','gb2312', $srdb['a25']).
"\t".iconv('utf-8','gb2312', $srdb['a26']).
"\t".iconv('utf-8','gb2312', $srdb['a27']).
"\t".iconv('utf-8','gb2312', $srdb['a28']).
"\t".iconv('utf-8','gb2312', $srdb['a29']).
"\t".iconv('utf-8','gb2312', $srdb['a30']).
"\n";

$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_user_list')." WHERE weid = '{$_W['uniacid']}' AND type = '1' ORDER BY id ASC ");
foreach ($list as &$row) {
	$str .= $row['id']."\t".$row['uid']."\t".iconv('utf-8','gb2312', $row['compname'])."\t".iconv('utf-8','gb2312', $row['name'])."\t".$row['phone']."\t\t\t\t\t\t\t\t\t\t\n";
}

$filename = "客户列表_".date('Ymd').'.xls';
export_csv($filename,$str);


//导出
function export_csv($filename,$data) {
	
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Content-Type:application/force-download');
	header('Content-Type:application/vnd.ms-execl');
	header('Content-Type:application/octet-stream');
	header('Content-Type:application/download');
	header("Content-Disposition:attachment;filename=".$filename);
	header('Content-Transfer-Encoding:binary');
	
    echo $data;
}
?>