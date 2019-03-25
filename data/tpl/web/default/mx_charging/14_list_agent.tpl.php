<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>智能云后台管理系统-- 代理商列表</title>
        
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
                    <h3 class="breadcrumb-header">代理商用户列表</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="<?php  echo $this->createWeburl('default')?>">首页</a></li>                           
                            <li class="active">代理商</li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">                    
                        <div class="col-md-12">
                            <div class="panel panel-white"> 
                              	<div class="panel-heading clearfix" style="margin-bottom:10px;">
                                    <a href="<?php  echo $this->createWeburl('add_agent')?>" type="button" class="btn btn-warning" style="float:right;" >添加代理商</a> 
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table-bordered table-hover" style="width:100%;line-height:60px;">
                                            <thead>
                                                <tr>
                                                  	<th style="text-align:left;padding-left:10px;">ID</th>   
                                                    <th style="text-align:left;padding-left:10px;">用户昵称</th> 
													<th style="text-align:left;padding-left:10px;">支付方式</th>	
                                                    <th style="text-align:left;padding-left:10px;">真实姓名</th>
                                                    <th style="text-align:left;padding-left:10px;">联系电话</th>
													<th style="text-align:left;padding-left:10px;">登录密码</th>
													<th style="text-align:left;padding-left:10px;">设备总数</th>
													<th style="text-align:center;">注册时间</th>
                                                    <th style="text-align:center;">操作</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                              	<?php  if(is_array($list)) { foreach($list as $index => $item) { ?>
                                               <tr>
                                                 	<td style="padding-left:10px;"><?php  echo $item['id'];?></td>
                                                    <td style="padding-left:10px;"><?php  echo $item['user'];?></td>
													<td style="padding-left:10px;">
													<?php  if($item['ispay'] == '1') { ?>
														<span style="color:red;">服务商支付</span>
													<?php  } else { ?>
														微信独立支付
													<?php  } ?>
													</td>
                                                    <td style="padding-left:10px;"><?php  echo $item['true_name'];?></td>
													<td style="padding-left:10px;"><?php  echo $item['tel'];?></td>
													<td style="padding-left:10px;"><?php  echo $item['pwd'];?></td>
                                                    <td  style="text-align:center;"> <?php  echo $item['num_count'];?> 台</td>
                                                    <td  style="text-align:center;"><?php  echo date("Y-m-d H:i:s",$item['reg_time']);?></td>
                                                    <td  style="text-align:center;">													
													<a href="<?php  echo $this->createWeburl('index_agent',array('id'=>$item['id']))?>" type="button" class="btn btn-info">查看代理</a> 
													&nbsp;&nbsp;													
													<a type="button"  href="<?php  echo $this->createWeburl('list_agent',array('op'=> 'del','id'=>$item['id']))?>" class="btn btn-danger"  onclick="return confirm('确定删除该记录吗?')" >删除代理</a>
													</td>
                                                </tr>
												<?php  } } ?>                                               
                                            </tbody>											
											<tr>
												<td colspan="7">
													<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups" style="margin:0 auto;padding-top:20px;padding-bottom:10px;">
														<div class="btn-group" role="group" aria-label="First group">
															<a type="button" href="<?php  if($page==1) echo $pages[0]['url']; else echo $pages[$page-2]['url']?>" class="btn btn-info"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
															<a type="button"  href="<?php  echo $pages[0]['url'];?>" class="btn btn-default">首页</a>
															<?php  if(is_array($pages)) { foreach($pages as $index => $item) { ?>
															<?php  if($index >= 2 && $index <=($page-7)) { ?>
																<?php  if($index == 2) { ?>
																	<a type="button" class="btn btn-default">...</a>
																<?php  } ?>
															<?php  } else if($index <= (count($pages)-3) && $index >= ($page+4)) { ?>
																<?php  if($index == ($page+4)) { ?>
																	<a type="button" class="btn btn-default">...</a>
																<?php  } ?>
															<?php  } else { ?>												
																<a href="<?php  echo $item['url'];?>" type="button" <?php  if($_GPC['page']==$item['index']) { ?>class="btn btn-default active"<?php  } else { ?> class="btn btn-default"<?php  } ?> class="btn btn-default"><?php  echo $item['index'];?></a>
															<?php  } ?>
														<?php  } } ?>
															<a type="button" href="<?php  echo $pages[count($pages)-1]['url']?>" class="btn btn-default">尾页</a>
															<a type="button" href="<?php  if($page==count($pages)) echo $pages[count($pages)-1]['url']; else echo $pages[$page]['url']?>" class="btn btn-info"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
														</div>                                           
													 </div>
												</td>
											</tr>
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