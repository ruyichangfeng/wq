<?php 
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
defined('IN_IA') or exit('Access Denied');
load()->func('communication');


//由ID取得作业内容
function GetZyContent($zyid,$schoolid,$weid){
	$ZYContents = pdo_fetchall("SELECT * FROM " . tablename('wx_school_questions') . " where schoolid =:schoolid AND weid = :weid and zyid= :zyid ORDER by qorder  ", array(':schoolid'=>$schoolid,':weid'=> $weid, ':zyid' => $zyid));
	$ZYtemp;
	
	foreach($ZYContents as $key=>$value)
	{
		$i                           = $key + 1 ;
		$ZYContents[$key]['content'] = iunserializer( $ZYContents[$key]['content'] );
		$ZYtemp[$i]                  = $ZYContents[$key];
	};

    //       (第一维)      （第二维）       (第三维)      (第四维)
	//$ZYtemp[第几题][id?title?content?][第几个选项][title?is_answer?]
	 return $ZYtemp;	
}

function GetZyContentPlusTm($zyid,$tmid,$schoolid,$weid){
	$ZYContents = pdo_fetchall("SELECT * FROM " . tablename('wx_school_questions') . " where schoolid =:schoolid AND weid = :weid and zyid= :zyid ORDER by qorder  ", array(':schoolid'=>$schoolid,':weid'=> $weid,':zyid' => $zyid));
	$ZYtemp;
	
	foreach($ZYContents as $key=>$value)
	{
		$i = $key + 1 ;
		$ZYContents[$key]['content'] = iunserializer( $ZYContents[$key]['content'] );
		$ZYtemp[$i] = $ZYContents[$key];
	};

    //       (第一维)      （第二维）       (第三维)      (第四维)
	//$ZYtemp[第几题][id?title?content?][第几个选项][title?is_answer?]
	 return $ZYtemp[$tmid];	
}

//由ID取得答题内容
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

function GetMyAnswerAll_tea($tid,$zyid){
	$all = pdo_fetchall("SELECT * FROM " . tablename('wx_school_answers') . " where tid= :tid AND zyid = :zyid  ORDER by tmid  ", array( ':tid' =>$tid, ':zyid' => $zyid));
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

function GetTongJi($zyid,$schoolid,$weid)
{
		$ZY_Content = GetZyContent($zyid,$schoolid,$weid);
		$TJtemp;
		foreach($ZY_Content as $key=>$value)
		{
			$tmid = $value['qorder'];
			foreach($value['content'] as $keys=>$values)
			{
				$xxid = $keys;
				$all = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wx_school_answers') . " where zyid= :zyid AND tmid = :tmid  AND MyAnswer =:xxid ORDER by tmid  ", array( ':zyid' =>$zyid, ':tmid' => $tmid, 'xxid' =>$xxid ));
				$Stud = pdo_fetchall("SELECT sid FROM " . tablename('wx_school_answers') . " where zyid= :zyid AND tmid = :tmid  AND MyAnswer =:xxid ORDER by tmid  ", array( ':zyid' =>$zyid, ':tmid' => $tmid, 'xxid' =>$xxid ));
				$TJtemp[$tmid][$xxid]['count'] = $all ;
				$TJtemp[$tmid][$xxid]['sids'] = $Stud ;
				
			}
		}
	return $TJtemp;
}

function GetWenDaTongJiPlusTm($zyid,$tmid){
	$temp = pdo_fetchall("SELECT sid,MyAnswer FROM " . tablename('wx_school_answers') . " where zyid= :zyid AND tmid = :tmid   ", array( ':zyid' =>$zyid, ':tmid' => $tmid ));
	/*foreach($temp as $key=>$value){
		
	}*/
	$FanHui = array();
	foreach($temp as $key=>$value)
	{
	$creator_name =  pdo_fetch("SELECT s_name FROM " . tablename('wx_school_students') . " where id= :sid   ", array( ':sid' =>$value['sid']));
	 	$FanHui[$key]['creator_name'] = $creator_name['s_name'] ;
	 	$FanHui[$key]['sid'] = $value['sid'];
		$FanHui[$key]['answer_content'] = $value['MyAnswer'];
	}
	return $FanHui;
}


function GetMyAnswer_type7($sid,$zyid){
	$all = pdo_fetch("SELECT * FROM " . tablename('wx_school_answers') . " where sid= :sid AND zyid = :zyid  AND type = 7  ", array( ':sid' =>$sid, ':zyid' => $zyid));
	
	$i = 1;
	$content_arr = iunserializer($all['MyAnswer']);
	
	$all['MyAnswer'] = $content_arr; 
	

	return $all ;
};

?>