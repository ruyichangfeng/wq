<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading">
		<?php  if(!empty($menus['id'])) { ?>编辑<?php  } else { ?>新增<?php  } ?>菜单
	</div>
	<div class="panel-body">
		<form action="" method="post" class="form-horizontal" role="form" id="form1" >
					<input type="hidden" name="type" value="<?php  echo $type;?>">
					<div style="clear:both"></div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">是否显示</label>
						<div class="col-sm-8 col-lg-10 col-xs-12">
							<label class="radio-inline">
								<input type="radio" name="isshow" value="1"  <?php  if($menus['isshow'] == '1') { ?>checked="true"<?php  } ?>>是
							</label>
							<label class="radio-inline">
								<input type="radio" name="isshow" value="0"   <?php  if($menus['isshow'] == '0') { ?>checked="true"<?php  } ?>>否
							</label>
							<span class="help-block">是否显示</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">排序序号</label>
						<div class="col-sm-8 col-lg-10 col-xs-12">
							<input type="text" value="<?php  echo $menus['sort'];?>" class="form-control" name="sort">
							<span class="help-block">排序序号</span>
						</div>
					</div>
					<?php  if($type==5) { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">榜单列表</label>
						<div class="col-sm-8 col-xs-12">
							<label class="checkbox-inline"><input type="checkbox" name="list[1]" value="邀请榜" <?php  if(in_array('邀请榜',$menus['settings']['list'])) { ?>checked<?php  } ?>>邀请榜</label>
							<label class="checkbox-inline"><input type="checkbox" name="list[2]" value="打赏榜" <?php  if(in_array('打赏榜',$menus['settings']['list'])) { ?>checked<?php  } ?>>打赏榜</label>
							<label class="checkbox-inline"><input type="checkbox" name="list[3]" value="金额榜" <?php  if(in_array('金额榜',$menus['settings']['list'])) { ?>checked<?php  } ?>>金额榜</label>
							<label class="checkbox-inline"><input type="checkbox" name="list[4]" value="助力榜" <?php  if(in_array('助力榜',$menus['settings']['list'])) { ?>checked<?php  } ?>>助力榜</label>
							<label class="checkbox-inline"><input type="checkbox" name="list[5]" value="点赞榜" <?php  if(in_array('点赞榜',$menus['settings']['list'])) { ?>checked<?php  } ?>>点赞榜</label>
						</div>
					</div>
					<?php  } ?>
					<div class="form-group">
							  <label class="col-xs-12 col-sm-2 col-md-2  col-lg-2 control-label">菜单名称</label>
							  <div class="col-sm-9 col-lg-10">
										  <input type="text" name="name" value="<?php  echo $menus['name'];?>" class="form-control">
								  <span class="help-block">菜单名称</span>
							  </div>
					 </div>
					 
					 <?php  if($type==1) { ?>
					<div class="form-group" <?php  if($type!='1') { ?>style="display: none"<?php  } ?>>
							  <label class="col-xs-12 col-sm-2 col-md-2  col-lg-2 control-label">链接地址</label>
							  <div class="col-sm-9 col-lg-10">
										  <input type="text" name="iframe" value="<?php  echo $menus['settings']['iframe'];?>" class="form-control">
								  <span class="help-block">链接可以直接在直播页打开</span>
							  </div>
					 </div>
					<?php  } ?>
					<?php  if($type==2) { ?>
					<div class="form-group" <?php  if($type!='2') { ?>style="display: none"<?php  } ?>>
								<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">内容详情</label>
								<div class="col-sm-9 col-lg-10">
									<?php  echo tpl_ueditor('content',$menus['settings']['content'])?>
									<span class="help-block">直播详情介绍</span>
								</div>
					</div>	
					<?php  } ?>
					<?php  if($type==7) { ?>
					<div class="form-group" <?php  if($type!='7') { ?>style="display: none"<?php  } ?>>
								<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">商城ID</label>
								<div class="col-sm-9 col-lg-10">
									<input type="text" name="mch_id" value="<?php  echo $menus['settings']['mch_id'];?>" class="form-control">
									<span class="help-block">商城ID</span>
								</div>
					</div>	
					<?php  } ?>
					<?php  if($type==6) { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">地图坐标</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<div class="input-group" style="width:400px;">
								<div class="input-group-addon">经度</div>
								<input type="text" class="form-control" name="longitude" value="<?php  echo $menus['settings']['longitude'];?>" >
								<span class="input-group-addon">纬度</span>
								<input type="text" class="form-control " name="latitude" value="<?php  echo $menus['settings']['latitude'];?>" >
							</div>
							<span class="help-block">经纬度请通过下面坐标拾取器获取</span>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">坐标拾取器</label>
						<div class="col-sm-9 col-lg-10">
							
							<iframe src="http://lbs.qq.com/tool/getpoint/getpoint.html" width='100%' height="740px" frameborder="0"></iframe>
						</div>
					</div>
					<?php  } ?>

					<div style="clear:both"></div>

			<div class="form-group">
			<div class="col-sm-12">
				<input name="submit" type="submit" value="提交" class="btn btn-primary" />
				<input type="hidden" name="id" value="<?php  echo $menus['id'];?>" />
				<input type="hidden" name="rid" value="<?php  echo $rid;?>" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
			</div>
	</div>
	</form>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>