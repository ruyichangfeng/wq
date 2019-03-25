<?php
/**
 * Plugin.php
 * 这不是一个自由软件！。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * 开发: 冰源
 * 日期: 18-1-26
 * 时间: 下午12:03
 */

namespace ext\apps\libs;


class Plugin
{

    //访问插件注册
    public function openPlugin(){
        global $_GPC;
        if(empty($_SESSION['plugin']) && $_SESSION['plugin']['name']!=$_GPC['plugin']){
            $pluginInfo = pdo_get("gd_plugin",array("plugin_str"=>$_GPC['plugin']));
            $_SESSION['plugin']=$pluginInfo;
        }
        return $_SESSION['plugin'];
    }
}