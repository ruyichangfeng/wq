<?php
  global $_W,$_GPC;
  
  $member = $this-> get_member();
  $uniacid=$_W['uniacid'];
  $settings = $this ->module['config'];
  $cgc_voice_book = new cgc_voice_book();
  $id=$_GPC['id'];
  if (empty($id)){
    message("没有参数，",$this->createMobileUrl("index"),"success");
  }
  $voice_book= $cgc_voice_book->getOne($id); 
  

  
    //根据可免费阅读数 判断是否可以开启阅读模式
  if (empty($member['status'])&&!empty($settings['free_num'])){
	  $sql = "SELECT count(id) FROM " . tablename('cgc_voice_book_study') . " WHERE uniacid=$uniacid and openid = '{$member['openid']}'";
	  $read_num = pdo_fetchcolumn($sql);
	  if ($read_num<intval($settings['free_num'])){
	  	$member['status'] = 1;
	  }
  }
  
    //print_r($voice_book);
   if ($settings['class_mode']==1 && $member['status']==0){
   	 $class_id=$voice_book['class'];
     if (!empty($class_id)){
  	    $sql = "select * from ".tablename("cgc_voice_book_member_class")." where uniacid=$uniacid and class_id=$class_id and openid = '{$member['openid']}'";
  	    $member_class = pdo_fetch($sql); 
  	  }
  	   
  	   if ($member_class['status']==1){
  		 $member['status'] = 1;
  	   }
     }
  
  
  
  
  
   if (empty($member['status']) && empty($_GPC['test111'])){
   	  //阅读记录
	  $book_study = pdo_get('cgc_voice_book_study', array('uniacid' => $_W['uniacid'], 'book_id' => $id,'openid'=>$member['openid']));
   	  if (empty($book_study)){
   	    message("不符合条件，请支付以后在阅读，",$this->createMobileUrl("index"),"success");
   	  }
  
  }
  
  
  
  
  $op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
  

  if ($op=='detail'){
	
	  if (!empty($id)){
	    $voice_book= $cgc_voice_book->getOne($id); 
	    if ($voice_book){
	    	$voice_book['content']=unserialize($voice_book['content']);
	    	//阅读记录
	    	$book_study = pdo_get('cgc_voice_book_study', array('uniacid' => $_W['uniacid'], 'book_id' => $id,'openid'=>$member['openid']));
	    	if (empty($book_study)){
	    		$book_study = array(
	    				'uniacid' => $_W['uniacid'],
	    				'openid' => $member['openid'],
	    				'nickname' => $member['nickname'],
	    				'headimgurl' => $member['headimgurl'],
	    				'book_id' => $voice_book['id'],
	    				'title' => $voice_book['title'],
	    				'createtime' => time(),
	    		);
	    		pdo_insert('cgc_voice_book_study', $book_study);
	    	}
	    	//增加访问量
	    	pdo_query('update ' . tablename('cgc_voice_book') . " set pv=pv+1 where id=:id", array(':id' => $id));
	    }
	  }
  }


  $settings['book_sharetitle'] = str_replace('{fromuser}', $member['nickname'], $settings['book_sharetitle']);
  
  $settings['book_sharetitle'] = str_replace('{title}', $voice_book['title'], $settings['book_sharetitle']);
  
  $settings['book_sharedescription'] = str_replace('{fromuser}', $member['nickname'], $settings['book_sharedescription']);
   
 $settings['book_sharedescription'] = str_replace('{title}', $voice_book['title'], $settings['book_sharedescription']);
 if ($voice_book['type']==1){
 	include $this->template('cgc_voice_book2');
 }else{
 	include $this->template('cgc_voice_book');
 }





 
