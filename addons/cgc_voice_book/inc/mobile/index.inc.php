<?php
  global $_W,$_GPC;
  
  $member = $this-> get_member();
  
  $uniacid=$_W['uniacid'];
  
  $settings = $this ->module['config'];
  
  $cgc_voice_book = new cgc_voice_book();
  
  $class_id = $_GPC["class_id"];
  
  $pindex = max(1, intval($_GPC["page"]));
  $psize= intval(!empty($_GPC["count"]) ? $_GPC["count"] : 9);
  $con=" uniacid=$uniacid ";
  
  if (!empty($class_id)){
  	$con .= " and `class` = ".intval($class_id);
  }
  
  $total=0;
  $list = $cgc_voice_book->getAllAndRead($con, $pindex,$psize,$total,$member['openid']);
  
  if ($_W['isajax']) {
  	header('Content-Type:application/json; charset=utf-8');
  	$html = "";
 	foreach($list as $key => $item){
 		if ($key%3==0) $html .= "<li>";
 		$html .= "<div class=\"list-item cou-img ml-item\" data-id=\"".$item['id']."\">";
 		$html .= "<div class=\"pic-wrap ";
 		if (!empty($item['isread'])){
 			$html .= " grid-isread";
 		}
 		$html .= " \">";
        $html .= "     <img src=\"".tomedia($item['cover'])."\" alt=\"\" class=\"cou-img\">";
        $html .= "</div>";
        $html .= "<div class=\"pic-desc\">".$item['title']."</div>";
        $html .= "     <div class=\"bott\">";
        $html .= "     	  <div class=\"listen-num\">";
        $html .= "            <span>".$item['pv']."</span>";
        $html .= "        </div>";
        $html .= "        <div class=\"commt-num\">";
        $html .= "            <span>0</span>";
        $html .= "        </div>";
        $html .= "    </div>";
        $html .= "</div>";
        if ($key%3==2) $html .= "</li>";
 	}
  	$ret = array (
  			'state' => array('code'=>20000,'msg'=>''),
  			'data' => array('count'=>count($list),'html'=>$html)
  	);
  	exit (json_encode($ret));
  }
  
  if ($settings['class_mode']==1&&empty($class_id)){
  	 $url = $this->createMobileUrl('class');
  	 header("location:$url");
  	 exit();
  }
  
  $sql = "SELECT sum(pv) FROM " . tablename('cgc_voice_book') . " WHERE {$con}";
  $total_pv = pdo_fetchcolumn($sql);
  //如果不是vip就在做判断。
  if (!empty($class_id)){
  	if (empty($member['status'])){
  	  $sql = "select * from ".tablename("cgc_voice_book_member_class")." where uniacid=$uniacid and class_id=$class_id and openid = '{$member['openid']}'";
  	  $member_class = pdo_fetch($sql);
  	  if ($member_class['status']==1){
  		$member['status'] = 1;
  	  }
  	}
  	
  }else{
  
	  //根据可免费阅读数 判断是否可以开启阅读模式
	  if (empty($member['status'])&&!empty($settings['free_num'])){
		  $sql = "SELECT count(id) FROM " . tablename('cgc_voice_book_study') . " WHERE uniacid=$uniacid and openid = '{$member['openid']}'";
		  $read_num = pdo_fetchcolumn($sql);
		  if ($read_num<intval($settings['free_num'])){
		    $member['status'] = 1;
		  	$member['free_status'] = 1;
		  }
	  }
  }
  
 
  define('TEE_CLIENT_ID', $settings['teegon_client_id']);
  
  if (!empty($class_id)){
  	$cgc_voice_book_class = new cgc_voice_book_class();
  	$book_class = $cgc_voice_book_class->getOne($class_id);
  	
  	$settings['name'] = $book_class['name'];
  	
  	$settings['fee'] = $book_class['price'];
  }
  

  include $this->template("index");





 
