<?php

class TopiclistModule {

    public $table = 'wg_sales_topic_list';
    /**
     * 保存一条用户记录至用户表中, 如果OpenID存在, 则更新记录
     * @param array $entity     用户数据
     * @return int|error        成功返回用户编号, 失败返回错误信息
     */
    public function add($data) {
        $ret   = pdo_insert($this->table, $data);
        if (!empty($ret)) {
            $cid =  pdo_insertid();
            return $cid;
        }
        return false;
    }

    public function getList($where, $order, $field = '*',$limit = 30) {
         return pdo_getall($this->table,$where,$field,'',$order, $limit);
    }

    public function del($where) {
        return pdo_delete($this->table, $where);
    }

    public function count($where) {
        return pdo_count( $this->table,$where);
    }

    public function update($where, $data) {
        $ret = pdo_update($this->table, $data, $where);
        if ($ret !== false) {
            return true;
        } else {
            return false;
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





}
