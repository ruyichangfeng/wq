<?php
require_once "Ischeck.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title><?php echo $cfg['title'];?> --- 入口地址</title>
        
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
        <link href="../template/assets/plugins/datatables/css/jquery.datatables.min.css" rel="stylesheet" type="text/css"/>	
        <link href="../template/assets/plugins/datatables/css/jquery.datatables_themeroller.css" rel="stylesheet" type="text/css"/>	
        <link href="../template/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css"/>
        
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
	<?php
	if($cfg['ishttps'] == 1){
		$http = 'https';
	}else{
		$http = 'http';
	}
	//WX 管理员地址
	$admin_url = $http."://".$_SERVER['HTTP_HOST']."/app/index.php?i=".$cfg['uniacid']."&aid=".$cfg['aid']."&c=entry&do=index&m=mx_washer";

	//WX 用户地址
	$user_url = $http."://".$_SERVER['HTTP_HOST']."/app/index.php?i=".$cfg['uniacid']."&aid=".$cfg['aid']."&c=entry&do=mindex&m=mx_washer";
	
	
	$cid = $cfg['uniacid'];
	
	?>
    <body class="compact-menu">
			<?php require "header.php";?>      
			<?php require "menu.php";?>
            <div class="page-inner">
                <div class="page-title">
                    <h3 class="breadcrumb-header">入口地址</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="{php echo $this->createWeburl('default')}">首页</a></li>                           
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
                                                    <td  style="padding-left:15px;">WX管理员入口</td>
													<td  style="padding-left:15px;"><?php echo $admin_url;?>
													&nbsp;&nbsp;&nbsp;													
													<button href="#" alt="<?php echo $admin_url;?>"  title="微信管理员入口" type="button" class="btn btn-warning qrcode_btn"  data-toggle="modal" data-target="#myModal">二维码</button>
													</td>
                                                </tr>                                               
												<tr>
                                                    <td  style="padding-left:15px;">WX用户地址</td>
													<td  style="padding-left:15px;"><?php echo $user_url;?>
													&nbsp;&nbsp;&nbsp;
													<button alt="<?php echo $user_url;?>" title="微信用户入口" type="button" class="btn btn-warning qrcode_btn"  data-toggle="modal" data-target="#myModal">二维码</button>
													
													</td>
                                                </tr>												
                                            </tbody>
											
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
               <?php require "copyright.php";?>
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
        <!-- 二维码 Modal- -->
	   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				 <div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title" id="myModalLabel">设备<span class="qr_device"></span>付款码 --- <span style="font-size:14px;font-weight:normal;color:red;">直接右击保存二维码即可</span></h3>
					</div>
					<div class="modal-body">
						   <!-- <div id="main" style="margin:0 auto;">  
								<div class="demo" style="width:512px;height:512px;margin:0 auto;">       
									<div id="code"></div>
								</div>   
							</div>  -->
							<div id="qrcode" style="width:512px;height:512px;margin:0 auto;"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-info" data-dismiss="modal">关闭</button>
					</div>
				</div>
			</div>
		</div>	
	<!-- 付款二维码 Modal--end- -->
	

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
        <script src="../template/assets/plugins/datatables/js/jquery.datatables.min.js"></script>
        <script src="../template/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="../template/assets/js/layers.min.js"></script>
		<!--<script src="../template/assets/plugins/qrcode/jquery.qrcode.min.js"></script>-->
        <!--<script src="../template/assets/js/pages/table-data.js"></script>-->
		<script src="../template/assets/plugins/qrcode/qrcode.js"></script>
        
    </body>
</html>
<script>
	$(function(){
			
			
				//二维码
	$(".qrcode_btn").click(function(){		
		var qr_url = $(this).attr('alt');
		console.log(qr_url);
		var device_code = $(this).attr('title');
		$(".qr_device").text(device_code);
		var qrcode = new QRCode('qrcode', {
			width : 512,
			height : 512,
			colorDark: '#000'
		});
		function makeCode () {      
			var QrCodeUrl =  qr_url;
			qrcode.makeCode(QrCodeUrl);
		}
		makeCode();
	});	
	$('#myModal').on('hidden.bs.modal', function (e) {	  
		location.reload();	
	})
		
		
		
		
		
		
	});

</script>