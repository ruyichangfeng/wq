<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?php  echo  $this->createWebUrl('userlist', array('foo'=>'index'));?>">用户管理</a></li>
    <li><a href="<?php  echo $this->createWebUrl('blacklist', array('foo'=>'index'));?>">黑名单管理</a></li>
</ul>

<div class="clearfix">
    <div class="panel panel-info">
        <div class="panel-heading">筛选</div>
        <div class="panel-body">
            <form action="./index.php" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="do" value="userlist" />
                <input type="hidden" name="foo" value="index" />
                <input type="hidden" name="m" value="xm_gohome" />
                <!--
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">用户昵称</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="nickname" id="nickname" type="text" value="<?php  echo $_GPC['nickname'];?>" placeholder="用户昵称">
                    </div>
                </div>-->

                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">用户昵称</label>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                        <input class="form-control" name="nickname" id="nickname" type="text" value="<?php  echo $_GPC['nickname'];?>" placeholder="用户昵称">
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
            用户列表
        </div>
        <div class="table-responsive panel-body" style="overflow:visible;">
            <table class="table table-hover">
            	<thead>
                	<tr class="active">
                    	<td width="50">ID编号</td>
                    	<td width="200">OpenID</td>
                        <td width="100">用户昵称</td>
                        <td width="100">真实姓名</td>
                        <td width="50">性别</td>
                        <td width="100">手机号码</td>
                        <td width="100">个人审核</td>
                        <td width="200">操作</td>
                    </tr>
                </thead>
                <tbody>
                	<?php  if(is_array($list)) { foreach($list as $val) { ?>
                	<tr>
                    	<td><?php  echo $val['uid'];?></td>
                    	<td><?php  echo $val['openid'];?></td>
                        <td>
                        	<?php  echo $val['nickname'];?>
                        </td>
                        <td>
                        	<?php  echo $this->getFansInfo($val['uid'], 'realname')?>
                        </td>
						<td>
                        <?php  if($this->getFansInfo($val['uid'], 'gender') == 0) { ?>
                        保密
                        <?php  } ?>
                        <?php  if($this->getFansInfo($val['uid'], 'gender') == 1) { ?>
                        男
                        <?php  } ?>
                        <?php  if($this->getFansInfo($val['uid'], 'gender') == 2) { ?>
                        女
                        <?php  } ?>
                        </td>
                        <td><?php  echo $this->getFansInfo($val['uid'], 'mobile')?></td>
						<td>
						<?php  if($this->checkexamine($val['openid']) == 1) { ?>
                        	已审核
                        <?php  } else { ?>
                        	未审核
                        <?php  } ?>
						</td>
                        <td style="overflow:visible;">
                        	<div class="btn-group btn-group-sm">
                                <a class="btn btn-default" href="<?php  echo $this->createWebUrl('userlist',array('foo'=>'edit', 'openid'=>$val['openid'], 'uid'=>$val['uid']));?>">
                                    <i class="fa fa-edit"></i>编辑
                                </a>

                            	<?php  if($this->checkexamine($val['openid']) == 0) { ?>
                            	   <a class="btn btn-default" href="<?php  echo $this->createWebUrl('userlist',array('foo'=>'examineok', 'openid'=>$val['openid']));?>" onClick="return confirm('确认通过审核?');">
                                        <i class="fa fa-unlock"></i> 审核通过
                                    </a>
                                <?php  } else { ?>
                                    <a class="btn btn-default" href="<?php  echo $this->createWebUrl('userlist',array('foo'=>'examineno', 'openid'=>$val['openid']));?>" onClick="return confirm('确认取消审核?');">
                                        <i class="fa fa-lock"></i> 取消审核
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
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>