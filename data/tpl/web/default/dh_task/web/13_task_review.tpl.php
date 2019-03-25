<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>

<?php  if($operation == 'display') { ?>
<div class="main">
    <div class="panel panel-default">
        <div class="panel-heading">筛选</div>
        <div class="table-responsive panel-body">
            <form action="./index.php" method="get" class="navbar-form navbar-left" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="dh_task" />
                <input type="hidden" name="do" value="task_review" />
                <input type="hidden" name="op" value="display" />
                <input type="hidden" name="storeid" value="<?php  echo $storeid;?>" />
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php  echo $username;?>" placeholder="任务领取人" name="username">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php  echo $task_title;?>" placeholder="任务名称" name="task_title">
                </div>
                <button class="btn btn-success"><i class="fa fa-search"></i> 搜索</button>
            </form>
        </div>
    </div>
    <form action="" method="post" class="form-horizontal form" >
        <div class="panel panel-default">
            <div class="table-responsive panel-body">
                <table class="table table-hover" style="display: block;">
                    <thead class="navbar-inner">
                    <tr>
                        <th style="width:10%;">任务领取人</th>
                        <th style="width:20%;">任务名称</th>
                        <th style="width:10%;">审核状态</th>
                        <th style="width:20%;">领取时间</th>
                        <th style="width:20%;">操作</th>
                    </tr>
                    </thead>
                    <tbody id="level-list">
                    <?php  if(is_array($receiveList)) { foreach($receiveList as $item) { ?>
                    <tr>
                        <td><?php  echo $item['user_id'];?></td>
                        <td><?php  echo $item['task_id'];?></td>
                        <td>
                            <?php  if($item['status'] == 0) { ?>
                                <span>任务正在进行</span>
                            <?php  } else if($item['status'] == 1) { ?>
                                <span class="label label-success">审核通过</span>
                            <?php  } else if($item['status'] == 2) { ?>
                                <span class="label label-danger">审核失败</span>
                            <?php  } else if($item['status'] == 3) { ?>
                                <span class="label label-info">已提交审核中</span>
                            <?php  } else if($item['status'] == 4) { ?>
                                <span>已放弃此任务</span>
                            <?php  } ?>
                        </td>
                        <td>
                            <?php  echo date('Y-m-d H:i:s', $item['receive_time'])?>
                        </td>
                        <td>
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('task_review', array('id' => $item['id'], 'op' => 'post', 'storeid' => $storeid))?>"><i class="fa fa-search"></i>详情</a>
                        </td>
                    </tr>
                    <?php  } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <?php  echo $pager;?>
</div>
<?php  } else if($operation == 'post') { ?>
<div class="main">
    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-warning" href="<?php  echo $this->createWebUrl('task_review', array('op' => 'display', 'storeid' => $storeid))?>">返回任务审核列表
            </a>
        </div>
    </div>
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="invitative">
        <div class="panel panel-default">
            <div class="panel-heading">
                任务审核信息
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务领取ID</label>
                    <div class="col-sm-9">
                        <p class="form-control-static">
                            <?php  echo $item['id'];?>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务领取人</label>
                    <div class="col-sm-9">
                        <p class="form-control-static">
                            <?php  echo $item['user_id'];?>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务名称</label>
                    <div class="col-sm-9">
                        <p class="form-control-static">
                            <?php  echo $item['task_id'];?>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务领取时间</label>
                    <div class="col-sm-9">
                        <div style="margin-top: 6px;"><?php  echo date('Y-m-d H:i:s', $item['receive_time'])?></div>
                    </div>
                </div>
                <?php  if($item['field']) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户表单资料</label>
                    <div class="col-sm-9">
                        
                        <?php  if(is_array($item['field'])) { foreach($item['field'] as $v) { ?>
                        <div style="margin-top: 6px;">
                        <?php  echo $v['name'];?>：<?php  echo $v['value'];?>
                        </div>
                        <?php  } } ?>
                        
                    </div>
                </div>
                <?php  } ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务凭证</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="prove"><?php  echo htmlspecialchars_decode($item['prove'])?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">图片凭证</label>
                    <div class="col-sm-9">
                        <?php  if(!empty($item['image'])) { ?>
                        <?php  if(is_array($item['image'])) { foreach($item['image'] as $v) { ?>
                            <a href="<?php  echo tomedia($v);?>"><img src="<?php  echo tomedia($v);?>" style="max-width: 23%;margin: 0 1% 5px 0;"></a>
                        <?php  } } ?>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务评语</label>
                    <div class="col-sm-9">
                        <textarea  class="form-control" name="evaluate"  id="task_desc"><?php  echo $item['evaluate'];?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务额外<?php  echo $this->getSetting('points_name');?></label>
                    <div class="col-sm-9">
                        <input type="text" name="points" value="<?php  echo $item['points'];?>" id="points" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">审核状态</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1" <?php  if($item['status']==1) { ?>checked<?php  } ?> />审核通过
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="2" <?php  if($item['status']==2) { ?>checked<?php  } ?> />审核失败
                        </label>
                    </div>
                </div>
        <?php  if($item['status'] == 3) { ?>
            <div class="form-group col-sm-12">
                <input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-3"/>
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            </div>
        <?php  } ?>
    </form>
</div>
<script type="text/javascript">
    function check() {
        if($.trim($('#username').val()) == '') {
            message('没有输入姓名.', '', 'error');
            return false;
        }s
        return true;
    }
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
