<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

		
	<div class="panel panel-success">

				<!-- Default panel contents -->
				<div class="panel-heading">基础设置</div>
				<div class="panel-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-8">
								<form action="" method="post" class="form-horizontal">
									<div class="form-group">
										<label for="title" class="col-sm-2 control-label tx-r">页面标题</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="title" name="title" placeholder="请输入标题名称" value="<?php  echo $base['title']?>">
										</div>
									</div>
									<div class="form-group">
										<label for="jigou" class="col-sm-2 control-label tx-r">所属机构</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="jigou" name="jigou" placeholder="请输入机构名称" value="<?php  echo $base['jigou']?>">
										</div>
									</div>
									<div class="form-group">
										<label for="didian" class="col-sm-2 control-label tx-r">办公地点</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="didian" name="didian" placeholder="请输入办公地点" value="<?php  echo $base['didian']?>">
										</div>
									</div>
									<div class="form-group">
										<label for="phone" class="col-sm-2 control-label tx-r">联系电话</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="phone" name="phone" placeholder="请输入联系电话" value="<?php  echo $base['phone']?>">
										</div>
									</div>

									<div class="form-group">
										<label for="shijian" class="col-sm-2 control-label tx-r">服务时间</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="shijian" name="shijian" placeholder="请输入服务时间" value="<?php  echo $base['shijian']?>">
										</div>
									</div>

									<div class="form-group">
										<label for="ewm" class="col-sm-2 control-label tx-r">公众号二维码</label>
										<div class="col-sm-10">
											<?php  echo tpl_form_field_image('ewm',tomedia($base['ewm']));?>
										</div>
									</div>
									<div class="form-group">
										<label for="lcpic" class="col-sm-2 control-label tx-r">基本流程图标</label>
										<div class="col-sm-10">
											<?php  echo tpl_form_field_image('lcpic',tomedia($base['lcpic']));?>
										</div>
									</div>
									<div class="form-group">
										<label for="typepic" class="col-sm-2 control-label tx-r">基本类别图标</label>
										<div class="col-sm-10">
											<?php  echo tpl_form_field_image('typepic',tomedia($base['typepic']));?>
										</div>
									</div>
									
									<div class="form-group">
										<label for="zhichi" class="col-sm-2 control-label tx-r">技术支持</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="copyright" name="zhichi" placeholder="" value="<?php  echo $base['zhichi']?>">
										</div>
									</div>
									
									<div class="form-group">
										<label for="" class="col-sm-2 control-label tx-r"></label>
										<div class="col-sm-10">
											<input type="submit" name="submit" class="btn btn-default" value="保存">
											<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
										</div>
									</div>
								</form>

							</div>
							<div class="col-xs-4">
								
							</div>
						</div>
					</div>

				</div>

			</div>

<script>
	var editor=UE.getEditor('rule',ueditoroption);
	editor.addListener('contentChange',function(){});
	editor.addListener('ready',function(){});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
