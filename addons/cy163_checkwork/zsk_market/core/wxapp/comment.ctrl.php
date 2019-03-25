<?php 
class Comment extends ZskWxapp{ 
 	public function uploadPic(){ 
		load()->func('file'); 
		$res=file_upload($_FILES['picture'],"image");
 		echo JSON_OUT($res);
	}
	public function orderComment(){//订单商品评论
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("comment");
		$picstr=trim($_GPC['picstr']);
		if(strlen($picstr)>10){
			$picstr=substr($picstr,0,strlen($picstr)-1);
		}
		$order=Model("order")->where("order_no ='".trim($_GPC["ordernum"])."'")->get();
		if(empty($order)){
			echo json_encode(array("sts"=>0));
			exit;
		}
        $orderdetail=Model("orderdetail")->where("order_no ='".trim($_GPC["ordernum"])."'")->get();
		$comment=array(
			"uniacid"=>$uniacid,
			"openid"=>$_GPC['openid'], 
			"shopid"=>$order['shopid'],
            "goodsid"=>$orderdetail['goodsid'],
			"parentid"=>0,
			"content"=>$_GPC['content'], 
			"status"=>1,
			"nick"=>intval($_GPC['nick']),
			"type"=>1, 
			"flower"=>intval($_GPC['flower']),
			"score1"=>intval($_GPC['score1']),
			"score2"=>intval($_GPC['score2']),
			"datetime"=>date("Y-m-d H:i:s",time()),
			"ordernum"=>trim($_GPC["ordernum"]),
			"pictures"=>$picstr
		); 
		$nickname=$_GPC['nickname'];
		if(strlen($nickname)<1){
			$nickname=substr($openid,0,10);
		}
		if(intval($_GPC['nick'])>0){ 
			$comment['nickname']=mb_substr($nickname,0,1,"utf-8")."***";
		}else{
			$comment['nickname']=$nickname;
		}
		$mid=$model->add($comment); 
		if($mid>0){
			Model("order")->where("order_no ='".$_GPC['ordernum']."'")->limit(1)->save(array("comment"=>1,"status"=>4));
		}
		echo json_encode(array("sts"=>$mid));
	}
	public function getGoodsComments(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("comment");
		$goodsid=intval($_GPC['goodsid']);
		$tab0=$model->tablename("comment");
		$tab1=$model->tablename("orderdetail");
	
		$sql="SELECT $tab0.*,LEFT($tab0.`datetime`,10) as `date` FROM $tab0 LEFT JOIN $tab1 ON $tab0.ordernum=$tab1.order_no WHERE $tab1.goodsid=$goodsid and $tab0.status>0";
		$data=$model->pagenation($sql);
		
		$ops="";
		foreach ($data['dataset'] as $key => $val) {
			$data['dataset'][$key]['pics']=explode(",", $val['pictures']);
			$ops.="'".$val['openid']."',";
		}
		if(strlen($ops)>15){
			$ops=substr($ops, 0,strlen($ops)-1);
			$m2=Model("member");
			$avs=$m2->where("openid in ($ops)")->getall("openid,avatar");
			foreach ($data['dataset'] as $k => $v) {
				foreach ($avs as $key => $val) {
					if($val['openid']==$v['openid']){
						$data['dataset'][$k]['avatar']=$val['avatar'];
					}
				}
			} 
		}
		$data['attachurl']=$_W['attachurl'];
		echo JSON_OUT($data,true);
	}
}
	 