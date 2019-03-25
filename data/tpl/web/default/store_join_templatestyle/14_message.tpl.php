<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="main">
		<input type="hidden" name="id" value="<?php  echo $items['id'];?>" />
		<div class="panel panel-default">
			<div class="panel-heading">
				留言列表
			</div>
			<div class="panel-body">
				<div class="main panel panel-default">
					<div class="panel-body table-responsive">
						<table class="table table-hover">
							<thead class="navbar-inner">
								<tr>
									<th>ID</th>
								<!--	<th>标题</th>-->
									<th>姓名</th>
									<th>手机号</th>	
									<th>留言内容</th>
									<th>留言时间</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<?php  if(is_array($items)) { foreach($items as $va) { ?>
								<tr>
									<td><?php  echo $va['id'];?></td>
									<!--<td><?php  echo $va['title'];?></td>-->
									<td><?php  echo $va['zname'];?></td>
									<td><?php  echo $va['zphone'];?></td>
                                                                        <td>  <textarea class="form-control"><?php  echo $va['zmessage'];?></textarea></td>
									<td><?php  echo date('Y-m-d',$va['zcreate_time'])?></td>
									
									<?php  if($va['order']==1) { ?>
									<td style="color: green;">已回复</td>
									<?php  } else { ?>
									<td style="color: red;">待回复</td>
									 <?php  } ?>
									<td style="text-align:left;">
									<?php  if($va['order']==1) { ?>
									  <a href="<?php  echo $this->createWebUrl('operation', array('openid' => $va['openid'],'sid' => $va['id'],'zmessage' => $va['zmessage']))?>">编辑</a>
									  <?php  } else { ?>
									  <a href="<?php  echo $this->createWebUrl('operation', array('openid' => $va['openid'],'sid' => $va['id'],'zmessage' => $va['zmessage']))?>">编辑</a>
									  <?php  } ?>
									</td>
								</tr>
								<?php  } } ?>
							</tbody>
						</table>
						<?php  echo $pager;?>
					</div>
				</div>

			</div>
			