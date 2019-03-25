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
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">分类</label>
                <div class="col-xs-12 col-sm-8">
                    <textarea name="post[group]" class="form-control" cols="30" rows="10" placeholder="internation:国际新闻|economics:经济新闻"><?php  echo $data['content']['group'];?></textarea>
                    <label style="color: #b32419">分类,以|作为分割。例:&nbsp;internation:国际新闻|economics:经济新闻</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">状态</label>
                <div class="col-xs-12 col-sm-8">
                    <div class="col-xs-12 col-sm-8">
                        <input type="checkbox" class="js-switch" value="1" name="post[status]" data-value="<?php  echo $data['content']['status'];?>" >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-9 col-md-10 col-lg-10 col-sm-offset-3 col-md-offset-2 col-lg-offset-2">
                    <input type="hidden" name="id" value="<?php  echo $data['id'];?>">
                    <input name="submit" type="submit" value="提交" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/common/xmjscode', TEMPLATE_INCLUDEPATH)) : (include template('web/common/xmjscode', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>