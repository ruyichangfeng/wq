<?php
/**
 * 积分宝模块微站定义
 *
 * @author 
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
ini_set('date.timezone','Asia/Shanghai');
define('OD_ROOT', IA_ROOT . '/addons/jlsh_code');

class Jlsh_codeModuleSite extends WeModuleSite {
	
	function __construct(){
	
		global $_W;
	
		$this->weid = $_W['uniacid'];
	}
	
	public function doWebJflist(){
		global $_W,$_GPC;
		
		$pindex = max(1, intval($_GPC['page']));
		
		$psize = 20;
		
		$list = pdo_fetchall("SELECT * FROM ".tablename('jc_setting')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");
		
		
		
		if (!empty($list)) {
		
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jc_setting')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC");
		
			$pager = pagination($total, $pindex, $psize);
		
			unset($row);
		
		}
		
		include $this->template('jf-list');
	}
	
	public function doWebJfdelete() {
		global $_W,$_GPC;
	
	
		$id = intval($_GPC['id']);
	
		$setting = pdo_fetch('select * from '.tablename('jc_setting').'where weid = :weid and id = :id',array(":weid" => $_W['uniacid'],":id" => $id));
		
	
		pdo_delete('jc_setting', array('id' => $id));
		pdo_delete("rule",array('id'=>$setting['ruleid']));
		pdo_delete("rule_keyword",array('rid'=>$setting['ruleid']));
		pdo_delete("jc_jilu",array('sid'=>$id));
	
	
		message('删除成功！', $this->createWebUrl('jflist', array()), 'success');
	}
	
	
	public function doWebJfsetting(){
		global $_W,$_GPC;
			
		$id = intval($_GPC['id']);
		
				
		if(!empty($id)){
		
			$kjsetting = pdo_fetch('select * from '.tablename('jc_setting').'where weid = :weid',array(":weid" => $_W['uniacid']));
		
		}
	
		include $this->template('jf-setting');
	}
	
	
	public function doWebJfsettingadd(){
		global $_W,$_GPC;
			
		$id = intval($_GPC['id']);
		

		load()->func('communication');
		
		$qrctype = 1;
			
		$acid = pdo_fetchcolumn("SELECT acid FROM ".tablename('account_wechats')." WHERE uniacid =".$_W['uniacid']);
			
		$uniacccount = WeAccount::create($acid);
			
		if ($qrctype == 1) {
		
			$qrcid = pdo_fetchcolumn("SELECT qrcid FROM ".tablename('qrcode')." WHERE acid = :acid AND model = '1' ORDER BY qrcid DESC LIMIT 1", array(':acid' => $acid));
		
			$barcode['action_info']['scene']['scene_id'] = !empty($qrcid) ? ($qrcid+1) : 100001;
		
			$barcode['expire_seconds'] = 604800;
		
			$barcode['action_name'] = 'QR_SCENE';
		
			$result = $uniacccount->barCodeCreateDisposable($barcode);
		
		} else {
		
			message('抱歉，此公众号暂不支持您请求的二维码类型！');
		
		}
			
		$imgs = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$result['ticket'];
		$scene_id = $barcode['action_info']['scene']['scene_id'];
		$ticketstr = $result['ticket'];
		$urlstr = $result['url'];
		
		
		$rule_data = array(
				'uniacid' => $_W['uniacid'],
				'name' => "二维码积分",
				'module' => "jlsh_code",
				'status' => 1,
				'displayorder' => 254,
		);
		$rule_key = array(
				'uniacid' => $_W['uniacid'],
				'module' => 'jlsh_code',
				'content' => 'jc'.$scene_id,
				'type' => '1',
				'displayorder' => 254,
				'status' => 1
		);
		
		pdo_insert('rule',$rule_data);
		$rid = pdo_insertid();
		$rule_key['rid'] = $rid;
		pdo_insert('rule_keyword',$rule_key);
		
		if (checksubmit('submit')) {
		
			$data = array(
					'weid' => $_W['uniacid'],
						
					'title' => trim($_GPC['title']),
						
					'number' => trim($_GPC['jfnumber']),
											
					'remind' => trim($_GPC['remind']),
					
					'codeurl' => $imgs,
					
					'ruleid' => $rid,
						
					'addtime' => TIMESTAMP
			);
		
			if (!empty($id)) {
		
				pdo_update('jc_setting',$data,array('id'=>$id));
				
				$this->CreateCode($id,$scene_id,$acid,$ticketstr,$urlstr);
				
				message('数据修改成功！', $this->createWebUrl('Jfsetting', array('op' => 'display')), 'success');
			} else {
		
				pdo_insert('jc_setting',$data);
				$jid = pdo_insertid();
				
				$this->CreateCode($jid,$scene_id,$acid,$ticketstr,$urlstr);
				message('数据添加成功！', $this->createWebUrl('Jfsetting', array()), 'success');
			}
			
		}
	}
	
	
	
	public function CreateCode($listid,$scene_id,$acid,$ticketstr,$urlstr){
		global $_W,$_GPC;
		
		
		$qrcode = array(
				'uniacid'=> $_W['uniacid'],
				'acid'=>$acid,
				'qrcid'=>$scene_id,
				'name'=>'二维码积分',
				'keyword'=>"jc".$scene_id,
				'model'=>1,
				'ticket'=>$ticketstr,
				'expire'=>30*24*3600,
				'createtime'=>time(),
				'status'=>1,
				'url'=>$urlstr,
		);
		pdo_insert('qrcode',$qrcode);
		pdo_insert('jc_qrcode',array('sceneid'=>$scene_id,'ticket'=>$ticketstr,'rid'=>$listid,'url'=>$urlstr));
		
	}
	
	
	public function doWebJilu(){
		global $_W,$_GPC;
		
		$list = pdo_fetchall("SELECT id,title FROM ".tablename('jc_setting')." WHERE weid = '".$_W['uniacid']."' ORDER BY id DESC  ");
		
		
		$pindex = max(1, intval($_GPC['page']));
		
		$psize = 15;
		
		if(!empty($_GPC['ddltitle'])){
			$sql = 'select *  from '.tablename('jc_jilu').' where title = :title ORDER BY addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid'],":title" => $_GPC['ddltitle']));
		}else{
			$sql = 'select * from '.tablename('jc_jilu').'  ORDER BY addtime DESC LIMIT '.($pindex - 1) * $psize.",{$psize}";
			$list = pdo_fetchall($sql,array(":weid" => $_W['uniacid']));
		}
		
		
		
		if (!empty($list)) {
		
			if(!empty($_GPC['ddltitle'])){
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jc_jilu')." WHERE weid = :weid and title = :title ",array(":weid" => $_W['uniacid'],":title" => $_GPC['ddltitle']));
			}else{
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('jc_jilu')." WHERE weid = :weid",array(":weid" => $_W['uniacid']));
			}
			$pager = pagination($total, $pindex, $psize);
		
			unset($row);
		
		}
		
		
		include $this->template('yewu-jilu');
	}
	
}