<?php

/**
 *
 * User: codeMonkey QQ:2463619823
 * Date: 2015/1/18
 * Time: 0:01
 */
class DBUtil
{


    public static $TABLE_XKWKJ = "mon_xkwkj";

    public static $TABLE_XKWKJ_GOODS = "mon_xkwkj_goods";

    public static $TABLE_XKWKJ_USER = "mon_xkwkj_user";

    public static $TABLE_XKWKJ_FIREND = "mon_xkwkj_firend";

    public static $TABLE_XKWJK_ORDER = "mon_xkwkj_order";

    public static $TABLE_XKWKJ_SETTING = "mon_xkwkj_setting";

    public static $TABLE_XKWKJ_INDEX_SETTING = "mon_xkwkj_index_setting";

    public static $TABLE_XKWKJ_USER_INFO = "mon_xkwkj_user_info";

    public static $TABLE_XKWKJ_USER_ADDRESS = "mon_xkwkj_address";

    public static $TABLE_XKWKJ_PPTS = "mon_xkwkj_ppts";

    public static $TABLE_XKWKJ_CATEGORY = "mon_xkwkj_category";

    public static $TABLE_XKWKJ_REPLY = "mon_xkwkj_reply";

    public static $TABLE_XKWKJ_TEMPLATE = "mon_xkwkj_template";

    public static $TABLE_XKWKJ_POSTER = "mon_xkwkj_poster";

    public static $TABLE_XKWKJ_POSTER_SETTING = "mon_xkwkj_poster_setting";

    public static $TABLE_XKWKJ_TJ_RECORD = "mon_xkwkj_tj_record";




    public static function findById($table, $id)
    {
        return pdo_fetch("select * from " . tablename($table) . " where id=:id", array(':id' => $id));
    }


    public static function findUnique($table, $params = array())
    {


        if (!empty($params)) {
            $where = " where ";
            $index = 0;
            foreach ($params as $key => $value) {

                $where .= substr($key, 1) . "=" . $key . " ";

                if ($index < count($params) - 1) {
                    $where .= " and ";
                }
                $index++;

            }
        }

        return pdo_fetch("select * from " . tablename($table) . $where, $params);

    }

    public static function  findList($table, $params = array())
    {


        if (!empty($params)) {
            $where = " where ";
            $index = 0;
            foreach ($params as $key => $value) {

                $where .= substr($key, 1) . "=" . $key . " ";

                if ($index < count($params) - 1) {
                    $where .= " and ";
                }
                $index++;

            }
        }

        return pdo_fetchall("select * from " . tablename($table) . $where, $params);
    }


    public static function  findListEx($table, $fileds, $params = array())
    {


        if (!empty($params)) {
            $where = " where ";
            $index = 0;
            foreach ($params as $key => $value) {

                $where .= substr($key, 1) . "=" . $key . " ";

                if ($index < count($params) - 1) {
                    $where .= " and ";
                }
                $index++;

            }
        }

        return pdo_fetchall("select " . $fileds . " from " . tablename($table) . $where, $params);
    }


    public static function  create($table, $data = array())
    {
        return pdo_insert($table, $data);

    }

    public static function  update($table, $data = array(), $params = array())
    {
        return pdo_update($table, $data, $params);

    }

    public static function  updateById($table, $data = array(), $id)
    {
        return pdo_update($table, $data, array('id' => $id));

    }


    public static function  deleteByid($table, $id)
    {
        return pdo_delete($table, array('id' => $id));
    }

    public static function  delete($table, $params = array())
    {
        return pdo_delete($table, $params);
    }


}