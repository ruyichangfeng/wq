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
    <div class="main" style="">
        <div class="btn-group" id="templist">
        </div>
        <form method="post" class="form-horizontal form" id="form" novalidate="novalidate" style="">
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">合作伙伴</label>
                <div class="col-xs-12 col-sm-8">
                    <div class="mui-input-cell">
                        <?php  echo tpl_form_field_multi_image('post[images]',$data['images'])?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-9 col-md-10 col-lg-10 col-sm-offset-3 col-md-offset-2 col-lg-offset-2">
                    <input name="submit" type="submit" value="提交" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript">
    </script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>