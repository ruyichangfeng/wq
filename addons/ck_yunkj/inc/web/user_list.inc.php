<?php
/**
 * 模块微站定义
 *
 * @author wujinxin
 * @url http://bbs.we7.cc/
 **/
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

load()->func('tpl');
$op = $_GPC['op'];
$type = $_GPC['type'];

$urlt = $this->createWebUrl('user_list');

$newtimes = mktime();

//年
$yearhtml = '';
$nowy = date('Y',mktime());
$nowm = date('m',mktime());
for ($i=0; $i<50; $i++) {
	$they = $nowy - $i;
	$yearhtml .= "<option value=\"$they\">$they</option>";
}

//月
$monthhtml = '';
for ($i=1; $i<13; $i++) {
	$selectstr = $i == $nowm?' selected':'';
	$monthhtml .= "<option value=\"$i\" $selectstr >$i</option>";
}

$cwgl_config = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));

//导入-----------------------------
if(checksubmit('import_submit')){
	
	$filename = $_FILES['file']['tmp_name'];
	if (empty ($filename)) {
		message('请选择要导入的CSV文件！');
	}
	 
	$handle = fopen($filename, 'r');
	$result = input_csv($handle); //解析csv
	$len_result = count($result);
	if($len_result==0){
		message('抱歉！CSV文件没有任何数据！');
	}
	
	$data_values = '';
	for ($i = 1; $i < $len_result; $i++) { //循环获取各字段值
		
		$uid = iconv('gb2312','utf-8', $result[$i][1]);
		$message1 = iconv('gb2312','utf-8', $result[$i][5]);
		$message2 = iconv('gb2312','utf-8', $result[$i][6]);
		$message3 = iconv('gb2312','utf-8', $result[$i][7]);
		$message4 = iconv('gb2312','utf-8', $result[$i][8]);
		$message5 = iconv('gb2312','utf-8', $result[$i][9]);
		$message6 = iconv('gb2312','utf-8', $result[$i][10]);
		$message7 = iconv('gb2312','utf-8', $result[$i][11]);
		$message8 = iconv('gb2312','utf-8', $result[$i][12]);
		$message9 = iconv('gb2312','utf-8', $result[$i][13]);
		$message10 = iconv('gb2312','utf-8', $result[$i][14]);
		$message11 = iconv('gb2312','utf-8', $result[$i][15]);
		$message12 = iconv('gb2312','utf-8', $result[$i][16]);
		$message13 = iconv('gb2312','utf-8', $result[$i][17]);
		$message14 = iconv('gb2312','utf-8', $result[$i][18]);
		$message15 = iconv('gb2312','utf-8', $result[$i][19]);
		$message16 = iconv('gb2312','utf-8', $result[$i][20]);
		$message17 = iconv('gb2312','utf-8', $result[$i][21]);
		$message18 = iconv('gb2312','utf-8', $result[$i][22]);
		$message19 = iconv('gb2312','utf-8', $result[$i][23]);
		$message20 = iconv('gb2312','utf-8', $result[$i][24]);
		$message21 = iconv('gb2312','utf-8', $result[$i][25]);
		$message22 = iconv('gb2312','utf-8', $result[$i][26]);
		$message23 = iconv('gb2312','utf-8', $result[$i][27]);
		$message24 = iconv('gb2312','utf-8', $result[$i][28]);
		$message25 = iconv('gb2312','utf-8', $result[$i][29]);
		$message26 = iconv('gb2312','utf-8', $result[$i][30]);
		$message27 = iconv('gb2312','utf-8', $result[$i][31]);
		$message28 = iconv('gb2312','utf-8', $result[$i][32]);
		$message29 = iconv('gb2312','utf-8', $result[$i][33]);
		$message30 = iconv('gb2312','utf-8', $result[$i][44]);
		$dateline = mktime();
		
		$srdbkk = pdo_get('cwgl_user_report', array('years' => $_GPC['years'],'month' => $_GPC['month'],'weid' => $_W['uniacid'],'uid' => $uid));
		if(empty($srdbkk['id'])){
		
			$resultp = pdo_insert('cwgl_user_report', array('uid' => $uid,'weid' => $_W['uniacid'],'deadline' => $dateline,'years' => $_GPC['years'],'month' => $_GPC['month'],'message1' => $message1,'message2' => $message2,'message3' => $message3,'message4' => $message4,'message5' => $message5,'message6' => $message6,'message7' => $message7,'message8' => $message8,'message9' => $message9,'message10' => $message10,'message11' => $message11,'message12' => $message12,'message13' => $message13,'message14' => $message14,'message15' => $message15,'message16' => $message16,'message17' => $message17,'message18' => $message18,'message19' => $message19,'message20' => $message20,'message21' => $message21,'message22' => $message22,'message23' => $message23,'message24' => $message24,'message25' => $message25,'message26' => $message26,'message27' => $message27,'message28' => $message28,'message29' => $message29,'message30' => $message30), true);
			
		}else{
		
			$resultp = pdo_query("UPDATE ".tablename('cwgl_user_report')." SET message1='{$message1}',message2='{$message2}',message3='{$message3}',message4='{$message4}',message5='{$message5}',message6='{$message6}',message7='{$message7}',message8='{$message8}',message9='{$message9}',message10='{$message10}',message11='{$message11}',message12='{$message12}',message13='{$message13}',message14='{$message14}',message15='{$message15}',message16='{$message16}',message17='{$message17}',message18='{$message18}',message19='{$message19}',message20='{$message20}',message21='{$message21}',message22='{$message22}',message23='{$message23}',message24='{$message24}',message25='{$message25}',message26='{$message26}',message27='{$message27}',message28='{$message28}',message29='{$message29}',message30='{$message30}' WHERE weid = '{$_W['uniacid']}' and uid = '{$uid}' and id = '".$srdbkk['id']."'");
			
		}
	
	}
	
	if($resultp){
		message('导入成功！', $urlt, 5);
	}else{
		message('导入失败！', $urlt, 5);
	}
	
}

function input_csv($handle) {
	$out = array ();
	$n = 0;
	while ($data = fgetcsv($handle, 10000)) {
		$num = count($data);
		for ($i = 0; $i < $num; $i++) {
			$out[$n][$i] = $data[$i];
		}
		$n++;
	}
	return $out;
}//-----------------------------------------

//保存报表参数
if(checksubmit('parameter_submit')){
	
	$data = array(
		'a1' => $_GPC['a1'],
		'a2' => $_GPC['a2'],
		'a3' => $_GPC['a3'],
		'a4' => $_GPC['a4'],
		'a5' => $_GPC['a5'],
		'a6' => $_GPC['a6'],
		'a7' => $_GPC['a7'],
		'a8' => $_GPC['a8'],
		'a9' => $_GPC['a9'],
		'a10' => $_GPC['a10'],
		'a11' => $_GPC['a11'],
		'a12' => $_GPC['a12'],
		'a13' => $_GPC['a13'],
		'a14' => $_GPC['a14'],
		'a15' => $_GPC['a15'],
		'a16' => $_GPC['a16'],
		'a17' => $_GPC['a17'],
		'a18' => $_GPC['a18'],
		'a19' => $_GPC['a19'],
		'a20' => $_GPC['a20'],
		'a21' => $_GPC['a21'],
		'a22' => $_GPC['a22'],
		'a23' => $_GPC['a23'],
		'a24' => $_GPC['a24'],
		'a25' => $_GPC['a25'],
		'a26' => $_GPC['a26'],
		'a27' => $_GPC['a27'],
		'a28' => $_GPC['a28'],
		'a29' => $_GPC['a29'],
		'a30' => $_GPC['a30']
	);
	
	if($_GPC['type']){
		$data['weid'] = $_W['uniacid'];
		$result = pdo_insert('cwgl_config', $data);
	}else{
		pdo_update('cwgl_config', $data, array('weid' => $_W['uniacid']));
	}
	
	message('保存成功！', $urlt, 'success');
		
}

//修改
if(checksubmit('edit_submit')){
	
	$data = array(
		'name' => $_GPC['name'],
		'phone' => $_GPC['phone'],
		'compname' => $_GPC['compname'],
		'message' => $_GPC['message'],
		'payfees' => $_GPC['payfees'],
		'type' => $_GPC['type']
	);
	
	//注册会员期限
	if($_GPC['monthadd']){
		$data['deadline'] =  $_GPC['monthadd']*2592000 + $newtimes;
	}
	
	//保存头像-----------
	if($_GPC['uid'] && $_GPC['avatar']){
		pdo_update('mc_members', array('avatar' => $_GPC['avatar'],'uid' => $_GPC['uid']), array('uniacid' => $_W['uniacid'],'uid' => $_GPC['uid']));
	}//------------------
	
	//修改
	if(!empty($_GPC['id'])){
		
		pdo_update('cwgl_user_list', $data, array('id' => $_GPC['id'],'weid' => $_W['uniacid']));
		message('修改成功！', $urlt, 'success');
		
	}else{
		message('修改失败！');
	}
	
}

//读取报表参数--------
if($op == 'parameter'){
	$srdb = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));
	if (empty($srdb)) {
		$type = 1;
	}
}//------------------

//读取
if($op == 'edit'){
	
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_user_list', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urlt, 'success');
	}
	
	$usershow = pdo_get('mc_members', array('uid' => $srdb['uid']));
	
	//领取会员信息
	$staff_show = pdo_get('cwgl_staff_list', array('id' => $srdb['ygid']));
	
	//获取头像
	$usershow1 = pdo_get('mc_members', array('uid' => $srdb['yguid']));
}

//删除---------------
if($op == 'delete'){
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_user_list', array('id' => $id));
		message('删除成功', $urlt, 'success');
	}else{
		message('删除失败', $urlt, 'success');
	}
}

//列表-------------------------
//排序
$ordersc = array($_GPC['ordersc']=>' selected');
if($_GPC['ordersc']){
	$ordersql = "ORDER BY b.id ".$_GPC['ordersc'];
}else{
	$ordersql = "ORDER BY b.id DESC";
}

$pindex = max(1, intval($_GPC['page']));
$psize = empty($_GPC['psize'])?0:intval($_GPC['psize']);
if(!in_array($psize, array(20,50,100))) $psize = 20;
$perpages = array($psize => ' selected');

$where = '';

if (!empty($_GPC['uid'])) {
	$where .= " AND b.uid = ".intval($_GPC['uid']);
}

if (!empty($_GPC['nickname'])) {
	$where .= " AND a.nickname LIKE '%{$_GPC['nickname']}%'";
}

if (!empty($_GPC['name'])) {
	$where .= " AND b.name LIKE '%{$_GPC['name']}%'";
}

if (!empty($_GPC['phone'])) {
	$where .= " AND b.phone LIKE '%{$_GPC['phone']}%'";
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('mc_members')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid  WHERE b.weid = '{$_W['uniacid']}' AND b.type = '1' {$where}");
if($total){
	$list = pdo_fetchall("SELECT a.avatar,a.nickname,b.* FROM ".tablename('mc_members')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid  WHERE b.weid = '{$_W['uniacid']}' AND b.type = '1' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	foreach ($list as &$row) {

		if($newtimes < $row['deadline']){
			$end_famate_time = $row['deadline']; //结束时间转化为时间戳
			$now_time = $newtimes;
	
			$remain_time = $end_famate_time-$now_time; //剩余的秒数
			$remain_date = floor($remain_time/(3600*24)); //剩余的小时
			$remain_hour = floor(($remain_time - $remain_date*3600*24)/(60*60)); //剩余的小时
			$remain_minute = floor(($remain_time - $remain_date*3600*24 - $remain_hour*60*60)/60); //剩余的分钟数
			$remain_second = ($remain_time - $remain_date*3600*24 - $remain_hour*60*60 - $remain_minute*60); //剩余的秒数
			
			if($remain_date > 0){
				$row['status'] = "剩余：".$remain_date."天";
			}elseif($remain_hour > 0){
				$row['status'] = "剩余：".$remain_hour."小时";
			}elseif($remain_minute > 0){
				$row['status'] = "剩余：".$remain_minute."分";
			}elseif($remain_second > 0){
				$row['status'] = "剩余：".$remain_second."秒";
			}
			
		}else{
			$row['status'] =  "<font color=\"#CC0000\">服务已到期</font>";
		}
		
	}
}
$pager = pagination($total, $pindex, $psize);

include $this->template('user_list');
?>