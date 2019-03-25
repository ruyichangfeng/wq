<?php

class teacherApi{

	public function getList($page){
		$list = M('teacher')->getList($page);
		return $list['list'];
	}
}