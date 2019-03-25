<?php 
class Topic extends ZskWxapp{
 	 
 	public function getTopic(){ 
		global $_W,$_GPC;
		$model=Model("topic");
		$uniacid=intval($_W['uniacid']);

		$tid=intval($_GPC['tid']);
		$topic=$model->where("uniacid=$uniacid and id=$tid")->get();
		$topic['content']=($topic['content']);
		$topic['datetime']=date("Y-m-d H:i",$topic['date']);
		$shop=$this->getShopByID($topic['shopid']);
		echo JSON_OUT(array("topic"=>$topic,"shop"=>$shop));
	}
	
}
	 