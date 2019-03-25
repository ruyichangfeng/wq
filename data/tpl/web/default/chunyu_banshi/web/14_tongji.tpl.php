<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
	<div class="panel panel-success">
		<!-- Default panel contents -->
		<div class="panel-heading">统计信息</div>
		<div class="panel-body">
			<div class="container-fluid">
				<div class="row">

					<div class="col-xs-8">
						<table class="table table-bordered">
						 <tr>
						 <th style="text-align: center">信息分类</th>
						 <th style="text-align: center">统计数据</th>
						 </tr>
						 <tr>
						 <td>业务类别数量</td>
						 <td><?php  echo $typenum;?></td>
						 </tr>
						 <tr>
						 <td>业务流程数量</td>
						 <td><?php  echo $yewunum;?></td>
						 </tr>
						
						</table>
						

					</div>

					<div class="col-xs-4">
						
					</div>
				</div>
			</div>

		</div>

	</div>

<script>
	var editor=UE.getEditor('rule',ueditoroption);
	editor.addListener('contentChange',function(){});
	editor.addListener('ready',function(){});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
