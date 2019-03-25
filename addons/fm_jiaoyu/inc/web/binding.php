<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

        global $_GPC, $_W;
		$weid = $_W['uniacid'];
		load()->func('tpl');

        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';    
        if ($operation == 'display') {
			load()->func('tpl');
			
			$item = pdo_fetch("SELECT id,bd_set,sms_use_times FROM " . tablename($this->table_set) . " WHERE weid = :weid ",array(':weid' => $weid));
			$bdset = unserialize($item['bd_set']);
			if(checksubmit('submit')){
				$id = intval($_GPC['id']);
				$temp = array(
					'bd_type'   	=> intval($_GPC['bd_type']),
					'binding_sms'   => intval($_GPC['binding_sms']),
					'code_time' 	=> trim($bdset['code_time']),
					'sms_SignName'  => trim($bdset['sms_SignName']),
					'sms_Code' 		=> trim($bdset['sms_Code']),
				);
				$data['bd_set'] = serialize($temp);
				if($temp['binding_sms'] == 1){
					if(empty($temp['sms_SignName']) || empty($temp['sms_Code'])){
						message('启用短信验证码时，请完善短信相关设置', referer(), 'error');
					}
					if($temp['code_time'] < 300){
						message('短信有效时间建议设置为大于5分钟', referer(), 'error');
					}					
				}
				if(!empty($id)){
					pdo_update($this->table_set, $data, array('id' => $id));
				}else{
					$data['weid'] = $weid;
					pdo_insert($this->table_set, $data);
				}
				message('设置成功', '', 'success');
			}
        } else{
			message('操作失败, 非法访问.');
		}			
		
   include $this->template ( 'web/binding' );
?>