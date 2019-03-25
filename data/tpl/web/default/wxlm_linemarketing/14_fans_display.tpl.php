<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">.xhred{ color:#F00;}</style>
<ul class="nav nav-tabs">
	<li class="active"><a href="<?php  echo $this->createWebUrl('fans', array('op'=>'display'));?>">粉丝信息管理</a></li>
	<!-- <?php  if($config['distribution_scale']!=0) { ?> -->
	<!-- <li ><a href="<?php  echo $this->createWebUrl('fans', array('op'=>'display2'));?>">上下级关系表</a></li> -->
	<!-- <?php  } ?> -->
</ul>

<div class="main">

    <div class="panel panel-primary">
             <div class="panel-heading" style="padding-top:0px; padding-bottom:0px;">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:#FFF; width:100%; line-height:40px;display:block;">
                    筛选 ↓  （点击可展开）
                </a>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <form action="" method="post" class="form-horizontal form" id="form">
                <div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">粉丝昵称</label>
					<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
						<input type="text" class="form-control" name="search[fans_nickname]" value="<?php  echo $data['search']['fans_nickname'];?>" placeholder="可模糊查询"/>
					</div>
				</div>
                <div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">粉丝姓名</label>
					<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
						<input type="text" class="form-control" name="search[fans_name]" value="<?php  echo $data['search']['fans_name'];?>"/>
					</div>
				</div>
                <div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">粉丝电话</label>
					<div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
						<input type="text" class="form-control" name="search[member_mobile]" value="<?php  echo $data['search']['member_mobile'];?>"/>
					</div>
				</div>
                <div class="form-group">
					<div class="col-xs-12 col-sm-9 col-md-10 col-lg-10 col-sm-offset-3 col-md-offset-2 col-lg-offset-2">
						<input name="submit" type="submit" value="搜索" class="btn btn-primary" style="width:10%;"/>
                        <input name="reset" type="button" value="清空" class="btn btn-primary" style="width:10%;" onclick="formreset()"/>
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <input type="hidden" name="searchflag" value="1" />
					</div>
				</div>
                </form>
            </div>
            </div>
        </div>

		<div class="panel panel-primary">
			<div class="panel-heading">粉丝信息管理</div>
			<div class="panel-body">
				<div class="table-responsive panel-body">
					<table class="table table-hover table-responsive" style="min-width: 300px;">
						<thead class="navbar-inner">
							<tr>
								<th style="width:6%;">序号</th>
								<th style="width:20%;">openid</th>
                                <th style="width:12%;">粉丝昵称</th>
                                <th style="width:17%;">粉丝姓名</th>
                                <th style="width:15%;">粉丝电话</th>
								<th style="width:25%;">操作</th>
							</tr>
						</thead>
						<tbody>
                            <?php  $i=($pindex-1)*$psize?>
                            <?php  if(is_array($data["records"])) { foreach($data["records"] as $key => $item) { ?>
                            <?php  $i++?>
							<tr>
								<td>
                                    <?php  echo $i;?>
								</td>
								<td>
                                    <?php  echo $item['fans_openid'];?>
								</td>
                                <td>
                                    <?php  echo $item['fans_nickname'];?>
								</td>
								<td>
                                    <?php  if($item['fans_name']=='') { ?>未编辑<?php  } else { ?><?php  echo $item['fans_name'];?><?php  } ?>
								</td>
								<td>
								 	<?php  if($item['fans_mobile']=='') { ?>未编辑<?php  } else { ?><?php  echo $item['fans_mobile'];?><?php  } ?>
								</td>
								<td>
									<a onclick="if(!confirm('删除后数据将不可恢复，确定要删除吗?')) return false;" href="<?php  echo $this->createWebUrl('fans', array('op'=>'delete', 'fans_id'=>$item['fans_id']));?>" class="btn btn-danger">删除</a>
								</td>
							</tr>
							<?php  } } ?>
							<?php  if(!empty($data["records"])) { ?>
							<tr>
								<td colspan="9">
									<!--<input name="submit" type="submit" value="保存" class="btn btn-primary" />-->
									<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
								</td>
							</tr>
							<?php  } else { ?>
							<tr>
								<td colspan="9">
									信息不存在！
								</td>
							</tr>
							<?php  } ?>
						</tbody>
					</table>
                    <div style="text-align:left;"><?php  echo $pagination;?></div>

				</div>
			</div>
		</div>
</div>






<script type="text/javascript">
function formreset()
{
	$('.form-control').val("");
	$("#member_state_0").prop("checked",'checked')
}
function submitjifen(id){
	var re = /^-?\\d+$/,
		type=$('input:radio[name="credit_type"]:checked').val();
	if($('#jine').val=='')
	{
		alert('请先填写充值分值，在进行提交');		
	}else if (type==1&&re.test($('#jine').val)){
		alert('积分分值必须为整数。');		
	}else{
		$.ajax({  
            type:"POST",
            url: "<?php  echo $this->createWebUrl('ajaxmember');?>",
            data:$('#jifenform'+id).serialize(),
            dataType:"json",
            // dataType:"text",
            async:false,
            success: function(data){
                if(data.result=='success')
                {
                	$('#credit'+data.type+id).html(data.rs);
                	$("#myModal"+id).modal('hide');
                }else{
                	alert('充值失败');
                }
            }
        });
	}		
}
function clearformss()
{
	$('#jine').val("");
}
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>