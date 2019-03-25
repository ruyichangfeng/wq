<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'display') { ?>
<form class="form-horizontal" action="" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">邮箱配置</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">邮箱服务器地址</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="mailhost" id="mailhost" value="<?php  echo $item['mailhost'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">请输入域名邮箱的服务器地址</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">远程服务器端口号</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="mailport" id="mailport" value="<?php  echo $item['mailport'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">以前默认25,现在新的不可用,可选465或587</div>
            </div>
            
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">发件人邮箱</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="mailsend" id="mailsend" value="<?php  echo $item['mailsend'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">输入发件人邮箱</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">发件人姓名(昵称)</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="mailformname" id="mailformname" value="<?php  echo $item['mailformname'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">显示在收件人邮件的发件人邮箱地址前的发件人姓名</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">smtp登录账号</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="mailusername" id="mailusername" value="<?php  echo $item['mailusername'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">smtp登录的账号 这里填入字符串格式</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">smtp登录的密码</label>
                <div class="form-controls col-sm-5">
                    <input type="text" name="mailpassword" id="mailpassword" value="<?php  echo $item['mailpassword'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off">
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">smtp登录的密码</div>
            </div>
            <div class="form-group">
                <label for="" class="control-label col-sm-2" style="margin-right:45px">接收邮件的邮箱</label>
                <div class="form-controls col-sm-5">
                    <!-- <input type="text" name="mailhostname" id="mailhostname" value="<?php  echo $item['mailhostname'];?>" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  placeholder="" autocomplete="off"> -->
                    <textarea rows="6" cols="20" class="form-control ng-pristine ng-untouched ng-valid ng-empty"  name="mailhostname" id="mailhostname"><?php  echo $item['mailhostname'];?></textarea>
                </div>
                <div class="col-sm-1"></div>
                <div class="form-controls col-sm-3 help-block">设置接收邮箱地址（建议使用你的常用邮箱,多个邮箱用<font color="red">,</font>号【<font color="red">英文逗号</font>】分隔）</div>
            </div>
            
    <div class="form-group">
        <div class="col-sm-12">
            <input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
            <input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" />
        </div>
    </div>
</form>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>