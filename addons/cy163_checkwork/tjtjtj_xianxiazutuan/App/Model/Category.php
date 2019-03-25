<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/15 0015
 * Time: 上午 10:46
 */

namespace App\Model;

use \Core\Model;

class Category extends Model
{

    protected $tablename = 'tjtjtj_xxzt_category';

    protected $fieldArray = array(
        'sid',
        'sort',
        'name',
        'logo',
        'create_at'
    );

}