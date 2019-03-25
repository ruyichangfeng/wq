<?php

define('IN_MOBILE', true);

require '../../../framework/bootstrap.inc.php';
$input = file_get_contents('php://input');
libxml_disable_entity_loader(true);

if (!(empty($input)) && empty($_GET['out_trade_no']))
{

    $obj = simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
    $data = json_decode(json_encode($obj), true);
    pdo_insert('wxlm_appointment_config', array('config_type'=>'666', 'config_value' => json_encode($obj)));
    if (empty($data))
    {
        exit('fail');
    }
    if (($data['result_code'] != 'SUCCESS') || ($data['return_code'] != 'SUCCESS'))
    {
        $result = array('return_code' => 'FAIL', 'return_msg' => (empty($data['return_msg']) ? $data['err_code_des'] : $data['return_msg']));
        echo array2xml($result);
        exit();
    }
    $get = $data;

}
else
{
    $get = $_GET;

}



?>