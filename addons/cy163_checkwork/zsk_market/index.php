<?php 
// 注   需导入  ims_uni_account_users表
//   需导入 ims_users表
//   ims_users_permission 表
session_start();
$IASTRURL =  str_replace("\\", '/', dirname(__FILE__));
if(is_dir($IASTRURL."/zsk_market")){
    define('FORM_ROOT', str_replace("\\", '/', dirname(__FILE__))."/zsk_market");
}else{
    define('FORM_ROOT', str_replace("\\", '/', dirname(__FILE__)));
}
include FORM_ROOT.'/defines.php';
require_once ZSK_PATH."core/task/pdo.class.php";
require_once FORM_ROOT.'/libs/global.func.php';
require_once ZSK_PATH."libs/function.php";
// require_once ZSK_PATH."libs/communication.func.php";
 

require_once ZSK_PATH."libs/wechat.class.php"; 
// require_once ZSK_PATH."libs/model.class.php"; 
require_once ZSK_PATH."libs/wxpay/wxpay.class.php";  
require_once ZSK_PATH."libs/wxpush.func.php";
//$host = $_SERVER['HTTP_HOST'];
$lockFile = FORM_ROOT."/install/install/install.lock";
if(!file_exists($lockFile)){
  include("./install/install.php");
  // header('Location:./install/install.php');
}else{
  // $_W['uniacid']=11;
  $_W['uniacid'] = $_SESSION['uniacid'];
  // $_W['username']="adminr";
  $_W['role'] = $_SESSION['judgeid'];
  $_W['setting']['upload']['image']['limit']=1024;
	if (!empty($_GPC['act'])||$_GPC['from']=="wxapp") {
      if($_GPC['from']=="wxapp"&&!empty($_GPC['act'])){
        $_W['uniacid']=intval($_GPC['i']);
        route();
      }else{
        if($_GPC['act']=="login.getlogin"){//判断是否为执行登录
            route();
        }else{
          if($_SESSION['username']){//判断是否已经登录
            $shopid=getShopID();
            // if(empty($shop9982)){
            //   $shop9982=getShopInfo();
            // } 
            $_W['username'] = $_SESSION['username'];
            route();
          }else{//执行加载登录页面
            echo "<script>parent.location.reload();</script>";
            $path=ZSK_PATH.'core/web/login.ctrl.php'; 
            require_once $path;
            $controller = new Login();
            $controller->index(); 
          }
        }
      }
    }else{
      if($_SESSION['username']){
        $_W['username'] = $_SESSION['username'];
     	  include("module.php");
      }else{
          $path=ZSK_PATH.'core/web/login.ctrl.php'; 
          require_once $path;
          $controller = new Login();
          $controller->index(); 
        }
  		//header('Location: ./module.php');
    }
}