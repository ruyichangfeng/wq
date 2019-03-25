<?php

/*
 * 公用方法，已自动加载
 */
function form_field_multi_image($name, $value = array(), $options = array()) {
    global $_W;
    $options['multiple'] = true;
    $options['direct'] = false;
    $options['fileSizeLimit'] = intval($GLOBALS['_W']['setting']['upload']['image']['limit']) * 1024;
    if (isset($options['dest_dir']) && !empty($options['dest_dir'])) {
        if (!preg_match('/^\w+([\/]\w+)?$/i', $options['dest_dir'])) {
            exit('图片上传目录错误,只能指定最多两级目录,如: "we7_store","we7_store/d1"');
        }
    }
    $brief = intval($options['brief']);
    $s = '';
    if (!defined('TPL_INIT_MULTI_IMAGE')) {
        $s = '
<style>
.close {
    float: right;
    font-size: 21px;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity: .2;
}
.multi-img-details .multi-item em {
    position: absolute;
    top: 0;
    right: -14px;
}
.multi-img-details .multi-item {
    max-width: 100%;
    max-height: 150px;
    height: auto;
    margin-top: 15px;
}
.input-pic-desc {
    display: inline-block;
    padding: 6px 12px;
    margin-left: 10px;
    height: 64px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    white-space: nowrap;
    vertical-align: middle;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>
<script type="text/javascript">
	function uploadMultiImage(elm, brief) {
		var name = $(elm).next().val();
		util.image( "", function(urls){
			$.each(urls, function(idx, url){
                if(brief) {
                    $(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'./resource/images/nopic.jpg\\\'; this.title=\\\'图片未找到.\\\'" src="\'+url.url+\'" class="img-responsive img-thumbnail"><textarea name="\'+name+\'_brief[]" value="" class="input-pic-desc" placeholder="图片介绍"></textarea><input type="hidden" name="\'+name+\'[]" value="\'+url.url+\'"><em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>\');
                } else {
                    $(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'./resource/images/nopic.jpg\\\'; this.title=\\\'图片未找到.\\\'" src="\'+url.url+\'" class="img-responsive img-thumbnail"><input type="hidden" name="\'+name+\'[]" value="\'+url.url+\'"><em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>\');
                }
				});
		}, ' . json_encode($options) . ');
	}
	function deleteMultiImage(elm){
		$(elm).parent().remove();
	}
</script>';
        define('TPL_INIT_MULTI_IMAGE', true);
    }

    $s .= <<<EOF
<div class="input-group">
	<input type="text" class="form-control" readonly="readonly" value="" placeholder="批量上传图片" autocomplete="off">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button" onclick="uploadMultiImage(this,{$brief});">选择图片</button>
		<input type="hidden" value="{$name}" />
	</span>
</div>
<div class="input-group multi-img-details">
EOF;
    if (is_array($value) && count($value) > 0) {
        foreach ($value as $row) {
            $s .= '
<div class="multi-item">
	<img src="' . $row['url'] . '" onerror="this.src=\'./resource/images/nopic.jpg\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail">
	<input type="hidden" name="' . $name . '[]" value="' . $row['url'] . '" >';
            if($options['brief']) {
                $s .= '<textarea name="' . $name . '_brief[]" class="input-pic-desc" placeholder="图片介绍">' . $row['brief'] . '</textarea>';
            }
            $s.='<em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em>
</div>';
        }
    }
    $s .= '</div>';

    return $s;
}

function formatArrImage($image) {
    global $_W;
    if($image['url_webp']) {
        $image['real_url'] = $image['url'];
        $image['url'] = $image['url_webp'];
        $image['attachment'] = $image['url'];
        unset($image['url_webp']);
    } elseif(substr($image['url'],0,1) == '/'){

    } elseif(strpos($image['url'],'http') === false && $image['url']) {
        $image['attachment'] = $image['url'];
        $image['url'] = $_W['attachurl'] . $image['url'];

    } else {
        $image['attachment'] = $image['url'];
    }
    return $image;
}
?>
