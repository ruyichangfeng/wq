<?php


/**
 * 获取表名
 */
function getTableName($key)
{
    $tables =  [
        'activity'              =>  'protech_activitysystem_activities',
        'activity_form'         =>  'protech_activitysystem_activity_forms',
    ];

    return $tables[$key];
}
