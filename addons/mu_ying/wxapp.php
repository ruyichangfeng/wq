<?php
/**
 * 母婴模块小程序接口定义
 *
 * @author wangbosichuang
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Mu_yingModuleWxapp extends WeModuleWxapp {
	
	//查询基础信息
	public function doPageBase() {
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$baseInfo = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_base') . " WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$baseInfo['slide'] = unserialize($baseInfo['slide']);
		$num = count($baseInfo['slide']);
		for($i = 0; $i < $num; $i++) {
			$baseInfo['slide'][$i] = $_W['attachurl'] . $baseInfo['slide'][$i];
		} 
		$baseInfo['db_img'] = $_W['attachurl'] . $baseInfo['db_img'];
		$baseInfo['bq_logo'] = $_W['attachurl'] . $baseInfo['bq_logo'];
		$baseInfo['wt_img'] = $_W['attachurl'] . $baseInfo['wt_img'];
		$baseInfo['sy_img'] = $_W['attachurl'] . $baseInfo['sy_img'];
		return $this->result(0, 'success', $baseInfo);
	} 

	//查询关于我们
	public function doPageAbout(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$about = pdo_fetch("SELECT * FROM ".tablename('yuezi_zx_gywm')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		$about['slide'] = unserialize($about['slide']);
		$num = count($about['slide']);
		for($i = 0; $i < $num; $i++) {
			$about['slide'][$i] = $_W['attachurl'] . $about['slide'][$i];
		} 
		$about['zhengshu'] = unserialize($about['zhengshu']);
		$num = count($about['zhengshu']);
		for($i = 0; $i < $num; $i++) {
			$about['zhengshu'][$i] = $_W['attachurl'] . $about['zhengshu'][$i];
		} 
		$about['img'] = $_W['attachurl'] . $about['img'];
		//$about['time'] = date('Y-m-d H:i:s',time($about['time']));
		return $this->result(0,'success',$about);
	}

	//查询责任使命
	public function doPageZereng(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$zereng = pdo_fetch("SELECT * FROM ".tablename('yuezi_zx_zereng')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		$zereng['img'] = unserialize($zereng['img']);
		$num = count($zereng['img']);
		for($i = 0; $i < $num; $i++) {
			$zereng['img'][$i] = $_W['attachurl'] . $zereng['img'][$i];
		} 
		$zereng['bq1_img'] = $_W['attachurl'] . $zereng['bq1_img'];
		$zereng['bq2_img'] = $_W['attachurl'] . $zereng['bq2_img'];
		$zereng['bq3_img'] = $_W['attachurl'] . $zereng['bq3_img'];
		return $this->result(0,'success',$zereng);
	}
	
	//查询专业力量
	public function doPageZhuangye(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$zhuangye = pdo_fetch("SELECT * FROM ".tablename('yuezi_zx_zhuangye')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		$zhuangye['img1'] = $_W['attachurl'] . $zhuangye['img1'];
		$zhuangye['img2'] = $_W['attachurl'] . $zhuangye['img2'];
		$zhuangye['img3'] = $_W['attachurl'] . $zhuangye['img3'];
		return $this->result(0,'success',$zhuangye);
	}

	//查询资讯
	public function doPageZixun(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$zixun = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_zixun')." WHERE uniacid =:uniacid  order by id desc",array(':uniacid'=>$uniacid));
		foreach ($zixun as &$value) {
			$value['img'] = $_W['attachurl'] . $value['img'];
		}
		return $this->result(0,'success',$zixun);
	}
	//查询资讯详情
	public function doPageZixunxq(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$id = $_REQUEST['id'];
		$zixunxq = pdo_fetch("SELECT * FROM ".tablename('yuezi_zx_zixun')." WHERE uniacid =:uniacid and id =:id",array(':uniacid'=>$uniacid,':id'=>$id));

		return $this->result(0,'success',$zixunxq);
	}


	//查询分店
	public function doPageFendian(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$fendian = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_fendian')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		foreach ($fendian as &$value) {
			$value['slide'] = unserialize($value['slide']);
			$num = count($value['slide']);
			for($i = 0; $i < $num; $i++) {
				$value['slide'][$i] = $_W['attachurl'] . $value['slide'][$i];
			} 
			$value['img'] = $_W['attachurl'] . $value['img'];
		}
		return $this->result(0,'success',$fendian);
	}

	//查询明星客户
	public function doPageMxkh(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$mxkh = pdo_fetch("SELECT * FROM ".tablename('yuezi_zx_mxkh')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		$mxkh['img'] = $_W['attachurl'] . $mxkh['img'];
		return $this->result(0,'success',$mxkh);
	}

	//查询明星客户案例
	public function doPageMxkhgl(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$mxkhgl = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_mxkhgl')." WHERE uniacid =:uniacid order by id desc",array(':uniacid'=>$uniacid));
		foreach ($mxkhgl as &$value) {
			$value['img'] = $_W['attachurl'] . $value['img'];
			$value['atart_time'] = date('Y-m-d',time($value['start_time']));
			$value['end_time'] = date('Y-m-d',time($value['end_time']));
		}
		return $this->result(0,'success',$mxkhgl);
	}

	//查询特色服务
	public function doPageTsfw(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$tsfw = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_tsfw')." WHERE uniacid =:uniacid  order by id desc",array(':uniacid'=>$uniacid));
		foreach ($tsfw as &$value) {
			$value['img'] = $_W['attachurl'] . $value['img'];
		}
		return $this->result(0,'success',$tsfw);
	}
	//查询特色服务详情
	public function doPageTsfwxq(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$id = $_REQUEST['id'];
		$tsfwxq = pdo_fetch("SELECT * FROM ".tablename('yuezi_zx_tsfw')." WHERE uniacid =:uniacid and id =:id",array(':uniacid'=>$uniacid,':id'=>$id));
		return $this->result(0,'success',$tsfwxq);
	}

	//查询套餐宣传图
	public function doPageTcimg(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$tc = pdo_fetch("SELECT * FROM ".tablename('yuezi_zx_tc')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		$tc['img'] = $_W['attachurl'] . $tc['img'];
		return $this->result(0,'success',$tc);
	}

	//查询套餐内容
	public function doPageTcgl(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$tcgl = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_tcnr')." WHERE uniacid =:uniacid  order by id desc",array(':uniacid'=>$uniacid));
		foreach ($tcgl as &$value) {
			$value['img'] = $_W['attachurl'] . $value['img'];
		}
		return $this->result(0,'success',$tcgl);
	}

	//查询套餐服务
	public function doPageTcfw(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$tcfw = pdo_fetch("SELECT * FROM ".tablename('yuezi_zx_tcfw')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		return $this->result(0,'success',$tcfw);
	}

	//查询关于爱帝宫（环境介绍）
	public function doPageGyhj(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$gyhj = pdo_fetch("SELECT * FROM ".tablename('yuezi_zx_hjjs')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		return $this->result(0,'success',$gyhj);
	}

	//查询妈妈印象标签
	public function doPageBiaoqian(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$biaoqian = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_hjbq')." WHERE uniacid =:uniacid  order by id desc",array(':uniacid'=>$uniacid));
		return $this->result(0,'success',$biaoqian);
	}

	//查询知识百科
	public function doPageZsbk(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('yuezi_zx_rj') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
        $pindex = max(1, intval($_GPC['page'])); 
        $pagesize = 5;
        $pager = pagination($total,$pindex,$pagesize);
        $p = ($pindex-1) * $pagesize; 
		$zsbk = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_rj')." WHERE uniacid =:uniacid order by id desc limit ".$p.",".$pagesize,array(':uniacid'=>$uniacid));
		foreach ($zsbk as &$value) {
			$value['img'] = $_W['attachurl'] . $value['img'];
			$value['time'] = date('Y-m-d H:i:s',time($value['time']));
		}
		return $this->result(0,'success',$zsbk);
	}

	//查询知识百科详情
	public function doPageZsbkxq(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$id = $_REQUEST['id'];
		$zsbkxq = pdo_fetch("SELECT * FROM ".tablename('yuezi_zx_rj')." WHERE uniacid =:uniacid and id =:id",array(':uniacid'=>$uniacid,':id'=>$id));
		$zsbkxq['time'] = date('Y-m-d H:i:s',time($zsbkxq['time']));
		return $this->result(0,'success',$zsbkxq);
	}
	
	//查询九大服务分类,内容
	public function doPageFwfl(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$fwfl = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_fwfl')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		foreach ($fwfl as $key=> $row) {
			$fwgl = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_fwgl')." WHERE fl_id = :fl_id",array(":fl_id"=>$row['fl_id']));
			$fwlist = array();
			foreach ($fwgl as &$fw_row) {
				$fwlist[] = array('fl_id'=>$fw_row['fl_id'],'title'=>$fw_row['title'],'text'=>$fw_row['text']);
			}
			$fwfl[$key]['fwlist'] = $fwlist;
		}
		return $this->result(0,'success',$fwfl);
	}
	//查询问题分类,及问题
	public function doPageWtfl(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$wtfl = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_wtfl')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		foreach ($wtfl as $key=> $row) {
			$wtgl = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_wtgl')." WHERE wt_id = :wt_id",array(":wt_id"=>$row['wt_id']));
			$wtlist = array();
			foreach ($wtgl as &$wt_row) {
				$wtlist[] = array('id'=>$wt_row['id'],'wt_id'=>$wt_row['wt_id'],'title'=>$wt_row['title'],'daan'=>$wt_row['daan']);
			}
			$wtfl[$key]['wtlist'] = $wtlist;
		}
		return $this->result(0,'success',$wtfl);
	}

	//查询首页菜单
	public function doPageSycd(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$sycd = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_caidan')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		foreach ($sycd as &$value) {
			$value['img'] = $_W['attachurl'] . $value['img'];
		}
		return $this->result(0,'success',$sycd);
	}
	//查询首页头条下菜单
	public function doPageButton(){
		global $_GPC,$_W;
		$uniacid = $_W['uniacid'];
		$button = pdo_fetch("select * from ".tablename('yuezi_zx_button')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		$button['cd1_img'] = $_W['attachurl'] . $button['cd1_img'];
		$button['cd2_img'] = $_W['attachurl'] . $button['cd2_img'];
		$button['cd3_img'] = $_W['attachurl'] . $button['cd3_img'];
		return $this->result(0,'success',$button);
	}
	

	//预约管理
	public function doPageYuyue(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$data = array(
			'uniacid'=> $_W['uniacid'],
			'name' => $_REQUEST['name'],
			'tel' => $_REQUEST['tel'],
			'email' => $_REQUEST['email'],
			'leixin' => $_REQUEST['leixin']
			);  
		$res = pdo_insert('yuezi_zx_yuyue', $data);
		if($res){
			$resarr = pdo_fetch("SELECT * FROM ".tablename('yuezi_zx_email')." WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
			//var_dump($resarr);
			$smtpemailto = $resarr['mailhostname'];//'';//发送给谁
			$mailtitle = "预约提醒通知：客户 ".$_REQUEST['name']." 手机号：".$_REQUEST['tel'];//邮件主题
			$mailcontent = "预约详情：客户 <b>".$_REQUEST['name']."</b>， 手机号：".$_REQUEST['tel']." 申请了 ：".$_REQUEST['leixin']." <br/>客户邮箱：".$_REQUEST['email'];//
			//引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
		    require_once ("api/phpmailer/class.phpmailer.php"); 
		    require_once ("api/phpmailer/class.smtp.php");
		    //实例化PHPMailer核心类
		    $mail = new PHPMailer();

		    //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
		    //$mail->SMTPDebug = 2;

		    //使用smtp鉴权方式发送邮件
		    $mail->isSMTP();

		    //smtp需要鉴权 这个必须是true
		    $mail->SMTPAuth=true;

		    //链接qq域名邮箱的服务器地址
		    $mail->Host = $resarr['mailhost'];

		    //设置使用ssl加密方式登录鉴权
		    $mail->SMTPSecure = 'ssl';

		    //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
		    $mail->Port = $resarr['mailport'];

		    
		    $mail->CharSet = 'UTF-8';

		    //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
		    $mail->FromName = $resarr['mailformname'];

		    //smtp登录的账号 这里填入字符串格式的qq号即可
		    $mail->Username = $resarr['mailusername'];

		    //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
		    $mail->Password = $resarr['mailpassword'];
		    //SMTP服务器的验证密码 'jvpfoeokxomufgji';//'drtzejqwbdomegbc';//jvpfoeokxomufgji

		    //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
		    $mail->From = $resarr['mailsend'];//$redis->get('email:send_email');//SMTP服务器的用户邮箱

		    //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
		    $mail->isHTML(true); 

		    //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
		    $arr_mailto = explode(',', $smtpemailto);
		    foreach ($arr_mailto as $v_mailto) {
		    	$mail->addAddress($v_mailto,'预约通知');
		    }
		    
		    //添加该邮件的主题
		    $mail->Subject = $mailtitle;

		    //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
		    $mail->Body = $mailcontent;
		    $flag = $mail->send();
			if($flag){
				$post->error = 0;
				$post->msg = "邮件发送成功！";
				return $this-> result(0,'success',$post);
			}else{
			    $post->error = 1;
				$post->msg = "邮件发送失败！请检查邮箱填写是否有误。";
				return $this-> result(1,'error',$post);
			}
			return $this-> result(0,'success');
		}else{
			return $this-> result(1,'error');
		}
	}




}