<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
   global $_W, $_GPC;
   $operation = in_array ( $_GPC ['op'], array ('default', 'fabu', 'delbjq', 'huifu', 'dianzan', 'sfabu', 'shbjq') ) ? $_GPC ['op'] : 'default';

    if ($operation == 'default') {
	           die ( json_encode ( array (
			         'result' => false,
			         'msg' => '你是傻逼吗！'
	                ) ) );
    }
	if ($operation == 'delbjq') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
				
            pdo_delete($this->table_bjq, array('id' => $_GPC['id']));			   
            pdo_delete($this->table_media, array('sherid' => $_GPC['id']));
			pdo_delete($this->table_dianzan, array('sherid' => $_GPC['id']));
			
			$data ['result'] = true;
			
			$data ['msg'] = '删除成功';		   
		}
	 die ( json_encode ( $data ) );	
    }
	if ($operation == 'shbjq') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
			$temp = array(
					'isopen' =>  0
				);	
			$setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid']));	
			
			$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE :weid = weid And :id = id", array(':weid' => $_GPC['weid'], ':id' => $_GPC['schoolid']));
			
			$bjq = pdo_fetch("SELECT * FROM " . tablename($this->table_bjq) . " where weid = :weid AND schoolid = :schoolid AND id = :id", array(':weid' => $_GPC ['weid'], ':schoolid' => $_GPC ['schoolid'], ':id' => $_GPC['id']));
            			
			$shername = $bjq['shername'];
						
			$schoolid = $_GPC['schoolid'];
			
			$weid = $_GPC['weid'];
			
			$toopenid = $bjq['openid'];
			
            pdo_update($this->table_bjq, $temp, array('id' => $_GPC['id']));			
			
			$data ['result'] = true;
			
			$data ['msg'] = '审核通过';

		    if ($setting['istplnotice'] == 1 && $setting['bjqshjg'] && $school['isopen'] == 1) {
				
				   $this->sendMobileBjqshjg($schoolid, $weid, $shername, $toopenid);
			}				
		}
	 die ( json_encode ( $data ) );	
    }	
	if ($operation == 'huifu') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
			
			$weid = $_GPC ['weid'];
			
			$schoolid = $_GPC ['schoolid'];
			
			$uid = $_GPC ['uid'];
			
			$sherid = $_GPC ['sherid'];
			
			$content = $_GPC ['content'];
			
			$shername = $_GPC ['shername'];
			
			$openid = $_GPC ['openid'];
			
			$temp = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'shername' => $shername,
					'sherid' => $sherid,
					'openid' => $openid,
					'content' => $content,	
					'createtime' => time(),
					'type'=>1,
				);
												
			    pdo_insert($this->table_bjq, $temp);			
							
			$data ['result'] = true;
			
			$data ['msg'] = '评论成功';		   
		}
	 die ( json_encode ( $data ) );	
    }
	if ($operation == 'dianzan') {
			$weid = $_GPC ['weid'];
			
			$schoolid = $_GPC ['schoolid'];
			
			$uid = $_GPC ['uid'];
			
			$sherid = $_GPC ['sherid'];
						
			$zname = $_GPC ['zname'];

			$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_dianzan) . " where :schoolid = schoolid And :weid = weid  And :uid = uid And :sherid = sherid", array(
			          ':weid' => $weid,
                      ':schoolid' => $schoolid,
					  ':uid' => $uid,
					  ':sherid' => $sherid
					   ), 'id');			
			
		$data = explode ( '|', $_GPC ['json'] );
		if (!empty($userid['id'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '您已经点过赞了' 
		               ) ) );
		}		
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
									
			$temp = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'zname' => $zname,
					'sherid' => $sherid,
					'createtime' => time(),
				);
												
			    pdo_insert($this->table_dianzan, $temp);			
							
			$data ['result'] = true;
			
			$data ['msg'] = '点赞成功';		   
		}
	 die ( json_encode ( $data ) );	
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
		 $bjids = explode ( ',', $_GPC ['bjids'] );
		 
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
			
				$bj_id1 = $bjids[0];
				
				$bj_id2 = $bjids[1];
				
				$bj_id3 = $bjids[2];
				
				$isopen = $_GPC['isopen'];
				
				$openid = $_GPC['openid'];
							
				$shername = $_GPC['shername'];
				
				$temp = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'shername' => $shername,
					'content' => $content,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'openid'=>$openid,
					'isopen'=>$isopen,
					'createtime' => time(),
					'type'=>0,
				);
												
			    pdo_insert($this->table_bjq, $temp);
			
			    $bjq_id = pdo_insertid();
				
			    $data1 = array(
					'sherid'=>$bjq_id,
			    );				
				
				pdo_update($this->table_bjq, $data1, array ('id' => $bjq_id) );
				
				if(!empty($photoUrls[0])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl0,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>1,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[1])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl1,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>2,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[2])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl2,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>3,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[3])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl3,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>4,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[4])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl4,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>5,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[5])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl5,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>6,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[6])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl6,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>7,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[7])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl7,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>8,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[8])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl8,	
					'bj_id1' => $bj_id1,
					'bj_id2' => $bj_id2,
					'bj_id3' => $bj_id3,
					'order'=>9,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}				
			
			    // if ($setting['istplnotice'] == 1 && $setting['bjtz']) {
				
				   // $this->sendMobileBjtz($notice_id, $schoolid, $weid, $tname, $bj_id);
				
			    // }else{
				  // die ( json_encode ( array (
                  // 'result' => false,
                  // 'msg' => '发送失败，请联系管理员开启模版消息！' 
		               // ) ) );
			    // }
	
		        $data ['result'] = true;
			
			    $data ['msg'] = '发布成功，请勿重复发布！';		
				
			}
          die ( json_encode ( $data ) ); 
		}
    }
	if ($operation == 'sfabu') {
		
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
			
				$bj_id = $_GPC['bj_id'];
								
				$isopen = $_GPC['isopen'];
				
				$openid = $_GPC['openid'];
							
				$shername = $_GPC['shername'];
				
				$temp = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'shername' => $shername,
					'content' => $content,	
					'bj_id1' => $bj_id,
					'openid'=>$openid,
					'isopen'=>$school['isopen'],
					'createtime' => time(),
					'type'=>0,
				);
												
			    pdo_insert($this->table_bjq, $temp);
			
			    $bjq_id = pdo_insertid();
				
			    $data1 = array(
					'sherid'=>$bjq_id,
			    );				
				
				pdo_update($this->table_bjq, $data1, array ('id' => $bjq_id) );
				
				if(!empty($photoUrls[0])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl0,	
					'bj_id1' => $bj_id,
					'order'=>1,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[1])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl1,	
					'bj_id1' => $bj_id,
					'order'=>2,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[2])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl2,	
					'bj_id1' => $bj_id,
					'order'=>3,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[3])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl3,	
					'bj_id1' => $bj_id,
					'order'=>4,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[4])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl4,	
					'bj_id1' => $bj_id,
					'order'=>5,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[5])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl5,	
					'bj_id1' => $bj_id,
					'order'=>6,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[6])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl6,	
					'bj_id1' => $bj_id,
					'order'=>7,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[7])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl7,	
					'bj_id1' => $bj_id,
					'order'=>8,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				if(!empty($photoUrls[8])) {
                   $data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'picurl' => $picurl8,	
					'bj_id1' => $bj_id,
					'order'=>9,
					'sherid'=>$bjq_id,
					'createtime' => time(),
			       );
                   pdo_insert($this->table_media, $data);				   
				}
				
                $school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE :weid = weid And :id = id", array(':weid' => $_GPC['weid'], ':id' => $_GPC['schoolid']));				
			    //向班主任发送通知
				if ($setting['istplnotice'] == 1 && $setting['bjqshtz'] && $school['isopen'] == 1) {
				
				   $this->sendMobileBjqshtz($schoolid, $weid, $shername, $bj_id);
				
			    }
	
		        $data ['result'] = true;
			
			    $data ['msg'] = '发布成功，请勿重复发布！';		
				
			}
          die ( json_encode ( $data ) ); 
		}
    }
	
?>