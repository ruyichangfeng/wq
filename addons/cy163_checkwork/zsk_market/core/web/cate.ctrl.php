 <?php
 class Cate extends ZskPage
 { 
 	public function index(){ 
 		$this->listview();
 	}
 	//商品分类列表
 	public function listview(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("category");
 		$shopid=getShopID();

 		$name=trim($_GPC['name']);
 		$where="uniacid=$uniacid";
 		if(strlen($name)){
 			$where.=" and name like '%".$name."%'";
 			$params['name']=$name;
 		}
 		// var_dump($where);die();
		$res=$model->where($where)->order("sort desc")->getall("*,parentid as pid");
 		foreach ($res as $key => $val) {
 			if(intval($val['status'])>0){
 				$res[$key]['sts']='<span style="color:#22B14C;">启用</span>';
 			}else{
 				$res[$key]['sts']='<span style="color:#999;">禁用</span>';
 			}
 			if(intval($val['indexPlay'])==1){
 				$res[$key]['iplay']='<span style="color:#00A2E8;">推荐</span>';
 			}else{
 				$res[$key]['iplay']='<span style="color:#999;">无</span>';
 			}
 			$res[$key]['src']=$_W['attachurl'].$val['logo'];
 		}
// 		 var_dump(111);die();
 		$cates=childtree($res,true);//转换成树状结构
 		include $this->template("web/cate/cate-list");
 	} 
  	//保存商品分类，idkey字段便于二级分类搜索
 	public function save(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("category");

 		$cid=intval($_POST['cid']); 
 		$pid=intval($_POST['pid']);
 		$cate=array(
 			"uniacid"=>intval($_W['uniacid']),
 			"parentid"=>$pid,
 			"name"=>trim($_POST['name']),
 			"sort"=>intval($_POST['sort']),
 			"status"=>intval($_POST['sts']),
 			'logo'=>trim($_POST['logo'])
 		);
 		if($pid>0){
 			$parent=$model->where("id=".$pid)->get("*");
 			$cate['idkey'].=$parent['idkey'].$pid.",";
 		}else{
 			$cate['idkey']=",0,";
 		} 
		if($cid>0){//修改
			$logo=trim($_POST['logo']); 
			$res=$model ->where("id=$cid and uniacid=$uniacid")->save($cate);
			if(!empty($res)){
				message("修改成功",$this->routeUrl("cate.index"));
			}else{
				message("修改失败");
			}
		}else{//新增 
			$cid=$model->add($cate);  
			if($cid>0){
				message("添加成功",$this->routeUrl("cate.index"));
			}else{
				message("添加失败");
			}
		} 
	}
	//添加分类页面
	public function addview(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("category"); 
		$pid=intval($_GPC['pid']); 
		if($pid>0){
			$parent=trim($_GPC['name']);
		}else{
			$parent="顶级分类";
		}
		$cate=array("parentid"=>$pid);
		include $this->template("web/cate/cate-edit");
		exit;
	}
	//分类编辑页面
	public function editview(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("category");

		$cid=intval($_GPC['cid']); 
		$cate=$model ->where("id=".$cid." and uniacid=$uniacid")->get("*");
		$parent="一级分类";
		if(intval($cate['parentid'])>0){
			$name=$model ->where("id=".intval($cate['parentid'])." and uniacid=$uniacid")->get("*");
			$parent=$name['name'];
		}
		include $this->template("web/cate/cate-edit");
		exit;
	}
	//删除分类
	public function delcate(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("category"); 
		$cid=intval($_GPC['cid']);
		$where=" ( id=$cid or parentid=$cid) and uniacid=$uniacid";
		$model=Model("category");
		$sts=$model->delete($where); 
		if($sts>0){
			message("删除成功",$this->routeUrl("cate.index"));
		}else{
			message("删除失败",$this->routeUrl("cate.index"));
		}  
		exit;
	}

	public function brand(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("brand");
		$shopid=getShopID();

		$name=trim($_GPC['name']);
		$where="uniacid=$uniacid";
		if(strlen($name)){
			$where.=" and name like '%".$name."%'";
			$params['name']=$name;
		}
		$category = Model('category')->where('uniacid='.$uniacid .' and parentid<1')->getall();
		$res=$model->where($where)->order("sort desc")->getall();
		include $this->template("web/cate/brand-list");
	}

	public function brandAdd(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$shopid = getShopID();
		$categoryModel = $this->model('category');
		if(is_mode() == 'POST'){
			$data = array(
				'category_id'=>$_GPC['category_id'],
				'name'=> $_GPC['name'],
				'logo'=>$_GPC['logo'],
				'status'=>$_GPC['status'],
				'sort'=>$_GPC['sort'],
			);

			$model = Model('brand');
			if($_GPC['id']){
//				$da['id'] = $_GPC['id'];
				$where=" id = ".$_GPC['id'];
				$res = $model->where($where)->save($data);
			}else{
				$data['uniacid'] = $uniacid;
				$data['shopid'] = getShopID();
				$res = $model->add($data);
			}
			if($res){
				message("提交成功",$this->routeUrl("cate.brand"));
			}else{
				message("提交失败");
			}
		}else if($_GPC['cid']){
			$where=" id = ".$_GPC['cid'];
			$model = Model('brand');
			$brand = $model->where($where)->get();
		}
		$where="uniacid=$uniacid and status = 1 and parentid < 1";
 		$category = $categoryModel->where($where)->order('sort desc')->getall();
		include $this->template("web/cate/brand-add");
	}

	public function fileimg(){
		global $_W,$_GPC;
		$filenamel = ZSK_PATH.'/static/';
		if (!is_dir($filenamel)) {                    //创建路径
			mkdir($filenamel,0777,true);
		}
		if(($_FILES["file"]["type"]=="image/png"||$_FILES["file"]["type"]=="image/jpeg")&&$_FILES["file"]["size"]<1024000){
			$ile = 'file/'.md5($_FILES["file"]["name"]).'.png';
			$filename = $filenamel . $ile;
			move_uploaded_file($_FILES["file"]["tmp_name"], $filename);//保存文件
			$data = ['code'=>true,'data'=>$ile,'msg'=>'上传成功'];
		}else{
			$data = ['code'=>false,'data'=>'','msg'=>'上传失败'];
		}
		echo json_encode($data);
	}

	public function brandDelect(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$cid=intval($_GPC['cid']);
		$where=" id=$cid  and uniacid=$uniacid";
		$model=Model("brand");
		$sts=$model->delete($where);
		if($sts>0){
			message("删除成功",$this->routeUrl("cate.brand"));
		}else{
			message("删除失败",$this->routeUrl("cate.brand"));
		}
		exit;
	}
}
?> 