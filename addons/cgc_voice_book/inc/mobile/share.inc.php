<?php
  global $_W,$_GPC;
  
  $member = $this-> get_member();
  $weid=$_W['uniacid'];
  $settings = $this ->module['config'];
  
  if ($settings['share_type']==1){
  
  	pdo_update('cgc_voice_book_member', array('status'=>1), array('id' => $member['id']));
  	
  	$this -> returnSuccess('分享成功', '');
  
  }
  
  





 
