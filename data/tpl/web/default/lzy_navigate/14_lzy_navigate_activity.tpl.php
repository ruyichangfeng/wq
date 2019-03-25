<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
  <li <?php  if($op== 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl($filename)?>">导航管理</a></li>
  <li <?php  if($op== 'post' && empty($id)) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl($filename,array('op'=>'post'))?>">新建导航</a></li>
  <?php  if(!empty($id)) { ?><li class="active"><a>编辑导航</a></li> <?php  } ?>
</ul>
<?php  if($op=='display') { ?>
<form action="./index.php" id="form1" method="get" class="form-horizontal" role="form">
<div class="panel panel-info">
  <div class="panel-heading">筛选</div>
  <div class="panel-body">
      <input type="hidden" name="c" value="site" />
      <input type="hidden" name="a" value="entry" />
      <input type="hidden" name="m" value="<?php  echo $this->modulename?>" />
      <input type="hidden" name="do" value="<?php  echo $filename;?>" />
      <div class="form-group">
        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">导航名称</label>
        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-4">
          <input class="form-control" name="title" id="" type="text" value="<?php  echo $_GPC['title'];?>" placeholder="">
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-12 col-sm-3 col-md-2 control-label">
          <button class="btn btn-default"><i class="fa fa-search"></i>搜索</button>
        </div>
      </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">导航列表    (共<i style="color:red"><?php  echo $total;?></i>条记录)</div>
  <div class="panel-body table-responsive" style="overflow: visible;">
    <table class="table table-hover">
      <thead class="navbar-inner">
        <tr>
          <th style="width: 5%;">选择</th>
          <th style="width: 15%;">导航名称</th>
          <th style="width: 10%;">时间</th>
          <th style="width: 20%;">操作</th>
        </tr>
      <tbody id="main">
        <?php  if(is_array($list)) { foreach($list as $row) { ?>
        <tr>
          <td><input type="checkbox" name="id[]" value="<?php  echo $row['id'];?>" class=""></td>
          <td style="white-space: normal; word-break: break-all"><?php  echo $row['title'];?></td>
          <td style="white-space: normal; word-break: break-all"><?php  echo date('Y-m-d H:i:s', $row['createtime'])?></td>
          <td style="white-space: normal; word-break: break-all; overflow: visible;">
            <div class="btn-group btn-group-sm">
              <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;"><i class="fa fa-external-link fa-fw"></i> 链接入口 <span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="<?php  echo $row['_url'];?>" target="_blank"><i class="fa fa-external-link fa-fw"></i> 直接访问</a></li>
                <li role="presentation"><a href="javascript:;" onclick="displayUrl('<?php  echo $row['_url'];?>');"><i class="fa fa-link fa-fw"></i> 查看链接</a></li>
                <li role="presentation"><a href="javascript:;" onclick="displayQr('<?php  echo $_W['siteroot'] . 'web/'.substr($this->createWebUrl('qr', array('raw' => base64_encode($row['_url']))),2)?>');"><i class="fa fa-qrcode fa-fw"></i> 查看二维码</a></li>
              </ul>
            </div>
            <a href="<?php  echo $this->CreateWebUrl($filename,array('op'=>'post','id'=>$row['id']))?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="编辑"><i class="fa fa-edit" ></i></a>
            <a onclick="if(!confirm('确定删除，删除后数据不可恢复?')) return false;" href="<?php  echo $this->CreateWebUrl($filename,array('op'=>'delete','id'=>$row['id']))?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>
          </td>
        </tr>
        <?php  } } ?>
        <tr>
          <td>
            <input type="checkbox" name="" onclick="var ck = this.checked;$(':checkbox').each(function(){this.checked = ck});">
          </td>
          <td colspan="3">
            <input type="hidden" id="op" name="op"/>
            <a href="javascript:batch_del();" class="btn btn-default 
btn-primary" data-toggle="tooltip" data-placement="top" title="批量删除"><i class="fa fa-times"></i>批量删除</a>
          </td>
        </tr>
      </tbody>
    </table>
    </form>
  </div>
  <?php  echo $pager;?>
</div>
</form>
<script type="text/javascript">
require(['bootstrap' ], function($) {
  $('.btn').hover(function() {$(this).tooltip('show');},
  function() {$(this).tooltip('hide');});
});
function displayUrl(url) {
  require(['jquery', 'util' ],function($, u) {
    var content = '<p class="form-control-static" style="word-break:break-all">直达链接: <br>'+ url + '</p>';
    var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>' + '<button type="button" class="btn btn-primary">复制直达链接</button>';
    var diaobj = u.dialog('查看URL', content, footer);
    diaobj.find('.btn-default').click(function() {diaobj.modal('hide');});
    diaobj.on('shown.bs.modal', function() {u.clip(diaobj.find('.btn-primary')[0], url);});
  diaobj.modal('show');
  });
}
function displayQr(url) {
  require(['jquery', 'util' ],function($, u) {
    var content = '<div class="panel panel-default text-center"><img src="' + url + '" alt="二维码" class="img-rounded"></div>';
    var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>';
    var diaobj = u.dialog('查看URL二维码', content, footer);
    diaobj.find('.btn-default').click(function() {diaobj.modal('hide');});
    diaobj.modal('show');
  });
}
function delete_all() {
  if (confirm('确认删除所有信息吗,删除完不可恢复?')) {
    location.href = "<?php  echo $this->createWebUrl($filename, array('op' => 'delete_all'))?>";
  }
}
function batch_del() {
  if (!confirm('确定批量删除吗?')){
    return false;
  }else {
    $('#op').val('batch_del');
    $('#form1').submit();
  }
}
</script>
<?php  } ?>
<?php  if($op=='post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="setting-form">
		<div class="panel panel-default">
			<div class="panel-heading">导航信息</div>
			<div class="panel-body">
				<div class="alert alert-info">
					通过本页面设定导航信息，其中“图片布局”为图片展示大小。
					<br/>
					用户通过<span class="label label-info">链接入口</span>进入导航页面。
				</div>
				<ul class="nav nav-tabs" id="myTab">
					<li class="active"><a href="#tab_navigate">导航设置</a></li>
					<li><a href="#tab_slide">幻灯片设置</a></li>
					<li><a href="#tab_other">其它信息设置</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_navigate">
						
						<div class="panel-body">
							<!-- 导航  -->
							
							<div class="col-xs-12 col-sm-12">
								<div style="display: none;">
									<table>
										<tbody id="List_tr">
											<tr>
												<td style="text-align:center;vertical-align:top;">
													<select name="data[navigate][layout][]" class="form-control">
														<option value="25">25%</option>
														<option value="3">30%</option>
														<option value="5">50%</option>
														<option value="7">70%</option>
													</select>
												</td>
												<td style="text-align:center;vertical-align:top;"><?php  echo tpl_form_field_image('data[navigate][img][]','');?></td>
												<td style="text-align:center;vertical-align:top;">
													<input name="data[navigate][img_urls][]" type="text" class="form-control span6" placeholder="点击图片，外链，以http开头。" />
												</td>
												<td style="vertical-align:top;"> 
													<a href='javascript:void(0);' onclick='upRuleItem(this);'>
														&nbsp;<i class='glyphicon glyphicon-arrow-up'></i>上移
													</a>
													<a href='javascript:void(0);' onclick='downRuleItem(this);'>
														&nbsp;<i class='glyphicon glyphicon-arrow-down'></i>下移
													</a>
													<a href='javascript:void(0);' onclick='$(this).parent().parent().remove();'>
														&nbsp;<i class='glyphicon glyphicon-remove'></i>删除
													</a>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<table class='table'>
									<thead>
										<tr>
											<th style="width: 180px;">图片布局</th>
											<th style="width: 200px;">图片</th>
											<th>链接地址</th>
											<th style="width: 180px;">操作</th>
										</tr>
									</thead>
									<tbody id="rule_items">
										<?php  if(is_array($page_data['navigate'])) { foreach($page_data['navigate'] as $item) { ?>
										<tr>
											<td style="text-align:center;vertical-align:top;">
												<select name="data[navigate][layout][]" class="form-control">
													<option value="25" <?php  if(25==$item['layout']) { ?>selected<?php  } ?>>25%</option>
													<option value="3" <?php  if(3==$item['layout']) { ?>selected<?php  } ?>>30%</option>
													<option value="5" <?php  if(5==$item['layout']) { ?>selected<?php  } ?>>50%</option>
													<option value="7" <?php  if(7==$item['layout']) { ?>selected<?php  } ?>>70%</option>
												</select>
											</td>
											<td style="text-align:center;vertical-align:top;"><?php  echo tpl_form_field_image('data[navigate][img][]',$item['img']);?></td>
											<td style="text-align:center;vertical-align:top;">
												<input name="data[navigate][img_urls][]" type="text" class="form-control span6" value="<?php  echo $item['img_urls'];?>" placeholder="点击图片，外链，以http开头。" />
											</td>
											<td style="vertical-align:top;">
												<a href='javascript:void(0);' onclick='upRuleItem(this);'>
													&nbsp;<i class='glyphicon glyphicon-arrow-up'></i>上移
												</a>
												<a href='javascript:void(0);' onclick='downRuleItem(this);'>
													&nbsp;<i class='glyphicon glyphicon-arrow-down'></i>下移
												</a>
												<a href='javascript:void(0);' onclick='$(this).parent().parent().remove();'>
													&nbsp;<i class='glyphicon glyphicon-remove'></i>删除
												</a>
											</td>
										</tr>
										<?php  } } ?> 
										<?php  if(count($page_data['navigate'])==0) { ?> 
										<tr>
											<td style="text-align:center;vertical-align:top;" >
												<select name="data[navigate][layout][]" class="form-control">
														<option value="25" <?php  if(25==$item['group']) { ?>selected<?php  } ?>>25%</option>
														<option value="3" <?php  if(3==$item['group']) { ?>selected<?php  } ?>>30%</option>
														<option value="5" <?php  if(5==$item['group']) { ?>selected<?php  } ?>>50%</option>
														<option value="7" <?php  if(7==$item['group']) { ?>selected<?php  } ?>>70%</option>
												</select>
											</td>
											<td style="text-align:center;vertical-align:top;"><?php  echo tpl_form_field_image('data[navigate][img][]','');?></td>
											<td style="text-align:center;vertical-align:top;">
												<input name="data[navigate][img_urls][]" type="text" class="form-control span6" placeholder="点击图片，外链，以http开头。" />
											</td>
											<td style="vertical-align:top;">
												<a href='javascript:void(0);' onclick='upRuleItem(this);'>
													&nbsp;<i class='glyphicon glyphicon-arrow-up'></i>上移
												</a>
												<a href='javascript:void(0);' onclick='downRuleItem(this);'>
													&nbsp;<i class='glyphicon glyphicon-arrow-down'></i>下移
												</a>
												<a href='javascript:void(0);' onclick='$(this).parent().parent().remove();'>
													&nbsp;<i class='glyphicon glyphicon-remove'></i>删除
												</a>
											</td>
										</tr>
										<?php  } ?>
									</tbody>
								</table>

							</div>
						</div>
						
						<button class="btn btn-primary" id="addRuleItem" type="button" style="margin: -15px 0 15px 15px;"><i class="fa fa-plus"></i>&nbsp;添加导航</button>
						
						
						<script type="text/javascript">
							$('#addRuleItem').click(function() {
								$('#rule_items').append($('#List_tr').html());
							});
							
							function upRuleItem(obj) {
								$item = $(obj).parent().parent();
								$prevItem = $item.prev();
								$item.insertBefore($prevItem);
							}

							function downRuleItem(obj) {
								$item = $(obj).parent().parent();
								$nextItem = $item.next();
								$item.insertAfter($nextItem);
							}
						</script>
						<!-- 导航  end  -->
					</div>

					<div class="tab-pane" id="tab_slide">
						<!-- 幻灯片 -->
						<div class="panel-body" id="List">
							<div class="well well-lg" id="List_data" style="display: none">
								<button type="button" class="close" onclick="$(this).parent().remove()">
									<span>&times;</span>
								</button>

								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">图片</label>
									<div class="col-sm-7 col-xs-12"><?php  echo tpl_form_field_image('data[slide][img][]','');?></div>
								</div>

								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">链接</label>
									<div class="col-sm-9 col-xs-12">
										<input type="text" class="form-control span7" placeholder="" name="data[slide][img_urls][]" value="">
										<span class="help-block"> 点击图片，外链，以http开头。 </span>
									</div>
								</div>
							</div>

							<?php  if(is_array($page_data['slide'])) { foreach($page_data['slide'] as $index => $item) { ?>
							<div class="well well-lg" id="List_data">
								<button type="button" class="close" onclick="$(this).parent().remove()">
									<span>&times;</span>
								</button>

								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片</label>
									<div class="col-sm-7 col-xs-12"><?php  echo tpl_form_field_image('data[slide][img][]',$item['img']);?></div>
								</div>

								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">链接</label>
									<div class="col-sm-9 col-xs-12">
										<input type="text" class="form-control span7" placeholder="" name="data[slide][img_urls][]" value="<?php  echo $item['img_urls'];?>">
										<span class="help-block"> 点击图片，外链，以http开头。 </span>
									</div>
								</div>
							</div>
							<?php  } } ?>
							<?php  if(count($page_data['slide'])==0) { ?> 
							<div class="well well-lg" id="List_data">
								<button type="button" class="close" onclick="$(this).parent().remove()">
									<span>&times;</span>
								</button>

								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片</label>
									<div class="col-sm-7 col-xs-12"><?php  echo tpl_form_field_image('data[slide][img][]','');?></div>
								</div>

								<div class="form-group">
									<label class="col-xs-12 col-sm-3 col-md-2 control-label">链接</label>
									<div class="col-sm-9 col-xs-12">
										<input type="text" class="form-control span7" placeholder="" name="data[slide][img_urls][]" >
										<span class="help-block"> 点击图片，外链，以http开头。 </span>
									</div>
								</div>
							</div>
							<?php  } ?>
						</div>
						<button class="btn btn-primary" id="addlist" type="button" style="margin: -15px 0 15px 15px;">
							<i class="fa fa-plus"></i>
							&nbsp;添加幻灯片
						</button>
						&nbsp;&nbsp;

						<script>
							$('#addlist').click(function() {
								var $prizeList = $('#List');
								var prizeSize = $prizeList.children('#List_data').size();
								$prizeList.append('<div class="well well-lg" id="List_data">' + ($('#List_data').html()) + '</div>');
							})
						</script>
						<!-- 幻灯片 end -->
					</div>

					<div class="tab-pane" id="tab_other">
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">导航标题</label>
							<div class="col-xs-12 col-sm-9">
								<input type="text" name="data[title]" value="<?php  echo $page_data['title'];?>" class="form-control">
								<span class="help-block">手机端标题名称,不填则默认</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">背景颜色</label>
							<div class="col-xs-12 col-sm-6">
								<?php  echo tpl_form_field_color('data[backcolor]',$page_data['backcolor']);?>
								<span class="help-block">背景颜色,不填则默认</span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
							<div class="col-xs-12 col-sm-9">
								<input type="text" name="data[sharetitle]" value="<?php  echo $page_data['sharetitle'];?>" class="form-control">
								<span class="help-block">微信分享标题</span>
							</div>
						</div>


						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享描述</label>
							<div class="col-xs-12 col-sm-9">
								<input type="text" name="data[sharedescription]" value="<?php  echo $page_data['sharedescription'];?>" class="form-control">
								<span class="help-block">微信分享描述</span>
							</div>
						</div>


						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享图片</label>
							<div class="col-xs-12 col-sm-9">
								<?php  echo tpl_form_field_image('data[shareimage]',$page_data['shareimage']);?>
								<span class="help-block">微信分享图片</span>
							</div>

						</div>

						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">底部版权</label>
							<div class="col-xs-12 col-sm-9">
								<input type="text" name="data[copyright]" value="<?php  echo $page_data['copyright'];?>" class="form-control">
								<span class="help-block">底部版权,不写则不显示</span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">底部版权url</label>
							<div class="col-xs-12 col-sm-9">
								<input type="text" name="data[copyright_link]" value="<?php  echo $page_data['copyright_link'];?>" class="form-control">
								<span class="help-block">底部版权url,不写则不显示，外链，以http开头。</span>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="form-group col-sm-12">
			<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>

<script>
	$(function() {
		window.optionchanged = false;
		$('#myTab a').click(function(e) {
			e.preventDefault();//阻止a链接的导航行为
			$(this).tab('show');//显示当前选中的链接及关联的content
		});
		$('.tpl-district').remove();
	});
</script>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>