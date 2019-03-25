<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
defined ( 'IN_IA' ) or exit ( 'Access Denied' );
define('OSSURL', 'http://weimeizhan.oss-cn-shenzhen.aliyuncs.com/');
require  'inc/func/core.php';
class Fk_csModuleSite extends Core {

	// 载入逻辑方法
	private function getLogic($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		if ($type == 'web') {
			checkLogin ();
			include_once 'inc/web/' . strtolower ( substr ( $_name, 5 ) ) . '.php';
		} else if ($type == 'mobile') {
			 if ($auth) {
				  include_once 'inc/func/isauth.php';
			  }
			include_once 'inc/mobile/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		} else if ($type == 'func') {
			//checkAuth ();
			include_once 'inc/func/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		}
	}

	private function getLogicmc($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		if ($type == 'mobile') {
			 if ($auth) {
				  include_once 'inc/func/isauth.php';
			  }
			session_start();  
			include_once 'inc/mobile/common/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
			include_once $this->template('loading');
		}
	}

	private function getLogicms($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		if ($type == 'mobile') {
			 if ($auth) {
				  include_once 'inc/func/isauth.php';
			  }
			session_start();
			include_once 'inc/mobile/student/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		}
	}

	private function getLogicmt($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		if ($type == 'mobile') {
			 if ($auth) {
				  include_once 'inc/func/isauth.php';
			  }
			include_once 'inc/mobile/teacher/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		}
	}

	private function getLogicmb($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		if ($type == 'mobile') {
			if ($auth) {
				include_once 'inc/func/isauth.php';
			}
			include_once 'inc/mobile/book/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		}
	}

	private function getLogicheck($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		if ($type == 'mobile') {
			include_once 'inc/mobile/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		}
	}
	
	public function doMobileCheckjl() {
		global $_GPC, $_W;		  
		include_once 'inc/mobile/checkjl.php';
	}
	
	public function doMobileCheckxz() {
		global $_GPC, $_W;
		include_once 'inc/mobile/checkxz.php';
	}

	public function doMobileCheckym() {
		global $_GPC, $_W;
		include_once 'inc/mobile/checkym.php';
	}

	public function doMobileCash() {
		global $_GPC, $_W;
		include_once 'inc/func/cash.php';
	}
	// ====================== Web =====================

	// 学校管理
	public function doWebSchool() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebIndexajax() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
    public function doWebUpgrade() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

    public function doWebFenzu() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

    public function doWebManager() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }
	
	// 分类管理
	public function doWebSchoolset() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	// 分类管理
	public function doWebSemester() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 教师管理
	public function doWebAssess() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 学生管理
	public function doWebStudents() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 成绩查询
	public function doWebChengji() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

    // 课程安排
	public function doWebKecheng() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 课表安排
	public function doWebKcbiao() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

    // 公立课表
    public function doWebTimetable () {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

	// 课程预约
	public function doWebSubscribe() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 食谱安排
	public function doWebCookBook() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 首页导航
	public function doWebNave() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//班级管理
	public function doWebTheclass() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	//成绩管理
	public function doWebScore() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	//课程类别管理
	public function doWebCourseClassification() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//科目管理
	public function doWebSubject() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

    //时段管理
	public function doWebTimeframe() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//星期管理
	public function doWebWeek() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//区域中心管理
	public function doWebDistrictCenter() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//客服管理管理
	public function doWebCustomerService() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//导航管理
	public function doWebNavBar(){
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	//班级大小管理
	public function doWebClassSize() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
    //排课设置
    public function doWebCourseSort () {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

	public function doWebArea() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebType() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebBanner() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebBanners() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

    public function doWebQuery() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

    public function doWebBasic() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

    public function doWebCook() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }
    //forSUTELIST
    public function doWebBaoming() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

    public function doWebArticle() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

    public function doWebNews() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

    public function doWebWenzhang() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

	public function doWebBannerList() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

    public function doWebBjquan() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

	public function doWebCost() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebPayall() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebPhotos() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebNotice() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebSignup() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebCheck() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebChecklog() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebCardlist() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebFlowlist() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebstart() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebComad() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebComload() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebBook() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebBook_lb() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebBook_age() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebBook_distance() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebBook_margin() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebBook_min() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebBook_max() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebBook_jy() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebBook_cz() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// ====================== FUNC =====================
	public function doMobileAuth() {
		$this->getLogic ( __FUNCTION__, 'func' );
	}
    // ====================== Mobile=====================
 	// 公共部分
	public function doMobileIndexajax() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}

	public function doMobileBjqajax() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}

    public function doMobileDongtaiajax() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}

	public function doMobileWapindex() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

	public function doMobilePayajax() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBdajax() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBangding() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileXsqj() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

	// ====================== Mobile Common=====================

    public function doMobileCooklist() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileCook() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileDetail() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileJianjie() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileKc() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileKcList() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
    public function doMobileKcinfo() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileKcdg() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileZhaosheng() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileNewslist() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileNew() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTeachers() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTcinfo() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSignup() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSignupjc() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSignuplist() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

	// ====================== Mobile Student=====================

	public function doMobileGopay() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTimetable() {
        $this->getLogicms ( __FUNCTION__, 'mobile', true );
    }

	public function doMobileVideo() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileSxcfb() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileChaxun() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileChengji() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileUser() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMyinfo() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileJiaoliu() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMytecher() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMyclass() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileMykclist() {
		$this->getLogicmt( __FUNCTION__, 'mobile', true );
	}

	public function doMobileMykcinfot() {
		$this->getLogicmt( __FUNCTION__, 'mobile', true );
	}

	public function doMobileMykcdetailt() {
		$this->getLogicmt( __FUNCTION__, 'mobile', true );
	}

	public function doMobileNewchecklog() {
		$this->getLogicmt( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSnoticelist() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSnotice() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSzuoye() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSzuoyelist() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSbjqfabu() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSbjq() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileOrder() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMykcinfo() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMykcdetial() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileObinfo() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

	public function doMobilePayorder() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSxc() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSxclist() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileCheckcard() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileChecklog() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileCallbook() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileAddchild() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	// ====================== Mobile Teacher =====================
	//for master
    public function doMobileTmssage() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTmcomet() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSmssage() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSmcomet() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMnotice() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMnoticelist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMfabu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileQingjia() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileZfabu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBjqfabu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMyschool() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBjq() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileZuoye() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileZuoyelist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileFabu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileNoticelist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileNotice() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTjiaoliulist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTjiaoliu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileXclist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileXc() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileXcfb() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBmlist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileBm() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileTchecklog() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileJschecklog() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileUpdateinfo() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileApplycourse() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileAddkb() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileTorder() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

	// ====================== Mobile Book =====================
	public function doMobileBookmap() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileMybook() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileBookorder() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileBooklog() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileBookcenter() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileMybookorder() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileMyonsalebook() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileMyunsalebook() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileAddbook() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileTransferbook() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileBookscore() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileOrderbooklist() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileBookcart() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileBookpay() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileBookcharge() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileScorelist() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileCommentlist() {
		$this->getLogicmb ( __FUNCTION__, 'mobile', true );
	}


	public function doMobileFabus()
	{
		global $_W,$_GPC;
		//require 'inc/mobile/fabu.inc.php';
		define("ASSETS_PATH",MODULE_URL.'public/assets/');
		$ids = $_GPC['media_ids'];

		$info = $_GPC['info'];
		$bookid = $_GPC['bookid'];
		$schoolid = $_GPC['schoolid'];
//		$site = pdo_fetch("SELECT isread FROM ".tablename("liuyan_website")." WHERE acid = ".$_W['uniacid']);
//		$status = $site['isread'];

//		if($ids != "" && $info != "")
//		{
//			$filelist = array();
//			$check_ids = explode(",",$ids );
//			if(count($check_ids) != 0)
//			{
//				$filelist = $this->downloadFromWxServer($ids, $this->settings);
//			}
//
//			$data = array(
//				'user' => $_W['fans']['nickname'],
//				'uid' => $_W['fans']['uid'],
//				'info' => $_GPC['info'],
//				'img' => serialize($filelist),
//				'time' => date("Y-m-d H:i:s"),
//				'status' => $status,
//				'acid' => $_W['uniacid'],
//			);
//
//
//
//			if(pdo_insert("liuyan_liuyan",$data))
//			{
//				echo json_encode(1);
//			}
//			else
//			{
//				echo json_encode(0);
//			}
//
//		}

		include $this->template("book/fabu");


	}

	public function doMobileShow()
	{
		global $_W,$_GPC;
		$lid = intval($_GPC['lid']);
		$uid = intval($_GPC['uid']);
		define("ASSETS_PATH",MODULE_URL.'public/assets/');
		$sql = "SELECT * FROM ".tablename("liuyan_liuyan")." LEFT JOIN ".tablename("liuyan_user")." ON ".tablename("liuyan_liuyan").".uid = ".tablename("liuyan_user").".uid WHERE ".tablename("liuyan_liuyan").".uid = ".$uid." AND ".tablename("liuyan_liuyan").".id =".$lid;
		$linfo = pdo_fetch($sql);


		$linfo['img'] = unserialize($linfo['img']);

		unset($sql);

		$sql = "SELECT * FROM ".tablename("liuyan_huifu")." WHERE uid = ".$uid." AND lid = ".$lid;

		$hres = pdo_fetchall($sql);



		$site = pdo_fetch("SELECT * FROM ".tablename("liuyan_website")." WHERE acid = ".$_W['uniacid']);



		include $this->template('book/show');
	}

	public function set_tabbar1($action, $schoolid)  {
    	global $_W;
    	$school = pdo_fetch("SELECT * FROM ".tablename($this->table_index)." WHERE :id = id", array(':id' => $schoolid));
		if ($school['is_cost'] == 2){
			if ($_W['isfounder']){
				$actions_titles1 = $this->actions_titles1;
			}else{
				$actions_titles1 = $this->actions_titles5;
			}
		}else {
			$actions_titles1 = $this->actions_titles1;
		}
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles1 as $key => $value) {
            $url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public $actions_titles1 = array(
	    'semester' => '分类管理',
        'assess' => '教师管理',
        'students' => '学生管理',
        'chengji' => '成绩查询',
        'kecheng' => '课程管理',
		'kcbiao' => '课表管理',
		'notice' => '作业通知请假',
		'signup' => '报名管理',
		'article' => '文章系统',
		'bjquan' => '班级圈',
		'photos' => '相册',
		'cost' => '缴费管理',
		'cook' => '食谱管理',
		'banner' => '幻灯片',
    );

    public $actions_titles5 = array(
	    'semester' => '分类管理',
        'assess' => '教师管理',
        'students' => '学生管理',
        'chengji' => '成绩查询',
        'kecheng' => '课程管理',
		'kcbiao' => '课表管理',
		'notice' => '作业通知请假',
		'signup' => '报名管理',
		'article' => '文章系统',
		'bjquan' => '班级圈',
		'photos' => '相册',
		'cook' => '食谱管理',
		'banner' => '幻灯片',
    );

    public function set_tabbar($action, $schoolid) {

        $actions_titles = $this->actions_titles;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles as $key => $value) {
            $url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public $actions_titles = array(
//	    'semester' => '年级管理',
//        'theclass' => '班级管理',
		'classSize' => '班级大小管理',
		'score' => '成绩管理',
		'navBar' => '导航管理',
		'courseClassification' => '类别管理',
        'subject' => '科目管理',
        'timeframe' => '时段管理',
        'week' => '星期管理',
		'districtCenter' => '区域中心管理',
		'customerService' => '客服管理',
    );

    public function set_tabbar2($action, $schoolid) {
        $actions_titles2 = $this->actions_titles2;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles2 as $key => $value) {
            $url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public $actions_titles2 = array(
	    'article' => '闲书指南',
        'news' => '闲书简介',
        'wenzhang' => '闲书规则',
		'bannerList' => '促销位管理',
    );

	public $actions_titles6 = array(
	    'book_lb'       => '闲书类别管理',
        'book_age'      => '适合年龄管理',
		'book_distance' => '距离管理',
	);

	public $actions_titles7 = array(
		'book_margin' => '保证金管理',
		'book_min'    => '上架下限管理',
		'book_max'    => '余额上限管理',
		'book_jy'     => '集赞管理',
		'book_cz'     => '押金管理',
	);

	public function set_tabbar6($action, $schoolid) {
		$actions_titles2 = $this->actions_titles6;
		$html = '<ul class="nav nav-tabs">';
		foreach ($actions_titles2 as $key => $value) {
			$url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
			$html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
		}
		$html .= '</ul>';
		return $html;
	}

	public function set_tabbar7($action, $schoolid) {
		$actions_titles2 = $this->actions_titles7;
		$html = '<ul class="nav nav-tabs">';
		foreach ($actions_titles2 as $key => $value) {
			$url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
			$html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
		}
		$html .= '</ul>';
		return $html;
	}

    public function showMessageAjax($msg, $code = 0){
        $result['code'] = $code;
        $result['msg'] = $msg;
        message($result, '', 'ajax');
    }

    protected function exportexcel($data = array(), $title = array(), $filename = 'report') {
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)) {
            foreach ($title as $k => $v) {
                $title[$k] = iconv("UTF-8", "GB2312", $v);
            }
            $title = implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck] = iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key] = implode("\t", $data[$key]);

            }
            echo implode("\n", $data);
        }
    }

    function uploadFile($file, $filetempname, $array) {
        //自己设置的上传文件存放路径
        $filePath = '../addons/fk_cs/public/upload/';

        include 'inc/func/phpexcelreader/reader.php';

        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('utf-8');

        //设置时区
        $time = date("y-m-d-H-i-s"); //去当前上传的时间
        $extend = strrchr($file, '.');
        //上传后的文件名
        $name = $time . $extend;
        $uploadfile = $filePath . $name; //上传后的文件名地址

        if (copy($filetempname, $uploadfile)) {
            if (!file_exists($filePath)) {
                echo '文件路径不存在.';
                return;
            }
            if (!is_readable($uploadfile)) {
                echo ("文件为只读,请修改文件相关权限.");
                return;
            }
            $data->read($uploadfile);
            error_reporting(E_ALL ^ E_NOTICE);
            $count = 0;
            for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { //$=2 第二行开始
                //以下注释的for循环打印excel表数据
                for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
                    //echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
                }

                $row = $data->sheets[0]['cells'][$i];
                //message($data->sheets[0]['cells'][$i][1]);

                if ($array['ac'] == "assess") {
                    $count = $count + $this->upload_assess($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "students") {
                    $count = $count + $this->upload_students($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "chengji") {
                    $count = $count + $this->upload_chengji($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "kecheng") {
                    $count = $count + $this->upload_kecheng($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "kcbiao") {
                    $count = $count + $this->upload_kcbiao($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "cardlist") {
                    $count = $count + $this->upload_cardlist($row, TIMESTAMP, $array);					
                }
            }
        }
		$msg = 1;
        if ($count == 0) {
            $msg = "表格设置错误请检查！";
        }
        return $msg;
    }

    function upload_assess($strs, $time, $array) {
        global $_W;
        $insert = array();
		$arr = explode('.',$_SERVER ['HTTP_HOST']);
		//绑定码
		$randStr = str_shuffle('1234567890');
        $rand = substr($randStr,0,6);
		//年级处理
		$xueqi1 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[10]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		$xueqi2 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[11]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		$xueqi3 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[12]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji1 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[13]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		$banji2 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[14]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		$banji3 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[15]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//科目处理
		$kemu1 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[16]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $kemu2 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[17]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		$kemu3 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[18]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		$insert['weid'] = $_W['uniacid'];
        $insert['tname'] = trim($strs[1]);
        $insert['birthdate'] = strtotime(trim($strs[2]));
        $insert['tel'] = trim($strs[3]);
        $insert['mobile'] = trim($strs[4]);
        $insert['email'] = trim($strs[5]);
        $insert['jiontime'] = strtotime(trim($strs[6]));
        $insert['headinfo'] = trim($strs[7]);
        $insert['info'] = trim($strs[8]);
        $insert['sex'] = trim($strs[9]);
        $insert['xq_id1'] = empty($xueqi1) ? 0 : intval($xueqi1['sid']);
        $insert['xq_id2'] = empty($xueqi2) ? 0 : intval($xueqi2['sid']);
        $insert['xq_id3'] = empty($xueqi3) ? 0 : intval($xueqi3['sid']);
        $insert['bj_id1'] = empty($banji1) ? 0 : intval($banji1['sid']);
        $insert['bj_id2'] = empty($banji2) ? 0 : intval($banji2['sid']);
        $insert['bj_id3'] = empty($banji3) ? 0 : intval($banji3['sid']);
        $insert['km_id1'] = empty($kemu1) ? 0 : intval($kemu1['sid']);
        $insert['km_id2'] = empty($kemu2) ? 0 : intval($kemu2['sid']);
		$insert['km_id3'] = empty($kemu2) ? 0 : intval($kemu3['sid']);
		$insert['schoolid'] = $array['schoolid'];
        $insert['status'] = 1;
        $insert['sort'] = '';
		$insert['jinyan'] = trim($strs[19]);
		$insert[$arr['2']] = 1;
		$insert['code'] = $rand;
		$insert['is_show'] = 0;
		$insert['openid'] = '';
		$insert['uid'] = 0;
		$insert['thumb'] = 'images/global/avatars/avatar_3.jpg';

        $assess = pdo_fetch("SELECT * FROM " . tablename('wx_school_t_teachers') . " WHERE tname=:tname AND mobile=:mobile AND weid=:weid And schoolid=:schoolid LIMIT 1", array(':tname' => trim($strs[1]), ':mobile' => $strs[4], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));

        if (empty($assess)) {
            return pdo_insert('wx_school_t_teachers', $insert);
        } else {
            return 0;
        }
    }

    function upload_students($strs, $time, $array) {
        global $_W;
        $insert = array();
		//年级处理
		$xueqi = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[9]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[10]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $insert['weid'] = $_W['uniacid'];
        $insert['s_name'] = trim($strs[1]);
        $insert['sex'] = trim($strs[2]);
        $insert['birthdate'] = strtotime(trim($strs[3]));
        $insert['mobile'] = trim($strs[4]);
        $insert['homephone'] = trim($strs[5]);
        $insert['seffectivetime'] = strtotime(trim($strs[6]));
        $insert['stheendtime'] = strtotime(trim($strs[7]));
        $insert['area_addr'] = trim($strs[8]);
		$insert['numberid'] = trim($strs[11]);
        $insert['xq_id'] = empty($xueqi) ? 0 : intval($xueqi['sid']);
        $insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
		$insert['schoolid'] = $array['schoolid'];
		$insert['createdate'] = time();
		$insert['jf_statu'] = '';
		$insert['localdate_id'] = '';
		$insert['note'] = '';
		$insert['amount'] = '';
		$insert['area'] = '';
		$insert['own'] = '';

        $students = pdo_fetch("SELECT * FROM " . tablename('wx_school_t_students') . " WHERE numberid=:numberid AND weid=:weid And schoolid=:schoolid LIMIT 1", array(':numberid' => trim($strs[11]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));

        if (empty($students)) {
            return pdo_insert('wx_school_t_students', $insert);
        } else {
            return 2;
        }
    }

    function upload_chengji($strs, $time, $array) {
        global $_W;
        $insert = array();
		//名字处理
		$sid = pdo_fetch("SELECT id FROM " . tablename('wx_school_t_students') . " WHERE s_name=:s_name AND weid=:weid And schoolid=:schoolid ", array(':s_name' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//年级处理
		$xueqi = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[2]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//期号处理
		$qihao = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[3]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[4]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//科目处理
		$kemu = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[5]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $insert['sid'] = empty($sid) ? 0 : intval($sid['id']);
        $insert['xq_id'] = empty($xueqi) ? 0 : intval($xueqi['sid']);
		$insert['qh_id'] = empty($qihao) ? 0 : intval($qihao['sid']);
        $insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
        $insert['km_id'] = empty($kemu) ? 0 : intval($kemu['sid']);
        $insert['my_score'] = trim($strs[6]);
		$insert['info'] = trim($strs[7]);
		$insert['schoolid'] = $array['schoolid'];
        $insert['weid'] = $_W['uniacid'];

        return pdo_insert('wx_school_t_score', $insert);
    }

    function upload_kecheng($strs, $time, $array) {
        global $_W;
        $insert = array();
		//名字处理
		$tid = pdo_fetch("SELECT id FROM " . tablename('wx_school_t_teachers') . " WHERE tname=:tname AND weid=:weid And schoolid=:schoolid ", array(':tname' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//年级处理
		$xueqi = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[2]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[4]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//科目处理
		$kemu = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[5]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $insert['tid'] = empty($tid) ? 0 : intval($tid['id']);
        $insert['xq_id'] = empty($xueqi) ? 0 : intval($xueqi['sid']);
		$insert['name'] = trim($strs[3]);
        $insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
        $insert['km_id'] = empty($kemu) ? 0 : intval($kemu['sid']);
        $insert['minge'] = trim($strs[6]);
		$insert['yibao'] = trim($strs[7]);
		$insert['cose'] = trim($strs[8]);
		$insert['dagang'] = trim($strs[9]);
		$insert['adrr'] = trim($strs[10]);
		$insert['is_hot'] = trim($strs[11]);
		$insert['ssort'] = trim($strs[14]);
		$insert['is_show'] = 1;
		$insert['start'] = strtotime(trim($strs[12]));
		$insert['end'] = strtotime(trim($strs[13]));
		$insert['schoolid'] = $array['schoolid'];
        $insert['weid'] = $_W['uniacid'];

        return pdo_insert('wx_school_t_tcourse', $insert);
    }

    function upload_kcbiao($strs, $time, $array) {
        global $_W;
        $insert = array();
		//名字处理
		$kc = pdo_fetch("SELECT id FROM " . tablename('wx_school_t_tcourse') . " WHERE id=:id AND weid=:weid And schoolid=:schoolid ", array(':id' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $tid = pdo_fetch("SELECT tid FROM " . tablename('wx_school_t_tcourse') . " WHERE id=:id AND weid=:weid And schoolid=:schoolid ", array(':id' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $bj = pdo_fetch("SELECT bj_id FROM " . tablename('wx_school_t_tcourse') . " WHERE id=:id AND weid=:weid And schoolid=:schoolid ", array(':id' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $km = pdo_fetch("SELECT km_id FROM " . tablename('wx_school_t_tcourse') . " WHERE id=:id AND weid=:weid And schoolid=:schoolid ", array(':id' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//年级处理
		$xq = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[2]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//期号处理
		$shiduan = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[3]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));

        $insert['kcid'] = empty($kc) ? 0 : intval($kc['id']);
	    $insert['tid'] = empty($tid) ? 0 : intval($tid['tid']);
        $insert['xq_id'] = empty($xq) ? 0 : intval($xq['sid']);
		$insert['sd_id'] = empty($shiduan) ? 0 : intval($shiduan['sid']);
        $insert['bj_id'] = empty($bj) ? 0 : intval($bj['bj_id']);
        $insert['km_id'] = empty($km) ? 0 : intval($km['km_id']);
        $insert['nub'] = trim($strs[4]);
		$insert['date'] = strtotime(trim($strs[5]));
		$insert['schoolid'] = $array['schoolid'];
        $insert['weid'] = $_W['uniacid'];

        return pdo_insert('wx_school_t_kcbiao', $insert);
    }
	
    function upload_cardlist($strs, $time, $array) {
        global $_W;
        $insert = array();
		$card = pdo_fetch("SELECT id FROM " . tablename('wx_school_t_idcard') . " WHERE idcard=:idcard AND weid=:weid And schoolid=:schoolid ", array(':idcard' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		if (!empty($strs[3])){
		$tid = pdo_fetch("SELECT id,tname,thumb FROM " . tablename('wx_school_t_teachers') . " WHERE tname=:tname AND weid=:weid And schoolid=:schoolid ", array(':tname' => trim($strs[3]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		}
		if (!empty($strs[4])){
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_t_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[4]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		}
		//名字处理
		if (!empty($strs[1])){
		$sid = pdo_fetch("SELECT id FROM " . tablename('wx_school_t_students') . " WHERE s_name=:s_name AND weid=:weid And schoolid=:schoolid And bj_id=:bj_id ", array(':s_name' => trim($strs[2]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid'], ':bj_id'=> $banji['sid']));
		}
        $insert['weid'] = $_W['uniacid']; 
		$insert['schoolid'] = $array['schoolid'];
		$insert['idcard'] = trim($strs[1]);
		$insert['sid'] = empty($sid) ? 0 : intval($sid['id']);
		$insert['tid'] = empty($tid) ? 0 : intval($tid['id']);
		$insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
		$insert['createtime'] = time();
        $insert['severend'] = strtotime(trim($strs[5]));
		$insert['spic'] = "";
		$insert['tpic'] = "";
		$insert['is_on'] = empty($strs[7]) ? 0 : 1;
		$insert['usertype'] = empty($strs[3]) ? 0 : 1;
		$insert['pard'] = empty($strs[6]) ? 0 : intval($strs[6]);
		$insert['pname'] = empty($strs[7]) ? 0 : trim($strs[7]);
        
		if (empty($card)) {
            return pdo_insert('wx_school_t_idcard', $insert);
        }else{
			 message('有重复卡号【'.$strs[1].'】，请检查');
		}
    }	

    private function checkUploadFileMIME($file) {
        // 1.through the file extension judgement 03 or 07
        $flag = 0;
        $file_array = explode(".", $file ["name"]);
        $file_extension = strtolower(array_pop($file_array));

        // 2.through the binary content to detect the file
        switch ($file_extension) {
            case "xls" :
                // 2003 excel
                $fh = fopen($file ["tmp_name"], "rb");
                $bin = fread($fh, 8);
                fclose($fh);
                $strinfo = @unpack("C8chars", $bin);
                $typecode = "";
                foreach ($strinfo as $num) {
                    $typecode .= dechex($num);
                }
                if ($typecode == "d0cf11e0a1b11ae1") {
                    $flag = 1;
                }
                break;
            case "xlsx" :
                // 2007 excel
                $fh = fopen($file ["tmp_name"], "rb");
                $bin = fread($fh, 4);
                fclose($fh);
                $strinfo = @unpack("C4chars", $bin);
                $typecode = "";
                foreach ($strinfo as $num) {
                    $typecode .= dechex($num);
                }
                echo $typecode . 'test';
                if ($typecode == "504b34") {
                    $flag = 1;
                }
                break;
        }

        // 3.return the flag
        return $flag;
    }

    public function doWebUploadExcel() {
        global $_GPC, $_W;

        if ($_GPC['leadExcel'] == "true") {
            $filename = $_FILES['inputExcel']['name'];
            $tmp_name = $_FILES['inputExcel']['tmp_name'];

            $flag = $this->checkUploadFileMIME($_FILES['inputExcel']);
            if ($flag == 0) {
                message('文件格式不对.');
            }

            if (empty($tmp_name)) {
                message('请选择要导入的Excel文件！');
            }

            $msg = $this->uploadFile($filename, $tmp_name, $_GPC);

            if ($msg == 1) {
                message('导入成功！', referer(), 'success');
            } else {
                message($msg, '', 'error');
            }
        }
    }

	public function weixin_fans_group($url, $data) {
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		load()->classs('weixin.account');
		$accObj = WeixinAccount::create($weid);
		$access_token = WeAccount::token();
		$url = sprintf($url, $access_token);
		load()->func('communication');
		$response = ihttp_request($url, $data);
		if (is_error($response)) {
			return error(-1, "访问公众平台接口失败, 错误: {$response['message']}");
		}
		$result = @json_decode($response['content'], true);
		if (empty($result)) {
		} elseif (!empty($result['errcode'])) {
			message("访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']}");
		}
		return $result;
	}

	public function createImageUrlCenter($qr_file,$schoolid) {
		global $_W, $_GPC;
		$param = pdo_fetch("select * from " . tablename($this->table_qrset) . " where id = :id", array(':id' => 1));
		$school = pdo_fetch("select * from " . tablename($this->table_index) . " where id = :id And weid = :weid", array(':id' => $schoolid, ':weid' => $_W['uniacid']));
		load()->func('file');
		mkdirs('../attachment/images/');
		$target_file = "../attachment/images/". time() . random(16) . ".jpg";

		if (!empty($school['logo'])) {
			$src_file = tomedia($school['logo']);
		} else {
			message('抱歉，'.$school['title'].'没有设置LOGO,请先到学校管理编辑上传学校的LOGO');
		}
		$this->resizeImage($this->imagecreate($qr_file), intval($param['logoqrwidth']), intval($param['logoqrheight']), $target_file);
		list($qrWidth, $qrHeight) = getimagesize($target_file);
		$centerleft = ($qrWidth - intval($param['logowidth'])) / 2;
		$centertop = ($qrHeight - intval($param['logoheight'])) / 2;
		$this->mergeImage($target_file, $src_file, $target_file, array('left' => $centerleft, 'top' => $centertop, 'width' => $param['logowidth'], 'height' => $param['logoheight']));

		return $target_file;

	}

	private function mergeImage($bg, $qr, $out, $param) {

		global $_W, $_GPC;
		load()->func('file');
		list($bgWidth, $bgHeight) = getimagesize($bg);
		list($qrWidth, $qrHeight) = getimagesize($qr);
		$bgImg = $this->imagecreate($bg);
		$qrImg = $this->imagecreate($qr);
		imagecopyresized($bgImg, $qrImg, $param['left'], $param['top'], 0, 0, $param['width'], $param['height'], $qrWidth, $qrHeight);
		ob_start();
		imagejpeg($bgImg, NULL, 100);
		$contents = ob_get_contents();
		ob_end_clean();
		imagedestroy($bgImg);
		imagedestroy($qrImg);

		file_write($out, $contents);

		//$fh = fopen($out, "w+");
		//fwrite($fh, $contents);
		//fclose($fh);
	}

	function resizeImage($im, $maxwidth, $maxheight, $path)	{
		$pic_width = imagesx($im);
		$pic_height = imagesy($im);
		if (($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight)) {
			if ($maxwidth && $pic_width > $maxwidth) {
				$widthratio = $maxwidth / $pic_width;
				$resizewidth_tag = true;
			}
			if ($maxheight && $pic_height > $maxheight) {
				$heightratio = $maxheight / $pic_height;
				$resizeheight_tag = true;
			}
			if ($resizewidth_tag && $resizeheight_tag) {
				if ($widthratio < $heightratio) $ratio = $widthratio; else $ratio = $heightratio;
			}
			if ($resizewidth_tag && !$resizeheight_tag) $ratio = $widthratio;
			if ($resizeheight_tag && !$resizewidth_tag) $ratio = $heightratio;
			$newwidth = $pic_width * $ratio;
			$newheight = $pic_height * $ratio;
			if (function_exists('imagecopyresampled')) {
				$newim = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
			} else {
				$newim = imagecreate($newwidth, $newheight);
				imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
			}
			imagejpeg($newim, $path);
			imagedestroy($newim);
		} else {
			imagejpeg($im, $path);
		}
	}

	private function imagecreate($bg) {
		$bgImg = @imagecreatefromjpeg($bg);
		if (FALSE == $bgImg) {
			$bgImg = @imagecreatefrompng($bg);
		}
		if (FALSE == $bgImg) {
			$bgImg = @imagecreatefromgif($bg);
		}
		return $bgImg;
	}
	
	public function doMobilePay() {
		global $_W, $_GPC;
        checkauth();
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$cose = $_GPC ['cose'];
		$wxpayid = intval($_GPC ['wxpay']);
        //构造支付请求中的参数
        $params = array(
            'tid' => $wxpayid,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
            'ordersn' => time(),  //收银台中显示的订单号
            'title' => '在线缴费',          //收银台中显示的标题
            'fee' => $cose,
            //'user' => $_W['member']['uid'],     //付款用户, 付款的用户名(选填项)
        );
        //调用pay方法
        include $this->template('students/pay');
	}
    /**
     * 支付后触发这个方法
     * @param $params
     */
	public function payResult($params) {

		global $_W, $_GPC;

		$orderid = $params['tid'];
        $wxpay = pdo_fetch("SELECT * FROM " . tablename($this->table_wxpay) . " WHERE id = '{$orderid}'");

		if ($params['result'] == 'success' && $params['from'] == 'notify') {

			pdo_update($this->table_wxpay, array('status' => 2), array('id' => $orderid));
			pdo_update($this->table_order, array('status' => 2, 'paytime' => time(), 'paytype' => 1, 'pay_type' => $params['type']), array('id' => $wxpay['od1']));
			$order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where id = :id ", array(':id' => $wxpay['od1']));
			$sign = pdo_fetch("SELECT * FROM " . tablename($this->table_signup) . " where :id = id", array(':id' => $order['signid']));
			$njinfo = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE :sid = sid ", array(':sid' => $sign['nj_id']));
			$njzr = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE :id = id ", array(':id' => $njinfo['tid']));		
			if($order['type'] == 4){
				$this->sendMobileBmshtz($order['signid'], $order['schoolid'], $order['weid'], $njzr['openid'], $sign['name']);
			}else if($order['type'] == 5){
				$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE id = :id ", array(':id' => $wxpay['schoolid']));
				$chard = pdo_fetch("SELECT severend FROM " . tablename($this->table_idcard) . " WHERE id = :id ", array(':id' => $order['bdcardid']));
				$card = unserialize($school['cardset']);
					if($card['cardtime'] == 1){
						$severend = $card['endtime1'] * 86400 + $chard['severend'];
					}else{
						$severend = $card['endtime2'];
					}				
				pdo_update($this->table_idcard, array('severend' => $severend), array('id' => $order['bdcardid']));
			}			 
			 if ($params['fee'] != $cose) {
				exit('支付失败');
			 }
		}
		if (empty($params['result']) || $params['result'] != 'success') {
			 pdo_update($this->table_wxpay, array('status' => 1), array('id' => $orderid));
			 pdo_update($this->table_order, array('status' => 1), array('id' => $wxpay['od1']));
		}
		if ($params['from'] == 'return') {		
			if($order['type'] == 4){		
				$url = $_W['siteroot'] . 'app/index.php?i=' . $wxpay['weid'] . '&c=entry&schoolid=' . $wxpay['schoolid'] . '&id=' . $order['signid'] . '&do=signupjc&m=fk_cs';
			}else if($order['type'] == 5){		
				$url = $_W['siteroot'] . 'app/index.php?i=' . $wxpay['weid'] . '&c=entry&schoolid=' . $wxpay['schoolid'] . '&do=user&m=fk_cs';
			}else{
				$url = $_W['siteroot'] . 'app/index.php?i=' . $wxpay['weid'] . '&c=entry&schoolid=' . $wxpay['schoolid'] . '&do=user&m=fk_cs';
			}
			if ($params['result'] == 'success') {
				message('支付成功！', $url);
			} else {
				message('支付失败！', $url);
			}
		}
	}

	public function uniarr($uniarr, $id) {

		foreach ($uniarr as $key => $value) {
			if ($id == $value) {
				return true;
			}
		}
		return false;
	}

	public function checkpay($schoolid, $sid, $userid, $uid) {
		global $_W, $_GPC;

		$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE :weid = weid And :schoolid = schoolid And :id = id", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':id' => $sid));
		$cost = pdo_fetchall("SELECT * FROM " . tablename($this->table_cost) . " where weid = :weid And schoolid = :schoolid And is_on = :is_on ", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_on' => 1));

		foreach ($cost as $key => $value) {
			$bjarr = explode(',',$value['bj_id']);
			$is = $this->uniarr($bjarr, $student['bj_id']);
			//print_r($bjarr);
			if ($is) {
				//$bjstatus = true;
				$orderst = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid And schoolid = :schoolid And obid = :obid And costid = :costid And sid = :sid And type = :type ", array(
							':weid' => $_W['uniacid'],
							':schoolid' => $schoolid,
							':costid' => $value['id'],
							':obid' => $value['about'],
							':sid' => $sid,
							':type' => 3
							));
				if (empty($orderst)) {
					$orderid = "{$uid}{$sid}";
						$date = array(
							'weid' =>  $_W['uniacid'],
							'schoolid' => $schoolid,
							'sid' => $sid,
							'userid' => $userid,
							'type' => 3,
							'status' => 1,
							'obid' => $value ['about'],
							'costid' => $value ['id'],
							'uid' => $uid,
							'cose' => $value['cost'],
							'payweid' => $value['payweid'],
							'orderid' => $orderid,
							'createtime' => time(),
						);
					pdo_insert($this->table_order, $date);
				}
			}
		}
	}

	public function checkobjiect($schoolid, $sid, $obid) {

		global $_W, $_GPC;

		$order = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid And schoolid = :schoolid And sid = :sid And type = :type And obid = :obid ORDER BY id DESC LIMIT 0,1", array(
				':weid' => $_W['uniacid'],
				':schoolid' => $schoolid,
				':sid' => $sid,
				':obid' => $obid,
				':type' => 3,
				));

		foreach ($order as $key => $value) {

			$cost = pdo_fetch("SELECT * FROM " . tablename($this->table_cost) . " where weid = :weid And schoolid = :schoolid And is_on = :is_on  And id = :id", array(
					':weid' => $_W['uniacid'],
					':schoolid' => $schoolid,
					':id' => $value['costid'],
					':is_on' => 1
					));
			if (!empty($cost)){
				if ($value['status'] == 2) {
					if ($cost['is_time'] == 1){
						if($cost['endtime'] < TIMESTAMP){
							$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('obinfo', array('id' => $value['costid'], 'schoolid' => $schoolid, 'type' => 1));
							header("location:$stopurl");
						}else if($cost['starttime'] > TIMESTAMP){
							$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('obinfo', array('id' => $value['costid'], 'schoolid' => $schoolid, 'type' => 2));
							header("location:$stopurl");
						}
					}else{
						$time = $cost['dataline'] * 86400;
						$times = $time + $value['paytime'];
						$rest = $times - TIMESTAMP;
						$restday = $rest/86400;
						if ($restday < 0){
							$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('obinfo', array('id' => $value['costid'], 'schoolid' => $schoolid, 'type' => 1));
							header("location:$stopurl");
						}
					}
				}else{
					$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('obinfo', array('id' => $value['costid'], 'schoolid' => $schoolid, 'type' => 1));
					header("location:$stopurl");
				}
			}
		}
	}
   
	public function sendcustomMsg($from_user, $msg) {
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		load()->classs('weixin.account');
		load()->func('communication');
		$accObj = WeixinAccount::create(9);
		$access_token = WeAccount::token();		
		$url          = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
		$msg          = str_replace('"', '\\"', $msg);
		$post         = '{"touser":"' . $from_user . '","msgtype":"text","text":{"content":"' . $msg . '"}}';
//		$this->curlPost($url, $post);
		ihttp_post($url,$post);
	}

    public function toSendCustomNotice($openid,$title,$content,$url){
		$send_text = '';
		$send_text.="您好，您有一个学校通知\r\n";
        $send_text.="标题：{$title}\r\n";
        $send_text.="时间：".date("Y-m-d H:i:s",time() )."\r\n";
        $send_text.="内容：{$content}\r\n";
        $send_text.="<a href=\"".$url."\">点此查看详情  </a>";
        $this->sendcustomMsg($openid,$send_text);
    }

	public function newBookOrderNotice($openid,$title,$content,$url){
		$send_text = '';
		$send_text.="您好，您有一个闲书订单\r\n";
		$send_text.="时间：".date("Y-m-d H:i:s",time() )."\r\n";
		$send_text.="内容：{$content}\r\n";
		$send_text.="<a href=\"".$url."\">点此查看详情  </a>";
		$this->sendcustomMsg($openid,$send_text);
	}

	public function checkBookAccount($openid,$schoolid,$weid)
	{
		$account = pdo_fetch("SELECT * FROM " .tablename($this->table_bookaccount) . "where openid = '{$openid}'");
		if(empty($account)){
			pdo_insert($this->table_bookaccount,array('openid' => $openid));
		}
		//关联集阅读
		$user = pdo_fetch ( "SELECT * FROM " . tablename ('jy_reads_user') . " WHERE replyid = :replyid and openid = :openid", array (
			':replyid' => 2,
			':openid' => $openid
		) );
		if(!empty($user)){
			$hits = intval ( $user ['hits'] );
			//查询集赞情况
			$margin = pdo_fetch("SELECT * FROM " . tablename($this->table_bookmargin) . "where type='book_jy'");
			if($hits > 0 && $hits >= $margin['amount']){
				$account1 = pdo_fetch("SELECT * FROM " .tablename($this->table_bookaccount) . "where openid = '{$openid}'");
				if($account1['jy_amount'] == null || $account1['jy_amount'] == '0.00'){
					$balance = $account1['balance'] + $margin['couponAmount'];
					pdo_update($this->table_bookaccount,array('jy_amount' => $margin['couponAmount'],'balance' => $balance),array('openid' => $account1['openid']));
					//发送模板消息
					$msgBody = array(
						'schoolid'   => $schoolid,
						'weid'       => $weid,
						'orderId'    => 10000,
						'orderType'  => 'jz',
						'amountData' => array(
							'preAmount'   => $account1['balance'],
							'afterAmount' => $balance,
							'amount'      => $margin['couponAmount']
						)
					);
					$this->sendMobileXsedbdtz($msgBody);
					//添加日志
					$data = array(
						'amount' => $margin['couponAmount'],
						'type'   => 'jy',
						'openid' => $openid,
						'remark' => '集赞赠送额度'
					);
					pdo_insert($this->table_booklog,$data);
				}
			}
		}
	}
	//百度地图坐标计算
	public function rad($d)
	{
		return $d * 3.1415926535898 / 180.0;
	}
	public function getDistance($lat1, $lng1, $lat2, $lng2)
	{
		$EARTH_RADIUS = 6378.137;//地球的半径
		$radLat1 = $this->rad($lat1);
		$radLat2 = $this->rad($lat2);
		$a = $radLat1 - $radLat2;
		$b = $this->rad($lng1) - $this->rad($lng2);
		$s = 2 * asin(sqrt(pow(sin($a/2),2) +
				cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
		$s = $s *$EARTH_RADIUS;
		$s = round($s * 10000) / 10000;
		$s=$s*1000;
		return ceil($s);
	}

	/**
	 * 标记大概的距离，做出友好的距离提示
	 * @param [$number] 距离数量
	 * @return[String] 距离提示
	 */
	public function mToKm($number){
		if(!is_numeric($number)) return ' ';
		return sprintf('%0.2f',($number/1000)).'千米';
//		if($number > 1000){
//			return sprintf('%0.2f',($number/1000)).'千米';
//		}else{
//			return $number.'米';
//		}
	}

	public function doMobilePaybook(){
		global $_GPC,$_W;
		$type = $_GPC['type'];
		$payopenid = $_GPC['payopenid'];
		$logid = intval($_GPC['logid']);
		$params = array(
			'module' => 'jing_cash',
			'type' => $type,
			'uniacid' => $_W['uniacid'],
			'acid' => $_W['acid'],
			'openid' => $_W['openid'],
			'payopenid' => $payopenid,
			'title' => '押金充值',
			'fee' => $_GPC['money'],
			'tid' => $logid
		);
		$moduleid = pdo_fetchcolumn("SELECT mid FROM ".tablename('modules')." WHERE name = :name", array(':name' => $params['module']));
		$moduleid = empty($moduleid) ? '000000' : sprintf("%06d", $moduleid);
		if ($type == 'wechat') {
			$config = $this->module['config'];
			if (!empty($config['rule'])) {
				$rule = iunserializer($config['rule']);
				foreach ($rule as $key => $value) {
					if ($value['cz'] == $_GPC['money']) {
						$zs = $value['zs'];
						$fh = isset($value['fh']) ? $value['fh'] : 1;
						break;
					}else{
						$zs = 0;
						$fh = 1;
					}
				}
			}
			if (empty($params['tid'])) {
				$insert = array(
					'uniacid' => $_W['uniacid'],
					'openid' => $_W['openid'],
					'money' => $_GPC['money'],
					'zs' => $zs,
					'fh' => $fh,
					'sy' => $zs,
					'lastfh' => 0,
					'createtime' => TIMESTAMP,
				);
				pdo_insert('jing_cash_recharge', $insert);
				$params['tid'] = pdo_insertid();
			}else{
				pdo_update('jing_cash_recharge', array('money' => $_GPC['money'], 'zs' => $zs, 'fh' => $fh, 'sy' => $zs, 'lastfh' => 0),array('id'=>$params['tid']));
			}

			if($_W['container'] != 'wechat'){
				exit(json_encode(array('status'=>0,'msg'=>'请在微信中使用.')));
			}
			if ($config['oauth'] == 0) { //不借用权限
				$setting = uni_setting($_W['uniacid'], array('payment'));
				$params['attach'] = $_W['uniacid'];
			}else{
				$acid = $config['oauth'];
				$account = account_fetch($acid);
				$uniacid = pdo_fetchcolumn("SELECT uniacid FROM ".tablename('account')." WHERE acid=:acid",array(':acid'=>$acid));
				$setting = uni_setting($uniacid, array('payment'));
				$params['attach'] = $uniacid;
			}

			if(!is_array($setting['payment'])) {
				exit(json_encode(array('status'=>0,'msg'=>'没有设定支付参数.')));
			}
			$wechat = $setting['payment']['wechat'];
			$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
			$row = pdo_fetch($sql, array(':acid' => $wechat['account']));
			$wechat['appid'] = $row['key'];
			$wechat['secret'] = $row['secret'];
			$wOpt = $this->wechat_build($params, $wechat);
			if (is_error($wOpt)) {
				if ($wOpt['message'] == 'invalid out_trade_no' || $wOpt['message'] == 'OUT_TRADE_NO_USED') {
					exit(json_encode(array('status'=>0,'msg'=>'抱歉，发起支付失败，系统已经修复此问题，请重新尝试支付。')));
				}
				exit(json_encode(array('status'=>0,'msg'=>'抱歉，发起支付失败，具体原因为：“'.$wOpt['errno'].':'.$wOpt['message'].'”。请及时联系站点管理员。')));
			}
			exit(json_encode(array('status'=>1,'wechat'=>$wOpt,'logid'=>$params['tid'])));
		}
	}

	public function wechat_build($params, $wechat) {
		global $_W;
		load()->func('communication');
		if (empty($wechat['version']) && !empty($wechat['signkey'])) {
			$wechat['version'] = 1;
		}
		$paylog = pdo_fetch("SELECT * FROM ".tablename('core_paylog')." WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid ",array(':uniacid'=>$params['uniacid'],':module'=>$params['module'],':tid'=>$params['tid']));
		if(!empty($paylog) && $paylog['status'] != '0') {
			return error(-1, '这个订单已经支付成功, 不需要重复支付.');
		}
		$moduleid = pdo_fetchcolumn("SELECT mid FROM ".tablename('modules')." WHERE name = :name", array(':name' => $params['module']));
		$moduleid = empty($moduleid) ? '000000' : sprintf("%06d", $moduleid);
		$fee = $params['fee'];
		if(!empty($paylog) && $paylog['status'] == '0') { //订单存在并且未支付，更新记录
			$fee = $params['fee'];
			$record = array();
			$record['fee'] = $fee;
			$record['uniontid'] = date('YmdHis').$moduleid.random(8,1);
			$record['card_fee'] = $fee;
			pdo_update('core_paylog', $record, array('tid'=>$params['tid'],'module'=>$params['module']));
		}
		if(empty($paylog)) {//订单不存在，加入记录
			$fee = $params['fee'];
			$record = array();
			$record['uniacid'] = $params['uniacid'];
			$record['openid'] = $params['openid'];
			$record['module'] = $params['module'];
			$record['type'] = $params['type'];
			$record['tid'] = $params['tid'];
			$record['uniontid'] = date('YmdHis').$moduleid.random(8,1);
			$record['fee'] = $fee;
			$record['status'] = '0';
			$record['is_usecard'] = 0;
			$record['card_id'] = 0;
			$record['card_fee'] = $fee;
			$record['encrypt_code'] = '';
			$record['acid'] = $params['acid'];
			pdo_insert('core_paylog', $record);
		}
		$params['uniontid'] = $record['uniontid'];
		$wOpt = array();
		if ($wechat['version'] == 1) {
			$wOpt['appId'] = $wechat['appid'];
			$wOpt['timeStamp'] = TIMESTAMP;
			$wOpt['nonceStr'] = random(8);
			$package = array();
			$package['bank_type'] = 'WX';
			$package['body'] = $params['title'];
			$package['attach'] = $params['attach'];
			$package['partner'] = $wechat['partner'];
			$package['out_trade_no'] = $params['uniontid'];
			$package['total_fee'] = $params['fee'] * 100;
			$package['fee_type'] = '1';
			$package['notify_url'] = $_W['siteroot'] . 'payment/wechat/notify.php';
			$package['spbill_create_ip'] = CLIENT_IP;
			$package['time_start'] = date('YmdHis', TIMESTAMP);
			$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
			$package['input_charset'] = 'UTF-8';
			ksort($package);
			$string1 = '';
			foreach($package as $key => $v) {
				if (empty($v)) {
					continue;
				}
				$string1 .= "{$key}={$v}&";
			}
			$string1 .= "key={$wechat['key']}";
			$sign = strtoupper(md5($string1));

			$string2 = '';
			foreach($package as $key => $v) {
				$v = urlencode($v);
				$string2 .= "{$key}={$v}&";
			}
			$string2 .= "sign={$sign}";
			$wOpt['package'] = $string2;

			$string = '';
			$keys = array('appId', 'timeStamp', 'nonceStr', 'package', 'appKey');
			sort($keys);
			foreach($keys as $key) {
				$v = $wOpt[$key];
				if($key == 'appKey') {
					$v = $wechat['signkey'];
				}
				$key = strtolower($key);
				$string .= "{$key}={$v}&";
			}
			$string = rtrim($string, '&');

			$wOpt['signType'] = 'SHA1';
			$wOpt['paySign'] = sha1($string);
			return $wOpt;
		} else {
			$package = array();
			$package['appid'] = $wechat['appid'];
			$package['mch_id'] = $wechat['mchid'];
			$package['nonce_str'] = random(8);
			$package['body'] = $params['title'];
			$package['attach'] = $params['attach'];
			$package['out_trade_no'] = $params['uniontid'];
			$package['total_fee'] = $params['fee'] * 100;
			$package['spbill_create_ip'] = CLIENT_IP;
			$package['time_start'] = date('YmdHis', TIMESTAMP);
			$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
			$package['notify_url'] = $_W['siteroot'] . 'payment/wechat/notify.php';
			$package['trade_type'] = 'JSAPI';
			$package['openid'] = $params['payopenid'];
			ksort($package, SORT_STRING);
			$string1 = '';
			foreach($package as $key => $v) {
				if (empty($v)) {
					continue;
				}
				$string1 .= "{$key}={$v}&";
			}
			$string1 .= "key={$wechat['signkey']}";
			$package['sign'] = strtoupper(md5($string1));
			$dat = array2xml($package);
			$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
			if (is_error($response)) {
				return $response;
			}
			$xml = @isimplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
			if (strval($xml->return_code) == 'FAIL') {
				return error(-1, strval($xml->return_msg));
			}
			if (strval($xml->result_code) == 'FAIL') {
				return error(-1, strval($xml->err_code).': '.strval($xml->err_code_des));
			}
			$prepayid = $xml->prepay_id;
			$wOpt['appId'] = $wechat['appid'];
			$wOpt['timeStamp'] = TIMESTAMP . "";
			$wOpt['nonceStr'] = random(8);
			$wOpt['package'] = 'prepay_id='.$prepayid;
			$wOpt['signType'] = 'MD5';
			ksort($wOpt, SORT_STRING);
			foreach($wOpt as $key => $v) {
				$string .= "{$key}={$v}&";
			}
			$string .= "key={$wechat['signkey']}";
			$wOpt['paySign'] = strtoupper(md5($string));
			return $wOpt;
		}
	}
}
