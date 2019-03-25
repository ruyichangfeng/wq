<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2016/3/13
 * Time: 17:16
 */

namespace Core;


class Model
{

    /**
     * @var string 表名
     */
    protected $tablename = '';

    /**
     * @var string 主键
     */
    protected $primaryKey = 'uid';

    /**
     * @var int 主键值
     */
    protected $uid = null;

    /**
     * @var array 字段数组
     */
    protected $fieldArray = array();

    /**
     * @var 条件查询数据
     */
    protected $whereArr = array();

    /**
     * 初始化
     * @author qsnh <616896861@qq.com>
     */
    public function __construct( $uid = null )
    {
        $this->uid = $uid;
    }

    /**
     * Setter方法 设置主键值
     * @param int $uid
     * @return class 构建链式查询结构
     */
    public function setUid( $uid )
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * Setter方法
     * @param string primarykey
     * @return class 构建链式查询结构
     */
    public function setPrimaryKey( $primarykey )
    {
        $this->primaryKey = $primarykey;
        return $this;
    }

    /**
     * Getter方法 获取主键值
     * @return int
     * @author qsnh <616896861@qq.com>
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * 插入操作
     * @param array 字段数组
     * @return int 主键值
     * @author qsnh <616896861@qq.com>
     */
    public function insert( $data = null )
    {
        global $_GPC;
        $data = is_null($data) ? $_GPC : $data;
        $data = $this->filter( $data );
        pdo_insert( $this->tablename, $data );
        $self = $this->where($data)->get(array($this->primaryKey));
        return $self[$this->primaryKey];
    }

    /**
     * 编辑操作
     * @param array $data
     * @return boolean
     * @author qsnh <616896861@qq.com>
     */
    public function update( $data = null )
    {
        global $_GPC;
        $data = is_null($data) ? $_GPC : $data;
        $data = $this->filter( $data );
        return pdo_update( $this->tablename, $data, $this->whereArr );
    }

    /**
     * 删除操作
     * @return boolean
     * @author qsnh <616896861@qq.com>
     */
    public function delete()
    {
        return pdo_delete( $this->tablename, $this->whereArr );
    }

    /**
     * 获取记录
     * @param array 字段数组
     * @return array
     * @author qsnh <616896861@qq.com>
     */
    public function get( $field = array() )
    {
        return pdo_get( $this->tablename, $this->whereArr, $field );
    }

    /**
     * 过滤
     * @author qsnh <616896861@qq.com>
     */
    public function filter( $data )
    {
        $tmp = array();
        foreach ( $data as $key => $val ) {
            if ( in_array( $key, $this->fieldArray ) ) {
                $tmp[$key] = $val;
            }
        }
        return $tmp;
    }

    /**
     * 设置过滤条件
     * @author qsnh <616896861@qq.com>
     */
    public function where($data = null)
    {
        if (empty($this->whereArr)) {
            if (!empty($this->uid)) {
                $this->whereArr['uid'] = $this->uid;
            }
        }
        if (!is_null($data)) {
            $this->whereArr = array_merge($this->whereArr, $data);
        }
        return $this;
    }

}