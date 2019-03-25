<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/nav', TEMPLATE_INCLUDEPATH)) : (include template('web/nav', TEMPLATE_INCLUDEPATH));?>
<style>
	.supportImg{width:15px;vertical-align:top;margin-left:10px}
	.footer2{
		width: 88%;
		height: 60px;
		position: fixed;
		background: #66CCCC;
		border-top: 1px solid #ccc;
		right:0;
		bottom: 0;
		overflow: hidden;
	}
	.footer2>div{width: 33%;float: left;line-height: 60px;text-align: center;color: #fff;font-weight: bold}
	#sureBtn{
		background: #FF6600;
		padding: 6px 20px;
		color: #fff;
		border-radius: 3px;
		cursor: pointer;
	}
</style>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo $this->createWebUrl('all');?>">所有活动报名管理</a></li>
</ul>
<div class="main">

		<div class="panel panel-info">
		<div class="panel-heading">筛选</div>

		<div class="panel-body">

			<form action="./index.php" method="get" class="form-horizontal" role="form">

				<input type="hidden" name="c" value="site" />
				<input type="hidden" name="a" value="entry" />
	        	<input type="hidden" name="m" value="jy_signup_a" />
	        	<input type="hidden" name="do" value="all" />

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">时间筛选</label>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<?php  echo tpl_form_field_daterange('time', $time);?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">活动选择</label>
					<div class="col-xs-12 col-sm-8 col-lg-9">
						<select name="hdid" class="form-control">
							<option value="0">请选择活动</option>
							<?php  if(is_array($hd_all)) { foreach($hd_all as $h) { ?>
							<option value="<?php  echo $h['id'];?>" <?php  if($h['id']==$_GPC['hdid']) { ?>selected<?php  } ?>><?php  echo $h['hdname'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>

				<div class="form-group">
				 	<div class=" col-xs-12 col-sm-2 col-lg-2">

						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>

					</div>
				</div>
			</form>
		</div>
    	</div>


		<div class="panel panel-default">
			<div class="panel-heading">活动报名人员详细数据  |  总数:<?php  echo count($list)?> <a href="<?php  echo $this->createWebUrl('allexport',array('time'=>$_GPC['time'],'hdid'=>$_GPC['hdid'],'keyword'=>$_GPC['keyword']))?>"><span style="margin-left:200px" class="btn btn-default">导出数据</span></a></div>
			<div class="panel-body table-responsive">

			    <form action="" method="post" onsubmit="">

				<table class="table">

					<thead class="navbar-inner">

						<tr>
							<th  style="width:1%;"></th>
							<th  style="width:8%;">用户头像</th>
							<th  style="width:8%;">用户昵称</th>
							<th style="width:8%;">活动名称</th>
							<th style="width:8%;">用户手机</th>
							<th style="width:8%;">商户订单号</th>
							<th  style="width:26%;">报名信息</th>
							<th style="width:8%;">报名时间</th>
							<th style="width:8%;">费用/积分</th>
							<th  style="width:10%;">评论</th>
							<th>操作</th>
						</tr>

					</thead>
					<tbody id="main">
						<?php  if(is_array($list)) { foreach($list as $item) { ?>

						<tr class="selectedTr" >
							<td>
								<input style="display:none" type="checkbox" name="ids[]" value="<?php  echo $item['id'];?>" />		<!---->
							</td>
							<td><?php  if($item['type']==2) { ?><img style="width:70px" src="<?php  echo tomedia($item['thumb'])?>"><?php  } else { ?><img style="width:70px" src="<?php  echo $_W['attach_url'];?><?php  echo $item['avatar'];?>"><?php  } ?></td>
				            <td style="white-space:normal; word-break:break-all;overflow:hidden">
								<p><?php  echo $item['nicheng'];?></p>
				            </td>
				            <td style="white-space:normal; word-break:break-all;overflow:hidden">
								<?php  echo $item['hdname'];?>
				            </td>
							<td>
								<p><?php  echo $item['mobile'];?></p>
							</td>
							<td style="white-space:normal; word-break:break-all;overflow:hidden"><?php  echo $item['uniontid'];?></td>
							<td style="white-space:normal; word-break:break-all;overflow:hidden">
								<?php  if(!empty($item['zl'])) { ?>
									<?php  $i=1;?>
									<?php  if(is_array($item['zl'])) { foreach($item['zl'] as $row) { ?>
									<div style="white-space:normal"><?php  echo $i;?>、<?php  echo $row['name'];?> : <?php  if($row['type']!=8) { ?><?php  echo $row['zhi'];?><?php  } else { ?>
										<?php  $row['zhi'] = explode(',',$row['zhi'])?>
										<?php  if(is_array($row['zhi'])) { foreach($row['zhi'] as $k => $r) { ?>
									 <a class='btn btn-xs btn-info bigphoto' rel="lightbox[<?php  echo $row['name'];?>]" src="<?php  echo tomedia($r)?>">图片<?php  echo $k+1?></a>
									 <?php  } } ?>
									<?php  } ?></div>
									<?php  $i++?>
									<?php  } } ?>
								<?php  } else { ?>
									<div style="color:orange">未填写资料</div>
								<?php  } ?>
							</td>
							<td style="white-space:normal; word-break:break-all;overflow:hidden">
								<?php  echo date('Y-m-d H:i',$item['createtime'])?>
							</td>
							<td>
								<?php  if($item['price']>0) { ?>
								<p style="color:red"><?php  echo $item['price'];?> 元</p>
								<?php  } else { ?>
									<?php  if($item['jifen']>0) { ?>
									<p style="color:orange"><?php  echo $item['jifen'];?> 积分</p>
									<?php  } else { ?>
									<p>无</p>
									<?php  } ?>
								<?php  } ?>
							</td>
							<td>
							<?php  if(!empty($item['pl'])) { ?>
								<?php  $i=1;?>
								<?php  if(is_array($item['pl'])) { foreach($item['pl'] as $row) { ?>
								<div style="white-space:normal"><?php  echo $i;?>、<?php  echo $row['description'];?> <?php  if(!empty($row['num'])) { ?> <img class="supportImg" src="../addons/jy_signup_a/images/icon-agree-on.png"/><?php  echo $row['num'];?><?php  } ?></div>
								<?php  $i++?>
								<?php  } } ?>
							<?php  } else { ?>
								<div style="color:orange">未发表评论</div>
							<?php  } ?>
							</td>
							<td>
								 <a href="<?php  echo $this->createWebUrl('delmember',array('id'=>$item['cid']))?>" class="btn btn-xs btn-danger">删除</a>
							</td>
						</tr>
						<?php  } } ?>
					</tbody>
				</table>
				<?php  echo $pager;?>
				</form>
		    </div>
		</div>

</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">图片展示</h4>
      </div>
      <div class="modal-body">
         <img  id="mimng" alt="" width="100%;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
<script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script>
require(['bootstrap'], function(){
			$('#myModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) // Button that triggered the modal
			  var src = button.data('src') // Extract info from data-* attributes
			  $("#mimng").attr('src',src);
			})
	})
</script>

<script>
  $(function(){
		  $(".bigphoto").click(function(){
				 var href = $(this).attr('src');
				 $("#boxpic").find('img').attr('src',href);
				 $("#garbox").show();
			   $("#boxpic").show();
				  return false;
			})
			$("#garbox").click(function(){
				$("#garbox").hide();
				$("#boxpic").hide();
			})
	})
</script>

<style>
  #garbox{
  	 background: #000;
		 opacity: 0.5;
		 width: 100%;
		 height: 100%;
		 position: fixed;
		 top:0;
		 left:0;
		 z-index: 9998;
		 display: none;
  }
	#boxpic{
		position: fixed;
    margin: 0 auto;
    z-index: 9998;
    top: 4%;
    left: 0;
    bottom: 0;
    right: 0;
    width: 60%;
    max-height: 84%;
    border-radius: 8px;
    background: #fff;
		display: none;
	}
	#boxpic img{
		height: 100%;
    padding: 15px;
    margin: 0 auto;
    display: block;
	}
</style>
<div id="garbox"></div>
<div id="boxpic">
	 <img src="http://wx.12580life.com.cn/attachment/images/11/2016/09/I7wkoC47Xw5XWS7x304CKs034pxzxw.jpeg" alt="">
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
