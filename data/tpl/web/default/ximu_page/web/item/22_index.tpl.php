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
            <?php  for($__i = 0 ; $__i < $info_item ; $__i ++){?>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">案例<?php  echo $__i+1?></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control"  name="post[name][]" value="<?php  echo $data['name'][$__i];?>" placeholder="案例名称">
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control"  name="post[desc][]" value="<?php  echo $data['desc'][$__i];?>" placeholder="案例介绍">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">案例<?php  echo $__i+1?>图片</label>
                <div class="col-xs-12 col-sm-8">
                    <div class="mui-input-cell">
                        <?php  echo tpl_form_field_image('post[images][]',$data['images'][$__i])?>
                    </div>
                </div>
            </div>
            <?php  }?>

            <div class="form-group">

                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" name="submit" class="btn btn-default">

                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript">
    </script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>