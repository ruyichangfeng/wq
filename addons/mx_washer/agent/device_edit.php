<?php
require_once "Ischeck.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Title -->
        <title><?php echo $cfg['title'];?> - 编辑入网设备</title>
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
                    <h3 class="breadcrumb-header">编辑入网设备</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="index.php">首页</a></li>
                            <li class="active">编辑入网设备</li>
                        </ol>
                    </div>
                </div>
				<?php
					if(isset($_GET['id']) && !empty($_GET['id'])){
						$id =$_GET['id'];
						$data = [
							'table' => 'device',
							'where' => 'id = '.$id.' and aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
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
                                            <label for="inputEmail3" class="col-sm-1 control-label">设备服务分类</label>
                                            <div class="col-sm-11">
													<select name="area_id" style="height:35px;border:1px #ddd solid;width:30%;border-radius:2px;">
													<?php
														$data = [
															'table' => "area",
															'where' => 'aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
														];
														$list = $ac->Select($data); 
														foreach($list as $k){
															if($k['id'] == $result['area_id']){
																echo "<option selected value='".$k['id']."'>".$k['area_name']."</option>";
															}else{
																echo "<option value='".$k['id']."'>".$k['area_name']."</option>";
															}
															
														}
													?>
												</select>
											
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1 control-label">是否定额消费</label>
                                            <div class="col-sm-11">
												<select name="isfixed" style="height:35px;border:1px #ddd solid;width:30%;border-radius:2px;">
													<?php
														if($k['isfixed'] == 1){
															echo '<option value="1" selected>是</option>';
														}else{
															echo '<option value="1">是</option>';
														}
														if($k['isfixed'] == 0){
															echo '<option value="0" selected>否</option>';
														}else{
															echo '<option value="0">是</option>';
														}
													?>
												
												</select>
											
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1 control-label">接入设备名称</label>
                                            <div class="col-sm-11">
                                                <input type="text" class="form-control check_device" name="device_code" value="<?php echo $result['device_code'];?>" required placeholder="填写设备编号……">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">计费单价</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="price" value="<?php echo $result['price'];?>" required class="password form-control" required  placeholder="输入普通用户每次消费金额……">
                                            </div>
                                        </div>
										 <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">VIP单价</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="vip_price" value="<?php echo $result['vip_price'];?>" required class="password form-control" required  placeholder="输入VIP用户每次消费金额……">
                                            </div>
                                        </div>
										 <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">套餐设置</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="package" value="<?php echo $result['package'];?>"  required class="password form-control" required  placeholder="计费单价对应脉冲数量……">
                                            </div>
                                        </div>											
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
												<input type="hidden" value="<?php echo $result['id'];?>" name="id">
												<input type="hidden" name="uniacid" value="<?php echo $_SESSION['Uniacid'];?>" >
												<input type="hidden" name="aid" value="<?php echo $_SESSION['Id'];?>">
                                                <button type="submit" class="btn btn-success m-t-xxs" name="sub">提交表单</button>
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
			'table' => 'device',
			'where' => 'id = '.$_POST['id'].' and aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
		];
		
		$value = [
			'area_id' => $_POST['area_id'],
			'device_code' => $_POST['device_code'],
			'price' => $_POST['price'],
			'vip_price' => $_POST['vip_price'],
			'package' => $_POST['package'],
			'isfixed' => $_POST['isfixed'],
		];
		$result =  $ac->Update($data,$value);
		if($result){
			$ac->success("编辑成功！","device_list.php");
		}else{
			$ac->error("编辑失败");
		}
		
	}

?>