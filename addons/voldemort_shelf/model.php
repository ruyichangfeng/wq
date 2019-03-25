<?php
include MODULE_ROOT.'/shelf-model.php';
include MODULE_ROOT.'/slide-model.php';
include MODULE_ROOT.'/category-model.php';




function mediaId2local($mediaId){
	global $_W;
	$res = pdo_fetchcolumn("SELECT `local_root` FROM ".tablename('wx_sucai_thumbs')." WHERE `wechat_mediaid`=:mediaid",array(':mediaid'=>$mediaId));
	if(empty($res)){
		return media_id($mediaId);
	}
	return local_url($res, $mediaId);
}

function local_url($local_root, $mediaId = ''){
	global $_W;
	$file = ATTACHMENT_ROOT.'/'.$local_root;
	$file = str_replace('///', '/', $file);
	$file = str_replace('//', '/', $file);
	if(file_exists($file)){
		$fileUrl = 'attachment/'.$local_root;
		return $_W['siteroot'].str_replace('//', '/', $fileUrl);
	}
	return media_id($mediaId);
}
//根据图片素材的media_id返回图片在系统中的连接
function media_id($mediaId){
	global $_W;
	$filename = $mediaId.".png";
	$filedir = ATTACHMENT_ROOT.'/images/sucai/';
	if(file_exists($filedir.$filename)){
		return $_W['siteroot'].'attachment/images/sucai/'.$filename;
	}

	$access_token = toolModel::getAccessToken();
	$permanent_news_get_url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$access_token;
	$params = array('media_id'=>$mediaId,'access_token'=>$access_token);

	$result = httpModel::https_request($permanent_news_get_url,json_encode($params));
	if(!file_exists(ATTACHMENT_ROOT.'/images/sucai')){
		mkdir(ATTACHMENT_ROOT.'/images/sucai', 0777, true);
	}
	
	file_put_contents($filedir.$filename, $result);
	$file_root = 'images/sucai/'.$filename;

	$hasExists = pdo_fetch("SELECT * FROM ".tablename('wx_sucai_thumbs')." WHERE `wechat_mediaid`=:mediaId",array(':mediaId'=>$mediaId));
	if($hasExists){
		pdo_update('wx_sucai_thumbs', array('local_root'=>$file_root), array('wechat_mediaid'=>$mediaId));
	}else{
		pdo_insert('wx_sucai_thumbs', array('local_root'=>$file_root,'wechat_mediaid'=>$mediaId));
	}

	return $_W['siteroot'].'attachment/'.$file_root;
	
}

function local2wechat_mediaId($imgFile = ''){
	$imgFile = substr($imgFile, stripos($imgFile,'images'));
	$img_local = ATTACHMENT_ROOT .'/' .$imgFile;
	$img_local = str_replace('//', '/', $img_local);
	if(!file_exists($img_local)){
		img_oss2local($imgFile);
	}
	
	
	if(!in_array(substr(strrchr($img_local, '.'), 1), explode('/', 'bmp/png/jpeg/jpg/gif'))){
		return array('err'=>1,'content'=>'扩展名不对，仅支持bmp/png/jpeg/jpg/gif');
	}
	if(filesize($img_local) > 2*1024*1024){
		return array('err'=>1,'content'=>'图片大小不能超过2M');
	}
	$url = toolModel::getMaterialUrl();
	$Upload = new uploadModel();
	$mediaId = $Upload->localImage2mediaId($url, $img_local);
	pdo_insert('wx_sucai_thumbs', array('wechat_mediaid'=>$mediaId,'local_root'=>$imgFile));
	return array('err'=>0,'content'=>$mediaId);
}
function _encode($str){
	if(is_array($str)){
        foreach($str as $key=>$value) {  
            $str[urlencode($key)] = _encode($value);  
        }  
    } else {  
        $str = urlencode($str);  
    }  
      
    return $str;  
}

function _json_encode($str){
	return urldecode(json_encode(_encode($str)));
}

//更新图文
function modify_new($media){
	WeUtility::logging('更新图文：',$media);
	$access_token = toolModel::getAccessToken();
	$permanent_news_get_url = 'https://api.weixin.qq.com/cgi-bin/material/update_news?access_token='.$access_token;
	
	$_content = _json_encode($media);
	// WeUtility::logging('更新图文-URL：',$permanent_news_get_url);
	// WeUtility::logging('更新图文-内容：',$_content);
	$result = httpModel::https_request($permanent_news_get_url,$_content);
	// WeUtility::logging('更新图文-结果：',$result);
	$result = json_decode($result,true);
	return $result['errcode'] == 0;
}

/*根据media_id获取图文素材详细内容*/
function news_mediaid($mediaId){
	global $_W;
	$access_token = toolModel::getAccessToken();
	$permanent_news_get_url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$access_token;
	$params = array('media_id'=>$mediaId,'access_token'=>$access_token);

	$res = httpModel::https_request($permanent_news_get_url,json_encode($params));
	$res = json_decode($res,true);
	
	// var_dump($res);exit;
	return $res['news_item'];
}

//根据media_id 下载并返回声音素材文件的物理路径
function voice_id_root($mediaId){
	global $_W;
	$filename = $mediaId.".mp3";
	$filedir = ATTACHMENT_ROOT.'/images/sucai/';
	if(file_exists($filedir.$filename)){
		return $filedir.$filename;
	}

	$access_token = toolModel::getAccessToken();
	$permanent_news_get_url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$access_token;
	$params = array('media_id'=>$mediaId,'access_token'=>$access_token);

	$result = httpModel::https_request($permanent_news_get_url,json_encode($params));
	if(!file_exists(ATTACHMENT_ROOT.'/images/sucai')){
		mkdir(ATTACHMENT_ROOT.'/images/sucai', 0777, true);
	}
	
	file_put_contents($filedir.$filename, $result);
	
	if(file_exists($filedir.$filename)){
		return $filedir.$filename;
	}
	return '';
}

function video_id($mediaId){
	global $_W;

	$access_token = toolModel::getAccessToken();
	$permanent_news_get_url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$access_token;
	$params = array('media_id'=>$mediaId,'access_token'=>$access_token);

	$res = httpModel::https_request($permanent_news_get_url,json_encode($params));
	$res = json_decode($res,true);
	if(isset($res['errcode']) && $res['errcode'] != 0){
		$res = array();
	}
	return $res;
}

//删除素材
function del_media_id($mediaId){
	//删除系统中的关键字：
	unkeyword_media($mediaId);
	//删除微信平台中的素材：
	global $_W;
	$access_token = toolModel::getAccessToken();
	$url = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token='.$access_token;
	$params = array('media_id'=>$mediaId,'access_token'=>$access_token);
	$res = httpModel::https_request($url,json_encode($params));
	$res = json_decode($res,true);
	return $res['errcode'] == 0;
}

class toolModel{
	public static $init = array(
					'image'=>array('type'=>'bmp,png,jpeg,jpg,gif','size'=>2097152),
					'voice'=>array('type'=>'mp3,wma,wav,amr','size'=>5242880),
					'video'=>array('type'=>'mp4','size'=>10485760),
					'thumb'=>array('type'=>'jpg,jpeg','size'=>65536),
					);

	public static function getAccessToken(){
		load()->classs('weixin.account');
		$accObj= new WeixinAccount();
		return $accObj->fetch_available_token();
	}

	public static function getMaterialUrl(){
		$access_token = self::getAccessToken();
		$url = 'http://api.weixin.qq.com/cgi-bin/material/add_material?access_token=%s';
		$url = sprintf($url,$access_token);
		return $url;
	}

	public function checkType($type,$value){
		return strpos(self::$init[$type]['type'], $value) === false ? '上传的文件格式不正确,支持的格式：'.self::$init[$type]['type'] : '';

	}

	public function checkSize($type,$value){
		return $value > self::$init[$type]['size'] ? '上传的文件大小不能超过限制（'.$init[$type]['size'] .')' : '';
		
	}
	
	//将文章中的图片转换成微信图片
	public static function trans_news($content){
		global $_W;
		$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.png|\.jpg]))[\'|\"].*?[\/]?>/"; 
		preg_match_all($pattern,$content,$match);
		$uploadModel = new uploadModel();
		$downloadModel = new downloadModel();
		$url = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token='.self::getAccessToken();
		$ori = array();
		$dist = array();
		foreach ($match[1] as $key => $item) {
			$img =  ATTACHMENT_ROOT.'/'.$downloadModel->download_img($item);
			$img = str_replace('//', '/', $img);
			if(!in_array(substr(strrchr($img, '.'), 1), explode('/', 'jpg/png'))){
				message('详情中图片扩展名不对，仅支持jpg/png','','error');
			}
			if(filesize($img) > 1*1024*1024){
				message('详情中图片大小不能超过1M','','error');
			}
			$res = $uploadModel->uploadLocalImage_https($url, $img);
			$content = str_replace($item, $res['content'], $content);
			unlink($img);
		}
		return str_replace('"', "'", $content);
	}


}

class httpModel{
	public static function http_request($url, $data = null)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		if (!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}

	public static function https_request($url, $data = null)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if (!empty($data)){
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}
}

class downloadModel{

	public function downloadWeixinFile($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$package = curl_exec($ch);
		$httpinfo = curl_getinfo($ch);
		curl_close($ch);
		$imageAll = array_merge(array('header' => $httpinfo), array('body' => $package));
		return $imageAll;
	}
	
	public function saveWeixinFile($filename, $filecontent)
	{
		global $_W;
		$picUrl = 'downloads' . '/' . date('Ym') . '/';
		$savePath = ATTACHMENT_ROOT . '/' . $picUrl;
		if(!file_exists($savePath)){
			mkdir($savePath, 0777, true);
		}
		$savePath .= $filename;
		$local_file = fopen($savePath, 'w');
		if (false !== $local_file){
		if (false !== fwrite($local_file, $filecontent)) {
		fclose($local_file);
		return $_W['attachurl'] . $picUrl . $filename;
		}
		}
		return false;
	}
	public function saveFileRoot($filename, $filecontent)
	{
		global $_W;
		$picUrl =  "images/{$_W['uniacid']}/" . date('Y/m/');
		$savePath = ATTACHMENT_ROOT . '/' . $picUrl;
		if(!file_exists($savePath)){
			mkdir($savePath, 0777, true);
		}
		$savePath .= $filename;
		$local_file = fopen($savePath, 'w');
		if (false !== $local_file){
		if (false !== fwrite($local_file, $filecontent)) {
			fclose($local_file);
			return $picUrl.$filename;
		}
		}
		return false;
	}
	public function download_img($url){
		$curl = curl_init($url);
		$filename = date("YmdHis").mt_rand(100,999).".jpg";
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$imageData = curl_exec($curl);
		curl_close($curl);
		return $this->saveFileRoot($filename,$imageData);
		
	}
}

class uploadModel{


	/**
	 * 上传微信永久性图文素材
	 * */
	public function upLoadWxPermanentArticle($articles = array()){
		
		$url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=%s';
		$access_token = toolModel::getAccessToken();
		$url = sprintf($url,$access_token);
		// WeUtility::logging('上传图文-原始内容', json_encode($articles));

		$articleData = _json_encode($articles);
		// WeUtility::logging('上传图文-处理后内容', $articleData);
		// WeUtility::logging('上传图文-URL', $url);
		
		$res = httpModel::https_request($url,$articleData);
		
		// WeUtility::logging('上传图文-返回信息', $res);
		$res = json_decode($res,true);

		return $res;
		
	}
	/**
	 * 上传微信永久性视频素材
	 * */
	public function upLoadWxPermanentVideo($video,$title,$introduction){
		$url = toolModel::getMaterialUrl();
		$data['title'] = $title;
		$data['introduction'] = $introduction;
		
		// $jsonInfo = json_encode($data, JSON_UNESCAPED_UNICODE);

		// $_content = json_encode($data);
		// $jsonInfo = preg_replace("#\\\u(([0-9a-f]+?){4})#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $_content);
		$jsonInfo = _json_encode($data);
		return $this->uploadWxVideo($url, $video,$jsonInfo);
	}
	/**
	 * 上传微信永久性图片素材
	 * */
	public function upLoadWxPermanentImage($imgFile){
		global $_W;
		$url = toolModel::getMaterialUrl();
		$imgFile = ATTACHMENT_ROOT . '/'.$imgFile;
		$res = $this->uploadLocalImage($url, $imgFile);
		/*
		if($res['code'] == 'success'){
			$imgData['media_id'] = $res['content'];
			$imgData['media_type'] = 'image';
			$imgData['created_at'] = time();
			$imgData['uniacid'] = $_W['uniacid'];
			$imgData['acid'] = $_W['acid'];
			pdo_insert('wx_sucai_permanent', $imgData);
		}*/
		return $res;
			
	}
	
	/**
	 * 上传微信永久性语音素材
	 * */
	public function upLoadWxPermanentVoice($voiceFile){
		$url = toolModel::getMaterialUrl();
		return $this->uploadVoice($url, $voiceFile);
		// return $this->uploadWxVoice($url, $voiceFile);

	}
	
	public function fileUpload($file, $type = 'image', $name = '') {
		if(empty($file)) {
			return error(-1, '没有上传内容');
		}
		if($type == 'thumb'){
			$type = 'image';
		}
		if(!in_array($type, array('image','audio','voice','video','thumb'))) {
			return error(-1, '未知的上传类型');
		}
		
		global $_W;
		
		if (empty($_W['uploadsetting'][$type])) {
			$_W['uploadsetting'] = array();
			$_W['uploadsetting'][$type]['folder'] = "{$type}s/{$_W['uniacid']}";
		}
		$settings = $_W['uploadsetting'];
		
		$extention = pathinfo($file['name'], PATHINFO_EXTENSION);
		$result = array();
		
		if(empty($name) || $name == 'auto') {
			$result['path'] = "{$settings[$type]['folder']}/" . date('Y/m/');
			if(!file_exists(ATTACHMENT_ROOT . '/' .$result['path'])){
				mkdir(ATTACHMENT_ROOT . '/' . $result['path'], 0777, true);
			}
			
			do {
				$filename = random(30) . ".{$extention}";
			} while(file_exists(ATTACHMENT_ROOT . '/' . $result['path'] . $filename));
			$result['path'] .= $filename;
		} else {
			$result['path'] = $name . '.' .$extention;
		}
		
		if(!file_move($file['tmp_name'], ATTACHMENT_ROOT . '/' . $result['path'])) {
			return error(-1, 'sorry,保存上传文件失败');
		}
		
		$result['success'] = true;
		return $result;
	}

	public function uploadWxVideo($url, $media,$jsonInfo){
		global $_W;
		$result = array('code'=>'err','content'=>'');
		$allowTypes = array('mp4','rm','rmvb','wmv','avi','mpg','mpeg');
		$mediaType = explode('/', $media['type']);
		$mediaType = $mediaType[1];
		if(!in_array($mediaType, $allowTypes)){
			$result['code'] = 'err';
			$result['content'] = '上传的视频文件格式不正确';
		}
		if($media['size'] > 20971520){
			$result['code'] = 'err';
			$result['content'] = '上传的视频大小不能超过20M';
		}else{
			load()->func('file');
			$file_save = $this->fileUpload($media, 'video', 'auto');
			if(is_array($file_save) && $file_save['success']){
				$file = ATTACHMENT_ROOT.'/'.$file_save['path'];
				$data = array('media'=>'@'.$file,'description'=>$jsonInfo);
				$s = httpModel::http_request($url, $data);
				
				$returnData = json_decode($s, true);
				if(isset($returnData['media_id'])){
					$result['code'] = 'success';
					$result['content'] = $returnData['media_id'];

					// $imgData['media_id'] = $returnData['media_id'];
					// $imgData['media_type'] = $mediaType;
					// $imgData['created_at'] = time();
					// $imgData['uniacid'] = $_W['uniacid'];
					// $imgData['acid'] = $_W['acid'];
					// pdo_insert('wx_sucai_permanent', $imgData);
				}else{
					$result['code'] = 'err';
					$result['content'] = '失败！微信返回信息：'.$s;
				}
				
			}else{
				$result['code'] = 'err';
				$result['content'] = '本地保存文件失败'.var_export($file_save,true);
			}
			
		}
		return $result;
	}
	public function uploadLocalImage($url, $img){
		$data = array('media'=>'@'.$img);
		$s = httpModel::http_request($url, $data);
		$returnData = json_decode($s, true);
		if(isset($returnData['media_id'])){
			$result['code'] = 'success';
			$result['content'] = $returnData['media_id'];
		}else{
			$result['code'] = 'err';
			$result['content'] = '失败！微信返回信息：'.$s;
		}
		return $result;
	}
	public function localImage2mediaId($url, $img){
		$data = array('media'=>'@'.$img);
		$s = httpModel::https_request($url, $data);
		$returnData = json_decode($s, true);
		if(isset($returnData['media_id'])){
			return $returnData['media_id'];
		}
		message($s,'','error');
		return $returnData;
	}
	public function uploadLocalImage_https($url, $img){
		$data = array('media'=>'@'.$img);
		$s = httpModel::https_request($url, $data);
		$returnData = json_decode($s, true);
		if(isset($returnData['url'])){
			$result['code'] = 'success';
			$result['content'] = $returnData['url'];
		}else{
			$result['code'] = 'err';
			$result['content'] = '失败！微信返回信息：'.$s;
		}
		return $result;
	}
	
	public function uploadWxImage($url, $media){
		global $_W;
		$result = array('code'=>'err','content'=>'');
		$allowTypes = array('bmp','png','jpeg','jpg','gif');
		$mediaType = explode('/', $media['type']);
		$mediaType = $mediaType[1];
		if(!in_array($mediaType, $allowTypes)){
			$result['code'] = 'err';
			$result['content'] = '上传的图片文件格式不正确';
		}
		if($media['size'] > 2097152){
			$result['code'] = 'err';
			$result['content'] = '上传的图片大小不能超过2M';
		}else{
			load()->func('file');
			$file_save = $this->fileUpload($media, 'image', 'auto');
			if(is_array($file_save) && $file_save['success']){
				$file = ATTACHMENT_ROOT.'/'.$file_save['path'];
				$data = array('media'=>'@'.$file);
				$s = httpModel::http_request($url, $data);
				
				$returnData = json_decode($s, true);
				if(isset($returnData['media_id'])){
					$result['code'] = 'success';
					$result['content'] = $returnData['media_id'];

				}else{
					$result['code'] = 'err';
					$result['content'] = '失败！微信返回信息：'.$s;
				}
				
			}else{
				$result['code'] = 'err';
				$result['content'] = '本地保存文件失败'.var_export($file_save,true);
			}
			
		}
		return $result;
	}

	public function uploadWxVoice($url, $media){
		global $_W;
		$result = array('code'=>'err','content'=>'');
		$allowTypes = array('mp3','wma','wav','amr');
		$mediaType = explode('/', $media['type']);
		$mediaType = $mediaType[1];
		if(!in_array($mediaType, $allowTypes)){
			$result['code'] = 'err';
			$result['content'] = '上传的语音文件格式不正确';
			return $result;
		}
		if($media['size'] > 5242880){
			$result['code'] = 'err';
			$result['content'] = '上传的语音文件大小不能超过5M';
		}else{
			load()->func('file');
			$file_save = $this->fileUpload($media, 'voice', 'auto');
			if(is_array($file_save) && $file_save['success']){
				$file = ATTACHMENT_ROOT.'/'.$file_save['path'];
				$data = array('media'=>'@'.$file);
				$s = httpModel::http_request($url, $data);
				
				$returnData = json_decode($s, true);
				if(isset($returnData['media_id'])){
					$result['code'] = 'success';
					$result['content'] = $returnData['media_id'];

					// $imgData['media_id'] = $returnData['media_id'];
					// $imgData['media_type'] = $mediaType;
					// $imgData['created_at'] = time();
					// $imgData['uniacid'] = $_W['uniacid'];
					// $imgData['acid'] = $_W['acid'];
					// pdo_insert('wx_sucai_permanent', $imgData);
				}else{
					$result['code'] = 'err';
					$result['content'] = '失败！微信返回信息：'.$s;
				}
				
			}else{
				$result['code'] = 'err';
				$result['content'] = '本地保存文件失败'.var_export($file_save,true);
			}
			
		}
		return $result;
	}

	public function uploadVoice($url, $media){
		$file = ATTACHMENT_ROOT.'/'.$media;
		$data = array('media'=>'@'.$file);
		$s = httpModel::http_request($url, $data);
		
		$returnData = json_decode($s, true);
		if(isset($returnData['media_id'])){
			$result['code'] = 'success';
			$result['content'] = $returnData['media_id'];

		}else{
			$result['code'] = 'err';
			$result['content'] = '失败！微信返回信息：'.$s;
		}
		return $result;
	}
}


