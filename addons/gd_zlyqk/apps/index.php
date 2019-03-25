<?php

defined('IN_IA') or exit('Access Denied');

//自动注册
include 'loader.php';
spl_autoload_register('pLoader::autoload');

global $_W;
$moduleName=$_W['current_module']['name'];
if (!defined('MODULE_ROOT')) {
    define('MODULE_ROOT',IA_ROOT."/addons/".$moduleName);
}
if (!defined('MODULE_URL')) {
    define('MODULE_URL', $_W['siteroot'].'addons/'.$moduleName.'/');
}

/**
 * 插件注册函数实现接
 * @param $plugin      string 插件名称
 * @param $controller  string 控制器名称,不可包含 _ 字符
 * @param $action      string 执行方法名称,不可包含 _ 字符
 * @param $isAdmin     bool   是否是后台方式
 */
function pluginRegister ($plugin,$controller,$action,$isAdmin){
    if($isAdmin){
        $nameSpace = 'app\\'.$plugin.'\admin\\'.ucwords($controller);
    }else{
        $nameSpace = 'app\\'.$plugin.'\mobile\\'.ucwords($controller);
    }
    try {
        $handel = new \ReflectionClass($nameSpace);
        if(!$handel->hasMethod($action)){
            echo $nameSpace."::".$action."方法不存在";
        }
        $instance  = $handel->newInstanceArgs(array(true));
        $instance->plugin=$plugin;
        $instance->pClass=$controller;
        $instance->pDo=$action;
        $instance->pAdmin=$isAdmin;
        $instance->modulename="gd_zlyqk";
        $instance->$action();

    } catch (Exception $e) {
        echo $nameSpace."类未找到";
        exit();
    }
}