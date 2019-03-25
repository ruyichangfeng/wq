<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="setting-form">
		<div class="panel panel-default">
			<div class="panel-heading">参数设置</div>
			<div class="panel-body">
				<div class="alert alert-info">
					通过本页面设定导航信息，其中“图片布局”为图片展示大小。
					<br/>
					如需查看示例，请点击<a id="refresh" class="btn btn-sm btn-danger" ><i class="fa fa-refresh"></i>&nbsp;初始化数据</a>进行数据初始化。
					<br>
					用户通过<span class="label label-info">导航入口</span>进入导航页面。
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
										<?php  if(is_array($settings['navigate'])) { foreach($settings['navigate'] as $item) { ?>
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
										<?php  if(count($settings['navigate'])==0) { ?> 
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

							<?php  if(is_array($settings['slide'])) { foreach($settings['slide'] as $index => $item) { ?>
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
							<?php  if(count($settings['slide'])==0) { ?> 
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
								<input type="text" name="data[title]" value="<?php  echo $settings['title'];?>" class="form-control">
								<span class="help-block">手机端标题名称,不填则默认</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">背景颜色</label>
							<div class="col-xs-12 col-sm-6">
								<?php  echo tpl_form_field_color('data[backcolor]',$settings['backcolor']);?>
								<span class="help-block">背景颜色,不填则默认</span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
							<div class="col-xs-12 col-sm-9">
								<input type="text" name="data[sharetitle]" value="<?php  echo $settings['sharetitle'];?>" class="form-control">
								<span class="help-block">微信分享标题</span>
							</div>
						</div>


						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享描述</label>
							<div class="col-xs-12 col-sm-9">
								<input type="text" name="data[sharedescription]" value="<?php  echo $settings['sharedescription'];?>" class="form-control">
								<span class="help-block">微信分享描述</span>
							</div>
						</div>


						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享图片</label>
							<div class="col-xs-12 col-sm-9">
								<?php  echo tpl_form_field_image('data[shareimage]',$settings['shareimage']);?>
								<span class="help-block">微信分享图片</span>
							</div>

						</div>

						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">底部版权</label>
							<div class="col-xs-12 col-sm-9">
								<input type="text" name="data[copyright]" value="<?php  echo $settings['copyright'];?>" class="form-control">
								<span class="help-block">底部版权,不写则不显示</span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">底部版权url</label>
							<div class="col-xs-12 col-sm-9">
								<input type="text" name="data[copyright_link]" value="<?php  echo $settings['copyright_link'];?>" class="form-control">
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
			e.preventDefault();//阻止a链接的跳转行为
			$(this).tab('show');//显示当前选中的链接及关联的content
		});
		$('.tpl-district').remove();
		
		$('#refresh').on('click',function(){
			if (confirm('确认进行数据初始化吗,此操作将覆盖现有数据?')){
				location.href ="./index.php?c=profile&a=module&do=setting&m=<?php  echo $this->modulename?>&op=init";	
			} 
		});
	});
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>