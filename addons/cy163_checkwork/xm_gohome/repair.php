<?php

function repair(){

if(!pdo_tableexists(xm_gohome_adv)) {
 pdo_query("CREATE TABLE ".tablename(xm_gohome_adv)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`adv_name`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`show_adr`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`link`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`pic`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`top`  int(11) NULL DEFAULT 0 ,
`stop`  int(11) NULL DEFAULT NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=6
;");}


if(!pdo_tableexists(xm_gohome_attend)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_attend)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`yopenid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`jopenid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`state`  int(11) NULL DEFAULT NULL ,
`invite`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`addtime`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=7

;");
}


if(!pdo_tableexists(xm_gohome_base)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_base)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`bili`  int(11) NULL DEFAULT 1 ,
`lead`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`lng`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '116.403851' ,
`lat`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '39.915177' ,
`yuming`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`logo`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`title`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`key_info`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`xianzhi`  int(11) NULL DEFAULT 0 ,
`version`  float NULL DEFAULT NULL ,
`banquan`  varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`authen`  int(11) NULL DEFAULT 0 ,
`timeout`  int(11) NULL DEFAULT '3' ,
`examine`  int(11) NULL DEFAULT 0 ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=136

;");}


if(!pdo_tableexists(xm_gohome_blacklist)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_blacklist)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`state`  int(11) NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=15

;");}


if(!pdo_tableexists(xm_gohome_card)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_card)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`staff_id`  int(11) NULL DEFAULT NULL ,
`person`  int(11) NULL DEFAULT 0 ,
`card_name`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`pic1`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`pic2`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`pic3`  varchar(800) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=29

;");}



if(!pdo_tableexists(xm_gohome_code)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_code)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`mobile`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`code`  int(11) NULL DEFAULT NULL ,
`starttime`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`endtime`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=23

;");}


if(!pdo_tableexists(xm_gohome_comment)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_comment)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`staff_id`  int(11) NULL DEFAULT NULL COMMENT '服务人员id' ,
`order_id`  int(11) NULL DEFAULT NULL COMMENT '订单id' ,
`xing`  int(11) NULL DEFAULT NULL COMMENT '星个数' ,
`comment`  varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '评价内容' ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=41

;");}


if(!pdo_tableexists(xm_gohome_companygetmoney)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_companygetmoney)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`staff_id`  int(11) NULL DEFAULT NULL COMMENT '服务人员id' ,
`order_id`  int(11) NULL DEFAULT NULL COMMENT '订单id' ,
`type`  int(11) NULL DEFAULT NULL ,
`way`  int(11) NULL DEFAULT NULL COMMENT '结算方式' ,
`serve_type`  int(11) NULL DEFAULT NULL COMMENT '服务类型' ,
`getmoney`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '得到金额' ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`way2`  int(11) NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=32

;");}


if(!pdo_tableexists(xm_gohome_examine)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_examine)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`adminname`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`addtime`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;");}


if(!pdo_tableexists(xm_gohome_falog)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_falog)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`money`  decimal(10,2) NULL DEFAULT NULL ,
`staff_id`  int(11) NULL DEFAULT NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1

;");}


if(!pdo_tableexists(xm_gohome_gg)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_gg)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`gg_name`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`gg_adr`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`link`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`pic`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`top`  int(11) NULL DEFAULT 0 ,
`stop`  int(11) NULL DEFAULT NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=8

;");}


if(!pdo_tableexists(xm_gohome_grab)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_grab)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`staff_id`  int(11) NULL DEFAULT NULL COMMENT '服务人员id' ,
`serve_type`  int(11) NULL DEFAULT NULL COMMENT '服务类别id' ,
`order_id`  int(11) NULL DEFAULT NULL COMMENT '订单id' ,
`offer`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '我的报价' ,
`suremoney`  float NULL DEFAULT 0 ,
`selected`  int(11) NULL DEFAULT 0 COMMENT '订单是否选中0未选中1选中2失败隐藏' ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`selectedtime`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=102

;");}


if(!pdo_tableexists(xm_gohome_grade)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_grade)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`grade_name`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`icon`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`grade_money`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 ,
`remark`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`delstate`  int(11) NULL DEFAULT 1 ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;");}


if(!pdo_tableexists(xm_gohome_invite)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_invite)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`mobile`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`invite`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`addtime`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=5

;");}



if(!pdo_tableexists(xm_gohome_message)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_message)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`platform`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`plat_name`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`plat_pwd`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`qianming`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`message1`  int(11) NULL DEFAULT 0 ,
`message1_content`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`message2`  int(11) NULL DEFAULT 0 ,
`message2_content`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`message3`  int(11) NULL DEFAULT 0 ,
`message3_content`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=2

;");}


if(!pdo_tableexists(xm_gohome_moneylog)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_moneylog)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`tid`  int(11) NULL DEFAULT NULL ,
`money1`  decimal(10,2) NULL DEFAULT NULL ,
`money2`  decimal(10,2) NULL DEFAULT NULL ,
`remark`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`username`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`s_openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=6

;");}


if(!pdo_tableexists(xm_gohome_msglog)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_msglog)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`staff_id`  int(11) NULL DEFAULT NULL COMMENT '服务人员id' ,
`serve_type`  int(11) NULL DEFAULT NULL COMMENT '服务类别id' ,
`order_id`  int(11) NULL DEFAULT NULL COMMENT '订单id' ,
`state`  int(11) NULL DEFAULT 0 COMMENT '订单状态0抢单中1已抢单' ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`selectedtime`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '选定时间' ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=308

;");}


if(!pdo_tableexists(xm_gohome_order)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_order)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`serve_type`  int(11) NULL DEFAULT NULL ,
`table_name`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '模板表名' ,
`other_id`  int(11) NULL DEFAULT NULL COMMENT '模板表写入的id' ,
`state`  int(11) NULL DEFAULT 0 COMMENT '0暂无抢单1指定服务人员2完工3已有人抢单' ,
`staff_id`  int(11) NULL DEFAULT 0 COMMENT '服务人员ID[选定的服务人员]' ,
`temp_id`  int(11) NULL DEFAULT 0 ,
`lat`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`lng`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`overtime`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=258

;");}


if(!pdo_tableexists(xm_gohome_paylog)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_paylog)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`staff_id`  int(11) NULL DEFAULT NULL COMMENT '服务人员id' ,
`order_id`  int(11) NULL DEFAULT NULL COMMENT '订单id' ,
`type`  int(11) NULL DEFAULT NULL COMMENT '支付类型' ,
`money`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付金额' ,
`remark`  varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`getMoney`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`state`  int(11) NULL DEFAULT 0 ,
`suanstate`  int(11) NULL DEFAULT 0 ,
`fastate`  int(11) NULL DEFAULT 0 ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=69

;");}


if(!pdo_tableexists(xm_gohome_pic)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_pic)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`pic`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`random`  int(11) NULL DEFAULT NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=177

;");}


if(!pdo_tableexists(xm_gohome_print)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_print)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`staff_id`  int(11) NULL DEFAULT NULL ,
`printer_sn`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`key_info`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`ip`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`number`  int(11) NULL DEFAULT NULL ,
`xiaopiao`  varchar(5000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=7

;");}


if(!pdo_tableexists(xm_gohome_question)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_question)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`q_name`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`question`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=3

;");}


if(!pdo_tableexists(xm_gohome_rechargelog)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_rechargelog)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`type`  int(11) NULL DEFAULT NULL COMMENT '支付类型' ,
`money`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '充值金额' ,
`remark`  varchar(800) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=56

;");}

if(!pdo_tableexists(xm_gohome_servetemp)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_servetemp)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`temp_name`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '模板名称' ,
`bewrite`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '描述' ,
`input_name`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标识' ,
`code`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '执行代码' ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;");}


if(!pdo_tableexists(xm_gohome_servetype)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_servetype)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`type_name`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`icon`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`icon_pc`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`top`  int(11) NULL DEFAULT 0 ,
`remark`  varchar(800) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`stop`  int(11) NULL DEFAULT NULL ,
`temp_id`  int(11) NULL DEFAULT 0 COMMENT '模板id' ,
`parent_id`  int(11) NOT NULL DEFAULT 0 COMMENT '父类id' ,
`child_num`  int(11) NOT NULL DEFAULT 0 COMMENT '子类个数' ,
`price`  decimal(10,2) NULL DEFAULT NULL ,
`price_unit`  decimal(10,2) NULL DEFAULT NULL ,
`unit`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`gettype`  int(11) NULL DEFAULT NULL ,
`bili_bai`  float NULL DEFAULT NULL ,
`bili_money`  float NULL DEFAULT NULL ,
`start`  float NULL DEFAULT NULL ,
`end`  float NULL DEFAULT NULL ,
`times`  int(11) NULL DEFAULT NULL ,
`basemoney`  decimal(10,2) NULL DEFAULT 0.00 ,
`front`  decimal(10,2) NULL DEFAULT 0.00 ,
`otmpmsg_id`  int(11) NULL DEFAULT 0 ,
`qtmpmsg_id`  int(11) NULL DEFAULT 0 ,
`xtmpmsg_id`  int(11) NULL DEFAULT 0 ,
`delstate`  int(11) NULL DEFAULT 1 ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=29

;");}


if(!pdo_tableexists(xm_gohome_shuoming)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_shuoming)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`s_name`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`shuoming`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=3

;");}



if(!pdo_tableexists(xm_gohome_staff)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_staff)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`staff_name`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`staff_mobile`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`pwd`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`sex`  int(11) NULL DEFAULT NULL ,
`avatar`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`age`  int(11) NULL DEFAULT NULL ,
`year`  int(11) NULL DEFAULT NULL ,
`card`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`serve_type`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`bank`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`bank_num`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`alipay`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`stop`  int(11) NULL DEFAULT NULL ,
`flag`  int(11) NULL DEFAULT 0 ,
`print_state`  int(11) NULL DEFAULT 0 ,
`company_name`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`contact`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`address`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`license`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`license_pic`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`company_mge`  int(11) NULL DEFAULT 0 ,
`company_flag`  int(11) NULL DEFAULT 0 ,
`staff_num`  int(11) NULL DEFAULT 0 ,
`card_all`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`money`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '余额' ,
`grade_id`  int(11) NULL DEFAULT NULL COMMENT '保证金级别' ,
`grade_money`  decimal(10,2) NULL DEFAULT NULL COMMENT '保证金金额' ,
`get_order`  int(11) NULL DEFAULT 0 COMMENT '接单数' ,
`grab_order`  int(11) NULL DEFAULT 0 COMMENT '抢单数' ,
`good`  int(11) NULL DEFAULT 0 COMMENT '好评数' ,
`center`  int(11) NULL DEFAULT 0 COMMENT '中评数' ,
`bad`  int(11) NULL DEFAULT 0 COMMENT '差评数' ,
`xing`  int(11) NULL DEFAULT 0 ,
`cperson`  int(11) NULL DEFAULT 0 ,
`log`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '经度' ,
`lat`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '纬度' ,
`adrstr`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`permanent`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`delstate`  int(11) NULL DEFAULT 1 ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`updatetime`  datetime NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=153

;");}


if(!pdo_tableexists(xm_gohome_temp)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_temp)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`temp_name`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`temp_token`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`bgcolor`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`bgimage`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`jsgs`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '计算公式' ,
`html`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`cid`  int(11) NULL DEFAULT NULL ,
`delstate`  int(11) NULL DEFAULT 1 ,
`updatetime`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=69

;");}


if(!pdo_tableexists(xm_gohome_tempmessage)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_tempmessage)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`message_name`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`msg_id`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`color_title`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`color_content`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`dataname`  varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`datavalue`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`msg_content`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=9

;");}


if(!pdo_tableexists(xm_gohome_tempmessagedefault)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_tempmessagedefault)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`stmpmsg_id`  int(11) NULL DEFAULT NULL ,
`otmpmsg_id`  int(11) NULL DEFAULT NULL ,
`qtmpmsg_id`  int(11) NULL DEFAULT NULL ,
`xtmpmsg_id`  int(11) NULL DEFAULT NULL ,
`addtime`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=9

;");}

if(!pdo_tableexists(xm_gohome_tempvalue)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_tempvalue)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`temp_id`  int(11) NULL DEFAULT NULL ,
`temp_token`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`input_type`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`input_laber`  varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`input_name`  varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`input_value`  varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`value_name`  varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`input_default`  varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`remark`  varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`prompts`  varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`top`  int(11) NULL DEFAULT 0 ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=374

;");}


if(!pdo_tableexists(xm_gohome_tixianlog)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_tixianlog)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`money`  decimal(10,2) NULL DEFAULT NULL ,
`start`  datetime NULL DEFAULT NULL ,
`end`  datetime NULL DEFAULT NULL ,
`yumoney`  decimal(10,2) NULL DEFAULT NULL ,
`famoney`  decimal(10,2) NULL DEFAULT NULL ,
`staff_id`  int(11) NULL DEFAULT NULL ,
`state`  int(11) NULL DEFAULT 0 ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=5

;");}


if(!pdo_tableexists(xm_gohome_userrechargelog)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_userrechargelog)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`type`  int(11) NULL DEFAULT NULL ,
`money`  decimal(10,2) NULL DEFAULT NULL ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=5

;");
}


if(!pdo_tableexists(xm_gohome_xmtemplet_test)) {
pdo_query("CREATE TABLE ".tablename(xm_gohome_xmtemplet_test)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NOT NULL ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`serve_type`  int(11) NULL DEFAULT NULL ,
`staff_id`  int(11) NULL DEFAULT NULL ,
`ftime`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fmobile`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fname`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fsex`  int(11) NULL DEFAULT NULL ,
`fadr`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`fperson`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`random`  int(11) NULL DEFAULT NULL ,
`flag`  int(11) NULL DEFAULT 0 ,
`dealprice`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 ,
`addtime`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ,
`testfx`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`sex`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`sex1`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`sex2`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`testdatetime`  datetime NULL DEFAULT NULL ,
`testdate`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`testcheckbox`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`test2`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=68

;");
}

if(!pdo_fieldexists(xm_gohome_base,  title)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `title` nvarchar(50) default '幸福到家';");
}

if(!pdo_fieldexists(xm_gohome_base,  key_info)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `key_info` nvarchar(100) default null;");
}

if(!pdo_fieldexists(xm_gohome_base,  xianzhi)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `xianzhi` int(11) default 0;");
}

if(!pdo_fieldexists(xm_gohome_base,  version)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `version` float default 0;");
}

if(!pdo_fieldexists(xm_gohome_base,  authen)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `authen` int(11) default 0;");
}

if(!pdo_fieldexists(xm_gohome_base,  timeout)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `timeout` int(11) default 0;");
}

if(!pdo_fieldexists(xm_gohome_base,  examine)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `examine` int(11) default 0;");
}
	
if(!pdo_fieldexists(xm_gohome_servetype, icon_pc)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `icon_pc` nvarchar(100) default null;");
}


if(!pdo_fieldexists(xm_gohome_servetype,  price)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `price` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00;");
}

if(!pdo_fieldexists(xm_gohome_servetype, otmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `otmpmsg_id` int(11) default 0;");
}

if(!pdo_fieldexists(xm_gohome_servetype, qtmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `qtmpmsg_id` int(11) default 0;");
}

if(!pdo_fieldexists(xm_gohome_servetype, xtmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `xtmpmsg_id` int(11) default 0;");
}

if(!pdo_fieldexists(xm_gohome_paylog,  remark)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_paylog)." ADD `remark` nvarchar(3000) default null;");
}

if(!pdo_fieldexists(xm_gohome_paylog,  state)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_paylog)." ADD `state` int(11) default 0;");
}

if(!pdo_fieldexists(xm_gohome_paylog,  suanstate)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_paylog)." ADD `suanstate` int(11) default 0;");
}

if(!pdo_fieldexists(xm_gohome_paylog,  fastate)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_paylog)." ADD `fastate` int(11) default 0;");
}

//服务人员表【打印机状态】
if(!pdo_fieldexists(xm_gohome_staff,  print_state)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `print_state` int(11) default 0;");
}

//服务人员表【开户银行】
if(!pdo_fieldexists(xm_gohome_staff,  bank)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `bank` nvarchar(300) default null;");
}

//服务人员表【银行卡号】
if(!pdo_fieldexists(xm_gohome_staff,  bank_num)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `bank_num` nvarchar(300) default null;");
}

//服务人员表【支付宝账号】
if(!pdo_fieldexists(xm_gohome_staff,  alipay)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `alipay` nvarchar(300) default null;");
}

//服务人员表【保证金等级】
if(!pdo_fieldexists(xm_gohome_staff,  grade_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `grade_id` int(11) default 0;");
}

//服务人员表【保证金金额】
if(!pdo_fieldexists(xm_gohome_staff,  grade_money)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `grade_money` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00;");
}

if(!pdo_fieldexists(xm_gohome_order,  lat)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_order)." ADD `lat` nvarchar(100) default null;");
}

if(!pdo_fieldexists(xm_gohome_order,  lng)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_order)." ADD `lng` nvarchar(100) default null;");
}

if(!pdo_fieldexists(xm_gohome_tixianlog,  yumoney)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tixianlog)." ADD `yumoney` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00;");
}

if(!pdo_fieldexists(xm_gohome_tixianlog,  famoney)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tixianlog)." ADD `famoney` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00;");
}

if(!pdo_fieldexists(xm_gohome_tixianlog,  staff_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tixianlog)." ADD `staff_id` int(11) default null;");
}

if(!pdo_fieldexists(xm_gohome_companygetmoney, type)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_companygetmoney)." ADD `type` int(11) default null;");
}

if(!pdo_fieldexists(xm_gohome_companygetmoney, way)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_companygetmoney)." ADD `way` int(11) default null;");
}

//项目【抢单基础金额】
if(!pdo_fieldexists(xm_gohome_servetype, basemoney)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `basemoney` DECIMAL(10,2) DEFAULT 0.00;");
}

//给xm_gohome_grade添加delstate字段
if(!pdo_fieldexists(xm_gohome_grade, delstate)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_grade)." ADD `delstate` int(11) default 1;");
}


if(!pdo_tableexists(xm_gohome_blacklist)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_blacklist)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`openid`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`state`  int(11) NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8");
}


if(!pdo_tableexists(xm_gohome_message)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_message)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,platform nvarchar(300) DEFAULT NULL,plat_name nvarchar(300) DEFAULT NULL,plat_pwd nvarchar(100) DEFAULT NULL,qianming nvarchar(500) DEFAULT NULL,message1 int(11) DEFAULT 0,message1_content text DEFAULT NULL,message2 int(11) DEFAULT 0,message2_content text DEFAULT NULL,message3 int(11) DEFAULT 0,message3_content text DEFAULT NULL,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}


if(!pdo_tableexists(xm_gohome_print)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_print)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,staff_id int(11) DEFAULT NULL,printer_sn nvarchar(100) DEFAULT NULL,key_info nvarchar(300) DEFAULT NULL,number int(11) DEFAULT NULL,xiaopiao text DEFAULT NULL,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}


if(!pdo_tableexists(xm_gohome_pic)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_pic)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,pic nvarchar(100) DEFAULT NULL,random int(11) DEFAULT NULL,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}


if(!pdo_tableexists(xm_gohome_temp)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_temp)." (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`weid`  int(11) NULL DEFAULT NULL ,
`temp_name`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`temp_token`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`bgcolor`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`bgimage`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`jsgs`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '计算公式' ,
`html`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`cid`  int(11) NULL DEFAULT NULL ,
`delstate`  int(11) NULL DEFAULT 1 ,
`updatetime`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8");
}


if(!pdo_tableexists(xm_gohome_tempvalue)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_tempvalue)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,temp_id int(11) DEFAULT NULL,temp_token varchar(300) DEFAULT NULL,input_type varchar(500) DEFAULT NULL,input_laber varchar(500) DEFAULT NULL,input_name varchar(1000) DEFAULT NULL,input_value varchar(1000) DEFAULT NULL,value_name varchar(1000) DEFAULT NULL,input_default varchar(1000) DEFAULT NULL,remark varchar(1000) DEFAULT NULL,prompts varchar(1000) DEFAULT NULL,top int(11) DEFAULT '0',PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}

if(!pdo_tableexists(xm_gohome_tixianlog)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_tixianlog)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,openid nvarchar(100) DEFAULT NULL,money DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,yumoney DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,famoney DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,staff_id int(11) DEFAULT NULL,state int(11) DEFAULT 0,start nvarchar(100) DEFAULT NULL,end nvarchar(100) DEFAULT NULL,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}

if(!pdo_tableexists(xm_gohome_moneylog)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_moneylog)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,money1 DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,money2 DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,remark text DEFAULT NULL,username nvarchar(100) DEFAULT NULL,tid int(11) DEFAULT NULL,openid nvarchar(100) DEFAULT NULL,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}

if(!pdo_tableexists(xm_gohome_falog)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_falog)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,openid nvarchar(100) DEFAULT NULL,money DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,staff_id int(11) DEFAULT NULL,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}

if(!pdo_tableexists(xm_gohome_running)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_running)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,type int(11) DEFAULT 0,type_id nvarchar(100) DEFAULT NULL,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}

//模板消息表
if(!pdo_tableexists(xm_gohome_tempmessage)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_tempmessage)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,message_name nvarchar(300) DEFAULT NULL,msg_id nvarchar(300) DEFAULT NULL,color_title nvarchar(100) DEFAULT NULL,color_content nvarchar(100) DEFAULT NULL,dataname nvarchar(1000) DEFAULT NULL,datavalue text DEFAULT NULL,msg_content text DEFAULT NULL,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}

//默认模板消息表
if(!pdo_tableexists(xm_gohome_tempmessagedefault)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_tempmessagedefault)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,`stmpmsg_id` int(11) DEFAULT NULL,`otmpmsg_id` int(11) DEFAULT NULL,`qtmpmsg_id` int(11) DEFAULT NULL,`xtmpmsg_id` int(11) DEFAULT NULL,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}


//保证金等级表
if(!pdo_tableexists(xm_gohome_grade)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_grade)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,grade_name nvarchar(300) DEFAULT NULL,icon nvarchar(100) DEFAULT NULL,grade_money DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,remark text DEFAULT NULL,delstate int(11) DEFAULT 1,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}

//用户充值表
if(!pdo_tableexists(xm_gohome_userrechargelog)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_userrechargelog)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,openid nvarchar(100) DEFAULT NULL,type int(11) DEFAULT NULL,money DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}

//验证码表
if(!pdo_tableexists(xm_gohome_code)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_code)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,mobile nvarchar(100) DEFAULT NULL,code int(11) DEFAULT NULL,starttime varchar DEFAULT NULL,endtime varchar DEFAULT NULL,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}


//邀请码表
if(!pdo_tableexists(xm_gohome_invite)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_invite)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,openid varchar(100) DEFAULT NULL,mobile varchar(100) DEFAULT NULL,invite varchar(100) DEFAULT NULL,addtime datetime DEFAULT NULL,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}

//邀请伙伴关系表
if(!pdo_tableexists(xm_gohome_attend)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_attend)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,yopenid varchar(100) DEFAULT NULL,jopenid varchar(100) DEFAULT NULL,state int(11) DEFAULT NULL,invite varchar(100) DEFAULT NULL,addtime datetime DEFAULT NULL,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}

//用户审核表
if(!pdo_tableexists(xm_gohome_examine)) {
	pdo_query("CREATE TABLE ".tablename(xm_gohome_examine)." (id int(11) NOT NULL AUTO_INCREMENT,weid int(11) NOT NULL,openid varchar(100) DEFAULT NULL,adminname varchar(100) DEFAULT NULL,addtime datetime DEFAULT NULL,PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
}

/**
*时间：2016年2月15日15:53:44
**/
if(!pdo_fieldexists(xm_gohome_temp,  price)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_temp)." ADD `price` int(11) default 1;");
}

if(!pdo_fieldexists(xm_gohome_temp,  juli)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_temp)." ADD `juli` int(11) default 0;");
}

if(!pdo_fieldexists(xm_gohome_temp,  input_1)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_temp)." ADD `input_1` varchar(100) default null;");
}

if(!pdo_fieldexists(xm_gohome_temp,  input_2)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_temp)." ADD `input_2` varchar(100) default null;");
}

/**
*时间:2016年2月16日10:11:32
*/

pdo_query("ALTER TABLE ".tablename('xm_gohome_base')." modify `version` float");
	
if(!pdo_fieldexists(xm_gohome_servetype,  fanwei)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `fanwei` int(11) default 0;");
}

/**
*时间：2016年2月29日14:39:48
**/
pdo_query("ALTER TABLE ".tablename('xm_gohome_code')." modify `starttime` varchar(20)");
pdo_query("ALTER TABLE ".tablename('xm_gohome_code')." modify `endtime` varchar(20)");

/**
*时间：2016年3月1日17:22:51
**/
if(!pdo_fieldexists(xm_gohome_code,  type)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_code)." ADD `type` int(11) default null;");
}

if(!pdo_fieldexists(xm_gohome_code,  isUse)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_code)." ADD `isUse` int(11) default '0';");
}

/**
*时间:2016年3月2日11:59:17
**/
if(!pdo_fieldexists(xm_gohome_base,  sauthen)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `sauthen` int(11) default 0;");
}

if(!pdo_fieldexists(xm_gohome_staff,  sserve_type)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `sserve_type` varchar(500) default null;");
}

// 2016-03-03 09:55
if(!pdo_fieldexists(xm_gohome_moneylog,  s_openid)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_moneylog)." ADD `s_openid` varchar(100) default null;");
}


//2016-3-10 11:38:44
if(!pdo_fieldexists(xm_gohome_servetype,  chao)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `chao` int(11) default 0;");
}

if(!pdo_fieldexists(xm_gohome_servetype,  link)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `link` varchar(100) default null;");
}

if(!pdo_fieldexists(xm_gohome_servetype,  mode)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `mode` int(11) default 1;");
}

/*
 * 2016年3月16日16:29:22
 */
if(!pdo_fieldexists(xm_gohome_servetype,  offer_state)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `offer_state` int(11) default 1;");
}

/*
 * 2016年3月17日14:28:53
 */
if(!pdo_fieldexists(xm_gohome_servetype,  temp_msg)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `temp_msg` int(11) default null;");
}
if(!pdo_fieldexists(xm_gohome_servetype,  send_sms)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `send_sms` int(11) default null;");
}
if(!pdo_fieldexists(xm_gohome_servetype,  mode_openid)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `mode_openid` varchar(300) default null;");
}
if(!pdo_fieldexists(xm_gohome_servetype,  mode_mobile)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `mode_mobile` varchar(300) default null;");
}

//修改字段默认值
pdo_query("alter table ".tablename('xm_gohome_temp')." alter column price drop default");
pdo_query("alter table ".tablename('xm_gohome_temp')." alter column price set default '1'");

if(!pdo_fieldexists(xm_gohome_order,  mode)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_order)." ADD `mode` int(11) default null;");
}

/**
 * 2016年3月21日17:08:27
 */
 if(!pdo_fieldexists(xm_gohome_servetype,  cardname)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `cardname` varchar(100) default null;");
}
 
 /**
  * 2016年4月1日09:46:42
  */
if(!pdo_fieldexists(xm_gohome_servetype,  front)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `front` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00;");
}

//用户预付金额日志表
if (!pdo_tableexists(xm_gohome_userfrontlog)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_userfrontlog) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	openid varchar(100) DEFAULT NULL,
	servetype int(11) DEFAULT NULL,
	money DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

/**
  * 2016年4月11日14:02:55
  */
if(!pdo_fieldexists(xm_gohome_base,  pai_temp)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `pai_temp` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists(xm_gohome_temp,  uploadpic)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_temp)." ADD `uploadpic` int(11) DEFAULT 1;");
}
if(!pdo_fieldexists(xm_gohome_temp,  getadr)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_temp)." ADD `getadr` int(11) DEFAULT 1;");
}

///删除一个用户管理
$arr = pdo_fetchall("SELECT eid FROM ".tablename('modules_bindings')." WHERE module='xm_gohome' AND entry='menu' AND title='用户管理' AND do='userlist'");
if(count($arr) == 0){
	pdo_query("insert into ".tablename('modules_bindings')." (module,entry,title,do,direct) values ('xm_gohome','menu','用户管理','userlist',0)");
}

if(count($arr) >1){
	$rs = pdo_query("delete from ".tablename('modules_bindings')." WHERE module='xm_gohome' AND entry='menu' AND title='用户管理'");
	if($rs){
		pdo_query("insert into ".tablename('modules_bindings')." (module,entry,title,do,direct) values ('xm_gohome','menu','用户管理','userlist',0)");
	}
}

/**
 *  2016年4月19日15:29:01
 */
if(!pdo_fieldexists(xm_gohome_base,  cash)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `cash` int(11) DEFAULT 0;");
}
/**
 * 2016年4月20日14:12:56
 */
if(!pdo_fieldexists(xm_gohome_staff,  nowstate)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `nowstate` int(11) DEFAULT 0;");
}
if(!pdo_fieldexists(xm_gohome_base,  tuistate)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `tuistate` int(11) DEFAULT 0;");
}
if(!pdo_fieldexists(xm_gohome_servetype,  first)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `first` int(11) DEFAULT 0;");
}
/*
 * 2016年4月21日11:20:07
 */
if(!pdo_fieldexists(xm_gohome_grab,  suretime)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_grab)." ADD `suretime` varchar(100) DEFAULT NULL;");
}

if(!pdo_fieldexists(xm_gohome_base,  diywait)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `diywait` varchar(100) DEFAULT '等待价格';");
}
if(!pdo_fieldexists(xm_gohome_base,  diypay)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `diypay` varchar(100) DEFAULT '付款';");
}
if(!pdo_fieldexists(xm_gohome_base,  diygrab)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `diygrab` varchar(100) DEFAULT '抢单';");
}
if(!pdo_fieldexists(xm_gohome_base,  diyyes)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `diyyes` varchar(100) DEFAULT '完成订单';");
}

/**
 * 2016年4月22日10:24:51
 */
if(!pdo_fieldexists(xm_gohome_servetype,  diytime)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `diytime` varchar(100) DEFAULT '服务时间';");
}
if(!pdo_fieldexists(xm_gohome_servetype,  diymobile)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `diymobile` varchar(100) DEFAULT '联系电话';");
}
if(!pdo_fieldexists(xm_gohome_servetype,  diyname)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `diyname` varchar(100) DEFAULT '您的姓名';");
}
if(!pdo_fieldexists(xm_gohome_servetype,  diypic)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `diypic` varchar(100) DEFAULT '上传图片';");
}
if(!pdo_fieldexists(xm_gohome_servetype,  diyaddress)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `diyaddress` varchar(100) DEFAULT '详细地址';");
}
if(!pdo_fieldexists(xm_gohome_servetype,  adr_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `adr_id` int(11) DEFAULT 0;");
}

if(!pdo_tableexists(xm_gohome_address)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_address) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	adr_name varchar(100) DEFAULT NULL,
	lng varchar(100) DEFAULT NULL,
	lat varchar(100) DEFAULT NULL,
	stop int(11) DEFAULT NULL,
	delstate int(11) DEFAULT 1,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if(!pdo_fieldexists(xm_gohome_base,  adr_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `adr_id` int(11) DEFAULT 0;");
}

if(!pdo_fieldexists(xm_gohome_tempmessagedefault,  wtmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tempmessagedefault)." ADD `wtmpmsg_id` varchar(100) DEFAULT null;");
}

/**
 * 2016年4月26日10:43:11
 */
pdo_query("ALTER TABLE ".tablename('xm_gohome_grab')." modify `suremoney` varchar(100)");

if(!pdo_fieldexists(xm_gohome_base,  page)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `page` int(11) DEFAULT 0;");
}

if(!pdo_fieldexists(xm_gohome_servetype,  payway)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `payway` int(11) DEFAULT 0;");
}

if(!pdo_fieldexists(xm_gohome_order,  flag)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_order)." ADD `flag` int(11) DEFAULT 1;");
}

/**
 * 2016年5月12日11:40:50
 */
if(!pdo_fieldexists(xm_gohome_grab,  random)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_grab)." ADD `random` int(11) DEFAULT null;");
}

if(!pdo_fieldexists(xm_gohome_grab,  remark)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_grab)." ADD `remark` text DEFAULT null;");
}

if(!pdo_fieldexists(xm_gohome_staff,  remark)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `remark` text DEFAULT null;");
}

//品类表
if (!pdo_tableexists(xm_gohome_type)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_type) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	type_name varchar(100) DEFAULT NULL,
	icon varchar(100) DEFAULT NULL,
	remark text DEFAULT NULL,
	gettype int(11) DEFAULT NULL,
	bili_bai float DEFAULT NULL,
	bili_money DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	start DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	end DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	stop int(11) DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	delstate int(11) DEFAULT 1,
	updatetime datetime DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

//商圈表
if (!pdo_tableexists(xm_gohome_lido)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_lido) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	lido_name varchar(100) DEFAULT NULL,
	remark text DEFAULT NULL,
	stop int(11) DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	delstate int(11) DEFAULT 1,
	updatetime datetime DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if (!pdo_tableexists(xm_gohome_merchant)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_merchant) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	openid varchar(50) DEFAULT NULL,
	staff_id int(11) DEFAULT NULL,
	merchant_name varchar(100) DEFAULT NULL,
	merchant_mobile varchar(50) DEFAULT NULL,
	password varchar(50) DEFAULT NULL,
	adr_id int(11) DEFAULT NULL,
	lido_id int(11) DEFAULT NULL,
	type_id int(11) DEFAULT NULL,
	coverpic varchar(100) DEFAULT NULL,
	merchant_address varchar(100) DEFAULT NULL,
	lng varchar(100) DEFAULT NULL,
	lat varchar(100) DEFAULT NULL,
	adrstr varchar(100) DEFAULT NULL,
	merchant_phone varchar(100) DEFAULT NULL,
	merchant_time varchar(100) DEFAULT NULL,
	merchant_timelong float DEFAULT NULL,
	merchant_price varchar(100) DEFAULT NULL,
	merchant_song varchar(100) DEFAULT NULL,
	night int(11) DEFAULT NULL,
	license varchar(100) DEFAULT NULL,
	license_pic varchar(100) DEFAULT NULL,
	stop int(11) DEFAULT NULL,
	top1 int(11) DEFAULT 0,
	top2 int(11) DEFAULT 0,
	top3 int(11) DEFAULT 0,
	xing int(11) DEFAULT 0,
	fxing int(11) DEFAULT 0,
	person int(11) DEFAULT 0,
	ordersum int(11) DEFAULT 0,
	flag int(11) DEFAULT 0,
	state int(11) DEFAULT NULL,
	shuoming varchar(300) DEFAULT NULL,
	stime varchar(50) DEFAULT NULL,
	delstate int(11) DEFAULT 1,
	gettype int(11) DEFAULT 0,
	bili_bai float DEFAULT 0,
	bili_money DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	start DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	end DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	updatetime datetime DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if (!pdo_tableexists(xm_gohome_menu)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_menu) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	merchant_id int(11) DEFAULT NULL,
	menu_name varchar(100) DEFAULT NULL,
	top int(11) DEFAULT NULL,
	allsum int(11) DEFAULT 0,
	stop int(11) DEFAULT 1,
	delstate int(11) DEFAULT 1,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	updatetime datetime DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if (!pdo_tableexists(xm_gohome_curry)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_curry) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	merchant_id int(11) DEFAULT NULL,
	menu_id int(11) DEFAULT NULL,
	curry_name varchar(100) DEFAULT NULL,
	pic varchar(100) DEFAULT NULL,
	price float DEFAULT NULL,
	top int(11) DEFAULT NULL,
	stop int(11) DEFAULT 1,
	allsum int(11) DEFAULT 0,
	zan int(11) DEFAULT 0,
	delstate int(11) DEFAULT 1,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	updatetime datetime DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

///添加菜单
$arr = pdo_fetchall("SELECT eid FROM ".tablename('modules_bindings')." WHERE module='xm_gohome' AND entry='menu' AND title='商铺管理' AND do='takeout'");
if(count($arr) == 0){
	pdo_query("insert into ".tablename('modules_bindings')." (module,entry,title,do,direct) values ('xm_gohome','menu','商铺管理','takeout',0)");
}

//2016年5月19日15:49:25
if (!pdo_tableexists(xm_gohome_takeorder)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_takeorder) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	merchantid int(11) DEFAULT NULL,
	orderid varchar(50) DEFAULT NULL,
	openid varchar(100) DEFAULT NULL,
	amount DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	quantity int(11) DEFAULT NULL,
	song DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	state int(11) DEFAULT NULL,
	paytype int(11) DEFAULT NULL,
	realname varchar(100) DEFAULT NULL,
	mobile varchar(200) DEFAULT NULL,
	sex varchar(50) DEFAULT NULL,
	address varchar(100) DEFAULT NULL,
	ctime int(11) DEFAULT NULL,
	otime int(11) DEFAULT NULL,
	ptime1 int(11) DEFAULT NULL,
	ptime2 int(11) DEFAULT NULL,
	gtime int(11) DEFAULT NULL,
	stime int(11) DEFAULT NULL,
	htime int(11) DEFAULT NULL,
	rtime int(11) DEFAULT NULL,
	dtime int(11) DEFAULT NULL,
	remark varchar(300) DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if (!pdo_tableexists(xm_gohome_takeorderitem)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_takeorderitem) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	orderid varchar(50) DEFAULT NULL,
	curryid int(11) DEFAULT NULL,
	quantity int(11) DEFAULT NULL,
	price DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	ctime int(11) DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

//2016年5月24日15:57:00
if (!pdo_tableexists(xm_gohome_takeaddress)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_takeaddress) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	openid varchar(100) DEFAULT NULL,
	realname varchar(100) DEFAULT NULL,
	sex int(11) DEFAULT 1,
	mobile varchar(100) DEFAULT NULL,
	adr_city varchar(100) DEFAULT NULL,
	adr_room varchar(100) DEFAULT NULL,
	type int(11) DEFAULT NULL,
	ctime varchar(100) DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

//2016年5月26日18:59:07
if(!pdo_fieldexists(xm_gohome_comment,  merchantid)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_comment)." ADD `merchantid` int(11) DEFAULT 0;");
}
if(!pdo_fieldexists(xm_gohome_comment,  ordernumber)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_comment)." ADD `ordernumber` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists(xm_gohome_comment,  grade)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_comment)." ADD `grade` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists(xm_gohome_comment,  fxing)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_comment)." ADD `fxing` int(11) DEFAULT 0;");
}
if(!pdo_fieldexists(xm_gohome_comment,  type)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_comment)." ADD `type` varchar(50) DEFAULT NULL;");
}

//2016年5月30日16:37:39
if (!pdo_tableexists(xm_gohome_takepaylog)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_takepaylog) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	openid varchar(50) DEFAULT NULL,
	merchant_id int(11) DEFAULT NULL,
	money DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	orderid varchar(50) DEFAULT NULL,
	type varchar(50) DEFAULT NULL,
	paytype int(11) DEFAULT NULL,
	getmoney DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	state int(11) DEFAULT 0,
	suanstate int(11) DEFAULT 0,
	fastate int(11) DEFAULT 0,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if(!pdo_fieldexists(xm_gohome_tempmessagedefault,  ttmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tempmessagedefault)." ADD `ttmpmsg_id` int(11) DEFAULT null;");
}

if(!pdo_fieldexists(xm_gohome_tempmessagedefault,  utmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tempmessagedefault)." ADD `utmpmsg_id` int(11) DEFAULT null;");
}

//2016年5月31日11:34:02
if (!pdo_tableexists(xm_gohome_takegetlog)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_takegetlog) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	merchantid int(11) DEFAULT NULL,
	orderid varchar(50) DEFAULT NULL,
	money DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	ctime int(11) DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

//2016年6月1日10:26:35
if (!pdo_tableexists(xm_gohome_commentreply)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_commentreply) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	cid int(11) DEFAULT NULL,
	reply text DEFAULT NULL,
	ctime int(11) DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if (!pdo_tableexists(xm_gohome_takekeep)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_takekeep) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	merchantid int(11) DEFAULT NULL,
	openid varchar(100) DEFAULT NULL,
	ctime int(11) DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

//2016年6月2日11:21:31
if(!pdo_fieldexists(xm_gohome_order,  ordernumber)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_order)." ADD `ordernumber` varchar(100) DEFAULT null;");
}

if(!pdo_fieldexists(xm_gohome_staff,  shuoming)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `shuoming` varchar(200) DEFAULT null;");
}
if(!pdo_fieldexists(xm_gohome_staff,  stime)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `stime` varchar(100) DEFAULT null;");
}
if(!pdo_fieldexists(xm_gohome_staff,  merchant_state)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `merchant_state` int(1) DEFAULT 0;");
}

//2016年6月8日11:51:23
if (!pdo_tableexists(xm_gohome_zanlog)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_zanlog) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	openid varchar(100) DEFAULT NULL,
	curry_id int(11) DEFAULT NULL,
	ctime int(11) DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

//添加菜单
$arr = pdo_fetchall("SELECT eid FROM ".tablename('modules_bindings')." WHERE module='xm_gohome' AND entry='menu' AND title='地区管理' AND do='address'");
if(count($arr) == 0){
	pdo_query("insert into ".tablename('modules_bindings')." (module,entry,title,do,direct) values ('xm_gohome','menu','地区管理','address',0)");
}

$arr = pdo_fetchall("SELECT eid FROM ".tablename('modules_bindings')." WHERE module='xm_gohome' AND entry='menu' AND title='商铺类别' AND do='type'");
if(count($arr) == 0){
	pdo_query("insert into ".tablename('modules_bindings')." (module,entry,title,do,direct) values ('xm_gohome','menu','商铺类别','type',0)");
}

$arr = pdo_fetchall("SELECT eid FROM ".tablename('modules_bindings')." WHERE module='xm_gohome' AND entry='menu' AND title='商圈管理' AND do='lido'");
if(count($arr) == 0){
	pdo_query("insert into ".tablename('modules_bindings')." (module,entry,title,do,direct) values ('xm_gohome','menu','商圈管理','lido',0)");
}

//2016年6月13日10:33:52
if(!pdo_fieldexists(xm_gohome_tempmessagedefault,  ctmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tempmessagedefault)." ADD `ctmpmsg_id` int(11) DEFAULT null;");
}
if(!pdo_fieldexists(xm_gohome_tempmessagedefault,  mtmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tempmessagedefault)." ADD `mtmpmsg_id` int(11) DEFAULT null;");
}

if(!pdo_fieldexists(xm_gohome_userfrontlog,  type)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_userfrontlog)." ADD `type` varchar(50) DEFAULT null;");
}

//2016年6月14日11:56:47
if(!pdo_fieldexists(xm_gohome_rechargelog,  staff_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_rechargelog)." ADD `staff_id` int(11) DEFAULT null;");
}

if(!pdo_fieldexists(xm_gohome_message,  code_content)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `code_content` varchar(300) DEFAULT null;");
}
if(!pdo_fieldexists(xm_gohome_message,  pai_content)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `pai_content` text DEFAULT null;");
}
if(!pdo_fieldexists(xm_gohome_message,  message4)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `message4` int(11) DEFAULT null;");
}
if(!pdo_fieldexists(xm_gohome_message,  message4_content)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `message4_content` text DEFAULT null;");
}

//2016-6-16 11:56:28
if(!pdo_fieldexists(xm_gohome_base,  ak)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `ak` varchar(50) DEFAULT null;");
}

//2016年6月20日17:03:47
if(!pdo_fieldexists(xm_gohome_base,  catch_bg)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `catch_bg` varchar(100) DEFAULT null;");
}

//2016年6月21日11:16:21
pdo_query("ALTER TABLE ".tablename('xm_gohome_staff')." modify `money` DECIMAL(10,2) DEFAULT 0.00");

if(!pdo_fieldexists(xm_gohome_order,  front)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_order)." ADD `front` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00;");
}

//2016年6月23日16:27:28
if(!pdo_fieldexists(xm_gohome_base,  takeout_icon)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `takeout_icon` nvarchar(100) default null;");
}
if(!pdo_fieldexists(xm_gohome_base,  icon_name)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `icon_name` nvarchar(100) default '外卖服务';");
}

//2016年6月24日15:29:09

if(!pdo_fieldexists(xm_gohome_curry,  barcode_number)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_curry)." ADD `barcode_number` varchar(100) DEFAULT NULL;");
}

//2016年6月28日10:44:51
if (!pdo_tableexists(xm_gohome_companygetmoney_merchant)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_companygetmoney_merchant) . "  ( 
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	merchant_id int(11) DEFAULT NULL,
	orderid varchar(100) DEFAULT NULL,
	getmoney DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	type int(11) DEFAULT NULL,
	way int(11) DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if (!pdo_tableexists(xm_gohome_tixianlog_merchant)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_tixianlog_merchant) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	openid varchar(100) DEFAULT NULL,
	money DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	start varchar(100) DEFAULT NULL,
	end varchar(100) DEFAULT NULL,
	yumoney DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	famoney DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	merchant_id int(11) DEFAULT NULL,
	state int(11) DEFAULT 0,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

pdo_query("update ".tablename('modules_bindings')." set title='超级管理' where module='xm_gohome' and entry='menu' and do='version'");
pdo_query("delete from ".tablename('modules_bindings')." where title='运营管理' and module='xm_gohome' and entry='menu' and do='running'");

if(!pdo_fieldexists(xm_gohome_base,  type)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `type` int(11) default 0");
}
if(!pdo_fieldexists(xm_gohome_base,  type_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `type_id` nvarchar(100) default null;");
}

//2016年6月29日10:39:32
if (!pdo_tableexists(xm_gohome_needorder)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_needorder) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	orderid varchar(100) DEFAULT NULL,
	openid varchar(100) DEFAULT NULL,
	realname varchar(100) DEFAULT NULL,
	gender int(11) DEFAULT NULL,
	mobile varchar(100) DEFAULT NULL,
	random varchar(100) DEFAULT NULL,
	address varchar(100) DEFAULT NULL,
	curry_name varchar(100) DEFAULT NULL,
	yuprice DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
	size varchar(100) DEFAULT NULL,
	gettime varchar(100) DEFAULT NULL,
	remark text DEFAULT NULL,
	state int(11) DEFAULT NULL,
	merchant_id int(11) DEFAULT 0,
	selecttime varchar(100) DEFAULT NULL,
	lat varchar(100) DEFAULT NULL,
	lng varchar(100) DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if(!pdo_fieldexists(xm_gohome_curry,  remark)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_curry)." ADD `remark` text default null");
}
if(!pdo_fieldexists(xm_gohome_curry,  adrstr)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_curry)." ADD `adrstr` varchar(100) default null");
}

if (!pdo_tableexists(xm_gohome_needmsglog)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_needmsglog) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	merchant_id int(11) DEFAULT NULL,
	ordernumber varchar(100) DEFAULT NULL,
	order_id int(11) DEFAULT NULL,
	state int(11) DEFAULT 0,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	selectedtime varchar(100) DEFAULT NULL,
	PRIMARY KEY (id) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if(!pdo_fieldexists(xm_gohome_tempmessagedefault,  needtmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tempmessagedefault)." ADD `needtmpmsg_id` int(11) DEFAULT null;");
}
if(!pdo_fieldexists(xm_gohome_tempmessagedefault,  grabtmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tempmessagedefault)." ADD `grabtmpmsg_id` int(11) DEFAULT null;");
}
if(!pdo_fieldexists(xm_gohome_tempmessagedefault,  quetmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tempmessagedefault)." ADD `quetmpmsg_id` int(11) DEFAULT null;");
}

if(!pdo_fieldexists(xm_gohome_needorder,  barcode_number)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_needorder)." ADD `barcode_number` varchar(100) DEFAULT null;");
}

//2016年6月29日 22:26:28
if(!pdo_fieldexists(xm_gohome_merchant,  new_disc)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_merchant)." ADD `new_disc` int(11) DEFAULT 0;");
}
if(!pdo_fieldexists(xm_gohome_merchant,  man1_disc)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_merchant)." ADD `man1_disc` int(11) DEFAULT 0;");
}
if(!pdo_fieldexists(xm_gohome_merchant,  man2_disc)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_merchant)." ADD `man2_disc` int(11) DEFAULT 0;");
}
if(!pdo_fieldexists(xm_gohome_merchant,  man3_disc)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_merchant)." ADD `man3_disc` int(11) DEFAULT 0;");
}
if(!pdo_fieldexists(xm_gohome_merchant,  disc)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_merchant)." ADD `disc` int(11) DEFAULT 0;");
}

if (!pdo_tableexists(xm_gohome_activity)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_activity) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	merchant_id int(11) DEFAULT NULL,
	new_disc float DEFAULT NULL,
	man_1 float DEFAULT NULL,
	jian_1 float DEFAULT NULL,
	man_2 float DEFAULT NULL,
	jian_2 float DEFAULT NULL,
	man_3 float DEFAULT NULL,
	jian_3 float DEFAULT NULL,
	disc float DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if(!pdo_fieldexists(xm_gohome_curry,  zhe)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_curry)." ADD `zhe` int(11) default 0");
}

if(!pdo_fieldexists(xm_gohome_takeorder,  normal)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_takeorder)." ADD `normal` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0.00;");
}

//2016年6月30日10:25:23
if(!pdo_fieldexists(xm_gohome_message,  tempid)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `tempid` varchar(100) DEFAULT null;");
}

if (!pdo_tableexists(xm_gohome_needgrab)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_needgrab) . "  (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) NOT NULL,
	openid varchar(100) DEFAULT NULL,
	order_id int(11) DEFAULT NULL,
	merchant_id int(11) DEFAULT NULL,
	offer varchar(100) DEFAULT NULL,
	random int(11) DEFAULT NULL,
	remark text DEFAULT NULL,
	selected int(11) DEFAULT 0,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	selectedtime nvarchar(100) DEFAULT NULL,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if(!pdo_fieldexists(xm_gohome_needorder,  curry_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_needorder)." ADD `curry_id` int(11) DEFAULT NULL;");
}

if(!pdo_fieldexists(xm_gohome_needorder,  paytime)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_needorder)." ADD `paytime` varchar(100) DEFAULT NULL;");
}

if(!pdo_fieldexists(xm_gohome_menu,  currysum)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_menu)." ADD `currysum` int(11) DEFAULT 0;");
}

//2016年7月6日11:54:40
if(!pdo_fieldexists(xm_gohome_order,  fname)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_order)." ADD `fname` varchar(100) DEFAULT NULL;");
}

if(!pdo_fieldexists(xm_gohome_order,  fmobile)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_order)." ADD `fmobile` varchar(100) DEFAULT NULL;");
}

//2016年7月7日11:00:20
if(!pdo_fieldexists(xm_gohome_address,  delstate)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_address)." ADD `delstate` int(11) DEFAULT 1;");
}

$getzd = pdo_fetch("show columns from ".tablename('xm_gohome_merchant')." like 'mobile'");
if(!empty($getzd)){
	pdo_query("ALTER TABLE ".tablename(xm_gohome_merchant)." change mobile merchant_mobile varchar(100) DEFAULT NULL;");
}

//2016年7月8日11:15:02
if(!pdo_fieldexists(xm_gohome_staff,  indextop)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_staff)." ADD `indextop` int(11) DEFAULT 0;");
}

//2016年7月11日15:56:20
if(!pdo_fieldexists(xm_gohome_message,  pai_tempid)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `pai_tempid` varchar(100) DEFAULT NULL;");
}

if(!pdo_fieldexists(xm_gohome_message,  msg1_tempid)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `msg1_tempid` varchar(100) DEFAULT NULL;");
}

if(!pdo_fieldexists(xm_gohome_message,  msg2_tempid)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `msg2_tempid` varchar(100) DEFAULT NULL;");
}

if(!pdo_fieldexists(xm_gohome_message,  msg3_tempid)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `msg3_tempid` varchar(100) DEFAULT NULL;");
}

if(!pdo_fieldexists(xm_gohome_message,  msg4_tempid)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `msg4_tempid` varchar(100) DEFAULT NULL;");
}

if(!pdo_fieldexists(xm_gohome_curry,  images)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_curry)." ADD `images` varchar(500) DEFAULT NULL;");
}

//2016年7月14日17:10:18
if(!pdo_fieldexists(xm_gohome_message,  selected)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `selected` int(11) DEFAULT NULL;");
}

//2016年7月15日14:05:38
if(!pdo_fieldexists(xm_gohome_message,  message5)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `message5` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists(xm_gohome_message,  msg5_tempid)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `msg5_tempid` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists(xm_gohome_message,  message5_content)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_message)." ADD `message5_content` varchar(500) DEFAULT NULL;");
}

//2016年7月18日15:37:17
pdo_query("update ".tablename('modules_bindings')." set title='参数设置' where module='xm_gohome' and entry='menu' and do='base' and title='基础数据'");

pdo_query("delete from ".tablename('modules_bindings')." where module='xm_gohome' and entry='menu' and do='question' and title='常见问题'");

pdo_query("delete from ".tablename('modules_bindings')." where module='xm_gohome' and entry='menu' and do='shuoming' and title='服务说明'");

pdo_query("delete from ".tablename('modules_bindings')." where module='xm_gohome' and entry='menu' and do='address' and title='地区管理'");

pdo_query("delete from ".tablename('modules_bindings')." where module='xm_gohome' and entry='menu' and do='type' and title='商铺类别'");

pdo_query("delete from ".tablename('modules_bindings')." where module='xm_gohome' and entry='menu' and do='lido' and title='商圈管理'");

pdo_query("delete from ".tablename('modules_bindings')." where module='xm_gohome' and entry='menu' and do='blacklist' and title='黑名单管理'");

//2016年7月19日15:43:29
pdo_query("ALTER TABLE ".tablename('xm_gohome_servetype')." modify `remark` text");

//协议
if (!pdo_tableexists(xm_gohome_xieyi)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_xieyi) . " (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) DEFAULT NULL,
	type int(11) DEFAULT NULL,
	xieyi_content text DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

//2016年7月20日18:01:16
if(!pdo_fieldexists(xm_gohome_moneylog,  type)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_moneylog)." ADD `type` varchar(100) DEFAULT NULL;");
}

//2016年7月22日15:47:45
if(!pdo_fieldexists(xm_gohome_tempmessagedefault,  suretmpmsg_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_tempmessagedefault)." ADD `suretmpmsg_id` int(11) DEFAULT null;");
}

if(!pdo_fieldexists(xm_gohome_needorder,  delstate)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_needorder)." ADD `delstate` int(11) DEFAULT 1;");
}

//2016年7月29日14:28:25
if(!pdo_fieldexists(xm_gohome_servetype,  jianshu)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_servetype)." ADD `jianshu` text DEFAULT NULL;");
}

if (!pdo_tableexists(xm_gohome_bank)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_bank) . "  (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) DEFAULT NULL,
	bank_name varchar(100) DEFAULT NULL,
	pic varchar(100) DEFAULT NULL,
	top int(11) DEFAULT 0,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if (!pdo_tableexists(xm_gohome_members)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_members) . "  (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) DEFAULT NULL,
	openid varchar(100) DEFAULT NULL,
	nickname varchar(100) DEFAULT NULL,
	realname varchar(100) DEFAULT NULL,
	mobile varchar(100) DEFAULT NULL,
	title varchar(100) DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if (!pdo_tableexists(xm_gohome_banklog)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_banklog) . "  (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) DEFAULT NULL,
	YURREF varchar(100) DEFAULT NULL,
	DBTACC varchar(100) DEFAULT NULL,
	DBTBBK varchar(100) DEFAULT NULL,
	TRSAMT varchar(100) DEFAULT NULL,
	NUSAGE varchar(100) DEFAULT NULL,
	CRTACC varchar(100) DEFAULT NULL,
	CRTNAM varchar(100) DEFAULT NULL,
	BNKFLG varchar(100) DEFAULT NULL,
	CRTBNK varchar(100) DEFAULT NULL,
	success varchar(100) DEFAULT NULL,
	message varchar(100) DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}


//2016年8月3日14:58:43
if(!pdo_fieldexists(xm_gohome_base,  qq_ak)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `qq_ak` varchar(50) DEFAULT NULL;");
}

//2016年8月5日16:24:15
if(!pdo_fieldexists(xm_gohome_order,  address)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_order)." ADD `address` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists(xm_gohome_order,  lou)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_order)." ADD `lou` varchar(100) DEFAULT NULL;");
}

//2016年8月9日10:31:29

if (!pdo_tableexists(xm_gohome_indextemp)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_indextemp) . "  (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) DEFAULT NULL,
	html text DEFAULT NULL,
	updatetime varchar(100) DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

$arr = pdo_fetchall("SELECT eid FROM ".tablename('modules_bindings')." WHERE module='xm_gohome' AND entry='menu' AND title='首页模板' AND do='indextemp'");
if(count($arr) == 0){
	pdo_query("insert into ".tablename('modules_bindings')." (module,entry,title,do,direct) values ('xm_gohome','menu','首页模板','indextemp',0)");
}

//2016年8月10日09:44:39
if(!pdo_fieldexists(xm_gohome_base,  pay)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `pay` int(11) DEFAULT 0;");
}
if(!pdo_fieldexists(xm_gohome_base,  appid)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `appid` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists(xm_gohome_base,  mch_id)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `mch_id` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists(xm_gohome_base,  apikey)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `apikey` varchar(50) DEFAULT NULL;");
}

if (!pdo_tableexists(xm_gohome_wxpaylog)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_wxpaylog) . "  (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) DEFAULT NULL,
	transaction_id varchar(100) DEFAULT NULL,
	updatetime varchar(100) DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

//2016年8月17日10:00:07
if(!pdo_fieldexists(xm_gohome_merchant,  chao)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_merchant)." ADD `chao` int(11) DEFAULT 0;");
}

if(!pdo_fieldexists(xm_gohome_merchant,  chao_url)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_merchant)." ADD `chao_url` varchar(50) DEFAULT NULL;");
}

if(!pdo_fieldexists(xm_gohome_temp,  moren)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_temp)." ADD `moren` int(11) DEFAULT 0;");
}

//2016年8月26日14:23:50
pdo_query("update ".tablename('modules')." set version='3.43' where name='xm_gohome' and type='business'");

if (!pdo_tableexists(xm_gohome_adrstr)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_adrstr) . "  (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) DEFAULT NULL,
	adrstr varchar(100) DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

//2016年8月30日10:49:39
pdo_query("update ".tablename('modules_bindings')." set title='个性化设置' where module='xm_gohome' and entry='menu' and do='indextemp' and title='首页模板'");

if(!pdo_fieldexists(xm_gohome_adrstr,  lat)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_adrstr)." ADD `lat` varchar(100) DEFAULT NULL;");
}

if(!pdo_fieldexists(xm_gohome_adrstr,  lng)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_adrstr)." ADD `lng` varchar(100) DEFAULT NULL;");
}

//2016年9月1日11:34:08
if (!pdo_tableexists(xm_gohome_nav)) {
	pdo_query("CREATE TABLE " . tablename(xm_gohome_nav) . "  (
	id int(11) NOT NULL AUTO_INCREMENT,
	weid int(11) DEFAULT NULL,
	nav1 varchar(50) DEFAULT NULL,
	nav2 varchar(50) DEFAULT NULL,
	nav3 varchar(50) DEFAULT NULL,
	nav4 varchar(50) DEFAULT NULL,
	updatetime varchar(50) DEFAULT NULL,
	addtime timestamp NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id) ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
	);
}

if(!pdo_fieldexists(xm_gohome_base,  search)) {
	pdo_query("ALTER TABLE ".tablename(xm_gohome_base)." ADD `search` int(11) DEFAULT 1;");
}



}