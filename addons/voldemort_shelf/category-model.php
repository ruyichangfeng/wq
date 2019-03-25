<?php
function cat_id2name($catId){
	$cat = Categories::cat_id($catId);
	return $cat->title;
}

/*所有文章分类*/
function cats_array_obj(){
	return Categories::all_cat();
}


/*获取文章的分类信息*/
function media_cats($mediaId){
	global $_W;
	$res = pdo_fetchall("SELECT * FROM " . tablename('article_shelf_relation') . " WHERE `uniacid`=:uniacid AND `media_id`=:media_id ORDER BY id DESC", array(':uniacid'=>$_W['uniacid'], ':media_id'=>$mediaId));
	$cats = array();
	if(!empty($res)){
		foreach ($res as $key => $item) {
			$cat = pdo_fetch("SELECT * FROM " . tablename('shelf_article_category') . " WHERE `uniacid`=:uniacid AND `id`=:id ORDER BY id DESC", array(':uniacid'=>$_W['uniacid'], ':id'=>$item['cat_id']));
			if(!empty($cat)){
				$cats[] = $item['cat_id'];
			}
			
		}
	}
	return $cats;
}

/*获取分类的文章信息*/
function cat_media($catId){
	global $_W;
	$res = pdo_fetchall("SELECT * FROM " . tablename('article_shelf_relation') . " WHERE `uniacid`=:uniacid AND `cat_id`=:cat_id ORDER BY id DESC", array(':uniacid'=>$_W['uniacid'], ':cat_id'=>$catId));
	$media = array();
	if(!empty($res)){
		foreach ($res as $key => $item) {
			$media[] = $item['media_id'];
		}
	}
	return $media;
}


class Categories{
	
	public static function all_cat(){
		global $_W;
		$cats = array();

		$tb = 'shelf_article_category';
		$all = pdo_fetchall("SELECT * FROM " . tablename($tb) . " WHERE `uniacid`=:uniacid ORDER BY id DESC", array(':uniacid'=>$_W['uniacid']));
		foreach ($all as $key => $item) {
			$cat = new Category((int)$item['id']);
			$cats[] = $cat;
		}
		return $cats;
	}


	public static function add($catName='', $mediaIds=array()){
		$catModel = new Category();
		$catModel->title = $catName;
		$catModel->article = $mediaIds;
		return $catModel->save();
	}

	public static function cat_id($catId){
		return new Category((int)$catId);
	}


	public static function cat_name($catName){
		return new Category($catName);
	}


	public static function rm($catId){
		$catModel = new Category((int)$catId);
		return $catModel->rm();
	}

	public static function modify($new=array(), $id){
		$catModel = new Category((int)$id);
		foreach ($new as $key => $value) {
			$catModel->$key = $value;
		}
		return $catModel->save();
	}


}

class Category{
	private $tb = 'shelf_article_category';
	public $id = '';
	public $title = '';
	public $article = array();
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
		global $_W;
		pdo_delete('article_shelf_relation', array('cat_id'=>$this->id, 'uniacid'=>$_W['uniacid']));
		return pdo_delete($this->tb, array('id'=>$this->id));
	}

	private function init($params=array()){
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
		if(!empty($res)){
			// message('初始化时失败.sql:'.$sql.'line:'.__LINE__,'','error');
			// message('当前文章分类不存在','','error');
			$this->id = $res['id'];
			$this->title = $res['title'];
			$this->article = empty($res['article']) ? array() : json_decode($res['article'], true);
		}

		
	}

	public function get_parameter(){
		return array('id'=>$this->id,
					 'title'=>$this->title,
					 'article'=>$this->article,
					 'uniacid'=>$this->uniacid,
					 );
	}

	public function get_parameter_json(){
		return array('id'=>$this->id,
					 'title'=>$this->title,
					 'article'=>json_encode($this->article),
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