<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('profile/common', TEMPLATE_INCLUDEPATH)) : (include template('profile/common', TEMPLATE_INCLUDEPATH));?>
<div id="js-profile-notify" ng-controller="remote">
	<div class="we7-form">
		<form action="" method="post">
			<div class="form-group">
				<div class="col-sm-12">
					<input type="radio" name="type" id="type-0" value="0" onclick="$('.remote-close').show();$('.remote-qiniu').hide();$('.remote-alioss').hide();$('.remote-ftp').hide();$('.remote-close').show();$('.remote-cos').hide();" <?php  if(empty($remote['type']) || $remote['type'] == '0') { ?> checked="checked" <?php  } ?>>
					<label class="radio-inline" for="type-0">
						关闭
					</label>
					<!--<input type="radio" name="type" id="type-1" value="1" onclick="$('.remote-qiniu').hide();$('.remote-ftp').show();$('.remote-alioss').hide();$('.remote-close').hide();$('.remote-cos').hide();" <?php  if(!empty($remote['type']) && $remote['type'] == '1') { ?> checked="checked" <?php  } ?>>-->
					<!--<label class="radio-inline" for="type-1">-->
						<!--FTP服务器-->
					<!--</label>-->
					<!--<input type="radio" name="type" id="type-2" value="2" onclick="$('.remote-qiniu').hide();$('.remote-alioss').show();$('.remote-ftp').hide();$('.remote-close').hide();$('.remote-cos').hide();" <?php  if(!empty($remote['type']) && $remote['type'] == '2') { ?> checked="checked" <?php  } ?>>-->
					<!--<label class="radio-inline" for="type-2">-->
						<!--阿里云OSS <span class="label label-success">推荐，快速稳定</span>-->
					<!--</label>-->
					<input type="radio" name="type" id="type-3" value="3" onclick="$('.remote-qiniu').show();$('.remote-alioss').hide();$('.remote-ftp').hide();$('.remote-close').hide();$('.remote-cos').hide();" <?php  if(!empty($remote['type']) && $remote['type'] == '3') { ?> checked="checked" <?php  } ?>>
					<label class="radio-inline" for="type-3">
						七牛云存储 <span class="label label-success">推荐，快速稳定</span>
					</label>
					<!--<input type="radio" name="type" id="type-4" value="4" onclick="$('.remote-qiniu').hide();$('.remote-alioss').hide();$('.remote-ftp').hide();$('.remote-close').hide();$('.remote-cos').show();" <?php  if(!empty($remote['type']) && $remote['type'] == '4') { ?> checked="checked" <?php  } ?>>-->
					<!--<label class="radio-inline" for="type-4">-->
						<!--腾讯云存储 <span class="label label-success">推荐，快速稳定</span>-->
					<!--</label>-->
					<!--<span class="help-block"></span>-->
				</div>
			</div>
			<div class="remote-qiniu" <?php  if($remote['type'] != 3) { ?>style="display: none;"<?php  } ?>>
				<div class="alert alert-info">
					启用七牛云存储后，请把/attachment目录（不包括此目录）下的子文件及子目录上传至七牛云存储, 相关工具：
					<a href="https://portal.qiniu.com/signin">七牛云存储</a>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Accesskey</label>
					<div class="col-sm-9">
						<input type="text" name="qiniu[accesskey]" class="form-control" value="<?php  echo $remote['qiniu']['accesskey'];?>" placeholder="" />
						<span class="help-block">用于签名的公钥</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Secretkey</label>
					<div class="col-sm-9">
						<input type="text" name="qiniu[secretkey]" class="form-control encrypt" value="<?php  echo $remote['qiniu']['secretkey'];?>" placeholder="" />
						<span class="help-block">用于签名的私钥</span>
					</div>
				</div>
				<div class="form-group" id="qiniubucket">
					<label class="col-sm-2 control-label">Bucket</label>
					<div class="col-sm-9">
						<input type="text" name="qiniu[bucket]" class="form-control" value="<?php  echo $remote['qiniu']['bucket'];?>" placeholder="" />
						<span class="help-block">请保证bucket为可公共读取的</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Url</label>
					<div class="col-sm-9">
						<input type="text" name="qiniu[url]" class="form-control" value="<?php  echo $remote['qiniu']['url'];?>" placeholder="" />
						<span class="help-block">七牛支持用户自定义访问域名。注：url开头加http://或https://结尾不加 ‘/’例：http://abc.com</span>
					</div>
				</div>
				<div class="form-group">
					<div class="">
						<button name="submit" class="btn btn-primary" value="submit">保存配置</button>
						<button name="button" type="button" class="btn btn-info js-checkremoteqiniu" value="check">测试配置（无需保存）</button>
						<?php  if(!empty($_W['setting']['remote_complete_info'][$_W['uniacid']]['type']) && !empty($local_attachment)) { ?>
						<a name="button" class="btn btn-info" href="<?php  echo url('profile/remote/upload_remote')?>">一键上传</a>
						<?php  } ?>
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
						<input type="hidden" name="do" value="save" />
					</div>
				</div>
			</div>
			<div class="form-group remote-close" <?php  if(!empty($remote['type'])) { ?>style="display: none"<?php  } ?>>
				<div class="">
					<button name="submit" class="btn btn-primary" value="submit">保存配置</button>
					<input type="hidden" name="do" value="save" />
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	$(function() {
		$('.encrypt').val(function() {
			return util.encrypt($(this).val());
		});
	});
	$('.js-checkremoteqiniu').on('click', function(){
		var key = $.trim($(':text[name="qiniu[accesskey]"]').val());
		if (key == '') {
			util.message('请填写Accesskey');
			return false;
		}
		var secret = $.trim($(':text[name="qiniu[secretkey]"]').val());
		if (secret == '') {
			util.message('请填写Secretkey');
			return false;
		}
		var param = {
			'accesskey' : $.trim($(':text[name="qiniu[accesskey]"]').val()),
			'secretkey' : $.trim($(':text[name="qiniu[secretkey]"]').val()),
			'url'  : $.trim($(':text[name="qiniu[url]"]').val()),
			'bucket' :  $.trim($(':text[name="qiniu[bucket]"]').val())
		};
		$.post("<?php  echo url('profile/remote/test_setting', array('type' => ATTACH_QINIU))?>",param, function(data) {
			var data = $.parseJSON(data);
			if(data.message.errno == 0) {
				util.message('配置成功');
				return false;
			}
			if(data.message.errno < 0) {
				util.message(data.message.message);
				return false;
			}
		});
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
