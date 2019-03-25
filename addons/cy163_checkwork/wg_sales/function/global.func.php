<?php

/**
 * ajax返回格式化
 * @param  $error_code
 * @param  $error_msg
 */
function ajaxReturn($error_code, $error_msg, $error_data = '') {
    $result = array(
        'ec'   => $error_code,
        'em'   => $error_msg,
        'data' => $error_data,
    );
    echo json_encode($result);
    exit;
}

/**
 * model返回格式化
 * @param  $error_code
 * @param  $error_msg
 */
function modelReturn($error_code, $error_msg, $error_data = '') {
    $result = array(
        'error_code' => $error_code,
        'error_msg' => $error_msg,
        'data' => $error_data,
    );
    return $result;
}

?>
