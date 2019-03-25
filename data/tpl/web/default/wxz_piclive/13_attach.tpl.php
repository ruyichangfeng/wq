<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<script type="text/javascript" src="resource/js/lib/jquery-ui-1.10.3.min.js"></script>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('topicManage', array('op' => 'display','lid'=>$lid))?>">图片附件</a></li>
</ul>
<?php  if($operation == 'post') { ?>

<style type='text/css'>
	.tab-pane {padding:20px 0 20px 0;}
</style>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1" name="theForm">
		<div class="panel panel-default">
			<div class="panel-heading">编辑图片</div>
			<div class="panel-body">
				<!--<ul class="nav nav-tabs" id="myTab">
					<li class="active" ><a href="#tab_basic">基本信息</a></li>
				</ul>-->
				<div class="tab-content">
					<div class="form-group">
                                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">图片</label>
                                                <div class="col-sm-9 col-xs-12">
                                                        <?php  echo tpl_form_field_image('original_img', $attachRow['picpath'], '', array('extras' => array('text' => 'readonly')))?>
                                                </div>
                                        </div>
				</div>
                                <?php  if($remoteType == 3) { ?>
                                <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">七牛图片样式(小图)</label>
                                        <div class="col-sm-9 col-xs-12">
                                                <select name="qiniu_sid" class='form-control'>
                                                        <option value="0">请选择……</option>
                                                        <?php  echo $qiniuStyleList;?>
                                                </select>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">七牛图片样式(大图)</label>
                                        <div class="col-sm-9 col-xs-12">
                                                <select name="qiniu_sid_big" class='form-control'>
                                                        <option value="0">请选择……</option>
                                                        <?php  echo $qiniuStyleList2;?>
                                                </select>
                                        </div>
                                </div>
                                <?php  } ?>
			</div>
		</div>
		<div class="form-group col-sm-12" style="margin-top:20px;">
			<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<script type="text/javascript">
	var category = <?php  echo json_encode($children)?>;

	$(function () {
		window.optionchanged = false;
		$('#myTab a').click(function (e) {
			e.preventDefault();//阻止a链接的跳转行为
			$(this).tab('show');//显示当前选中的链接及关联的content
		})
	});
	
</script>

<?php  } else if($operation == 'display') { ?>
<div class="main">
	<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form">
			<input type="hidden" name="c" value="site" />
			<input type="hidden" name="a" value="entry" />
			<input type="hidden" name="m" value="wxz_piclive" />
			<input type="hidden" name="do" value="attach" />
                        <input type="hidden" name="lid" value="<?php  echo $lid;?>" />
			<input type="hidden" name="op" value="display" />
			<!--<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
				<div class="col-xs-12 col-sm-8 col-lg-9">
					<input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
				</div>
			</div>-->      
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">所属直播间</label>
				<div class="col-xs-12 col-sm-8 col-lg-9">
					<select name="lid" class='form-control'>
                                                <option value="0" >请选择</option>
                                                <?php  echo $live_list;?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<!--<label class="col-xs-12 col-sm-3 col-md-1 control-label">分类</label>
				<div class="col-sm-8 col-xs-12">
					<select name="cat_id" class='form-control input-medium'>
						
					</select>
				</div>-->
				<div class="col-xs-12 col-sm-2 col-lg-2" style="margin-left:90px;">
					<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
				</div>
			</div>

			<div class="form-group">
			</div>
		</form>
	</div>
</div>
<style>
.label{cursor:pointer;}
</style>
<div class="panel panel-default">
	<div class="panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:5%;">编号</th>
                                        <th style="width:5%;">组编号</th>
					<th style="width:10%;">所属分类</th>
                                        <th style="width:15%;">图片</th>
					<th style="width:10%;">时间</th>
                                        <th style="width:8%;">备注</th>
					<th style="text-align:right; width:20%;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['aid'];?></td>
                                        <td><?php  echo $item['tid'];?></td>
					<td><?php  echo $item['type_name'];?></td>
                                        <td>
                                            <div class="input-group " style="margin-top:.5em;">
                                                    <img src="<?php  echo $item['picpath'];?>" onerror="" class="img-responsive img-thumbnail" width="150">
                                            </div>
                                        </td>
					<td><?php  echo $item['add_time'];?></td>
                                        <td><?php  echo $item['topic_name'];?></td>
					<td style="text-align:right;">
                                            <a href="<?php  echo $this->createWebUrl('attach', array('aid' => $item['aid'], 'op' => 'post'))?>"class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
						<a href="<?php  echo $this->createWebUrl('attach', array('aid' => $item['aid'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>&nbsp;&nbsp;
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<?php  echo $pager;?>
	</div>
	</div>
</div>
<script type="text/javascript">
	require(['bootstrap'],function($){
		$('.btn').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
	});

	var category = <?php  echo json_encode($children)?>;
	function setProperty(obj,id,type){
		$(obj).html($(obj).html() + "...");
		$.post("<?php  echo $this->createWebUrl('setgoodsproperty')?>"
			,{id:id,type:type, data: obj.getAttribute("data")}
			,function(d){
				$(obj).html($(obj).html().replace("...",""));
				if(type=='type'){
				 $(obj).html( d.data=='1'?'实体物品':'虚拟物品');
				}
				if(type=='status'){
				 $(obj).html( d.data=='1'?'上架':'下架');
				}
				$(obj).attr("data",d.data);
				if(d.result==1){
					$(obj).toggleClass("label-info");
				}
			}
			,"json"
		);
	}

</script>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
