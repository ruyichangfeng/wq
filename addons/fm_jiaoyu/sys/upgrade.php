<?php
$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_user' ) . "(
  	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID',	
	`tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '教师ID',
  	`weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`uid` int(10) unsigned NOT NULL COMMENT '微擎系统memberID',	
  	`openid` varchar(30) NOT NULL COMMENT 'openid',
	`userinfo` text COMMENT '用户信息',
	`pard` int(1) unsigned NOT NULL COMMENT '关系',
  	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户状态',
	`is_allowmsg` tinyint(1) NOT NULL DEFAULT '1' COMMENT '私聊信息接收语法',
  	`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  	PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_set' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `weid` int(10) unsigned NOT NULL,
    `istplnotice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否模版通知',
	`gunali` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理方式',
    `xsqingjia` varchar(200) DEFAULT '' COMMENT '学生请假申请ID',
	`xsqjsh` varchar(200) DEFAULT '' COMMENT '学生请假审核通知ID',
	`jsqingjia` varchar(200) DEFAULT '' COMMENT '教员请假申请体提醒ID',
	`jsqjsh` varchar(200) DEFAULT '' COMMENT '教员请假审核通知ID',
	`xxtongzhi` varchar(200) DEFAULT '' COMMENT '学校通知ID',
	`liuyan` varchar(200) DEFAULT '' COMMENT '家长留言ID',
	`liuyanhf` varchar(200) DEFAULT '' COMMENT '教师回复家长留言ID',
	`zuoye` varchar(200) DEFAULT '' COMMENT '发布作业提醒ID',
	`bjtz` varchar(200) DEFAULT '' COMMENT '班级通知ID',
	`bjqshjg` varchar(200) DEFAULT '' COMMENT '',
	`bjqshtz` varchar(200) DEFAULT '' COMMENT '',	
	`jxlxtx` varchar(200) DEFAULT '' COMMENT '进校提醒',
	`jfjgtz` varchar(200) DEFAULT '' COMMENT '缴费结果通知',
	`htname` varchar(200) DEFAULT '' COMMENT '后台系统名称',
	`banner1` varchar(200) DEFAULT '' COMMENT '',
	`banner2` varchar(200) DEFAULT '' COMMENT '',
	`banner3` varchar(200) DEFAULT '' COMMENT '',
	`banner4` varchar(200) DEFAULT '' COMMENT '',
       PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_leave' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
	`leaveid` int(10) unsigned NOT NULL,
    `weid` int(10) unsigned NOT NULL,
	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`uid` int(10) unsigned NOT NULL COMMENT '微擎UID',
	`tuid` int(10) unsigned NOT NULL COMMENT '老师微擎UID',	
	`userid` int(10) unsigned NOT NULL COMMENT '发送者id',
	`touserid` int(10) unsigned NOT NULL COMMENT '接收者id',		
	`openid` varchar(200) DEFAULT '' COMMENT 'openid',
	`sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID',	
	`tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '教师ID',
	`type` varchar(10) DEFAULT '' COMMENT '请假类型',
    `startime` varchar(200) DEFAULT '' COMMENT '开始时间',
	`endtime` varchar(200) DEFAULT '' COMMENT '结束时间',
    `startime1` int(10) unsigned NOT NULL COMMENT '开始时间',
	`endtime1` int(10) unsigned NOT NULL COMMENT '结束时间',
	`conet` varchar(200) DEFAULT '' COMMENT '详细内容',
	`reconet` varchar(200) DEFAULT '' COMMENT '详细内容',
	`createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
	`cltime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理时间',
	`cltid` int(10) unsigned NOT NULL COMMENT '老师id',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态',
	`bj_id` int(10) unsigned NOT NULL COMMENT '班级ID',
	`teacherid` int(11) DEFAULT NULL,
	`isliuyan` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否留言',
	`isfrist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1是0否',
	`isread` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1未读2已读',
       PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_notice' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `weid` int(10) unsigned NOT NULL,
	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`tid` int(10) unsigned NOT NULL COMMENT '教师ID',
	`tname` varchar(10) DEFAULT '' COMMENT '发布老师名字',
	`title` varchar(50) DEFAULT '' COMMENT '文章名称',
	`content` text NOT NULL COMMENT '详细内容',
	`outurl` varchar(500) DEFAULT '' COMMENT '外部链接',
	`picarr` text COMMENT '用户信息',
	`createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
	`bj_id` int(10) unsigned NOT NULL COMMENT '班级ID',
	`km_id` int(10) unsigned NOT NULL COMMENT '科目ID',
	`type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否班级通知',
	`ismobile` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0手机端1电脑端',
	`groupid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1为全体师生2为全体教师3为全体家长和学生',
     PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_bjq' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `weid` int(10) unsigned NOT NULL,
	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`content` text NOT NULL COMMENT '详细内容或评价',
	`uid` int(10) unsigned NOT NULL COMMENT '发布者UID',
	`bj_id1` int(10) unsigned NOT NULL COMMENT '班级ID1',
    `bj_id2` int(10) unsigned NOT NULL COMMENT '班级ID2',
    `bj_id3` int(10) unsigned NOT NULL COMMENT '班级ID3',
	`sherid` int(10) unsigned NOT NULL COMMENT '所属图文id',	
	`shername` varchar(50) DEFAULT '' COMMENT '分享者名字',
	`openid` varchar(30) NOT NULL COMMENT '帖子所属openid',
	`isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',	
	`type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型0为班级圈1为评论',
	`msgtype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1文字图片2语音3视频',
	`createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
     PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_media' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `weid` int(10) unsigned NOT NULL,
	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`uid` int(10) unsigned NOT NULL COMMENT '发布者UID',
	`sid` int(10) unsigned NOT NULL COMMENT '学生SID',
	`picurl` varchar(255) DEFAULT '' COMMENT '图片',
	`fmpicurl` varchar(255) DEFAULT '' COMMENT '封面图片',
	`bj_id1` int(10) unsigned NOT NULL COMMENT '班级ID1',
    `bj_id2` int(10) unsigned NOT NULL COMMENT '班级ID2',
    `bj_id3` int(10) unsigned NOT NULL COMMENT '班级ID3',
	`order` int(10) unsigned NOT NULL COMMENT '排序',
	`sherid` int(10) unsigned NOT NULL COMMENT '所属图文id',	
	`createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
	`type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0班级圈1学生相册',
	`isfm` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1是0否',
     PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_dianzan' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `weid` int(10) unsigned NOT NULL,
	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`uid` int(10) unsigned NOT NULL COMMENT '发布者UID',
	`sherid` int(10) unsigned NOT NULL COMMENT '所属图文id',
	`zname` varchar(50) DEFAULT '' COMMENT '点赞人名字',
    `order` int(10) unsigned NOT NULL COMMENT '排序',	
	`createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
     PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_order' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `weid` int(10) unsigned NOT NULL,
	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`orderid` int(10) unsigned NOT NULL COMMENT '订单ID',
	`uid` int(10) unsigned NOT NULL COMMENT '发布者UID',
	`userid` int(10) unsigned NOT NULL COMMENT '发布者UID',
	`sid` int(10) unsigned NOT NULL COMMENT '学生id',
	`kcid` int(10) unsigned NOT NULL COMMENT '课程ID',
	`costid` int(10) unsigned NOT NULL COMMENT '项目ID',
	`lastorderid` int(10) unsigned NOT NULL COMMENT '继承订单,用于功能续费',
	`signid` int(10) unsigned NOT NULL COMMENT '报名ID',
	`bdcardid` int(10) unsigned NOT NULL COMMENT '帮卡ID',
	`obid` int(10) unsigned NOT NULL COMMENT '功能ID',
    `cose` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1未支付2为已支付3为已退款',
	`type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1课程2项目3功能',	
	`createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
	`paytime` int(10) unsigned NOT NULL COMMENT '支付时间',
	`paytype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1线上2现金',
	`pay_type` varchar(100) DEFAULT '' COMMENT '支付方式',
	`tuitime` int(10) unsigned NOT NULL COMMENT '退费时间',
	`xufeitype` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1已续费2未续费',
	`payweid` int(10) unsigned NOT NULL COMMENT '支付公众号',
     PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_wxpay' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `weid` int(10) unsigned NOT NULL,
	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`orderid` int(10) unsigned NOT NULL COMMENT '返回订单ID',
	`od1` int(10) unsigned NOT NULL COMMENT '1',
	`od2` int(10) unsigned NOT NULL COMMENT '2',
	`od3` int(10) unsigned NOT NULL COMMENT '3',
	`od4` int(10) unsigned NOT NULL COMMENT '4',
	`od5` int(10) unsigned NOT NULL COMMENT '5',
    `cose` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
	`payweid` int(10) unsigned NOT NULL COMMENT '支付公众号',
	`openid` varchar(30) NOT NULL COMMENT 'openid',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1未支付2为未支付3为已退款',
     PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;
	";
pdo_run($sql);

//use
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_qrcode_info' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `qrcid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二维码场景ID',
  `gpid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '场景名称',
  `keyword` varchar(100) NOT NULL COMMENT '关联关键字',
  `model` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '模式，1临时，2为永久',
  `ticket` varchar(250) NOT NULL DEFAULT '' COMMENT '标识',
  `show_url` varchar(550) NOT NULL DEFAULT '' COMMENT '图片地址',
  `expire` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `subnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注扫描次数',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '生成时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为未启用，1为启用',
  `group_id` int(3) unsigned NOT NULL DEFAULT '0',
  `rid` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_qrcid` (`qrcid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

//use
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_qrcode_statinfo' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `qid` int(10) unsigned NOT NULL,
  `openid` varchar(150) NOT NULL DEFAULT '' COMMENT '用户的唯一身份ID',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否发生在订阅时',
  `qrcid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二维码场景ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '场景名称',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '生成时间',
  `group_id` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

//use
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_qrcode_set' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bg` int(10) unsigned NOT NULL DEFAULT '0',
  `qrleft` int(10) unsigned NOT NULL DEFAULT '0',
  `qrtop` int(10) unsigned NOT NULL DEFAULT '0',
  `qrwidth` int(10) unsigned NOT NULL DEFAULT '0',
  `qrheight` int(10) unsigned NOT NULL DEFAULT '0',
  `model` int(10) unsigned NOT NULL DEFAULT '1',
  `logoheight` int(10) unsigned NOT NULL DEFAULT '0',
  `logowidth` int(10) unsigned NOT NULL DEFAULT '0',
  `logoqrheight` int(10) unsigned NOT NULL DEFAULT '0',
  `logoqrwidth` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

//use
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_fans_group' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `group_desc` varchar(50) NOT NULL DEFAULT '',
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  `type` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '二维码状态',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_news' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,  
  `cateid` int(10) unsigned NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `picarr` text COMMENT '图片组',
  `displayorder` tinyint(3) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_show_home` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `click` int(10) unsigned NOT NULL,
  `dianzan` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_cost' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,
  `cost` decimal(18,2) NOT NULL DEFAULT '0.00',
  `bj_id` text COMMENT '关联班级组',
  `name` varchar(100) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `description` text NOT NULL COMMENT '缴费说明',
  `about` int(10) unsigned NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `is_sys` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1关联缴费，2不关联',
  `is_time` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1有时间限制，2不限制',
  `is_on` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1启用，2不启用',
  `createtime` int(10) unsigned NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,  
  `dataline` int(10) unsigned NOT NULL,  
  `payweid` int(10) unsigned NOT NULL COMMENT '支付公众号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_object' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` int(10) unsigned NOT NULL,
  `type` varchar(50) NOT NULL, 
  `displayorder` varchar(50) NOT NULL, 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_signup' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,
  `icon` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `numberid` int(11) DEFAULT NULL,
  `sex` int(1) NOT NULL,
  `mobile` char(11) NOT NULL,  
  `nj_id` int(10) unsigned NOT NULL COMMENT '年级ID',  
  `bj_id` int(10) unsigned NOT NULL COMMENT '班级ID',
  `idcard` varchar(18) NOT NULL,
  `cost` varchar(10) NOT NULL,
  `birthday` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `passtime` int(10) unsigned NOT NULL,
  `lasttime` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL COMMENT '发布者UID',
  `orderid` int(10) unsigned NOT NULL COMMENT '',
  `openid` varchar(30) NOT NULL COMMENT 'openid',
  `pard` tinyint(1) unsigned NOT NULL COMMENT '关系',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1审核中2审核通过3不通过',
  `sid` int(10) unsigned NOT NULL,	
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_record' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,  
  `noticeid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `sid` int(10) unsigned NOT NULL,  
  `openid` varchar(30) NOT NULL COMMENT 'openid',
  `type` int(1) unsigned NOT NULL COMMENT '类型1通知2作业',
  `createtime` int(10) unsigned NOT NULL,
  `readtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_checkmac' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,
  `macname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `macid` varchar(200) NOT NULL,
  `banner` varchar(2000) DEFAULT '',  
  `is_on` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1启用2不启用', 
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1进校2离校', 
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_checklog' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL, 
  `macid` int(10) unsigned NOT NULL,  
  `cardid` varchar(200) NOT NULL,
  `sid` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL, 
  `bj_id` int(10) unsigned NOT NULL,
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lon` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',   
  `temperature` varchar(10) DEFAULT '',
  `pic` varchar(255) DEFAULT '' COMMENT '图片',
  `pic2` varchar(255) DEFAULT '' COMMENT '图片2',
  `type` varchar(50) DEFAULT '' COMMENT '进校类型',
  `leixing` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1进校2离校3迟到4早退',
  `pard` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '1本人2母亲3父亲4爷爷5奶奶6外公7外婆8叔叔9阿姨10其他11老师',
  `qdtid` int(11) NOT NULL COMMENT '代签userid',
  `checktype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1刷卡2微信',  
  `isconfirm` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1确认2拒绝',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_idcard' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL, 
  `sid` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `bj_id` int(10) unsigned NOT NULL, 
  `pname` varchar(200) NOT NULL,
  `idcard` varchar(200) NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `spic` varchar(1000) NOT NULL,
  `tpic` varchar(1000) NOT NULL,
  `pard` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1本人2母亲3父亲4爷爷5奶奶6外公7外婆8叔叔9阿姨10其他',
  `createtime` int(10) unsigned NOT NULL,
  `severend` int(10) unsigned NOT NULL,
  `is_on` int(1) NOT NULL DEFAULT '0' COMMENT '1:使用,2未用,默认0',
  `is_frist` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:首次,2非首次',
  `usertype` int(1) NOT NULL DEFAULT '0' COMMENT '1:老师,学生0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_icon' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号',
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分校id',  
  `name` varchar(50) NOT NULL COMMENT '按钮名称',
  `beizhu` varchar(50) NOT NULL COMMENT '备注或小字',
  `icon` varchar(1000) NOT NULL COMMENT '按钮图标',
  `url` varchar(1000) NOT NULL COMMENT '链接url',  
  `place` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1首页菜单2底部菜单',
  `ssort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '显示状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_courseTable' ) . "(
 `id` int(11) NOT NULL AUTO_INCREMENT,
`schoolid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分校id',
`weid` int(10) unsigned NOT NULL,
`title` varchar(50) NOT NULL,
`ishow` int(1) NOT NULL DEFAULT '1' COMMENT '1:显示,2隐藏,默认1',
`sort` int(11) NOT NULL DEFAULT '1',
`type` varchar(15) NOT NULL DEFAULT '',
`headpic` varchar(200) NOT NULL DEFAULT '',
`infos` varchar(500) NOT NULL,
`xq_id` int(11) NOT NULL COMMENT '学期id',
`bj_id` int(11) NOT NULL COMMENT '班级id',
PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_email' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL, 
  `sid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `bj_id` int(10) unsigned NOT NULL,
  `pard` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1本人2母亲3父亲4爷爷5奶奶6外公7外婆8叔叔9阿姨10其他',
  `suggesd` varchar(1000) DEFAULT '',
  `emailid` int(10) unsigned NOT NULL,
  `isread` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `is_how` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '',
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_zjh' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_on` tinyint(1) NOT NULL DEFAULT '1',
  `picrul` varchar(1000) NOT NULL,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,
  `planuid` varchar(37) NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `bj_id` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1图片2文字',
  `start` int(10) unsigned NOT NULL,
  `end` int(10) unsigned NOT NULL,
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_zjhset' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,
  `planuid` varchar(37) NOT NULL,
  `activetypeid` varchar(100) NOT NULL,
  `curactiveid` varchar(100) NOT NULL,
  `activetypename` varchar(30) DEFAULT '' COMMENT '名称',
  `type` varchar(2) DEFAULT '' COMMENT 'AM,PM',
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_zjhdetail' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,
  `planuid` varchar(37) NOT NULL,
  `curactivename` varchar(100) NOT NULL,
  `detailuid` varchar(37) NOT NULL,
  `curactiveid` varchar(100) NOT NULL,
  `activedesc` text COMMENT '内容',
  `week` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1-5',
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_shouceset' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL, 
  `title` varchar(7) DEFAULT '',
  `bottext` varchar(7) DEFAULT '',
  `boturl` varchar(1000) DEFAULT '',
  `lasttxet` varchar(7) DEFAULT '',
  `nj_id` int(10) unsigned NOT NULL,
  `icon` varchar(1000) DEFAULT '',
  `bg1` varchar(1000) DEFAULT '',
  `bg2` varchar(1000) DEFAULT '',
  `bg3` varchar(1000) DEFAULT '',
  `bg4` varchar(1000) DEFAULT '',
  `bg5` varchar(1000) DEFAULT '',
  `bg6` varchar(1000) DEFAULT '',
  `bgm` varchar(1000) DEFAULT '',
  `top1` varchar(1000) DEFAULT '',
  `top2` varchar(1000) DEFAULT '',
  `top3` varchar(1000) DEFAULT '',
  `top4` varchar(1000) DEFAULT '', 
  `top5` varchar(1000) DEFAULT '',
  `guidword1` varchar(20) DEFAULT '',
  `guidword2` varchar(20) DEFAULT '',
  `guidurl` varchar(1000) DEFAULT '',
  `createtime` int(10) unsigned NOT NULL,
  `allowshare` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1允许2禁止',
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_shouceseticon' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,
  `setid` int(10) unsigned NOT NULL COMMENT '设置ID',  
  `title` varchar(7) DEFAULT '',
  `icon1title` varchar(10) DEFAULT '',
  `icon2title` varchar(10) DEFAULT '',
  `icon3title` varchar(10) DEFAULT '',
  `icon4title` varchar(10) DEFAULT '',
  `icon5title` varchar(10) DEFAULT '',
  `icon1` varchar(1000) DEFAULT '',
  `icon2` varchar(1000) DEFAULT '',
  `icon3` varchar(1000) DEFAULT '',
  `icon4` varchar(1000) DEFAULT '',
  `icon5` varchar(1000) DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1教师使用2家长',
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_shouce' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL, 
  `bj_id` int(10) unsigned NOT NULL,
  `xq_id` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `title` varchar(1000) DEFAULT '',
  `setid` int(10) unsigned NOT NULL COMMENT '设置ID',
  `kcid` int(10) unsigned NOT NULL COMMENT '课程ID',
  `ksid` int(10) unsigned NOT NULL COMMENT '课时ID',
  `starttime` int(10) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `sendtype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1未发送2部分发送3全部发送',
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_scforxs' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL, 
  `scid` int(10) unsigned NOT NULL,
  `setid` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `sid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `iconsetid` int(10) unsigned NOT NULL COMMENT '评价id',
  `iconlevel` int(10) unsigned NOT NULL COMMENT '本评价等级',
  `tword` varchar(1000) DEFAULT '' COMMENT '老师评语',
  `jzword` varchar(1000) DEFAULT '' COMMENT '家长评语',
  `dianzan` varchar(1000) DEFAULT '' COMMENT '点赞数',
  `dianzopenid` varchar(500) DEFAULT '' COMMENT '点赞人openid',
  `fromto` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1来自老师2来自家长',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1文字2表现评价3点赞',
  `createtime` int(10) unsigned NOT NULL,
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_shoucepyk' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL, 
  `bj_id` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `title` text DEFAULT '' COMMENT '内容',
  `createtime` int(10) unsigned NOT NULL,
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_allcamera' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,
  `kcid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '画面名称',
  `conet` text DEFAULT '' COMMENT '说明',
  `videopic` varchar(1000) NOT NULL DEFAULT '' COMMENT '监控地址', 
  `videourl` varchar(1000) NOT NULL DEFAULT '' COMMENT '监控地址',  
  `starttime` varchar(50) NOT NULL,
  `endtime` varchar(50) NOT NULL, 
  `createtime` int(10) unsigned NOT NULL,
  `allowpy` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1允许2拒绝',
  `videotype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1公共2指定班级',
  `bj_id` text COMMENT '关联班级组',  
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1监控2课程直播',
  `click` int(10) unsigned NOT NULL COMMENT '查看量',
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_camerapl' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL, 
  `carmeraid` int(10) unsigned NOT NULL COMMENT '画面ID',
  `userid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `bj_id` int(10) unsigned NOT NULL COMMENT '班级ID',
  `conet` text DEFAULT '' COMMENT '内容',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1点赞2评论',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_timetable' ) . "(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分校id',  
  `weid` int(10) unsigned NOT NULL,
  `bj_id` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `begintime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `monday` text NOT NULL,
  `tuesday` text NOT NULL,
  `wednesday` text NOT NULL,
  `thursday` text NOT NULL,
  `friday` text NOT NULL,
  `saturday` text NOT NULL,
  `sunday` text NOT NULL,
  `ishow` int(1) NOT NULL DEFAULT '1' COMMENT '1:显示,2隐藏,默认1',
  `sort` int(11) NOT NULL DEFAULT '1',
  `type` varchar(15) NOT NULL DEFAULT '',
  `headpic` varchar(200) NOT NULL DEFAULT '',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'coupon' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `type` varchar(15) NOT NULL,
  `logo_url` varchar(150) NOT NULL,
  `code_type` tinyint(3) unsigned NOT NULL,
  `brand_name` varchar(15) NOT NULL,
  `title` varchar(15) NOT NULL,
  `sub_title` varchar(20) NOT NULL,
  `color` varchar(15) NOT NULL,
  `notice` varchar(15) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date_info` varchar(200) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `location_id_list` varchar(1000) NOT NULL,
  `use_custom_code` tinyint(3) NOT NULL,
  `bind_openid` tinyint(3) unsigned NOT NULL,
  `can_share` tinyint(3) unsigned NOT NULL,
  `can_give_friend` tinyint(3) unsigned NOT NULL,
  `get_limit` tinyint(3) unsigned NOT NULL,
  `service_phone` varchar(20) NOT NULL,
  `extra` varchar(1000) NOT NULL,
  `source` varchar(20) NOT NULL,
  `url_name_type` varchar(20) NOT NULL,
  `custom_url` varchar(100) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_selfconsume` tinyint(3) unsigned NOT NULL,
  `promotion_url_name` varchar(10) NOT NULL,
  `promotion_url` varchar(100) NOT NULL,
  `promotion_url_sub_title` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
";
pdo_run($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_user_class' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `sid` int(10) unsigned NOT NULL,
  `bj_id` int(10) unsigned NOT NULL,
  `km_id` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1老师2学生',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
pdo_run($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_online' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,  
  `macid` int(10) unsigned NOT NULL,
  `commond` int(10) unsigned NOT NULL,
  `result` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `isread` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `createtime` int(10) unsigned NOT NULL COMMENT '生成时间',
  `dotime` int(10) unsigned NOT NULL COMMENT '执行时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
pdo_run($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_sms_log' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,  
  `type` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `sendtime` int(10) unsigned NOT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
pdo_run($sql);

// 新增  一个学生绑定三个微信号 默认不绑定
if(!pdo_fieldexists('users', 'tid')) {
	pdo_query("ALTER TABLE ".tablename('users')." ADD `tid` int(10) NOT NULL DEFAULT '0' COMMENT '';");
}

if(!pdo_fieldexists('users', 'schoolid')) {
	pdo_query("ALTER TABLE ".tablename('users')." ADD `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '';");
}

if(!pdo_fieldexists('users', 'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('users')." ADD `uniacid` int(10) NOT NULL DEFAULT '0' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_bjq', 'msgtype')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_bjq')." ADD `msgtype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1文字图片2语音3视频';");
}

if(!pdo_fieldexists('wx_school_bjq', 'userid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_bjq')." ADD `userid` int(10) NOT NULL COMMENT '发布者用户ID';");
}

if(!pdo_fieldexists('wx_school_bjq', 'video')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_bjq')." ADD `video` varchar(1000) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_bjq', 'videoimg')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_bjq')." ADD `videoimg` varchar(1000) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_bjq', 'plid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_bjq')." ADD `plid` int(10) NOT NULL DEFAULT '0' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_bjq', 'is_private')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_bjq')." ADD `is_private` varchar(3) NOT NULL DEFAULT 'N' COMMENT '禁止评论';");
}

if(!pdo_fieldexists('wx_school_bjq', 'audio')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_bjq')." ADD `audio` varchar(1000) DEFAULT '' COMMENT '音频地址';");
}

if(!pdo_fieldexists('wx_school_bjq', 'audiotime')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_bjq')." ADD `audiotime` int(10) NOT NULL DEFAULT '0' COMMENT '音频时间';");
}

if(!pdo_fieldexists('wx_school_bjq', 'link')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_bjq')." ADD `link` varchar(1000) DEFAULT '' COMMENT '外链地址';");
}

if(!pdo_fieldexists('wx_school_bjq', 'linkdesc')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_bjq')." ADD `linkdesc` varchar(200) DEFAULT '' COMMENT '外链标题';");
}

if(!pdo_fieldexists('wx_school_bjq', 'hftoname')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_bjq')." ADD `hftoname` varchar(100) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_record', 'type')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_record')." ADD `type` int(1) unsigned NOT NULL COMMENT '类型1通知2作业';");
}

if(!pdo_fieldexists('wx_school_checkmac', 'is_on')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checkmac')." ADD `is_on` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1启用2不启用';");
}

if(!pdo_fieldexists('wx_school_checkmac', 'type')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checkmac')." ADD `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1进校2离校';");
}

if(!pdo_fieldexists('wx_school_checkmac', 'macset')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checkmac')." ADD `macset` VARCHAR(2000) DEFAULT '' AFTER `banner`;");
}

if(!pdo_fieldexists('wx_school_idcard', 'is_on')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_idcard')." ADD `is_on` int(1) NOT NULL DEFAULT '0' COMMENT '1:使用,2未用,默认0';");
}

if(!pdo_fieldexists('wx_school_idcard', 'is_frist')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_idcard')." ADD `is_frist` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:首次,2非首次';");
}

if(!pdo_fieldexists('wx_school_idcard', 'usertype')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_idcard')." ADD `usertype` int(1) NOT NULL DEFAULT '0' COMMENT '1:老师,学生0';");
}

if(!pdo_fieldexists('wx_school_idcard', 'spic')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_idcard')." ADD `spic` varchar(1000) NOT NULL;");
}

if(!pdo_fieldexists('wx_school_idcard', 'tpic')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_idcard')." ADD `tpic` varchar(1000) NOT NULL;");
}

if(!pdo_fieldexists('wx_school_idcard', 'pname')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_idcard')." ADD `pname` varchar(200) NOT NULL;");
}

if(!pdo_fieldexists('wx_school_checkmac', 'banner')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checkmac')." ADD `banner` varchar(2000) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_leave', 'teacherid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_leave')." ADD `teacherid` int(11) DEFAULT NULL;");
}

if(!pdo_fieldexists('wx_school_leave', 'userid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_leave')." ADD `userid` int(11) DEFAULT NULL;");
}

if(!pdo_fieldexists('wx_school_leave', 'touserid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_leave')." ADD `touserid` int(11) DEFAULT NULL;");
}

if(!pdo_fieldexists('wx_school_leave', 'startime1')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_leave')." ADD `startime1` int(10) DEFAULT NULL;");
}

if(!pdo_fieldexists('wx_school_leave', 'endtime1')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_leave')." ADD `endtime1` int(10) DEFAULT NULL;");
}

if(!pdo_fieldexists('wx_school_leave', 'cltid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_leave')." ADD `cltid` int(10) unsigned NOT NULL COMMENT '老师id';");
}

if(!pdo_fieldexists('wx_school_signup', 'pard')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_signup')." ADD `pard` tinyint(1) unsigned NOT NULL COMMENT '关系';");
}

if(!pdo_fieldexists('wx_school_signup', 'sid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_signup')." ADD `sid` int(11) unsigned NOT NULL COMMENT '';");
}

if(!pdo_fieldexists('wx_school_leave', 'isfrist')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_leave')." ADD `isfrist` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1是0否';");
}

if(!pdo_fieldexists('wx_school_leave', 'isread')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_leave')." ADD `isread` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1是2否';");
}

if(!pdo_fieldexists('wx_school_leave', 'reconet')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_leave')." ADD `reconet` varchar(200) DEFAULT '' COMMENT '教师回复';");
}

if(!pdo_fieldexists('wx_school_kcbiao', 'isxiangqing')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_kcbiao')." ADD `isxiangqing` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0显示1否';");
}

if(!pdo_fieldexists('wx_school_tcourse', 'is_show')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_tcourse')." ADD `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1显示,2否';");
}

if(!pdo_fieldexists('wx_school_tcourse', 'ssort')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_tcourse')." ADD `ssort` tinyint(5) NOT NULL DEFAULT '0';");
}

if(!pdo_fieldexists('wx_school_media', 'sid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_media')." ADD `sid` int(10) unsigned NOT NULL COMMENT '学生SID';");
}

if(!pdo_fieldexists('wx_school_media', 'fmpicurl')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_media')." ADD `fmpicurl` varchar(255) DEFAULT '' COMMENT '封面图片';");
}

if(!pdo_fieldexists('wx_school_media', 'type')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_media')." ADD `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0班级圈1相册';");
}

if(!pdo_fieldexists('wx_school_media', 'isfm')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_media')." ADD `isfm` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0否1是';");
}

if(!pdo_fieldexists('wx_school_order', 'pay_type')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_order')." ADD `pay_type` varchar(100) DEFAULT '' COMMENT '支付方式';");
}

if(!pdo_fieldexists('wx_school_order', 'xufeitype')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_order')." ADD `xufeitype` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1已续费2未续费';");
}

if(!pdo_fieldexists('wx_school_order', 'lastorderid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_order')." ADD `lastorderid` int(10) unsigned NOT NULL COMMENT '继承订单,用于续费';");
}

if(!pdo_fieldexists('wx_school_order', 'paytime')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_order')." ADD `paytime` int(10) unsigned NOT NULL COMMENT '支付时间';");
}

if(!pdo_fieldexists('wx_school_order', 'paytype')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_order')." ADD `paytype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1线上2现金';");
}

if(!pdo_fieldexists('wx_school_order', 'tuitime')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_order')." ADD `tuitime` int(10) unsigned NOT NULL COMMENT '退款时间';");
}

if(!pdo_fieldexists('wx_school_order', 'costid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_order')." ADD `costid` int(10) unsigned NOT NULL COMMENT '项目ID';");
}

if(!pdo_fieldexists('wx_school_order', 'signid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_order')." ADD `signid` int(10) unsigned NOT NULL COMMENT '报名ID';");
}

if(!pdo_fieldexists('wx_school_order', 'bdcardid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_order')." ADD `bdcardid` int(10) unsigned NOT NULL COMMENT '帮卡ID';");
}

if(!pdo_fieldexists('wx_school_banners', 'begintime')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_banners')." ADD `begintime` int(11) NOT NULL;");
}

if(!pdo_fieldexists('wx_school_banners', 'endtime')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_banners')." ADD `endtime` int(11) NOT NULL;");
}

if(!pdo_fieldexists('wx_school_banners', 'leixing')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_banners')." ADD `leixing` int(1) NOT NULL DEFAULT '0' COMMENT '0学校,1平台';");
}

if(!pdo_fieldexists('wx_school_banners', 'arr')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_banners')." ADD `arr` text COMMENT '列表信息';");
}

if(!pdo_fieldexists('wx_school_kcbiao', 'content')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_kcbiao')." ADD `content` text NOT NULL COMMENT '课程内容';");
}

if(!pdo_fieldexists('wx_school_index', 'sms_set')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `sms_set` varchar(1000) NOT NULL DEFAULT '' COMMENT '短信设置';");
}

if(!pdo_fieldexists('wx_school_index', 'is_kb')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_kb` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1启用2不启公立课表';");
}

if(!pdo_fieldexists('wx_school_index', 'send_overtime')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `send_overtime` INT(10) NOT NULL DEFAULT '-1' COMMENT '延迟发送';");
}

if(!pdo_fieldexists('wx_school_index', 'sms_use_times')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `sms_use_times` INT(10) NOT NULL COMMENT '短信调用次数';");
}

if(!pdo_fieldexists('wx_school_index', 'sms_rest_times')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `sms_rest_times` INT(10) NOT NULL COMMENT '可用短信条数';");
}

if(!pdo_fieldexists('wx_school_index', 'is_fbvocie')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_fbvocie` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启语音';");
}

if(!pdo_fieldexists('wx_school_index', 'is_fbnew')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_fbnew` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用语音和视频';");
}

if(!pdo_fieldexists('wx_school_index', 'txid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `txid` varchar(100) NOT NULL DEFAULT '' COMMENT '腾讯云APPID';");
}

if(!pdo_fieldexists('wx_school_index', 'txms')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `txms` varchar(100) NOT NULL DEFAULT '0' COMMENT '腾讯云密钥';");
}

if(!pdo_fieldexists('wx_school_index', 'is_openht')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_openht` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1启用2不启用独立后台';");
}

if(!pdo_fieldexists('wx_school_index', 'userstyle')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `userstyle` varchar(50) NOT NULL DEFAULT 'user' COMMENT '家长学生中心模板';");
}

if(!pdo_fieldexists('wx_school_index', 'bjqstyle')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `bjqstyle` varchar(50) NOT NULL DEFAULT 'old' COMMENT '班级圈模板';");
}

if(!pdo_fieldexists('wx_school_index', 'is_showew')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_showew` tinyint(1) NOT NULL DEFAULT '1' COMMENT '2显示1否';");
}

if(!pdo_fieldexists('wx_school_index', 'wqgroupid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `wqgroupid` int(10) NOT NULL DEFAULT '0' COMMENT '微擎默认用户组';");
}

if(!pdo_fieldexists('wx_school_index', 'cityid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `cityid` int(10) NOT NULL DEFAULT '0' COMMENT '城市ID';");
}

if(!pdo_fieldexists('wx_school_area', 'type')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_area')." ADD `type` char(20) NOT NULL;");
}

if(!pdo_fieldexists('wx_school_score', 'createtime')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_score')." ADD `createtime` int(10) unsigned NOT NULL;");
}

if(!pdo_fieldexists('wx_school_index', 'shoucename')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `shoucename` varchar(200) NOT NULL DEFAULT '' COMMENT '手册名称';");
}

if(!pdo_fieldexists('wx_school_index', 'videoname')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `videoname` varchar(200) NOT NULL DEFAULT '' COMMENT '监控名称';");
}

if(!pdo_fieldexists('wx_school_index', 'videopic')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `videopic` varchar(1000) NOT NULL DEFAULT '' COMMENT '监控封面';");
}

if(!pdo_fieldexists('wx_school_index', 'is_zjh')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_zjh` tinyint(1) NOT NULL DEFAULT '1' COMMENT '2显示1否';");
}

if(!pdo_fieldexists('wx_school_index', 'is_showad')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_showad` int(10) NOT NULL DEFAULT '0' COMMENT '广告ID';");
}

if(!pdo_fieldexists('wx_school_index', 'is_comload')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_comload` int(10) NOT NULL DEFAULT '0' COMMENT '广告ID';");
}

if(!pdo_fieldexists('wx_school_index', 'isopen')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0显示1否';");
}

if(!pdo_fieldexists('wx_school_index', 'is_sign')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_sign` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1启用2不启用';");
}

if(!pdo_fieldexists('wx_school_index', 'manger')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `manger` varchar(200) NOT NULL DEFAULT '' COMMENT '信息审核员';");
}

if(!pdo_fieldexists('wx_school_index', 'signset')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `signset` varchar(200) NOT NULL COMMENT '报名设置';");
}

if(!pdo_fieldexists('wx_school_index', 'is_cost')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_cost` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用';");
}

if(!pdo_fieldexists('wx_school_index', 'is_video')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_video` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用';");
}

if(!pdo_fieldexists('wx_school_index', 'is_recordmac')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_recordmac` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用';");
}

if(!pdo_fieldexists('wx_school_index', 'zhaosheng')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `zhaosheng` text NOT NULL COMMENT '招生简章';");
}

if(!pdo_fieldexists('wx_school_index', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `uid` int(10) NOT NULL DEFAULT '0' COMMENT '账户ID';");
}

if(!pdo_fieldexists('wx_school_index', 'style2')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `style2` varchar(200) NOT NULL DEFAULT '' COMMENT '模版名称2';");
}

if(!pdo_fieldexists('wx_school_index', 'style3')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `style3` varchar(200) NOT NULL DEFAULT '' COMMENT '模版名称3';");
}

if(!pdo_fieldexists('wx_school_index', 'spic')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `spic` varchar(200) NOT NULL DEFAULT '' COMMENT '默认学生头像';");
}

if(!pdo_fieldexists('wx_school_index', 'tpic')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `tpic` varchar(200) NOT NULL DEFAULT '' COMMENT '默认教师头像';");
}

if(!pdo_fieldexists('wx_school_index', 'is_wxsign')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_wxsign` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1启用2不启用微信签到';");
}

if(!pdo_fieldexists('wx_school_index', 'is_signneedcomfim')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_signneedcomfim` tinyint(1) NOT NULL DEFAULT '1' COMMENT '手机签到是否需确认1是2否';");
}

if(!pdo_fieldexists('wx_school_index', 'bd_type')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `bd_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1名手2名码3名学4名手码5名手学6名学码7名手学码7名手学码';");
}

if(!pdo_fieldexists('wx_school_set', 'guanli')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `guanli` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理方式';");
}

if(!pdo_fieldexists('wx_school_set', 'jxlxtx')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `jxlxtx` varchar(200) DEFAULT '' COMMENT '进校提醒';");
}

if(!pdo_fieldexists('wx_school_set', 'jfjgtz')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `jfjgtz` varchar(200) DEFAULT '' COMMENT '缴费结果通知';");
}

if(!pdo_fieldexists('wx_school_set', 'bd_set')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `bd_set` varchar(1000) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_set', 'sms_acss')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `sms_acss` varchar(1000) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_set', 'sms_use_times')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `sms_use_times` int(10) NOT NULL COMMENT '短信调用次数';");
}

if(!pdo_fieldexists('wx_school_tcourse', 'yibao')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_tcourse')." ADD `yibao` int(11) NOT NULL COMMENT '已报人数';");
}

if(!pdo_fieldexists('wx_school_tcourse', 'cose')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_tcourse')." ADD `cose` varchar(11) NOT NULL COMMENT '价格';");
}

if(!pdo_fieldexists('wx_school_index', 'qroce')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `qroce` varchar(200) NOT NULL DEFAULT '' COMMENT '二维码';");
}

if(!pdo_fieldexists('wx_school_index', 'issale')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `issale` tinyint(1) NOT NULL DEFAULT '5' COMMENT '5种状态';");
}

if(!pdo_fieldexists('wx_school_index', 'jxstart')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `jxstart` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'jxend')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `jxend` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'lxstart')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `lxstart` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'lxend')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `lxend` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'jxstart1')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `jxstart1` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'jxend1')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `jxend1` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'lxstart1')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `lxstart1` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'lxend1')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `lxend1` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'jxstart2')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `jxstart2` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'jxend2')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `jxend2` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'lxstart2')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `lxstart2` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'lxend2')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `lxend2` varchar(50) DEFAULT '';");
}

if(!pdo_fieldexists('wx_school_index', 'is_cardpay')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_cardpay` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用';");
}

if(!pdo_fieldexists('wx_school_index', 'is_cardlist')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `is_cardlist` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用';");
}

if(!pdo_fieldexists('wx_school_index', 'cardset')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD `cardset` varchar(500) NOT NULL COMMENT '刷卡设置';");
}

if(!pdo_fieldexists('wx_school_set', 'bjqshjg')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `bjqshjg` varchar(200) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_set', 'bjqshtz')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `bjqshtz` varchar(200) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_score', 'info')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_score')." ADD `info` varchar(1000) NOT NULL DEFAULT '' COMMENT '教师评价';");
}

if(!pdo_fieldexists('wx_school_set', 'zuoye')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `zuoye` varchar(200) DEFAULT '' COMMENT '发布作业提醒ID';");
}

if(!pdo_fieldexists('wx_school_students', 'xjid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `xjid` int(11) unsigned NOT NULL COMMENT '学籍信息';");
}

if(!pdo_fieldexists('wx_school_students', 'ouserid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `ouserid` int(11) unsigned NOT NULL COMMENT '';");
}

if(!pdo_fieldexists('wx_school_students', 'muserid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `muserid` int(11) unsigned NOT NULL COMMENT '';");
}

if(!pdo_fieldexists('wx_school_students', 'duserid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `duserid` int(11) unsigned NOT NULL COMMENT '';");
}

if(!pdo_fieldexists('wx_school_students', 'otheruserid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `otheruserid` int(11) unsigned NOT NULL COMMENT '';");
}

if(!pdo_fieldexists('wx_school_students', 'icon')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `icon` varchar(255) DEFAULT '' COMMENT '头像';");
}

if(!pdo_fieldexists('wx_school_students', 'numberid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `numberid` varchar(18) COMMENT '学号';");
}

if(!pdo_fieldexists('wx_school_students', 'code')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `code` varchar(18) COMMENT '绑定码';");
}

if(!pdo_fieldexists('wx_school_notice', 'video')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD `video` varchar(100) DEFAULT '' COMMENT '视频画面';");
}

if(!pdo_fieldexists('wx_school_notice', 'videopic')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD `videopic` varchar(100) DEFAULT '' COMMENT '视频封面';");
}

if(!pdo_fieldexists('wx_school_notice', 'audio')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD `audio` varchar(100) DEFAULT '' COMMENT '音频';");
}

if(!pdo_fieldexists('wx_school_notice', 'audiotime')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD `audiotime` int(10) unsigned NOT NULL COMMENT '音频时长';");
}

if(!pdo_fieldexists('wx_school_notice', 'km_id')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD `km_id` int(10) unsigned NOT NULL COMMENT '科目ID';");
}

if(!pdo_fieldexists('wx_school_notice', 'groupid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD `groupid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1为全体师生2为全体教师3为全体家长和学生';");
}

if(!pdo_fieldexists('wx_school_notice', 'ismobile')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD `ismobile` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0手机1电脑';");
}

if(!pdo_fieldexists('wx_school_notice', 'outurl')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD `outurl` varchar(500) DEFAULT '' COMMENT '外部链接';");
}

$arr = explode('.',$_SERVER ['HTTP_HOST']);

if(!pdo_fieldexists('wx_school_students', 'mom')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `mom` varchar(30) NOT NULL DEFAULT '0' COMMENT '母亲微信';");
}

if(!pdo_fieldexists('wx_school_students', 'dad')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `dad` varchar(30) NOT NULL DEFAULT '0' COMMENT '父亲微信';");
}

if(!pdo_fieldexists('wx_school_students', 'own')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `own` varchar(30) NOT NULL DEFAULT '0' COMMENT '自己微信';");
}

if(!pdo_fieldexists('wx_school_students', 'other')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `other` varchar(30) DEFAULT '0' COMMENT '家长';");
}

if(!pdo_fieldexists('wx_school_students', 'ouid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `ouid` int(10) unsigned NOT NULL COMMENT '微擎系统memberID';");
}

if(!pdo_fieldexists('wx_school_students', 'muid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `muid` int(10) unsigned NOT NULL COMMENT '微擎系统memberID';");
}

if(!pdo_fieldexists('wx_school_students', 'duid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `duid` int(10) unsigned NOT NULL COMMENT '微擎系统memberID';");
}

if(!pdo_fieldexists('wx_school_students', 'otheruid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `otheruid` int(10) unsigned NOT NULL COMMENT '微擎系统memberID';");
}

if(!pdo_fieldexists('wx_school_classify', 'erwei')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `erwei` varchar(200) NOT NULL DEFAULT '' COMMENT '群二维码';");
}

if(!pdo_fieldexists('wx_school_classify', 'icon')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `icon` varchar(500) DEFAULT '' COMMENT '图标';");
}

if(!pdo_fieldexists('wx_school_classify', 'pname')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `pname` varchar(50) NOT NULL DEFAULT '' COMMENT '称谓';");
}

if(!pdo_fieldexists('wx_school_classify', 'qun')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `qun` varchar(200) NOT NULL DEFAULT '' COMMENT 'Q群链接';");
}

if(!pdo_fieldexists('wx_school_classify', 'video')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `video` varchar(200) NOT NULL DEFAULT '' COMMENT '教室监控地址';");
}

if(!pdo_fieldexists('wx_school_classify', 'video1')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `video1` varchar(200) NOT NULL DEFAULT '' COMMENT '教室监控地址1';");
}

if(!pdo_fieldexists('wx_school_classify', 'videostart')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `videostart` varchar(50) NOT NULL DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_classify', 'videoend')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `videoend` varchar(50) NOT NULL DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_classify', 'cost')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `cost` varchar(50) NOT NULL DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_classify', 'carmeraid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `carmeraid` text DEFAULT '' COMMENT '说明';");
}

if(!pdo_fieldexists('wx_school_wxpay', 'openid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_wxpay')." ADD `openid` varchar(30) NOT NULL DEFAULT '' COMMENT 'openid';");
}

if(!pdo_fieldexists('wx_school_wxpay', $arr['1'])) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_wxpay')." ADD `{$arr['1']}` varchar(30) NOT NULL DEFAULT '0' COMMENT '订单ID' AFTER id;");
}

if(!pdo_fieldexists('wx_school_classify', 'tid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `tid` int(11) unsigned NOT NULL COMMENT '班级主任userid';");
}

if(!pdo_fieldexists('wx_school_classify', 'videoclick')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `videoclick` int(11) unsigned NOT NULL COMMENT '视频点击量';");
}

if(!pdo_fieldexists('wx_school_classify', 'allowpy')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `allowpy` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1允许2拒绝';");
}

if(!pdo_fieldexists('wx_school_icon', 'beizhu')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_icon')." ADD `beizhu` varchar(50) NOT NULL COMMENT '备注或小字';");
}

if(!pdo_fieldexists('wx_school_icon', 'color')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_icon')." ADD `color` varchar(50) NOT NULL COMMENT '颜色';");
}

if(!pdo_fieldexists('wx_school_icon', 'icon2')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_icon')." ADD `icon2` varchar(1000) NOT NULL AFTER `icon`;");
}

if(!pdo_fieldexists('wx_school_icon', 'do')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_icon')." ADD `do` varchar(100) NOT NULL AFTER `url`;");
}

if(!pdo_fieldexists('wx_school_teachers', 'code')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `code` int(11) unsigned NOT NULL COMMENT '绑定码';");
}

if(!pdo_fieldexists('wx_school_teachers', 'com')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `com` int(11) unsigned NOT NULL COMMENT '';");
}

if(!pdo_fieldexists('wx_school_teachers', 'is_show')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示';");
}

if(!pdo_fieldexists('wx_school_teachers', 'openid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `openid` varchar(30) NOT NULL DEFAULT '0' COMMENT '老师微信';");
}

if(!pdo_fieldexists('wx_school_teachers', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `uid` int(10) unsigned NOT NULL COMMENT '微擎系统memberID';");
}

if(!pdo_fieldexists('wx_school_teachers', 'km_id3')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `km_id3` int(11) NOT NULL COMMENT '授课科目3';");
}

if(!pdo_fieldexists('wx_school_teachers', 'fz_id')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `fz_id` int(11) NOT NULL COMMENT '分组ID';");
}

if(!pdo_fieldexists('wx_school_teachers', 'userid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `userid` int(11) NOT NULL COMMENT '用户ID';");
}

if(!pdo_fieldexists('wx_school_checklog', 'lat')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checklog')." ADD `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度';");
}

if(!pdo_fieldexists('wx_school_checklog', 'lon')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checklog')." ADD `lon` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度';");
}

if(!pdo_fieldexists('wx_school_checklog', 'isread')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checklog')." ADD `isread` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1已读2未读';");
}

if(!pdo_fieldexists('wx_school_checklog', 'checktype')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checklog')." ADD `checktype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1刷卡2微信';");
}

if(!pdo_fieldexists('wx_school_checklog', 'isconfirm')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checklog')." ADD `isconfirm` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1确认2拒绝';");
}

if(!pdo_fieldexists('wx_school_checklog', 'qdtid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checklog')." ADD `qdtid` int(11) NOT NULL COMMENT '代签userid';");
}

if(!pdo_fieldexists('wx_school_checklog', 'pic2')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checklog')." ADD `pic2` varchar(255) DEFAULT '' COMMENT '图片2';");
}

if(!pdo_fieldexists('wx_school_cost', 'payweid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_cost')." ADD `payweid` int(10) unsigned NOT NULL COMMENT '支付公众号';");
}

if(!pdo_fieldexists('wx_school_tcourse', 'payweid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_tcourse')." ADD `payweid` int(10) unsigned NOT NULL COMMENT '支付公众号';");
}

if(!pdo_fieldexists('wx_school_order', 'payweid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_order')." ADD `payweid` int(10) unsigned NOT NULL COMMENT '支付公众号';");
}

if(!pdo_fieldexists('wx_school_wxpay', 'payweid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_wxpay')." ADD `payweid` int(10) unsigned NOT NULL COMMENT '支付公众号';");
}

if(!pdo_fieldexists('wx_school_user', 'is_allowmsg')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_user')." ADD `is_allowmsg` tinyint(1) NOT NULL DEFAULT '1' COMMENT '私聊信息接收语法';");
}

if(!pdo_fieldexists('wx_school_fans_group', 'is_zhu')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_fans_group')." ADD `is_zhu` tinyint(1) NOT NULL DEFAULT '2' COMMENT '是否本校主二维码';");
}

if(!pdo_fieldexists('wx_school_set', 'htname')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `htname` varchar(200) DEFAULT '' COMMENT '后台系统名称';");
}

if(!pdo_fieldexists('wx_school_set', 'bgcolor')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `bgcolor` varchar(20) DEFAULT '' COMMENT '后台系统背景颜色';");
}

if(!pdo_fieldexists('wx_school_set', 'bgimg')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `bgimg` varchar(200) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_set', 'banner1')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `banner1` varchar(200) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_set', 'banner2')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `banner2` varchar(200) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_set', 'banner3')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `banner3` varchar(200) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('wx_school_set', 'banner4')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD `banner4` varchar(200) DEFAULT '' COMMENT '';");
}

if(!pdo_fieldexists('ims_wx_school_banners', 'click')) {
	pdo_query("ALTER TABLE ".tablename('ims_wx_school_banners')." ADD `click` varchar(1000) DEFAULT '' COMMENT '点击量';");
}

if(pdo_fieldexists('wx_school_students', 'wecha_id')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_students')." CHANGE `wecha_id` `own` varchar(30) NOT NULL DEFAULT '0' COMMENT '自己微信';");
}

if(pdo_fieldexists('wx_school_students', 'numberid')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_students')." CHANGE `numberid` `numberid` varchar(18) COMMENT '学号';");
}

if(pdo_fieldexists('wx_school_user', 'status')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_user')." CHANGE `status` `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户状态';");
}

if(pdo_fieldexists('wx_school_news', 'id')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_news')." CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}

if(pdo_fieldexists('wx_school_news', 'displayorder')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_news')." CHANGE `displayorder` `displayorder` int(10) unsigned NOT NULL COMMENT '排序';");
}

if(pdo_fieldexists('wx_school_checkmac', 'macid')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_checkmac')." CHANGE `macid` `macid` varchar(200)  NOT NULL DEFAULT '' COMMENT '设备编号';");
}

if(!pdo_fieldexists('wx_school_checkmac', 'twmac')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_checkmac')." ADD `twmac` VARCHAR(200) NOT NULL DEFAULT '-1';");
}

if(pdo_fieldexists('wx_school_checklog', 'cardid')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_checklog')." CHANGE `cardid` `cardid` varchar(200)  NOT NULL DEFAULT '' COMMENT '卡号';");
}

if(pdo_fieldexists('wx_school_checklog', 'pard')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_checklog')." CHANGE `pard` `pard` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '1本人2母亲3父亲4爷爷5奶奶6外公7外婆8叔叔9阿姨10其他11老师';");
}

if(pdo_fieldexists('wx_school_idcard', 'idcard')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_idcard')." CHANGE `idcard` `idcard` varchar(200)  NOT NULL DEFAULT '' COMMENT '卡号';");
}

if(pdo_fieldexists('wx_school_user', 'sid')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_user')." CHANGE `sid` `sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID';");
}

if(pdo_fieldexists('wx_school_user', 'tid')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_user')." CHANGE `tid` `tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '老师ID';");
}

if(pdo_fieldexists('wx_school_index', 'issale')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_index')." CHANGE `issale` `issale` tinyint(1) NOT NULL DEFAULT '5' COMMENT '5种状态';");
}

if(pdo_fieldexists('wx_school_index', 'style1')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_index')." CHANGE `style1` `style1` varchar(200) NOT NULL DEFAULT '' COMMENT '模版名称';");
}

if(pdo_fieldexists('wx_school_classify', 'video')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_classify')." CHANGE `video` `video` varchar(1000) NOT NULL DEFAULT '' COMMENT '教室监控地址';");
}

if(pdo_fieldexists('wx_school_classify', 'video1')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_classify')." CHANGE `video1` `video1` varchar(1000) NOT NULL DEFAULT '' COMMENT '教室监控地址1';");
}

if(pdo_fieldexists('wx_school_cost', 'cost')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_cost')." CHANGE `cost` `cost` decimal(18,2) NOT NULL DEFAULT '0.00';");
}

if(pdo_fieldexists('wx_school_order', 'cose')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_order')." CHANGE `cose` `cose` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '价格';");
}

if(pdo_fieldexists('wx_school_wxpay', 'cose')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_wxpay')." CHANGE `cose` `cose` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '价格';");
}

if(pdo_fieldexists('wx_school_tcourse', 'cose')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_tcourse')." CHANGE `cose` `cose` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '价格';");
}

if(pdo_fieldexists('wx_school_idcard', 'usertype')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_idcard')." CHANGE `usertype` `usertype` int(1) NOT NULL DEFAULT '0' COMMENT '1:老师,学生0';");
}

pdo_query("DROP TABLE IF EXISTS ".tablename('wx_school_bbsreply').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('wx_school_cat').";");

$auth2 = IA_ROOT . "/addons/fm_jiaoyu/inc/func/auth2.php";
if (is_file($auth2)) {
	@unlink($auth2);
}
file_put_contents($auth2, "<?php if(!defined('IN_IA')) {exit('Access Denied');}if(!defined('FM_JIAOYU_HOST')) {define('FM_JIAOYU_HOST', '" . $_SERVER ['HTTP_HOST'] . "');}");

// pdo_insert
$count = pdo_fetchcolumn ( 'SELECT COUNT(1) FROM ' . tablename ( 'wx_school_qrcode_set' ) );
if (empty($count)) {
	$data = array (
		'logowidth' => 65,
		'logoheight' => 65,
		'logoqrwidth' => 250,  
		'logoqrheight' => 250		
	);
	pdo_insert ( 'wx_school_qrcode_set', $data );	
}

$base1 = pdo_fetch("SELECT * FROM ".tablename('wx_school_object')." WHERE :type = type And :item = item ", array(':type' => 'base', ':item' => 1));
$base2 = pdo_fetch("SELECT * FROM ".tablename('wx_school_object')." WHERE :type = type And :item = item ", array(':type' => 'hight', ':item' => 2));
$base3 = pdo_fetch("SELECT * FROM ".tablename('wx_school_object')." WHERE :type = type And :item = item ", array(':type' => 'video', ':item' => 3));
$base4 = pdo_fetch("SELECT * FROM ".tablename('wx_school_classify')." WHERE :type = type ", array(':type' => 'thevideos'));
if (empty($base1)) {
	$data1 = array (
					'item' => 1,
					'type' => 'base',
					'displayorder' => '基础功能（通知，作业，留言，请假, 周计划）'		
	);
	pdo_insert ( 'wx_school_object', $data1 );	
}
$object1 = pdo_fetch("SELECT * FROM ".tablename('wx_school_object')." WHERE :id = id ", array(':id' => 1));
if (!empty($object1)) {
	$data1 = array (
					'item' => 1,
					'type' => 'base',
					'displayorder' => '基础功能（通知，作业，留言，请假, 周计划）'		
	);
	pdo_update ( 'wx_school_object', $data1, array('id' =>1));	
}
if (empty($base2)) {
	$data2 = array (
			'item' => 2,
			'type' => 'hight',
			'displayorder' => '进阶功能(班级圈,相册,通讯录)'		
	);
	pdo_insert ( 'wx_school_object', $data2 );
}
if (empty($base3)) {
	$data3 = array (
			'item' => 3,
			'type' => 'video',
			'displayorder' => '教室实时画面'		
	);
	pdo_insert ( 'wx_school_object', $data3 );
}
if (empty($base4)) {
	$data4 = array (
			'video1' => $_SERVER ['HTTP_HOST']
	);
	pdo_insert ( 'wx_school_classify', $data4 );
}

if(!pdo_fieldexists('wx_school_bjq', $arr['0'])) {
	               pdo_query("ALTER TABLE  ".tablename('wx_school_bjq')." ADD `{$arr['0']}` varchar(30) NOT NULL DEFAULT '0' COMMENT '0' AFTER uid;");
                }
if(!pdo_fieldexists('wx_school_dianzan', $arr['1'])) {
	               pdo_query("ALTER TABLE  ".tablename('wx_school_dianzan')." ADD `{$arr['1']}` varchar(30) NOT NULL DEFAULT '0' COMMENT '图片路径' AFTER createtime;");
                }
if(!pdo_fieldexists('wx_school_order', $arr['1'])) {
	               pdo_query("ALTER TABLE  ".tablename('wx_school_order')." ADD `{$arr['1']}` varchar(30) NOT NULL DEFAULT '0' COMMENT '支付LOGO' AFTER createtime;");
                }				
if(!pdo_fieldexists('wx_school_teachers', $arr['2'])) {
	               pdo_query("ALTER TABLE  ".tablename('wx_school_teachers')." ADD `{$arr['2']}` varchar(30) NOT NULL DEFAULT '0' COMMENT '0' AFTER xq_id3;");
                }
if(!pdo_fieldexists('wx_school_notice', $arr['3'])) {
	               pdo_query("ALTER TABLE  ".tablename('wx_school_notice')." ADD `{$arr['3']}` varchar(30) NOT NULL DEFAULT '0' COMMENT '0' AFTER bj_id;");
                }
