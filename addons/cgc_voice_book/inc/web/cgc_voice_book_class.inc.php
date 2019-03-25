<?php

  global $_W, $_GPC;
  $settings=$this->module["config"];
  load()->func("tpl");
  $op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
  $uniacid=$_W["uniacid"];
  


  $filename=(basename(__file__,".inc.php"));
  $data = new $filename();

  if ($op=="display") {
    $pindex = max(1, intval($_GPC["page"]));
    $psize= 50;
    $con="uniacid=$uniacid";
	
    $nickname = $_GPC["nickname"];
    if(!empty($nickname)){
      $con.=" and nickname like '%$nickname%'";
    }

    $total=0;
    $list = $data->getAll($con, $pindex,$psize,$total); 
    $pager = pagination($total, $pindex, $psize);
    
    if(!empty($list)){
    	foreach ($list as $key => $value) {
    
    		$url = $this->createMobileUrl("index", array('class_id' => $list[$key]["id"]));
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
    }

    if (checksubmit("submit")) {

      $input =array();
      $input=$_GPC["page_data"];
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
