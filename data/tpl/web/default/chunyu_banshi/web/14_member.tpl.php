<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="panel panel-default mb10 mt1">
  <div class="panel-heading">
    <h3 class="panel-title">用户信息</h3>   
  </div>
  <div class="tab-content">
    <div>
    	<table class="table">
	    	<thead>
			<tr>
				<th>ID</th>
				<th>openid</th>
				<th>昵称</th>
				
				<th>登录时间</th>
				<th>操作</th>
			</tr>
		</thead>	
		<tbody>
			<?php  if(is_array($memberlist)) { foreach($memberlist as $key => $item) { ?>
			<tr>
				<td><?php  echo $item['mid'];?></td>
				<td><?php  echo $item['openid'];?></td>
				<td><?php  echo $item['nickname'];?></td>
				
				<td><?php  echo date('Y-m-d H:i:s', $item['createtime'])?></td>
				<td>
				<!-- <a href="<?php  echo $this->createWebUrl('yonghu_info',array('yongid'=>$item['mid']));?>" class="btn btn-primary btn-xs active" role="button">查看</a>&nbsp;&nbsp; -->
				<!-- <a href="<?php  echo $this->createWebUrl('wangge_edit',array('yongid'=>$item['wid']));?>" class="btn btn-primary btn-xs active" role="button">编辑</a>&nbsp;&nbsp; -->
				<a href="<?php  echo $this->createWebUrl('member_del',array('mid'=>$item['mid']));?>" class="btn btn-primary btn-xs active" role="button" onClick="return confirm('确定删除?');">删除</a></td>
			</tr>
			<?php  } } ?>
		</tbody>
	</table>
    </div>
  </div>
</div>

<?php  echo $pager;?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>