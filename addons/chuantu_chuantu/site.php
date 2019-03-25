<?php
/**
 * 传图抽奖模块微站定义
 *
 * @author wuyou8888
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Chuantu_chuantuModuleSite extends WeModuleSite {

	public function doMobileIndex(){
		global $_W,$_GPC;
		$setting = $this -> module['config'];
		$user = pdo_fetch("SELECT * FROM ".tablename('chuantu_user')." WHERE openid='$_W[openid]' and uniacid = $_W[uniacid] ");
		$upload = pdo_fetch("SELECT * FROM ".tablename('chuantu_upload')." WHERE openid='$_W[openid]' and uniacid =$_W[uniacid] ");
        include $this->template("index");
	}
	public function doWebOk(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$val = $_GPC['val'];
		$config = $this->module['config'];
		if($id){
			$info = pdo_fetch('SELECT * FROM'.tablename('chuantu_upload')." WHERE id=$id");
			if($info){
				if($val == -1){
					pdo_update('chuantu_upload',array('state'=>-1,'lasttime'=>TIMESTAMP),array('id'=>$id));
					$return = array(
						'msg'=>'设为无效完备',
						'success'=>-1
					);
					$acid = $info['uniacid'];
					$send['touser'] = trim($info['openid']);
					$send['msgtype'] = trim('text');
					//替换
					$reply = $config['error']?$config['error']:'对不起，您上传的图片不符合要求，本次机会作废。';
					$send['text'] = array('content' => urlencode($reply));
					$acc = WeAccount::create($_W[uniacid]);
					$data = $acc->sendCustomNotice($send);
					pdo_update('chuantu_upload',array('state'=>-1,'lasttime'=>TIMESTAMP),array('id'=>$id));
				}elseif($val == 1){
					//开始给奖品
					//ogaNIs79nvovPNuRxK08ypCzIHNs
					if($config['send_type']=='kefu'){
						$send['touser'] = trim($info['openid']);
						$send['msgtype'] = trim('text');
						$send['text'] = array('content' => urlencode($config['tips']));
						$acc = WeAccount::create($acid);
						$data = $acc->sendCustomNotice($send);
						$return = array(
							'msg'=>'发送提醒消息完备',
							'success'=>1
						);
						pdo_update('chuantu_upload',array('state'=>1,'lasttime'=>TIMESTAMP),array('id'=>$id));
					}else{
						//
						$prize = pdo_fetch('SELECT * FROM '.tablename('chuantu_prize')." where state=0 and uniacid =$_W[uniacid]");
						if(!empty($prize)){
							$acid = $info['uniacid'];
							$send['touser'] = trim($info['openid']);
							$send['msgtype'] = trim('text');
							//替换
							$reply = str_replace('#code#', $prize['code'], $config['tips']);
							$send['text'] = array('content' => urlencode($reply));
							$acc = WeAccount::create($acid);
							$data = $acc->sendCustomNotice($send);
							pdo_update('chuantu_upload',array('state'=>1,'lasttime'=>TIMESTAMP,'code'=>$prize['code']),array('id'=>$id));
							pdo_update('chuantu_prize',array('state'=>1,'lasttime'=>TIMESTAMP),array('id'=>$prize[id]));
							$return = array(
								'msg'=>'发送消息完备',
								'success'=>1
							);
						}else{
							$return = array(
								'msg'=>'奖品已经没有了。',
								'success'=>-1
							);
						}
						//

					}
					
					
				}
			}
		}
		echo json_encode($return);
	}
	public function doWebClear(){
		global $_W,$_GPC;
		pdo_query('DELETE FROM '.tablename('chuantu_upload')." WHERE uniacid =$_W[uniacid]");
		pdo_query('DELETE FROM '.tablename('chuantu_prize')." WHERE uniacid =$_W[uniacid]");
		message('信息清空成功', $this->createweburl('upload'), 'success');
	}
	public function doMobileUse(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		if($id>0){
			$info = pdo_fetch("SELECT * FROM ".tablename('chuantu_upload')." WHERE id=$id");
			if(empty($info)){
				$return = array(
					'success'=>0,
					'msg'=>'找不到中奖信息'
				);
			}else{
				pdo_update('chuantu_upload',array('state'=>1),array('id'=>$id));
				$return = array(
					'success'=>1,
					'msg'=>'使用完成'
				);
			}
			
		}else{
			$return = array(
				'success'=>0,
				'msg'=>'编号不能为空'
			);
		}
		echo json_encode($return);
	}
	public function doMobileShare(){
		global $_W,$_GPC;
		$setting = $this -> module['config'];
		include $this->template("share");
	}
	public function doWebUpload(){
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$orderbytime = $_GPC['orderbytime'];
		//$condition = ' WHERE `uniacid`=:uniacid ';
		if($_GPC['last']){
			if($_GPC['last']==-1){
				$_GPC['last'] = 0;
			}
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('chuantu_upload') . " WHERE `uniacid`=$_W[uniacid] and RIGHT(bianhao,1) = $_GPC[last]");
			$list = pdo_fetchall("SELECT a.id,a.state,a.bianhao,a.code,a.lasttime,a.picurl,a.createtime,b.json_nickname,b.headimgurl FROM " . tablename('chuantu_upload') . " as a LEFT JOIN ".tablename('chuantu_user') ." as b on a.openid=b.openid ". " where a.uniacid=$_W[uniacid] AND RIGHT(a.bianhao,1) = $_GPC[last] order by a.bianhao desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		}else{
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('chuantu_upload') . " WHERE `uniacid`=$_W[uniacid]");
			$list = pdo_fetchall("SELECT a.id,a.state,a.bianhao,a.code,a.lasttime,a.picurl,a.createtime,b.json_nickname,b.headimgurl FROM " . tablename('chuantu_upload') . " as a LEFT JOIN ".tablename('chuantu_user') ." as b on a.openid=b.openid ". " where a.uniacid=$_W[uniacid] order by a.bianhao desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		}

		$pager = pagination($total, $pindex, $psize);
		include $this->template("upload");
	}
	public function doWebPrize() {
		global $_GPC, $_W;
		$ops = array('display', 'post', 'list', 'view', 'del', 'edit');
		$op = $_GPC['op'];
		$op = in_array($op, $ops) ? $op : 'display';
		if ($op == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$orderbytime = $_GPC['orderbytime'];
			$condition = ' WHERE `uniacid`=:uniacid ';

			$pars = array();
			$pars[':uniacid'] = $_W['uniacid'];

			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('chuantu_prize') . " WHERE `uniacid`=:uniacid", $pars);
			$list = pdo_fetchall("SELECT * FROM " . tablename('chuantu_prize') . $condition . " order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $pars);
			$pager = pagination($total, $pindex, $psize);
			include $this -> template('prize');
		}elseif ($op == 'edit') {
			$id = $_GPC['id'];
			if (checksubmit('submit')) {
				if($id){
					$update = array(
						'code'=>$_GPC['title'],
					);
					pdo_update('chuantu_prize',$update,array('id'=>$id));
					//pdo_insert('yanzhi_log', $update);
					message('修改信息成功', referer(), 'success');
				}else{
					$insert = array(
						'uniacid'=>$_W['uniacid'],
						'code'=>$_GPC['code'],
						'createtime'=>TIMESTAMP,
					);
					pdo_insert('chuantu_prize',$insert);
					message('添加信息成功', $this->createweburl('prize'), 'success');
				}
				
			}else {
				if($id){
					$jiangpin = pdo_fetch('SELECT * FROM '.tablename('chuantu_prize')." WHERE id=$id");
				}
				include $this -> template('prize');
			}

		}elseif($op == 'del'){
			$id = $_GPC['id'];
			pdo_delete('chuantu_prize',array('id'=>$id));
			message('删除信息成功', $this->createweburl('prize'), 'success');
		}
	}

	public function doWebEnter() {
		global $_W, $_GPC;
		/*
		for($i=11;$i<=120;$i++){
			$code  = substr(strval($i+1000),1,3);
			$insert = array(
				'uniacid'=>$_W['uniacid'],
				'code'=>'QZ5330'.$code,
				'createtime'=>TIMESTAMP,
			);
			pdo_insert('chuantu_prize',$insert);
		}
		*/
		/*
		require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel/IOFactory.php';		
		$reader = PHPExcel_IOFactory::createReader('Excel5');
		echo IA_ROOT .'/1.xls';
		$PHPExcel = $reader->load(IA_ROOT .'/1.xls'); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		/*
		//内容转换为数组
		$objPHPExcel = new PHPExcel();
		$reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
    	$PHPExcel = $reader->load(IA_ROOT .'/1.xls'); // 载入excel文件
    	$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
    	$highestRow = $sheet->getHighestRow(); // 取得总行数
    	print_r($highestRow);

		foreach($indata as $row){
			$data  = array();
			$data['uniacid'] = intval($_W['uniacid']);
			$data['code'] = intval($row[0]);
			pdo_insert('chuantu_prize', $data);
		}
		*/
	}

}