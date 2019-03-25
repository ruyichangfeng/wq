<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
    <ul class="we7-page-tab">
        <li class="active">网站基本信息设置</li>
    </ul>
    <div class="main" style="">
        <div class="btn-group" id="templist">
        </div>
        <form method="post" class="form-horizontal form" id="form" novalidate="novalidate" style="">
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">网站名称</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[name]" class="form-control" value="<?php  echo $data['name'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">网站icon</label>
                <div class="col-xs-12 col-sm-8">
                    <?php  echo tpl_form_field_image('post[icon]',$data['icon']);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">网站LOGO</label>
                <div class="col-xs-12 col-sm-8">
                    <?php  echo tpl_form_field_image('post[logo]',$data['logo']);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">网站关键字</label>
                <div class="col-xs-12 col-sm-8">
                    <textarea name="post[keyword]" class="form-control" cols="30" rows="2"><?php  echo $data['keyword'];?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">网站描述</label>
                <div class="col-xs-12 col-sm-8">
                    <textarea name="post[desc]" class="form-control" cols="30" rows="2"><?php  echo $data['desc'];?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">关于我们</label>
                <div class="col-xs-12 col-sm-8">
                    <textarea name="post[about]" class="form-control" cols="30" rows="2"><?php  echo $data['about'];?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">广告图</label>
                <div class="col-xs-12 col-sm-8">
                    <?php  echo tpl_form_field_image('post[ads]',$data['ads']);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">公司名称</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[company]" class="form-control" value="<?php  echo $data['company'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">公司地址</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[address]" class="form-control" value="<?php  echo $data['address'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">联系电话</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[tel]" class="form-control" value="<?php  echo $data['tel'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">邮箱</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[email]" class="form-control" value="<?php  echo $data['email'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">备案号</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[icp]" class="form-control" value="<?php  echo $data['icp'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">QQ</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[qq]" class="form-control" value="<?php  echo $data['qq'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">微博地址</label>
                <div class="col-xs-12 col-sm-8">
                    <input type="text" name="post[weibo]" class="form-control" value="<?php  echo $data['weibo'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">地图坐标</label>
                <div class="col-xs-12 col-sm-5">
                    <input type="text" name="post[map]" class="form-control" value="<?php  echo $data['map'];?>">
                </div>
                <label style="color: red;"><a href="http://api.map.baidu.com/lbsapi/getpoint/index.html" target="_blank">点击获取百度地图坐标</a> </label>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">公众号二维码</label>
                <div class="col-xs-12 col-sm-8">
                    <?php  echo tpl_form_field_image('post[qrcode]',$data['qrcode']);?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-9 col-md-10 col-lg-10 col-sm-offset-3 col-md-offset-2 col-lg-offset-2">
                    <input type="hidden" name="id" value="2">
                    <input name="submit" type="submit" value="提交" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript">
    </script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>