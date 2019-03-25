<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

function template_compat($filename) {
	static $mapping = array(
		'home/home' => 'index',
		'header' => 'common/header',
		'footer' => 'common/footer',
		'slide' => 'common/slide',
	);
	if(!empty($mapping[$filename])) {
		return $mapping[$filename];
	}
	return '';
}

function template_page($id, $flag = TEMPLATE_DISPLAY) {
	global $_W;
	$page = pdo_fetch("SELECT * FROM ".tablename('site_page')." WHERE id = :id LIMIT 1", array(':id' => $id));
	if (empty($page)) {
		return error(1, 'Error: Page is not found');
	}
	if (empty($page['html'])) {
		return '';
	}
	$page['params'] = json_decode($page['params'], true);
	$GLOBALS['title'] = $page['title'];
	$GLOBALS['_share'] = array('desc' => $page['description'], 'title' => $page['title'], 'imgUrl' => tomedia($page['params']['0']['params']['thumb']));;

	$compile = IA_ROOT . "/data/tpl/app/{$id}.{$_W['template']}.tpl.php";
	$path = dirname($compile);
	if (!is_dir($path)) {
		load()->func('file');
		mkdirs($path);
	}
	$content = template_parse($page['html']);
	if (!empty($page['params'][0]['params']['bgColor'])) {
		$content .= '<style>body{background-color:'.$page['params'][0]['params']['bgColor'].' !important;}</style>';
	}
	$content .= '<script type="text/javascript"> var scale = 1, marginLeft, marginTop; var width = window.screen.width; var height = window.screen.height; width / height > 320 / 568 ? (scale = height / 568,  marginLeft = (width / scale - 320) / 2) : (scale = width / 320, marginTop = (height / scale - 568) / 2); window != window.top && $(".container").css({width: "100%", height: "100%", overflow: "hidden", "transform-origin": "top left", transform: "scale(" + scale + ")"}); $(".container div").eq(0).css({"marginTop" : marginTop, "marginLeft": marginLeft}); $("meta[name='."'".'viewport'."'".']").attr("content", "width=320, initial-scale=" + scale + ", maximum-scale=" + scale + ", user-scalable=no"); </script>';
	file_put_contents($compile, $content);
	switch ($flag) {
		case TEMPLATE_DISPLAY:
		default:
			extract($GLOBALS, EXTR_SKIP);
			template('common/header');
			include $compile;
			template('common/footer');
			break;
		case TEMPLATE_FETCH:
			extract($GLOBALS, EXTR_SKIP);
			ob_clean();
			ob_start();
			include $compile;
			$contents = ob_get_contents();
			ob_clean();
			return $contents;
			break;
		case TEMPLATE_INCLUDEPATH:
			return $compile;
			break;
	}
}

function template($filename, $flag = TEMPLATE_DISPLAY) {
	global $_W, $_GPC;
	$source = IA_ROOT . "/app/themes/{$_W['template']}/{$filename}.html";
	$compile = IA_ROOT . "/data/tpl/app/{$_W['template']}/{$filename}.tpl.php";
	if(!is_file($source)) {
		$compatFilename = template_compat($filename);
		if(!empty($compatFilename)) {
			return template($compatFilename, $flag);
		}
	}
	if(!is_file($source)) {
		$source = IA_ROOT . "/app/themes/default/{$filename}.html";
		$compile = IA_ROOT . "/data/tpl/app/default/{$filename}.tpl.php";
	}

	if(!is_file($source)) {
		exit("Error: template source '{$filename}' is not exist!");
	}
	$paths = pathinfo($compile);
	$compile = str_replace($paths['filename'], $_W['uniacid'] . '_' . intval($_GPC['t']) . '_' . $paths['filename'], $compile);

	if(DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile)) {
		template_compile($source, $compile);
	}
	switch ($flag) {
		case TEMPLATE_DISPLAY:
		default:
			extract($GLOBALS, EXTR_SKIP);
			include $compile;
			break;
		case TEMPLATE_FETCH:
			extract($GLOBALS, EXTR_SKIP);
			ob_clean();
			ob_start();
			include $compile;
			$contents = ob_get_contents();
			ob_clean();
			return $contents;
			break;
		case TEMPLATE_INCLUDEPATH:
			return $compile;
			break;
	}
}

function template_compile($from, $to) {
	$path = dirname($to);
	if (!is_dir($path)) {
		load()->func('file');
		mkdirs($path);
	}
	$content = template_parse(file_get_contents($from));
	file_put_contents($to, $content);
}

function template_parse($str) {
	$str = preg_replace('/<!--{(.+?)}-->/s', '{$1}', $str);
	$str = preg_replace('/{template\s+(.+?)}/', '<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template($1, TEMPLATE_INCLUDEPATH)) : (include template($1, TEMPLATE_INCLUDEPATH));?>', $str);
	$str = preg_replace('/{php\s+(.+?)}/', '<?php $1?>', $str);
	$str = preg_replace('/{if\s+(.+?)}/', '<?php if($1) { ?>', $str);
	$str = preg_replace('/{else}/', '<?php } else { ?>', $str);
	$str = preg_replace('/{else ?if\s+(.+?)}/', '<?php } else if($1) { ?>', $str);
	$str = preg_replace('/{\/if}/', '<?php } ?>', $str);
	$str = preg_replace('/{loop\s+(\S+)\s+(\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2) { ?>', $str);
	$str = preg_replace('/{loop\s+(\S+)\s+(\S+)\s+(\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2 => $3) { ?>', $str);
	$str = preg_replace('/{\/loop}/', '<?php } } ?>', $str);
	$str = preg_replace('/{(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)}/', '<?php echo $1;?>', $str);
	$str = preg_replace('/{(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff\[\]\'\"\$]*)}/', '<?php echo $1;?>', $str);
	$str = preg_replace('/{url\s+(\S+)}/', '<?php echo url($1);?>', $str);
	$str = preg_replace('/{url\s+(\S+)\s+(array\(.+?\))}/', '<?php echo url($1, $2);?>', $str);
	$str = preg_replace('/{media\s+(\S+)}/', '<?php echo tomedia($1);?>', $str);
	$str = preg_replace_callback('/{data\s+(.+?)}/s', "moduledata", $str);
	$str = preg_replace('/{\/data}/', '<?php } } ?>', $str);
	$str = preg_replace_callback('/<\?php([^\?]+)\?>/s', "template_addquote", $str);
	$str = preg_replace('/{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)}/s', '<?php echo $1;?>', $str);
	$str = str_replace('{##', '{', $str);
	$str = str_replace('##}', '}', $str);
	if (!empty($GLOBALS['_W']['setting']['remote']['type'])) {
		$str = str_replace('</body>', "<script>var imgs = document.getElementsByTagName('img');for(var i=0, len=imgs.length; i < len; i++){imgs[i].onerror = function() {if (!this.getAttribute('check-src') && (this.src.indexOf('http://') > -1 || this.src.indexOf('https://') > -1)) {this.src = this.src.indexOf('{$GLOBALS['_W']['attachurl_local']}') == -1 ? this.src.replace('{$GLOBALS['_W']['attachurl_remote']}', '{$GLOBALS['_W']['attachurl_local']}') : this.src.replace('{$GLOBALS['_W']['attachurl_local']}', '{$GLOBALS['_W']['attachurl_remote']}');this.setAttribute('check-src', true);}}}</script></body>", $str);
	}
	$str = "<?php defined('IN_IA') or exit('Access Denied');?>" . $str;
	return $str;
}

function template_addquote($matchs) {
	$code = "<?php {$matchs[1]}?>";
	$code = preg_replace('/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\](?![a-zA-Z0-9_\-\.\x7f-\xff\[\]]*[\'"])/s', "['$1']", $code);
	return str_replace('\\\"', '\"', $code);
}


function moduledata($params = '') {
	if (empty($params[1])) {
		return '';
	}
	$params = explode(' ', $params[1]);
	if (empty($params)) {
		return '';
	}
	$data = array();
	foreach ($params as $row) {
		$row = explode('=', $row);
		$data[$row[0]] = str_replace(array("'", '"'), '', $row[1]);
	}
	$funcname = $data['func'];
	$assign = !empty($data['assign']) ? $data['assign'] : $funcname;
	$item = !empty($data['item']) ? $data['item'] : 'row';
	$data['limit'] = !empty($data['limit']) ? $data['limit'] : 10;
	if (empty($data['return']) || $data['return'] == 'false') {
		$return = false;
	} else {
		$return = true;
	}
	$data['index'] = !empty($data['index']) ? $data['index'] : 'iteration';
	if (!empty($data['module'])) {
		$modulename = $data['module'];
	} else {
		list($modulename) = explode('_', $data['func']);
	}
	$data['multiid'] = intval($_GET['t']);
	$data['uniacid'] = intval($_GET['i']);
	$data['acid'] = intval($_GET['j']);

	if (empty($modulename) || empty($funcname)) {
		return '';
	}
	$variable = var_export($data, true);
	$variable = preg_replace("/'(\\$[a-zA-Z_\x7f-\xff\[\]\']*?)'/", '$1', $variable);
	$php = "<?php \${$assign} = modulefunc('$modulename', '{$funcname}', {$variable}); ";
	if (empty($return)) {
		$php .= "if(is_array(\${$assign})) { \$i=0; foreach(\${$assign} as \$i => \${$item}) { \$i++; \${$item}['{$data['index']}'] = \$i; ";
	}
	$php .= "?>";
	return $php;
}

function modulefunc($modulename, $funcname, $params) {
	static $includes;

	$includefile = '';
	if (!function_exists($funcname)) {
		if (!isset($includes[$modulename])) {
			if (!file_exists(IA_ROOT . '/addons/'.$modulename.'/model.php')) {
				return '';
			} else {
				$includes[$modulename] = true;
				include_once IA_ROOT . '/addons/'.$modulename.'/model.php';
			}
		}
	}

	if (function_exists($funcname)) {
		return call_user_func_array($funcname, array($params));
	} else {
		return array();
	}
}


function site_navs($params = array()) {
	global $_W, $multi, $cid, $ishomepage;
	$condition = '';
	if(!$cid || !$ishomepage) {
		if (!empty($params['section'])) {
			$condition = " AND section = '".intval($params['section'])."'";
		}
		if(empty($params['multiid'])) {
			load()->model('account');
			$setting = uni_setting($_W['uniacid']);
			$multiid = $setting['default_site'];
		} else{
			$multiid = intval($params['multiid']);
		}
		$navs = pdo_fetchall("SELECT id, name, description, url, icon, css, position, module FROM ".tablename('site_nav')." WHERE position = '1' AND status = 1 AND uniacid = '{$_W['uniacid']}' AND multiid = '{$multiid}' $condition ORDER BY displayorder DESC, id DESC");
	} else {
		$condition = " AND parentid = '".$cid."'";
		$navs = pdo_fetchall("SELECT * FROM ".tablename('site_category')." WHERE enabled = '1' AND uniacid = '{$_W['uniacid']}' $condition ORDER BY displayorder DESC, id DESC");
	}
	if(!empty($navs)) {
		foreach ($navs as &$row) {
			if(!$cid || !$ishomepage) {
				if (!strexists($row['url'], 'tel:') && !strexists($row['url'], '://') && !strexists($row['url'], 'www') && !strexists($row['url'], 'i=')) {
					$row['url'] .= strexists($row['url'], '?') ?  '&i='.$_W['uniacid'] : '?i='.$_W['uniacid'];
				}
			} else {
				if(empty($row['linkurl']) || (!strexists($row['linkurl'], 'http://') && !strexists($row['linkurl'], 'https://'))) {
					$row['url'] = murl('site/site/list', array('cid' => $row['id']));
				} else {
					$row['url'] = $row['linkurl'];
				}
			}
			$row['css'] = unserialize($row['css']);
			if(empty($row['css']['icon']['icon'])){
				$row['css']['icon']['icon'] = 'fa fa-external-link';
			}
			$row['css']['icon']['style'] = "color:{$row['css']['icon']['color']};font-size:{$row['css']['icon']['font-size']}px;";
			$row['css']['name'] = "color:{$row['css']['name']['color']};";
			$row['html'] = '<a href="'.$row['url'].'" class="box-item">';
			$row['html'] .= '<i '.(!empty($row['icon']) ? "style=\"background:url('".tomedia($row['icon'])."') no-repeat;background-size:cover;\" class=\"icon\"" : "class=\"fa {$row['css']['icon']['icon']} \" style=\"{$row['css']['icon']['style']}\"").'></i>';
			$row['html'] .= "<span style=\"{$row['css']['name']}\" title=\"{$row['name']}\">{$row['name']}</span></a>";
		}
		unset($row);
	}
	return $navs;
}

function site_article($params = array()) {
	global $_GPC, $_W;
	extract($params);
	$pindex = max(1, intval($_GPC['page']));
	if (!isset($limit)) {
		$psize = 10;
	} else {
		$psize = intval($limit);
		$psize = max(1, $limit);
	}
	$result = array();

	$condition = " WHERE uniacid = :uniacid ";
	$pars = array(':uniacid' => $_W['uniacid']);
	if (!empty($cid)) {
		$category = pdo_fetch("SELECT parentid FROM ".tablename('site_category')." WHERE id = :id", array(':id' => $cid));
		if (!empty($category['parentid'])) {
			$condition .= " AND ccate = :ccate ";
			$pars[':ccate'] = $cid;
		} else {
			$condition .= " AND pcate = :pcate AND ccate = 0";
			$pars[':pcate'] = $cid;
		}
	}
	if ($iscommend == 'true') {
		$condition .= " AND iscommend = '1'";
	}
	if ($ishot == 'true') {
		$condition .= " AND ishot = '1'";
	}
	$sql = "SELECT * FROM ".tablename('site_article'). $condition. ' ORDER BY displayorder DESC, id DESC LIMIT ' . ($pindex - 1) * $psize .',' .$psize;
	$result['list'] = pdo_fetchall($sql, $pars);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('site_article') . $condition, $pars);
	$result['pager'] = pagination($total, $pindex, $psize);
	if (!empty($result['list'])) {
		foreach ($result['list'] as &$row) {
			if(empty($row['linkurl'])) {
				$row['linkurl'] = murl('site/site/detail', array('id' => $row['id'], 'uniacid' => $_W['uniacid']));
			}
			$row['thumb'] = tomedia($row['thumb']);
		}
	}
	return $result;
}

function site_category($params = array()) {
	global $_GPC, $_W;
	extract($params);
	if (!isset($parentid)) {
		$condition = "";
	} else {
		$parentid = intval($parentid);
		$condition = " AND parentid = '$parentid'";
	}
	$category = array();
	$result = pdo_fetchall("SELECT * FROM ".tablename('site_category')." WHERE uniacid = '{$_W['uniacid']}' $condition ORDER BY parentid ASC, displayorder ASC, id ASC ");
	if (!empty($result)) {
		foreach ($result as $row) {
			if(empty($row['linkurl'])) {
				$row['linkurl'] = url('site/site/list', array('cid' =>$row['id']));
			}
			$row['icon'] = tomedia($row['icon']);
			$row['css'] = unserialize($row['css']);
			if(empty($row['css']['icon']['icon'])){
				$row['css']['icon']['icon'] = 'fa fa-external-link';
			}
			$row['css']['icon']['style'] = "color:{$row['css']['icon']['color']};font-size:{$row['css']['icon']['font-size']}px;";
			$row['css']['name'] = "color:{$row['css']['name']['color']};";
			if (!isset($parentid)) {
				if (empty($row['parentid'])) {
					$category[$row['id']] = $row;
				} else {
					$category[$row['parentid']]['children'][$row['id']] = $row;
				}
			} else {
				$category[] = $row;
			}
		}
	}
	return $category;
}

function site_slide_search($params = array()) {
	global $_W;
	if(empty($params['limit'])) {
		$params['limit'] = 4;
	}
	if(empty($params['multiid'])) {
		$multiid = pdo_fetchcolumn('SELECT default_site FROM ' . tablename('uni_settings') . ' WHERE uniacid = :id', array(':id' => $_W['uniacid']));
	} else{
		$multiid = intval($params['multiid']);
	}
	$sql = "SELECT * FROM " . tablename('site_slide') . " WHERE uniacid = '{$_W['uniacid']}' AND multiid = {$multiid} ORDER BY `displayorder` DESC, `id` DESC LIMIT " . intval($params['limit']);
	$list = pdo_fetchall($sql);
	if(!empty($list)) {
		foreach($list as &$row) {
			if (!strexists($row['url'], './')) {
				if (!strexists($row['url'], 'http')) {
					$row['url'] = $_W['sitescheme'] . $row['url'];
				}
			}
			$row['thumb'] = tomedia($row['thumb']);
		}
	}
	return $list;
}

function app_slide($params = array()) {
	return site_slide_search($params);
}

function site_widget_link($params = array()) {
	$widgetparams = json_decode($params['params'], true);
	$sql = 'SELECT * FROM ' .tablename('site_article')." WHERE uniacid = :uniacid ";
	$sqlparams = array(':uniacid' => $params['uniacid']);
	if (!empty($widgetparams['selectCate']['pid'])) {
		$sql .= " AND pcate = :pid";
		$sqlparams[':pid'] = $widgetparams['selectCate']['pid'];
	}
	if (!empty($widgetparams['selectCate']['cid'])) {
		$sql .= " AND ccate = :cid";
		$sqlparams[':cid'] = $widgetparams['selectCate']['cid'];
	}
	if (!empty($widgetparams['iscommend'])) {
		$sql .= " AND iscommend = '1'";
	}
	if (!empty($widgetparams['ishot'])) {
		$sql .= " AND ishot = '1'";
	}
	if (!empty($widgetparams['isnew'])) {
		$sql .= " ORDER BY id DESC ";
	}
	if (!empty($widgetparams['pageSize'])) {
		$limit = intval($widgetparams['pageSize']);
		$sql .= " LIMIT {$limit}";
	}
	$list = pdo_fetchall($sql, $sqlparams);
	if (!empty($list)) {
		foreach ($list as $i => &$row) {
			$row['title'] = cutstr($row['title'], 20, true);
			$row['thumb_url'] = tomedia($row['thumb']);
			$row['url'] = url('site/site/detail', array('id' => $row['id']));
		}
	}
	return (array)$list;
}

function site_quickmenu() {
	global $_W, $_GPC;

	if ($_GPC['c'] == 'mc' || $_GPC['c'] == 'activity') {
		$quickmenu = pdo_fetch("SELECT html, params FROM ".tablename('site_page')." WHERE uniacid = :uniacid AND type = '4' AND status = '1'", array(':uniacid' => $_W['uniacid']));
	} elseif ($_GPC['c'] == 'auth') {
		return false;
	} else {
		$multiid = intval($_GPC['t']);
		if (empty($multiid) && !empty($_GPC['__multiid'])) {
			$id = intval($_GPC['__multiid']);
			$site_multi_info = pdo_get('site_multi', array('id' => $id,'uniacid' => $_W['uniacid']));		
			$multiid = empty($site_multi_info) ? '' : $id;
		} else {
			if(!($_GPC['c'] == 'home' && $_GPC['a'] == 'page')){
				isetcookie('__multiid', '');
			}
		}
		if (empty($multiid)) {
			$setting = uni_setting($_W['uniacid'], array('default_site'));
			$multiid = $setting['default_site'];
		}
		$quickmenu = pdo_fetch("SELECT html, params FROM ".tablename('site_page')." WHERE multiid = :multiid AND type = '2' AND status = '1'", array(':multiid' => $multiid));
	}
	if (empty($quickmenu)) {
		return false;
	}
	$quickmenu['params'] = json_decode($quickmenu['params'], true);
	if ($_GPC['c'] == 'home' && $_GPC['a'] != 'page' && empty($quickmenu['params']['position']['homepage'])) {
		return false;
	}
	if ($_GPC['c'] == 'home' && $_GPC['a'] == 'page' && empty($quickmenu['params']['position']['page'])) {
		return false;
	}
	if ($_GPC['c'] == 'site' && empty($quickmenu['params']['position']['article'])) {
		return false;
	}
	if (!empty($_GPC['m']) && !empty($quickmenu['params']['ignoreModules'][$_GPC['m']])) {
		return false;
	}

	echo $quickmenu['html'];
	echo "<script type=\"text/javascript\">
	$('.js-quickmenu').find('a').each(function(){
		if ($(this).attr('href')) {
			var url = $(this).attr('href').replace('./', '');
			if (location.href.indexOf(url) > -1) {
				var onclass = $(this).find('i').attr('js-onclass-name');
				if (onclass) {
					$(this).find('i').attr('class', onclass);
					$(this).find('i').css('color', $(this).find('i').attr('js-onclass-color'));
				}
			}
		}
	});
</script>";
}

function site_cloud_ad($params) {
	global $_W;
	$querystring = array(
		'ad_type' => $params['ad_type'],
		'type' => $params['type'],
		'module' => $params['module'],
		'uniacid' => $_W['uniacid'],
		'site_key' => $_W['setting']['site']['key'],
	);
	$url = 'http://s.we7.cc/index.php?c=store&a=link&do=ad&'.http_build_query($querystring, null, '&');
	load()->func('communication');
	$ret = ihttp_request($url, array(), array(), 20);
	if (is_error($ret)) {
		echo '';
	} else {
	echo <<<EOF
<script type="text/javascript">{$ret['content']}</script>
EOF;
	}
}