<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>static/js/artDialog/skins/idialog.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/artDialog.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>static/js/artDialog/plugins/iframeTools.js"></script>

<ul class="nav nav-tabs">
    <li><a href="<?php  echo  $this->createWebUrl('company', array('foo'=>'index'));?>">公司管理</a></li>
    <li class="active"><a href="<?php  echo  $this->createWebUrl('company', array('foo'=>'look', 'id'=>$id));?>">公司员工</a></li>
    <li><a href="<?php  echo  $this->createWebUrl('company', array('foo'=>'addstaff','id'=>$id));?>">添加员工</a></li>
</ul>

<div class="clearfix">
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="do" value="company" />
                <input type="hidden" name="foo" value="look" />
                <input type="hidden" name="id" value="<?php  echo $id;?>" />
                <input type="hidden" name="m" value="xm_gohome" />
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">员工姓名</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="staff_name" id=" staff_name" type="text" value="<?php  echo $_GPC['staff_name'];?>" placeholder="员工姓名">
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
            公司人员列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <?php  if($list[0]['id'] == '') { ?>
            <span>暂无数据</span>
            <?php  } else { ?>
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	
                        <td width="80">姓名</td>
                        <td width="100">性别</td>
                        <td width="150">手机号码</td>
						<td width="200">身份证</td>
                        <td>已有证件</td>
                        <td>公司名称</td>
						<td width="450">操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td><?php  echo $val['staff_name'];?></td>
                        <td><?php  echo $this->getSex($val['sex'])?></td>
						<td><?php  echo $val['staff_mobile'];?></td>
                        <td><?php  echo $val['card'];?></td>
                        <td><?php  echo $val['card_all'];?></td>
						<td><?php  echo $val['company_name'];?></td>
                        <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
                                <input type="hidden" id="xiangqing<?php  echo $val['id'];?>" value="<?php  echo $_W['siteroot'];?>web/index.php?c=site&a=entry&id=<?php  echo $val['id'];?>&do=serveperson&foo=xiangqing&m=xm_gohome" />
                                <a class="btn btn-default" onclick="submit2(<?php  echo $val['id'];?>)"><i class="fa fa-edit"></i> 详情</a>

                            	<?php  if($val['print_state'] == 0) { ?>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('cloudprint',array('foo'=>'add', 'id'=>$val['id'], 'company_id'=>$id));?>"><i class="fa fa-print"></i>派发打印机</a>
                                <?php  } ?>
                                
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('company',array('foo'=>'staffsheng','id'=>$val['id'],'mge'=>$val['company_flag']));?>"><i class="fa fa-edit"></i>个人审核编辑</a>
                            	
                                <?php  if($val['indextop'] == 0) { ?>
                                <a class="btn btn-default" onclick="sub(<?php  echo $val['id'];?>,1)">
                                    <i class="fa fa-edit"></i><span id="sub_text<?php  echo $val['id'];?>">首页推荐</span>
                                </a>
                                <?php  } else { ?>
                                <a class="btn btn-default" onclick="sub(<?php  echo $val['id'];?>,0)">
                                    <i class="fa fa-edit"></i><span id="sub_text<?php  echo $val['id'];?>">取消推荐</span>
                                </a>
                                <?php  } ?>

                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('company',array('foo'=>'editstaff', 'id'=>$val['id'], 'company_id'=>$id));?>"><i class="fa fa-edit"></i> 编辑</a>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('company', array('foo'=>'deletestaff', 'id'=>$val['id'], 'company_id'=>$id))?>" onclick="return confirm('确认删除该工人?');"><i class="fa fa-remove"></i> 删除</a>
                            </div>
                        </td>
                    </tr>
                    <?php  } } ?>
                    
                </tbody>
            </table>
            <?php  } ?>
        </div>
        
        <div class="panel-body text-center">
            <?php  echo $pager;?>
        </div>
        
    </div>
</div>

<script type="text/javascript">
function sub(id,state){
    $.ajax({
        url: "<?php  echo $this->createWebUrl('serveperson', array('foo'=>'subok'))?>",
        type:"POST",
        data:{"id":id, "state":state},
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
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>