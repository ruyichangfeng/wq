<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('hjjs', array('op' => 'display'))?>">环境介绍</a></li>
    <li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('hjjs', array('op' => 'post'))?>">妈妈印象标签</a></li>
</ul>
<?php  if($op == 'display') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">环境介绍添加</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">环境介绍</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="hj" id="hj" value="<?php  echo $item['hj'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入环境介绍</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">护理经验</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="jy" id="jy" value="<?php  echo $item['jy'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入护理经验</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">分店名称</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="fd" id="fd" value="<?php  echo $item['fd'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入分店名称,多个用逗号隔开</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">服务妈妈数量</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="sl" id="sl" value="<?php  echo $item['sl'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入服务妈妈数量</div>
            </div>
      </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
            <input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" style="margin-left: 45%;" />
        </div>
    </div>
</form>
<?php  } ?>
<?php  if($op == 'post') { ?>
<form action="" method="post" class="form-horizontal form"  id="form1" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">妈妈印象标签</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">妈妈印象标签</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-4 col-xs-12">
                    <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
                    <input type="submit" name="submit" value="添加/修改" class="btn btn-primary col-lg-4">
                </div>
            </div>
        </div>
    </div>
</form>
<table class="table we7-table table-hover article-list vertical-middle">
    <tr>
        <td>ID</td>
        <td>标签</td>
        <td class="text-right">操作</td>
    </tr>
    <?php  if(is_array($products)) { foreach($products as $item) { ?>
    <tr>
        <td><?php  echo $item['id'];?></td>
        <td>
            <?php  echo $item['title'];?>
        </td>
        <td class="text-right">
            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('hjjs', array('id' => $item['id'], 'op' =>'post'))?>" >编辑</a>
            <a class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('hjjs', array('id' => $item['id'], 'op' => 'delete'))?>">删除</a>
        </td>
    </tr>
    <?php  } } ?>
</table>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>