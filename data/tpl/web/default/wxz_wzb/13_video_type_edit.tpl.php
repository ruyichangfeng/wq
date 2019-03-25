<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>


<!--参与粉丝/中奖名单-->
<div class="main">
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>

<style>
#myTab a{margin:5px !important;}
</style>
<form action="" method="post" class="form-horizontal" role="form" id="form1" >
<input type="hidden" name="id" value="<?php  echo $list['id'];?>"> 
<div class="panel panel-default">	
	<div class="panel-body">
			<div class="panel-body">
				   <div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">直播类型</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<label class="radio-inline">
								<input type="radio" name="type" value="7" <?php  if($list['type'] == '7') { ?>checked="true"<?php  } ?> onclick="$('.tupian').show();$('.leshi').hide();$('.aodian').hide();$('.daima').hide();$('.leshis').hide();$('.xiongmao').hide();$('.huajiao').hide();$('.aliyun').hide();$('.xsd').hide();$('.yy').hide();$('.qg').hide();">图片
							</label>
							<label class="radio-inline">
								<input type="radio" name="type" value="1" <?php  if($list['type'] == '1') { ?>checked="true"<?php  } ?> onclick="$('.leshi').show();$('.aodian').hide();$('.daima').hide();$('.leshis').hide();$('.xiongmao').hide();$('.huajiao').hide();$('.aliyun').hide();$('.tupian').hide();$('.xsd').hide();$('.yy').hide();$('.qg').hide();">乐视
							</label>
							<label class="radio-inline">
								<input type="radio" name="type" value="6" <?php  if($list['type'] == '6') { ?>checked="true"<?php  } ?> onclick="$('.leshi').hide();$('.aodian').hide();$('.daima').hide();$('.leshis').hide();$('.xiongmao').hide();$('.huajiao').hide();$('.aliyun').show();$('.tupian').hide();$('.xsd').hide();$('.yy').hide();$('.qg').hide();">阿里云
							</label>
							<label class="radio-inline">
								<input type="radio" name="type" value="2" <?php  if($list['type'] == '2') { ?>checked="true"<?php  } ?> onclick="$('.leshi').hide();$('.aodian').show();$('.daima').hide();$('.leshis').hide();$('.xiongmao').hide();$('.huajiao').hide();$('.aliyun').hide();$('.tupian').hide();$('.xsd').hide();$('.yy').hide();$('.qg').hide();">M3U8视频格式(如：奥点云、腾讯云、七牛云、萤石等自建服务器)
							</label>
							<label class="radio-inline">
								<input type="radio" name="type" value="8" <?php  if($list['type'] == '8') { ?>checked="true"<?php  } ?> onclick="$('.leshi').hide();$('.aodian').hide();$('.daima').hide();$('.leshis').hide();$('.xiongmao').hide();$('.huajiao').hide();$('.aliyun').hide();$('.tupian').hide();$('.xsd').show();$('.yy').hide();$('.qg').hide();">小水滴
							</label>
							<label class="radio-inline">
								<input type="radio" name="type" value="10" <?php  if($list['type'] == '10') { ?>checked="true"<?php  } ?> onclick="$('.leshi').hide();$('.aodian').hide();$('.daima').hide();$('.leshis').hide();$('.xiongmao').hide();$('.huajiao').hide();$('.aliyun').hide();$('.tupian').hide();$('.xsd').hide();$('.yy').hide();$('.qg').show();">青果
							</label>
							<label class="radio-inline">
								<input type="radio" name="type" value="3" <?php  if($list['type'] == '3') { ?>checked="true"<?php  } ?> onclick="$('.leshi').hide();$('.aodian').hide();$('.daima').show();$('.leshis').hide();$('.xiongmao').hide();$('.huajiao').hide();$('.aliyun').hide();$('.tupian').hide();$('.xsd').hide();$('.yy').hide();$('.qg').hide();">其他播放器代码(如：优酷、土豆、腾讯、爱奇艺等视频网站)
							</label>
							<label class="radio-inline">
								<input type="radio" name="type" value="4" <?php  if($list['type'] == '4') { ?>checked="true"<?php  } ?> onclick="$('.leshi').hide();$('.aodian').hide();$('.daima').hide();$('.leshis').hide();$('.xiongmao').show();$('.huajiao').hide();$('.aliyun').hide();$('.tupian').hide();$('.xsd').hide();$('.yy').hide();$('.qg').hide();">熊猫直播
							</label>
							<label class="radio-inline">
								<input type="radio" name="type" value="9" <?php  if($list['type'] == '9') { ?>checked="true"<?php  } ?> onclick="$('.leshi').hide();$('.aodian').hide();$('.daima').hide();$('.leshis').hide();$('.xiongmao').hide();$('.huajiao').hide();$('.aliyun').hide();$('.tupian').hide();$('.xsd').hide();$('.yy').show();$('.qg').hide();">YY
							</label>
							<!-- <label class="radio-inline">
								<input type="radio" name="type" value="5" <?php  if($list['type'] == '5') { ?>checked="true"<?php  } ?> onclick="$('.leshi').hide();$('.aodian').hide();$('.daima').hide();$('.leshis').hide();$('.xiongmao').hide();$('.huajiao').show();$('.aliyun').hide();">花椒直播
							</label> -->
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">视频分辨率</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<div class="input-group" style="width:300px;">
								<div class="input-group-addon">分辨率</div>
								<input type="text" class="form-control" name="player_weight" value="<?php  echo $list['player_weight'];?>" >
								<span class="input-group-addon">X</span>
								<input type="text" class="form-control " name="player_height" value="<?php  echo $list['player_height'];?>" >
							</div>
							<span class="help-block">默认：1280*720</span>
						</div>
					</div>
					<div class="form-group daima" style="<?php  if($list['type']=='3') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">第三方视频类型</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<label class='radio-inline' >
								<input type='radio' name="dtype" value='1' <?php  if($list['settings']['ltype']==1) { ?>checked<?php  } ?> />直播
							</label>
							<label class='radio-inline' >
								<input type='radio' name="dtype" value='2' <?php  if($list['settings']['ltype']==2) { ?>checked<?php  } ?> /> 点播
							</label>
						</div>
					</div>
					<div class="form-group aodian" style="<?php  if($list['type']=='2') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">奥点云视频类型</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<label class='radio-inline' >
								<input type='radio' name="atype" value='1' <?php  if($list['settings']['ltype']==1) { ?>checked<?php  } ?> />直播
							</label>
							<label class='radio-inline' >
								<input type='radio' name="atype" value='2' <?php  if($list['settings']['ltype']==2) { ?>checked<?php  } ?> /> 点播
							</label>
						</div>
					</div>
					<div class="form-group aodian" style="<?php  if($list['type']=='2') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">视频封面</label>
						<div class="col-sm-9 col-xs-12">
							<?php  echo tpl_form_field_image("img", $list['settings']['img'])?>
							<div class="help-block"><font style="color: red">最佳尺寸：1280*720px</font></div>
						</div>
					</div>
					<div class="form-group aodian" style="<?php  if($list['type']=='2') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"> rtmp （电脑端播放用）</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="rtmp" value="<?php  echo $list['settings']['rtmp'];?>">
						</div>
					</div>
					<div class="form-group aodian" style="<?php  if($list['type']=='2') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">hls（手机端播放用）</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="hls" value="<?php  echo $list['settings']['hls'];?>">
							<span class="help-block">请填写【.M3U8】结尾的视频流地址</span>
						</div>
					</div>
					
					<div class="form-group leshi" style="<?php  if($list['type']=='1') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">乐视云视频类型</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<label class='radio-inline' >
								<input type='radio' name="ltype" value='1' <?php  if($list['settings']['ltype']==1) { ?>checked<?php  } ?> onclick="$('.zhibo').show();$('.dianbo').hide();"/>直播
							</label>
							<label class='radio-inline' >
								<input type='radio' name="ltype" value='2' <?php  if($list['settings']['ltype']==2) { ?>checked<?php  } ?> onclick="$('.zhibo').hide();$('.dianbo').show();"/> 点播
							</label>
						</div>
					</div>

					<div class="form-group aliyun" style="<?php  if($list['type']=='6') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">阿里云</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<label class='radio-inline' >
								<input type='radio' name="lltype" value='1' <?php  if($list['settings']['lltype']==1) { ?>checked<?php  } ?> />直播
							</label>
							<label class='radio-inline' >
								<input type='radio' name="lltype" value='2' <?php  if($list['settings']['lltype']==2) { ?>checked<?php  } ?> /> 点播
							</label>
						</div>
					</div>
					<div class="form-group aliyun" style="<?php  if($list['type']=='6') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">视频封面</label>
						<div class="col-sm-9 col-xs-12">
							<?php  echo tpl_form_field_image("limg", $list['settings']['limg'])?>
							<div class="help-block"><font style="color: red">最佳尺寸：1280*720px</font></div>
						</div>
					</div>
					<div class="form-group aliyun" style="<?php  if($list['type']=='6') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"> rtmp （电脑端播放用）</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="lrtmp" value="<?php  echo $list['settings']['lrtmp'];?>">
						</div>
					</div>
					<div class="form-group aliyun" style="<?php  if($list['type']=='6') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">hls（手机端播放用）</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="lhls" value="<?php  echo $list['settings']['lhls'];?>">
							<span class="help-block">请填写【.M3U8】结尾的视频流地址</span>
						</div>
					</div>

					<div class="form-group zhibo leshis" style="<?php  if($list['type']=='1' && $list['settings']['ltype']==1) { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">乐视云id</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="activity_id" value="<?php  echo $list['settings']['activity_id'];?>">
							<span class="help-block">乐视云id 例：
								<a href="javascript:;" data-toggle="modal" data-target="#subscribeurl">点击查看</a>
							</span>
						</div>
					</div>
					<div class="form-group dianbo leshis" style="<?php  if($list['type']=='1' && $list['settings']['ltype']==2) { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">乐视云点播uu</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="uu" value="<?php  echo $list['settings']['uu'];?>">
							<span class="help-block">乐视云点播uu</span>
						</div>
					</div>
					<div class="form-group dianbo leshis" style="<?php  if($list['type']=='1' && $list['settings']['ltype']==2) { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">乐视云点播vu</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="vu" value="<?php  echo $list['settings']['vu'];?>">
							<span class="help-block">乐视云点播vu</span>
						</div>
					</div>
					<div class="form-group dianbo leshis" style="<?php  if($list['type']=='1' && $list['settings']['ltype']==2) { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">乐视云点播pu</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="pu" value="<?php  echo $list['settings']['pu'];?>">
							<span class="help-block">乐视云点播pu、可以不填写</span>
						</div>
					</div>
					<div class="form-group daima" style="<?php  if($list['type']=='3') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">播放器代码</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<textarea style="height:100px;" id='daima' name="daima" class="form-control" cols="60"><?php  echo $list['settings']['daima'];?></textarea>
							<span class="help-block">播放器代码</span>
						</div>
					</div>
					<div class="form-group xiongmao" style="<?php  if($list['type']=='4') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"> 熊猫直播房间号</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="xmroomid" value="<?php  echo $list['settings']['xmroomid'];?>">
						</div>
					</div>
					<div class="form-group  yy" style="<?php  if($list['type']=='9') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"> sid</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="sid" value="<?php  echo $list['settings']['sid'];?>">
						</div>
					</div>
					<div class="form-group  yy" style="<?php  if($list['type']=='9') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"> ssid</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="ssid" value="<?php  echo $list['settings']['ssid'];?>">
						</div>
					</div>
					<div class="form-group  yy" style="<?php  if($list['type']=='9') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"> tpl</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="tpl" value="<?php  echo $list['settings']['tpl'];?>">
						</div>
					</div>
					<div class="form-group qg" style="<?php  if($list['type']=='10') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"> 房间id</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="qgid" value="<?php  echo $list['settings']['qgid'];?>">
						</div>
					</div>
					<div class="form-group qg" style="<?php  if($list['type']=='10') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">房间类别</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<label class='radio-inline' >
								<input type='radio' name="qgtype" value='1' <?php  if($list['settings']['qgtype']==1) { ?>checked<?php  } ?> />类别一
							</label>
							<label class='radio-inline' >
								<input type='radio' name="qgtype" value='2' <?php  if($list['settings']['qgtype']==2) { ?>checked<?php  } ?> /> 类别二
							</label>
							<label class='radio-inline' >
								<input type='radio' name="qgtype" value='3' <?php  if($list['settings']['qgtype']==3) { ?>checked<?php  } ?> /> 类别三
							</label>
						</div>
					</div>
					<div class="form-group xsd" style="<?php  if($list['type']=='8') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"> 小水滴底座的sn码</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="xsdroomid" value="<?php  echo $list['settings']['xsdroomid'];?>">
							<span class="help-block">建议设置一条引导关注的素材链接。例:
								<a href="javascript:;" data-toggle="modal" data-target="#subscribeurl2">点击查看</a>
							</span>
						</div>

					</div>
					<div class="form-group huajiao" style="<?php  if($list['type']=='5') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"> 花椒直播房间号</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<input type="text" class="form-control" name="hjroomid" value="<?php  echo $list['settings']['hjroomid'];?>">
						</div>
					</div>
					<div class="form-group tupian" style="<?php  if($list['type']=='7') { ?>display:block<?php  } else { ?>display:none<?php  } ?>">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">图片</label>
						<div class="col-sm-8 col-lg-9 col-xs-12">
							<?php  echo tpl_form_field_image('pic', $list['settings']['pic']);?>
						</div>
					</div>
		  </div>
    </div>
</div>
<div class="modal fade" id="subscribeurl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content" style="width:740px;">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">乐视云id</h4>
					</div>
					<div class="modal-body">
						
						<img src="../addons/wxz_wzb/template/js/le.png">
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
					</div>
				</div>
			</div>
		</div>
	<div class="form-group">
			<div class="col-sm-12">
				<input name="submit" type="submit" value="提交" class="btn btn-success" />
				<input type="hidden" name="row_id" value="<?php  echo $list['id'];?>" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
			</div>
	</div>
</form>
<div class="modal fade" id="subscribeurl2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content" style="width:740px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">小水滴sn示例</h4>
			</div>
			<div class="modal-body">
				<img src="/addons/wxz_wzb/template/images/xsd.jpg" style="width:100%">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>