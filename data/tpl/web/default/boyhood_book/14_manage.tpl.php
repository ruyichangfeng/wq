<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li><a href="./index.php?c=platform&a=reply&do=post&m=<?php  echo $this->modulename?>">新建活动</a></li>
    <li <?php  if(!$op) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('manage')?>">预约活动</a></li>
    <li  <?php  if($op == 'post') { ?>class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('manage',array('op'=>'post'))?>">新增业务</a></li>
    <li <?php  if($op == 'display') { ?>class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('manage',array('op'=>'display'))?>">预约业务</a></li>
    <?php  if($op == 'record') { ?><li class="active" ><a>预约记录</a></li><?php  } ?>
</ul>
<style>
th{
	text-align: center !important;
}

td{
	text-align: center !important;
	white-space: normal !important;
	word-break: break-all !important;
}
</style>
<div class="main" style="background: white;">
    <div style="padding:15px;">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th>规则名称</th>					
                    <th>活动名称</th>
                    <th>活动时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $l) { ?>
                <tr>
                    <td><a href="./index.php?c=platform&a=reply&do=post&m=<?php  echo $this->modulename?>&rid=<?php  echo $l['rid'];?>"><?php  echo $l['name'];?></a></td>
                    <td><a href="./index.php?c=platform&a=reply&do=post&m=<?php  echo $this->modulename?>&rid=<?php  echo $l['rid'];?>"><?php  echo $l['title'];?></a></td>
                    <td>开始时间：<?php  echo date('Y-m-d H:i:s',$l['starttime'])?><br>结束时间：<?php  echo date('Y-m-d H:i:s',$l['endtime'])?></td>
                    <td>
                    	<a href='<?php  echo $this->createWebUrl("manage",array("op"=>"display","cate"=>$l["cate"]))?>' class="btn btn-info btn-sm">查看业务</a>
                    	<a href='<?php  echo $this->createWebUrl("manage",array("op"=>"record","rid"=>$l["rid"]))?>' class="btn btn-warning btn-sm">预约记录(<?php  echo $l['book'];?>)</a>
                    </td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>