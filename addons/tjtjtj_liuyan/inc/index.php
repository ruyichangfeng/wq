<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2016/3/13
 * Time: 14:15
 */

$model  = is_null($_GPC['model']) ? 'index' : strtolower($_GPC['model']);
$action = is_null($_GPC['action']) ? 'index' : strtolower($_GPC['action']);

//引入文件
include_once MODULE_ROOT.'/inc/'.$model.'/'.$action.'.php';