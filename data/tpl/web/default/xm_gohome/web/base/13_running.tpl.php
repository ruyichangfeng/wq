<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'list'));?>">基本参数</a></li>
    <li class="active"><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'running'));?>">运营设置</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'question'));?>">常见问题</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'shuoming'));?>">服务说明</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('address', array('foo'=>'index'));?>">地区管理</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('lido', array('foo'=>'index'));?>">商圈管理</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('type', array('foo'=>'list'));?>">商铺类别</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'geren'));?>">个人加盟协议</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('base', array('foo'=>'fuwu'));?>">服务商加盟协议</a></li>
</ul>


<div class="clearfix">
    <div class="panel panel-info">
        <div class="panel-heading">
        系统运营设置
        </div>
    </div>

    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('base', array('foo'=>'runningok'));?>" method="post">
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>">
            
            <div class="panel-heading">
                运营管理
            </div>
            <div class="panel-body">
            	
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">运营模式</label>
                    <div class="col-sm-9 col-xs-12">
                    	<div>
                            <label class="radio-inline">
                                <input type="radio" name="type" value="1" <?php  if($item['type']==1) { ?> checked <?php  } ?> onClick="check(1)" >单项目运营
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" value="0" <?php  if($item['type']==0) { ?> checked <?php  } ?> onClick="check(2)">多项目运营
                            </label>
                        </div>
                    </div>
                </div>
                
                <div id="show">
                	<div class="form-group">
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">项目列表</label>
                        <div class="col-sm-9 col-xs-12">
                            <div>
                            <?php  if($list[0]['id'] == '') { ?>
                            	暂无项目<a href="<?php  echo  $this->createWebUrl('servechildadd', array());?>">点此添加项目</a>
                            <?php  } else { ?>
                                <?php  if(is_array($list)) { foreach($list as $vo) { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="type_id" value="<?php  echo $vo['id'];?>" <?php  if($item['type_id']==$vo['id']) { ?> checked <?php  } ?>><?php  echo $vo['type_name'];?>
                                    </label>
                                <?php  } } ?>
                            <?php  } ?>
                            </div>
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
<script>
$(document).ready(function(){
	init();	
});
	
function init(){
	var value="";
	var radio=document.getElementsByName("type");
	for(var i=0;i<radio.length;i++){
		if(radio[i].checked==true){
			value=radio[i].value;
			break;
		}
		
		if(value == 1){
			document.getElementById("show").style.display = 'block';
		}else{
			document.getElementById("show").style.display = 'none';
		}
	}
}
function check(type){
	if(type == 1){
		document.getElementById("show").style.display = 'block';
	}else{
		document.getElementById("show").style.display = 'none';
	}
}
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>