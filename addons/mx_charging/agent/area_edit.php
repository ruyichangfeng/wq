<?php
require_once "Ischeck.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Title -->
        <title><?php echo $cfg['title'];?> - 编辑区域</title>
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
                    <h3 class="breadcrumb-header">编辑区域</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="index.php">首页</a></li>
                            <li class="active">编辑区域</li>
                        </ol>
                    </div>
                </div>
				<?php
					if(isset($_GET['id']) && !empty($_GET['id'])){
						$id =$_GET['id'];
						$data = [
							'table' => 'area',
							'where' => 'id = '.$id,
							'field' => '*',
						];
						$result = $ac->Find($data);
					}else{
						$ac->error("参数异常！无记录！");
					}				
				?>
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
                                            <label for="inputEmail3" class="col-sm-1 control-label">区域名称</label>
                                            <div class="col-sm-11">
                                                <input type="text" class="form-control" name="area_name" required value="<?php echo $result['area_name'];?>" placeholder="添加区域名称……">
                                            </div>
                                        </div>
                                       <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">经度纬度</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="latitu" value="<?php echo $result["latitu"];?>" class="password form-control" placeholder="输入区域经纬度……">
												<p style="margin-top:15px;"><span style='color:red;'>非必填</span>查询目标区域经纬度 <a href="http://www.gpsspg.com/maps.htm" target="blank">http://www.gpsspg.com/maps.htm</a></p>
                                            </div>
                                        </div>										
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
												<input type="hidden" name="id" value="<?php echo $result['id'];?>">
												<input type="hidden" name="appid" value="<?php echo $cfg['appid'];?>">
												<input type="hidden" name="uniacid" value="<?php echo $_SESSION['Uniacid'];?>" >
												<input type="hidden" name="aid" value="<?php echo $_SESSION['Id'];?>">
                                                <button type="submit" class="btn btn-success m-t-xxs" name="sub">提交表单</button>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">详细地址</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="address" value="<?php echo $result['address'];?>" required class="password form-control" placeholder="填写区域详细地址……">
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
		$data=[
			'table' => 'area',
			'where' => 'id = '.$_POST['id'].' and aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
		];
		$value = [
			'area_name' => $_POST['area_name'],
			'latitu' => $_POST['latitu'],
			'address' => $_POST['address'],			
		];
		
		$result =  $ac->Update($data,$value);
		if($result){
			$ac->success("编辑成功！","area_list.php");
		}else{
			$ac->error("编辑失败");
		}
		 
	}

?>