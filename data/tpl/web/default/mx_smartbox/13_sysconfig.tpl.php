<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>智能云后台管理系统 -- 系统配置</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Lalassu" />
        
        <!-- Styles -->
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/uniform/css/default.css" rel="stylesheet"/>
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>	
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>	
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>	
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>	
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/slidepushmenus/css/component.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/summernote-master/summernote.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css"/>
        
        <!-- Theme Styles -->
        <link href="<?php echo MODULE_URL;?>template/assets/css/layers.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo MODULE_URL;?>template/assets/css/layers/dark-layer.css" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="<?php echo MODULE_URL;?>template/assets/css/custom.css" rel="stylesheet" type="text/css"/>
        
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body class="compact-menu">
        <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
		<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('menu', TEMPLATE_INCLUDEPATH)) : (include template('menu', TEMPLATE_INCLUDEPATH));?>
            <div class="page-inner">
                <div class="page-title">
                    <h3 class="breadcrumb-header">系统配置</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="<?php  echo $this->createWeburl('default')?>">首页</a></li>
                            <li class="active">系统配置</li>
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
                                    <form class="form-horizontal" role="form" action="" method="POST">                                     
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">API通信秘钥</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="tokens" value="<?php  echo $conf['tokens'];?>" class="password form-control" placeholder="输入API通信秘钥……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">API通信地址</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="apiurl" value="<?php  echo $conf['apiurl'];?>" class="password form-control" placeholder="输入API通信地址.http/https开头,以 / 结尾……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">是否Https</label>
                                            <div class="col-sm-11">
												<select name="ishttps" class="password form-control">
													<?php  if($conf['ishttps'] == 0) { ?>
														<option value="0" selected  >否</option>
														<option value="1"  >是</option>
													<?php  } else { ?>
														<option value="0"   >否</option>
														<option value="1" selected >是</option>
													<?php  } ?>
													
												</select>
                                                
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">APPID</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="appid" value="<?php  echo $conf['appid'];?>" class="password form-control" placeholder="输入运营服务商APPID…………">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">Appsecrect</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="appsecrect" value="<?php  echo $conf['appsecrect'];?>" class="password form-control" placeholder="输入运营服务商appsecrect……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">Mchid</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="mchid" value="<?php  echo $conf['mchid'];?>" class="password form-control" placeholder="输入Mchid商户号……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">Wxkey</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="wxkey" value="<?php  echo $conf['wxkey'];?>" class="password form-control" placeholder="输入wxkey……">
                                            </div>
                                        </div>
										
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
												<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                                                <input type="submit" class="btn btn-success m-t-xxs" name="submit" value="保存设置">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                       
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
                <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('copyright', TEMPLATE_INCLUDEPATH)) : (include template('copyright', TEMPLATE_INCLUDEPATH));?>
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
        
	

        <!-- Javascripts -->
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/jquery/jquery-3.2.1.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/pace-master/pace.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/switchery/switchery.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/uniform/js/jquery.uniform.standalone.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/offcanvasmenueffects/js/classie.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/waves/waves.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/3d-bold-navigation/js/main.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/summernote-master/summernote.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/js/layers.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/js/pages/form-elements.js"></script>
		<script src="<?php echo MODULE_URL;?>template/assets/js/jscolor.min.js"></script>
		
     <script>
	function setTextColor(picker) {
		//document.getElementsByTagName('body')[0].style.color = '#' + picker.toString()
	}
	</script>
    </body>
</html>