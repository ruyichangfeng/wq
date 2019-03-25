 <?php
 //好像也是已经废弃了的
 class Topic extends ZskPage
 { 
 	public function index(){ 
 		$this->listview();
 	}
 	public function listview(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("topic"); 
 		$shopid=getShopID();
 		$topics=$model->where("uniacid=$uniacid and shopid=$shopid")->getall();

 		include $this->template("web/activity/topic-list");
 	}
 	public function save(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$model=Model("topic");
 		$topic=array(
 			"shopid"=>getShopID(),
 			"uniacid"=>$uniacid,
 			"content"=>$_GPC['content'],
 			"title"=>$_GPC['title'],
 			"date"=>time(),
 			"picture_cover"=>$_GPC['picture_cover']
 		);
 		$tid=intval($_GPC['tid']);
 		if($tid>0){
 			$model->where("uniacid=$uniacid and id=$tid")->save($topic);
 		}else{
 			$model->add($topic);
 		}
 		message("保存成功",$this->routeUrl("topic.listview"));
		exit;
	}
	
	public function editview(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("topic"); 
 		$tid=intval($_GPC['tid']);
 		$topic=$model->where("uniacid=$uniacid and id=$tid")->get();
		include $this->template("web/activity/topic-edit");
		exit;
	}
	public function deltopic(){ 
  		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
  		$model=Model("topic");
		$res= $model->delete("id=".intval($_GPC['tid'])." and uniacid=".intval($_W['uniacid']));
		 
		if($res>0){
			message("删除成功",$this->routeUrl("topic.listview"));
		}else{
			message("删除失败");
		}
	}
	public function getGoodsInfo(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
  		$model=Model("goods");
  		$goods=$model->where("number='".$_GPC['number']."'")->get();
  		if(!empty($goods)){
  			$goods['src']=str_replace("http://", "https://", $_W['attachurl']).$goods['picture'];
  		}
  		echo JSON_OUT($goods,true);
	}
}