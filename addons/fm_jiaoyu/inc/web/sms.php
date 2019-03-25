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
		$item = pdo_fetch("SELECT id,sms_acss FROM " . tablename($this->table_set) . " WHERE weid = :weid ",array(':weid' => $weid));	
		$bdset = unserialize($item['sms_acss']);
		if(checksubmit('submit')){
			$id = intval($_GPC['id']);
			$temp = array(
				'is_sms'   	=> intval($_GPC['is_sms']),
				'show_res'   	=> intval($_GPC['show_res']),
				'accessKeyId'   => trim($_GPC['accessKeyId']),
				'accessKeySecret'  => trim($_GPC['accessKeySecret']),
			);
			$data['sms_acss'] = serialize($temp);
			if($temp['is_sms'] == 1){
				if(empty($temp['accessKeyId']) || empty($temp['accessKeySecret'])){
					message('启用短信验证码时，请完善短信相关设置', referer(), 'error');
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
	} elseif ($operation == 'display1'){
		$pindex    = max(1, intval($_GPC['page']));
		$psize     = 20;			
		$schoolist = pdo_fetchall("SELECT id,title,sms_use_times,sms_rest_times FROM " . tablename($this->table_index) . " WHERE weid = '{$weid}' ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_index) . " WHERE weid = '{$weid}' $condition ");
		$pager = pagination($total, $pindex, $psize);		
	} elseif ($operation == 'display2'){
		$pindex    = max(1, intval($_GPC['page']));
		$psize     = 20;
		$condition = '';
		if(!empty($_GPC['status'])){
			$status     = $_GPC['status'];
			$condition .= " AND status = '{$status}' ";
		}
		if(!empty($_GPC['mobile'])){
			$mobile     = trim($_GPC['mobile']);
			$condition .= " AND mobile = '{$mobile}' ";
		}		
		mload()->model('sms');
		$schoolid = intval($_GPC['schoolid']);
		$smslog  = pdo_fetchall("SELECT * FROM " . tablename('wx_school_sms_log') . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);		
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('wx_school_sms_log') . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ");
		$pager = pagination($total, $pindex, $psize);		
	} else{
		message('操作失败, 非法访问.');
	}
        
   include $this->template ( 'web/sms' );
?>