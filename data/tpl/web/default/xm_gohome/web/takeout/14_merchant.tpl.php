<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>static/js/artDialog/skins/idialog.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/artDialog.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/plugins/iframeTools.js"></script>

<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo $this->createWebUrl('takeout', array('foo'=>'list'));?>">商铺列表</a></li>
    <!--
    <li><a href="<?php  echo $this->createWebUrl('takeout', array('foo'=>'add'));?>">添加商铺</a></li>
    <li><a href="<?php  echo $this->createWebUrl('takeout', array('foo'=>'lido'));?>">商圈列表</a></li>
    <li><a href="<?php  echo $this->createWebUrl('takeout', array('foo'=>'lidoadd'));?>">添加商圈</a></li>
    <li><a href="<?php  echo $this->createWebUrl('takeout', array('foo'=>'type'));?>">品类列表</a></li>
    <li><a href="<?php  echo $this->createWebUrl('takeout', array('foo'=>'typeadd'));?>">添加品类</a></li>
    -->
</ul>

<div class="clearfix">
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="do" value="takeout" />
                <input type="hidden" name="foo" value="list" />
                <input type="hidden" name="m" value="xm_gohome" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">商铺名称</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="merchant_name" id="merchant_name" type="text" value="<?php  echo $_GPC['merchant_name'];?>" placeholder="商铺名称">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">联系电话</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="merchant_phone" id="merchant_phone" type="text" value="<?php  echo $_GPC['merchant_phone'];?>" placeholder="联系电话">
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-default">
    	<div class="panel-heading">
                商铺列表
        </div>
        <?php  if($list[0]['id'] == '') { ?>
        <div class="uinn">暂无数据</div>
        <?php  } else { ?>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td>商铺名称</td>
                        <td>电话</td>
                        <td>审核</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td>
                        	<p class="form-control-static"><?php  echo $val['merchant_name'];?></p>
                        </td>
                        <td>
                        	<p class="form-control-static"><?php  echo $val['merchant_phone'];?></p>
                        </td>
                        <td>
                            <p class="form-control-static"><?php  if($val['state'] == 0) { ?>未审核<?php  } else { ?>已审核<?php  } ?></p>
                        </td>
                        <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
                                <input type="hidden" id="xiangqing<?php  echo $val['id'];?>" value="<?php  echo $_W['siteroot'];?>web/index.php?c=site&a=entry&id=<?php  echo $val['id'];?>&do=takeout&foo=xiangqing&m=xm_gohome" />
                                <a class="btn btn-default" onclick="submit2(<?php  echo $val['id'];?>)"><i class="fa fa-edit"></i> 详情</a>
                                
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('takeout', array('foo'=>'add', 'id'=>$val['id']));?>"><i class="fa fa-edit"></i> 编辑</a>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('takeout', array('foo'=>'delete', 'id'=>$val['id']))?>" onClick="return confirm('确认删除?');"><i class="fa fa-remove"></i> 删除</a>
                                <?php  if($val['state'] == 0) { ?>
                                    <a class="btn btn-default" href="<?php  echo $this->createWebUrl('takeout', array('foo'=>'sheng', 'merchant_id'=>$val['id']))?>"><i class="fa fa-lock"></i> 审核</a>
                                <?php  } ?>

                                <input type="hidden" id="info<?php  echo $val['id'];?>" value="<?php  echo $_W['siteroot'];?>web/index.php?c=site&a=entry&id=<?php  echo $val['id'];?>&do=takeout&foo=recommend&m=xm_gohome" />
                                <a onclick="submit(<?php  echo $val['id'];?>)" class="btn btn-default"><i class="fa fa-thumbs-up"></i>推荐权值</a>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('menu', array('foo'=>'list', 'merchant_id'=>$val['id']))?>"><i class="fa fa-sitemap"></i> 商品类别管理</a>

                                <input type="hidden" id="activity<?php  echo $val['id'];?>" value="<?php  echo $_W['siteroot'];?>web/index.php?c=site&a=entry&id=<?php  echo $val['id'];?>&do=takeout&foo=activity&m=xm_gohome" />
                                <a class="btn btn-default" onclick="submit1(<?php  echo $val['id'];?>)"><i class="fa fa-group"></i> 优惠折扣</a>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('takeout', array('foo'=>'reports', 'merchant_id'=>$val['id']))?>"><i class="fa fa-desktop"></i> 订单列表</a>
                            </div>
                        </td>
                    </tr>
                    <?php  } } ?>
                    
                </tbody>
            </table>
        </div>
        <?php  } ?>
        
        <div class="panel-body text-center">
            <?php  echo $pager;?>
        </div>
        <!--
        <div class="panel-footer">
			<a class="btn btn-default" href="<?php  echo $this->createWebUrl('takeout',array('foo'=>'add'));?>">新增商铺</a>
        </div>
        -->
    </div>
</div>

<script type="text/javascript">
function submit(id){
    var url = document.getElementById('info'+''+id+'').value;
    art.dialog.open(url,{
        id:'diaPei',
        title:'订单详情',
        width:'500px',
    });
}

function submit1(id){
    var url = document.getElementById('activity'+''+id+'').value;
    art.dialog.open(url,{
        id:'diaPei',
        title:'活动页面',
        width:'500px',
    });
}

function submit2(id){
    var url = document.getElementById('xiangqing'+''+id+'').value;
    art.dialog.open(url,{
        id:'diaPei',
        title:'详情页面',
        width:'500px',
    });
}
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>