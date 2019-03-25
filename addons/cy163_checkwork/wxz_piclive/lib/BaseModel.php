<?php

/**
 * model基础类
 * Created by PhpStorm.
 * User: lirui
 * Date: 2017/12/15
 * Time: 1:36
 */
class BaseModel
{
    public $table;
    public $_W;
    public $_GPC;
    public $uniacid;
    public $querySql;

    public function __construct($table = '')
    {
        global $_GPC, $_W;
        $this->_GPC = $_GPC;
        $this->_W = $_W;
        $this->uniacid = $_W['uniacid'];
        if ($table) {
            $this->table = $table;
        }
    }

    /**
     * 通过id获取详情
     *
     * @param $id
     */
    public function getById($id, $field = '*')
    {
        if (!$id || !$field) {
            return false;
        }
        if (is_array($id)) {
            $idStr = implode(',', $id);
            $condition = "id in ({$idStr})";
            $sql = "SELECT {$field} FROM " . tablename($this->table) . " WHERE {$condition} order by field(id,{$idStr})";
            $this->querySql = $sql;
            return wxzFormatArrayByKey(pdo_fetchall($sql), 'id');
        } else {
            $condition = "id={$id}";
            $sql = "SELECT {$field} FROM " . tablename($this->table) . " WHERE {$condition}";
            $this->querySql = $sql;
            return pdo_fetch($sql);
        }
    }

    /**
     * 通过id更新
     *
     * @param type $id
     * @param type $data
     */
    public function updateById($id, $data)
    {
        if (!$id || !$data) {
            return false;
        }
        if (is_array($id)) {
            $idStr = implode(',', $id);
            $condition = "id in ({$idStr})";
        } else {
            $condition = ['id' => $id];
        }
        return pdo_update($this->table, $data, $condition);
    }

    /**
     * 增加+1
     */
    public function incrColumn($condition, $column, $num = 1)
    {
        if (!$condition || !$column) {
            return;
        }
        $sql = "update " . tablename($this->table) . " set {$column}={$column}+{$num} where {$condition}";
        return $this->querySql($sql);
    }

    /**
     * -1
     */
    public function reduceColumn($condition, $column, $num = 1)
    {
        if (!$condition || !$column) {
            return;
        }
        $sql = "update " . tablename($this->table) . " set {$column}={$column}-{$num} where {$condition}";
        return $this->querySql($sql);
    }

    /**
     * 通过id删除
     *
     * @param type $id
     */
    public function delById($id)
    {
        if (!$id) {
            return false;
        }
        if (is_array($id)) {
            $idStr = implode(',', $id);
            $condition = "id in ({$idStr})";
        } else {
            $condition = ['id' => $id];
        }
        return pdo_delete($this->table, $condition);
    }

    /**
     * @param $condition
     * @return bool
     */
    public function delete($condition)
    {
        if (!$condition) {
            return false;
        }

        return pdo_delete($this->table, $condition);
    }

    /**
     * 获取总数
     *
     * @param $condition
     */
    public function getCount($condition)
    {
        $sql = "select count(1) as num from " . tablename($this->table) . " where {$condition}";
        $this->querySql = $sql;
        return pdo_fetchcolumn($sql);
    }

    /**
     * 插入
     *
     * @param $data
     */
    public function add($data, $replace = false)
    {
        if (!$data || !is_array($data)) {
            return false;
        }
        pdo_insert($this->table, $data, $replace);
        return pdo_insertid();
    }

    /**
     * 根据条件更新数据
     *
     * @param $condition
     */
    public function update($condition, $data)
    {
        if (!$condition || !$data) {
            return false;
        }
        return pdo_update($this->table, $data, $condition);
    }

    /**
     * 获取list数据
     * @param $condition
     * @param string $field
     * @param string $order
     * @param string $limit
     * @param string $group
     * @return bool|mixed
     */
    public function getAll($condition, $field = '*', $order = '', $limit = '', $group = '')
    {
        if (!$condition || !$field) {
            return false;
        }
        if (empty($field)) {
            $field = '*';
        }
        $sql = "select {$field} from " . tablename($this->table) . " where {$condition}";
        if ($group) {
            $sql .= " group by {$group}";
        }
        if ($order) {
            $sql .= " order by {$order}";
        }
        if ($limit) {
            $sql .= " limit {$limit}";
        }
        $this->querySql = $sql;
        return pdo_fetchall($sql);
    }

    /**
     * 获取执行的sql
     */
    public function getLastSql()
    {
        $result = [];

        $debug = pdo_debug(false);
        $last = array_pop($debug);

        $result['sql'] = $last['sql'];
        $result['error'] = $last['error'];

        foreach ($last['params'] as $key => $param) {
            $result['sql'] = str_replace($key, '"' . $param . '"', $result['sql']);
        }
        return $result;
    }

    /**
     * 获取单条数据
     *
     * @param        $condition
     * @param        $order
     * @param string $field
     *
     * @return bool|mixed
     */
    public function getRow($condition, $field = '*', $order = '')
    {
        if (!$condition || !$field) {
            return false;
        }

        $sql = "select {$field} from " . tablename($this->table) . " where {$condition}";
        if ($order) {
            $sql .= " order by {$order}";
        }
        $this->querySql = $sql;
        return pdo_fetch($sql);
    }

    /**
     * 获取单个列
     * @param $condition
     * @param $column
     */
    public function getColumn($condition, $column)
    {
        if (!$condition || !$column) {
            return false;
        }
        $sql = "SELECT {$column} FROM " . tablename($this->table) . " WHERE {$condition}";
        $this->querySql = $sql;
        return pdo_fetchcolumn($sql);
    }

    /**
     * 查询sql
     * @param $sql
     * @param $isFetch
     * @return $result
     */
    public function querySql($sql, $isFetch = true)
    {
        if (!$sql) {
            return false;
        }
        $this->querySql = $sql;
        if ($isFetch) {
            return pdo_fetchall($sql);
        } else {
            return pdo_query($sql);
        }
    }

    /**
     * 返回格式化
     *
     * @param type $error_code
     * @param type $error_msg
     */
    public function returnFormat($code, $msg, $data = '')
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        return $result;
    }

}