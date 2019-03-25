<?php
/**
 * Created by PhpStorm.
 * User: tinkpad
 * Date: 2017/11/18
 * Time: 22:14
 */

error_reporting(0);
date_default_timezone_set("PRC");
define('IN_IA', 1);
include dirname(__FILE__) . "/db/simple_html_dom.php";
include dirname(__FILE__) . "/db/DBMysqlNamespace.php";
include dirname(__FILE__) . "/db/SqlBuilder.class.php";
include dirname(__FILE__) . "/../../../data/config.php";
class BaseHandler {

    private static $_config = null;
    private static $_db     = null;
    private static $_instance = null;
    public static function getHandler() {
        if(!self::$_instance) {
            self::$_instance = self::getDB();
        }
        return self::$_instance;
    }

    private static function getDB() {
        $db = DBMysqlNamespace::createDBHandle(self::$_config, self::$_db);
        if(!$db) {
            echo date("Y-m-d H:i:s") . " connect db fail\n";
            exit;
        }
        return $db;
    }

    public static function setConfig($config) {
        if(!isset($config['db']['master'])){
            $config['db']['master'] = $config['db'];
        }
        self::$_config = [
            'host'     => $config['db']['master']['host'],
            'username' => $config['db']['master']['username'],
            'password' => $config['db']['master']['password'],
            'port'     => $config['db']['master']['port'],
        ];
        self::$_db = $config['db']['master']['database'];
    }


}

BaseHandler::setConfig($config);
