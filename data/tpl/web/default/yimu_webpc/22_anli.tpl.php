<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('tabs', TEMPLATE_INCLUDEPATH)) : (include template('tabs', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
	th,tr,td{
		border:1px solid #e2e2e2;
		overflow: hidden;
	}
.img{
	width:120px;
	height:80px;
	
	}
</style>
<div style="width: 100%; overflow: hidden;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="31" height="30" align="center">ID</td>
    <td width="24%" align="center">案例名称</td>
    <td width="24%" align="center">案例图片</td>
    <td width="24%" align="center">二维码</td>
    <td width="24%" colspan="2" align="center">操作</td>
  </tr>
 <?php  if(is_array($setting)) { foreach($setting as $index => $item) { ?>
  <tr style="border:1px solid #e2e2e2">
    <td height="100" align="center">&nbsp;</td>
    <td align="center"><?php  echo $item['name'];?></td>
    <td align="center">
    	<div class="img">
        	<img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $item['img'];?>" width="120" height="80">
        </div>
       
      </td>
    <td align="center">
    	<div class="img">
        	<img src="<?php  echo $_W['siteroot'];?>attachment/<?php  echo $item['code'];?>" width="120" height="80">
        </div>
       
    </td>
    <td align="center"><a href="<?php  echo $this->createWebUrl('intanli', array('anid' => $item['id']));?>" class="btn btn-default btn-sm">编辑</a></td>
    <td align="center"><a onclick="return confirm('确定删除该案例吗？')" href="<?php  echo $this->createWebUrl('del',array('anid'=>$item['id']))?>" class="btn btn-danger btn-sm" >删除</a></td>
  </tr>
  <?php  } } ?>
</table>
</div>