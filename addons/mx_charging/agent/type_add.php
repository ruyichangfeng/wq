<?php
require_once "Ischeck.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Title -->
        <title><?php echo $cfg['title'];?> - 添加设备分类</title>
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
        <link href="../template/assets/plugins/slidepushmenus/css/component.css" rel="stylesheet" type="text/css"/>
        <link href="../template/assets/plugins/summernote-master/summernote.css" rel="stylesheet" type="text/css"/>
        <link href="../template/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css"/>
        <link href="../template/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css"/>
        <link href="../template/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
        <link href="../template/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css"/>
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
    </head>
    <body class="compact-menu">
        <?php require "header.php";?>      
		<?php require "menu.php";?>
            <div class="page-inner">
                <div class="page-title">
                    <h3 class="breadcrumb-header">添加设备分类</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="index.php">首页</a></li>
                            <li class="active">添加设备分类</li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">                        
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <!--<div class="panel-heading clearfix">
                                    <h4 class="panel-title">Horizontal Form</h4>
                                </div>-->
                                <div class="panel-body">
                                    <form class="form-horizontal m-t-xs" method="post" action="">										
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1 control-label">分类名称</label>
                                            <div class="col-sm-11">
                                                <input type="text" class="form-control" name="tname" required placeholder="填写设备分类名称……">
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
												<input type="hidden" name="appid" value="<?php echo $cfg['appid'];?>" >
												<input type="hidden" name="uniacid" value="<?php echo $_SESSION['Uniacid'];?>" >
												<input type="hidden" name="aid" value="<?php echo $_SESSION['Id'];?>">
                                                <button type="submit" class="btn btn-success m-t-xxs" name="sub">立即添加</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
                <?php require "copyright.php";?>
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
        <script src="../template/assets/plugins/3d-bold-navigation/js/main.js"></script>
        <script src="../template/assets/plugins/summernote-master/summernote.min.js"></script>
        <script src="../template/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="../template/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script src="../template/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
        <script src="../template/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
        <script src="../template/assets/js/layers.min.js"></script>
        <script src="../template/assets/js/pages/form-elements.js"></script>
    </body>
</html>

<?php
	if(isset($_POST['sub'])){		
		
			$aid = $_POST['aid'];
			$appid = $_POST['appid'];
			$tname = $_POST['tname'];
			$uniacid = $_POST['uniacid'];		
			
			
			$data = [			
					'aid' => $aid,
					'appid' => $appid,
					'uniacid'=> $uniacid,					
					'tname' => $tname,					
				];
				$result = $ac->Add("types",$data);
				if($result){
					$ac->success("设备分类添加成功！","device_type.php");
				}else{
					$ac->error("设备分类添加失败！");
				}
			

	}
	
	//CURL
 function curl_request($url,$data = null){			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			if (!empty($data)){
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			}
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($curl);
			curl_close($curl);
			return $output;
}	
	
	

?>