<?php
/**
 * DIY多表单模块微站定义
 *
 * @author Jason
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Hacker_diyformModuleSite extends WeModuleSite {


public function doMobileIndex() {
	global $_W,$_GPC;
$rid=$_GPC['rid'];
load()->func('tpl');
$nav = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_nav')." WHERE uniacid = :uniacid and rid = :rid", array(':uniacid' => $_W['uniacid'],':rid'=>$rid));

$reply = pdo_fetch("SELECT * FROM ".tablename('hackerdiyform_reply')." WHERE uniacid = :uniacid and rid = :rid", array(':uniacid' => $_W['uniacid'],':rid'=>$rid));

$list = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_type')." WHERE uniacid = :uniacid and rid = :rid order by orderl desc", array(':uniacid' => $_W['uniacid'],':rid'=>$rid));


$types = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_type')." WHERE uniacid = :uniacid and rid = :rid and type in (0,1,2)", array(':uniacid' => $_W['uniacid'],':rid'=>$rid));





				 


				 

for($i=0;$i<count($types);$i++){
	$o[$types[$i]['id']] = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_sonoption')." WHERE uniacid = :uniacid and rid = :rid and typeid =".$types[$i]['id'], array(':uniacid' => $_W['uniacid'],'rid'=>$rid));
	}
	$data='';
	$picdata='';

//print_r($list);
//exit();

	
			
			
if(!empty($_GPC['submit'])){
	
	if($reply['isfollow']==1){
		$member = pdo_fetch("SELECT * FROM ".tablename('mc_mapping_fans')." WHERE uniacid = :uniacid and openid = :openid and follow = 1", array(':uniacid' => $_W['uniacid'],':openid'=>$_W['openid']));
		
		
		if(empty($member)){
			message('亲，请先关注我们的公众号',$this-> createMobileUrl('index',array('rid'=>$_GPC['rid'])));
			exit();
			}
		}
	
	
	if($reply['postnum']!=0){
		$postnum = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_data')." WHERE uniacid = :uniacid and openid = :openid and rid = :rid", array(':uniacid' => $_W['uniacid'],':openid'=>$_W['openid'],':rid'=>$_GPC['rid']));
		$postnum=count($postnum);
		
		
		
		if($postnum>=$reply['postnum']){
			message('亲，请提交的次数超过上限了',$this-> createMobileUrl('index',array('rid'=>$_GPC['rid'])));
			exit();
			}
			
			
		}
		
	
	
	
	$senddata='';
	for($i=0;$i<count($list);$i++)
				{
			
			
			
				if($list[$i]['type']==9){
					
					
					//修改
					if($reply['issend']==1){
						if($list[$i]['issend']==1){
							
									$sheng=$_GPC['type'.$i.'1'];
									$shi=$_GPC['type'.$i.'2'];
									$qu=$_GPC['type'.$i.'3'];
									$address=$sheng.$shi.$qu;
									
							$senddata.=$list[$i]['name'].':'.$address." \n ";
							
							}
					
					 }
				 		
								$sheng=$_GPC['type'.$i.'1'];
								$shi=$_GPC['type'.$i.'2'];
								$qu=$_GPC['type'.$i.'3'];
								$address=$sheng.$shi.$qu;
								
								$data.=$address.'|';
								
								
	             }	
								
								
			
			
			if($list[$i]['type']!=5&&$list[$i]['type']!=1&&$list[$i]['type']!=9){
				//修改
				if($reply['issend']==1){
					if($list[$i]['issend']==1){
						
						$sd=$_GPC['type'.$i];
						$senddata.=$list[$i]['name'].':'.$sd." \n ";
						
						}
				
				 }	
				
						$datatype=$_GPC['type'.$i];
						$data.=$datatype.'|';
				}else if($list[$i]['type']==1){
						
							
							$sum='';	
								
					for($k=0;$k<count($_GPC['type'.$i]);$k++){
						
			
							$sum.=$_GPC['type'.$i][$k].',';
							
							}
						$sum=substr($sum,0,strlen($sum)-1);
						
						$data.= $sum.'|';
				//修改		
				if($reply['issend']==1){
					if($list[$i]['issend']==1){
						
						
						$senddata.=$list[$i]['name'].':'.$sum." \n ";
						
						}
						
					}
							
									
			}else 
				if($list[$i]['type']==5){
				
				$datatype=$_GPC['type'.$i];
				$picdata.=$datatype.'|';
				}
				}
		$picdata=substr($picdata,0,strlen($picdata)-1);
		$data=substr($data,0,strlen($data)-1);
		
		
		/*if($reply['issend']==1){
			$senddata=substr($senddata,0,strlen($senddata)-1);	
		}*/
		
	
	
		
			$arr = array(
						'uniacid'=> $_W['uniacid'],
						'data'=>$data,
						'pic'=>$picdata,
						'rid'=>$_GPC['rid'],
						'openid'=>$_W['openid'],
						'time'=>time()
					);
							$result = pdo_insert('hackerdiyform_data', $arr);
							
							if (!empty($result)) {
								
								//通知发送
								if($reply['issend']==1){
										
										if($reply['sendmethod']=='sms'){
										
											$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
			//短信
				
					
				
					
					$post_data = "account=".$reply['smsuser']."&password=".$reply['smspass']."&mobile=".$reply['smsnum']."&content=".rawurlencode($senddata);
					//密码可以使用明文密码或使用32位MD5加密
					$gets =  xml_to_array(Post($post_data, $target));
					if($gets['SubmitResult']['code']==2){
						//$_SESSION['mobile'] = $mobile;
						//$_SESSION['mobile_code'] = $mobile_code;
					}
					//echo $gets['SubmitResult']['msg'];

										
										}else 
										
										
										if($reply['sendmethod']=='temp'){
										
											
			//模版消息
			$fans=mc_fansinfo($_W['openid']);
			
				
										sendCustomerFP($reply['sendopenid'],$fans['nickname'],date("Y-m-d  H:i:s",time()),$senddata,$reply['sendid']);
				
					
				

										
										}
										
										
									}
									
								
								
								if($reply['url']){
									header('Location:'.$reply['url']);
									}else{
										message('提交成功',$this-> createMobileUrl('index',array('rid'=>$_GPC['rid'])),'success');
										}
								
								
								
							}else{
								message('提交失败',$this-> createMobileUrl('index',array('rid'=>$_GPC['rid'])),'error');
								}
						
						
			exit();	
		}
		
	
	
	
	

include $this->template('index');
	}

	public function doWebControl() {
		//这个操作被定义用来呈现 管理中心导航菜单
			global $_W,$_GPC;
			
		$row = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_reply')." WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
			
			include $this->template('control'); 
	}
	
	public function doWebManagement() {
		//这个操作被定义用来呈现 管理中心导航菜单
			global $_W,$_GPC;

			$_SESSION['rid']= $_GPC['rid'];
		
			include $this->template('management'); 
	}
	
	
	
	public function doWebNavphoto(){
						
						 global $_W,$_GPC;
						
						 
						 
				if(!empty($_GPC['submit'])){
				 $image=$_GPC['image'];
			
				 $src=$_GPC['src'];
			
				 
				 	$arr = array(
						'uniacid'=> $_W['uniacid'],
						'image'=>$image,
						'src'=>$src,
						'rid'=>$_GPC['rid'],
					);
							$result = pdo_insert('hackerdiyform_nav', $arr);
							if (!empty($result)) {
								message('轮播图片上传成功',$this-> createWebUrl('navphoto',array('rid'=>$_GPC['rid'])),'success');
							}else{
								message('轮播图片上传失败，请返回重试',$this-> createWebUrl('navphoto',array('rid'=>$_GPC['rid'])),'error');
								}
				 
				 
				 
				 
				
				 
				 exit();
				 }
						 include $this->template('navphoto'); 
						}
						
	



public function doWebCnavphoto(){
						
						 global $_W,$_GPC;
						 $rid=$_GPC['rid'];
						 	if(!empty($_GPC['id'])and!empty($_GPC['delete']) ){
					
								$id=$_GPC['id'];
									$result = pdo_delete('hackerdiyform_nav', array('id' => $id));
								if (!empty($result)) {
									message('删除轮播图片成功',$this-> createWebUrl('cnavphoto',array('rid'=>$_GPC['rid'],'uniacid'=>$_W['uniacid'])),'sucess');
								}else{
												message('删除轮播图片失败',$this-> createWebUrl('cnavphoto',array('rid'=>$_GPC['rid'],'uniacid'=>$_W['uniacid'])),'error');
												}
								
								exit();
								}
						 
						 
						 
						 
						 
					if(!empty($_GPC['id'])and!empty($_GPC['change']) ){
					$src=$_GPC['src'];
					$id=$_GPC['id'];
					$image=$_GPC['image'];
				
					
								$user_data = array(
									'src' => $src,
									'image' => $image,
								);
								$result = pdo_update('hackerdiyform_nav', $user_data, array('id' =>$id));
								if (!empty($result)) {
									message('修改轮播图片成功',$this-> createWebUrl('cnavphoto',array('rid'=>$_GPC['rid'])),'sucess');
								}else{
									
									message('修改轮播图片失败',$this-> createWebUrl('cnavphoto',array('rid'=>$_GPC['rid'])),'error');
									}
					exit();
					}
						 
						 $listnav = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_nav').
				 		 "where `uniacid`=:uniacid and rid = ".$rid, array(':uniacid'=>$_W['uniacid']));
						 include $this->template('cnavphoto'); 
						 	}
							
							
							
		public function doWebSet() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;

		 if(!empty($_GPC['submit'])){
			
			 $type=$_GPC['type'];
			 $name=$_GPC['name'];
			 
			
			 
			 
			 $user_data = array(
						'type' => $type,
						'uniacid' => $_W['uniacid'],
						'name'=>$name,
						'rid'=>$_GPC['rid']
					);
				$result = pdo_insert('hackerdiyform_type', $user_data);
				if (!empty($result)) {
					
					message('添加分类成功',$this-> createWebUrl('set',array('rid'=>$_GPC['rid'])),'success');
				}


			 exit();
			 }
			 		 include $this->template('set');
	}
	
	
	
		public function doWebSetlist() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
		
			if(!empty($_GPC['delete'])){
			$id=$_GPC['id'];
			
			$result = pdo_delete('hackerdiyform_type', array('id' => $id));
					if (!empty($result)) {
										message('删除成功',$this-> createWebUrl('setlist',array('rid'=>$_GPC['rid'])),'success');
									}else{
										message('删除失败',$this-> createWebUrl('setlist',array('rid'=>$_GPC['rid'])),'error');
										}
										exit();
			}
			
			
			if(!empty($_GPC['submit'])){
			$id=$_GPC['id'];
			$rid=$_GPC['rid'];
			
			$user_data = array(
				'name' => $_GPC['name'],
				'orderl' => $_GPC['order'],
				'ischeck' => $_GPC['ischeck'],
				'issend' => $_GPC['issend'],
			);
			
			$result = pdo_update('hackerdiyform_type', $user_data, array('id' => $id));
					if (!empty($result)) {
										message('更新成功',$this-> createWebUrl('setlist',array('rid'=>$_GPC['rid'])),'success');
									}else{
										message('更新失败',$this-> createWebUrl('setlist',array('rid'=>$_GPC['rid'])),'error');
										}
										exit();
			}
		
		
		$res = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_type').
				 "where `uniacid`=:uniacid and rid = ".$_GPC['rid'], array(':uniacid'=>$_W['uniacid']));  
			 
		include $this->template('setlist');
	}
	
	
	
	
	
	public function doWebOptionlist() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
	
			$rid=$_GPC['rid'];
			
			if(!empty($_GPC['delete'])){
			$id=$_GPC['id'];
			
			$result = pdo_delete('hackerdiyform_sonoption', array('id' => $id));
					if (!empty($result)) {
										message('删除成功',$this-> createWebUrl('optionlist',array('rid'=>$_GPC['rid'],'typeid'=>$_GPC['typeid'])),'success');
									}else{
										message('删除失败',$this-> createWebUrl('optionlist',array('rid'=>$_GPC['rid'],'typeid'=>$_GPC['typeid'])),'error');
										}
										exit();
			}
			
			
			if(!empty($_GPC['submit'])){
			$id=$_GPC['id'];
			$rid=$_GPC['rid'];
			
			$user_data = array(
				'name' => $_GPC['name'],
				'image'=>$_GPC['image'],
			);
			
			$result = pdo_update('hackerdiyform_sonoption', $user_data, array('id' => $id));
					if (!empty($result)) {
										message('更新成功',$this-> createWebUrl('optionlist',array('rid'=>$_GPC['rid'],'typeid'=>$_GPC['typeid'])),'success');
									}else{
										message('更新成功',$this-> createWebUrl('optionlist',array('rid'=>$_GPC['rid'],'typeid'=>$_GPC['typeid'])),'error');
										}
										exit();
			}
		
		
		$res = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_sonoption').
				 "where `uniacid`=:uniacid and rid = :rid and typeid =".$_GPC['typeid'], array(':uniacid'=>$_W['uniacid'],':rid'=>$rid));  
			 
		include $this->template('optionlist');
	}
	
	
			public function doWebSonoption() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
		
		$rid=$_GPC['rid'];
			
			
			if(!empty($_GPC['submit'])){
			
			$rid=$_GPC['rid'];
			
			$user_data = array(
				'name' => $_GPC['name'],
				'typeid' => $_GPC['typeid'],
				'rid' => $rid,
				'uniacid'=>$_W['uniacid'],
				'image'=>$_GPC['image'],
			);
		
			
		$result = pdo_insert('hackerdiyform_sonoption', $user_data);
		
					if (!empty($result)) {
										message('添加成功',$this-> createWebUrl('sonoption',array('rid'=>$_GPC['rid'])),'success');
									}else{
										message('添加成功',$this-> createWebUrl('sonoption',array('rid'=>$_GPC['rid'])),'error');
										}
										exit();
			}
		
		
		$res = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_type').
				 "where `uniacid`=:uniacid and rid = :rid and type in (0,1,2)", array(':uniacid'=>$_W['uniacid'],':rid'=>$_GPC['rid']));  
			 
		include $this->template('sonoption');
	}
	
	
	
		public function doWebDatalist() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
		$rid=$_GPC['rid'];
		$type = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_type').
				 "where `uniacid`=:uniacid and rid = :rid and type != 5 order by orderl desc", array(':uniacid'=>$_W['uniacid'],':rid'=>$_GPC['rid']));  
			
			
	

	$dataall = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_data').
				 "where `uniacid`=:uniacid and rid = :rid ", array(':uniacid'=>$_W['uniacid'],':rid'=>$_GPC['rid'])); 
				 

			
		if(!empty($_GPC['search'])){
			
			$data = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_data').
				 "where `uniacid`=:uniacid and rid = :rid and data like '%".$_GPC['values']."%'", array(':uniacid'=>$_W['uniacid'],':rid'=>$_GPC['rid'])); 
			
			}else{	 
		
		
				
	        $pindex = $_GPC['page'];
            $strat=$pindex*5-5;

			if($strat<0){
				$strat=0;
				}

            //$start=$pindex*5;
        $data = pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_data').' where `uniacid`=:uniacid and rid = :rid limit '.$strat.',5', array(':uniacid'=>$_W['uniacid'],':rid'=>$_GPC['rid']));   
        $count = pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('hackerdiyform_data').' where `uniacid`=:uniacid and rid = :rid ', array(':uniacid'=>$_W['uniacid'],':rid'=>$_GPC['rid']));
        $pagination = pagination($count, $pindex, 5);    //  生成HTML分页导航条
		
		
			
	
			}
		
				 
		$pic=pdo_fetchall("SELECT * FROM ".tablename('hackerdiyform_type').
				 "where `uniacid`=:uniacid and rid = :rid and type = 5 order by orderl desc", array(':uniacid'=>$_W['uniacid'],':rid'=>$_GPC['rid']));
		
		
		
		
	  for($i=0;$i<count($data);$i++){
		 	
		 
		 		
		  		 $text = $data[$i]['data'];   

				 $datalist[$i] = explode("|",  $text);   
			}	 
			
			//全部数据
			for($i=0;$i<count($dataall);$i++){
		 	
		 
		 		
		  		 $text = $dataall[$i]['data'];   

				 $dataalllist[$i] = explode("|",  $text); 
				 
				  $z[$i][1]=date("Y-m-d  H:i:s",$dataall[$i]['time']);
			
				 
				 $dataalllist[$i]=array_merge_recursive($z[$i], $dataalllist[$i]);
				 
				   
			}	
			
			
			
			 for($i=0;$i<count($data);$i++){
				 $text = $data[$i]['pic'];   

				 $piclist[$i] = explode("|",  $text);   
			}	
			
			
		
		
			if(!empty($_GPC['delete'])){
			$id=$_GPC['id'];
			
			$result = pdo_delete('hackerdiyform_data', array('id' => $id));
					if (!empty($result)) {
										message('删除成功',$this-> createWebUrl('datalist',array('rid'=>$_GPC['rid'],'typeid'=>$_GPC['typeid'])),'success');
									}else{
										message('删除失败',$this-> createWebUrl('datalist',array('rid'=>$_GPC['rid'],'typeid'=>$_GPC['typeid'])),'error');
										}
										exit();
			}
			
			
			
			
			
			if(!empty($_GPC['down'])){
				
				
				//引入PHPExcel库文件（路径根据自己情况）
include '../addons/hacker_diyform/phpexcel/Classes/PHPExcel.php';

//创建对象
$excel = new PHPExcel();
//Excel表格式,这里简略写了8列
$letter = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ');
//表头数组
//$tableheader = array('学号','姓名','性别','年龄','班级');

for($i=0;$i<count($type);$i++){
	$tableheader[$i+1]=$type[$i]['name'];
	
	}


$tableheader[0]='提交时间';


//填充表头信息
for($i = 0;$i < count($tableheader);$i++) {
$excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
}




$data = $dataalllist;


//填充表格信息
for ($i = 2;$i <= count($data) + 1;$i++) {
$j = 0;
foreach ($data[$i - 2] as $key=>$value) {
$excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
$j++;
}
}


//创建Excel输入对象
$write = new PHPExcel_Writer_Excel5($excel);
header("Pragma: public");
header("Expires: 0");
header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
header("Content-Type:application/force-download");
header("Content-Type:application/vnd.ms-execl");
header("Content-Type:application/octet-stream");
header("Content-Type:application/download");;
header('Content-Disposition:attachment;filename="testdata.xls"');
header("Content-Transfer-Encoding:binary");
$write->save('php://output');

				}
	

		
				 include $this->template('datalist');
		}
							
}





























function Post($curlPost,$url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
}
function xml_to_array($xml){
    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    if(preg_match_all($reg, $xml, $matches)){
        $count = count($matches[0]);
        for($i = 0; $i < $count; $i++){
        $subxml= $matches[2][$i];
        $key = $matches[1][$i];
            if(preg_match( $reg, $subxml )){
                $arr[$key] = xml_to_array( $subxml );
            }else{
                $arr[$key] = $subxml;
            }
        }
    }
    return $arr;
}








function sendCustomerFP($openid,$keyword1,$keyword2,$senddata,$template_id) {
    global $_W;
    /*$template_id = pdo_fetchcolumn("select CustomerFP from ".tablename('hc_deluxejjr_templatenews')." where uniacid = ".$_W['uniacid']);*/
    
    if (!empty($template_id)) {
         $datas = array(
            'first' => array('value' => '消息提醒', 'color' => '#73a68d'),
             'keyword1' => array('value' => $keyword1, 'color' => '#73a68d'),
            'keyword2' => array('value' => $keyword2, 'color' => '#73a68d'),
             'remark' => array('value' => $senddata, 'color' => '#73a68d')
             );
        $data = json_encode($datas); //发送的消息模板数据
    }

    if (!empty($template_id)){
        $accountid = pdo_fetch("select * from ".tablename('account_wechats')." where uniacid = ".$_W['uniacid']);
        $appid = $accountid['key'];
        $appSecret = $accountid['secret'];



        if(empty($url)){
            $url = '';
        } else {
            $url = $url;
        }
        $sendopenid = $openid;
        $topcolor = "#FF0000";


        tempmsg($template_id, $url, $data, $topcolor, $sendopenid, $appid, $appSecret);

    }
}



function tempmsg($template_id, $url, $data, $topcolor, $sendopenid, $appid, $appSecret){
    load()->func('communication');

    if ($data->expire_time < time()) {
        $url1 = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appSecret."";
        $res = json_decode(httpGet($url1));

        $tokens = $res->access_token;

        if(empty($tokens)){
            return;
        }
        $postarr = '{"touser":"'.$sendopenid.'","template_id":"'.$template_id.'","url":"'.$url.'","topcolor":"'.$topcolor.'","data":'.$data.'}';
        $res = ihttp_post('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$tokens,$postarr);
    }
}


function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}

