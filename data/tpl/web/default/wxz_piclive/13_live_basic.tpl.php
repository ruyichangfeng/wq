<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>直播间标题</label>
	<div class="col-sm-9 col-xs-12">
		<input type="text" name="live_name" id="goodsname" class="form-control" value="<?php  echo $item['live_name'];?>" />
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">简介</label>
	<div class="col-sm-9 col-xs-12">
		<input type="text" name="live_brief" id="live_brief" class="form-control" value="<?php  echo $item['live_brief'];?>" />
	</div>
</div>
<!--<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">商品单位</label>
	<div class="col-sm-6 col-xs-6">
		<input type="text" name="unit" id="unit" class="form-control" value="<?php  echo $item['unit'];?>" />
		<span class="help-block">如: 个/件/包</span>
	</div>
</div>-->

<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">Banner图片（375*180）</label>
	<div class="col-sm-9 col-xs-12">
		<?php  echo tpl_form_field_image('live_img', $item['live_img'], '', array('extras' => array('text' => 'readonly')))?>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">开场图片（480*960）</label>
	<div class="col-sm-9 col-xs-12">
                <?php  echo tpl_form_field_image('original_img', $item['original_img'], '', array('extras' => array('text' => 'readonly')))?>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">水印大图</label>
	<div class="col-sm-9 col-xs-12">
                <?php  echo tpl_form_field_image('water_img', $item['water_img'], '', array('extras' => array('text' => 'readonly')))?>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">水印小图</label>
	<div class="col-sm-9 col-xs-12">
                <?php  echo tpl_form_field_image('water_thumb', $item['water_thumb'], '', array('extras' => array('text' => 'readonly')))?>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">直播日期</label>
	<div class="col-sm-4 col-xs-6">
		<?php echo tpl_form_field_date('start_date', !empty($item['start_date']) ? date('Y-m-d H:i',$item['start_date']) : date('Y-m-d H:i'), 1)?>
	</div>
	<div class="col-sm-4 col-xs-6">
		<?php echo tpl_form_field_date('end_date', !empty($item['end_date']) ? date('Y-m-d H:i',$item['end_date']) : date('Y-m-d H:i'), 1)?>
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">邀请规则说明</label>
	<div class="col-sm-9 col-xs-12">
		<input type="text" name="rule_brief" id="rule_brief" class="form-control" value="<?php  echo $item['rule_brief'];?>" />
	</div>
</div>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">HLS视频代码(头部banner位置)</label>
	<div class="col-sm-9 col-xs-12">
		<textarea name="video_code" class="form-control" rows="10" cols="70"><?php  echo $item['video_code'];?></textarea>注意：此处代码不为空时，显示，否则显示banner图片
	</div>
</div>

<script language="javascript">

	$(function () {
		var i = 0;
		$('#selectimage').click(function () {
			var editor = KindEditor.editor({
				allowFileManager: false,
				imageSizeLimit: '30MB',
				uploadJson: './index.php?act=attachment&do=upload'
			});
			editor.loadPlugin('multiimage', function () {
				editor.plugin.multiImageDialog({
					clickFn: function (list) {
						if (list && list.length > 0) {
							for (i in list) {
								if (list[i]) {
									html = '<li class="imgbox" style="list-type:none">' +
												'<a class="item_close" href="javascript:;" onclick="deletepic(this);" title="删除"></a>' +
												'<span class="item_box"> <img src="' + list[i]['url'] + '" style="height:80px"></span>' +
												'<input type="hidden" name="attachment-new[]" value="' + list[i]['filename'] + '" />' +
											'</li>';
									$('#fileList').append(html);
									i++;
								}
							}
							editor.hideDialog();
						} else {
							alert('请先选择要上传的图片！');
						}
					}
				});
			});
		});
	});

	function deletepic(obj) {
		if (confirm("确认要删除？")) {
			var $thisob = $(obj);
			var $liobj = $thisob.parent();
			var picurl = $liobj.children('input').val();
			$.post('<?php  echo $this->createMobileUrl('ajaxdelete',array())?>', {pic: picurl}, function (m) {
				if (m == '1') {
					$liobj.remove();
				} else {
					alert("删除失败");
				}
			}, "html");
		}
	}

</script>