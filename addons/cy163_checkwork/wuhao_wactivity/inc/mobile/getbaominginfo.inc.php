<?php
global $_W,$_GPC;

require_once dirname(__FILE__).'/common_mobile.php';



list($data_matches,$data_total)=getinfo('baoming','报名');

if($data_total){	
	include $this->template('getbaominginfo');
}else{
	message('尚没有报名数据', $this->createMobileUrl('baoming', array()), 'error');
}