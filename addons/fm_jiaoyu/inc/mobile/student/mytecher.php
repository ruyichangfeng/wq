<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
		$schoolid = intval($_GPC['schoolid']);
        
		//教师列表按教师入职时间先后顺序排列，先入职再前
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		if($it){
			$student = pdo_fetch("SELECT xq_id,bj_id FROM " . tablename($this->table_students) . " WHERE schoolid = :schoolid And id = :id", array(':schoolid' => $schoolid,':id' => $it['sid']));
			$bj_id = $student['bj_id'];
			$list = pdo_fetchall("SELECT tid,km_id FROM " . tablename($this->table_class) . " WHERE weid = :weid AND schoolid =:schoolid AND bj_id = :bj_id ", array(
					':weid' => $weid,
					':schoolid' => $schoolid,
					':bj_id' =>$bj_id
					));	
					/*foreach($list as $key=>$value)
			{
				echo $key.":".$value. "\n";
			};*/
				$master2temp = pdo_fetchall("SELECT DISTINCT * FROM " . tablename($this->table_class) . " WHERE weid = :weid AND schoolid = :schoolid  AND bj_id =:bj_id ORDER BY id DESC", array(
				':weid' => $weid,
				':schoolid' => $schoolid,
				
				':bj_id' => $student['bj_id'],
			
			));
			/*foreach($master2temp as $key)
			{
				foreach( $key as $row=>$value)
			{
				echo $row.":".$value."\n";
			}
				
			};	*/	
			/*foreach($master2temp as $key=>$value)
			{
				echo $key.":".$value. "\n";
			};*/
			foreach($list as $key => $row){
					$teacher = pdo_fetch("SELECT tname,thumb FROM " . tablename($this->table_teachers) . " WHERE id = :id", array(':id' => $row['tid']));
					if(!empty($teacher)){
						$list[$key]['tname'] = $teacher['tname'];
						$list[$key]['thumb'] = $teacher['thumb'];
						$list[$key]['kemu'] = pdo_fetchall("SELECT km_id FROM " . tablename($this->table_class) . " WHERE schoolid = :schoolid AND tid =:tid AND bj_id = :bj_id ", array(':schoolid' => $schoolid,':tid' => $row['tid'],':bj_id' =>$bj_id));
						foreach($list[$key]['kemu'] as $k => $r){
							$kemunam = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $r['km_id']));
							$list[$key]['kemu'][$k]['kemus'] = $kemunam['sname'];
						}
					}
			}
		
			$bjname = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $student['bj_id']));
			$xqname = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $student['xq_id']));	
			
			$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
			/*foreach($list as $key)
			{
				foreach($key as $row=>$value)
				echo $row.":".$value. "\n";
				
			};*/
			include $this->template(''.$school['style2'].'/mytecher');
		}else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
		}
?>