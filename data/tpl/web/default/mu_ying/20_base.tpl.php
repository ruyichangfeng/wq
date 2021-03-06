<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'display') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">基本信息设置</h3>
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
                <label for="" class="control-label col-sm-2" style="margin-right:45px">公司联系电话设置</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="tel" id="tel" value="<?php  echo $item['tel'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入联系电话（注：只能添加一个电话号码）</div>
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
                <label for="" class="control-label col-sm-2" style="margin-right:45px">幻灯片高度</label>
                <div class="form-controls col-sm-5">
                    <input type="number" name="slide_header" id="slide_header" value="<?php  echo $item['slide_header'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入幻灯片高度（如：不填默认300rpx, 填写数字即可）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">底部宣传图</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('db_img', $item['db_img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传底部宣传图（建议尺寸750x280）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">常见问题宣传图</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('wt_img', $item['wt_img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传常见问题宣传图（建议尺寸750x280）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">首页头条标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="headline" id="headline" value="<?php  echo $item['headline'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入首页头条标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">首页头条详情</label>
                <div class="form-controls col-sm-8">
                    <?php  echo tpl_ueditor('headline_text', $item['headline_text']);?>
                    <div class="help-block">请输入首页头条详情</div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">预约标题设置</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="yx_title" id="yx_title" value="<?php  echo $item['yx_title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入预约标题</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">预约优惠</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="yx_youhui" id="yx_youhui" value="<?php  echo $item['yx_youhui'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入预约优惠（如：申请即送200元通乳券）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">资讯标题</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="zx_title" id="zx_title" value="<?php  echo $item['zx_title'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入资讯标题（如：猜你喜欢）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">返回我们图标</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('sy_img', $item['sy_img'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请上传返回我们小图标</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">版权logo</label>
                <div class="form-controls col-sm-5">
                    <?php  echo tpl_form_field_image('bq_logo', $item['bq_logo'])?>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">上传灰色logo（图片尺寸：90x90）</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">版权</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="banquan" id="banquan" value="<?php  echo $item['banquan'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">底部版权</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">网址</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="wangzhi" id="wangzhi" value="<?php  echo $item['wangzhi'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入公司网址</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">跳转小程序的appid</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="appid" id="appid" value="<?php  echo $item['appid'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入跳转小程序的appid<span style="color: red">(注：必须是互相关联的小程序才可以跳转)</span></div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">小程序打开的页面路径</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="path" id="path" value="<?php  echo $item['path'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入小程序打开的页面路径<span style="color: red">（注：不填默认为首页）</span></div>
            </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
            <input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" style="margin-left: 45%;" />
        </div>
    </div>
</form>
<?php  } ?>
</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>