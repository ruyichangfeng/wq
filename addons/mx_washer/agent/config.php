<?php
require_once "Ischeck.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title><?php echo $cfg['title'];?> - 系统配置</title>        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Lalassu" />        
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
                    <h3 class="breadcrumb-header">系统配置</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="index.php">首页</a></li>
                            <li class="active">系统配置</li>
                        </ol>
                    </div>
                </div>
				<?php
					//查询该代理商信息
					$ag_data = [
						'table' => 'agent',
						'where' => 'id = '.$_SESSION['Id'].' and uniacid ='.$_SESSION['Uniacid'].'',
						'field' => 'ispay',
					];
					$ag_rs = $ac->Find($ag_data);	
					//读取系统表是否https
					$sys_data = [
						'table' => 'sysconfig',
						'where' => 'uniacid ='.$_SESSION['Uniacid'].'',
						'field' => 'ishttps',
					];
					$sys_rs = $ac->Find($sys_data);

					
					
					//查询代理商配置信息
					$data = [
						'table' => 'config',
						'where' => 'aid = '.$_SESSION['Id'].' and uniacid ='.$_SESSION['Uniacid'].'',
					];
					$result = $ac->Find($data);
					if(!$result){ //如果不存在，添加
						$data = [
							'aid' => $_SESSION['Id'],
							'uniacid' => $_SESSION['Uniacid'],
						];
						$ac->Add("config",$data);						
					}
					
					if(isset($_POST['submit'])){
						$title = $_POST['title'];
						$bgcolor = $_POST['bgcolor'];					
						$hotline = $_POST['hotline'];
						$vip_price = $_POST['vip_price'];
						$appid = $_POST['appid'];
						$appsecrect = $_POST['appsecrect'];
						$mchid = $_POST['mchid'];
						$wxkey = $_POST['wxkey'];
						$alimail = $_POST['alimail'];
						$aliparent = $_POST['aliparent'];
						$alikey = $_POST['alikey'];						
						
						$data2=[
							'table' => 'config',
							'where' => 'aid = '.$_SESSION['Id'].' and uniacid ='.$_SESSION['Uniacid'].'',
						];
						$value = [
							'title' => $title,
							'bgcolor' => $bgcolor,
							'ispay' => $ag_rs['ispay'],
							'ishttps' => $sys_rs['ishttps'],
							'hotline' => $hotline,
							'vip_price' => $vip_price,
							'appid' => $appid,
							'appsecrect' => $appsecrect,
							'mchid' => $mchid,
							'wxkey' => $wxkey,
							'alimail' => $alimail,
							'aliparent' => $aliparent,
							'alikey' => $alikey,
						];
						$rs =  $ac->Update($data2,$value);
						if($rs){
							$ac->success("编辑成功！","config.php");
						}else{
							$ac->error("编辑失败！");
						}
						
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
                                   <form class="form-horizontal" role="form" action="" method="POST">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1 control-label">运营商名称</label>
                                            <div class="col-sm-11">
                                                <input type="text" class="form-control" name="title" value="<?php echo $result['title']?>" required placeholder="输入运营商名称……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1 control-label">用户中心背景</label>
                                            <div class="col-sm-11">
												<?php 
													if($result['bgcolor'] <> ""){
												?>
												<input type="text" class="form-control jscolor" name="bgcolor" value="<?php echo $result['bgcolor'];?>" required placeholder="选择或输入用户中心背景……">
												<?php 
													}else{
												?>
												<input type="text" class="form-control jscolor" name="bgcolor" value="63B8FF" required placeholder="选择或输入用户中心背景……">
												<?php
													}
												?>                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">客服电话</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="hotline" required value="<?php echo $result['hotline'];?>" class="password form-control"  placeholder="输入客服联系电话……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">升级VIP价格</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="vip_price" required value="<?php echo $result['vip_price'];?>" class="password form-control"  placeholder="输入用户自主升级VIP价格……">
                                            </div>
                                        </div>										
                                       <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">APPID</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="appid" class="password form-control" value="<?php echo $result['appid'];?>" placeholder="输入公众号Appid……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">Appsecret</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="appsecrect" value="<?php echo $result['appsecrect'];?>" class="password form-control" placeholder="输入公众号Appsecret……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">MCHID</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="mchid" class="password form-control" value="<?php echo $result['mchid'];?>" placeholder="输入微信商家商户号……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">WXKEY</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="wxkey" class="password form-control" value="<?php echo $result['wxkey'];?>" placeholder="输入微信支付秘钥……">
                                            </div>
                                        </div>
										<!--<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label" style="color:Red;">支付宝账户</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="alimail" class="password form-control" value="<?php //echo $result['alimail'];?>" placeholder="收款支付宝邮箱账号……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label" style="color:Red;">支付宝身份ID</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="aliparent" class="password form-control" value="<?php //echo $result['aliparent'];?>" placeholder="以2088开头由16位纯数字组成字符串……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label"style="color:Red;">支付宝秘钥</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="alikey" class="password form-control" value="<?php //echo $result['alikey'];?>" placeholder="由字母和数字组成的32位字符串……">
                                            </div>
                                        </div>-->										
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">												
												<input type="hidden" name="id" value="<?php echo $result['id'];?>" />
                                                <input type="submit" class="btn btn-success m-t-xxs" name="submit" value="保存设置">
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
        <script src="../template/assets/js/jscolor.min.js"></script>
    </body>
</html>
<script>
	$(function(){
		
		
		
		
	});
</script>