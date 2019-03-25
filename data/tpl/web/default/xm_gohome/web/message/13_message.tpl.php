<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li class="active"><a href="<?php  echo  $this->createWebUrl('message', array('foo'=>'index'));?>">短信设置[短信宝]</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('message', array('foo'=>'aly'));?>">短信设置[阿里大鱼]</a></li>    
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

    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('message', array('foo'=>'ok1'));?>" method="post" >
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>">
        
        <div class="panel panel-info">    
            <div class="panel-heading">
            	短信宝设置
            </div>
        </div>
            
            <div class="panel-body">
            	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">短信平台</label>
                    <div class="col-sm-9 col-xs-12">
                    	<select name="platform" id="platform" class="form-control  input-s-lg" >
                            <option value="1" selected>短信宝</option>
                        </select>
                        <span class="help_block">如果没有，<a href="http://www.smsbao.com/reg?r=10226" target="_blank">点此进行申请</a></span>
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
                        <span class="help_block" style="color:red;">启用后模块将使用短信宝进行短信发送</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户名</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="plat_name" id="plat_name" value="<?php  echo $item['plat_name'];?>" placeholder="" class="form-control">
                        <span class="help_block">在短信宝注册用户的用户名</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">
                        密码
                    </label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="plat_pwd" id="plat_pwd" value="" placeholder="不修改不用填写" class="form-control">
                        <span class="help_block">
                           在短信宝注册用户时的密码
                        </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">签名</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="qianming" id="qianming" value="<?php  echo $item['qianming'];?>" placeholder="欣媒互动" class="form-control">
                        <span class="help_block"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">标签说明</label>
                    <div class="col-sm-9 col-xs-12">
                        <span style="color:red;">
                        1. 服务类别：{order}、 服务时间：{ftime}、服务地点：{fadr}、预约所填联系人：{username}、预约所填电话：{fmobile}、预计价格：{money}、 用户昵称：{nickname}、 下单时间：{addtime}；<br>
                        2.在服务人员抢单后，除上述标签以外，还有服务人员姓名：{staff_name}，服务人员手机号码：{staff_mobile}服务人员报价：{offer}<br>
                        3.在服务完成以后，除上述标签以外，还有服务人员确认价格：{suremoney}；<br>
                        4.外卖下单，订单编号：{ordernumber}、下单人姓名：{realname}、下单人手机号码：{fmobile}、送货地址：{address}、下单金额：{money}、下单时间：{addtime}
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">填写说明</label>
                    <div class="col-sm-9 col-xs-12">
                        <span>
                        直接填写完整的短信内容即<br>
                        </span>
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
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">下单短信内容(标签)</label>
                        <div class="col-sm-9 col-xs-12">
                        	<textarea name="message1_content" id="message1_content" class="form-control" rows="6" placeholder="不启动不用填写"><?php  echo $item['message1_content'];?></textarea>
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
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">抢单短信内容(标签)</label>
                        <div class="col-sm-9 col-xs-12">
                        	<textarea name="message2_content" id="message2_content" class="form-control" rows="6" placeholder="不启动不用填写"><?php  echo $item['message2_content'];?></textarea>
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
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">选定服务人员短信内容(标签)</label>
                        <div class="col-sm-9 col-xs-12">
                            <textarea name="message3_content" id="message3_content" class="form-control" rows="6" placeholder="不启动不用填写"><?php  echo $item['message3_content'];?></textarea>
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
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">选定服务人员短信通知</label>
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
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">确认价格短信内容(标签)</label>
                        <div class="col-sm-9 col-xs-12">
                            <textarea name="message5_content" id="message5_content" class="form-control" rows="6" placeholder="不启动不用填写"><?php  echo $item['message5_content'];?></textarea>
                        </div>
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
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">外卖下单短信内容(标签)</label>
                        <div class="col-sm-9 col-xs-12">
                            <textarea name="message4_content" id="message4_content" class="form-control" rows="6" placeholder="不启动不用填写"><?php  echo $item['message4_content'];?></textarea>
                        </div>
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