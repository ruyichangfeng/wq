<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */global $_W, $_GPC;
   $operation = in_array ( $_GPC ['op'], array ('default','fabu','mfabu','zfabu','fangxue','sxcfb','xcfb','dellimg') ) ? $_GPC ['op'] : 'default';

    if ($operation == 'default') {
	           die ( json_encode ( array (
			         'result' => false,
			         'msg' => '你是傻逼吗'
	                ) ) );
              }			
	if ($operation == 'fabu') {
		
		 load()->func('communication');
		 load()->classs('weixin.account');
		 load()->func('file');
         $accObj= WeixinAccount::create($_W['account']['acid']);
         $access_token = $accObj->fetch_token();
	     $token2 =  $access_token;
		 $photoUrls = explode ( ',', $_GPC ['photoUrls'] );
		 $data = explode ( '|', $_GPC ['json'] );
		 
				if(!empty($photoUrls[0])) {		 
					$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[0];
					$pic_data = ihttp_request($url);
					$path = "images/";
					$picurl0 = $path.random(30) .".jpg";
					file_write($picurl0,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl0); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}					
				}
		
				if(!empty($photoUrls[1])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[1];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl1 = $path.random(30) .".jpg";
				file_write($picurl1,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl1); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[2])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[2];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl2 = $path.random(30) .".jpg";
				file_write($picurl2,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl2); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}
		
				if(!empty($photoUrls[3])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[3];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl3 = $path.random(30) .".jpg";
				file_write($picurl3,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl3); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[4])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[4];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl4 = $path.random(30) .".jpg";
				file_write($picurl4,$pic_data['content']);	
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl4); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[5])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[5];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl5 = $path.random(30) .".jpg";
				file_write($picurl5,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl5); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[6])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[6];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl6 = $path.random(30) .".jpg";
				file_write($picurl6,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl6); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[7])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[7];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl7 = $path.random(30) .".jpg";
				file_write($picurl7,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl7); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[8])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[8];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl8 = $path.random(30) .".jpg";
				file_write($picurl8,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl8); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}
				
		 $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid'])); 
		
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			
			if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求,请刷新页面！' 
		               ) ) );
					   
		    }else{
					 				
				$schoolid = $_GPC['schoolid'];
			
				$title = $_GPC['title'];
			
				$weid = $_GPC['weid'];
			
				$content = $_GPC['content'];
			
				$tid = $_GPC['tid'];
			
				$bj_id = $_GPC['bj_id'];

				$course_id = $_GPC['course_id'];

				$tname = $_GPC['tname'];
				
				$temp = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'tid' => $tid,
					'tname' => $tname,
					'title' => $title,
					'content' => $content,
					'createtime' => time(),
					'bj_id' => $bj_id,
					'course_id' => $course_id,
					'type'=>1,
				);
				
				$picstr = array(
						'p1' => $picurl0,
						'p2' => $picurl1,
						'p3' => $picurl2,
						'p4' => $picurl3,
						'p5' => $picurl4,
						'p6' => $picurl5,
						'p7' => $picurl6,
						'p8' => $picurl7,
                        'p9' => $picurl8,						
				         );
				
                $temp['picarr'] = iserializer($picstr);	
				
			    pdo_insert($this->table_notice, $temp);
			
			    $notice_id = pdo_insertid();
			
			    if ($setting['istplnotice'] == 1 && $setting['bjtz']) {

				   $this->sendMobileBjtz($notice_id, $schoolid, $weid, $tname, $course_id);
				
			    }else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			    }
	
			
		        $data ['result'] = true;
			
			    $data ['msg'] = '发布成功，请勿重复发布！';		
				
			}
          die ( json_encode ( $data ) ); 
		}
    }

	if ($operation == 'mfabu') {
		
		 load()->func('communication');
		 load()->classs('weixin.account');
		 load()->func('file');
         $accObj= WeixinAccount::create($_W['account']['acid']);
         $access_token = $accObj->fetch_token();
	     $token2 =  $access_token;
		 $photoUrls = explode ( ',', $_GPC ['photoUrls'] );
		 $data = explode ( '|', $_GPC ['json'] );
		 
				if(!empty($photoUrls[0])) {		 
					$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[0];
					$pic_data = ihttp_request($url);
					$path = "images/";
					$picurl0 = $path.random(30) .".jpg";
					file_write($picurl0,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl0); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}					
				}
		
				if(!empty($photoUrls[1])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[1];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl1 = $path.random(30) .".jpg";
				file_write($picurl1,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl1); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[2])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[2];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl2 = $path.random(30) .".jpg";
				file_write($picurl2,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl2); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}
		
				if(!empty($photoUrls[3])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[3];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl3 = $path.random(30) .".jpg";
				file_write($picurl3,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl3); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[4])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[4];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl4 = $path.random(30) .".jpg";
				file_write($picurl4,$pic_data['content']);	
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl4); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[5])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[5];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl5 = $path.random(30) .".jpg";
				file_write($picurl5,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl5); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[6])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[6];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl6 = $path.random(30) .".jpg";
				file_write($picurl6,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl6); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[7])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[7];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl7 = $path.random(30) .".jpg";
				file_write($picurl7,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl7); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[8])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[8];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl8 = $path.random(30) .".jpg";
				file_write($picurl8,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl8); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}
				
		 $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid'])); 
		
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			
			if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求,请刷新页面！' 
		               ) ) );
					   
		    }else{
					 				
				$schoolid = $_GPC['schoolid'];
			
				$title = $_GPC['title'];
			
				$weid = $_GPC['weid'];
			
				$content = $_GPC['content'];
			
				$tid = $_GPC['tid'];
			
				$groupid = $_GPC['bj_id']; //用户组
							
				$tname = $_GPC['tname'];
				
				$temp = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'tid' => $tid,
					'tname' => $tname,
					'title' => $title,
					'content' => $content,
					'createtime' => time(),
					'type'=>2,
					'groupid'=>$groupid,
				);
				
				$picstr = array(
						'p1' => $picurl0,
						'p2' => $picurl1,
						'p3' => $picurl2,
						'p4' => $picurl3,
						'p5' => $picurl4,
						'p6' => $picurl5,
						'p7' => $picurl6,
						'p8' => $picurl7,
                        'p9' => $picurl8,						
				         );
				
                $temp['picarr'] = iserializer($picstr);	
				
			    pdo_insert($this->table_notice, $temp);
			
			    $notice_id = pdo_insertid();
			
			    if ($setting['istplnotice'] == 1 && $setting['xxtongzhi']) {
				
				   $this->sendMobileXytz($notice_id, $schoolid, $weid, $tname, $groupid);
				
			    }else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			    }
	
			
		        $data ['result'] = true;
			
			    $data ['msg'] = '发布成功，请勿重复发布！';		
				
			}
          die ( json_encode ( $data ) ); 
		}
    }

	if ($operation == 'zfabu') {
		
		 load()->func('communication');
		 load()->classs('weixin.account');
		 load()->func('file');
         $accObj= WeixinAccount::create($_W['account']['acid']);
         $access_token = $accObj->fetch_token();
	     $token2 =  $access_token;
		 $photoUrls = explode ( ',', $_GPC ['photoUrls'] );
		 $data = explode ( '|', $_GPC ['json'] );
		 
				if(!empty($photoUrls[0])) {		 
					$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[0];
					$pic_data = ihttp_request($url);
					$path = "images/";
					$picurl0 = $path.random(30) .".jpg";
					file_write($picurl0,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl0); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}					
				}
		
				if(!empty($photoUrls[1])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[1];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl1 = $path.random(30) .".jpg";
				file_write($picurl1,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl1); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[2])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[2];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl2 = $path.random(30) .".jpg";
				file_write($picurl2,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl2); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}
		
				if(!empty($photoUrls[3])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[3];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl3 = $path.random(30) .".jpg";
				file_write($picurl3,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl3); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[4])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[4];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl4 = $path.random(30) .".jpg";
				file_write($picurl4,$pic_data['content']);	
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl4); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[5])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[5];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl5 = $path.random(30) .".jpg";
				file_write($picurl5,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl5); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[6])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[6];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl6 = $path.random(30) .".jpg";
				file_write($picurl6,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl6); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[7])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[7];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl7 = $path.random(30) .".jpg";
				file_write($picurl7,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl7); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[8])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[8];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl8 = $path.random(30) .".jpg";
				file_write($picurl8,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl8); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}
				
		 $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid'])); 
		
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			
			if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求,请刷新页面！' 
		               ) ) );
					   
		    }else{
					 				
				$schoolid = $_GPC['schoolid'];
			
				$title = $_GPC['title'];
			
				$weid = $_GPC['weid'];
			
				$content = $_GPC['content'];
			
				$tid = $_GPC['tid'];

				$course_id = $_GPC['course_id'];
			
				$bj_id = $_GPC['bj_id']; //班级
				
				$km_id = $_GPC['km_id']; //班级
							
				$tname = $_GPC['tname'];
				
				$temp = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'tid' => $tid,
					'tname' => $tname,
					'title' => $title,
					'content' => $content,
					'createtime' => time(),
					'type'=>3,
					'km_id'=>$km_id,
					'bj_id'=>$bj_id,
					'course_id' => $course_id,
				);
				
				$picstr = array(
						'p1' => $picurl0,
						'p2' => $picurl1,
						'p3' => $picurl2,
						'p4' => $picurl3,
						'p5' => $picurl4,
						'p6' => $picurl5,
						'p7' => $picurl6,
						'p8' => $picurl7,
                        'p9' => $picurl8,						
				         );
				
                $temp['picarr'] = iserializer($picstr);	
				
			    pdo_insert($this->table_notice, $temp);
			
			    $notice_id = pdo_insertid();
			
			    if ($setting['istplnotice'] == 1 && $setting['zuoye']) {
				
				   $this->sendMobileZuoye($notice_id, $schoolid, $weid, $tname, $course_id);
				
			    }else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			    }
	
			
		        $data ['result'] = true;
			
			    $data ['msg'] = '发布成功，请勿重复发布！';		
				
			}
          die ( json_encode ( $data ) ); 
		}
    }

	if ($operation == 'fangxue') {

		 $data = explode ( '|', $_GPC ['json'] );
	
		 $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid'])); 
		
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			
			if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求,请刷新页面！' 
		               ) ) );
					   
		    }else{
					 				
				$schoolid = $_GPC['schoolid'];
						
				$weid = $_GPC['weid'];
									
				$bj_id = $_GPC['bj_id']; //班级
											
				$tname = $_GPC['tname'];

			    if ($setting['istplnotice'] == 1 && $setting['bjtz']) {
				
				   $this->sendMobileFxtz($schoolid, $weid, $tname, $bj_id);
				
			    }else{
				  die ( json_encode ( array (
                  'result' => false,
                  'msg' => '发送失败，请联系管理员开启模版消息！' 
		               ) ) );
			    }	
			
		        $data ['result'] = true;
			
			    $data ['msg'] = '群发成功，请勿重复发布！';		
				
			}
          die ( json_encode ( $data ) ); 
		}
    }

	if ($operation == 'sxcfb') {
		
		 load()->func('communication');
		 load()->classs('weixin.account');
		 load()->func('file');
         $accObj= WeixinAccount::create($_W['account']['acid']);
         $access_token = $accObj->fetch_token();
	     $token2 =  $access_token;
		 $photoUrls = explode ( ',', $_GPC ['photoUrls'] );
		 $data = explode ( '|', $_GPC ['json'] );
		 $school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id = :id", array(':weid' => $_GPC ['weid'], ':id' => $_GPC ['schoolid']));
				if(!empty($photoUrls[0])) {		 
					$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[0];
					$pic_data = ihttp_request($url);
					$path = "images/";
					$picurl0 = $path.random(30) .".jpg";
					file_write($picurl0,$pic_data['content']);			
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl0); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}
		
				if(!empty($photoUrls[1])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[1];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl1 = $path.random(30) .".jpg";
				file_write($picurl1,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl1); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[2])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[2];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl2 = $path.random(30) .".jpg";
				file_write($picurl2,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl2); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}
		
				if(!empty($photoUrls[3])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[3];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl3 = $path.random(30) .".jpg";
				file_write($picurl3,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl3); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[4])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[4];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl4 = $path.random(30) .".jpg";
				file_write($picurl4,$pic_data['content']);	
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl4); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}					
				}

				if(!empty($photoUrls[5])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[5];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl5 = $path.random(30) .".jpg";
				file_write($picurl5,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl5); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[6])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[6];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl6 = $path.random(30) .".jpg";
				file_write($picurl6,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl6); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[7])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[7];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl7 = $path.random(30) .".jpg";
				file_write($picurl7,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl7); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[8])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[8];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl8 = $path.random(30) .".jpg";
				file_write($picurl8,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl8); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}
				
		 $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid']));
		 	
		
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			
			if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求,请刷新页面！' 
		               ) ) );
					   
		    }else{
					 				
				$schoolid = $_GPC['schoolid'];
						
				$weid = $_GPC['weid'];
			
				$content = $_GPC['content'];
			
				$uid = $_GPC['uid'];
				
				$sid = $_GPC['sid'];
			
				$bj_id = $_GPC['bj_id'];
				
				$isfmpic = pdo_fetch("SELECT * FROM " . tablename($this->table_media) . " WHERE :weid = weid And :schoolid = schoolid And :sid = sid And :type = type And :bj_id1 = bj_id1 ORDER BY id ASC LIMIT 0,1 ", array(
						 ':weid' => $weid,
						 ':schoolid' => $schoolid,
						 ':sid' => $sid,
						 ':bj_id1' => $bj_id,
						 ':type' => 1
						 ));
				 
				if (!empty($isfmpic['fmpicurl'])){
					if(!empty($photoUrls[0])) {
					   $data = array(
						'weid' =>  $weid,
						'schoolid' => $schoolid,
						'uid' => $uid,
						'sid' => $sid,
						'picurl' => $picurl0,
						'bj_id1' => $bj_id,
						'order'=>1,
						'createtime' => time(),
						'type'=>1,
					   );
					   pdo_insert($this->table_media, $data);
					}				
				}else{
					if(!empty($photoUrls[0])) {
					   $data = array(
						'weid' =>  $weid,
						'schoolid' => $schoolid,
						'uid' => $uid,
						'sid' => $sid,
						'picurl' => $picurl0,
						'fmpicurl' => $picurl0,
						'bj_id1' => $bj_id,
						'order'=>1,
						'createtime' => time(),
						'type'=>1,
						'isfm'=>1
					   );
					   pdo_insert($this->table_media, $data);
					}					
				}							

				if(!empty($photoUrls[1])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl1,
					'bj_id1' => $bj_id,
					'order'=>2,
					'createtime' => time(),
					'type'=>1,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[2])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl2,	
					'bj_id1' => $bj_id,
					'order'=>3,
					'createtime' => time(),
					'type'=>1,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[3])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl3,	
					'bj_id1' => $bj_id,
					'order'=>4,
					'createtime' => time(),
					'type'=>1,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[4])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl4,	
					'bj_id1' => $bj_id,
					'order'=>5,
					'createtime' => time(),
					'type'=>1,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[5])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl5,	
					'bj_id1' => $bj_id,
					'order'=>6,
					'createtime' => time(),
					'type'=>1,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[6])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl6,	
					'bj_id1' => $bj_id,
					'order'=>7,
					'createtime' => time(),
					'type'=>1,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[7])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl7,	
					'bj_id1' => $bj_id,
					'order'=>8,
					'createtime' => time(),
					'type'=>1,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[8])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl8,	
					'bj_id1' => $bj_id,
					'order'=>9,
					'createtime' => time(),
					'type'=>1,
			       );
                   pdo_insert($this->table_media, $data);				   
				}	
	
		        $data ['result'] = true;
			
			    $data ['msg'] = '发布成功，请勿重复发布！';		
				
			}
          die ( json_encode ( $data ) ); 
		}
    }
	if ($operation == 'xcfb') {
		
		 load()->func('communication');
		 load()->classs('weixin.account');
		 load()->func('file');
         $accObj= WeixinAccount::create($_W['account']['acid']);
         $access_token = $accObj->fetch_token();
	     $token2 =  $access_token;
		 $photoUrls = explode ( ',', $_GPC ['photoUrls'] );
		 $bjids = explode ( ',', $_GPC ['bj_id'] );
		 $data = explode ( '|', $_GPC ['json'] );
		 $school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id = :id", array(':weid' => $_GPC ['weid'], ':id' => $_GPC ['schoolid']));
				if(!empty($photoUrls[0])) {		 
					$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[0];
					$pic_data = ihttp_request($url);
					$path = "images/";
					$picurl0 = $path.random(30) .".jpg";
					file_write($picurl0,$pic_data['content']);			
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl0); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}
		
				if(!empty($photoUrls[1])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[1];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl1 = $path.random(30) .".jpg";
				file_write($picurl1,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl1); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[2])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[2];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl2 = $path.random(30) .".jpg";
				file_write($picurl2,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl2); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}
		
				if(!empty($photoUrls[3])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[3];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl3 = $path.random(30) .".jpg";
				file_write($picurl3,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl3); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[4])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[4];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl4 = $path.random(30) .".jpg";
				file_write($picurl4,$pic_data['content']);	
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl4); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}					
				}

				if(!empty($photoUrls[5])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[5];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl5 = $path.random(30) .".jpg";
				file_write($picurl5,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl5); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
				}

				if(!empty($photoUrls[6])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[6];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl6 = $path.random(30) .".jpg";
				file_write($picurl6,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl6); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[7])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[7];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl7 = $path.random(30) .".jpg";
				file_write($picurl7,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl7); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}

				if(!empty($photoUrls[8])) {		 
				$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls[8];
				$pic_data = ihttp_request($url);
				$path = "images/";
				$picurl8 = $path.random(30) .".jpg";
				file_write($picurl8,$pic_data['content']);
						if (!empty($_W['setting']['remote']['type'])) { // 
							$remotestatus = file_remote_upload($picurl8); //
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}				
				}
				
		 $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid']));
		 	
		
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			
			if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求,请刷新页面！' 
		               ) ) );
					   
		    }else{
					 				
				$schoolid = $_GPC['schoolid'];
						
				$weid = $_GPC['weid'];
			
				$content = $_GPC['content'];
			
				$uid = $_GPC['uid'];
				
				$sid = $_GPC['sid'];
			
				$bj_id1 = $bjids[0];
				
				$bj_id2 = $bjids[1];
				
				$bj_id3 = $bjids[2];
								 
				
				if(!empty($photoUrls[0])) {
				   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl0,
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>1,
					'createtime' => time(),
					'type'=>2,
				   );
				   pdo_insert($this->table_media, $data);
				}				
							
				if(!empty($photoUrls[1])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl1,
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>2,
					'createtime' => time(),
					'type'=>2,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[2])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl2,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>3,
					'createtime' => time(),
					'type'=>2,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[3])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl3,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>4,
					'createtime' => time(),
					'type'=>2,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[4])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl4,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>5,
					'createtime' => time(),
					'type'=>2,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[5])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl5,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>6,
					'createtime' => time(),
					'type'=>2,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[6])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl6,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>7,
					'createtime' => time(),
					'type'=>2,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[7])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl7,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>8,
					'createtime' => time(),
					'type'=>2,
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[8])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'sid' => $sid,
					'picurl' => $picurl8,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>9,
					'createtime' => time(),
					'type'=>2,
			       );
                   pdo_insert($this->table_media, $data);				   
				}	
	
		        $data ['result'] = true;
			
			    $data ['msg'] = '发布成功，请勿重复发布！';		
				
			}
          die ( json_encode ( $data ) ); 
		}
    }	
	if ($operation == 'dellimg') {
		$dataid = explode ( ',', $_GPC ['fileids'] );
			
			if (empty($dataid)){
				   die ( json_encode ( array (
						'result' => false,
						'msg' => '您没有选中任何图片！' 
						   ) ) );
			}else{
				foreach ($dataid as $mid => $row) {
				$isfm = pdo_fetch("SELECT * FROM " . tablename($this->table_media) . " where id=:id ", array(':id' => $row));
					if ($isfm['isfm'] == 1){
						die ( json_encode ( array (
							'result' => false,
							'msg' => '您不能删除封面图片！' 
								) ) );
					}else{
						pdo_delete($this->table_media, array('id' => $row));
						$data ['result'] = true;
						$data ['msg'] = '删除成功！';
					}	
				}

			}
		die ( json_encode ( $data ) ); 
	}
?>