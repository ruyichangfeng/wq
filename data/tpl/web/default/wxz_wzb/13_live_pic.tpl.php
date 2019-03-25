<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>
		<!--模板设置-->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion"
					href="#collapse1">
					添加图文直播内容
				</a>
				</h4>
			</div>
			<div id="collapse1" class="panel-collapse collapse in">
				<form id="add_member" action="<?php  echo $this->createWebUrl('livePic')?>" method="post" enctype="multipart/form-data" class="form-horizontal ">
					<div class="panel-body">
						<div class="form-horizontal form">
							<input type="hidden" name="item" value="ajax">
							<input type="hidden" name="key" value="setting">
							<input type="hidden" name="publisher" class="form-control" value="<?php  echo $item['publisher'];?>">
							<input type="hidden" name="images" class="form-control" value="<?php  echo $item['images'];?>">
							<input type="hidden" name="rid" class="form-control" value="<?php  echo $rid;?>">
							<div class="form-group">
								<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="text-input">标题：：</label>
								<div class="col-sm-8 col-xs-12 col-md-9">
									<input type="text" id="caidantitle" name="title" class="form-control" value="<?php  echo $item['title'];?>" placeholder="标题">

								</div>
							</div>
							
							<div class="form-group">
								<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">文字内容</label>
								<div class="col-sm-8 col-xs-12 col-md-9">									
								<?php  echo tpl_ueditor("content",$item['content'])?>
								
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
								<div class="col-sm-9 col-xs-12">
									<button class="btn btn-primary" name="btn-setting" type="submit">提交</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!--模板设置-->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion"
					href="#collapse1">
					图文直播记录
				</a>
				</h4>
			</div>
			<div class="panel-body">
			<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>		
					<th align="center" style="width:40%;text-align:center;">标题</th>
                    <th align="center" style="width:30%;text-align:center;">内容</th>
					<th align="center" style="width:10%;text-align:center;">时间</th>
					<th align="center" style="width:10%;text-align:center;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($LivePic)) { foreach($LivePic as $row) { ?>
					<tr>
						<td align="center" style="text-align:center;"><?php  echo $row['title'];?></td>
                        <td align="center" style="text-align:center;"><?php  echo $row['content'];?></td>
						<td align="center" style=" text-align:center;"><?php  echo date('Y-m-d H:i',$row['dateline'])?></td>
						<td align="center" style=" text-align:center;">
						<a href="<?php  echo $this->createWebUrl('livePic',array('id' =>$row['id'],'rid' =>$rid))?>" class="btn btn-default">复制</a>
						<a href="<?php  echo $this->createWebUrl('livepicedit',array('id' =>$row['id'],'rid' =>$rid))?>" class="btn btn-default">编辑</a>
						<a href="<?php  echo $this->createWebUrl('delpic',array('id' =>$row['id'],'rid' =>$rid))?>" class="btn btn-default">删除</a></td>
					</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
			</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>