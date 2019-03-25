<?php
global $_W,$_GPC;

require_once dirname(__FILE__).'/common_mobile.php';


list($data_matches,$data_total)=getinfo('qiandao','签到');

if($data_total){	
	include $this->template('getqiandaoinfo');
}else{
	message('尚没有签到数据', $this->createMobileUrl('qiandao', array()), 'error');
}
