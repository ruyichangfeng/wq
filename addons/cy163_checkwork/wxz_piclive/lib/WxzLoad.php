<?php
/**
 * Created by PhpStorm.
 * User: lirui
 * Date: 2018/2/4
 * Time: 下午10:09
 */

class WxzLoad
{
    private static $conf;

    /**
     * 加载文件配置
     */
    public static function loadConf($file, $key1 = '', $key2 = '')
    {
        $result = NULL;
        if (!$file) {
            return $result;
        }

        if (isset(self::$conf[$file])) {
            $result = self::$conf[$file];
        } else {
            $path = ADDON_PATH . "/conf/{$file}.php";
            if (!file_exists($path)) {
                return $result;
            } else {
                $result = include_once $path;
                self::$conf[$file] = $result;
            }
        }

        if (!$result || !is_array($result)) {
            return $result;
        }

        if ($key1) {
            $result = $result[$key1];
        }
        if ($key2) {
            $result = $result[$key2];
        }

        return $result;
    }

}