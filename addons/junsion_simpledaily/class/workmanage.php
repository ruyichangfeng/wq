<?php
global $_W,$_GPC;

$op = $_GPC['op'] ? $_GPC['op'] : 'display';
$id = $_GPC['id'];

if ($op == 'display'){
	if (checksubmit('submit')){
		foreach ($_GPC['sort'] as $wid => $sort){
			pdo_update($this->modulename.'_works',array('sort'=>$sort),array('id'=>$wid));
		}
		message('修改排序成功！',referer(),'success');
	}
	$titles = array('标准','开学季','七夕','彩虹','书信','梦幻','神秘','可爱','云层','古朴','原木','童话','复古','浪漫','华丽','纯真','自然','气泡','夏天','中秋');
	$pindex = max(1,$_GPC['page']);
	$psize = 20;
	$condition = '';
	$title = $_GPC['title'];
	$style = $_GPC['style'];
	$nickname = $_GPC['nickname'];
	if (!empty($title)) $condition .= " and w.title like '%{$title}%'";
	if (!empty($style)) $condition .= " and s.title='{$style}'";
	if (!empty($nickname)) $condition .= " and w.nickname like '%{$nickname}%'";
	if (!empty($_GPC['mid'])) $condition .= " and openid='{$_GPC['mid']}'";
	$list = pdo_fetchall("select w.*,s.title as stitle from ".tablename($this->modulename.'_works')." w left join ".tablename($this->modulename.'_style')." s on s.id=w.styleid where w.weid='{$_W['uniacid']}' {$condition} order by w.sort desc, w.good desc, w.createtime desc limit ".($pindex-1)*$psize.",".$psize);
	$total = pdo_fetchcolumn("select count(1) from ".tablename($this->modulename.'_works')." w join ".tablename($this->modulename.'_style')." s on s.id=w.styleid where w.weid='{$_W['uniacid']}' {$condition}");
	$pager = pagination($total, $pindex, $psize);
}elseif ($op == 'del'){
	$id = $_GPC['id'];
	$works = pdo_fetch("select * from " . tablename($this->modulename.'_works') . " where id = '{$id}'");
	if(empty($works)){
		message('抱歉！该简记不存在或已删除',referer(),'error');
	}
	if(pdo_delete($this->modulename.'_works',array('id'=>$id))){
		message('删除成功',referer(),'success');
	}else{
		message('删除失败',referer(),'error');
	}
}elseif ($op == 'setStatus'){
	$data = $_GPC['data'];
	$data = abs($data-1);
	pdo_update($this->modulename.'_works',array('status'=>$data),array('id'=>$id));
	die(json_encode(array('data'=>$data)));
}elseif ($op == 'setFind'){
	$data = $_GPC['data'];
	$data = abs($data-1);
	pdo_update($this->modulename.'_works',array('find'=>$data),array('id'=>$id));
	die(json_encode(array('data'=>$data)));
}

include $this->template('workmanage');