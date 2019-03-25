<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('gywm', array('op' => 'display'))?>">关于我们</a></li>
    <li <?php  if($op == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('gywm', array('op' => 'post'))?>">责任使命</a></li>
    <li <?php  if($op == 'content') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('gywm', array('op' => 'content'))?>">专业力量</a></li>
    <li <?php  if($op == 'fendian') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('gywm', array('op' => 'fendian'))?>">分店管理</a></li>
</ul>
<?php  if($op == 'display') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">关于我们</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">头部标题设置</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入头部标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">幻灯片</label>
                <div class="form-controls col-sm-5">
                     <?php  echo tpl_form_field_multi_image('slide',$item['slide']);?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">备注：上传的第一张就是最后一个显示（尺寸750x450）</div>
            </div>

            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">底部宣传图</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('img', $item['img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传底部宣传图（建议尺寸750x280）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">品牌标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="pinpai" id="pinpai" value="<?php  echo $item['pinpai'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入品牌标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">品牌简介</label>
                <div class="form-controls col-sm-5">
                    <textarea rows="6" cols="20" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  name="pinpai_jianjie" id="pinpai_jianjie"><?php  echo $item['pinpai_jianjie'];?></textarea>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入品牌简介</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">荣誉标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="rongyu" id="rongyu" value="<?php  echo $item['rongyu'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入荣誉标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">荣誉简介</label>
                <div class="form-controls col-sm-5">
                    <textarea rows="6" cols="20" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  name="miaoshu" id="miaoshu"><?php  echo $item['miaoshu'];?></textarea>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入荣誉简介</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">荣誉证书图片</label>
                <div class="form-controls col-sm-5">
                     <?php  echo tpl_form_field_multi_image('zhengshu',$item['zhengshu']);?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">备注：建议最多上传四张图片</div>
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
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">责任使命</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">责任简介</label>
                <div class="form-controls col-sm-5">
                    <textarea rows="6" cols="20" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  name="jianjie" id="jianjie"><?php  echo $item['jianjie'];?></textarea>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入责任简介</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">标签1</label>
                <div class="form-controls col-sm-2" style="margin-right: 15px">
                    <input type="text" name="bq1_name" id="bq1_name" value="<?php  echo $item['bq1_name'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="form-controls col-sm-2">
                    <input type="text" name="bq1_name2" id="bq1_name2" value="<?php  echo $item['bq1_name2'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="form-controls col-sm-3 help-block" style="padding-left: 15px">四字成语</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">标签1图片</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('bq1_img', $item['bq1_img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传图片（建议尺寸65x65）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">标签2</label>
                <div class="form-controls col-sm-2" style="margin-right: 15px">
                    <input type="text" name="bq2_name" id="bq2_name" value="<?php  echo $item['bq2_name'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="form-controls col-sm-2">
                    <input type="text" name="bq2_name2" id="bq2_name2" value="<?php  echo $item['bq2_name2'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="form-controls col-sm-3 help-block" style="padding-left: 15px">四字成语</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">标签2图片</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('bq2_img', $item['bq2_img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传图片（建议尺寸65x65）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">标签3</label>
                <div class="form-controls col-sm-2" style="margin-right: 15px">
                    <input type="text" name="bq3_name" id="bq3_name" value="<?php  echo $item['bq3_name'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="form-controls col-sm-2">
                    <input type="text" name="bq3_name2" id="bq3_name2" value="<?php  echo $item['bq3_name2'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="form-controls col-sm-3 help-block" style="padding-left: 15px">四字成语</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">标签3图片</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('bq3_img', $item['bq3_img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传图片（建议尺寸65x65）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图</label>
                <div class="form-controls col-sm-5">
                     <?php  echo tpl_form_field_multi_image('img',$item['img']);?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">备注：建议最多上传两张图片</div>
            </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
            <input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" style="margin-left: 45%;" />
        </div>
    </div>
</form>
<?php  } ?>
<?php  if($op == "content") { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">专业力量</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">专业力量简介</label>
                <div class="form-controls col-sm-5">
                    <textarea rows="6" cols="20" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  name="jianjie" id="jianjie"><?php  echo $item['jianjie'];?></textarea>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入专业力量简介</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图1</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('img1', $item['img1'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传宣传图（建议尺寸120x150）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图1标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="img1_title" id="img1_title" value="<?php  echo $item['img1_title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入宣传图2标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图2</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('img2', $item['img2'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传宣传图（建议尺寸120x150）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图2标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="img2_title" id="img2_title" value="<?php  echo $item['img2_title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入宣传图2标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图3</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('img3', $item['img3'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传宣传图（建议尺寸120x150）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">宣传图3标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="img3_title" id="img3_title" value="<?php  echo $item['img3_title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入宣传图3标题</div>
            </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
            <input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" style="margin-left: 45%;" />
        </div>
    </div>
</form>
<?php  } ?>
<?php  if($op == "fendian") { ?>
<div class="pull-right">
    <a href="<?php  echo $this->createWeburl('gywm', array('op'=>'fendians'));?>"  class="btn btn-primary we7-padding-horizontal" style="margin-bottom: 20px">添加分店</a>
</div>
<form class="form-horizontal" action="" method="post">
    <table class="table we7-table table-hover article-list vertical-middle">
        <tr>
            <td>分店地区</td>
            <td>分店名称</td>
            <td>简介</td>
            <td class="text-right">操作</td>
        </tr>
        <?php  if(is_array($products)) { foreach($products as $item) { ?>
        <tr>
            <td style="width: 100px;">
                <?php  echo $item['name'];?>
            </td>
            <td style="width: 100px;">
                <?php  echo $item['title'];?>
            </td>
            <td>
                <?php  echo $item['jianjie'];?>
            </td>
            <td class="text-right">
                <a class="btn btn-default btn-sm" href="<?php  echo $this->createWeburl('gywm', array('id' => $item['id'], 'op' =>'fendians'))?>" >编辑</a>
                <a class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认吗？'); return false;" href="<?php  echo $this->createWeburl('gywm', array('id' => $item['id'], 'op' => 'dd'))?>">删除</a>
            </td>
        </tr>
        <?php  } } ?>
    </table>
</form>
<?php  } ?>
<?php  if($op == 'fendians') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">添加分店</h3>
        </div>
        
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-1">分店地区</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="name" id="name" value="<?php  echo $item['name'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">分店地区</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">分店名称</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <input type="text" name="title" id="title" value="<?php  echo $item['title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">输入分店名称</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">轮播图</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <?php  echo tpl_form_field_multi_image('slide',$item['slide']);?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">上传轮播图</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1" style="margin-right:75px">宣传图</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('img', $item['img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传宣传图</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-1">简介</label>
                <div class="form-controls col-sm-5" style="margin-left: 75px;">
                    <textarea rows="6" cols="20" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  name="jianjie" id="jianjie"><?php  echo $item['jianjie'];?></textarea>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入分店简介</div>
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