<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/15 0015
 * Time: 上午 10:44
 */

namespace App\Model;

use \Core\Model;

class Goods extends Model
{

    protected $tablename = 'tjtjtj_xxzt_goods';

    protected $fieldArray = array(
        'sid',
        'sort',
        'name',
        'logo',
        'cid',
        'stock',
        'sales',
        'singlelimit',
        'morelimit',
        'gprice',
        'sprice',
        'mprice',
        'atlas',
        'details',
        'lid',
        'status',
        'create_at'
    );

    /**
     * 减少库存
     */
    public function decStock($nums)
    {
        return pdo_query('UPDATE '.tablename($this->tablename).' SET stock = stock - '.$nums.' WHERE uid = :uid', array(':uid' => $this->getUid()));
    }

}