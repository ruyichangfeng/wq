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
        if($_GPC['op'] == 'add'){
			 $data = explode ( '|', $_GPC ['json'] ); 
			if($_GPC['RecordUid']){
				$item = pdo_fetch("SELECT id FROM " . tablename($this->table_scpy) . " where weid = :weid AND schoolid = :schoolid AND id = :id", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $_GPC['RecordUid']));
				if($item['id']){
					pdo_update($this->table_scpy, array('title' => trim($_GPC['CommentText'])), array('id' => $_GPC['RecordUid']));
			        $data ['status'] = 1;
			        $data ['info'] = '修改成功！';
				}
			}else{
				pdo_insert($this->table_scpy, array(
					'title' => trim($_GPC['CommentText']),
					'tid' => trim($_GPC['tid']),
					'weid' => $weid,
					'schoolid' => $schoolid,
					'createtime' => time()
				));
				$data ['status'] = 1;
				$data ['info'] = '添加成功！';				
			}
			die ( json_encode ( $data ) );
		}
		if(!empty($userid['id'])){
			include $this->template(''.$school['style3'].'/shoucepyglad');
        }else{
			include $this->template('bangding');
        }        
?>