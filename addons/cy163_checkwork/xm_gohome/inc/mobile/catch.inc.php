<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$this->checkreg();

$foo = $_GPC['foo'];
$foos = array('index', 'getInfo', 'project', 'staffinfo', 'commentlist', 'getcommentlist');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$list1 = pdo_fetchall("select id,type_name,icon from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and delstate=1");

	$page ='catch';
		
	include $this->template($this->temp.'_catch');
}

if($foo == 'getInfo'){
		$forumPage = $_GPC['forumPage'];
		$type_id   = $_GPC['type_id'];
		if(empty($_GPC['lat'])){
			echo 0;
			exit();
		}
		$adrstr = $this->encode_geohash($_GPC['lat'],$_GPC['lng'],12);
		$adrstr = substr($adrstr,0,2);
		
		$pageSize = 10;
        $startCount=($forumPage-1)*$pageSize;
		
		if(empty($_GPC['type_id'])){
			$arr = pdo_fetchall("select * from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and company_mge=0 and stop=1 and openid != '' and delstate = 1 and adrstr like '".$adrstr."%' order by adrstr desc limit ".$startCount.",".$pageSize."");
		}else{
			$arr = pdo_fetchall("select * from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and company_mge=0 and stop=1 and openid != '' and delstate = 1 and find_in_set(".$_GPC['type_id'].",serve_type) and adrstr like '".$adrstr."%' order by adrstr desc limit ".$startCount.",".$pageSize."");
		}
		if(empty($arr)){
			echo 0;
		}else{
			$start = "[";
			$idStr = '';
			foreach($arr as $value){
				$id   = intval($value['id']);
				$url  = $this->createMobileUrl('catch',array('foo'=>'staffinfo', 'id'=>$id));
				$jump = $_W['siteroot']."app/index.php?i=".$this->weid."&c=entry&id=".$id."&do=catch&foo=project&m=xm_gohome";
				$juli = $this->getDistance($value['lat'],$value['log'],$_GPC['lat'],$_GPC['lng']);
				if($value['avatar'] == ''){
					$avatar = MODULE_URL.'static/images/11.jpg';
				}else{
					if(substr($value['avatar'],0,6) == 'images'){
						$avatar = $_W['attachurl'].$value['avatar'];
					}else{
                    	$avatar = $_W['attachurl'].'gohome/avatar/'.$value['avatar'];
                    }
				}
				$pro          = $this->getStaffPro($value['id']);
				$staff_name   = $value['staff_name'];
				$company_name = $value['company_name'];
				$get_order    = $value['get_order'];
				$good 		  = $value['good'];
				if(strpos($value['card_all'], '身份证') !== false){
					$shiming = 1;
				}else{
					$shiming = 0;
				}
				
				if($value['sex'] == 1){
					$sex = '他';
				}else if($value['sex'] == 2){
					$sex = '她';
				}else{
					$sex = '他(她)';
				}
				
				$bao        = 0;
				$grade_icon = '';
				if($value['company_flag'] == 1){
					if($this->getGrade($company_name, $value['openid'], 'grade_money') > 0){
						$bao 		= 1;
						$grade_icon = $_W['attachurl'].$this->getGradeInfo($this->getGrade($company_name, $value['openid'] , 'grade_id'), 'icon');
					}
				}else{
					if($value['grade_money']>0){
						$bao        = 1;
						$grade_icon = $_W['attachurl'].$this->getGradeInfo($value['grade_id'], 'icon');
					}
				}
				
				$idStr .= '{"id":"'.$id.'","url":"'.$url.'","jump":"'.$jump.'","juli":"'.$juli.'","avatar":"'.$avatar.'","pro":"'.$pro.'","staff_name":"'.$staff_name.'","company_name":"'.$company_name.'","get_order":"'.$get_order.'","good":"'.$good.'","shiming":"'.$shiming.'","sex":"'.$sex.'","bao":"'.$bao.'","grade_icon":"'.$grade_icon.'"},';
			}
			$idStr = rtrim($idStr,',');
			$end = ']';
			$json = $start.$idStr.$end;
			echo $json;
		}
}

if($foo == 'project'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		$id = 0;
	}
	$item = pdo_fetch("select staff_name,serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
	$arr = explode(",",$item['serve_type']);
		
	$idStr = '';
	for($i=0;$i<count($arr);$i++){
		$sitem = pdo_fetch("select id,type_name from ".tablename('xm_gohome_servetype')." where id=".$arr[$i]." and delstate=1");
		if(!empty($sitem)){
			$tid = $sitem['id'];
			$type_name = $sitem['type_name'];
			$url = $this->createMobileUrl('templateok', array('foo'=>'index', 'id'=>$tid, 'staff_id'=>$id));
			$idStr .= '<li><a href="'.$url.'" target="_blank" class="block-in uinn2-1 uba b-gra5 umar-a">'.$type_name.'</a></li>';
		}
	}
	$idStr = rtrim($idStr,'/');
		
	include $this->template($this->temp.'_showpro');
}

if($foo == 'staffinfo'){
	$id = $_GPC['id'];
	if(empty($id)){
		message('参数错误：未获取到工人ID');
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_staff')." where id=".$id." and delstate=1");
		
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_comment')." where weid=".$this->weid." and staff_id=".$id." and type='servetype' order by addtime desc limit 0,8");
		
	$page     = 'catch';
	$catch_bg = $this->getBase('catch_bg');
		
	include $this->template($this->temp.'_catchstaff');
}

if($foo == 'commentlist'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误：未获取到工人ID');
	}
		
	$page = 'catch';
		
	include $this->template($this->temp.'_commentlist');
}

if($foo == 'getcommentlist'){
	$staff_id  = $_GPC['staff_id'];
	if(empty($staff_id)){
		echo 0;
	}
	$forumPage = $_GPC['forumPage'];
	$pageSize  = 5;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_comment')." where weid=".$this->weid." and staff_id='".$staff_id."' order by addtime desc limit ".$startCount.",".$pageSize."");
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			if($this->getMemberInfo($value['openid'], 'avatar') == ''){
				$avatar = '';
			}else{
				$avatar = $this->getMemberInfo($value['openid'], 'avatar');
			}
			$nickname = $this->getMemberInfo($value['openid'], 'nickname');
			$xing = $value['xing'];
			$comment = $value['comment'];
			$addtime = $value['addtime'];
			$idStr .= '{"id":"'.$id.'","avatar":"'.$avatar.'","nickname":"'.$nickname.'","xing":"'.$xing.'","comment":"'.$comment.'","addtime":"'.$addtime.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

?>