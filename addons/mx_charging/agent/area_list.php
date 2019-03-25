<?php
require_once "Ischeck.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- Title -->
        <title><?php echo $cfg['title'];?> - 区域列表</title>        
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
    <body class="compact-menu">
        <?php require "header.php";?>      
		<?php require "menu.php";?>
            <div class="page-inner">
                <div class="page-title">
                    <h3 class="breadcrumb-header">区域列表</h3>
                    <div class="page-breadcrumb">
                        <ol class="breadcrumb breadcrumb-with-header">
                            <li><a href="index.php">首页</a></li>                           
                            <li class="active">区域列表</li>
                        </ol>
                    </div>					
                </div>
				<?php
				$data = [
					'table' => "area",
					'field' => '*',
					'limit' => 50,
					'where' => 'aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
					'order' => "id desc"
				];
				$list = $ac->Select($data); 

				foreach($list as $k=>$v){
					 $data2 = [
						'table' => "device",
						'field' => 'id',
						'where' => 'area_id ='.$v['id'].''
					];
					$count = $ac->getCount($data2);	
					
					
					if($count > 0){
						$list[$k]['num_count'] = $count;	
					}else{
						$list[$k]['num_count'] = 0;
					}					
				} 
				
				
				?>
                <div id="main-wrapper">
                    <div class="row">                    
                        <div class="col-md-12">
                            <div class="panel panel-white">
								 <div class="panel-heading clearfix" style="margin-bottom:10px;">
                                    <a href="area_add.php" type="button" class="btn btn-warning" style="float:right;" >添加区域</a> 
                                </div>	
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table-bordered table-hover" style="width:100%;line-height:40px;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:Center;">ID</th>
                                                    <th style="text-align:Center;">区域名称</th>   
													<th style="text-align:Center;">坐标位置</th>													
                                                    <th style="text-align:Center;">详细地址</th>
													<th style="text-align:Center;">设备数量</th>													
                                                    <th style="text-align:Center;">操作</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php 
													if($list){												
													foreach($list as $k){
												?>
                                                <tr>
                                                    <td  align="center"><?php echo $k['id'];?></td>
                                                    <td  align="left">&nbsp;<?php echo $k['area_name'];?></td>
													<td  align="center"><?php echo $k['latitu'];?></td>
													<td  align="left">&nbsp;<?php echo $k['address'];?></td>
													<td  align="center"> <?php echo $k['num_count'];?> 台</td>										
                                                    <td  style="text-align:center;">
													<a href="area_edit.php?id=<?php echo $k['id'];?>" type="button" class="btn btn-info">编辑</a> 
													&nbsp;&nbsp;													
													<a href="?ac=del&id=<?php echo $k['id'];?>" onclick="return confirm('确定删除该条记录?')" class="btn btn-danger">删除</a>
													</td>
                                                </tr>
												<?php
														}
													}else{
												?>
												<tr>
                                                    <td colspan="6" style="text-align:center;">暂无记录</td>                                                   
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
			if(isset($_GET['ac']) && $_GET['ac']= 'del'){
				$id =$_GET['id'];
				$data=[
					'table' => "area",
					'where' => 'id = '.$id.' and aid='.$_SESSION['Id'].' and uniacid='.$_SESSION['Uniacid'].'',
				];
				$result = $ac->Del($data);
				if($result){
					$ac->success("删除成功！","area_list.php");
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
        <!--<script src="../template/assets/js/pages/table-data.js"></script>-->
        
    </body>
</html>