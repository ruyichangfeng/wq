<?php
require_once "Ischeck.php";
define("APPID",$cfg['appid']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- Title -->
        <title><?php echo $cfg['title'];?> -- 用户列表</title>        
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
                            <li class="active">用户列表</li>
                        </ol>
                    </div>
                </div>
                <div id="main-wrapper">
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel panel-white">                         
								<?php							
								$data = [
									'table' => "user",
									'field' => '*',
									'limit' => 10,
									'where' => 'aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
									'order' => "id desc"
								];
								$list = $ac->Select($data);
								
							//返回总行数
							$data2 = [
									'table' => "user",
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
													<th style="padding-left:5px;">头像</th>
                                                    <th style="padding-left:5px;">昵称</th>
													<th style="text-align:center;">余额</th>
													<th style="padding-left:5px;">积分</th>
													<th style="text-align:center;">时间</th>
                                                    <th style="text-align:center;">操作</th>
                                                </tr>
                                            </thead>
                                            <tbody  id="box_list">
												<?php 
													if($list){												
													foreach($list as $k){
												?>
                                                <tr>
                                                    <th scope="row"  style="padding-left:5px;"><?php echo $k['id'];?></th>
													 <td  style="padding-left:5px;"><img src="<?php echo $k['avatar'];?>" width="30" height="30"></td>
                                                    <td  style="padding-left:5px;"><?php echo $k['nickname'];?> </td>
													<td style="padding-left:5px;"><?php echo $k['money'];?></td>
													<td style="padding-left:5px;"><?php echo $k['integral'];?></td>
                                                    <td style="text-align:center;"><?php echo date("Y-m-d H:i:s",$k['regtime']); ?></td>
                                                    <td style="text-align:center;padding-top:3px;padding-bottom:3px;">
														&nbsp;&nbsp;
														<?php 
															if($k['isadmin'] == 1){
														?>
														<a href="?ac=upadmin&id=<?php echo $k['id'];?>&isad=<?php echo $k['isadmin'];?>" type="button" class="btn btn-danger" onclick="return confirm('确定取消管理员身份吗?')" >取消管理</a> 	
														<?php 														
															}else{
														?>
														<a href="?ac=upadmin&id=<?php echo $k['id'];?>&isad=<?php echo $k['isadmin'];?>" type="button" class="btn btn-default" onclick="return confirm('确定升级管理员吗?')" >升级管理员</a> 	
														<?php											
															}
														?>
														&nbsp;&nbsp;
														<?php 
															if($k['isvip'] == 1){
														?>
														<a href="?ac=upvip&id=<?php echo $k['id'];?>&isvi=<?php echo $k['isvip'];?>" type="button" class="btn btn-primary" onclick="return confirm('确定取消VIP吗?')" >取消VIP</a> 	
														<?php 														
															}else{
														?>
														<a href="?ac=upvip&id=<?php echo $k['id'];?>&isvi=<?php echo $k['isvip'];?>" type="button" class="btn btn-default" onclick="return confirm('确定升级VIP吗?')" >升级VIP</a> 	
														<?php											
															}
														?>
														&nbsp;&nbsp;
														<a href="?ac=update" type="button" class="btn btn-warning" onclick="return confirm('确定删除吗?')" >删除用户</a>
														&nbsp;&nbsp;
														
													</td>
                                                </tr>
                                               <?php
														}
													}else{
												?>
												<tr>
                                                    <td colspan="7" style="text-align:center;">暂无记录</td>                                                   
                                                </tr>
												<?php
													}
												?>  
												</tbody>
												<tr>
													<td colspan="7">
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
			$.post("ajax.php",{ac:'fpageuser',p:index,psize:10,aid:<?php echo $_SESSION['Id'];?>,uniacid:<?php echo $_SESSION['Uniacid'];?>,},function(response,status,xhr){
				$("#box_list").html(response);				
			},'html');	
		});
});
</script>
<?php
	//升级管理员
	if(isset($_GET['ac']) && $_GET['ac'] == 'upadmin'){
		$id =$_GET['id'];
		$isad = $_GET['isad'];		
		$data=[
			'table' => 'user',
			'where' => 'id = '.$id.' and aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
		];
		if($isad == 0){
			$value = [
				'isadmin' => 1,			
			];
		}elseif($isad == 1){
			$value = [
				'isadmin' => 0,			
			];
		}	
		$result =  $ac->Update($data,$value);
		if($result){
			$ac->success("设置成功！","user_list.php");
		}else{
			$ac->error("设置失败");
		}		
	}
	
	//升级VIP
	if(isset($_GET['ac']) && $_GET['ac'] == 'upvip'){
		$id =$_GET['id'];
		$isvi = $_GET['isvi'];		
		$data=[
			'table' => 'user',
			'where' => 'id = '.$id.' and aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
		];
		if($isvi == 0){
			$value = [
				'isvip' => 1,			
			];
		}elseif($isvi == 1){
			$value = [
				'isvip' => 0,			
			];
		}	
		$result =  $ac->Update($data,$value);
		if($result){
			$ac->success("设置成功！","user_list.php");
		}else{
			$ac->error("设置失败");
		}		
	}




?>