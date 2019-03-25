<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- Title -->
        <title>智能云后台管理系统-- 消费明细</title>        
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
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="index.php">首页</a></li>
                            <li class="active">财务明细报表</li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">消费记录</h4>
                                </div>
								<div class="panel-body">
                                    <form class="form-inline">
										<div class="form-group">财务记录检索：</div>
                                        <div class="form-group">
                                            <input type="text" class="form-control"  placeholder="输入代理商姓名……">
                                        </div>
										<div class="form-group">
                                            <select name="password" class="password form-control">
											  <option value="" selected>全部明细记录</option>
											  <option value="">自营财务明细</option>
											  <option value="">代理商财务明细</option>
											</select>
                                        </div>
										<div class="form-group">
                                            <select name="password" class="password form-control">
											  <option value="" selected>所有支付方式</option>
											  <option value="">微信支付</option>
											  <option value="">支付宝支付</option>
											   <option value="">余额支付</option>
											</select>
                                        </div>
										<div class="form-group">
                                            <select name="password" class="password form-control">
											  <option value="" selected>所有消费类型</option>
											  <option value="">消费记录</option>
											  <option value="">充值记录</option>
											</select>
                                        </div>
										<div class="form-group">
                                            <select name="password" class="password form-control">
											  <option value="" selected>选择报表周期</option>
											  <option value="">周内报表</option>
											  <option value="">月度报表</option>
											</select>
                                        </div>
										
                                       
                                        <button type="submit" class="btn btn-info">立即检索</button>
                                    </form>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table-bordered" style="width:100%;line-height:35px;">
                                            <thead>
                                                <tr>
                                                    <th style="padding-left:5px;">序列</th>
                                                    <th style="padding-left:5px;">代理商</th>
													<th style="padding-left:5px;">设备号</th>
													<th style="padding-left:5px;">金额</th>
                                                    <th style="padding-left:5px;">商户号</th>
                                                    <th style="padding-left:5px;">支付方式</th>
                                                    <th style="padding-left:5px;">支付说明</th>
													<th style="padding-left:5px;">消费单号</th>
													<th style="padding-left:5px;">时间</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											   <?php  if(is_array($list)) { foreach($list as $index => $item) { ?>
                                                <tr>
                                                    <th scope="row"  style="padding-left:5px;"><?php  echo $item['id'];?></th>
                                                    <td  style="padding-left:5px;"><?php  echo $item['true_name'];?></td>
													<td style="padding-left:5px;"><?php  echo $item['device_code'];?></td>
													<td style="padding-left:5px;"><?php  echo $item['pay_money'];?> 元</td>
                                                    <td style="padding-left:5px;"><?php  echo $item['mchid'];?></td>
                                                    <td style="padding-left:5px;">
													<?php  if($item['pay_type'] == 2) { ?>
													微信扫码
													<?php  } else if($item['pay_type'] == 3) { ?>
													支付宝
													<?php  } else if($item['pay_type'] == 4) { ?>
													积分支付
													<?php  } else if($item['pay_type'] == 5) { ?>
													余额支付
													<?php  } else if($item['pay_type'] == 6) { ?>
													 <span style='color:green'>账户充值</span>
													<?php  } ?>
													</td>
													<td style="padding-left:5px;"><?php  echo $item['remark'];?></td>
													<td style="padding-left:5px;"><?php  echo $item['out_trade_no'];?></td>
                                                    <td style="padding-left:5px;"><?php  echo date("Y-m-d H:i:s",$item['times'])?></td>
                                                </tr>
                                               <?php  } } ?>  
												<tr>
												<td colspan="9">
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
								
								
                            </div>
                          
                        </div>                       
                    </div>
                </div>
				<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('copyright', TEMPLATE_INCLUDEPATH)) : (include template('copyright', TEMPLATE_INCLUDEPATH));?>
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
       
        <div class="cd-overlay"></div>
	

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
        <script src="<?php echo MODULE_URL;?>template/assets/js/layers.min.js"></script>
        <script src="<?php echo MODULE_URL;?>template/assets/js/pages/profile.js"></script>
        
    </body>
</html>