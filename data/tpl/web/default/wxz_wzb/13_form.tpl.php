<?php defined('IN_IA') or exit('Access Denied');?><script type="text/javascript" src="./resource/js/lib/jquery-1.11.1.min.js"></script>
<input type="hidden" name="aid" value="<?php  echo $setting['id'];?>" />
<input type="hidden" name="lid" value="<?php  echo $live_setting['id'];?>" />
<div class="panel panel-default">
    <div class="panel-heading">
        活动设置
    </div>
    <div class="panel-body">  
	<?php  if($rid) { ?>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">直接调用链接</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" id="link" class="form-control" placeholder="" name="link" disabled="disabled" value="<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&m=wxz_wzb&do=index2&rid=<?php  echo $rid;?>">
				<div class="help-block"><font style="color: red">需要拥有高级接口权限的！</font></div>
			</div>
		</div> 
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">二维码图片调用</label>
			<div class="col-sm-9 col-xs-12">
				<img src="<?php  echo $imgUrl;?>">
				<div class="help-block"><font style="color: red">需要拥有高级接口权限的！</font></div>
			</div>
		</div>  
	<?php  } ?>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">活动封面标题：</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control span7" name="setting[title]" value="<?php  echo $setting['title'];?>">
				<div class="help-block">活动封面标题</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">活动封面：</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_form_field_image("setting[logo]", $setting['logo'])?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">活动封面描述：</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control span7" name="setting[sub_title]" value="<?php  echo $setting['sub_title'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">引导关注链接：</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control span7" name="setting[attention_url]" value="<?php  echo $setting['attention_url'];?>">

				<span class="help-block">建议设置一条引导关注的素材链接。例:
					<a href="javascript:;" data-toggle="modal" data-target="#subscribeurl">点击查看</a>
				</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">引导关注二维码：</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_form_field_image("setting[attention_code]", $setting['attention_code'])?>
				<div class="help-block"><font style="color: red">最佳尺寸：200*200px</font></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>关注模式</label>
			<div class="col-sm-9 col-xs-12">
			   <label class='radio-inline' onclick="$('#days').hide();">
					<input type='radio' name="setting[gz_must]" value='1' <?php  if($setting['gz_must']==1) { ?>checked<?php  } ?> />强制关注
				</label>
				<label class='radio-inline' onclick="$('#days').hide();">
					<input type='radio' name="setting[gz_must]" value='0' <?php  if($setting['gz_must']==0) { ?>checked<?php  } ?> /> 普通(用户可点击弹出二维码)
				</label>
				<label class='radio-inline' onclick="$('#days').show();">
					<input type='radio' name="setting[gz_must]" value='2' <?php  if($setting['gz_must']==2) { ?>checked<?php  } ?> /> 自动弹出可关闭二维码
				</label>
				<div class="help-block"></div>
			</div>
		</div>
		<div class="form-group" id="days" <?php  if($setting['gz_must']!=2) { ?> style="display:none;"<?php  } ?>>
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">关注模式三缓存时间：</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control span7" name="setting[days]" value="<?php  echo $setting['days'];?>">
				<div class="help-block">单位天，0则表示用户每次进入直播间都弹出二维码，否则表示每N天弹出一次二维码</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">游客头像：</label>
			<div class="col-sm-9 col-xs-12">
				<?php  echo tpl_form_field_image("setting[no_avatar]", $setting['no_avatar'])?>
				<div class="help-block"><font style="color: red">非微信客户端访问的用户头像(最佳尺寸：100*100px)</font></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-3 col-md-2 control-label">直播间标题：</label>
			<div class="col-sm-9 col-xs-12">
				<input type="text" class="form-control span7" name="livesetting[title]" value="<?php  echo $live_setting['title'];?>">
				<div class="help-block">直播间标题</div>
			</div>
		</div>
    </div>
</div>

<div class="modal fade" id="subscribeurl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content" style="width:740px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">引导关注示例</h4>
			</div>
			<div class="modal-body">
				<h4>引导关注素材示例页面</h4>
				<span class="help-block">2017-04-04&nbsp;&nbsp;
				<a href="javascript:;">XXXXXX</a></span>
				<img src="./resource/images/subscribe.gif">
				<span class="help-block">XXXXXXXXX的微信公众平台管理系统。</span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>
