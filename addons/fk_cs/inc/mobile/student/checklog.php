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
		$time = $_GPC['time'];
		
		if (!empty($_GPC['userid'])){
			$_SESSION['user'] = $_GPC['userid'];
		}

		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));

		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		$parents = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where weid = :weid AND openid=:openid AND schoolid=:schoolid ", array(':weid' => $weid, ':openid' => $openid, ':schoolid' => $schoolid));
		if(!empty($parents['area_addr_location'])){
			$parents['area_addr_location'] = json_decode($parents['area_addr_location'],true);
		}
				
        if(!empty($it)){
			if(empty($time)){
				
				$starttime = mktime(0,0,0,date("m"),date("d"),date("Y"));
	 
				$endtime = $starttime + 86399;
				
				$condition .= " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
			}else{
				
				$date = explode ( '-', $time );
				
				$starttime = mktime(0,0,0,$date[1],$date[2],$date[0]);
				
				$endtime = $starttime + 86399;
				
				$condition .= " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
			}
					
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['sid']));
			
			$log = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " where weid = :weid AND schoolid = :schoolid AND sid = :sid $condition ORDER by createtime ASC", array(
				':weid' => $weid,
				':schoolid' => $schoolid,
				':sid' => $it['sid']
			));

			if (empty($_W['setting']['remote']['type'])) { 
				$urls = "http://severwm.oss-cn-shenzhen.aliyuncs.com/"; 
			} else {
				$urls = "http://severwm.oss-cn-shenzhen.aliyuncs.com/"; 
			}
			include $this->template(''.$school['style2'].'/checklog');
        }else{
//			session_destroy();
//            include $this->template('bangding');
			include $this->template(''.$school['style2'].'/addchild');
        }        
?>