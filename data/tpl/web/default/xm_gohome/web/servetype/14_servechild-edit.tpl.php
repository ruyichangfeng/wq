<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('servetype', array('foo'=>'index'));?>">服务项目管理</a></li>
    <li class="active"><a href="">修改服务项目</a></li>
</ul>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('servetype', array('foo'=>'editok'));?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>"  />
    <input type="hidden" name="old_parentid" value="<?php  echo $item['parent_id'];?>"  />

        <div class="panel panel-default">
            <div class="panel-heading">
                修改服务项目
            </div>
            <div class="panel-body">
            
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">所属父类</label>
                    <div class="col-sm-9 col-xs-12">
                        <select name="parent_id" id="parent_id" class="form-control  input-s-lg" onchange="check()">
                            <option value="0" <?php  if($item['parent_id'] == 0) { ?> selected <?php  } ?>>--做为根类别--</option>
                            <?php  if(is_array($list1)) { foreach($list1 as $vo1) { ?>
                            <option value="<?php  echo $vo1['id'];?>" <?php  if($item['parent_id']==$vo1['id']) { ?> selected <?php  } ?>><?php  echo $vo1['type_name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">类别名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="type_name" id="type_name" value="<?php  echo $item['type_name'];?>" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">超链接</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="chao" value="1"  onclick="check_link(1)" <?php  if($item['chao'] == 1) { ?> checked <?php  } ?>>启用
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="chao" value="0" onclick="check_link(0)" <?php  if($item['chao'] == 0) { ?> checked <?php  } ?>>不启用
                            </label>
                        </div>
						<span class="help-block">当启用超链接以后，以下设置都将失效，将直接跳转到超链接所指的地址</span>
                    </div>
                </div>
                
                <div id="link_show">
	                <div class="form-group">
	                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">链接地址</label>
	                    <div class="col-sm-9 col-xs-12">
	                        <input type="text" name="link" id="link" value="<?php  echo $item['link'];?>" class="form-control">
	                        <span class="help-block">链接地址必须已http://开头</span>	
	                    </div>
	                </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">显示图标[智能设备端]</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_form_field_image('icon',$item['icon']);?>
                        <span class="help-block">推荐尺寸：60*60</span>	
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">显示图标[PC端]</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_form_field_image('icon_pc',$item['icon_pc']);?>
                    </div>
                </div>
				
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">显示排序</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="top" id="top" value="<?php  echo $item['top'];?>" class="form-control">
						<span class="help-block">数字越小越靠前</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">项目简述</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea name="jianshu" id="jainshu" class="form-control"><?php  echo $item['jianshu'];?></textarea>
                        <span class="help-block">对项目的一个简单描述</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">项目说明</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_ueditor('remark', $item['remark']);?>
                        <span class="help-block">对项目的详细说明</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">模型名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <select name="temp_id" id="temp_id" class="form-control  input-s-lg">
                            <option value="">选择模型</option>
                            <?php  if(is_array($list2)) { foreach($list2 as $vo2) { ?>
                            <option value="<?php  echo $vo2['id'];?>" <?php  if($vo2['id'] == $item['temp_id']) { ?> selected="selected" <?php  } ?>><?php  echo $vo2['temp_name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单模式</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="mode" value="1" onclick="check_mode(1)" <?php  if($item['mode'] == 1) { ?> checked <?php  } ?>}>抢单模式
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="mode" value="0" onclick="check_mode(0)" <?php  if($item['mode'] == 0) { ?> checked <?php  } ?>>派单模式
                            </label>
                        </div>
						<span class="help-block"></span>
                    </div>
                </div>
                
                <div id="mode_show" style="display: none;">
                	<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                    		<label><input type="checkbox" name="temp_msg[]" value="1" <?php  if($item['temp_msg']==1) { ?> checked <?php  } ?>>消息推送</label>
                    		&nbsp;&nbsp;&nbsp;&nbsp;[推送openid添加]<input type="text" name="mode_openid" id="mode_openid" value="<?php  echo $item['mode_openid'];?>" class="form-control" >
                        </div>
						<span class="help-block" style="color:red;">有多个openid以半角逗号分割[openid在公司/工人列表中查看]<br/></span>
                    </div>
                    
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                    		<label><input type="checkbox" name="send_sms[]" value="1" <?php  if($item['send_sms']==1) { ?> checked <?php  } ?>>发送短信</label>
                    		&nbsp;&nbsp;&nbsp;&nbsp;[手机号码添加]<input type="text" name="mode_mobile" id="mode_mobile" value="<?php  echo $item['mode_mobile'];?>" class="form-control">
                        </div>
						<span class="help-block" style="color:red;">有多个手机号码以半角逗号分割</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">抢单报价</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="offer_state" value="1" <?php  if($item['offer_state'] == 1) { ?> checked <?php  } ?>>必填
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="offer_state" value="0" <?php  if($item['offer_state'] == 0) { ?> checked <?php  } ?>>可不填
                            </label>
                        </div>
						<span class="help-block">在服务人员抢单报价时，价格是否需要填写</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">第一抢单即为选定服务人员</label>
                    <div class="col-sm-9 col-xs-12">
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="first" value="1" <?php  if($item['first'] == 1) { ?> checked <?php  } ?>>开启
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="first" value="0" <?php  if($item['first'] == 0) { ?> checked <?php  } ?>>不开启
                            </label>
                        </div>
                        <span class="help-block">当订单推送后第一个抢单的服务人员即为选定服务人员</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">所需证件</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="cardname" id="cardname" value="<?php  echo $item['cardname'];?>" class="form-control">
						<span class="help-block">此项目所需证件，可为空，多个以||分割</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">市场价格</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="price" id="price" value="<?php  echo $item['price'];?>" class="form-control">
						<span class="help-block">服务项目的市场价格</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">优惠价格</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="price_unit" id="price_unit" value="<?php  echo $item['price_unit'];?>" class="form-control">
						<span class="help-block">服务项目的优惠价格</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">单位</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="unit" id="unit" value="<?php  echo $item['unit'];?>" class="form-control">
						<span class="help-block">及服务项目的计算单位，如：小时、单、次</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">平台佣金方式</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <input type="radio" name="gettype" value="1" onclick="check1(1)" <?php  if($item['gettype'] == 1) { ?> checked <?php  } ?>>按百分比
                            <input type="text" name="bili_bai" id="bili_bai" value="<?php  echo $item['bili_bai'];?>">%
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="gettype" value="0" onclick="check1(2)" <?php  if($item['gettype'] == 0) { ?> checked <?php  } ?>>按每单收费
                            <input type="text" name="bili_money" id="bili_money" value="<?php  echo $item['bili_money'];?>">元/单
                        </div>
                    </div>
                </div>
                
				
				<div id="show1">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">平台佣金峰值</label>
                    <div class="col-sm-9 col-xs-12">
                        保底：<input type="text" name="start" id="start" value="<?php  echo $item['start'];?>" >元
                        封顶：<input type="text" name="end" id="end" value="<?php  echo $item['end'];?>" >元
                        <span class="help-block" style="color:red;">封顶为0时，表示不封顶</span>
                    </div>
                </div>
				</div>
            
				
				
				<div id="show2">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">平台佣金结算</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="times" value="1" <?php  if($item['times'] == 1) { ?> checked <?php  } ?>>在选定人员时结算
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="times" value="0" <?php  if($item['times'] == 0) { ?> checked <?php  } ?>>在付款是结算
                            </label>
                        </div>
						<span class="help-block">本选项仅对平台佣金方式为按单计算生效</span>
                    </div>
                </div>
				</div>
				
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">抢单余额下限</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="basemoney" id="basemoney" value="<?php  echo $item['basemoney'];?>" class="form-control">
						<span class="help-block">服务人员余额低于此处设定值时不能抢单，设为0则可以一直抢单,设为负数服务人员可以欠款抢单</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">预付金金额</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="front" id="front" value="<?php  echo $item['front'];?>" class="form-control">
						<span class="help-block">用户下单时所需支付的预付金额，交预付金后才可执行后面的操作，设为0则不需要预付金，预付金在结算时会减去</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">预付金支付时间</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="payway" value="0" <?php  if($item['payway'] == 0) { ?> checked <?php  } ?>>提交预约订单
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="payway" value="1" <?php  if($item['payway'] == 1) { ?> checked <?php  } ?>>选定服务人员
                            </label>
                        </div>
						<span class="help-block"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单推送模板消息[给服务人员]</label>
                    <div class="col-sm-9 col-xs-12">
                    	<select name="otmpmsg_id" id="otmpmsg_id" class="form-control  input-s-lg">
                            <option value="0">选择模板消息</option>
                            <?php  if(is_array($list)) { foreach($list as $vo) { ?>
                            <option value="<?php  echo $vo['id'];?>" <?php  if($item['otmpmsg_id'] == $vo['id']) { ?> selected <?php  } ?>><?php  echo $vo['message_name'];?></option>
                            <?php  } } ?>
                        </select>
                        
                     <span class="help_block">当没有指定模板消息时使用指定的默认模板消息</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">抢单模板消息[给用户]</label>
                    <div class="col-sm-9 col-xs-12">
                    	<select name="qtmpmsg_id" id="qtmpmsg_id" class="form-control  input-s-lg">
                            <option value="0">选择模板消息</option>
                            <?php  if(is_array($list)) { foreach($list as $vo) { ?>
                            <option value="<?php  echo $vo['id'];?>" <?php  if($item['qtmpmsg_id'] == $vo['id']) { ?> selected <?php  } ?>><?php  echo $vo['message_name'];?></option>
                            <?php  } } ?>
                        </select>
                        
                     <span class="help_block">当没有指定模板消息时使用指定的默认模板消息</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">选定服务人员模板消息[给服务人员]</label>
                    <div class="col-sm-9 col-xs-12">
                    	<select name="xtmpmsg_id" id="xtmpmsg_id" class="form-control  input-s-lg">
                            <option value="0">选择模板消息</option>
                            <?php  if(is_array($list)) { foreach($list as $vo) { ?>
                            <option value="<?php  echo $vo['id'];?>" <?php  if($item['xtmpmsg_id'] == $vo['id']) { ?> selected <?php  } ?>><?php  echo $vo['message_name'];?></option>
                            <?php  } } ?>
                        </select>
                        
                     <span class="help_block">当没有指定模板消息时使用指定的默认模板消息</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推送范围</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="fanwei" value="5" <?php  if($item['fanwei']==5) { ?> checked <?php  } ?>>1公里
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="fanwei" value="4" <?php  if($item['fanwei']==4) { ?> checked <?php  } ?>>5公里
                            </label>
                            
                            <label class="radio-inline">
                                <input type="radio" name="fanwei" value="3" <?php  if($item['fanwei']==3) { ?> checked <?php  } ?>>40公里
                            </label>
                            
                            <label class="radio-inline">
                                <input type="radio" name="fanwei" value="2" <?php  if($item['fanwei']==2) { ?> checked <?php  } ?>>100公里
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="fanwei" value="0" <?php  if($item['fanwei']==0) { ?> checked <?php  } ?>>不限
                            </label>
                        </div>
						<span class="help-block"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否显示</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="stop" value="1" <?php  if($item['stop'] == 1) { ?> checked <?php  } ?>>是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="stop" value="0" <?php  if($item['stop'] == 0) { ?> checked <?php  } ?>>否
                            </label>
                        </div>
						<span class="help-block">可以控制此类型是否在页面显示</span>
                    </div>
                </div>
                
                <div class="panel-heading">
                	客服端个性定制【你填入的将会替换客服端相对应的文字显示】
            	</div>
                
                <div class="panel-body">
                	<div class="form-group">
	                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">预约时间=</label>
	                    <div class="col-sm-9 col-xs-12">
	                        <input type="text" name="diytime" id="diytime" placeholder="预约时间" value="<?php  echo $item['diytime'];?>" class="form-control">
	                        <span class="help_block">预约页面的预约时间</span>
	                    </div>
	                </div>
                </div>
                
                <div class="panel-body">
                	<div class="form-group">
	                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">联系电话=</label>
	                    <div class="col-sm-9 col-xs-12">
	                        <input type="text" name="diymobile" id="diymobile" placeholder="联系电话" value="<?php  echo $item['diymobile'];?>" class="form-control">
	                        <span class="help_block">预约页面的联系电话</span>
	                    </div>
	                </div>
                </div>
                
                <div class="panel-body">
                	<div class="form-group">
	                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">您的姓名=</label>
	                    <div class="col-sm-9 col-xs-12">
	                        <input type="text" name="diyname" id="diyname" placeholder="您的姓名" value="<?php  echo $item['diyname'];?>" class="form-control">
	                        <span class="help_block">预约页面的姓名</span>
	                    </div>
	                </div>
                </div>
                
                <div class="panel-body">
                	<div class="form-group">
	                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">上传图片=</label>
	                    <div class="col-sm-9 col-xs-12">
	                        <input type="text" name="diypic" id="diypic" placeholder="上传图片" value="<?php  echo $item['diypic'];?>" class="form-control">
	                        <span class="help_block">预约页面的上传图片</span>
	                    </div>
	                </div>
                </div>
                
                <div class="panel-body">
                	<div class="form-group">
	                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">详细地址=</label>
	                    <div class="col-sm-9 col-xs-12">
	                        <input type="text" name="diyaddress" id="diyaddress" placeholder="详细地址" value="<?php  echo $item['diyaddress'];?>" class="form-control">
	                        <span class="help_block">预约页面的详细地址</span>
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
        </div>
    </form>
</div>

<script>
$(document).ready(function(){  
	init();
}); 

function init(){
	var value_1="";
	var radio1=document.getElementsByName("chao");
	for(var i=0;i<radio1.length;i++){
		if(radio1[i].checked==true){
			value_1=radio1[i].value;
			break;
		}
	}
	if(value_1 == 1){
		document.getElementById('link_show').style.display = 'block';
	}else{
		document.getElementById('link_show').style.display = 'none';
	}
	
	var value_2="";
	var radio2=document.getElementsByName("mode");
	for(var k=0;k<radio2.length;k++){
		if(radio2[k].checked==true){
			value_2=radio2[k].value;
			break;
		}
	}
	if(value_2 == 0){
		document.getElementById('mode_show').style.display = 'block';
	}else{
		document.getElementById('mode_show').style.display = 'none';
	}
	
	var value="";
	var radio=document.getElementsByName("gettype");
	for(var j=0;j<radio.length;j++){
		if(radio[j].checked==true){
			value=radio[j].value;
			break;
		}
	}
	if(value==1){
		document.getElementById('show1').style.display = 'block';
		document.getElementById('show2').style.display = 'none';
	}else{
		document.getElementById('show1').style.display = 'none';
		document.getElementById('show2').style.display = 'block';
	}
}

function check1(id){
	if(id == 1){
		document.getElementById('show1').style.display = 'block';
		document.getElementById('show2').style.display = 'none';
	}else{
		document.getElementById('show1').style.display = 'none';
		document.getElementById('show2').style.display = 'block';
	}
}

function check(){
	var r = document.getElementById('parent_id').value;
	$.ajax({
		url: "<?php  echo $this->createWebUrl('servetype', array('foo'=>'checktype'));?>",
		type:"POST",
		data:{"id":r},
		dataType:"json",
		success: function(res){
			if(res > 0){
				location.reload();
				alert('您选择的所属父类下还有子类别，不能移动！');
			}
		}
	});
}

function check_link(id){
	if(id == 1){
		document.getElementById('link_show').style.display = 'block';
	}else{
		document.getElementById('link_show').style.display = 'none';
	}
}

function check_mode(id){
	if(id == 0){
		document.getElementById('mode_show').style.display = 'block';
	}else{
		document.getElementById('mode_show').style.display = 'none';
	}
}
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>