<?php
defined('IN_IA') or exit('Access Denied');
define('MB_ROOT', IA_ROOT . '/addons/cgc_voice_book');
require MB_ROOT . '/inc/util.php';
require MB_ROOT . '/inc/common.php';


class cgc_voice_bookModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W;
		$settings=$this->module['config'];
		$uniacid=$_W['uniacid'];
		$from_user=$this->message['from'];
		load()->model('mc');
		$member=mc_fetch($from_user);
		
		//上传图片
		if($this->message['msgtype']=="image"){
			
			load()->classs('weixin.account');
			$acc= WeixinAccount::create($uniacid);
			$arr= array("media_id"=>$this->message['mediaid']);
			$file= $acc->downloadMedia($arr);
			if (is_error($file)){
				return $this->respText("mediaid:".$this->message['mediaid']."||".$file['message']);
			}
			$cgc_voice_book_pic = new cgc_voice_book_pic();
			$data=array("uniacid"=>$_W['uniacid'],
					"openid"=>$from_user,
					"headimgurl"=>$member['avatar'],
					"nickname"=>$member['nickname'],
					"pic"=>$file,
					"media_id"=>$this->message['mediaid'],
					"createtime"=>time()
			);
			
			$temp=$cgc_voice_book_pic->insert($data);
			if ($temp){
				if ($settings['auto_audit']==1){
					return $this->respText("上传图片成功，请等待审核！");
				}else{
					 $msg=send_invite_code_new($from_user,$member);
					return $this->respText($msg);
				
				}
			}
		} else {
			//文字回复
			if (!empty($settings['resp_txt'])){
				post_send_text($from_user,$settings['resp_txt']);
			}
			
			//图片回复
			if (!empty($settings['resp_pic'])){
				$settings['resp_pic']=$this->remote_file($settings['resp_pic']);
				$acc= WeixinAccount::create($uniacid);
			
				$ret=$acc->uploadMedia($settings['resp_pic']);
				if (!is_error($ret)){
					$data = array(
							"touser"=>$from_user,
							"msgtype"=>"image",
							"image"=>array("media_id"=>$ret["media_id"])
					);
					$acc->sendCustomNotice($data);
				} else {
				 
				}
			}
			
			return '';
		}
  }
  
  
  function remote_file($src_file) {
     global $_W;     
     if (!empty($_W['setting']['remote']['type'])) {   
     	load()->func('file');	
     	mkdirs(ATTACHMENT_ROOT . "cgc_voice_book/".date("Y/m/d"));	
	    $target_file=ATTACHMENT_ROOT ."cgc_voice_book/".date("Y/m/d")."/".time().rand(1,1000).".jpg";	     
		if (!$this->copyfiles(tomedia($src_file),$target_file)){
		   exit("error file");
		 }		 
		 return $target_file;
	   } else {
	   	return $src_file;
     }	
   }
   
   function copyfiles($file1,$file2){ 
    $contentx =@file_get_contents($file1); 
    $openedfile = fopen($file2, "w"); 
  fwrite($openedfile, $contentx); 
  fclose($openedfile); 
   if ($contentx === FALSE) { 
   $status=false; 
   }else $status=true; 
   return $status; 
  } 
  
}