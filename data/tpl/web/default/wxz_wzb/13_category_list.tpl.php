<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
.editable-click, a.editable-click {
    color: #000 !important;
    border-bottom:none !important;
    text-decoration: none;
}
.editable-input.editable-has-buttons {
    width: auto;
    max-width: 100px;
}
.st-sort-ascent:before {
    content: '\25B2';
}
</style>
<!-- 项目管理 -->
<div class="panel panel-default">
	<div class="panel-heading" style='position:relative;'>
		<span>项目管理</span>
		<span style="position:absolute;right:10px;top:3px;">
			<a href="<?php  echo $this->createWebUrl('category_edit', array('pid' => 0))?>" class="btn btn-default">
				新增直播分类
			</a>
		</span>
	</div>
	<div class="panel-body">
		<form action="" method="post" onsubmit="return formcheck(this)">
		<div class="panel panel-default">
		<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th style="width:5%; text-align:center;">显示顺序</th>
					<th style="width:15%;">分类名称</th>
					<th style="width:5%; text-align:center;">是否显示</th>
					<th style="width:25%; text-align:center;">是否外链</th>
					<th style="width:5%; text-align:center;">日期</th>
					<th style="width:15%; text-align:center">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php  if(is_array($categorys)) { foreach($categorys as $row) { ?>
				<tr>
					<td class="text-center">
						<input type="text" class="form-control" name="sort[<?php  echo $row['id'];?>][sort]}]" value="<?php  echo $row['sort'];?>">
					</td>
					<td class="text-left"><div style="height:30px;line-height:30px"><?php  echo $row['title'];?>&nbsp;&nbsp;<?php  if(empty($row['parentid'])) { ?><a href="<?php  echo $this->createWebUrl('wlive', array('cid' =>$row['id']))?>" title="添加子分类"><i class="fa fa-plus"></i> 添加外链直播间</a><?php  } ?></div></td>
					<td class="text-center"><?php echo $row['isshow'] ? '是' : '否'?></td>
					<td class="text-center">否</td>
					<td class="text-center"><?php  echo date('Y-m-d H:i:s',$row['dateline'])?></td>
					<td class="text-center" >
						<a class="btn btn-default" title="编辑" href="<?php  echo $this->createWebUrl('category_edit',array('id'=>$row['id']))?>">
							<i class="fa fa-gear"></i>
						</a>
						<a class="btn btn-default" title="删除" href="<?php  echo $this->createWebUrl('category_del',array('id'=>$row['id']))?>" onclick="return confirm('删除将删除该分类下直播间的所有信息且无法恢复，确认吗？');return false;">
							<i class="fa fa-times"></i>
						</a>
					</td>
				</tr>
				<?php  if(is_array($children[$row['id']])) { foreach($children[$row['id']] as $row) { ?>
				<?php  if($row['islinkurl'] !=0) { ?>
				<tr>
					<td class="text-center">
						<input type="text" class="form-control" name="sort[<?php  echo $row['id'];?>][sort]}]" value="<?php  echo $row['sort'];?>">
					</td>
					<td class="text-left"><div style="padding-left:50px;height:30px;line-height:30px;background:url('../addons/wxz_wzb/template/images/bg_repno.gif') no-repeat -245px -545px;">外链直播间：<?php  echo $row['title'];?></div></td>
					<td class="text-center"><?php echo $row['isshow'] ? '是' : '否'?></td>
					<td class="text-center"><?php echo $row['islinkurl'] ? $row['linkurl'] : '否'?></td>
					<td class="text-center"><?php  echo date('Y-m-d H:i:s',$row['dateline'])?></td>
					<td class="text-center">
						<a class="btn btn-default" title="编辑" href="<?php  echo $this->createWebUrl('wlive',array('id'=>$row['id'],'cid'=>$row['cid']))?>">
							<i class="fa fa-gear"></i>
						</a>
						<a class="btn btn-default" title="删除" href="<?php  echo $this->createWebUrl('wlive_del',array('id'=>$row['id']))?>" onclick="return confirm('删除将删除该直播间的所有信息且无法恢复，确认吗？');return false;">
							<i class="fa fa-times"></i>
						</a>
					</td>
				</tr>
				<?php  } else { ?>
				<tr>
					<td class="text-center">
						<input type="text" class="form-control" name="sort[<?php  echo $row['id'];?>][sort]}]" value="<?php  echo $row['sort'];?>">
					</td>
					<td class="text-left"><div style="padding-left:50px;height:30px;line-height:30px;background:url('../addons/wxz_wzb/template/images/bg_repno.gif') no-repeat -245px -545px;">直播间：<?php  echo $row['title'];?></div></td>
					<td class="text-center"><?php echo $row['isshow'] ? '是' : '否'?></td>
					<td class="text-center"><?php echo $row['islinkurl'] ? $row['linkurl'] : '否'?></td>
					<td class="text-center"><?php  echo date('Y-m-d H:i:s',$row['dateline'])?></td>
					<td class="text-center">
						<a class="btn btn-default" title="编辑" href="<?php  echo $this->createWebUrl('clive_edit',array('id'=>$row['id']))?>">
							<i class="fa fa-gear"></i>
						</a>
						<a class="btn btn-default" title="删除" href="<?php  echo $this->createWebUrl('category_del',array('id'=>$row['id']))?>" onclick="return confirm('删除将删除该直播间的所有信息且无法恢复，确认吗？');return false;">
							<i class="fa fa-times"></i>
						</a>
					</td>
				</tr>
				<?php  } ?>
				
				<?php  } } ?>
			<?php  } } ?>
				<tr>
					<td colspan="6">
						<a href="<?php  echo $this->createWebUrl('category_edit', array('pid' => 0))?>"><i class="fa fa-plus-circle" title="添加新分类"></i> 添加新分类</a>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
		</div>
			<div class="form-group col-sm-12">
				<input name="submit" type="submit" class="btn btn-primary col-lg-1" value="提交">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</form>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>