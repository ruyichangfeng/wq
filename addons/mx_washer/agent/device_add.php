<?php
require_once "Ischeck.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Title -->
        <title><?php echo $cfg['title'];?> - 添加设备入网</title>
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
                    <h3 class="breadcrumb-header">添加设备入网</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="index.php">首页</a></li>
                            <li class="active">添加设备入网</li>
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
                                    <form class="form-horizontal m-t-xs" method="post" action="">	
										<div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1 control-label">设备分类</label>
                                            <div class="col-sm-11">
												<select name="tid" style="height:35px;border:1px #ddd solid;width:30%;border-radius:2px;">
													<?php
														$data = [
															'table' => "types",
															'where' => 'aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
														];
														$list = $ac->Select($data); 
														foreach($list as $k){
															echo "<option value='".$k['id']."'>".$k['tname']."</option>";
														}
													?>
												</select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1 control-label">设备编号</label>
                                            <div class="col-sm-11">
                                                <input type="text" class="form-control check_device" name="device_code" required placeholder="填写设备编号……">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">计费单价</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="price" value="1" required class="password form-control" required  placeholder="普通用户单价……">
                                            </div>
                                        </div>
										 <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">VIP单价</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="vip_price" value="1" required class="password form-control" required  placeholder="VIP消费单价……">
                                            </div>
                                        </div>
										 <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">计价套餐</label>
                                            <div class="col-sm-11">
                                                <input type="text" name="package" value="1" required class="password form-control" required  placeholder="计费单价对应脉冲/继电器数量……">
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputPassword3" class="col-sm-1 control-label">定额消费</label>
                                            <div class="col-sm-11">
                                               <select name="isfixed" style="height:35px;border:1px #ddd solid;width:30%;border-radius:2px;">
													<option value="1">是</option>
													<option value="0">否</option>
											   </select>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1 control-label">设置区域</label>
                                            <div class="col-sm-11">
												<select name="area_id" style="height:35px;border:1px #ddd solid;width:30%;border-radius:2px;">
													<?php
														$data = [
															'table' => "area",
															'where' => 'aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
														];
														$list = $ac->Select($data); 
														foreach($list as $k){
															echo "<option value='".$k['id']."'>".$k['area_name']."</option>";
														}
													?>
												</select>
                                            </div>
                                        </div>										
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
												<input type="hidden" name="uniacid" value="<?php echo $_SESSION['Uniacid'];?>" >
												<input type="hidden" name="aid" value="<?php echo $_SESSION['Id'];?>">
                                                <button type="submit" class="btn btn-success m-t-xxs" name="sub">立即添加</button>
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
<script>
	$(function(){
		$(".check_device").blur(function(){
			var device_code = $(this).val(); 
			$.post("ajax.php",{ac:'check_device',device_name:device_code},function(response,status,xhr){
				if(response == 1){
					alert("设备已存在！！");
					return false
				}else{
					return true;
				}
			},'json');			
		});		
	});
</script>
<?php
	if(isset($_POST['sub'])){		
		$data = [
			'table' => 'device',
			'where' => 'device_code = "'.$_POST['device_code'].'"',
			'field' => 'id',
		];
		$result = $ac->Find($data);
		if($result){
			$ac->error("设备已存在！");
		}else{
         
		$tid = $_POST['tid'];	
			$aid = $_POST['aid'];
			$device_code = $_POST['device_code'];
			$uniacid = $_POST['uniacid'];
			$price = $_POST['price'];
			$vip_price = $_POST['vip_price'];
			$package = $_POST['package'];
			$area_id = $_POST['area_id'];
			$isfixed = $_POST['isfixed'];
			
			
			//检查设备名长度
			if(strlen($device_code) == 10){
				$pat="/^C[A-Z0-9]{9}/";
				if(!preg_match($pat,$device_code,$arr)){
				 $ac->error("设备识别码格式异常01！");	
				 exit;
				}
			}else{				
				 $ac->error("设备设别码格式异常02！");		
				 exit;
			}
			
			//系统配置通信字段
			$sys_data = [
				'table' => 'sysconfig',
				'where' => 'uniacid = "'.$uniacid.'"',				
			];
			$syscfg = $ac->Find($sys_data);        
			//远程存库
			$curl_data = [
				'action' => 'registered',
				'device_code' => $device_code,			
				'token' => $syscfg['tokens'],
				'appid' => $syscfg['appid'],			
			];
			$curl_url = $syscfg['apiurl']."/paycloud/Api.php";
           
			$rs_json = curl_request($curl_url,$curl_data);
			$rs_arr = json_decode($rs_json,true);
          
   
          
			if($rs_arr[0] == 'SUCCESS'){
				$data = [	
					'tid' => $tid,
					'aid' => $aid,
					'uniacid'=> $uniacid,					
					'device_code' => $device_code,
					'price' => $price,
					'vip_price' => $vip_price,
					'package' => $package,				
					'area_id' => $area_id,	
					'reg_date' => time(),
					'fid' => $rs_arr[1],
					'folder' => $rs_arr[2],
					'isfixed' => $isfixed,
					'status' => 0	
				];
				$result = $ac->Add("device",$data);
				if($result){
					$ac->success("设备入网成功！","device_list.php");
				}else{
					$ac->error("设备入网失败！");
				}
			}elseif($rs_arr[0] == 'ERROR'){
				switch($rs_arr[1]){
					case 1001:
						$ac->error("Appid或Tken异常");
					break;
					case 2001:
						$ac->error("设备编号格式异常");						
					break;
					case 2002:
						message("设备编号长度异常!",'refresh','error');	
						$ac->error("设备编号长度异常");
					break;
					case 2003:
						$ac->error("设备编号已存在");
					break;	
					case 2004:
						$ac->error("设备出库异常");
					break;				
					case "ERROR":
						$ac->error("设备远程联网失败");
					break;
				}
			}
			
			
			
		}
	}
	
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