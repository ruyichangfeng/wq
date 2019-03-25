<?php
/**
 * 微信投票高级营销[驽马]模块定义
 *
 * @author yofung168
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Numa_voteModule extends WeModule {
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
	}

	public function ruleDeleted($rid) {
		global $_W;
		//删除规则时调用，这里 $rid 为对应的规则编号
		pdo_delete("cover_reply",array("uniacid"=>$_W['uniacid'],"rid"=>$rid,"module"=>"numa_vote"));
	}
	public function settingsDisplay($settings) {
		global $_W, $_GPC;  
		$m="";
		 parse_str($_W['siteurl']);
		 $current_modulename = $m;  
		 include_once ( IA_ROOT . '/addons/'.$current_modulename.'/alinuma.func.php'); 
		 $settings = pdo_getcolumn("uni_account_modules",array("uniacid"=>$_W['uniacid'],"module"=>"numa_smallapp"),"settings");
	     $settings = iunserializer($settings);  
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			$data = array();  
			$data['tongji'] = $_GPC['tongji'];
			//字段验证, 并获得正确的数据$dat
			$advcode = $_GPC['advcode'];
			//判断授权码是否正确
						//判断授权码是否正确
			if($advcode!=""){
				 $result = alinuma_checkAuth($advcode,"adv","numa_vote",$_W['account']['original']);
				  if(!$result || is_error($result)){
				 	    $data['valid']=0;
				 	    $data['advcode']= "";
				 	    $data['stime'] =0;
				 	    $data['etime'] =0;
				 	    message("保存失败,授权码无效!".isset($result['message'])?$result["message"]:'',"",'error');
				 }else{
				 	    if($result['valid']==1){
					 	    	$data['valid']=1;
						 	    $data['advcode'] = $advcode;
						 	    $data['stime'] = $result['stime'];
						 	    $data['etime'] = $result['etime']; 
				 	    }else{
				 	    	   $data['valid']=0;
				 	    	   $data['advcode']= "";
				 	    	   $data['stime'] =0;
				 	    	   $data['etime'] =0;
				 	    }  
				 }
			}
			if(false!==$this->saveSettings($data)){
				  message("保存成功!","",'success');
			}else{
				   message("保存失败!","",'error');
			}
		} 
		$identifycode = alinuma_encrypt($_SERVER['HTTP_HOST']."|".$_W['account']['original']."|".$_W['account']['name']."|numa_vote","alinuma");
		$decode = alinuma_decrypt($identifycode,"alinuma");
		//这里来展示设置项表单
	    $this->current_module = "numa_vote";
		include $this->template('setting');
	} 
}