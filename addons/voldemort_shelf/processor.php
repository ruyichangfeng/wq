<?php
/**
 * 素材管理模块处理程序
 *
 * @author voldemort
 * @url http://bbs.we7.cc/
 */
require 'model.php';
defined('IN_IA') or exit('Access Denied');

class Voldemort_shelfModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W;
		
	}

	public function resp_media($media){
		switch ($media['type']) {
			case 'news':
				$news = news_mediaid($media['media_id']);
				foreach ($news as $key => $item) {
					$new['title'] = $item['title'];
					$new['description'] = $item['digest'];
					$new['picurl'] = media_id($item['thumb_media_id']);
					$new['url'] = $item['url'];
					$res[] = $new;
				}
				return $this->respNews($res);
				break;
			case 'image':
				return $this->respImage($media['media_id']);
				break;
			case 'voice':
				return $this->respVoice($media['media_id']);
				break;
			case 'video':
				$video = video_id($media['media_id']);
				return $this->respVideo(array('MediaId'=>$media['media_id'],'Title'=>$video['name'],'Description'=>$video['description']));
				break;
			
			default:
				# code...
				break;
		}
	}
}