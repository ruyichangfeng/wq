<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>

<?php  if($operation == 'display') { ?>
<div class="main">
    <div class="panel panel-default">
        <div class="panel-heading">筛选</div>
        <div class="table-responsive panel-body">
            <form action="" method="get" class="navbar-form navbar-left" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="dh_task" />
                <input type="hidden" name="do" value="fans" />
                <input type="hidden" name="op" value="display" />
                <input type="hidden" name="storeid" value="<?php  echo $storeid;?>" />
                <div class="form-group">
                    <select class="form-control" id="status" name="status" autocomplete="off">
                        <option value="">全部</option>
                        <option value="1">正常状态</option>
                        <option value="0">禁止领取任务</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="types" name="types" autocomplete="off">
                        <option value="username">用户名称</option>
                        <option value="mobile">手机号码</option>
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
                <table class="table table-hover" style="display: block;width:100%;">
                    <thead class="navbar-inner">
                    <tr>
                        <th style="width:10%">id</th>
                        <th style="width:15%">推荐人</th>
                        <th style="width:15%">昵称</th>
                        <th style="width:10%">等级</th>
						<th style="width:10%"><?php  echo $this->getSetting('points_name');?></th>
                        <th style="width:10%">推广人数</th>
                        <th style="width:15%">加入时间</th>
                        <th style="width:5%">状态</th>
                        <th style="width:15%">操作</th>
                    </tr>
                    </thead>
                    <tbody id="level-list">
                    <?php  if(is_array($list)) { foreach($list as $item) { ?>
                    <tr>
                        <td><?php  echo $item['id'];?></td>
                        <td style="white-space:normal;">
                            <?php  if($item['uid_nickname']) { ?>
                            <img src="<?php  echo tomedia($item['uid_headimgurl']);?>" style="width:30px;height:30px;padding1px;border:1px solid #ccc"/>
                            </br><?php  echo $item['uid_nickname'];?>
                            <?php  } else { ?>
                            <span class="label label-info">平台</span>
                            <?php  } ?>
                        </td>
                        <td style="white-space:normal;">
                            <img src="<?php  echo tomedia($item['headimgurl']);?>" style="width:30px;height:30px;padding:1px;border:1px solid #ccc"/>
                            </br><?php  if($item['username']) { ?><?php  echo $item['username'];?><?php  } else { ?><?php  echo $item['nickname'];?><?php  } ?>
                            
                        </td>
						<td><?php  echo $item['level'];?></td>
                        <td><?php  echo $item['points'];?><br>
                        <span class="label label-info"><a href="javascript:chang_points(<?php  echo $item['id'];?>,'<?php  echo $item['nickname'];?>')">充值</a></span>
                        </td>
                        <td><?php  echo $item['commission_num_result'];?>/<?php  echo $item['commission_num'];?></td>
                        <td><?php  echo $item['dateline'];?></td>
                        <td>
                            <?php  if($item['status'] == 0) { ?>
                            <span class="label label-danger">禁用</span>
                            <?php  } else { ?>
                            <span class="label label-success">正常</span>
                            <?php  } ?>
                        </td>
                        <td>
                            <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('fans', array('id' => $item['id'], 'op' => 'post', 'storeid' => $storeid))?>"><i class="fa fa-search"></i>详情</a>
                            <?php  if($_W['isfounder'] || $_W['role'] == 'manager') { ?>
                            <?php  if($item['status'] == 1) { ?>
                            <a class="btn btn-default btn-sm" onclick="return confirm('您确定要禁止领取任务吗？');return false;" href="<?php  echo $this->createWebUrl('fans', array('id' => $item['id'], 'status' => $item['status'], 'op' => 'setstatus', 'storeid' => $storeid))?>"
 title="冻结"><i class="fa fa-lock"></i>禁止</a>
                            <?php  } else { ?>
                            <a class="btn btn-default btn-sm" onclick="return confirm('您确定要解除禁止状态吗？');return false;" href="<?php  echo $this->createWebUrl('fans', array('id' => $item['id'], 'status' => $item['status'], 'op' => 'setstatus', 'storeid' => $storeid))?>"
                                title="解冻"><i class="fa fa-unlock"></i>解除</a>
                            <?php  } ?>
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
</div>

<div class="modal fade" id="renzheng-container" tabindex="-1" style="margin-top: 100px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php  echo $this->createWebUrl('fans', array(op=>'change_points'))?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">用户充值：<span id="nickname"></span></h4>
                </div>
                <div class="modal-body">
                    充值金额
                    <span style="color:#f00;font-size: 16px;">(必填)</span>
                    <input class="form-control pull-right" style="width: 70%;margin-top: -5px;" name="point" type="text" placeholder="正数表示增加，负数表示减少">
                    <input  name="userid" hidden id="userid" type="text" >
                 </div>
                <div class="modal-footer" style="padding: 5px 15px;">
                    <a class="btn btn-default js-cancel" data-dismiss="modal">取消</a>
                    <button type="submit" class="btn btn-primary" name="confrimsign" value="认证">充值</button>
                    <input type="hidden" name="token" value="fa12abfe" />
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function chang_points(id,nickname){
        $("#userid").val(id);
        $("#nickname").html(" <span style='color:#f00;'>"+nickname+"</span>");
        $('#renzheng-container').modal()
    }
</script>

<?php  } else if($operation == 'post') { ?>
<div class="main">
    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-warning" href="<?php  echo $this->createWebUrl('fans', array('op' => 'display', 'storeid' => $storeid))?>">返回会员管理
            </a>
        </div>
    </div>
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="invitative">
        <div class="panel panel-default">
            <div class="panel-heading">
                用户信息
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">微信ID</label>
                    <div class="col-sm-9">
                        <p class="form-control-static">
                            <?php  echo $item['from_user'];?>
                        </p>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户标签</label>
                    <div class="col-sm-9">
                        <p class="form-control-static">
                            <select name="cateid">
							<option value="0">0 -- 未指派</option>
							<?php  if(is_array($catelist)) { foreach($catelist as $cate) { ?>
								<option value="<?php  echo $cate['id'];?>" <?php  if(!empty($item['cateid']) && $item['cateid']==$cate['id']) { ?>selected<?php  } ?> ><?php  echo $cate['id'];?> -- <?php  echo $cate['title'];?></option>
							<?php  } } ?>
							</select>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $this->getSetting('points_name');?></label>
                    <div class="col-sm-9">
                        <p class="form-control-static">
                            <?php  if(empty($item['points'])) { ?>0<?php  } else { ?><?php  echo $item['points'];?><?php  } ?>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">昵称</label>
                    <div class="col-sm-9">
                        <input type="text" name="nickname" value="<?php  echo $item['nickname'];?>" id="nickname" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">头像</label>
                    <div class="col-sm-9">
                        <?php  if(empty($item['headimgurl'])) { ?>
                        <?php  echo tpl_form_field_image('headimgurl', '../addons/dh_task/template/images/default-headimg.jpg')?>
                        <?php  } else { ?>
                        <?php  echo tpl_form_field_image('headimgurl', $item['headimgurl'])?>
                        <?php  } ?>
                        <div class="help-block">大图片建议尺寸：80像素 * 80像素</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">姓名</label>
                    <div class="col-sm-9">
                        <input type="text" name="username" value="<?php  echo $item['username'];?>" id="username" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">手机</label>
                    <div class="col-sm-9">
                        <input type="text" name="mobile" value="<?php  echo $item['mobile'];?>" id="mobile" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">性别</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="sex" value="1" <?php  if($item['sex']==1 || empty($item['sex'])) { ?>checked<?php  } ?>>男
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="sex" value="2" <?php  if($item['sex']==2) { ?>checked<?php  } ?>>女
					    </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">最后登陆时间</label>
                    <div class="col-sm-9">
                        <p class="form-control-static">
                            <?php  echo date('Y-m-d H:i:s', $item['lasttime'])?>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">更新时间</label>
                    <div class="col-sm-9">
                        <p class="form-control-static">
                            <?php  echo date('Y-m-d H:i:s', $item['dateline'])?>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">认证状态</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="legalize" value="0" <?php  if($item['legalize']==0 || empty($item['sex'])) { ?>checked<?php  } ?>>未认证
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="legalize" value="1" <?php  if($item['legalize']==1) { ?>checked<?php  } ?>>已认证
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="legalize" value="2" <?php  if($item['legalize']==2) { ?>checked<?php  } ?>>认证中
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label" style="color:#f00;">禁止用户</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1" <?php  if($item['status']==1 || empty($item)) { ?>checked<?php  } ?>>正常
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="0" <?php  if(isset($item['status']) && empty($item['status'])) { ?>checked<?php  } ?>>禁止</label>
                        <span class="help-block">禁止后用户无法访问网站</span>
                    </div>

                </div>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="保存设置" class="btn btn-primary col-lg-3"/>
            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        </div>
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
