<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">类别列表</a></li>
	<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">新增类别</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
    	<table class="table">
	    	<thead>
			<tr>
				<th>ID</th>
				<th>类别图标</th>
				<th>类别名称</th>
				<th>操作</th>
			</tr>
		</thead>	
		<tbody>
			<?php  if(is_array($typelist)) { foreach($typelist as $key => $item) { ?>
			<tr>
				<td><?php  echo $item['tid'];?></td>
				<td><img style="width: 60px;height: 60px;" src="<?php  echo tomedia($item['typepic'])?>"></td>
				<td><?php  echo $item['typename'];?></td>
				<td>
					<a href="<?php  echo $this->createWebUrl('type_edit',array('tid'=>$item['tid']));?>" class="btn btn-primary btn-xs active" role="button">编辑</a>&nbsp;&nbsp;
					<a href="<?php  echo $this->createWebUrl('type_del',array('tid'=>$item['tid']));?>" class="btn btn-primary btn-xs active" role="button" onClick="return confirm('确定删除?');">删除</a>
				</td>
			
			</tr>
			<?php  } } ?>
		</tbody>
	</table>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
    	<form method="post" action="">
    		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
		  <div class="form-group">
		    <label  class="col-sm-2 control-label tx-r" for="typename">类别名称</label>
		    <div class="col-sm-10">
		    <input type="text" class="form-control" id="typename" placeholder="请填写类别名称" name="typename">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="typepic">类别图标</label>
		     <div class="col-sm-10">
		    <?php  echo tpl_form_field_image('typepic');?>
		    </div>
		  </div>
		  <input type="submit" name="submit" class="btn btn-default" value="提交">
	</form>
    </div>
  </div>
</div>
<?php  echo $pager;?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>