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
                    <h3 class="breadcrumb-header">接入设备管理</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="index.php">首页</a></li>                           
                            <li class="active">接入设备管理</li>
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
					'table' => "device,ims_xc_area",
					'field' => 'ims_xc_device.id as  did,device_code,isfixed,vip_price,tid,price,folder,package,area_id,fid,status,reg_date,ims_xc_area.id,area_name',
					'where' => 'ims_xc_device.area_id=ims_xc_area.id and  ims_xc_device.aid='.$_SESSION['Id'].' and ims_xc_device.uniacid='.$_SESSION['Uniacid'].'',
					'limit' => 10,
					'order' => "ims_xc_device.id desc"	
				];
				$list = $ac->Select($data);	

				//读取设备分类
				foreach($list as $k=>$v){
					$type_data = [
						'table' => 'types',
						'where' => 'id = '.$v['tid'].'',
					];
					$type_rs = $ac->Find($type_data);		
					$list[$k]['tname'] = $type_rs['tname'];
				}
				

				
				//API远程 --- 更新状态数据-----
				$fid_list = "";
				foreach($list as $k){
					$fid_list .= $k['fid'].",";					
				}
				 //系统配置通信字段
			   $sys_data = [
					'table' => 'sysconfig',
					'where' => 'uniacid = '.$cfg['uniacid'].'',
				];
				$syscfg = $ac->Find($sys_data);			   
				//远程存库
				$curl_data = [
					'action' => 'reupdate',		
					'token' => $syscfg['tokens'],
					'appid' => $syscfg['appid'],
					'fidlist' => trim($fid_list,",")
				];		
				$curl_url = $syscfg['apiurl']."/paycloud/Api.php";
				$rs_json = curl_request($curl_url,$curl_data);
				$rs_arr = json_decode($rs_json,true);		
				if($rs_arr[0] == 'SUCCESS'){
					$status_arr = explode(",",$rs_arr[1]); //远程返回状态数组
					$fid_arr = explode(",",trim($fid_list,","));
					//循环更新状态，根据上面的fid的顺序					
					for($i=0;$i<count($fid_arr);$i++){			
						$data=[
							'table' => 'device',
							'where' => 'fid = '.$fid_arr[$i].'',
						];
						$value = [
							'status' => $status_arr[$i],						
						];
						$ac->Update($data,$value);
					}	
				}				
				//API远程 --- 更新 end
				//返回总行数
					$data2 = [
						'table' => "device",
						'field' => 'id',
					];
				$total = $ac->getCount($data2);			
				$limit = 10;
				$p_count = ceil($total/$limit);
				//echo $p_count;
				?>
                <div id="main-wrapper">
                    <div class="row">                    
                        <div class="col-md-12">
                            <div class="panel panel-white">
								 <div class="panel-heading clearfix" style="margin-bottom:10px;">
                                    <a href="device_add.php" type="button" class="btn btn-warning" style="float:right;" >添加设备接入</a>
                                </div>
								<div class="panel-body">
                                    <form class="form-inline" method="post" action="">
										<div class="form-group">设备检索：</div>
                                        <div class="form-group">
                                            <input type="text" name="device_code" class="form-control input_device_code"  placeholder="输入设备编号……">
                                        </div>
										<div class="form-group">
                                            <select name="server_type"  class="password form-control select_server_type">
											  <option value="0" selected>选择服务器</option>
											  <?php
														$server_data = [
															'table' => "deviceserver",
														];
														$server_result = $ac->Select($server_data); 
														foreach($server_result as $t){
															echo "<option value='".$t['id']."'>".$t['servername']."</option>";
														}
													?>
											</select>
                                        </div>
										<div class="form-group">
                                            <select name="server_status" class="password form-control select_server_status">
											  <option value="2" selected>选择状态</option>
											  <option value="1">在线设备</option>
											  <option value="0">离线设备</option>
											</select>
                                        </div>                                       
                                        <input type="submit" class="btn btn-info" name="serarch" value="立即检索">
                                    </form>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table-bordered table-hover" style="width:100%;line-height:40px;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:Center;">ID</th>
                                                    <th style="text-align:Center;">设备名称</th>  
													<th style="text-align:Center;">设备分类</th>													
													<th style="text-align:Center;">所属区域</th>													
                                                    <th style="text-align:Center;">[普价 | VIP | 脉冲]</th>
													<th style="text-align:Center;">设备状态</th>
													<th style="text-align:Center;">入网时间</th>
                                                    <th style="text-align:Center;">操作</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody id="box_list">
												<?php 
													if($list){												
													foreach($list as $k){
												?>
                                                <tr>
                                                    <td  align="center"><?php echo $k['did'];?></td>
                                                    <td  align="center">													
													<?php
													if($k['isfixed'] == 1){
														echo '<span style="color:green;font-size:12px;">'.$k['device_code'].'</span>';
													}else{
														echo $k['device_code'];
													}
													?>
													</td>
													<td  align="center"><?php echo $k['tname'];?></td>
													<td  align="center"><?php echo $k['area_name'];?></td>
													<td  align="center">
													<?php
													if($k['folder'] == 'paycloud'){
														echo $k['price']."|"."<span style=\"color:red;\">". $k['vip_price'].'</span> / '.$k['package'].'个';
													}else{
														
													}
													
													?>
													
													</td>
													<td  align="center">
													<?php
													if($k['status'] == 1){
														echo '<span style="color:green">在线</span>';
													}else{
														echo '<span style="color:#999">离线</span>';
													}													
													?>													
													</td>
													<td  align="center"><?php echo date("Y-m-d H:i:s",$k['reg_date']);?></td>
                                                    <td  style="text-align:center;">
													<a href="#" alt="<?php echo $k['fid'].'-'.$k['did'];?>"  type="button" class="btn btn-default checksend" >设备调试</a> 
													&nbsp;
													<a href="#" alt="<?php echo $k['fid'].'-'.$k['did'];?>"  type="button" class="btn btn-warning checksta" >状态检测</a> 
													&nbsp;
													<?php 
													
													if($cfg['ishttps'] == 1){
														$http = 'https';
													}else{
														$http = 'http';
													}
																										
													$QrCodeUrlurl = $http.'://'.$_SERVER['SERVER_NAME'].'/addons/mx_charging/agent/qrcode.php?state='.$_SESSION['Id'].'_'.$_SESSION['Uniacid'].'_'.$k['did']."";

													?>
													<a href="#" alt="<?php echo $QrCodeUrlurl;?>" title="<?php echo $k['device_code'];?>" type="button" class="btn btn-primary qrcode_btn"  data-toggle="modal" data-target="#myModal">付款码</a> 
													&nbsp;
													<a href="device_edit.php?id=<?php echo $k['did'];?>" type="button" class="btn btn-info">编辑</a> 
													&nbsp;&nbsp;
													<a href="?ac=del&ctr=<?php echo $k['did'].'-'.$k['fid'];?>" onclick="return confirm('确定删除该条记录?')" class="btn btn-danger">删除</a>
													</td>
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
																for($k=0;$k<=$p_count;$k++){
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
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
                <?php require "copyright.php";?>
            </div><!-- Page Inner -->
        </main><!-- Page Content -->      	
		<?php
			//删除设备，需要同步远程，先删除远程，在删除本地
			if(isset($_GET['ac']) && $_GET['ac']= 'del'){
				$ctr =explode("-",$_GET['ctr']);
				$id = $ctr[0];
				$fid = $ctr[1];
				//API远程 --- 删除设备-----
				 //系统配置通信字段
			   $sys_data = [
					'table' => 'sysconfig',
					'where' => 'uniacid = '.$cfg['uniacid'].'',
				];
				$syscfg = $ac->Find($sys_data);			   
				//远程存库
				$curl_data = [
					'action' => 'device_delate',		
					'token' => $syscfg['tokens'],
					'appid' => $syscfg['appid'],
					'fid' => $fid
				];		
				$curl_url = $syscfg['apiurl']."/paycloud/Api.php";
				$rs_json = curl_request($curl_url,$curl_data);
				$rs_arr = json_decode($rs_json,true);							
				//API远程 --- 删除 end
				if($rs_arr[0] =='SUCCESS'){ //远程删除成功
					$data=[
						'table' => "device",
						'where' => 'id = '.$id.' and aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
					];
					$result = $ac->Del($data);
					if($result){
						$ac->success("删除成功！","device_list.php");
					}else{
						$ac->error("本地设备删除失败！");
					}
				}elseif($rs_arr[0] =='ERROR'){ //远程删除失败
					if($rs_arr[1] == '3000'){
						$ac->error("删除失败！远程响应操作失败！");
					}else{
						$ac->error("删除失败！未知错误！");
					}
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
    $(document).on('click','.qrcode_btn',function(){
	//$(".qrcode_btn").click(function(){		
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
	//设备检测是否在线
    $(document).on('click','.checksta',function(){  
	//$(".checksta").click(function(){
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
	
	//设备发包测试
     $(document).on('click','.checksend',function(){  
	//$(".checksend").click(function(){
		var fid = $(this).attr('alt');
        //检测是否在线，在线则发包
      $.post("ajax.php",{ac:'checkSta','fid':fid,uniacid:<?php echo $_SESSION['Uniacid'];?>},function(response,status,xhr){
			 if(response == 1){
					$.post("ajax.php",{ac:'checksend','fid':fid,uniacid:<?php echo $_SESSION['Uniacid'];?>},function(response,status,xhr){          	
                      if(response == 1){
                           alert('发送成功');
                       }else if(response == 0){
                           alert('发送失败');
                       }
                  },'json');               
			 }else if(response == 0){
				 alert('设备离线，发送失败！');
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