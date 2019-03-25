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
 		if($_GPC['op'] == 'del'){
			if(!$_GPC['tid']){
				$data = explode ( '|', $_GPC ['json'] );
				$data ['status'] = 2;
				$data ['info'] = '非法请求！';				
			}else{
				pdo_delete($this->table_sc, array('id' => $_GPC['id']));
				pdo_delete($this->table_scforxs, array('scid' => $_GPC['id']));				
				$data ['status'] = 1;
				$data ['info'] = '删除成功！';				
			}
			die ( json_encode ( $data ) );	
		}       
	   if(!empty($userid['id'])){
			if(!empty($_GPC['bj_id'])){
				$bj_id = $_GPC['bj_id'];
			}else{
				$mybjlist = pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " where schoolid = {$schoolid} And type = 'theclass' And tid = {$it['tid']} ORDER BY ssort DESC LIMIT 0,1 ");
				$bj_id = $mybjlist['sid'];
			}
			$bjlist = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = '{$it['tid']}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
			$njzr = pdo_fetchall("SELECT sid FROM " . tablename($this->table_classify) . " where weid = :weid And schoolid = :schoolid And tid = :tid And type = :type", array(':weid' => $weid, ':schoolid' => $schoolid, ':tid' => $it['tid'], ':type' => 'semester'));
			$bjidname = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $bj_id));
			$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where :id = id ", array(':id' => $it['tid']));
			$bj1 = pdo_fetch("SELECT sid,sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $teacher['bj_id1'])); 
			$bj2 = pdo_fetch("SELECT sid,sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $teacher['bj_id2'])); 
			$bj2 = pdo_fetch("SELECT sid,sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $teacher['bj_id3'])); 
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_sc) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And bj_id = '{$bj_id}' ORDER BY createtime DESC");
			foreach($list as $key => $vule){
				$scset = pdo_fetch("SELECT icon FROM " . tablename($this->table_scset) . " where :id = id ", array(':id' => $vule['setid'])); 
				$kc = pdo_fetch("SELECT name FROM " . tablename($this->table_tcourse) . " where id = '{$vule['kcid']}' ");
				$bj = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $vule['bj_id']));
				$qh = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $vule['xq_id']));				
				$list[$key]['icon'] = $scset['icon'];
				$list[$key]['kcname'] = $kc['name'];
				$list[$key]['bjname'] = $bj['sname'];
				$list[$key]['xqname'] = $qh['sname'];
			}
			include $this->template(''.$school['style3'].'/shoucelist');
        }else{
			include $this->template('bangding');
        }        
?>