<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
    .style-desc{
        word-break: break-all;
        word-wrap: break-word;
        background-color: #ebeef5;
        padding: 5px 10px;
        border-radius: 4px;
        white-space: normal;
    }
    
</style>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('qiniustyle',array('op' =>'display'))?>">图片样式</a></li>
	<li<?php  if(empty($style['id']) && $operation == 'post') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('qiniustyle',array('op' =>'post'))?>">添加图片样式</a></li>
	<?php  if(!empty($style['id']) && $operation== 'post') { ?> <li class="active"><a href="<?php  echo $this->createWebUrl('qiniustyle',array('op' =>'post','id'=>$style['sid']))?>">编辑图片样式</a></li> <?php  } ?>
</ul>

<?php  if($operation == 'display') { ?>
<div class="main panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
                                    <th style="width:50px;">编号</th>
                                    <th style="width:100px;">名称</th>
                                    <th style="width:260px;">处理结构</th>
                                    <th style="width:100px;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
                                    <td><?php  echo $item['id'];?></td>
                                    <td><?php  echo $item['title'];?></td>
                                    <td title="<?php  echo $style['styleText'];?>"><div class="style-desc ng-binding"><?php  echo $item['styleText'];?></div></td>
                                    <td style="text-align:left;">
                                            <a href="<?php  echo $this->createWebUrl('qiniustyle', array('op' => 'post', 'sid' => $item['id']))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="修改"><i class="fa fa-pencil"></i></a>
                                            <a href="<?php  echo $this->createWebUrl('qiniustyle', array('op' => 'delete', 'sid' => $item['id']))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="删除"><i class="fa fa-times"></i></a>
                                    </td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
</div>

<script>
	require(['bootstrap'],function($){
		$('.btn').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
	});
</script>

<?php  } else if($operation == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onsubmit='return formcheck()'>
		<input type="hidden" name="id" value="<?php  echo $liveType['id'];?>" />
		<div class="panel panel-default">
			<!--<div class="panel-heading">
				分类设置
			</div>-->
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" id='name' name="title" class="form-control" value="<?php  echo $style['title'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">处理接口</label>
					<div class="col-sm-9 col-xs-12">
						<textarea name="styleText" class="form-control" cols="100" ><?php  echo $style['styleText'];?></textarea>
					</div>
				</div>
		</div>
	</div>
	<div class="form-group col-sm-12">
		<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"/>
		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
	</div>
	</form>
</div>

<script language='javascript'>
	function formcheck() {
		if ($("#name").val().length == 0) {
			Tip.focus("name", "请填写分类名称!", "top");
			return false;
		} 
		return true;
	}
</script>

<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>