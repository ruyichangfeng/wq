<?php
defined('IN_IA') or exit('Access Denied');

function getConsultantByParentId($parent_id)
{
    global $_W;

    $sql = "SELECT consultant_id FROM " . tablename('qw_microedu_parents') . " WHERE uniacid=:uniacid AND id=:parent_id";
    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':parent_id' => $parent_id,
    );

    $consultant_id = pdo_fetchcolumn($sql, $params);

    if (!is_null($consultant_id)) {
        $sql = "SELECT * FROM " . tablename('qw_microedu_consultants') . " WHERE uniacid=:uniacid AND id=:consultant_id";
        $params = array(
            ':uniacid' => $_W['uniacid'],
            ':consultant_id' => $consultant_id,
        );

        return pdo_fetch($sql, $params);
    } else {
        return false;
    }
}