<?php

  global $_W, $_GPC;
  $settings=$this->module["config"];
  load()->func("tpl");
  $op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
  $uniacid=$_W["uniacid"];
  
  ini_set('display_errors', '1');
            error_reporting(E_ALL ^ E_NOTICE);

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
      
      $member_class = $_GPC['member_class'];
      
      $member_class_arr = array();
      
      if (!empty($id)) {
        $temp=$data->modify($id,$input);
      }
      else{
        $temp=$data->insert($input); 
      }
      
      $page_data['openid'] = $input['openid'];
      
      pdo_query("delete from ".tablename('cgc_voice_book_member_class')." where uniacid=$uniacid and openid = '{$page_data['openid']}'");
      
      if(is_array($member_class['class_id'])){
      	foreach($member_class['class_id'] as $key=>$value){
      		$d=array(
      				'class_id'=>$member_class['class_id'][$key],
      				'class_name'=>$member_class['class_name'][$key],
      				'status'=>$member_class['status'][$key],
      				'uniacid'=>$uniacid,
      				'openid'=>$input['openid'],
      				'nickname'=>$input['nickname'],
      				'headimgurl'=>$input['headimgurl'],
      				'createtime'=>TIMESTAMP
      		);
      		pdo_insert('cgc_voice_book_member_class', $d);
      	}
      }

      message("信息更新成功",$this->createWebUrl($filename, array("op" => "display")), "success");
    }
    $cgc_voice_book_class = new cgc_voice_book_class();
    
    $class_list = $cgc_voice_book_class->getByConAll(" uniacid=$uniacid order by sort asc");
    
    $sql = "select * from ".tablename("cgc_voice_book_member_class")." where uniacid=$uniacid and openid = '{$page_data['openid']}'";
    
    $member_class_list = pdo_fetchall($sql,array(),"class_id");
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
