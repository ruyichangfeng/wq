<?php
/**
 * Created by PhpStorm.
 * User: Lzhy ysjywz@gmail.com
 * Date: 2018/5/18
 * Time: 上午10:06
 */
namespace Core\model;

use Core\common\Model;

class data extends Model
{
    public function dataList()
    {
        $list = $this->table('h5_news')->select(); 
            
        return $list;
    }
}