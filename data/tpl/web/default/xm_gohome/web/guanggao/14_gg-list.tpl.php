<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('gg', array('foo'=>'index'));?>">推荐服务[广告]管理</a></li>
	<li><a href="<?php  echo  $this->createWebUrl('gg', array('foo'=>'add'));?>">添加推荐服务[广告]</a></li>
</ul>

<div class="clearfix">    
    <div class="panel panel-default">
    	<div class="panel-heading">
            幻灯片列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td>名称</td>
                        <td>显示图标</td>
                        <td>链接地址</td>
                        <td>排序参数</td>
                        <td>是否显示</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td>
                        	<p class="form-control-static"><?php  echo $val['gg_name'];?></p>
                        </td>
                        <td>
                        	<img id="img1" src="<?php  echo $_W['attachurl'];?><?php  echo $val['pic'];?>" width="200" height="100" />
                        </td>
                        <td>
							<p class="form-control-static"><?php  echo $val['link'];?></p>
                        </td>
						<td>
							<p class="form-control-static"><?php  echo $val['top'];?></p>
                        </td>
                        <td>
                        <?php  if($val['stop'] == 1) { ?>
                        	<p class="form-control-static">显示</p>
                        <?php  } else { ?>
                        	<p class="form-control-static">不显示</p>
                        <?php  } ?>
                        </td>
					    <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('gg',array('foo'=>'edit','id'=>$val['id']));?>"><i class="fa fa-edit"></i> 编辑</a>
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('gg', array('foo'=>'delete','id'=>$val['id']))?>" onClick="return confirm('确认删除该幻灯片?');"><i class="fa fa-remove"></i> 删除</a>
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
			<a class="btn btn-default" href="<?php  echo $this->createWebUrl('gg',array('gg'=>'add'));?>">新增推荐服务[广告]</a>
        </div>
        
    </div>
</div>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>