<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'index'));?>">系统更新</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'ma'));?>">更新码更新</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'reset'));?>">重置系统</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'xiu'));?>">字段修复</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('version', array('foo'=>'power'));?>">分权管理</a></li>
</ul>

<div class="clearfix">    
    <form id="theform" class="form form-horizontal" action="<?php  echo $this->createWebUrl('version',array('foo'=>'downok'))?>" method="post" onsubmit="return check()">
    
            <div class="panel-body">
                <input type="hidden" name="new_version" value="<?php  echo $new_version;?>"  />
                <input type="hidden" name="old_version" value="<?php  echo $old_version;?>"  />
            </div>    
                <?php  if($new_version > $old_version) { ?>
                最新版本为<?php  echo $new_version/100?>，当前版本为<?php  echo $old_version/100?>,请点击"更新"按钮进行升级！<br/>
                <?php  } ?>
                
                
                <?php  if($new_version > $old_version) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-md-2 col-lg-1">
                        <div id="show_1">
                        <input name="submit" type="submit" value="更新" class="btn btn-primary btn-block" />
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        </div>
                        
                        <div id="show_2" style="display:none;" class="tx-c">更新中...</div>
                    </div>
                </div>
                <?php  } else { ?>
                当前已是最新版本,无须更新 *_^
                <?php  } ?>
                <?php  echo $dis;?>
       
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