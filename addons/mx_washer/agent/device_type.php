<?php
require_once "Ischeck.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Title -->
        <title><?php echo $cfg['title'];?> - 接入设备管理</title>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
		<meta http-equiv="refresh" content="60">
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
    <body class="compact-menu">
        <?php require "header.php";?>      
		<?php require "menu.php";?>
            <div class="page-inner">
                <div class="page-title">
                    <h3 class="breadcrumb-header">设备分类管理</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="index.php">首页</a></li>                           
                            <li class="active">设备分类管理</li>
                        </ol>
                    </div>					
                </div>
				<?php		
				//当前首屏显示
				$where_Str ="";
				/* if(isset($_POST['serarch'])){					
					if(empty($_POST['device_code']) && $_POST['server_type'] ==0 && $_POST['server_status'] == 2){
						$where_Str .= "";
					}elseif(!empty($_POST['device_code'])){
						$where_Str .=" and ak_devicelist.device_name = '".$_POST['device_code']."'";
					}elseif($_POST['server_type'] == 0 && $_POST['server_status'] == 2){
						$where_Str .= "";
					}elseif($_POST['server_type'] !=0 && $_POST['server_status'] == 2){ 
						$where_Str .=" and ak_devicelist.server_type = ".$_POST['server_type']."";
					}elseif($_POST['server_type'] ==0 && $_POST['server_status'] != 2){
						$where_Str .=" and ak_devicelist.status = ".$_POST['server_status']."";
					}elseif($_POST['server_type'] !=0 && $_POST['server_status'] != 2){
						$where_Str .=" and ak_devicelist.status = ".$_POST['server_status']." and server_type=".$_POST['server_type']."";
					}
				}else{
					$where_Str .="";
				}	 */	
				$where_Str .="";	
				$data = [
					'table' => "types",
					'field' => '*',
					'where' => 'aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',					
					'order' => "id desc"	
				];
				$list = $ac->Select($data);	

				foreach($list as $k=>$v){
					$data2 = [
						'table' => "device",
						'field' => 'id',
						'where' => 'tid = '.$v['id'].' and aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',	
						
					];
					$total = $ac->getCount($data2);
					$list[$k]['count'] = $total;
				}
				
				
				
				
				?>
                <div id="main-wrapper">
                    <div class="row">                    
                        <div class="col-md-12">
                            <div class="panel panel-white">
								 <div class="panel-heading clearfix" style="margin-bottom:10px;">
                                    <a href="type_add.php" type="button" class="btn btn-warning" style="float:right;" >添加设备分类</a>
                                </div>
								
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table-bordered table-hover" style="width:100%;line-height:40px;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:Center;">ID</th>
                                                    <th style="text-align:Center;">分类名称</th>   
													<th style="text-align:Center;">设备数量</th>  													
                                                    <th style="text-align:Center;">操作</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody id="box_list">
												<?php 
													if($list){												
													foreach($list as $k){
												?>
                                                <tr>
                                                    <td  align="center"><?php echo $k['id'];?></td>                                                   
													<td  align="center"><?php echo $k['tname'];?></td>
													<td  align="center"><?php echo $k['count'];?> 台</td>
                                                    <td  style="text-align:center;">
													&nbsp;
													<a href="type_edit.php?id=<?php echo $k['id'];?>" type="button" class="btn btn-info">编辑</a> 
													&nbsp;&nbsp;
													<a href="?ac=del&id=<?php echo $k['id'];?>" onclick="return confirm('确定删除该条记录?')" class="btn btn-danger">删除</a>
													</td>
                                                </tr>
												<?php
														}
													}else{
												?>
												<tr>
                                                    <td colspan="4" style="text-align:center;">暂无记录</td>                                                   
                                                </tr>
												<?php
													}
												?>
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
		<?php
			if(isset($_GET['ac']) && $_GET['ac'] == 'del'){
				$id= $_GET['id'];
				$data=[
					    'table' => "types",
						'where' => 'id = '.$id.' and aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
					];
					$result = $ac->Del($data);
					if($result){
						$ac->success("删除成功！","device_type.php");
					}else{
						$ac->error("删除失败！");
				}
			}
			
			
			
			
			
			
		?>
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
	<!-- 付款二维码 Modal- -->
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
	//设备检测
	$(".checksta").click(function(){
		var fid = $(this).attr('alt');
		$.post("ajax.php",{ac:'checkSta','fid':fid,uniacid:<?php echo $_SESSION['Uniacid'];?>},function(response,status,xhr){
			 if(response == 1){
				 alert('设备在线');
			 }else if(response == 0){
				 alert('设备离线');
			 }else if(response == 2){
				 alert('新设备请入网！');
			 }
		},'json');	
	});
		//分页
		$(".btn_pg").click(function(){
			var index = $(this).text();
			$.post("ajax.php",{ac:'fpage',p:index,psize:10,aid:<?php echo $_SESSION['Id'];?>,uniacid:<?php echo $_SESSION['Uniacid'];?>,where_str:"<?php echo $where_Str;?>"},function(response,status,xhr){
				$("#box_list").html(response);				
			},'html');		
		});
		//搜索
		$(".input_device_code").focus();		
		$(".input_device_code").change(function(){
			var value = $(this).val();
			$(".select_server_type").attr("disabled",true);
			$(".select_server_status").attr("disabled",true);
		});
		$(".select_server_type").change(function(){
			$(".input_device_code").attr("disabled",true);
		});
		$(".select_server_status").change(function(){
			$(".input_device_code").attr("disabled",true);
		});
	});
</script>
<?php

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