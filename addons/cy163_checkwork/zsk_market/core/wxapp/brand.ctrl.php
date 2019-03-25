<?php
class Brand extends ZskWxapp{
	//查询所有品牌
	public function  brandr(){
		global $_W,$_GPC;
		$model=Model("brand");
		$uniacid=intval($_W['uniacid']);
		$cateid = intval($_GPC['cateid']);
		$search  = $_GPC['search'];
		$where = "";
		if($search){
			$str=trim($search);
			$str = $this->emptyreplace($str);
			$data = explode(',',$str);
			$where .=" uniacid=".$_W['uniacid'];
			if(count($data)>0){
				$where .=" and (";
				for($i=0;$i<count($data);$i++) {
					$where .=" name like '%".$data[$i]."%'";
					if($i<intval(count($data))-1){
						$where .=" or";
					}
				}
				$where .=')';
			}
			$res = Model('goods')->where($where)->group("brandid")->getall();
			$data = array();
			foreach ($res as $v) {
				if($v['brandid']>0){
					$data[] = intval($v['brandid']);
				}
			}
			$where ="";
			if(count($data)>0){
				$where .= "(";
				for($i=0;$i<count($data);$i++) {
					$where .=" id =".$data[$i]."";
					if($i<intval(count($data))-1){
						$where .=" or";
					}
				}
				$where .=" ) and ";
			}
		}
		if($cateid){
			$res = Model("category")->where("id=$cateid")->get('parentid');
			if ($res['parentid']!=0) {
				$where .= "category_id=".intval($res['parentid'])." and";
			}else{
				$where .="category_id=".intval($cateid)." and ";
			}
		}
		$where .=" uniacid=$uniacid and status=1";
		$brand=$model->where($where)->order("sort desc")->getall();
		echo JSON_OUT($brand);
	}
	public function onemoney(){
		global $_W,$_GPC;
		$model=Model("brand");
		$uniacid=intval($_W['uniacid']);
		$cateid = intval($_GPC['cateid']);
		$search  = $_GPC['search'];
		$where = "";
		$a = $model->tablename("goods");
		$b = $model->tablename("activities");
		$c = $model->tablename("snapup");
		if($search){
			$str=trim($search);
			$str = $this->emptyreplace($str);
			$data = explode(',',$str);
			$where .=" and $a.uniacid=".$_W['uniacid']." and ";
			if(count($data)>0){
				for($i=0;$i<count($data);$i++) {
					$where .=" $a.name like '%".$data[$i]."%'";
					if($i<intval(count($data))-1){
						$where .=" or";
					}
				}
			}
			$sql = "SELECT $a.* FROM $a INNER JOIN $b ON $a.id = $b.goodsid INNER JOIN $c ON $b.activityid = $c.id WHERE $c.starttime<".time()." and $c.endtime>".time()." and $b.judgeid=1 ".$where." group by $a.brandid ";
			$res = $model->query($sql);
			// $res = Model('goods')->where($where)->group("brandid")->getall();
			$data = array();
			foreach ($res as $v) {
				if($v['brandid']>0){
					$data[] = intval($v['brandid']);
				}
			}
			$where  = "";
			if(count($data)>0){
				$where .= "(";
				for($i=0;$i<count($data);$i++) {
					$where .=" id =".$data[$i]."";
					if($i<intval(count($data))-1){
						$where .=" or";
					}
				}
				$where .=" ) and ";
			}
		}else{
			$sql = "SELECT $a.* FROM $a INNER JOIN $b ON $a.id = $b.goodsid INNER JOIN $c ON $b.activityid = $c.id WHERE $c.starttime<".time()." and $c.endtime>".time()." and $b.judgeid=1 group by $a.brandid ";
			$res = $model->query($sql);
			$data = array();
			foreach ($res as $v) {
				if($v['brandid']>0){
					$data[] = intval($v['brandid']);
				}
			}
			$where  = "";
			if(count($data)>0){
				$where .= "(";
				for($i=0;$i<count($data);$i++) {
					$where .=" id =".$data[$i]."";
					if($i<intval(count($data))-1){
						$where .=" or";
					}
				}
				$where .=" ) and ";
			}
		}
		if($cateid){
			$res = Model("category")->where("id=$cateid")->get('parentid');
			$where .= "category_id=".intval($res['parentid'])." and";
		}
		$where .=" uniacid=$uniacid and status=1";
		// var_dump($where);die();
		$brand=$model->where($where)->order("sort desc")->getall();
		echo JSON_OUT($brand);
	}
		/* 
	}

* 关键词中的空格替换为',' 

*/

		public function emptyreplace($str) { 

		$str = str_replace('　', ' ', $str); //替换全角空格为半角 

		$str = str_replace(' ', ' ', $str); //替换连续的空格为一个 

		$noe = false; //是否遇到不是空格的字符 

		for ($i=0 ; $i<strlen($str); $i++) { //遍历整个字符串 

		if($noe && $str[$i]==' ') $str[$i] = ','; //如果当前这个空格之前出现了不是空格的字符 

		elseif($str[$i]!=' ') $noe=true; //当前这个字符不是空格，定义下 $noe 变量 

		} 

		return $str; 

		} 
	public function getcate1(){
		global $_W,$_GPC;
		$model=Model("category");
		$uniacid=intval($_W['uniacid']);
		$res=array("type"=>0);//0为分类，1位商品
		$res['data']=$model->where("uniacid='".$_W['uniacid']."' and parentid=".intval($_GPC['cateid']))->order("sort desc")->getall("id,name,logo,status");
		if(count($res['data'])<1){
			$m3=Model("goods");
			$goods=$m3->where("cateid=".intval($_GPC['cateid'])." and uniacid=$uniacid and status>0")->limit(50)->order("sort desc")->getall("id,name,picture as logo,price");
			$res['data']=getGoodsSimpleInfo($goods);
			$res['type']=1; 
		}
		if(count($res['data'])>=1){
			$m3=Model("goods");
			$goods=$m3->where("cateid=".intval($_GPC['cateid'])." and uniacid=$uniacid and status>0")->limit(50)->order("sort desc")->getall("id,name,picture as logo,price");
			$res['datag']=getGoodsSimpleInfo($goods);
		}
		foreach ($res['datag'] as $key => $val) {
			if(strlen($val['logo'])>5){
				$res['datag'][$key]['src']=$_W['attachurl'].$val['logo'];
			}
		}
		foreach ($res['data'] as $key => $val) {
			if(strlen($val['logo'])>5){
				$res['data'][$key]['src']=$_W['attachurl'].$val['logo'];
			}
		}
		echo JSON_OUT($res,true);
	} 
}
	 