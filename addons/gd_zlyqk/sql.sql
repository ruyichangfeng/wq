CREATE TABLE `ims_gd_staffcol` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(145) NOT NULL,
  `type` VARCHAR(45) NOT NULL,
  `status` INT NULL DEFAULT 1,
  `create_time` INT NULL,
  `sort` VARCHAR(45) NULL DEFAULT '1',
  `val` VARCHAR(445) NULL,
  `uniacid` INT NULL DEFAULT 0,
  PRIMARY KEY (`id`));

  ALTER TABLE `ims_gd_article`
ADD COLUMN `icon` VARCHAR(445) NULL ;


CREATE TABLE `ims_gd_staffext` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NOT NULL DEFAULT 0,
  `uid` INT NOT NULL,
  `member_id` INT NOT NULL,
  `member_name` VARCHAR(145) NULL,
  `name` VARCHAR(145) NULL,
  `mobile` VARCHAR(45) NULL,
  `ext` VARCHAR(1045) NULL,
  `create_time` INT NULL DEFAULT 0,
  `avatar` VARCHAR(445) NULL,
  `status` INT NULL DEFAULT 1,
  PRIMARY KEY (`id`));




CREATE TABLE `ims_gd_zlk` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NOT NULL DEFAULT 0,
  `name` VARCHAR(145) NOT NULL,
  `status` INT NULL DEFAULT 1,
  `create_time` INT NULL DEFAULT 0,
  `category` INT NULL DEFAULT 0,
  `category_name` VARCHAR(145) NULL,
  `desc` TEXT NULL,
  `table` VARCHAR(200) NULL,
  `xml` TEXT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `ims_gd_zlx` (
`id` INT NOT NULL AUTO_INCREMENT,
`uniacid` INT NOT NULL,
`name` VARCHAR(145) NOT NULL,
`status` INT NULL DEFAULT 1,
`create_time` INT NULL,
PRIMARY KEY (`id`));

--------------5.09-------------
CREATE TABLE `ims_gd_zlx` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NOT NULL,
  `name` VARCHAR(145) NOT NULL,
  `status` INT NULL DEFAULT 1,
  `create_time` INT NULL,
  PRIMARY KEY (`id`));

--------------5.08-------------
CREATE TABLE `ims_gd_member_ext` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NULL DEFAULT 0,
  `name` VARCHAR(100) NOT NULL,
  `sort` INT NULL DEFAULT 1,
  `xml` TEXT NULL,
  `create_time` INT NULL DEFAULT 0,
  `status` INT NULL DEFAULT 1,
  PRIMARY KEY (`id`));

ALTER TABLE `ims_gd_app` ADD `per_num` INT NOT NULL DEFAULT '0' ;

--------------5.01-------------
CREATE TABLE `ims_gd_images` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NOT NULL,
  `name` VARCHAR(245) NULL,
  `thumb` VARCHAR(445) NULL,
  `type` VARCHAR(445) NULL,
  `url` VARCHAR(45) NULL,
  `create_time` INT NULL,
  `status` INT NULL DEFAULT 1,
  PRIMARY KEY (`id`));

-------------4.05--------------
ALTER TABLE `ims_gd_node` ADD `xml_id` VARCHAR(50) NOT NULL, ADD `type` INT NOT NULL DEFAULT '1' ;
ALTER TABLE `ims_gd_node` ADD `ship` VARCHAR(2000) NOT NULL ;
ALTER TABLE `ims_gd_flow` ADD `line` TEXT NOT NULL ;
ALTER TABLE `ims_gd_flow` ADD `task` TEXT NOT NULL ;

ALTER TABLE `ims_gd_pool` ADD `before_node` INT NOT NULL DEFAULT '0' ;
ALTER TABLE `ims_gd_pool` ADD `before_line` VARCHAR(50) NOT NULL ;

ALTER TABLE `ims_gd_deal` ADD `line_id` VARCHAR(50) NOT NULL ;
ALTER TABLE `ims_gd_app` ADD `menu` INT NOT NULL DEFAULT '1' ;

ALTER TABLE `ims_gd_app` ADD `cond` INT NOT NULL DEFAULT '0' , ADD `cond_num` INT NOT NULL DEFAULT '0' ;
-------------4.0.4--------------
CREATE TABLE `ims_gd_label` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NOT NULL DEFAULT 0,
  `label_name` VARCHAR(300) NOT NULL,
  `status` INT NULL DEFAULT 1,
  `create_time` INT NULL DEFAULT 0,
  PRIMARY KEY (`id`));

ALTER TABLE `ims_gd_member`
ADD COLUMN `label` INT NULL DEFAULT 0 AFTER `admin_id`;

-------------4.0.2---------------
ALTER TABLE `ims_gd_app` ADD `cond` INT NOT NULL DEFAULT '0' , ADD `cond_num` INT NOT NULL DEFAULT '0' ;
-------------4.0.1---------------
ALTER TABLE `ims_gd_app` ADD `mods` INT(7) NOT NULL DEFAULT '1';

-------------4.0---------------
ALTER TABLE `ims_gd_app` ADD `department` VARCHAR(400) NOT NULL;
ALTER TABLE `ims_gd_pool` ADD `is_form` INT NOT NULL DEFAULT '0' ;

-------------3.14----------------
CREATE TABLE `ims_gd_preline` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NULL DEFAULT 0,
  `flow_id` INT NULL DEFAULT 0,
  `line_id` VARCHAR(145) NULL DEFAULT '',
  `form_list` TEXT NULL,
  `create_time` INT NULL DEFAULT 0,
  `status` INT NULL DEFAULT 1,
  PRIMARY KEY (`id`));

-------------3.04----------------
ALTER TABLE `ims_gd_app` ADD `sorter` INT NOT NULL DEFAULT '0';
-------------3.3------------------
CREATE TABLE `ims_gd_ld` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NOT NULL,
  `name` VARCHAR(445) NOT NULL,
  `parent_id` INT NOT NULL,
  `des` VARCHAR(4445) NULL,
  `create_time` INT NULL,
  `status` INT NULL DEFAULT 1,
  PRIMARY KEY (`id`));

INSERT INTO `ims_gd_element` (`id`, `name`, `type`, `create_time`, `status`, `el_name`, `flow_id`) VALUES (0, 'ld', '100', '0', '1', '联动', '0');

-------------3.2-------------------
ALTER TABLE `ims_gd_app`
  ADD `back` INT NULL DEFAULT '0' ,
  ADD `cancel` INT NOT NULL DEFAULT '0' ;

CREATE TABLE `ims_gd_cancel` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NOT NULL,
  `app_id` INT NOT NULL,
  `pool_id` INT NOT NULL,
  `recorder_id` INT NOT NULL,
  `node_id` INT NOT NULL,
  `node_name` VARCHAR(145) NOT NULL,
  `member_id` INT NULL DEFAULT 0,
  `member_name` VARCHAR(145) NULL,
  `create_time` INT NULL DEFAULT 0,
  `status` INT NULL DEFAULT 1,
  PRIMARY KEY (`id`));
-------------3.0--------------------
CREATE TABLE  `ims_gd_acc` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NULL,
  `acc_name` VARCHAR(145) NULL DEFAULT '',
  `acc` TEXT NULL,
  `status` INT NULL DEFAULT 0,
  `create_time` INT NULL DEFAULT 0,
  PRIMARY KEY (`id`));

ALTER TABLE `ims_gd_department`
  ADD COLUMN `acc_id` INT NULL ;

ALTER TABLE `ims_gd_order`
  ADD `pool_id` INT NOT NULL ,
  ADD `staff_msg` TEXT NOT NULL ,
  ADD `member_msg` TEXT NOT NULL;
ALTER TABLE `ims_gd_pool`
  ADD `need_pay` INT NOT NULL DEFAULT '0' ,
  ADD `pay_money` VARCHAR(10) NOT NULL,
  ADD `order_id` INT NOT NULL ;
ALTER TABLE `ims_gd_order`
  ADD `data` TEXT NOT NULL ,
  ADD `fms` INT NOT NULL DEFAULT '1' ,
  ADD `who_list` VARCHAR(1000) NOT NULL ;

------------------------------------
ALTER TABLE `ims_gd_pool`
ADD COLUMN `is_abort`  DEFAULT 0 ;

CREATE TABLE `ims_gd_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NOT NULL,
  `name` VARCHAR(145) NOT NULL,
  `create_time` INT NULL,
  `status` INT NULL DEFAULT 1,
  PRIMARY KEY (`id`));

  CREATE TABLE `ims_gd_property` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NOT NULL,
  `name` VARCHAR(145) NOT NULL,
  `pay` DECIMAL(12,1) NULL DEFAULT 0,
  `notice` VARCHAR(450) NULL DEFAULT '',
  `status` INT NULL DEFAULT 1,
  `create_time` INT NULL DEFAULT 0,
  PRIMARY KEY (`id`));

ALTER TABLE `ims_gd_app`
ADD COLUMN `category` INT NULL DEFAULT 0 ,
ADD COLUMN `property` VARCHAR(1000) NULL DEFAULT '' ;

ALTER TABLE `ims_gd_pool`
ADD COLUMN `category` INT NULL DEFAULT 0 ,
ADD COLUMN `property` INT NULL DEFAULT 0 ;
ALTER TABLE `ims_gd_pool`
ADD COLUMN `app_pay` DECIMAL(12,1) NULL DEFAULT 0 ;

CREATE TABLE `ims_gd_article` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uniacid` INT NULL,
  `is_admin` INT NULL DEFAULT 0,
  `admin_group` VARCHAR(300) NULL DEFAULT '',
  `title` VARCHAR(1000) NULL DEFAULT '',
  `from` VARCHAR(1000) NULL DEFAULT '',
  `desc` TEXT NULL,
  `content` TEXT NULL,
  `create_time` INT NULL DEFAULT 0,
  `gone_time` INT NULL DEFAULT 0,
  `status` INT NULL DEFAULT 1,
  PRIMARY KEY (`id`));

  ALTER TABLE `ims_gd_article` ADD `public` VARCHAR(1000) NOT NULL;

  ALTER TABLE `ims_gd_article`
ADD COLUMN `is_default` INT NULL DEFAULT 0;

ALTER TABLE `ims_gd_app`
ADD COLUMN `is_show` INT NULL DEFAULT 1 ;








