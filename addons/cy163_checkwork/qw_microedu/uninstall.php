<?php
 
defined('IN_IA') or exit('Access Denied');
$sql = file_get_contents($modulepath . 'uninstall.sql');
$sql = str_replace("\r", "\n", $sql);
$ret = array();
$num = 0;
foreach(explode(";\n", trim($sql)) as $query) {
        $ret[$num] = '';
        $queries = explode("\n", trim($query));
        foreach($queries as $query) {
                $ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0].$query[1] == '--') ? '' : $query;
        }
        $num++;
}
unset($sql);
$orginal = 'ims_';
$prefix = $GLOBALS['_W']['config']['db']['tablepre'];
if ($orginal != $prefix) {
    $ret = str_replace ( "{$orginal}", "{$prefix}", $ret );
}
foreach ($ret as $query) {
    $query = trim($query);
    if ($query) {
        pdo_query($query);
    }
}