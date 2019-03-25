<?php
/**
 * 米花商城模块处理程序
 *
 * @author 米花
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
require("myclass/autoLoad.php");
require("myclass/func.php");

class mihua_mallModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W, $_GPC;
		$config  = $this->module['config']; 
		load()->model('mc');
		$account = $_W['account'];
		if ($this->message['content'] == '分销专属二维码') {
			return $this->loadImg_QR($account,1,'',' and active=1 ');
		}
		if(strstr($this->message['content'], "产品+")){
			return $this->loadImg_QR($account,11,'product_qr');
		}
		#生成公众号海报
		$keysword = pdo_fetch("select * from ".tablename('rule_keyword')." where content=:content and module='mihua_mall' and status=1 ",array('content'=>$this->message['content']));
		if($keysword){
			$rule=pdo_fetch("select * from ".tablename('rule')." where id=:rid",array('rid'=>$keysword['rid']));
			if($rule['name']=='进入公众号(系统维护)'){
				return $this->loadImg_QR($account,10,'weixin_qr');
			}
		}
		//用户扫描关注二维码机那里
		if($this->message['content']=='mihua_mall' && $this->message['scene']>0 || $this->message['content']=='from_user_qr'){
			if($this->message['content']=='from_user_qr'){
				$this->message['eventkey']=$this->message['scene'];
			}
			$profile_share 			= D('member')->dataEdit($this->message['scene'],false);
			$seid   	   			= $profile_share['id'];
			$openid    	   			= $this->message['from'];
			$params["from_user"] 	= $openid;
			$profile   				= D('member')->edit($params,false);	
			$access_token = $this->get_weixin_token();
			$content  = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid} ");
			$con_arr  = json_decode($content,true);
			$nickname = $con_arr['nickname'];			
			if (!$profile) {
				$data 				= array(
											   'from_user' 		=> $openid, 
											   'realname' 		=> $nickname, 
											   'commission' 	=> 0, 
											   'createtime' 	=> TIMESTAMP, 
											   'shareid' 		=> $seid, 
											   'status' 		=> 1, 
											   'flag' 			=> 0,
											   'uid' 			=> $uid,
											   'pwd' 			=> 'er'
									);
				D('member')->dataAdd($data);
				#end 更新
				$notice = "恭喜你，您的会员【".$nickname."】通过扫描您的二维码，".$config['take_notice'];
				if($profile_share['shareid']>0){
					$profile_share2 = D('member')->dataEdit($profile_share['shareid'],false); 
					$notice2 		= "恭喜你，您的会员【".$nickname."】通过扫描您下级【{$profile_share['realname']}】的二维码，".$config['take_notice'];
					$this->sendcustomMsg($account,$profile_share2['from_user'],$notice2);	
				}
				if($profile_share2['shareid']>0){
					$profile_share3 = D('member')->dataEdit($profile_share2['shareid'],false);
					$notice3 		= "恭喜你，您的会员【".$nickname."】通过扫描您下级【{$profile_share2['realname']}】的下级【{$profile_share['realname']}】二维码，".$config['take_notice'];
					$this->sendcustomMsg($account,$profile_share3['from_user'],$notice3);	
				}
			}else{
				$notice = "您好：会员【".$nickname."】扫描您的二维码";
			}
			$this->sendcustomMsg($account,$profile_share['from_user'],$notice);			
			$this->sendcustomMsg($account,$openid,$config['scan_code_word']);	
		}
		#end
	}
	public function loadImg_QR($account,$msgtype,$model,$other_where=''){
				global $_W;
				$rule=pdo_fetch("select * from ".tablename('mihua_mall_channel')." where msgtype=:msgtype and isdel=0  and uniacid=:uniacid {$other_where} order by channel desc",array('uniacid' => $GLOBALS['_W']['uniacid'],'msgtype'=>$msgtype));
				$profile = pdo_fetch('SELECT * FROM ' . tablename('mihua_mall_member') . " WHERE  uniacid = :uniacid  AND from_user = :from_user ", array(':uniacid' => $GLOBALS['_W']['uniacid'], ':from_user' => $this->message['from']));
			/*	if (empty($profile['id']) || $profile['flag']==0) {
					$regurl = $GLOBALS['_W']['siteroot']."app/index.php?i={$GLOBALS['_W']['uniacid']}&c=entry&do=register&m=mihua_mall&uniacid=".$GLOBALS['_W']['uniacid']."";
					return $this->respText("请先注册成代理！购买一单就成为代理了啦！");
				}
				*/
				if($rule){
						if($model=='weixin_qr'){
							$barcode=array(
    								'action_name'=>'QR_LIMIT_SCENE',    // 临时二维码, 
    								'action_info'=>array(
    									'scene'=>array(
    										'scene_id'=>$profile['id']
    										)
    									),
								);				
						}elseif($model=='product_qr'){
							list($a,$product_name)=explode('+', $this->message['content']);
							#搜索产品名
							$product_result=pdo_fetch("select * from ".tablename('mihua_mall_goods')." where title='{$product_name}' ");
							$homeurl = $GLOBALS['_W']['siteroot'] . "app/index.php?i={$GLOBALS['_W']['uniacid']}&c=entry&do=detail&m=mihua_mall&id=" . $product_result['id'] . '&mid=' . $profile['id'];
						}else{
							$homeurl = $GLOBALS['_W']['siteroot'] . "app/index.php?i={$GLOBALS['_W']['uniacid']}&c=entry&do=list&m=mihua_mall&uniacid=" . $GLOBALS['_W']['uniacid'] . '&mid=' . $profile['id'];
						}

					$follow  = pdo_fetch("select * from " . tablename('mihua_mall_follow') . " WHERE uniacid=:uniacid and follower=:from_user and channel=:channel limit 1", array(':uniacid' => $GLOBALS['_W']['uniacid'], ':from_user' => $this->message['from'],':channel'=>$rule['channel']));
					if (!empty($follow['follower'])) {
						if ($follow['createtime'] > TIMESTAMP) {
							exit;
						} else {
							pdo_update('mihua_mall_follow', array('createtime' => TIMESTAMP + (3)), array('uniacid' => $GLOBALS['_W']['uniacid'], 'follower' => $this->message['from'],'channel'=>$rule['channel']));
						}
					} else {
						$insert = array('uniacid' => $GLOBALS['_W']['uniacid'], 'follower' => $this->message['from'], 'leader' => $this->message['from'], 'channel' => $rule['channel'], 'credit' => 0, 'createtime' => TIMESTAMP + (3));
						pdo_insert('mihua_mall_follow', $insert);
					}
				   $qmjf_qr = pdo_fetch("select * from " . tablename('mihua_mall_qr') . " WHERE uniacid=:uniacid and from_user=:from_user and channel=:channel  limit 1", array(':uniacid' => $GLOBALS['_W']['uniacid'], ':from_user' => $this->message['from'], ':channel' => $rule['channel']));
				   if ((empty($qmjf_qr['id']) || empty($qmjf_qr['qr_url']) || empty($qmjf_qr['media_id']) || empty($qmjf_qr['id'])) || (!empty($qmjf_qr['expiretime']) && $qmjf_qr['expiretime'] < TIMESTAMP) || $model == 'product_qr') {
				     // if(1){
				     	pdo_update('mihua_mall_follow', array('createtime' => TIMESTAMP + (6)), array('uniacid' => $GLOBALS['_W']['uniacid'], 'follower' => $this->message['from'],'channel'=>$rule['channel']));
				     	if (!empty($rule['notice'])) {
				     		$res=$this->sendcustomMsg($account, $this->message['from'], $rule['notice']);
				       	}
				       	if (empty($qmjf_qr['id'])) {
				       		$insert = array('uniacid' => $GLOBALS['_W']['uniacid'], 'from_user' => $this->message['from'], 'channel' => $rule['channel'], 'qr_url' => '', 'media_id' => 0, 'expiretime' => TIMESTAMP + (60 * 24 * 6), 'createtime' => TIMESTAMP);
				       		pdo_insert('mihua_mall_qr', $insert);
				       	}
				  	  $tqmjf_qr = pdo_fetch("select * from " . tablename('mihua_mall_qr') . " WHERE uniacid=:uniacid and from_user=:from_user and channel=:channel  limit 1", array(':uniacid' => $GLOBALS['_W']['uniacid'], ':from_user' => $this->message['from'], ':channel' => $rule['channel']));
				  	  $newid    = $tqmjf_qr['id'];
						
				  	  if($model=='weixin_qr'){
				  	  		load()->classs('account');
				  	  		$this->account = WeAccount::create($GLOBALS['_W']['acid']);
				  	  		$weixin_qr=$this->account->barCodeCreateFixed($barcode);								
				  	  		$qrfile="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$weixin_qr['ticket'];
							
				  	  		//系统的--二维码管理
				  	  		$insert = array(
								'uniacid' => $GLOBALS['_W']['uniacid'],
								'acid' => $GLOBALS['_W']['acid'],
								'qrcid' =>$profile['id'],
								'keyword' => 'mihua_mall',
								'name' => '进入公众号二维码',
								'model' => 2,
								'ticket' => $weixin_qr['ticket'],
								'url' => $qrfile,
								'expire' => $barcode['expire_seconds'],
								'createtime' => TIMESTAMP,
								'status' => '1',
								'type' => 'scene',
							);
							pdo_insert('qrcode', $insert);
						
				  	  }else{
				  			if (!empty($profile['id'])) {
			  					$qrfile = $this->getURLQR($profile['id'], $this->message['from'], $homeurl);
							 } else {
								$qrfile = $this->getURLQR(0, $this->message['from'], $homeurl);
							}
				  	  }
					for ($a = 0; $a < 3; $a++) {
						$qrpic = $this->genImage($rule['bg'], $qrfile, $GLOBALS['_W']['uniacid'], $this->message['from'],$rule['channel']);
						
						if (!empty($qrpic)) {
							$a = 4;
						}
					}
					
					  	$media_id = $this->uploadImage($account,$qrpic);							  								 
					//	$content  = @json_decode($media_id, true);						
					//	pdo_update('mihua_mall_qr', array('expiretime' => TIMESTAMP + (86400 * 2), 'media_id' => $content['media_id'], 'qr_url' => $qrpic), array('id' => $newid));
					pdo_update('mihua_mall_qr', array('expiretime' => TIMESTAMP + (86400 * 2), 'media_id' => $media_id, 'qr_url' => $qrpic), array('id' => $newid));
					$this->sendcustomIMG($account, $this->message['from'], 	$media_id);						
					
						
						
						exit;
					} else {
						return $this->respImage($qmjf_qr['media_id']);
					}

					}else{
						return $this->respText("商家未设置二维码生成");
					}

		}
	public function uploadImage($account, $img) {
		return $this->uploadRes($this->get_weixin_token(), $img, 'image');
	}
	public function sendcustomMsg($account, $from_user, $msg) {
		$access_token = $this->get_weixin_token();
		$url          = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
		$post         = '{"touser":"' . $from_user . '","msgtype":"text","text":{"content":"' . $msg . '"}}';
		$msg=$this->curlPost($url, $post);
	}

	public function sendcustomIMG($account, $from_user, $msg) {
		
		$access_token = $this->get_weixin_token();
		$url          = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
		$post         = '{"touser":"' . $from_user . '","msgtype":"image","image":{"media_id":"' . $msg . '"}}';
		$this->curlPost($url, $post);
	}
	
  
	public function getURLQR($mid, $from_user, $homeurl) {
		include IA_ROOT. "/framework/library/qrcode/phpqrcode.php";
		$value                = $homeurl . '&mid=' . $mid;
		$errorCorrectionLevel = "L";
		$matrixPointSize      = "4";
		$rand_file            = $from_user . '.png';
		$att_target_file      = 'qr-' . $rand_file;
		$target_file          = MODULE_ROOT . '/tmppic/' . $att_target_file;
		QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);
		return $target_file;
	}

	/*public function uploadRes($access_token, $img, $type) {
		$url  = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$type}";
		$post = array('media' => '@' . $img);
		$ret  = $this->curlPost($url, $post);
		return $ret;
	} */

	private function uploadRes($access_token, $img, $type) {
    $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$type}";
    $post = array(
      'media' => '@' . $img
    );
    $ret = $this->http_request($url, $post);
    $content = @json_decode($ret['content'], true);
    return $content['media_id'];
  }
 
  public static function http_request($url, $post = '', $extra = array(), $timeout = 60000)
  {
    $timeout = intval($timeout / 1000);
    $timeout = (0 == $timeout) ? 1 : $timeout;
    $urlset = parse_url($url);
    if(empty($urlset['path'])) {
      $urlset['path'] = '/';
    }
	
    if(!empty($urlset['query'])) {
      $urlset['query'] = "?{$urlset['query']}";
    }
    if(empty($urlset['port'])) {
      $urlset['port'] = $urlset['scheme'] == 'https' ? '443' : '80';
    }
    if (strexists($url, 'https://') && !extension_loaded('openssl')) {
      if (!extension_loaded("openssl")) {
        message('请开启您PHP环境的openssl');
      }
    }
    if(function_exists('curl_init') && function_exists('curl_exec')) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $urlset['scheme']. '://' .$urlset['host'].($urlset['port'] == '80' ? '' : ':'.$urlset['port']).$urlset['path'].$urlset['query']);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HEADER, 1);
      if($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        if (is_array($post)) {
          $filepost = false;
          foreach ($post as $name => $value) {
            if (substr($value, 0, 1) == '@') {
              $filepost = true;
              $post[$name] = class_exists('CURLFile', false) ? new CURLFile(substr($value, 1)) : $value;
              break;
            }
          }
          if (!$filepost) {
            $post = http_build_query($post);
          }
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      }
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSLVERSION, 1);
      if (defined('CURL_SSLVERSION_TLSv1')) {
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
      }
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
      if (!empty($extra) && is_array($extra)) {
        $headers = array();
        foreach ($extra as $opt => $value) {
          if (strexists($opt, 'CURLOPT_')) {
            curl_setopt($ch, constant($opt), $value);
          } elseif (is_numeric($opt)) {
            curl_setopt($ch, $opt, $value);
          } else {
            $headers[] = "{$opt}: {$value}";
          }
        }
        if(!empty($headers)) {
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
      }
      $data = curl_exec($ch);
      $status = curl_getinfo($ch);
      $errno = curl_errno($ch);
      $error = curl_error($ch);
      curl_close($ch);
      if($errno || empty($data)) {
        return error(1, $error);
      } else {
        load()->func('communication');
        return ihttp_response_parse($data);
      }
    }
    $method = empty($post) ? 'GET' : 'POST';
    $fdata = "{$method} {$urlset['path']}{$urlset['query']} HT"."TP/1.1\r\n";
    $fdata .= "Host: {$urlset['host']}\r\n";
    if(function_exists('gzdecode')) {
      $fdata .= "Accept-Encoding: gzip, deflate\r\n";
    }
    $fdata .= "Connection: close\r\n";
    if (!empty($extra) && is_array($extra)) {
      foreach ($extra as $opt => $value) {
        if (!strexists($opt, 'CURLOPT_')) {
          $fdata .= "{$opt}: {$value}\r\n";
        }
      }
    }
    $body = '';
    if ($post) {
      if (is_array($post)) {
        $body = http_build_query($post);
      } else {
        $body = urlencode($post);
      }
      $fdata .= 'Content-Length: ' . strlen($body) . "\r\n\r\n{$body}";
    } else {
      $fdata .= "\r\n";
    }
    if($urlset['scheme'] == 'https') {
      $fp = fsockopen('ssl://' . $urlset['host'], $urlset['port'], $errno, $error);
    } else {
      $fp = fsockopen($urlset['host'], $urlset['port'], $errno, $error);
    }
    stream_set_blocking($fp, true);
    stream_set_timeout($fp, $timeout);
    if (!$fp) {
      return error(1, $error);
    } else {
      fwrite($fp, $fdata);
      $content = '';
      while (!feof($fp))
        $content .= fgets($fp, 512);
      fclose($fp);
      load()->func('communication');
      return ihttp_response_parse($content, true);
    }
  }




	public function curlPost($url, $data) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$info = curl_exec($ch);
		curl_close($ch);
		return $info;
	}
	private function genImage($bg, $qr_file, $uniacid, $from_user,$channel) {
		global $_W;
		$express = pdo_fetch("select * from " . tablename('mihua_mall_channel') . " WHERE channel=:channel", array(':channel' => $channel));
		if (!empty($express['channel'])) {
			$rand_file           = $from_user . '.jpg';
			$att_target_file     = 'qr-image-' . $rand_file;
			$att_head_cache_file = 'head-image-' . $rand_file;
			$target_file         = MODULE_ROOT . '/tmppic/' . $att_target_file;
			$head_cache_file     = MODULE_ROOT . '/tmppic/' . $att_head_cache_file;
			$bg_file             = ATTACHMENT_ROOT .'/'. $bg;
			$ch                  = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_channel') . " WHERE channel=:channel", array(":channel" => $express['channel']));
			$ch                  = $this->decode_channel_param($ch, $ch['bgparam']);
			$this->mergeImage($bg_file, $qr_file, $target_file, array('left' => $ch['qrleft'], 'top' => $ch['qrtop'], 'width' => $ch['qrwidth'], 'height' => $ch['qrheight']));
			$enableHead = $ch['avatarenable'];
			$enableName = $ch['nameenable'];
			$uid=mc_openid2uid($from_user);
			$fans=mc_fetch($uid,array('nickname', 'avatar'));
			$fans_info=mc_fansinfo($uid,$_W['acid'],$uniacid);
			if (!empty($fans)) {
				if ($enableName) {
					if (strlen($fans_info['nickname']) > 0) {
					//	return $this->respText($fans_info['nickname']);
						$this->writeText($target_file, $target_file, '我是' . $fans_info['nickname'], array('size' => $ch['namesize'], 'left' => $ch['nameleft'], 'top' => $ch['nametop']));
					}
				}
				if ($enableHead) {
					if (strlen($fans['avatar']) > 10) {
						$head_file = $fans['avatar'];
						$bild      = $head_cache_file;
						$url       = $this->curl_file_get_contents($head_file);
						$fp        = fopen($bild, 'w');
						$ws        = fwrite($fp, $url);
						fclose($fp);
						if ($ws == false || $ws == 0 || empty($ws)) {
							return '';
						}
						$this->mergeImage($target_file, $head_cache_file, $target_file, array('left' => $ch['avatarleft'], 'top' => $ch['avatartop'], 'width' => $ch['avatarwidth'], 'height' => $ch['avatarheight']));
					}
				}
			}
			return MODULE_ROOT . '/tmppic/' . $att_target_file;
		}
		return '';
	}
	public function curl_file_get_contents($durl) {
		$r = null;
		if (function_exists('curl_init') && function_exists('curl_exec')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $durl);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$r = curl_exec($ch);
			curl_close($ch);
		}
		return $r;
	}

	public function writeText($bg, $out, $text, $param = array()) {
		list($bgWidth, $bgHeight) = getimagesize($bg);
		extract($param);
		$im    = imagecreatefromjpeg($bg);
		$black = imagecolorallocate($im, 0, 0, 0);
		$font  = MODULE_ROOT . '/font/msyhbd.ttf';
		$white = imagecolorallocate($im, 255, 255, 255);
		imagettftext($im, $size, 0, $left, $top + $size / 2, $white, $font, $text);
		ob_start();
		imagejpeg($im, NULL, 100);
		$contents = ob_get_contents();
		ob_end_clean();
		imagedestroy($im);
		$fh = fopen($out, "w+");
		fwrite($fh, $contents);
		fclose($fh);
	}
	public static function decode_channel_param($item, $p) {
		$gpc                  = unserialize($p);
		$item['qrleft']       = intval($gpc['qrleft']) ? intval($gpc['qrleft']) : 145;
		$item['qrtop']        = intval($gpc['qrtop']) ? intval($gpc['qrtop']) : 475;
		$item['qrwidth']      = intval($gpc['qrwidth']) ? intval($gpc['qrwidth']) : 240;
		$item['qrheight']     = intval($gpc['qrheight']) ? intval($gpc['qrheight']) : 240;
		$item['avatarleft']   = intval($gpc['avatarleft']) ? intval($gpc['avatarleft']) : 111;
		$item['avatartop']    = intval($gpc['avatartop']) ? intval($gpc['avatartop']) : 10;
		$item['avatarwidth']  = intval($gpc['avatarwidth']) ? intval($gpc['avatarwidth']) : 86;
		$item['avatarheight'] = intval($gpc['avatarheight']) ? intval($gpc['avatarheight']) : 86;
		$item['avatarenable'] = intval($gpc['avatarenable']);
		$item['nameleft']     = intval($gpc['nameleft']) ? intval($gpc['nameleft']) : 211;
		$item['nametop']      = intval($gpc['nametop']) ? intval($gpc['nametop']) : 68;
		$item['namesize']     = intval($gpc['namesize']) ? intval($gpc['namesize']) : 16;
		$item['namecolor']    = $gpc['namecolor'];
		$item['nameenable']   = intval($gpc['nameenable']);
		return $item;
	}
	
	public function mergeImage($bg, $qr, $out, $param) {
		list($bgWidth, $bgHeight) = getimagesize($bg);
		list($qrWidth, $qrHeight) = getimagesize($qr);
		extract($param);
		$bgImg = $this->imagecreate($bg);
		$qrImg = $this->imagecreate($qr);
		imagecopyresized($bgImg, $qrImg, $left, $top, 0, 0, $width, $height, $qrWidth, $qrHeight);
		ob_start();
		imagejpeg($bgImg, NULL, 100);
		$contents = ob_get_contents();
		ob_end_clean();
		imagedestroy($bgImg);
		imagedestroy($qrImg);
		$fh = fopen($out, "w+");
		fwrite($fh, $contents);
		fclose($fh);
	}

	public function imagecreate($bg) {
		$bgImg = @imagecreatefromjpeg($bg);
		if (FALSE == $bgImg) {
			$bgImg = @imagecreatefrompng($bg);
		}
		if (FALSE == $bgImg) {
			$bgImg = @imagecreatefromgif($bg);
		}
		return $bgImg;
	}
	public function get_weixin_token() {
		global $_W;
		load()->classs('account');
		$accObj= WeixinAccount::create($_W['acid']);
		$access_token = $accObj->fetch_token();
		return $access_token;		
	}	 
}