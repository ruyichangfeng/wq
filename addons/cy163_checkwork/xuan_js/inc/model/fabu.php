<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
} 
class Xuan_js_fabu {
   public function getlist($a=array()){ 
   		global $_W;
   		$fenlei2=$a['fenlei2'];//子分类
   		$order=$a['order'];//排序
   		$orderby=$a['orderby'];
   		$limit=$a['limit'];//分页
   		$like=$a['like']; //查询

   		$condition =  "and uniacid = :uniacid ";
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($fenlei2)) {
			$condition .=  " and fenlei2 = :fenlei2 ";
			$params[':fenlei2'] = $fenlei2;
		}
		if (!empty($like)) {
			$condition .= " AND (title LIKE '%{$like}%' or description LIKE '%{$like}%' )";
		}
		
		$sql = "SELECT * FROM " . tablename('xuan_js_fabu') . " where 1 {$condition} and shengyu !=0 and status >0 ORDER BY {$order} {$orderby} {$limit}";
		$list = pdo_fetchall($sql, $params);
		$uidopenid=m('member')->get_uidopenid();
		foreach ($list as $k => &$v) {
			$sql = "SELECT count(*) FROM " . tablename('xuan_js_zan') . " where fid=:fid";
			//获取点赞
			$count = pdo_fetchcolumn($sql, array('fid'=>$v['id']));
			$v['zan']=$count;
			$v['mezan']=m('member')->getzan($uidopenid['uid'],$v['id']);
			//获取用户头像
			$avatar=m('member')->getinfo($v['uid'],'avatar,gender,nickname');
			$v['sex']=$avatar['gender'];
			$v['nickname']=$avatar['nickname'];
			$v['avatar']=$avatar['avatar'];
			$v['createtime']=date("Y-m-d",$v['createtime']);
			//相册拆分
			$imgk=explode('@',$v['img']);
			if (count($imgk)-1>3) {
				$v['imgf'] = array_slice($imgk, 0, 3);
			}else{
				$v['imgf'] = array_slice($imgk, 0, count($imgk)-1);
			}
			

		}
		
		return $list;	
   }

   public function getonebyid($id){
   		global $_W;
   		$condition =  "and uniacid = :uniacid ";
		$params = array(':uniacid' => $_W['uniacid']);  

		if (!empty($id)) {
			$condition .=  " and id = :id ";
			$params[':id'] = $id;
		}

		$sql = "SELECT * FROM " . tablename('xuan_js_fabu') . " where 1 {$condition}";
		$list = pdo_fetch($sql, $params);
		
		
		return $list;	
   }
   /*
   * 获取某人所以发布列表
   */
   public function getalluid($uid){
   		global $_W;
   		$condition =  "and uniacid = :uniacid ";
		$params = array(':uniacid' => $_W['uniacid']);  

		if (!empty($uid)) {
			$condition .=  " and uid = :uid ";
			$params[':uid'] = $uid;
		}

		$sql = "SELECT * FROM " . tablename('xuan_js_fabu') . " where 1 {$condition} order by id desc";
		$list = pdo_fetchall($sql, $params);
		
		
		return $list;	
   }
}