<?php
global $_W, $_GPC;
checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'add', 'addok', 'edit', 'editok', 'delete', 'getOrderCount', 'tempvalue', 'baseok', 'valueaddok', 'gongshiok', 'valueedit', 'valueeditok', 'valuedelete', 'setModel', 'center', 'centerok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == "index"){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_temp')." WHERE weid =".$this->weid." and delstate=1 ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_temp')." WHERE weid = ".$this->weid." and delstate=1");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	$posturl = POSTURL."creatinput.php";
	
	include $this->template('web/servetemp/temp-list');
}

if($foo == "add"){
	include $this->template('web/servetemp/temp-add');
}

if($foo == "addok"){
	$temp_name  = $_GPC['temp_name'];
	$temp_token = $_GPC['temp_token'];
	if(empty($temp_name)){
		message("模型名称不能为空！");
	}	
	if(substr($temp_token,0,8) != 'templat_'){
		message('模型标识必须已templat_开头!');
	}
	
	if(checksubmit('submit')){
		$check1 = pdo_fetch("select id from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and delstate=1 and temp_name='".$temp_name."'");
		if(empty($check1['id'])){
			$check2 = pdo_fetch("select id from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and temp_token='".$temp_token."' and delstate=1");
			if(empty($check2['id'])){
				
				$table_name = 'xm_gohome_'.$temp_token;
				if(!pdo_tableexists($table_name)){
					$data['weid']      = $this->weid;
					$data['temp_name'] = $temp_name;
					$data['temp_token']= $temp_token;
					$data['uploadpic'] = $_GPC['uploadpic'];
					$data['getadr']    = $_GPC['getadr'];
					$data['moren']     = $_GPC['moren'];
					$data['bgcolor']   = $_GPC['bgcolor'];
					$data['bgimage']   = $_GPC['bgimage'];
					$res = pdo_insert('xm_gohome_temp', $data);
					$newId = pdo_insertid();
					if($res){
						if(!pdo_tableexists($table_name)) {
							pdo_query("CREATE TABLE ".tablename($table_name)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,openid nvarchar(100) DEFAULT NULL,serve_type int(11) DEFAULT NULL,staff_id int(11) DEFAULT NULL,ftime nvarchar(100) DEFAULT NULL,fmobile nvarchar(100) DEFAULT NULL,fname nvarchar(100) DEFAULT NULL,fsex int(11) DEFAULT NULL,fadr nvarchar(300) DEFAULT NULL,fperson nvarchar(100) DEFAULT NULL,random int(11) DEFAULT NULL,flag int(11) DEFAULT 0,dealprice DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
						}
						message('模型添加成功！', $this->createWebUrl('servetemp', array('foo'=>'index')), 'success');
					}else{
						message('模型添加失败！');
					}
				}else{
					message('系统中已存在该数据表，创建模型失败！');
				}
			}else{
				message('此模型标识已存在，请重新填写！');
			}
		}else{
			message('在此公众号下已存在该模型名称，不能添加！');
		}
	}
}

if($foo == "edit"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误，无法获取模型ID');
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_temp')." where id=".$id);
		
	include $this->template('web/servetemp/temp-edit');
}

if($foo == "editok"){
	$temp_name  = $_GPC['temp_name'];
	$temp_token = $_GPC['temp_token'];
	if(empty($temp_name)){
		message("模型名称不能为空！");
	}	
	if(substr($temp_token,0,8) != 'templat_'){
		message('模型标识必须已templat_开头!');
	}

	if(checksubmit()){
		$id = intval($_GPC['id']);
		$check1 = pdo_fetch("select id from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and temp_name = '".$_GPC['temp_name']."' and id!=".$id);
		if(empty($check1)){
		
			$data['temp_name'] = $_GPC['temp_name'];
			$data['temp_token'] = $_GPC['temp_token'];
			$data['uploadpic'] = $_GPC['uploadpic'];
			$data['getadr'] = $_GPC['getadr'];
			$data['moren']   = $_GPC['moren'];
			$data['bgcolor'] = $_GPC['bgcolor'];
			$data['bgimage'] = $_GPC['bgimage'];
			$data['updatetime'] = date('Y-m-d H:i:s',time());
			$res = pdo_update('xm_gohome_temp', $data, array('id'=>$id));
			if($res){
				message('模型修改成功！请点击生成模板生成新的模板文件', $this->createWebUrl('servetemp', array('foo'=>'index')), 'success');
			}else{
				message('模型修改失败！');
			}
		}else{
			message('该模型名称已存在！');
		}
	}
}

if($foo == "getOrderCount"){
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select temp_token from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and id=".$id);
	$tn = 'xm_gohome_'.$item['temp_token'];
	
	$s = pdo_fetchcolumn("select COUNT(*) from ".tablename('xm_gohome_order')." where weid=".$this->weid." and table_name='".$tn."'");
	if(empty($s)){
		echo 0;
	}else{
		echo $s;
	}
}

if($foo == "delete"){
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select temp_token from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and id=".$id);
	$tn = 'xm_gohome_'.$item['temp_token'];
		
	$data['delstate'] = 0;
	$res = pdo_update('xm_gohome_temp', $data, array('id'=>$id));
	if($res){
		pdo_query("delete from ".tablename('xm_gohome_tempvalue')." where temp_token='".$item['temp_token']."'");
		pdo_query("DROP TABLE IF EXISTS ".tablename($tn)."");
		echo 1;
	}else{
		echo 0;
	}
}

if($foo == "tempvalue"){
	$temp_id = intval($_GPC['temp_id']);
	$temp_token = $_GPC['temp_token'];
		
	$item = pdo_fetch("select * from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and id=".$temp_id);
	
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_token='".$temp_token."' order by top asc");
	$posturl = POSTURL."creatinput.php";
		
	include $this->template('web/servetemp/tempvalue-add');
}

if($foo == "baseok"){
	if(checksubmit('submit')){
		$temp_id = intval($_GPC['temp_id']);
		$temp_token = $_GPC['temp_token'];
			
		$data['price'] = $_GPC['price'];
		$data['juli'] = $_GPC['juli'];
		if($_GPC['juli'] == 0){
			$input_1 = '';
			$input_2 = '';
		}else{
			$input_1 = $_GPC['input_1'];
			$input_2 = $_GPC['input_2'];
		}
			
		$data['input_1'] = $input_1;
		$data['input_2'] = $input_2;
		$res = pdo_update('xm_gohome_temp', $data, array('id'=>$temp_id));
		if($res){
			message('添加成功！', $this->createWebUrl('servetemp', array('foo'=>'tempvalue','temp_id'=>$temp_id,'temp_token'=>$temp_token)), 'success');
		}else{
			message('添加失败！');
		}
	}
}

if($foo == "valueaddok"){
	if(checksubmit('submit')){
		$temp_id = intval($_GPC['temp_id']);
		$temp_token = $_GPC['temp_token'];
		if(empty($_GPC['input_laber'])){
			message('描述不能为空！');
		}
		if(empty($_GPC['input_type'])){
			message('请选择字段类型！');
		}
		if(empty($_GPC['input_name'])){
			message('字段标识不能为空！');
		}
		$input_type = $_GPC['input_type'];
		if($input_type == 'text' || $input_type == 'textarea' || $input_type == 'ttimes' || $input_type == 'dates' || $input_type == 'nums'){
			$input_value = '';
			$value_name = '';
		}else{
			$input_value = $_GPC['input_value'];
			$value_name = $_GPC['value_name'];
		}
			
		if($input_type == 'radio'){
			if($_GPC['input_value'] == ''){
				message('你选择了单选或多选，字段选项值不能为空！');
			}
			if($_GPC['value_name'] == ''){
				message('你选择了单选或多选，字段选项名称不能为空！');
			}
				
			if($_GPC['input_default'] == ''){
				message('你选择了单选或多选，选项默认值不能为空');
			}
		}
			
		if($input_type == 'checkbox' || $input_type == 'select'){
			if($_GPC['input_value'] == ''){
				message('你选择了单选或多选，字段选项值不能为空！');
			}
			if($_GPC['value_name'] == ''){
				message('你选择了单选或多选，字段选项名称不能为空！');
			}
		}
			
		if($_GPC['top'] == ''){
			$top = 999;
		}else{
			$top = $_GPC['top'];
		}
		$check = pdo_fetch("select id from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_token='".$temp_token."' and input_name='".$_GPC['input_name']."'");
		if(empty($check['id'])){

			$data['weid'] = $this->weid;
			$data['temp_id'] = $temp_id;
			$data['temp_token'] = $temp_token;
			$data['input_laber'] = $_GPC['input_laber'];
			$data['input_type'] = $_GPC['input_type'];
			$data['input_name'] = $_GPC['input_name'];
			$data['input_value'] = $input_value;
			$data['value_name'] = $value_name;
			$data['input_default'] = $_GPC['input_default'];
			$data['remark'] = $_GPC['remark'];
			$data['prompts'] = $_GPC['prompts'];
			$data['top'] = $top;
			$res = pdo_insert('xm_gohome_tempvalue', $data);
			$newId = pdo_insertid();
			if($res){
				//添加表中字段
				$table_name = 'xm_gohome_'.$temp_token;
				if(!pdo_fieldexists($table_name,  $_GPC['input_name'])) {
					if($_GPC['input_type'] == 'times'){
						pdo_query("ALTER TABLE ".tablename($table_name)." ADD `".$_GPC['input_name']."` datetime DEFAULT NULL;");
					}else{
						pdo_query("ALTER TABLE ".tablename($table_name)." ADD `".$_GPC['input_name']."` nvarchar(500) DEFAULT NULL;");
					}
				}
				message('添加字段成功！', $this->createWebUrl('servetemp', array('foo'=>'tempvalue','temp_id'=>$temp_id,'temp_token'=>$temp_token)), 'success');
			}else{
				message('添加字段失败');
			}
		}else{
			message('该字段标识已存在在该模型字段中，请输入新的字段标识！');
		}
	}
}

if($foo == "gongshiok"){
	if(checksubmit('submit')){

		$temp_id = intval($_GPC['temp1_id']);
		$temp_token = $_GPC['temp1_token'];
		$data['jsgs'] = base64_encode($_POST['jsgs']);
		$data['updatetime'] = date('Y-m-d H:i:s',time());
		$res = pdo_update('xm_gohome_temp', $data, array('id'=>$temp_id));
		if($res){
			message('公式更新成功！请点击生成模板生成新的模板文件', $this->createWebUrl('servetemp', array('foo'=>'tempvalue','temp_id'=>$temp_id,'temp_token'=>$temp_token)), 'success');
		}else{
			message('公式更新失败');
		}
	}
}

if($foo == "valueedit"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到字段ID！");
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_tempvalue')." where id=".$id);
		
	include $this->template('web/servetemp/tempvalue-edit');
}

if($foo == "valueeditok"){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		$temp_id = $_GPC['temp_id'];
		$temp_token = $_GPC['temp_token'];
		if(empty($_GPC['input_laber'])){
			message('描述不能为空！');
		}
		if(empty($_GPC['input_type'])){
			message('请选择字段类型！');
		}
		if(empty($_GPC['input_name'])){
			message('字段标识不能为空！');
		}
		$input_type = $_GPC['input_type'];
		if($input_type == 'text' || $input_type == 'textarea' || $input_type == 'times' || $input_type == 'dates'){
			$input_value = '';
			$value_name = '';
		}else{
			$input_value = $_GPC['input_value'];
			$value_name = $_GPC['value_name'];
		}
			
		if($input_type == 'radio'){
			if($_GPC['input_value'] == ''){
				message('你选择了单选或多选，字段选项值不能为空！');
			}
			if($_GPC['value_name'] == ''){
				message('你选择了单选或多选，字段选项名称不能为空！');
			}
				
			if($_GPC['input_default'] == ''){
				message('你选择了单选或多选，选项默认值不能为空');
			}
		}
		if($input_type == 'checkbox' || $input_type == 'select'){
			if($_GPC['input_value'] == ''){
				message('你选择了单选或多选，字段选项值不能为空！');
			}
			if($_GPC['value_name'] == ''){
				message('你选择了单选或多选，字段选项名称不能为空！');
			}
		}
			
		if($_GPC['top'] == ''){
			$top = 999;
		}else{
			$top = $_GPC['top'];
		}

		$data['input_laber'] = $_GPC['input_laber'];
		$data['input_type'] = $_GPC['input_type'];
		$data['input_name'] = $_GPC['input_name'];
		$data['input_value'] = $input_value;
		$data['value_name'] = $value_name;
		$data['input_default'] = $_GPC['input_default'];
		$data['remark'] = $_GPC['remark'];
		$data['prompts'] = $_GPC['prompts'];
		$data['top'] = $top;
		$res = pdo_update('xm_gohome_tempvalue', $data, array('id'=>$id));
		if($res){
			message('修改字段成功！请点击生成模板生成新的模板文件', $this->createWebUrl('servetemp', array('foo'=>'tempvalue','temp_id'=>$temp_id,'temp_token'=>$temp_token)), 'success');
		}else{
			message('修改字段失败！');
		}
	}
}

if($foo == "valuedelete"){
	$id = intval($_GPC['id']);

	$temp_id = intval($_GPC['temp_id']);
	$temp_token = $_GPC['temp_token'];
	$res = pdo_delete("xm_gohome_tempvalue", array('id'=>$id));
	if($res){
		message('字段删除成功！请点击生成模板生成新的模板文件', $this->createWebUrl('servetemp', array('foo'=>'tempvalue','temp_id'=>$temp_id,'temp_token'=>$temp_token)), 'success');
	}else{
		message('字段删除失败，请重试！');
	}
}

if($foo == "setModel"){
	$temp_id = $_GPC['temp_id'];
	$temp_token = $_GPC['temp_token'];
		
	$data['app'] = 'gohome';
	$data['key'] = $this->key_info;
	$data['modroot'] = urlencode(MODULE_URL);
	$data['posturl'] = urlencode($this->createMobileUrl('templateok',array()));		
			
	$item_m = pdo_fetch("select temp_name,uploadpic,getadr,moren,price,juli,input_1,input_2 from ".tablename('xm_gohome_temp')." where id=".$temp_id);
	$data['title'] = $item_m['temp_name'];
	$data['uploadpic'] = $item_m['uploadpic'];
	$data['getadr'] = $item_m['getadr'];
	$data['moren']  = $item_m['moren'];
	$data['price'] = $item_m['price'];
	$data['juli'] = $item_m['juli'];
	$data['input_1'] = $item_m['input_1'];
	$data['input_2'] = $item_m['input_2'];
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_token='".$temp_token."' order by top asc");
	$idStr = '';
	foreach($arr as $value){
		$idStr .= $value['input_laber'].'$$$$'.$value['input_type'].'$$$$'.$value['input_name'].'$$$$'.$value['value_name'].'$$$$'.$value['input_value'].'$$$$'.$value['input_default'].'$$$$'.$value['remark'].'$$$$'.$value['prompts'].'@@@@';
	}
	$idStr = rtrim($idStr,'@@@@');
		
	$data['filesstr'] = base64_encode($idStr);
	$data['is_format'] = 'yes';
		
	$item = pdo_fetch("select jsgs from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and temp_token='".$temp_token."'");
	$data['tempname'] = $temp_token;
	$data['ex'] = $item['jsgs'];
		
	//$posturl = POSTURL."creatinput_v6.php";
	$posturl = POSTURL."creatinput_v6.1.php";
	$res = $this->post($posturl, $data, 5);
	$res = trim ($res);
	$res = strstr($res, '(');
	$res = str_replace('(','',$res);
	$res = str_replace(')','',$res);
	$res = json_decode($res,true);
	if(empty($res['bodystr'])){
		echo 0;
	}else{
		$data_u['html'] =  $res['bodystr'];
		$data_u['cid'] = $res['cid'];
		$data_u['updatetime'] = date('Y-m-d H:i:s',time());
		$res1 = pdo_update('xm_gohome_temp', $data_u, array('id'=>$temp_id));
		if($res1){
			echo 1;
		}else{
			echo 0;
		}	
	}
}

if($foo == "center"){
	$app = 'gohome';
	$weid = $this->weid;
	$key_info = $this->key_info;
	$data['app'] = 'gohome';
	$data['key'] = $key_info;
	
	$url = POSTURL."showtmp.php";
	$res = $this->post($url, $data, 5);
	$res = str_replace('(','',$res);
	$res = str_replace(')','',$res);
	
	$arr = json_decode($res,true);
	$str = base64_decode($arr['bodystr']);
	if($str != ''){
		$arrt= explode('####',$str);
		$idStr = '';
		foreach($arrt as $a)
		{
			$arrb= unserialize($a);
			$idStr .= '<ul class="thumbnails">
						  <li style="width:262px;" class="list-unstyled">
							<div class="thumbnail">
								<div class="module-pic">
									<img src="http://cloud.n3.cn/gohome_tmpimg/'.$arrb["img"].'">
										<div class="module-detail">
											<h5 class="module-title">'.$arrb["title"].'</h5>
											<p class="module-brief"></p>
										</div>
								</div>
								<div class="module-button">
									<div  onclick="getInfo('.$arrb["id"].')" class="btn btn-primary">点击下载
								</div>
							</div>
						</li>
					</ul>';
		}
	}
		
	$geturl = POSTURL."sendtmp.php";
		
	include $this->template('web/servetemp/temp-shop');
}

if($foo == "centerok"){
	$num = $this->generate_code(4);
	$temp_name = base64_decode($_GPC['temp_name']).'_'.$num;     
	$temp_token = base64_decode($_GPC['temp_token']).'_'.$num;   
	$jsgs = $_GPC['ex'];              
	
	$check = pdo_fetch("select id from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and temp_name='".$temp_name."'");
	if(empty($check['id'])){
		$check1 = pdo_fetch("select id from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and temp_token='".$temp_token."'");
		if(empty($check1)){
			$table_name = 'xm_gohome_'.$temp_token;
			$check2 = pdo_fetch("SHOW TABLES LIKE '".tablename($table_name)."'");
			if(empty($check2)){
				$data['weid'] = $this->weid;
				$data['temp_name'] = $temp_name;
				$data['temp_token'] = $temp_token;
				$data['jsgs'] = $jsgs;
				$res = pdo_insert('xm_gohome_temp', $data);
				$temp_id = pdo_insertid();
				if($res){
					if(!pdo_tableexists($table_name)) {
						$result = pdo_query("CREATE TABLE ".tablename($table_name)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,openid nvarchar(100) DEFAULT NULL,serve_type int(11) DEFAULT NULL,staff_id int(11) DEFAULT NULL,ftime nvarchar(100) DEFAULT NULL,fmobile nvarchar(100) DEFAULT NULL,fname nvarchar(100) DEFAULT NULL,fsex int(11) DEFAULT NULL,fadr nvarchar(300) DEFAULT NULL,fperson nvarchar(100) DEFAULT NULL,random int(11) DEFAULT NULL,flag int(11) DEFAULT 0,dealprice DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
					}
					$bodystr = base64_decode($_GPC['bodystr']);
					$arr = explode("@@@@", $bodystr);
						
					foreach($arr as $item){
						$temp = explode('$$$$',$item);
								
						$input_laber = $temp[0];
						$input_type = $temp[1];
						$input_name = $temp[2];
						$value_name = $temp[3];
						$input_value = $temp[4];
						$input_default = $temp[5];
						$remark = $temp[6];
						$prompts = $temp[7];
						$top = $temp[8];
						if(empty($top)){
							$top = 999;
						}
							
						$data_v['weid'] = $this->weid;
						$data_v['temp_id'] = $temp_id;
						$data_v['temp_token'] = $temp_token;
						$data_v['input_laber'] = $input_laber;
						$data_v['input_type'] = $input_type;
						$data_v['input_name'] = $input_name;
						$data_v['input_value'] = $input_value;
						$data_v['value_name'] = $value_name;
						$data_v['input_default'] = $input_default;
						$data_v['remark'] = $remark;
						$data_v['prompts'] = $prompts;
						$data_v['top'] = $top;	
						$result = pdo_insert('xm_gohome_tempvalue', $data_v);
							
						if(!pdo_fieldexists($table_name,  $input_name)) {
							if($inpty_type == 'times'){
								pdo_query("ALTER TABLE ".tablename($table_name)." ADD `".$input_name."` datetime DEFAULT NULL;");
							}else{
								pdo_query("ALTER TABLE ".tablename($table_name)." ADD `".$input_name."` nvarchar(500) DEFAULT NULL;");
							}
						}
					}
					echo 2;
				}else{
					echo 1;
				}
			}else{
				echo 0;
			}	
		}else{
			echo 0;
		}
	}else{
		echo 3;	
	}
}

?>