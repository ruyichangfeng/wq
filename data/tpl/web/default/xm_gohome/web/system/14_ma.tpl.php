<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'index'));?>">系统更新</a></li>
    <li class="active"><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'ma'));?>">更新码更新</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'reset'));?>">重置系统</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'xiu'));?>">字段修复</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'power'));?>">分权管理</a></li>
</ul>
<div class="clearfix">
<div><strong>更新码更新</strong>:更新码更新机制是针对个别站点的定制功能或者其它一些需针对特定站点推送的更新，一般由官方提供更新码后才能更新！</div>    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('version',array('foo'=>'downok'))?>" method="post" onsubmit="return check1()">
    
            <div class="panel-body">
              
            </div>    
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">更新码</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="singekey" id="singekey" placeholder="" class="form-control">
                        <span class="block-help"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-md-2 col-lg-1">
                        
                        <div id="show_11">
                        <input name="submit" type="submit" value="更新" class="btn btn-primary btn-block" />
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        </div>
                        
                        <div id="show_22" style="display:none;" class="tx-c">更新中...</div>
                       
                    </div>
                </div>
       
    </form>   
</div>

<script>
function check(){
	document.getElementById('show_1').style.display = 'none';
	document.getElementById('show_2').style.display = 'block';
}

function check1(){
	document.getElementById('show_11').style.display = 'none';
	document.getElementById('show_22').style.display = 'block';
}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>