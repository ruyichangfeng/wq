<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('tcjg', array('op' => 'display'))?>">套餐宣传图</a></li>
    <li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('tcjg', array('op' => 'post'))?>">套餐内容</a></li>
    <li <?php  if($op == 'fu') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('tcjg', array('op' => 'fu'))?>">套餐服务</a></li>
</ul>
<?php  if($op == 'display') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">套餐宣传图添加</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">顶部标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入顶部标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('img', $item['img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传底部宣传图（建议尺寸750x280）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图大标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="img_title" id="img_title" value="<?php  echo $item['img_title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入宣传图大标题（注：建议不超过10个字）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图小标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="img_name" id="img_name" value="<?php  echo $item['img_name'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入宣传图小标题（注：建议不超过10个字）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图介绍</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="img_js" id="img_js" value="<?php  echo $item['img_js'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入宣传图介绍（注：建议不超过10个字）</div>
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
<div class="pull-right">
    <a href="<?php  echo $this->createWeburl('tcjg', array('op'=>'posts'));?>"  class="btn btn-primary we7-padding-horizontal" style="margin-bottom: 20px">套餐内容添加</a>
</div>
<form class="form-horizontal" action="" method="post">
    <table class="table we7-table table-hover article-list vertical-middle">
        <tr>
            <td>ID</td>
            <td>套餐图片</td>
            <td>套餐标题</td>
            <td>套餐小标题</td>
            <td class="text-right">操作</td>
        </tr>
        <?php  if(is_array($products)) { foreach($products as $item) { ?>
        <tr>
            <td><?php  echo $item['id'];?></td>
            <td style="width: 150px">
                <img src="<?php  echo tomedia($item['img']);?>" width="100px" alt="">
            </td>
            <td>
                <?php  echo $item['title'];?>
            </td>
            <td>
                <?php  echo $item['f_title'];?>
            </td>
            <td class="text-right">
                <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('tcjg', array('id' => $item['id'], 'op' =>'posts'))?>" >编辑</a>
                <a class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('tcjg', array('id' => $item['id'], 'op' => 'delete'))?>">删除</a>
            </td>
        </tr>
        <?php  } } ?>
    </table>
</form>
<?php  } ?>
<?php  if($op == 'posts') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">套餐内容添加</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-1">标题</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">套餐标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">小标题</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="f_title" id="f_title" value="<?php  echo $item['f_title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">套餐小标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">套餐图片</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <?php  echo tpl_form_field_image('img', $item['img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">上传套餐图片</div>
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
<?php  if($op == "fu") { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">套餐服务添加</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">套餐服务内容</label>
                <div class="form-controls col-sm-8">
                    <?php  echo tpl_ueditor('about', $item['about']);?>
                    <div class="help-block">请输入图文详情</div>
                </div>
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
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>