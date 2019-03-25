<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid'];
        mload()->model('que');
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$leaveid = $_GPC['leaveid'];
		$contentsAll= $_GPC['content'];
 	//	$xxid = $_GPC['id'];
 		$tmid = $_GPC['tmid'];
 		$XuanXiangArr = GetZyContentPlusTm($leaveid,$tmid,$schoolid,$weid);

	$listAll = pdo_fetchall("SELECT * FROM ".tablename($this->table_record)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And noticeid = '{$leaveid}' ORDER BY id DESC ");
	$listNO = pdo_fetchall("SELECT * FROM ".tablename($this->table_record)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And noticeid = '{$leaveid}' And readtime = 0 ORDER BY id DESC ");
	$listYES = pdo_fetchall("SELECT * FROM ".tablename($this->table_record)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And noticeid = '{$leaveid}' And readtime > 5000 ORDER BY readtime DESC ");
	$WeiDu = count($listNO);
	$YiDu = count($listYES);
	$Zong = count($listAll);
	$count_zong = count( pdo_fetchall("SELECT distinct userid FROM ".tablename($this->table_answers)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And zyid = '{$leaveid}' And tmid ='{$tmid}'  ORDER BY id DESC "));
	$contents = array();
	$countuser = array();
 	$TongJi_userid = array();
	foreach($XuanXiangArr['content'] as $key=>$value)
	{
 		$contents[$key] =$value['title'];
 		$xxid = $key ;
	$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
      $TongJi_userid[$key] = pdo_fetchall("SELECT userid,sid,tid FROM ".tablename($this->table_answers)."where schoolid = :schoolid AND weid = :weid AND zyid = :zyid AND tmid = :tmid AND MyAnswer = :xxid ",array(':schoolid' =>$schoolid,':weid' =>$weid,':zyid' =>$leaveid,':tmid'=>$tmid, ':xxid' =>$xxid ));
  
    // var_dump( $TongJi_userid);
	    foreach($TongJi_userid[$key] as $keys=>$values)
	    {
		  //  echo  $values['tid'];
			 if($values['sid'] != 0)
	   		{
		   		//echo "yes";
				$temp =  pdo_fetch("SELECT userinfo,pard,uid FROM ".tablename($this->table_user)."where weid = :weid AND schoolid = :schoolid AND id=:userid",array(':weid'=> $weid,':schoolid' => $schoolid, ':userid' => $values['userid'] ));
			    $temp_de = iunserializer($temp['userinfo']);
			    $TongJi_userid[$key][$keys]['name'] = $temp_de['name'] ;
			    $TongJi_userid[$key][$keys]['mobile'] = $temp_de['mobile'] ;
			    $TongJi_userid[$key][$keys]['pard'] = $temp['pard'] ;
			   
			    $s_temp = pdo_fetch("SELECT s_name,icon FROM " . tablename ( $this->table_students ) . " where schoolid = :schoolid AND id =:id ", array(':schoolid' => $schoolid, ':id' => $values['sid']));
		        $TongJi_userid[$key][$keys]['s_name'] = $s_temp['s_name'] ;
			    $TongJi_userid[$key][$keys]['icon'] = $s_temp['icon'] ;
		    } 
		    else if($values['tid'] != 0)
	    	{
		    	//echo "no";
			   	$temp =  pdo_fetch("SELECT userinfo,pard,uid FROM ".tablename($this->table_user)."where weid = :weid AND schoolid = :schoolid AND id=:userid",array(':weid'=> $weid,':schoolid' => $schoolid, ':userid' => $values['userid'] ));
			  
				$t_temp = pdo_fetch("SELECT * FROM " . tablename ( $this->table_teachers ) . " where schoolid = :schoolid AND id =:id ", array(':schoolid' => $schoolid, ':id' => $values['tid']));
		        $TongJi_userid[$key][$keys]['s_name'] = $t_temp['tname'] ;
			    $TongJi_userid[$key][$keys]['icon'] = $t_temp['thumb'] ;
		      	$TongJi_userid[$key][$keys]['is_t'] = 1 ;
		       	$TongJi_userid[$key][$keys]['name'] = $t_temp['name'] ;
			    $TongJi_userid[$key][$keys]['mobile'] = $t_temp['mobile'] ;	    
		    }
		    $member = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $weid, ':uid' => $temp['uid']));
			$TongJi_userid[$key][$keys]['avatar'] = $member['avatar'] ;
			   // var_dump($s_temp);
	 	};
		$countuser[$key] = count($TongJi_userid[$key]);
	};
	$tmcount = count($TongJi_userid);	
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
        if(!empty($userid['id'])){
			include $this->template(''.$school['style3'].'/questionnaire');
        }else{
			include $this->template('bangding');
        } 
        
?>