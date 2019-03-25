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
                <input type="hidden" name="do" value="task" />
                <input type="hidden" name="op" value="display" />
                <input type="hidden" name="storeid" value="<?php  echo $storeid;?>" />
                <div class="form-group">
                    <select class="form-control" id="task_type" name="nav_id" autocomplete="off">
                        <option value="">全部分类</option>
                        <?php  if(is_array($navlist)) { foreach($navlist as $v) { ?>
                        <option value="<?php  echo $v['id'];?>"><?php  echo $v['title'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="colname" name="colname" autocomplete="off">
                        <option value="task_title">任务标题</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="请输入" name="keyword">
                </div>
                <button class="btn btn-success"><i class="fa fa-search"></i> 搜索</button>
            </form>
        </div>
    </div>
    <form action="" method="post" class="form-horizontal form" >
        <div class="panel panel-default">
            <div class="table-responsive panel-body">
                <table class="table table-hover" style="display:block;">
				
                    <thead class="navbar-inner">
                    <tr>
                        <th style="width:5%">id</th>
                        <th style="width:5%">排序</th>
                        <th style="width:5%">分类导航</th>
						<th style="width:20%">任务名称</th>
						<th style="width:5%">状态</th>
						<th style="width:5%">已领取</th>
						<th style="width:5%">需要审核</th>
                        <th style="width:5%">开放领取</th>
                        <th style="width:10%">分类标签</th>
                        <th style="width:15%">操作</th>
                    </tr>
                    </thead>
                    <tbody id="level-list">
                    <?php  if(is_array($tasklist)) { foreach($tasklist as $item) { ?>
                    <tr>
                        <td><?php  echo $item['id'];?></td>
                        <td><?php  echo $item['sorting'];?></td>
                        <td><?php  echo $item['navtitle'];?></td>
                        
                        <td><?php  echo $item['task_title'];?></td>
                        <td>
                        <?php  if($item['status'] == 0) { ?><span class="label label-default">下线</span>
                        <?php  } else if(time()<$item['starttime']) { ?><span class="label label-info">未开始</span>
                        <?php  } else if(time()>$item['endtime']) { ?><span class="label label-primary">已结束</span>
                        <?php  } else { ?><span class="label label-success">进行中</span>
                        <?php  } ?>
                        </td>
                        <td><?php  echo $item['receive'];?></td>
                        <td>
                            <?php  if(empty($item['is_review']) || $item['is_review']==0) { ?>
                            <span class="label label-danger">否</span>
                            <?php  } else if($item['is_review'] == 1) { ?>
                            <span class="label label-success">是</span>
                            <?php  } ?>
                        </td>
                        <td>
                            <?php  if(empty($item['is_open']) || $item['is_open'] == 0) { ?>
                                <span class="label label-danger">否</span>
                            <?php  } else if($item['is_open'] == 1) { ?>
                                <span class="label label-success">是</span>
                            <?php  } ?>
                        </td>
                        <td><?php  echo $item['catetitle'];?></td>
                        <td>
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('task_review', array('op'=>'display','task_title'=>$item['task_title']))?>" title="上线"><i class="fa fa-edit"></i>任务审核</a>
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('task', array('id' => $item['id'], 'op' => 'post'))?>"><i class="fa fa-search"></i>修改</a>
                            <?php  if($item['status'] == 1) { ?>
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('task', array('id' => $item['id'], 'op' => 'setstatus'))?>" title="下线"><i class="fa fa-arrow-down"></i>下线</a>
                            <?php  } else { ?>
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('task', array('id' => $item['id'], 'status' => 1, 'op' => 'setstatus'))?>" title="上线"><i class="fa fa-arrow-up"></i>上线</a>
                            <?php  } ?>

                        </td>
                    </tr>
                    <?php  } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <?php  echo $pager;?>

    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-success" href="<?php  echo $this->createWebUrl('task', array('op' => 'post'))?>">发布新任务</a>
        </div>
    </div>
</div>
<?php  } else if($operation == 'post') { ?>
<div class="main">
    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-warning" href="<?php  echo $this->createWebUrl('task', array('op' => 'display', 'storeid' => $storeid))?>">返回任务列表
            </a>
        </div>
    </div>
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="invitative">
        <div class="panel panel-default">
            <div class="panel-heading">
                任务编辑
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否开放领取</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="is_open" value="0" <?php  if($item['is_open']==0 || empty($item['is_open'])) { ?>checked<?php  } ?>>否
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_open" value="1" <?php  if($item['is_open']==1) { ?>checked<?php  } ?>>是
                        </label>
                        <div class="help-block">如果设置为开放领取，任务标签将不被限制</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务标签</label>
                    <div class="col-sm-9">
                        <select name="cateid">
                            <?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
                                <option value="<?php  echo $category['id'];?>" <?php  if($item['cateid'] == $category['id']) { ?>selected<?php  } ?>><?php  echo $category['title'];?></option>
                            }
                            <?php  } } ?>
                        </select>
                        <div class="help-block">用户认证后，只能领取相应标签下的任务</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分类导航</label>
                    <div class="col-sm-9">
                        <select name="nav_id">
                            <?php  if(is_array($navlist)) { foreach($navlist as $v) { ?>
                                <option value="<?php  echo $v['id'];?>" <?php  if($item['nav_id'] == $v['id']) { ?>selected<?php  } ?>><?php  echo $v['title'];?></option>
                            <?php  } } ?>
                        </select>
                        <div class="help-block">手机端首页进行分类显示</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">领取等级限制</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="where_type" value="0" <?php  if($item['where_type']==0 || empty($item['where_type'])) { ?>checked<?php  } ?>>不限制
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="where_type" value="1" <?php  if($item['where_type']==1) { ?>checked<?php  } ?>>等于
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="where_type" value="2" <?php  if($item['where_type']==2) { ?>checked<?php  } ?>>大于
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="where_type" value="3" <?php  if($item['where_type']==3) { ?>checked<?php  } ?>>小于
                        </label>
                        <div class="help-block">如果设置为不限制，下一项留空即可</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">等级限制数值</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="请按照提示填写" name="where_con" value="<?php  echo $item['where_con'];?>" id="where_con" class="form-control" />
                        <div class="help-block">勾选等于时输入形如|1|2|3|(单数字|2|)，勾选大小于填入单数字即可，勾选不限制留空</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">可获得<?php  echo $this->getSetting('points_name');?></label>
                    <div class="col-sm-9">
                        <input type="text" name="task_points" value="<?php  echo $item['task_points'];?>" id="task_points" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">需要消费<?php  echo $this->getSetting('points_name');?></label>
                    <div class="col-sm-9">
                        <input type="text" name="task_exp" value="<?php  echo $item['task_exp'];?>" id="task_exp" class="form-control" />
                        <div class="help-block">为0表示免费领取</div>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户限制领取</label>
                    <div class="col-sm-9">
                        <input type="text" name="user_receive" value="<?php  echo $item['user_receive'];?>" id="user_receive" class="form-control" />
                        <div class="help-block">为0时不限制</div>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">最多可领取</label>
                    <div class="col-sm-9">
                        <input type="text" name="task_receive" value="<?php  echo $item['task_receive'];?>" id="task_receive" class="form-control" />
                        <div class="help-block">为0时不限制</div>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="task_title" value="<?php  echo $item['task_title'];?>" id="task_title" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务简介</label>
                    <div class="col-sm-9">
                        <textarea  class="form-control" name="task_desc"  id="task_desc"><?php  echo $item['task_desc'];?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务图片</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image('task_image', $item['task_image'])?>
                        <div class="help-block">大图片建议尺寸：600像素 * 600像素</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否置顶</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="is_top" value="1" <?php  if($item['is_top']==1) { ?>checked<?php  } ?>>是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_top" value="0" <?php  if($item['is_top']==0 || empty($item['is_top'])) { ?>checked<?php  } ?>>否
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                    <div class="col-sm-9">
                        <input type="text" name="sorting" value="<?php  echo $item['sorting'];?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务详情</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_ueditor("task_content",htmlspecialchars_decode($item['task_content'])) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">隐藏内容</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_ueditor("hide_content",htmlspecialchars_decode($item['hide_content'])) ?>
                        <div class="help-block">领取任务后可以查看</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开始领取时间</label>
                    <div class="col-sm-9">
                        <?php  echo _tpl_form_field_date("starttime",$item['starttime'],true) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">最后领取时间</label>
                    <div class="col-sm-9">
                        <?php  echo _tpl_form_field_date("endtime",$item['endtime'],true) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务限制时间</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="该内容仅用于审核时手动查看，需要手动输入(100字以内)" name="task_do_time" value="<?php  echo $item['task_do_time'];?>" id="task_do_time" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否需要审核</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="is_review" value="1" <?php  if($item['is_review']==1 || !isset($item['is_review'])) { ?>checked<?php  } ?>>需要
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_review" value="0" <?php  if($item['is_review']==0 && isset($item['is_review'])) { ?>checked<?php  } ?>>不需要
                        </label>
                        <div class="help-block">如果不需要审核，用户领取后自动完成(设置为需要审核需要设置一个审核人才会生效)</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">审核人</label>
                    <div class="col-sm-9 col-xs-12">
                        <div class="input-group">
                            <input type="text" name="nickname" value="<?php  if($review_user['username']) { ?><?php  echo $review_user['username'];?><?php  } else { ?><?php  echo $review_user['nickname'];?><?php  } ?>" class="form-control" readonly="">
                            <input type="hidden" name="agentid" value="<?php  echo $item['review_userid'];?>">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="$('#modal-module-menus').modal();" data-original-title="" title="">选择粉丝</button>
                            </span>
                        </div>
                        <div class="input-group cover" style="margin-top:.5em;">
                            <img src="<?php  echo $review_user['headimgurl'];?>" width="150" />
                        </div>
                        <div class="help-block">任务在手机端可由此人审核。</div>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务领取后</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="auto_review" <?php  if(empty($item['auto_review'])) { ?>checked<?php  } ?> value="0" >手动提交审核
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="auto_review" <?php  if($item['auto_review'] == 1) { ?>checked<?php  } ?> value="1" >自动提交审核
                        </label>
                        <div class="help-block">自动提交审核任务领取后直接进入审核阶段</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">完成提升级数</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="请输入正整数" name="user_level" value="<?php  if($item['user_level']) { ?><?php  echo $item['user_level'];?><?php  } else { ?>0<?php  } ?>" class="form-control" />
                        <div class="help-block">0表示不升级，正整数表示升级数</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义字段</label>
                    <div class="col-sm-9">
                        <select name="fieldset_id">
                            <option value="0">不绑定</option>
                            <?php  if(is_array($filedset)) { foreach($filedset as $v) { ?>
                            <option value="<?php  echo $v['id'];?>" <?php  if($item['fieldset_id'] == $v['id']) { ?>selected<?php  } ?>><?php  echo $v['name'];?></option>
                            <?php  } } ?>
                        </select>
                        <div class="help-block">绑定自定义字段后，用户领取任务时需要填写字段信息</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="保存任务" class="btn btn-primary col-lg-3"/>
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_modal_fans', TEMPLATE_INCLUDEPATH)) : (include template('web/_modal_fans', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>