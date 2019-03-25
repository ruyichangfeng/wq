<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>static/js/artDialog/skins/idialog.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/artDialog.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/plugins/iframeTools.js"></script>

<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('serveperson', array('foo'=>'index'));?>">服务人员管理</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('serveperson', array('foo'=>'add'));?>">添加服务人员</a></li>
</ul>

<div class="clearfix"> 
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="do" value="Serveperson" />
                <input type="hidden" name="foo" value="index" />
                <input type="hidden" name="m" value="xm_gohome" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">姓名</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="staff_name" id="staff_name" type="text" value="<?php  echo $_GPC['staff_name'];?>" placeholder="姓名">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">手机号码</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="staff_mobile" id="staff_mobile" type="text" value="<?php  echo $_GPC['staff_mobile'];?>" placeholder="手机号码">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">身份证号码</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="card" id="card" type="text" value="<?php  echo $_GPC['card'];?>" placeholder="身份证号码">
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
            服务人员列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	
                    	<td width="100">姓名</td>
                        <td width="100">性别</td>
                        <td width="100">手机号码</td>
				
                        <td width="100">余额</td>
                        <td width="100">个人审核</td>
                        <td width="150">已有证件</td>
                        <td width="400">操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	
                    	<td><?php  echo $val['staff_name'];?></td>
                        <td><?php  echo $this->getSex($val['sex'])?></td>
						<td><?php  echo $val['staff_mobile'];?></td>
                        
                        <td>￥<?php  echo $val['money'];?></td>
						<td>
						<?php  if($val['flag'] == 1) { ?>
                        	已审核
                        <?php  } else { ?>
                        	未审核
                        <?php  } ?>
						</td>
                        <td><?php  echo $val['card_all'];?></td>
                        
						<td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
                            	<input type="hidden" id="xiangqing<?php  echo $val['id'];?>" value="<?php  echo $_W['siteroot'];?>web/index.php?c=site&a=entry&id=<?php  echo $val['id'];?>&do=serveperson&foo=xiangqing&m=xm_gohome" />
                                <a class="btn btn-default" onclick="submit2(<?php  echo $val['id'];?>)"><i class="fa fa-edit"></i> 详情</a>

                                <?php  if($val['print_state'] == 0) { ?>
                                    <a class="btn btn-default" href="<?php  echo $this->createWebUrl('cloudprint',array('foo'=>'add', 'id'=>$val['id'], 'mrak'=>'staff'));?>"><i class="fa fa-print"></i>派发打印机</a>
                                <?php  } ?>

                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('serveperson',array('foo'=>'sheng','id'=>$val['id']));?>"><i class="fa fa-lock"></i>个人审核编辑</a>

                                <?php  if($val['sserve_type'] != '') { ?>
                                    <a class="btn btn-default" href="<?php  echo $this->createWebUrl('serveperson',array('foo'=>'projectsheng', 'id'=>$val['id']));?>"><i class="fa fa-lock"></i>项目审核</a>
                                <?php  } ?>

                                <input type="hidden" id="jump<?php  echo $val['id'];?>" value="<?php  echo $_W['siteroot'];?>web/index.php?c=site&a=entry&id=<?php  echo $val['id'];?>&do=serveperson&foo=chong&m=xm_gohome" />
                            	<a onclick="submitok(<?php  echo $val['id'];?>)" class="btn btn-default"><i class="fa fa-money"></i>充值</a>
                                
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('serveperson',array('foo'=>'chonglog', 'id'=>$val['id']));?>">
                                    <i class="fa fa-edit"></i> 财务流水
                                </a>

                                <?php  if($val['indextop'] == 0) { ?>
                                <a class="btn btn-default" onclick="sub(<?php  echo $val['id'];?>,1)">
                                    <i class="fa fa-edit"></i><span id="sub_text<?php  echo $val['id'];?>">首页推荐</span>
                                </a>
                                <?php  } else { ?>
                                <a class="btn btn-default" onclick="sub(<?php  echo $val['id'];?>,0)">
                                    <i class="fa fa-edit"></i><span id="sub_text<?php  echo $val['id'];?>">取消推荐</span>
                                </a>
                                <?php  } ?>

                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('serveperson',array('foo'=>'edit','id'=>$val['id']));?>"><i class="fa fa-edit"></i> 编辑</a>
                                <?php  if($val['staff_num'] == 0) { ?>
                                	<a class="btn btn-default" href="<?php  echo $this->createWebUrl('serveperson', array('foo'=>'delete','id'=>$val['id']))?>" onclick="return confirm('确认删除该服务人员?');"><i class="fa fa-remove"></i> 删除</a>
                                <?php  } else { ?>
                                	<a class="btn btn-default" href="" onclick="delinfo()"><i class="fa fa-remove"></i> 删除</a>
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
        
        <div class="panel-footer">
        	<a class="btn btn-default" href="<?php  echo $this->createWebUrl('serveperson', array('foo'=>'add'))?>">新增服务人员</a>
        </div>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>

<script>
function delinfo(){
	alert('该公司下还有服务人员，请删除服务人员后再来删除公司！');
	return false;	
}

function submitok(id){
    var url = document.getElementById('jump'+''+id+'').value;
    art.dialog.open(url,{
        id:'diaChong',
        title:'订单详情',
        width:'500px',
    });
}

function sub(id,state){
    $.ajax({
        url: "<?php  echo $this->createWebUrl('serveperson', array('foo'=>'subok'))?>",
        type:"POST",
        data:{"id":id, "zt":state},
        dataType:"json",
        success: function(res){
            if(res == 1){
                //document.getElementById('sub_text'+''+id+'').innerHTML = '已推荐';
                window.location.reload();
            }else{
                art.dialog({
                    time: 1,
                    content: '设置失败！'
                });
            }
        }
    });
}


function submit2(id){
    var url = document.getElementById('xiangqing'+''+id+'').value;
    art.dialog.open(url,{
        id:'diaInfo',
        title:'详情页面',
        width:'500px',
    });
}
</script>