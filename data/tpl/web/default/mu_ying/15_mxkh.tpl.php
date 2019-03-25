<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('mxkh', array('op' => 'display'))?>">明星客户</a></li>
    <li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('mxkh', array('op' => 'post'))?>">案例内容</a></li>
</ul>
<?php  if($op == 'display') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">明星客户描述添加</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">头部标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入头部标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('img', $item['img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传头部宣传图（建议尺寸750x280）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">描述</label>
                <div class="form-controls col-sm-5">
                    <textarea rows="6" cols="20" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  name="jianjie" id="jianjie"><?php  echo $item['jianjie'];?></textarea>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入客户描述</div>
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
    <a href="<?php  echo $this->createWeburl('mxkh', array('op'=>'posts'));?>"  class="btn btn-primary we7-padding-horizontal" style="margin-bottom: 20px">客户案例添加</a>
</div>
<form class="form-horizontal" action="" method="post">
    <table class="table we7-table table-hover article-list vertical-middle">
        <tr>
            <td>ID</td>
            <td>客户姓名</td>
            <td>客户介绍</td>
            <td>全家福</td>
            <td>入职时间</td>
            <td>套餐类型</td>
            <td>房型</td>
            <td class="text-right">操作</td>
        </tr>
        <?php  if(is_array($products)) { foreach($products as $item) { ?>
        <tr>
            <td><?php  echo $item['id'];?></td>
            <td><?php  echo $item['name'];?></td>
            <td><?php  echo $item['title'];?></td>
            <td style="width: 150px">
                <img src="<?php  echo tomedia($item['img']);?>" width="100px" alt="">
            </td>
            <td><?php  echo $item['start_time'];?>至<?php  echo $item['end_time'];?></td>
            <td>
                <?php  echo $item['leixing'];?>
            </td>
            <td>
                <?php  echo $item['fangxing'];?>
            </td>
            <td class="text-right">
                <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('mxkh', array('id' => $item['id'], 'op' =>'posts'))?>" >编辑</a>
                <a class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWebUrl('mxkh', array('id' => $item['id'], 'op' => 'delete'))?>">删除</a>
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
                <label for="" class="control-label col-sm-1">客户姓名</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="name" id="name" value="<?php  echo $item['name'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">客户姓名</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">客户介绍</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">客户介绍</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">全家福</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <?php  echo tpl_form_field_image('img', $item['img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">上传全家福</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">入职时间</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <?php  echo tpl_form_field_daterange('Time',array('start'=>$item['start_time'],'end'=>$item['end_time']));?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">上传入职时间</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">套餐类型</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="leixing" id="leixing" value="<?php  echo $item['leixing'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">套餐类型</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">房型</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="fangxing" id="fangxing" value="<?php  echo $item['fangxing'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">房型</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">客户简介</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <textarea rows="6" cols="20" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  name="jianjie" id="jianjie"><?php  echo $item['jianjie'];?></textarea>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">客户简介</div>
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