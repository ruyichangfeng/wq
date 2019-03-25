<?php
/**
 * 万能表单模块微站定义
 *
 * @author wuhao
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Wuhao_multiformModuleSite extends WeModuleSite {
	public function doWebTemplate() {
		global $_W,$_GPC;
		if($_GPC['submit']==1){
			$data['templatename']=$_GPC['templatename'];
			$data['length']=$_GPC['length'];
			$data['uniacid']=$_W['uniacid'];
			$data['data_detail']=$_GPC['data_detail'];
			$data['create_time']=date('y-m-d H:i:s',time());

			$data_template=pdo_fetch("SELECT * FROM ".tablename('multiform_template')." WHERE `uniacid`=:uniacid AND `templatename` = :templatename",array(':uniacid'=>$_W['uniacid'],':templatename'=>$data['templatename']));
			if(!$data_template){
				$res=pdo_insert('multiform_template',$data,true);
				if($res){
					echo "添加模板成功";
				}else{
					echo "添加模板失败";
				}
			}else{
				echo "此模板已存在";
			}
		}else{
			$op=0;
			include $this->template('template');
		}
	}
	public function doWebEdittemplate() {
		global $_W,$_GPC;		
		if($_GPC['submit']==1){
			$data['templatename']=$_GPC['templatename'];
			$data['length']=$_GPC['length'];
			$data['uniacid']=$_W['uniacid'];
			$data['data_detail']=$_GPC['data_detail'];
			$data['create_time']=date('y-m-d H:i:s',time());
			$data['templateid']=$_GPC['templateid'];
			
			$result=pdo_update('multiform_template', $data, array('templateid' => $data['templateid'],'uniacid'=>$data['uniacid']));
			if($result){
				echo "更新模板信息成功";
			}else{
				echo "更新模板信息失败";
			}
		}else{
			$data_template=pdo_fetch("SELECT * FROM ".tablename('multiform_template')." WHERE `uniacid`=:uniacid AND `templateid`=:templateid",array(':uniacid'=>$_W['uniacid'],':templateid'=>$_GPC['templateid']));
			$op=1;
			include $this->template('template');
		}
	}
	public function doWebListalltemplate() {
		global $_W,$_GPC;
		$pageindex = max(intval($_GPC['page']), 1); // 当前页码
		$pagesize =20; // 设置分页大小
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('multiform_template')." WHERE `uniacid`=:uniacid ORDER BY templateid DESC",array(':uniacid'=>$_W['uniacid']));

		$pager = pagination($total, $pageindex, $pagesize);

		$data_template=pdo_fetchall("SELECT * FROM ".tablename('multiform_template')." WHERE `uniacid`=:uniacid ORDER BY templateid DESC LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize,array(':uniacid'=>$_W['uniacid']));

		//$data_templates=array();
		foreach($data_template as $key=>$value){
			$str = html_entity_decode($value['data_detail']);
			$data_detail=json_decode($str);				

			$data_templates[$key]=array();
			$i=0;	
			foreach($data_detail as $key_d=>$value_d){					
				foreach($value_d as $key1=>$value1){
					if($key1=='title'){
						$title=$value1;
						$data_templates[$key][$i++]['title']=$title;
					}else if($key1=='type'){
						$type=$value1;
					}else if($key1=='content'){
						$content=$value1;
					}else if($key1=='contentarray'){
						$contentarray=$value1;
					}else if($key1=='timeflag'){
						$timeflag=$value1;
						if(!(($content == null) && ($contentarray == null))){
							$data_templates[$key][$i]['title']=$title;
							if($type==1||$type==8||$type==10||$type==11||$type==14||$type==15){
								$data_templates[$key][$i]['content']=$content;
							}else if($type==9){
								foreach($contentarray as $key2=>$value2){
									$data_templates[$key][$i]['content'].=$value2.' ';
								}
							}
							$i++;
						}
					}
				}
			}
			
		}
		include $this->template('listalltemplate');
	}
	public function doWebDeltemplate() {
		global $_W,$_GPC;

		$res=pdo_delete('multiform_template',array('templateid'=>$_GPC['templateid'],'uniacid'=>$_W['uniacid']));
		if($res){
			message("删除模板成功！",$this->createWebUrl('listalltemplate', array()),'success');
		}else{
			message("删除模板失败！",$this->createWebUrl('listalltemplate', array()),'error');
		}
	}

	public function doWebMatches() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
		if($_GPC['submit']==1){	
			$data['uniacid']=$_W['uniacid'];
			$data['title']=$_GPC['title'];//活动标题
			$data['templateid']=$_GPC['templateid'];			
			$data['create_time']=date('y-m-d H:i:s',time());
			$data['data_detail']=$_GPC['data_detail'];			
			$data_match=pdo_fetch("SELECT * FROM ".tablename('multiform_matches')." WHERE `uniacid`=:uniacid AND `templateid`=:templateid AND `title`=:title",array(':uniacid'=>$_W['uniacid'],':templateid'=>$data['templateid'],':title'=>$data['title']));
			if($data_match){
				echo "此活动已添加";
			}else{
				$res=pdo_insert('multiform_matches',$data,true);
				if($res){
					echo "添加活动成功";
				}else{
					echo "添加活动失败";
				}
			}
		}else{
			$op=0;
			$data_template=pdo_fetch("SELECT * FROM ".tablename('multiform_template')." WHERE `uniacid`=:uniacid AND `default`=:default",array(':uniacid'=>$_W['uniacid'],':default'=>1));
			include $this->template('matches');
		}
	}
	public function doWebEditmatches() {
		global $_W,$_GPC;
		if($_GPC['submit']==1){
			$data['uniacid']=$_W['uniacid'];
			$data['title']=$_GPC['title'];
			$data['templateid']=$_GPC['templateid'];
			$data['create_time']=date('y-m-d H:i:s',time());
			$data['data_detail']=$_GPC['data_detail'];
			$data['matchid']=$_GPC['matchid'];
			
			$result=pdo_update('multiform_matches', $data, array('matchid' => $data['matchid'],'uniacid'=>$data['uniacid']));
			if($result){
				message('更新活动成功',$this->createWebUrl('listallmatches',array()),'success');
			}else{
				message('更新活动失败',$this->createWebUrl('listallmatches',array()),'error');
			}
		}else{
			$data_matches=pdo_fetch("SELECT * FROM ".tablename('multiform_matches')." WHERE `uniacid`=:uniacid AND `matchid`=:matchid",array(':uniacid'=>$_W['uniacid'],':matchid'=>$_GPC['matchid']));
			$data_template=pdo_fetch("SELECT * FROM ".tablename('multiform_template')." WHERE `uniacid`=:uniacid AND `templateid`=:templateid",array(':uniacid'=>$_W['uniacid'],':templateid'=>$data_matches['templateid']));

			

			$str = html_entity_decode($data_template['data_detail']);
			$template=json_decode($str);	

			$template_array=array();
			foreach($template as $key=>$value){
				foreach($value as $key1=>$value1){							
					$template_array[$key][$key1]=$value1;							
				}
				$template_array[$key]['found']=0;
			}

			$str = html_entity_decode($data_matches['data_detail']);
			$matches=json_decode($str);					
			$matches_array=array();
			foreach($matches as $key=>$value){
				foreach($value as $key1=>$value1){							
					$matches_array[$key][$key1]=$value1;							
				}
				$matches_array[$key]['found']=0;
			}

			

			foreach($template_array as $key=>$value){
				foreach($matches_array as $key1=>$value1){
					if($value['title']==$value1['title']){
						$matches_array[$key1]['found']=1;
						//$matches_array[$key1]['change']=0;
						$template_array[$key]['found']=1;
						break;
					}
				}
			}
			
			

			foreach($matches_array as $key=>$value){
				if($value['found']==0){					
					$pattern='/,{&quot;title&quot;:&quot;'.$value['title'].'(.+?)timeflag&quot;:(true|false)}/';
					$data_matches['data_detail'] = preg_replace($pattern, '', $data_matches['data_detail']);
					$pattern1='/\[{&quot;title&quot;:&quot;'.$value['title'].'(.+?)timeflag&quot;:(true|false)},/';
					$data_matches['data_detail'] = preg_replace($pattern1, '[', $data_matches['data_detail']);
					$pattern2='/\[{&quot;title&quot;:&quot;'.$value['title'].'(.+?)timeflag&quot;:(true|false)}/';
					$data_matches['data_detail'] = preg_replace($pattern2, '[', $data_matches['data_detail']);
				}
			}

			foreach($template_array as $key=>$value){
				if($value['found']==0){
					$pattern='/,{&quot;title&quot;:&quot;'.$value['title'].'(.+?)timeflag&quot;:(true|false)}/';
					$matchnum=preg_match($pattern,$data_template['data_detail'],$result);
					if($matchnum==0){
						$pattern='/{&quot;title&quot;:&quot;'.$value['title'].'(.+?)timeflag&quot;:(true|false)}/';
						$matchnum=preg_match($pattern,$data_template['data_detail'],$result);
						if($data_matches['data_detail']=='[]'){
							$data_matches['data_detail'] = preg_replace('/\[]/', '['.$result[0].']', $data_matches['data_detail']);
						}else{
							$data_matches['data_detail'] = preg_replace('/}]/', '},'.$result[0].']', $data_matches['data_detail']);
						}
					}else{
						$data_matches['data_detail'] = preg_replace('/}]/', '}'.$result[0].']', $data_matches['data_detail']);
					}
				}
			}

			$op=1;
			include $this->template('matches');
		}
	}

	public function doWebListallmatches() {
		global $_W,$_GPC;
		$pageindex = max(intval($_GPC['page']), 1); // 当前页码
		$pagesize =20; // 设置分页大小
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('multiform_matches')." WHERE `uniacid`=:uniacid ORDER BY matchid DESC",array(':uniacid'=>$_W['uniacid']));

		$pager = pagination($total, $pageindex, $pagesize);

		$data_matches=pdo_fetchall("SELECT * FROM ".tablename('multiform_matches')." WHERE `uniacid`=:uniacid ORDER BY matchid DESC LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize,array(':uniacid'=>$_W['uniacid']));
		//$data_matchess=array();
		foreach($data_matches as $key=>$value){
			$str = html_entity_decode($value['data_detail']);
			$data_detail=json_decode($str);				

			$data_matchess[$key]=array();
			$i=0;	
			foreach($data_detail as $key_d=>$value_d){

				foreach($value_d as $key1=>$value1){
					if($key1=='title'){
						$title=$value1;
						//$data_matchess[$key][$i++]['title']=$title;
					}else if($key1=='type'){
						$type=$value1;						
					}else if($key1=='content'){
						$content=$value1;
					}else if($key1=='contentarray'){
						$contentarray=$value1;
					}else if($key1=='province'){
						$province=$value1;
					}else if($key1=='city'){
						$city=$value1;
					}else if($key1=='district'){
						$district=$value1;
					}else if($key1=='startDate'){
						$startdate=$value1;
					}else if($key1=='endDate'){
						$enddate=$value1;
					}else if($key1=='timeflag'){
						$timeflag=$value1;
						if(!(($content == null) && ($contentarray == null))){
							$data_matchess[$key][$i]['title']=$title;
							if($type==1||$type==8||$type==10||$type==11||$type==12){
								$data_matchess[$key][$i]['content']=$content;
							}else if($type==9){
								foreach($contentarray as $key2=>$value2){
									$data_matchess[$key][$i]['content'].=$value2.' ';
								}
							}else if($type==15){
								$data_matchess[$key][$i]['content']=$contentarray;
							}						
						}else if($type==2){
							$data_matchess[$key][$i]['title']=$title;
							$data_matchess[$key][$i]['content']=$startdate.'---'.$enddate;
						}else if($type==14){
							$data_matchess[$key][$i]['title']=$title;
							$data_matchess[$key][$i]['content']=$province.$city.$district;
						}
						$i++;
					}
				}
			}
		}
		
		include $this->template('listallmatches');
	}

	public function doWebDelmatches() {
		global $_W,$_GPC;		

		$res=pdo_delete('multiform_matches',array('matchid'=>$_GPC['matchid'],'uniacid'=>$_W['uniacid']));
		if($res){
			message("删除活动成功！",$this->createWebUrl('listallmatches', array()),'success');
		}else{
			message("删除活动失败！",$this->createWebUrl('listallmatches', array()),'error');
		}
	}

	public function doWebGenmatches() {
		global $_W,$_GPC;
		$data_template=pdo_fetch("SELECT * FROM ".tablename('multiform_template')." WHERE `uniacid`=:uniacid AND `templateid`=:templateid",array(':uniacid'=>$_W['uniacid'],':templateid'=>$_GPC['templateid']));

		$data_template_default=pdo_fetch("SELECT * FROM ".tablename('multiform_template')." WHERE `uniacid`=:uniacid AND `default`=:default",array(':uniacid'=>$_W['uniacid'],':default'=>1));
		if($data_template_default){
			pdo_update('multiform_template', array('default' => 0), array('templateid' => $data_template_default['templateid'],'uniacid'=>$_W['uniacid']));
		}

		$result=pdo_update('multiform_template', array('default' => 1), array('templateid' => $data_template['templateid'],'uniacid'=>$_W['uniacid']));
		if(!$result){
			message('更新默认模板失败！', $this->createWebUrl('listalltemplate', ''), 'error');
		}			
		include $this->template('matches');
	}
}