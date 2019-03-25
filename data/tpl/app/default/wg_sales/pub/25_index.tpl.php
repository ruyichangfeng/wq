<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-title" content="xx">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>发布投稿</title>

    <script type="text/javascript" src="<?php  echo $_W['siteroot'];?>app/resource/js/app/util.js"></script>
    <script src="<?php  echo $_W['siteroot'];?>app/resource/js/require.js"></script>
    <script type="text/javascript" src="<?php  echo $_W['siteroot'];?>app/resource/js/lib/jquery-1.11.1.min.js?v=20160824"></script>
    <script type="text/javascript" src="<?php  echo $_W['siteroot'];?>app/resource/js/lib/mui.min.js?v=20160824"></script>
    <script type="text/javascript" src="<?php  echo $_W['siteroot'];?>app/resource/js/app/common.js?v=20160824"></script>
    <link href="<?php  echo $_W['siteroot'];?>app/resource/css/common.min.css?v=20160824" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo STATIC_ROOT;?>/css/uc-ad.css?id=123">

    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_ROOT;?>/css/wangEditor-mobile.min.css">

</head>
<body>
<ul class="ad-tab">
    <li data-id="1" <?php  if($cate==1){?>class="active"<?php  }?>>文章发布</li>
    <?php  if($ad==1){?><li data-id="2" <?php  if($cate==2){?>class="active"<?php  }?>>广告投放</li><?php  } ?>
</ul>

<div class="ad-tab-con">
    <form method="post" id="form">
        <input id="cate" name="cate" value="<?php  echo $cate;?>" type="hidden">
        <div class="con-list">
            <p>栏目：</p>
            <select name="category_id" style="height: 100%;">
                <?php  $ii=0; foreach($category as $value){ $ii++; ?>
                <option <?php  if($value['id'] == $article['category_id']){echo 'selected';}?> value="<?php  echo $value['id'];?>"><?php  echo $value['name'];?></option>
                <?php  } ?>
            </select>
        </div>
        <div class="con-list">
            <p>作者：</p>
            <input type="text" id="author" name="author" value="<?php  echo $article['author'];?>" placeholder="作者昵称" />
        </div>
        <div class="con-list">
            <p>标题：</p>
            <input type="text" id="title" name="title" value="<?php  echo $article['title'];?>" placeholder="请输入标题，最多25个字" />
        </div>
        <div class="con-textarea">
            <p class="con-textarea-p">内容：</p>
            <textarea id="textarea1" name="content" style="width:100%;height:100%;">
<?php  echo $article['content'];?>
                </textarea>
        </div>
        <ul class="upload-img">
            <?php  echo tpl_app_form_field_image('image', $article['image']);?>
        </ul>
    </form>

</div>
<button class="confirm-push">确定发布</button>
<div class="mask active" style="display: none;"></div>
<div class="push-suc-pop" style="display: none;">
    <span class="close-btn"></span>
    <p class="pop-p1">发布成功</p>
    <p class="pop-p2">感谢您的支持，请等待管理员审核！</p>
</div>


<script type="text/javascript" src="<?php echo STATIC_ROOT;?>/js/zepto.js"></script>
<script type="text/javascript" src="<?php echo STATIC_ROOT;?>/js/zepto.touch.js"></script>
<script type="text/javascript" src="<?php echo STATIC_ROOT;?>/js/wangEditor-mobile.min.js?id=123311"></script>
<script type="text/javascript">
    $(function () {
        $('.ad-tab li').click(function () {
            $('.ad-tab li').removeClass('active');
            $(this).addClass('active');
            $('#cate').val($(this).attr('data-id'));
        });
        $('.confirm-push').click(function () {
            if($('#title').val() == ''){
                alert('标题不能为空');
                return false;
            }


            // 获取编辑器区域
            var $txt = editor.$txt;

            // 查看对象
            console.log($txt);

            // 获取 html
            var html =  $txt.html();

            // 获取 text
            var text = $txt.text();
            if(text == '') {
                alert('内容不能为空');
                return false;
            }
            $('#form').submit();
        });

        // 全局配置
        // ___E.config.menus = ['bold', 'color', 'quote'];

        // 生成编辑器
        var editor = new ___E('textarea1');

        // 自定义配置
        //editor.config.uploadImgUrl = '/upload';

         editor.config.menus = ['head',
             'bold',
             'color',
             'quote',
             'list',
//             'img',
             'check'];

        // 初始化
        editor.init();

        console.log(editor.$txt);
    });
</script>
<script>;</script><script type="text/javascript" src="https://simplife.cc/app/index.php?i=25&c=utility&a=visit&do=showjs&m=wg_sales"></script></body>
</html>
