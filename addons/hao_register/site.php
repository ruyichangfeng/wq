<?php
/**
 * 活动报名模块微站定义
 *
 * @author 洛杉矶豪哥
 * @url http://test.idouly.com
 */
defined('IN_IA') or exit('Access Denied');

class Hao_registerModuleSite extends WeModuleSite {
    
	public function doMobileIndex() {
		global $_GPC,$_W;  //全局变量$_W获得公众号信息，$GPC获得表单内容var
		if(checksubmit('submit')){
            $data['content'] = $_GPC['content'];
            $data['name'] = $_GPC['name'];
            $data['uniacid'] = $_W['uniacid'];

            $res = pdo_insert('baoming',$data);
            if($res){
              die('<script>alert("报名成功！");location.href = "'.$this->createMobileUrl('index').'";</script>');
		    }
		}
		include $this->template('liuyan');
	}

	public function doWebActivity() {       
        $sql = "select * from ".tablename('baoming');
        $res = pdo_fetchall($sql);
        include $this->template('activity');
	}

	//删除报名记录
	public function doWebRegisterdelete(){
		
		global $_W,$_GPC;
		
		$id = $_GPC['id'];
		
		pdo_delete('baoming', array('uniacid' => $id));
		
		message('删除成功！', $this->createWebUrl('activity'), 'success');
	}
}