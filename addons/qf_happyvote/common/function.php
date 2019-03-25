<?php
/**
 * 生成接口返回数据
 */
function response($data, $code = 200, $msg = '') {
    $data = array(
        'code' => $code,
        'data' => $data,
        'msg' => $msg,
    );
    echo json_encode($data);
    die;
}

/**
 * 更新会员积分
 */
function updatewe7credit1($uid, $integral, $message) {
    load()->model('mc'); 
    require_once MODULE_ROOT . '/common/config.php';
    mc_credit_update($uid, 'credit1', $integral, array($uid, $message, MODULE_ID));
}