<?php

  global $_W, $_GPC;
  $settings=$this->module["config"];
  load()->func("tpl");
  $op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
  $uniacid=$_W["uniacid"];

  $filename=(basename(__file__,".inc.php"));
  $data = new $filename();
  
  $cgc_voice_book_class = new cgc_voice_book_class();
  
  $class_list = $cgc_voice_book_class->getByConAll(" uniacid=$uniacid order by sort asc");

  if ($op=="display") {
    $pindex = max(1, intval($_GPC["page"]));
    $psize= 50;
    $con=" b.uniacid=$uniacid";
    
    $title = $_GPC["title"];
    if(!empty($title)){
    	$con.=" and b.title like '%$title%'";
    }
    
    $class = $_GPC["class"];
    if(!empty($class)){
    	$con.=" and b.class = ".intval($class);
    }
    
    $total=0;
    $list = $data->getAll($con, $pindex,$psize,$total); 
    $pager = pagination($total, $pindex, $psize);
    
    if(!empty($list)){
    	foreach ($list as $key => $value) {
    		
    		$url = $this->createMobileUrl("cgc_voice_book", array('id' => $list[$key]["id"],'op'=>'detail'));
    		$url = substr($url, 2);
    		$url = $_W["siteroot"] . "app/" . $url;
    		$list[$key]["url"] = $url;
    	}
    }

    include $this->template($filename);
    exit();
  }

  if ($op=="post") {
    $id=$_GPC["id"]; 
    if (!empty($id)){
      $page_data= $data->getOne($id); 
      $page_data['content']=unserialize($page_data['content']);
    }

    if (checksubmit("submit")) {

      $input =array();
      $input=$_GPC["page_data"];
      $content = $_GPC['content'];
      $content_rule=array();
      if(is_array($content['img'])){
      	foreach($content['img'] as $key=>$value){
      		$d=array(
      				'img'=>$content['img'][$key],
      				'text'=>$content['text'][$key],
      		);
      		$content_rule[]=$d;
      	}
      }
      if(!empty($content_rule)){
      	$input['content'] = serialize($content_rule);
      }
      $input["uniacid"] = $uniacid;
      $input["createtime"] = TIMESTAMP;

      if (!empty($id)) {
        $temp=$data->modify($id,$input);
      }
      else{
        $temp=$data->insert($input); 
      }

      message("信息更新成功",$this->createWebUrl($filename, array("op" => "display")), "success");
    }
    include $this->template($filename);
    exit();
  }

  if ($op=="delete") {
    $id=$_GPC["id"];
    $data->delete($id);
    message("删除成功",$this->createWebUrl($filename, array("op" => "display")), "success");
  }

  if ($op=="delete_all") {
    $data->deleteAll();
    message("删除成功",$this->createWebUrl($filename, array("op" => "display")), "success");
  }
  if ($op=="batch_del") {
    $ids=$_GPC["id"];
    
    if (empty($ids)){
      message("信息不能为空.");
    }
    
    foreach ($ids as $id){
      $data->delete($id);
    }
    
    message("删除成功",$this->createWebUrl($filename, array("op" => "display")), "success");
  }
  
  if ($op=='init'){  	
 
  	$type = !empty($_GPC["type"]) ? $_GPC["type"] : 0;
  	
  	$begindate = $_GPC["begindate"];
  	$enddate = $_GPC["enddate"];
  	
  	load()->func('communication');
  	
  	$url = "http://www.mingfengfushi.cn/addons/cgc_voice_book_service/service/VideoBookService.php";
  	$result = ihttp_post($url, array('type'=>$type,'begindate'=>$begindate,'enddate'=>$enddate));
  	
  	if ($result['code']==200){
  		$content = $result['content'];
  		
  		$result = json_decode($content,true);
  		
  		if ($result['code']==1){
  			$list = $result['list'];
  			if(!empty($list)&&count($list)>0){
  				foreach ($list as $key => $value) {
  					unset($list[$key]["id"]);
  					$list[$key]["uniacid"] = $uniacid;
  					$list[$key]["createtime"] = TIMESTAMP;
  					$list[$key]["pv"] = 0;
  					$list[$key]["commt"] = 0;
  					
  					/*$url=downUrlFile($list[$key]["voice"],"audio",$uniacid);
  					$list[$key]["voice"]=$url['url'];*/
  					$data->insert($list[$key]);
  				}
  				message("云同步绘画本成功",$this->createWebUrl($filename, array("op" => "display")), "success");
  			}else{
  				message("未搜索到绘本信息，请更换日期同步！");
  			}
  		}else{
  			message("服务通信故障.");
  		}
  	}else{
  		message("服务通信失败.");
  	}
  }
  
  
