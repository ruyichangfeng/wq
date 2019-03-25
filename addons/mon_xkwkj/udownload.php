<?php
if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');
global $_GPC,$_W;
$kid= intval($_GPC['kid']);
if(empty($kid)){
    message('抱歉，传递的参数错误！','', 'error');              
}

$xkwkj=DBUtil::findById(DBUtil::$TABLE_XKWKJ,$kid);

$dc = $_GPC['dc'];
$list = pdo_fetchall("SELECT u.*,u.createtime as utime, ui.uname as uname, ui.tel as tel FROM " . tablename(DBUtil::$TABLE_XKWKJ_USER) . " u left join
".tablename(DBUtil::$TABLE_XKWKJ_USER_INFO)." ui on ui.openid= u.openid
WHERE u.kid =:kid  and ui.weid={$this->weid} ORDER BY utime  DESC ", array(":kid"=>$kid));


$title = array(
	'openID',
	'昵称',
	'注册姓名',
	'注册手机号',
	'砍后价格',
	'参加时间'
);

$arraydata[] = iconv("UTF-8","GB2312//IGNORE", implode("\t", $title )) ;


$html .= "\n";
foreach ($list as $value) {

	$tmp_value =  array(
		$value['openid'],
		$value['nickname'],
		$value['uname'],
		$value["tel"],
		$value["price"],
		date('Y-m-d H:i',$value['utime'])
	);

	$html .= ($value['createtime'] == 0 ? '' : date('Y-m-d H:i',$value['createtime'])) . "\n";
	$arraydata[] = iconv("UTF-8","GB2312//IGNORE", implode("\t", $tmp_value )) ;

}

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/vnd.ms-execl");
header("Content-Type: application/force-download");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=".$xkwkj['title']." 参加用户数据.xls");
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 0");
echo  implode("\t\n",$arraydata);
exit();
