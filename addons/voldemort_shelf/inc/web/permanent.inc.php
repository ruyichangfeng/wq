<?php
/**
 * 永久图文
 * */
date_default_timezone_set('Asia/Shanghai');

require MODULE_ROOT.'/model.php';
global $_GPC, $_W;
$operation = array('ajax_preview_list'=>'预览列表','ajax_rm_preview'=>'删除指定预览微信号','list'=>'默认形式显示','list_list'=>'列表形式显示','list_card'=>'卡片形式显示','post_news'=>'新增图文','del'=>'删除','post'=>'编辑','download'=>'下载','send'=>'群发','set_clock'=>'设置定时群发','send_clock'=>'定时群发','preview'=>'预览','keyword'=>'关键字设置','detail'=>'文章详情','modify_new'=>'编辑图文','ajax'=>'ajax操作获取粉丝分组');
$media = array('news'=>'图文','thumb'=>'图片','voice'=>'声音','video'=>'视频');

$op = isset($_GPC['action']) && array_key_exists($_GPC['action'], $operation) ? $_GPC['action'] : 'list';
$type = isset($_GPC['type']) && array_key_exists($_GPC['type'], $media) ? $_GPC['type'] : 'news';
load()->func('communication');
$Upload = new uploadModel();
$acid = pdo_fetchcolumn("SELECT `acid` FROM ".tablename('account_wechats')." WHERE `uniacid`=:uniacid",array(':uniacid'=>$_W['uniacid']));

if($op == 'ajax'){
	if($_W['isajax']) {
		$acid = intval($_GPC['acid']);
		$groups = pdo_fetch('SELECT * FROM ' . tablename('mc_fans_groups') . ' WHERE uniacid = :uniacid AND acid = :acid', array(':uniacid' => $_W['uniacid'], ':acid' => $acid));
		$groups = unserialize($groups['groups']) ? unserialize($groups['groups']) : array();
		if(empty($groups)) {
			exit(json_encode(array('status' => 'empty', 'message' => '该公众号还没有从公众平台获取粉丝分组')));
		} else {
			$html = '<option name="groupid" value="0">请选择粉丝分组</option><option value="-2" name="groupid">全部用户</option>';
			foreach($groups as $group) {
				if( $group['id'] == 0) {
					$group['id'] = -1;
				}
				$html .= '<option name="groupid" data-num = "'. $group['count'] .'" value="' . $group['id'] . '">' .  $group['name'] . '</option>';
			}
			exit(json_encode(array('status' => 'success', 'message' => $html)));
		}
	}
}
/*获取预览列表*/
if($op == 'ajax_preview_list'){
	$list = preview_list();
	exit(json_encode($list));
}

/*删除指定预览微信号*/
if($op == 'ajax_rm_preview'){
	$wechat = $_GPC['wechat'];
	$list = rm_preview($wechat);
	exit(json_encode($list));
}


if ($op == 'send_clock') {
	send_clock();
}

if($type == 'news' ){
	if($op == 'list_list' || $op == 'list'){
		//图文，列表形式
		$page = isset($_GPC['page']) ? max($_GPC['page'],1) : 1;

		$count = isset($_GPC['count']) ? min($_GPC['count'],20) : 10;
		$access_token = toolModel::getAccessToken();
		$permanent_news_get_url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$access_token;
		
		//if 搜索 指定关键词
		$keyword = trim($_GPC['query']);
		if(!empty($keyword)){
			$permanent_materialcount_url = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token='.$access_token;
			$materialcounts = httpModel::https_request($permanent_materialcount_url);
			
			$materialcounts = json_decode($materialcounts,true);
			if(isset($result['errcode']) && $result['errcode'] != 0){
				message('同步失败：'.$result['errmsg'],'','error');
			}
			$news_count = $materialcounts['news_count'];//图文总数
			
			$_page = 1;
			$_count = 20;
			$_pages = ceil($news_count/$_count);
			$items = array();
			while ($_page <= $_pages) {
				$offset = ($_page-1)*$_count;
				$_page++;
				$params = array('type'=>'news','offset'=>$offset,'count'=>$_count);

				$result = httpModel::https_request($permanent_news_get_url,json_encode($params));
				$result = json_decode($result,true);
				if(isset($result['errcode']) && $result['errcode'] != 0){
					message('同步失败2：'.$result['errmsg'],'','error');
				}
				foreach ($result['item'] as $key => &$news) {
					foreach ($news['content']['news_item'] as $key => &$item) {
						$haystack = array($item['title'], $item['author'], $item['digest'], $item['content']);
						if(stripos(implode(',', $haystack), $keyword) !== false){
							$item['title'] = str_replace($keyword, "<span class='hightlight'>".$keyword."</span>", $item['title']);
							$items[] = $news;
							break;
						}
					}

				}
				
			}

		}else{
			$offset = ($page-1)*$count;
			$params = array('type'=>'news','offset'=>$offset,'count'=>$count);
			$result = httpModel::https_request($permanent_news_get_url,json_encode($params));
			$result = json_decode($result,true);
			if(isset($result['errcode']) && $result['errcode'] != 0){
				message('同步失败：'.$result['errmsg'],'','error');
			}
			$total_count = $result['total_count'];
			$item_count = $result['item_count'];
			$pages = ceil($total_count / $count);
			$items = $result['item'];

		}

		
		$tpl = 'news';
		load()->func('tpl');
		include $this->template('index');
	}elseif($op == 'post_news'){
		load()->func('tpl');
		if(checksubmit('news_submit')){
			$module  = new Sucai_news();
			$msg = $module->fieldsFormValidate();

			$newItems = array();
			if(is_string($msg) && trim($msg) != '') {
				message($msg);
			}
			foreach ($module->replies[0] as $new) {
				$row['title'] = $new['title'];
				$row['author'] = $new['author'];
				$thumb = local2wechat_mediaId($new['thumb']);
				if($thumb['err'] != 0){
					message('图片不符合要求:'.$thumb['content'],'','err');
				}
				if(empty($new['content'])){
					message('详情不能为空','','error');
				}
				$row['thumb_media_id'] = $thumb['content'];
				$row['show_cover_pic'] = $new['incontent'] ? 1 : 0;
				$row['digest'] = $new['description'];
				$row['content'] = toolModel::trans_news(html_entity_decode($new['content']));
				$row['content_source_url'] = substr($new['url'], 0, 4) == 'http' ? $new['url'] : (substr($new['url'], 0, 2) == './' ?  $_W['siteroot'].'app/'.$new['url']: 'http://'.$new['url']);
				$newItems['articles'][] = $row;
			}

				$res = $Upload->upLoadWxPermanentArticle($newItems);
				if(isset($res['media_id'])){
					message('添加成功',$this->createWebUrl('permanent',array('type'=>'news','action'=>'list_list')),'success');
				}
				message('添加失败'.var_export($res,true),'','error');
		}
		
		include $this->template('news_post');
	}elseif ($op == 'del') {
		$mediaId = $_GPC['media'];
		$res = del_media_id($mediaId);
		exit($res);
		
	}elseif ($op == 'send') {

		send($acid,$_GPC['groupid'],$_GPC['groupname'],$_GPC['fansnum'],'news',$_GPC['media_id']);
		
	}elseif ($op == 'preview') {
		/*预览*/
		$wechat = $_GPC['wechat'];
		$media_id = $_GPC['media_id'];
		if(trim($wechat) == ''){
			exit(json_encode(error(-1, '微信号不能为空')));
		}
		$status = preview($wechat,'mpnews',$media_id);
		if(is_error($status)) {
			exit(json_encode($status));
		} else {
			flush_preview_list($wechat);
			exit('success');
		}
	}elseif ($op == 'keyword') {
		$res = keyword('news',$_GPC['media_id'],$_GPC['keyword']);
		if(is_array($res)){
			exit(json_encode($res));
		}else{
			exit('success');
		}
	}elseif($op == 'set_clock'){
		
		$res = set_clock($acid,'news',$_GPC['media_id'],strtotime($_GPC['send_time']),$_GPC['groupid'],$_GPC['groupname'],$_GPC['send_title']);
		if($res){
			exit('success');
		}else{
			exit(json_encode(error(-1, '定时失败')));
		}
	}elseif ($op == 'detail') {
		$media_id = trim($_GPC['media']);
		$news = news_mediaid($media_id);
		$new = $news[$_GPC['item']];
		$pic_url = $new['pic_url'] = media_id($new['thumb_media_id']);
		$pic_url = str_replace($_W['siteroot'], '', $pic_url);
		$new['pic_root'] = str_replace('attachment/', '', $pic_url);
		exit(json_encode($new));
	}elseif($op == 'modify_new'){
		if(checksubmit()){
			$thumb = local2wechat_mediaId($_GPC['thumb']);
			if($thumb['err'] != 0){
				message('图片不符合要求:'.$thumb['content'],'','err');
			}
			$param['media_id'] = trim($_GPC['media']);
			$param['index'] = $_GPC['item'];
			$param['articles'] = array('title'=>$_GPC['title'],
										'thumb_media_id'=>html_entity_decode($thumb['content']),
										'author'=>html_entity_decode($_GPC['author']),
										'digest'=>html_entity_decode($_GPC['digest']),
										'show_cover_pic'=>$_GPC['incontent'],
										'content'=>toolModel::trans_news(html_entity_decode($_GPC['u_content'])),
										'content_source_url'=>substr($_GPC['content_source_url'], 0, 4) == 'http' ? $_GPC['content_source_url'] : 'http://'.$_GPC['content_source_url'],
									);
			$result = modify_new($param);
			if($result){
				message('更新图文成功',$this->createWebUrl('permanent',array('type'=>'news','action'=>'list')),'success');
			}else{
				message('更新图文失败','','error');
			}
		}
		
		if(!empty($_GPC['media'])){
			$media_id = trim($_GPC['media']);
			$pos = $_GPC['item'];
			$news = news_mediaid($media_id);
			$new = $news[$pos];
			$pic_url = $new['pic_url'] = media_id($new['thumb_media_id']);
			$new['content'] = str_replace('data-src', 'src', $new['content']);
			load()->func('tpl');
			
		}
		include $this->template('news_modify');
	}
	
}elseif ($type == 'thumb') {
	if($op == 'del') {
		$mediaId = $_GPC['media'];
		$res = del_media_id($mediaId);
		exit($res);
		
	}elseif($op == 'list'){
		//缩略图
		$page = isset($_GPC['page']) ? max($_GPC['page'],1) : 1;

		$count = isset($_GPC['count']) ? min($_GPC['count'],20) : 12;
		$access_token = toolModel::getAccessToken();

		$permanent_news_get_url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$access_token;
		$offset = ($page-1)*$count;
		
		$params = array('type'=>'image','offset'=>$offset,'count'=>$count);

		$result = ihttp_request($permanent_news_get_url,json_encode($params));
		$result = json_decode($result['content'],true);
		$total_count = $result['total_count'];
		$item_count = $result['item_count'];

		$pages = ceil($total_count / $count);
		$items = $result['item'];
		$images = array();
		foreach ($items as $key => $item) {
			$image['url'] = media_id($item['media_id']);
			$image['name'] = $item['name'];
			$image['media_id'] = $item['media_id'];
			$images[] = $image;
		}
		$tpl = 'image';
		include $this->template('index');
	}elseif ($op == 'post') {
		load()->func('tpl');
		if(checksubmit('thumb_submit')){
			foreach ($_GPC['image'] as $key => $item) {
				// $uploadImage = $Upload->upLoadWxPermanentImage($item);
				// if($uploadImage['code'] == 'err'){
				// 	message(var_export($uploadImage['content'],true),'','error');
				// }
				$thumb = local2wechat_mediaId($item);
				if($thumb['err'] != 0){
					message('图片不符合要求:'.$thumb['content'],'','err');
				}
			}
			
			message('添加成功',$this->createWebUrl('permanent',array('type'=>'thumb','action'=>'list')),'success');

		}
		include $this->template('image_post');
	}elseif ($op == 'send') {
		send($acid,$_GPC['groupid'],$_GPC['groupname'],$_GPC['fansnum'],'image',$_GPC['media_id']);
		
	}elseif ($op == 'preview') {
		$wechat = $_GPC['wechat'];
		$media_id = $_GPC['media_id'];
		if(trim($wechat) == ''){
			exit(json_encode(error(-1, '微信号不能为空')));
		}
		$status = preview($wechat,'image',$media_id);
		if(is_error($status)) {
			exit(json_encode($status));
		} else {
			
			exit('success');
		}
	}elseif ($op == 'keyword') {
		$res = keyword('image',$_GPC['media_id'],$_GPC['keyword']);
		if(is_array($res)){
			exit(json_encode($res));
		}else{
			exit('success');
		}
	}elseif($op == 'set_clock'){
		$res = set_clock($acid,'image',$_GPC['media_id'],strtotime($_GPC['send_time']),$_GPC['groupid'],$_GPC['groupname']);
		if($res){
			exit('success');
		}else{
			exit(json_encode(error(-1, '定时失败')));
		}
	}

}elseif ($type == 'voice') {
	//声音
	if($op == 'list'){
		$page = isset($_GPC['page']) ? max($_GPC['page'],1) : 1;

		$count = isset($_GPC['count']) ? min($_GPC['count'],20) : 12;
		$access_token = toolModel::getAccessToken();

		$permanent_news_get_url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$access_token;
		$offset = ($page-1)*$count;
		
		$params = array('type'=>'voice','offset'=>$offset,'count'=>$count);

		$result = ihttp_request($permanent_news_get_url,json_encode($params));
		$result = json_decode($result['content'],true);
		$total_count = $result['total_count'];
		$item_count = $result['item_count'];

		$pages = ceil($total_count / $count);
		$items = $result['item'];
		foreach ($items as $key => $item) {
			$voice['name'] = $item['name'];
			$voice['media_id'] = $item['media_id'];
			$voice['update_time'] = $item['update_time'];
			$voices[] = $voice;
		}
		$tpl = 'voice';
		include $this->template('index');
	}elseif ($op == 'download') {
		$mediaId = $_GPC['media'];
		$mediaName = $_GPC['name'];
		$file = voice_id_root($mediaId);
		$fileTmp = pathinfo($file);
		$fp=fopen($file,"r");  
		$file_size=filesize($file);  
		  
		Header("Content-type: application/octet-stream");   
		Header("Accept-Length:".$file_size);   
		Header("Content-Disposition: attachment; filename=".$mediaName);   
		readfile($file);
	}elseif ($op == 'del') {
		$mediaId = $_GPC['media'];
		$res = del_media_id($mediaId);
		exit($res);
	}elseif ($op == 'post') {
		load()->func('tpl');
		if(checksubmit('voice_submit')){

			$uploadVoice = $Upload->upLoadWxPermanentVoice($_GPC['media']);
			if($uploadVoice['code'] == 'err'){
				message(var_export($uploadVoice['content'],true),'','error');
			}else{
				
				message('添加成功',$this->createWebUrl('permanent',array('type'=>'voice','action'=>'list')),'success');
			}
		}
		include $this->template('voice_post');
	}elseif ($op == 'preview') {
		$wechat = $_GPC['wechat'];
		$media_id = $_GPC['media_id'];
		if(trim($wechat) == ''){
			exit(json_encode(error(-1, '微信号不能为空')));
		}
		$status = preview($wechat,'voice',$media_id);
		if(is_error($status)) {
			exit(json_encode($status));
		} else {
			
			exit('success');
		}
	}elseif ($op == 'send') {
		send($acid,$_GPC['groupid'],$_GPC['groupname'],$_GPC['fansnum'],'voice',$_GPC['media_id']);
		
	}elseif ($op == 'keyword') {
		$res = keyword('voice',$_GPC['media_id'],$_GPC['keyword']);
		if(is_array($res)){
			exit(json_encode($res));
		}else{
			exit('success');
		}
	}elseif($op == 'set_clock'){
		$res = set_clock($acid,'voice',$_GPC['media_id'],strtotime($_GPC['send_time']),$_GPC['groupid'],$_GPC['groupname']);
		if($res){
			exit('success');
		}else{
			exit(json_encode(error(-1, '定时失败')));
		}
	}

}elseif ($type == 'video') {
	if($op == 'list'){
		$page = isset($_GPC['page']) ? max($_GPC['page'],1) : 1;

		$count = isset($_GPC['count']) ? min($_GPC['count'],9) : 9;
		$access_token = toolModel::getAccessToken();

		$permanent_news_get_url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$access_token;
		$offset = ($page-1)*$count;
		
		$params = array('type'=>'video','offset'=>$offset,'count'=>$count);

		$result = ihttp_request($permanent_news_get_url,json_encode($params));
		$result = json_decode($result['content'],true);
		$total_count = $result['total_count'];
		$item_count = $result['item_count'];

		$pages = ceil($total_count / $count);
		$items = $result['item'];
		foreach ($items as $key => $item) {
			$video['name'] = $item['name'];
			$video['media_id'] = $item['media_id'];
			$video['update_time'] = $item['update_time'];
			$video['detail'] = video_id($item['media_id']);
			$videos[] = $video;
		}
		$tpl = 'video';
		include $this->template('index');
	}elseif ($op == 'post') {
		
		load()->func('tpl');
		include $this->template('video_post');
	}elseif ($op == 'del') {
		$mediaId = $_GPC['media'];
		$res = del_media_id($mediaId);
		exit($res);
	}elseif ($op == 'preview') {
		$wechat = $_GPC['wechat'];
		$media_id = $_GPC['media_id'];
		if(trim($wechat) == ''){
			exit(json_encode(error(-1, '微信号不能为空')));
		}
		$status = preview($wechat,'mpvideo',$media_id);
		if(is_error($status)) {
			exit(json_encode($status));
		} else {
			
			exit('success');
		}
	}elseif ($op == 'send') {
		send($acid,$_GPC['groupid'],$_GPC['groupname'],$_GPC['fansnum'],'video',$_GPC['media_id']);
		
	}elseif ($op == 'keyword') {
		$res = keyword('video',$_GPC['media_id'],$_GPC['keyword']);
		if(is_array($res)){
			exit(json_encode($res));
		}else{
			exit('success');
		}
	}elseif($op == 'set_clock'){
		$res = set_clock($acid,'video',$_GPC['media_id'],strtotime($_GPC['send_time']),$_GPC['groupid'],$_GPC['groupname']);
		if($res){
			exit('success');
		}else{
			exit(json_encode(error(-1, '定时失败')));
		}
	}

}

exit;
//以下是旧内容

$item = isset($_GPC['item']) ? $_GPC['item'] : '';
$Upload = new uploadModel();
if($operation == 'post'){
	$access_token = toolModel::getAccessToken();
	
	load()->func('tpl');
	if($item == 'thumb'){
		if(checksubmit('thumb-submit')){
			$uploadVoice = $Upload->upLoadWxPermanentImage($_GPC['thumb']);
			if($uploadVoice['code'] == 'err'){
				message(var_export($uploadVoice['content'],true),'','error');
			}else{
				message('添加成功','refresh','success');
			}
		}
	}elseif($item == 'video'){
		if(checksubmit('video-submit')){
			$title = $_GPC['video-title'];
			$introduction = $_GPC['video-introduction'];
			$uploadVoice = $Upload->upLoadWxPermanentVideo($_FILES['permanent-video'],$title,$introduction);
			if($uploadVoice['code'] == 'err'){
				message(var_export($uploadVoice['content'],true),'','error');
			}else{
				
				message('添加成功','refresh','success');
			}
		}
	}elseif($item == 'voice'){
		if(checksubmit('voice-submit')){
			$uploadVoice = $Upload->upLoadWxPermanentVoice($_FILES['permanent-voice']);
			if($uploadVoice['code'] == 'err'){
				message(var_export($uploadVoice['content'],true),'','error');
			}else{
				
				message('添加成功','refresh','success');
			}
		}
	}elseif($item == 'image'){
		if(checksubmit('image-submit')){
			$uploadImage = $Upload->upLoadWxPermanentImage($_GPC['thumb']);
			if($uploadImage['code'] == 'err'){
				message(var_export($uploadImage['content'],true),'','error');
			}else{
				message('添加成功','refresh','success');
			}
		}
	}elseif($item == 'news'){
		if(checksubmit('single-submit') || checksubmit('multiple-submit')){
			$newItems = array();
			foreach ($_GPC['titles'] as $k => $v) {
				$thumb = $_GPC['thumbs'][$k];

				$media = $Upload->upLoadWxPermanentImage($thumb);
				if($media['code'] == 'err'){
					message('图片上传失败'.var_export($media['content'],true),'','error');
					exit;
				}
				$row['title'] = $v;
				$row['author'] = $_GPC['authors'][$k];
				$row['thumb_media_id'] = $media['content'];
				$row['digest'] = $_GPC['descriptions'][$k];
				$row['content'] = html_entity_decode($_GPC['contents'][$k]);
				$row['content_source_url'] = $_GPC['urls'][$k];
				$row['show_cover_pic'] = in_array($k+1, $_GPC['incontent']) ? 1 : 0;
				// $row['createtime'] = time();
				$newItems['articles'][] = $row;
			}
			$res = $Upload->upLoadWxPermanentArticle($newItems);
			if($res){
				message('添加成功','refresh','success');
			}
			message('添加失败'.var_export($res,true),'','error');
		}
		
	}
}elseif($operation == 'display'){
	global $_W,$_GPC;
	$p = isset($_GPC['page']) ? $_GPC['page'] : 1;
	$pindex = max(1,intval($p));
	$psize = 20;
	$sql = "SELECT * FROM " . tablename('wx_sucai_permanent') . " WHERE `uniacid`=:uniacid ORDER BY `permanent_id` DESC LIMIT ".($pindex-1)*$psize.",{$psize}";
	$medias = pdo_fetchall($sql, array(':uniacid'=>$_W['uniacid']));
	if(!empty($medias)){
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ". tablename('wx_sucai_permanent')." WHERE `uniacid`=:uniacid",array(':uniacid'=>$_W['uniacid']));
		$pager = pagination($total,$pindex,$psize);
	}
	// $medias = pdo_fetchall("SELECT * FROM " . tablename('wx_sucai_permanent') . " ORDER BY `permanent_id` DESC");
	
}elseif($operation == 'ajax'){
	$access_token = $this->getAccessToken();
	if($item == 'single'){
		$url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=%s';
		$url = sprintf($url,$access_token);
		$param1 = $_GPC['singleParams'];
		$param2 = $_GPC['singleContent'];
		$data['articles'] = array();

	echo json_encode($param1);
	exit;
		
		
	}
	
}
include $this->template('permanent');