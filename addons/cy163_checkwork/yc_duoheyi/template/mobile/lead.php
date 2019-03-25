<?php
    global $_GPC, $_W;
    $rid = intval($_GPC['rid']);
    if (empty($rid)) 
    {
        message('抱歉，坐标不存在或是已经删除！', '', 'error');
    }
	$lng=$this->module['config']['map']['lng'];
	$lat=$this->module['config']['map']['lat']; 
    if (empty($this->module['config']['map']))
    {
        message('抱歉，坐标不存在或是已经删除！', '', 'error');
    }

    $url = "http://api.map.baidu.com/marker?location=".$lat.",".$lng."&title=".$this->module['config']['name']."&output=html";


    header('Location: '. $url);
    exit;

?>
