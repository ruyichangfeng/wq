<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
		//处理选择借用支付返回丢失缓存和weid的情况
		$weid = $_W['uniacid'];
		$openid = $_W['openid'];	
		$schoolid = intval($_GPC['schoolid']);
		$userss = intval($_GPC['id']);

		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $_SESSION['user']));

		$school = pdo_fetch("SELECT title,spic,is_rest,shoucename,is_video,videoname,is_zjh,is_recordmac,style2,userstyle,gonggao FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		
        if(!empty($it)){
			$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id AND schoolid=:schoolid ", array(':weid' => $weid, ':id' => $it['sid'], ':schoolid' => $schoolid));			
            $mybanji = pdo_fetch("SELECT sname,qun FROM " . tablename($this->table_classify) . " WHERE :schoolid = schoolid And :sid = sid ", array(':schoolid' => $schoolid, ':sid' => $students['bj_id']));
		    
			$myfamily =  pdo_fetchall("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And weid = :weid AND sid=:sid ", array(':schoolid' => $schoolid,':weid' => $weid, ':sid' => $it['sid']));
			foreach($myfamily as $key => $row){
				$item = pdo_fetch("SELECT avatar,nickname FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $row['uid'], ':uniacid' => $weid));
				$myfamily[$key]['name'] = '';
				$myfamily[$key]['mobile'] = '';				
				if($row['userinfo']){
					$thisuser = iunserializer($row['userinfo']);
					$myfamily[$key]['name'] = $thisuser['name'];
					$myfamily[$key]['mobile'] = $thisuser['mobile'];
				}
				$myfamily[$key]['guanxi'] = getpard($row['pard']);
				$myfamily[$key]['icon'] = $item['avatar'];
				$myfamily[$key]['nickname'] = $item['nickname'];
			}			
			
			$userinfo = iunserializer($it['userinfo']);
				
			include $this->template(''.$school['style2'].'/myfamily');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }
