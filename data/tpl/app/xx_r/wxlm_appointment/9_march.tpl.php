<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php  echo $this->config['system_name']?></title>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('head', TEMPLATE_INCLUDEPATH)) : (include template('head', TEMPLATE_INCLUDEPATH));?>
    <link href="<?php echo RES;?>mobile/css/style_admin.css" rel="stylesheet" type="text/css">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
</head>
<body style="background: url(<?php echo RES;?>mobile/images/bac.png) no-repeat;padding-bottom: 40px;">
<form action="" method="post" enctype="multipart/form-data" id="form">
    <div class="fg2-index-title">商户入驻</div>
    <div class="fg2-imgbox" id="fg2-imgbox">

    </div>
    <div id="filediv">
        <a id="file_1" href="javascript:;" class="file">选择文件
            <input type="file" id="doc_1"  name="file[]"  multiple="multiple"  style="width:80%;" onchange="javascript:setImagePreviews(1);" accept="image/*" />
        </a>
    </div>

    <input type="text" name="march[march_business_name]" class="form-control"  placeholder="申请商家名称">
    <input type="text" name="march[march_admin_name]" class="form-control"  placeholder="负责人">
    <input type="tel"  name="march[march_admin_tel]" class="form-control" placeholder="负责人电话">
    <a href="javascript:sumbmitForm();" class="fg2-index-sub">先提交认证 </a>
    <div class="fg2-index-text"><span style="color: red">*</span>上传营业执照、手持身份证和授权书</div>
</form>
  <script src="<?php echo RES;?>mobile/js/pinterest_grid.js" type="text/javascript"></script>
<script type="text/javascript">

    $(function(){

        $("#fg2-imgbox").pinterest_grid({
            // no_columns: 10,
            padding_x: 0,
            padding_y: 0,
            margin_bottom: 0,
            single_column_breakpoint: 200
        });
    });

    var $li = $("<li></li>");

    function setImagePreviews(id) {
        var docObj = document.getElementById("doc_"+id);
        var dd = document.getElementById("fg2-imgbox");
        // dd.innerHTML = "";
        var fileList = docObj.files;
        for (var i = 0; i < fileList.length; i++) {
            dd.innerHTML += "<div  class='article' style='float:left'> <img id='img_"+id +'_'+ i + "'  /> </div>";
            var imgObjPreview = document.getElementById("img_"+id+'_'+i);
            if (docObj.files && docObj.files[i]) {
                //火狐下，直接设img属性
                imgObjPreview.style.display = 'block';
                imgObjPreview.style.width = '100%';
                // imgObjPreview.style.height = '180px';
                //imgObjPreview.src = docObj.files[0].getAsDataURL();
                //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式
                imgObjPreview.src = window.URL.createObjectURL(docObj.files[i]);
            }

        }
        $("#file_"+id).css("display","none");


        var  newid = id + 1;

        var str ='<a href="javascript:;" class="file" id="file_'+newid+'">选择文件 <input type="file"  name="file[]" id="doc_'+newid+'" multiple="multiple"  style="width:80%;" onchange="javascript:setImagePreviews('+newid+');" accept="image/*" /></a>';

        $("#filediv").append(str);


        return true;
    }
</script>
<script>
    function sumbmitForm() {

        if ($('input[name="file[1]"]').val() == '')
        {
            alert('请先上传相关证书图片;');
            return false;
        }

        if ($('input[name="march[march_business_name]"]').val() == '')
        {
            alert('请填写入驻商家名称;');
            return false;
        }

        if ($('input[name="march[march_admin_name]"]').val() == '')
        {
            alert('请填写入负责人姓名;');
            return false;
        }

        if ($('input[name="march[march_admin_tel]"]').val() == '')
        {
            alert('请填写入负责人电话;');
            return false;
        }

        $('#form').submit();

    }
</script>
<script>;</script><script type="text/javascript" src="http://simplife.cc/app/index.php?i=9&c=utility&a=visit&do=showjs&m=wxlm_appointment"></script></body>
</html>