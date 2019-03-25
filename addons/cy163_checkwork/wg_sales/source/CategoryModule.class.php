<?php

class CategoryModule {

    public $table = 'wg_sales_category';
    /**
     * 保存一条用户记录至用户表中, 如果OpenID存在, 则更新记录
     * @param array $entity     用户数据
     * @return int|error        成功返回用户编号, 失败返回错误信息
     */
    public function add($data) {
        $ret = pdo_insert($this->table, $data);
        if (!empty($ret)) {
            $cid =  pdo_insertid();
            if($cid) {
                $this->_initCategory($cid);
            }
            return $cid;
        }
        return false;
    }

    public function getList($where){

    }


    public function update($where, $data) {
        $ret = pdo_update($this->table, $data, $where);
        if ($ret !== false) {
            return true;
        } else {
            return error(-1, '数据更新失败, 请稍后重试');
        }
    }

    public function getOne($where) {
        $ret = pdo_get($this->table, $where);
        if (!empty($ret)) {
            return $ret;
        } else {
            return array();
        }
    }

    /**
     * 获取所有管理员列表
     */
    public function getAllCategory($where) {
        $ret = pdo_getall($this->table, $where,'*','','display_order asc');
        if (!empty($ret)) {
            return $ret;
        } else {
            return array();
        }
    }



    private function _initCategory($cid) {
        pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('wg_sales_article_news_'.$cid)." (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `type` int(11) NOT NULL DEFAULT '1' COMMENT '文章类型1:普通,2:图集,3:视频...',
  `site` varchar(100) NOT NULL,
  `author` varchar(256) NOT NULL DEFAULT '',
  `majory_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL DEFAULT '',
  `image` varchar(2000) NOT NULL,
  `kw` varchar(250) DEFAULT NULL,
  `url` varchar(1024) NOT NULL DEFAULT '',
  `text` varchar(300) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `praise` int(11) NOT NULL DEFAULT '0',
  `read_times` int(10) unsigned NOT NULL DEFAULT '0',
  `time_step` int(11) NOT NULL DEFAULT '0',
  `data_type` int(11) DEFAULT '0' COMMENT '0:text,1:json',
  `jump` int(11) NOT NULL DEFAULT '0',
  `comment_times` int(11) NOT NULL DEFAULT '0',
  `special` INT NOT NULL DEFAULT '0' COMMENT '评论,打赏二进制',
  `state` varchar(200) NOT NULL DEFAULT '' COMMENT '声明',
  `goods_info` varchar(500) NOT NULL DEFAULT '' COMMENT '广告信息',
  `md5` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md5` (`md5`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
       pdo_query("CREATE TABLE IF NOT EXISTS ".tablename('wg_sales_comment_'.$cid)." (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:匿名,1:实名',
  `article_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `content` varchar(300) NOT NULL DEFAULT '',
  `praise` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复id',
  `comment_times` int(11) NOT NULL DEFAULT '0' COMMENT '回复次数',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `comment_id` (`comment_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

}
