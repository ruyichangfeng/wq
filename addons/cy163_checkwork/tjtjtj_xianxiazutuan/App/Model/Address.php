<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/13 0013
 * Time: 下午 2:53
 */

namespace App\Model;


use \Core\Model;

class Address extends Model
{

    protected $tablename = 'tjtjtj_xxzt_address';

    protected $fieldArray = array(
        'sid',
        'userid',
        'name',
        'mobile',
        'province',
        'city',
        'county',
        'address',
        'create_at',
        'isdefault'
    );

    /**
     * 获取用户地址
     */
    public function getUserAddress($userid)
    {
        $rec = pdo_fetchall('SELECT * FROM '.tablename($this->tablename).' WHERE userid = :userid ORDER BY isdefault DESC', array(':userid' => $userid));
        return $rec;
    }

    /**
     * 获取用户默认地址
     */
    public function getUserDefault($userid)
    {
        $address = pdo_fetch('SELECT * FROM '.tablename($this->tablename).' WHERE userid = :userid ORDER BY isdefault DESC LIMIT 1 ', array(':userid' => $userid));
        return $address;
    }

    /**
     * 设置默认地址
     */
    public function setDefault($aid = 0, $userid = 0)
    {
        $all = pdo_getall($this->tablename, array('userid' => $userid));
        if ($all) {
            foreach ($all as $val) {
                pdo_update($this->tablename, array('isdefault' => 0), array('uid' => $val['uid']));
            }
        }
        if ($aid != 0 && $userid != 0) {
            pdo_update($this->tablename, array('isdefault' => 1), array('uid' => $aid));
        }
    }

}