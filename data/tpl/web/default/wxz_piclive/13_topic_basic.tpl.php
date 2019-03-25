<?php defined('IN_IA') or exit('Access Denied');?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">所属分类</label>
	<div class="col-sm-9 col-xs-12">
		<select name="topic_type" class='form-control'>
			<option value="0">请选择……</option>
			<?php  echo $live_type_list;?>
		</select>
	</div>
</div>
<!--<div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label">图片拍照方式</label>
        <div class="col-sm-9 col-xs-12">
                <label class="radio-inline">
                        <input type="radio" name="show_type" value="0" <?php  if($item['show_type'] == '0') { ?> checked<?php  } ?>> 横拍
                </label>
                <label class="radio-inline">
                        <input type="radio" name="show_type" value="1" <?php  if($item['show_type'] == '1') { ?> checked<?php  } ?>> 竖拍
                </label>
        </div>
</div>-->
<?php  if($remote_type == 3) { ?>
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
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">备注</label>
	<div class="col-sm-9 col-xs-12">
		<textarea name="topic_name" class="form-control" cols="70"><?php  echo $item['topic_name'];?></textarea>
	</div>
</div>
<?php  if($tid == 0) { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">图片</label>
	<div class="col-sm-9 col-xs-12">
		<?php  echo tpl_form_field_multi_image('original_img',$piclist)?>
	</div>
</div>
<?php  } else { ?>
<?php  if(is_array($multi_aid)) { foreach($multi_aid as $row) { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">图片</label>
	<div class="col-sm-9 col-xs-12">
		<?php  echo tpl_form_field_image('original_img[]', $row['picpath'], '', array('extras' => array('text' => 'readonly')))?>
		<input type="hidden" name="aid[]" value="<?php  echo $row['aid'];?>">
	</div>
</div>
<?php  } } ?>
<?php  } ?>

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