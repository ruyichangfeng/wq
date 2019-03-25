<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<form action="" method="post" class="form-horizontal" role="form" id="theform">
<div class="main">
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>
	<div class="panel panel-default">
            <div class="panel-heading">
                红包接口参数(需认证服务号并开通微信支付,如果账号是订阅号也可以借用别人的账号)
            </div>
            <div class="panel-body">
				<input type="hidden" name="rid" value="<?php  echo $rid;?>" class="form-control">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 红包领取方式</label>
					<div class="col-sm-9 col-xs-12">
					    <label class='radio-inline' >
							<input type='radio' name='type' value='1' <?php  if($item['type']==1) { ?>checked<?php  } ?> />方式1：关注分享赢红包
						</label>
						<label class='radio-inline' >
							<input type='radio' name='type' value='2' <?php  if($item['type']==2) { ?>checked<?php  } ?> /> 方式2：关注邀请好友观看赢红包（根据带来的观看访客奖励）
						</label>
					<div class="help-block">1:关注分享后自动发放红包，2：分享每引入一位关注访客即可随机获取金额</div>
				</div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">最小金额</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="min" value="<?php  echo $item['min'];?>" class="form-control">
                        <span class="help-block">针对红包领取方式1，发送红包时的最小金额，单位(分),最少100分！</span>
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">最大金额</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="max" value="<?php  echo $item['max'];?>" class="form-control">
                        <span class="help-block">针对红包领取方式1，发送红包时的最大金额，单位(分),最多20000分！</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">奖励最小金额</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="reward_amount_min" value="<?php  echo $item['reward_amount_min'];?>" class="form-control">
                        <span class="help-block">针对红包领取方式2，每引入一个关注者奖励固定金额，单位(分)！</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">奖励最大金额</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="reward_amount_max" value="<?php  echo $item['reward_amount_max'];?>" class="form-control">
                        <span class="help-block">针对红包领取方式2，每引入一个关注者奖励固定金额，单位(分)！</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">预计发放总金额</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="pool_amount" value="<?php  echo $item['pool_amount'];?>" class="form-control">
                        <span class="help-block">预计发放总金额，红包发放总金额超过预计发放总金额。则不在发红包。 单位(分)！</span>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">提现最小金额</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="withdraw_min" value="<?php  echo $item['withdraw_min'];?>" class="form-control">
                        <span class="help-block">提现最小金额，最小金额为1元。100分 单位(分)！</span>
                    </div>
                </div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label">红包领取规则</label>
					<div class="col-sm-8 col-xs-12 col-md-9">
						<?php  echo tpl_ueditor('packet_rule',$item['packet_rule'])?>
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
                //if($.trim($(':text[name=type]').val()) == '') {
               //     message += '类型必须选择<br>';
               // }
                
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