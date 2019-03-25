<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
   global $_W, $_GPC;
   $operation = in_array ( $_GPC ['op'], array ('default', 'fabu', 'getSignature', 'delbjq', 'huifu', 'dianzan', 'sfabu', 'shbjq', 'delmyhf','donwimg','donwvioce','setstar') ) ? $_GPC ['op'] : 'default';

    if ($operation == 'default') {
	           die ( json_encode ( array (
			         'result' => false,
			         'msg' => '你是傻逼吗！'
	                ) ) );
    }
	if ($operation == 'setstar') {
		if(empty($_GPC['weid']) || empty($_GPC['schoolid'])){
		   die ( json_encode ( array (
				 'result' => false,
				 'msg' => '非法访问！'
				) ) );			
		}
		$bj_id 	  = intval($_GPC['bj_id']);
		$mub 	  = intval($_GPC['mub']);
		$sid 	  = intval($_GPC['sid']);
		$school = pdo_fetch("SELECT spic FROM " . tablename($this->table_index) . " WHERE :id = id", array(':id' => trim($_GPC['schoolid'])));
		$student = pdo_fetch("SELECT icon,s_name FROM " . tablename($this->table_students) . " WHERE :id = id", array(':id' => $sid));
		$thisbj  = pdo_fetch("SELECT is_bjzx,star FROM " . tablename($this->table_classify) . " WHERE :sid = sid", array(':sid' => $bj_id));
		if($thisbj['is_bjzx'] == 1){
			$star = unserialize($thisbj['star']);
			$temp = array(
				'icon1' => $star['icon1'],
				'icon2' => $star['icon2'],
				'icon3' => $star['icon3'],
				'icon4' => $star['icon4'],
				'name1' => $star['name1'],
				'name2' => $star['name2'],
				'name3' => $star['name3'],
				'name4' => $star['name4'],
			);
			if($mub == 1){
				$temp['icon1'] = !empty($student['icon']) ? tomedia($student['icon']) : tomedia($school['spic']);
				$temp['name1'] = $student['s_name'];
			}
			if($mub == 2){
				$temp['icon2'] = !empty($student['icon']) ? tomedia($student['icon']) : tomedia($school['spic']);
				$temp['name2'] = $student['s_name'];
			}
			if($mub == 3){
				$temp['icon3'] = !empty($student['icon']) ? tomedia($student['icon']) : tomedia($school['spic']);
				$temp['name3'] = $student['s_name'];
			}
			if($mub == 4){
				$temp['icon4'] = !empty($student['icon']) ? tomedia($student['icon']) : tomedia($school['spic']);
				$temp['name4'] = $student['s_name'];
			}			
			$datas['star'] = iserializer($temp);
			pdo_update($this->table_classify, $datas, array('sid' => $bj_id));
			$data ['s_name'] = $student['s_name'];
			$data ['icon'] = !empty($student['icon']) ? tomedia($student['icon']) : tomedia($school['spic']);
			$data ['result'] = true;
			$data ['msg'] = '设置成功';
		}else{
			$data ['result'] = false;
			$data ['msg'] = '本班未开启班级之星功能';
		}
		die ( json_encode ( $data ) );			
	}
	if ($operation == 'getSignature') {
		$school = pdo_fetch("SELECT txid,txms FROM " . tablename($this->table_index) . " WHERE :id = id", array(':id' => trim($_GPC['schoolid'])));
		$secret_id = $school['txid'];
		$secret_key = $school['txms'];
		// 确定签名的当前时间和失效时间
		$current = time();
		$expired = $current + 86400;  // 签名有效期：1天

		$args = $_GPC['args'];
		//$argss = str_replace('.mp3','=',$args);
		// 向参数列表填入参数
		$arg_list = array(
			"secretId" => $secret_id,
			"currentTimeStamp" => $current,
			"expireTime" => $expired,
			"random" => rand());

		// 计算签名
		$orignal = http_build_query($arg_list);
		$signature = base64_encode(hash_hmac('SHA1', $orignal, $secret_key, true).$orignal."&".(iconv("UTF-8", "gbk",  urldecode($args))));

		$data['getSignature'] = base64_encode(iconv("UTF-8", "gbk",  urldecode($args)));
		die ( json_encode ( $data ) );		
	}
	if ($operation == 'donwimg') {
		//上传图片 (lee 0722)
		$data = explode ( '|', $_GPC ['json'] );
		 load()->func('communication');
		 load()->classs('weixin.account');
		 load()->func('file');
         $accObj= WeixinAccount::create($_W['account']['acid']);
         $access_token = $accObj->fetch_token();
	     $token2 =  $access_token;
		 $photoUrls = trim($_GPC ['serverId']);
		if(!empty($photoUrls)) {
			$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls;
			$pic_data = ihttp_request($url);
			$path = "images/bjq/img/";
			$picurl = $path.random(30) .".jpg";
			file_write($picurl,$pic_data['content']);
				if (!empty($_W['setting']['remote']['type'])) { // 
					$remotestatus = file_remote_upload($picurl); //
					if (is_error($remotestatus)) {
						message('远程附件上传失败，请检查配置并重新上传');
					}
				}
		}
		$data ['data'] = $picurl;
		die ( json_encode ( $data ) );	
    }
	if ($operation == 'donwvioce') {
		 load()->func('communication');
		 load()->classs('weixin.account');
		 load()->func('file');
         $accObj= WeixinAccount::create($_W['account']['acid']);
         $access_token = $accObj->fetch_token();
	     $token2 =  $access_token;
		 $photoUrls = trim($_GPC ['serverId']);		 
		if($_GPC ['serverId']) {
			$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrls;
			$pic_data = ihttp_request($url);
			$path = "images/bjq/vioce/";
			$amr = $path.random(30) .".amr";
			file_write($amr,$pic_data['content']);
			$files = IA_ROOT . "/attachment/".$amr;
			if(file_exists(IA_ROOT . "/attachment/".$amr)){
				$versionfile = IA_ROOT . '/addons/fm_jiaoyu/inc/func/auth2.php';
				require $versionfile;
				$test = upload_file_to_cdn($files,FM_JIAOYU_HOST);
				$respoed = json_decode($test,true);
				if($respoed['result']==1){
					$vioce = file_get_contents($respoed['mp3']);
					$mp3 = $path.$respoed['name'].".mp3";
					file_write($mp3,$vioce);
					if(file_exists(IA_ROOT . "/attachment/".$mp3)){
						if (!empty($_W['setting']['remote']['type'])) {
							$remotestatus = file_remote_upload($mp3);
							if (is_error($remotestatus)) {
								message('远程附件上传失败，请检查配置并重新上传');
							}
						}
						file_delete($amr);
					}
				}
			}			
		}
		$data ['data'] = $mp3;
		die ( json_encode ( $data ) );			
    }	
	if ($operation == 'delmyhf') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] ) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
				
            pdo_delete($this->table_bjq, array('id' => $_GPC['id']));			   
			
			$data ['result'] = true;
			
			$data ['msg'] = '删除成功';		   
		}
	 die ( json_encode ( $data ) );	
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
			
			$bjq = pdo_fetch("SELECT shername,openid,userid FROM " . tablename($this->table_bjq) . " where weid = :weid AND schoolid = :schoolid AND id = :id", array(':weid' => $_GPC ['weid'], ':schoolid' => $_GPC ['schoolid'], ':id' => $_GPC['id']));
            			
			$shername = $bjq['shername'];
						
			$schoolid = $_GPC['schoolid'];
			
			$weid = $_GPC['weid'];
			
			$toopenid = $bjq['openid'];
			
            pdo_update($this->table_bjq, $temp, array('id' => $_GPC['id']));			
			
			$data ['result'] = true;
			
			$data ['msg'] = '审核通过';
				
			$this->sendMobileBjqshjg($schoolid, $weid, $shername, $toopenid, $bjq['userid']);
							
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
			
			$plid = $_GPC ['plid'];
			
			$hftoname = $_GPC ['hftoname'];
			
			$openid = $_GPC ['openid'];
			
			$temp = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'shername' => $shername,
					'sherid' => $sherid,
					'hftoname' => $hftoname,
					'plid' => $plid,					
					'openid' => $openid,
					'content' => $content,	
					'createtime' => time(),
					'type'=>1,
				);
												
			    pdo_insert($this->table_bjq, $temp);			
				$thisid = pdo_insertid();			
			$data ['result'] = true;
			
			$data ['id'] = $thisid;
			
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
					   ));			
			
		$data = explode ( '|', $_GPC ['json'] );
		if (!empty($userid['id'])) {
												
			pdo_delete($this->table_dianzan, array('sherid' => $sherid,'uid' => $uid,'schoolid' => $schoolid));	
							
			$data ['result'] = true;
			
			$data ['msg'] = '取消赞成功';
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
		 $data = explode ( '|', $_GPC ['json'] );
		
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' ,
					'status' => 2,
                    'info' => '非法请求！' 
		               ) ) );
	    }else{
			
			if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求,请刷新页面！' ,
					'status' => 2,
                    'info' => '非法请求！' 
		               ) ) );	   
		    }else{
					 				
				$schoolid = trim($_GPC['schoolid']);
						
				$weid = trim($_GPC['weid']);
			
				$content = trim($_GPC['content']);
			
				$uid = trim($_GPC['uid']);
				
				$userid = trim($_GPC['userid']);
			
				$bj_id1 = trim($_GPC ['bj_id']);
								
				$isopen = trim($_GPC['isopen']);
				
				$openid = trim($_GPC['openid']);
				
				$audios = $_GPC ['audioServerid'];
				
				$audio = $audios[0];
				
				$audiotimes = $_GPC['audioTime'];
				
				$audiotime = $audiotimes[0];
				
				$link = trim($_GPC['linkAddress']);
				
				$linkdesc = trim($_GPC['linkDesc']);
							
				$shername = trim($_GPC['shername']);
				
				$is_private = trim($_GPC['is_private']);
				
				$msgtype = 1;
				
				if(!empty($audio)){
					$msgtype = 2;//录音
				}
				$video = '';
				$school = pdo_fetch("SELECT isopen,txid,txms FROM " . tablename($this->table_index) . " WHERE :weid = weid And :id = id", array(':weid' => $_GPC['weid'], ':id' => $_GPC['schoolid']));
				if(!empty($_GPC['videoMediaId'])){
					$msgtype = 3;//视频
					$HttpUrl="vod.api.qcloud.com";
					$HttpMethod="GET"; 
					$isHttps =true;
					$secretKey=$school['txms'];
					$COMMON_PARAMS = array(
							'Nonce'=> rand(),
							'Timestamp'=>time(NULL),
							'Action'=>'DescribeVodPlayUrls',
							'SecretId'=> $school['txid'],
							'Region' =>'',
					);
					$COMMON_PARAMS1 = array(
							'Nonce'=> rand(),
							'Timestamp'=>time(NULL),
							'Action'=>'DeleteVodFile',
							'SecretId'=> $school['txid'],
							'Region' =>'',
					);
					$PRIVATE_PARAMS = array(
							'fileId'=> trim($_GPC['videoMediaId']),
					);
					$getfile = CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps);
					
					if($getfile['code'] == 0){
						$videoimg = $getimg['fileSet'][0]['imageUrl'];
						$video = $getfile['playSet'][0]['url'];	
						$videos = file_get_contents($video);
						$path = "images/bjq/video/";
						$video = $path.random(30).".mp4";
						file_write($video,$videos);
						if(file_exists(IA_ROOT . "/attachment/".$video)){
							if (!empty($_W['setting']['remote']['type'])) {
								$remotestatus = file_remote_upload($video);
								if (is_error($remotestatus)) {
									message('远程附件上传失败，请检查配置并重新上传');
								}
							}
							$PRIVATE_PARAMS1 = array(
									'fileId'=> trim($_GPC['videoMediaId']),
									'priority'=> 0,
							);
							CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS1,$secretKey, $PRIVATE_PARAMS1, $isHttps);
						}						
					}else{
						die ( json_encode ( array (
							'status' => 2,
							'info' => '上传失败！' 
						   ) ) );
					}
				}

				if(!empty($_GPC['linkAddress'])){
					$msgtype = 4;//外链
				}				
				if($audio){
					$versionfile = IA_ROOT . '/addons/fm_jiaoyu/inc/func/auth2.php';
					require $versionfile;
					$mp3name = str_replace('images/bjq/vioce/','',$audio);
					$mp3 = str_replace('.mp3','',$mp3name);
					delvioce($mp3,FM_JIAOYU_HOST);
				}
				$temp = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'shername' => $shername,
					'audio' => $audio,
					'audiotime' => $audiotime,
					'content' => $content,
					'userid' => $userid,
					'videoimg' => $videoimg,
					'video' => $video,
					'link' => $link,
					'linkdesc' => $linkdesc,
					'bj_id1' => $bj_id1,
					'openid'=>$openid,
					'isopen'=>0,
					'is_private'=>$is_private,
					'createtime' => time(),
					'msgtype'=>$msgtype,
					'type'=>0,
				);
												
			    pdo_insert($this->table_bjq, $temp);
			
			    $bjq_id = pdo_insertid();
				
			    $data1 = array(
					'sherid'=>$bjq_id,
			    );
				
				pdo_update($this->table_bjq, $data1, array ('id' => $bjq_id) );
				
				if($_GPC ['photoUrls']){
					 $school = pdo_fetch("SELECT bjqstyle FROM " . tablename($this->table_index) . " where id = :id", array(':id' => $_GPC['schoolid']));
					 if($school['bjqstyle'] == 'old'){
						 $photoUrls = explode ( ',', $_GPC ['photoUrls'] );
							$order = 1;
							foreach($photoUrls as $key => $v){
								if(!empty($v)) {
									$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$v;
									$pic_data = ihttp_request($url);
									$path = "images/bjq/img/";
									$picurl = $path.random(30) .".jpg";
									file_write($picurl,$pic_data['content']);
										if (!empty($_W['setting']['remote']['type'])) { //
											$remotestatus = file_remote_upload($picurl); //
											if (is_error($remotestatus)) {
												message('远程附件上传失败，请检查配置并重新上传');
											}
										}
								    $data = array(
										'weid' =>  $weid,
										'schoolid' => $schoolid,
										'uid' => $uid,
										'picurl' => $picurl,	
										'bj_id1' => $bj_id1,
										'order'=>$order,
										'sherid'=>$bjq_id,
										'createtime' => time(),
								    );
									pdo_insert($this->table_media, $data);
								}
								$order++;
							}						 
					 }else{
						$photoUrls = $_GPC ['photoUrls']; 
					 }
					 $order = 1;
					 foreach($photoUrls as $key => $v){
						if(!empty($v)) {
						   $data = array(
							'weid' =>  $weid,
							'schoolid' => $schoolid,
							'uid' => $uid,
							'picurl' => $v,	
							'bj_id1' => $bj_id1,
							'order'=>$order,
							'sherid'=>$bjq_id,
							'createtime' => time(),
						   );
						   pdo_insert($this->table_media, $data);							
						}
						$order++;
					 }
				}

		        $data ['status'] = 1;
				
			    $data ['info'] = '发布成功，请勿重复发布！';	
				
		        $data ['result'] = true;

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
		 //$photoUrls = explode ( ',', $_GPC ['photoUrls'] );
		 $data = explode ( '|', $_GPC ['json'] );
		
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' ,
					'status' => 2,
                    'info' => '非法请求！' 
		               ) ) );
	    }else{
			
			if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求,请刷新页面！' ,
					'status' => 2,
                    'info' => '非法请求！' 
		               ) ) );	   
		    }else{
					 				
				$schoolid = trim($_GPC['schoolid']);
						
				$weid = trim($_GPC['weid']);
			
				$content = trim($_GPC['content']);
			
				$uid = trim($_GPC['uid']);
				
				$userid = trim($_GPC['userid']);
				
				$bj_id1 = trim($_GPC ['bj_id']);
								
				$isopen = trim($_GPC['isopen']);
				
				$openid = trim($_GPC['openid']);
				
				$audios = $_GPC ['audioServerid'];
				
				$audio = $audios[0];
				
				$audiotimes = $_GPC['audioTime'];
				
				$audiotime = $audiotimes[0];
				
				$link = trim($_GPC['linkAddress']);
				
				$linkdesc = trim($_GPC['linkDesc']);
							
				$shername = trim($_GPC['shername']);
				
				$is_private = trim($_GPC['is_private']);
				
				$msgtype = 1;
				
				if(!empty($audio)){
					$msgtype = 2;//录音
				}
				$video = '';
				$school = pdo_fetch("SELECT isopen,txid,txms FROM " . tablename($this->table_index) . " WHERE :weid = weid And :id = id", array(':weid' => $_GPC['weid'], ':id' => $_GPC['schoolid']));
				if(!empty($_GPC['videoMediaId'])){
					$msgtype = 3;//视频
					$HttpUrl="vod.api.qcloud.com";
					$HttpMethod="GET"; 
					$isHttps =true;
					$secretKey=$school['txms'];
					$COMMON_PARAMS = array(
							'Nonce'=> rand(),
							'Timestamp'=>time(NULL),
							'Action'=>'DescribeVodPlayUrls',
							'SecretId'=> $school['txid'],
							'Region' =>'',
					);
					$COMMON_PARAMS1 = array(
							'Nonce'=> rand(),
							'Timestamp'=>time(NULL),
							'Action'=>'DeleteVodFile',
							'SecretId'=> $school['txid'],
							'Region' =>'',
					);
					$PRIVATE_PARAMS = array(
							'fileId'=> trim($_GPC['videoMediaId']),
					);
					$getfile = CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS,$secretKey, $PRIVATE_PARAMS, $isHttps);

					if($getfile['code'] == 0){
						$videoimg = $getimg['fileSet'][0]['imageUrl'];
						$video = $getfile['playSet'][0]['url'];	
						$videos = file_get_contents($video);
						$path = "images/bjq/video/";
						$video = $path.random(30).".mp4";
						file_write($video,$videos);
						if(file_exists(IA_ROOT . "/attachment/".$video)){
							if (!empty($_W['setting']['remote']['type'])) {
								$remotestatus = file_remote_upload($video);
								if (is_error($remotestatus)) {
									message('远程附件上传失败，请检查配置并重新上传');
								}
							}
							$PRIVATE_PARAMS1 = array(
									'fileId'=> trim($_GPC['videoMediaId']),
									'priority'=> 0,
							);
							CreateRequest($HttpUrl,$HttpMethod,$COMMON_PARAMS1,$secretKey, $PRIVATE_PARAMS1, $isHttps);							
						}						
					}else{
						die ( json_encode ( array (
							'status' => 2,
							'info' => '上传失败！' 
						   ) ) );
					}
				}

				if(!empty($_GPC['linkAddress'])){
					$msgtype = 4;//外链
				}
				if($audio && $_GPC['photoUrls']){
					$msgtype = 5;//外链
				}				
				if($_GPC['videoMediaId'] && $_GPC['photoUrls']){
					$msgtype = 6;//外链
				}				
				if($audio){
					$versionfile = IA_ROOT . '/addons/fm_jiaoyu/inc/func/auth2.php';
					require $versionfile;
					$mp3name = str_replace('images/bjq/vioce/','',$audio);
					$mp3 = str_replace('.mp3','',$mp3name);
					delvioce($mp3,FM_JIAOYU_HOST);
				}
				$temp = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'uid' => $uid,
					'userid' => $userid,
					'shername' => $shername,
					'audio' => $audio,
					'audiotime' => $audiotime,
					'content' => $content,
					'videoimg' => $videoimg,
					'video' => $video,
					'link' => $link,
					'linkdesc' => $linkdesc,
					'bj_id1' => $bj_id1,
					'openid'=>$openid,
					'isopen'=>$isopen,
					'is_private'=>$is_private,
					'createtime' => time(),
					'msgtype'=>$msgtype,
					'type'=>0,
				);
												
			    pdo_insert($this->table_bjq, $temp);
			
			    $bjq_id = pdo_insertid();
				
			    $data1 = array(
					'sherid'=>$bjq_id,
			    );
				
				pdo_update($this->table_bjq, $data1, array ('id' => $bjq_id) );
				
				if($_GPC ['photoUrls']){
					 $school = pdo_fetch("SELECT bjqstyle FROM " . tablename($this->table_index) . " where id = :id", array(':id' => $_GPC['schoolid']));
					 if($school['bjqstyle'] == 'old'){
						 $photoUrls = explode ( ',', $_GPC ['photoUrls'] );
							$order = 1;
							foreach($photoUrls as $key => $v){
								if(!empty($v)) {
									$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$v;
									$pic_data = ihttp_request($url);
									$path = "images/bjq/img/";
									$picurl = $path.random(30) .".jpg";
									file_write($picurl,$pic_data['content']);
										if (!empty($_W['setting']['remote']['type'])) { //
											$remotestatus = file_remote_upload($picurl); //
											if (is_error($remotestatus)) {
												message('远程附件上传失败，请检查配置并重新上传');
											}
										}
								    $data = array(
										'weid' =>  $weid,
										'schoolid' => $schoolid,
										'uid' => $uid,
										'picurl' => $picurl,	
										'bj_id1' => $bj_id1,
										'order'=>$order,
										'sherid'=>$bjq_id,
										'createtime' => time(),
								    );
									pdo_insert($this->table_media, $data);
								}
								$order++;
							}
					 }else{
						$photoUrls = $_GPC ['photoUrls']; 
						 $order = 1;
						 foreach($photoUrls as $key => $v){
							if(!empty($v)) {
							   $data = array(
								'weid' =>  $weid,
								'schoolid' => $schoolid,
								'uid' => $uid,
								'picurl' => $v,	
								'bj_id1' => $bj_id1,
								'order'=>$order,
								'sherid'=>$bjq_id,
								'createtime' => time(),
							   );
							   pdo_insert($this->table_media, $data);							
							}
							$order++;
						 }						
					 }
				}
                				
			    //向班主任发送通知
				if ($school['isopen'] == 1) {
				
				   $this->sendMobileBjqshtz($schoolid, $weid, $shername, $bj_id1);
				
			    }
		        $data ['status'] = 1;
				
			    $data ['info'] = '发布成功，请勿重复发布！';	
				
		        $data ['result'] = true;

			}
          die ( json_encode ( $data ) ); 
		}
    }	

	
?>