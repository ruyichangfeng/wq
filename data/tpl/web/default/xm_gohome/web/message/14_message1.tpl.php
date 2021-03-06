<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li><a href="<?php  echo  $this->createWebUrl('message', array('foo'=>'index'));?>">短信设置[短信宝]</a></li>
    <li class="active"><a href="<?php  echo  $this->createWebUrl('message', array('foo'=>'aly'));?>">短信设置[阿里大鱼]</a></li>    
</ul>

<div class="clearfix">
    <div class="panel panel-info">
        <div class="panel-heading">短信配置：只需在短信宝与阿里大鱼配置一个,目前短信平台为[
        <?php  if($selected == 0) { ?>
        暂无短信配置
        <?php  } ?>
        <?php  if($selected == 1) { ?>
        短信宝
        <?php  } ?>
        <?php  if($selected == 2) { ?>
        阿里大鱼
        <?php  } ?>
        ]<br>
        </div>
    </div>

    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('message', array('foo'=>'ok2'));?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>">
            <div class="panel-heading">
            	阿里大鱼设置
            </div>
            <div class="panel-body">
            	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">短信平台</label>
                    <div class="col-sm-9 col-xs-12">
                    	<select name="platform" id="platform" class="form-control  input-s-lg" >
                            <option value="2" selected >阿里大鱼</option>
                        </select>
                        
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否启用</label>
                    <div class="col-sm-9 col-xs-12">
                        <div>
                        <label class="radio-inline">
                            <input type="radio" name="selected" value="1" <?php  if($item['selected'] == 1) { ?> checked <?php  } ?>>启用
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="selected" value="0" <?php  if($item['selected'] == 0) { ?> checked <?php  } ?>>不启用
                        </label>
                        </div>
                        <span class="help_block" style="color:red;">启用后模块将使用阿里大鱼进行短信发送</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">
                        App Key
                    </label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="plat_name" id="plat_name" value="<?php  echo $item['plat_name'];?>" placeholder="" class="form-control">
                        <span class="help_block">
                            阿里大鱼安全配置中的App Key
                        </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">
                        App Serve
                    </label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="plat_pwd" id="plat_pwd" value="<?php  echo $item['plat_pwd'];?>" placeholder="" class="form-control">
                        <span class="help_block">
                            阿里大鱼安全配置中的App Serve
                        </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">签名</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="qianming" id="qianming" value="<?php  echo $item['qianming'];?>" placeholder="" class="form-control">
                        <span class="help_block"></span>
                    </div>
                </div>
                

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">填写说明</label>
                    <div class="col-sm-9 col-xs-12">
                        <span>
                        在阿里大鱼平台创建短信模板时，标签名称必须与本模块标签一致，例如本模块内的订单时间标签为 <span style="color:red;">{ftime}</span> ,则在阿里大鱼里面必须用<span style="color:red;">${ftime}</span><br>
                        </span>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        短信验证码
                    </div>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">短信验证码模板ID</label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" name="tempid" id="tempid" value="<?php  echo $item['tempid'];?>" placeholder="" class="form-control">

                                <span class="help_block" style="color:red;">在阿里大鱼添加短信模板时，模板内容定义参数如下，验证码：${code}、有效时间${time}</span>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">配置实例</label>
                            <div class="col-sm-9 col-xs-12">
                               你的验证码为${code},在${time}分钟内有效，请勿告诉他人
                            </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        派单短信
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">派单短信模板ID</label>
                        <div class="col-sm-9 col-xs-12">
                            <input type="text" name="pai_tempid" id="pai_tempid" value="<?php  echo $item['pai_tempid'];?>" placeholder="" class="form-control">
                            <span class="help_block" style="color:red;">在阿里大鱼添加短信模板时，模板内容定义参数如下，服务项目：${order}、用户昵称${nickname}、预约联系人${fname}、预约联系电话${fmobile}、服务地址${fadr}、服务时间${ftime}、预估价格${money}、下单时间${addtime}</span>
                        </div>
                    </div>

                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">配置实例</label>
                            <div class="col-sm-9 col-xs-12">
                               有新的订单,服务项目${order},联系人${username}，预计价格${money}，快打开微信查看
                            </div>
                    </div>
                </div>    

                <div class="panel panel-info">
                    <div class="panel-heading">
                        用户下单短信
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户下单短信通知</label>
                        <div class="col-sm-9 col-xs-12">
                        	<div>
                                <label class="radio-inline">
                                    <input type="radio" name="message1" value="1" <?php  if($item['message1'] == 1) { ?> checked <?php  } ?>>启用
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="message1" value="0" <?php  if($item['message1'] == 0) { ?> checked <?php  } ?>>不启用
                                </label>
                            </div>
                            <span style="color:red;">（谨慎选择!启用后，用户下单会给所有范围内的服务人员发送短信，如果服务人员较多
    会产生较大短信量）</span>
                        </div>
                    </div>

                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">下单短信模板ID</label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" name="msg1_tempid" id="msg1_tempid" value="<?php  echo $item['msg1_tempid'];?>" placeholder="" class="form-control">
                                <span class="help_block" style="color:red">在阿里大鱼添加短信模板时，模板内容定义参数如下，服务项目：${order}、用户昵称${nickname}、预约联系人${fname}、预约联系电话${fmobile}、服务地址${fadr}、服务时间${ftime}、预估价格${money}、下单时间${addtime}</span>
                            </div>
                    </div>

                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">配置实例</label>
                            <div class="col-sm-9 col-xs-12">
                               ${staff_name}抢单了，报价${offer}，请打开微信查看报价详情
                            </div>
                    </div>
                </div>    
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        抢单短信
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">抢单短信通知</label>
                        <div class="col-sm-9 col-xs-12">
                        	<div>
                                <label class="radio-inline">
                                    <input type="radio" name="message2" value="1" <?php  if($item['message2'] == 1) { ?> checked <?php  } ?>>启用
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="message2" value="0" <?php  if($item['message2'] == 0) { ?> checked <?php  } ?>>不启用
                                </label>
                            </div>
                            <span style="color:red;">（启用后，有服务人员抢单后，会给用户发送一条短信）</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">抢单短信模板ID</label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" name="msg2_tempid" id="msg2_tempid" value="<?php  echo $item['msg2_tempid'];?>" placeholder="" class="form-control">
                                <span class="help_block" style="color:red">在阿里大鱼添加短信模板时，模板内容定义参数如下，服务项目：${order}、用户昵称${nickname}、预约联系人${fname}、预约联系电话${fmobile}、服务地址${fadr}、服务时间${ftime}、预估价格${money}、下单时间${addtime}、抢单服务人员${staff_name}、服务人员电话${staff_mobile}、报价${offer}</span>
                            </div>
                    </div>

                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">配置实例</label>
                            <div class="col-sm-9 col-xs-12">
                               ${staff_name}抢单了，报价${offer}，请打开微信查看报价详情
                            </div>
                    </div>

                </div>    
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        选定服务人员短信
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">选定服务人员短信通知</label>
                        <div class="col-sm-9 col-xs-12">
                        	<div>
                                <label class="radio-inline">
                                    <input type="radio" name="message3" value="1" <?php  if($item['message3'] == 1) { ?> checked <?php  } ?>>启用
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="message3" value="0" <?php  if($item['message3'] == 0) { ?> checked <?php  } ?>>不启用
                                </label>
                            </div>
                            <span style="color:red;">（启用后，用户选定服务人员后，会给服务人员发送一条短信）</span>
                        </div>
                    </div>

                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">选定服务人员短信模板ID</label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" name="msg3_tempid" id="msg3_tempid" value="<?php  echo $item['msg3_tempid'];?>" placeholder="" class="form-control">
                                <span class="help_block" style="color:red">在阿里大鱼添加短信模板时，模板内容定义参数如下，服务项目：${order}、用户昵称${nickname}、预约联系人${fname}、预约联系电话${fmobile}、服务地址${fadr}、服务时间${ftime}、预估价格${money}、下单时间${addtime}、抢单服务人员${staff_name}、服务人员电话${staff_mobile}、报价${offer}</span>
                            </div>
                    </div>

                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">配置实例</label>
                            <div class="col-sm-9 col-xs-12">
                               ${staff_name}恭喜你被选中，你的报价${offer}元，被${nickname}选中，请在微信上查看服务详情。
                            </div>
                    </div>

                </div> 

                <div class="panel panel-info">
                    <div class="panel-heading">
                        服务人员确认价格短信
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务人员确定价格短信通知</label>
                        <div class="col-sm-9 col-xs-12">
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="message5" value="1" <?php  if($item['message5'] == 1) { ?> checked <?php  } ?>>启用
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="message5" value="0" <?php  if($item['message5'] == 0) { ?> checked <?php  } ?>>不启用
                                </label>
                            </div>
                            <span style="color:red;">（启用后，服务人员确认价格后，会给用户发送一条短信）</span>
                        </div>
                    </div>

                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">确认价格短信模板ID</label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" name="msg5_tempid" id="msg5_tempid" value="<?php  echo $item['msg5_tempid'];?>" placeholder="" class="form-control">
                                <span class="help_block" style="color:red">在阿里大鱼添加短信模板时，模板内容定义参数如下，服务项目：${order}、用户昵称${nickname}、预约联系人${fname}、预约联系电话${fmobile}、服务地址${fadr}、服务时间${ftime}、预估价格${money}、下单时间${addtime}、抢单服务人员${staff_name}、服务人员电话${staff_mobile}、报价${offer}、确认价格${suremoney}</span>
                            </div>
                    </div>

                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">配置实例</label>
                            <div class="col-sm-9 col-xs-12">
                               员工${staff_name}已完工，确认价格为${suremoney},请尽快付款。
                    </div>
                </div>    
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        外卖下单短信
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">外卖下单短信通知</label>
                        <div class="col-sm-9 col-xs-12">
                            <div>
                                <label class="radio-inline">
                                    <input type="radio" name="message4" value="1" <?php  if($item['message4'] == 1) { ?> checked <?php  } ?>>启用
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="message4" value="0" <?php  if($item['message4'] == 0) { ?> checked <?php  } ?>>不启用
                                </label>
                            </div>
                            <span style="color:red;">（启用后，用户下单以后，会给商铺负责人发送一条短信）</span>
                        </div>
                    </div>

                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">外卖下单短信模板ID</label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" name="msg4_tempid" id="msg4_tempid" value="<?php  echo $item['msg4_tempid'];?>" placeholder="" class="form-control">
                                <span class="help_block" style="color:red">在阿里大鱼添加短信模板时，模板内容定义参数如下，订单编号${ordernumber}、下单人姓名${realname}、下单人手机号码${fmobile}、送货地址${address}、下单金额${money}、下单时间${addtime}</span>
                            </div>
                    </div>

                    <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">配置实例</label>
                            <div class="col-sm-9 col-xs-12">
                               有订单了，订单编号${ordernumber},姓名${realname}，联系人${fmobile},下单金额${money},请打开微信查看。
                    </div>
                    
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
    </form>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>