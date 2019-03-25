<?php
  global $_W,$_GPC;
  
  if   (empty($_SESSION['enter'])) {
    exit('22');
  }
  
  $member = $this-> get_member();
  
  $uniacid=$_W['uniacid'];
  
  $settings = $this ->module['config'];
 
  $op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";

  if($op == "display"){
  	
  	if(empty($settings['code_type'])){
	  //判断参数
	  if(empty($_GPC['id'])){
		  $this->returnError('参数不正确');
	  }
	
	  $book_code = pdo_get('cgc_voice_book_code', array ('uniacid' => $_W['uniacid'],'openid' => $member['openid'],'id'=>$_GPC['id']));
	
	  if(!$book_code){
		  $this->returnError('未找到记录');
	  }
  	}else{
  		$book_code = pdo_get('cgc_voice_book_code', array ('uniacid' => $_W['uniacid'],'openid' => $member['openid']));
  		if(empty($book_code)){
  			$invite_code = NoRand();
  			$book_code = array();
  			$book_code['uniacid'] = $_W['uniacid'];
  			$book_code['nickname'] = $member['nickname'];
  			$book_code['openid'] = $member['openid'];
  			$book_code['headimgurl'] = $member['headimgurl'];
  			$book_code['invite_code'] = $invite_code;
  			$book_code['status'] = 0;
  			$book_code['is_check'] = 0;
  			$book_code['createtime'] = time();
  			$id = pdo_insert("cgc_voice_book_code", $book_code);
  			if ($id){
  				$book_code['id'] = $id;
  			} else{
  				$this->returnError('邀请码生成失败');
  			}
  		}
  	}
	  
	 include $this->template("invite_code_true");
  }else if($op == "post"){
	  $book_code = pdo_get('cgc_voice_book_code', array ('uniacid' => $_W['uniacid'],'openid' => $member['openid'],'invite_code'=>$_GPC['invite_code']));
	  $_url = $_W['siteroot'] . "app/" . substr($this->createMobileUrl('index'), 2);
	  
	  if(!$book_code){
		  $this->returnError('未找到匹配数据!');
	  }
	  
	  if(!empty($book_code['status'])){
		  $this->returnError('邀请码已经使用!',$_url);
	  }
	
	  $result = pdo_update('cgc_voice_book_code', array('status'=>1), array('id' => $book_code['id']));
	  if($result){
		  $result = pdo_update('cgc_voice_book_member', array('status'=>1), array('id' => $member['id']));
		  
		  $this->returnSuccess('兑现成功!',$_url);
	  }else{
		  $this->returnError('兑现失败!');
	  }
  }







 
