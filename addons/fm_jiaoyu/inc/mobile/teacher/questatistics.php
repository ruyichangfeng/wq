<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid'];
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$leaveid = $_GPC['leaveid'];
  		mload()->model('que');
  		$XuanXIangCount;
  		$tempALL = pdo_fetchall("SELECT distinct tmid FROM " . tablename('wx_school_answers') . " where zyid= :zyid AND  schoolid = :schoolid  AND weid = :weid  ORDER BY tmid ", array( ':zyid' =>$leaveid,':schoolid' =>$schoolid, ':weid' => $weid ));
  		foreach($tempALL as $value )
	{
		//var_dump($value);
		$tempA = pdo_fetchall("SELECT distinct sid FROM " . tablename('wx_school_answers') . " where zyid= :zyid AND tmid = :tmid  AND schoolid = :schoolid  AND weid = :weid  ", array( ':zyid' =>$leaveid, ':tmid' => $value['tmid'],':schoolid' =>$schoolid, ':weid' => $weid ));
		$XuanXIangCount[$value['tmid']] = count($tempA);
		
};
 //var_dump($XuanXIangCount);
       $ZYNEIRONG = GetZyContent($leaveid,$schoolid,$weid);
       $countOfTm = count($ZYNEIRONG);
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');


$listAll = pdo_fetchall("SELECT * FROM ".tablename($this->table_record)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And noticeid = '{$leaveid}' ORDER BY id DESC ");
$listNO = pdo_fetchall("SELECT * FROM ".tablename($this->table_record)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And noticeid = '{$leaveid}' And readtime = 0 ORDER BY id DESC ");
	$listYES = pdo_fetchall("SELECT * FROM ".tablename($this->table_record)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And noticeid = '{$leaveid}' And readtime > 5000 ORDER BY readtime DESC ");
	$WeiDu = count($listNO);
	$YiDu = count($listYES);
	$Zong = count($listAll);
		
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));
		$leave = pdo_fetch("SELECT * FROM " . tablename($this->table_notice) . " where :id = id", array(':id' => $leaveid));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		$nowbj =  pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid =:sid ", array(':sid' => $leave['bj_id']));
		$nowkm =  pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid =:sid ", array(':sid' => $leave['km_id']));		
        if(!empty($userid['id'])){
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $leave['sid']));
			$member = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid = :uid", array(':uniacid' => $weid, ':uid'=> $leave['uid']));
			$isbzr = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['tid']));
			$picarr = iunserializer($leave['picarr']);	
			include $this->template(''.$school['style3'].'/questatistics');
        }else{
			include $this->template('bangding');
        } 
        
?>