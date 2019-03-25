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
define('PSIZE', '5');
if($_W['container'] == 'wechat'){
	define('WEIXIN', '1');
}else{
	define('WEIXIN', '2');
}


class Jy_onlinemvModuleSite extends WeModuleSite {

	// public function doMobileIndex() {
	// 	//这个操作被定义用来呈现 功能封面
	// }
	

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
				'color' => $_GPC ['color'],
				'valid_time' => $_GPC ['valid_time'],
				'number' => $_GPC ['number'],
				'price' => $_GPC ['price'],
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
			if (! empty ( $_GPC ['displayorder'] )) {
				foreach ( $_GPC ['displayorder'] as $id => $displayorder ) {
					pdo_update ( 'jy_onlinemv_class', array ('displayorder' => $displayorder ), array ('id' => $id) );
				}
				message ( '分类管理更新成功！', $this->createWebUrl ( 'class', array ('op' => 'display') ), 'success' );
			}
			$category = pdo_fetchall ( "SELECT * FROM " . tablename ('jy_onlinemv_class') . " WHERE weid = '{$_W['weid']}'  ORDER BY displayorder DESC,id ASC" );
			$children = array();
			foreach($category as $ck => $cv){
				if (!empty($cv['parentid'])) {
	                $children[$cv['parentid']][] = $cv;
	                unset($category[$ck]);
	            }
			}

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
		if ($operation == 'display') {
			$pindex = max(1, intval($_GPC['page']));//当前第几页
			$psize = 10;//每页几条信息
			if (! empty ( $_GPC ['displayorder'] )) {
				foreach ( $_GPC ['displayorder'] as $id => $displayorder ) {
					pdo_update ( 'jy_onlinemv_video', array ('displayorder' => $displayorder ), array ('id' => $id) );
				}
				message ( '视频排序更新成功！', $this->createWebUrl ( 'store', array ('op' => 'display') ), 'success' );
			}
			$list = pdo_fetchall ( "SELECT a.*,b.catename FROM " . tablename ( 'jy_onlinemv_video' ) . " a left join ".tablename( 'jy_onlinemv_class' )." b on a.mdcateid=b.id WHERE a.weid = '{$_W['weid']}' ORDER BY a.displayorder desc limit ".($pindex-1)*$psize.",{$psize}");
			$all_sql = "select count(id) as a from ".tablename('jy_onlinemv_video')." where weid='{$weid}'";
			$abc = pdo_fetch($all_sql);

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

				$item['thumbs'] = unserialize($item['thumb']);
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

				$data = array (
						'weid' => $_W ['weid'],
						'displayorder' => intval ( $_GPC ['displayorder'] ) ,
						'videoname' => $_GPC ['videoname'],
						'lid' => $lid,
						'visit' => $_GPC ['visit'],
						'l_video_address' => $_GPC ['l_video_address'],
						'pass' => $_GPC ['pass'],
						's_video_address' => $_GPC ['s_video_address'],
						'mdcateid' => $_GPC ['mdcateid'],
						'visit' => $_GPC ['visit'],
						'thumb' => serialize($_GPC ['thumb']),
						'logo' => $_GPC ['logo'],
						'remark' => $_GPC ['remark'],
						'enabled' => intval ( $_GPC ['enabled'] ),
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
		}
	}

	//首页显示
	public function doMobileindex(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		// $this->_Auth();//获取用户信息
		// $this->__douser();//存储用户信息
		// $this->__cull();
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
		$sql_type = "select * from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and enabled=1 and parentid=0";
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
			}
			
			$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
			$stores[$key]['lable'] = $lable_list;
		}
		
		//菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC");
		include $this->template('index');
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
			}
			
			$lable_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_lable')." WHERE weid='{$weid}'".$l_where);
			$stores[$key]['lable'] = $lable_list;
		}

		if($stores){
			foreach ($stores as $ke => $va) {
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="point-div"><div class="con"><div class="detail"><div class="pic">';

				if(!$va['logo']){
					if(!$setting['avar']){
						$logo=ONLINEMV_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['logo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="130px" height="130px"></div><div class="title"><h3 class="font-color">';
				$storename =  mb_substr($va['videoname'],0,10,'utf-8');
				$div .= '名称 '.$storename.'</h3>';
				foreach($va['lable'] as $key1 => $val1){
					$div .= '<span style="background-color: '.$setting['color'].';color:#ffffff;padding:1px 3px;">'.$val1['name'].'</span>';
				}

				$remark =  mb_substr($va['remark'],0,20,'utf-8');
				$div .= '<p class="font-color" style="word-wrap: break-word;word-break:break-all;">简介 '.$remark.'</p>';
				$div .= '<p class="font-color">'.date('Y-m-d',$va['createtime']).'</p></div>';
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
		$this->__cull();
		$do = $_GPC['do'];
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = PSIZE;//每页几条信息
		$act = "dis";
		$id = $_GPC['pid'];
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
		// $condition = '';
		// foreach($children as $key1 => $val1){

		// }
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//获取视频信息
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 and mdcateid='{$id}' order by displayorder desc limit 0,{$psize}";
		$storess = pdo_fetchall($stores_sql);
		//更新访问记录
		$updatesql = "update ".tablename('jy_onlinemv_stat')." set classid='{$id}' where weid='{$weid}' and id='{$_SESSION['statid']}'";
		pdo_query($updatesql);
		//底部菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$newarr = array();
		
		$i=($pindex-1)*$psize; $j=1;
		$t=0;
		if($doajax==1){
			//获取视频信息
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 and mdcateid='{$id}' order by displayorder desc limit 0,{$psize}";
		$storess = pdo_fetchall($stores_sql);
			foreach ($storess as $key => $value) {
				if($j>$i){
					if($t<$psize){
						$new[]=$value;
						$t++;
					}else{
						break;
					}
				}
				$j++;
			}
			$stores=$new;
			if($stores){
				foreach ($stores as $ke => $va) {
					$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
					$div .= '<div class="point-div"><div class="con"><div class="detail"><div class="pic">';

					if(!$va['storelogo']){
						if(!$setting['avar']){
							$logo=ONLINEMV_IMAGE.'123.png';
						}else{
							$logo=$setting['avar'];
						}
					}else{
						$logo=$va['storelogo'];
					}
					$div .= '<img src="'.tomedia($logo).'" width="100%"></div><div class="title"><h3>';
					$storename =  mb_substr($va['videoname'],0,12,'utf-8');
					$div .= $storename.'...</h3><p>';
					
					$div .= '访问次数：'.$va['visit'].'...</p></div>';
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
		}else{
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
	}

	//
	public function doMobileajaxlist(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$do = $_GPC['do'];
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = PSIZE;//每页几条信息
		$act = "dis";
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
		// $condition = '';
		// foreach($children as $key1 => $val1){

		// }
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//获取视频信息
		$stores_sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and enabled=1 and mdcateid='{$id}' order by displayorder desc limit 0,{$psize}";
		$storess = pdo_fetchall($stores_sql);
		
		//底部菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		$newarr = array();
		
		$i=($pindex-1)*$psize; $j=1;
		$t=0;
		// if($doajax==1){
			foreach ($storess as $key => $value) {
				if($j>$i){
					if($t<$psize){
						$new[]=$value;
						$t++;
					}else{
						break;
					}
				}
				$j++;
			}
			$stores=$new;
			if($stores){
				foreach ($stores as $ke => $va) {
					$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
					$div .= '<div class="point-div"><div class="con"><div class="detail"><div class="pic">';

					if(!$va['storelogo']){
						if(!$setting['avar']){
							$logo=ONLINEMV_IMAGE.'123.png';
						}else{
							$logo=$setting['avar'];
						}
					}else{
						$logo=$va['storelogo'];
					}
					$div .= '<img src="'.tomedia($logo).'" width="100%"></div><div class="title"><h3>';
					$storename =  mb_substr($va['videoname'],0,12,'utf-8');
					$div .= $storename.'...</h3><p>';
					
					$div .= '访问次数：'.$va['visit'].'...</p></div>';
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
		// }else{
		// 	foreach ($storess as $key => $value) {
		// 		if($t<$psize){
		// 			$new[]=$value;
		// 			$t++;
		// 		}else{
		// 			break;
		// 		}
		// 	}
		// 	$stores=$new;
		// 	include $this->template('type');
		// }
	}

	//子分类视频列表
	public function doMobileclist(){
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
		//更新访问记录
		$updatesql = "update ".tablename('jy_onlinemv_stat')." set classid='{$id}' where weid='{$weid}' and id='{$_SESSION['statid']}'";
		pdo_query($updatesql);
		//底部菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");
		
		$newarr = array();
		
		$i=($pindex-1)*$psize; $j=1;
		$t=0;
		if($doajax==1){
			foreach ($storess as $key => $value) {
				if($j>$i){
					if($t<$psize){
						$new[]=$value;
						$t++;
					}else{
						break;
					}
				}
				$j++;
			}
			$stores=$new;
			if($stores){
				foreach ($stores as $ke => $va) {
					$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
					$div .= '<div class="point-div"><div class="con"><div class="detail"><div class="pic">';

					if(!$va['storelogo']){
						if(!$setting['avar']){
							$logo=ONLINEMV_IMAGE.'123.png';
						}else{
							$logo=$setting['avar'];
						}
					}else{
						$logo=$va['storelogo'];
					}
					$div .= '<img src="'.tomedia($logo).'" width="100%"></div><div class="title"><h3>';
					$storename =  mb_substr($va['videoname'],0,12,'utf-8');
					$div .= $storename.'...</h3><p>';
					
					$div .= '访问次数：'.$va['visit'].'...</p></div>';
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
		}else{
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
	}

	public function doMobileshowDetail(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$this->__cull();
		$id = $_GPC['id'];
		//更新视频访问量
		$update = "update ".tablename('jy_onlinemv_video')." set visit = visit+1 where weid='{$weid}' and id='{$id}'";
		pdo_query($update);
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		
		// $dat = date('Y-m-d','2451491200');
		// var_dump($dat);exit;
		//获取用户信息
		$openid = $_W['openid'];
		$osql = "SELECT * FROM ".tablename('jy_onlinemv_user')." WHERE weid='{$weid}' AND openid='{$openid}'";
		$user_info = pdo_fetch($osql);
		//获取购买视频的信息
		$userid = $user_info['id'];
		$order_sql = "SELECT * FROM ".tablename('jy_onlinemv_order')." WHERE weid='{$weid}' AND userid='{$userid}' AND videoid='{$id}'";
		$order_list = pdo_fetch($order_sql);
		
		//判断是否是会员  是否在有效期 是否还有观影次数
		//当天的时间戳
		/* 
		$member 0:不是会员或者需要购买了  1:是会员且已购买视频 2:是会员但是没有购买会员
		*/
		
		$now = strtotime(date('Y-m-d 00:00:00',time()));
		if($user_info['is_member'] == 0 && $user_info['number'] == 0 || $user_info['validity'] < $now){
			$member = 0;
		}elseif($user_info['is_member'] == 1 && $user_info['validity'] > $now && !empty($order_list)){
			$member = 1;
		}elseif($user_info['is_member'] == 1 && $user_info['number'] > 0 && $user_info['validity'] > $now && empty($order_list)){
			$member = 2;
		}else{
			$member = 0;
		}


		
		//底部菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_menu')." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC ");

		$sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and id='{$id}'";
		$infos = pdo_fetch($sql);
		$infos['thumb'] = unserialize($infos['thumb']);
		//对链接进行处理
		if($member == 1){
			// $ak = "wIWaT0CKixoqawb1qKceTI945mgeLVvGzBl7Lszx";
			// $sk = "DxbgXjXpRUf0CwbA-eO1buRMc0iKWuM-snSP8FMT";
			$ak = $setting['ak'];
			$sk = $setting['sk'];
			$auth = new Auth($ak,$sk);
			$baseUrl = $infos['l_video_address'];
			$authUrl = $auth->privateDownloadUrl($baseUrl);

			   
		}
		$title=$infos['videoname'];
		$typename = pdo_fetch("select catename from ".tablename('jy_onlinemv_class')." where weid='{$weid}' and id='{$infos['mdcateid']}'");
		// $all = pdo_fetchall("select * from ".tablename(STORE_ATTR_TABLE)." where weid='{$weid}' and storeid='{$id}'");

		$updatesql = "update ".tablename('jy_onlinemv_stat')." set videoid='{$id}',classid='{$infos['mdcateid']}' where weid='{$weid}' and id='{$_SESSION['statid']}'";
		pdo_query($updatesql);

		include $this->template('showdetail');
		
	}

	public function doMobileVideo(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		$id = $_GPC['id'];
		$buy = $_GPC['buy'];

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
		
		$now = strtotime(date('Y-m-d 00:00:00',time()));
		if($user_info['is_member'] == 0 && $user_info['number'] == 0 || $user_info['validity'] < $now){
			$member = 0;
		}elseif($user_info['is_member'] == 1 && $user_info['validity'] > $now && !empty($order_list)){
			$member = 1;
		}elseif($user_info['is_member'] == 1 && $user_info['number'] > 0 && $user_info['validity'] > $now && empty($order_list)){
			$member = 2;
		}else{
			$member = 0;
		}
		// if($user_info['is_member'] == 0 || $user_info['number'] == 0 || $user_info['validity'] < $now){
		// 	$member = 0;
		// }elseif($user_info['is_member'] == 1 && $user_info['number'] > 0 && $user_info['validity'] > $now){
		// 	$member = 1;
		// }else{
		// 	$member = 0;
		// }
		

		$sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and id='{$id}'";
		$infos = pdo_fetch($sql);
		$infos['thumb'] = unserialize($infos['thumb']);
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
				// message('抱歉,您的视频购买次数已用完,请先充值',$this->createMobileUrl('wxpay',array('id'=>$infos['acid'])),'error');
			}
		}
		//对链接进行处理
		if($member == 1){
			// $ak = "wIWaT0CKixoqawb1qKceTI945mgeLVvGzBl7Lszx";
			// $sk = "DxbgXjXpRUf0CwbA-eO1buRMc0iKWuM-snSP8FMT";
			$ak = $setting['ak'];
			$sk = $setting['sk'];
			$auth = new Auth($ak,$sk);
			$baseUrl = $infos['l_video_address'];
			$authUrl = $auth->privateDownloadUrl($baseUrl);
			   
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
		//获取购买视频的信息
		$userid = $user_info['id'];
		$order_sql = "SELECT * FROM ".tablename('jy_onlinemv_order')." WHERE weid='{$weid}' AND userid='{$userid}' AND videoid='{$id}'";
		$order_list = pdo_fetch($order_sql);
		//判断是否是会员  是否在有效期 是否还有观影次数
		//当天的时间戳
		
		$now = strtotime(date('Y-m-d 00:00:00',time()));
		if($user_info['is_member'] == 0 && $user_info['number'] == 0 || $user_info['validity'] < $now){
			$member = 0;
		}elseif($user_info['is_member'] == 1 && $user_info['number'] > 0 && $user_info['validity'] > $now && !empty($order_list)){
			$member = 1;
		}elseif($user_info['is_member'] == 1 && $user_info['number'] > 0 && $user_info['validity'] > $now && empty($order_list)){
			$member = 2;
		}elseif($user_info['is_member'] == 1 && $user_info['validity'] > $now && !empty($order_list)){
			$member = 1;
		}else{
			$member = 0;
		}

		$sql = "select * from ".tablename('jy_onlinemv_video')." where weid='{$weid}' and id='{$id}'";
		$infos = pdo_fetch($sql);
		$infos['thumb'] = unserialize($infos['thumb']);
		//对链接进行处理
		
			// $ak = "wIWaT0CKixoqawb1qKceTI945mgeLVvGzBl7Lszx";
			// $sk = "DxbgXjXpRUf0CwbA-eO1buRMc0iKWuM-snSP8FMT";
			//1
			// $validity = $user_info['validity'];//文件的URL
			// $video_url = $infos['l_video_address']."?e=2451491200";
			// $sign = hash_hmac('sha1',$video_url,$sk,true);
			// $encode = $ak.':'.\Qiniu\base64_urlSafeEncode($sign);;
			// $real_url = $video_url.'&token='.$encode;
			//2
			// $auth = new Auth($ak,$sk);
			// $baseUrl = $infos['s_video_address'];
			// $authUrl = $auth->privateDownloadUrl($baseUrl);
			
			   
		
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
		/*获取设置信息*/
		$sql_set = "select * from ".tablename('jy_onlinemv_setting')." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$sitem=pdo_fetch("SELECT * FROM ".tablename('jy_onlinemv_setting')." WHERE weid=".$weid);
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
			
			$record_list = pdo_fetchall("SELECT * FROM ".tablename('jy_onlinemv_records')." WHERE weid='{$weid}' AND userid='{$userid}' order by id desc limit 0,{$psize}");
			
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
				// $div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="weui_cells weui_cells_access">';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>购买时间：'.$va['time'].' 天</p></div><div class="weui_cell_ft"></div></a>';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>购买部数：'.$va['number'].' 部</p></div><div class="weui_cell_ft"></div></a>';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>购买价格：'.$va['price'].' 元</p></div><div class="weui_cell_ft"></div></a>';
				$div .= '<a class="weui_cell" href="###"><div class="weui_cell_bd weui_cell_primary">';
				$div .= '<p>购买日期：'.date('Y-m-d',$va['createtime']).'</p></div><div class="weui_cell_ft"></div></a>';
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
			$user_order = pdo_fetchall("SELECT a.id,a.createtime,b.realname,b.mobile,c.catename,d.videoname FROM ".tablename('jy_onlinemv_order')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id left join ".tablename('jy_onlinemv_class')." as c on a.classid=c.id left join ".tablename('jy_onlinemv_video')." as d on a.videoid=d.id WHERE a.weid='{$weid}' AND b.openid='{$openid}' order by a.id desc limit 0,{$psize}");
			
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

	//用户管理
	public function doWebuser(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = 10;//每页几条信息
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'post';
		$sql = "select a.*,b.province, b.city , b.district from ".tablename('jy_onlinemv_user')." a left join ".tablename('jy_onlinemv_user_attr')." b on a.id=b.mid where a.weid='{$weid}' limit ".($pindex-1)*$psize.",{$psize}";
		$lists = pdo_fetchall($sql);
		$all_sql = "select count(id) as a from ".tablename('jy_onlinemv_user')." where weid='{$weid}'";
		$abc = pdo_fetch($all_sql);
		foreach ($lists as $key => $value) {
			$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$value['uid']}'";
			$infos = pdo_fetch($sqls);
			$lists[$key]['nickname']=$infos['nickname'];
			$lists[$key]['avatar']=$infos['avatar'];
		}

		$pager = pagination($abc['a'], $pindex, $psize);
		include $this->template('web/user');
	}

	public function doWebshoudetail(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'detail';
		$id = $_GPC['id'];
		$sql = "select c.* ,d.nickname,d.avatar from (select a.*,b.mid,b.city,b.province,b.district from ".tablename('jy_onlinemv_user')." as a , ".tablename('jy_onlinemv_user_attr')." as b where a.id=b.mid ) c left join ".tablename('mc_members')." d on c.uid=d.uid where c.weid='{$weid}' and c.id='{$id}'";
		$infos = pdo_fetch($sql);
		$sql_s = "select count(mid) as a from ".tablename('jy_onlinemv_stat')." where weid='{$weid}' and mid='{$id}'";
		$a = pdo_fetch($sql_s);
		$sql_a = "select count(distinct(videoid)) as b from ".tablename('jy_onlinemv_stat')." where weid='{$weid}' and mid='{$id}' and videoid != 0";
		$abc = pdo_fetch($sql_a);
		$sql_f = "select count(distinct(classid)) as b from ".tablename('jy_onlinemv_stat')." where weid='{$weid}' and mid='{$id}' and classid != 0";
		$af = pdo_fetch($sql_f);
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

	//视频管理
	public function doWebRecharge(){
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		$keyword = $_GPC['keyword'];
		$condition = '';
		if($keyword){
			$condition = "AND b.realname like '%{$keyword}%'";
		}
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if ($operation == 'display') {
			$pindex = max(1, intval($_GPC['page']));//当前第几页
			$psize = 15;//每页几条信息
			$user_info = pdo_fetchall("SELECT a.number,a.time,a.price,a.createtime,b.realname,b.mobile FROM ".tablename('jy_onlinemv_records')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id WHERE a.weid='{$weid}'".$condition." order by b.id desc,a.id desc limit ".($pindex-1)*$psize.",{$psize}");
			$all_sql = "SELECT count(a.id) as a FROM ".tablename('jy_onlinemv_records')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id WHERE a.weid='{$weid}'".$condition;
			$abc = pdo_fetch($all_sql);

			$pager = pagination($abc['a'], $pindex, $psize);
			
			include $this->template ( 'web/recharge' );
		}
	}

	//购买记录
	public function doWeborder(){
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		$keyword = $_GPC['keyword'];
		$condition = '';
		if($keyword){
			$condition = "AND b.realname like '%{$keyword}%'";
		}
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if ($operation == 'display'){
			$pindex = max(1, intval($_GPC['page']));//当前第几页
			$psize = 15;//每页几条信息
			$user_order = pdo_fetchall("SELECT a.*,b.realname,b.mobile,c.catename,d.videoname FROM ".tablename('jy_onlinemv_order')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id left join ".tablename('jy_onlinemv_class')." as c on a.classid=c.id left join ".tablename('jy_onlinemv_video')." as d on a.videoid=d.id WHERE a.weid='{$weid}'".$condition." order by a.id desc limit ".($pindex-1)*$psize.",{$psize}");
		
			$all_sql = "SELECT count(a.id) as a FROM ".tablename('jy_onlinemv_order')." as a left join ".tablename('jy_onlinemv_user')." as b on a.userid=b.id left join ".tablename('jy_onlinemv_class')." as c on a.classid=c.id left join ".tablename('jy_onlinemv_video')." as d on a.videoid=d.id WHERE a.weid='{$weid}'".$condition;
			$abc = pdo_fetch($all_sql);

			$pager = pagination($abc['a'], $pindex, $psize);
		}
		include $this->template ( 'web/order' );
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
		$videoid = $_GPC['id'];
		
		$this->payrecharge($videoid);
	}

	//支付操作
	public function payrecharge($vid){
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

		// if($plid){
		// 	$pay_log = pdo_fetch("select * from " .tablename('core_paylog'). " where uniacid='{$weid}' and plid=".$plid);
		// 	$total=$pay_log['fee'];
		// 	$tid=$pay_log['tid'];
		// }else{
			// $total=$info['cost'];
			$total=$setting['price'];
			$tid=TIMESTAMP;
			// $tid=TIMESTAMP.$orid;
		// }

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
			$order_data = array(
				'weid'=>$weid,
				'classid'=>$infos['mdcateid'],
				'videoid'=>$log['acid'],
				'userid'=>$user_info['id'],
				'createtime'=>TIMESTAMP,
			);
			pdo_insert('jy_onlinemv_order', $order_data);
			$oid = pdo_insertid();
			//写入充值记录表
			$record_data = array(
				'weid'=>$weid,
				'userid'=>$user_info['id'],
				'number'=>$setting['number'],
				'time'=>$setting['valid_time'],
				'price'=>$setting['price'],
				'createtime'=>TIMESTAMP,
			);
			pdo_insert('jy_onlinemv_records', $record_data);
			$rid = pdo_insertid();
			//更新用户看电影的记录
			$new_number = $setting['number'] + $user_info['number']-1;
			//有效期
			//
			$now_data = date('Y-m-d 00:00:00',time());
			$now_time = strtotime($now_data.' +'.$setting['valid_time'].' days');
			$user_data = array(
				'number'=>$new_number,
				'is_member'=>1,
				'validity'=>$now_time,
				'total'=>$user_info['total']+1,
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