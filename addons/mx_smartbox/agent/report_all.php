<?php
require_once "Ischeck.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- Title -->
        <title><?php echo $cfg['title'];?> - 财务明细</title>        
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
								<?php							
								$data = [
									'table' => "financial",
									'field' => '*',
									'limit' => 10,
									'where' => 'aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
									'order' => "id desc"
								];
								$list = $ac->Select($data);
								
							//返回总行数
							$data2 = [
									'table' => "financial",
									'field' => 'id',
									'where' => 'aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
							];
							
							$total = $ac->getCount($data2);			
							$limit = 10;
							$p_count = ceil($total/$limit);
								
								?>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table-bordered" style="width:100%;line-height:35px;">
                                            <thead>
                                                <tr>
                                                    <th style="padding-left:5px;">序列</th>
													<th style="padding-left:5px;">设备号</th>
                                                    <th style="padding-left:5px;">金额</th>
													<th style="text-align:center;">商户号</th>
													<th style="padding-left:5px;">支付方式</th>
                                                    <th style="padding-left:5px;">消费说明</th>
                                                    <th style="text-align:center;">消费单号</th>
                                                    <th style="text-align:center;">时间</th>
                                                </tr>
                                            </thead>
                                            <tbody  id="box_list">
												<?php 
													if($list){												
													foreach($list as $k){
												?>
                                                <tr>
                                                    <th scope="row"  style="padding-left:5px;"><?php echo $k['id'];?></th>
													 <td  style="padding-left:5px;"><?php echo $k['device_code'];?></td>
                                                    <td  style="padding-left:5px;"><?php echo $k['pay_money'];?> 元</td>
													<td style="padding-left:5px;"><?php echo $k['mchid'];?></td>
													<td style="padding-left:5px;">
													<?php
													if($k['pay_type'] == 2){
														echo "微信扫码";
													}elseif($k['pay_type'] == 3){
														echo "支付宝扫码";
													}elseif($k['pay_type'] == 4){
														echo "积分支付";
													}elseif($k['pay_type'] == 5){
														echo "余额支付";
													}elseif($k['pay_type'] == 6){
														echo "<span style='color:green;'>账户充值</span>";
													}													
													?>													
													</td>
                                                    <td style="padding-left:5px;"><?php echo $k['remark'];?></td>
                                                    <td style="text-align:center;"><?php echo $k['out_trade_no'];?></td>
                                                    <td style="text-align:center;"><?php echo date("Y-m-d H:i:s",$k['times']); ?></td>
                                                </tr>
                                               <?php
														}
													}else{
												?>
												<tr>
                                                    <td colspan="8" style="text-align:center;">暂无记录</td>                                                   
                                                </tr>
												<?php
													}
												?>                                         
                                               
                                               
												</tbody>
												<tr>
													<td colspan="8">
													<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups" style="margin:0 auto;padding-top:10px;padding-bottom:10px;">
														<div class="btn-group" role="group" aria-label="First group">
															<?php
																for($k=0;$k<$p_count;$k++){
															?>
															<button type="button" class="btn btn-default btn_pg"><?php echo ($k+1);?></button>
															<?php
																}
															?>	
														</div>                                           
													 </div>
													</td>
												</tr>
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
								
								
                            </div>
                          
                        </div>                       
                    </div>
                </div>
					<?php require "copyright.php";?>
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
       
        <div class="cd-overlay"></div>	

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
        <script src="../template/assets/js/layers.min.js"></script>
        <script src="../template/assets/js/pages/profile.js"></script>
        
    </body>
</html>
<script>
$(function(){	
	//分页
		$(".btn_pg").click(function(){
			var index = $(this).text();
			$.post("ajax.php",{ac:'fpagebill',p:index,psize:10,aid:<?php echo $_SESSION['Id'];?>,uniacid:<?php echo $_SESSION['Uniacid'];?>,},function(response,status,xhr){
				$("#box_list").html(response);				
			},'html');	
		});
	
	
	
	
});


</script>