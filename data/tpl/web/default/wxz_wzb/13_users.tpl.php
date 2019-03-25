<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
	</head>
	<body>
	<div class="main">
		<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>
		<div class="panel panel-info">
			<div class="panel-heading">筛选</div>
			<div class="panel-body">
				<form action="./index.php" method="get" class="form-horizontal" role="form">
					<input type="hidden" name="c" value="site" />
					<input type="hidden" name="a" value="entry" />
					<input type="hidden" name="m" value="wxz_wzb" />
					<input type="hidden" name="rid" value="<?php  echo $rid;?>" />
					<input type="hidden" name="do" value="users" />
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">昵称</label>
						<div class="col-xs-12 col-sm-8 col-lg-9">
							<input class="form-control" name="nickname" id="" type="text" value="<?php  echo $_GPC['nickname'];?>" placeholder="昵称">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">openid</label>
						<div class="col-xs-12 col-sm-8 col-lg-9">
							<input class="form-control" name="openid" id="" type="text" value="<?php  echo $_GPC['openid'];?>" placeholder="openid">
						</div>
					</div>
					<div class="form-group" style="text-align:right;">
						<div class="col-xs-12 col-sm-8 col-lg-11">
							<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
							<a class="btn btn-default" href="<?php  echo $this->createWebUrl('users',array('type' =>'all','rid'=>$rid))?>">全部</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!--模板设置-->
		<form action="./index.php" method="get" class="form-horizontal" role="form">
		<input type="hidden" name="c" value="site" />
		<input type="hidden" name="a" value="entry" />
		<input type="hidden" name="m" value="wxz_wzb" />
		<input type="hidden" name="rid" value="<?php  echo $rid;?>" />
		<input type="hidden" name="do" value="user_set" />
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion"
					href="#collapse1">
					观众列表
				</a>
				</h4>
			</div>
			<div class="panel-body">
			<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:3%;text-align:center;"></th>
					<th align="center" style="width:10%;text-align:center;">昵称</th>	
                    <th align="center" style="width:10%;text-align:center;">头像</th>
					<th align="center" style="width:10%;text-align:center;">总金额</th>
					<th align="center" style="width:10%;text-align:center;">已提现</th>
					<!-- <th align="center" style="width:10%;text-align:center;">openid</th> -->
					<th align="center" style="width:10%;text-align:center;">余额</th>
					<th align="center" style="width:10%;text-align:center;">时间</th>
					<th align="center" style="width:10%;text-align:center;">会员</th>
					<th align="center" style="text-align:center;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($Users)) { foreach($Users as $row) { ?>
					<tr>		
						<td><input class="check-delete tagids-<?php  echo $row['id'];?>" type="checkbox" name="users[]" value="<?php  echo $row['id'];?>" data-tagids="<?php  echo $row['groupid'];?>" data-openid="<?php  echo $row['openid'];?>" data-fanid="<?php  echo $row['id'];?>"/></td>
						<td align="center" style="text-align:center;"><?php  echo $row['nickname'];?></td>
                        <td align="center" style="text-align:center;"><img src="<?php  echo $row['headimgurl'];?>" width="60"></td>
                        <td align="center" style="text-align:center;"><?php  echo $row['amount']/100?>元</td>
                        <td align="center" style="text-align:center;"><?php  echo $row['deposit']/100?>元</td>
						<!-- <td align="center" style="text-align:center;"><?php  echo $row['sub_openid'];?></td> -->
                        <td align="center" style="text-align:center;"><?php  echo ($row['amount']-$row['deposit'])/100?>元</td>
						<td align="center" style="text-align:center;"><?php  echo date('Y-m-d H:i:s',$row['dateline'])?></td>
						<td align="center" style="text-align:center;"><?php  echo $row['cid'];?></td>
						<td align="center" style=" text-align:center;">
						<a href="<?php  echo $this->createWebUrl('help',array('uid' =>$row['id'],'rid'=>$rid))?>"><button type="button" class="btn btn-info" >查看助力详情</button>
						<a href="<?php  echo $this->createWebUrl('withdraw',array('uid' =>$row['id'],'rid'=>$rid))?>"><button type="button" class="btn btn-info" >提现详情</button></a>
						<a href="<?php  echo $this->createWebUrl('user_setting',array('uid' =>$row['id'],'rid'=>$rid))?>"><button type="button" class="btn btn-info" >设置</button></a>
                        <a class="btn btn-default" title="删除" href="<?php  echo $this->createWebUrl('user_del',array('id' =>$row['id']))?>" onclick="return confirm('删除用户且无法恢复，确认吗？');return false;">删除</a>
						</td>
					</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<table class="table table-hover">
				<tr>
					<td width="30">
						<input type="checkbox" onclick="var ck = this.checked;$('.check-delete').each(function(){this.checked = ck});" />
						
					</td>
					<td class="text-left" colspan="8">
						<?php  if(is_array($categorys)) { foreach($categorys as $row) { ?>
						<label><input type="checkbox" name="cid[]" value="<?php  echo $row['id'];?>" <?php  if(in_array($row['id'],$cid)) { ?>checked<?php  } ?>><?php  echo $row['title'];?></label>
						<?php  } } ?>
						<?php echo tpl_form_field_daterange('activity',array('start'=>date('Y-m-d H:i:s',empty($list['start_at'])?time():$list['start_at']),'end'=>date('Y-m-d H:i:s',empty($list['end_at'])?time()+3600*5:$list['end_at'])),true);?>
						<input type="submit" name="submit" class="btn btn-primary span2" value="分配" onclick="del()"/> &nbsp;
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					</td>
				</tr>

			</table>
			</form>
		<?php  echo $pager;?>
			</div>
		</div>
			</div>
		</div>
		
</div>
<script type="text/javascript">
			require(["daterangepicker"], function($){
				$(function(){
					$(".daterange.daterange-time").each(function(){
						var elm = this;
						$(this).daterangepicker({
							startDate: $(elm).prev().prev().val(),
							endDate: $(elm).prev().val(),
							format: "YYYY-MM-DD HH:mm",
							timePicker: true,
							timePicker12Hour : false,
							timePickerIncrement: 1,
							ranges: {
								'1个星期': [moment(), moment().add('days',7)],
								'1个月': [moment(), moment().add('month',1)],
								'3个月': [moment(), moment().add('month',3)],
								'半年': [moment(), moment().add('month',6)],
								'1年': [moment(), moment().add('year',1)],
								'2年': [moment(), moment().add('year',2)]
							},
							minuteStep: 1
						}, function(start, end){
							$(elm).find(".date-title").html(start.toDateTimeStr() + " 至 " + end.toDateTimeStr());
							$(elm).prev().prev().val(start.toDateTimeStr());
							$(elm).prev().val(end.toDateTimeStr());
						});
					});
				});
			});
		</script>';
	</body>
</html>