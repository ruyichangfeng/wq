<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<form action="" method="post" class="form-horizontal" role="form" id="theform">
<div class="main">
	<div class="panel panel-default">
            <div class="panel-heading">
                红包接口参数(需认证服务号并开通微信支付,如果账号是订阅号也可以借用别人的账号)
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-13 col-sm-2 col-md-2 col-lg-2 control-label">商户logo</label>
                    <div class="col-sm-8">
                        <?php  echo tpl_form_field_image('logo',$item['logo'])?>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">发送公众号名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="sname" value="<?php  echo $item['sname'];?>" class="form-control">
                        <span class="help-block">发送红包时显示的公众号名称，不填使用默认的公众号,不能超过25个汉字！</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">红包活动名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="actname" value="<?php  echo $item['actname'];?>" class="form-control">
                        <span class="help-block">发送红包时显示的活动名称,不能超过10个汉字！</span>
                    </div>
                </div>

                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">发送祝福语</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="wishing" value="<?php  echo $item['wishing'];?>" class="form-control">
                        <span class="help-block">发送红包时显示的祝福语,不能超过100个汉字！</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">AppID</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="appid" value="<?php  echo $item['appid'];?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">AppSecret</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="secret" value="<?php  echo $item['secret'];?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商户号</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="mchid" value="<?php  echo $item['mchid'];?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商户支付密钥</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="password" value="<?php  echo $item['password'];?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务器IP</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="ip" value="<?php  echo $item['ip'];?>" class="form-control">
                        <span class="help-block">发放红包接口需要服务器IP. 程序将自动获取你的服务器IP, 如果获取失败, 请手动指定</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商户支付证书</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea class="form-control" name="apiclient_cert" rows="8" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接输入"></textarea>
                        <span class="help-block">从商户平台上下载支付证书, 解压并取得其中的 <mark>apiclient_cert.pem</mark> 用记事本打开并复制文件内容, 填至此处</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付证书私钥</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea class="form-control" name="apiclient_key" rows="8" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接输入"></textarea>
                        <span class="help-block">从商户平台上下载支付证书, 解压并取得其中的 <mark>apiclient_key.pem</mark> 用记事本打开并复制文件内容, 填至此处</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付根证书</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea class="form-control" name="rootca" rows="8" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接输入"></textarea>
                        <span class="help-block">从商户平台上下载支付证书, 解压并取得其中的 <mark>rootca.pem</mark> 用记事本打开并复制文件内容, 填至此处</span>
                    </div>
                </div>
                <div class="form-group">
				    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				    <div class="col-md-2 col-lg-1">
				         <input name="submit" type="submit" value="保存" class="btn btn-primary btn-block" />
				         <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				    </div>
				</div>
            </div>
        </div>
</div>

</form>
<script>
    require(['jquery', 'util'], function($, u) {
        $(function(){
            $('#theform').submit(function(){
                var message = '';
                if($.trim($(':text[name=appid]').val()) == '') {
                    message += '必须输入AppID<br>';
                }
                if($.trim($(':text[name=secret]').val()) == '') {
                    message += '必须输入AppSecret<br>';
                }
                if($.trim($(':text[name=mchid]').val()) == '') {
                    message += '必须输入微信支付商户号<br>';
                }
                if($.trim($(':text[name=password]').val()) == '') {
                    message += '必须输入微信支付商户密钥<br>';
                }
                if(message) {
                    u.message(message);
                    return false;
                }
                return true;
            });
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>