<?php 
class Find extends ZskWxapp{
	//加载发现文章
 	public function loadFind(){
 		global $_W,$_GPC;
		$model=Model("find");
		$uniacid=intval($_W['uniacid']);  
		$tab0=$model->tablename("find");
		$tab1=$model->tablename("member");
		$now=date("Y-m-d H:i:s",time());
		$sql="SELECT $tab0.id,$tab0.type,$tab0.pictures,$tab0.picture,$tab0.goodsid,$tab0.openid,$tab0.shopid,$tab0.uniacid,$tab0.content,$tab0.count_good,$tab0.count_comment,$tab0.count_read,$tab0.count_good0,$tab0.count_read0,$tab0.createtime,LEFT ($tab0.createtime,10) as `datetime`,$tab1.nickname,$tab1.avatar FROM $tab0 LEFT JOIN $tab1 ON $tab0.openid=$tab1.openid WHERE $tab0.uniacid=$uniacid and $tab0.status=1 and $tab0.createtime<'".$now."'ORDER BY $tab0.`createtime` desc ";

		$arts=$model->pagenation($sql);
		$arts['attachurl']=$_W['attachurl']; 
		$ids=""; 
	 	$shops=getShops($arts['dataset']);
		foreach ($arts['dataset'] as $key => $val) { 
			if(strlen($val['pictures'])>5){
				//图片通过英文逗号分隔出来
				$arts['dataset'][$key]['pictures']=explode(",",$val['pictures']);
			} 
			foreach ($shops as $k => $v) {
				if(intval($v['id'])==intval($val['shopid'])){
					$arts['dataset'][$key]['logo']=$v['logo'];
					$arts['dataset'][$key]['shopname']=$v['name'];
					break;
				}
			}
		} 
		

		
		$arts['shops']=$shops;
		echo JSON_OUT($arts,true);
 	}
 	//发现点赞
 	public function veryGood(){
 		global $_W,$_GPC;
		$model=Model("find");
		$uniacid=intval($_W['uniacid']);
		$tab=$model->tablename("find");
	 	$sql="UPDATE $tab SET count_good=count_good+1 WHERE id = ".intval($_GPC['findid']);
	 	$res=$model->query($sql);
		echo $sql;
 	}
 	public function getFind(){
 		global $_W,$_GPC;
		$model=Model("find");
		$uniacid=intval($_W['uniacid']);
		$type=intval($_GPC['type']);
		$findid=intval($_GPC['findid']);
		$find=Model("find")->where("uniacid=".$uniacid ." and id=".$findid)->get("*,LEFT (createtime,10) as `datetime`");
        //$find['article'] = htmlspecialchars_decode($find['article'],ENT_QUOTES);

		$shop=$this->getShopByID(intval($find['shopid']));
		echo JSON_OUT(array("find"=>$find,"shop"=>$shop));
 	}
 	public function readIds(){
 		global $_W,$_GPC;
		$model=Model("find");
		$uniacid=intval($_W['uniacid']);
		$tab=$model->tablename("find");
	 	$sql="UPDATE $tab SET count_read=count_read+1 WHERE id in (".$_GPC['ids'].")";
	 	$res=$model->query($sql);
		echo $sql;
 	}
 }