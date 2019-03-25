<?php


/**
 *砍价活动
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
 `weid` int(11) NOT NULL  ,
 `title` varchar(200) NOT NULL,
 `starttime` int(10),
 `endtime` int(10),
 `kj_intro` text,
 `p_kc` int(10) default 0,
 `p_y_price` float(10,2) ,
 `p_low_price` float(10,2),
  `yf_price` float(10,2) default 0,
 `share_title` varchar(200),
`share_icon` varchar(200),
`share_content` varchar(200),
`hot_tel` varchar(50),
`createtime` int(10) DEFAULT 0,
`kj_dialog_tip` varchar(1000),
`rank_tip` varchar(1000),
`u_fist_tip` varchar(1000),
`u_already_tip` varchar(1000),
`fk_fist_tip` varchar(1000),
`fk_already_tip` varchar(1000),
`kj_rule` text,
`pay_type` int(2),
`p_model` varchar(1000),
`kj_follow_enable` int(1),
 `join_follow_enable` int(1),
`follow_dlg_tip` varchar(500),
`follow_btn_name` varchar(20),
`erweim` varchar(300),
`share_bg` varchar(300),
`rank_num` int(10),
`join_rank_num` int(10),
`v_user` int(10),
`zt_address` varchar(1000),
`one_kj_enable` int(1),
`day_help_count` int(10),
`submit_money_limit` float(10,2),
`hx_enabled` int(1),
`show_index_enable` int(1),
`index_sort` int(10),
`announcement` varchar(2000),
`zgg_url` varchar(500),
`join_user_limit` int(10),
`help_limit` int(10),
`locationlimit` varchar(1000),
`bgmusic` varchar(500),
`kc_type` int(1),
`lq_type` int(1),
`cid` int(5),
`shtel` varchar(20),
 `gid` int(10),
 `templateid` int(10),
 `hfbk_enable` int(1),
 `vcount` int(10) DEFAULT 0 ,
 `sharecount` int(10) DEFAULT 0, 
  `v_vcount` int(10) DEFAULT 0 ,
 `v_sharecount` int(10) DEFAULT 0, 
 INDEX (weid),
 INDEX (cid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);


/**
 * 砍价用户
 */

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_user') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`kid` int(10) NOT NULL,
`unid` int(10),
 `openid` varchar(200) NOT NULL,
  kd int(2),
 `nickname` varchar(100) NOT NULL,
 `headimgurl` varchar(200) NOT NULL,
 `price` float(10,2),
 `ip` varchar(30),
 `uname` varchar(100),
 `tel` varchar(100),
 `createtime` int(10) DEFAULT 0,
 `updatetime` int(10) DEFAULT 0,
  INDEX (kid),
  INDEX (openid),
  INDEX (unid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);

/**
 * 用户基本信息
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_user_info') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`weid` int(10) NOT NULL,
`nickname` varchar(100) NOT NULL,
`openid` varchar(200) NOT NULL,
`headimgurl` varchar(200) NOT NULL,
`uname` varchar(100),
`tel` varchar(100),
`createtime` int(10) DEFAULT 0,
 INDEX (weid),
  INDEX (openid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);


/**
 * 砍价好友
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_firend') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`kid` int(10) NOT NULL,
`uid` int(10) NOT NULL,
 `openid` varchar(200) NOT NULL,
 `nickname` varchar(100) NOT NULL,
 `kd` int(2),
 `kname` int(3),
 `msg` varchar(500),
 `ac` varchar(50),
 `headimgurl` varchar(200) NOT NULL,
 `k_price` float(10,2),
 `kh_price` float(10,2),
 `createtime` int(10) DEFAULT 0,
  `ip` varchar(30),
 INDEX (kid),
    INDEX (uid),
     INDEX (openid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);

/**
 * 订单
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_order') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`kid` int(10) NOT NULL,
`uid` int(10) NOT NULL,
`unid` int(10),
`uname` varchar(100),
`address` varchar(100),
`privnce` varchar(100),
`city` varchar(100),
`town` varchar(100),
`tel` varchar(50),
`zipcode` varchar(100),
 `openid` varchar(200) ,
 `outno` varchar(200),
 `order_no` varchar(100) ,
 `wxorder_no` varchar(100) ,
  `y_price` float(10,2),
  `kh_price` float(10,2),
  `yf_price` float(10,2),
 `total_price` float(10,2),
`pay_type` int(2),
`lq_type` int(2),
`p_model` varchar(1000),
 `status` int(1),
 `wxnotify` varchar(200),
  `notifytime` int(10) DEFAULT 0,
 `createtime` int(10) DEFAULT 0,
 `remark` varchar(500),
  INDEX (openid, unid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);

/**
 * 设置
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_setting') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`weid` int(10) NOT NULL,
`kf` varchar(500),
`is_collect_user_info` int(1),
`help_kj_limit` int(10),
`appid` varchar(200) ,
`appsecret` varchar(200),
`mchid` varchar(100),
`shkey` varchar(100),
`tmp_enable` int(1),
`tmpId` varchar(500),
`fh_tmp_enable` int(1),
`fh_tmp_id` varchar(500),
 `createtime` int(10) DEFAULT 0,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);
/**
 * 首页设置
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_index_setting') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`weid` int(10) NOT NULL,
`pagesize` varchar(200) ,
`home_style` int(1),
`announcement` varchar(2000),
`banner_bg` varchar(1000),
`banner_url` varchar(2000),
`ppt_enable` int(1),
`category_enable` int(1),
 `createtime` int(10) DEFAULT 0,
 `share_title` varchar(200),
`share_icon` varchar(200),
`share_content` varchar(200),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

pdo_query($sql);

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_address') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`weid` int(10),
`openid` varchar(100) NOT NULL,
`unid` int(10),
`is_default` int(1),
`uname` varchar(50),
`tel` varchar(15),
`province` varchar(50),
`city` varchar(50),
`county` varchar(50),
`address` varchar(200),
`createtime` int(10),
 INDEX (openid, unid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

pdo_query($sql);



$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_ppts') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`p_type` int(1),
`weid` int(10),
`kid` int(10),
`pptname` varchar(100),
`dsort` int(10),
`images` varchar(500),
`ppt_url` varchar(500),
`createtime` int(10) DEFAULT 0,
 INDEX (weid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);




$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_category') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`typname` varchar(50),
`weid` int(10),
`icon_type` int(1),
`systypeicon` varchar(500),
`typeicon` varchar(500),
`display_sort` int(10),
 INDEX (weid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);


$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_reply') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`rid` int(50),
`kid` int(10),
 `new_title` varchar(200),
`new_icon` varchar(200),
`new_content` varchar(200),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);




/**
 * 商品
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_goods') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`weid` int(10),
`p_name` varchar(100),
`p_pic` varchar(300),
`p_preview_pic` varchar(300),
`p_url` varchar(500),
`createtime` int(10) DEFAULT 0,
 INDEX (weid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);




$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_template') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`templatename` varchar(100),
`preview_pic` varchar(300),
`dirname` varchar(50),
`tempalte_type` int(4),
`createtime` int(10) DEFAULT 0,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);



$default_exites = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mon_xkwkj_template') . " WHERE dirname =:dirname", array(":dirname" => 'default'));
if ($default_exites == 0) {
 $template_default = " insert into ". tablename('mon_xkwkj_template') .
     "(templatename, preview_pic, dirname, tempalte_type, createtime) values ('黑色炫酷', '../addons/mon_xkwkj/images/temp1.jpg', 'default', 0, ".time().")";
   pdo_query($template_default);


 $template_default3 = " insert into ". tablename('mon_xkwkj_template') .
     "(templatename, preview_pic, dirname, tempalte_type, createtime) values ('黄蓝灵动', '../addons/mon_xkwkj/images/2.png', 'default3', 0, ".time().")";
 pdo_query($template_default3);


   $template_default2 = " insert into ". tablename('mon_xkwkj_template') .
       "(templatename, preview_pic, dirname, tempalte_type, createtime) values ('瀑布自然', '../addons/mon_xkwkj/images/2.png', 'default2', 0, ".time().")";
   pdo_query($template_default2);

}



/**
 * 海报
 */

$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_poster') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`kid` int(10) DEFAULT 0 ,
`uid` int(10) DEFAULT 0 ,
`ticket` varchar(250),
`qrtype` int(4),
`expiretime` int(10) DEFAULT 0 ,
`createtime` int(10) DEFAULT 0,
 INDEX (kid, uid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

pdo_query($sql);


$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_poster_setting') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`kid` int(10) DEFAULT 0 ,
`bg` varchar(500),
`qr_enable` int(1),
`pdata` text,
`qrtype` int(4),
`qrversion` int(10),
`updatetime` int(10) DEFAULT 0,
`createtime` int(10) DEFAULT 0,
 INDEX (kid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

pdo_query($sql);



$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_tj_record') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`kid` int(10) DEFAULT 0,
`ttype` int(10) DEFAULT 0 ,
`nickname` varchar(100) NOT NULL,
`openid` varchar(200) NOT NULL,
`headimgurl` varchar(200) NOT NULL,
`createtime` int(10) DEFAULT 0,
 INDEX (kid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

pdo_query($sql);






















