<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/header', TEMPLATE_INCLUDEPATH)) : (include template('public/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('public/comhead', TEMPLATE_INCLUDEPATH)) : (include template('public/comhead', TEMPLATE_INCLUDEPATH));?>

<?php  if($operation == 'display') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="invitative">
        <div class="panel panel-default">
            <div class="panel-heading">
                系统设置
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">网站名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="web_name" value="<?php  echo $item['web_name'];?>" id="web_name" class="form-control" />
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">手机端模板</label>
                    <div class="col-sm-9">
                        <p class="form-control-static">
                             <input type="text" name="mobile_tpl" value="<?php  echo $item['mobile_tpl'];?>" id="points" class="form-control" />
                        </p>
                    </div>
                </div> -->
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户认证</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="user_legalize" value="0" <?php  if($item['user_legalize']==0 || empty($item['user_legalize'])) { ?>checked<?php  } ?> />无需认证
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="user_legalize" value="1" <?php  if($item['user_legalize']==1) { ?>checked<?php  } ?> />开始就认证
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="user_legalize" value="2" <?php  if($item['user_legalize']==2) { ?>checked<?php  } ?> />领取任务时认证
                        </label>
                        <div class="help-block">如果关闭认证，用户将能够显示并领取所有分类下的任务</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户审核人id</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="多个审核人用|分开" name="review_user" value="<?php  echo $item['review_user'];?>" id="review_user" class="form-control" />
                        <div class="help-block">添加用户审核任务id，需要多个审核人用|隔开</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                任务设置
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">符合任务标签显示</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="user_cate" value="1" <?php  if($item['user_cate']==1 || empty($item['user_cate'])) { ?>checked<?php  } ?> />只显示符合用户标签的任务
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="user_cate" value="0" <?php  if($item['user_cate']==0) { ?>checked<?php  } ?> />显示所有标签的任务
                        </label>
                        <div class="help-block">如果关闭认证，此项设置无效</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">符合任务等级显示</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="user_level" value="1" <?php  if($item['user_level']==1 || empty($item['user_level'])) { ?>checked<?php  } ?> />只显示符合用户等级的任务
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="user_level" value="0" <?php  if($item['user_level']==0) { ?>checked<?php  } ?> />显示所有等级任务
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务默认图片</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image('task_image', $item['task_image'])?>
                        <div class="help-block">大图片建议尺寸：600像素 * 600像素</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                积分设置
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户默认积分</label>
                    <div class="col-sm-9">
                        <input type="text" name="user_points" value="<?php  echo $item['user_points'];?>" id="points" class="form-control" />
                        <div class="help-block">在用户认证或者用户关注公众号后赠送此积分，后台认证无效，只能获得一次积分</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">平台积分名称</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="points_name" value="<?php  echo $item['points_name'];?>" id="points_name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">积分提现功能</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="is_propor" value="1" <?php  if($item['is_propor']==1) { ?>checked<?php  } ?> />开启
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_propor" value="0" <?php  if($item['is_propor']==0 || empty($item['is_propor'])) { ?>checked<?php  } ?> />关闭
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">积分提现比例</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="point_propor" value="<?php  echo $item['point_propor'];?>" id="point_propor">
                        <div class="help-block">请设置1元等于多少积分</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">最低提现积分</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="min_point" value="<?php  echo $item['min_point'];?>" id="min_point">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                关注设置
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">未关注是否可以领取任务</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="follow_task" value="1" <?php  if($item['follow_task']==1 || empty($item['follow_task'])) { ?>checked<?php  } ?> />是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="follow_task" value="0" <?php  if($item['follow_task']==0 && isset($item['follow_task'])) { ?>checked<?php  } ?> />否
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开启未关注提醒</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="isneedfollow" value="1" <?php  if($item['isneedfollow']==1 || empty($item['isneedfollow'])) { ?>checked<?php  } ?> />开启
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="isneedfollow" value="0" <?php  if($item['isneedfollow']==0) { ?>checked<?php  } ?> />关闭
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">关注二维码</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image('follow_image', $item['follow_image'])?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">网站LOGO</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image('weblogo', $item['weblogo'])?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                分享设置
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开启推广功能</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="is_commission" value="1" <?php  if($item['is_commission']==1) { ?>checked<?php  } ?> />开启
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_commission" value="0" <?php  if($item['is_commission']==0 || empty($item['is_commission'])) { ?>checked<?php  } ?> />关闭
                        </label>
                        <div class="help-block">开启推广功能后用户，邀请用户将会获得推广奖励</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推广积分</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="share_point" value="<?php  echo $item['share_point'];?>">
                        <div class="help-block">完成推广后获得的积分数</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">积分获得方式</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" name="manner" value="1" <?php  if($item['manner']==1) { ?>checked<?php  } ?> />成为会员获得
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="manner" value="2" <?php  if($item['manner']==2) { ?>checked<?php  } ?> />关注公众号获得
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="manner" value="3" <?php  if($item['manner']==3) { ?>checked<?php  } ?> />完成任务获得
                        </label>
                        <div class="help-block">指定用户获得积分的方式</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">指定任务</label>
                    <div class="col-sm-9">
                        <select name="share_taskid">
                            <option value="0">不指定</option>
                            <?php  if(is_array($tasklist)) { foreach($tasklist as $task) { ?>
                                <option value="<?php  echo $task['id'];?>" <?php  if($item['share_taskid'] == $task['id']) { ?>selected<?php  } ?>><?php  echo $task['task_title'];?></option>
                            <?php  } } ?>
                        </select>
                        <div class="help-block">上一项设置为完成任务获得时有效，如果不指定任务，用户随机完成一个任务后即可获得分享积分</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="share_title" value="<?php  echo $item['share_title'];?>">
                        <div class="help-block">会员名：#会员名#</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享内容</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="share_desc" value="<?php  echo $item['share_desc'];?>">
                        <div class="help-block">会员名：#会员名#</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享图片</label>
                    <div class="col-sm-9">
                        <?php  echo tpl_form_field_image('share_image', $item['share_image'])?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                通知设置
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务通知模板id</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="task_tempid1" value="<?php  echo $item['task_tempid1'];?>">
                        <div class="help-block">请在<span class="label label-info">IT科技-互联网|电子商务</span>搜索<span class="label label-info">任务处理通知</span>，添加编号为<span class="label label-info">OPENTM200605630</span>的模板</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">通知用户</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="task_temp_user" value="<?php  echo $item['task_temp_user'];?>">
                        <div class="help-block">请填写用用户id,多个用户用|分隔，只通知任务领取，需要关注公众号后接收到通知</div>
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
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
