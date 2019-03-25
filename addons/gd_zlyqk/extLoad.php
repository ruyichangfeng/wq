<?php

/**
 * loader.php
 * 这不是一个自由软件！。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * 开发: 冰源
 * 日期: 17-12-16
 * 时间: 上午9:58
 */

class extLoader
{
    public static $vendorMap = array(
        'ext' => __DIR__ ,
    );

    public static function autoload($class)
    {
        $file = self::findFile($class);
        if (file_exists($file)) {
            self::includeFile($file);
        }
    }

    private static function findFile($class)
    {
        $vendor = substr($class, 0, strpos($class, '\\'));
        $vendorDir = self::$vendorMap[$vendor];
        $filePath = substr($class, strlen($vendor)) . '.php';
        return strtr($vendorDir . $filePath, '\\', DIRECTORY_SEPARATOR);
    }

    private static function includeFile($file)
    {
        if (is_file($file)) {
            include $file;
        }
    }
}