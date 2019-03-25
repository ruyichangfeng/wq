<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
defined ( 'IN_IA' ) or exit ( 'Access Denied' );
define('OSSURL', $_W['sitescheme'].'weimeizhanoss.oss-cn-shenzhen.aliyuncs.com/');
class Core extends WeModuleSite {

	// ===============================================
	public $m = 'wx_school';
	public $table_classify = 'wx_school_classify';
	public $table_score = 'wx_school_score';
	public $table_news = 'wx_school_news';
	public $table_index = 'wx_school_index';
	public $table_students = 'wx_school_students';
	public $table_tcourse = 'wx_school_tcourse';
	public $table_teachers = 'wx_school_teachers';
	public $table_area = 'wx_school_area';
    public $table_type = 'wx_school_type';
    public $table_kcbiao = 'wx_school_kcbiao';
	public $table_cook = 'wx_school_cookbook';
	public $table_reply = 'wx_school_reply';
	public $table_banners = 'wx_school_banners';
	public $table_bbsreply = 'wx_school_bbsreply';
	public $table_user = 'wx_school_user';
	public $table_set = 'wx_school_set';
	public $table_leave = 'wx_school_leave';
	public $table_notice = 'wx_school_notice';
	public $table_bjq = 'wx_school_bjq';
	public $table_media = 'wx_school_media';
	public $table_dianzan = 'wx_school_dianzan';
	public $table_order = 'wx_school_order';
    public $table_wxpay = 'wx_school_wxpay';
    public $table_group = 'wx_school_fans_group';
	public $table_qrinfo = 'wx_school_qrcode_info';
	public $table_qrset = 'wx_school_qrcode_set';
	public $table_qrstat = 'wx_school_qrcode_statinfo';
	public $table_cost = 'wx_school_cost';
	public $table_object = 'wx_school_object';
	public $table_signup = 'wx_school_signup';
	public $table_record = 'wx_school_record';
	public $table_checkmac = 'wx_school_checkmac';
	public $table_checklog = 'wx_school_checklog';
	public $table_idcard = 'wx_school_idcard';
	public $table_icon = 'wx_school_icon';
	public $table_timetable = 'wx_school_timetable';
	public $table_zjh = 'wx_school_zjh';
	public $table_zjhset = 'wx_school_zjhset';
	public $table_zjhdetail = 'wx_school_zjhdetail';
	public $table_scset = 'wx_school_shouceset';
	public $table_scicon = 'wx_school_shouceseticon';
	public $table_sc = 'wx_school_shouce';
	public $table_scpy = 'wx_school_shoucepyk';
	public $table_scforxs = 'wx_school_scforxs';
	public $table_allcamera = 'wx_school_allcamera';
	public $table_camerapl = 'wx_school_camerapl';
	public $table_class = 'wx_school_user_class';
	public $table_online = 'wx_school_online';
	public $table_questions = 'wx_school_questions';
	public $table_answers = 'wx_school_answers';	

    public function getNaveMenu($schoolid, $action)
    {
        global $_W, $_GPC;
        $do = $_GPC['do'];
        $navemenu = array();
		$school = pdo_fetch("SELECT is_cost,is_recordmac,is_rest,shoucename,is_video,videoname,is_kb FROM " . tablename($this->table_index) . " WHERE :id = id", array(':id' => $schoolid));
			$navemenu[0] = array(
				'title' => '<icon style="color:#d9534f;" class="fa fa-cog"></icon>  基本设置',
				'items' => array(
					0 => array(
						'title' => '校园概览 ',
						'url' => $do != 'start' ? $this->createWebUrl('start', array('op' => 'display', 'schoolid' => $schoolid)) : '',
						'active' => $action == 'start' ? ' active' : '',
						'append' => array(
							'title' => '<i style="color:#d9534f;" class="fa fa-bank"></i>',
						),
					),			
					1 => array(
						'title' => '校园设置 ',
						'url' => $do != 'schoolset' ? $this->createWebUrl('schoolset', array('op' => 'post', 'schoolid' => $schoolid)) : '',
						'active' => $action == 'schoolset' ? ' active' : '',
						'append' => array(
							'title' => '<i style="color:#d9534f;" class="fa fa-cog"></i>',
						),
					),
					2 => array(
						'title' => '基础设置 ',
						'url' => $do != 'semester' ? $this->createWebUrl('semester', array('op' => 'display', 'schoolid' => $schoolid)) : '',
						'active' => $action == 'semester' ? ' active' : '',
						'append' => array(
							'title' => '<i style="color:#d9534f;" class="fa fa-bars"></i>',
						),
					),
				),
				'icon' => 'fa fa-user-md',
				'this' => 'no1'
			);
			if ($school['is_video']==1 && !empty($school['videoname'])) {
				$navemenu[0]['items'][] = array(
					'title' => $school['videoname'],
					'url' => $do != 'allcamera' ? $this->createWebUrl('allcamera', array('op' => 'display', 'schoolid' => $schoolid)) : '',
					'active' => $action == 'allcamera' ? ' active' : '',
					'append' => array(
						'title' => '<i style="color:#d9534f;" class="fa fa-eye"></i>',
					),
				);
			}
			$navemenu[0]['items'][] = array(
				'title' => '食谱管理', 'url' => $do != 'cook' ? $this->createWebUrl('cook', array('op' => 'display', 'schoolid' => $schoolid)) : '',
				'active' => $action == 'cook' ? ' active' : '',
				'append' => array(
					'title' => '<i style="color:#d9534f;" class="fa fa-cutlery"></i>',
				)
			);
			$navemenu[0]['items'][] = array(
				'title' => '幻灯片管理',
				'url' => $do != 'banner' ? $this->createWebUrl('banner', array('op' => 'display', 'schoolid' => $schoolid)) : '',
				'active' => $action == 'banner' ? ' active' : '',
				'append' => array(
					'title' => '<i style="color:#d9534f;" class="fa fa-image"></i>',
				),
			);
			$navemenu[1] = array(
				'title' => '<icon style="color:#7228b5;" class="fa fa-database"></icon>  教务管理',
				'items' => array(
					0 => array(
						'title' => '教师管理',
						'url' => $do != 'assess' ? $this->createWebUrl('assess', array('op' => 'display', 'schoolid' => $schoolid)) : '',
						'active' => $action == 'assess' ? ' active' : '',
						'append' => array(
							'title' => '<i style="color:#7228b5;" class="fa fa-user"></i>',
						),
					),
					1 => array('title' => '学生管理', 'url' => $do != 'students' ? $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)) : '',
						'active' => $action == 'students' ? ' active' : '',
						'append' => array(
							'title' => '<i style="color:#7228b5;" class="fa fa-users"></i>',
						),
					),
					2 => array('title' => '成绩管理', 'url' => $do != 'chengji' ? $this->createWebUrl('chengji', array('op' => 'display', 'schoolid' => $schoolid)) : '',
						'active' => $action == 'chengji' ? ' active' : '',
						'append' => array(
							'title' => '<i style="color:#7228b5;" class="fa fa-book"></i>',
						),
					),
					3 => array('title' => '课程管理', 'url' => $do != 'kecheng' ? $this->createWebUrl('kecheng', array('op' => 'display', 'schoolid' => $schoolid)) : '',
						'active' => $action == 'kecheng' ? ' active' : '',
						'append' => array(
							'title' => '<i style="color:#7228b5;" class="fa fa-graduation-cap"></i>',
						),
					),
				),	
				'this' => 'no2'	
			);
			if ($school['is_kb'] == 1) {
				$navemenu[1]['items'][] = array(	
					'title' => '公立课表',
					'url' => $do != 'timetable' ? $this->createWebUrl('timetable', array('op' => 'display', 'schoolid' => $schoolid)) : '',
					'active' => $action == 'timetable' ? ' active' : '',
					'append' => array(
						'title' => '<i style="color:#7228b5;" class="fa fa-bomb"></i>',
					),
				);
			}			
			if ($school['is_rest'] == 1 && $school['shoucename']) {	
				$navemenu[1]['items'][] = array(				
					'title' => $school['shoucename'],
					'url' => $do != 'shoucelist' ? $this->createWebUrl('shoucelist', array('op' => 'display', 'schoolid' => $schoolid)) : '',
					'active' => $action == 'shoucelist' ? ' active' : '',
					'append' => array(
						'title' => '<i style="color:#7228b5;" class="fa fa-child"></i>',
					),									
				);		
			}			
        $navemenu[2] = array(
            'title' => '<icon style="color:#258a25;" class="fa fa-wechat"></icon> 互动管理',
            'items' => array(
                0 => array('title' => '作业通知请假', 'url' => $do != 'notice' ? $this->createWebUrl('notice', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                    'active' => $action == 'notice' ? ' active' : '',
                    'append' => array(
                        'title' => '<i style="color:#258a25;" class="fa fa-bullhorn"></i>',
                    ),
                ),
                1 => array('title' => '报名管理', 'url' => $do != 'signup' ? $this->createWebUrl('signup', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                    'active' => $action == 'signup' ? ' active' : '',
                    'append' => array(
                        'title' => '<i style="color:#258a25;" class="fa fa-comments"></i>',
                    ),
                ),
                2 => array('title' => '文章系统', 'url' => $do != 'article' ? $this->createWebUrl('article', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                    'active' => $action == 'article' ? ' active' : '',
                    'append' => array(
                        'title' => '<i style="color:#258a25;" class="fa fa-desktop"></i>',
                    ),
                ),
                3 => array('title' => '班级圈管理', 'url' => $do != 'bjquan' ? $this->createWebUrl('bjquan', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                    'active' => $action == 'bjquan' ? ' active' : '',
                    'append' => array(
                        'title' => '<i style="color:#258a25;" class="fa fa-wechat"></i>',
                    ),
                ),
                4 => array('title' => '相册管理', 'url' => $do != 'photos' ? $this->createWebUrl('photos', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                    'active' => $action == 'photos' ? ' active' : '',
                    'append' => array(
                        'title' => '<i style="color:#258a25;" class="fa fa-camera"></i>',
                    ),
                ),
            ),
			'this' => 'no3'	
        );
        if ($school['is_cost'] == 2) {
            if ($_W['isfounder'] || $_W['role'] == 'owner') {
                $navemenu[3] = array(
                    'title' => '<icon style="color:#cc6b08;" class="fa fa-money"></icon>  财务管理',
                    'items' => array(
                        0 => array('title' => '缴费管理', 'url' => $do != 'cost' ? $this->createWebUrl('cost', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                            'active' => $action == 'cost' ? ' active' : '',
                            'append' => array(
                                'title' => '<i style="color:#cc6b08;" class="fa fa-money"></i>',
                            ),
                        ),
                        1 => array('title' => '订单管理', 'url' => $do != 'payall' ? $this->createWebUrl('payall', array('op' => 'display', 'schoolid' => $schoolid, 'is_pay' => '-1')) : '',
                            'active' => $action == 'payall' ? ' active' : '',
                            'append' => array(
                                'title' => '<i style="color:#cc6b08;" class="fa fa-bar-chart-o"></i>',
                            ),
                        ),
                    ),
					'this' => 'no4'	
                );
            }
        } else {
            $navemenu[3] = array(
                'title' => '<icon style="color:#cc6b08;" class="fa fa-money"></icon>  财务管理',
                'items' => array(
                    0 => array('title' => '缴费管理', 'url' => $do != 'cost' ? $this->createWebUrl('cost', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                        'active' => $action == 'cost' ? ' active' : '',
                        'append' => array(
                            'title' => '<i style="color:#cc6b08;" class="fa fa-money"></i>',
                        ),
                    ),
                    1 => array('title' => '订单管理', 'url' => $do != 'payall' ? $this->createWebUrl('payall', array('op' => 'display', 'schoolid' => $schoolid, 'is_pay' => '-1')) : '',
                        'active' => $action == 'payall' ? ' active' : '',
                        'append' => array(
                            'title' => '<i style="color:#cc6b08;" class="fa fa-bar-chart-o"></i>',
                        ),
                    ),
                ),
				'this' => 'no4'	
            );
        }
        if ($school['is_recordmac'] == 2) {
            if ($_W['isfounder'] || $_W['role'] == 'owner') {
                $navemenu[4] = array(
                    'title' => '<icon style="color:#077ccc;" class="fa fa-credit-card"></icon>  考勤管理',
                    'items' => array(
                        0 => array('title' => '考勤记录', 'url' => $do != 'checklog' ? $this->createWebUrl('checklog', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                            'active' => $action == 'checklog' ? ' active' : '',
                            'append' => array(
                                'title' => '<i style="color:#077ccc;" class="fa fa-table"></i>',
                            ),
                        ),
                        1 => array('title' => '设备管理', 'url' => $do != 'check' ? $this->createWebUrl('check', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                            'active' => $action == 'check' ? ' active' : '',
                            'append' => array(
                                'title' => '<i style="color:#077ccc;" class="fa fa-gears"></i>',
                            ),
                        ),
                        2 => array('title' => '考勤卡库', 'url' => $do != 'cardlist' ? $this->createWebUrl('cardlist', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                            'active' => $action == 'cardlist' ? ' active' : '',
                            'append' => array(
                                'title' => '<i style="color:#077ccc;" class="fa fa-credit-card"></i>',
                            ),
                        ),
                    ),
					'this' => 'no5'	
                );
            }
        } else {
            $navemenu[4] = array(
                'title' => '<icon style="color:#077ccc;" class="fa fa-credit-card"></icon>  考勤管理',
                'items' => array(
                    0 => array('title' => '考勤记录', 'url' => $do != 'checklog' ? $this->createWebUrl('checklog', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                        'active' => $action == 'checklog' ? ' active' : '',
                        'append' => array(
                            'title' => '<i style="color:#077ccc;" class="fa fa-table"></i>',
                        ),
                    ),
                    1 => array('title' => '设备管理', 'url' => $do != 'check' ? $this->createWebUrl('check', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                        'active' => $action == 'check' ? ' active' : '',
                        'append' => array(
                            'title' => '<i style="color:#077ccc;" class="fa fa-gears"></i>',
                        ),
                    ),
                    2 => array('title' => '考勤卡库', 'url' => $do != 'cardlist' ? $this->createWebUrl('cardlist', array('op' => 'display', 'schoolid' => $schoolid)) : '',
                        'active' => $action == 'cardlist' ? ' active' : '',
                        'append' => array(
                            'title' => '<i style="color:#077ccc;" class="fa fa-credit-card"></i>',
                        ),
                    ),
                ),
				'this' => 'no5'
            );
        }
        return $navemenu;
    }

	public function sendtempmsg($template_id, $url, $data, $topcolor, $tousers = '') {
		load()->func('communication');
		load()->classs('weixin.account');
		$access_token = WeAccount::token();
		if(empty($access_token)) {
			return;
		}
		$postarr = '{"touser":"'.$tousers.'","template_id":"'.$template_id.'","url":"'.$url.'","topcolor":"'.$topcolor.'","data":'.$data.'}';
		$res = ihttp_post('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token,$postarr);
		return true;
	}

	public function sendMobileBmshtz($signup_id, $schoolid, $weid, $tid, $s_name) { //报名审核提醒老师
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'bjqshtz');
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['bjqshtz'] == 1 || !empty($smsset['bjqshtz'])){
			$teacher = pdo_fetch("SELECT id,openid,mobile,tname FROM " . tablename($this->table_teachers) . " WHERE :id = id ", array(':id' => $tid));
			$signtype = pdo_fetch("SELECT bj_id,orderid FROM " . tablename($this->table_signup) . " where :id = id", array(':id' => $signup_id));
			$class = pdo_fetch("SELECT cost FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $signtype['bj_id']));
			if(!empty($class['cost'])){
				$order = pdo_fetch("SELECT status FROM " . tablename($this->table_order) . " where id = :id ", array(':id' => $signtype['orderid']));
			}
			$leibie = "学生报名申请";
			if(!empty($class['cost'])){
				if($order['status'] == 1){
					$zhuangtai = "未付费";
				}else{
					$zhuangtai = "已付费";
				}
			}else{
				$zhuangtai = "未通过";
			}
			$ttime = date('Y-m-d H:i:s', TIMESTAMP);
			$body = "点击本条消息快速审核 ";
			$datas=array(
			'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
			'first'=>array('value'=>'老师您好,您收到了一条报名审核提醒','color'=>'#FF9E05'),
			'keyword1'=>array('value'=>$leibie,'color'=>'#1587CD'),
			'keyword2'=>array('value'=>$s_name,'color'=>'#FF9E05'),
			'keyword3'=>array('value'=>$zhuangtai,'color'=>'#1587CD'),
			'keyword4'=>array('value'=>$ttime,'color'=>'#1587CD'),
			'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );
			$data=json_encode($datas); //发送的消息模板数据
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('bm', array('schoolid' => $schoolid, 'id' => $signup_id));
			if(isallow_sendsms($schoolid,'bjqshtz')){
				if($teacher['mobile']){
					$ttimes = date('m月d日 H:i', TIMESTAMP);
					$content = array(
						'name' => $s_name,
						'time' => $ttimes,
						'type' => "报名申请审核",
					);
					mload()->model('sms');
					sms_send($teacher['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'bmshtz', $weid, $schoolid);
				}
			}
			if (!empty($smsset['bjqshtz'])) {
				$this->sendtempmsg($smsset['bjqshtz'], $url, $data, '#FF0000', $teacher['openid']);
			}
		}
	}
	
	public function sendMobileBmshjg($signupid, $schoolid, $weid, $toopenid, $s_name) { //老师修改报名资料后，会提醒学生(无需发短信)
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'bjqshjg');	
		if(!empty($smsset['bjqshjg'])){		
			$signtype = pdo_fetch("SELECT * FROM " . tablename($this->table_signup) . " where :id = id", array(':id' => $signupid));
			$class = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $signtype['bj_id']));
			if(!empty($class['cost'])){
				$order = pdo_fetch("SELECT status FROM " . tablename($this->table_order) . " where id = :id ", array(':id' => $signtype['orderid']));
			}
			$leibie = "报名申请";
			if(!empty($class['cost'])){
				if($order['status'] == 1){
					$zhuangtai = "未付费";
					$body = "点击本条消息快速支付报名费";
				}else{
					$zhuangtai = "已付费";
					$body = "点击本条消息快速查看 ";
				}
			}else{
				$zhuangtai = "审核中";
				$body = "点击本条消息快速查看 ";
			}
			$ttime = date('Y-m-d H:i:s', TIMESTAMP);
			$datas=array(
			'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
			'first'=>array('value'=>'您好,【'.$s_name.'】的报名资料已经开始审核','color'=>'#FF9E05'),
			'keyword1'=>array('value'=>$leibie,'color'=>'#1587CD'),
			'keyword2'=>array('value'=>$zhuangtai,'color'=>'#FF9E05'),
			'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
			'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );
			$data=json_encode($datas); //发送的消息模板数据
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('signupjc', array('schoolid' => $schoolid, 'id' =>$signupid));
			$this->sendtempmsg($smsset['bjqshjg'], $url, $data, '#FF0000', $toopenid);	
		}
	}

	public function sendMobileBmshjgtz($signupid, $schoolid, $weid, $toopenid, $s_name, $rand) {  //报名结果通知学生
		global $_GPC,$_W;	
		$smsset = get_weidset($weid,'bjqshjg');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['bjqshjg'] == 1 || !empty($smsset['bjqshjg'])){
			$signtype = pdo_fetch("SELECT * FROM " . tablename($this->table_signup) . " where id = :id", array(':id' => $signupid));
			$leibie = "报名申请";
			if ($signtype['status'] == 2){
				$zhuangtai = "已通过";
				$body = "您可以通过以下信息绑定学生:\n学生姓名:{$s_name}\n学号:{$signtype['numberid']}\n手机号码:{$signtype['mobile']}\n绑定码:{$rand}\n千万不要将本信息告诉给陌生人 ";
			}else if($signtype['status'] == 3){
				$zhuangtai = "未通过";
				$body = "点击本条消息查看详情 ";
			}

			$ttime = date('Y-m-d H:i:s', TIMESTAMP);

			$datas=array(
				'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
				'first'=>array('value'=>'您好,【'.$s_name.'】的报名资料审核完毕','color'=>'#FF9E05'),
				'keyword1'=>array('value'=>$leibie,'color'=>'#1587CD'),
				'keyword2'=>array('value'=>$s_name,'color'=>'#FF9E05'),
				'keyword3'=>array('value'=>$zhuangtai,'color'=>'#1587CD'),
				'keyword4'=>array('value'=>$ttime,'color'=>'#1587CD'),
				'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );				 
			$data=json_encode($datas); //发送的消息模板数据
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('signupjc', array('schoolid' => $schoolid, 'id' =>$signupid));
			if (!empty($smsset['bjqshjg'])) {
				$this->sendtempmsg($smsset['bjqshjg'], $url, $data, '#FF0000', $toopenid);
			}
			if(isallow_sendsms($schoolid,'bjqshjg')){
				if($signtype['mobile']){
					$content = array(
						'name' => $s_name,
						'type' => "报名申请审核",
						'result' => $zhuangtai,
					);
					mload()->model('sms');
					sms_send($signtype['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'bmshjgtz', $weid, $schoolid);
				}
			}			
		}
	}	

	public function sendMobileSignshtz($logid) { //微信签到审核提醒老师
		global $_GPC,$_W;
		$log = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " where :id = id", array(':id' => $logid));
		$schoolid = $log['schoolid'];
		$weid = $log['weid'];		
		$smsset = get_weidset($weid,'bjqshtz');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['bjqshtz'] == 1 || !empty($smsset['bjqshtz'])){
			$class = pdo_fetch("SELECT tid FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $log['bj_id']));
			$teacher = pdo_fetch("SELECT openid,tname,mobile FROM " . tablename($this->table_teachers) . " where id = :id And schoolid = :schoolid ", array(':schoolid' => $log['schoolid'],':id' => $class['tid']));
			$student = pdo_fetch("SELECT s_name FROM " . tablename($this->table_students) . " where id = :id ", array(':id' => $log['sid']));
			$school = pdo_fetch("SELECT is_signneedcomfim FROM " . tablename($this->table_index) . " where id = :id ", array(':id' => $log['schoolid']));
			if($log['leixing'] ==1){
				$leixing == "到校";
			}else{
				$leixing == "离校";
			}
			$title = "学生{$leixing}签到审核提醒";
			if($log['isconfirm'] == 1){
				$zhuangtai = "已通过";
			}else{
				$zhuangtai = "未审核";
			}
			$ttime = date('Y-m-d H:i:s', $log['createtime']);
			$time = date('Y-m-d', $log['createtime']);
			$body = "点击本条消息快速审核";
			$datas=array(
			'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
			'first'=>array('value'=>''.$teacher['tname'].'老师您好,您收到了一条签到审核提醒','color'=>'#FF9E05'),
			'keyword1'=>array('value'=>$title,'color'=>'#1587CD'),
			'keyword2'=>array('value'=>$student['s_name'],'color'=>'#FF9E05'),
			'keyword3'=>array('value'=>$zhuangtai,'color'=>'#1587CD'),
			'keyword4'=>array('value'=>$ttime,'color'=>'#1587CD'),
			'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );
			$data=json_encode($datas); //发送的消息模板数据
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('signlist', array('schoolid' => $log['schoolid'],'time' => $time,'bj_id' => $log['bj_id']));
			if (!empty($smsset['bjqshtz'])) {
				$this->sendtempmsg($smsset['bjqshtz'], $url, $data, '#FF0000', $teacher['openid']);
			}
			if(isallow_sendsms($schoolid,'bjqshtz')){
				if($teacher['mobile']){
					$ttimes = date('m月d日 H:i', TIMESTAMP);
					$content = array(
						'name' => $student['s_name'],
						'time' => $ttimes,
						'type' => "微信签到审核",
					);
					mload()->model('sms');
					sms_send($teacher['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'signshtz', $weid, $schoolid);
				}
			}
		}		
	}
	
	public function sendMobileFzqdshjg($logid) { //微信辅助签到确认结果通知给学生
		global $_GPC,$_W;
		$log = pdo_fetch("SELECT sid,leixing,schoolid,weid FROM " . tablename($this->table_checklog) . " where :id = id", array(':id' => $logid));
		$schoolid = $log['schoolid'];
		$weid = $log['weid'];
		$sms_set = get_school_sms_set($schoolid);
		$smsset = get_weidset($weid,'bjqshjg');
		if($sms_set['bjqshjg'] == 1 || !empty($smsset['bjqshjg'])){
			$student = pdo_fetch("SELECT s_name FROM " . tablename($this->table_students) . " where id = :id ", array(':id' => $log['sid']));
			if($log['leixing'] ==1){
				$leixing == "到校";
			}else{
				$leixing == "离校";
			}
			$leibie = "签到确认成功";
			$zhuangtai = "审核通过";
			$ttime = date('Y-m-d H:i:s', TIMESTAMP);
			$body = "点击本条消息快速查看 ";
			$openidall = pdo_fetchall("select sid,id,openid,userinfo from ".tablename($this->table_user)." where sid = '{$log['sid']}'");
			$body  = "点击本条消息查看详情 ";
			$num = count($openidall);
			if ($num > 1){
				foreach ($openidall as $key => $values) {
					$openid = $values['openid'];
					$datas=array(
					'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
					'first'=>array('value'=>'您好'.$student['s_name'].',您的'.$leixing.'签到已审核通过','color'=>'#FF9E05'),
					'keyword1'=>array('value'=>$leibie,'color'=>'#1587CD'),
					'keyword2'=>array('value'=>$zhuangtai,'color'=>'#FF9E05'),
					'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
					'remark'=> array('value'=>$body,'color'=>'#FF9E05')
					 );
					$data = json_encode($datas); //发送的消息模板数据
					$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('calendar', array('schoolid' => $log['schoolid'],'userid'=>$values['id']));				
					if($smsset['bjqshjg']){
						$this->sendtempmsg($smsset['bjqshjg'], $url, $data, '#FF0000', $openid);	
					}
					if(isallow_sendsms($schoolid,'bjqshjg')){
						$userinfo = unserialize($values['userinfo']);
						if($userinfo['mobile']){
							$content = array(
								'name' => $student['s_name'],
								'type' => "微信签到",
								'result' => "已通过",
							);
							mload()->model('sms');
							sms_send($userinfo['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'fzqdshjg', $weid, $schoolid);
						}
					}				
				}
			}else{
				$openid = $openidall['0']['openid'];
				$datas=array(
				'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
				'first'=>array('value'=>'您好'.$student['s_name'].',您的'.$leixing.'签到已审核通过','color'=>'#FF9E05'),
				'keyword1'=>array('value'=>$leibie,'color'=>'#1587CD'),
				'keyword2'=>array('value'=>$zhuangtai,'color'=>'#FF9E05'),
				'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
				'remark'=> array('value'=>$body,'color'=>'#FF9E05')
				 );
				$data = json_encode($datas); //发送的消息模板数据					
				$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('calendar', array('schoolid' => $log['schoolid'],'userid' => $openidall['0']['id']));
				if($smsset['bjqshjg']){
					$this->sendtempmsg($smsset['bjqshjg'], $url, $data, '#FF0000', $openid);	
				}
				if(isallow_sendsms($schoolid,'bjqshjg')){
					$userinfo = unserialize($openidall['0']['userinfo']);
					if($userinfo['mobile']){
						$content = array(
							'name' => $student['s_name'],
							'type' => "微信签到",
							'result' => "已通过",
						);
						mload()->model('sms');
						sms_send($userinfo['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'fzqdshjg', $weid, $schoolid);
					}
				}			
			}
		}
	}
	
	public function sendMobileBjqshtz($schoolid, $weid, $shername, $bj_id) { //班级圈审核提醒老师
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'bjqshtz');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['bjqshtz'] == 1 || !empty($smsset['bjqshtz'])){
			$bzj = pdo_fetch("SELECT tid FROM " . tablename($this->table_classify) . " where weid = :weid And schoolid = :schoolid And sid = :sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':sid' => $bj_id));
			$teachers = pdo_fetch("SELECT tname,openid,mobile FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $bzj['tid']));
			$leibie = "班级圈内容审核";
			$zhuangtai = "未通过";
			$ttime = date('Y-m-d H:i:s', TIMESTAMP);
			$body = "点击本条消息快速审核 ";
			$datas=array(
			'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
			'first'=>array('value'=>'老师您好,您收到了一条班级圈内容审核提醒','color'=>'#FF9E05'),
			'keyword1'=>array('value'=>$leibie,'color'=>'#1587CD'),
			'keyword2'=>array('value'=>$shername,'color'=>'#FF9E05'),
			'keyword3'=>array('value'=>$zhuangtai,'color'=>'#1587CD'),
			'keyword4'=>array('value'=>$ttime,'color'=>'#1587CD'),
			'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );
			$data=json_encode($datas); //发送的消息模板数据

			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('bjq', array('schoolid' => $schoolid, 'bj_id' => $bj_id));
			if(isallow_sendsms($schoolid,'bjqshtz')){
				if($teachers['mobile']){
					$ttimes = date('m月d日 H:i', TIMESTAMP);
					$content = array(
						'name' => $shername,
						'time' => $ttimes,
						'type' => "班级圈内容审核",
					);
					mload()->model('sms');
					sms_send($teachers['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'bjqshtz', $weid, $schoolid);
				}
			}
			if (!empty($smsset['bjqshtz'])) {
				$this->sendtempmsg($smsset['bjqshtz'], $url, $data, '#FF0000', $teachers['openid']);
			}
		}
	}

	public function sendMobileBjqshjg($schoolid, $weid, $shername, $toopenid, $userid) {  //班级圈内容审核结果通知学生
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'bjqshjg');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['bjqshjg'] == 1 || !empty($smsset['bjqshjg'])) {	
			$leibie = "班级圈内容审核";
			$zhuangtai = "审核通过";
			$ttime = date('Y-m-d H:i:s', TIMESTAMP);
			$body = "点击本条消息快速查看 ";
			$datas=array(
			'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
			'first'=>array('value'=>'您好'.$shername.',您收到一条班级圈审核结果通知','color'=>'#FF9E05'),
			'keyword1'=>array('value'=>$leibie,'color'=>'#1587CD'),
			'keyword2'=>array('value'=>$zhuangtai,'color'=>'#FF9E05'),
			'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
			'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );
			$data=json_encode($datas); //发送的消息模板数据
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('sbjq', array('schoolid' => $schoolid));
			if(isallow_sendsms($schoolid,'bjqshjg')){
				$user = pdo_fetch("select userinfo from ".tablename($this->table_user)." where id = '{$userid}'");
				$userinfo = unserialize($user['userinfo']);
				if($userinfo['mobile']){
					$content = array(
						'name' => $shername,
						'type' => "班级圈内容审核",
						'result' => "已通过",
					);
					mload()->model('sms');
					sms_send($userinfo['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'bjqshjg', $weid, $schoolid);
				}
			}			
			if (!empty($smsset['bjqshjg']) && !empty($toopenid)) {
				$this->sendtempmsg($smsset['bjqshjg'], $url, $data, '#FF0000', $toopenid);
			}
		}
	}
	
	public function doWebZuoyeMsg(){
		global $_GPC,$_W;
		$notice_id = $_GPC['notice_id'];
		$schoolid = $_GPC['schoolid'];
		$weid = $_GPC['weid'];
		$tname = $_GPC['tname'];
		$bj_id = $_GPC['bj_id'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 2;

		$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid And bj_id = :bj_id ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize,array(':weid'=>$weid, ':schoolid'=>$schoolid, ':bj_id'=>$bj_id));
		$total = pdo_fetchcolumn("SELECT COUNT(1) FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid And bj_id = :bj_id",array(':weid'=>$weid, ':schoolid'=>$schoolid, ':bj_id'=>$bj_id));

		$tp = ceil($total/$psize);
		for ($i=1; $i < $tp; $i++) {
			$this->sendMobileZuoye($notice_id, $schoolid, $weid, $tname, $bj_id, $pindex, $psize);
			if ($pindex == $i) {
				$mq = round(($pindex / $tp) * 100);
				$msg = '正在发送，目前：<strong style="color:#5cb85c">' . $mq . ' %</strong>,请勿执行任何操作';

				$page = $pindex + 1;
				$to = $this -> createWebUrl('ZuoyeMsg', array('notice_id' => $notice_id, 'schoolid' => $schoolid, 'weid' => $weid, 'tname' => $tname, 'bj_id' => $bj_id, 'page' => $page));
				$this->imessage($msg, $to);
			}
		}
		$this->imessage('发送成功！', $this -> createWebUrl('notice', array('op' => 'display5','schoolid' => $schoolid,'notice_id' => $notice_id)));
	}

	public function sendMobileZuoye($notice_id, $schoolid, $weid, $tname, $bj_id) {  //作业群发通知
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'zuoye');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['zuoye'] == 1 || !empty($smsset['zuoye'])) {
			$notice = pdo_fetch("SELECT * FROM ".tablename($this->table_notice)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $notice_id, ':schoolid' => $schoolid));
			$km = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE :sid = sid AND :schoolid =schoolid", array(':sid' => $notice['km_id'], ':schoolid' => $schoolid));
			$bj = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " WHERE :sid = sid AND :schoolid =schoolid", array(':sid' => $notice['bj_id'], ':schoolid' => $schoolid));
			$userinfo = pdo_fetchall("SELECT id FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid And bj_id = :bj_id ORDER BY id DESC",array(':weid'=>$weid, ':schoolid'=>$schoolid, ':bj_id'=>$notice['bj_id']));
			foreach ($userinfo as $key => $value) {
				$openidall = pdo_fetchall("select * from ".tablename($this->table_user)." where sid = '{$value['id']}'");
				$title ="【{$km['sname']}】-{$tname}发来一条作业消息!";
				$bjname  = "{$bj['sname']}";
				$body  = "点击本条消息查看详情 ";

				$num = count($openidall);
				if ($num > 1){
					foreach ($openidall as $key => $values) {
						$openid = $values['openid'];
						$mobileinfo = $values['userinfo'];
						$record = pdo_fetch("SELECT id FROM ".tablename($this->table_record)." where weid = :weid And schoolid = :schoolid And noticeid = :noticeid And openid = :openid And sid = :sid And userid = :userid And type = :type",array(
							':weid'=>$weid,
							':schoolid'=>$schoolid,
							':noticeid'=>$notice_id,
							':openid'=>$openid,
							':sid'=>$values['sid'],
							':userid'=>$values['id'],
							':type' => 2
						));
						$datas=array(
							'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
							'first'=>array('value'=>$title,'color'=>'#1587CD'),
							'keyword1'=>array('value'=>$bjname,'color'=>'#1587CD'),
							'keyword2'=>array('value'=>$notice['title'],'color'=>'#2D6A90'),
							'remark'=> array('value'=>$body,'color'=>'#FF9E05')
						);
						$data = json_encode($datas); //发送的消息模板数据
						if(empty($record['id'])){
							if($values['sid']){
								$date = array(
									'weid' =>  $notice['weid'],
									'schoolid' => $schoolid,
									'noticeid' => $notice_id,
									'sid' => $values['sid'],
									'userid' => $values['id'],
									'openid' => $openid,
									'type' => 2,
									'createtime' => $notice['createtime']
								);
								pdo_insert($this->table_record, $date);
								$record_id = pdo_insertid();
								if(!empty($notice['outurl'])){
									$url = $notice['outurl'];
								}else{
									$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('szuoye', array('schoolid' => $schoolid,'record_id' => $record_id,'id' => $notice_id,'userid' => $values['id']));
								}
								if(isallow_sendsms($schoolid,'zuoye')){
									$mobile = unserialize($mobileinfo);
									if($mobile['mobile']){
										$ttimes = date('m月d日 H:i', TIMESTAMP);
										$content = array(
											'name' => "(".$km['sname'].")-".$tname."老师",
											'time' => $ttimes,
										);
										mload()->model('sms');
										sms_send($mobile['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'zuoye', $weid, $schoolid);
									}
								}
								if(!empty($smsset['zuoye'])){	
									$this->sendtempmsg($smsset['zuoye'], $url, $data, '#FF0000', $openid);
								}	
							}
						}
					}
				}else{
					$openid = $openidall['0']['openid'];
					$mobileinfo = $openidall['0']['userinfo'];
					$record = pdo_fetch("SELECT id FROM ".tablename($this->table_record)." where weid = :weid And schoolid = :schoolid And noticeid = :noticeid And openid = :openid And sid = :sid And userid = :userid And type = :type",array(
						':weid'=>$notice['weid'],
						':schoolid'=>$schoolid,
						':noticeid'=>$notice_id,
						':openid'=>$openid,
						':sid'=>$openidall['0']['sid'],
						':userid'=>$openidall['0']['id'],
						':type' => 2
					));
					$datas=array(
						'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
						'first'=>array('value'=>$title,'color'=>'#1587CD'),
						'keyword1'=>array('value'=>$bjname,'color'=>'#1587CD'),
						'keyword2'=>array('value'=>$notice['title'],'color'=>'#2D6A90'),
						'remark'=> array('value'=>$body,'color'=>'#FF9E05')
					);
					$data = json_encode($datas); //发送的消息模板数据					
					if(empty($record['id'])){
						if($openidall['0']['sid']){
							$date = array(
								'weid' =>  $notice['weid'],
								'schoolid' => $schoolid,
								'noticeid' => $notice_id,
								'sid' => $openidall['0']['sid'],
								'userid' => $openidall['0']['id'],
								'openid' => $openid,
								'type' => 2,
								'createtime' => $notice['createtime']
							);
							pdo_insert($this->table_record, $date);
							$record_id = pdo_insertid();	
							if(!empty($notice['outurl'])){
								$url = $notice['outurl'];
							}else{
								$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('szuoye', array('schoolid' => $schoolid,'record_id' => $record_id,'id' => $notice_id,'userid' => $openidall['0']['id']));
							}
							if(isallow_sendsms($schoolid,'zuoye')){
								$mobile = unserialize($mobileinfo);
								if($mobile['mobile']){
									$ttimes = date('m月d日 H:i', TIMESTAMP);
									$content = array(
										'name' => "(".$km['sname'].")-".$tname."老师",
										'time' => $ttimes,
									);
									mload()->model('sms');
									sms_send($mobile['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'zuoye', $weid, $schoolid);
								}
							}							
							if(!empty($smsset['zuoye'])){	
								$this->sendtempmsg($smsset['zuoye'], $url, $data, '#FF0000', $openid);
							}
						}
					}
				}
			}
		}
	}
	public function doWebBjtzMsg(){
		global $_GPC,$_W;
		$notice_id = $_GPC['notice_id'];
		$schoolid = $_GPC['schoolid'];
		$weid = $_GPC['weid'];
		$tname = $_GPC['tname'];
		$bj_id = $_GPC['bj_id'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 2;

		$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid And bj_id = :bj_id ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize,array(':weid'=>$weid, ':schoolid'=>$schoolid, ':bj_id'=>$bj_id));
		$total = pdo_fetchcolumn("SELECT COUNT(1) FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid And bj_id = :bj_id",array(':weid'=>$weid, ':schoolid'=>$schoolid, ':bj_id'=>$bj_id));

		$tp = ceil($total/$psize);
		for ($i=1; $i < $tp; $i++) {
			$this->sendMobileBjtz($notice_id, $schoolid, $weid, $tname, $bj_id, $pindex, $psize);
			if ($pindex == $i) {
				$mq = round(($pindex / $tp) * 100);
				$msg = '正在发送，目前：<strong style="color:#5cb85c">' . $mq . ' %</strong>,请勿执行任何操作';

				$page = $pindex + 1;
				$to = $this -> createWebUrl('BjtzMsg', array('notice_id' => $notice_id, 'schoolid' => $schoolid, 'weid' => $weid, 'tname' => $tname, 'bj_id' => $bj_id, 'page' => $page));
				$this->imessage($msg, $to);
			}
		}
		$this->imessage('发送成功！', $this -> createWebUrl('notice', array('op' => 'display5','schoolid' => $schoolid,'notice_id' => $notice_id)));
	}

	public function sendMobileBjtz($notice_id, $schoolid, $weid, $tname, $bj_id) { //班级群发通知
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'bjtz');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['bjtz'] == 1 || !empty($smsset['bjtz'])) {
			$notice = pdo_fetch("SELECT * FROM ".tablename($this->table_notice)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $notice_id, ':schoolid' => $schoolid));
			$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE :weid = weid AND :schoolid =schoolid", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
			$userinfo=pdo_fetchall("SELECT * FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid And bj_id = :bj_id",array(':weid'=>$weid, ':schoolid'=>$schoolid, ':bj_id'=>$bj_id));
			foreach ($userinfo as $key => $value) {
				$openidall = pdo_fetchall("select * from ".tablename($this->table_user)." where sid = '{$value['id']}' ");
				$name  = "{$tname}老师";
				$bjname  = "{$category[$notice['bj_id']]['sname']}";
				$ttime = date('Y-m-d H:i:s', $notice['createtime']);
				$body  = "点击本条消息查看详情 ";
				$num = count($openidall);
				if ($num > 1){
					foreach ($openidall as $key => $values) {
						$openid = $values['openid'];
						$mobileinfo = $values['userinfo'];
						$record = pdo_fetch("SELECT id FROM ".tablename($this->table_record)." where weid = :weid And schoolid = :schoolid And noticeid = :noticeid And openid = :openid And sid = :sid And userid = :userid And type = :type",array(
							':weid'=>$weid,
							':schoolid'=>$schoolid,
							':noticeid'=>$notice_id,
							':openid'=>$openid,
							':sid'=>$values['sid'],
							':userid'=>$values['id'],
							':type'=>1
						));
						$student = pdo_fetch("SELECT s_name FROM ".tablename($this->table_students)." where id = :id",array(':id'=>$values['sid']));
						if($values['pard'] == 2){
							$guanxi = "妈妈";
						}else if($values['pard'] == 3){
							$guanxi = "爸爸";
						}else if($values['pard'] == 4){
							$guanxi = "";
						}else if($values['pard'] == 5){
							$guanxi = "家长";
						}
						$title = "【{$student['s_name']}】{$guanxi}，您收到一条班级通知";
						$datas=array(
							'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
							'first'=>array('value'=>$title,'color'=>'#1587CD'),
							'keyword1'=>array('value'=>$bjname,'color'=>'#1587CD'),
							'keyword2'=>array('value'=>$name,'color'=>'#2D6A90'),
							'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
							'keyword4'=>array('value'=>$notice['title'],'color'=>'#1587CD'),
							'remark'=> array('value'=>$body,'color'=>'#FF9E05')
									);
						$data = json_encode($datas); //发送的消息模板数据

						if(empty($record['id'])){
							if($values['sid']){
								$date = array(
									'weid' =>  $weid,
									'schoolid' => $schoolid,
									'noticeid' => $notice_id,
									'sid' => $values['sid'],
									'userid' => $values['id'],
									'openid' => $openid,
									'type' => 1,
									'createtime' => $notice['createtime']
								);
								pdo_insert($this->table_record, $date);
								$record_id = pdo_insertid();
								if(!empty($notice['outurl'])){
									$url = $notice['outurl'];
								}else{
									$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('snotice', array('schoolid' => $schoolid,'record_id' => $record_id,'id' => $notice_id,'userid' => $values['id']));
								}
								if(isallow_sendsms($schoolid,'bjtz')){
									$mobile = unserialize($mobileinfo);
									if($mobile['mobile']){
										$ttimes = date('m月d日 H:i', TIMESTAMP);
										$content = array(
											'name' => "(".$student['s_name'].")".$guanxi,
											'time' => $ttimes,
											'type' => "班级通知",
										);
										mload()->model('sms');
										sms_send($mobile['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'bjtz', $weid, $schoolid);
									}
								}
								if(!empty($smsset['bjtz'])){
									$this->sendtempmsg($smsset['bjtz'], $url, $data, '#FF0000', $openid);
								}
							}
						}
					}
				}else{
						$openid = $openidall['0']['openid'];
						$mobileinfo = $openidall['0']['userinfo'];
						$record = pdo_fetch("SELECT id FROM ".tablename($this->table_record)." where weid = :weid And schoolid = :schoolid And noticeid = :noticeid And openid = :openid And sid = :sid And userid = :userid And type = :type",array(
											':weid'=>$_W['uniacid'],
											':schoolid'=>$schoolid,
											':noticeid'=>$notice_id,
											':openid'=>$openid,
											':sid'=>$openidall['0']['sid'],
											':userid'=>$openidall['0']['id'],
											':type'=>1,
						));
						$student = pdo_fetch("SELECT s_name FROM ".tablename($this->table_students)." where id = :id",array(':id'=>$openidall['0']['sid']));
						if($openidall['0']['pard'] == 2){
							$guanxi = "妈妈";
						}else if($openidall['0']['pard'] == 3){
							$guanxi = "爸爸";
						}else if($openidall['0']['pard'] == 4){
							$guanxi = "";
						}else if($openidall['0']['pard'] == 5){
							$guanxi = "家长";
						}
						$title = "【{$student['s_name']}】{$guanxi}，您收到一条班级通知";
						$datas=array(
							'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
							'first'=>array('value'=>$title,'color'=>'#1587CD'),
							'keyword1'=>array('value'=>$bjname,'color'=>'#1587CD'),
							'keyword2'=>array('value'=>$name,'color'=>'#2D6A90'),
							'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
							'keyword4'=>array('value'=>$notice['title'],'color'=>'#1587CD'),
							'remark'=> array('value'=>$body,'color'=>'#FF9E05')
									);
						$data = json_encode($datas); //发送的消息模板数据
						if(empty($record['id'])){
							if($openidall['0']['sid']){
								$date = array(
									'weid' =>  $_W['uniacid'],
									'schoolid' => $schoolid,
									'noticeid' => $notice_id,
									'sid' => $openidall['0']['sid'],
									'userid' => $openidall['0']['id'],
									'openid' => $openid,
									'type' => 1,
									'createtime' => $notice['createtime']
								);
								pdo_insert($this->table_record, $date);
								$record_id = pdo_insertid();
								if(!empty($notice['outurl'])){
								$url = $notice['outurl'];
								}else{
									$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('snotice', array('schoolid' => $schoolid,'record_id' => $record_id,'id' => $notice_id,'userid' => $openidall['0']['id']));
								}
								if(isallow_sendsms($schoolid,'bjtz')){
									$mobile = unserialize($mobileinfo);
									if($mobile['mobile']){
										$ttimes = date('m月d日 H:i', TIMESTAMP);
										$content = array(
											'name' => "(".$student['s_name'].")".$guanxi,
											'time' => $ttimes,
											'type' => "班级通知",
										);
										mload()->model('sms');
										sms_send($mobile['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'bjtz', $weid, $schoolid);
									}
								}
								if(!empty($smsset['bjtz'])){
									$this->sendtempmsg($smsset['bjtz'], $url, $data, '#FF0000', $openid);
								}
							}
						}
				}
			}
		}
	}
	
	public function doWebXytzMsg(){
		global $_GPC,$_W;
		$notice_id = $_GPC['notice_id'];
		$schoolid = $_GPC['schoolid'];
		$weid = $_GPC['weid'];
		$tname = $_GPC['tname'];
		$groupid = $_GPC['groupid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 2;
		if ($groupid == 1) {

		$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_user)." where weid = :weid And schoolid = :schoolid ORDER BY id ASC ",array(':weid'=>$weid, ':schoolid'=>$schoolid));
		$total = pdo_fetchcolumn("SELECT COUNT(1) FROM ".tablename($this->table_user)." where weid = :weid And schoolid = :schoolid",array(':weid'=>$weid, ':schoolid'=>$schoolid));

		}
		if ($groupid == 2) {

		$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_teachers)." where weid = :weid And schoolid = :schoolid ORDER BY id ASC ",array(':weid'=>$weid, ':schoolid'=>$schoolid));
		$total = pdo_fetchcolumn("SELECT COUNT(1) FROM ".tablename($this->table_teachers)." where weid = :weid And schoolid = :schoolid",array(':weid'=>$weid, ':schoolid'=>$schoolid));

		}
		if ($groupid == 3) {

		$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid ORDER BY id ASC LIMIT " . ($pindex - 1) * $psize . ',' . $psize,array(':weid'=>$weid, ':schoolid'=>$schoolid));
		$total = pdo_fetchcolumn("SELECT COUNT(1) FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid",array(':weid'=>$weid, ':schoolid'=>$schoolid));

        }
		$tp = ceil($total/$psize);
			//echo '第' . $pindex . '次,总共'.$tp.'次';

		for ($i=1; $i < $tp; $i++) {
			$this->sendMobileXytz($notice_id, $schoolid, $weid, $tname, $groupid, $pindex, $psize);
			if ($pindex == $i) {
				$mq = round(($pindex / $tp) * 100);
				$msg = '正在发送，目前：<strong style="color:#5cb85c">' . $mq . ' %</strong>,请勿执行任何操作';

				$page = $pindex + 1;
				$to = $this -> createWebUrl('XytzMsg', array('notice_id' => $notice_id, 'schoolid' => $schoolid, 'weid' => $weid, 'tname' => $tname, 'groupid' => $groupid, 'page' => $page));
				$this->imessage($msg, $to);
			}
		}
		$this->imessage('发送成功！', $this -> createWebUrl('notice', array('op' => 'display5','schoolid' => $schoolid,'notice_id' => $notice_id)));
	}

	public function sendMobileXytz($notice_id, $schoolid, $weid, $tname, $groupid,$pindex='1', $psize='20') { //校园群发通知
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'xxtongzhi');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['xxtongzhi'] == 1 || !empty($smsset['xxtongzhi'])) {
			$notice = pdo_fetch("SELECT title,outurl,createtime FROM ".tablename($this->table_notice)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $notice_id, ':schoolid' => $schoolid));
			$school = pdo_fetch("SELECT title FROM ".tablename($this->table_index)." WHERE :weid = weid AND :id = id", array(':weid' => $weid, ':id' => $schoolid));
			if ($groupid == 1) {

			$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_user)." where weid = :weid And schoolid = :schoolid LIMIT " . ($pindex - 1) * $psize . ',' . $psize,array(':weid'=>$weid, ':schoolid'=>$schoolid));

			}
			if ($groupid == 2) {

			$userinfo = pdo_fetchall("SELECT id,tname,mobile FROM ".tablename($this->table_teachers)." where weid = :weid And schoolid = :schoolid LIMIT " . ($pindex - 1) * $psize . ',' . $psize,array(':weid'=>$weid, ':schoolid'=>$schoolid));

			}
			if ($groupid == 3) {
				$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize,array(':weid'=>$weid, ':schoolid'=>$schoolid));

			}
			foreach ($userinfo as $key => $value) {
				$openid = "";
					if ($groupid == 2) {
						$openid = pdo_fetch("select * from ".tablename($this->table_user)." where tid = '{$value['id']}' ");
						$title = "【{$value['tname']}】老师，您收到一条学校通知";
						$schoolname ="{$school['title']}";
						$name  = "{$tname}老师";
						$ttime = date('Y-m-d H:i:s', $notice['createtime']);
						$body  = "点击本条消息查看详情 ";
						$datas=array(
							'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
							'first'=>array('value'=>$title,'color'=>'#1587CD'),
							'keyword1'=>array('value'=>$schoolname,'color'=>'#1587CD'),
							'keyword2'=>array('value'=>$name,'color'=>'#2D6A90'),
							'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
							'keyword4'=>array('value'=>$notice['title'],'color'=>'#1587CD'),
							'remark'=> array('value'=>$body,'color'=>'#FF9E05')
									);
						$data = json_encode($datas); //发送的消息模板数据
						//message($datas);

						$record = pdo_fetch("SELECT id FROM ".tablename($this->table_record)." where weid = :weid And schoolid = :schoolid And noticeid = :noticeid And openid = :openid And tid = :tid And userid = :userid And type = :type",array(
											':weid'=>$_W['uniacid'],
											':schoolid'=>$schoolid,
											':noticeid'=>$notice_id,
											':openid'=>$openid['openid'],
											':tid'=>$openid['tid'],
											':userid'=>$openid['id'],
											':type'=>3,
						));
						if(empty($record['id'])){
							if($openid['tid']){
								$date = array(
									'weid' =>  $_W['uniacid'],
									'schoolid' => $schoolid,
									'noticeid' => $notice_id,
									'tid' => $openid['tid'],
									'userid' => $openid['id'],
									'openid' => $openid['openid'],
									'type' => 3,
									'createtime' => $notice['createtime']
								);
								pdo_insert($this->table_record, $date);
								$record_id = pdo_insertid();
							
								if(!empty($notice['outurl'])){
									$url = $notice['outurl'];
								}else{
									$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('mnotice', array('schoolid' => $schoolid,'id' => $notice_id,'record_id' => $record_id));
								}
								if(isallow_sendsms($schoolid,'xxtongzhi')){
									if($value['mobile']){
										$ttimes = date('m月d日 H:i', TIMESTAMP);
										$content = array(
											'name' => $value['tname']."老师",
											'time' => $ttimes,
										);
										mload()->model('sms');
										sms_send($value['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'xxtongzhi', $weid, $schoolid);
									}
								}								
								if(!empty($smsset['xxtongzhi'])){
									$this->sendtempmsg($smsset['xxtongzhi'], $url, $data, '#FF0000', $openid['openid']);
								}
							}
						}
					}else{
						if ($groupid == 1) {
							$openid = pdo_fetch("select * from ".tablename($this->table_user)." where id = '{$value['id']}' ");
							if(!empty($value['pard'])){
								$student = pdo_fetch("SELECT s_name FROM ".tablename($this->table_students)." where id = :id",array(':id'=>$value['sid']));
								$ttime = date('Y-m-d H:i:s', $notice['createtime']);
								if($value['pard'] == 2){
									$guanxi = "妈妈";
								}else if($value['pard'] == 3){
									$guanxi = "爸爸";
								}else if($value['pard'] == 4){
									$guanxi = "";
								}else if($value['pard'] == 5){
									$guanxi = "家长";
								}
								$mobiles = unserialize($openid['userinfo']);
								$mobile = $mobiles['mobile'];
								$ttimes = date('m月d日 H:i', TIMESTAMP);
								$content = array(
									'name' => "(".$student['s_name'].")".$guanxi,
									'time' => $ttimes,
								);								
								$title = "【{$student['s_name']}】{$guanxi}，您收到一条学校通知";
								$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('snotice', array('schoolid' => $schoolid,'record_id' => $record_id,'id' => $notice_id,'userid' => $value['id']));							
							}else{
								$teacher = pdo_fetch("SELECT tname,mobile FROM ".tablename($this->table_teachers)." where id = :id",array(':id'=>$value['tid']));
								$title = "【{$teacher['tname']}】老师，您收到一条学校通知";
								$ttime = date('Y-m-d H:i:s', $notice['createtime']);
								$mobile = $teacher['mobile'];
								$ttimes = date('m月d日 H:i', TIMESTAMP);
								$content = array(
									'name' => $teacher['tname'],
									'time' => $ttimes,
								);
								$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('mnotice', array('schoolid' => $schoolid,'id' => $notice_id,'record_id' => $record_id));		
							}
							$schoolname ="{$school['title']}";
							$name  = "{$tname}老师";
							$body  = "点击本条消息查看详情 ";
							$datas=array(
								'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
								'first'=>array('value'=>$title,'color'=>'#1587CD'),
								'keyword1'=>array('value'=>$schoolname,'color'=>'#1587CD'),
								'keyword2'=>array('value'=>$name,'color'=>'#2D6A90'),
								'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
								'keyword4'=>array('value'=>$notice['title'],'color'=>'#1587CD'),
								'remark'=> array('value'=>$body,'color'=>'#FF9E05')
										);
							$data = json_encode($datas); //发送的消息模板数据
							if(!empty($value['pard'])){ //判断身份 然后检测是否发送本消息
								$record = pdo_fetch("SELECT id FROM ".tablename($this->table_record)." where weid = :weid And schoolid = :schoolid And noticeid = :noticeid And openid = :openid And sid = :sid And userid = :userid And type = :type",array(
													':weid'=>$_W['uniacid'],
													':schoolid'=>$schoolid,
													':noticeid'=>$notice_id,
													':openid'=>$openid['openid'],
													':sid'=>$openid['sid'],
													':userid'=>$openid['id'],
													':type'=>3
								));
								if(empty($record['id'])){
									if($openid['sid']){
										$date = array(
											'weid' =>  $_W['uniacid'],
											'schoolid' => $schoolid,
											'noticeid' => $notice_id,
											'sid' => $openid['sid'],
											'userid' => $openid['id'],
											'openid' => $openid['openid'],
											'type' => 3,
											'createtime' => $notice['createtime']
										);
										pdo_insert($this->table_record, $date);
										$record_id = pdo_insertid();
										if(!empty($notice['outurl'])){
											$url = $notice['outurl'];
										}
										if(isallow_sendsms($schoolid,'xxtongzhi')){
											if($mobile){
												mload()->model('sms');
												sms_send($mobile, $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'xxtongzhi', $weid, $schoolid);
											}
										}
										if(!empty($smsset['xxtongzhi'])){
											$this->sendtempmsg($smsset['xxtongzhi'], $url, $data, '#FF0000', $openid['openid']);
										}										
									}
								}
							}else{
								$record = pdo_fetch("SELECT id FROM ".tablename($this->table_record)." where weid = :weid And schoolid = :schoolid And noticeid = :noticeid And openid = :openid And tid = :tid And userid = :userid And type = :type",array(
													':weid'=>$_W['uniacid'],
													':schoolid'=>$schoolid,
													':noticeid'=>$notice_id,
													':openid'=>$openid['openid'],
													':tid'=>$openid['tid'],
													':userid'=>$openid['id'],
													':type'=>3,
								));
								if(empty($record['id'])){
									if($openid['tid']){
										$date = array(
											'weid' =>  $_W['uniacid'],
											'schoolid' => $schoolid,
											'noticeid' => $notice_id,
											'tid' => $openid['tid'],
											'userid' => $openid['id'],
											'openid' => $openid['openid'],
											'type' => 3,
											'createtime' => $notice['createtime']
										);
										pdo_insert($this->table_record, $date);
										$record_id = pdo_insertid();
										if(!empty($notice['outurl'])){
											$url = $notice['outurl'];
										}
										if(isallow_sendsms($schoolid,'xxtongzhi')){
											if($mobile){
												mload()->model('sms');
												sms_send($mobile, $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'xxtongzhi', $weid, $schoolid);
											}
										}										
										if(!empty($smsset['xxtongzhi'])){
											$this->sendtempmsg($smsset['xxtongzhi'], $url, $data, '#FF0000', $openid['openid']);
										}
									}
								}
							}
						}
						if ($groupid == 3) {
							$openid = pdo_fetchall("select * from ".tablename($this->table_user)." where sid = '{$value['id']}' ");
							foreach($openid as $o) {
								if($o['pard'] == 2){
									$guanxi = "妈妈";
								}else if($o['pard'] == 3){
									$guanxi = "爸爸";
								}else if($o['pard'] == 4){
									$guanxi = "";
								}else if($o['pard'] == 5){
									$guanxi = "家长";
								}
								$ttime = date('Y-m-d H:i:s', $notice['createtime']);
								$ttimes = date('m月d日 H:i', TIMESTAMP);
								$content = array(
									'name' => "(".$value['s_name'].")".$guanxi,
									'time' => $ttimes,
								);								
								$title = "【{$value['s_name']}】{$guanxi}，您收到一条学校通知";
								$schoolname ="{$school['title']}";
								$name  = "{$tname}老师";
								$body  = "点击本条消息查看详情 ";
								$datas=array(
									'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
									'first'=>array('value'=>$title,'color'=>'#1587CD'),
									'keyword1'=>array('value'=>$schoolname,'color'=>'#1587CD'),
									'keyword2'=>array('value'=>$name,'color'=>'#2D6A90'),
									'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
									'keyword4'=>array('value'=>$notice['title'],'color'=>'#1587CD'),
									'remark'=> array('value'=>$body,'color'=>'#FF9E05')
											);
								$data = json_encode($datas); //发送的消息模板数据
								$record = pdo_fetch("SELECT * FROM ".tablename($this->table_record)." where weid = :weid And schoolid = :schoolid And noticeid = :noticeid And openid = :openid And sid = :sid And userid = :userid And type = :type",array(
													':weid'=>$_W['uniacid'],
													':schoolid'=>$schoolid,
													':noticeid'=>$notice_id,
													':openid'=>$o['openid'],
													':sid'=>$o['sid'],
													':userid'=>$o['id'],
													':type'=>3
								));
								if(empty($record['id'])){
									if($o['sid']){
										$date = array(
											'weid' =>  $_W['uniacid'],
											'schoolid' => $schoolid,
											'noticeid' => $notice_id,
											'sid' => $o['sid'],
											'userid' => $o['id'],
											'openid' => $o['openid'],
											'type' => 3,
											'createtime' => $notice['createtime']
										);
										pdo_insert($this->table_record, $date);
										$record_id = pdo_insertid();
										if(!empty($notice['outurl'])){
											$url = $notice['outurl'];
										}else{
											$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('snotice', array('schoolid' => $schoolid,'record_id' => $record_id,'id' => $notice_id,'userid' => $o['id']));
										}
										if(isallow_sendsms($schoolid,'xxtongzhi')){
											$mobiles = unserialize($o['userinfo']);
											$mobile = $mobiles['mobile'];											
											if($mobile){
												mload()->model('sms');
												sms_send($mobile, $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'xxtongzhi', $weid, $schoolid);
											}
										}
										if(!empty($smsset['xxtongzhi'])){
											$this->sendtempmsg($smsset['xxtongzhi'], $url, $data, '#FF0000', $o['openid']);
										}
									}
								}
							}
						}
					}
			}
		}
	}

	public function sendMobileFxtz($schoolid, $weid, $tname, $bj_id) { //放学群发通知
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'bjtz');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['bjtz'] == 1 || !empty($smsset['bjtz'])) {
			$bname = pdo_fetch("SELECT * FROM ".tablename($this->table_classify)." WHERE :weid = weid AND :schoolid =schoolid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':sid' => $bj_id));
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;

			$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid And bj_id = :bj_id",array(':weid'=>$weid, ':schoolid'=>$schoolid, ':bj_id'=>$bj_id));

			foreach ($userinfo as $key => $value) {

				$openidall = pdo_fetchall("select openid,userinfo,pard from ".tablename($this->table_user)." where sid = '{$value['id']}' ");
				$s_name = $value['s_name'];
				$name  = "班主任-{$tname}";
				$title = "{$s_name}家长，您收到一条学生放学通知";
				$bjname  = "{$bname['sname']}";
				$ttime = date('Y-m-d H:i:s', TIMESTAMP);
				$notice  = "本班已经放学，请家长留意学生放学后动态，确认是否安全回家";
				$body  = "";
				$datas=array(
					'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
					'first'=>array('value'=>$title,'color'=>'#FF9E05'),
					'keyword1'=>array('value'=>$bjname,'color'=>'#1587CD'),
					'keyword2'=>array('value'=>$name,'color'=>'#2D6A90'),
					'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
					'keyword4'=>array('value'=>$notice,'color'=>'#1587CD'),
					'remark'=> array('value'=>$body,'color'=>'#FF9E05')
							);
				$data = json_encode($datas); //发送的消息模板数据
				$url = "";
				$num = count($openidall);
				$ttimes = date('m月d日 H:i', TIMESTAMP);
				$content = array(
					'name' => "(".$s_name.")"."家长",
					'time' => $ttimes,
					'type' => "放学通知",
				);			
				if ($num > 1){
					foreach ($openidall as $key => $values) {
						if($values['pard'] != 4){ //不发送给学生本人
							if(isallow_sendsms($schoolid,'bjtz')){
								$mobiles = unserialize($values['userinfo']);
								$mobile = $mobiles['mobile'];											
								if($mobile){
									mload()->model('sms');
									sms_send($mobile, $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'bjtz', $weid, $schoolid);
								}
							}
							if(!empty($smsset['bjtz'])){
								$openid = $values['openid'];
								$this->sendtempmsg($smsset['bjtz'], $url, $data, '#FF0000', $openid);
							}
						}
					}
				}else{
					if(isallow_sendsms($schoolid,'bjtz')){
						$mobiles = unserialize($openidall['0']['userinfo']);
						$mobile = $mobiles['mobile'];											
						if($mobile){
							mload()->model('sms');
							sms_send($mobile, $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'bjtz', $weid, $schoolid);
						}
					}
					if(!empty($smsset['bjtz'])){
						$openid = $openidall['0']['openid'];
						$this->sendtempmsg($smsset['bjtz'], $url, $data, '#FF0000', $openid);
					}
				}
			}
		}
	}
	
	public function sendMobileFxsc($weid, $schoolid, $tname, $sid, $scid, $setid) { 
		global $_GPC,$_W;
		$school = pdo_fetch("SELECT shoucename FROM ".tablename($this->table_index)." WHERE :id = id", array(':id' => $schoolid));
		$smsset = get_weidset($weid,'bjtz');	
		if(!empty($smsset['bjtz'])) {		
			$student = pdo_fetch("SELECT bj_id,s_name FROM ".tablename($this->table_students)." WHERE :id = id", array(':id' => $sid)); 
			$bname = pdo_fetch("SELECT sname FROM ".tablename($this->table_classify)." WHERE :sid = sid", array(':sid' => $student['bj_id']));
			$userinfo = pdo_fetchall("SELECT id,openid,pard FROM ".tablename($this->table_user)." where weid = :weid And schoolid = :schoolid And sid = :sid",array(':weid'=>$weid, ':schoolid'=>$schoolid, ':sid'=>$sid));
			foreach ($userinfo as $key => $value) {
				$name  = "老师-{$tname}";
				if($value['pard'] == 2){
					$pard ="妈妈";
				}
				if($value['pard'] == 3){
					$pard ="爸爸";
				}
				if($value['pard'] == 4){
					$pard ="";
				}
				if($value['pard'] == 5){
					$pard ="家长";
				}			
				$title = "{$student['s_name']}{$pard}，您收到一条学生{$school['shoucename']}消息";
				$bjname  = "{$bname['sname']}";
				$ttime = date('Y-m-d H:i:s', TIMESTAMP);
				$notice  = "点击本条消息可快速查看";
				$body  = "";
				$datas = array(
					'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
					'first'=>array('value'=>$title,'color'=>'#FF9E05'),
					'keyword1'=>array('value'=>$bjname,'color'=>'#1587CD'),
					'keyword2'=>array('value'=>$name,'color'=>'#2D6A90'),
					'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
					'keyword4'=>array('value'=>$notice,'color'=>'#1587CD'),
					'remark'=> array('value'=>$body,'color'=>'#FF9E05')
							);
				$data = json_encode($datas); //发送的消息模板数据
				$url = $_W['siteroot'] .'app/'.$this->createMobileUrl('scforxs', array('schoolid' => $schoolid,'scid' => $scid,'userid' => $value['id'],'setid' => $setid,'op' => 'check','type' => 'school'));
				$openid = $openidall['0']['openid'];
				$this->sendtempmsg($smsset['bjtz'], $url, $data, '#FF0000', $value['openid']);
			}
		}
	}	

	public function sendMobileXsqj($leave_id, $schoolid, $weid, $tid) { //学生请假通知 发送给老师
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'xsqingjia');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['xsqingjia'] == 1 || !empty($smsset['xsqingjia'])) {
			$leave = pdo_fetch("SELECT * FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leave_id, ':schoolid' => $schoolid));		
			$student = pdo_fetch("SELECT muid,duid,otheruid,s_name,bj_id FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $leave['sid']));
			$teacher = pdo_fetch("SELECT tname,openid,mobile FROM " . tablename($this->table_teachers) . " where id = :id", array(':id' => $tid));
			$guanxi = "本人";
			if($student['muid'] == $leave['uid']){
				$guanxi = "妈妈";
			}else if($student['duid'] == $leave['uid']) {
				$guanxi = "爸爸";
			}else if($student['otheruid'] == $leave['uid']) {
				$guanxi = "家长";
			}
			$shenfen = "{$student['s_name']}{$guanxi}";
			$stime = date('m月d日 H:i',$leave['startime1']);
			$etime = date('m月d日 H:i',$leave['endtime1']);
			$ttime = date('Y-m-d H:i:s', $leave['createtime']);
			$time  = "{$stime}至{$etime}";
			$body .= "消息时间：{$ttime} \n";
			$body .= "点击本条消息快速处理 ";
			$datas=array(
			'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
			'first'=>array('value'=>'您收到了一条'.$shenfen.'的请假申请','color'=>'#1587CD'),
			'childName'=>array('value'=>$student['s_name'],'color'=>'#1587CD'),
			'time'=>array('value'=>$time,'color'=>'#2D6A90'),
			'score'=>array('value'=>$leave['conet'],'color'=>'#1587CD'),
			'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );
			$data=json_encode($datas); //发送的消息模板数据
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('smssage', array('schoolid' => $schoolid,'bj_id' => $student['bj_id']));
			if(isallow_sendsms($schoolid,'xsqingjia')){
				if($teacher['mobile']){
					$ttimes = date('m月d日 H:i', TIMESTAMP);
					$content = array(
						'name' => $student['s_name'].$guanxi,
						'time' => $ttimes,
					);
					mload()->model('sms');
					sms_send($teacher['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'xsqingjia', $weid, $schoolid);
				}
			}
			if (!empty($smsset['xsqingjia'])) {
				$this->sendtempmsg($smsset['xsqingjia'], $url, $data, '#FF0000', $teacher['openid']);
			}
		}
	}

	public function sendMobileXsqjsh($leaveid, $schoolid, $weid, $tname) { //学生请假审核结果 发送给学生
		global $_W;
		$smsset = get_weidset($weid,'xsqjsh');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['xsqjsh'] == 1 || !empty($smsset['xsqjsh'])) {
			$leave = pdo_fetch("SELECT * FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leaveid, ':schoolid' => $schoolid));
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $leave['sid']));
			$jieguo = "";
			if($leave['status'] ==1){
				$jieguo = "同意";
			}else{
				$jieguo = "不同意";
			}
			$stime = date('m月d日 H:i',$leave['startime1']);
			$etime = date('m月d日 H:i',$leave['endtime1']);
			$time = "{$stime}至{$etime}";
			$ctime = date('Y-m-d H:i:s', $leave['cltime']);
			$body .= "处理时间：{$ctime} \n";
			$body .= "{$leave['reconet']}";
			$datas=array(
			'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
			'first'=>array('value'=>'您好，'.$tname.'老师已经回复了您的请假申请','color'=>'#1587CD'),
			'keyword1'=>array('value'=>$student['s_name'],'color'=>'#1587CD'),
			'keyword2'=>array('value'=>$time,'color'=>'#2D6A90'),
			'keyword3'=>array('value'=>$jieguo,'color'=>'#1587CD'),
			'keyword4'=>array('value'=>$tname,'color'=>'#1587CD'),
			'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );
			$data=json_encode($datas); //发送的消息模板数据
			$touser = pdo_fetch("SELECT id,userinfo FROM " . tablename($this->table_user) . " where schoolid = :schoolid AND sid = :sid AND uid = :uid AND openid = :openid", array(':schoolid' => $schoolid, ':sid' => $leave['sid'], ':uid' => $leave['uid'], ':openid' => $leave['openid']));
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('leavelist', array('schoolid' => $schoolid,'userid' => $touser['id']));
			if(isallow_sendsms($schoolid,'xsqjsh')){
				$mobiles = unserialize($touser['userinfo']);
				$mobile = $mobiles['mobile'];
				if($mobile){
					$content = array(
						'name' => $student['s_name'].$guanxi,
						'type' => $jieguo,
					);
					mload()->model('sms');
					sms_send($mobile, $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'xsqjsh', $weid, $schoolid);
				}
			}			
			if (!empty($smsset['xsqjsh'])) {
				$this->sendtempmsg($smsset['xsqjsh'], $url, $data, '#FF0000', $leave['openid']);
			}
		}
	}

	public function sendMobileJzly($leave_id, $schoolid, $weid, $uid, $bj_id, $sid, $tid) { //家长或学生留言 发送给老师
		global $_W;
		$smsset = get_weidset($weid,'liuyan');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['liuyan'] == 1 || !empty($smsset['liuyan'])) {		
			$leave = pdo_fetch("SELECT * FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leave_id, ':schoolid' => $schoolid));
			$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $sid));
			$msgs = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND status=:status", array(':weid' => $weid, ':schoolid' => $schoolid, ':status' => 2));
			$teacher = pdo_fetch("SELECT mobile,tname,openid FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $tid));//查询master
			$guanxi = "本人";
			if($students['muid'] == $uid){
				$guanxi = "妈妈";
			}else if($students['duid'] == $uid) {
				$guanxi = "爸爸";
			}else if($students['otheruid'] == $uid) {
				$guanxi = "家长";
			}
			$time = date('Y-m-d H:i:s', $leave['createtime']);
			$data1 = "{$students['s_name']}{$guanxi}";
			$body .= "留言摘要：{$leave['conet']} \n";
			$body .= "点击本条消息快速回复 ";
			$datas=array(
			'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
			'first'=>array('value'=>'您好，'.$teacher['tname'].'老师,您收到了一条留言信息！','color'=>'#1587CD'),
			'keyword1'=>array('value'=>$data1,'color'=>'#1587CD'),
			'keyword2'=>array('value'=>$time,'color'=>'#2D6A90'),
			'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );
			$data=json_encode($datas); //发送的消息模板数据
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('tjiaoliu', array('schoolid' => $schoolid,'id' => $leave_id,'leaveid' => $leave['leaveid']));
			if(isallow_sendsms($schoolid,'liuyan')){
				if($teacher['mobile']){
					$ttimes = date('m月d日 H:i', TIMESTAMP);
					$content = array(
						'name' => $students['s_name'].$guanxi,
						'time' => $ttimes,
					);	
					mload()->model('sms');					
					sms_send($teacher['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'liuyan', $weid, $schoolid);
				}
			}
			if (!empty($smsset['liuyan'])) {
				$this->sendtempmsg($smsset['liuyan'], $url, $data, '#FF0000', $teacher['openid']);
			}
		}
	}

	public function sendMobileJzlyhf($leave_id, $schoolid, $weid, $topenid, $sid, $tname, $uid) { //班主任回复家长留言 发送给家长或学生
		global $_W;
		$smsset = get_weidset($weid,'liuyanhf');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['liuyanhf'] == 1 || !empty($smsset['liuyanhf'])) {
			$leave = pdo_fetch("SELECT conet,createtime FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leave_id, ':schoolid' => $schoolid));
			$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $sid));
			$msgs = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND status=:status", array(':weid' => $weid, ':schoolid' => $schoolid, ':status' => 2));
			$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $tid));//查询master
			$guanxi = "";
			if($students['muid'] == $uid){
				$guanxi = "妈妈";
			}else if($students['duid'] == $uid) {
				$guanxi = "爸爸";
			}else if($students['otheruid'] == $uid) {
				$guanxi = "家长";
			}
			$time = date('Y-m-d H:i:s', $leave['createtime']);
			$data1 = "{$students['s_name']}{$guanxi},您收到了一条老师的留言回复信息！";
			$body = "点击本条消息快速回复 ";
			$datas=array(
			'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
			'first'=>array('value'=>$data1,'color'=>'#1587CD'),
			'keyword1'=>array('value'=>$tname,'color'=>'#1587CD'),
			'keyword2'=>array('value'=>$time,'color'=>'#2D6A90'),
			'keyword3'=>array('value'=>$leave['conet'],'color'=>'#2D6A90'),
			'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );
			$data=json_encode($datas); //发送的消息模板数据
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('jiaoliu', array('schoolid' => $schoolid));
			if(isallow_sendsms($schoolid,'liuyanhf')){
				$touser = pdo_fetch("SELECT userinfo FROM " . tablename($this->table_user) . " where schoolid = :schoolid AND sid = :sid AND uid = :uid AND openid = :openid", array(':schoolid' => $schoolid, ':sid' => $sid, ':uid' => $uid, ':openid' => $topenid));
				$mobiles = unserialize($touser['userinfo']);
				$mobile = $mobiles['mobile'];
				if($mobile){
					$ttimes = date('m月d日 H:i', TIMESTAMP);
					$content = array(
						'name' => $students['s_name'].$guanxi,
						'time' => $ttimes,
					);
					mload()->model('sms');
					sms_send($mobile, $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'liuyanhf', $weid, $schoolid);
				}
			}
			if (!empty($smsset['liuyanhf'])) {
				$this->sendtempmsg($smsset['liuyanhf'], $url, $data, '#FF0000', $topenid);
			}
		}
	}
	
	public function sendMobileLyhf($leave_id, $schoolid, $weid) { //通讯录私聊
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'liuyan');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['liuyan'] == 1 || !empty($smsset['liuyan'])) {
			$leave = pdo_fetch("SELECT userid,touserid,conet,createtime,leaveid FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leave_id, ':schoolid' => $schoolid));
			$user = pdo_fetch("SELECT pard,sid,tid,userinfo FROM " . tablename($this->table_user) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $leave['userid']));
			$touser = pdo_fetch("SELECT id,pard,sid,tid,userinfo,openid FROM " . tablename($this->table_user) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $leave['touserid']));
			$students1 = pdo_fetch("SELECT s_name FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $user['sid']));
			$students2 = pdo_fetch("SELECT s_name FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $touser['sid']));
			$teacher1 = pdo_fetch("SELECT tname FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $user['tid']));
			$teacher2 = pdo_fetch("SELECT tname,mobile FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $touser['tid']));
			mload()->model('user');
			if($user['sid']){
				$gx1 = check_gx($user['pard']);
			}
			if($touser['sid']){
				$gx2 = check_gx($touser['pard']);
			}		
			$tname = empty($user['sid']) ? $teacher1['tname']."老师" : $students1['s_name']."$gx1";//发送
			$tname1 = empty($touser['sid']) ? $teacher2['tname']."老师" : $students2['s_name']."$gx2";//接收
			$time = date('Y-m-d H:i:s', $leave['createtime']);
			$data1 = "{$tname1},您收到了一条留言！";
			$body = "点击本条消息快速回复 ";
			$datas=array(
				'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
				'first'=>array('value'=>$data1,'color'=>'#1587CD'),
				'keyword1'=>array('value'=>$tname,'color'=>'#1587CD'),
				'keyword2'=>array('value'=>$time,'color'=>'#2D6A90'),
				'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );		 
			$data=json_encode($datas); //发送的消息模板数据
			if($touser['sid']){
				$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('sduihua', array('schoolid' => $schoolid,'id' =>$leave['leaveid'],'userid' =>$touser['id']));
			}else{
				$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('tduihua', array('schoolid' => $schoolid,'id' =>$leave['leaveid'],'userid' =>$touser['id']));
			}
			if(isallow_sendsms($schoolid,'liuyan')){
				$mobiles = unserialize($touser['userinfo']);
				$mobile = empty($touser['sid']) ? $teacher2['mobile'] : $mobiles['mobile'];
				if($mobile){
					$ttimes = date('m月d日 H:i', TIMESTAMP);
					$content = array(
						'name' => $tname,
						'time' => $ttimes,
					);
					mload()->model('sms');
					sms_send($mobile, $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'lyhf', $weid, $schoolid);
				}
			}			
			if (!empty($smsset['liuyan'])) {
				$this->sendtempmsg($smsset['liuyan'], $url, $data, '#FF0000', $touser['openid']);
			}
		}
	}	

	public function sendMobileJsqj($leave_id, $schoolid, $weid, $openid) { //教师请假 发送给校长或主任
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'jsqingjia');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['jsqingjia'] == 1 || !empty($smsset['jsqingjia'])) {		
			$leave = pdo_fetch("SELECT startime1,endtime1,type,conet FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leave_id, ':schoolid' => $schoolid));
			$teacher = pdo_fetch("SELECT tname,mobile FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $leave['tid']));
			$stime = date('Y-m-d H:i', $leave['startime1']);
			$etime = date('Y-m-d H:i', $leave['endtime1']);
			$time = "{$stime}至{$etime}";
			$body = "点击本条消息快速处理 ";
			$datas=array(
				'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
				'first'=>array('value'=>'您收到了一条教师请假申请','color'=>'#1587CD'),
				'keyword1'=>array('value'=>$teacher['tname'],'color'=>'#1587CD'),
				'keyword2'=>array('value'=>$leave['type'],'color'=>'#2D6A90'),
				'keyword3'=>array('value'=>$time,'color'=>'#1587CD'),
				'keyword4'=>array('value'=>$leave['conet'],'color'=>'#173177'),
				'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );
			$data=json_encode($datas); //发送的消息模板数据
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('tmcomet', array('schoolid' => $schoolid,'id' => $leave_id));
			if(isallow_sendsms($schoolid,'jsqingjia')){
				if($teacher['mobile']){
					$ttimes = date('m月d日 H:i', TIMESTAMP);
					$content = array(
						'name' => $teacher['tname'],
						'time' => $ttimes,
					);
					mload()->model('sms');
					sms_send($teacher['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'jsqingjia', $weid, $schoolid);
				}
			}
			if (!empty($smsset['jsqingjia'])) {
				$this->sendtempmsg($smsset['jsqingjia'], $url, $data, '#FF0000', $openid);
			}
		}
	}

	public function sendMobileJsqjsh($leaveid, $schoolid, $weid, $shname) { //教师审核结果 发送给请假教师
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'jsqjsh');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['jsqjsh'] == 1 || !empty($smsset['jsqjsh'])) {
			$leave = pdo_fetch("SELECT cltime,tid FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leaveid, ':schoolid' => $schoolid));
			$teacher = pdo_fetch("SELECT tname,mobile FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $leave['tid']));
			$jieguo = "";
			if($leave['status'] ==1){
				$jieguo = "同意";
			}else{
				$jieguo = "不同意";
			}
			$time = date('Y-m-d H:i', $leave['cltime']);
			$body = "点击本条消息查看详情 ";
			$datas=array(
			'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
			'first'=>array('value'=>'请假审批结果通知','color'=>'#1587CD'),
			'keyword1'=>array('value'=>$jieguo,'color'=>'#1587CD'),
			'keyword2'=>array('value'=>$shname,'color'=>'#2D6A90'),
			'keyword3'=>array('value'=>$time,'color'=>'#1587CD'),
			'remark'=> array('value'=>$body,'color'=>'#FF9E05')
			 );
			$data=json_encode($datas); //发送的消息模板数据
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('leavelistforteacher', array('schoolid' => $schoolid,'id' => $leaveid));
			if(isallow_sendsms($schoolid,'jsqjsh')){
				if($teacher['mobile']){
					$content = array(
						'name' => $teacher['tname'],
						'type' => $jieguo,
					);
					mload()->model('sms');
					sms_send($teacher['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'jsqjsh', $weid, $schoolid);
				}
			}
			if (!empty($smsset['jsqjsh'])) {
				$this->sendtempmsg($smsset['jsqjsh'], $url, $data, '#FF0000', $leave['openid']);
			}
		}
	}

	public function sendMobileJxlxtz($schoolid, $weid, $bj_id, $sid, $type, $leixing, $id, $pard) { //学生进校离校通知
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'jxlxtx');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['jxlxtx'] == 1 || !empty($smsset['jxlxtx'])) {
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id = :id ", array(':id' => $sid));
			$log = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " where id = :id ", array(':id' => $id));
			$userinfo = pdo_fetchall("SELECT id,pard,userinfo FROM ".tablename($this->table_user)." where weid = :weid And schoolid = :schoolid And sid = :sid",array(':weid'=>$weid, ':schoolid'=>$schoolid, ':sid'=>$sid));

			foreach ($userinfo as $key => $value) {

				$openid = pdo_fetch("select id,openid from ".tablename($this->table_user)." where id = '{$value['id']}' ");
				$s_name = $student['s_name'];
				include 'pard.php';
				$guanxi = "";
				if($leixing == 1){
					$lx = "进校";
					if($pard >1){
						$body  = "您的孩子已由【{$jsr}】安全送到,点击详情查看更多";
					}else{
						$body  = "打卡成功,点击详情查看";
					}
				}else{
					$lx = "离校";
					if($pard >1){
						$body  = "您的孩子已由【{$jsr}】安全接到,点击详情查看更多";
					}else{
						$body  = "打卡成功,点击详情查看";
					}
				}
				if($value['pard'] == 2){
					$guanxi = "妈妈";
				}else if($value['pard'] == 3) {
					$guanxi = "爸爸";
				}else if($value['pard'] == 5) {
					$guanxi = "家长";
				}
				if($openid['pard'] == 4){			
					$title = "【{$s_name}】,您收到一条学生{$lx}通知";
				}else{
					$title = "【{$s_name}】{$guanxi},您收到一条学生{$lx}通知";
				}
				$ttime = date('Y-m-d H:i:s', $log['createtime']);
				$time = date('Y-m-d', $log['createtime']);
				$datas=array(
					'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
					'first'=>array('value'=>$title,'color'=>'#FF9E05'),
					'childName'=>array('value'=>$s_name,'color'=>'#1587CD'),
					'time'=>array('value'=>$ttime,'color'=>'#2D6A90'),
					'status'=>array('value'=>$type,'color'=>'#1587CD'),
					'remark'=> array('value'=>$body,'color'=>'#FF9E05')
							);
				$data = json_encode($datas); //发送的消息模板数据
				$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('calendar', array('schoolid' => $schoolid,'userid' => $openid['id'],'time' => $time,'logid' => $id));
				if(isallow_sendsms($schoolid,'jxlxtx')){
					$mobile = unserialize($value['userinfo']);
					if($mobile['mobile']){
						$ttimes = date('m月d日 H:i', TIMESTAMP);
						$content = array(
							'name' => $s_name,
							'time' => $ttimes,
							'type' => $lx,
						);
						mload()->model('sms');
						sms_send($mobile['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'jxlxtx', $weid, $schoolid);
					}
				}
				if(!empty($smsset['jxlxtx'])){
					$this->sendtempmsg($smsset['jxlxtx'], $url, $data, '#FF0000', $openid['openid']);
				}
			}
		}
	}

	public function sendMobileFzqdtx($schoolid, $weid, $bj_id, $sid, $type, $leixing, $id, $pard) { //教师代签到或签离提醒 发送给学生
		global $_GPC,$_W;
		$smsset = get_weidset($weid,'jxlxtx');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['jxlxtx'] == 1 || !empty($smsset['jxlxtx'])) {
			$student = pdo_fetch("SELECT s_name FROM " . tablename($this->table_students) . " where id = :id ", array(':id' => $sid));
			$log = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " where id = :id ", array(':id' => $id));
			$openidall = pdo_fetchall("select sid,id,openid,pard,userinfo from ".tablename($this->table_user)." where sid = :sid ", array(':sid' => $log['sid']));
			$num = count($openidall);
			if ($num > 1){
				foreach ($openidall as $key => $values) {
					if($values['sid']){
						include 'pard.php';
						$guanxi = "";
						if($leixing == 1){
							$lx = "进校";
						}else{
							$lx = "离校";
						}
						$body  = "学生已由老师代签考勤,点击详情查看更多";
						if($values['pard'] == 2){
							$guanxi = "妈妈";
						}else if($values['pard'] == 3) {
							$guanxi = "爸爸";
						}else if($values['pard'] == 5) {
							$guanxi = "家长";
						}
						if($values['pard'] == 4){			
							$title = "【{$student['s_name']}】,您收到一条学生{$lx}通知";
						}else{
							$title = "【{$student['s_name']}】{$guanxi},您收到一条学生{$lx}通知";
						}
						$ttime = date('Y-m-d H:i:s', $log['createtime']);
						$time = date('Y-m-d', $log['createtime']);
						$datas=array(
							'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
							'first'=>array('value'=>$title,'color'=>'#FF9E05'),
							'childName'=>array('value'=>$student['s_name'],'color'=>'#1587CD'),
							'time'=>array('value'=>$ttime,'color'=>'#2D6A90'),
							'status'=>array('value'=>$type,'color'=>'#1587CD'),
							'remark'=> array('value'=>$body,'color'=>'#FF9E05')
									);
						$data = json_encode($datas); //发送的消息模板数据
						$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('calendar', array('schoolid' => $schoolid,'userid' => $values['id'],'time' => $time));
						if(isallow_sendsms($schoolid,'jxlxtx')){
							$mobile = unserialize($values['userinfo']);
							if($mobile['mobile']){
								$ttimes = date('m月d日 H:i', TIMESTAMP);
								$content = array(
									'name' => $student['s_name'],
									'time' => $ttimes,
									'type' => $lx,
								);
								mload()->model('sms');
								sms_send($mobile['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'jxlxtx', $weid, $schoolid);
							}
						}
						if(!empty($smsset['jxlxtx'])){
							$this->sendtempmsg($smsset['jxlxtx'], $url, $data, '#FF0000', $values['openid']);		
						}
					}
				}
			}else{
				if($openidall['0']['sid']){
					include 'pard.php';
					$guanxi = "";
					if($leixing == 1){
						$lx = "进校";
					}else{
						$lx = "离校";
					}
					$body  = "学生已由老师代签考勤,点击详情查看更多";
					if($openidall['0']['pard'] == 2){
						$guanxi = "妈妈";
					}else if($openidall['0']['pard'] == 3) {
						$guanxi = "爸爸";
					}else if($openidall['0']['pard'] == 5) {
						$guanxi = "家长";
					}
					if($openidall['0']['pard'] == 4){			
						$title = "【{$student['s_name']}】,您收到一条学生{$lx}通知";
					}else{
						$title = "【{$student['s_name']}】{$guanxi},您收到一条学生{$lx}通知";
					}
					$ttime = date('Y-m-d H:i:s', $log['createtime']);
					$time = date('Y-m-d', $log['createtime']);
					$datas=array(
						'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
						'first'=>array('value'=>$title,'color'=>'#FF9E05'),
						'childName'=>array('value'=>$student['s_name'],'color'=>'#1587CD'),
						'time'=>array('value'=>$ttime,'color'=>'#2D6A90'),
						'status'=>array('value'=>$type,'color'=>'#1587CD'),
						'remark'=> array('value'=>$body,'color'=>'#FF9E05')
								);
					$data = json_encode($datas); //发送的消息模板数据
					$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('calendar', array('schoolid' => $schoolid,'userid' => $openidall['0']['id'],'time' => $time));
					if(isallow_sendsms($schoolid,'jxlxtx')){
						$mobile = unserialize($openidall['0']['userinfo']);
						if($mobile['mobile']){
							$ttimes = date('m月d日 H:i', TIMESTAMP);
							$content = array(
								'name' => $student['s_name'],
								'time' => $ttimes,
								'type' => $lx,
							);
							mload()->model('sms');
							sms_send($mobile['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'jxlxtx', $weid, $schoolid);
						}
					}
					if(!empty($smsset['jxlxtx'])){
						$this->sendtempmsg($smsset['jxlxtx'], $url, $data, '#FF0000', $openidall['0']['openid']);	
					}
				}
			}
		}
	}
	
	public function sendMobileJfjgtz($orderid) { //缴费结果通知
		global $_W;
		$order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where id = :id ", array(':id' => $orderid));
		$weid = $order['weid'];
		$schoolid = $order['schoolid'];		
		$smsset = get_weidset($weid,'jfjgtz');	
		$sms_set = get_school_sms_set($schoolid);
		if($sms_set['jfjgtz'] == 1 || !empty($smsset['jfjgtz'])) {
			$student = pdo_fetch("SELECT s_name FROM " . tablename($this->table_students) . " where id = :id ", array(':id' => $order['sid']));
			$userinfo = pdo_fetchall("SELECT id,pard,openid,userinfo FROM ".tablename($this->table_user)." where schoolid = :schoolid And sid = :sid",array(':schoolid'=>$order['schoolid'], ':sid'=>$order['sid']));
			foreach ($userinfo as $key => $value) {
				$openid = pdo_fetch("select openid from ".tablename($this->table_user)." where id = '{$value['id']}' ");
				$s_name = $student['s_name'];
				$pard = $value['pard'];
				if($pard == 2){
					$jsr  = "妈妈";
				}
				if($pard == 3){
					$jsr  = "爸爸";
				}
				if($pard == 4){
					$jsr  = "";
				}
				if($pard == 5){
					$jsr  = "家长";
				}			
				$title = "【{$s_name}】{$jsr},您收到一条缴费结果通知";
				$time = date('Y-m-d H:i:s', $order['paytime']);
				if($order['type'] ==1){
					$kc = pdo_fetch("SELECT name FROM ".tablename($this->table_tcourse)." WHERE id = '{$order['kcid']}'");//课程
					$ob = "【{$kc['name']}】";
				}else if ($order['type'] ==3){
					$ct = pdo_fetch("SELECT * FROM ".tablename($this->table_cost)." WHERE id = '{$order['costid']}'");//项目
					$ob = "【{$ct['name']}】";
				}else if ($order['type'] ==4){
					$ob = "【报名费】";
				}else if ($order['type'] ==5){	
					$ob = "【考勤卡费】";
				}
				if($order['status'] ==1){
					$ty = "【未支付】";
				}else if ($order['status'] ==2){
					$ty = "【已支付】";
				}
				$body  = "订单号【{$orderid}】,点击详情查看";
				$datas=array(
					'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
					'first'=>array('value'=>$title,'color'=>'#FF9E05'),
					'keyword1'=>array('value'=>$s_name,'color'=>'#1587CD'),
					'keyword2'=>array('value'=>$time,'color'=>'#2D6A90'),
					'keyword3'=>array('value'=>$ob,'color'=>'#1587CD'),
					'keyword4'=> array('value'=>$ty,'color'=>'#FF9E05'),
					'remark'=> array('value'=>$body,'color'=>'#FF9E05')
				);		
				$data = json_encode($datas); //发送的消息模板数据
				$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('user', array('schoolid' => $order['schoolid'],'userid' => $value['id'], 'op' => 'all_g'));
				if(isallow_sendsms($schoolid,'jfjgtz')){
					$mobile = unserialize($value['userinfo']);
					if($mobile['mobile']){
						$ttimes = date('m月d日 H:i', TIMESTAMP);
						$content = array(
							'name' => $student['s_name'],
							'time' => $ttimes,
							'type' => $lx,
						);
						mload()->model('sms');
						sms_send($mobile['mobile'], $content, $smsset['sms_SignName'], $smsset['sms_Code'], 'jfjgtz', $weid, $schoolid);
					}
				}				
				if(!empty($smsset['jfjgtz'])){
					$this->sendtempmsg($smsset['jfjgtz'], $url, $data, '#FF0000', $openid['openid']);
				}	
			}
		}
	}	
}