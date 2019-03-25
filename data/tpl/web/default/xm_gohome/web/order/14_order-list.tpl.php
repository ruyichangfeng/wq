<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>static/js/artDialog/skins/idialog.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/artDialog.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/plugins/iframeTools.js"></script>

<ul class="nav nav-tabs">
	<li class="<?php  if($serve_type == '0') { ?> active <?php  } ?>">
        <a href="<?php  echo  $this->createWebUrl('order', array('foo'=>'allorder'));?>">总订单表
        </a>
    </li>
    
    <?php  if(is_array($list1)) { foreach($list1 as $vo) { ?>
    <li class="<?php  if($vo['id'] == $serve_type) { ?> active <?php  } ?>">
        <a href="<?php  echo  $this->createWebUrl('order', array('id'=>$vo['id'],'temp_id'=>$vo['temp_id']));?>"><?php  echo $vo['type_name'];?></a>
    </li>
    <?php  } } ?>
    <!--
    <li><a href="<?php  echo  $this->createWebUrl('staffadd', array());?>">添加服务人员</a></li>
    -->
</ul>

<div class="clearfix">
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="do" value="order" />
                <input type="hidden" name="foo" value="index" />
                <input type="hidden" name="id" value="<?php  echo $serve_type;?>">
                <input type="hidden" name="m" value="xm_gohome" />

                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">用户姓名</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="realname" id="realname" type="text" value="<?php  echo $_GPC['realname'];?>" placeholder="用户姓名">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">订单模式</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <select name="mode" id="mode" class="form-control">
                            <option value="">选择订单模式</option>
                            <option value="1">抢单模式</option>
                            <option value="0">派单模式</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">手机号码</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="mobile" id="mobile" type="text" value="<?php  echo $_GPC['mobile'];?>" placeholder="手机号码">
                    </div>

                    <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
                        <!--
                        <div class="btn btn-info" onclick="dao()"><i class="fa fa-print"></i> 导出</div>
                        -->
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>

                <!--
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">状态</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <select class="form-control" name="state" id="state">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                </div>
                -->
            </form>
        </div>
    </div>  
       
    <div class="panel panel-default">
    	<div class="panel-heading">
            订单列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
        	<?php  if($text != '') { ?>
            	<?php  echo $text;?>
            <?php  } else { ?>
            	<?php  if($list2[0]['id'] != '') { ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td width="80">订单类型</td>
                            <td width="150">用户昵称</td>
                            <td width="80">用户姓名</td>
                            <td width="80">服务类别</td>
                            <td width="130">服务时间</td>
                            <td width="80">联系电话</td>
                            <td width="180">地址</td>
                            <td width="80">订单状态</td>
                            <td width="80">接单工人</td>
                            <td width="160">操作</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  if(is_array($list2)) { foreach($list2 as $val) { ?>
                        <tr>
                            <td><?php  if($val['mode'] == 0) { ?>派单模式<?php  } else { ?>抢单模式<?php  } ?></td>
                            <td style="white-space:normal;overflow: visible;"><?php  echo $this->getMemberInfo($val['openid'], 'nickname');?>&nbsp;&nbsp;
                            <?php  if($this->getBlackState($val['openid']) == 0) { ?>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('order',array('foo'=>'setuser', 'openid'=>$val['openid'], value=>1));?>">
                                    <i class="fa fa-edit"></i><font color="#FF0000">加入黑名单</font>
                                </a>
                            <?php  } else { ?>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('order',array('foo'=>'setuser', 'openid'=>$val['openid'], value=>0));?>">
                                    <i class="fa fa-edit"></i><font color="#FF0000">解除黑名单</font>
                                </a>
                            <?php  } ?>
                            </td>
                            <td style="white-space:normal;overflow: visible;"><?php  echo $this->getMemberInfo($val['openid'], 'realname');?>&nbsp;&nbsp;
                            <td style="white-space:normal;overflow: visible;"><?php  echo $this->getServeType($val['serve_type']);?></td>
                            <td style="white-space:normal;overflow: visible;"><?php  echo $this->getOrderInfo($val['table_name'],$val['other_id'],'ftime')?></td>
                            <td><?php  echo $this->getOrderInfo($val['table_name'],$val['other_id'],'fmobile')?></td>
                            <td style="white-space:normal;overflow: visible;"><?php  echo $this->getOrderInfo($val['table_name'],$val['other_id'],'fadr')?></td>
                            <td style="white-space:normal;overflow: visible;"><?php  echo $this->getOrderState($val['state'],$val['mode'])?></td>
                            <td style="white-space:normal;overflow: visible;">
                            <?php  if($val['state'] == 1) { ?>
                                <?php  echo $this->getStaffInfo($val['staff_id'], 'staff_name')?>
                            <?php  } ?>
                            <?php  if($val['state'] == 2) { ?>
                                <?php  echo $this->getStaffInfo($val['staff_id'], 'staff_name')?>
                            <?php  } ?>
                            </td>
                            <input type="hidden" id="jump<?php  echo $val['id'];?>" value="<?php  echo $_W['siteroot'];?>web/index.php?c=site&a=entry&order_id=<?php  echo $val['id'];?>&serve_type=<?php  echo $val['serve_type'];?>&do=order&foo=send&m=xm_gohome" />
                            <input type="hidden" id="jumps<?php  echo $val['id'];?>" value="<?php  echo $_W['siteroot'];?>web/index.php?c=site&a=entry&order_id=<?php  echo $val['id'];?>&serve_type=<?php  echo $val['serve_type'];?>&do=order&foo=pai&m=xm_gohome" />
                            <input type="hidden" id="info<?php  echo $val['id'];?>" value="<?php  echo $_W['siteroot'];?>web/index.php?c=site&a=entry&order_id=<?php  echo $val['id'];?>&serve_type=<?php  echo $val['serve_type'];?>&do=order&foo=info&m=xm_gohome" />
                            <td>
                                <div onclick="info_order(<?php  echo $val['id'];?>)" class="btn btn-default" href=""><i class="fa fa-edit"></i> 订单详情</div>
                                <?php  if($val['mode'] == 0) { ?>
                                    <?php  if($val['state'] == 0) { ?>
                                    <div onclick="send_order(<?php  echo $val['id'];?>)" class="btn btn-default" href=""><i class="fa fa-edit"></i> 派单</div>
                                    <?php  } else if($val['state'] == 1) { ?>
                                    <div onclick="send_order(<?php  echo $val['id'];?>)" class="btn btn-default"><i class="fa fa-edit"></i> 重新派单</div>
                                    <!--
                                    <div onclick="pai_order(<?php  echo $val['id'];?>)" class="btn btn-default"><i class="fa fa-edit"></i> 查看派单</div>
                                    -->
                                    <?php  } else { ?>
                                    <div class="btn btn-default"><i class="fa fa-edit"></i> 已完工</div>
                                    <!--
                                    <div onclick="ok_order(<?php  echo $val['id'];?>)" class="btn btn-default" href=""><i class="fa fa-edit"></i> 确认完工</div>
                                    -->
                                    <?php  } ?>
                                <?php  } ?>
                            </td>
                        </tr>
                        <?php  } } ?>
                        
                    </tbody>
                </table>
                <?php  } else { ?>
                	<span>暂无订单数据</span>
                <?php  } ?>
              <?php  } ?>  
        </div>
        
        <div class="panel-body text-center">
            <?php  echo $pager;?>
        </div>
        
        <div class="panel-footer">
        	
        </div>
    </div>

    <input type="hidden" id="dao" value="<?php  echo $_W['siteroot'];?>web/index.php?c=site&a=entry&serve_type=<?php  echo $serve_type;?>&do=order&foo=daoshow&m=xm_gohome" />
</div>

<script type="text/javascript">
	function send_order(id){
		var url = document.getElementById('jump'+''+id+'').value;
		art.dialog.open(url,{
			id:'diaOrder',
			title:'派单',
			width:'500px',
			
		});
	}
	
	function pai_order(id){
		var url = document.getElementById('jumps'+''+id+'').value;
		art.dialog.open(url,{
			id:'diaOrder1',
			title:'派单',
			width:'500px',
			
		});
	}
	
	function info_order(id){
		var url = document.getElementById('info'+''+id+'').value;
		art.dialog.open(url,{
			id:'diaOrder',
			title:'订单详情',
			width:'500px',
			
		});
	}

    function dao(){
        var url = document.getElementById('dao').value;
        art.dialog.open(url,{
            id:'diaOrder',
            title:'订单详情',
            width:'500px',
            
        });   
    }
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>