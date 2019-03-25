<?php 
//店铺后台
class Goods extends ZskWxapp{
	public function checkShopAdmin(){
		global $_W,$_GPC;

 		$model=Model("member");
 		$uniacid=intval($_W['uniacid']);
 		$openid=$_GPC['openid'];
 		$shopid=$_GPC['shopid'];
 		$mem=$model->exist("openid='".$openid."' and adminshopid=$shopid and uniacid=".$uniacid);

		if(!$mem){
			echo json_encode(array("status"=>-1,"msg"=>"权限不足"));
			exit;
		} 
	}
	//商家后台发布 发现 时搜索商品
	public function search5ByKeyword(){
		global $_W,$_GPC;
		$model=Model("goods");
		$uniacid=intval($_W['uniacid']);
		$shopid=intval($_GPC['shopid']);
		$res=array();
		$key=(trim($_GPC['key']));
		if(strlen($key)>0){
			$res=$model->where("uniacid=".$uniacid." AND ( name like '%".$key."%' or number like '%".$key."%') and shopid=".$shopid)->limit(5)->getall();
			foreach ($res as $k => $v) {
				if(strlen($v['picture'])>5){
					$res[$k]['src']=$_W['attachurl'].$v['picture'];
				}else{
					$res[$k]['src']="";
				}
			}
		} 
		echo JSON_OUT($res,true);
	}
 	public function goodspage(){
 		global $_W,$_GPC;
 		$model=Model("goods");
 		$uniacid=intval($_W['uniacid']);
 		$openid=$_GPC['openid'];
 		$shopid=$_GPC['shopid'];
 		$where="uniacid=$uniacid and shopid=$shopid";
 		if(strlen(trim($_GPC['keyword']))){
 			$where.=" and name like '%".$_GPC['keyword']."%'";
 		}
 		$page=$model ->where($where)->page("id,number,cateid,uniacid,picture,picture_wide,status,price,name,sellCount,sort,shopid");
 		$goods=$page['dataset'];
 		$page['dataset']=getGoodsSimpleInfo($goods); 
 		$page['attachurl']=$_W['attachurl']; 
 		echo JSON_OUT($page,true);
 	}
 	public function editdata(){
 		global $_W,$_GPC;
 		// 先查询商品id再判断
 		$model=Model("goods");
 		$uniacid=intval($_W['uniacid']);
 		$openid=$_GPC['openid'];
 		$shopid=$_GPC['shopid'];
 		$where="uniacid=$uniacid ";
 		$goodsid=intval($_GPC['goodsid']);
 		$goods=$model->where("$where and id=$goodsid")->get();
 		$cates=Model("category")->order("id asc")->where("$where and status>0 and parentid<1")->getall("*,parentid as pid");
 		$brandModel = Model("brand");
        $brandWhere="uniacid=$uniacid and shopid=$shopid";
 		$spec=Model("goodsoption")->where("$where and shopid=$shopid ")->getall();//查询所有规格
 		if($goods){
 			$judgecate = Model("category")->where("id=".$goods['cateid'])->get();
 			$cate1id = "";
 			$cases2 =Model("category")->where("parentid=".$goods['cateid'])->getall("*,parentid as pid");
 			if($judgecate['parentid']>0){
 				$cases2 = Model("category")->where("parentid=".$judgecate['parentid'])->getall("*,parentid as pid");
 				foreach ($cases2 as $key => $val) {
	 				if($goods['cateid']==$val['id']){
	 					$cases2[$key]['checked']=1;
	 				}
	 			}
 				$cate1id =$judgecate['parentid'];
 			}
 			$cases=Model("goodscase")->where("$where and goodsid=$goodsid and isopt>0")->getall();
 			//轮播图
 			$swipers = Model("goodsswiper")->where('uniacid='.$uniacid.' and goodsid='.$goodsid.' and goodsid !=0')->getall("path");
 			// $swipers = pdo_getall('azsk_shop_goodsswiper', array('uniacid' => $uniacid,'goodsid'=>$goodsid,'goodsid !='=>0), array('path') , '' , array());
 			//详情图
 			$details = Model("goodspic")->where('uniacid='.$uniacid.' and goodsid='.$goodsid.' and goodsid !=0')->getall('path');
 			// $details = pdo_getall('azsk_shop_goodspic', array('uniacid' => $uniacid,'goodsid'=>$goodsid,'goodsid !='=>0), array('path') , '' , array());
 			$after = Model("goodsafter")->where('uniacid='.$uniacid.' and goodsid='.$goodsid.' and goodsid !=0')->getall('path');
 			// 循环属性表
 			// $spec_names1 = array();
 			// $spec_names2 = array();
 			$cates=childrank($cates);
 			foreach ($cates as $key => $val) {
 				if($goods['cateid']==$val['id']){
 					$cates[$key]['checked']=1;
 				}
 			}
 			echo JSON_OUT(array("cases"=>$cases,"goods"=>$goods,"attachurl"=>$_W['attachurl'],'spec'=>$spec,'pic_swipers'=>$swipers,"pic_after"=>$after,'pic_details'=>$details, "cates"=>$cates,"cate1id"=>$cate1id,"cases2"=>$cases2 ),true);
 		}else{
 			echo JSON_OUT(array("goods"=>$goods,'spec'=>$spec, "cates"=>$cates),true);
 		}
 	}
 	public function gettwocate(){
 		global $_W,$_GPC;
        $category_id = intval($_GPC['category_id']);
   //      $taba = Model("category")->tablename("category");
   //      $sql = "SELECT *,parentid as pid FROM $taba WHERE status>0 and parentid=".$category_id;
 		// 	var_dump($sql);die();
 		// $cates = Model("category")->query($sql);
 		$cates=Model("category")->order("id asc")->where("status>0 and parentid=".$category_id)->getall("*,parentid as pid");
 		echo JSON_OUT($cates);

 	}
    public function optkdi(){
        global $_W,$_GPC;
        $uniacid=intval($_W['uniacid']);
        $shopid=intval($_GPC['shopid']);
        $category_id = $_GPC['category_id'];
        $brand = model('brand')->where("uniacid=$uniacid and category_id=$category_id")->getall();
        echo JSON_OUT($brand);
    }

 	public function saveGoods(){
 		$this->checkShopAdmin();
 		global $_W,$_GPC;
 		$pics=json_decode($_POST['pics'],true);
 		$uniacid=intval($_W['uniacid']); 
 		$shopid=intval($_GPC['shopid']);
 		$gid=intval($_GPC['goodsid']);
 		$out=array("status"=>0); 
		//判断库存
 		$goods0=array(
			"uniacid"=>$uniacid,
			"shopid"=>$shopid,
		 	"cateid"=>trim($_GPC['cateid']),
			"name"=>trim($_GPC['name']),
			"price"=>floatval($_GPC['price']),
			"price0"=>floatval($_GPC['price01']),
			"content"=>$_GPC['content'],
			// "content1"=>$_GPC['content1'],
			"stock"=>intval($_GPC['stock']),
			"updatetime"=>time(),
			// "video"=>$_GPC['video'],
			"date"=>time(),
			"status"=>intval($_GPC['status']),
			"wechat_payment"=>$_GPC['wechat_payment'],
			"delivery"=>$_GPC['delivery'],
			"brandid"=>$_GPC['brandid'],
			"sale"=>$_GPC['sale'],
			"after_sale"=>$_GPC['after_sale'],
		);
		// var_dump($goods0);die();
 		$model=Model("goods"); 
		$goods=$model->where("uniacid=$uniacid and id=$gid and shopid=$shopid")->get();//验证是否商品属于该店铺
		//判断规格组
		
		$m2=Model("goodscase");
		if(intval($goods['id'])>0){ //有商品修改

			$res=$model->where("id=".$gid." and  uniacid=$uniacid and shopid=$shopid ")->save($goods0);
			 
		}else{
			$goods0['sort']=intval($_GPC['sort']);
			$goods0['shopid']=$shopid;
			$gid=$model->add($goods0); 

			if($gid){
				 
				$model->where("id=".$gid)->save(array("number"=>10000+$gid));
			}
		}
		if($gid<1){
			$out['msg']="保存失败";
			echo json_encode($out);exit;
		}  
		$cases=json_decode($_POST['cases'],true);
		$cids="0";
		$newcases=array();
		$cm=Model("goodscase");
 		$goods2['opt1']=$cases[0]['opt1'];
	 	$goods2['opt2']=$cases[0]['opt2'];
	 	
	 	$out['cases']=$cases;
	 	$model->where("id=".$gid)->limit(1)->save($goods2);
 
		foreach ($cases as $key => $val) {
			$cids.=",".intval($val['id']);
			$val['goodsid']=$gid;
			$val['opt1']=$goods2['opt1'];
			$val['opt2']=$goods2['opt2'];
			$val['shopid']=$shopid;
			$val['uniacid']=$uniacid;
			$val['status']=1;
			if(intval($val['id'])<0){ 
				unset($val['id']);
				array_push($newcases, $val);
			}
			if(intval($val['id'])>0){
				$cm->where("uniacid=".$uniacid." and shopid=".$shopid." and id=".intval($val['id']))->save($val);
			}
		}
		$result =$cm->delete("uniacid=".$uniacid." and shopid=".$shopid." and goodsid=".$gid." and isopt>0 and id not in ($cids)");
		$cm->addall($newcases);
		
 		$details=$swiper=array(); 
 		foreach ($pics as $key => $pic) {
 			if($pic['type']=="logo"){
 				Model("goods")->where("uniacid=$uniacid and id=$gid")->save(array("picture"=>$pic['server']));
 			}
 			if($pic['type']=="wide"){
 				Model("goods")->where("uniacid=$uniacid and id=$gid")->save(array("picture_wide"=>$pic['server']));
 			}
 			if($pic['type']=="swipers"){
 				$swip1=Model("goodsswiper")->where("goodsid=".$gid)->get();
 				$swip=array(
 					"path"=>$pic['server'],
 					"goodsid"=>$gid,
 					"sort"=>0,
 					"date"=>time(),
 					"uniacid"=>$_W['uniacid'],
 					"status"=>1
 				);
 				M("goodsswiper")->add($swip);
 			}
 			if($pic['type']=="details"){
 				$det=array(
 					"path"=>$pic['server'],
 					"goodsid"=>$gid,
 					"sort"=>0,
 					"date"=>time(),
 					"uniacid"=>$_W['uniacid'],
 					"status"=>1
 				);
 				M("goodspic")->add($det);
 			}
 			if ($pic['type']=="after") {
 				$swip1=Model("goodsafter")->where("goodsid=".$gid)->get();
 				$swip=array(
 					"path"=>$pic['server'],
 					"goodsid"=>$gid,
 					"sort"=>0,
 					"date"=>time(),
 					"uniacid"=>$_W['uniacid'],
 					"status"=>1
 				);
 				M("goodsafter")->add($swip);
 			}
 		} 
 		$out['status']=$gid;  
 		echo json_encode($out);
 	}
 	//规格管理
 	public function findNorms(){
 		global $_W,$_GPC;
 		$model=Model("goodsoption");
 		// $pics=json_decode($_POST['pics'],true);
 		$shopid=$_GPC['shopid'];
 		$uniacid=intval($_W['uniacid']); 
 		// $normid=intval($_GPC['normid']);
 		$where="uniacid=$uniacid ";
 		if (!isset($_GPC['mark'])) {
 			//查询所有规格
	 		$norms=$model->where("$where and shopid=$shopid")->getall();
	 		echo JSON_OUT(array("norms"=>$norms),true);
 		}else if($_GPC['mark']=='1'){
 			$inputNorms = $_GPC['inputnorms'];
 			$parentid = $_GPC['parentid'];
 			if($parentid==0){
 				$value=array(
 					'uniacid'=>$uniacid,
 					'shopid'=>$shopid,
 					'goodsid'=>0,
 					'parentid'=>0,
 					'name'=>$inputNorms,
 					'status'=>1,
 				);
 			}else{
 				$value=array(
 					'uniacid'=>$uniacid,
 					'shopid'=>$shopid,
 					'goodsid'=>0,
 					'parentid'=>$parentid,
 					'name'=>$inputNorms,
 					'status'=>1,
 				);
 			}
 			$res = $model->add($value);
	 		echo JSON_OUT(array("res"=>$res),true);
 		}else if($_GPC['mark']=='2'){
 			$inputnorms1 = $_GPC['inputnorms1'];
 			$id_norm = $_GPC['id_norm'];
 			$value=array(
 					'name'=>$inputnorms1,
 				);
	 		// $norms=Model("goods")->where("$where and shopid=$shopid and opt1_id=$id_norm")->getAll();
	 		// $norms1=Model("goods")->where("$where and shopid=$shopid and opt2_id=$id_norm")->getAll();
	 		//修改商品表规格id
 			$value1=array(
					'opt1_id'=>0,
				);
 			Model("goods")->where("uniacid=$uniacid and shopid=$shopid and opt1_id=$id_norm")->save($value1);
 			$value2=array(
 					'opt2_id'=>0,
 				);
 			Model("goods")->where("uniacid=$uniacid and shopid=$shopid and opt2_id=$id_norm")->save($value2);

 			$res=$model->where("id=".$id_norm." and  uniacid=$uniacid and shopid=$shopid ")->save($value);
 			echo JSON_OUT(array("res"=>$res),true);
 		}else if($_GPC['mark']=='3'){
 			$id = $_GPC['id'];
	 		$norms=$model->where("$where and shopid=$shopid and parentid=$id")->getAll();
 			$result = pdo_delete('azsk_shop_goodsoption', array('uniacid' =>$uniacid,'shopid'=>$shopid,'id'=> $id));
 			if($norms!=0){
 				$res = pdo_delete('azsk_shop_goodsoption', array('uniacid' =>$uniacid,'shopid'=>$shopid,'parentid'=> $id));
 			}
 			//修改商品表规格id
 			$value1=array(
					'opt1_id'=>0,
				);
 			Model("goods")->where("uniacid=$uniacid and shopid=$shopid and opt1_id=$id")->save($value1);
 			$value2=array(
 					'opt2_id'=>0,
 				);
 			Model("goods")->where("uniacid=$uniacid and shopid=$shopid and opt2_id=$id")->save($value2);
 			
	 		echo JSON_OUT(array("res"=>$result),true);
 		}
 	}
 	//拼团
 	public function collage(){
 		global $_W,$_GPC;
 		$model=Model("discount");
 		$shopid=$_GPC['shopid'];
 		$uniacid=intval($_W['uniacid']); 
 		$where="uniacid=$uniacid ";
 		if(!isset($_GPC['status']) && !isset($_GPC['id']) && !isset($_GPC['mark'])){//查询所有拼团活动
 			$discounts=$model->where("$where and shopid=$shopid and type = 4")->getall();
 			foreach ($discounts as $key => $value) {
 				// $value['images'] = Model("goods")->where("$where and shopid=$shopid and id=$value['id']")->get();
 				$value['images'] = pdo_getcolumn('azsk_shop_goods', array('uniacid' => $uniacid,'shopid'=>$shopid,'id'=>$value['goodsid']), 'picture_wide',1);
 				$value['shopName'] = pdo_getcolumn('azsk_shop_goods', array('uniacid' => $uniacid,'shopid'=>$shopid,'id'=>$value['goodsid']), 'name',1);
 				$discount[] = $value;
 			}
	 		// echo JSON_OUT(array("discount"=>$discount),true);
	 		echo json_encode(array("discount"=>$discount,"attachurl"=>$_W['attachurl']),true);
 		}else if(isset($_GPC['status'])){//修改活动状态
	 		$status=$_GPC['status'];
	 		$goodsid=$_GPC['goodsid'];
	 		if($status=='启用' || $status == '禁用'){
		 		$statusNum=$_GPC['statusNum'];
	 			$arr=array(
	 					"status"=>$statusNum,
	 				);
	 			$res=$model->where( " $where and shopid=$shopid and goodsid=$goodsid and type = 4")->save($arr);
	 		}else{
	 			$res = pdo_delete('azsk_shop_discount', array('uniacid' => $uniacid,'shopid'=>$shopid,'goodsid'=>$goodsid,'type'=>'4'));
	 		}
 			echo JSON_OUT(array("res"=>$res),true);
 		}else if(isset($_GPC['id'])){//添加活动查询某个商品
 			$id=$_GPC['id'];
 			$class=Model("pintuancate")->where("$where")->getall();
			if($_GPC['modify']=="123"){//修改
 				$dis_pintuan=$model->where("$where and shopid=$shopid and id = $id and type = 4")->get();
 				$goods=Model("goodscase")->where("$where and shopid=$shopid and goodsid = ".$dis_pintuan['goodsid'])->getall();

 				foreach ($goods as $key => $value) {
 					$opt1 = $value['opt1']; 
 					$opt2 = $value['opt2']; 
 				}
 				$go = json_decode($dis_pintuan['casejson'],true);
 				// unset($dis_pintuan['casejson']);
 				foreach ($go as $key => $value) {
 					$value['id'] = $value['caseid'];
 					foreach ($goods as $k => $val) {
 						if($val['id']==$value['caseid']){
 							$value['option1'] = $val['option1'];
 							$value['option2'] = $val['option2'];
 							$good[] = $value;
 						}
 					}
 				}
 				echo json_encode(array("good"=>$good,'class'=>$class,'opt1'=>$opt1,'opt2'=>$opt2,'dis_pintuan'=>$dis_pintuan));
 			}else{
 				$good=Model("goodscase")->where("$where and shopid=$shopid and goodsid = $id")->getall();
 				foreach ($good as $key => $value) {
 					$opt1 = $value['opt1']; 
 					$opt2 = $value['opt2']; 
 				}
 				echo JSON_OUT(array("good"=>$good,'class'=>$class,'opt1'=>$opt1,'opt2'=>$opt2),true);
 			}
 		}else if(isset($_GPC['mark'])){//提交数据
 			$id=$_GPC['sid'];
 			if($_GPC['mark']=='1'){//添加
 				$good=Model("goodscase")->where("$where and shopid=$shopid and goodsid = $id")->getall();
 				$starttime = $this->changtime($_GPC['starttime'],1);
 				$stoptime = $this->changtime($_GPC['stoptime'],2);
 				foreach ($good as $key => $value) {
 					$a[] =array(
 						'caseid'=>$_GPC['id'.$value['id']],
 						'price'=>$_GPC['price'.$value['id']],
 						'stock'=>$_GPC['stock'.$value['id']],
 					);
 				}
 				$disc = array(
 					'uniacid'=>$uniacid,
 					'shopid'=>$shopid,
 					'goodsid'=>$id,
 					'cateid'=>$_GPC['cateid'],
 					'type'=>'4',
 					'distype'=>'1',
 					'tag'=>'拼团',
 					'starttime'=>$starttime,
 					'stoptime'=>$stoptime,
 					'status'=>'1',
 					'group_start'=>$_GPC['group_start'],
 					'group_limit'=>$_GPC['group_start'],
 					'casejson'=>json_encode($a),
 					'title'=>$_GPC['title'],
 					'notice'=>$_GPC['notice'],
 					'seconds'=>$_GPC['seconds'],
 				);
 				$res = $model->add($disc);
 				echo JSON_OUT(array('res'=>$res),true);
 			}else if($_GPC['mark']=='2'){
 				$goodid=$_GPC['goodid'];
 				$good=Model("goodscase")->where("$where and shopid=$shopid and goodsid = $goodid")->getall();
 				$starttime = $this->changtime($_GPC['starttime'],1);
 				$stoptime = $this->changtime($_GPC['stoptime'],2);
 				foreach ($good as $key => $value) {
 					$a[] =array(
 						'caseid'=>$_GPC['id'.$value['id']],
 						'price'=>$_GPC['price'.$value['id']],
 						'stock'=>$_GPC['stock'.$value['id']],
 					);
 				}
 				$disc = array(
 					'uniacid'=>$uniacid,
 					'shopid'=>$shopid,
 					'goodsid'=>$goodid,
 					'cateid'=>$_GPC['cateid'],
 					'type'=>'4',
 					'distype'=>'1',
 					'tag'=>'拼团',
 					'starttime'=>$starttime,
 					'stoptime'=>$stoptime,
 					'status'=>'1',
 					'group_start'=>$_GPC['group_start'],
 					'group_limit'=>$_GPC['group_start'],
 					'casejson'=>json_encode($a),
 					'title'=>$_GPC['title'],
 					'notice'=>$_GPC['notice'],
 					'seconds'=>$_GPC['seconds'],
 				);
 				$res = $model->where("id=".$id." and  uniacid=$uniacid and shopid=$shopid and goodsid = $goodid")->save($disc);
 				echo JSON_OUT(array('res'=>$res),true);
 			}
 		}
 	}
 	//秒杀
 	public function second(){
 		global $_W,$_GPC;
 		$model=Model("discount");
 		$shopid=$_GPC['shopid'];
 		$uniacid=intval($_W['uniacid']); 
 		$where="uniacid=$uniacid ";
 		if(!isset($_GPC['status']) && !isset($_GPC['id']) && !isset($_GPC['mark'])){//查询所有拼团活动
 			$second_kills=$model->where("$where and shopid=$shopid and type = 2")->getall();
 			
 			foreach ($second_kills as $key => $value) {
 				$go[$key] = json_decode($value['casejson'],true);
 			}
 			foreach ($go as $ke => $valu) {
				foreach ($valu as  $v) {
					$a[$ke][] = $v['price'];
					$b[$ke][] = $v['stock'];
				}
 				foreach ($second_kills as $key => $value) {
 					if($ke==$key){
 						$value['minimum'] = min($a[$key]);
 						$value['total'] = array_sum($b[$key]);
 						$second[] = $value;
 					}
 				}
 			}
 			foreach ($second as $key => $value) {
 				// $value['images'] = Model("goods")->where("$where and shopid=$shopid and id=$value['id']")->get();
 				$value['images'] = pdo_getcolumn('azsk_shop_goods', array('uniacid' => $uniacid,'shopid'=>$shopid,'id'=>$value['goodsid']), 'picture_wide',1);
 				$value['shopName'] = pdo_getcolumn('azsk_shop_goods', array('uniacid' => $uniacid,'shopid'=>$shopid,'id'=>$value['goodsid']), 'name',1);
 				$second_kill[] = $value;
 			}
	 		// echo JSON_OUT(array("discount"=>$discount),true);
	 		
	 		echo json_encode(array("second_kill"=>$second_kill,"attachurl"=>$_W['attachurl']),true);
 		}else if(isset($_GPC['status'])){//修改活动状态
	 		$status=$_GPC['status'];
	 		$goodsid=$_GPC['goodsid'];
	 		if($status=='启用' || $status == '禁用'){
		 		$statusNum=$_GPC['statusNum'];
	 			$arr=array(
	 					"status"=>$statusNum,
	 				);
	 			$res=$model->where( "$where and shopid=$shopid and goodsid=$goodsid and type = 2")->save($arr);
 				 
	 		}else{
	 			$res = pdo_delete('azsk_shop_discount', array('uniacid' => $uniacid,'shopid'=>$shopid,'goodsid'=>$goodsid,'type'=>'2'));
	 		}
 			echo JSON_OUT(array("res"=>$res),true);
 		}else if(isset($_GPC['mark'])){
 			$id=$_GPC['sid'];
 			if($_GPC['mark']=='1'){//添加
 				$good=Model("goodscase")->where("$where and shopid=$shopid and goodsid = $id")->getall();
 				foreach ($good as $key => $value) {
 					$a[] =array(
 						'caseid'=>$_GPC['id'.$value['id']],
 						'price'=>$_GPC['price'.$value['id']],
 						'stock'=>$_GPC['stock'.$value['id']],
 					);
 				}

 				$dateli = strtotime($_GPC['dateline']);//开始时间
 				
 				$dateline1 = strtotime($_GPC['dateline1']);//结束时间
 				$dateline="";
 				do {
 					$dateline.=date('Y-m-d',$dateli).',';
 					$dateli+=86400;
 				} while ($dateli<=$dateline1);
 				$dateline=substr($dateline, 0,-1);

 				$disc = array(
 					'uniacid'=>$uniacid,
 					'shopid'=>$shopid,
 					'goodsid'=>$id,
 					'type'=>'2',
 					'distype'=>'1',
 					'tag'=>'秒杀',
 					'status'=>'1',
 					'group_start'=>'1',
 					'group_limit'=>'1',
 					'casejson'=>json_encode($a),
 					'dateline'=>$dateline,
 					'timeline'=>$_GPC['timeline'],
 				);
 				$res = $model->add($disc);
 				echo JSON_OUT(array('res'=>$res),true);
 			}else{//修改

 			}
 		}else if(isset($_GPC['id'])){//添加活动查询某个商品
 			$id=$_GPC['id'];
			if($_GPC['modify']=="123"){//修改
 				$dis_miaosha=$model->where("$where and shopid=$shopid and id = $id and type = 2")->get();
 				$goods=Model("goodscase")->where("$where and shopid=$shopid and goodsid = ".$dis_miaosha['goodsid'])->getall();

 				foreach ($goods as $key => $value) {
 					$opt1 = $value['opt1']; 
 					$opt2 = $value['opt2']; 
 				}
 				$go = json_decode($dis_miaosha['casejson'],true);
 				// unset($dis_miaosha['casejson']);
 				foreach ($go as $key => $value) {
 					$value['id'] = $value['caseid'];
 					foreach ($goods as $k => $val) {
 						if($val['id']==$value['caseid']){
 							$value['option1'] = $val['option1'];
 							$value['option2'] = $val['option2'];
 							$good[] = $value;
 						}
 					}
 				}
				$s = split($dis_miaosha['dateline'],",");
				$first = $s[0];
				echo "<pre>";
				print_r($s);
				echo "</pre>";
 				echo json_encode(array("good"=>$good,'opt1'=>$opt1,'opt2'=>$opt2,'dis_miaosha'=>$dis_miaosha));
 			}else{
 				$good=Model("goodscase")->where("$where and shopid=$shopid and goodsid = $id")->getall();
 				foreach ($good as $key => $value) {
 					$opt1 = $value['opt1']; 
 					$opt2 = $value['opt2']; 
 				}
 				echo JSON_OUT(array("good"=>$good,'opt1'=>$opt1,'opt2'=>$opt2),true);
 			}
 		}
 	}
 	//查询分类
 	public function  getcate0(){
		global $_W,$_GPC;
		$model=Model("category");
		$shopid = intval($_POST['shopid']);
		$uniacid=intval($_W['uniacid']);
		$a = $model->tablename("category");
		$b = $model->tablename("goods");
		$sql = "SELECT $a.id,$a.name,$a.logo FROM $a INNER JOIN $b ON $a.id = $b.cateid WHERE $b.shopid=".$shopid." and $a.uniacid = ".$uniacid." and $a.parentid=0 and $a.status>0 group by $a.id order by $a.sort desc";
		$cates = $model->query($sql);
		// $cates=$model->where("uniacid='".$_W['uniacid']."' and parentid=0 and status>0")->order("sort desc")->getall("id,name,logo");
		echo JSON_OUT($cates,true);
	}
	//查询商品
	public function getcate1(){
		global $_W,$_GPC;
		$model=Model("discount");
		$shopid = $_GPC['shopid']; 
		$uniacid=intval($_W['uniacid']);
		$where="uniacid=$uniacid ";
		
		if(isset($_GPC['second'])){//秒杀
			$discounts=$model->where("$where and shopid=$shopid and type = 2")->getall('goodsid');
		}else if(isset($_GPC['cut_down'])){//砍价
			$discounts=$model->where("$where and shopid=$shopid and type = 5")->getall('goodsid');
		}else{//拼团
			$discounts=$model->where("$where and shopid=$shopid and type = 4")->getall('goodsid');
		}
		$m3=Model("goods");
		$goods=$m3->where(" $where and status>0 and shopid = $shopid and cateid >0")->getall("id,name,picture as logo,price,cateid");
		foreach ($goods as $key => $value) {
			$a[] = $value['id'];
		}
		foreach ($discounts as $k => $val) {
			$b[] = $val['goodsid'];
		}
		$s = array_merge(array_diff($a, $b),array_diff($b,$a));
		foreach ($s as $key => $value) {
			$re[] = $m3->where(" $where and status>0 and shopid = $shopid and cateid >0 and id = ".$value)->get("id,name,picture as logo,price,cateid");
		}
		foreach ($re as $key => $value) {
			if(strlen($value['logo'])>10){
				$value['src']=$_W['attachurl'].$value['logo'];
				$res[] = $value;
			}else{
				$res[] = $value;
			}
		}
		echo JSON_OUT($res,true);
	} 
	private function changtime($time,$id){
		if($id == '1'){
 			$starttime = explode(',',$time);
			$year = "20".$starttime[0];
			$month = 1+$starttime[1];
			$day = 1+$starttime[2];
			$hour = $starttime[3];
			$min = $starttime[4];
			$second = $starttime[5];
			$starttime = $year."-".$month."-".$day." ".$hour.":".$min.":".$second;
			return $starttime;
		}else{
			$stoptime = explode(',', $time);
			$year = "20".$stoptime[0];
			$month = 1+$stoptime[1];
			$day = 1+$stoptime[2];
			$hour = $stoptime[3];
			$min = $stoptime[4];
			$second = $stoptime[5];
			$stoptime = $year."-".$month."-".$day." ".$hour.":".$min.":".$second;
			return $stoptime;
		}
	}
	public function select_datanum(){
		global $_W,$_GPC;
		$model=Model("order");
		$model1 = Model("shop");
		$shopid = $_GPC['shopid']; 
		$uniacid=intval($_W['uniacid']);
		$where="uniacid=$uniacid ";
		$money=$model1->where("$where and id=$shopid ")->get("balance ,balance_freezing");//查询商家可提现余额,余额
		$order=$model->where("$where and shopid=$shopid ")->getall();//查询商家各种订单
		$time = date("Ymd").'000000';
		$time1 =date("Ymd").'235959';
		//今日
		$i = 0;
		$j = 0;
		$q = 0;
		foreach ($order as $key => $value) {
			$rest = substr($value['order_no'],0,14);
			if($rest>$time&&$rest<$time1){
				
				if($value['status']==1){//今日订单
					$money_pay[] =  $value['money_pay'];
					$today["money"] = array_sum($money_pay);
					$a[] = $rest;
					$today['order'] = count($a); 
				}else if($value['status']){

				}
			}
			if($value['status']==1){
				$i++;
				$orders['df'] = $i;
			}
			if ($value['status']==0) {
				$j++;
				$orders['dfk'] = $j;
			}
			if($value['status']=='-2'){
				$q++;
				$orders['tkd'] = $q;
			}
		}
		$goods=Model("goods")->where("$where and shopid=$shopid ")->getall();
		$goodsnum = count($goods);
		echo JSON_OUT(array('money'=>$money,'today'=>$today,'order'=>$orders,'goodsnum'=>$goodsnum),true);
	}
	public function getOptions(){
			global $_W,$_GPC; 
		$model= Model("goodsoption");
		$shopid =intval($_GPC['shopid']); 
		$uniacid=intval($_W['uniacid']);
		$options=$model->where("shopid=".$shopid)->getall("id,name,parentid as pid,status,uniacid,shopid,0 as active");
		$options=childtree($options);
		echo JSON_OUT($options,true);
	}
}
	 