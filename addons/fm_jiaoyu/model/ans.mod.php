<?php 
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
defined('IN_IA') or exit('Access Denied');
load()->func('communication');


//由ID取得作业内容
function GetMyAnswerAll($sid,$zyid){
	$all = pdo_fetchall("SELECT * FROM " . tablename('wx_school_answers') . " where sid= :sid AND zyid = :zyid ORDER by tmid  ", array( ':sid' =>$sid, ':zyid' => $zyid));
	$temp;
	$i = 1;
	foreach($all  as $key =>$value )
	{
		$tmid_temp = $value['tmid'];
		if($value['type']  != 2){
		$temp[$tmid_temp]= $value['MyAnswer'];
		}
		if($value['type']  == 2){
			if(empty($temp[$tmid_temp])){
				
				$i = 1 ;
				$temp[$tmid_temp][$i] = $value['MyAnswer'];

				}
				
			elseif(!empty($temp[$tmid_temp])){
				$i++ ;
				
				$temp[$tmid_temp][$i] = $value['MyAnswer'];
			}
		}
	}

	return $temp ;
};

function GetAnswerByTm_D($array,$tmid){
	$answer;
	$i=1;
	foreach($array  as $key=>$value)
	{
		if($value['tmid'] == $tmid)
		{
			$answer[$tmid][$i] = $value['MyAnswer'];
			$i = $i + 1 ;
		}
	}
	return $answer;
};

function GetAnswerByTm_FD($array,$tmid){
	$answer;
	
	foreach($array  as $key=>$value)
	{
		if($value['tmid'] == $tmid)
		{
			$answer = $value['MyAnswer'];
			
		}
	}
	return $answer;
}




?>