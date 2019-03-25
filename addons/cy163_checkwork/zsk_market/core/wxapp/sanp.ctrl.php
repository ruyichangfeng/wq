<?php
class Sanp extends ZskPage
{ 
 	public function index(){
 		global $_GPC,$_W;
 		$model = Model("activities");
 		$a = $model->tablename("snapup");
 		$b = $model->tablename("activities");
 		$c = $model->tablename("goods");
 		$sql = "SELECT $a.*,$b.id as aid ,$b.shopid,$b.goodsid,$b.goodsnum,$b.activityid,$c.price,$c.picture,$c.name FROM $a INNER JOIN $b ON $a.id = $b.activityid INNER JOIN $c ON $b.goodsid = $c.id WHERE $a.starttime <".time()." and $a.endtime>".time()." and $b.goodsnum>0 and $b.judgeid=1 and $a.uniacid=".$_W['uniacid'];
 		$data=$model->query($sql);
 		$indexdata = array();
 		foreach ($data as $v) {
 			$v['picture'] = $_W['attachurl'].$v['picture'];
 			$indexdata[] = $v;

 		}
 		echo JSON_OUT($indexdata);
 	}
 	//品牌查询一元抢购
 	public function selectband(){
 		global $_GPC,$_W;
 		$bandid = $_GPC['brandid'];
 		$model = Model("activities");
 		$a = $model->tablename("snapup");
 		$b = $model->tablename("activities");
 		$c = $model->tablename("goods");
 		if($bandid=="all"){
 			$where = " ";
 		}else{
 			$where = " and $c.brandid=".$bandid;
 		}
 		$sql = "SELECT $a.*,$b.id as aid ,$b.shopid,$b.goodsid,$b.goodsnum,$b.activityid,$c.price,$c.picture,$c.name FROM $a INNER JOIN $b ON $a.id = $b.activityid INNER JOIN $c ON $b.goodsid = $c.id WHERE $a.starttime <".time()." and $a.endtime>".time()." and $b.judgeid=1 and $a.uniacid=".$_W['uniacid']." and $b.judgeid=1".$where;
 		$data=$model->query($sql);
 		if($data){
 			$indexdata = array();
	 		foreach ($data as $v) {
	 			$v['picture'] = $_W['attachurl'].$v['picture'];
	 			$indexdata[] = $v;

	 		}
 		}
 		echo JSON_OUT($indexdata);
 	}
 	//获取分类  仅有商品
 	public function selectcate(){
 		global $_GPC,$_W;
 		// $model=Model("category");
 		// $res = $model->where("parentid>0 and uniacid=".$_W['uniacid'])->getall();
		$model=Model("shop");
		$uniacid=intval($_W['uniacid']);
		$tab0=$model->tablename("category");
		$tab1=$model->tablename("goods");
		$tab2 = $model->tablename("snapup");
		$tab3 = $model->tablename("activities");
		$sql="SELECT $tab0.id,$tab0.name,$tab0.logo FROM $tab3 INNER JOIN $tab2 ON $tab2.id=$tab3.activityid INNER JOIN $tab1 ON $tab3.goodsid = $tab1.id INNER JOIN $tab0 ON $tab0.id=$tab1.cateid  WHERE $tab2.starttime<".time()." and $tab2.endtime>".time()." and $tab0.parentid>0 and $tab0.status>0 AND $tab1.status>0 group by $tab1.cateid ";
		// $sql="SELECT $tab0.id,$tab0.name,$tab0.logo FROM $tab1 INNER JOIN $tab0 ON $tab0.id=$tab1.cateid INNER JOIN $tab3 ON $tab3.goodsid = $tab1.id INNER JOIN $tab2 ON $tab2.id = $tab3.activityid  WHERE $tab2.starttime<".time()." and $tab2.endtime>".time()." and $tab0.parentid>0 and $tab0.status>0 AND $tab1.status>0 group by $tab1.cateid ";
		$res=$model->query($sql); 
 		$indexdata = array();
 		foreach ($res as $v) {
 			$v['logo'] = $_W['attachurl'].$v['logo'];
 			$indexdata[] = $v;

 		}
 		echo JSON_OUT($indexdata);
 	}
 	//获取分类商品
 	public function cateselectshop(){
 		global $_GPC,$_W;
 		$cateid = $_GPC['cateid'];
 		$model = Model("activities");
 		$a = $model->tablename("snapup");
 		$b = $model->tablename("activities");
 		$c = $model->tablename("goods");
 		$sql = "SELECT $a.*,$b.id as aid ,$b.shopid,$b.goodsid,$b.goodsnum,$b.activityid,$c.price,$c.picture,$c.name FROM $a INNER JOIN $b ON $a.id = $b.activityid INNER JOIN $c ON $b.goodsid = $c.id WHERE $a.starttime <".time()." and $b.judgeid=1 and $a.endtime>".time()." and $a.uniacid=".$_W['uniacid']." and $c.cateid=".$cateid;
 		$data=$model->query($sql);
 		if($data){
 			$indexdata = array();
	 		foreach ($data as $v) {
	 			$v['picture'] = $_W['attachurl'].$v['picture'];
	 			$indexdata[] = $v;

	 		}
 		}
 		echo JSON_OUT($indexdata);
 	}
 	//搜索商品
 	public function selectgoods(){
		global $_GPC,$_W;
 		$name = $_GPC['name'];
 		$model = Model("activities");
 		$a = $model->tablename("snapup");
 		$b = $model->tablename("activities");
 		$c = $model->tablename("goods");
 		$sql = "SELECT $a.*,$b.id as aid ,$b.shopid,$b.goodsid,$b.goodsnum,$b.activityid,$c.price,$c.picture,$c.name FROM $a INNER JOIN $b ON $a.id = $b.activityid INNER JOIN $c ON $b.goodsid = $c.id WHERE $a.starttime <".time()." and $b.judgeid=1 and $a.endtime>".time()." and $a.uniacid=".$_W['uniacid']." and $c.name like '%".$name."%'";
 		$data=$model->query($sql);
 		if($data){
 			$indexdata = array();
	 		foreach ($data as $v) {
	 			$v['picture'] = $_W['attachurl'].$v['picture'];
	 			$indexdata[] = $v;

	 		}
 		}
 		echo JSON_OUT($indexdata);
 	}
}