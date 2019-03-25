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
            <label for="" class="col-sm-2 control-label">团队介绍条数：</label>
            <div class="col-sm-4">
                <input type="number" class="form-control"  name="post[info_team]" value="<?php  echo $data['info_team'];?>" placeholder="团队介绍信息条数">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">服务项目条数：</label>
            <div class="col-sm-4">
                <input type="number" class="form-control"  name="post[info_service]" value="<?php  echo $data['info_service'];?>" placeholder="服务项目信息条数">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">案例展示条数：</label>
            <div class="col-sm-4">
                <input type="number" class="form-control"  name="post[info_item]" value="<?php  echo $data['info_item'];?>" placeholder="案例展示信息条数">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">幻灯片条数：</label>
            <div class="col-sm-4">
                <input type="number" class="form-control"  name="post[info_slide]" value="<?php  echo $data['info_slide'];?>" placeholder="幻灯片信息条数">
            </div>
        </div>
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