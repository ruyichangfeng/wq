<?php
  global $_W,$_GPC;
  
  $member = $this-> get_member();
  
  $uniacid=$_W['uniacid'];
  
  $settings = $this ->module['config'];
  
  $op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
  
  $cgc_voice_book_commt = new cgc_voice_book_commt();
  
  $book_id = $_GPC["courseid"];
  
  if ($op=='display'){
  
	$pindex = max(1, intval($_GPC["page"]));
	$psize= intval(!empty($_GPC["count"]) ? $_GPC["count"] : 9);
	$con="uniacid=$uniacid and book_id = $book_id and pid = 0 ";
	$total=0;
	$list = $cgc_voice_book_commt->getAll($con, $pindex,$psize,$total);
  
  	$html = "<li>";
 	foreach($list as $key => $item){
 		
 		$html .= "<div class=\"cou-tiwen wenda\">";
 		$html .= "<div flex=\"main:left\">";
 		$html .= "<img src=\"".tomedia($item['headimgurl'])."\" alt=\"\">";
 		$html .= "<p class=\"name\">".$item['nickname']."</p>";
 		$html .= "<p class=\"time\">".format_date($item['createtime'])."</p>";
 		$html .= "</div>";
 		$html .= "<p class=\"txt\">".$item['content']."</p>";
 		$html .= "<div flex=\"dir:right main:justify\">";
 		$html .= "<div for=\"inp-huida\" class=\"btn-huida\" data-id=\"".$item['id']."\">回复</div>";
 		$html .= "</div>";
 		$html .= "</div>";
 		
 		$hdlist = $cgc_voice_book_commt->selectByConAll(" and pid = {$item['id']} order by createtime desc");
 		
 		foreach($hdlist as $key1 => $item1){
	 		$html .= "<div class=\"cou-huida wenda\">";
	 		$html .= "<ul>";
	 		$html .= "<li class=\"huida-list\">";
	 		$html .= "<div flex=\"main:left\">";
	 		$html .= "<img src=\"".tomedia($item1['headimgurl'])."\" alt=\"\">";
	 		$html .= "<p class=\"name\">".$item1['nickname']."</p>";
	 		$html .= "<p class=\"time\">".format_date($item1['createtime'])."</p>";
	 		$html .= "</div>";
	 		$html .= "<p class=\"txt\">".$item1['content']."</p>";
	 		
	 		$html .= "</li>";
	 		$html .= "</ul>";
	 		$html .= "</div>";
 		}
 	}
 	$html .= "</li>";
  	$ret = array (
  			'state' => array('code'=>20000,'msg'=>''),
  			'data' => array('count'=>count($list),'html'=>$html)
  	);
  	
  	
  }else if ($op=='tj'){
  	$content = $_GPC["content"];
  	$pid = !empty($_GPC["id"]) ? intval($_GPC["id"]) : 0;
  	$data = array(
  			'uniacid'=>$uniacid,
  			'openid'=>$member['openid'],
  			'nickname'=>$member['nickname'],
  			'headimgurl'=>$member['headimgurl'],
  			'book_id'=> $book_id,
  			'content'=> $content,
  			'createtime'=>TIMESTAMP,
  			'pid'=>$pid,
  			);
  	$ret=$cgc_voice_book_commt->insert($data);
  	
  	if ($ret){
  		//增加访问量
  		pdo_query('update ' . tablename('cgc_voice_book') . " set commt=commt+1 where id=:id", array(':id' => $book_id));
	  	$ret = array (
	  			'state' => array('code'=>20000,'msg'=>'')
	  	);
  	}else{
  		$ret = array (
  				'state' => array('code'=>0,'msg'=>'评论失败！')
  		);
  	}
  	
  }
  
  header('Content-Type:application/json; charset=utf-8');
  exit (json_encode($ret));
  





 
