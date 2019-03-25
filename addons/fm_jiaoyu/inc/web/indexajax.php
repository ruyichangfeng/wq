<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */global $_W, $_GPC;
   $operation = in_array ( $_GPC ['op'], array ('default','checkpass','guanli','getquyulist','getbjlist','createorder','checkorder','getloadingorder','delorder') ) ? $_GPC ['op'] : 'default';

    if ($operation == 'default') {
	           die ( json_encode ( array (
			         'result' => false,
			         'msg' => '你是傻逼吗'
	                ) ) );
    }
	if ($operation == 'createorder') {
		if (empty($_GPC ['schoolid']) || empty($_GPC ['weid'])) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }
		$checkorder = pdo_fetch("SELECT * FROM " . tablename($this->table_online) . " WHERE :macid = macid And result = 2 And isread = 2", array(':macid' => trim($_GPC['macid'])));
		  
		if(!empty($checkorder)){
			     die ( json_encode ( array (
                 'result' => false,
                 'msg' => '尚有未执行完的任务,如需要执行定时任务,请在先执行其他任务在执行该任务！' 
		          ) ) );
		}else{  
			$data = array(
				'weid'	 	=> trim($_GPC['weid']),
				'schoolid'	=> trim($_GPC['schoolid']),
				'commond'   => trim($_GPC['order']),
				'macid'	    => trim($_GPC['macid']),
				'createtime'=> time()
			);
			if($_GPC['time_type'] == 2){
				if(empty($_GPC['dotime1']) || empty($_GPC['dotime1'])){
					 die ( json_encode ( array (
					 'result' => false,
					 'msg' => '抱歉,执行定时任务，请先选择时间！' 
					  ) ) );					
				}
				$signTime = $_GPC['dotime1']." ".$_GPC['dotime2'];
				$data['dotime']	= strtotime($signTime);
			}
		    pdo_insert($this->table_online, $data);
			$onlineid = pdo_insertid();
			$result ['result'] = true;
			$result ['id'] 	= $onlineid;
			$result ['msg'] = '命令已创建！';

		 die ( json_encode ( $result ) );
		}
    }
	if ($operation == 'checkorder') {
		$order = pdo_fetch("SELECT * FROM " . tablename($this->table_online) . " WHERE :id = id ", array(':id' => trim($_GPC['id'])));
		if($order['result'] == 2){
			$result ['result'] = false;
			$result ['msg'] = '玩命执行命令中。。。';			
		}else{
			$result ['result'] = true;
			$result ['msg'] = '命令执行成功！';
		}
		 die ( json_encode ( $result ) );
		
    }
	if ($operation == 'delorder') {
		$order = pdo_fetch("SELECT * FROM " . tablename($this->table_online) . " WHERE :id = id ", array(':id' => trim($_GPC['id'])));
		if($order){
			$result ['result'] = true;
			$result ['msg'] = '删除成功';	
			pdo_delete($this->table_online, array('id' => trim($_GPC['id'])));	
		}else{
			$result ['result'] = false;
			$result ['msg'] = '此任务不存在或已被删除';
		}
		 die ( json_encode ( $result ) );
		
    }	
	if ($operation == 'getloadingorder') {
		$checkorder = pdo_fetch("SELECT * FROM " . tablename($this->table_online) . " WHERE :macid = macid And result = 2 And isread = 2", array(':macid' => trim($_GPC['id'])));
		if($checkorder){
			if(!empty($checkorder['dotime'])){
				$dotime = date('Y-m-d H:i:s',$checkorder['dotime']);
			}else{
				$dotime = "未执行";
			}
			if($checkorder['commond'] == 1){
				$ordername = "立即更新学生和卡信息.创建于".date('Y-m-d H:i:s',$checkorder['createtime'])." 执行时间:".$dotime;
			}
			if($checkorder['commond'] == 2){
				$ordername = "重新初始化学生和卡信息".date('Y-m-d H:i:s',$checkorder['createtime'])." 执行时间:".$dotime;
			}
			if($checkorder['commond'] == 3){
				$ordername = "更新图片".date('Y-m-d H:i:s',$checkorder['createtime'])." 执行时间:".$dotime;
			}
			if($checkorder['commond'] == 4){
				$ordername = "重启设备".date('Y-m-d H:i:s',$checkorder['createtime'])." 执行时间:".$dotime;
			}			
			$result ['result'] = true;
			$result ['id'] = $checkorder['id'];
			$result ['ordername'] = $ordername;
		}else{
			$result ['result'] = false;	
		}
		 die ( json_encode ( $result ) );	
    }	
	if ($operation == 'checkpass') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schooid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	         }
		
		$tid = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where :id = id And :weid = weid And :password = password", array(
		         ':id' => $_GPC ['schooid'],
				 ':weid' => $_GPC ['weid'],
				 ':password'=>$_GPC ['password']
				  ), 'id');
				  
		if(empty($tid['id'])){
			     die ( json_encode ( array (
                 'result' => false,
                 'msg' => '密码输入错误！' 
		          ) ) );
		}else{  			
			$data ['result'] = true;
			
			$data ['url'] = $_W['siteroot'] .'web/'.$this->createWebUrl('assess', array('id' => $_GPC ['schooid'], 'schoolid' =>  $_GPC ['schooid']));
			
			$data ['msg'] = '密码正确！';

		 die ( json_encode ( $data ) );
		}
    }
	if ($operation == 'guanli') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schooid1'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	         }
		
		$tid = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where :id = id And :weid = weid And :password = password", array(
		         ':id' => $_GPC ['schooid1'],
				 ':weid' => $_GPC ['weid'],
				 ':password'=>$_GPC ['password1']
				  ), 'id');
				  
		if(empty($tid['id'])){
			     die ( json_encode ( array (
                 'result' => false,
                 'msg' => '密码输入错误！' 
		          ) ) );
		}else{  			
			$data ['result'] = true;
			
			$data ['url'] = $_W['siteroot'] .'web/'.$this->createWebUrl('school', array('id' => $_GPC ['schooid1'], 'schoolid' =>  $_GPC ['schooid1'], 'op' => 'post'));
			
			$data ['msg'] = '密码正确！';

		 die ( json_encode ( $data ) );
		}
    }
	if ($operation == 'getquyulist')  {
		if (! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			$data = array();
			$bjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_area) . " where weid = '{$_GPC['weid']}' And parentid = '{$_GPC['gradeId']}' And type = '' ORDER BY ssort DESC");
   			$data ['bjlist'] = $bjlist;
			$data ['result'] = true;
			$data ['msg'] = '成功获取！';
			
          die ( json_encode ( $data ) );
		  
		}
    }
	if ($operation == 'getbjlist')  {
		if (! $_GPC ['schoolid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	    }else{
			$data = array();
			$bjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$_GPC['schoolid']}' And parentid = '{$_GPC['gradeId']}' And type = 'theclass' ORDER BY ssort DESC");
   			$data ['bjlist'] = $bjlist;
			$data ['result'] = true;
			$data ['msg'] = '成功获取！';
			
          die ( json_encode ( $data ) );
		  
		}
    }
		
?>