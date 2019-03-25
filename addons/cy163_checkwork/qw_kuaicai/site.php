<?php
/**
 * 疯狂送菜模块微站定义
 *
 * @author zhao
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Qw_kuaicaiModuleSite extends WeModuleSite {

	//public function doMobileIndex() {
		//这个操作被定义用来呈现 功能封面
	//}

	public $settings;

	public function __construct() {
		global $_W;
		$sql = 'SELECT `settings` FROM ' . tablename('uni_account_modules') . ' WHERE `uniacid` = :uniacid AND `module` = :module';
		$settings = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':module' => 'qw_kuaicai'));
		$this -> settings = iunserializer($settings);

	}
	public function doWebOrder() {

		global $_W,$_GPC;
		$op = $_GPC['op'] ? trim($_GPC['op']) : 'display';
		$set = $this->settings;

		if($op=='display') {


			$date = $_GPC['date'];


			$start = strtotime($date['start']);
			$end = strtotime($date['end'])+86399;


			 if(empty($date)){


				 $start=time()-86400*20;
				 $end=time()+86400*19+86399;
			}



			$con = " and a.addtime>='$start' and a.addtime<'$end' ";
			$xingming = trim($_GPC['xingming']);

			$ordersn = trim($_GPC['ordersn']);

			$status = $_GPC['status'];

			if (!empty($xingming)) {


				$con .= " and a.xingming like '%$xingming%' ";
			}
			if (!empty($ordersn)) {
				$con .= " and a.ordersn like '%$ordersn%' ";

			}

			if (!empty($status)) {
				$con .= " and a.status = '$status' ";

			}

			$pindex = max(1, intval($_GPC['page']));
			$psize = 3;

			$cailist = pdo_fetchall("SELECT id,title,num FROM" . tablename('qw_kuaicai_pro') . "WHERE uniacid = '{$_W['uniacid']}'");


			$orderlist = pdo_fetchall("SELECT a.*,b.openid,b.name,b.nicheng,b.phone FROM" . tablename('qw_kuaicai_order') . " as a left join " . tablename("qw_kuaicai_user") . " as b on a.uid = b.uid WHERE a.uniacid = '{$_W['uniacid']}'" . $con . " order by a.addtime desc  LIMIT " . ($pindex - 1) * $psize . "," . $psize);

			$total = pdo_fetchall("SELECT * FROM" . tablename('qw_kuaicai_order') . " as a left join " . tablename("qw_kuaicai_user") . " as b on a.uid = b.uid WHERE a.uniacid = '{$_W['uniacid']}'" . $con);

			$total = count($total);

			$pager = pagination($total, $pindex, $psize);

			$tjorderlist = pdo_fetchall("SELECT * FROM" . tablename('qw_kuaicai_order') ." WHERE uniacid = '{$_W['uniacid']}' and addtime>'$start' and addtime<'$end'");

			//菜品统计
            $sta=array();
			foreach($tjorderlist as $item){
				$sxuanze= array();

				$sxuanze = explode(',',$item['xuanze']);
                  array_pop($sxuanze);
				foreach($sxuanze as $v){

					array_push($sta,$v);
				}
				unset($sxuanze);

			}
           $rs=array();
			foreach($sta as $v){


				$rs[$v]++;
			}
           $tongji = array();
			foreach($rs as $key=>$v){


				foreach($cailist as $item){

                  if($key==$item['id']){

					   $tongji['title'][]=$item['title'];
					  $tongji['num'][]= $v;
				     }

				}
			}




			//统计结束


		}else if($op=='del'){

          $idd = intval($_GPC['idd']);



			$res = pdo_delete('qw_kuaicai_order',array('id'=>$idd));

			if($res){


				message("成功删除订单",$this->createWeburl('order'));
			}else{

				message("删除订单失败",$this->createWeburl('order'));
			}



		}
          if($_W['isajax']){

                $countjici = $_GPC['countjici'];
			    $ordersn = $_GPC['ordersn'];


			   $oxq = $this->orderxq($ordersn);

			  //会员卡计次修改

			  load()->model('mc');
			  $uid = mc_openid2uid($oxq['openid']);
			  $mcard = pdo_fetch("SELECT * FROM " . tablename('mc_card_members') . "WHERE uniacid = '{$_W['uniacid']}' AND uid =".$uid);

			  $changenums = $mcard['nums']-$countjici;
			  if($changenums<0){

				  exit(json_encode(array('error'=>0,'message'=>"超过剩余次数了")));

			  }


              $changeres =  pdo_update("mc_card_members",array("nums"=>$changenums),array('uniacid'=>$_W['uniacid'],'uid'=>$uid));

			  $changeorder = pdo_update("qw_kuaicai_order",array("status"=>2),array("ordersn"=>$ordersn));


			  //当前时间
			  $currtime = date('Y-m-d H:i:s',time());




			  if($changeres&&$changeorder){

                 //发送模板消息


				  $url=$this->createMobileurl("order");

				  $url = str_replace('./','http://'.$set['wangurl'].'/',$url);
				  $succtplid= $set['succtplid'];
				  $succlefttpl = json_decode($set['succlefttpl']);
				  $succrighttpl = json_decode($set['succrighttpl']);
				  $content=array();

				  foreach($succlefttpl as $key=>$v){

					  $succrighttpl[$key]=str_replace('[sn]',$ordersn,$succrighttpl[$key]);

					  $succrighttpl[$key]=str_replace('[count]',$countjici,$succrighttpl[$key]);
					  $succrighttpl[$key]=str_replace('[time]',$currtime,$succrighttpl[$key]);

					  $succrighttpl[$key]=str_replace('[uid]',$uid,$succrighttpl[$key]);
					  $succrighttpl[$key]=str_replace('[yuci]',$changenums,$succrighttpl[$key]);
					  $content[$v]= array('value'=>$succrighttpl[$key]);


				  }


				  $this->sendtpl($oxq['openid'],$url,$succtplid,$content);




				  exit(json_encode(array('error'=>1,'message'=>$countjici."成功")));

			  }
			  else{

				  exit(json_encode(array('error'=>0,'message'=>$countjici."失败")));
			  }



		  }

		include $this->template('order');
		//这个操作被定义用来呈现 管理中心导航菜单
	}

	function orderxq($ordersn){

		global $_W,$_GPC;

		$order = pdo_fetch("SELECT * FROM".tablename('qw_kuaicai_order')."as a left join ".tablename('qw_kuaicai_user')." as b on a.uid = b.uid WHERE a.uniacid = '{$_W['uniacid']}' and a.ordersn='$ordersn'");
		return $order;

	}



	public function doWebUsers() {


		global $_W,$_GPC;




		$op = $_GPC['op']?trim($_GPC['op']):'display';

		if($op=='display'){


			$sql = 'SELECT * FROM '.tablename('qw_kuaicai_user').' WHERE uniacid=:uniacid';
			$params = array(':uniacid'=>$_W['uniacid']);
			$userlist = pdo_fetchall($sql, $params);


		}
		else if($op=='edit'){



			$id = intval($_GPC['id']);
			if(!empty($id)){
				$sql = 'SELECT * FROM '.tablename('qw_kuaicai_user').' WHERE id=:id AND uniacid=:uniacid LIMIT 1';
				$params = array(':id'=>$id, ':uniacid'=>$_W['uniacid']);


				$user = pdo_fetch($sql, $params);




				if(empty($user)){
					message('没有此用户.', $this->createWebUrl('users'));
				}
			}

			if(checksubmit('submit')){



				$data = array(


				);



				if(!empty($id)){

					pdo_update('qw_kuaicai_user',$data,array('id'=>$id));
				}else{

					pdo_insert('qw_kuaicai_user',$data);
				}
				message('数据更新成功！', $this->createWebUrl('users',array('op' => 'display')), 'success');

			}

		}elseif($op=="del"){

			if(!intval($_GPC['idd'])){

				message("不存在",$this->createWeburl('users'));
			}

			$idd = intval($_GPC['idd']);



			$res = pdo_delete('qw_kuaicai_user',array('id'=>$idd));

			//$ordel = pdo_delete("qw_kuaicai_order",array('uid'=>$idd));
			if($res){

				message("删除成功",$this->createWeburl('users'),'success');
			}else {

				message("删除失败", $this->createWeburl('users'), 'error');


			}
		}


		include $this->template('users');


		//这个操作被定义用来呈现 管理中心导航菜单
	}
	public function doWebProduct() {
		global $_W,$_GPC;

		$op = $_GPC['op']?trim($_GPC['op']):'display';

		if($op=='display'){


			$sql = 'SELECT * FROM '.tablename('qw_kuaicai_pro').' WHERE uniacid=:uniacid';
			$params = array(':uniacid'=>$_W['uniacid']);
			$prolist = pdo_fetchall($sql, $params);


		}
		else if($op=='edit'){



			$id = intval($_GPC['id']);
			if(!empty($id)){
				$sql = 'SELECT * FROM '.tablename('qw_kuaicai_pro').' WHERE id=:id AND uniacid=:uniacid LIMIT 1';
				$params = array(':id'=>$id, ':uniacid'=>$_W['uniacid']);


				$pro = pdo_fetch($sql, $params);




				if(empty($pro)){
					message('没有此商品.', $this->createWebUrl('product'));
				}
			}

			if(checksubmit('submit')){



				$data = array(

					'title'=>trim($_GPC['title']),
					'pic'=>$_GPC['pic'],

					'uniacid'=>$_W['uniacid'],
					'des'=>$_GPC['des'],
					'status'=>$_GPC['status']?$_GPC['status']:1,//1为显示，2为隐藏

					'num'=>$_GPC['num']?$_GPC['num']:1,
					'sort'=>$_GPC['sort']?$_GPC['sort']:100,
					'yxstatus'=>$_GPC['yxstatus']?$_GPC['yxstatus']:2,//1为开启，2为关闭
				);



				if(!empty($id)){

					pdo_update('qw_kuaicai_pro',$data,array('id'=>$id));
				}else{

					pdo_insert('qw_kuaicai_pro',$data);
				}
				message('数据更新成功！', $this->createWebUrl('product',array('op' => 'display')), 'success');

			}

		}elseif($op=="del"){

			if(!intval($_GPC['idd'])){

				message("不存在",$this->createWeburl('product'));
			}

			$idd = intval($_GPC['idd']);

			$res = pdo_delete('qw_kuaicai_pro',array('id'=>$idd));
			if($res){

				message("删除成功",$this->createWeburl('product'),'success');
			}else{

				message("删除失败",$this->createWeburl('product'),'error');
			}


		}

		if($_W['isajax']){


			$id =$_GPC['idd'];//菜品的id

			$caixq = pdo_fetch("SELECT * FROM".tablename("qw_kuaicai_pro")."WHERE uniacid ='{$_W['uniacid']}' and id='$id'");

			//修改状态




			if($caixq['yxstatus']==1){

				$res = pdo_update("qw_kuaicai_pro",array('yxstatus'=>2),array('id'=>$id));

				 if($res){

					 exit(json_encode(array('error'=>1,'message'=>'成功修改','yxstatus'=>2)));
				 }else{

					 exit(json_encode(array('error'=>1,'message'=>'失败')));
				 }


			}else{


				$res = pdo_update("qw_kuaicai_pro",array('yxstatus'=>1),array('id'=>$id));

				if($res){

					exit(json_encode(array('error'=>1,'message'=>'成功修改','yxstatus'=>1)));
				}else{

					exit(json_encode(array('error'=>1,'message'=>'失败')));
				}
			}


		}

		include $this->template('product');
		//这个操作被定义用来呈现 管理中心导航菜单
	}
	public function doMobileOrder() {
		global $_W,$_GPC;

		//$this->checkreg();


		$openid = $_W['openid'];
		$this->zizhu();
		//广告
		$adlist = pdo_fetchall("SELECT * FROM".tablename('qw_kuaicai_ad')."WHERE uniacid = '{$_W['uniacid']}'");


		$orderlist = pdo_fetchall("SELECT * FROM".tablename('qw_kuaicai_order')."as a left join ".tablename('qw_kuaicai_user')."as b on a.uid=b.uid WHERE a.uniacid = '{$_W['uniacid']}' and b.openid='$openid' order by addtime desc");

       $cailist = pdo_fetchall("SELECT id,title,num FROM".tablename('qw_kuaicai_pro')."WHERE uniacid = '{$_W['uniacid']}'");





		include $this->template('order');
	}
 //自动注册

	public function zizhu(){


		global $_W,$_GPC;
		load()->model('mc');
		$userinfo = mc_oauth_userinfo();


		$openid = $_W['openid'];

		$nickname = $userinfo['nickname'];

		$uid = mc_openid2uid($openid);




		$xq = pdo_fetch("SELECT * FROM".tablename("qw_kuaicai_user")."WHERE uniacid ='{$_W['uniacid']}' and openid='$openid'");


		if(!$xq){
			$userdata=array(

				'uid'=>$uid,
				'openid'=>$_W['openid'],
				'uniacid'=>$_W['uniacid'],
                'nicheng'=>$nickname,

			);
			pdo_insert("qw_kuaicai_user",$userdata);

		}


	}
	//个人中心
	public function doMobileperson_center() {




		global $_W,$_GPC;
		//load()->model('mc');

		//$info = mc_oauth_userinfo();
		$openid = $_W['openid'];
		$nickname = $_W['fans']['tag']['nickname'];
//		$headimg = $info['headimgurl'];
		$uid = $_W['member']['uid'];
		$adlist = pdo_fetchall("SELECT * FROM".tablename('qw_kuaicai_ad')."WHERE uniacid = '{$_W['uniacid']}'");

         $addressxq = pdo_fetch("SELECT * FROM".tablename('mc_member_address')."WHERE uniacid = '{$_W['uniacid']}' and uid='$uid'");

		$address = $addressxq['province'].$addressxq['city'].$addressxq['district'].$addressxq['address'];
		//检测注册

         $this->zizhu();

		$info = pdo_fetch("SELECT * FROM".tablename('qw_kuaicai_user')."WHERE uniacid = '{$_W['uniacid']}' and uid='$uid'");


         $week = explode('|',$info['libai']);
		 array_pop($week);



		if($_W['isajax']){

			$data = array(
			'nicheng' => $nickname,
				'uid'=>$uid,

			'xqstatus' => $_GPC['xqstatus'],
			'libai' => $_GPC['week'],
			'infostatus' => $_GPC['infostatus'],

			);
			
			
			$res = pdo_update('qw_kuaicai_user',$data,array('id'=>$info['id'],'uniacid'=>$_W['uniacid']));
           if($res){

			   exit(json_encode(array('error'=>1,'message'=>'成功')));

		   }else{

			   exit(json_encode(array('error'=>0,'message'=>'保存失败，请重试')));
		   }


		}

		//检测注册
		include $this->template('person_center');
	}
	//送菜
	public function doMobilesong() {
		global $_W,$_GPC;

		$set= $this->settings;

		load()->model('mc');
		$openid = $_W['openid'];

		$this->zizhu();
		$adlist = pdo_fetchall("SELECT * FROM".tablename('qw_kuaicai_ad')."WHERE uniacid = '{$_W['uniacid']}'");

		$xq = pdo_fetch("SELECT * FROM".tablename('qw_kuaicai_user')."WHERE uniacid ='{$_W['uniacid']}' and openid = '$openid'");


		$cailist = pdo_fetchall("SELECT * FROM".tablename('qw_kuaicai_pro')."WHERE uniacid='{$_W['uniacid']}'");



		//检测信息是否填写完整，如果不完整则跳转到个人中心页面

		if($_W['isajax']){


			$xuanze = $_GPC['xuanze'];

			$addtime = strtotime($_GPC['addtime']);



			if(empty($xq['infostatus'])||empty($xq['xqstatus'])||empty($xq['libai'])){

				//信息填写不完整

				exit(json_encode(array('error'=>3,'message'=>'请完善好个人信息，如通知接收状态，地址，配送需求等，')));
			}


			//检测有没有填写完整信息，如果没有填写完整，请跳转到center中心继续完整信息


         //添加到order中,判断只要是某一天24小时内提交的
			$today =  $addtime;



			$endtoday = $today+24 * 60 * 60;

			$uid = $xq['uid'];


			$chaxun = pdo_fetch("SELECT * FROM".tablename('qw_kuaicai_order')."WHERE uniacid = '{$_W['uniacid']}' and uid='$uid' and addtime> '$today' and addtime<'$endtoday' limit 1 ");

			$xuanzet = explode(',',$xuanze);


			array_pop($xuanzet);

			$pro="";

			foreach($cailist as $v)
			{


				if(in_array($v['id'],$xuanzet)){

					$pro.=$v['title'].", ";


				}

			}


			if(!empty($chaxun)){



		       $ordersn = $chaxun['ordersn'];


			  $res = 	pdo_update('qw_kuaicai_order',array('xuanze'=>$xuanze,'count'=>$chaxun['count']+1,'addtime'=>$addtime+60*60,'mark'=>$_GPC['mark']),array('ordersn'=>$ordersn,'status'=>1));
              if($res){




				//  var payurl="./index.php?i="+{php echo $uniacid}+"&c=entry&id="+data.orderid+"&do=pay&m=moneygo_dao";

				  $url=$this->createMobileurl("order");

				  $url = str_replace('./','http://'.$set['wangurl'].'/',$url);
				  $tplid= $set['tplid'];
				  $lefttpl = json_decode($set['lefttpl']);
				  $righttpl = json_decode($set['righttpl']);
				  $content=array();

				  foreach($lefttpl as $key=>$v){

					  $righttpl[$key]=str_replace('[sn]',$ordersn,$righttpl[$key]);

					  $righttpl[$key]=str_replace('[pro]',$pro,$righttpl[$key]);
					  $content[$v]= array('value'=>$righttpl[$key]);


				  }


				  $this->sendtpl($openid,$url,$tplid,$content);





				exit(json_encode(array('error'=>1,'message'=>'成功更新'.$_GPC['addtime'].'订单')));


			  }else{

				  exit(json_encode(array('error'=>0,'message'=>'失败或者订单已经完成')));
			  }



			}

			//是否是今天再次提交的，然后更新本次


			$order = array(

				'ordersn'=>time().rand(1000,2000),
				'uniacid'=>$_W['uniacid'],
				'uid'=>$xq['uid'],
				'xuanze'=>$xuanze,
				'addtime'=>$addtime+60*60,
				'count'=>1,
				'status'=>1,
				'mark'=>$_GPC['mark'],
			);

		  $res = 	pdo_insert('qw_kuaicai_order',$order);

			if($res){

				$url=$this->createMobileurl("order");

				$url = str_replace('./','http://'.$set['wangurl'].'/',$url);
				$tplid= $set['tplid'];
				$lefttpl = json_decode($set['lefttpl']);
				$righttpl = json_decode($set['righttpl']);
				$content=array();

				foreach($lefttpl as $key=>$v){

					$righttpl[$key]=str_replace('[sn]',$order['ordersn'],$righttpl[$key]);

					$righttpl[$key]=str_replace('[pro]',$pro,$righttpl[$key]);
					$content[$v]= array('value'=>$righttpl[$key]);


				}


				$this->sendtpl($openid,$url,$tplid,$content);

			   exit(json_encode(array('error'=>1,'message'=>'成功')));
			}else{
				exit(json_encode(array('error'=>0,'message'=>'失败')));
			}



		}
		include $this->template('song');

	}





	//测试数组
	function p($arr){

		echo "<pre>";
		print_r($arr);

	}

	//群发消息

	public function doWebsend(){

		global $_W,$_GPC;

      //每天17时发送

		//mktime(hour,minute,second,month,day,year,is_dst);

		$set = $this->settings;

		$year = date('Y',time());
		$month = date('m',time());
		$day = date('d',time());
		$hour = intval($set['hour'])?intval($set['hour']):17;

		echo $hour;

	   $dingshi = mktime($hour,0,0,$month,$day,$year);

		if(!(($dingshi+20*60)>time())||!(($dingshi-20*60)<=time())){

			echo "不到时间";
			die;


		}


		$todayw = date("w")+1;

		$set=$this->settings;

		if($todayw>6){

			$todayw=0;
		}


		$cailist = pdo_fetchall("SELECT * FROM".tablename('qw_kuaicai_pro')."WHERE uniacid='{$_W['uniacid']}' and yxstatus=1");//处于优先状态的菜
		$yxarr="";
		$pro="";

		foreach($cailist as $item){

			$yxarr.=$item['id'].",";
			$pro.=$item['title'].",";

		}

		$this->p($yxarr);
		$this->p($pro);
		$userlist  = pdo_fetchall("SELECT * FROM".tablename("qw_kuaicai_user")."WHERE uniacid = '{$_W['uniacid']}' and infostatus=1 and xqstatus=1");

//		$this->p($userlist);
		//需求状态1，通知状态1
         $week = array();
		foreach($userlist as $v){

			  $week = explode('|',$v['libai']);

		       array_pop($week);

		   //是否在星期之内

		   if(in_array($todayw,$week)){

               //查看明天是否有订单，

			   $starttime = strtotime(date('Y-m-d',time()+86400));

			   $endtime = $starttime+86399;

			   $tomorder = pdo_fetch("SELECT * FROM".tablename('qw_kuaicai_order')."WHERE uniacid = '{$_W['uniacid']}' and uid=".$v['uid']." and addtime>'$starttime' and addtime<'$endtime'");

			   if(empty($tomorder)){

                 //如果明天没有订单，则发送标记要处理的订单


				   $order = array(

					   'ordersn'=>time().rand(1000,2000),
					   'uniacid'=>$_W['uniacid'],
					   'uid'=>$v['uid'],
					   'xuanze'=>$yxarr,
					   'addtime'=>$starttime+60*60,
					   'count'=>1,
					   'status'=>1,
				   );



				   //插入数据库

				   $res = pdo_insert("qw_kuaicai_order",$order);


                   if($res){

					   $url=$this->createMobileurl("order");

					   $url = str_replace('./','http://'.$set['wangurl'].'/',$url);
					   $tplid= $set['tplid'];
					   $lefttpl = json_decode($set['lefttpl']);
					   $righttpl = json_decode($set['righttpl']);
					   $content=array();

					   foreach($lefttpl as $key=>$vv){

						   $righttpl[$key]=str_replace('[sn]',$order['ordersn'],$righttpl[$key]);

						   $righttpl[$key]=str_replace('[pro]',$pro,$righttpl[$key]);
						   $content[$vv]= array('value'=>$righttpl[$key]);


					   }

                        echo $v['openid'];
					   $this->sendtpl($v['openid'],$url,$tplid,$content);
					   //发送模板消息

					   echo "成功";
				   }else{

					   echo "失败";

				   }


			   }else{


				   echo "今日订单已经发送";
			   }

		   }


       }

		//根据用户信息，包括星期进行发送
		//增加订单状态

	}

	//广告ad管理

	public function doWebAd() {
		global $_W,$_GPC;

		$op = $_GPC['op']?trim($_GPC['op']):'display';

		if($op=='display'){


			$sql = 'SELECT * FROM '.tablename('qw_kuaicai_ad').' WHERE uniacid=:uniacid';
			$params = array(':uniacid'=>$_W['uniacid']);
			$adlist = pdo_fetchall($sql, $params);


		}
		else if($op=='edit'){



			$id = intval($_GPC['id']);
			if(!empty($id)){
				$sql = 'SELECT * FROM '.tablename('qw_kuaicai_ad').' WHERE id=:id AND uniacid=:uniacid LIMIT 1';
				$params = array(':id'=>$id, ':uniacid'=>$_W['uniacid']);


				$ad = pdo_fetch($sql, $params);




				if(empty($ad)){
					message('没有此广告.', $this->createWebUrl('product'));
				}
			}

			if(checksubmit('submit')){



				$data = array(

					'title'=>trim($_GPC['title']),
					'pic'=>$_GPC['pic'],

					'uniacid'=>$_W['uniacid'],
					'url'=>$_GPC['url'],

					'status'=>$_GPC['status']?$_GPC['status']:1,//1为显示，2为隐藏


				);



				if(!empty($id)){

					pdo_update('qw_kuaicai_ad',$data,array('id'=>$id));
				}else{

					pdo_insert('qw_kuaicai_ad',$data);
				}
				message('数据更新成功！', $this->createWebUrl('ad',array('op' => 'display')), 'success');

			}

		}elseif($op=="del"){

			if(!intval($_GPC['idd'])){

				message("不存在",$this->createWeburl('ad'));
			}

			$idd = intval($_GPC['idd']);

			$res = pdo_delete('qw_kuaicai_ad',array('id'=>$idd));
			if($res){

				message("删除成功",$this->createWeburl('ad'),'success');
			}else{

				message("删除失败",$this->createWeburl('ad'),'error');
			}


		}



		include $this->template('ad');
		//这个操作被定义用来呈现 管理中心导航菜单
	}


	//模板消息提醒
	public function sendtpl($openid, $url, $template_id, $content) {

		global $_GPC, $_W;

		load() -> classs('weixin.account');

		load() -> func('communication');

		$obj = new WeiXinAccount();

		$access_token = $obj -> fetch_available_token();

		$data = array(
			'touser' => $openid,
			'template_id' => $template_id,
			'url' => $url,
			'topcolor' => "#FF0000",
			'data' => $content,

		);

		$json = json_encode($data);

		$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;

		$ret = ihttp_post($url, $json);
	}

	//发送文本消息

	public function sendtext($text,$openid){

		global $_GPC, $_W;
		load() -> func('tpl');
		load() -> model('mc');
		$acc = WeAccount::create($_W['account']['acid']);

		$send = array("touser" =>$openid, "msgtype" => "text", "text" => array("content" => urlencode($text)));
		$res = $acc -> sendCustomNotice($send);

	}

	public function  doWebsendtest(){
		global $_GPC, $_W;

		$set = $this->settings;

		//print_r($set);


		$openid = 'oiKBctxrMCnI4ULuoSRFaznglgnU';
		$url="http://www.baidu.com/";
		$succtplid= $set['succtplid'];

		$ordersn = "##替换ordersn123##";
		$succlefttpl = json_decode($set['succlefttpl']);
		$succrighttpl = json_decode($set['succrighttpl']);
		$content=array();

		foreach($succlefttpl as $key=>$v){

			$succrighttpl[$key]=str_replace('[sn]',$ordersn,$succrighttpl[$key]);

            $content[$v]= array('value'=>$succrighttpl[$key]);


		}





		$this->sendtpl($openid,$url,$succtplid,$content);

		$tplid= $set['tplid'];

		$ordersn = "##替换ordersn123##";
		$lefttpl = json_decode($set['lefttpl']);
		$righttpl = json_decode($set['righttpl']);
		$content2=array();

		foreach($lefttpl as $key=>$v){

			$righttpl[$key]=str_replace('[sn]',$ordersn,$righttpl[$key]);

			$content2[$v]= array('value'=>$righttpl[$key]);


		}
		$this->sendtpl($openid,$url,$tplid,$content2);



	}
}