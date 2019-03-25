<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_header", TEMPLATE_INCLUDEPATH)) : (include template("base/child_header", TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/static/color/jquery.js"></script>
<script type="text/javascript" src="<?php echo MODULE_URL;?>/static/color/jquery.colorpicker.js"></script>
<?php  $config=$beforeList?>
<style>
    .notice {margin-top:20px !important;}
    img{margin-left:30px;height:30px;}
</style>
<blockquote class="layui-elem-quote ">
    <div class="layui-inline">
        <?php  if($_GPC['group']==1) { ?>
            请参考微信进行设置.(关闭状态,不显示设置区块)
        <?php  } else if($_GPC['group']==2) { ?>
            微信通知消息设置
        <?php  } else if($_GPC['group']==3) { ?>
            七牛云存储设置,密钥获取(个人中心>密钥管理),先创建一个名为yqkzy的bucket,否则无法使用.
        <?php  } else if($_GPC['group']==5) { ?>
            首页设置,状态设置,软件名,微信菜单设置
        <?php  } else if($_GPC['group']==6) { ?>
            一个公众号多应用设置
        <?php  } else if($_GPC['group']==7) { ?>
            短信配置(<a href="https://dayu.aliyun.com/" target="_blank">阿里云短信服务</a>)
        <?php  } else if($_GPC['group']==8) { ?>
            注册流程设置
        <?php  } else if($_GPC['group']==9) { ?>
            云端注册,云市场|次帐号可在云市场使用,请记住
        <?php  } else if($_GPC['group']==110) { ?>
            系统可以用链接
        <?php  } else { ?>
            处理流程设置
        <?php  } ?>
    </div>
</blockquote>
<form class="layui-form" style="margin-left:40px;" >
    <input type="hidden" name="in[group]" id="gp" value="<?php  echo $_GPC['group'];?>">
    <input type="hidden" name="group" value="<?php  echo $_GPC['group'];?>">
    <!--首页设置-->
    <?php  if($_GPC['group']==1) { ?>
    <?php  } ?>
    <!--消息提醒设置-->
    <?php  if($_GPC['group']==2) { ?>
    <div class="layui-form-item">
        <label class="layui-form-label">通知消息</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[msg_add]" value="1"  lay-filter="ck"  uni_id="msg_add" <?php  if($config['msg_add']==1) { ?> checked <?php  } ?>  title="开启">
            <div class="layui-unselect layui-form-checkbox" lay-skin="">
                <span>开启</span>
                <i class="layui-icon"></i>
            </div>
        </div>
    </div>
    <div class="layui-form-item msg_add" <?php  if($config['msg_add']==1) { ?>style='display:block'<?php  } else { ?>style='display:none'<?php  } ?> >
        <label class="layui-form-label">模板ID</label>
        <div class="layui-input-block">
            <input type="text" name="in[tpl_register]" lay-verify="title" value="<?php  echo $config['tpl_register'];?>"  placeholder="请输入模板ID" class="layui-input" style="width: 400px;">
            <label class="notice">
                请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”<br>
                添加标题为：”流程执行结果提醒“，编号为：“OPENTM207112569”的模板。
            </label>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">提醒消息</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[msg_add_r]" value="1"  lay-filter="ck"  uni_id="msg_add_r" <?php  if($config['msg_add_r']==1) { ?> checked <?php  } ?>  title="开启">
        </div>
    </div>
    <div class="layui-form-item msg_add_r">
        <label class="layui-form-label">提醒人员</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[msg_add_re]" value="1" <?php  if($config['msg_add_re']==1) { ?> checked <?php  } ?>  title="固定"> <a class="layui-btn layui-btn-radius  layui-btn-mini s_m" href="javascript:">谨慎设置</a>
        </div>
    </div>
    <div class="layui-form-item msg_add_r" <?php  if($config['msg_add_r']==1) { ?>style='display:block'<?php  } else { ?>style='display:none'<?php  } ?> >
    <label class="layui-form-label">模板ID</label>
    <div class="layui-input-block">
        <input type="text" name="in[tpl_remind]" lay-verify="title" value="<?php  echo $config['tpl_remind'];?>"  placeholder="请输入模板ID" class="layui-input" style="width: 400px;">
        <label class="notice">
            请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”<br>
            添加标题为：”订单超时提醒“，编号为：“OPENTM207029449”的模板。
        </label>
        <p></p>
        <br>
        <p>宝塔计划任务</p>
        <p>
            URL地址：<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&do=remind&m=gd_zlyqk&num=2&time=30
        </p>
        <p>
            参数对照:URL地址：<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&do=remind&m=gd_zlyqk&num=总共提醒多少次&time=两次提醒时间间隔(分钟)
        </p>
        <br>
        <p>
            <p>非宝塔（百度linux添加计划任务）：</p>
            <p> <h3>操作步骤</h3></p>
            <p>安装curl</p>
            <p>ubuntu服务器 apt-get install curl</p>
            <p>centos服务器 yum install curl</p>
            <p>crontab -e 编辑计划任务输入</p>
            <p>*/2 * * * * curl -sS --connect-timeout 10 -m 60 '<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&do=remind&m=gd_zlyqk&time=30'</p>
            <p>参数对照:*/几分钟 * * * * curl -sS --connect-timeout 10 -m 60 '<?php  echo $_W['siteroot'];?>app/index.php?i=<?php  echo $_W['uniacid'];?>&c=entry&do=remind&m=gd_zlyqk&time=提醒时间间隔（单位分钟）'</p>
        </p>
    </div>

    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="save">立即提交</button>
        </div>
    </div>
    <?php  } ?>
    <!--云存储设置-->
    <?php  if($_GPC['group']==3) { ?>
    <div class="layui-form-item">
        <label class="layui-form-label">图片</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[img_local]" value="1"   <?php  if($config['img_local']==1) { ?> checked <?php  } ?> title="本地存储">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">7牛</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[ak_sk]" value="1"  lay-filter="ck"  uni_id="ak_sk" <?php  if($config['ak_sk']==1) { ?> checked <?php  } ?> title="开启(语音必须开启)">
        </div>
    </div>
    <div class="layui-form-item ak_sk" <?php  if($config['ak_sk']==1) { ?>style='display:block'<?php  } else { ?>style='display:none'<?php  } ?>>
    <label class="layui-form-label">bucket</label>
    <div class="layui-input-block">
        <input type="text" name="in[bucket]" lay-verify="title" value="<?php  echo $config['bucket'];?>" placeholder="默认 yqkzy" class="layui-input" style="width: 400px;">
    </div>
    </div>
    <div class="layui-form-item ak_sk" <?php  if($config['ak_sk']==1) { ?>style='display:block'<?php  } else { ?>style='display:none'<?php  } ?>>
        <label class="layui-form-label">AK</label>
        <div class="layui-input-block">
            <input type="text" name="in[ak_text]" lay-verify="title" value="<?php  echo $config['ak_text'];?>" placeholder="ak_text" class="layui-input" style="width: 400px;">
        </div>
    </div>

    <div class="layui-form-item ak_sk" <?php  if($config['ak_sk']==1) { ?>style='display:block'<?php  } else { ?>style='display:none'<?php  } ?>>
        <label class="layui-form-label">SK</label>
        <div class="layui-input-block">
            <input type="text" name="in[sk_text]" lay-verify="title" value="<?php  echo $config['sk_text'];?>" placeholder="sk_text" class="layui-input" style="width: 400px;">
        </div>
    </div>
    <div class="layui-form-item ak_sk" <?php  if($config['ak_sk']==1) { ?>style='display:block'<?php  } else { ?>style='display:none'<?php  } ?>>
    <label class="layui-form-label">外链路径</label>
    <div class="layui-input-block">
        <input type="text" name="in[niu_url]" lay-verify="title" value="<?php  echo $config['niu_url'];?>" placeholder="资源外链路径,例如=:http://ov2ibvpc6.bkt.clouddn.com" class="layui-input" style="width: 400px;">
    </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="save">立即提交</button>
        </div>
    </div>
    <?php  } ?>

    <!--云存储设置-->
    <?php  if($_GPC['group']==110) { ?>
    <div class="layui-form-item ak_sk" style="margin-top:30px;">
    <label class="layui-form-label">微信首页</label>
    <div class="layui-input-block">
        <input type="text" lay-verify="title" value="<?php  echo $_W['siteroot'];?>app/<?php  echo $this->createMobileUrl('appList')?>"   class="layui-input" style="width: 600px;border:0;border-bottom: 1px solid #ccc;">
    </div>
    </div>
    <div class="layui-form-item ak_sk" style="margin-top:30px;">
        <label class="layui-form-label">提交列表</label>
        <div class="layui-input-block">
            <input type="text" lay-verify="title" value="<?php  echo $_W['siteroot'];?>app/<?php  echo $this->createMobileUrl('category')?>"   class="layui-input" style="width: 600px;border:0;border-bottom: 1px solid #ccc;">
        </div>
    </div>

    <div class="layui-form-item ak_sk" style="margin-top:30px;">
        <label class="layui-form-label">个人中心</label>
        <div class="layui-input-block">
            <input type="text" lay-verify="title" value="<?php  echo $_W['siteroot'];?>app/<?php  echo $this->createMobileUrl('member')?>"   class="layui-input" style="width: 600px;border:0;border-bottom: 1px solid #ccc;">
        </div>
    </div>
    <div class="layui-form-item ak_sk" style="margin-top:30px;">
        <label class="layui-form-label">注册页</label>
        <div class="layui-input-block">
            <input type="text" lay-verify="title" value="<?php  echo $_W['siteroot'];?>app/<?php  echo $this->createMobileUrl('memberInfo')?>"   class="layui-input" style="width: 600px;border:0;border-bottom: 1px solid #ccc;">
        </div>
    </div>
    <div class="layui-form-item ak_sk" style="margin-top:30px;">
        <label class="layui-form-label">员工入驻</label>
        <div class="layui-input-block">
            <input type="text" lay-verify="title" value="<?php  echo $_W['siteroot'];?>app/<?php  echo $this->createMobileUrl('staffIn')?>"   class="layui-input" style="width: 600px;border:0;border-bottom: 1px solid #ccc;">
        </div>
    </div>
    <div class="layui-form-item ak_sk" style="margin-top:30px;">
        <label class="layui-form-label">公告列表</label>
        <div class="layui-input-block">
            <input type="text" lay-verify="title" value="<?php  echo $_W['siteroot'];?>app/<?php  echo $this->createMobileUrl('articles')?>"   class="layui-input" style="width: 600px;border:0;border-bottom: 1px solid #ccc;">
        </div>
    </div>
    <div class="layui-form-item ak_sk" style="margin-top:30px;">
        <label class="layui-form-label">员工中心</label>
        <div class="layui-input-block">
            <input type="text" lay-verify="title" value="<?php  echo $_W['siteroot'];?>app/<?php  echo $this->createMobileUrl('staff')?>"   class="layui-input" style="width: 600px;border:0;border-bottom: 1px solid #ccc;">
        </div>
    </div>
    <div class="layui-form-item ak_sk" style="margin-top:30px;">
        <label class="layui-form-label">工作台</label>
        <div class="layui-input-block">
            <input type="text" lay-verify="title" value="<?php  echo $_W['siteroot'];?>app/<?php  echo $this->createMobileUrl('msg')?>"   class="layui-input" style="width: 600px;border:0;border-bottom: 1px solid #ccc;">
        </div>
    </div>
    <div class="layui-form-item ak_sk" style="margin-top:30px;">
        <label class="layui-form-label">后台地址</label>
        <div class="layui-input-block">
            <input type="text" lay-verify="title" value="<?php  echo $config['login'];?>"   class="layui-input" style="width: 600px;border:0;border-bottom: 1px solid #ccc;">
        </div>
    </div>
    <?php  } ?>

    <!--云存储设置-->
    <?php  if($_GPC['group']==4) { ?>
    <div class="layui-form-item ak_sk" >
        <label class="layui-form-label">状态数</label>
        <div class="layui-input-block">
            <input type="text" name="in[max_status]" lay-verify="title" value="<?php  echo $config['max_status'];?>" placeholder="状态数" class="layui-input" style="width: 400px;">
        </div>
    </div>
    <div class="layui-form-item ak_sk" >
        <label class="layui-form-label">表单数</label>
        <div class="layui-input-block">
            <input type="text" name="in[max_form]" lay-verify="title" value="<?php  echo $config['max_form'];?>" placeholder="表单数" class="layui-input" style="width: 400px;">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="save">立即提交</button>
        </div>
    </div>
    <?php  } ?>

    <!--中文语言设置-->
    <?php  if($_GPC['group']==5) { ?>
    <fieldset style="border: 1px solid #00a65a;margin-top:20px;width: 550px;margin-bottom:20px;">
        <legend >页面设置</legend>
        <!--<div class="layui-form-item">-->
            <!--<label class="layui-form-label">默认首页</label>-->
            <!--<div class="layui-input-block">-->
                <!--<input type="radio" name="in[df_index]" value="1" <?php  if($config['df_index']==1) { ?>checked<?php  } ?> title="应用列表">-->
                <!--<input type="radio" name="in[df_index]" value="2" <?php  if($config['df_index']==2) { ?>checked<?php  } ?> title="默认表单" >-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="layui-form-item">-->
            <!--<label class="layui-form-label">消息菜单</label>-->
            <!--<div class="layui-input-block">-->
                <!--<input type="radio" name="in[staff_mg]" value="1" <?php  if($config['staff_mg']==1) { ?>checked<?php  } ?> title="开启" >-->
                <!--<input type="radio" name="in[staff_mg]" value="0" <?php  if($config['staff_mg']==0) { ?>checked<?php  } ?> title="关闭">-->
            <!--</div>-->
        <!--</div>-->
        <div class="layui-form-item">
            <label class="layui-form-label">入驻申请</label>
            <div class="layui-input-block">
                <input type="radio" name="in[staff_in]" value="1" <?php  if($config['staff_in']==1) { ?>checked<?php  } ?> title="开启" >
                <input type="radio" name="in[staff_in]" value="0" <?php  if($config['staff_in']==0) { ?>checked<?php  } ?> title="关闭">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">工作台菜单</label>
            <div class="layui-input-block">
                <input type="radio" name="in[pt_in]" value="1" <?php  if($config['pt_in']==1) { ?>checked<?php  } ?> title="开启" >
                <input type="radio" name="in[pt_in]" value="0" <?php  if($config['pt_in']==0) { ?>checked<?php  } ?> title="关闭">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">消息页菜单</label>
            <div class="layui-input-block">
                <input type="radio" name="in[msg_in]" value="1" <?php  if($config['msg_in']==1) { ?>checked<?php  } ?> title="开启" >
                <input type="radio" name="in[msg_in]" value="0" <?php  if($config['msg_in']==0) { ?>checked<?php  } ?> title="关闭">
            </div>
        </div>
        <div class="layui-form-item " >
            <label class="layui-form-label">主题色调</label>
            <div class="layui-input-block">
                <input type="text" name="in[app_color]"  value="<?php  if($config['app_color']) { ?> <?php  echo $config['app_color'];?> <?php  } else { ?> #f08500 <?php  } ?>" placeholder="主题色调" class="layui-input app_them" style="width: 200px;color:<?php  if($config['app_color']) { ?> <?php  echo $config['app_color'];?> <?php  } else { ?> #f08500 <?php  } ?>">
                <div style="position: absolute;margin-left: 140px;margin-top:-27px;">
                    <img src="<?php echo MODULE_URL;?>/static/color/colorpicker.png" id="cp100" style="cursor:pointer;width:18px;height:18px;"/>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset style="border: 1px solid #00a65a;margin-top:20px;width: 550px;margin-bottom:20px;">
        <legend >微信标题</legend>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">首页</label>
            <div class="layui-input-block">
                <input type="text" name="in[wx_index]" lay-verify="title" value="<?php  echo $config['wx_index'];?>" placeholder="首页" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">个人中心</label>
            <div class="layui-input-block">
                <input type="text" name="in[wx_self]" lay-verify="title" value="<?php  echo $config['wx_self'];?>" placeholder="个人中心" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">信息维护</label>
            <div class="layui-input-block">
                <input type="text" name="in[wx_info]" lay-verify="title" value="<?php  echo $config['wx_info'];?>" placeholder="信息维护" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">应用首页</label>
            <div class="layui-input-block">
                <input type="text" name="in[wx_app_list]" lay-verify="title" value="<?php  echo $config['wx_app_list'];?>" placeholder="微信菜单" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">消息列表</label>
            <div class="layui-input-block">
                <input type="text" name="in[msg_my]" lay-verify="title" value="<?php  echo $config['msg_my'];?>" placeholder="消息列表" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">消息详情</label>
            <div class="layui-input-block">
                <input type="text" name="in[msg_detail]" lay-verify="title" value="<?php  echo $config['msg_detail'];?>" placeholder="消息详情" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">任务列表</label>
            <div class="layui-input-block">
                <input type="text" name="in[task_list]" lay-verify="title" value="<?php  echo $config['task_list'];?>" placeholder="任务列表" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">通知列表</label>
            <div class="layui-input-block">
                <input type="text" name="in[notice_list]" lay-verify="title" placeholder="通知列表"  value="<?php  echo $config['notice_list'];?>"  class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">通知详情</label>
            <div class="layui-input-block">
                <input type="text" name="in[notice_detail]" lay-verify="title" placeholder="通知详情" value="<?php  echo $config['notice_detail'];?>"  class="layui-input" style="width: 400px;">
            </div>
        </div>
    </fieldset>

    <fieldset style="border: 1px solid #00a65a;margin-top:20px;width: 550px;margin-bottom:20px;">
        <legend >节点状态</legend>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">待分配</label>
            <div class="layui-input-block">
                <input type="text" name="in[node_status_0]" lay-verify="title" value="<?php  echo $config['node_status_0'];?>" placeholder="待分配" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">可处理</label>
            <div class="layui-input-block">
                <input type="text" name="in[node_status_4]" lay-verify="title" value="<?php  echo $config['node_status_4'];?>" placeholder="可处理" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">待处理</label>
            <div class="layui-input-block">
                <input type="text" name="in[node_status_2]" lay-verify="title" value="<?php  echo $config['node_status_2'];?>" placeholder="待处理" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">已处理</label>
            <div class="layui-input-block">
                <input type="text" name="in[node_status_3]" lay-verify="title" value="<?php  echo $config['node_status_3'];?>" placeholder="已完成" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">接单</label>
            <div class="layui-input-block">
                <input type="text" name="in[jd]" lay-verify="title" value="<?php  echo $config['jd'];?>" placeholder="已完成" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item " >
            <label class="layui-form-label">数据报表</label>
            <div class="layui-input-block">
                <input type="text" name="in[sjbb]" lay-verify="title" value="<?php  echo $config['sjbb'];?>" placeholder="数据报表（微信端）" class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item " >
            <label class="layui-form-label">流程进程</label>
            <div class="layui-input-block">
                <input type="text" name="in[lcjc]" lay-verify="title" value="<?php  echo $config['lcjc'];?>" placeholder="流程进程（微信端）" class="layui-input" style="width: 400px;">
            </div>
        </div>
    </fieldset>

    <fieldset style="border: 1px solid #00a65a;margin-top:20px;width: 550px;margin-bottom:20px;">
        <legend >消息状态</legend>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">待处理</label>
            <div class="layui-input-block">
                <input type="text" name="in[msg_status_0]" lay-verify="title" value="<?php  echo $config['msg_status_0'];?>" placeholder="待处理" class="layui-input" style="width: 400px;">
                <div style="margin-top:5px;">
                    <span id="cp1_text" style="color:<?php  echo $config['msg_color_0'];?>"><?php  if($config['msg_color_0']) { ?> <?php  echo $config['msg_color_0'];?> <?php  } else { ?> #000000 <?php  } ?></span>
                    <img src="<?php echo MODULE_URL;?>/static/color/colorpicker.png" id="cp1" style="cursor:pointer;width:18px;height:18px;"/>
                    <input type="hidden" name="in[msg_color_0]" value="<?php  echo $config['msg_color_0'];?>" id="color_1">
                </div>
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">处理中</label>
            <div class="layui-input-block">
                <input type="text" name="in[msg_status_1]" lay-verify="title" value="<?php  echo $config['msg_status_1'];?>" placeholder="处理中" class="layui-input" style="width: 400px;">
                <div style="margin-top:5px;">
                    <span id="cp2_text" style="color:<?php  echo $config['msg_color_1'];?>"><?php  if($config['msg_color_1']) { ?> <?php  echo $config['msg_color_1'];?> <?php  } else { ?> #000000 <?php  } ?></span>
                    <img src="<?php echo MODULE_URL;?>/static/color/colorpicker.png" id="cp2" style="cursor:pointer;width:18px;height:18px;"/>
                    <input type="hidden" name="in[msg_color_1]" value="<?php  echo $config['msg_color_1'];?>" id="color_2">
                </div>
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">已完成</label>
            <div class="layui-input-block">
                <input type="text" name="in[msg_status_2]" lay-verify="title" value="<?php  echo $config['msg_status_2'];?>" placeholder="已完成" class="layui-input" style="width: 400px;">
                <div style="margin-top:5px;">
                    <span id="cp3_text" style="color:<?php  echo $config['msg_color_2'];?>"><?php  if($config['msg_color_2']) { ?> <?php  echo $config['msg_color_2'];?> <?php  } else { ?> #000000 <?php  } ?></span>
                    <img src="<?php echo MODULE_URL;?>/static/color/colorpicker.png" id="cp3" style="cursor:pointer;width:18px;height:18px;"/>
                    <input type="hidden" name="in[msg_color_2]" value="<?php  echo $config['msg_color_2'];?>" id="color_3">
                </div>
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">已撤销</label>
            <div class="layui-input-block">
                <input type="text" name="in[msg_status_3]" lay-verify="title" value="<?php  echo $config['msg_status_3'];?>"  placeholder="已撤销" class="layui-input" style="width: 400px;">
                <div style="margin-top:5px;">
                    <span id="cp4_text" style="color:<?php  echo $config['msg_color_3'];?>"><?php  if($config['msg_color_3']) { ?> <?php  echo $config['msg_color_3'];?> <?php  } else { ?> #000000 <?php  } ?></span>
                    <img src="<?php echo MODULE_URL;?>/static/color/colorpicker.png" id="cp4" style="cursor:pointer;width:18px;height:18px;"/>
                    <input type="hidden" name="in[msg_color_3]" value="<?php  echo $config['msg_color_3'];?>" id="color_4">
                </div>
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">已转单</label>
            <div class="layui-input-block">
                <input type="text" name="in[msg_status_4]" lay-verify="title" value="<?php  echo $config['msg_status_4'];?>" placeholder="已转单"  class="layui-input" style="width: 400px;">
                <div style="margin-top:5px;">
                    <span id="cp5_text" style="color:<?php  echo $config['msg_color_4'];?>"><?php  if($config['msg_color_4']) { ?> <?php  echo $config['msg_color_4'];?> <?php  } else { ?> #000000 <?php  } ?></span>
                    <img src="<?php echo MODULE_URL;?>/static/color/colorpicker.png" id="cp5" style="cursor:pointer;width:18px;height:18px;"/>
                    <input type="hidden" name="in[msg_color_4]" value="<?php  echo $config['msg_color_4'];?>" id="color_5">
                </div>
            </div>
        </div>
        <div class="layui-form-item ak_sk" >
            <label class="layui-form-label">被退回</label>
            <div class="layui-input-block">
                <input type="text" name="in[msg_status_5]" lay-verify="title" value="<?php  echo $config['msg_status_5'];?>" placeholder="被退回" class="layui-input" style="width: 400px;">
                <div style="margin-top:5px;">
                    <span id="cp6_text" style="color:<?php  echo $config['msg_color_5'];?>">#<?php  if($config['msg_color_5']) { ?> <?php  echo $config['msg_color_5'];?> <?php  } else { ?> #000000 <?php  } ?></span>
                    <img src="<?php echo MODULE_URL;?>/static/color/colorpicker.png" id="cp6" style="cursor:pointer;width:18px;height:18px;"/>
                    <input type="hidden" name="in[msg_color_5]" value="<?php  echo $config['msg_color_5'];?>" id="color_6">
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset style="border: 1px solid #00a65a;width: 550px;">
        <legend >其他设置</legend>
        <div class="layui-form-item">
            <label class="layui-form-label">系统名称</label>
            <div class="layui-input-block">
                <input type="text" name="in[soft_names]" lay-verify="title" value="<?php  echo $config['soft_names'];?>" placeholder="后台软件名"  class="layui-input" style="width: 400px;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登录页名称</label>
            <div class="layui-input-block">
                <input type="text" name="in[login_name]" lay-verify="title" value="<?php  echo $config['login_name'];?>" placeholder="登录页名称"  class="layui-input" style="width: 400px;">
            </div>
        </div>
    </fieldset>

    <div class="layui-form-item" style="margin-top: 20px;">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="save">立即提交</button>
        </div>
    </div>
    <?php  } ?>

    <!--多应用设置-->
    <?php  if($_GPC['group']==7) { ?>
    <div class="layui-form-item ak_sk" style="margin-top:30px;">
        <label class="layui-form-label">Access Key Id</label>
        <div class="layui-input-block">
            <input type="text" name="in[aki]" lay-verify="title" value="<?php  echo $config['aki'];?>"  class="layui-input" style="width: 400px;">
        </div>
    </div>
    <div class="layui-form-item ak_sk" >
        <label class="layui-form-label">Access Key Secret</label>
        <div class="layui-input-block">
            <input type="text" name="in[aks]" lay-verify="title" value="<?php  echo $config['aks'];?>"  class="layui-input" style="width: 400px;">
        </div>
    </div>
    <div class="layui-form-item ak_sk" >
        <label class="layui-form-label">短信签名</label>
        <div class="layui-input-block">
            <input type="text" name="in[qm]" lay-verify="title" value="<?php  echo $config['qm'];?>"  class="layui-input" style="width: 400px;">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">验证码</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[sms_switch]" value="1"  lay-filter="ck"  <?php  if($config['sms_switch']==1) { ?> checked <?php  } ?> title="开启">
        </div>
    </div>
    <div class="layui-form-item ak_sk" >
        <label class="layui-form-label">验证码模版</label>
        <div class="layui-input-block">
            <input type="text" name="in[mb]" lay-verify="title" value="<?php  echo $config['mb'];?>"  class="layui-input" style="width: 400px;">
            您的验证码:${code},5分钟有效
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">流程通知</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[sms_lc]" value="1"  lay-filter="ck"  <?php  if($config['sms_lc']==1) { ?> checked <?php  } ?> title="开启">
        </div>
    </div>
    <div class="layui-form-item ak_sk" >
        <label class="layui-form-label">流程模版</label>
        <div class="layui-input-block">
            <input type="text" name="in[mb_lc]" lay-verify="title" value="<?php  echo $config['mb_lc'];?>"  class="layui-input" style="width: 400px;">
            你好${name}，单号${order}，当前状态 ${status}，处理时间 ${time}
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="save">立即提交</button>
        </div>
    </div>
    <?php  } ?>

    <!--注册流程设置-->
    <?php  if($_GPC['group']==8) { ?>
    <div class="layui-form-item">
        <label class="layui-form-label">强制注册</label>
        <div class="layui-input-block">
            <input type="radio" name="in[register_in]" value="1" <?php  if($config['register_in']==1) { ?>checked<?php  } ?> title="开启" >
            <input type="radio" name="in[register_in]" value="0" <?php  if($config['register_in']==0) { ?>checked<?php  } ?> title="关闭">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">信息同步</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[member_syn]" value="1"  lay-filter="ck"  <?php  if($config['member_syn']==1) { ?> checked <?php  } ?> title="开启">
            <div class="layui-unselect layui-form-checkbox" lay-skin="">
                <span>开启</span>
                <i class="layui-icon"></i>
            </div>
            <span style="margin-left: 30px;">开启,电话姓名会同步系统会员信息</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">验证码</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[member_code]" value="1"  lay-filter="ck"  <?php  if($config['member_code']==1) { ?> checked <?php  } ?> title="开启">
            <div class="layui-unselect layui-form-checkbox" lay-skin="">
                <span>开启</span>
                <i class="layui-icon"></i>
            </div>
            <span style="margin-left: 30px;">手机号需要短信验证(需配置短信接口)</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">应用同步</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[member_group]" value="1"  lay-filter="ck"  <?php  if($config['member_group']==1) { ?> checked <?php  } ?> title="同步">
            <div class="layui-unselect layui-form-checkbox" lay-skin="">
                <span>同步</span>
                <i class="layui-icon"></i>
            </div>
            <span style="margin-left: 30px;">开启创建应用同时,会创建同名会员组</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">扩展会员信息</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[ext_member]" value="1"  lay-filter="ckys"  <?php  if($config['ext_member']==1) { ?> checked <?php  } ?> title="开启">
            <button class="layui-btn layui-btn-small layui-btn-danger adc_ad" <?php  if($config['ext_member']!=1) { ?>style="display:none"<?php  } ?>><i class="layui-icon"></i></button>
            <span style="margin-left: 30px;">开启可以扩展会员注册信息</span>
        </div>
    </div>
    <?php  if($config['ext_member']==1) { ?>
    <div class="layui-form-item member_step">
        <label class="layui-form-label">扩展信息分步填写</label>
        <div class="layui-input-block">
            <input type="checkbox" name="in[member_step]" value="1"   <?php  if($config['member_step']==1) { ?> checked <?php  } ?> title="开启">
            <span style="margin-left: 30px;">开启分配多个页面完成信息填写</span>
        </div>
    </div>
    <?php  } ?>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="save">立即提交</button>
        </div>
    </div>
    <?php  } ?>
    <!--云端注册-->
    <?php  if($_GPC['group']==9) { ?>
    <?php  if(empty($config['mi'])) { ?>
    <div class="layui-form-item yun_set" style="margin-top: 10px;">
        <label class="layui-form-label">电话</label>
        <div class="layui-input-block" >
            <input type="text"  name="in[yun_acc]"   value="<?php  echo $config['yun_acc'];?>"  class="layui-input" placeholder="填写电话" style="width: 300px;">
        </div>
    </div>
    <?php  } ?>

    <?php  if(empty($config['mi'])) { ?>
    <div class="layui-form-item yun_set" >
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block" >
            <input type="password"  name="yun_pass"   class="layui-input" placeholder="填写密码" style="width: 300px;">
        </div>
    </div>
    <?php  } ?>
    <div class="layui-form-item yun_set" <?php  if(!empty($config['mi'])) { ?>style="margin-top: 10px;"<?php  } ?> >
        <label class="layui-form-label">域名</label>
        <div class="layui-input-block" >
            <input type="text"  name="in[yun_domain]" readonly  value="<?php  echo $_W['siteroot'];?>"  class="layui-input" placeholder="填写域名" style="width: 300px;">
        </div>
    </div>
    <?php  if(!empty($config['mi'])) { ?>
    <div class="layui-form-item yun_set">
        <label class="layui-form-label">MI</label>
        <div class="layui-input-block" >
            <input type="text"  name="in[yun_mi]"  readonly value="<?php  echo $config['mi'];?>"  class="layui-input" placeholder="填写MI" style="width: 300px;">
        </div>
    </div>
    <?php  } ?>
    <div class="layui-form-item " style="display: none" >
        <label class="layui-form-label">入口</label>
        <div class="layui-input-block" >
            <a href="http://login.k9k.org" style="line-height: 38px;" target="_blank">http://login.k9k.org</a> <span style="color: red;margin-left:20px;">(员工登录地址)</span>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <?php  if(empty($config['mi'])) { ?>
            <button class="layui-btn" lay-submit="" lay-filter="save">立即提交</button>
            <?php  } ?>
        </div>
    </div>
    <?php  } ?>
</form>
<script>

    $("#cp1").colorpicker({
        fillcolor:true,
        success:function(o,color){
            $("#cp1_text").text(color).css("color",color);
            $("#color_1").val(color);
        }
    });
    $("#cp2").colorpicker({
        fillcolor:true,
        success:function(o,color){
            $("#cp2_text").text(color).css("color",color);
            $("#color_2").val(color);
        }
    });
    $("#cp3").colorpicker({
        fillcolor:true,
        success:function(o,color){
            $("#cp3_text").text(color).css("color",color);
            $("#color_3").val(color);
        }
    });
    $("#cp4").colorpicker({
        fillcolor:true,
        success:function(o,color){
            $("#cp4_text").text(color).css("color",color);
            $("#color_4").val(color);
        }
    });
    $("#cp5").colorpicker({
        fillcolor:true,
        success:function(o,color){
            $("#cp5_text").text(color).css("color",color);
            $("#color_5").val(color);
        }
    });

    $("#cp100").colorpicker({
        fillcolor:true,
        success:function(o,color){
            $(".app_them").val(color).css("color",color);
        }
    });

    $("#cp6").colorpicker({
        fillcolor:true,
        success:function(o,color){
            $("#cp6_text").text(color).css("color",color);
            $("#color_6").val(color);
        }
    });
    layui.use(['form','jquery','upload'], function(){
        var $ = layui.jquery;
        var form = layui.form();

        form.on('checkbox(ckys)', function(data){
            if(data.elem.checked){
                $(".adc_ad").show();
                $(".member_step").show();
            }else{
                $(".adc_ad").hide();
                $(".member_step").hide();
            }
        });

        layui.layer.photos({
            photos: '#imgList'
            ,anim: 5
        });
        layui.layer.photos({
            photos: '#imgList1'
            ,anim: 5
        });

        $(".adc_ad").click(function(){
            var id = $(this).attr("data-id");
            var url = "<?php  echo $this->createWebUrl('mExt')?>";
            var index = layui.layer.open({
                title : "编辑注册额外信息",
                type : 2,
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回注册设置', '.layui-layer-setwin .layui-layer-close', {tips: 3});
                    },500)
                }
            });
            layui.layer.full(index);
            return false;
        });

        $(".s_m").click(function(){
            var url = "<?php  echo $this->createWebUrl('List',array('tb'=>'mm'))?>";
            var index = layui.layer.open({
                title : "提醒人员",
                type : 2,
                area:['600px','80%'],
                content : url,
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返', '.layui-layer-setwin .layui-layer-close', {tips: 3});
                    },500)
                }
            });
            return false;
        });

        layui.upload({
            elem: '.layui-upload-file',
            url: "<?php  echo $this->createWebUrl('upload')?>",
            method: 'post',
            ext:'jpg|png|gif',
            success: function (res) {
                layui.layer.msg(res.msg);
                if(res.code==2){
                    return false;
                }
                $("#imgs").attr("src","/"+res.url);
                $("#cov").val(res.url);
            }
        });
        layui.upload({
            elem: '.layui-upload-file1',
            url: "<?php  echo $this->createWebUrl('upload')?>",
            method: 'post',
            ext:'jpg|png|gif',
            success: function (res) {
                layui.layer.msg(res.msg);
                if(res.code==2){
                    return false;
                }
                $("#imgs1").attr("src","/"+res.url);
                $("#cov1").val(res.url);
            }
        });

        form.on('checkbox(ck)', function(data){
            var _this=$(this);
            var uni_id = _this.attr('uni_id');
            if(uni_id!='undefined'){
                if(data.elem.checked){
                    $("."+uni_id).css("display","block");
                }else{
                    $("."+uni_id).css("display","none");
                }
            }
        });
        form.on('submit(save)', function(data){
            $.post("<?php  echo $this->createWebUrl('Add',array('tb'=>'setting'))?>",data.field,function(response){
                layer.msg(response.msg,{type:1});
                if(response.code==1){
                    setTimeout(function(){
                        if($("#gp").val()==9){
                            parent.location.reload();
                        }else{
                            location.reload();
                        }
                    },1000);
                }
            },'json');
            return false;
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template("base/child_footer", TEMPLATE_INCLUDEPATH)) : (include template("base/child_footer", TEMPLATE_INCLUDEPATH));?>