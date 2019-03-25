<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="we7-page-search we7-padding-bottom clearfix">
	<div class="pull-right">
		<?php  if(!defined('SYSTEM_WELCOME_MODULE')) { ?>
		<a href="<?php  echo $this->createWebUrl('article_post')?>" class="btn btn-primary we7-padding-horizontal">+新建文章</a>
		<?php  } else { ?>
		<a href="<?php  echo $this->createWebUrl('article_post', array('module_type' => 'system_welcome'))?>" class="btn btn-primary we7-padding-horizontal">+新建文章</a>
		<?php  } ?>
	</div>
	<form action="" method="get" class="form-inline">
		<input type="hidden" name="c" value="site">
		<input type="hidden" name="a" value="entry">
		<input type="hidden" name="do" value="article">
		<input type="hidden" name="m" value="<?php  echo $_W['current_module']['name'];?>">
		<?php  if(defined('SYSTEM_WELCOME_MODULE')) { ?><input type="hidden" name="module_type" value="system_welcome"><?php  } ?>
		<div class="input-group col-sm-5">
			<input class="form-control" name="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入标题名">
			<span class="input-group-btn"><button class="btn btn-default"><i class="fa fa-search"></i></button></span>
		</div>
	</form>
</div>
<!-- <form action="" method="post" class="we7-form" role="form"> -->
	<table class="table we7-table table-hover article-list vertical-middle">
		<!-- <col width="80px"> -->
		<col width="80px"/>
		<col/>
		<col width="170px"/>
		<col width="200px"/>
		<tr>
			<!-- <th></th> -->
			<th>排序</th>
			<th class="text-left">标题</th>
			<th>创建时间</th>
			<th class="text-right">操作</th>
		</tr>
		<?php  if(empty($article_list)) { ?>
		<tr>
			<td colspan="5" class="text-center">暂无数据</td>
		</tr>
		<?php  } else { ?>
		<?php  if(is_array($article_list)) { foreach($article_list as $key => $article) { ?>
		<tr>
			<!-- <td>
				<input type="checkbox" we7-check-all="1" name="rid[]" id="rid-<?php  echo $key;?>" value="<?php  echo $article['id'];?>">
				<label for="rid-<?php  echo $key;?>">&nbsp;</label>
			</td> -->
			<td><?php  echo $article['displayorder'];?></td>
			<td class="text-left" title="<?php  echo $article['title'];?>"><?php  echo mb_substr($article['title'], 0, 20, 'utf-8')?></td>
			<td><?php  echo $article['createtime'];?></td>
			<td>
				<div class="link-group">
					<?php  if(!defined('SYSTEM_WELCOME_MODULE')) { ?>
					<a href="<?php  echo $this->createWebUrl('article_post', array('id' => $article['id']))?>">编辑</a>
					<a href="<?php  echo $this->createWebUrl('article_del', array('id' => $article['id']))?>" class="del">删除</a>
					<a class="js-clip" href="javascript:;" data-url="<?php  echo $_W['siteroot'] . 'web/' . $this->createWebUrl('article_detail', array('id' => $article['id'], 'uniacid' => $_W['uniacid'], 'direct' => 1))?>">复制链接</a>
					<?php  } else { ?>
					<a href="<?php  echo $this->createWebUrl('article_post', array('id' => $article['id'], 'module_type' => 'system_welcome'))?>">编辑</a>
					<a href="<?php  echo $this->createWebUrl('article_del', array('id' => $article['id'], 'module_type' => 'system_welcome'))?>" class="del">删除</a>
					<a class="js-clip" href="javascript:;" data-url="<?php  echo $_W['siteroot'] . 'web/' . $this->createWebUrl('article_detail', array('id' => $article['id'], 'direct' => 1, 'module_type' => 'system_welcome'))?>">复制链接</a>
					<?php  } ?>
					
					<!-- <a href="<?php  echo $this->createWebUrl('qrcode', array('id' => $article['id']))?>">下载二维码</a> -->
				</div>
			</td>
		</tr>
		<?php  } } ?>
		<?php  } ?>
	</table>
<!-- 	<div class="pull-left we7-margin-top">
		<input type="checkbox" we7-check-all="1" name="rid[]" id="select_all" value="1" ng-style="{'margin-left': '30px'}">
		<label for="select_all">&nbsp;</label>
		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		<input type="submit" class="btn btn-danger" name="submit" value="删除" onclick="if(!confirm('确定删除吗？')) return false;"/>
	</div> -->
	<div class="text-right we7-margin-top">
		<?php  echo $pager;?>
	</div>
<!-- </form> -->
<script>
	// $('#select_all').click(function(){
	// 	$('.article-list :checkbox').prop('checked', $(this).prop('checked'));
	// });
	
	$('.js-clip').each(function(){
		util.clip(this, $(this).attr('data-url'));
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>