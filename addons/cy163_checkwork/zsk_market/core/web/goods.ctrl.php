 <?php
 class Goods extends ZskPage
 {

 	function index(){
 		$this->listview();
 	}
 	function listview(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("goods");
 		$name=trim($_GPC['name']);
 		$shopid=getShopID();
 		$where="uniacid=$uniacid and shopid=$shopid";

 		if(strlen($name)){
 			$where.=" and name like '%".$name."%' or number like '%".$name."%'";
 			$params['name']=$name;
 		}
 		$page=$model->where($where)->order("sort desc")->page("*");
 		$urge=Model("item")->where("uniacid=$uniacid and datatype='goods-list'")->getall("id,name");
 		$goodslist=$page['dataset'];
 	    foreach ($goodslist as $key => $val) {
 	    	$ids.=$val['id'].",";
 	    }
 	    if(strlen($ids)>1){
 	    	$ids=substr($ids, 0,strlen($ids)-1);
 	    	$tab2=$model->tablename("item");
 	    	$tab3=$model->tablename("goodsurge");
 	    	$sql="SELECT $tab2.name as itemname,$tab2.id as itemid,$tab3.goodsid as goodsid,$tab3.id as urid FROM $tab2 LEFT JOIN $tab3 ON $tab2.id=$tab3.itemid WHERE $tab3.goodsid in ($ids)";
 	    	$items=$model->query($sql);
 	    	foreach ($goodslist as $key => $val) {
	 	    	foreach ($items as $k => $v) {
	 	    		if($val['id']==$v['goodsid']){
	 	    			$goodslist[$key]['items'][]=$v;
	 	    		}
	 	    	}
	 	    }
 	    }

 	    $nowe7=true;
 		$page['url']=$this->routeUrl("goods.listview");
 		include $this->template("web/goods/goods-list");
 	}

	function daoru(){
		global $_W,$_GPC;
//		var_dump(111);die;
		include $this->template("web/goods/goods-daoru");
	}
	 function shangcuanFile(){
		 global $_W,$_GPC;

         $uniacid=intval($_W['uniacid']);
         $shopid=getShopID();
         $model=Model("goods");
		 if($_FILES["xlsx"]){
             $filenamel = ZSK_PATH.'/static/upload/images';
             if (!is_dir($filenamel)) {                    //创建路径
                 mkdir($filenamel,0777,true);
             }
			 $filename = $filenamel.$_FILES["xlsx"]["name"];
             if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $filename)>0) {
                 echo getInfo(false,'上传Excel文件不能带有中文，请修改文件名称');
                 return false;
             }
			 move_uploaded_file($_FILES["xlsx"]["tmp_name"],$filename);//保存文件
			 $execl = importExecl($filename);
			 $goodsmodel=Model("goods");
			 $goods = $goodsmodel->tablename("goods");

			 $zid = "name,price,price0,sellCount0,stock,cateid,brandid,status,catalog,picture,picture_wide,content,opt1,opt1_id,opt2,opt2_id,delivery,wechat_payment,sale,after_sale,uniacid,shopid";
             $goodsmodel->query('BEGIN');
             $goodsmodel->query('autocommit=false');

             $casemodel = Model('goodscase');
             $casetable = $casemodel->tablename("goodscase");
             $casemodel->query('BEGIN');
             $casemodel->query('autocommit=false');

             $goodsswipermodel = Model('goodsswiper');
             $goodsswipermodel->query('BEGIN');
             $goodsswipermodel->query('autocommit=false');
             $goodsswipertable = $casemodel->tablename("goodsswiper");

			 foreach ($execl as $k => $v){
				 if($k > 1){
				     if($v['A'] == '' || mb_strlen($v['A'],'utf8') >= 30){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'商品名称不正确或者超出长度，商品行号为：【'.$k.'行】；请认真填写');
                         return false;
                     }else if($v['B'] <= 0 ||  !(is_numeric($v['B']))){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'现价出错，价格必须是数字并且大于0，商品名称为：【'.$v['A'].'】；请认真填写');
                         return false;
                     }else if($v['C'] <= 0 ||  !(is_numeric($v['C']))){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'原价出错，价格必须是数字并且大于0，商品名称为：【'.$v['A'].'】；请认真填写');
                         return false;
                     }else if($v['D'] < 0 || $v['D'] > 500 ||  !(is_numeric($v['D']))){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'虚拟销量报错啦，虚拟销售量必须是数字且大于等于0，虚拟销售量不能超过500，商品名称为：【'.$v['A'].'】；请认真填写');
                         return false;
                     }else if($v['E'] <= 0 || !(is_numeric($v['E']))){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'库存报错啦，库存必须是数字且大于0，商品名称为：【'.$v['A'].'】；请认真填写');
                         return false;
                     }else if($v['H'] != 1 && $v['H'] != 2){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'商品上下架状态不对，请检查，商品名称为：【'.$v['A'].'】；');
                         return false;
                     }else if( substr($v['I'],-1,1) != '/'){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'图片目录格式不正确，请检查，商品名称为：【'.$v['A'].'】；');
                         return false;
                     }else if($v['S'] < 1 || $v['s'] >2 ){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'微信付款支付方式不正确，商品名称为：【'.$v['A'].'】；');
                         return false;
                     }else if($v['R'] < 1 || $v['R'] >2 ){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'货到付款支付方式不正确，商品名称为：【'.$v['A'].'】；');
                         return false;
                     }else if($v['R'] == 2 && $v['S'] == 2 ){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'支付方式不正确，请至少开启一种支付方式，商品名称为：【'.$v['A'].'】；');
                         return false;
                     }else if($v['T'] < 1 || $v['T'] >2 ){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'是否支持售后填写方式不正确，商品名称为：【'.$v['A'].'】；');
                         return false;
                     }else if($v['B'] >= $v['C']){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'现价不能大于等于原价，请重新设置，商品名称为：【'.$v['A'].'】；');
                         return false;
                     }else if(substr($v['J'],-3) != 'png' && substr($v['J'],-3) != 'jpg'){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'商品首图只支持 png | jpg ，请重新填写图片名称，商品名称为：【'.$v['A'].'】；');
                         return false;
                     }
//				     else if(substr($v['K'],-3) != 'png' && substr($v['K'],-3) != 'jpg'){
//                         $casemodel->query('rollback');
//                         $casemodel->query('autocommit');
//                         $casemodel->query('close');
//
//                         $goodsmodel->query("rollback");
//                         $goodsmodel->query('autocommit=true');
//                         $goodsmodel->query('close');
//
//                         $goodsswipermodel->query('rollback');
//                         $goodsswipermodel->query('autocommit');
//                         $goodsswipermodel->query('close');
//                         echo getInfo(false,'商品活动图片只支持 png | jpg ，请重新填写图片名称，商品名称为：【'.$v['A'].'】；');
//                         return false;
//                     }

                     $opt1 = explode(",", $v['O']);
//                     foreach ($opt1 as $kl => $vl){
//                         $goodsoption = Model('goodsoption')->where('shopid='.$shopid.' and uniacid='.$uniacid .' and id='.$vl)->get();
//                         if(!count($goodsoption)){
//                             $casemodel->query('rollback');
//                             $casemodel->query('autocommit');
//                             $casemodel->query('close');
//
//                             $goodsmodel->query("rollback");
//                             $goodsmodel->query('autocommit=true');
//                             $goodsmodel->query('close');
//
//                             $goodsswipermodel->query('rollback');
//                             $goodsswipermodel->query('autocommit');
//                             $goodsswipermodel->query('close');
//                             echo getInfo(false,'商品上传失败，错误规格ID，商品名称为：【'.$v['A'].'】；请认真填写');
//                             return false;
//                         }
//                     }

                     $categoryModel = Model('category');
                     $brandModel = Model('brand');
                     $category = $categoryModel->where('uniacid='.$uniacid.' and id='.$v['F'])->get();
                     $brand = $brandModel->where('uniacid='.$uniacid .' and id='.$v['G'])->get();
                     if(!count($category) || !$category){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'商品上传失败，没有该商品分类，商品名称为：【'.$v['A'].'】；请认真填写');
                         return false;
                     }else if($category['parentid'] != $brand['category_id'] && $category['id'] != $brand['category_id']){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'商品上传失败，该商品分类和品牌不对应，请重新填写分类和品牌，商品名称为：【'.$v['A'].'】；');
                         return false;
                     } else if(!count($brand) || !$brand){
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');
                         echo getInfo(false,'商品上传失败，该商品没有此品牌，请重新填写品牌，商品名称为：【'.$v['A'].'】；');
                         return false;
                     }
                     $opt2 = explode(",", $v['Q']);
                     $content = explode(",", $v['M']);
                     $after_sale = explode(",", $v['U']);
                     $goodsswiper = explode(",", $v['L']);
//                     if(count($goodsswiper) > 5){
//                         $casemodel->query('rollback');
//                         $casemodel->query('autocommit');
//                         $casemodel->query('close');
//
//                         $goodsmodel->query("rollback");
//                         $goodsmodel->query('autocommit=true');
//                         $goodsmodel->query('close');
//
//                         $goodsswipermodel->query('rollback');
//                         $goodsswipermodel->query('autocommit');
//                         $goodsswipermodel->query('close');
//                         echo getInfo(false,'详情轮播图最多只能上传5张图片，请重新填写品牌，商品名称为：【'.$v['A'].'】；');
//                         return false;
//                     }

                     $img='';
                     $sale='';

                     foreach ($content as $kc => $vc){
                         //商品详情图，循环套上标签
                         $img .= "<img src='".$_W['attachurl'].'images/'.$uniacid.'/'.$shopid.'/'.$v['I'].$vc."'>";
                     }
                     $img = htmlspecialchars($img);
                     foreach ($after_sale as $kc => $vc){
                         //商品售后图，循环套上标签
                         $sale .= "<img src='".$_W['attachurl'].'images/'.$uniacid.'/'.$shopid.'/'.$v['I'].$vc."'>";
                     }
                     $sale = htmlspecialchars($sale);
                     $optionModel = model('goodsoption');
                     $option1 = $optionModel->where('id='.$opt1[0])->get();
                     $option2 = $optionModel->where('id='.$opt2[0])->get();
                     $sql = 'INSERT INTO '.$goods.' ('.$zid.') VALUES ("'.$v['A'].'","'.$v['B'].'","'.$v['C'].'","'.$v['D'].'","'.$v['E'].'","'.$v['F'].'","'.$v['G'].'","'.$v['H'].'","'.$v['I'].'","'.'images/'.$uniacid.'/'.$shopid.'/'.$v['I'].$v['J'].'","'.'images/'.$uniacid.'/'.$shopid.'/'.$v['I'].$v['K'].'","'.$img.'","'.$v['N'].'","'.$option1['parentid'].'","'.$v['P'].'","'.$option2['parentid'].'","'.$v['R'].'","'.$v['S'].'","'.$v['T'].'","'.$sale.'","'.$uniacid.'","'.$shopid.'")';
                     $resx = $goodsmodel->query($sql);
					 $id = $goodsmodel->query('select @@IDENTITY');
					 $data['number'] = ($id[0]['@@IDENTITY']+100000);
                     $goodsmodel->where('id='.$id[0]['@@IDENTITY'])->save($data);
					 if($resx){
                         $goodsid = $id[0]['@@IDENTITY'];
					     foreach ($goodsswiper as $ku => $vu){

					         $goodsswipersql = 'INSERT INTO '.$goodsswipertable.'(uniacid,goodsid,path,status) value('.$uniacid.','.$goodsid.',"'.'images/'.$uniacid.'/'.$shopid.'/'.$v['I'].$vu .'", 1)';
					         $goodsswiper = $goodsswipermodel->query($goodsswipersql);
                             if($goodsswiper){
                             }else{
                                 $casemodel->query('rollback');
                                 $casemodel->query('autocommit');
                                 $casemodel->query('close');

                                 $goodsmodel->query("rollback");
                                 $goodsmodel->query('autocommit=true');
                                 $goodsmodel->query('close');

                                 $goodsswipermodel->query('rollback');
                                 $goodsswipermodel->query('autocommit');
                                 $goodsswipermodel->query('close');
                                 echo getInfo(false,'商品上传失败，商品轮播图错误，商品名称为：【'.$v['A'].'】；');
                                 return false;
                             }
                         }
					     if(isset($opt1[0]) && isset($opt2[0]) && isset($v['N']) && isset($v['P'])){
                             foreach ($opt1 as $kone => $vone){
                                 $option1 = $optionModel->where('uniacid='.$uniacid.' and shopid='.$shopid.' and id='.$vone)->get();
                                 if($option1){
                                 }else{
                                     $casemodel->query('rollback');
                                     $casemodel->query('autocommit');
                                     $casemodel->query('close');

                                     $goodsmodel->query("rollback");
                                     $goodsmodel->query('autocommit=true');
                                     $goodsmodel->query('close');

                                     $goodsswipermodel->query('rollback');
                                     $goodsswipermodel->query('autocommit');
                                     $goodsswipermodel->query('close');
                                     echo getInfo(false,'商品上传失败，商品规格错误,错误商品名称为：【'.$v['A'].'】；');
                                     return false;
                                 }
                                 foreach ($opt2 as $ktwo => $vtwo){
                                     $option2 = $optionModel->where('uniacid='.$uniacid.' and shopid='.$shopid.' and id='.$vtwo)->get();
                                     if($option2){
                                         $casesql = 'INSERT INTO '.$casetable.'( uniacid, shopid, goodsid,isopt,opt1,opt2,option1,option2,price,stock,thumb) value('.$uniacid.','.$shopid.','.$id[0]['@@IDENTITY'].', 1,\''.$v['N'].'\',\''.$v['P'].'\',\''.$option1['name'].'\',\''.$option2['name'].'\',\''.$v['B'].'\',\''.$v['E'].'\',\''.'images/'.$uniacid.'/'.$shopid.'/'.$v['I'].$v['J'].'\')';
                                         $csty = $casemodel->query($casesql);
                                         if($csty){
                                         }else{
                                             $casemodel->query('rollback');
                                             $casemodel->query('autocommit');
                                             $casemodel->query('close');

                                             $goodsmodel->query("rollback");
                                             $goodsmodel->query('autocommit=true');
                                             $goodsmodel->query('close');

                                             $goodsswipermodel->query('rollback');
                                             $goodsswipermodel->query('autocommit');
                                             $goodsswipermodel->query('close');
                                             echo getInfo(false,'商品上传失败，商品规格错误,错误商品名称为：【'.$v['A'].'】3；');
                                             return false;
                                         }
                                     }else{
                                         $casemodel->query('rollback');
                                         $casemodel->query('autocommit');
                                         $casemodel->query('close');

                                         $goodsmodel->query("rollback");
                                         $goodsmodel->query('autocommit=true');
                                         $goodsmodel->query('close');

                                         $goodsswipermodel->query('rollback');
                                         $goodsswipermodel->query('autocommit');
                                         $goodsswipermodel->query('close');
                                         echo getInfo(false,'商品上传失败，商品规格错误,错误商品名称为：【'.$v['A'].'】2；');
                                         return false;
                                     }
                                 }
                             }
                         }else if(isset($opt1[0]) && isset($v['N'])){
					         $optis = $opt1;
					         $skt = $v['N'];
					         foreach ($optis as $koo => $voo){
                                 $option1 = $optionModel->where('uniacid='.$uniacid.' and shopid='.$shopid.' and id='.$voo)->get();
                                 $casesql = 'INSERT INTO '.$casetable.'( uniacid, shopid, goodsid,isopt,opt1,option1,price,stock,thumb) value('.$uniacid.','.$shopid.','.$id[0]['@@IDENTITY'].', 1,\''.$skt.'\',\''.$option1['name'].'\',\''.$v['B'].'\',\''.$v['E'].'\',\''.'images/'.$uniacid.'/'.$shopid.'/'.$v['I'].$v['J'].'\')';
                                 $csty = $casemodel->query($casesql);
                                 if($csty){
                                 }else{
                                     $casemodel->query('rollback');
                                     $casemodel->query('autocommit');
                                     $casemodel->query('close');

                                     $goodsmodel->query("rollback");
                                     $goodsmodel->query('autocommit=true');
                                     $goodsmodel->query('close');

                                     $goodsswipermodel->query('rollback');
                                     $goodsswipermodel->query('autocommit');
                                     $goodsswipermodel->query('close');
                                     echo getInfo(false,'商品上传失败，商品规格错误,错误商品名称为：【'.$v['A'].'】3；');
                                     return false;
                                 }
                             }
                         }else if( isset($opt2[0]) && isset($v['P'])){
                             $optis = $opt2;
                             $skt = $v['P'];

                             foreach ($optis as $koo => $voo){
                                 $option1 = $optionModel->where('uniacid='.$uniacid.' and shopid='.$shopid.' and id='.$voo)->get();
                                 $casesql = 'INSERT INTO '.$casetable.'( uniacid, shopid, goodsid,isopt,opt1,option1,price,stock,thumb) value('.$uniacid.','.$shopid.','.$id[0]['@@IDENTITY'].', 1,\''.$skt.'\',\''.$option1['name'].'\',\''.$v['B'].'\',\''.$v['E'].'\',\''.'images/'.$uniacid.'/'.$shopid.'/'.$v['I'].$v['J'].'\')';
                                 $csty = $casemodel->query($casesql);
                                 if($csty){
                                 }else{
                                     $casemodel->query('rollback');
                                     $casemodel->query('autocommit');
                                     $casemodel->query('close');

                                     $goodsmodel->query("rollback");
                                     $goodsmodel->query('autocommit=true');
                                     $goodsmodel->query('close');

                                     $goodsswipermodel->query('rollback');
                                     $goodsswipermodel->query('autocommit');
                                     $goodsswipermodel->query('close');
                                     echo getInfo(false,'商品上传失败，商品规格错误,错误商品名称为：【'.$v['A'].'】3；');
                                     return false;
                                 }
                             }
                         }
					 }else{
                         $casemodel->query('rollback');
                         $casemodel->query('autocommit');
                         $casemodel->query('close');

                         $goodsmodel->query("rollback");
                         $goodsmodel->query('autocommit=true');
                         $goodsmodel->query('close');

                         $goodsswipermodel->query('rollback');
                         $goodsswipermodel->query('autocommit');
                         $goodsswipermodel->query('close');

                         echo getInfo(false,'商品上传失败，请写入正确的商品信息，错误商品名称为：【'.$v['A'].'】1；');
                         return false;
					 }
				 }
			 }

             $casemodel->query('commit');
             $casemodel->query('autocommit=true');
             $casemodel->query('close');

             $goodsmodel->query("commit");
             $goodsmodel->query('autocommit=true');
             $goodsmodel->query('close');

             $goodsswipermodel->query('commit');
             $goodsswipermodel->query('autocommit');
             $goodsswipermodel->query('close');
             echo getInfo(true,'请上传商品压缩图片');
		 }else if($_FILES["zip"]){
             $filenamel = ZSK_PATH.'/attachment/images/'.$uniacid.'/'.$shopid;
             if (!is_dir($filenamel)) {                    //创建路径
                 mkdir($filenamel,0777,true);
             }
			 $filename = $filenamel.'/'.$_FILES["zip"]["name"];
             if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $filename)>0) {
                 echo getInfo(false,'上传Zip压缩文件不能带有中文，请修改文件名称');
                 return false;
             }
			 move_uploaded_file($_FILES["zip"]["tmp_name"],$filename);//保存文件
			 $zip = new ZipArchive();
			 $flag = $zip->open($filename);
			 if($flag!==true){
				 echo "open error code: {$flag}\n";
				 exit();
			 }
			 $zip->extractTo($filenamel);
			 $flag = $zip->close();
			 $state = $flag ? true:false;
			 if($state){
                 echo getInfo(true,'商品快捷添加成功');
			 }else{
                 echo getInfo(false,'商品上传失败');
			 }

		 }else{
             echo getInfo(false,'错误提交');
		 }

	 }



 	function daochu(){
        global $_W,$_GPC;
        $uniacid=intval($_W['uniacid']);
        $model=Model("goods");
        $name=trim($_GPC['name']);
        $shopid=getShopID();
        $where="uniacid=$uniacid and shopid=$shopid";
        if(strlen($name)){
            $where.=" and name like '%".$name."%' or number like '%".$name."%'";
            $params['name']=$name;
        }
        $page=$model->where($where)->order("sort desc")->page("*");
        $urge=Model("item")->where("uniacid=$uniacid and datatype='goods-list'")->getall("id,name");
        $goodslist=$page['dataset'];
        foreach ($goodslist as $key => $val) {
            $ids.=$val['id'].",";
        }
        if(strlen($ids)>1){
            $ids=substr($ids, 0,strlen($ids)-1);
            $tab2=$model->tablename("item");
            $tab3=$model->tablename("goodsurge");
            $sql="SELECT $tab2.name as itemname,$tab2.id as itemid,$tab3.goodsid as goodsid,$tab3.id as urid FROM $tab2 LEFT JOIN $tab3 ON $tab2.id=$tab3.itemid WHERE $tab3.goodsid in ($ids)";
            $items=$model->query($sql);
            foreach ($goodslist as $key => $val) {
                foreach ($items as $k => $v) {
                    if($val['id']==$v['goodsid']){
                        $goodslist[$key]['items'][]=$v;
                    }
                }
				$goodslist[$key]['catalog'] = '/goods/';  //商品目录
            }
        }
//		number cateid name price sellCount sellCount0 stock status itemStr unit sort insort picture picture_wide  date content content1 opt1 opt1_id opt2 opt2_id price0 video
		$indexKey = array('number','cateid','name','price','price0','sellCount','sellCount0','stock','status','catalog','sort','picture','picture_wide','content','opt1','opt1_id','opt2','opt2_id');
//        $indexKey = array('id','number','name','price','price0');
		//excel表头内容
        $header = array('number'=>'商品编号','cateid'=>'商品分类id','name'=>'商品名称','price'=>'现价','price0'=>'原价','sellCount'=>'真实销售量','sellCount0'=>'初始销售量','stock'=>'库存','status'=>'状态','catalog'=>'目录','sort'=>'店内排序','picture'=>'封面图片','picture_wide'=>'活动图片','content'=>'商品详情图','opt1'=>'规格1名称','opt1_id'=>'规格1 id','opt2'=>'规格2名称','opt2_id'=>'规格2 id');
        array_unshift($goodslist,$header);//将查询到的订单数据和表头内容合并,构造成数组list
        $this->toExcel($goodslist,'1',$indexKey,1,true);
	}

     function toExcel($list,$filename,$indexKey,$startRow=1,$excel2007=false){
         //文件引入
         // echo $pe['host_root'].'include/class/PHPExcel.php';die;
         include(ZSK_PATH.'/libs/PHPExcel-1.8/Classes/PHPExcel.php');
         include(ZSK_PATH.'/libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
         // require("/include/class/PHPExcel.php");
         // include("/include/class/PHPExcel/Writer/Excel2007.php");
         ob_end_clean();
         if(empty($filename)) $filename = time();
         if( !is_array($indexKey)) return false;

         $header_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
         //初始化PHPExcel()
         $objPHPExcel = new PHPExcel();

         //设置保存版本格式
         if($excel2007){
             $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
             $filename = $filename.'.xlsx';
         }else{
             $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
             $filename = $filename.'.xls';
         }

         //接下来就是写数据到表格里面去
         $objActSheet = $objPHPExcel->getActiveSheet();
         //$startRow = 1;
         foreach ($list as $row) {
             foreach ($indexKey as $key => $value){
                 //这里是设置单元格的内容
                 $objActSheet->setCellValue($header_arr[$key].$startRow,$row[$value]);
             }
             $startRow++;
         }

         // 下载这个表格，在浏览器输出
         header("Pragma: public");
         header("Expires: 0");
         header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
         header("Content-Type:application/force-download");
         header("Content-Type:application/vnd.ms-execl");
         header("Content-Type:application/octet-stream");
         header("Content-Type:application/download");;
         header('Content-Disposition:attachment;filename='.$filename.'');
         header("Content-Transfer-Encoding:binary");
         $objWriter->save('php://output');
     }

     /**
      * @throws PHPExcel_Writer_Exception
      * 下载文件
      */
     public function excelDownload(){
         include(ZSK_PATH.'/libs/PHPExcel-1.8/Classes/PHPExcel.php');
         include(ZSK_PATH.'/libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

         $file_name = "Excel实例文件.xlsx";     //下载文件名
         $file_dir = dirname(ZSK_STATIC)."/static/xiazai/".$file_name; //下载文件存放目录
//         var_dump(file_exists($file_dir));
//         var_dump($file_dir);die;
         ob_end_clean();
         $objPHPExcel = new PHPExcel();
         $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
         // 下载这个表格，在浏览器输出
         header("Pragma: public");
         header("Expires: 0");
         header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
         header("Content-Type:application/force-download");
         header("Content-Type:application/vnd.ms-execl");
         header("Content-Type:application/octet-stream");
         header("Content-Type:application/download");;
         header('Content-Disposition:attachment;filename='.$file_name.'');
         header("Content-Transfer-Encoding:binary");
         $objWriter->save(ZSK_STATIC ."/static/xiazai/". $file_name);
     }

     public function zipDownload(){
         $file_name = "Zip实例文件.zip";     //下载文件名
         $file_dir = dirname(ZSK_STATIC)."/xiazai/".$file_name;
         header('Content-Type:text/html;charset=utf-8');
         header('Content-disposition:attachment;filename='.$file_name);
         $filesize = filesize( ZSK_STATIC.'xiazai/'.$file_name);
//         readfile($file_dir);
         header('Content-length:'.$filesize);
     }

 	function search3(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("goods");

 		$name=trim($_GPC['name']);
 		$where="uniacid=$uniacid";
 		if(strlen($name)){
 			$where.=" and name like '%".$name."%' or number like '%".$name."%'";
 		}
 		$res=$model->where($where)->limit(3)->getall("*");
 	   	echo JSON_OUT($res,true);
 	}
  	function optionview(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$shopid=getShopID();
 		$model=Model("goodsoption");

 		$res=$model->where("uniacid=".$uniacid." and shopid=".$shopid)->getall("*,parentid as pid");
 		$options=childtree($res);
 		include $this->template("web/goods/goods-option");
 	}
 	function save(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$shopid=getShopID();

 		$price=floatval($_POST['price']);
		$stock=intval($_POST['stock']);
		$name=trim($_POST['name']);
		$content=trim($_GPC['content']);

		$gid=intval($_POST['gid']);


 		$model=Model("goods");
        $after_sale = htmlspecialchars($_GPC['after_sale'],ENT_QUOTES );
        $after_saleitl = htmlspecialchars($_GPC['after_saleitl']);
        //$after_saleitl =str_replace('&amp;nbsp','&nbsp', $after_saleitl);
        $cateid = (intval($_POST['cateid']) && intval($_POST['cateidone'])) ? intval($_POST['cateidone']) : intval($_POST['cateid']);
        $goods0=array("price"=>$price,
            "price0"=>floatval($_GPC['price0']),
            "cateid"=>$cateid,
            "name"=>$name,
//            "content"=>$content,
            "stock"=>$stock,
            "picture"=>$_GPC['picture'],
            "picture_wide"=>$_GPC['picture_wide'],
            "uniacid"=>$_W['uniacid'],
            "date"=>time(),
            "updatetime"=>time(),
            "status"=>intval($_POST['sts']),
            "sellCount0"=>intval($_GPC['sellCount0']),
            "brandid"=>intval($_GPC['brandid']),
            "delivery"=>intval($_GPC['delivery']),
            "wechat_payment"=>intval($_GPC['wechat_payment']),
            "sale"=>intval($_GPC['sale']),
            "after_sale"=>trim($after_sale),
            "content"=>trim($after_saleitl),
        );

		$goods=$model->where("uniacid=$uniacid and id=$gid and shopid=$shopid")->get();//验证是否商品属于该店铺
		$case0=array(
			"goodsid"=>$gid,
			"isopt"=>0,
			"shopid"=>$shopid,
			"uniacid"=>$uniacid,
			"price"=>$goods0['price'],
			"thumb"=>$goods0['picture'],
			"stock"=>$goods0['stock']
		);
		if(intval($goods['id'])>0){
			$res=$model->where("id=".$gid." and  uniacid=$uniacid and shopid=$shopid ")->save($goods0);
			$res3=Model("goodscase")->where("goodsid=".$goods['id']." and isopt=0")->get();
			if($res3){
				Model("goodscase")->where("goodsid=".$goods['id']." and isopt=0")->save($case0);
			}else{
				Model("goodscase")->add($case0);
			}
		}else{
			$goods0['sort']=intval($_GPC['sort']);
			$goods0['shopid']=$shopid;
			$gid=$model->add($goods0);
			if($gid){
				$case0['goodsid']=$gid;
				Model("goodscase")->add($case0);
				$model->where("id=".$gid)->save(array("number"=>(100000+$gid)));
			}else{
				message("保存失败");
			}
		}
		$pics=$_GPC['pics'];
		if(count($pics)){
			$m2=Model("goodsswiper");
			$m2->delete("uniacid=$uniacid and goodsid=$gid");
			foreach ($pics as $key => $val) {
				$swip=array('goodsid'=>$gid,"uniacid"=>$uniacid,"path"=>$val,"status"=>1,"date"=>time());
				$m2->add($swip);
			}
		}
        $pics=$_GPC['goodspic'];
        if(count($pics)){
            $m2=Model("goodspic");
            $m2->delete("uniacid=$uniacid and goodsid=$gid");
            foreach ($pics as $key => $val) {
                $swip=array('goodsid'=>$gid,"uniacid"=>$uniacid,"path"=>$val,"status"=>1,"date"=>time());
                $m2->add($swip);
            }
        }
        $pics=$_GPC['goodsafter'];
        if(count($pics)){
            $m2=Model("goodsafter");
            $m2->delete("uniacid=$uniacid and goodsid=$gid");
            foreach ($pics as $key => $val) {
                $swip=array('goodsid'=>$gid,"uniacid"=>$uniacid,"path"=>$val,"status"=>1,"date"=>time());
                $m2->add($swip);
            }
        }
		if(intval($goods['id'])>0){
			message("保存成功",$this->routeUrl("goods.editview")."&gid=".$gid);
		}else{
			message("保存成功",$this->routeUrl("goods.listview"));
		}

		exit;
	}

	function editview(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("goods");
 		$shopid=getShopID();
		$gid=intval($_GPC['gid']);
		$goods=$model ->where("id=".$gid." and uniacid=$uniacid and shopid=$shopid")->get("*");
        $goods['content'] = htmlspecialchars_decode( $goods['content']);
        $goods['after_sale'] = htmlspecialchars_decode($goods['after_sale']);
//        if(count($content)){
//            $goods['content']='';
//            foreach ($content as $k => $v){
//                if($v) {
//                    $goods['content'] .= '<img src="' . $_W['attachurl'] . $v . '" />';
//                }
//            }
//        }

//		if(count($after_sale)){
//            $goods['after_sale']='';
//            foreach ($after_sale as $k => $v){
//                if($v){
//                    $goods['after_sale'].='<img src="'.$_W['attachurl'].$v.'" />';
//                }
//            }
//        }
		$m2=Model("category");
	 	$cates=$m2->where("uniacid=$uniacid and status=1")->getall("*,parentid as pid");

	 	$goodscate=$m2->where("id=".intval($goods['cateid']))->get();
	 	$swipers=array();
	 	$m3=Model("goodsswiper");

	 	$res=$m3->where("goodsid=$gid and uniacid=$uniacid and goodsid>0")->getall();
//        $brand = model('brand')->where("uniacid=$uniacid and shopid=$shopid")->getall();
	 	foreach ($res as $key => $val) {
	 		array_push($swipers, $val['path']);
	 	}
	 	$cates=childtree($cates);
        $res =  Model("goodspic")->where('uniacid='.$uniacid.' and goodsid='.$goods['id'].' and goodsid !=0')->getall('path');
        $goodspic = array();
        foreach ($res as $key => $val) {
            array_push($goodspic, $val['path']);
        }
        $goodsafter = array();
        $res = Model("goodsafter")->where('uniacid='.$uniacid.' and goodsid='.$goods['id'].' and goodsid !=0')->getall('path');
        foreach ($res as $key => $val) {
            array_push($goodsafter, $val['path']);
        }
		include $this->template("web/goods/goods-edit");
		exit;
	}

	function optkdi(){
        global $_W,$_GPC;
        $uniacid=intval($_W['uniacid']);
        $shopid=getShopID();
        $category_id = $_GPC['category_id'];
        $m2=Model("category");
        $cates=$m2->where("uniacid=$uniacid and id=$category_id")->getall();
        $brandModel=Model('brand');
        if($cates[0]['parentid']){
            $catesone=$m2->where("uniacid=".$uniacid." and status=1 and parentid=".$cates[0]['parentid'])->getall();
            $brand = $brandModel->where("uniacid=".$uniacid." and status=1 and category_id=".$cates[0]['parentid'])->getall();
        }else{
            $catesone=$m2->where("uniacid=".$uniacid." and status=1 and parentid=".$category_id)->getall();
            $brand = $brandModel->where("uniacid=$uniacid  and status=1 and category_id=$category_id")->getall();
        }
        echo JSON_OUT(['brand'=>$brand,'catesone'=>$catesone]);
    }

	function swipview(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("goodsswiper");
 		$gid=intval($_GPC['gid']);
 		$goods=M("goods")->where("uniacid=$uniacid and id=$gid")->get();
 		$swip=$model->where("goodsid=$gid")->order("sort desc")->getall("*");

 		include $this->template("web/goods/goods-swip");
	}

	function uploadswip(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		if(strlen(trim($_POST['picture']))){
 				$model=Model("goodsswiper");
	 		$swip=array(
	 			"path"=>$_POST['picture'],
	 			"goodsid"=>$_GPC['gid'],
	 			"sort"=>intval($_GPC['sort']),
	 			"uniacid"=>$uniacid
	 		);
	 		$res=$model->add($swip);
	 		if($res){
	 			message("添加成功",$this->routeUrl("goods.swipview")."&gid=".intval($_GPC['gid']));
	 		}else{
	 			message("添加失败");
			}
 		}else{
 			message("添加失败,缺少图片");
		}

 	}
 	function delSwip(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("goodsswiper");
 		$model->limit(1)->delete("uniacid=$uniacid and id=".intval($_GPC['sid']));

 		 message("删除成功",$this->routeUrl("goods.swipview")."&gid=".intval($_GPC['gid']));
 	}
	/*
	function uploadpicture(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);

 		$model=Model("goodspic");
 		$swip=array(
 			"path"=>$_POST['picture'],
 			"goodsid"=>$_GPC['gid'],
 			"sort"=>intval($_GPC['sort']),
 			"uniacid"=>$uniacid,
 			"status"=>1
 		);
 		$res=$model->add($swip);
 		if($res){
 			message("添加成功",$this->routeUrl("goods.pictureview")."&gid=".intval($_GPC['gid']));
 		}else{
 			message("添加失败");
		}
 	}
 	function delpicture(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("goodspic");
 		$model->limit(1)->delete("uniacid=$uniacid and id=".intval($_GPC['sid']));
 		 message("删除成功",$this->routeUrl("goods.pictureview")."&gid=".intval($_GPC['gid']));
 	}*/
 	function caseview(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("goodscase");
 		$gid=intval($_GPC['gid']);
 		$shopid=getShopID();
 		$goods=M("goods")->where("uniacid=$uniacid and id=$gid and shopid=$shopid")->get();
 		$options0=M("goodsoption")->where("uniacid=".$uniacid." and shopid=".$shopid) ->getall("*,parentid as pid");
 		$options=childtree($options0);
 		$cases=$model->where("goodsid=".$gid." and shopid=".$shopid." and uniacid=".$uniacid." and status>0 and isopt>0")->order("option1 asc")->getall();
 		$length_opt2=$model->group("option2")->where("uniacid=".$uniacid." and goodsid=".$gid." and isopt>0")->count();

 		if(intval($length_opt2)<1)$length_opt2=1;
 		include $this->template("web/goods/goods-case2");
	}
	function delGoods(){
		global $_W,$_GPC;
		$model=Model("goods");
		$uniacid=intval($_W['uniacid']);
		$goodsid=intval($_GPC['goodsid']);
		$shopid=getShopID();
		$goods=$model->where("id=$goodsid and shopid=".$shopid)->get();
		$res=$model->delete("id=$goodsid and uniacid=$uniacid and shopid=$shopid");
		if($res){
			M("goodscase")->delete("goodsid=$goodsid and uniacid=$uniacid");
			M("goodspic")->delete("goodsid=$goodsid ");
			M("goodsswiper")->delete("goodsid=$goodsid ");
			M("item")->delete("`goodsnum`=".$goods['number']);
			M("membercart")->delete("goodsid=$goodsid");
			M("collection")->delete("goodsid=$goodsid");
			message("删除成功",$this->routeUrl("goods.listview"));
		}else{
			 message("删除失败",$this->routeUrl("goods.listview"),"error");
		}
	}
	function getOptions0(){
		global $_W,$_GPC;
		$model=Model("goodsoption");
		$uniacid=intval($_W['uniacid']);

		$options=$model->where("uniacid=$uniacid and parentid=0 ")->getall("*");
		echo JSON_OUT($options);
	}
	function getOptByPid(){
			global $_W,$_GPC;
		$model=Model("goodsoption");
		$uniacid=intval($_W['uniacid']);
		$pid=intval($_GPC['pid']);
		$options=$model->where("uniacid=$uniacid and parentid=$pid")->getall("*");
		echo JSON_OUT($options);
	}
	function saveOption2(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$oid=intval($_GPC['oid']);
 		$goodsid=intval($_GPC['goodsid']);
 		$shopid=getShopID();
 		$options=$_POST['options'];
 		$opts=array();
 		foreach ($options as $key => $val) {
 			foreach ($val as $k => $v) {
 				if(strlen(trim($v))>0&& strlen(trim($v))<60){//一个汉子utf8 占3个字符长度
 					$opt=array(
	 					"name"=>$v,
	 					"uniacid"=>$uniacid,
	 					"shopid"=>$shopid,
	 					"status"=>1,
	 					"parentid"=>$key,
	 				);
	 				array_push($opts, $opt);
 				}
 			}
 		}
 		$model=Model("goodsoption");
        $res = $model->addall($opts);
        // var_dump($res);die();
 		message("保存成功",$this->routeUrl("goods.optionview"));
	}
	function saveOption(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$oid=intval($_GPC['oid']);
 		$goodsid=intval($_GPC['goodsid']);
 		$shopid=getShopID();
 		if($_GPC['name'] == ''){
            message("请填写属性名称");
        }
 		$option=array(
 			'name'=>$_GPC['name'],
 			'uniacid'=>$uniacid,
 			"parentid"=>intval($_GPC['parentid']),
 			"shopid"=>$shopid,
 			"status"=>1
 		);

	 	Model("goodsoption")->add($option);
	 	message("保存成功",$this->routeUrl("goods.optionview"));
	}
	function editcase(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$shopid=getShopID();
 		$model=Model("goodscase");
 		$caseid=intval($_GPC['caseid']);
 		$goodsid=intval($_GPC['goodsid']);
 		$case=$model->where("goodsid=$goodsid and id=$caseid") ->get("*");
		$goods=M("goods")->where("uniacid=$uniacid and id=$goodsid")->get();
		$where.="uniacid=$uniacid and parentid>0 and shopid=".$shopid;
		if(intval($goods['opt1_id'])<1&& intval($goods['opt2_id'])<1){
			message("商品属性关系已失效，请重新保存商品属性后重试");
		}
		if(intval($goods['opt1_id'])){
			$options1=Model("goodsoption")->where($where." and parentid=".$goods['opt1_id'])->getall();
		}
		if(intval($goods['opt2_id'])){
			$options2=Model("goodsoption")->where($where." and parentid=".$goods['opt2_id'])->getall();
		}

 		include $this->template("web/goods/goods-case-edit");
	}
	function saveCase(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$shopid=getShopID();
 		$cid=intval($_GPC['caseid']);
 		$goodsid=intval($_GPC['goodsid']);
 		$case=array(
 			"goodsid"=>$_GPC['goodsid'],
 			"uniacid"=>$uniacid,
 			"shopid"=>$shopid,
 			"date"=>time(),
 			"option1"=>$_GPC['option1'],
 			"option2"=>$_GPC['option2'],
 			"opt1"=>$_GPC['opt1'],
 			"opt2"=>$_GPC['opt2'],
 			"stock"=>intval($_GPC['stock']),
 			"price"=>floatval ($_GPC['price']),
 			"thumb"=> ($_GPC['thumb']),
 			"status"=>1,
 		);
		$model=Model("goodscase");
		$case0=$model->where("goodsid=".$goodsid." and uniacid=".$uniacid." and option1='".$_GPC['option1']."' and option2='".$_GPC['option2']."'")->get();

		if($cid>0){
			if(!empty($case0)&& $case0['id']!=$cid){
				message("保存失败，已有相同规格");
			}else{
				$model->where("id=$cid and goodsid=$goodsid and uniacid=$uniacid and shopid=".$shopid)->limit(1)->save($case);
 				message("保存成功",$this->routeUrl("goods.caseview")."&gid=".$goodsid);
			}

 		}else{
 			if(!empty($case0)){
				message("保存失败，已有相同规格");
			}else{
				$res=$model->add($case);
	 			if($res){
	 				message("添加成功",$this->routeUrl("goods.caseview")."&gid=".$goodsid);
	 			}else{
	 				message("添加失败");
	 			}
			}

 		}

	}
	function delCase(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("goodscase");
 		$cid=intval($_GPC['cid']);
 		$case=$model->where("id=".$cid)->get();

 		$shopid=getShopID();
 		$model->limit(1)->delete("shopid=$shopid and uniacid=$uniacid and id=".$cid);
 		$count=$model->where("goodsid=".intval($case['goodsid'])." and isopt>0")->count();
 		$m2=Model("goods");
 		if($count<1){
 			$m2->limit(1)->where("id=".intval($case['goodsid']))->save(array("opt1"=>"","opt2"=>""));
 		}
 		message("删除成功",$this->routeUrl("goods.caseview")."&gid=".intval($_GPC['goodsid']));
	}
	function delOption(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("goodsoption");
 		$optid=intval($_GPC['oid']);
 		$shopid=getShopID();
 		$res=$model->delete("uniacid=$uniacid and shopid=".$shopid." and (id=".$optid." or parentid=".$optid.")");
 		message("删除成功",$this->routeUrl("goods.optionview") );
	}
	function saveProperty(){
		$goods=array("opt1"=>'',"opt2"=>'',"opt1_id"=>'',"opt2_id"=>'');
		if(!empty( $_POST['prop'][0])){
			foreach ($_POST['prop'][0] as $key => $val) {
				$goods['opt1']=$val;
				$goods['opt1_id']=intval($key);

			}
		}
		if(!empty($_POST['prop'][1])){
			foreach ($_POST['prop'][1] as $key => $val) {
				$goods['opt2']=$val;
				$goods['opt2_id']=intval($key);
			}
		}

		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$shopid=getShopID();
 		$goodsid=intval($_GPC['goodsid']);
        $casemodel=Model("goodscase");
        $cases=$casemodel->where("goodsid=$goodsid and status>0 and isopt>0")->order("option1 asc")->getall();
        if(count($cases)){
            foreach ($cases as $k=>$v){
                if($v['opt1'] != $goods['opt1'] && $v['opt1'] != $goods['opt2'] && $v['opt2'] != $goods['opt1'] && $v['opt2'] != $goods['opt2']){
                    message("更新失败，商品规格与商品属性不符，请重新选择",$this->routeUrl("goods.caseview")."&gid=".$_GPC['goodsid']);
                }
            }
        }
 		$model=Model("goods");
 		$model->where("id=".$goodsid." and uniacid=".$uniacid." and shopid=".$shopid)->limit(1)->save($goods);
        unset($goods['opt1_id']);
 		unset($goods['opt2_id']);
 		Model("goodscase")->where("goodsid=".$goodsid." and uniacid=".$uniacid." and isopt>0")->save($goods);

		message("更新成功",$this->routeUrl("goods.caseview")."&gid=".$_GPC['goodsid']);
	}
	function makeCase(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$shopid=getShopID();
 		$goodsid=intval($_GPC['goodsid']);
 		$model=Model("goods");
 		$goods=$model->where("id=$goodsid")->get();
 		Model("discount")->where("uniacid=".$uniacid." and shopid=".$shopid." and goodsid=".intval($goods['id']))->save(array("status"=>0));
 		$model->where("id=".$goodsid." and uniacid=".$uniacid." and shopid=".$shopid)->limit(1)->save(array("opt1"=>$_GPC['opt0'],"opt2"=>$_GPC['opt1']));


		$model=Model("goodscase");
		$pid0=array();
		$post=$_POST;
		$model->where("goodsid=$goodsid and uniacid=$uniacid and isopt>0")->delete();
	 	$option0=$_GPC['op0'];
	 	$option1=$_GPC['op1'];
	 	$cases=array();

	 	foreach ($option0 as $k0 => $v0) {
	 		if(strlen(trim($v0))>0){
		 		$case= array(
					"shopid"=>$shopid,
					"goodsid"=>$goodsid,
					"uniacid"=>$uniacid,
					"isopt"=>1,
					"option1"=>$v0,
					"opt1"=>$_GPC['opt0'],
//					"date"=>time(),
					"price"=>$goods['price'],
					"stock"=>100,
					"thumb"=>$goods['picture'],
					"status"=>1
				);
				if(count($option1)>0){
					foreach ($option1 as $k1 => $v1) {
						$case['opt2']=$_GPC['opt1'];
						$case['option2']=$v1;
						array_push($cases, $case);
					}
				}else{
					array_push($cases, $case);
				}
			}
	 	}
		$model->addall($cases);
		message("更新成功",$this->routeUrl("goods.caseview")."&gid=".$_GPC['goodsid']);
	}
	function chgStatus(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$goodsid=intval($_GPC['gid']);
 		$model=Model("goods");
 		$model->where("uniacid=$uniacid and id=$goodsid")->limit(1)->save(array("status"=>intval($_GPC['status'])));
 		if($_GPC['ref']=="manage"){
 			message("操作成功",$this->routeUrl("shops.goodsview"));
 		}else{
 			message("操作成功",$this->routeUrl("goods.listview"));
 		}

	}


	//修改商品排序
	function chgSort(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$goodsid=intval($_GPC['goodsid']);
 		$model=Model("goods");
 		$model->where("uniacid=$uniacid and id=$goodsid")->limit(1)->save(array("sort"=>intval($_GPC['sort'])));
 		message("保存成功",$this->routeUrl("goods.listview"));
	}
	public function saveCaseStock(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$goodsid=intval($_GPC['goodsid']);
 		$model=Model("goods");
 		$cids=$_GPC['cid'];
 		$prices=$_GPC['price'];
 		$stocks=$_GPC["stock"];
 		if(count($cids)==count($prices)&& count($cids)==count($stocks)){
 			$idstr="";$stockCase="";$priceCase="";
 			foreach ($cids as $k => $v) {
 				$idstr.=$v.",";
 				$priceCase.=" WHEN ".$v." THEN ".$prices[$k]." ";
 				$stockCase.=" WHEN ".$v." THEN ".$stocks[$k]." ";
 			}
 			if(strlen($idstr)>0){
 				$idstr=substr($idstr, 0,strlen($idstr)-1);
	 			$tab=$model->tablename("goodscase");
	 			$sql="UPDATE $tab SET price= CASE id $priceCase END ,stock = CASE id $stockCase END WHERE id in ($idstr);";
	 			$model->query($sql);

 			}

 		}
 		message("保存成功",$this->routeUrl("goods.caseview")."&gid=".intval($_GPC['gid']));
	}
	function saveUrge(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$goodsid=intval($_GPC['goodsid']);
 		$itemid=intval($_GPC['itemid']);
 		isManager(true);//验证是不是管理员
 		$model=Model("goodsurge");
 		$data=array(
 			"sort"=>intval($_GPC["sort"]),
 			"uniacid"=>$uniacid,
 			"itemid"=>$itemid,
 			"goodsid"=>intval($_GPC['goodsid']),
 			"status"=>1
 		);
 		$ex=$model->where("uniacid=$uniacid and goodsid=$goodsid and itemid=$itemid")->get();
 		if(!empty($ex)){

 		}else{
 			$model->add($data);
 		}
 		message("保存成功",$this->routeUrl("goods.listview"));
	}
	function cancelItem(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$goodsid=intval($_GPC['goodsid']);
 		$urid=intval($_GPC['urid']);

 		$model=Model("goodsurge");
 		$model->limit(1)->delete("uniacid=$uniacid and id=$urid");
 		message("保存成功",$this->routeUrl("goods.listview"));
	}
	function getCases(){
		//获取活动规格
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$goodsid=intval($_GPC['goodsid']);
//        var_dump(123);
 		$model=Model("goodscase");
 		$cases['default']=$model->where("goodsid=$goodsid and uniacid=$uniacid and isopt=0")->get();
		$cases['opts']=$model->order("opt1 asc,opt2 asc")->where("goodsid=$goodsid and uniacid=$uniacid and isopt>0 and status>0")->getall();
//        var_dump($model);die;
		$cases['opt1']=$model->group("opt1")->where("opt1 is not null and opt1 <>'' and goodsid=$goodsid and uniacid=$uniacid and isopt>0 and status>0")->get("opt1 as `text`");
		$cases['opt2']=$model->group("opt2")->where("opt2 is not null and opt2 <>'' and goodsid=$goodsid and uniacid=$uniacid and isopt>0 and status>0")->get("opt2 as `text`");
		$did=intval($_GPC['did']);
		$isle = $cases['opts'];

		if($did>0){
			$discount=Model("discount")->where("id=$did")->get();
			$cases2=json_decode($discount['casejson'],true);
            foreach ($cases2 as $key => $val) {
                if(count($isle)){
                    foreach ($isle as $k => $v) {
                        if(!$isle[$k]['qwsa'] || $isle[$k]['qwsa']>1){
                            if($val['caseid']==$v['id'] ){
                                $isle[$k]['stock']=$val['stock'];
                                $isle[$k]['price']=$val['price'];
                                $isle[$k]['qwsa']=1;
                            }else{
                                $isle[$k]['qwsa']=2;
                            }
                        }
                        if(intval($val['caseid'])==intval($cases['default']['id'])){

                            $cases['default'][$key]['stock']=$val['stock'];
                            $cases['default'][$key]['price']=$val['price'];
                        }
                    }
                }
//                else{
//                    $cases['default']['stock']=$val['stock'];
//                    $cases['default']['price']=$val['price'];
//                }
            }
		}else{
            foreach ($cases['opts'] as $k => $v) {
                $isle[$k]['qwsa']=3;
            }
        }
        $cases['opts'] = $isle;
 		echo JSON_OUT($cases,true);
	}


}
?>