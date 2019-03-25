<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>static/js/artDialog/skins/idialog.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/artDialog.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/plugins/iframeTools.js"></script>

<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('company', array('foo'=>'index'));?>">公司管理</a></li>
</ul>

<div class="clearfix"> 
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="do" value="company" />
                <input type="hidden" name="foo" value="index" />
                <input type="hidden" name="m" value="xm_gohome" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">公司名称</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="company_name" id="company_name" type="text" value="<?php  echo $_GPC['company_name'];?>" placeholder="公司名称">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">联系电话</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="mobile" id="mobile" type="text" value="<?php  echo $_GPC['mobile'];?>" placeholder="联系号码">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">公司地址</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="address" id="address" type="text" value="<?php  echo $_GPC['address'];?>" placeholder="公司地址">
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
            公司列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td width="250">OpenId</td>
                    	<td width="150">公司名称</td>
                        <td width="150">公司地址</td>
                        <td width="100">联系电话</td>
                        <td width="80">负责人</td>
                        <td width="100">负责人电话</td>
						<!--
						<td width="100">营业执照注册码</td>
						-->
                        <td width="80">余额</td>
                        <td width="80">公司审核</td>
                        <!--
                        <td width="100">身份验证</td>
                        -->
                        <td width="380">操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td><?php  echo $val['openid'];?></td>
                    	<td><?php  echo $val['company_name'];?></td>
                        <td><?php  echo $val['address'];?></td>
						<td><?php  echo $val['contact'];?></td>
						<td><?php  echo $val['staff_name'];?></td>
                        <td><?php  echo $val['staff_mobile'];?></td>
                        <td>￥<?php  echo $val['money'];?></td>
						<td>
						<?php  if($val['flag'] == 1) { ?>
                        	已审核
                        <?php  } else { ?>
                        	未审核
                        <?php  } ?>
						</td>
                        <!--
                        <td>
                        
                        <?php  if($val['openid'] == '') { ?>
                        未验证
                        <?php  } else { ?>
                        已验证
                        <?php  } ?>
                        </td>
                        -->
                       <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('company',array('foo'=>'sheng','id'=>$val['id']));?>">
                                    <i class="fa fa-lock"></i>公司审核
                                </a>
                                
                                <input type="hidden" id="jump<?php  echo $val['id'];?>" value="<?php  echo $_W['siteroot'];?>web/index.php?c=site&a=entry&id=<?php  echo $val['id'];?>&do=company&foo=chong&m=xm_gohome" />
                                <a class="btn btn-default" onclick="submit(<?php  echo $val['id'];?>)">
                                    <i class="fa fa-money"></i>充值
                                </a>

                                <?php  if($val['openid'] != '') { ?>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('company',array('foo'=>'look','id'=>$val['id']));?>">
                                    <i class="fa fa-user"></i>查看员工
                                </a>
                                <?php  } ?>

                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('company',array('foo'=>'chonglog', 'id'=>$val['id']));?>">
                                    <i class="fa fa-edit"></i> 财务流水
                                </a>

								<a class="btn btn-default" href="<?php  echo $this->createWebUrl('company',array('foo'=>'edit','id'=>$val['id']));?>">
                                    <i class="fa fa-edit"></i> 编辑
                                </a>
                                
                                <?php  if($val['staff_num'] == 0) { ?>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('company', array('foo'=>'delete','id'=>$val['id']))?>" onclick="return confirm('确认删除该公司?');">
                                    <i class="fa fa-remove"></i> 删除
                                </a>
                                <?php  } else { ?>
                                <a class="btn btn-default" onclick="delinfo()"><i class="fa fa-remove"></i> 删除</a>
                                <?php  } ?>
                            </div>
                        </td>
                    </tr>
                    <?php  } } ?>
                    
                </tbody>
            </table>
        </div>
        
        <div class="panel-body text-center">
            <?php  echo $pager;?>
        </div>
        
        <!--
        <div class="panel-footer">
        	<a class="btn btn-default" href="<?php  echo $this->createWebUrl('companyad', array('name'=>'xm_gohome'))?>">添加公司</a>
        </div>
        -->
        
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
<script>
function delinfo(){
	alert('该公司下还有服务人员，请删除服务人员后再来删除公司！');
	return false;	
}

function submit(id){
    var url = document.getElementById('jump'+''+id+'').value;
    art.dialog.open(url,{
        id:'diaChong',
        title:'订单详情',
        width:'500px',
    });
}
</script>