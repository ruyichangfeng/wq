 <?php
 class Priterupdate extends ZskPage
 { 
 	public function index(){
 		 global $_W,$_GPC;
 		$model=Model("order");
 		$order_no="20180623150200924";
 		$result=$model->where($order_no)->get();
 		include $this->template("web/temp/priter");
 	} 

}