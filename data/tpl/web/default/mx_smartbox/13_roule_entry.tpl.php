<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>智能云后台管理系统-- 入口地址</title>
        
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
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/datatables/css/jquery.datatables.min.css" rel="stylesheet" type="text/css"/>	
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/datatables/css/jquery.datatables_themeroller.css" rel="stylesheet" type="text/css"/>	
        <link href="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css"/>
        
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
                    <h3 class="breadcrumb-header">入口地址</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="<?php  echo $this->createWeburl('default')?>">首页</a></li>                           
                            <li class="active">入口地址</li>
                        </ol>
                    </div>					
                </div>
                <div id="main-wrapper">
                    <div class="row">                    
                        <div class="col-md-12">
                            <div class="panel panel-white">								 
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table-bordered table-hover" style="width:100%;line-height:40px;">
                                            <thead>
                                                <tr>
                                                    <th style="padding-left:15px;">入口名称</th>
                                                    <th style="padding-left:15px;">入口地址</th>                                                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                               <tr>
                                                    <td  style="padding-left:15px;">PC代理商入口</td>
													<td  style="padding-left:15px;"><?php  echo $pc_agent_url;?></td>
                                                </tr>
																							
                                            </tbody>
											
                                        </table>
                                    </div>
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
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/datatables/js/jquery.datatables.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/js/layers.min.js"></script>
        <!--<script src="<?php echo MODULE_URL;?>template/assets/js/pages/table-data.js"></script>-->
        
    </body>
</html>