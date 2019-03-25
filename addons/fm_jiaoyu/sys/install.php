<?php

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_area' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '区域名称',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `ssort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `type` char(20) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '显示状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_type' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '类型名称',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `ssort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '显示状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_icon' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公众号',
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分校id',  
  `name` varchar(50) NOT NULL COMMENT '按钮名称',
  `icon` varchar(1000) NOT NULL COMMENT '按钮图标',
  `beizhu` varchar(50) NOT NULL COMMENT '备注或小字',
  `color` varchar(50) NOT NULL COMMENT '颜色',
  `url` varchar(1000) NOT NULL COMMENT '链接url',  
  `place` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1首页菜单2底部菜单',
  `ssort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '显示状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_classify' ) . "(
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分校id',  
  `sname` varchar(50) NOT NULL,
  `pname` varchar(50) NOT NULL,
  `ssort` int(5) NOT NULL,
  `weid` int(10) unsigned NOT NULL,
  `type` char(20) NOT NULL,
  `carmeraid` text DEFAULT '' COMMENT '画面ID组',
  `erwei` varchar(200) NOT NULL DEFAULT '' COMMENT '群二维码',
  `qun` varchar(200) NOT NULL DEFAULT '' COMMENT 'QQ群链接',
  `video` varchar(1000) NOT NULL DEFAULT '' COMMENT '教室监控地址',
  `video1` varchar(1000) NOT NULL DEFAULT '' COMMENT '教室监控地址1',
  `videostart` varchar(50) NOT NULL,
  `videoend` varchar(50) NOT NULL,
  `allowpy` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1允许2拒绝',
  `cost` varchar(11) NOT NULL COMMENT '报名费用',
  `videoclick` varchar(11) NOT NULL COMMENT '视频点击量',
  `tid` int(11) unsigned NOT NULL COMMENT '班级主任userid',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;";
pdo_query($sql);

$sql = "		
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_score' ) . "(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分校id',
  `xq_id` int(11) NOT NULL,
  `bj_id` int(11) NOT NULL,
  `qh_id` int(11) NOT NULL,
  `km_id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `my_score` varchar(50) NOT NULL,
  `info` varchar(1000) NOT NULL DEFAULT '' COMMENT '教师评价',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=675 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_index' ) . "(
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '账户ID',
  `weid` int(10) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `areaid` int(10) NOT NULL DEFAULT '0' COMMENT '区域id',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `logo` varchar(1000) NOT NULL DEFAULT '' COMMENT '学校logo',
  `thumb` varchar(200) NOT NULL DEFAULT '' COMMENT '图文消息缩略图',
  `qroce` varchar(200) NOT NULL DEFAULT '' COMMENT '二维码',
  `info` varchar(1000) NOT NULL DEFAULT '' COMMENT '简短描述',
  `content` text NOT NULL COMMENT '简介',
  `zhaosheng` text NOT NULL COMMENT '招生简章',
  `tel` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `location_p` varchar(100) NOT NULL DEFAULT '' COMMENT '省',
  `location_c` varchar(100) NOT NULL DEFAULT '' COMMENT '市',
  `location_a` varchar(100) NOT NULL DEFAULT '' COMMENT '区',
  `address` varchar(200) NOT NULL COMMENT '地址',
  `place` varchar(200) NOT NULL DEFAULT '',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '经度',
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000' COMMENT '纬度',
  `password` varchar(20) NOT NULL DEFAULT '' COMMENT '登录密码',
  `hours` varchar(200) NOT NULL DEFAULT '' COMMENT '营业时间',
  `recharging_password` varchar(20) NOT NULL DEFAULT '' COMMENT '充值密码',
  `thumb_url` varchar(1000) DEFAULT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在手机端显示',
  `ssort` tinyint(3) NOT NULL DEFAULT '0',
  `is_sms` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '搜索页显示',
  `is_showew` tinyint(1) NOT NULL DEFAULT '1' COMMENT '页面显示二维码开关',
  `is_showad` int(10) NOT NULL DEFAULT '0' COMMENT '是否显示广告',
  `is_comload` int(10) NOT NULL DEFAULT '0' COMMENT '广告ID',
  `is_recordmac` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用',
  `is_cardpay` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用',
  `is_cardlist` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用',
  `is_cost` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用',
  `is_video` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用',
  `is_sign` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1启用2不启用',
  `is_zjh` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1启用2不启用周计划',
  `is_wxsign` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1启用2不启用微信签到',
  `is_openht` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1启用2不启用独立后台',
  `is_signneedcomfim` tinyint(1) NOT NULL DEFAULT '1' COMMENT '手机签到是否需确认1是2否',
  `shoucename` varchar(200) NOT NULL DEFAULT '' COMMENT '手册名称',
  `videoname` varchar(200) NOT NULL DEFAULT '' COMMENT '监控名称',
  `wqgroupid` int(10) NOT NULL DEFAULT '0' COMMENT '微擎默认用户组',
  `videopic` varchar(1000) NOT NULL DEFAULT '' COMMENT '监控封面',
  `manger` varchar(200) NOT NULL DEFAULT '' COMMENT '模版名称1',
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0显示1不',
  `issale` tinyint(1) NOT NULL DEFAULT '5' COMMENT '5种状态',
  `gonggao` varchar(1000) NOT NULL DEFAULT '' COMMENT '通知',
  `is_rest` tinyint(1) NOT NULL DEFAULT '0',
  `signset` varchar(200) NOT NULL COMMENT '报名设置',
  `cardset` varchar(500) NOT NULL COMMENT '刷卡设置',
  `typeid` int(10) NOT NULL DEFAULT '0' COMMENT '学校类型',
  `cityid` int(10) NOT NULL DEFAULT '0' COMMENT '城市ID',
  `spic` varchar(200) NOT NULL DEFAULT '' COMMENT '默认学生头像',
  `tpic` varchar(200) NOT NULL DEFAULT '' COMMENT '默认教师头像',
  `jxstart` varchar(50) DEFAULT '',
  `jxend` varchar(50) DEFAULT '', 
  `lxstart` varchar(50) DEFAULT '',
  `lxend` varchar(50) DEFAULT '',
  `jxstart1` varchar(50) DEFAULT '',
  `jxend1` varchar(50) DEFAULT '', 
  `lxstart1` varchar(50) DEFAULT '',
  `lxend1` varchar(50) DEFAULT '',
  `jxstart2` varchar(50) DEFAULT '',
  `jxend2` varchar(50) DEFAULT '', 
  `lxstart2` varchar(50) DEFAULT '',
  `lxend2` varchar(50) NOT NULL,  
  `style1` varchar(200) NOT NULL DEFAULT '' COMMENT '模版名称1',
  `style2` varchar(200) NOT NULL DEFAULT '' COMMENT '模版名称2',
  `style3` varchar(200) NOT NULL DEFAULT '' COMMENT '模版名称3',
  `userstyle` varchar(50) NOT NULL DEFAULT '' COMMENT '家长学生中心模板',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;";
pdo_query($sql);

$sql = "		
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_students' ) . "(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分校id',
  `icon` varchar(255) NOT NULL,
  `numberid` varchar(18) NOT NULL,
  `xq_id` int(11) NOT NULL,
  `area_addr` varchar(200) NOT NULL DEFAULT '',
  `ck_id` int(11) NOT NULL,
  `bj_id` int(11) NOT NULL,
  `birthdate` int(10) unsigned NOT NULL,
  `sex` int(1) NOT NULL,
  `createdate` int(10) unsigned NOT NULL,
  `seffectivetime` int(10) unsigned NOT NULL,
  `stheendtime` int(10) unsigned NOT NULL,
  `jf_statu` int(11) DEFAULT NULL,
  `mobile` char(11) NOT NULL,
  `homephone` char(16) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `localdate_id` char(20) NOT NULL DEFAULT '',
  `note` varchar(50) NOT NULL DEFAULT '',
  `amount` int(11) NOT NULL,
  `area` varchar(50) NOT NULL,
  `own` varchar(30) NOT NULL DEFAULT '0' COMMENT '本人微信info',
  `mom` varchar(30) NOT NULL DEFAULT '0' COMMENT '母亲微信info',
  `dad` varchar(30) NOT NULL DEFAULT '0' COMMENT '父亲微信info',
  `other` varchar(30) NOT NULL DEFAULT '0' COMMENT '其他家长微信info',
  `ouserid` int(11) NOT NULL COMMENT '用户ID',
  `muserid` int(11) NOT NULL COMMENT '用户ID',
  `duserid` int(11) NOT NULL COMMENT '用户ID',
  `otheruserid` int(11) NOT NULL COMMENT '用户ID',
  `ouid` int(10) unsigned NOT NULL COMMENT '微擎系统memberID',
  `muid` int(10) unsigned NOT NULL COMMENT '微擎系统memberID',
  `duid` int(10) unsigned NOT NULL COMMENT '微擎系统memberID',
  `otheruid` int(10) unsigned NOT NULL COMMENT '微擎系统memberID',
  `xjid` int(11) unsigned NOT NULL COMMENT '学籍信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=670 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_tcourse' ) . "(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分校id',  
  `weid` int(10) unsigned NOT NULL,
  `tid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '课程名称',  
  `dagang` text NOT NULL COMMENT '课程大纲',
  `start` int(10) unsigned NOT NULL COMMENT '开始时间',
  `end` int(10) unsigned NOT NULL COMMENT '结束时间',  
  `minge` int(11) NOT NULL COMMENT '名额限制',
  `yibao` int(11) NOT NULL COMMENT '已报人数',
  `cose` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '报名费用',
  `adrr` varchar(100) NOT NULL DEFAULT '' COMMENT '授课地址或教室',    
  `km_id` int(11) NOT NULL,
  `bj_id` int(11) NOT NULL,
  `xq_id` int(11) NOT NULL,
  `sd_id` int(11) NOT NULL,
  `is_hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1显示,2否',
  `payweid` int(10) unsigned NOT NULL COMMENT '支付公众号',
  `ssort` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_teachers' ) . "(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分校id',  
  `weid` int(10) unsigned NOT NULL,
  `tname` varchar(50) NOT NULL,
  `birthdate` int(10) unsigned NOT NULL,
  `tel` varchar(20) NOT NULL,
  `mobile` char(11) NOT NULL,
  `email` char(50) NOT NULL,
  `sex` int(1) NOT NULL,
  `km_id1` int(11) NOT NULL COMMENT '授课科目1',
  `km_id2` int(11) NOT NULL COMMENT '授课科目2',
  `km_id3` int(11) NOT NULL COMMENT '授课科目3',
  `bj_id1` int(11) NOT NULL COMMENT '授课班级1',
  `bj_id2` int(11) NOT NULL COMMENT '授课班级2',
  `bj_id3` int(11) NOT NULL COMMENT '授课班级3',
  `xq_id1` int(11) NOT NULL COMMENT '授课年级1',
  `xq_id2` int(11) NOT NULL COMMENT '授课年级2',
  `xq_id3` int(11) NOT NULL COMMENT '授课年级3',
  `fz_id` int(11) NOT NULL COMMENT '所属分组',
  `jiontime` int(10) unsigned NOT NULL,
  `info` text NOT NULL COMMENT '教学成果',
  `jinyan` text NOT NULL COMMENT '教学经验',
  `headinfo` text NOT NULL COMMENT '教学特点',
  `thumb` varchar(200) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  `code` int(11) unsigned NOT NULL COMMENT '绑定码',
  `openid` varchar(30) NOT NULL DEFAULT '0' COMMENT '教师微信',
  `uid` int(10) unsigned NOT NULL COMMENT '微擎系统memberID',
  `userid` int(11) NOT NULL COMMENT '用户ID',
  `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示', 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_kcbiao' ) . "(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分校id',  
  `weid` int(10) unsigned NOT NULL,
  `tid` int(11) NOT NULL COMMENT '所属教师ID',
  `kcid` int(11) NOT NULL COMMENT '所属课程ID',
  `nub` int(11) NOT NULL COMMENT '第几堂课或第几讲',  
  `bj_id` int(11) NOT NULL,
  `km_id` int(11) NOT NULL,  
  `xq_id` int(11) NOT NULL,
  `sd_id` int(11) NOT NULL,
  `isxiangqing` tinyint(1) NOT NULL DEFAULT '0' COMMENT '内容显示开关',
  `content` text NOT NULL COMMENT '课程内容',
  `date` int(10) unsigned NOT NULL COMMENT '开课日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_cookbook' ) . "(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分校id',  
  `weid` int(10) unsigned NOT NULL,
  `keyword` varchar(50) NOT NULL,
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
  `infos` varchar(500) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_reply' ) . "(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `schoolid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_rid` (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_banners' ) . "(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `uniacid` int(10) unsigned NOT NULL,
  `schoolid` int(11) DEFAULT '0',
  `bannername` varchar(50) DEFAULT '',
  `link` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `begintime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,  
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `leixing` int(1) NOT NULL DEFAULT '0' COMMENT '0学校,1平台',
  `arr` text COMMENT '列表信息',
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

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
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;";
pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_set' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `weid` int(10) unsigned NOT NULL,
    `istplnotice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否模版通知',
	`guanli` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理方式',
    `xsqingjia` varchar(200) DEFAULT '' COMMENT '学生请假申请ID',
	`xsqjsh` varchar(200) DEFAULT '' COMMENT '学生请假审核通知ID',
	`jsqingjia` varchar(200) DEFAULT '' COMMENT '教员请假申请体提醒ID',
	`jsqjsh` varchar(200) DEFAULT '' COMMENT '教员请假审核通知ID',
	`xxtongzhi` varchar(200) DEFAULT '' COMMENT '学校通知ID',
	`liuyan` varchar(200) DEFAULT '' COMMENT '家长留言ID',
	`liuyanhf` varchar(200) DEFAULT '' COMMENT '教师回复家长留言ID',
	`zuoye` varchar(200) DEFAULT '' COMMENT '发布作业提醒ID',
	`bjtz` varchar(200) DEFAULT '' COMMENT '班级通知ID',
	`bjqshjg` varchar(200) DEFAULT '' COMMENT '班级圈审核结果',
	`bjqshtz` varchar(200) DEFAULT '' COMMENT '班级圈审核提醒',	
	`jxlxtx` varchar(200) DEFAULT '' COMMENT '进校提醒',
	`jfjgtz` varchar(200) DEFAULT '' COMMENT '缴费结果通知',
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
	`isfrist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1是0否',
	`isliuyan` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否留言',
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
	`picarr` text COMMENT '图片组',
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
	`lastorderid` int(10) unsigned NOT NULL COMMENT '继承订单,用于续费',
	`signid` int(10) unsigned NOT NULL COMMENT '报名ID',
    `bdcardid` int(10) unsigned NOT NULL COMMENT '帮卡ID',
	`obid` int(10) unsigned NOT NULL COMMENT '功能ID',
    `cose` decimal(18,2) NOT NULL DEFAULT '0.00',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1未支付2为已支付3为已退款',
	`type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1课程2项目3功能4报名',	
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
    `cose` decimal(18,2) NOT NULL DEFAULT '0.00',
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
  `title` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `content` mediumtext NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `picarr` text COMMENT '图片组',
  `displayorder` tinyint(3) unsigned NOT NULL,
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
  `cost` varchar(10) NOT NULL COMMENT '报名费用',
  `birthday` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `passtime` int(10) unsigned NOT NULL,
  `lasttime` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL COMMENT '发布者UID',
  `orderid` int(10) unsigned NOT NULL COMMENT '',
  `openid` varchar(30) NOT NULL COMMENT 'openid',
  `pard` tinyint(1) unsigned NOT NULL COMMENT '关系',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1审核中2审核通过3不通过',  
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
  `isread` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1已读2未读',
  `pard` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '1本人2母亲3父亲4爷爷5奶奶6外公7外婆8叔叔9阿姨10其他11老师',
  `qdtid` int(11) NOT NULL COMMENT '代签老师ID',
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
  `pname` varchar(200) NOT NULL,
  `bj_id` int(10) unsigned NOT NULL, 
  `idcard` varchar(200) NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `spic` varchar(1000) NOT NULL,
  `tpic` varchar(1000) NOT NULL,
  `pard` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1本人2母亲3父亲4爷爷5奶奶6外公7外婆8叔叔9阿姨10其他',
  `createtime` int(10) unsigned NOT NULL,
  `severend` int(10) unsigned NOT NULL,
  `is_on` int(1) NOT NULL DEFAULT '0' COMMENT '1:使用,2未用,默认0',
  `usertype` int(1) NOT NULL DEFAULT '0' COMMENT '1:老师,学生0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
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
  `videopic` varchar(1000) NOT NULL DEFAULT '' COMMENT '监控地址', 
  `videourl` varchar(1000) NOT NULL DEFAULT '' COMMENT '监控地址',  
  `starttime` varchar(50) NOT NULL,
  `endtime` varchar(50) NOT NULL, 
  `createtime` int(10) unsigned NOT NULL,
  `conet` text DEFAULT '' COMMENT '说明',
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
  `conet` text DEFAULT '' COMMENT '内容',
  `bj_id` int(10) unsigned NOT NULL COMMENT '班级ID',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1点赞2评论',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
pdo_query($sql);

if(!pdo_fieldexists('users', 'tid')) {
	pdo_query("ALTER TABLE ".tablename('users')." ADD `tid` int(10) NOT NULL DEFAULT '0' COMMENT '';");
}

if(!pdo_fieldexists('users', 'schoolid')) {
	pdo_query("ALTER TABLE ".tablename('users')." ADD `schoolid` int(10) NOT NULL DEFAULT '0' COMMENT '';");
}

if(!pdo_fieldexists('users', 'uniacid')) {
	pdo_query("ALTER TABLE ".tablename('users')." ADD `uniacid` int(10) NOT NULL DEFAULT '0' COMMENT '';");
}
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
$data1 = array (
		'item' => 1,
		'type' => 'base',
		'displayorder' => '基础功能(通知,作业,留言,请假,周计划)'		
	);
	pdo_insert ( 'wx_school_object', $data1 );
$data2 = array (
		'item' => 2,
		'type' => 'hight',
		'displayorder' => '进阶功能(班级圈,相册,通讯录)'		
	);
	pdo_insert ( 'wx_school_object', $data2 );
$data3 = array (
		'item' => 3,
		'type' => 'video',
		'displayorder' => '教室实时画面'		
	);
	pdo_insert ( 'wx_school_object', $data3 );
$data4 = array (
		'video1' => $_SERVER ['HTTP_HOST']
);
    pdo_insert ( 'wx_school_classify', $data4 );	
