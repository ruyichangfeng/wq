<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $schoolid = intval($_GPC['schoolid']);
        
        $school = pdo_fetch("SELECT title,style1 FROM " . tablename($this->table_index) . " where weid = :weid AND id = :id ", array(':weid' => $weid, ':id' => $schoolid));
	
		if (!empty($_W['setting']['remote']['type'])) { 
			$urls = $_W['attachurl']; 
		} else {
			$urls = $_W['siteroot'].'attachment/';
		}
		$starttime = mktime(0,0,0,date("m"),date("d"),date("Y"));
		$endtime = $starttime + 86399;
		$condition = " AND begintime < '{$starttime}' AND endtime > '{$endtime}'";
		$cook = pdo_fetch("SELECT * FROM " . tablename($this->table_cook) . " WHERE schoolid = '{$schoolid}' AND ishow = 1 $condition");
		$week = date("w",$endtime);
		if($week ==1){
				if($cook['monday']){
					$thecook = iunserializer($cook['monday']);
					$zc = $thecook['mon_zc'];
					$zcpic = $thecook['mon_zc_pic'];
					$zjc = $thecook['mon_zjc'];
					$zjcpic = $thecook['mon_zjc_pic'];
					$wc = $thecook['mon_wc'];
					$wcpic = $thecook['mon_wc_pic'];
					$wjc = $thecook['mon_wjc'];
					$wjcpic = $thecook['mon_wjc_pic'];
					$wwc = $thecook['mon_wwc'];
					$wwcpic = $thecook['mon_wwc_pic'];
				}
		}
		if($week ==2){
			if($cook['tuesday']){
                $thecook = iunserializer($cook['tuesday']);
				$zc = $thecook['tus_zc'];
				$zcpic = $thecook['tus_zc_pic'];
				$zjc = $thecook['tus_zjc'];
				$zjcpic = $thecook['tus_zjc_pic'];
				$wc = $thecook['tus_wc'];
				$wcpic = $thecook['tus_wc_pic'];
				$wjc = $thecook['tus_wjc'];
				$wjcpic = $thecook['tus_wjc_pic'];
				$wwc = $thecook['tus_wwc'];
				$wwcpic = $thecook['tus_wwc_pic'];		
			}		
		}
		if($week ==3){
			if($cook['wednesday']){
                $thecook = iunserializer($cook['wednesday']);	
				$zc = $thecook['wed_zc'];
				$zcpic = $thecook['wed_zc_pic'];
				$zjc = $thecook['wed_zjc'];
				$zjcpic = $thecook['wed_zjc_pic'];
				$wc = $thecook['wed_wc'];
				$wcpic = $thecook['wed_wc_pic'];
				$wjc = $thecook['wed_wjc'];
				$wjcpic = $thecook['wed_wjc_pic'];
				$wwc = $thecook['wed_wwc'];
				$wwcpic = $thecook['wed_wwc_pic'];	
			}		
		}
		if($week ==4){
			if($cook['thursday']){
                $thecook = iunserializer($cook['thursday']);
				$zc = $thecook['thu_zc'];
				$zcpic = $thecook['thu_zc_pic'];
				$zjc = $thecook['thu_zjc'];
				$zjcpic = $thecook['thu_zjc_pic'];
				$wc = $thecook['thu_wc'];
				$wcpic = $thecook['thu_wc_pic'];
				$wjc = $thecook['thu_wjc'];
				$wjcpic = $thecook['thu_wjc_pic'];
				$wwc = $thecook['thu_wwc'];
				$wwcpic = $thecook['thu_wwc_pic'];	
			}		
		}
		if($week ==5){
			if($cook['friday']){
                $thecook = iunserializer($cook['friday']);	
				$zc = $thecook['fri_zc'];
				$zcpic = $thecook['fri_zc_pic'];
				$zjc = $thecook['fri_zjc'];
				$zjcpic = $thecook['fri_zjc_pic'];
				$wc = $thecook['fri_wc'];
				$wcpic = $thecook['fri_wc_pic'];
				$wjc = $thecook['fri_wjc'];
				$wjcpic = $thecook['fri_wjc_pic'];
				$wwc = $thecook['fri_wwc'];
				$wwcpic = $thecook['fri_wwc_pic'];
			}		
		}
		if($week ==6){
			if($cook['saturday']){
                $thecook = iunserializer($cook['saturday']);
				$zc = $thecook['sat_zc'];
				$zcpic = $thecook['sat_zc_pic'];
				$zjc = $thecook['sat_zjc'];
				$zjcpic = $thecook['sat_zjc_pic'];
				$wc = $thecook['sat_wc'];
				$wcpic = $thecook['sat_wc_pic'];
				$wjc = $thecook['sat_wjc'];
				$wjcpic = $thecook['sat_wjc_pic'];
				$wwc = $thecook['sat_wwc'];
				$wwcpic = $thecook['sat_wwc_pic'];
			}		
		}
		if($week ==7){
			if($cook['sunday']){
                $thecook = iunserializer($cook['sunday']);	
				$zc = $thecook['sun_zc'];
				$zcpic = $thecook['sun_zc_pic'];
				$zjc = $thecook['sun_zjc'];
				$zjcpic = $thecook['sun_zjc_pic'];
				$wc = $thecook['sun_wc'];
				$wcpic = $thecook['sun_wc_pic'];
				$wjc = $thecook['sun_wjc'];
				$wjcpic = $thecook['sun_wjc_pic'];
				$wwc = $thecook['sun_wwc'];
				$wwcpic = $thecook['sun_wwc_pic'];	
			}		
		}		
        include $this->template(''.$school['style1'].'/cooklist');
?>