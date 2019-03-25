<?php

defined('IN_IA') or exit('Access Denied');

class Xm_housekeepModuleReceiver extends WeModuleReceiver {
	public function receive() {
		global $_W;
		load()->model('mc');
		$fromuser = $this->message['from'];
		//if (empty($fromuser)) {
		//	exit();
		//}
		
		//$type = $this->message['type'];
		if ($this->message['msgtype'] == 'event') 
		{
			if ($this->message['event'] == 'subscribe' || $this->message['event']== 'SCAN')
			{
				$sceneid = str_replace('qrscene_', '',$this->message['scene']);
				if($this->checkopenid($fromuser) == 0){
					$data= array(
							'openid' =>$fromuser,
							'weid' => $_W['uniacid'],
							'fromopenid' => $sceneid,
					        'addtime' =>date("y-m-d H:i:s")
					);
         		  	pdo_insert('xm_housekeep_userfrom', $data);	
				}
				  
			}
		}
	}
	
	
	public function checkopenid($openid){
		global $_W,$_GPC;
		
		$sql = "SELECT id FROM ".tablename('xm_housekeep_userfrom')." WHERE openid='".$openid."' AND weid ='".$_W['uniacid']."'";
		$item = pdo_fetch($sql);
		if(empty($item)){
			return 0;
		}else{
			return 1;
		}
	}
}