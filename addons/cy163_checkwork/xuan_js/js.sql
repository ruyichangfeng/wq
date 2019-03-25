SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
CREATE TABLE IF NOT EXISTS `ims_xuan_js_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `thumb` varchar(255) NOT NULL COMMENT '分类图片',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `sheding` text,
  `description` varchar(500) NOT NULL COMMENT '分类介绍',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;



CREATE TABLE IF NOT EXISTS `ims_xuan_js_fabu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `title` varchar(255) NOT NULL COMMENT '标题名称',
  `amount` int(11) NOT NULL COMMENT '数量',
  `shengyu` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '商品上架状态1为上架',
  `college` varchar(255) NOT NULL COMMENT '书本院系',
  `grade` varchar(255) NOT NULL COMMENT '年级',
  `description` varchar(255) NOT NULL COMMENT '主内容',
  `type` int(11) NOT NULL COMMENT '1为开个价2为免费送',
  `price` decimal(10,2) NOT NULL COMMENT '现价',
  `sprice` varchar(50) NOT NULL COMMENT '免费送的价格',
  `fengmian` varchar(255) NOT NULL COMMENT '封面图片',
  `img` text NOT NULL COMMENT '图片集合',
  `oprice` decimal(10,2) NOT NULL COMMENT '原价',
  `face` tinyint(3) NOT NULL COMMENT '1为开启当面交易',
  `kuaidi` tinyint(3) NOT NULL COMMENT '1为开启快递交易',
  `kuaidifee` decimal(10,2) NOT NULL COMMENT '快递费用',
  `onlinepay` tinyint(3) NOT NULL COMMENT '1位开启在线交易',
  `offlinepay` tinyint(3) NOT NULL COMMENT '1位开启线下交易',
  `weixin` varchar(20) NOT NULL COMMENT '线下交易微信号',
  `phone` varchar(20) NOT NULL COMMENT '手机号',
  `fenlei1` varchar(20) NOT NULL COMMENT '大分类',
  `fenlei2` varchar(20) NOT NULL COMMENT 'fenlei',
  `createtime` varchar(20) NOT NULL COMMENT 'fabu时间',
  `updatetime` varchar(20) NOT NULL COMMENT '更新时间',
  `view` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

CREATE TABLE IF NOT EXISTS `ims_xuan_js_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` varchar(200) NOT NULL COMMENT '订单编号',
  `uid` int(11) DEFAULT '0' COMMENT '购买人id',
  `pingjia1` int(11) NOT NULL DEFAULT '0' COMMENT '购买人评价',
  `pingjia2` int(11) NOT NULL DEFAULT '0' COMMENT '出售人评价',
  `buid` int(11) NOT NULL COMMENT '商品所有人',
  `weixin` varchar(20) DEFAULT '0' COMMENT '购买人微信',
  `wxpay` int(11) NOT NULL,
  `offlinepay` int(11) NOT NULL,
  `zhifu` tinyint(1) DEFAULT '0' COMMENT '是否支付',
  `fid` int(11) DEFAULT '0' COMMENT '商品id',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `kuaidi` int(11) NOT NULL,
  `face` int(11) NOT NULL,
  `kuaidifee` decimal(10,2) NOT NULL,
  `status` varchar(11) DEFAULT '0' COMMENT '订单状态',
  `img` varchar(255) NOT NULL COMMENT '点赞人头像',
  `name` varchar(255) NOT NULL COMMENT '收货人姓名',
  `phone` varchar(255) NOT NULL COMMENT '收货人电话',
  `address` varchar(255) NOT NULL COMMENT '收货人地址',
  `kuaidiname` varchar(20) NOT NULL,
  `danhao` varchar(40) NOT NULL,
  `liuyan` varchar(200) NOT NULL COMMENT '留言内容',
  `createtime` varchar(20) NOT NULL COMMENT 'fabu时间',
  `updatetime` varchar(20) NOT NULL COMMENT '更新时间',
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

CREATE TABLE IF NOT EXISTS `ims_xuan_js_pinglun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT '点赞人uid',
  `nickname` varchar(20) NOT NULL,
  `fid` int(11) DEFAULT '0' COMMENT '商品id',
  `img` varchar(255) NOT NULL COMMENT '点赞人头像',
  `content` varchar(100) NOT NULL COMMENT '评论内容',
  `createtime` varchar(20) NOT NULL COMMENT 'fabu时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

CREATE TABLE IF NOT EXISTS `ims_xuan_js_shoucang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT '用户uid',
  `fid` int(11) DEFAULT '0' COMMENT '商品id',
  `createtime` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

CREATE TABLE IF NOT EXISTS `ims_xuan_js_zan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT '点赞id',
  `fid` int(11) DEFAULT '0' COMMENT '商品id',
  `img` varchar(255) NOT NULL COMMENT '点赞人头像',
  `createtime` varchar(20) NOT NULL COMMENT 'fabu时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

CREATE TABLE IF NOT EXISTS `ims_xuan_js_ziliao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT '用户uid',
  `weixin` varchar(20) DEFAULT '0' COMMENT '购买人微信',
  `phone` varchar(11) DEFAULT '0' COMMENT '手机',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
/********更新chat*********/
CREATE TABLE IF NOT EXISTS `ims_xuan_js_chat` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `from_user_id` int(11) NOT NUll COMMENT '来自uid',
  `to_user_id` int(11) NOT NUll COMMENT '来自uid',
  `readed` tinyint(1) DEFAULT '0' COMMENT '是否已读',
  `type` varchar(20) NOT NUll COMMENT '消息类型',
  `data` text NOT NUll COMMENT '消息内容存json数据',
  `circle_id` varchar(20) NOT NUll COMMENT '消息房间',
  `created_at` varchar(255)
) CHARSET=utf8;
/******举报表*********/
CREATE TABLE IF NOT EXISTS `ims_xuan_js_jubao` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `from_user_id` int(11) NOT NUll COMMENT '举报人uid',
  `goodsid` int(11) NOT NUll COMMENT '举报商品id',
  `avatar` varchar(255) NOT NUll COMMENT '举报人头像',
  `nickname` text NOT NUll COMMENT '举报人昵称',
  `reason` varchar(20) NOT NUll COMMENT '举报类型',.
  `otherreason` varchar(255) NOT NUll COMMENT '举报信息',
  `status` int(3) NOT NUll COMMENT '处理标记',
  `createtime` varchar(255),
  `uniacid` int(11) NOT NULL
) CHARSET=utf8;
/********提现申请**********/
CREATE TABLE IF NOT EXISTS `ims_xuan_js_tixian` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `uid` int(11) NOT NUll COMMENT '提现人uid',
  `money` decimal(10,2) NOT NULL COMMENT '提现金额',
  `avatar` varchar(255) NOT NUll COMMENT '提现人头像',
  `nickname` text NOT NUll COMMENT '提现人昵称',
  `status` int(3) NOT NUll COMMENT '处理标记0申请，1微信零钱提现成功，2拒绝返回，3拒绝不返回金额，4，手工提现成功',
  `createtime` varchar(255),
  `uniacid` int(11) NOT NULL
) CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_xuan_welfare_tixian` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `uid` int(11) NOT NUll COMMENT '提现人uid',
  `jfen` decimal(10,2) NOT NULL COMMENT '提现积分',
  `type` varchar(255) NOT NULL COMMENT '提现类型',
  `bank_num` varchar(255) NOT NULL COMMENT '银行账号',
  `addr_name` varchar(255) NOT NULL COMMENT '银行信息',
  `status` int(3) NOT NUll COMMENT '处理标记0申请，1提现成功，2拒绝返回',
  `createtime` varchar(255)
) CHARSET=utf8;