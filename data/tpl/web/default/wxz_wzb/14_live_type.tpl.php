<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>
<div class="panel panel-default">
	<div class="panel-heading" style="position:relative;">
				<span>直播栏目管理</span>		<span style="position:absolute;right:10px;top:3px;">			<a href="<?php  echo $this->createWebUrl('live_type',array('rid'=>$rid))?>" class="btn btn-default">				栏目类别			</a>		</span>
	</div>
	<div class="panel-body">
		<table  class="table table-striped">
			<thead>
				<tr>
					<th style="width:20%;">类型</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						iframe嵌入(谨慎使用部分页面不兼容)
					</td>
					<td style="overflow:visible">
						<a class="btn btn-default" title="增加" href="<?php  echo $this->createWebUrl('live_edit',array('rid'=>$rid,'type'=>1))?>">
							<i class="fa fa-plus"></i>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						图文信息介绍
					</td>
					<td style="overflow:visible">
						<a class="btn btn-default" title="增加" href="<?php  echo $this->createWebUrl('live_edit',array('rid'=>$rid,'type'=>2))?>">
							<i class="fa fa-plus"></i>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						聊天区
					</td>
					<td style="overflow:visible">
						<a class="btn btn-default" title="增加" href="<?php  echo $this->createWebUrl('live_edit',array('rid'=>$rid,'type'=>3))?>">
							<i class="fa fa-plus"></i>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						图文直播
					</td>
					<td style="overflow:visible">
						<a class="btn btn-default" title="增加" href="<?php  echo $this->createWebUrl('live_edit',array('rid'=>$rid,'type'=>4))?>">
							<i class="fa fa-plus"></i>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						榜单
					</td>
					<td style="overflow:visible">
						<a class="btn btn-default" title="增加" href="<?php  echo $this->createWebUrl('live_edit',array('rid'=>$rid,'type'=>5))?>">
							<i class="fa fa-plus"></i>
						</a>
					</td>
				</tr>
				<tr>
					<td>
						地图
					</td>
					<td style="overflow:visible">
						<a class="btn btn-default" title="增加" href="<?php  echo $this->createWebUrl('live_edit',array('rid'=>$rid,'type'=>6))?>">
							<i class="fa fa-plus"></i>
						</a>
					</td>
				</tr>
				<?php  if(pdo_tableexists('wxz_lzl_goods')) { ?>
				
				<tr>
					<td>
						商城
					</td>
					<td style="overflow:visible">
						<a class="btn btn-default" title="增加" href="<?php  echo $this->createWebUrl('live_edit',array('rid'=>$rid,'type'=>7))?>">
							<i class="fa fa-plus"></i>
						</a>
					</td>
				</tr>
				<?php  } ?>
			</tbody>
		</table>
		
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>