<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $this->weid;
        $from_user = $this->_fromuser;
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$obid = 2;
        
        //查询是否用户登录		
        $cache = cache_load('accout');
		
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
        if(!empty($it)){
			$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
			
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND :schoolid = schoolid AND id=:id", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $it['sid']));
			
			$bj = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $student['bj_id']));

			$frist = pdo_fetch("SELECT * FROM " . tablename($this->table_media) . " where schoolid = '{$schoolid}' And type = 0 And bj_id1 = '{$student['bj_id']}' ORDER BY createtime DESC LIMIT 0,1");

			$total = pdo_fetchcolumn("SELECT count(*) FROM " . tablename($this->table_media) . " where schoolid = '{$schoolid}' And type = 0 And (bj_id1 = '{$student['bj_id']}' or bj_id2 = '{$student['bj_id']}' or bj_id3 = '{$student['bj_id']}')");
			
			$cfrist = pdo_fetch("SELECT * FROM " . tablename($this->table_media) . " where schoolid = '{$schoolid}' And type = 2 And (bj_id1 = '{$student['bj_id']}' or bj_id2 = '{$student['bj_id']}' or bj_id3 = '{$student['bj_id']}') ORDER BY id DESC LIMIT 0,1");

			$ctotal = pdo_fetchcolumn("SELECT count(*) FROM " . tablename($this->table_media) . " where schoolid = '{$schoolid}' And type = 2 And (bj_id1 = '{$student['bj_id']}' or bj_id2 = '{$student['bj_id']}' or bj_id3 = '{$student['bj_id']}')");
			
			$this->checkpay($schoolid, $student['id'], $it['id'], $it['uid']);
			
			if ($_GPC['getalist']) {
				$pageSize = intval($_GPC['pageSize']);
				$nowPage = intval($_GPC['nowPage']);
				$item_per_page = empty($_GPC['pageSize']) ? 6 : intval($_GPC['pageSize']);
				$page_number = max(1, intval($_GPC['nowPage']));  
				$bj_id = $student['bj_id'];
				$condition .= " And (bj_id1 = '{$bj_id}' or bj_id2 = '{$bj_id}' or bj_id3 = '{$bj_id}')";			
				if(!is_numeric($page_number)){  
					header('HTTP/1.1 500 Invalid page number!');  
					exit();  
				}
							
				$position = ($page_number-1) * $item_per_page;
				
				$xclist =pdo_fetchall("SELECT * FROM " . tablename($this->table_media) . " WHERE weid = {$_W['uniacid']} AND type= 1 AND isfm= 1 $condition ORDER BY createtime DESC LIMIT " . $position . ',' . $item_per_page );
				foreach ($xclist as $key => $value) {
					$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND :schoolid = schoolid AND id=:id", array(
						':weid' => $weid,
						':schoolid' => $schoolid,
						':id' => $value['sid']
						));
					$stotal = pdo_fetchcolumn("SELECT count(*) FROM " . tablename($this->table_media) . " where schoolid = '{$schoolid}' And type = 1 And sid = '{$value['sid']}' ");	  
					$xclist[$key]['tag'] = $students['s_name'];	
					$xclist[$key]['wlzytype'] = $value['sid'];
					$xclist[$key]['total'] = $stotal;
					$xclist[$key]['tagid'] = $value['uid'];
					$xclist[$key]['picurl'] = tomedia($value['fmpicurl']);
				}
				$datas = array(
					'ret' => array('code' => '200','msg' => 'success'),
					'data' => array(
								'albumList' => $xclist,
									)
							);
							
					echo json_encode($datas);
					exit;
			}
		
		 	include $this->template(''.$school['style2'].'/sxclist');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
