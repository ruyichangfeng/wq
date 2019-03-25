<?php
//1.2版本更新
if(!pdo_fieldexists('dh_task_setting', 'isneedfollow')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `isneedfollow` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '是否开始关注二维码'");
}
if(!pdo_fieldexists('dh_task_setting', 'follow_image')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `follow_image` VARCHAR( 255 ) NOT NULL COMMENT  '关注二维码'");
}
if(!pdo_fieldexists('dh_task_setting', 'weblogo')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `weblogo` VARCHAR( 255 ) NOT NULL COMMENT  '网站logo'");
}
//1.3版本更新
if(pdo_fieldexists('dh_task_receive', 'status')) {
  pdo_query("ALTER TABLE  ".tablename('dh_task_receive')." CHANGE  `status`  `status` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '0代表未审核1通过2不通过3审核中4已放弃'");
}
//1.4版本更新
$sql = "
CREATE TABLE IF NOT EXISTS `ims_dh_task_ad` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL COMMENT '公众号id',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `image` varchar(255) NOT NULL COMMENT '图片',
  `mark` varchar(255) NOT NULL COMMENT '描述',
  `link` varchar(255) NOT NULL COMMENT '链接',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '类型1首页幻灯片',
  `sorting` int(10) NOT NULL DEFAULT '1' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;
";
pdo_query($sql);

if(!pdo_fieldexists('dh_task_receive', 'image')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_receive')." ADD  `image` VARCHAR( 255 ) NOT NULL COMMENT  '凭证图片'");
}

//1.5版本更新
if(!pdo_fieldexists('dh_task_fans', 'account_type')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_fans')." ADD  `account_type` varchar(50) NOT NULL COMMENT '提现账户类型'");
}
if(!pdo_fieldexists('dh_task_fans', 'account')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_fans')." ADD  `account` varchar(50) NOT NULL COMMENT '提现账户'");
}
if(!pdo_fieldexists('dh_task_fans', 'point_gift')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_fans')." ADD  `point_gift` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否赠送了新用户积分'");
}
if(!pdo_fieldexists('dh_task_fans', 'qrcode')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_fans')." ADD  `qrcode` varchar(150) NOT NULL COMMENT '推广二维码'");
}
if(!pdo_fieldexists('dh_task_fans', 'is_commission')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_fans')." ADD  `is_commission` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否完成推广任务'");
}

if(!pdo_fieldexists('dh_task_task', 'is_show')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_task')." ADD  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示，用于删除任务'");
}
$sql = "
    CREATE TABLE IF NOT EXISTS `ims_dh_task_field` (
      `id` int(10) NOT NULL AUTO_INCREMENT,
      `weid` int(10) NOT NULL,
      `fieldset_id` int(10) NOT NULL,
      `name` varchar(250) NOT NULL,
      `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '类型1为文本框2下拉选项',
      `sorting` int(10) NOT NULL DEFAULT '1' COMMENT '排序',
      `config` varchar(255) NOT NULL COMMENT '如果为下拉单选类型时的字段值',
      `default` text NOT NULL COMMENT '默认值',
      `verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '字段验证0无1必填2数字3电话',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

    CREATE TABLE IF NOT EXISTS `ims_dh_task_fieldset` (
      `id` int(10) NOT NULL AUTO_INCREMENT,
      `weid` int(10) NOT NULL,
      `name` varchar(250) NOT NULL COMMENT '表名',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
pdo_query($sql);

if(!pdo_fieldexists('dh_task_points', 'type')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_points')." ADD  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1任务，2系统，3充值提现'");
}
if(!pdo_fieldexists('dh_task_receive', 'field')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_receive')." ADD  `field` text NOT NULL COMMENT '表单内容，采用json存储'");
}

if(pdo_fieldexists('dh_task_receive', 'image')) {
  $result = pdo_query("ALTER TABLE  ".tablename('dh_task_receive')." CHANGE  `image`  `image` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '凭证图片，json格式存贮多张图片'");
}
$sql="
    CREATE TABLE IF NOT EXISTS `ims_dh_task_recharge` (
      `id` int(10) NOT NULL AUTO_INCREMENT,
      `weid` int(10) NOT NULL,
      `user_id` int(10) NOT NULL COMMENT '用户id',
      `price` decimal(10,2) NOT NULL COMMENT '金额',
      `points` int(10) NOT NULL COMMENT '积分',
      `mark` varchar(250) NOT NULL COMMENT '备注',
      `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0处理中，2成功，3失败',
      `time` int(10) NOT NULL COMMENT '提交时间',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='充值提现表' AUTO_INCREMENT=1 ;
";
pdo_query($sql);
if(!pdo_fieldexists('dh_task_setting', 'point_propor')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `point_propor` int(4) NOT NULL DEFAULT '100' COMMENT '积分提现比例，1元等于多少积分'");
}
if(!pdo_fieldexists('dh_task_setting', 'is_propor')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `is_propor` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启提现功能'");
}
if(!pdo_fieldexists('dh_task_setting', 'min_point')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `min_point` int(10) NOT NULL DEFAULT '0' COMMENT '最小提现积分'");
}
if(!pdo_fieldexists('dh_task_setting', 'is_commission')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `is_commission` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启分销功能'");
}
if(!pdo_fieldexists('dh_task_setting', 'share_title')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `share_title` varchar(50) NOT NULL COMMENT '分享标题'");
}
if(!pdo_fieldexists('dh_task_setting', 'share_desc')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `share_desc` varchar(100) NOT NULL COMMENT '分享描述'");
}
if(!pdo_fieldexists('dh_task_setting', 'share_image')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `share_image` varchar(100) NOT NULL COMMENT '分享图片'");
}
if(!pdo_fieldexists('dh_task_setting', 'share_point')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `share_point` int(10) NOT NULL DEFAULT '0' COMMENT '分享后获得多少积分，在完成一个任务后获得'");
}
if(!pdo_fieldexists('dh_task_setting', 'follow_task')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `follow_task` tinyint(1) NOT NULL DEFAULT '1' COMMENT '未关注是否可以领取任务'");
}
if(!pdo_fieldexists('dh_task_setting', 'share_taskid')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `share_taskid` int(10) NOT NULL DEFAULT '0' COMMENT '分享后指定完成的任务'");
}
if(!pdo_fieldexists('dh_task_task', 'fieldset_id')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_task')." ADD  `fieldset_id` int(10) NOT NULL COMMENT '绑定的自定义字段'");
}
if(!pdo_fieldexists('dh_task_task', 'status')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_task')." ADD  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示'");
}
//1.6版本新增
if(!pdo_fieldexists('dh_task_setting', 'task_tempid1')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `task_tempid1` varchar(50) NOT NULL COMMENT '任务模板消息id'");
}
if(!pdo_fieldexists('dh_task_setting', 'task_temp_user')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_setting')." ADD  `task_temp_user` varchar(200) NOT NULL COMMENT '通知接收人'");
}
//2.0新增
if(!pdo_fieldexists('dh_task_task', 'auto_review')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_task')." ADD  `auto_review` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '是否自动提交审核'");
}
if(!pdo_fieldexists('dh_task_task', 'user_level')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_task')." ADD  `user_level` INT( 10 ) NOT NULL DEFAULT  '0' COMMENT  '完成任务提升等级'");
}
if(!pdo_fieldexists('dh_task_task', 'nav_id')) {
    pdo_query("ALTER TABLE ".tablename('dh_task_task')." ADD  `nav_id` INT( 10 ) NOT NULL COMMENT  '导航分类id'");
}
$sql = "
CREATE TABLE IF NOT EXISTS `ims_dh_task_task_nav` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `title` varchar(250) NOT NULL COMMENT '导航名称',
  `sorting` int(10) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
pdo_query($sql);
echo "执行完毕";