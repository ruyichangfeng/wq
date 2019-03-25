<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/16 0016
 * Time: 下午 12:22
 */

namespace App\Model;

use \Core\Model;

class Sliders extends Model
{

    protected $tablename = 'tjtjtj_xxzt_sliders';

    protected $fieldArray = array(
        'sid',
        'sort',
        'title',
        'thumb',
        'href',
        'create_at'
    );

    /**
     * 获取幻灯片
     */
    public function getAll()
    {
        $rec = pdo_fetchall('SELECT * FROM '.tablename($this->tablename).' ORDER BY sort ASC');
        return $rec;
    }

}