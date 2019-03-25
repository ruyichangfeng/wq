<?php








if(!pdo_fieldexists('mon_xkwkj_firend', 'kname')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_firend')." ADD `kname` int(3) ;");
}



if(!pdo_fieldexists('mon_xkwkj_firend', 'ac')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_firend')." ADD `ac` varchar(50) ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'kj_intro')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `kj_intro` text ;");
}

if(!pdo_fieldexists('mon_xkwkj_order', 'outno')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_order')." ADD `outno` varchar(200) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'kj_intro')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `kj_intro` text ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'kj_follow_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `kj_follow_enable` int(1) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'join_follow_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `join_follow_enable` int(1) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'follow_dlg_tip')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `follow_dlg_tip` varchar(500) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'follow_btn_name')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `follow_btn_name` varchar(20) ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'share_bg')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `share_bg` varchar(300) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'rank_num')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `rank_num` int(10) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'v_user')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `v_user` int(10);");
}

if(!pdo_fieldexists('mon_xkwkj', 'join_rank_num')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `join_rank_num` int(10) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'zt_address')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `zt_address` varchar(1000) ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'one_kj_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `one_kj_enable` int(1) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'day_help_count')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `day_help_count` int(10) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'kj_follow_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `kj_follow_enable` int(1);");
}

if(!pdo_fieldexists('mon_xkwkj', 'submit_money_limit')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `submit_money_limit` float(10,2) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'hx_enabled')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `hx_enabled` int(1) ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'tmp_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `tmp_enable` int(1) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'tmpId')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `tmpId` varchar(1000) ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'fh_tmp_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `fh_tmp_enable` int(1) ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'fh_tmp_id')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `fh_tmp_id` varchar(1000) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'show_index_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `show_index_enable` int(1) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'index_sort')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `index_sort` int(10) ;");
}



if(!pdo_fieldexists('mon_xkwkj_setting', 'is_collect_user_info')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_setting')." ADD `is_collect_user_info` int(1) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'is_collec_order_address')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `is_collec_order_address` int(1) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'help_limit')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `help_limit` int(10) ;");
}
if(!pdo_fieldexists('mon_xkwkj', 'locationlimit')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `locationlimit` varchar(1000) ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'erweim')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `erweim` varchar(300) ;");
}


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
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);



$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_index_setting') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`weid` int(10) NOT NULL,
`pagesize` varchar(200) ,
`announcement` varchar(2000),
`banner_bg` varchar(1000),
`banner_url` varchar(2000),
 `createtime` int(10) DEFAULT 0,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

pdo_query($sql);


if(!pdo_fieldexists('mon_xkwkj_index_setting', 'share_title')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_index_setting')." ADD `share_title` varchar(200) ;");
}

if(!pdo_fieldexists('mon_xkwkj_index_setting', 'share_icon')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_index_setting')." ADD `share_icon` varchar(200) ;");
}

if(!pdo_fieldexists('mon_xkwkj_index_setting', 'share_content')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_index_setting')." ADD `share_content` varchar(200) ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'announcement')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `announcement` varchar(2000) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'zgg_url')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `zgg_url` varchar(500) ;");
}



if(!pdo_fieldexists('mon_xkwkj', 'join_user_limit')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `join_user_limit` int(10) ;");
}


if(!pdo_fieldexists('mon_xkwkj_setting', 'help_kj_limit')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_setting')." ADD `help_kj_limit` int(10) ;");
}


if (!pdo_indexexists('mon_xkwkj_user', 'index_kid')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_user')." ADD INDEX index_kid (`kid`) ;");
}

if (!pdo_indexexists('mon_xkwkj_user', 'index_openid')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_user')." ADD INDEX index_openid (`openid`) ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'bgmusic')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `bgmusic` varchar(500) ;");
}

/**
 * 地址表
 */
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



if(!pdo_fieldexists('mon_xkwkj_order', 'unid')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_order')." ADD `unid` int(10) ;");
}


if(!pdo_fieldexists('mon_xkwkj_user', 'unid')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_user')." ADD `unid` int(10) ;");
}

if(!pdo_fieldexists('mon_xkwkj_order', 'remark')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_order')." ADD `remark` varchar(500) ;");
}



if(!pdo_fieldexists('mon_xkwkj', 'kc_type')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `kc_type` int(1) ;");
}


if(!pdo_fieldexists('mon_xkwkj_order', 'lq_type')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_order')." ADD `lq_type` int(2) ;");
}




$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_ppts') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`p_type` int(1),
`kid` int(10),
`weid` int(10),
`pptname` varchar(100),
`dsort` int(10),
`images` varchar(500),
`ppt_url` varchar(500),
`createtime` int(10) DEFAULT 0,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);


if(!pdo_fieldexists('mon_xkwkj_index_setting', 'ppt_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_index_setting')." ADD `ppt_enable` int(1) ;");
}


// 2.1.9
if(!pdo_fieldexists('mon_xkwkj_setting', 'tmp_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_setting')." ADD `tmp_enable` int(1) ;");
}


if(!pdo_fieldexists('mon_xkwkj_setting', 'tmpId')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_setting')." ADD `tmpId` varchar(500) ;");
}

if(!pdo_fieldexists('mon_xkwkj_setting', 'fh_tmp_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_setting')." ADD `fh_tmp_enable` int(1) ;");
}


if(!pdo_fieldexists('mon_xkwkj_setting', 'fh_tmp_id')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_setting')." ADD `fh_tmp_id` varchar(500) ;");
}

if(!pdo_fieldexists('mon_xkwkj', 'lq_type')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `lq_type` int(1) ;");
}


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


if(!pdo_fieldexists('mon_xkwkj_index_setting', 'category_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_index_setting')." ADD `category_enable` int(1) ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'cid')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `cid` int(5) ;");
}


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

if(!pdo_fieldexists('mon_xkwkj', 'shtel')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `shtel` varchar(20) ;");
}



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


if(pdo_fieldexists('mon_xkwkj', 'new_title')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop  `new_title`;");
}

if(pdo_fieldexists('mon_xkwkj', 'new_icon')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop  `new_icon`;");
}

if(pdo_fieldexists('mon_xkwkj', 'new_content')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop  `new_content` ;");
}


if(pdo_fieldexists('mon_xkwkj', 'tmp_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop  `tmp_enable`;");
}

if(pdo_fieldexists('mon_xkwkj', 'tmpId')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop  `tmpId`;");
}

if(pdo_fieldexists('mon_xkwkj', 'fh_tmp_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop  `fh_tmp_enable` ;");
}

if(pdo_fieldexists('mon_xkwkj', 'fh_tmp_id')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop `fh_tmp_id`;");
}

if(pdo_fieldexists('mon_xkwkj', 'is_collec_order_address')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop `is_collec_order_address`;");
}

if(!pdo_fieldexists('mon_xkwkj', 'gid')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `gid` int(10) ;");
}



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


if(!pdo_fieldexists('mon_xkwkj', 'templateid')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `templateid` int(10) ;");
}




if(pdo_fieldexists('mon_xkwkj', 'p_name')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop `p_name`;");
}


if(pdo_fieldexists('mon_xkwkj', 'p_pic')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop `p_pic`;");
}


if(pdo_fieldexists('mon_xkwkj', 'p_preview_pic')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop `p_preview_pic`;");
}


if(pdo_fieldexists('mon_xkwkj', 'p_url')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop `p_url`;");
}



if(pdo_fieldexists('mon_xkwkj', 'follow_url')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop `follow_url`;");
}


if(!pdo_fieldexists('mon_xkwkj', 'hfbk_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `hfbk_enable` int(1) ;");
}


if(!pdo_fieldexists('mon_xkwkj_setting', 'kf')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_setting')." ADD `kf` varchar(500) ;");
}


if(!pdo_fieldexists('mon_xkwkj_index_setting', 'home_style')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_index_setting')." ADD `home_style` int(1) ;");
}


// V2.5.4
if (!pdo_indexexists('mon_xkwkj_firend', 'index_kid')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_firend')." ADD INDEX index_kid (`kid`) ;");
}

if (!pdo_indexexists('mon_xkwkj_firend', 'index_uid')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_firend')." ADD INDEX index_uid (`uid`) ;");
}


$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_xkwkj_poster') . " (
`id` int(10) unsigned  AUTO_INCREMENT,
`kid` int(10) DEFAULT 0 ,
`uid` int(10) DEFAULT 0,
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
`qrtype` int(1),
`qr_enable` int(1),
`pdata` text,
`qrversion` int(10),
`updatetime` int(10) DEFAULT 0,
`createtime` int(10) DEFAULT 0,
 INDEX (kid),
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

pdo_query($sql);


// V 2.6.1
if(!pdo_fieldexists('mon_xkwkj_user', 'updatetime')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_user')." ADD `updatetime` int(10) DEFAULT 0 ;");
}

// V 2.6.2
if(pdo_fieldexists('mon_xkwkj', 'rid')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop  `rid`;");
}

if(pdo_fieldexists('mon_xkwkj', 'copyright')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop  `copyright`;");
}


if(pdo_fieldexists('mon_xkwkj', 'copyright')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." drop  `copyright_url`;");
}




if(!pdo_fieldexists('mon_xkwkj', 'vcount')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `vcount` int(10) DEFAULT 0 ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'sharecount')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `sharecount` int(10) DEFAULT 0 ;");
}


if (!pdo_indexexists('mon_xkwkj_firend', 'index_openid')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj_firend')." ADD INDEX index_openid (`openid`) ;");
}




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



if(!pdo_fieldexists('mon_xkwkj', 'v_vcount')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `v_vcount` int(10) DEFAULT 0 ;");
}


if(!pdo_fieldexists('mon_xkwkj', 'v_sharecount')) {
	pdo_query("ALTER TABLE ".tablename('mon_xkwkj')." ADD `v_sharecount` int(10) DEFAULT 0 ;");
}




























