<?php
/**
 * Created by PhpStorm.
 * User: sks
 * Date: 16/9/1
 * Time: 上午9:52
 */
defined("IN_IA") or exit("Access Denied");
//if(!pdo_tableexists("qw_microedu_consultant")){
//    pdo_query(
//        "CREATE TABLE `ims_qw_microedu_consultant` (
//        `id` int(11) NOT NULL AUTO_INCREMENT,
//        `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
//        `nickname` varchar(255) DEFAULT NULL COMMENT '昵称',
//        `username` varchar(255) DEFAULT NULL COMMENT '姓名',
//        `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
//        `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT ' 性别 1男,2女,3其他',
//        `openid` varchar(255) DEFAULT NULL COMMENT '微信用户openid',
//        `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1为正常',
//        `uniacid` int(11) DEFAULT NULL,
//        `consultantgroup_id` int(11) DEFAULT NULL,
//        PRIMARY KEY (`id`)
//        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
//    );
//}
//if(!pdo_fieldexists("qw_microedu_consultant","addtime")){
//    pdo_query(
//        "ALTER TABLE `ims_qw_microedu_consultant` ADD `addtime` int(11) NOT NULL DEFAULT '0';"
//    );
//}
////顾问组表
//if(!pdo_tableexists("qw_micro_consultantgroups")){
//    pdo_query(
//      "CREATE TABLE `ims_qw_microedu_consultantgroups` (
//          `id` int(11) NOT NULL AUTO_INCREMENT,
//          `uniacid` int(11) DEFAULT NULL,
//          `leader_id` int(11) DEFAULT NULL,
//          PRIMARY KEY (`id`)
//          ) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
//    );
//}

