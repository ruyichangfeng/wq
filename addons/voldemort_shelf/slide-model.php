<?php


class slidesModel{
	
	public static $tb = 'article_shelf_slides';


	public function del($id){
		global $_W;
		return pdo_delete(self::$tb, array('slides_id'=>$id,'uniacid'=>$_W['uniacid']));
	}

	public function add($data){
		global $_W;
		$link = trim($data['link']);
		$slides['uniacid'] = $_W['uniacid'];
		$slides['name'] = $data['name'];
		$slides['show_sort'] = $data['show_sort'];
		$slides['link'] = substr($link, 0, 4) == 'http' ? $link : 'http://'.$link;
		$slides['thumb'] = $data['thumb'];
		$slides['description'] = trim($data['description']);

		pdo_insert(self::$tb, $slides);//添加商品
		return pdo_insertid();
	}

	public function modify($data, $id){
		global $_W;
		$link = trim($data['link']);
		$slides['name'] = $data['name'];
		$slides['thumb'] = $data['thumb'];
		$slides['show_sort'] = $data['show_sort'];
		$slides['link'] = substr($link, 0, 4) == 'http' ? $link : 'http://'.$link;
		$slides['description'] = trim($data['description']);
		return pdo_update(self::$tb, $slides, array('uniacid'=>$_W['uniacid'], 'slides_id'=>$id));
	}

	public function all(){
		global $_W;
		return pdo_fetchall("SELECT * FROM " . tablename(self::$tb) . " WHERE `uniacid`=:uniacid ORDER BY `show_sort` ASC, `slides_id` DESC",array(':uniacid'=>$_W['uniacid']));
	}

	public function item($id){
		global $_W;
		return pdo_fetch("SELECT * FROM " . tablename(self::$tb) . " WHERE `uniacid`=:uniacid AND `slides_id`=:slides_id ",array(':uniacid'=>$_W['uniacid'],':slides_id'=>$id));
	
	}
	
}
