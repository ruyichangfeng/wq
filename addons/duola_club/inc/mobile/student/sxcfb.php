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
        
        //查询是否用户登录		
		
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));	
		if(!empty($it)){
			$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $it['sid']));
			$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $schoolid));
			
			$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  :weid AND schoolid =:schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'sid');
					
			$bj_id = $category[$students['bj_id']]['sid'];
			
			$bjidname = $category[$students['bj_id']]['sname'];		
				
			$shenfen = "";
			
			if ($it['pard'] == 2){
				$shenfen = "母亲";
			}else if($it['pard'] == 3){	
				$shenfen = "父亲";
			}else if($it['pard'] == 4){	
				$shenfen = "本人";			
			}
			
       
            
			//$isbzr = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $it['tid']));
			
		    include $this->template(''.$school['style2'].'/sxcfb'); 
		}else{
			session_destroy();
			include $this->template('bangding'); 
		}        
?>