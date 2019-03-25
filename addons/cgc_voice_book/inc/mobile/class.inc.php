<?php
  global $_W,$_GPC;
  
  $member = $this->get_member();
  
  $uniacid=$_W['uniacid'];
  
  $settings = $this ->module['config'];
  
  $cgc_voice_book_class = new cgc_voice_book_class();
  
  $class_list = $cgc_voice_book_class->getByConAll(" uniacid=$uniacid order by sort asc");
  
  $sql = "select * from ".tablename("cgc_voice_book_member_class")." where uniacid=$uniacid and openid = '{$member['openid']}'";
  
  $member_class_list = pdo_fetchall($sql,array(),"class_id");

  include $this->template("class");





 
