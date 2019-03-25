<?php
/**
 * 插件列表
 * pluginlist.inc.php
 * 这不是一个自由软件！。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * 开发: 冰源
 * 日期: 18-1-20
 * 时间: 下午3:31
 */

use ext\libs\plugin;

$plugin = new plugin();
$pluginList = $plugin->getPluginList();

include $this->template("plugin_list");