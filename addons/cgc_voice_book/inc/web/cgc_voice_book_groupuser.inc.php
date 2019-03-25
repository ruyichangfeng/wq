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
    
    $group_id = $_GPC['group_id'];

    if(!empty($group_id)){
      $con.=" and group_id = $group_id ";
    }

    $total=0;
    $list = $data->getAll($con, $pindex,$psize,$total); 
    $pager = pagination($total, $pindex, $psize);
    
    $cgc_voice_book_group = new cgc_voice_book_group();
    
    $group = $cgc_voice_book_group->getOne($group_id);
    

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

  if ($op=="delete_all_user") {
  	  $cgc_qun_user = new cgc_qun_user();
    $cgc_qun_user->deleteAll();
    message("删除成功",$this->createWebUrl($filename, array("op" => "display",'group_id'=>$_GPC['group_id'])), "success");
  }
  
    if ($op=='batch_del') {
	$ids=$_GPC['id'];
	if (empty($ids)){
		message('信息不能为空.');
	}

	foreach ($ids as $id){
		 $data->delete($id);
	}
	message('删除成功',$this->createWebUrl($filename, array('op' => 'display')), 'success');
}
