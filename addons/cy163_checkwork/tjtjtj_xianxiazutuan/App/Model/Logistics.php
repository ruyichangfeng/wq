<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/15 0015
 * Time: 上午 10:47
 */

namespace App\Model;

use \Core\Model;

class Logistics extends Model
{

    protected $tablename = 'tjtjtj_xxzt_logistics';

    protected $fieldArray = array(
        'sid',
        'name',
        'area',
        'yesfee',
        'nofee'
    );

}