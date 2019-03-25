<?php
/**
 * [woniu] Copyright (c) 2016/8/18
 */
defined('IN_IA') or exit('Access Denied');
/********************web页面跳转************************/
function fx_template_compat($filename) {
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

function fx_template($filename, $flag = TEMPLATE_DISPLAY) {
	global $_W, $_GPC;
	$name = MODULE_NAME;
	$source = IA_ROOT . "/addons/{$name}/template/mobile/{$filename}.html";
	$compile = IA_ROOT . "/data/tpl/app/{$name}/app/{$filename}.tpl.php";
	if(!is_file($source)) {
		$compatFilename = fx_template_compat($filename);
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
		fx_template_compile($source, $compile);
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

function fx_template_compile($from, $to) {
	$path = dirname($to);
	if (!is_dir($path)) {
		load()->func('file');
		mkdirs($path);
	}
	$content = fx_template_parse(file_get_contents($from));
	file_put_contents($to, $content);
}

function fx_template_parse($str) {
	$str = preg_replace('/<!--{(.+?)}-->/s', '{$1}', $str);
	$str = preg_replace('/{fx_template\s+(.+?)}/', '<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->fx_template($1, TEMPLATE_INCLUDEPATH)) : (include fx_template($1, TEMPLATE_INCLUDEPATH));?>', $str);
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
	$str = preg_replace_callback('/{data\s+(.+?)}/s', "fx_moduledata", $str);
	$str = preg_replace('/{\/data}/', '<?php } } ?>', $str);
	$str = preg_replace_callback('/<\?php([^\?]+)\?>/s', "fx_template_addquote", $str);
	$str = preg_replace('/{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)}/s', '<?php echo $1;?>', $str);
	$str = str_replace('{##', '{', $str);
	$str = str_replace('##}', '}', $str);
	if (!empty($GLOBALS['_W']['setting']['remote']['type'])) {
		$str = str_replace('</body>', "<script>var imgs = document.getElementsByTagName('img');for(var i=0, len=imgs.length; i < len; i++){imgs[i].onerror = function() {if (!this.getAttribute('check-src') && (this.src.indexOf('http://') > -1 || this.src.indexOf('https://') > -1)) {this.src = this.src.indexOf('{$GLOBALS['_W']['attachurl_local']}') == -1 ? this.src.replace('{$GLOBALS['_W']['attachurl_remote']}', '{$GLOBALS['_W']['attachurl_local']}') : this.src.replace('{$GLOBALS['_W']['attachurl_local']}', '{$GLOBALS['_W']['attachurl_remote']}');this.setAttribute('check-src', true);}}}</script></body>", $str);
	}
	$str = "<?php defined('IN_IA') or exit('Access Denied');?>" . $str;
	return $str;
}


function fx_template_addquote($matchs) {
	$code = "<?php {$matchs[1]}?>";
	$code = preg_replace('/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\](?![a-zA-Z0-9_\-\.\x7f-\xff\[\]]*[\'"])/s', "['$1']", $code);
	return str_replace('\\\"', '\"', $code);
}


function fx_moduledata($params = '') {
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
		unset($data['module']);
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
	$php = "<?php \${$assign} = fx_modulefunc('$modulename', '{$funcname}', {$variable}); ";
	if (empty($return)) {
		$php .= "if(is_array(\${$assign})) { \$i=0; foreach(\${$assign} as \$i => \${$item}) { \$i++; \${$item}['{$data['index']}'] = \$i; ";
	}
	$php .= "?>";
	return $php;
}

function fx_modulefunc($modulename, $funcname, $params) {
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