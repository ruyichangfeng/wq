<?php
global $_W,$_GPC;

checkauth();
$uid = $_W['member']['uid'];

$sql = "SELECT id FROM ".tablename('intelligent_kindergarten_topic_read')." WHERE openid = :openid ";
$params = array(':openid'=>$_W['openid']);
$id = pdo_fetchcolumn($sql,$params);

if(empty($id)){
	$done = 0;
}else{
	$done = 1;
}

if($done) {
	$task['done'] = 1;//任务完成
	$task['result'] = '恭喜您已完成首次看帖任务';

} else {
	$url = murl('entry',array('m'=>'intelligent_kindergarten','do'=>'forum'));
	//任务完成向导
	$task['guide'] = '<ul class="list">
				<a class="item item-icon-right" href="'.$url.'">
					<h2>立即看帖</h2>
				</a>
			</ul>'; //指导用户如何参与任务的文字说明。支持html代码

}