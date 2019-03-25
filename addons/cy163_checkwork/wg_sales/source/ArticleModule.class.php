<?php

class ArticleModule {

    public $table = 'wg_sales_article_news_';
    /**
     * 保存一条用户记录至用户表中, 如果OpenID存在, 则更新记录
     * @param array $entity     用户数据
     * @return int|error        成功返回用户编号, 失败返回错误信息
     */
    public function add($category_id, $data) {
        $table = $this->table.$category_id;
        $ret   = pdo_insert($table, $data);
        if (!empty($ret)) {
            $cid =  pdo_insertid();
            return $cid;
        }
        return false;
    }

    public function getList($category_id, $where, $field, $order, $limit) {
        $table = $this->table.$category_id;
        return pdo_getall($table,$where,$field,'',$order,$limit);
    }
    public function count($category_id, $where) {
        $table = $this->table.$category_id;
        return pdo_count($table,$where);
    }
    public function del($category_id, $where) {
        $table = $this->table.$category_id;
        return pdo_delete($table, $where);
    }


    public function update($category_id, $where, $data) {
        $table = $this->table.$category_id;
        $ret = pdo_update($table, $data, $where);
        if ($ret !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function getOne($category_id, $where,$field = '*') {
        $table = $this->table.$category_id;
        $ret = pdo_get($table, $where, $field);
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



}
