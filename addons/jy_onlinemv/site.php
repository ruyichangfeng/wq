<?php
/**
 * 在线观影模块微站定义
 *
 * @author xiaoming
 * @url http://anonymous.orz.xyz/
 */
require_once 'vendor/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

defined('IN_IA') or exit('Access Denied');
define('ONLINEMV_CSS', '../addons/jy_onlinemv/static/css/');
define('ONLINEMV_JS', '../addons/jy_onlinemv/static/js/');
define('ONLINEMV_IMAGE', '../addons/jy_onlinemv/static/images/');
define('PSIZE', '100');
if($_W['container'] == 'wechat'){
	define('WEIXIN', '1');
}else{
	define('WEIXIN', '2');
}


class Jy_onlinemvModuleSite extends WeModuleSite {

	public function __cull(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$userinfo = $_SESSION['userinfo'];
		$openid = $_W['openid'];

		$datas = array(
			'weid'=>$weid,
			'mid'=>$userinfo['id'],
			'createtime'=>TIMESTAMP
			);
		pdo_insert('jy_onlinemv_stat',$datas);
		$_SESSION['statid'] = pdo_insertid();
		
	}

	private function array_sort($arr,$keys,$type='asc'){ 
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v){
			$new_array[$k] = $arr[$k];
		}
		return $new_array; 
	}

	//基本设置
	public function doWebSetting() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		checklogin();

		load()->func('tpl');

		$item=pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_setting')." WHERE weid=".$weid);
		if(empty($item))
		{
			$item['color'] = '#4aded4';
			$item['type'] = 2;
			$item['monthly'] = 1;
		}

		if(checksubmit()) {
			
			$data=array(
				'weid'=>$weid,
				'aname'=>$_GPC['aname'],
				'title'=>$_GPC['title'],
				'avar'=>$_GPC['avar'],
				'sharetitle'=>$_GPC['sharetitle'],
				'sharedesc'=>$_GPC['sharedesc'],
				'sharelogo'=>$_GPC['sharelogo'],
				'copyright' => $_GPC ['copyright'],
				'copyrighturl' => $_GPC ['copyrighturl'],
				'catethumn' => $_GPC ['catethumn'],
				'topbanner' => $_GPC ['topbanner'],
				'color' => $_GPC ['color'],
				'buynow' => $_GPC ['buynow'],
				'monthprice' => $_GPC ['monthprice'],
				'yearprice' => $_GPC ['yearprice'],
				'valid_time' => $_GPC ['valid_time'],
				'number' => $_GPC ['number'],
				'price' => $_GPC ['price'],
				'type' => $_GPC ['type'],
				'monthly' => $_GPC ['monthly'],
				'package' => $_GPC ['package'],
				'pack' => $_GPC ['pack'],
				'unitprice' => $_GPC ['unitprice'],
				'camilo' => $_GPC ['camilo'],
				'ak' => $_GPC ['ak'],
				'sk' => $_GPC ['sk'],
				'updatetime'=>TIMESTAMP,
				);
			
			
			
			if(empty($item['id']))
			{
				$data['createtime']=time();
				pdo_insert('jy_onlinemv_setting',$data);
			}
			else
			{
				pdo_update('jy_onlinemv_setting',$data,array('weid'=>$weid));
			}

			message("设置成功!",$this->createWebUrl('setting'),'success');
		}
		include $this->template('web/setting');
	}

	//幻灯片设置
	public function doWebBanner() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		checklogin();

		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
	    if ($operation == 'display') {
	        if (!empty($_GPC['displayorder'])) {
	            foreach ($_GPC['displayorder'] as $id => $displayorder) {
	                pdo_update('jy_onlinemv_banner', array('displayorder' => $displayorder), array('id' => $id));
	            }
	            message('Banner更新成功！', $this->createWebUrl('banner', array('op' => 'display')), 'success');
	        }
	        if(!empty($_GPC['keyword']))
	        {
	        	$condition.=" AND catename LIKE '%{$_GPC['keyword']}%' ";
	        }
	        $category = pdo_fetchall("SELECT * FROM " . tablename('jy_onlinemv_banner') . " WHERE weid = '{$_W['weid']}' ".$condition." ORDER BY displayorder DESC,id ASC");
	        include $this->template('web/banner');
	    } elseif ($operation == 'post') {
	    	load()->func('tpl');

	        $id = intval($_GPC['id']);
	        if (!empty($id)) {
	            $category = pdo_fetch("SELECT * FROM " . tablename('jy_onlinemv_banner') . " WHERE id = '$id'");
	        } else {
	            $category = array(
	                'displayorder' => 0,
	                'enabled' =>0,
	                'status' =>1,
	            );
	        }

	        if (checksubmit('submit')) {
	            if (empty($_GPC['catename'])) {
	                message('抱歉，请输入Banner名称！');
	            }
	            $link=$_GPC['url'];
				if(!empty($link)){
					if (!preg_match("/^(http|ftp):/", $link)){
					   $link='http://'.$link;
					}
				}
				if($this->text_len($link)>500){
					message("链接内容超长啦！");
				}
	            $data = array(
	                'weid' => $_W['weid'],
	                'catename' => $_GPC['catename'],
	                'thumb' => $_GPC['thumb'],
	                'content' => $_GPC['content'],
	                'enabled' => $_GPC['enabled'],
	                'url' => $link,
	                'displayorder' => intval($_GPC['displayorder']),
	                'status' => intval($_GPC['status']),
	            );

	            if (!empty($id)) {
	                pdo_update('jy_onlinemv_banner', $data, array('id' => $id));
	            } else {
	            	$data['createtime']=TIMESTAMP;
	                pdo_insert('jy_onlinemv_banner', $data);
	                $id = pdo_insertid();
	            }
	            message('更新Banner成功！', $this->createWebUrl('banner', array('op' => 'display')), 'success');
	        }
	        include $this->template('web/banner');
	    } elseif ($operation == 'delete') {
	        $id = intval($_GPC['id']);
	        $category = pdo_fetch("SELECT id FROM " . tablename('jy_onlinemv_banner') . " WHERE id = '$id'");
	        if (empty($category)) {
	            message('抱歉，Banner不存在或是已经被删除！', $this->createWebUrl('banner', array('op' => 'display')), 'error');
	        }
	        pdo_delete('jy_onlinemv_banner', array('id' => $id));
	        message('Banner删除成功！', $this->createWebUrl('banner', array('op' => 'display')), 'success');
	    }
	}

	//分类管理
	public function doWebclass(){
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if ($operation == 'display') {
			// $pindex = max(1, intval($_GPC['page']));//当前第几页
			// $psize = 15;//每页几条信息

			if (! empty ( $_GPC ['displayorder'] )) {
				foreach ( $_GPC ['displayorder'] as $id => $displayorder ) {
					pdo_update ( 'jy_onlinemv_class', array ('displayorder' => $displayorder ), array ('id' => $id) );
				}
				message ( '分类管理更新成功！', $this->createWebUrl ( 'class', array ('op' => 'display') ), 'success' );
			}
			// $category = pdo_fetchall ( "SELECT * FROM " . tablename ('jy_onlinemv_class') . " WHERE weid = '{$_W['weid']}'  ORDER BY displayorder DESC,id ASC limit ".($pindex-1)*$psize.",{$psize}" );
			$category = pdo_fetchall ( "SELECT * FROM " . tablename ('jy_onlinemv_class') . " WHERE weid = '{$_W['weid']}'  ORDER BY displayorder DESC,id ASC" );
			$children = array();
			foreach($category as $ck => $cv){
				if (!empty($cv['parentid'])) {
	                $children[$cv['parentid']][] = $cv;
	                unset($category[$ck]);
	            }
			}
			$all_sql = "select count(id) as a from ".tablename('jy_onlinemv_class')." where weid='{$weid}'";
			$abc = pdo_fetch($all_sql);
			$total = $abc['a'];
			$pager = pagination($abc['a'], $pindex, $psize);

			include $this->template ( 'web/class' );
		}elseif ($operation == 'post') {
			$parentid = intval($_GPC['parentid']);
			$id = intval ( $_GPC ['id'] );
			load()->func('tpl');
			if (! empty ( $id )) {
				$category = pdo_fetch ( "SELECT * FROM " . tablename ('jy_onlinemv_class') . " WHERE id = '$id'" );
			} else {
				$category = array (
						'displayorder' => 0,
						'enabled' => 1
				);
			}
			if (!empty($parentid)) {
	            $parent = pdo_fetch("SELECT id, catename FROM " . tablename('jy_onlinemv_class') . " WHERE id = '{$parentid}'");
	            if (empty($parent)) {
	                message('抱歉，该类型不存在或是已经被删除！', $this->createWebUrl('post'), 'error');
	            }
	        }
	        
			if (checksubmit ( 'submit' )) {
				if (empty ( $_GPC ['catename'] )) {
					message ( '抱歉，请输入分类名称！' );
				}
				$temp = pdo_fetch ( "SELECT id FROM " . tablename ( 'jy_onlinemv_class' ) . " WHERE weid=" . $weid . " AND catename='" . $_GPC ['catename'] . "'" );
				if (! empty ( $temp ) && $id != $temp ['id']) {
					message ( '已存在该分类管理！', $this->createWebUrl ( 'class', array ('op' => 'display' ) ), 'error' );
				}
				$data = array (
						'weid' => $_W ['weid'],
						'catename' => $_GPC ['catename'],
						'thumb' => $_GPC ['thumb'],
						'icon' => $_GPC ['icon'],
						'remark' => $_GPC ['remark'],
						'enabled' => intval ( $_GPC ['enabled'] ),
						'is_index' => intval ( $_GPC ['is_index'] ),
						'parentid' => intval ( $_GPC ['parentid'] ),
						'displayorder' => intval ( $_GPC ['displayorder'] ) ,
						'createtime' => TIMESTAMP,
						
				);
				if (! empty ( $id )) {
					pdo_update ( 'jy_onlinemv_class', $data, array ('id' => $id ) );
				} else {
					pdo_insert ( 'jy_onlinemv_class', $data );
					$id = pdo_insertid ();
				}
				message ( '分类管理设置成功！', $this->createWebUrl ( 'class', array ('op' => 'display' ) ), 'success' );
			}
			include $this->template ( 'web/class' );
		} elseif ($operation == 'delete') {
			$id = intval ( $_GPC ['id'] );
			$category = pdo_fetch ( "SELECT id FROM " . tablename ( 'jy_onlinemv_class' ) . " WHERE id = '$id'" );
			if (empty ( $category )) {
				message ( '抱歉，分类管理设置不存在或是已经被删除！', $this->createWebUrl ( 'class', array ('op' => 'display' ) ), 'error' );
			}
			pdo_delete ( 'jy_onlinemv_class', array ('id' => $id ) );
			message ( '分类管理设置删除成功！', $this->createWebUrl ( 'class', array ('op' => 'display' ) ), 'success' );
		}
	}

	//视频管理
	public function doWebStore() {
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();

		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		load()->func('tpl');
		$types = pdo_fetchall( "SELECT * FROM " . tablename ( 'jy_onlinemv_class' ) . " WHERE weid = '{$_W['weid']}' ORDER BY id ASC" );
		//标签
		$lables = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$_W['weid']}' ORDER BY displayorder DESC");
		//设置信息
		$setting=pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_setting')." WHERE weid=".$weid);

		if ($operation == 'display') {
			$keyword = $_GPC['keyword'];
			$sort = intval($_GPC['sort']);
			
			$keyword = str_replace("_", "\_", $keyword);
			$keyword = str_replace("%", "\%", $keyword);
			$condition = '';
			if($keyword){
				$condition = ' AND videoname like "%'.$keyword.'%" OR catename like "%'.$keyword.'%"';
			}else{
				$condition = '';
			}
			$sort_where = '';
			if($sort == 1){
				$sort_where .= ' order by visit desc,a.displayorder desc';
			}elseif($sort == 2){
				$sort_where .= ' order by dolike desc,a.displayorder desc';
			}elseif($sort == 3){
				$sort_where .= ' order by comnum desc,a.displayorder desc';
			}else{
				$sort_where .= ' ORDER BY a.displayorder desc';
			}

			$pindex = max(1, intval($_GPC['page']));//当前第几页
			$psize = 10;//每页几条信息
			if (! empty ( $_GPC ['displayorder'] )) {
				foreach ( $_GPC ['displayorder'] as $id => $displayorder ) {
					pdo_update ( 'jy_onlinemv_video', array ('displayorder' => $displayorder ), array ('id' => $id) );
				}
				message ( '视频排序更新成功！', $this->createWebUrl ( 'store', array ('op' => 'display') ), 'success' );
			}
			$list = pdo_fetchall ( "SELECT a.*,b.id as bid,b.catename FROM " . tablename ( 'jy_onlinemv_video' ) . " a left join ".tablename( 'jy_onlinemv_class' )." b on a.mdcateid=b.id WHERE a.weid = '{$_W['weid']}'".$condition.$sort_where." limit ".($pindex-1)*$psize.",{$psize}");
			foreach($list as $lk => $lv){
				//查看是否是一级分类
				$csql = "SELECT id,parentid FROM ".tablename('jy_onlinemv_class')." WHERE weid='{$weid}' AND id='{$lv['bid']}'";
				$cinfo = pdo_fetch($csql);
				if($cinfo['parentid'] != 0){
					$cpsql = "SELECT id,catename FROM ".tablename('jy_onlinemv_class')." WHERE weid='{$weid}' AND id='{$cinfo['parentid']}'";
					$cpinfo = pdo_fetch($cpsql);
					$list[$lk]['pname'] = $cpinfo['catename'];
				}
			}

			$all_sql = "select count(id) as a from ".tablename('jy_onlinemv_video')." where weid='{$weid}'";
			$abc = pdo_fetch($all_sql);
			$total = $abc['a'];
			$pager = pagination($abc['a'], $pindex, $psize);

			include $this->template ( 'web/store' );
		}elseif ($operation == 'post') {
			$id = intval ( $_GPC ['id'] );
			if (! empty ( $id )) {
				$item = pdo_fetch ( "SELECT * FROM " . tablename ( 'jy_onlinemv_video' ) . " WHERE id = '$id'" );
				$lid_arr = explode(',',$item['lid']);
				foreach($lables as $key1 => $val1){
					if(in_array($val1['id'], $lid_arr)){
						$lables[$key1]['checked'] = "true";
					}else{
						$lables[$key1]['checked'] = "false";
					}
				}
				//衔接其他章节
				$md = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_video_attr')." WHERE weid='{$weid}' AND videoid='{$id}'");
				// $item['thumbs'] = unserialize($item['thumb']);
				$item['thumbs'] = $item['thumb'];
			} else {
				$item = array (
						'displayorder' => 0,
						'enabled' => 1
				);
			}
			if (checksubmit ( 'submit' )) {
				if (empty ( $_GPC ['videoname'] )) {
					message ( '抱歉，请输入视频名称！' );
				}
				$temp = pdo_fetch ( "SELECT id FROM " . tablename ( 'jy_onlinemv_video' ) . " WHERE weid=" . $weid . " AND videoname='" . $_GPC ['videoname'] . "'" );
				if (! empty ( $temp ) && $id != $temp ['id']) {
					message ( '已存在该视频名称！', $this->createWebUrl ( 'store', array ('op' => 'display' ) ), 'error' );
				}
				$lid = implode(',',$_GPC ['lid']);
				// 'thumb' => serialize($_GPC ['thumb']),
				$data = array (
						'weid' => $_W ['weid'],
						'displayorder' => intval ( $_GPC ['displayorder'] ) ,
						'videoname' => $_GPC ['videoname'],
						'lid' => $lid,
						'visit' => $_GPC ['visit'],
						'l_video_address' => $_GPC ['l_video_address'],
						's_video_address' => $_GPC ['s_video_address'],
						'mdcateid' => $_GPC ['mdcateid'],
						'visit' => $_GPC ['visit'],
						'thumb' => $_GPC ['thumb'],
						'logo' => $_GPC ['logo'],
						'remark' => $_GPC ['remark'],
						'details' => $_GPC ['details'],
						'enabled' => intval ( $_GPC ['enabled'] ),
						'isopenm' => intval ( $_GPC ['isopenm'] ),
						'mdwz' => $_GPC ['mdwz'],
						'vprice' => $_GPC ['vprice'],
						'is_charge' => intval ( $_GPC ['is_charge'] ),
						'createtime' => TIMESTAMP
				);
				if (! empty ( $id )) {
					pdo_update ( 'jy_onlinemv_video', $data, array ('id' => $id ) );
				} else {
					pdo_insert ( 'jy_onlinemv_video', $data );
					$id = pdo_insertid ();
				}
				message ( '更新视频成功！', $this->createWebUrl ( 'store', array ('op' => 'display' ) ), 'success' );
			}
			include $this->template ( 'web/store' );
		} elseif ($operation == 'delete') {
			$id = intval ( $_GPC ['id'] );
			$category = pdo_fetch ( "SELECT id FROM " . tablename ( 'jy_onlinemv_video' ) . " WHERE id = '$id'" );
			if (empty ( $category )) {
				message ( '抱歉，视频不存在或是已经被删除！', $this->createWebUrl ( 'store', array ('op' => 'display' ) ), 'error' );
			}
			pdo_delete ( 'jy_onlinemv_video', array ('id' => $id ) );
			message ( '视频删除成功！', $this->createWebUrl ( 'store', array ('op' => 'display' ) ), 'success' );
		}elseif($operation == 'usertore'){
			$id = $_GPC['id'];
			$pindex = max(1, intval($_GPC['page']));//当前第几页
			$psize = 10;//每页几条信息
			$sql = "SELECT distinct(mid),createtime FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND videoid='{$id}' order by id desc limit ".($pindex-1)*$psize.",{$psize}";
			$info = pdo_fetchall($sql);
			foreach($info as $key => $val){
				//用户表
				$usql = "SELECT id,uid FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND id='{$val['mid']}'";
				$uinfo = pdo_fetch($usql);
				//查询头像 昵称
				$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$uinfo['uid']}'";
				$minfo = pdo_fetch($sqls);
				//判断是否分享
				$shsql = "SELECT id FROM ".tablename('jy_onlinemv_share')." WHERE weid='{$weid}' AND userid='{$val['mid']}' AND vid='{$id}'";
				$shinfo = pdo_fetch($shsql);
				if($shinfo){
					$info[$key]['share'] = 1;
				}else{
					$info[$key]['share'] = 0;
				}
				//判断是否点赞
				$isql = "SELECT id FROM ".tablename('jy_onlinemv_interests')." WHERE weid='{$weid}' AND userid='{$val['mid']}' AND vid='{$id}'";
				$ilist = pdo_fetch($isql);
				if($ilist){
					$info[$key]['interest'] = 1;
				}else{
					$info[$key]['interest'] = 0;
				}
				//判断是否评论
				$csql = "SELECT id,content FROM ".tablename('jy_onlinemv_comments')." WHERE weid='{$weid}' AND userid='{$val['mid']}' AND vid='{$id}'";
				$cinfo = pdo_fetch($csql);
				
				if($cinfo){
					$info[$key]['com'] = 1;
					$info[$key]['comid'] = $cinfo['id'];
					$info[$key]['content'] = $cinfo['content'];
				}else{
					$info[$key]['com'] = 0;
					$info[$key]['content'] = '';
				}
				$info[$key]['nickname'] = $minfo['nickname'];
				$info[$key]['avatar'] = $minfo['avatar'];
			}
			
			$all_sql = "select count(id) as a from ".tablename('jy_onlinemv_stat')." where weid='{$weid}' AND videoid='{$id}'";
			$abc = pdo_fetch($all_sql);
			$total = $abc['a'];
			$pager = pagination($abc['a'], $pindex, $psize);
			include $this->template ( 'web/usertore' );
			}
	}

	//视频管理的用户数据
	public function doWebUsertore(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$id = $_GPC['id'];
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = 10;//每页几条信息
		$sql = "SELECT distinct(mid),createtime FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND videoid='{$id}' order by id desc limit ".($pindex-1)*$psize.",{$psize}";
		$info = pdo_fetchall($sql);
		foreach($info as $key => $val){
			//用户表
			$usql = "SELECT id,uid FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND id='{$val['mid']}'";
			$uinfo = pdo_fetch($usql);
			//查询头像 昵称
			$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$uinfo['uid']}'";
			$minfo = pdo_fetch($sqls);
			//判断是否分享
			$shsql = "SELECT id FROM ".tablename('jy_onlinemv_share')." WHERE weid='{$weid}' AND userid='{$val['mid']}' AND vid='{$id}'";
			$shinfo = pdo_fetch($shsql);
			if($shinfo){
				$info[$key]['share'] = 1;
			}else{
				$info[$key]['share'] = 0;
			}
			//判断是否点赞
			$isql = "SELECT id FROM ".tablename('jy_onlinemv_interests')." WHERE weid='{$weid}' AND userid='{$val['mid']}' AND vid='{$id}'";
			$ilist = pdo_fetch($isql);
			if($ilist){
				$info[$key]['interest'] = 1;
			}else{
				$info[$key]['interest'] = 0;
			}
			//判断是否评论
			$csql = "SELECT id,content FROM ".tablename('jy_onlinemv_comments')." WHERE weid='{$weid}' AND userid='{$val['mid']}' AND vid='{$id}'";
			$cinfo = pdo_fetch($csql);
			
			if($cinfo){
				$info[$key]['com'] = 1;
				$info[$key]['comid'] = $cinfo['id'];
				$info[$key]['content'] = $cinfo['content'];
			}else{
				$info[$key]['com'] = 0;
				$info[$key]['content'] = '';
			}
			$info[$key]['nickname'] = $minfo['nickname'];
			$info[$key]['avatar'] = $minfo['avatar'];
		}
		
		$all_sql = "select count(id) as a from ".tablename('jy_onlinemv_stat')." where weid='{$weid}' AND videoid='{$id}'";
		$abc = pdo_fetch($all_sql);
		$total = $abc['a'];
		$pager = pagination($abc['a'], $pindex, $psize);
		include $this->template ( 'web/usertore' );
		// 
	}

	//删除评论
	public function doWebDelcom(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$id = $_GPC['id'];
		$vid = $_GPC['vid'];
		$sql = "SELECT * FROM ".tablename('jy_onlinemv_comments')." WHERE weid='{$weid}' AND id='{$id}'";
		$info = pdo_fetch($sql);
		if (empty ( $info )) {
				message ( '抱歉，评论不存在或是已经被删除！', $this->createWebUrl ( 'usertore', array ('id' => $vid) ), 'error' );
		}
		pdo_delete ( 'jy_onlinemv_comments', array ('id' => $id ) );
		message ( '评论删除成功！', $this->createWebUrl ( 'usertore',array ('id' => $vid) ), 'success' );
	}

	//添加衔接章节
	public function doWebstoremad(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$id = $_GPC['id'];
		$btnc = $_GPC['btnc'];
		$content = $_GPC['content'];
		$url = $_GPC['url'];
		$yureid = ($_GPC['yureid']=='undefined') ? '' : $_GPC['yureid'];

		$data = array(
			'weid'=>$weid,
			'videoid'=>$id,
			'btncon'=>$btnc,
			'content'=>$content,
			'url'=>$url,
			'createtime'=>TIMESTAMP,
			);
		if(!empty($yureid)){
			pdo_update('jy_onlinemv_video_attr',$data,array('weid'=>$weid,'id'=>$yureid));
			$returns = array(
				'status'=>1,
				'yureid'=>$yureid,
				);
		}else{
			pdo_insert('jy_onlinemv_video_attr',$data);
			$insterid = pdo_insertid();
			$returns = array(
				'status'=>1,
				'yureid'=>$insterid,
				);
		}

		echo json_encode($returns);
	}

	//卡密管理
	public function doWebCamilo(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = 20;//每页几条信息
		$sql = "SELECT * FROM ".tablename('jy_onlinemv_camilo')." WHERE weid='{$weid}' limit ".($pindex-1)*$psize.",{$psize}";
		$list = pdo_fetchall($sql);
		$all_sql = "select count(id) as a from ".tablename('jy_onlinemv_camilo')." where weid='{$weid}'";
		$abc = pdo_fetch($all_sql);
		$pager = pagination($abc['a'], $pindex, $psize);
		include $this->template ( 'web/camilo' );
	}

	//导入卡密
	public function doWebImport(){
		global $_W,$_GPC;
	    $weid=$_W['uniacid'];
	    header("Content-Type:text/html;charset=utf-8"); 

        $tmp = $_FILES['file']['tmp_name']; 
        if (empty ($tmp)) { 
            echo '请选择要导入的Excel文件！'; 
            
            exit; 
        } 
        
        $file_types = explode ( ".", $_FILES ['file'] ['name'] );
        $file_type = $file_types [count ( $file_types ) - 1];
        
        if (strtolower ( $file_type ) != "xls")              
        {
            message( '不是Excel文件，重新上传' );
        }
        
        require_once '../framework/library/phpexcel/PHPExcel.php';
        
        $PHPExcel = new PHPExcel(); 
        $Obj = new PHPExcel_Reader_Excel2007();
        
        //为了可以读取所有版本Excel文件
        if(!$Obj->canRead($tmp))
        {						
        	$Obj = new PHPExcel_Reader_Excel5();	
        	if(!$Obj->canRead($tmp))
        	{						
        		echo '未发现Excel文件！';
        		return;
        	}
        }
        
        $Obj->setReadDataOnly(true);
        $phpExcel = $Obj->load($tmp);
        
        
        //获取当前活动sheet
        $objWorksheet = $phpExcel->getActiveSheet();
        //获取行数
        $highestRow = $objWorksheet->getHighestRow();
        //获取列数
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        //循环输出数据 
        $data = array();
        for($row = 1; $row <= $highestRow; ++$row) {
        	$name=$objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
        	$cmprice=$objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
        	
        	$cmname=pdo_fetch("SELECT id FROM ".tablename('jy_onlinemv_camilo')." WHERE weid=$weid AND cmname='".$name."' ");
        	if(empty($cmname))
        	{
        	    $data=array(
        	            'cmname'=>$name,
        	            'cmprice'=>$cmprice,
        	            'weid'=>$weid,
        	            'status'=>0,
        	        );
        	    pdo_insert("jy_onlinemv_camilo",$data);
        	}


        }
        //echo '<pre>';
        message("导入数据成功！",$this->createWebUrl('camilo'),'success');
	}

	public function doWebstoremdel(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$id = $_GPC['id'];
		$yureid = $_GPC['yureid'];
		pdo_delete('jy_onlinemv_video_attr',array('weid'=>$weid,'id'=>$yureid));
		echo 1;
	}

	//首页时间排序
	public function doMobiletindex(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		//pans判断是否已经有记录
		$userinfo = $_SESSION['userinfo'];
		$uid = $userinfo['id'];
		$stat_info = pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$uid}' AND videoid=0 AND classid=0");
		if($stat_info){
			//更新访问记录
			$time = TIMESTAMP;
			$updatesql = "update ".tablename('jy_onlinemv_stat')." set createtime='{$time}' where weid='{$weid}' and id='{$stat_info['id']}'";
			pdo_query($updatesql);
		}else{
			$this->__cull();
		}
		$keyword = $_GPC['keyword'];
		$psize = PSIZE;//每页几条信息
		
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$title = $setting['title'];
		/*获取幻灯片*/
		$sql = "select * from ".tablename('jy_onlinemv_banner')." where weid='{$weid}' and status=1 order by displayorder desc";
		$baners = pdo_fetchall($sql);

		/*获取分类*/
		$sql_type = "select * from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and enabled=1 and parentid=0 and is_index=1 order by displayorder desc limit 0,3";
		$types = pdo_fetchall($sql_type);

		/*获取视频信息*/
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 order by id desc limit 0,{$psize}";
		$stores = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($stores as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
				
			}else{
				$lable_list = array();
			}
			$stores[$key]['lable'] = $lable_list;
		}
		
		//菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC");
		include $this->template('tindex');
	}

	public function doMobileajaxtindex(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$psize = PSIZE;//每页几条信息
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		

		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 order by id desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($stores as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
				
			}else{
				$lable_list = array();
			}
			
			$stores[$key]['lable'] = $lable_list;
		}

		if($stores){
			foreach ($stores as $ke => $va) {
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="point-div"><div class="con"><div class="detail">';
				
				$div .= '<div class="pic" style="margin-top:3px;">';
				if(!$va['logo']){
					if(!$setting['avar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['logo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="130px" height="90px"></div><div class="title">';
				
				$div .= '<h3 class="font-color">';
				$storename =  mb_substr($va['videoname'],0,10,'utf-8');
				$div .= $storename.'</h3>';
				foreach($va['lable'] as $key1 => $val1){
					$div .= '<span style="background-color: '.$setting['color'].';color:#ffffff;padding:1px 3px;border-radius:3px;margin-left:3px;">'.$val1['name'].'</span>';
				}

				$remark =  mb_substr($va['remark'],0,9,'utf-8');
				$div .= '<p class="font-color" style="word-wrap: break-word;word-break:break-all;">简介 '.$remark.'...</p>';
				$div .= '<p class="font-color">'.date('Y-m-d',$va['createtime']).'<img src="'.ONLINEMV_IMAGE.'interest.png" class="interest" id="interest" onclick="inter('.$va['id'].')" />  &nbsp;'.$va['dolike'].'
								<img src="'.ONLINEMV_IMAGE.'comment.png" class="comment" id="comment" />  &nbsp;'.$va['comnum'].'</p></div>';
				
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				
				
				$va['remark']= htmlspecialchars_decode($va['remark']);
				$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
				
				$div .='</div></div></div></div></a>';
			}

			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
		}
		echo json_encode($returns);
	}

	//首页热度排序
	public function doMobilehindex(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		//pans判断是否已经有记录
		$userinfo = $_SESSION['userinfo'];
		$uid = $userinfo['id'];
		$stat_info = pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$uid}' AND videoid=0 AND classid=0");
		if($stat_info){
			//更新访问记录
			$time = TIMESTAMP;
			$updatesql = "update ".tablename('jy_onlinemv_stat')." set createtime='{$time}' where weid='{$weid}' and id='{$stat_info['id']}'";
			pdo_query($updatesql);
		}else{
			$this->__cull();
		}
		$keyword = $_GPC['keyword'];
		$psize = PSIZE;//每页几条信息
		
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$title = $setting['title'];
		/*获取幻灯片*/
		$sql = "select * from ".tablename('jy_onlinemv_banner')." where weid='{$weid}' and status=1 order by displayorder desc";
		$baners = pdo_fetchall($sql);

		/*获取分类*/
		$sql_type = "select * from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and enabled=1 and parentid=0 and is_index=1 order by displayorder desc limit 0,3";
		$types = pdo_fetchall($sql_type);

		/*获取视频信息*/
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 order by dolike desc limit 0,{$psize}";
		$stores = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($stores as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
				
			}else{
				$lable_list = array();
			}
			$stores[$key]['lable'] = $lable_list;
		}
		
		//菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC");
		include $this->template('hindex');
	}

	public function doMobileajaxhindex(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$psize = PSIZE;//每页几条信息
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		

		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 order by dolike desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($stores as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
				
			}else{
				$lable_list = array();
			}
			
			$stores[$key]['lable'] = $lable_list;
		}

		if($stores){
			foreach ($stores as $ke => $va) {
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="point-div"><div class="con"><div class="detail">';
				
				$div .= '<div class="pic" style="margin-top:3px;">';
				if(!$va['logo']){
					if(!$setting['avar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['logo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="130px" height="90px"></div><div class="title">';
				
				$div .= '<h3 class="font-color">';
				$storename =  mb_substr($va['videoname'],0,10,'utf-8');
				$div .= $storename.'</h3>';
				foreach($va['lable'] as $key1 => $val1){
					$div .= '<span style="background-color: '.$setting['color'].';color:#ffffff;padding:1px 3px;border-radius:3px;margin-left:3px;">'.$val1['name'].'</span>';
				}

				$remark =  mb_substr($va['remark'],0,9,'utf-8');
				$div .= '<p class="font-color" style="word-wrap: break-word;word-break:break-all;">简介 '.$remark.'...</p>';
				$div .= '<p class="font-color">'.date('Y-m-d',$va['createtime']).'<img src="'.ONLINEMV_IMAGE.'interest.png" class="interest" id="interest" onclick="inter('.$va['id'].')" />  &nbsp;'.$va['dolike'].'
								<img src="'.ONLINEMV_IMAGE.'comment.png" class="comment" id="comment" />  &nbsp;'.$va['comnum'].'</p></div>';
				
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				
				
				$va['remark']= htmlspecialchars_decode($va['remark']);
				$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
				
				$div .='</div></div></div></div></a>';
			}

			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
		}
		echo json_encode($returns);
	}

	//首页默认排序
	public function doMobiledindex(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		//pans判断是否已经有记录
		$userinfo = $_SESSION['userinfo'];
		$uid = $userinfo['id'];
		$stat_info = pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$uid}' AND videoid=0 AND classid=0");
		if($stat_info){
			//更新访问记录
			$time = TIMESTAMP;
			$updatesql = "update ".tablename('jy_onlinemv_stat')." set createtime='{$time}' where weid='{$weid}' and id='{$stat_info['id']}'";
			pdo_query($updatesql);
		}else{
			$this->__cull();
		}
		// $this->__cull();
		$keyword = $_GPC['keyword'];
		$psize = PSIZE;//每页几条信息
		
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$title = $setting['title'];
		/*获取幻灯片*/
		$sql = "select * from ".tablename('jy_onlinemv_banner')." where weid='{$weid}' and status=1 order by displayorder desc";
		$baners = pdo_fetchall($sql);

		/*获取分类*/
		$sql_type = "select * from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and enabled=1 and parentid=0 and is_index=1 order by displayorder desc limit 0,3";
		$types = pdo_fetchall($sql_type);

		/*获取视频信息*/
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 order by id desc limit 0,{$psize}";
		$stores = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($stores as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
			}else{
				$lable_list = array();
			}
			$stores[$key]['lable'] = $lable_list;
		}
		
		//菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC");
		include $this->template('dindex');
	}

	public function doMobileajaxdindex(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$psize = PSIZE;//每页几条信息
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		

		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 order by id desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($stores as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
			}else{
				$lable_list = array();
			}
			$stores[$key]['lable'] = $lable_list;
		}

		if($stores){
			foreach ($stores as $ke => $va) {
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="point-div"><div class="con"><div class="detail">';
				
				$div .= '<div class="pic" style="margin-top:3px;">';
				if(!$va['logo']){
					if(!$setting['avar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['logo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="130px" height="90px"></div><div class="title">';
				$storename =  mb_substr($va['videoname'],0,10,'utf-8');
				
				$div .= '<h3 class="font-color">';
				$div .= $storename.'</h3>';
				foreach($va['lable'] as $key1 => $val1){
					$div .= '<span style="background-color: '.$setting['color'].';color:#ffffff;padding:1px 3px;border-radius:3px;margin-left:3px;">'.$val1['name'].'</span>';
				}

				$remark =  mb_substr($va['remark'],0,9,'utf-8');
				$div .= '<p class="font-color" style="word-wrap: break-word;word-break:break-all;">简介 '.$remark.'...</p>';
				$div .= '<p class="font-color">'.date('Y-m-d',$va['createtime']).'<img src="'.ONLINEMV_IMAGE.'interest.png" class="interest" id="interest" onclick="inter('.$va['id'].')" />  &nbsp;'.$va['dolike'].'
								<img src="'.ONLINEMV_IMAGE.'comment.png" class="comment" id="comment" />  &nbsp;'.$va['comnum'].'</p></div>';
				
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				
				
				$va['remark']= htmlspecialchars_decode($va['remark']);
				$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
				
				$div .='</div></div></div></div></a>';
			}

			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
		}
		echo json_encode($returns);
	}

	//首页显示
	public function doMobileindex(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		//pans判断是否已经有记录
		$userinfo = $_SESSION['userinfo'];
		$uid = $userinfo['id'];
		$stat_info = pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$uid}' AND videoid=0 AND classid=0");
		if($stat_info){
			//更新访问记录
			$time = TIMESTAMP;
			$updatesql = "update ".tablename('jy_onlinemv_stat')." set createtime='{$time}' where weid='{$weid}' and id='{$stat_info['id']}'";
			pdo_query($updatesql);
		}else{
			$this->__cull();
		}
		
		// $sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$keyword = $_GPC['keyword'];
		$psize = PSIZE;//每页几条信息
		
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$title = $setting['title'];
		/*获取幻灯片*/
		$sql = "select * from ".tablename('jy_onlinemv_banner')." where weid='{$weid}' and status=1 order by displayorder desc";
		$baners = pdo_fetchall($sql);

		/*获取分类*/
		$sql_type = "select * from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and enabled=1 and parentid=0 and is_index=1 order by displayorder desc limit 0,3";
		$types = pdo_fetchall($sql_type);

		/*获取视频信息*/
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 order by displayorder desc limit 0,{$psize}";
		$stores = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($stores as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
			}else{
				$lable_list = array();
			}
			
			$stores[$key]['lable'] = $lable_list;
		}
		
		//菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC");
		include $this->template('index');
	}

	//首页搜索
	public function doMobileSearch(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		// $sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$keyword = $_GPC['keyword'];
		$keyword = str_replace("_", "\_", $keyword);
		$keyword = str_replace("%", "\%", $keyword);
		$psize = PSIZE;//每页几条信息
		
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$title = $setting['title'];
		$keyword = $_GPC['keyword'];
		
		//根据搜索的关键词 查找视频信息
		//是否在标签里面
		$lsql = "SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}' and name like '%".$keyword."%'";
		$linfo = pdo_fetchall($lsql);
		//获取标签ID
		$condition = '';
		foreach($linfo as $key => $val){
			$lid = $val['id'];
			if($lid){
				$condition .= " OR a.lid like '%".$lid."%'";
			}
			
		}
		
		$sql = "SELECT a.*,b.catename FROM ".tablename('jy_onlinemv_video')." as a left join ".tablename('jy_onlinemv_class')." as b on a.mdcateid=b.id WHERE a.weid='{$weid}' AND a.videoname like '%".$keyword."%' OR b.catename like '%".$keyword."%' ".$condition." and a.enabled=1 order by a.displayorder desc limit 0,{$psize}";
		
		$list = pdo_fetchall($sql);
		foreach($list as $key2 => $val2){
			$lid = $val2['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
			}else{
				$lable_list = array();
			}
			
			$list[$key2]['lable'] = $lable_list;
		}
		
		//菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC");
		include $this->template('search');
	}

	public function doMobileajaxsearch(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$psize = PSIZE;//每页几条信息
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$keyword = $_GPC['keyword'];
		$keyword = str_replace("_", "\_", $keyword);
		$keyword = str_replace("%", "\%", $keyword);
		//根据搜索的关键词 查找视频信息
		//是否在标签里面
		$lsql = "SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}' and name like '%".$keyword."%'";
		$linfo = pdo_fetchall($lsql);
		//获取标签ID
		$condition = '';
		foreach($linfo as $key => $val){
			$lid = $val['id'];
			if($lid){
				$condition .= " OR a.lid like '%".$lid."%'";
			}
		}
		
		$sql = "SELECT a.*,b.catename FROM ".tablename('jy_onlinemv_video')." as a left join ".tablename('jy_onlinemv_class')." as b on a.mdcateid=b.id WHERE a.weid='{$weid}' AND a.videoname like '%".$keyword."%' OR b.catename like '%".$keyword."%' ".$condition." and a.enabled=1 order by a.displayorder desc limit ".($pindex-1)*$psize.",{$psize}";
		$list = pdo_fetchall($sql);
		foreach($list as $key2 => $val2){
			$lid = $val2['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
			}else{
				$lable_list = array();
			}
			$list[$key2]['lable'] = $lable_list;
			
		}
		if($list){
			foreach($list as $ke => $va){
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="point-div"><div class="con"><div class="detail">';
				
				$div .= '<div class="pic" style="margin-top:3px;">';
				if(!$va['logo']){
					if(!$setting['avar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['logo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="130px" height="90px"></div><div class="title">';
				$storename =  mb_substr($va['videoname'],0,10,'utf-8');
				
				$div .= '<h3 class="font-color">';
				$div .= $storename.'</h3>';
				foreach($va['lable'] as $key1 => $val1){
					$div .= '<span style="background-color: '.$setting['color'].';color:#ffffff;padding:1px 3px;border-radius:3px;margin-left:3px;">'.$val1['name'].'</span>';
				}

				$remark =  mb_substr($va['remark'],0,9,'utf-8');
				$div .= '<p class="font-color" style="word-wrap: break-word;word-break:break-all;">简介 '.$remark.'...</p>';
				$div .= '<p class="font-color">'.date('Y-m-d',$va['createtime']).'<img src="'.ONLINEMV_IMAGE.'interest.png" class="interest" id="interest" onclick="inter('.$va['id'].')" />  &nbsp;'.$va['dolike'].'
								<img src="'.ONLINEMV_IMAGE.'comment.png" class="comment" id="comment" />  &nbsp;'.$va['comnum'].'</p></div>';
				
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				
				
				$va['remark']= htmlspecialchars_decode($va['remark']);
				$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
				
				$div .='</div></div></div></div></a>';
			}
			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
			);
		}else{
			$returns=array(
				'statue'=>2,
				'msg'=>'已加载全部数据',
				'page'=>$pindex,
			);
		}
		echo json_encode($returns);
	}

	public function doMobileajaxindex(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$psize = PSIZE;//每页几条信息
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		

		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 order by displayorder desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($stores as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
				
			}else{
				$lable_list = array();
			}
			$stores[$key]['lable'] = $lable_list;
		}

		if($stores){
			foreach ($stores as $ke => $va) {
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="point-div"><div class="con"><div class="detail" style="border:none;">';
				
				$div .= '<div class="pic" style="margin-top:3px;">';
				if(!$va['logo']){
					if(!$setting['avar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['logo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="130px" height="90px"></div><div class="title">';
				
				$div .= '<h3 class="font-color">';
				$storename =  mb_substr($va['videoname'],0,10,'utf-8');
				$div .= $storename.'</h3>';
				foreach($va['lable'] as $key1 => $val1){
					$div .= '<span style="background-color: '.$setting['color'].';color:#ffffff;padding:1px 3px;border-radius:3px;margin-left:3px;">'.$val1['name'].'</span>';
				}

				$remark =  mb_substr($va['remark'],0,9,'utf-8');
				$div .= '<p class="font-color" style="word-wrap: break-word;word-break:break-all;">简介 '.$remark.'...</p>';
				$div .= '<p class="font-color">'.date('Y-m-d',$va['createtime']).'<img src="'.ONLINEMV_IMAGE.'interest.png" class="interest" id="interest" onclick="inter('.$va['id'].')" />  &nbsp;'.$va['dolike'].'
								<img src="'.ONLINEMV_IMAGE.'comment.png" class="comment" id="comment" />  &nbsp;'.$va['comnum'].'</p></div>';
				
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				
				
				$va['remark']= htmlspecialchars_decode($va['remark']);
				$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
				
				$div .='</div></div></div></div></a>';
			}

			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
		}
		echo json_encode($returns);
	}

	//分类视频
	public function doMobilelist(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$id = $_GPC['pid'];
		//pans判断是否已经有记录
		$userinfo = $_SESSION['userinfo'];
		$uid = $userinfo['id'];
		$stat_info = pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$uid}' AND videoid=0 AND classid='{$id}'");
		if($stat_info){
			//更新访问记录
			$time = TIMESTAMP;
			$updatesql = "update ".tablename('jy_onlinemv_stat')." set createtime='{$time}' where weid='{$weid}' and id='{$stat_info['id']}'";
			pdo_query($updatesql);
		}else{
			$this->__cull();
			$updatesql = "update ".tablename('jy_onlinemv_stat')." set classid='{$id}' where weid='{$weid}' and id='{$_SESSION['statid']}'";
			pdo_query($updatesql);
		}
		// $this->__cull();
		$do = $_GPC['do'];
		//$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = PSIZE;//每页几条信息
		//$act = "dis";
		

		$update = "update ".tablename('jy_onlinemv_class')." set visit = visit+1 where weid='{$weid}' and id='{$id}'";
		pdo_query($update);
		/*获取分类信息*/
		$sql = "select id,catename,thumb from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and id='{$id}'";
		$class = pdo_fetch($sql);
		$title = $class['catename'];
		//子分类
		$children = array();
		if(!empty($class)){
			$parentid = $class['id'];
			$csql = "select id,catename,thumb,icon from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and parentid='{$parentid}' order by displayorder desc";
			$children = pdo_fetchall($csql);
		}
		$condition = '';
		foreach($children as $key1 => $val1){
			$condition .= ' or mdcateid = '.$val1['id'];
		}
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//获取视频信息
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 and mdcateid='{$id}'".$condition." order by displayorder desc limit 0,{$psize}";
		$storess = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($storess as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
				
			}else{
				$lable_list = array();
			}
			
			$storess[$key]['lable'] = $lable_list;
		}
		//更新访问记录
		//$updatesql = "update ".tablename('jy_onlinemv_stat')." set classid='{$id}' where weid='{$weid}' and id='{$_SESSION['statid']}'";
		//pdo_query($updatesql);
		//底部菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$newarr = array();
		
		foreach ($storess as $key => $value) {
			if($t<$psize){
				$new[]=$value;
				$t++;
			}else{
				break;
			}
		}
		$stores=$new;
		include $this->template('type');
	}

	//
	public function doMobileajaxlist(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$do = $_GPC['do'];
		//$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		//$pindex = 2;//当前第几页
		$psize = PSIZE;//每页几条信息
		$id = $_GPC['pid'];

		/*获取分类信息*/
		$sql = "select id,catename,thumb from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and id='{$id}'";
		$class = pdo_fetch($sql);
		$title = $class['catename'];
		//子分类
		$children = array();
		if(!empty($class)){
			$parentid = $class['id'];
			$csql = "select id,catename,thumb,icon from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and parentid='{$parentid}' order by displayorder desc";
			$children = pdo_fetchall($csql);
		}
		$condition = '';
		foreach($children as $key1 => $val1){
			$condition .= ' or mdcateid = '.$val1['id'];
		}
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//获取视频信息
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 and mdcateid='{$id}'".$condition." order by displayorder desc limit ".($pindex-1)*$psize.",{$psize}";
		$storess = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($storess as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
				
			}else{
				$lable_list = array();
			}
			$storess[$key]['lable'] = $lable_list;
		}
		// var_dump($storess);exit;
		//底部菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");

		if($storess){
			foreach ($storess as $ke => $va) {
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="point-div"><div class="con"><div class="detail">';
				
				$div .= '<div class="pic" style="margin-top:3px;">';
				if(!$va['logo']){
					if(!$setting['avar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['logo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="130px" height="90px"></div><div class="title">';
				
				$div .= '<h3 class="font-color">';
				$storename =  mb_substr($va['videoname'],0,10,'utf-8');
				$div .= $storename.'</h3>';
				foreach($va['lable'] as $key1 => $val1){
					$div .= '<span style="background-color: '.$setting['color'].';color:#ffffff;padding:1px 3px;">'.$val1['name'].'</span>';
				}

				$remark =  mb_substr($va['remark'],0,9,'utf-8');
				$div .= '<p class="font-color" style="word-wrap: break-word;word-break:break-all;">简介 '.$remark.'...</p>';
				$div .= '<p class="font-color">'.date('Y-m-d',$va['createtime']).'<img src="'.ONLINEMV_IMAGE.'interest.png" class="interest" id="interest" onclick="inter('.$va['id'].')" />  &nbsp;'.$va['dolike'].'
								<img src="'.ONLINEMV_IMAGE.'comment.png" class="comment" id="comment" />  &nbsp;'.$va['comnum'].'</p></div>';
				
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				
				
				$va['remark']= htmlspecialchars_decode($va['remark']);
				$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
				
				$div .='</div></div></div></div></a>';
			}
			
			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
				'statue'=>2,
				'msg'=>'已加载全部数据',
				'page'=>$pindex,
				);
		}
		echo json_encode($returns);
		
	}

	//子分类视频列表
	public function doMobileclist(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		//pans判断是否已经有记录
		$id = $_GPC['cid'];
		$userinfo = $_SESSION['userinfo'];
		$uid = $userinfo['id'];
		$stat_info = pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$uid}' AND classid='{$id}' AND videoid=0");
		if($stat_info){
			//更新访问记录
			$time = TIMESTAMP;
			$updatesql = "update ".tablename('jy_onlinemv_stat')." set createtime='{$time}' where weid='{$weid}' and id='{$stat_info['id']}'";
			pdo_query($updatesql);
		}else{
			$this->__cull();
			$updatesql = "update ".tablename('jy_onlinemv_stat')." set classid='{$id}' where weid='{$weid}' and id='{$_SESSION['statid']}'";
			pdo_query($updatesql);
		}
		// $this->__cull();
		$do = $_GPC['do'];
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = PSIZE;//每页几条信息
		$act = "dis";
		
		$update = "update ".tablename('jy_onlinemv_class')." set visit = visit+1 where weid='{$weid}' and id='{$id}'";
		pdo_query($update);
		/*获取分类信息*/
		$sql = "select id,catename,thumb from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and id='{$id}' order by displayorder desc";
		$class = pdo_fetch($sql);

		
		$title = $class['catename'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//视频信息
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 and mdcateid='{$id}' order by displayorder desc";
		$storess = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($storess as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
				
			}else{
				$lable_list = array();
			}
			
			$storess[$key]['lable'] = $lable_list;
		}
		//更新访问记录
		
		//底部菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		
		foreach ($storess as $key => $value) {
			if($t<$psize){
				$new[]=$value;
				$t++;
			}else{
				break;
			}
		}
		$stores=$new;
		include $this->template('ctype');
	}

	//子分类页面的ajax加载
	public function doMobileajaxclist(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$do = $_GPC['do'];
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = PSIZE;//每页几条信息
		$act = "dis";
		$id = $_GPC['cid'];
		
		/*获取分类信息*/
		$sql = "select id,catename,thumb from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and id='{$id}' order by displayorder desc";
		$class = pdo_fetch($sql);

		
		$title = $class['catename'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//视频信息
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 and mdcateid='{$id}' order by displayorder desc";
		$storess = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		$lable_name = array();
		foreach($storess as $key => $val){
			$lid = $val['lid'];
			$l_where = '';
			if($lid){
				$l_where = " AND id in (".$lid.")";
				$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
			}else{
				$lable_list = array();
			}
			$storess[$key]['lable'] = $lable_list;
		}
		
		//底部菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		
		if($stores){
			foreach ($storess as $ke => $va) {
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="point-div"><div class="con"><div class="detail">';
				
				$div .= '<div class="pic" style="margin-top:3px;">';
				if(!$va['logo']){
					if(!$setting['avar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['logo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="130px" height="90px"></div><div class="title">';
				
				$div .= '<h3 class="font-color">';
				$storename =  mb_substr($va['videoname'],0,10,'utf-8');
				$div .= $storename.'</h3>';
				foreach($va['lable'] as $key1 => $val1){
					$div .= '<span style="background-color: '.$setting['color'].';color:#ffffff;padding:1px 3px;">'.$val1['name'].'</span>';
				}

				$remark =  mb_substr($va['remark'],0,9,'utf-8');
				$div .= '<p class="font-color" style="word-wrap: break-word;word-break:break-all;">简介 '.$remark.'...</p>';
				$div .= '<p class="font-color">'.date('Y-m-d',$va['createtime']).'<img src="'.ONLINEMV_IMAGE.'interest.png" class="interest" id="interest" onclick="inter('.$va['id'].')" />  &nbsp;'.$va['dolike'].'
								<img src="'.ONLINEMV_IMAGE.'comment.png" class="comment" id="comment" />  &nbsp;'.$va['comnum'].'</p></div>';
				
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				
				
				$va['remark']= htmlspecialchars_decode($va['remark']);
				$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
				
				$div .='</div></div></div></div></a>';
			}
			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
				'statue'=>2,
				'msg'=>'已加载全部数据',
				'page'=>$pindex,
				);
		}
		echo json_encode($returns);
		
	}
	//点赞
	public function doMobileSetinterest(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$vid = intval($_GPC['vid']);
		//获取用户信息
		$openid = $_W['openid'];
		$osql = "SELECT * FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'";
		$user_info = pdo_fetch($osql);
		$userid = $user_info['id'];
		//先判断是否有点赞记录
		$sql = "SELECT * FROM ".tablename('jy_onlinemv_interests')." WHERE weid='{$weid}' AND vid='{$vid}' AND userid='{$userid}'";
		$list = pdo_fetchall($sql);
		if($list){
			$returns=array(
				'statue'=>2,
			);
		}else{
			//将点赞记录存入数据表
			$data = array(
				'weid'=>$weid,
				'userid'=>$userid,
				'vid'=>$vid,
				'createtime'=>TIMESTAMP,
			);
			pdo_insert('jy_onlinemv_interests', $data);
		    $id = pdo_insertid();
		    //更新视频访问量
			$update = "update ".tablename('jy_onlinemv_video')." set dolike = dolike+1 where weid='{$weid}' and id='{$vid}'";
			pdo_query($update);
		    $csql = "SELECT id,dolike FROM ".tablename('jy_onlinemv_video')." WHERE weid='{$weid}' AND id='{$vid}'";
		    $cinfo = pdo_fetch($csql);
		    $cnum = $cinfo['dolike'];
			$returns=array(
				'statue'=>1,
				'number'=>$cnum,
			);
		}
		
		echo json_encode($returns);
	}

	//发布评论
	public function doMobileSetcomment(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$vid = intval($_GPC['vid']);
		$message = $_GPC['umess'];
		//获取用户信息
		$openid = $_W['openid'];
		$osql = "SELECT * FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'";
		$user_info = pdo_fetch($osql);
		$userid = $user_info['id'];
		
		//将点赞记录存入数据表
		$data = array(
			'weid'=>$weid,
			'userid'=>$userid,
			'vid'=>$vid,
			'content'=>$message,
			'createtime'=>TIMESTAMP,
		);
		pdo_insert('jy_onlinemv_comments', $data);
	    $pid = pdo_insertid();
	    //
	    //查询头像 昵称
		$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$user_info['uid']}'";
		$minfo = pdo_fetch($sqls);
		$div .= '<div class="point-div" style="margin:1px 0px;padding:20px 5%;"><div class="con"><div class="detail">';
		$div .= '<div class="pic">';
		if(!$minfo['avatar']){
			$logo=ONLINEMV_IMAGE.'123.png';
		}else{
			$logo=$minfo['avatar'];
		}
		$div .= '<img src="'.tomedia($logo).'" width="110px" height="110px"></div><div class="title" style="margin-left:0%;max-width:54%;">';
		
		$div .= '<p class="font-color">';
		$nickname =  mb_substr($minfo['nickname'],0,10,'utf-8');
		$div .= $nickname.'</p>';
		$div .= '<p class="font-color">刚刚</p>';

		$content =  mb_substr($message,0,20,'utf-8');
		$div .= '<p class="font-color" style="word-wrap: break-word;word-break:break-all;">'.$content.'</p>';
		
		if(!$setting['color']){
			$color="#fff";
			$fontcolor='';
		}else{
			$color=$setting['color'];
			$fontcolor='color:#000;';
		} 
		
		$div .='</div></div></div></div></a>';
	    //更新视频访问量
		$update = "update ".tablename('jy_onlinemv_video')." set comnum = comnum+1 where weid='{$weid}' and id='{$vid}'";
		pdo_query($update);
	    $csql = "SELECT id,comnum FROM ".tablename('jy_onlinemv_video')." WHERE weid='{$weid}' AND id='{$vid}'";
	    $cinfo = pdo_fetch($csql);
	    $cnum = $cinfo['comnum'];
		
		$returns=array(
			'statue'=>1,
			'number'=>$cnum,
			'data'=>$div,
		);

		echo json_encode($returns);
	}

	//分享
	public function doMobileajaxshare(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$vid = intval($_GPC['vid']);
		//获取用户信息
		$openid = $_W['openid'];
		$osql = "SELECT * FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'";
		$user_info = pdo_fetch($osql);
		$userid = $user_info['id'];
		//
		$data = array(
				'weid'=>$weid,
				'vid'=>$vid,
				'userid'=>$userid,
				'createtime'=>TIMESTAMP,
		);
		$sqls = "SELECT id FROM ".tablename('jy_onlinemv_share')." WHERE weid='{$weid}' AND userid='{$userid}' AND vid='{$vid}'";
		$list = pdo_fetch($sqls);
		if($list){
			pdo_update('jy_onlinemv_share',$data,array('id'=>$list['id']));
		}else{
			//将分享记录记入数据表中
			pdo_insert('jy_onlinemv_share', $data);
		    $pid = pdo_insertid();
		}
		
	    //更新视频分享量
		$update = "update ".tablename('jy_onlinemv_video')." set share = share+1 where weid='{$weid}' and id='{$vid}'";
		pdo_query($update);
	    $csql = "SELECT id,share FROM ".tablename('jy_onlinemv_video')." WHERE weid='{$weid}' AND id='{$vid}'";
	    $cinfo = pdo_fetch($csql);
	    $cnum = $cinfo['share'];

	    $returns=array(
			'statue'=>1,
			'number'=>$cnum,
		);

		echo json_encode($returns);
	}

	//购买视频
	public function doMobilebuyvideo(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$id = $_GPC['vid'];
		$buy = $_GPC['vdo'];
		$sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and id='{$id}'";
		$infos = pdo_fetch($sql);
		//获取用户信息
		$openid = $_W['openid'];
		$osql = "SELECT * FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'";
		$user_info = pdo_fetch($osql);
		//判断是否购买
		if($buy == 'buy'){
			if($user_info['number'] >0){
				$user_data = array(
					'number'=> $user_info['number'] - 1,
					'total'=>$user_info['total'] + 1,
				);
				pdo_update('jy_onlinemv_user',$user_data,array('id'=>$user_info['id']));
				$order_data = array(
					'weid'=>$weid,
					'classid'=>$infos['mdcateid'],
					'videoid'=>$infos['id'],
					'userid'=>$user_info['id'],
					'createtime'=>TIMESTAMP,
				);
				pdo_insert('jy_onlinemv_order', $order_data);
				$oid = pdo_insertid();
				$returns=array(
					'statue'=>1,
					'msg'=>'购买成功',
				);
			}else{
				$returns=array(
					'statue'=>2,
					'msg'=>'抱歉,您的视频购买次数已用完,请先充值',
				);
				// message('抱歉,您的视频购买次数已用完,请先充值',$this->createMobileUrl('topmember',array('id'=>$infos['id'])),'error');
			}
			// $member = 1;
		}
		echo json_encode($returns);
	}

	public function doMobileshowDetail(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$id = $_GPC['id'];
		$buy = $_GPC['buy'];
		$sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and id='{$id}'";
		$infos = pdo_fetch($sql);
		//获取用户信息
		$openid = $_W['openid'];
		$osql = "SELECT * FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'";
		$user_info = pdo_fetch($osql);
		
		// $this->__cull();
		$psize = PSIZE;
		
		//更新视频访问量
		$update = "update ".tablename('jy_onlinemv_video')." set visit = visit+1 where weid='{$weid}' and id='{$id}'";
		pdo_query($update);
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//判断是否购买
		if($buy == 'buy'){
			if($user_info['number'] >0){
				$user_data = array(
					'number'=> $user_info['number'] - 1,
					'total'=>$user_info['total'] + 1,
				);
				pdo_update('jy_onlinemv_user',$user_data,array('id'=>$user_info['id']));
				$order_data = array(
					'weid'=>$weid,
					'classid'=>$infos['mdcateid'],
					'videoid'=>$infos['id'],
					'userid'=>$user_info['id'],
					'paytype'=>4,
					'paymethod'=>3,
					'paystat'=>1,
					'createtime'=>TIMESTAMP,
				);
				pdo_insert('jy_onlinemv_order', $order_data);
				$oid = pdo_insertid();
			}else{
				message('抱歉,您的视频购买次数已用完,请先充值',$this->createMobileUrl('topmember',array('id'=>$infos['id'])),'error');
			}
			// $member = 1;
		}
		// $dat = date('Y-m-d','2451491200');
		// var_dump($dat);exit;
		
		//获取购买视频的信息
		$userid = $user_info['id'];
		$order_sql = "SELECT * FROM ".tablename('jy_onlinemv_order')." WHERE weid='{$weid}' AND userid='{$userid}' AND videoid='{$id}' AND paystat=1";
		$order_list = pdo_fetch($order_sql);
		
		//判断是否是会员  是否在有效期 是否还有观影次数
		//当天的时间戳
		/* 
		$member 0:不是会员或者需要购买了  1:是会员且已购买视频 2:是会员但是没有购买会员
		*/
		
		//获取购买视频的信息
		// $userid = $user_info['id'];
		// $order_sql = "SELECT * FROM ".tablename('jy_onlinemv_order')." WHERE weid='{$weid}' AND userid='{$userid}' AND videoid='{$id}'";
		// $order_list = pdo_fetch($order_sql);
		
		//判断是否是会员  是否在有效期 是否还有观影次数
		//当天的时间戳
		
		$now = strtotime(date('Y-m-d 00:00:00',time()));
		if($user_info['paytype'] == 1 && $user_info['validity'] > $now){
			$member = 1;
		}elseif($user_info['paytype'] == 2 && $user_info['validity'] > $now){
			$member = 1;
		}elseif(!empty($order_list)){
			$member = 1;
		}elseif($user_info['paytype'] == 3 && empty($order_list)){
			$member = 0;
		}elseif($user_info['paytype'] == 4 && $user_info['number'] > 0 && $user_info['validity'] > $now && empty($order_list)){
			$member = 2;
		}else{
			$member = 0;
		}
		// if($user_info['is_member'] == 0 && $user_info['number'] == 0 || $user_info['validity'] < $now){
		// 	$member = 0;
		// }elseif($user_info['is_member'] == 1 && $user_info['validity'] > $now && !empty($order_list)){
		// 	$member = 1;
		// }elseif($user_info['is_member'] == 1 && $user_info['number'] > 0 && $user_info['validity'] > $now && empty($order_list)){
		// 	$member = 2;
		// }else{
		// 	$member = 0;
		// }
		
		//底部菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");

		
		//判断是否已赞
		$visql = "SELECT id FROM ".tablename('jy_onlinemv_interests')." WHERE weid='{$weid}' AND vid='{$id}' AND userid='{$userid}'";
		$vilist = pdo_fetch($visql);
		if($vilist){
			$dolike = 1;
		}else{
			$dolike = 0;
		}
		//该视频的标签信息
		$lid = $infos['lid'];
		if($lid){
			$lsql = "SELECT id,name FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}' AND id in ({$lid})";
		}else{
			$lsql = "SELECT id,name FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'";
		}
		
		$linfo = pdo_fetchall($lsql);
		//该视频的关联视频信息
		$vasql = "SELECT id,btncon,content,url FROM ".tablename('jy_onlinemv_video_attr')." WHERE weid='{$weid}' AND videoid='{$id}' order by id desc";
		$valist = pdo_fetchall($vasql);
		//该视频的评论信息
		$vcsql = "SELECT id,userid,content,createtime FROM ".tablename('jy_onlinemv_comments')." WHERE weid='{$weid}' AND vid='{$id}' order by id desc limit 0,{$psize}";
		$vclist = pdo_fetchall($vcsql);
		foreach($vclist as $key => $val){
			//用户表
			$usql = "SELECT id,uid FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND id='{$val['userid']}'";
			$uinfo = pdo_fetch($usql);
			//查询头像 昵称
			$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$uinfo['uid']}'";
			$minfo = pdo_fetch($sqls);
			$vclist[$key]['nickname'] = $minfo['nickname'];
			$vclist[$key]['avatar'] = $minfo['avatar'];

			$difference = time() - $val['createtime'];
			$day = round($difference/3600/24);
			// var_dump($day);
			if($day == 0){
				// $ctime = round($difference/3600);
				$remain = $difference % 86400;
				if($remain >= 60){
					$secs = $remain / 60;
					$mins = intval( $remain / 60 );
					if($mins >= 60){
						$hours = intval( $remain / 3600 );
						$vclist[$key]['release'] = 3;
						$vclist[$key]['releasetime'] = $hours;
					}else{
						$vclist[$key]['release'] = 2;
						$vclist[$key]['releasetime'] = $mins;
					}
				}else{
					$vclist[$key]['release'] = 1;
				}
				
			}else{
				$vclist[$key]['release'] = 0;
			}
		}
		// var_dump($vclist);exit;
		// exit;
		//免费视频
		if($infos['is_charge'] == 0){
			$member = 3;
		}
		// $infos['thumb'] = unserialize($infos['thumb']);
		$infos['thumb'] = $infos['thumb'];
		//对链接进行处理
		//判断选择的存储类型
		if($setting['type'] ==1){
			if($member == 1 || $member == 3){
				$ak = $setting['ak'];
				$sk = $setting['sk'];
				$auth = new Auth($ak,$sk);
				$baseUrl = $infos['l_video_address'];
				$authUrl = $auth->privateDownloadUrl($baseUrl);
				   
			}else{
				$ak = $setting['ak'];
				$sk = $setting['sk'];
				$auth = new Auth($ak,$sk);
				$baseUrl = $infos['s_video_address'];
				$authUrl = $auth->privateDownloadUrl($baseUrl);
			}
		}
		
		$title=$infos['videoname'];
		$typename = pdo_fetch("select catename from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and id='{$infos['mdcateid']}'");
		// $updatesql = "update ".tablename('jy_onlinemv_stat')." set videoid='{$id}',classid='{$infos['mdcateid']}' where weid='{$weid}' and id='{$_SESSION['statid']}'";
		// pdo_query($updatesql);
		//pans判断是否已经有记录
		$userinfo = $_SESSION['userinfo'];
		$uid = $userinfo['id'];
		$stat_info = pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$uid}' AND videoid='{$id}' AND classid={$infos['mdcateid']}");
		if($stat_info){
			//更新访问记录
			$time = TIMESTAMP;
			$updatesql = "update ".tablename('jy_onlinemv_stat')." set createtime='{$time}' where weid='{$weid}' and id='{$stat_info['id']}'";
			pdo_query($updatesql);
		}else{
			$this->__cull();
			$updatesql = "update ".tablename('jy_onlinemv_stat')." set videoid='{$id}',classid='{$infos['mdcateid']}' where weid='{$weid}' and id='{$_SESSION['statid']}'";
			pdo_query($updatesql);
		}
		
		include $this->template('showdetail');
		
	}

	//ajax加载视频评论
	public function doMobileajaxvmess(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$vid = $_GPC['vid'];
		$psize = PSIZE;//每页几条信息
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		

		$stores_sql = "select id,userid,content,createtime from ".tablename('jy_onlinemv_comments')." where weid='{$weid}' and vid='{$vid}' order by id desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);
		foreach($stores as $key => $val){
			//用户表
			$usql = "SELECT id,uid FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND id='{$val['userid']}'";
			$uinfo = pdo_fetch($usql);
			//查询头像 昵称
			$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$uinfo['uid']}'";
			$minfo = pdo_fetch($sqls);
			$stores[$key]['nickname'] = $minfo['nickname'];
			$stores[$key]['avatar'] = $minfo['avatar'];

			$difference = time() - $val['createtime'];
			$day = round($difference/3600/24);
			// var_dump($day);
			if($day == 0){
				// $ctime = round($difference/3600);
				$remain = $difference % 86400;
				if($remain >= 60){
					$secs = $remain / 60;
					$mins = intval( $remain / 60 );
					if($mins >= 60){
						$hours = intval( $remain / 3600 );
						$stores[$key]['release'] = 3;
						$stores[$key]['releasetime'] = $hours;
					}else{
						$stores[$key]['release'] = 2;
						$stores[$key]['releasetime'] = $mins;
					}
				}else{
					$stores[$key]['release'] = 1;
				}
				
			}else{
				$stores[$key]['release'] = 0;
			}
		}

		if($stores){
			foreach ($stores as $ke => $va) {
				$div .= '<div class="point-div" style="margin:1px 0px;padding:20px 5%;"><div class="con"><div class="detail">';
				$div .= '<div class="pic">';
				if(!$va['avatar']){
					if(!$setting['avatar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avatar'];
					}
				}else{
					$logo=$va['avatar'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="110px" height="110px"></div><div class="title" style="margin-left:0%;max-width:54%;">';
				
				$div .= '<p class="font-color">';
				$nickname =  mb_substr($va['nickname'],0,10,'utf-8');
				$div .= $nickname.'</p>';
				if($va['release'] == 0){
					$div .= '<p class="font-color">'.date('Y-m-d H:i:s',$va['createtime']).'</p>';
				}elseif($va['release'] == 1){
					$div .= '<p class="font-color">刚刚</p>';
				}elseif($va['release'] == 2){
					$div .= '<p class="font-color">'.$va['releasetime'].'分钟前</p>';
				}elseif($va['release'] == 3){
					$div .= '<p class="font-color">'.$va['releasetime'].'小时前</p>';
				}else{
					$div .= '<p class="font-color">'.date('Y-m-d H:i:s',$va['createtime']).'</p>';
				}
				

				$content =  mb_substr($va['content'],0,20,'utf-8');
				$div .= '<p class="font-color" style="word-wrap: break-word;word-break:break-all;">'.$content.'</p>';
				
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				} 
				
				$div .='</div></div></div></div></a>';
			}

			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
		}
		echo json_encode($returns);
	}

	public function doMobileVideo(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$id = $_GPC['id'];
		$buy = $_GPC['buy'];
		//视频信息
		$sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and id='{$id}'";
		$infos = pdo_fetch($sql);
		//获取用户信息
		$openid = $_W['openid'];
		$osql = "SELECT * FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'";
		$user_info = pdo_fetch($osql);
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//判断是否购买
		if($buy == 'buy'){
			if($user_info['number'] >0){
				$user_data = array(
					'number'=> $user_info['number'] - 1,
					'total'=>$user_info['total'] + 1,
				);
				pdo_update('jy_onlinemv_user',$user_data,array('id'=>$user_info['id']));
				$order_data = array(
					'weid'=>$weid,
					'classid'=>$infos['mdcateid'],
					'videoid'=>$infos['id'],
					'userid'=>$user_info['id'],
					'createtime'=>TIMESTAMP,
				);
				pdo_insert('jy_onlinemv_order', $order_data);
				$oid = pdo_insertid();
			}else{
				message('抱歉,您的视频购买次数已用完,请先充值',$this->createMobileUrl('topmember',array('id'=>$infos['id'])),'error');
			}
			// $member = 1;
		}
		//获取购买视频的信息
		$userid = $user_info['id'];
		$order_sql = "SELECT * FROM ".tablename('jy_onlinemv_order')." WHERE weid='{$weid}' AND userid='{$userid}' AND videoid='{$id}'";
		$order_list = pdo_fetch($order_sql);
		
		//判断是否是会员  是否在有效期 是否还有观影次数
		//当天的时间戳
		
		$now = strtotime(date('Y-m-d 00:00:00',time()));
		if($user_info['paytype'] == 1 && $user_info['validity'] > $now){
			$member = 1;
		}elseif($user_info['paytype'] == 2 && $user_info['validity'] > $now){
			$member = 1;
		}elseif(!empty($order_list)){
			$member = 1;
		}elseif($user_info['paytype'] == 3 && empty($order_list)){
			$member = 0;
		}elseif($user_info['paytype'] == 4 && $user_info['number'] > 0 && $user_info['validity'] > $now && empty($order_list)){
			$member = 2;
		}else{
			$member = 0;
		}
		// if($user_info['is_member'] == 0 && $user_info['number'] == 0 || $user_info['validity'] < $now){
		// 	$member = 0;
		// }elseif($user_info['is_member'] == 1 && $user_info['validity'] > $now && !empty($order_list)){
		// 	$member = 1;
		// }elseif($user_info['is_member'] == 1 && $user_info['number'] > 0 && $user_info['validity'] > $now && empty($order_list)){
		// 	$member = 2;
		// }else{
		// 	$member = 0;
		// }
		
		if($infos['is_charge'] == 0){
			$member = 3;
		}
		$infos['thumb'] = unserialize($infos['thumb']);
		
		if($setting['type'] == 1){
			//对链接进行处理
			if($member == 1 || $member == 3){
				$ak = $setting['ak'];
				$sk = $setting['sk'];
				$auth = new Auth($ak,$sk);
				$baseUrl = $infos['l_video_address'];
				$authUrl = $auth->privateDownloadUrl($baseUrl);
				   
			}else{
				$ak = $setting['ak'];
				$sk = $setting['sk'];
				$auth = new Auth($ak,$sk);
				$baseUrl = $infos['s_video_address'];
				$sauthUrl = $auth->privateDownloadUrl($baseUrl);
			}
		}
		
		
		$title=$infos['videoname'];
		include $this->template('video');
	}

	//视频试看页面
	public function doMobileProved(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$id = $_GPC['id'];
		
		//获取用户信息
		$openid = $_W['openid'];
		$osql = "SELECT * FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'";
		$user_info = pdo_fetch($osql);
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//获取购买视频的信息
		$userid = $user_info['id'];
		$order_sql = "SELECT * FROM ".tablename('jy_onlinemv_order')." WHERE weid='{$weid}' AND userid='{$userid}' AND videoid='{$id}'";
		$order_list = pdo_fetch($order_sql);
		//判断是否是会员  是否在有效期 是否还有观影次数
		//当天的时间戳
		
		// $now = strtotime(date('Y-m-d 00:00:00',time()));
		// if($user_info['is_member'] == 0 && $user_info['number'] == 0 || $user_info['validity'] < $now){
		// 	$member = 0;
		// }elseif($user_info['is_member'] == 1 && $user_info['number'] > 0 && $user_info['validity'] > $now && !empty($order_list)){
		// 	$member = 1;
		// }elseif($user_info['is_member'] == 1 && $user_info['number'] > 0 && $user_info['validity'] > $now && empty($order_list)){
		// 	$member = 2;
		// }elseif($user_info['is_member'] == 1 && $user_info['validity'] > $now && !empty($order_list)){
		// 	$member = 1;
		// }else{
		// 	$member = 0;
		// }

		$sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and id='{$id}'";
		$infos = pdo_fetch($sql);
		$infos['thumb'] = unserialize($infos['thumb']);
		//对链接进行处理
		if($setting['type'] == 1){
			$ak = $setting['ak'];
			$sk = $setting['sk'];
			$auth = new Auth($ak,$sk);
			$baseUrl = $infos['s_video_address'];
			$authUrl = $auth->privateDownloadUrl($baseUrl);
		}
		
		$title=$infos['videoname'];
		include $this->template('proved');
	}
	

	//个人中心
	public function doMobileGeren() {
		//个人中心
		global $_W,$_GPC;
		$weid=$_W['uniacid'];

		$this->_Auth();
		$this->__douser();
		$weixin=$_SESSION['weixin'];

		$uid=$_SESSION['uid'];
		$from_user=$_SESSION['jy_openid'];
		// /*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		// $sitem=pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_setting')." WHERE weid=".$weid);
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");

		$member=pdo_fetch("SELECT a.id,a.validity,a.number,b.avatar,b.nickname FROM ".tablename('jy_onlinemv_user')." as a left join ".tablename('mc_members')." as b on a.uid=b.uid WHERE a.weid=".$weid." AND a.uid=".$uid);
		
		if(!empty($member)){
			$id = $member['id'];
			$sql_a = "select count(distinct(videoid)) as b from ".tablename('jy_onlinemv_stat')." where weid='{$weid}' and mid='{$id}' and videoid != 0";
			$abc = pdo_fetch($sql_a);
			$sql_f = "select count(distinct(classid)) as b from ".tablename('jy_onlinemv_stat')." where weid='{$weid}' and mid='{$id}' and classid != 0";
			$af = pdo_fetch($sql_f);
		}
		
		
		$title="个人中心";
		include $this->template('geren');
	}

	//绑定个人信息
	public function doMobileFile() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];

		$this->_Auth();
		$this->__douser();
		$weixin=$_SESSION['weixin'];
		$uid=$_SESSION['uid'];
		$from_user=$_SESSION['jy_openid'];

		$sitem=pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_setting')." WHERE weid=".$weid);

		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$member=pdo_fetch("SELECT id,mobile,realname FROM ".tablename('jy_onlinemv_user')." WHERE weid=".$weid." AND uid=".$uid);
		if($sitem['sync']==1 && empty($member['mobile']) && empty($member['realname']))
		{
			$sync_member=pdo_fetch("SELECT realname,mobile FROM ".tablename('mc_members')." WHERE uniacid=".$weid." AND uid=".$uid);
			if(!empty($sync_member['mobile']) && !empty($sync_member['realname']))
			{
				pdo_update('jy_onlinemv_user',array('mobile'=>$sync_member['mobile'],'realname'=>$sync_member['realname']),array('uid'=>$uid,'weid'=>$weid));
				$member=pdo_fetch("SELECT id,mobile,realname FROM ".tablename('jy_onlinemv_user')." WHERE weid=".$weid." AND uid=".$uid);
			}
		}

		
		$op=$_GPC['op'];
		if($op=='add')
		{
			
				$phone=intval($_GPC['mobile']);
				$realname=$_GPC['realname'];
				$user=pdo_fetch('SELECT * FROM '.tablename('jy_onlinemv_user')." WHERE weid=".$weid." AND mobile='$phone'");
				if(!empty($user) && $user['id']!=$member['id'])
				{
					echo 2;
					exit;
				}
				else
				{
					if(empty($phone) || empty($realname))
					{
						echo 3;
						exit;
					}
					else
					{
						pdo_update('jy_onlinemv_user',array('mobile'=>$phone,'realname'=>$realname),array('id'=>$member['id']));
						if($sitem['sync']==1)
						{
							pdo_update('mc_members',array('mobile'=>$phone,'realname'=>$realname),array('uid'=>$uid));
						}
						echo 1;
						exit;
					}
				}
			
		}
		if($op=='add2')
		{
			
			
				$phone=intval($_GPC['mobile']);
				$realname=$_GPC['realname'];
				if(!empty($phone))
				{
					$user=pdo_fetch('SELECT * FROM '.tablename('jy_onlinemv_user')." WHERE weid=".$weid." AND mobile='$phone'");
					if(!empty($user) && $user['id']!=$member['id'])
					{
						echo 2;
						exit;
					}
				}

				if(empty($phone) && empty($realname))
				{
					echo 3;
					exit;
				}
				else
				{
					$data3=array();
					if(!empty($phone))
					{
						$data3['mobile']=$phone;
					}
					if(!empty($realname))
					{
						$data3['realname']=$realname;
					}
					pdo_update('jy_onlinemv_user',$data3,array('id'=>$member['id']));
					if($sitem['sync']==1)
					{
						pdo_update('mc_members',$data3,array('uid'=>$uid));
					}
					echo 1;
					exit;
				}
			
			
		}
		
		$title="绑定信息";
		include $this->template('file');
	}

	//我的充值记录
	public function doMobileRecord(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$psize = PSIZE;//每页几条信息
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$openid = $_W['openid'];
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$user_info = pdo_fetch("SELECT id FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'");
		if(!empty($user_info)){
			$userid = $user_info['id'];
			//购买记录
			
			$record_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_records')." WHERE weid='{$weid}' AND userid='{$userid}' AND paystat=1 order by id desc limit 0,{$psize}");
		
		}else{
			message ( '抱歉，暂无数据', $this->createWebUrl ('geren'),'error');
		}
		
		$title="我的充值记录";
		include $this->template('record');
	}

	public function doMobileajaxrecord(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$psize = PSIZE;//每页几条信息
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$openid = $_W['openid'];
		$user_info = pdo_fetch("SELECT id FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'");
		$userid = $user_info['id'];
		$stores_sql = "SELECT * FROM ".tablename('jy_onlinemv_records')." WHERE weid='{$weid}' AND userid='{$userid}' order by id desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);
		

		if($stores){
			$div = '';
			foreach ($stores as $ke => $va) {
				if($va['paytype'] == 1){
					$paytype = '包月';
				}elseif($va['paytype'] == 2){
					$paytype = '包年';
				}elseif($va['paytype'] == 3){
					$paytype = '单个视频';
				}elseif($va['paytype'] == 4){
					$paytype = '视频套餐';
				}else{
					$paytype = '';
				}

				if($va['paymethod'] == 1){
					$paymethod = '微信';
				}elseif($va['paymethod'] == 2){
					$paymethod = '卡密';
				}else{
					$paymethod = '';
				}
				// $div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="weui_cells weui_cells_access">';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>购买时间：'.$va['buytime'].' </p></div><div class="weui_cell_ft"></div></a>';
				
				if($va['paytype'] == 4){
					$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
					$div .= '<p>购买部数：'.$va['number'].' 部</p></div><div class="weui_cell_ft"></div></a>';
				}
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>购买价格：'.$va['price'].' 元</p></div><div class="weui_cell_ft"></div></a>';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>购买日期：'.date('Y-m-d',$va['createtime']).'</p></div><div class="weui_cell_ft"></div></a>';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>充值方式：'.$paytype.' </p></div><div class="weui_cell_ft"></div></a>';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>支付方式：'.$paymethod.' </p></div><div class="weui_cell_ft"></div></a>';
				if($va['paymethod'] == 2){
					$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
					$div .= '<p>卡密价格：'.$va['camiloprice'].' </p></div><div class="weui_cell_ft"></div></a>';
				}

				$div .='</div>';
			}

			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
		}
		echo json_encode($returns);
	}

	//购买记录
	public function doMobileOrder(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$psize = PSIZE;//每页几条信息
		$openid = $_W['openid'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$user_info = pdo_fetch("SELECT id FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'");
		if(!empty($user_info)){
			$userid = $user_info['id'];
			$user_order = pdo_fetchall("SELECT a.id,a.createtime,b.realname,b.mobile,c.catename,d.videoname FROM ".tablename('jy_onlinemv_order')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id left join ".tablename('jy_onlinemv_class')." as c on a.classid=c.id left join ".tablename('jy_onlinemv_video')." as d on a.videoid=d.id WHERE a.weid='{$weid}' AND b.openid='{$openid}' and a.paystat=1 order by a.id desc limit 0,{$psize}");
			
		}else{
			message ( '抱歉，暂无数据', $this->createWebUrl ('geren'),'error');
		}
		$title="我的购买记录";
		include $this->template('order');
	}

	public function doMobileajaxorder(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		
		$psize = PSIZE;//每页几条信息
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$openid = $_W['openid'];
		$user_info = pdo_fetch("SELECT id FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'");
		$userid = $user_info['id'];
		$stores_sql = "SELECT a.id,a.createtime,b.realname,b.mobile,c.catename,d.videoname FROM ".tablename('jy_onlinemv_order')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id left join ".tablename('jy_onlinemv_class')." as c on a.classid=c.id left join ".tablename('jy_onlinemv_video')." as d on a.videoid=d.id WHERE a.weid='{$weid}' AND b.openid='{$openid}' order by a.id desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);
		

		if($stores){
			$div = '';
			foreach ($stores as $ke => $va) {
				// $div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="weui_cells weui_cells_access">';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>视频分类：'.$va['catename'].'</p></div><div class="weui_cell_ft"></div></a>';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>视频名称：'.$va['videoname'].'</p></div><div class="weui_cell_ft"></div></a>';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>购买时间：'.date('Y-m-d',$va['createtime']).'</p></div><div class="weui_cell_ft"></div></a>';
				$div .='</div>';
			}

			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
		}
		echo json_encode($returns);
	}

	//浏览记录
	public function doMobileBrowse(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$psize = PSIZE;//每页几条信息
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$openid = $_W['openid'];
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$user_info = pdo_fetch("SELECT id FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'");
		if(!empty($user_info)){
			$userid = $user_info['id'];
			$user_browse = pdo_fetchall("SELECT a.id,a.createtime,b.catename,c.videoname FROM ".tablename('jy_onlinemv_stat')." as a left join ".tablename('jy_onlinemv_class')." as b on a.classid=b.id left join ".tablename('jy_onlinemv_video')." as c on a.videoid=c.id WHERE a.weid='{$weid}' AND a.mid='{$userid}' AND a.videoid!=0 AND a.classid!=0 order by a.id desc limit 0,{$psize}");
			
		}else{
			message ( '抱歉，暂无数据', $this->createWebUrl ('geren'),'error');
		}

		$title="我的浏览记录";
		include $this->template('browse');
	}

	public function doMobileajaxbrowse(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$psize = PSIZE;//每页几条信息
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$openid = $_W['openid'];
		$user_info = pdo_fetch("SELECT id FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'");
		$userid = $user_info['id'];
		$stores_sql = "SELECT a.id,a.createtime,b.catename,c.videoname FROM ".tablename('jy_onlinemv_stat')." as a left join ".tablename('jy_onlinemv_class')." as b on a.classid=b.id left join ".tablename('jy_onlinemv_video')." as c on a.videoid=c.id WHERE a.weid='{$weid}' AND a.mid='{$userid}' AND a.videoid!=0 AND a.classid!=0 order by a.id desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);
		

		if($stores){
			$div = '';
			foreach ($stores as $ke => $va) {
				// $div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="weui_cells weui_cells_access">';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>视频分类：'.$va['catename'].'</p></div><div class="weui_cell_ft"></div></a>';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>视频名称：'.$va['videoname'].'</p></div><div class="weui_cell_ft"></div></a>';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>浏览时间：'.date('Y-m-d',$va['createtime']).'</p></div><div class="weui_cell_ft"></div></a>';
				$div .='</div>';
			}

			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
		}
		echo json_encode($returns);
	}

	//我的评论列表
	public function doMobileMymessage(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$psize = PSIZE;//每页几条信息
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$openid = $_W['openid'];
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$user_info = pdo_fetch("SELECT id FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'");
		if(!empty($user_info)){
			$userid = $user_info['id'];
			$msql = "SELECT a.id,a.content,a.createtime,b.videoname,b.lid,b.logo FROM ".tablename('jy_onlinemv_comments')." as a left join ".tablename('jy_onlinemv_video')." as b on a.vid=b.id WHERE a.weid='{$weid}' AND a.userid='{$userid}' order by a.id desc limit 0,{$psize}";
			$mlist = pdo_fetchall($msql);
			foreach($mlist as $key => $val){
				$lid = $val['lid'];
				if($lid){
					$lsql = "SELECT id,name FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}' AND id in ({$lid})";
					$linfo = pdo_fetchall($lsql);
					$mlist[$key]['lable'] = $linfo;
				}else{
					$mlist[$key]['lable'] = array();
				}
				
			}
		}else{
			message ( '抱歉，暂无数据', $this->createWebUrl ('geren'),'error');
		}
		
		$title="我的评论记录";
		include $this->template('mymessage');
	}

	//
	public function doMobileajaxmymessage(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$psize = PSIZE;//每页几条信息
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$openid = $_W['openid'];
		//$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$user_info = pdo_fetch("SELECT id FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'");
		
		$userid = $user_info['id'];
		$msql = "SELECT a.id,a.content,a.createtime,b.videoname,b.lid,b.logo FROM ".tablename('jy_onlinemv_comments')." as a left join ".tablename('jy_onlinemv_video')." as b on a.vid=b.id WHERE a.weid='{$weid}' AND a.userid='{$userid}' order by a.id desc limit ".($pindex-1)*$psize.",{$psize}";
		$mlist = pdo_fetchall($msql);
		if(!empty($mlist)){
			foreach($mlist as $key => $val){
				$lid = $val['lid'];
				if($lid){
					$lsql = "SELECT id,name FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}' AND id in ({$lid})";
					$linfo = pdo_fetchall($lsql);
				}else{
					$linfo = array();
				}
				
				$mlist[$key]['lable'] = $linfo;
			}
			foreach($mlist as $ke => $va){
				
				$div .= '<div class="point-div"><div class="con"><div class="detail" style="background-color:#F5F4F4;border:none;">';
				$div .= '<div class="pic" style="margin-top:20px;margin-left:15px;margin-bottom:15px;">';
				if(!$va['logo']){
					if(!$setting['avar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['logo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="120px" height="80px"></div><div class="title" style="margin-top:30px;">';
				$storename =  mb_substr($va['videoname'],0,10,'utf-8');
				
				$div .= '<h3 class="font-color">';
				$div .= $storename.'</h3>';
				foreach($va['lable'] as $key1 => $val1){
					$div .= '<span style="background-color: '.$setting['color'].';color:#ffffff;padding:1px 3px;">'.$val1['name'].'</span>';
				}

				$remark =  mb_substr($va['remark'],0,20,'utf-8');
				$div .= '<p class="font-color" style="word-wrap: break-word;word-break:break-all;">'.date('Y年m月d日',$va['createtime']).'</p></div></div>';
				$div .= '<div style="border-bottom:1px solid #F9F8F8;padding-bottom:10px;">  
                        <span style="font-size:14px;color:'.$setting['color'].'">我的评论：</span><span style="color:#E1E0E0;">'.$va['content'].'</span>
                    </div> ';
				
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				
				
				$div .='</div></div>';
			}
			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
			);
		}else{
			$returns=array(
				'statue'=>2,
				'msg'=>'已加载全部数据',
				'page'=>$pindex,
			);
		}
		echo json_encode($returns);
	}

	//我的兴趣
	public function doMobileMylove(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$psize = PSIZE;//每页几条信息
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$openid = $_W['openid'];
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$user_info = pdo_fetch("SELECT id FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'");
		$userid = $user_info['id'];
		//我的兴趣
		$isql = "SELECT a.userid,a.createtime,b.videoname,b.lid,b.logo FROM ".tablename('jy_onlinemv_interests')." as a left join ".tablename('jy_onlinemv_video')." as b on a.vid=b.id WHERE a.weid='{$weid}' AND a.userid='{$userid}' order by a.id desc limit 0,{$psize}";
		$ilist = pdo_fetchall($isql);

		foreach($ilist as $key => $val){
			$lid = $val['lid'];
			if($lid){
				$lsql = "SELECT id,name FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}' AND id in ({$lid})";
				$linfo = pdo_fetchall($lsql);
			}else{
				$linfo = array();
			}
			
			$ilist[$key]['lable'] = $linfo;
		}
		
		$title="我的兴趣";
		include $this->template('mylove');
	}

	public function doMobileajaxmylove(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$psize = PSIZE;//每页几条信息
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$openid = $_W['openid'];
		//$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$user_info = pdo_fetch("SELECT id FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'");
		$userid = $user_info['id'];
		//我的兴趣
		$isql = "SELECT a.userid,a.createtime,b.videoname,b.lid,b.logo FROM ".tablename('jy_onlinemv_interests')." as a left join ".tablename('jy_onlinemv_video')." as b on a.vid=b.id WHERE a.weid='{$weid}' AND a.userid='{$userid}' order by a.id desc limit ".($pindex-1)*$psize.",{$psize}";
		$ilist = pdo_fetchall($isql);
		foreach($ilist as $key => $val){
			$lid = $val['lid'];
			if($lid){
				$lsql = "SELECT id,name FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}' AND id in ({$lid})";
				$linfo = pdo_fetchall($lsql);
			}else{
				$linfo = array();
			}
			
			$ilist[$key]['lable'] = $linfo;
		}
		if($ilist){
			foreach($ilist as $ke => $va){
				
				$div .= '<div class="point-div"><div class="con"><div class="detail" style="background-color:#F5F4F4;border:none;">';
				$div .= '<div class="pic" style="margin-top:20px;margin-left:15px;margin-bottom:15px;">';
				if(!$va['logo']){
					if(!$setting['avar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['logo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="120px" height="80px"></div><div class="title" style="margin-top:30px;">';
				$storename =  mb_substr($va['videoname'],0,10,'utf-8');
				
				$div .= '<h3 class="font-color">';
				$div .= $storename.'</h3>';
				foreach($va['lable'] as $key1 => $val1){
					$div .= '<span style="background-color: '.$setting['color'].';color:#ffffff;padding:1px 3px;">'.$val1['name'].'</span>';
				}

				$remark =  mb_substr($va['remark'],0,20,'utf-8');
				$div .= '<p class="font"-color>'.date('Y年m月d日',$va['createtime']).'</p></div></div></div></div>';
								
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				
				
				
			}
			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
			);
		}else{

			$returns=array(
				'statue'=>2,
				'msg'=>'已加载全部数据',
				'page'=>$pindex,
			);
		}
		echo json_encode($returns);
	}

	//所有分类
	public function doMobileAllcate(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$psize = PSIZE;//每页几条信息
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//底部菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		//分类
		$sql = "SELECT id,catename,parentid FROM ".tablename('jy_onlinemv_class')." WHERE weid='{$weid}' AND enabled=1 order by displayorder desc";
		$list = pdo_fetchall($sql);

		$children = array();
		foreach($list as $ck => $cv){
			if (!empty($cv['parentid'])) {
                $children[$cv['parentid']][] = $cv;
                unset($list[$ck]);
            }
		}

		/*获取视频信息*/
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 order by displayorder desc limit 0,{$psize}";
		$stores = pdo_fetchall($stores_sql);
		//获取视频的标签信息
		

		$title="全部分类";
		include $this->template('allcate');
	}

	public function doMobileajaxallcate(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$psize = PSIZE;//每页几条信息
		$pindex = max(1, intval($_GPC['page']));//当前第几页

		/*获取视频信息*/
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 order by displayorder desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);
		if($stores){
			foreach($stores as $ke => $va){
				
				$div .= '<div class="point-div" style="width:39.5%;float:left;margin:1px 0px;padding-top:15px;padding-bottom:10px;"><div class="con">';
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="detail" style="border:none;"><div class="pic" style="width:100%;">';
				if(!$va['logo']){
					if(!$setting['avar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['logo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="100%" height="100px"></div><div class="title" style="width:93%;max-width:93%;">';
				$storename =  mb_substr($va['videoname'],0,5,'utf-8');
				
				$div .= '<span class="font-color">';
				$div .= $storename.'</span>';
				$div .= '<p class="font-color" style="float:right;"><img src="'.ONLINEMV_IMAGE.'interest.png" class="interest" id="interest" onclick="inter('.$va['id'].')" />  &nbsp;'.$va['dolike'].'
								<img src="'.ONLINEMV_IMAGE.'comment.png" class="comment" id="comment" />  &nbsp;'.$va['comnum'].'</p></div></div></a>';
								
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				
				
				$div .='</div></div>';
			}
			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
			);
		}else{
			$returns=array(
				'statue'=>2,
				'msg'=>'已加载全部数据',
				'page'=>$pindex,
			);
		}
		echo json_encode($returns);
	}

	//充值页面
	public function doMobileTopmember(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$id = $_GPC['id'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//获取视频信息
		$vsql = "SELECT * FROM ".tablename('jy_onlinemv_video')." WHERE weid='{$weid}' AND id='{$id}'";
		$vinfo = pdo_fetch($vsql);
		//底部菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$title="充值";
		include $this->template('topmember');
	}
	

	//封号处理
	public function doWebBanuser(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$id = $_GPC['id'];
		$op = $_GPC['op'];
		if($op){
			$update=array(
				'enable'=>1,
				);
			pdo_update('jy_onlinemv_user',$update, array('weid'=>$weid,'id'=>$id));
			message('已解封',$this->createWebUrl('user'),'success');
		}else{
			$update=array(
				'enable'=>2,
				);
			pdo_update('jy_onlinemv_user',$update , array('weid'=>$weid,'id'=>$id));
			message('已封号',$this->createWebUrl('user'),'success');
		}
	}

	//用户管理
	public function doWebuser(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = 10;//每页几条信息
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if($operation == 'display'){
			$sql = "select a.*,b.province, b.city , b.district from ".tablename('jy_onlinemv_user')." a left join ".tablename('jy_onlinemv_user_attr')." b on a.id=b.mid where a.weid='{$weid}' limit ".($pindex-1)*$psize.",{$psize}";
			$lists = pdo_fetchall($sql);
			
			$all_sql = "select count(id) as a from ".tablename('jy_onlinemv_user')." where weid='{$weid}'";
			$abc = pdo_fetch($all_sql);
			foreach ($lists as $key => $value) {
				$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$value['uid']}'";
				$infos = pdo_fetch($sqls);
				$lists[$key]['nickname']=$infos['nickname'];
				$lists[$key]['avatar']=$infos['avatar'];
				//浏览视频数
				$ssql = "SELECT count(distinct(videoid)) as sa  FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$value['id']}' AND videoid != 0";
				$sinfo = pdo_fetch($ssql);
				$lists[$key]['sa'] = $sinfo['sa'];
				//用户评论数
				$csql = "SELECT * FROM ".tablename('jy_onlinemv_comments')." WHERE weid='{$weid}' AND userid='{$value['id']}'";
				$clist = pdo_fetchall($csql);
				$lists[$key]['pl'] = count($clist);
				//点赞记录
				$isql = "SELECT * FROM ".tablename('jy_onlinemv_interests')." WHERE weid='{$weid}' AND userid='{$value['id']}'";
				$ilist = pdo_fetchall($isql);
				$lists[$key]['zan'] = count($ilist);
			}

			$pager = pagination($abc['a'], $pindex, $psize);
			include $this->template('web/user');
		}elseif($operation == 'shoudetail'){
			$id = $_GPC['id'];
			$sql = "select c.* ,d.nickname,d.avatar from (select a.*,b.mid,b.city,b.province,b.district from ".tablename('jy_onlinemv_user')." as a , ".tablename('jy_onlinemv_user_attr')." as b where a.id=b.mid ) c left join ".tablename('mc_members')." d on c.uid=d.uid where c.weid='{$weid}' and c.id='{$id}'";
			$infos = pdo_fetch($sql);
			//浏览视频数
			$ssql = "SELECT count(distinct(videoid)) as sa  FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$id}' AND videoid != 0";
			$sinfo = pdo_fetch($ssql);
			$stsql = "SELECT * FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$id}' AND videoid != 0";
			$stlist = pdo_fetchall($stsql);
			foreach($stlist as $key1 => $val1){
				$vsql = "SELECT a.id,a.videoname,a.enabled,b.catename FROM ".tablename('jy_onlinemv_video')." as a left join ".tablename('jy_onlinemv_class')." as b on a.mdcateid=b.id WHERE a.weid='{$weid}' AND a.id='{$val1['videoid']}'";
				$vinfo = pdo_fetch($vsql);
				$stlist[$key1]['videoname'] = $vinfo['videoname'];
				$stlist[$key1]['catename'] = $vinfo['catename'];
				$stlist[$key1]['enabled'] = $vinfo['enabled'];
			}
			
			//评论数
			$csql = "SELECT * FROM ".tablename('jy_onlinemv_comments')." WHERE weid='{$weid}' AND userid='{$id}'";
			$clist = pdo_fetchall($csql);
			foreach($clist as $key2 => $val2){
				$cvsql = "SELECT a.id,a.videoname,a.enabled,b.catename FROM ".tablename('jy_onlinemv_video')." as a left join ".tablename('jy_onlinemv_class')." as b on a.mdcateid=b.id WHERE a.weid='{$weid}' AND a.id='{$val2['vid']}'";
				$cvinfo = pdo_fetch($cvsql);
				$clist[$key2]['videoname'] = $cvinfo['videoname'];
				$clist[$key2]['catename'] = $cvinfo['catename'];
			}

			//点赞记录
			$isql = "SELECT * FROM ".tablename('jy_onlinemv_interests')." WHERE weid='{$weid}' AND userid='{$id}'";
			$ilist = pdo_fetchall($isql);
			foreach($ilist as $key3 => $val3){
				$ivsql = "SELECT a.id,a.videoname,a.enabled,b.catename FROM ".tablename('jy_onlinemv_video')." as a left join ".tablename('jy_onlinemv_class')." as b on a.mdcateid=b.id WHERE a.weid='{$weid}' AND a.id='{$val3['vid']}'";
				$ivinfo = pdo_fetch($ivsql);
				$ilist[$key3]['videoname'] = $ivinfo['videoname'];
				$ilist[$key3]['catename'] = $ivinfo['catename'];
			}

			//分享记录
			$shsql = "SELECT * FROM ".tablename('jy_onlinemv_share')." WHERE weid='{$weid}' AND userid='{$id}'";
			$shlist = pdo_fetchall($shsql);
			foreach($shlist as $key4 => $val4){
				$shvsql = "SELECT a.id,a.videoname,a.enabled,b.catename FROM ".tablename('jy_onlinemv_video')." as a left join ".tablename('jy_onlinemv_class')." as b on a.mdcateid=b.id WHERE a.weid='{$weid}' AND a.id='{$val4['vid']}'";
				$shvlist = pdo_fetch($shvsql);
				$shlist[$key4]['videoname'] = $shvlist['videoname'];
				$shlist[$key4]['catename'] = $shvlist['catename'];
			}

			include $this->template('web/detail');
		}
		
	}

	public function doWebshoudetail(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'detail';
		$id = $_GPC['id'];
		$sql = "select c.* ,d.nickname,d.avatar from (select a.*,b.mid,b.city,b.province,b.district from ".tablename('jy_onlinemv_user')." as a , ".tablename('jy_onlinemv_user_attr')." as b where a.id=b.mid ) c left join ".tablename('mc_members')." d on c.uid=d.uid where c.weid='{$weid}' and c.id='{$id}'";
		$infos = pdo_fetch($sql);
		//浏览视频数
		$ssql = "SELECT count(distinct(videoid)) as sa  FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$id}' AND videoid != 0";
		$sinfo = pdo_fetch($ssql);
		$stsql = "SELECT * FROM ".tablename('jy_onlinemv_stat')." WHERE weid='{$weid}' AND mid='{$id}' AND videoid != 0";
		$stlist = pdo_fetchall($stsql);
		foreach($stlist as $key1 => $val1){
			$vsql = "SELECT a.id,a.videoname,a.enabled,b.catename FROM ".tablename('jy_onlinemv_video')." as a left join ".tablename('jy_onlinemv_class')." as b on a.mdcateid=b.id WHERE a.weid='{$weid}' AND a.id='{$val1['videoid']}'";
			$vinfo = pdo_fetch($vsql);
			$stlist[$key1]['videoname'] = $vinfo['videoname'];
			$stlist[$key1]['catename'] = $vinfo['catename'];
			$stlist[$key1]['enabled'] = $vinfo['enabled'];
		}
		
		//评论数
		$csql = "SELECT * FROM ".tablename('jy_onlinemv_comments')." WHERE weid='{$weid}' AND userid='{$id}'";
		$clist = pdo_fetchall($csql);
		foreach($clist as $key2 => $val2){
			$cvsql = "SELECT a.id,a.videoname,a.enabled,b.catename FROM ".tablename('jy_onlinemv_video')." as a left join ".tablename('jy_onlinemv_class')." as b on a.mdcateid=b.id WHERE a.weid='{$weid}' AND a.id='{$val2['vid']}'";
			$cvinfo = pdo_fetch($cvsql);
			$clist[$key2]['videoname'] = $cvinfo['videoname'];
			$clist[$key2]['catename'] = $cvinfo['catename'];
		}

		//点赞记录
		$isql = "SELECT * FROM ".tablename('jy_onlinemv_interests')." WHERE weid='{$weid}' AND userid='{$id}'";
		$ilist = pdo_fetchall($isql);
		foreach($ilist as $key3 => $val3){
			$ivsql = "SELECT a.id,a.videoname,a.enabled,b.catename FROM ".tablename('jy_onlinemv_video')." as a left join ".tablename('jy_onlinemv_class')." as b on a.mdcateid=b.id WHERE a.weid='{$weid}' AND a.id='{$val3['vid']}'";
			$ivinfo = pdo_fetch($ivsql);
			$ilist[$key3]['videoname'] = $ivinfo['videoname'];
			$ilist[$key3]['catename'] = $ivinfo['catename'];
		}

		include $this->template('web/detail');
	}

	//底部菜单设置
	public function doWebmenu() {
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if ($operation == 'display') {
			if (! empty ( $_GPC ['displayorder'] )) {
				foreach ( $_GPC ['displayorder'] as $id => $displayorder ) {
					pdo_update ( 'jy_onlinemv_menu', array ('displayorder' => $displayorder ), array ('id' => $id) );
				}
				message ( '自定义菜单管理更新成功！', $this->createWebUrl ( 'menu', array ('op' => 'display') ), 'success' );
			}
			$category = pdo_fetchall ( "SELECT * FROM " . tablename ( 'jy_onlinemv_menu' ) . " WHERE weid = '{$_W['weid']}' ORDER BY displayorder DESC,id ASC" );
			include $this->template ( 'web/menu' );
		} elseif ($operation == 'post') {
			$id = intval ( $_GPC ['id'] );
			load()->func('tpl');
			$condition='';
			if (! empty ( $id )) {
				$category = pdo_fetch ( "SELECT * FROM " . tablename ( 'jy_onlinemv_menu' ) . " WHERE id = '$id'" );
				$condition.=" AND id!=".$id;
			} else {
				$category = array (
						'displayorder' => 0,
						'thumb' => '',
						'url' => '',
						'enabled' => 1
				);
			}
			if (checksubmit ( 'submit' )) {
				if (empty ( $_GPC ['catename'] )) {
					message ( '抱歉，请输入自定义菜单管理！' );
				}

				$temp = pdo_fetch ( "SELECT id FROM " . tablename ( 'jy_onlinemv_menu' ) . " WHERE weid=" . $weid . " AND name='" . $_GPC ['catename'] . "'" );
				if (! empty ( $temp ) && $id != $temp ['id']) {
					message ( '已存在该自定义菜单管理！', $this->createWebUrl ( 'url', array ('op' => 'display' ) ), 'error' );
				}
				$enabled=intval($_GPC['enabled']);
				if($enabled==1)
				{
					$temp=pdo_fetchcolumn("SELECT count(id) FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ".$condition);
				}
				if($temp==4)
				{
					message("自定义菜单最多设置4个显示项，请先去除其他显示项！");
				}
				if (empty ( $_GPC ['thumb'] )) {
					message ( '抱歉，请上传自定义菜单icon！' );
				}
				$data = array (
						'weid' => $_W ['weid'],
						'name' => $_GPC ['catename'],
						'description' => $_GPC ['description'],
						'enabled' => intval ( $_GPC ['enabled'] ),
						'thumb' => $_GPC ['thumb'],
						'url' => $_GPC ['url'],
						'displayorder' => intval ( $_GPC ['displayorder'] ) 
				);
				$type=intval($_GPC['type']);
				if($type==1)
				{
					$data['url']=$this->createMobileUrl('index');
				}
				if($type==2)
				{
					$data['url']=$this->createMobileUrl('record');
				}
				
				if($type==3)
				{
					$data['url']=$this->createMobileUrl('geren');
				}
				if (! empty ( $id )) {
					pdo_update ( 'jy_onlinemv_menu', $data, array ('id' => $id ) );
				} else {
					pdo_insert ( 'jy_onlinemv_menu', $data );
					$id = pdo_insertid ();
				}
				message ( '更新自定义菜单管理设置成功！', $this->createWebUrl ( 'menu', array ('op' => 'display' ) ), 'success' );
			}
			include $this->template ( 'web/menu' );
		} elseif ($operation == 'delete') {
			$id = intval ( $_GPC ['id'] );
			$category = pdo_fetch ( "SELECT id FROM " . tablename ( 'jy_onlinemv_menu' ) . " WHERE id = '$id'" );
			if (empty ( $category )) {
				message ( '抱歉，自定义菜单管理设置不存在或是已经被删除！', $this->createWebUrl ( 'menu', array ('op' => 'display' ) ), 'error' );
			}
			pdo_delete ( 'jy_onlinemv_menu', array ('id' => $id ) );
			message ( '自定义菜单管理设置删除成功！', $this->createWebUrl ( 'menu', array ('op' => 'display' ) ), 'success' );
		}
	}

	//充值管理
	public function doWebRecharge(){
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		$keyword = $_GPC['keyword'];
		$keyword = str_replace("_", "\_", $keyword);
		$keyword = str_replace("%", "\%", $keyword);
		$condition = '';
		if($keyword){
			$condition = "AND b.realname like '%{$keyword}%'";
		}
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if ($operation == 'display') {
			$pindex = max(1, intval($_GPC['page']));//当前第几页
			$psize = 15;//每页几条信息
			$user_info = pdo_fetchall("SELECT a.*,b.uid,b.realname,b.mobile FROM ".tablename('jy_onlinemv_records')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id WHERE a.weid='{$weid}'".$condition." order by b.id desc,a.id desc limit ".($pindex-1)*$psize.",{$psize}");
			
			foreach($user_info as $key => $val){
				$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$val['uid']}'";
				$minfo = pdo_fetch($sqls);
				
				$user_info[$key]['nickname'] = $minfo['nickname'];
				$user_info[$key]['avatar'] = $minfo['avatar'];
			}
			
			$all_sql = "SELECT count(a.id) as a FROM ".tablename('jy_onlinemv_records')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id WHERE a.weid='{$weid}'".$condition;
			$abc = pdo_fetch($all_sql);
			$total = $abc['a'];
			$pager = pagination($abc['a'], $pindex, $psize);
			//总金额
			$tsql = "SELECT sum(price) as tmoney FROM ".tablename('jy_onlinemv_records')." WHERE weid='{$weid}'";
			$tinfo = pdo_fetch($tsql);
			$total_money = $tinfo['tmoney'];
			include $this->template ( 'web/recharge' );
		}
	}

	//充值数据导出
	public function doWebBrexport(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		checklogin();
		$user_info = pdo_fetchall("SELECT a.*,b.uid,b.realname,b.mobile FROM ".tablename('jy_onlinemv_records')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id WHERE a.weid='{$weid}'".$condition." order by b.id desc,a.id desc");
			
		foreach($user_info as $key => $val){
			$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$val['uid']}'";
			$minfo = pdo_fetch($sqls);
			
			$user_info[$key]['nickname'] = $minfo['nickname'];
			$user_info[$key]['avatar'] = $minfo['avatar'];
		}
		
		ob_end_clean();

		require_once '../framework/library/phpexcel/PHPExcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");

		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', '用户ID')
					->setCellValue('B1', '用户昵称')
					->setCellValue('C1', '用户姓名')
					->setCellValue('D1', '用户手机')
					->setCellValue('E1', '充值金额')
					->setCellValue('F1', '充值天数')
					->setCellValue('G1', '充值类型')
					->setCellValue('H1', '充值方式')
					->setCellValue('I1', '商户订单号')
					->setCellValue('J1', '购买时间')
					->setCellValue('K1', '支付状态');
		

		$i=2;

		foreach ($user_info as $key => $row) {
			if($row['paytype'] == 1){
				$paytype = '包月';
			}elseif($row['paytype'] == 2){
				$paytype = '包年';
			}elseif($row['paytype'] == 3){
				$paytype = '单个视频';
			}elseif($row['paytype'] == 4){
				$paytype = '视频套餐';
			}else{
				$paytype = '';
			}

			if($row['paymethod'] == 1){
				$paymethod = '微信';
			}elseif($row['paymethod'] == 2){
				$paymethod = '卡密支付; 卡密:'.$row['camiloname'].';价格:'.$row['camiloprice'].'元';
			}else{
				$paymethod = '';
			}

			if($row['paystat'] == 1){
				$payment = '已付';
			}else{
				$payment = '未付';
			}

			
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$i, $row['userid'])
			->setCellValue('B'.$i, $row['nickname'])
			->setCellValue('C'.$i, $row['realname'])
			->setCellValue('D'.$i, $row['mobile'])
			->setCellValue('E'.$i, $row['price'])
			->setCellValue('F'.$i, $row['buytime'])
			->setCellValue('G'.$i, $paytype)
			->setCellValue('H'.$i, $paymethod)
			->setCellValue('I'.$i, $row['uniontid'])
			->setCellValue('J'.$i, date('Y-m-d H:i',$row['createtime']))
			->setCellValue('K'.$i, $payment);


			$i++;

		}

		$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(140);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(140);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(40);

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('充值记录数据'."_".date('Y-m-d'));


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.'充值记录数据'."_".date('Ymd').'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		ob_flush();
		flush();

		message("导出成功",$this->createWebUrl('recharge'),'success');
	}


	//购买记录
	public function doWeborder(){
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		$keyword = $_GPC['keyword'];
		$keyword = str_replace("_", "\_", $keyword);
		$keyword = str_replace("%", "\%", $keyword);
		$condition = '';
		if($keyword){
			$condition = "AND b.realname like '%{$keyword}%'";
		}
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if ($operation == 'display'){
			$pindex = max(1, intval($_GPC['page']));//当前第几页
			$psize = 15;//每页几条信息
			$user_order = pdo_fetchall("SELECT a.*,b.uid,b.realname,b.mobile,c.catename,d.videoname FROM ".tablename('jy_onlinemv_order')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id left join ".tablename('jy_onlinemv_class')." as c on a.classid=c.id left join ".tablename('jy_onlinemv_video')." as d on a.videoid=d.id WHERE a.weid='{$weid}'".$condition." order by a.id desc limit ".($pindex-1)*$psize.",{$psize}");
			foreach($user_order as $key => $val){
				$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$val['uid']}'";
				$minfo = pdo_fetch($sqls);
				
				$user_order[$key]['nickname'] = $minfo['nickname'];
				$user_order[$key]['avatar'] = $minfo['avatar'];
			}
			$all_sql = "SELECT count(a.id) as a FROM ".tablename('jy_onlinemv_order')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id left join ".tablename('jy_onlinemv_class')." as c on a.classid=c.id left join ".tablename('jy_onlinemv_video')." as d on a.videoid=d.id WHERE a.weid='{$weid}'".$condition;
			$abc = pdo_fetch($all_sql);

			$pager = pagination($abc['a'], $pindex, $psize);
		}
		include $this->template ( 'web/order' );
	}

	//购买记录数据导出
	public function doWebBorxport(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		checklogin();
		$user_order = pdo_fetchall("SELECT a.*,b.uid,b.realname,b.mobile,c.catename,d.videoname FROM ".tablename('jy_onlinemv_order')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id left join ".tablename('jy_onlinemv_class')." as c on a.classid=c.id left join ".tablename('jy_onlinemv_video')." as d on a.videoid=d.id WHERE a.weid='{$weid}'".$condition." order by a.id desc");
		foreach($user_order as $key => $val){
			$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$val['uid']}'";
			$minfo = pdo_fetch($sqls);
			
			$user_order[$key]['nickname'] = $minfo['nickname'];
			$user_order[$key]['avatar'] = $minfo['avatar'];
		}
		
		ob_end_clean();

		require_once '../framework/library/phpexcel/PHPExcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");

		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', '用户ID')
					->setCellValue('B1', '用户昵称')
					->setCellValue('C1', '用户姓名')
					->setCellValue('D1', '用户手机')
					->setCellValue('E1', '购买视频分类')
					->setCellValue('F1', '购买视频名称')
					->setCellValue('G1', '购买时间');
		

		$i=2;

		foreach ($user_order as $key => $row) {

			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$i, $row['userid'])
			->setCellValue('B'.$i, $row['nickname'])
			->setCellValue('C'.$i, $row['realname'])
			->setCellValue('D'.$i, $row['mobile'])
			->setCellValue('E'.$i, $row['catename'])
			->setCellValue('F'.$i, $row['videoname'])
			->setCellValue('G'.$i, date('Y-m-d H:i',$row['createtime']));


			$i++;

		}

		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('购买记录数据'."_".date('Y-m-d'));


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.'购买记录数据'."_".date('Ymd').'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		ob_flush();
		flush();

		message("导出成功",$this->createWebUrl('order'),'success');
	}

	//标签管理
	public function doWebLable(){
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if ($operation == 'display') {
			if (! empty ( $_GPC ['displayorder'] )) {
				foreach ( $_GPC ['displayorder'] as $id => $displayorder ) {
					pdo_update ( 'jy_onlinemv_lable', array ('displayorder' => $displayorder ), array ('id' => $id) );
				}
				message ( '标签管理更新成功！', $this->createWebUrl ( 'lable', array ('op' => 'display') ), 'success' );
			}
			$category = pdo_fetchall ( "SELECT * FROM " . tablename ('jy_onlinemv_lable') . " WHERE weid = '{$_W['weid']}'  ORDER BY displayorder DESC,id ASC" );
			// $children = array();
			// foreach($category as $ck => $cv){
			// 	if (!empty($cv['parentid'])) {
	  //               $children[$cv['parentid']][] = $cv;
	  //               unset($category[$ck]);
	  //           }
			// }

			include $this->template ( 'web/lable' );
		}elseif ($operation == 'post') {
			// $parentid = intval($_GPC['parentid']);
			$id = intval ( $_GPC ['id'] );
			load()->func('tpl');
			if (! empty ( $id )) {
				$category = pdo_fetch ( "SELECT * FROM " . tablename ('jy_onlinemv_lable') . " WHERE id = '$id'" );
			} else {
				$category = array (
						'displayorder' => 0,
				);
			}
			if (!empty($parentid)) {
	            $parent = pdo_fetch("SELECT id, name FROM " . tablename('jy_onlinemv_lable') . " WHERE id = '{$parentid}'");
	            if (empty($parent)) {
	                message('抱歉，该标签不存在或是已经被删除！', $this->createWebUrl('post'), 'error');
	            }
	        }
	        
			if (checksubmit ( 'submit' )) {
				if (empty ( $_GPC ['name'] )) {
					message ( '抱歉，请输入标签名称！' );
				}
				$temp = pdo_fetch ( "SELECT id FROM " . tablename ( 'jy_onlinemv_lable' ) . " WHERE weid=" . $weid . " AND name='" . $_GPC ['name'] . "'" );
				if (! empty ( $temp ) && $id != $temp ['id']) {
					message ( '已存在该标签管理！', $this->createWebUrl ( 'lable', array ('op' => 'display' ) ), 'error' );
				}
				$data = array (
						'weid' => $_W ['weid'],
						'name' => $_GPC ['name'],
						'displayorder' => intval ( $_GPC ['displayorder'] ) ,
						'createtime' => TIMESTAMP,
						
				);
				if (! empty ( $id )) {
					pdo_update ( 'jy_onlinemv_lable', $data, array ('id' => $id ) );
				} else {
					pdo_insert ( 'jy_onlinemv_lable', $data );
					$id = pdo_insertid ();
				}
				message ( '标签管理设置成功！', $this->createWebUrl ( 'lable', array ('op' => 'display' ) ), 'success' );
			}
			include $this->template ( 'web/lable' );
		} elseif ($operation == 'delete') {
			$id = intval ( $_GPC ['id'] );
			$category = pdo_fetch ( "SELECT id FROM " . tablename ( 'jy_onlinemv_lable' ) . " WHERE id = '$id'" );
			if (empty ( $category )) {
				message ( '抱歉，标签不存在或是已经被删除！', $this->createWebUrl ( 'lable', array ('op' => 'display' ) ), 'error' );
			}
			pdo_delete ( 'jy_onlinemv_lable', array ('id' => $id ) );
			message ( '标签删除成功！', $this->createWebUrl ( 'lable', array ('op' => 'display' ) ), 'success' );
		}
	}

	protected function _Auth(){
 		global $_GPC , $_W;
 		$weid=$_W['uniacid'];
 		if ($_W['container'] != 'wechat') {
 			return $this->returnError('请将该页面分享到微信打开！', '', 'error');
 		}

 		if (!isset($_SESSION['jy_openid']) || empty($_SESSION['jy_openid']) || !isset($_SESSION['uid']) || empty($_SESSION['uid'])){
 			unset($uid);
 		}
 		else
 		{
 			$from_user=$_SESSION['jy_openid'];

 			$member_temp=pdo_fetch("SELECT uid,nickname,follow FROM ".tablename('mc_mapping_fans')." WHERE openid='$from_user' AND uniacid=".$weid);
 			if(empty($member_temp['nickname']) || $member_temp['uid']==0)
 			{
 				unset($uid);
 			}
 			else
 			{
 				$uid=$member_temp['uid'];
 				$_W['member']['uid']=$uid;
 				unset($member_temp);
 				$huiyuan_temp=pdo_fetch("SELECT nickname FROM ".tablename('mc_members')." WHERE uniacid=".$weid." AND  uid=".$uid);
 				if(empty($huiyuan_temp['nickname']))
 				{
 					unset($uid);
 				}
 			}
 		}
 		if(empty($uid))
 		{
 			if (!empty($_W['openid']) && intval($_W['account']['level']) >= 3) {
 				$accObj = WeiXinAccount::create($_W['account']);
 				$userinfo = $accObj->fansQueryInfo($_W['openid']);
 			}

 			$state = '9yeid-'.$_W['session_id'];

 			$_SESSION['dest_url'] = base64_encode($_SERVER['QUERY_STRING']);

 			$op=$_GPC['op'];

 			$code = $_GET['code'];
 			$from_user=$_W['openid'];

 			if(empty($code)){
 				if($userinfo['subscribe']==0)
 				{
 					$url = $_W['siteroot'] . 'app/index.php?' . $_SERVER['QUERY_STRING'];
 					$callback = urlencode($url);
 					$forward = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$_W['oauth_account']['key'].'&redirect_uri='.$callback.'&response_type=code&scope=snsapi_userinfo&state='.$state.'#wechat_redirect';

 					header("Location: ".$forward);
 				}
 				else
 				{
 					//用户已经关注改公众号了
 					$weid=$_W['uniacid'];

          //  老胡旧方法
 			  	// 	$fan_temp=pdo_fetch("SELECT * FROM ".tablename('mc_mapping_fans')." WHERE openid='$from_user' AND uniacid=".$weid);

          /**
           * 解决袁文涛fans 表唯一问题
           */
           $fans_temp=pdo_fetchall("SELECT uniacid FROM ".tablename('mc_mapping_fans')." WHERE openid='$from_user' ");

           $fan_temp = '';
           if(empty($fans_temp[0])){
              $_isUnique =  false;
           }else{
               $_isUnique = 'not';
           }

           foreach ($fans_temp as $key => $value) {
               if($value['uniacid']==$weid){
                   $fan_temp=pdo_fetch("SELECT * FROM ".tablename('mc_mapping_fans')." WHERE openid='$from_user' AND uniacid=".$weid);
                   $_isUnique = true;
               }
           }


 					if(!empty($userinfo) && !empty($userinfo['headimgurl']) && !empty($userinfo['nickname']))
 					{
 						$userinfo['avatar'] = $userinfo['headimgurl'];
 						unset($userinfo['headimgurl']);

 						//开启了强制注册，自定义注册
 						$default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['uniacid']));

 						$data = array(
 							'uniacid' => $_W['uniacid'],
 							'email' => md5($_W['openid']).'@9yetech.com'.$op,
 							'salt' => random(8),
 							'groupid' => $default_groupid,
 							'createtime' => TIMESTAMP,
 							'nickname' 		=> stripslashes($userinfo['nickname']),
 							'avatar' 		=> $userinfo['avatar'],
 							'gender' 		=> $userinfo['sex'],
 							'nationality' 	=> $userinfo['country'],
 							'resideprovince'=> $userinfo['province'] . '省',
 							'residecity' 	=> $userinfo['city'] . '市',
 						);
 						$data['password'] = md5($_W['openid'] . $data['salt'] . $_W['config']['setting']['authkey']);
 						if(empty($fan_temp))
 						{
 							pdo_insert('mc_members', $data);
 							$uid = pdo_insertid();
 						}
 						else
 						{
 							pdo_update('mc_members' ,$data ,array('uid'=>$fan_temp['uid']));
 							$uid=$fan_temp['uid'];
 						}



 						$record = array(
 							'openid' 		=> $_W['openid'],
 							'uid' 			=> $uid,
 							'acid' 			=> $_W['acid'],
 							'uniacid' 		=> $_W['uniacid'],
 							'salt' 			=> random(8),
 							'updatetime' 	=> TIMESTAMP,
 							'nickname' 		=> stripslashes($userinfo['nickname']),
 							'follow' 		=> $userinfo['subscribe'],
 							'followtime' 	=> $userinfo['subscribe_time'],
 							'unfollowtime' 	=> 0,
 							'tag' 			=> base64_encode(iserializer($userinfo))
 						);
 						$record['uid'] = $uid;
 						if(empty($fan_temp)&&$_isUnique!='not'&&!$_isUnique)
 						{
 							pdo_insert('mc_mapping_fans', $record);
 						}
 						else
 						{
 							pdo_update('mc_mapping_fans' ,$record ,array('fanid'=>$fan_temp['fanid']));
 						}
 						$_SESSION['jy_openid']=$_W['openid'];
 						$_SESSION['openid']=$_W['openid'];
 						$_SESSION['uid']=$uid;
 					}
 				}
 			}
 			else
 			{
 				//未关注，通过网页授权
 				$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$_W['oauth_account']['key']."&secret=".$_W['oauth_account']['secret']."&code=".$code."&grant_type=authorization_code";
 				load()->func('communication');
 				$response = ihttp_get($url);
 				$oauth = @json_decode($response['content'], true);

 				$url = "https://api.weixin.qq.com/sns/userinfo?access_token={$oauth['access_token']}&openid={$oauth['openid']}&lang=zh_CN";
 				$response = ihttp_get($url);


 				if (!is_error($response)) {

 					$userinfo = array();
 					$userinfo = @json_decode($response['content'], true);

 					$userinfo['avatar'] = $userinfo['headimgurl'];
 					unset($userinfo['headimgurl']);


 					$_SESSION['userinfo'] = base64_encode(iserializer($userinfo));

 						if(!empty($userinfo) && !empty($userinfo['avatar']) && !empty($userinfo['nickname']))
 						{
 							$weid=$_W['uniacid'];

 							$fan_temp=pdo_fetch("SELECT * FROM ".tablename('mc_mapping_fans')." WHERE openid='$from_user' AND uniacid=".$weid);
 							//开启了强制注册，自定义注册
 							$default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['uniacid']));
 							$data = array(
 								'uniacid' => $_W['uniacid'],
 								'email' => md5($_W['openid']).'@9yetech.com'.$op,
 								'salt' => random(8),
 								'groupid' => $default_groupid,
 								'createtime' => TIMESTAMP,
 								'nickname' 		=> stripslashes($userinfo['nickname']),
 								'avatar' 		=> rtrim($userinfo['avatar'], '0') . 132,
 								'gender' 		=> $userinfo['sex'],
 								'nationality' 	=> $userinfo['country'],
 								'resideprovince'=> $userinfo['province'] . '省',
 								'residecity' 	=> $userinfo['city'] . '市',
 							);
 							$data['password'] = md5($_W['openid'] . $data['salt'] . $_W['config']['setting']['authkey']);

 							if(empty($fan_temp))
 							{
 								pdo_insert('mc_members', $data);
 								$uid = pdo_insertid();
 							}
 							else
 							{
 								pdo_update('mc_members' ,$data ,array('uid'=>$fan_temp['uid']));
 								$uid=$fan_temp['uid'];
 							}

 							$record = array(
 								'openid' 		=> $oauth['openid'],
 								'uid' 			=> $uid,
 								'acid' 			=> $_W['acid'],
 								'uniacid' 		=> $_W['uniacid'],
 								'salt' 			=> random(8),
 								'updatetime' 	=> TIMESTAMP,
 								'nickname' 		=> stripslashes($userinfo['nickname']),
 								'follow' 		=> $userinfo['subscribe'],
 								'followtime' 	=> $userinfo['subscribe_time'],
 								'unfollowtime' 	=> 0,
 								'tag' 			=> base64_encode(iserializer($userinfo))
 							);
 							$record['uid'] = $uid;

 							if(empty($fan_temp)&&!$_isUnique)
 							{
 								pdo_insert('mc_mapping_fans', $record);
 							}
 							else if($_isUnique=='not'){

              }
              else
 							{
 								$temp=pdo_update('mc_mapping_fans' ,$record ,array('fanid'=>$fan_temp['fanid']));
 							}
 							$_SESSION['jy_openid']=$oauth['openid'];
 							$_SESSION['openid']=$oauth['openid'];
 							$_SESSION['uid']=$uid;

 						}

 				} else {
 					$this->returnError('微信授权获取用户信息失败,请重新尝试: ' . $response['message']);
 				}
 			}
 		}
 	}

 	//处理用户信息
	public function __douser(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$uid = $_SESSION['uid'];
		$openid = $_SESSION['openid'];
		$sql = "select * from ".tablename('jy_onlinemv_user')." where weid='{$weid}' and uid='{$uid}'";
		$minfo = pdo_fetch($sql);
		if($minfo['enable']==2){
			$this->returnError('很抱歉，此账号已被封号!请联系客服！');
		}
		if($minfo){
			$update = array(
				'updatetime'=>TIMESTAMP,
				);
			pdo_update('jy_onlinemv_user',$update,array('weid'=>$weid,'uid'=>$uid));//更新登录时间
			$_SESSION['userinfo'] = $minfo;
		}else{
			$data = array(
				'weid'=>$weid,
				'uid'=>$uid,
				'openid'=>$openid,
				'enable'=>1,
				'createtime'=>TIMESTAMP,
				'updatetime'=>TIMESTAMP,
			);
			pdo_insert('jy_onlinemv_user',$data);
			$pdo_insertid = pdo_insertid();
			$indata = array(
				'weid'=>$weid,
				'mid'=>$pdo_insertid,
				);
			pdo_insert('jy_onlinemv_user_attr',$indata);
			$_SESSION['userinfo'] = $data;
			$_SESSION['userinfo']['id']=$pdo_insertid;
		}
	}

	protected function returnError($message, $data = '', $status = 0, $type = '')
	{
		global $_W;
		if ($_W['isajax'] || $type == 'ajax') {
			header('Content-Type:application/json; charset=utf-8');
			$ret = array('status' => $status, 'info' => $message, 'data' => $data);
			exit(json_encode($ret));
		} else {
			return $this->returnMessage($message, $data, 'error');
		}
	}

	protected function returnSuccess($message, $data = '', $status = 1, $type = '')
	{
		global $_W;
		if ($_W['isajax'] || $type == 'ajax') {
			header('Content-Type:application/json; charset=utf-8');
			$ret = array('status' => $status, 'info' => $message, 'data' => $data);
			exit(json_encode($ret));
		} else {
			return $this->returnMessage($message, $data, 'success');
		}
	}
	protected function returnMessage($msg, $redirect = '', $type = '')
	{
		global $_W, $_GPC;
		if ($redirect == 'refresh') {
			$redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
		}
		if ($redirect == 'referer') {
			$redirect = referer();
		}
		if ($redirect == '') {
			$type = in_array($type, array('success', 'error', 'info', 'warn')) ? $type : 'info';
		} else {
			$type = in_array($type, array('success', 'error', 'info', 'warn')) ? $type : 'success';
		}
		if (empty($msg) && !empty($redirect)) {
			header('location: ' . $redirect);
		}
		$label = $type;
		if ($type == 'error') {
			$label = 'warn';
		}
		include $this->template('inc/message');
		exit();
	}

	public function doMobileWxpay(){
		global $_W, $_GPC;
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$weid=$_W['uniacid'];
		$videoid = $_GPC['id'];
		$paytype = $_GPC['mptype'];
		$paymethod = $_GPC['paytype'];
		$camilo = $_GPC['kmtext'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//获取视频信息
		$vsql = "SELECT * FROM ".tablename('jy_onlinemv_video')." WHERE weid='{$weid}' AND id='{$videoid}'";
		$vinfo = pdo_fetch($vsql);

		if($setting['camilo'] == 0){
			if($camilo){
				$returns=array(
					'statue'=>0,
					'mdata'=>'非法操作',
				);
				echo json_encode($returns);exit;
				// message('非法操作',$this->createMobileUrl('index'),'error');
			}
		}
		if($paymethod == 2){
			if($paytype != 4){
				$returns=array(
					'statue'=>0,
					'mdata'=>'此充值方式不能使用卡密支付',
				);
				echo json_encode($returns);exit;
				// message('此充值方式不能使用卡密支付',$this->createMobileUrl('topmember',array('id'=>$videoid)),'error');
			}
		}

		//获取用户信息
		$openid = $_W['openid'];
		$osql = "SELECT * FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'";
		$user_info = pdo_fetch($osql);
		//金额
		if($paytype == 1){
			$total=$setting['monthprice'];
			$buytime = "一个月";
			$buynum = 0;
		}elseif($paytype == 2){
			$total=$setting['yearprice'];
			$buytime = "一年";
			$buynum = 0;
		}elseif($paytype == 3){
			$total=$vinfo['vprice'];
			$buytime = '';
			$buynum = 1;
		}elseif($paytype == 4){
			$total=$setting['price'];
			$buytime = $setting['valid_time'].'天';
			$buynum = $setting['number'];
		}else{
			$returns=array(
				'statue'=>0,
				'mdata'=>'非法操作',
			);
			echo json_encode($returns);exit;
			// message('非法操作',$this->createMobileUrl('index'),'error');
		}
		$paytime = time();
		
		//判断是否选择的卡密
		if($setting['camilo'] == 1){
			if($paymethod == 2 && $paytype == 4){
				if($camilo){
					//判断卡密是否正确
					$ksql = "SELECT * FROM ".tablename('jy_onlinemv_camilo')." WHERE weid='{$weid}' AND cmname='{$camilo}'";
					$kinfo = pdo_fetch($ksql);
					if(empty($kinfo)){
						$returns=array(
							'statue'=>0,
							'mdata'=>'卡密不存在',
						);
						echo json_encode($returns);exit;
						// message('卡密不存在',$this->createMobileUrl('topmember',array('id'=>$videoid)),'error');
					}
					
					if($kinfo['status'] == 1){
						$returns=array(
							'statue'=>0,
							'mdata'=>'此卡密已使用过',
						);
						echo json_encode($returns);exit;
						// message('此卡密已使用过',$this->createMobileUrl('index'),'error');
					}elseif($kinfo['status'] == 0){
						$kdata = array(
							'status'=>1,
							'updatetime'=>TIMESTAMP,
						);
						pdo_update('jy_onlinemv_camilo',$kdata,array('id'=>$kinfo['id']));
					}
					//修改订单状态
					//写入购买记录表
					$order_data = array(
						'weid'=>$weid,
						'classid'=>$vinfo['mdcateid'],
						'videoid'=>$vinfo['id'],
						'userid'=>$user_info['id'],
						'createtime'=>$paytime,
						'paytype'=>$paytype,
						'paymethod'=>$paymethod,
						'paystat'=>1,
					);
					pdo_insert('jy_onlinemv_order', $order_data);
					$oid = pdo_insertid();
					//写入充值记录表
					$record_data = array(
						'weid'=>$weid,
						'userid'=>$user_info['id'],
						'number'=>$buynum,
						'buytime'=>$buytime,
						'camiloname'=>$kinfo['cmname'],
						'camiloprice'=>$kinfo['cmprice'],
						'price'=>$total,
						'createtime'=>$paytime,
						'paytype'=>$paytype,
						'paymethod'=>$paymethod,
						'paystat'=>1,
					);
					pdo_insert('jy_onlinemv_records', $record_data);
					$rid = pdo_insertid();
					//更新用户看电影的记录
					$new_number = $setting['number'] + $user_info['number'];
					//有效期
					//

					$now_data = date('Y-m-d 00:00:00',time());
					$viptime = date('Y-m-d 00:00:00',$user_info['validity']);
					if($now_data > $viptime){
						$now_time = strtotime($now_data.' +'.$setting['valid_time'].' days');
					}else{
						$now_time = strtotime($viptime.' +'.$setting['valid_time'].' days');
					}
					
					$user_data = array(
						'number'=>$new_number,
						'is_member'=>1,
						'validity'=>$now_time,
						'paytype'=>$paytype,
					);
					pdo_update('jy_onlinemv_user',$user_data,array('id'=>$user_info['id']));
					$returns=array(
						'statue'=>1,
						'mdata'=>'支付成功',
					);
					echo json_encode($returns);exit;
					// message('支付成功',$this->createMobileUrl('video',array('id'=>$videoid)),'success');
				}else{
					$returns=array(
						'statue'=>0,
						'mdata'=>'请输入卡密',
					);
					echo json_encode($returns);exit;
					// message('请输入卡密',$this->createMobileUrl('topmember',array('id'=>$videoid)),'error');
				}
			}else{

			}
			
		}

		//写入购买记录表
		$order_data = array(
			'weid'=>$weid,
			'classid'=>$vinfo['mdcateid'],
			'videoid'=>$vinfo['id'],
			'userid'=>$user_info['id'],
			'createtime'=>$paytime,
			'paytype'=>$paytype,
			'paymethod'=>$paymethod,
			'paystat'=>0,
		);

		pdo_insert('jy_onlinemv_order', $order_data);
		$oid = pdo_insertid();
		//写入充值记录表
		$record_data = array(
			'weid'=>$weid,
			'userid'=>$user_info['id'],
			'number'=>$buynum,
			'buytime'=>$buytime,
			'price'=>$total,
			'createtime'=>$paytime,
			'paytype'=>$paytype,
			'paymethod'=>$paymethod,
			'paystat'=>0,
		);
		pdo_insert('jy_onlinemv_records', $record_data);
		$rid = pdo_insertid();
		$returns=array(
			'statue'=>2,
			'vid'=>$videoid,
			'ptype'=>$paytype,
			'pmethod'=>$paymethod,
			'ptime'=>$paytime,
		);
		echo json_encode($returns);exit;
		
		// $this->payrecharge($videoid,$paytype,$paymethod,$paytime);
	}

	public function doMobilevipwechat(){
		global $_W,$_GPC;
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$videoid = intval($_GPC['vid']);
		$paytype = intval($_GPC['ptype']);
		$paymethod = intval($_GPC['pmethod']);
		$paytime = $_GPC['ptime'];
		$this->payrecharge($videoid,$paytype,$paymethod,$paytime);
	}

	//支付操作
	public function payrecharge($vid,$paytype,$paymethod,$paytime){
		global $_W,$_GPC;
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$weid=$_W['uniacid'];
		$acid=$vid;
		
		
		// $orid = $_GPC['orid'];
		$mid = $_SESSION['mid'];
		// $plid = $_GPC['plid'] ? $_GPC['plid'] : '';//支付id
		$uid=$_SESSION['uid'];
		$from_user=$_SESSION['jy_openid'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		/*获取设置信息*/
		//获取视频信息
		$vsql = "SELECT * FROM ".tablename('jy_onlinemv_video')." WHERE weid='{$weid}' AND id='{$vid}'";
		$vinfo = pdo_fetch($vsql);

		//判断选择的哪种充值类型 充值方式
		if($paytype == 1){
			$total=$setting['monthprice'];
		}elseif($paytype == 2){
			$total=$setting['yearprice'];
		}elseif($paytype == 3){
			$total=$vinfo['vprice'];
		}elseif($paytype == 4){
			$total=$setting['price'];
		}else{
			message('非法操作',$this->createMobileUrl('index'),'error');
		}

		//$total=$setting['price'];
		$tid=$paytime;

		$params['tid'] = $tid;
		$params['fee'] = $total;
		$params['user'] = $from_user;
		$params['title'] = "支付";
		$params['ordersn'] = random(8);
		$params['virtual'] =  true;
		if(!$this->inMobile) {
			message('支付功能只能在手机上使用');
		}

		$params['module'] = $this->module['name'];
		$pars = array();
		$pars[':uniacid'] = $weid;
		$pars[':module'] = $params['module'];
		$pars[':tid'] = $params['tid'];
		$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
		$log = pdo_fetch($sql, $pars);
		if(!empty($log) && $log['status'] == '1') {
			message('这个订单已经支付成功, 不需要重复支付.');
		}

		$setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));

		if(!is_array($setting['payment'])) {
			message('没有有效的支付方式, 请联系网站管理员.');
		}
		//print_r($setting);exit();
		if (empty($log)) {
	        $log = array(
	                'uniacid' => $weid,
	                'acid' => $acid,
	                'openid' => $from_user,
	                'module' => $this->module['name'], //模块名称，请保证$this可用
	                'tid' => $params['tid'],
	                'fee' => $total,
	                'card_fee' => $total,
	                'status' => '0',
	                'is_usecard' => '0',
	        );
	        pdo_insert('core_paylog', $log);
	        $plid = pdo_insertid();
	        // $update = array(
	        // 	'plid'=>$plid
	        // 	);
	        // pdo_update('jy_one_enroll',$update,array('weid'=>$weid,'bmid'=>$orid));
		}

		$params=base64_encode(json_encode($params));
		echo "<script>
				window.location.href = '".url('mc/cash/wechat')."&params=".$params."';
			</script>";
	}

	//支付完成后的回调函数
	public function payResult($params){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$params['module'] = $this->module['name'];
		$pars = array();
		$pars[':uniacid'] = $_W['uniacid'];
		$pars[':module'] = $params['module'];
		$pars[':tid'] = $params['tid'];
		$tid = $params['tid'];
		$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
		$log = pdo_fetch($sql, $pars);
		if($log['fee']!=$params['fee'])
		{
			echo '非法操作！发布失败!';exit;
		}
		//获取用户信息
		$openid = $log['openid'];
		$osql = "SELECT * FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'";
		$user_info = pdo_fetch($osql);
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$sql_v = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and id=".$log['acid'];
		$infos = pdo_fetch($sql_v);
		
		if($params['result']=='success' && $params['from'] == 'notify'){
			//写入购买记录表
			$odsql = "SELECT * FROM ".tablename('jy_onlinemv_order')." WHERE weid='{$weid}' AND createtime='{$tid}'";
			$oinfo = pdo_fetch($odsql);
			if($oinfo['paystat'] == 0){
				pdo_update('jy_onlinemv_order',array('paystat'=>1),array('id'=>$oinfo['id']));
			}else{
				echo '非法操作';exit;
			}
			
			// $order_data = array(
			// 	'weid'=>$weid,
			// 	'classid'=>$infos['mdcateid'],
			// 	'videoid'=>$log['acid'],
			// 	'userid'=>$user_info['id'],
			// 	'createtime'=>TIMESTAMP,
			// );
			// pdo_insert('jy_onlinemv_order', $order_data);
			// $oid = pdo_insertid();
			//写入充值记录表
			$rsql = "SELECT * FROM ".tablename('jy_onlinemv_records')." WHERE weid='{$weid}' AND createtime='{$tid}'";
			$rinfo = pdo_fetch($rsql);
			if($rinfo['paystat'] == 0){
				pdo_update('jy_onlinemv_records',array('paystat'=>1,'uniontid'=>$params['uniontid']),array('id'=>$rinfo['id']));
			}else{
				echo '非法操作';exit;
			}
			
			// $record_data = array(
			// 	'weid'=>$weid,
			// 	'userid'=>$user_info['id'],
			// 	'number'=>$setting['number'],
			// 	'time'=>$setting['valid_time'],
			// 	'price'=>$setting['price'],
			// 	'uniontid'=>$params['uniontid'],
			// 	'createtime'=>TIMESTAMP,
			// );
			// pdo_insert('jy_onlinemv_records', $record_data);
			// $rid = pdo_insertid();
			//更新用户看电影的记录
			
			//有效期
			//
			$now_data = date('Y-m-d 00:00:00',time());
			$viptime = date('Y-m-d 00:00:00',$user_info['validity']);
			if($now_data > $viptime){
				$now_time = strtotime($now_data.' +'.$setting['valid_time'].' days');
			}else{
				$now_time = strtotime($viptime.' +'.$setting['valid_time'].' days');
			}
			$paytype = $rinfo['paytype'];
			if($paytype == 1){
				if($now_data > $viptime){
					$now_time = strtotime("+1 month");
				}else{
					$now_time = strtotime($viptime.' +1 month');
				}
				
				$vnumber = 0;
				$new_number = $user_info['number'];
			}elseif($paytype == 2){
				if($now_data > $viptime){
					$now_time = strtotime("+1 year");
				}else{
					$now_time = strtotime($viptime.' +1 year');
				}
				
				$vnumber = 0;
				$new_number = $user_info['number'];
			}elseif($paytype == 3){
				$now_time = $user_info['validity'];
				$vnumber = 1;
				$new_number = $user_info['number'];
			}elseif($paytype == 4){
				if($now_data > $viptime){
					$now_time = strtotime($now_data.' +'.$setting['valid_time'].' days');
				}else{
					$now_time = strtotime($viptime.' +'.$setting['valid_time'].' days');
				}
				
				$vnumber = 0;
				$new_number = $setting['number'] + $user_info['number'];
			}
			
			$user_data = array(
				'number'=>$new_number,
				'is_member'=>1,
				'validity'=>$now_time,
				'total'=>$user_info['total']+$vnumber,
				'paytype'=>$paytype,
			);
			pdo_update('jy_onlinemv_user',$user_data,array('id'=>$user_info['id']));
			
			
			// message('恭喜您,充值成功！',$this->createMobileUrl('video',array('id'=>$log['acid'])),'success');
		}
		// else{
		// 	$this->returnError('很抱歉,支付失败！','','error');
		// 	//message('很抱歉,支付失败！',$this->createMobileUrl('Index',),'success');
		// }
		if ($params['from'] == 'return') {
//window.location.href = '".$_W['siteroot'].'app/' .substr($this->createMobileUrl('video',array('id'=>$log['acid'])),2)."';
			if ($params['result'] == 'success') {
				echo "<script>

					window.location.href = '".$_W['siteroot'].'app/' .substr($this->createMobileUrl('index'),2)."';
					

				</script>";
			}
			else
			{
				return $this->returnError('支付失败！', $this->createMobileUrl('index'), 'error');
			}
		}
	}

}