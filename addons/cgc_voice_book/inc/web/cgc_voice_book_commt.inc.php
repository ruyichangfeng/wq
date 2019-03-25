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

    $book_tilte = $_GPC["book_tilte"];
    if(!empty($book_tilte)){
      $con.=" and book_tilte like '%$book_tilte%'";
    }

    $content = $_GPC["content"];
    if(!empty($content)){
      $con.=" and content like '%$content%'";
    }

    $total=0;
    $list = $data->getAll($con, $pindex,$psize,$total); 
    $pager = pagination($total, $pindex, $psize);

    if(!empty($list)){
      foreach ($list as $key => $value) {
        $url = $this->createMobileUrl("enter", array("a_id" => $list[$key]["id"]));
        $url = substr($url, 2);
        $url = $_W["siteroot"] . "app/" . $url;
        $list[$key]["_url"] = $url;
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
    $commt_data= $data->getOne($id);
    $data->delete($id);
    
    pdo_query('update ' . tablename('cgc_voice_book') . " set commt=(select count(id) from ".tablename('cgc_voice_book_commt')." where book_id=:id) where id=:id", array(':id' => $commt_data['book_id']));
    message("删除成功",$this->createWebUrl($filename, array("op" => "display")), "success");
  }

  if ($op=="delete_all") {
    $data->deleteAll();
    
    
    pdo_query('update ' . tablename('cgc_voice_book') . " set commt=0 where `uniacid`=:uniacid", array(':uniacid' => $uniacid));
    
    message("删除成功",$this->createWebUrl($filename, array("op" => "display")), "success");
  }
  if ($op=="batch_del") {
    $ids=$_GPC["id"];
    if (empty($ids)){
      message("信息不能为空.");
    }
    foreach ($ids as $id){
      $commt_data= $data->getOne($id);
      $data->delete($id);
      pdo_query('update ' . tablename('cgc_voice_book') . " set commt=(select count(id) from ".tablename('cgc_voice_book_commt')." where book_id=:id) where id=:id", array(':id' => $commt_data['book_id']));
      
    }
    message("删除成功",$this->createWebUrl($filename, array("op" => "display")), "success");
  }
  