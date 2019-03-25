<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('list_nav', TEMPLATE_INCLUDEPATH)) : (include template('list_nav', TEMPLATE_INCLUDEPATH));?>
	<div class="panel panel-info">
			<div class="panel-heading">筛选</div>
			<div class="panel-body">
				<form action="./index.php" method="get" class="form-horizontal" role="form">
					<input type="hidden" name="c" value="site" />
					<input type="hidden" name="a" value="entry" />
					<input type="hidden" name="m" value="wxz_wzb" />
					<input type="hidden" name="rid" value="<?php  echo $rid;?>" />
					<input type="hidden" name="do" value="sendgiftlist" />
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">昵称</label>
						<div class="col-xs-12 col-sm-8 col-lg-9">
							<input class="form-control" name="nickname" id="" type="text" value="<?php  echo $_GPC['nickname'];?>" placeholder="昵称">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">openid</label>
						<div class="col-xs-12 col-sm-8 col-lg-9">
							<input class="form-control" name="openid" id="" type="text" value="<?php  echo $_GPC['openid'];?>" placeholder="openid">
						</div>
					</div>
					<div class="form-group" style="text-align:right;">
						<div class="col-xs-12 col-sm-8 col-lg-11">
							<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
							<a class="btn btn-default" href="<?php  echo $this->createWebUrl('sendgiftlist',array('type' =>'all','rid'=>$rid))?>">全部</a>
						</div>
					</div>
				</form>
			</div>
		</div>
    <!--模板设置-->
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-hover">
                <thead class="navbar-inner">
                <tr>
                    <th align="center" style="width:10%;text-align:center;">昵称</th>
                    <th align="center" style="width:10%;text-align:center;">头像</th>
                    <th align="center" style="width:10%;text-align:center;">礼物</th>
                    <th align="center" style="width:10%;text-align:center;">单价</th>
                    <th align="center" style="width:10%;text-align:center;">数量</th>
                    <th align="center" style="width:10%;text-align:center;">时间</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($ds)) { foreach($ds as $row) { ?>
                <tr>
                    <td align="center" style="text-align:center;"><?php  echo $row['nickname'];?></td>
                    <td align="center" style="text-align:center;"><img src="<?php  echo $row['headimgurl'];?>" width="60"></td>
                    <td align="center" style="text-align:center;"><img src="<?php  echo $row['pic'];?>" width="60"></td>
                    <td align="center" style="text-align:center;"><?php  echo $row['amount']/100?>元</td>
                    <td align="center" style="text-align:center;"><?php  echo $row['num']?></td>
                    <td align="center" style=" text-align:center;"><?php  echo date('Y-m-d H:i',$row['dateline'])?></td>
                </tr>
                <?php  } } ?>
                </tbody>
            </table>
            <?php  echo $pager;?>
        </div>
    </div>
</div>
</div>

</div>

<script>
    require(['bootstrap','util'],function($,util){
        $('button[name=btn-setting]').click(function(){
            setting.save_setting();
        });

        var setting = {
            save_setting:function(){
                $.ajax({
                    url: "<?php  echo wurl('site/entry/setting',array('m'=>'wxz_wzb','op'=>'setting','item'=>'ajax','key'=>'setting'));?>",
                    type: 'POST',
                    data: {
                        title: $("input[name='title']").val(),
                        logo: $("input[name='logo']").val(),
                        sub_title: $("input[name='sub_title']").val(),
                        share_img: $("input[name='share_img']").val(),
                        share_title: $("input[name='share_title']").val(),
                        share_desc: $("textarea[name='share_desc']").val(),
                        attention_url: $("input[name='attention_url']").val()
                    },
                    success:function(res){
                        if(res > 0){
                            util.message('消息提示: 设置成功','', 'success');

                        }else{
                            util.message('消息提示: 设置失败','', 'error');
                        }
                    },
                    error:function(){
                        alert('ajax error');
                    }
                });
            }
        }
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>