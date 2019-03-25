<?php
/**
 * 附近商家|多门店地图导航模块微站定义
 *
 * @author hellozjx
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');



class Wx_lbsmapModuleSite extends WeModuleSite {
	public $table_category = 'wx_lbsmap_category';

	function getDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 2)

    {

        $radLat1 = $lat1 * M_PI / 180;

        $radLat2 = $lat2 * M_PI / 180;

        $a = $lat1 * M_PI / 180 - $lat2 * M_PI / 180;

        $b = $lng1 * M_PI / 180 - $lng2 * M_PI / 180;



        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));

        $s = $s * 6371;

        $s = round($s * 1000);

        if ($len_type > 1) {

            $s /= 1000;

        }

        $s /= 1000;

        return round($s, $decimal);

    }



	public function doMobileGetlbs()
	{
		global $_W, $_GPC;
		$catenameid=$_GPC['catenameid'];
		$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		if(empty($catenameid))
		{
			$url=$_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&do=map&m=wx_lbsmap';
		}
		else
		{
			$url=$_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&do=map&m=wx_lbsmap&catenameid='.$catenameid;
		}
		include $this->template('getlbs');

	}

	protected function returnSuccess($message, $data = '', $status = 1, $type = '')
	{
		global $_W;
		if ($_W['isajax'] || $type == 'ajax') {
			header('Content-Type:application/json; charset=utf-8');
			$ret = array('status' => $status, 'info' => $message, 'data' => $data);
			exit(json_encode($ret));
		}
	}
	public function doWebCategory(){
		global $_GPC,$_W;

		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$id = intval($_GPC['id']);
		if ($op == 'post') {
			if (!empty($id)) {
				$item = pdo_fetch("SELECT * FROM".tablename($this->table_category)."WHERE id='{$id}'");
			}
			if ($_W['ispost']) {
				$data = array(
						'weid'    => $_W['weid'],
						'name'    => $_GPC['cname'],
						'url'=>$_GPC['url'],
						'parentid' => $_GPC['parentid'],
						'enabled' => $_GPC['enabled'] ? 1 : 0,
				);
				if (empty($id)) {
					pdo_insert($this->table_category,$data);
					message('添加成功',$this->createWebUrl('Category'),'success');
				}else{
					pdo_update($this->table_category,$data,array('id' => $id));
					message('更新成功',$this->createWebUrl('Category'),'success');
				}
			}
		}elseif($op == 'display'){
			$o = '';
			
			$parents = pdo_fetchall("SELECT * FROM".tablename($this->table_category)." WHERE weid = '{$_W['weid']}' AND parentid = 0");
			foreach ($parents AS $parent){
				$enable = intval($parent['enabled']) ? '<button class="btn btn-success btn-sm">是</button>' : '<button class="btn btn-danger btn-sm">否</button>';
				$o .= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$parent['id']}\" /></td>";
				$o .= "<td>". $parent['name'] ."</td>";
				$o .= "<td> —— </td>";
				$o .= "<td>".$enable. "</td>";
				$o .= "<td><a href=". $this->createWebUrl('category',array('op' => 'post','id' => $parent['id'])) ." >编辑</a></td></tr>";
				
				$subcates = pdo_fetchall("SELECT * FROM ".tablename($this->table_category)." WHERE parentid = {$parent['id']}");
				foreach ($subcates AS $subcate){
					$enable = intval($subcate['enabled']) ? '<button class="btn btn-success btn-sm">是</button>' : '<button class="btn btn-danger btn-sm">否</button>';
					$o .= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$subcate['id']}\" /></td>";
					$o .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;|——". $subcate['name'] ."</td>";
					$o .= "<td>". $parent['name'] ."</td>";
					$o .= "<td>". $enable ."</td>";
					$o .= "<td><a href=". $this->createWebUrl('category',array('op' => 'post','id' => $subcate['id'])).">编辑</a></td></tr>";
				}
			}
		}
		
		if(checksubmit('delete')){
			pdo_delete($this->table_category, " id  IN  ('".implode(",", $_GPC['select'])."')");
			message('删除成功',referer(),'success');
		}
		
		//增加父栏目
		$categorys = pdo_fetchall("SELECT * FROM".tablename($this->table_category)."WHERE weid = :weid AND parentid = 0", array(':weid' => $this->weid));
		
		include $this->template('category');
	}

	public function doMobileMap() 
	{
		//这个操作被定义用来呈现 功能封面
		global $_W, $_GPC;
		$cfg=$this->module['config'];
		if(empty($cfg['icon']))
		{
			$icon = tomedia('./addons/wx_lbsmap/icon.jpg');
		}
		else
		{
			$icon =$_W['attachurl'].$cfg['icon'];
		}
		if(empty($cfg['marker']))
		{
			$marker = tomedia('./addons/wx_lbsmap/images/lbs.png');
		}
		else
		{
			$marker =$_W['attachurl'].$cfg['marker'];
		}

		$diyurl_name=mb_strlen($cfg['diyurl_name'], 'utf-8') > 6 ? mb_substr($cfg['diyurl_name'], 0, 6, 'utf-8').'...' : $cfg['diyurl_name'];
		$diyurl=$cfg['diyurl'];
		$latflag='lat_'.$_W['uniacid'];
		$lngflag='lng_'.$_W['uniacid'];

		if(empty($cfg['lat'])||empty($cfg['lng']))
		{
			$lat = trim($_GPC['lat']);
			$lng = trim($_GPC['lng']);
		}
		else
		{
			$lat=$cfg['lat'];
			$lng=$cfg['lng'];
		}
		if (!empty($lat) && !empty($lng)) {
			setcookie($latflag, $lat, TIMESTAMP + 5);
			setcookie($lngflag, $lng, TIMESTAMP + 5);
		} else {
			if (isset($_COOKIE[$latflag])) {
				$lat = $_COOKIE[$latflag];
				$lng = $_COOKIE[$lngflag];
			}
		}

		if (empty($lat) || empty($lng)) 
		{
			$for=$_W['siteroot'] . 'app/' . substr($this->createMobileUrl('getlbs'), 2);
			header('location:' . $for);
		}

		$catenameid=$_GPC['catenameid'];
		$list = pdo_fetchall("SELECT *,(lat-:lat) * (lat-:lat) + (lng-:lng) * (lng-:lng) as dist FROM " . tablename('wx_lbsmap_store') . " where uniacid = :weid ORDER BY dist DESC", array(':weid' => $_W['uniacid'], ':lat' => $lat, ':lng' => $lng));
		$list_getid=pdo_fetchall("SELECT *,(lat-:lat) * (lat-:lat) + (lng-:lng) * (lng-:lng) as dist FROM " . tablename('wx_lbsmap_store') . " where catenameid=:catenameid and uniacid = :weid ORDER BY dist DESC", array(':catenameid'=>$catenameid,':weid' => $_W['uniacid'], ':lat' => $lat, ':lng' => $lng));
		$maps = array();

		if(!empty($catenameid))
		{
				foreach ($list_getid as $key_getid => $value_getid) 
				{
					$maps[] = array(

						'url' => $this->createMobileUrl('detail', array('id' => $value_getid['id']), true),

						'sname' => $value_getid['sname'],

						'saddress' => $value_getid['saddress'],

						'stel' => $value_getid['stel'],

						'sthumb' => tomedia($value_getid['sthumb']),

						'dist' => $this->getDistance($value_getid['lat'], $value_getid['lng'], $lat, $lng) . '千米',

						'oname' => "商家详情",

						'imageOffset' => array('width' => 0, 'height' => 3),

						'position' => array('lat' => $value_getid['lat'], 'lng' => $value_getid['lng']),

						'showc'=>$value_getid['showc'],

						'cthumb' => tomedia($value_getid['cthumb']),

						'cname'=>$value_getid['cname'],

						'info'=>$value_getid['cinfo'],

						'level'=>$value_getid['clevel'],

						'ctel'=>$value_getid['ctel'],

						'showbtn'=>$value_getid['showbtn'],

						'diyurl_name'=>$value_getid['diyurl_name'],

						'diyurl'=>$value_getid['diyurl'],

					);
				}
		}
		else
		{
				foreach ($list as $key => $value) 
				{
					$maps[] = array(

						'url' => $this->createMobileUrl('detail', array('id' => $value['id']), true),

						'sname' => $value['sname'],

						'saddress' => $value['saddress'],

						'stel' => $value['stel'],

						'sthumb' => tomedia($value['sthumb']),

						'dist' => $this->getDistance($value['lat'], $value['lng'], $lat, $lng) . '千米',

						'oname' => "商家详情",

						'imageOffset' => array('width' => 0, 'height' => 3),

						'position' => array('lat' => $value['lat'], 'lng' => $value['lng']),

						'showc'=>$value['showc'],

						'cthumb' => tomedia($value['cthumb']),

						'cname'=>$value['cname'],

						'info'=>$value['cinfo'],

						'level'=>$value['clevel'],

						'ctel'=>$value['ctel'],

						'showbtn'=>$value['showbtn'],

						'diyurl_name'=>$value['diyurl_name'],

						'diyurl'=>$value['diyurl'],

					);
				}
		}
		$menu=pdo_fetchall("select * from ".tablename('wx_lbsmap_category')." where weid=:weid and parentid=0 limit 3",array(":weid"=>$_W['uniacid']));
		for($i=0;$i<count($menu);$i++)
		{
			$sub_menu[$i]=pdo_fetchall("select * from ".tablename('wx_lbsmap_category')." where weid=:weid and parentid=:pid",array(":weid"=>$_W['uniacid'],":pid"=>$menu[$i]['id']));
		}
		if(count($menu)>0)
		{
			$width=sprintf("%.2f",100/count($menu));
		}
		else
		{
			$width=100;
		}
		$category = pdo_fetchall("SELECT * FROM " . tablename('wx_lbsmap_classify') . " where weid = ".$_W['uniacid']);

		$json_maps = json_encode($maps);
		if(empty($cfg['level']))
		{
			$level=15;
		}
		else
		{
			$level=$cfg['level'];
		}
		$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		if($cfg['template']=='1')
		{

			include $this -> template ('map_new');

		}
		else
		{
			include $this -> template ('map_classical');
		}

		

	}

	public function doWebStore() {

		//这个操作被定义用来呈现 管理中心导航菜单

		global $_W, $_GPC;

		empty($_GPC['op'])?$operation='display':$operation=$_GPC['op'];

		if($operation=='edit')

		{

			if(!empty($_GPC['sid']))

			{

				$list=pdo_fetch("select * from ".tablename('wx_lbsmap_store')." where id=:sid and uniacid=:weid",array(':sid'=>$_GPC['sid'],':weid'=>$_W['uniacid']));

			}

			if (checksubmit('submit'))

			{

				$data = array

				(

					'uniacid'=>intval($_W['uniacid']),

					'sthumb'=>trim($_GPC['sthumb']),

					'sname'=>trim($_GPC['sname']),

					'stel'=>trim($_GPC['stel']),

					'saddress'=>trim($_GPC['saddress']),

					'lat'=>trim($_GPC['baidumap']['lat']),

					'lng'=>trim($_GPC['baidumap']['lng']),

					'showc'=>intval($_GPC['showc']),

					'cname'=>trim($_GPC['cname']),

					'cthumb'=>trim($_GPC['cthumb']),

					'ctel'=>trim($_GPC['ctel']),

					'cinfo'=>trim($_GPC['cinfo']),

					'clevel'=>intval($_GPC['clevel']),

					'showbtn'=>intval($_GPC['showbtn']),

					'diyurl_name'=>trim($_GPC['diyurl_name']),

					'diyurl'=>trim($_GPC['diyurl']),

					'catenameid'=>trim($_GPC['catenameid']),

				);

				if(!empty($list))

				{

					pdo_update('wx_lbsmap_store', $data, array('id' => $_GPC['sid']));

				}

				else

				{

					pdo_insert('wx_lbsmap_store',$data);

				}

				message('门店信息保存成功！', $this -> createWebUrl('store',array('op'=>'display')), 'success');

			}

		}

		elseif($operation=='display')

		{

			$search=trim($_GPC['search']);

			$searchid=$_GPC['searchid'];

			$sqlzhuru=intval($searchid);

			$where='';

			if(!empty($search))

			{

				$where.=" and a.sname like '%{$search}%'";

			}

			if(!empty($searchid))

			{

				$where.=" and a.catenameid = '{$sqlzhuru}'";

			}

			$lists=pdo_fetchall("SELECT a.*,b.catename FROM " . tablename('wx_lbsmap_store') . " a left join ".tablename('wx_lbsmap_classify')." b on b.id=a.catenameid where a.uniacid=:weid".$where,array(':weid'=>$_W['uniacid']));

			

			

		}

		elseif($operation=='delete')

		{

			if(empty($_GPC['sid']))

			{

				message('指定的门店信息不正确，请检查！', $this -> createWebUrl('store',array('op'=>'display')),'error');

			}else

			{

				pdo_delete('wx_lbsmap_store',array('id'=>$_GPC['sid'],'uniacid'=>$_W['uniacid']));

				message('指定门店信息已删除！',$this -> createWebUrl('store',array('op'=>'display')),'success');

			}

			

		}

	

		$category = pdo_fetchall("SELECT * FROM " . tablename('wx_lbsmap_classify') . " where weid = ".$_W['uniacid']);

		

		$getid=pdo_fetch("SELECT b.id FROM " . tablename('wx_lbsmap_store') . " a join ".tablename('wx_lbsmap_classify')." b on b.id=a.catenameid where a.id=:sid and uniacid=:weid",array(':sid'=>$_GPC['sid'],':weid'=>$_W['uniacid']));

		

		include $this -> template ('store');

	}

	public function doWebClassify() {

		

		global $_W, $_GPC;

        $weid = $_W['uniacid'];

        checklogin();

        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

        if ($operation == 'display'){

            if (!empty($_GPC['displayorder'])){

                foreach ($_GPC['displayorder'] as $id => $displayorder){

                    pdo_update('wx_lbsmap_classify', array('displayorder' => $displayorder), array('id' => $id));

                }

                message('更新成功！', $this -> createWebUrl('classify', array('op' => 'display')), 'success');

            }

            $category = pdo_fetchall("SELECT * FROM " . tablename('wx_lbsmap_classify') . " WHERE weid = '{$_W['weid']}' ORDER BY displayorder DESC,id ASC");



        }elseif ($operation == 'post'){

            $id = intval($_GPC['id']);

            if (!empty($id)){

                $category = pdo_fetch("SELECT * FROM " . tablename('wx_lbsmap_classify') . " WHERE id = '$id'");

            }else{

                $category = array('displayorder' => 0, 'enabled' => 1,);

            }

            if (checksubmit('submit')){

                if (empty($_GPC['catename'])){

                    message('抱歉，请输入分类名称！');

                }

                $temp = pdo_fetch("SELECT id FROM " . tablename('wx_lbsmap_classify') . " WHERE weid=" . $weid . " AND catename='" . $_GPC['catename'] . "'");

                if(!empty($temp) && $id != $temp['id']){

                    message('已存在该分类！', $this -> createWebUrl('classify', array('op' => 'display')), 'error');

                }

                $data = array('weid' => $_W['weid'], 'catename' => $_GPC['catename'], 'enabled' => intval($_GPC['enabled']), 'displayorder' => intval($_GPC['displayorder']),);

                if (!empty($id)){

                    pdo_update('wx_lbsmap_classify', $data, array('id' => $id));

                }else{

                    pdo_insert('wx_lbsmap_classify', $data);

                    $id = pdo_insertid();

                }

                message('更新成功！', $this -> createWebUrl('classify', array('op' => 'display')), 'success');

            }



        }elseif ($operation == 'delete'){

            $id = intval($_GPC['id']);

            $category = pdo_fetch("SELECT id FROM " . tablename('wx_lbsmap_classify') . " WHERE id = '$id'");

            if (empty($category)){

                message('抱歉，该分类不存在或是已经被删除！', $this -> createWebUrl('classify', array('op' => 'display')), 'error');

            }

            pdo_delete('wx_lbsmap_classify', array('id' => $id));

            message('删除成功！', $this -> createWebUrl('classify', array('op' => 'display')), 'success');

        }

		include $this -> template ('classify');

	}



}