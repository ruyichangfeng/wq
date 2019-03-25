<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
} 
class Xuan_js_user {
	public function getziliao($uid){
		global $_W;
		$sql = "SELECT * FROM " . tablename('xuan_js_ziliao') . " where uid=:uid";
        //获取点赞
        $count = pdo_fetch($sql, array('uid'=>$uid));
        return $count;
	}
	public function updateziliao($weixin,$phone){
		global $_W;
		$uidopenid=m('member')->get_uidopenid();
		$a=m('user')->getziliao($uidopenid['uid']);
		if ($a) {
			$id=$a['id'];
			$data = array(
	    		'weixin' => $weixin,
	    		'phone' => $phone
			);
			$result = pdo_update('xuan_js_ziliao', $data, array('id' => $id));
			return $result;
		}else{
			$data = array(
    		'weixin' => $weixin,
    		'phone' => $phone,
    		'uid'=>$uidopenid['uid']
			);
			$result = pdo_insert('xuan_js_ziliao', $data);
			return $result;
		}
		
	}


}