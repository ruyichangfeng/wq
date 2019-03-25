<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('servetype', array('foo'=>'index'));?>">服务项目管理</a></li>
    <li><a href="<?php  echo $this->createWebUrl('servetype', array('foo'=>'add'));?>">添加服务项目</a></li>
</ul>

<div class="clearfix">    
    <div class="panel panel-default">
    	<div class="panel-heading">
            服务类别列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td width="50">序号</td>
                        <td width="100">类别名称</td>
                        <!--<td width="150">描述</td>-->
                        <td width="150">模型名称</td>
                        <!--<td width="100">运营地区</td>-->
                        <td width="100">子类个数</td>
                        <td width="100">市场价格</td>
                        <td width="100">优惠价格</td>
                        <td width="100">计算单位</td>
						<td width="120">抢单基础金额</td>
                        <td width="120">预约金</td>
						<td width="350">操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  $n=0;?>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                    <?php  $n+=1;?>
                	<tr>
                    	<td><?php  echo $n;?></td>
                        <td><?php  echo $val['type_name'];?></td>
						
                        <td><?php  echo $this->getTempName($val['temp_id']);?></td>
                        <!--<td><?php  echo $this->getAdrInfo($val['adr_id'], 'adr_name');?></td>-->
                        <td><?php  echo $val['child_num'];?></td>
                        <td><?php  echo $val['price'];?></td>
                        <td><?php  echo $val['price_unit'];?></td>
                        <td><?php  echo $val['unit'];?></td>
						<td><?php  echo $val['basemoney'];?></td>
                        <td><?php  echo $val['front'];?></td>
                        <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
								<a class="btn btn-default" href="<?php  echo $this->createWebUrl('servetype',array('foo'=>'edit', 'id'=>$val['id']));?>">
                                    <i class="fa fa-edit"></i> 编辑
                                </a>
                                <?php  if($val['child_num'] == 0) { ?>
                                    <a class="btn btn-default" href="<?php  echo $this->createWebUrl('servetype', array('foo'=>'delete', 'id'=>$val['id']))?>" onclick="return confirm('确认删除该服务类别吗?');">
                                        <i class="fa fa-remove"></i> 删除
                                    </a>
                                <?php  } else { ?>
                                    <a class="btn btn-default" href="#" onclick="delinfo()">
                                        <i class="fa fa-remove"></i> 删除
                                    </a>
                                <?php  } ?>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('servetype',array('foo'=>'add', 'id'=>$val['id']));?>">
                                    <i class="fa fa-edit"></i> 添加子类
                                </a>
                                <?php  if($val['child_num'] != 0) { ?>
                                    <a class="btn btn-default" href="<?php  echo $this->createWebUrl('servetype',array('foo'=>'child', 'id'=>$val['id']));?>">
                                        <i class="fa fa-edit"></i> 查看子类
                                    </a>
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
        	<a class="btn btn-default" href="<?php  echo $this->createWebUrl('servetype', array('foo'=>'add'))?>">新增服务项目</a>
        </div>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>

<script>
function delinfo(){
	alert('该服务类别下还有子类别，不能删除！如果需要删除，请先删除该服务类别下的子类后再来删除！');
}
</script>