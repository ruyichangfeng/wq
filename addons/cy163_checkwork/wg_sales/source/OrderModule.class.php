<?php

class OrderModule {

    public $table = 'wg_sales_reward';

    public function update($where, $data) {
        $ret = pdo_update($this->table, $data, $where);
        if ($ret !== false) {
            return true;
        } else {
            return false;
        }
    }
    public function count($where) {
        return pdo_count($this->table,$where);
    }

    public function getOne($where,$field = '*') {
        $ret = pdo_get($this->table, $where, $field);
        if (!empty($ret)) {
            return $ret;
        } else {
            return array();
        }
    }

    public function getList($where, $field, $order, $limit) {
        return pdo_getall( $this->table,$where,$field,'',$order,$limit);
    }
    public function add($data) {
        $ret   = pdo_insert($this->table, $data);
        if (!empty($ret)) {
            $cid =  pdo_insertid();
            return $cid;
        }
        return false;
    }
}
