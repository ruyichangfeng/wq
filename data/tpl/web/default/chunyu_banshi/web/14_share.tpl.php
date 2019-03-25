<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

	<div class="panel panel-success">

				<!-- Default panel contents -->

				<div class="panel-heading">分享设置</div>

				<div class="panel-body">

					<div class="container-fluid">

						<div class="row">

							<div class="col-xs-8">

								<form action="" method="post" class="form-horizontal">

									<div class="form-group">

										<label for="gzurl" class="col-sm-2 control-label tx-r">分享链接</label>

										<div class="col-sm-10">

											<input type="text" class="form-control" id="gzurl" name="gzurl" placeholder="" value="<?php  echo $share['gzurl']?>">

											<span>分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致</span>

										</div>

									</div>

									<div class="form-group">

										<label for="sharetitle" class="col-sm-2 control-label tx-r">分享标题</label>

										<div class="col-sm-10">

											<input type="text" class="form-control" id="sharetitle" name="sharetitle" placeholder="" value="<?php  echo $share['sharetitle']?>">

											<span>此设置用于首页分享的分享语</span>

										</div>

									</div>

									<div class="form-group">

										<label for="shareimg" class="col-sm-2 control-label tx-r">分享图片</label>

										<div class="col-sm-10">

											<?php  echo tpl_form_field_image('shareimg',tomedia($share['shareimg']));?>

											<span>图片建议尺寸：500像素*500像素</span>

										</div>

									</div>	

									<div class="form-group">

										<label for="sharetext" class="col-sm-2 control-label tx-r">分享内容</label>

										<div class="col-sm-10">

											<input type="text" class="form-control" id="sharetext" name="sharetext" placeholder="" value="<?php  echo $share['sharetext']?>">

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

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>

