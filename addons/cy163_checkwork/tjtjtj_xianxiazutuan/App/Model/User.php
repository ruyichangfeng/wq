<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/11 0011
 * Time: 下午 7:02
 */

namespace App\Model;

use \Core\Model;

class User extends Model
{

    protected $tablename = 'tjtjtj_xxzt_users';

    protected $fieldArray = array(
        'sid',
        'wid',
        'nickname',
        'avatar',
        'mobile',
        'create_at'
    );

}