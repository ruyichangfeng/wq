<?php
/**
 * 微教育模块
 *QQ：332035136
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
       // $json = $_GPC['txtItemJson'];
        mload()->model('que');

        
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$leaveid = intval($_GPC['id']);
		$record_id = intval($_GPC['record_id']);
		//mload()->model('store');
		if (!empty($_GPC['userid'])){
		    $_SESSION['user'] = $_GPC['userid'];
		}
		$obid = 1;
        
        //查询是否用户登录
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		$userid = $it['id'];
		$leave = pdo_fetch("SELECT * FROM " . tablename($this->table_notice) . " where :id = id", array(':id' => $leaveid));
		$anstype = iunserializer($leave['anstype']);
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  :weid AND schoolid =:schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
		
        $bzrtid = $category[$leave['bj_id']]['tid'];
		$bjname = $category[$leave['bj_id']]['sname'];
		
        if(!empty($it)){
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['sid']));
			$this->checkobjiect($schoolid, $it['sid'], $obid);
			$picarr = iunserializer($leave['picarr']);
			$recode = pdo_fetch("SELECT * FROM " . tablename($this->table_record) . " where schoolid = :schoolid And noticeid = :noticeid And sid = :sid And userid = :userid", array(':schoolid' => $schoolid,':noticeid' => $leaveid,':sid' => $it['sid'],':userid' => $it['id']));
			$ZY_contents = GetZyContent($leaveid,$schoolid,$weid);
			if ($recode){
				//$id = !empty($record_id) ? $record_id : $recode['id'];
				//$record = pdo_fetch("SELECT readtime FROM " . tablename($this->table_record) . " where id = :id", array(':id' => $recode['id']));
				if($recode['readtime'] == 0){
					$date = array(
						'readtime' =>time()
					);
					pdo_update($this->table_record, $date, array('id' => $recode['id']));				
				}			
			}else{
				$data = array(
					'weid' =>  $weid,
					'schoolid' => $schoolid,
					'noticeid' => $leaveid,
					'sid' => $it['sid'],
					'userid' => $it['id'],
					'openid' => $openid,
					'type' => $leave['type'],
					'createtime' => $leave['createtime'],
					'readtime' =>time()
				);
				pdo_insert($this->table_record, $data);		
			}
	//echo "here";
	
	$student = pdo_fetch("SELECT s_name,icon FROM " . tablename($this->table_students) . " where schoolid = :schoolid AND id = :id", array(':schoolid' => $schoolid, ':id' => $it['sid']));
			$testAA = GetMyAnswerAll($it['sid'] ,$leaveid,$schoolid,$weid);
			$testBB = GetMyAnswer_type7($it['sid'],$leaveid);
			//var_dump($testBB);
			//var_dump($it['sid']);
			//var_dump($leaveid);
		//	echo $testAA;
			//$answerss = GetAnswerByTm_WenDa($testAA,3);
			//echo $testAA;
			/*foreach($testAA as $key=>$value)
			{
				echo $key.":".$value ."</br>";
				foreach($value  as $keys=>$values )
				{
					
					echo $keys.":".$values ."</br>";
				}
			}*/
			//echo "yes";
		  include $this->template(''.$school['style2'].'/szuoye');
		//  $TJjieguo = GetTongJi($leaveid);
		  //print_r($TJjieguo);
		  /*foreach($TJjieguo as  $key=> $value)
		  {
			//  $TJjieguo[1][1];
			  echo $key.":".$value."\n<br>";
			  foreach($value as $keys=>$values)
			   {
				   echo $kes.":".$values."\n<br>";
				   foreach($values as $keyss=>$valuess)
				   {
					    echo $kess.":".$valuess."\n<br>";
				   }
			   }
		  }*/
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
?>