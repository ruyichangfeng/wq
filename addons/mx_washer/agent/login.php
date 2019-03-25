<!DOCTYPE html>
<?php
	session_Start();
	 function __autoload($classname){
		require_once $classname.'.class.php';
	}	
	$ac = new Actions(); 
?>
<html lang="en">
    <head>        
        <!-- Title -->
        <title>智能云平台 -- 代理商户端</title>        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <!-- Styles -->
        <link href="../template/assets/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
        <link href="../template/assets/plugins/uniform/css/default.css" rel="stylesheet"/>
        <link href="../template/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../template/assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="../template/assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>	
        <link href="../template/assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>	
        <link href="../template/assets/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>	
        <link href="../template/assets/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
        <link href="../template/assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>	
        <!-- Theme Styles -->
        <link href="../template/assets/css/layers.min.css" rel="stylesheet" type="text/css"/>
        <link href="../template/assets/css/layers/dark-layer.css" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="../template/assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <script src="../template/assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
        <script src="../template/assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
<?php
 if(isset($_POST['login'])){
	$user = $_POST['UserName'];
	$pwd = md5($_POST['UserPwd']);
	$data = [
		'table' => 'agent',
		'where' => 'user = "'.$user.'" and pwd = "'.$pwd.'"',
		'field' => '*',
	];
	$result = $ac->Find($data);
	if($result){
		$_SESSION['AgentUser'] = $result['user'];
		$_SESSION['Id'] = $result['id'];
		$_SESSION['Uniacid'] = $result['uniacid'];
		echo "<script>alert('登录成功！');window.location.href='index.php';</script>";
	}else{
		echo "<script>alert('登录失败!');window.history.back();</script>";
	}
}
?> 
    </head>
    <body class="page-login">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-3 center">
                            <div class="panel panel-white" id="js-alerts" style="margin-top:50px;">
                                <div class="panel-body">
                                    <div class="login-box">
                                        <a href="" class="logo-name text-lg text-center m-t-xs">代理商云平台系统管理员登录</a>
                                        <p class="text-center m-t-md"></p>
                                        <form class="m-t-md" action="" method="post">
                                            <div class="form-group">
                                                <input type="text" name="UserName" class="form-control" placeholder="输入用户名……" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="UserPwd" class="form-control password" placeholder="请输入密码……" required>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-block" name="login">登录</button>
                                            <a href="forgot.php" class="display-block text-center m-t-md text-sm"></a>
                                        </form>
                                        <p class="text-center m-t-xs text-sm">2017&copy; AMK.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
        <!-- Javascripts -->
        <script src="../template/assets/plugins/jquery/jquery-3.2.1.min.js"></script>
        <script src="../template/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="../template/assets/plugins/pace-master/pace.min.js"></script>
        <script src="../template/assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../template/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="../template/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../template/assets/plugins/switchery/switchery.min.js"></script>
        <script src="../template/assets/plugins/uniform/js/jquery.uniform.standalone.js"></script>
        <script src="../template/assets/plugins/offcanvasmenueffects/js/classie.js"></script>
        <script src="../template/assets/plugins/waves/waves.min.js"></script>
        <script src="../template/assets/js/layers.min.js"></script>
    </body>
</html>