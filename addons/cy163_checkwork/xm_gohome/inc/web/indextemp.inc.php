<?php
global $_W, $_GPC;
checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'ok', 'nav', 'navok', 'edit', 'editok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == "index"){

	$app      = 'gohome';
	$key_info = $this->key_info;
	$modroot  = urlencode(MODULE_URL);

	$data['app'] = 'gohome';
	$data['key'] = $key_info;
	
	$url = POSTURL."showindextmp.php";
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
									<img src="'.$arrb["pic"].'">
										<div class="module-detail">
											<h5 class="module-title">'.$arrb["dis"].'</h5>
											<p class="module-brief"></p>
										</div>
								</div>
								<div class="module-button">
									<div  onclick="getInfo('.$arrb["id"].')" class="btn btn-primary">点击下载
								</div>
								<a href="'.$arrb["pic"].'"  target="_blank">查看大图</a>
							</div>
							<div>'.$arrb["rmark"].'</div>
						</li>
					</ul>';
		}
	}
		
	$geturl = POSTURL."sendindextmp.php";
	//$geturl = POSTURL."sendtmp.php";

	include $this->template('web/indextemp/index');
}

if($foo == "ok"){
	$bodystr = $_GPC['bodystr'];

	mkdir(MODULE_ROOT."/template/mobile/".$_W['uniacid']);
	$path  = MODULE_ROOT."/template/mobile/".$_W['uniacid']."/u_index.html";
	
	$fp = fopen($path,'wb');
	if(false!==$fp){
		$html    = base64_decode($bodystr);
		$res = fwrite($fp, $html);
	    fclose($fp);
	    if($res>0){
		   echo 1;
		}else{
	   	   echo 3;
		}
	}else{
		echo 2; //打开文件失败
	}
}

if($foo == "nav"){

	$item = pdo_get('xm_gohome_nav', array('weid'=>$_W['uniacid']));

	include $this->template('web/indextemp/nav');
}

if($foo == "navok"){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		$data['nav1'] = $_GPC['nav1'];
		$data['nav2'] = $_GPC['nav2'];
		$data['nav3'] = $_GPC['nav3'];
		$data['nav4'] = $_GPC['nav4'];
		if(empty($id)){
			$data['weid'] = $this->weid;
			$result = pdo_insert('xm_gohome_nav',$data);
			if($result){
				message('添加数据成功！', $this->createWebUrl('indextemp', array('foo'=>'nav')), 'success');
			}else{
				message('添加数据失败！');
			}
		}else{
			$data['updatetime'] = date('Y-m-d H:i:s', time());
			$result = pdo_update('xm_gohome_nav', $data, array('id'=>$id));
			if($result){
				message('修改数据成功！', $this->createWebUrl('indextemp', array('foo'=>'nav')), 'success');
			}else{
				message('修改数据失败！');
			}
		}
	}
}

if($foo == "edit"){
	$file_path    = MODULE_ROOT."/template/mobile/".$_W['uniacid']."/u_index.html";
	
	header("content-type:text/html;charset=utf-8");
	//判断是否有这个文件 
	if(file_exists($file_path)){ 
		if($fp=fopen($file_path,"a+")){ 
			$conn = fread($fp,filesize($file_path)); 
		}else{ 
			message("文件打不开"); 
		} 
	}else{ 
		message("没有这个文件"); 
	} 
	fclose($fp);

	include $this->template('web/indextemp/edit');
}

if($foo == "editok"){

	$conn = htmlspecialchars_decode($_GPC['conn'], ENT_QUOTES);

	mkdir(MODULE_ROOT."/template/mobile/".$_W['uniacid']);
	$path  = MODULE_ROOT."/template/mobile/".$_W['uniacid']."/u_index.html";
	
	$fp = fopen($path,'wb');
	if(false!==$fp){
		//$html    = base64_decode($bodystr);
		$res = fwrite($fp, $conn);
	    fclose($fp);
	    if($res>0){
		   message("编辑模板成功！", $this->createWebUrl('indextemp', array('foo'=>'edit')), 'success');
		}else{
	   	   message("编辑模板失败！");
		}
	}else{
		message("打开文件失败");
	}
}
?>