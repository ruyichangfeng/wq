<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
header("Content-type: text/html; charset=utf-8");
include_once dirname(__FILE__) .'/Index.php';
Index::run();