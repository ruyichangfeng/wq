<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
		$weid = $_W['uniacid'];
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];		
		if ($_GPC['user']){
			$_SESSION['user'] = intval($_GPC['user']);
		}
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));	
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
		
        if(!empty($it)){
			$rest = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->table_order)." WHERE sid = '{$it['sid']}' And status = '1'");
            $card = unserialize($school['cardset']);
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $it['sid']));
            			
			$userinfo = iunserializer($it['userinfo']);
			
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " where :schoolid = schoolid And :weid = weid And :sid = sid ORDER BY createtime DESC", array(
		         ':weid' => $weid,
				 ':schoolid' => $schoolid,
				 ':sid' => $it['sid'],
				 ));
			foreach($list as $key => $row){
				$kc = pdo_fetch("SELECT * FROM ".tablename($this->table_tcourse)." WHERE id = '{$row['kcid']}'");//课程
				$ct = pdo_fetch("SELECT * FROM ".tablename($this->table_cost)." WHERE id = '{$row['costid']}'");//项目
				$ls = pdo_fetch("SELECT * FROM ".tablename($this->table_teachers)." WHERE id = '{$kc['tid']}'");//老师
				$list[$key]['kcname'] = $kc['name'];
				$list[$key]['kcstart'] = $kc['start'];
				$list[$key]['kcend'] = $kc['end'];
				$list[$key]['adrr'] = $kc['adrr'];
				$list[$key]['minge'] = $kc['minge'];
				$list[$key]['yibao'] = $kc['yibao'];				
				$list[$key]['tname'] = $ls['tname'];
				$list[$key]['ticon'] = $ls['thumb'];
				$list[$key]['obname'] = $ct['name'];
				$list[$key]['obicon'] = $ct['icon'];
				$list[$key]['obstart'] = $ct['starttime'];
				$list[$key]['obend'] = $ct['endtime'];
				$list[$key]['obtime'] = $ct['dataline'];
				$list[$key]['is_time'] = $ct['is_time'];
			}	 
		    include $this->template(''.$school['style2'].'/order');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
?>