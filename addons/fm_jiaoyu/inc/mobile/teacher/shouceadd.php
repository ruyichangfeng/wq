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
        $nowtime = time();
        //查询是否用户登录
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $userid['id']));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid)); 
		if($_GPC['op']=='add'){
	     $data = explode ( '|', $_GPC ['json'] );   
            if (empty($_GPC ['schoolid'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	        } else {
					$temp = array(
						'weid' => $weid,
						'schoolid' => $schoolid,
						'title' => trim($_GPC['title']),
						'tid' => trim($_GPC['tid']),
						'setid' => trim($_GPC['setid']),
						'bj_id' => trim($_GPC['bj_id']),
						'xq_id' => trim($_GPC['qh_id']),
						'kcid' => trim($_GPC['kc_id']),
						'ksid' => trim($_GPC['ks_id']),
						'starttime' => strtotime($_GPC['starttime']),
						'endtime' => strtotime($_GPC['endtime']),
						'createtime' => time(),
						'sendtype' => 1
					);	
					pdo_insert($this->table_sc, $temp);
			        $data ['status'] = 1;
			
			        $data ['info'] = '创建成功！';
		        
		      die ( json_encode ( $data ) );
	        }			
		}
        if(!empty($userid['id'])){
			$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where :id = id ", array(':id' => $it['tid']));
			$bj1 = pdo_fetch("SELECT sid,sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $teacher['bj_id1'])); 
			$bj2 = pdo_fetch("SELECT sid,sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $teacher['bj_id2'])); 
			$bj2 = pdo_fetch("SELECT sid,sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $teacher['bj_id3']));			
			$allbj = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = '{$it['tid']}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
			$allqh = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 'score' ORDER BY sid ASC, ssort DESC");
			$allkc = pdo_fetchall("SELECT id,name FROM " . tablename($this->table_tcourse) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = '{$it['tid']}' ORDER BY id ASC, ssort DESC");
			$allscset = pdo_fetchall("SELECT id,title,icon,ssort FROM " . tablename($this->table_scset) . " where schoolid = '{$schoolid}' And weid = '{$weid}' ORDER BY ssort ASC");
			$bjidname = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $bj_id));
			include $this->template(''.$school['style3'].'/shouceadd');
        }else{
			include $this->template('bangding');
        }        
?>