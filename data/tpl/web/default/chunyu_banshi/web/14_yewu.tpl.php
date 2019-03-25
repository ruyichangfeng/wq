<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<?php  if(is_array($typelist)) { foreach($typelist as $key => $item) { ?>
	<a class="btn btn-primary" href="<?php  echo $this->createWebUrl('yewu',array('typeid'=>$item['tid'],));?>" role="button"><?php  echo $item['typename'];?></a>
<?php  } } ?>
<hr>
<div class="panel panel-default mb10 mt1">
  <div class="panel-heading">
    <h3 class="panel-title">业务流程列表&nbsp;-&nbsp;<?php  if(!$_GPC['typeid']) { ?>全部<?php  } else { ?><?php  echo $tname['typename'];?><?php  } ?></h3>   
  </div>
  
  <!-- Nav tabs -->

  <ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">业务流程列表</a></li>
	<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">新增业务流程</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
    	<table class="table">
	    	<thead>
			<tr>
				<th>ID</th>
				<th>业务图标</th>
				<th>业务标题</th>
				<th>所属分类</th>
				<th>操作</th>
			</tr>
		</thead>	
		<tbody>
			<?php  if(is_array($yewulist)) { foreach($yewulist as $key => $item) { ?>
			<tr>
				<td><?php  echo $item['lid'];?></td>
				<td><img style="width: 60px;height: 60px;" src="<?php  echo tomedia($item['lpic'])?>"></td>
				<td><?php  echo $item['lname'];?></td>
				<td><?php  echo $item['typename'];?></td>
				
				<td>
				<!-- <a href="<?php  echo $this->createWebUrl('yewu_info',array('lid'=>$item['lid']));?>" class="btn btn-primary btn-xs active" role="button">查看</a>&nbsp;&nbsp; -->
				<a href="<?php  echo $this->createWebUrl('yewu_edit',array('lid'=>$item['lid']));?>" class="btn btn-primary btn-xs active" role="button">编辑</a>&nbsp;&nbsp;
				<a href="<?php  echo $this->createWebUrl('yewu_del',array('lid'=>$item['lid']));?>" class="btn btn-primary btn-xs active" role="button" onClick="return confirm('确定删除?');">删除</a></td>
			</tr>
			<?php  } } ?>
		</tbody>
	</table>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">

    	<form method="post" action="" class="form-horizontal">
    		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="lname">业务流程名称</label>
		     <div class="col-sm-10">
		   	 <input type="text" class="form-control" id="lname" placeholder="请填写业务流程名称" name="lname">
		   	 </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="lpic">业务流程图标</label>
		     <div class="col-sm-10">
		    	<?php  echo tpl_form_field_image('lpic');?>
		    </div>
		  </div>

		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="tid">业务所属分类</label>
			    <div class="col-sm-10">
			    	<select class="form-control" name="tid" id="tid">
				<option value="">请选择所属分类</option>
				<?php  if(is_array($typelist)) { foreach($typelist as $key => $item) { ?>
				<option value="<?php  echo $item['id'];?>"><?php  echo $item['typename'];?></option>
				<?php  } } ?>
				</select>
			    </div> 
		  </div>

		   <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="ljieshao">业务办理介绍</label>
		     <div class="col-sm-10">
			<?php  echo tpl_ueditor('ljieshao');?>
			</div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="ltiaojian">业务办理条件</label>
		     <div class="col-sm-10">
			<?php  echo tpl_ueditor('ltiaojian');?>
			</div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="lcailiao">业务办理材料</label>
		     <div class="col-sm-10">
			<?php  echo tpl_ueditor('lcailiao');?>
			</div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="lliucheng">业务办理流程</label>
		     <div class="col-sm-10">
			<?php  echo tpl_ueditor('lliucheng');?>
			</div>
		  </div>
		 <!--  <div class="form-group">
		    <label class="col-sm-2 control-label tx-r" for="lxiazai">业务资料上传</label>
		     <div class="col-sm-10">
			 <?php  echo tpl_form_field_image('lxiazai');?>
			</div>
		  </div> -->
		
		<div style="text-align: center;">
		<input type="submit" name="submit" class="btn btn-primary" value="提交">&nbsp;&nbsp;
		<a href="<?php  echo $this->createWebUrl('yewu',array());?>">
		<input type="button" class="btn btn-warning" value="返回">
		</a>
		</div>
		<br>
	</form>
    </div>
  </div>
</div>

<?php  echo $pager;?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>