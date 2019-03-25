<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
    <link rel="stylesheet" type="text/css" href="<?php  echo $static;?>/css/switch-style.css"/>
    <ul class="we7-page-tab">
        <?php  if(is_array($opList)) { foreach($opList as $index => $item) { ?>
            <?php  if($item['active'] == 1) { ?>
                <li class="active"><?php  echo $item['title'];?></li>
            <?php  } else { ?>
                <li><a href="<?php  echo $item['url'];?>"><?php  echo $item['title'];?></a></li>
            <?php  } ?>
        <?php  } } ?>
    </ul>
    <div class="main">
        <form method="post" class="form-horizontal form" id="form" novalidate="novalidate" >
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">标题</label>
                <div class="col-xs-12 col-sm-8">
                        <input type="text" name="post[title]" class="form-control" value="<?php  echo $data['title'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">图片</label>
                <div class="col-xs-12 col-sm-8">
                    <?php  echo tpl_form_field_image('post[images]',$data['images']);?>
                    <label style="color: #b32419">推荐尺寸：205X110</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">跳转链接</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[url]" class="form-control" value="<?php  echo $data['url'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">排序</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="number" name="post[order]" class="form-control" value="<?php  echo $data['order'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">状态</label>
                <div class="col-xs-12 col-sm-8">
                    <label class="radio-inline">
                        <input type="radio" name="post[status]" value="1" checked>开启
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="post[status]" value="0" <?php  if($data['status'] == 0) { ?>checked<?php  } ?>>关闭
                    </label>
                </div>
            </div>

            <input type="hidden" value="<?php  echo $data['id'];?>" name="post[id]">
            <div class="form-group">
                <div class="col-xs-12 col-sm-9 col-md-10 col-lg-10 col-sm-offset-3 col-md-offset-2 col-lg-offset-2">
                    <input type="hidden" name="id" value="2">
                    <input name="submit" type="submit" value="提交" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <script>
    </script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>