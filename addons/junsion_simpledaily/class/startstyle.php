<?php
global $_W;
$dir = IA_ROOT."/addons/junsion_simpledaily/style";
if(is_dir($dir)){
	$titles = array('标准','开学季','七夕','彩虹','书信','梦幻','神秘','可爱','云层','古朴','原木','童话','复古','浪漫','华丽','纯真','自然','气泡','夏天','中秋');
	$list = pdo_fetch("select id from ".tablename($this->modulename.'_style')." where weid='{$_W['uniacid']}' limit 1"); 
	if (!$list) {
		$count = 20;
		for ($i=1;$i<=$count;$i++){
			pdo_insert($this->modulename.'_style',array(
					'weid' => $_W['uniacid'],
					'title' => $titles[$i-1],
					'path' => STYLEPATH.'style'.$i,
					'sort' => 0,
					'status' => 1,
					'createtime' => time(),
			));
		}
		message('初始化模板成功！',referer(),'success');
	}else{
		message('已初始化模板了！',referer(),'error');
	}
}else{
	message('请先上传模板文件！',referer(),'error');
}