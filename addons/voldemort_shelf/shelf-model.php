<?php

class Shelfs{

	public static function slides(){
		$slidesModel = new slidesModel();
		$slides = $slidesModel->all();
	}
	
	public static function all_cat(){
		global $_W;
		$cats = array();

		$tb = 'article_shelf';
		$all = pdo_fetchall("SELECT * FROM " . tablename($tb) . " WHERE `uniacid`=:uniacid ORDER BY id DESC", array(':uniacid'=>$_W['uniacid']));
		foreach ($all as $key => $item) {
			$cat = new Shelf((int)$item['id']);
			$cats[] = $cat;
		}
		return $cats;
	}


	public static function add($title='', $slides=array(), $atl_cats=array()){
		$shelfModel = new Shelf();
		$shelfModel->title = $title;
		$shelfModel->slides = $slides;
		$shelfModel->atl_cats = $atl_cats;
		return $shelfModel->save();
	}

	public static function cat_id($catId){
		return new Shelf((int)$catId);
	}


	public static function cat_name($catName){
		return new Shelf($catName);
	}


	public static function rm($catId){
		$shelfModel = new Shelf((int)$catId);
		return $shelfModel->rm();
	}

	public static function modify($new=array(), $id){
		$shelfModel = new Shelf((int)$id);
		foreach ($new as $key => $value) {
			$shelfModel->$key = $value;
		}
		return $shelfModel->save();
	}


}

class Shelf{
	private $tb = 'article_shelf';
	public $id = '';
	public $title = '';
	public $slides = array();
	public $atl_cats = array();
	public $link = '';
	public $uniacid = '';

	public function __construct($idOrName=null){
		global $_W;
		$this->uniacid = $_W['uniacid'];
		if(is_integer($idOrName)){
			$this->init(array('id'=>$idOrName));
		}elseif(is_string($idOrName)){
			$this->init(array('title'=>$idOrName));
		}

	}

	public function rm(){
		return pdo_delete($this->tb, array('id'=>$this->id));
	}

	private function init($params=array()){
		global $_W;
		$where = '';
		foreach ($params as $key => $value) {
			if(is_integer($value)){
				$where .= " `$key`=$value AND ";
			}else{
				$where .= " `$key`='$value' AND ";
			}
			
		}
		$sql = "SELECT * FROM ".tablename($this->tb);
		if(!empty($where)){

			$sql.= " WHERE ".substr($where, 0, -4);
		}
		$res = pdo_fetch($sql);
		if(empty($res)){
			// message('初始化时失败.sql:'.$sql.'line:'.__LINE__,'','error');
			$res = array('id'=>0, 'title'=>'', 'slides'=>array(), 'atl_cats'=>array(), 'uniacid'=>$_W['uniacid']);
		}
		$this->set_parameter($res);
		
	}

	private function set_parameter($res=array()){
		$this->id = $res['id'];
		$this->title = $res['title'];
		$this->slides = empty($res['slides']) ? array() : json_decode($res['slides'], true);
		$this->atl_cats = empty($res['atl_cats']) ? array() : json_decode($res['atl_cats'], true);
	}

	public function get_parameter(){
		return array('id'=>$this->id,
					 'title'=>$this->title,
					 'slides'=>$this->slides,
					 'atl_cats'=>$this->atl_cats,
					 'uniacid'=>$this->uniacid,
					 );
	}

	public function get_parameter_json(){
		return array('id'=>$this->id,
					 'title'=>$this->title,
					 'slides'=>json_encode($this->slides),
					 'atl_cats'=>json_encode($this->atl_cats),
					 'uniacid'=>$this->uniacid,
					 );
	}
	
	public function save(){
		if(!empty($this->id)){
			return pdo_update($this->tb, $this->get_parameter_json(), array('id'=>$this->id));
		}
		return pdo_insert($this->tb, $this->get_parameter_json());
	}

	
}