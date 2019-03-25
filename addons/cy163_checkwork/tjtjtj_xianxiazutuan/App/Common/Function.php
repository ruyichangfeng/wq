<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/11 0011
 * Time: 下午 7:24
 */

if (!function_exists('C')) {
    /**
     * 获取模块的全局配置
     */
    function C($key, $value = null)
    {
        return is_null($_SESSION['xxzt_config'][$key]) ? $value : $_SESSION['xxzt_config'][$key];
    }
}

if (!function_exists('getCurUrl')) {
    /**
     * 获取当前URL
     */
    function getCurUrl()
    {
        return urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
    }
}

if (!function_exists('genOrderId')) {
    /**
     * 生成订单ID
     */
    function genOrderId()
    {
        return time().mt_rand(1001,9999);
    }
}

if (!function_exists('alert')) {
    /**
     * 错误跳转函数
     */
    function alert($message, $url, $status) {
        $color = $status == 'success' ? 'green' : 'red';
        $html = <<<HTML
<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<title>错误</title>
</head>
<body>
<h2 style="text-align: center;color: $color; font-family: 'Microsoft Yahei';">$message <small id="time">3</small></h2>
<script >
var itime = 3;
setInterval(function(){
    if (itime == 1) {
        location.href = "$url";
    }
    itime-=1;
    document.getElementById('time').innerText = itime;
}, 1000);
</script>
</body>
</html>
HTML;
        echo $html;
        exit;
    }
}

if (!function_exists('referer')) {
    /**
     * 获取上一页URL
     */
    function referer() {
        return $_SERVER['HTTP_REFERER'];
    }
}

if (!function_exists('status2string')) {
    /**
     * 订单状态转换为文本
     */
    function status2string($status)
    {
        $s = '';
        switch ($status) {
            case -3:
                $s = '已退款';
                break;
            case -2:
                $s = '待退款';
                break;
            case -1:
                $s = '已取消';
                break;
            case 0:
                $s = '未支付';
                break;
            case 1:
                $s = '已支付';
                break;
            case 2:
                $s = '已发货';
                break;
            case 3:
                $s = '已收货';
                break;
        }
        return $s;
    }
}

if (!function_exists('getDataSectionOrders')) {
    function getDataSectionOrders ($starttime, $endtime, $status = '') {
        $where = '';
        switch ($status) {
            case 1:
            case 2:
            case 3:
                $where = 'status >= '.$status;
                break;
            case 0:
            case -1:
                $where = '(status = 0 || status = -1)';
                break;
            case -2:
            case -3:
                $where = 'status <= '.$status;
                break;
            default:
                $where = '';
                break;
        }
        $rec = pdo_fetchall(
            'SELECT fee FROM '.tablename('tjtjtj_xxzt_orders').' WHERE (create_at >= :sat && create_at < :eat ) AND '.$where,
            array(
                ':sat' => $starttime,
                ':eat' => $endtime
            )
        );
        $fee = 0;
        foreach ($rec as $val) {
            $fee += $val['fee'];
        }
        return $fee;
    }
}


/**
 * 获取微擎AccessToken
 */
function getAccessToken()
{
    global $_W;
    $accesstoken = unserialize($_W['account']['uniaccount']['access_token']);
    return $accesstoken['token'];
}

/**
 * 发送支付成功模版消息
 */
function sendPaySuccessMessage($touser, $data)
{
    $post = array(
        'touser' => $touser,
        'template_id' => $_SESSION['xxzt_config']['notify_pay_success'],
        'url' => '',
        'data' => array(
            'first' => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_pay_success_header']),
                'color' => '#333'
            ),
            'orderMoneySum' => array(
                'value' => urlencode($data['fee'].'元'),
                'color' => '#333'
            ),
            'orderProductName' => array(
                'value' => $data['goodsname'],
                'color' => '#333'
            ),
            'remark'   => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_pay_success_footer']),
                'color' => '#333'
            )
        )
    );
    \Core\Lib\Weixin::sendMessage(getAccessToken(), $post);
}

/**
 * 发送订单取消通知
 */
function sendOrderCancelMessage($touser, $data)
{
    $post = array(
        'touser' => $touser,
        'template_id' => $_SESSION['xxzt_config']['notify_cancel_order'],
        'url' => '',
        'data' => array(
            'first' => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_cancel_order_header']),
                'color' => '#333'
            ),
            'keyword1' => array(
                'value' => urlencode($data['orderid']),
                'color' => '#333'
            ),
            'keyword2' => array(
                'value' => '取消',
                'color' => '#333'
            ),
            'keyword3' => array(
                'value' => urlencode($data['fee']),
                'color' => '#333'
            ),
            'keyword4' => array(
                'value' => urlencode(date('Y-m-d H:i', $data['create_at'])),
                'color' => '#333'
            ),
            'keyword5' => array(
                'value' => urlencode($data['mobile']),
                'color' => '#333'
            ),
            'remark'   => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_cancel_order_footer']),
                'color' => '#333'
            )
        )
    );
    \Core\Lib\Weixin::sendMessage(getAccessToken(), $post);
}

/**
 * 发送组团成功通知
 */
function sendGroupSuccessMessage($touser, $data)
{
    $post = array(
        'touser' => $touser,
        'template_id' => $_SESSION['xxzt_config']['notify_group_success'],
        'url' => '',
        'data' => array(
            'first' => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_group_success_header']),
                'color' => '#333'
            ),
            'keyword1' => array(
                'value' => urlencode($data['name']),
                'color' => '#333'
            ),
            'keyword2' => array(
                'value' => urlencode($data['needpeople'].'人团'.$data['gprice'].'元'),
                'color' => '#333'
            ),
            'remark'   => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_group_success_footer']),
                'color' => '#333'
            )
        )
    );
    \Core\Lib\Weixin::sendMessage(getAccessToken(), $post);
}

/**
 * 发送组团失败通知
 */
function sendGroupFailMessage($touser, $data)
{
    $post = array(
        'touser' => $touser,
        'template_id' => $_SESSION['xxzt_config']['notify_group_fail'],
        'url' => '',
        'data' => array(
            'first' => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_group_fail_header']),
                'color' => '#333'
            ),
            'keyword1' => array(
                'value' => urlencode($data['name']),
                'color' => '#333'
            ),
            'keyword2' => array(
                'value' => urlencode($data['needpeople'].'人团'.$data['gprice'].'元'),
                'color' => '#333'
            ),
            'remark'   => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_group_fail_footer']),
                'color' => '#333'
            )
        )
    );
    \Core\Lib\Weixin::sendMessage(getAccessToken(), $post);
}


/**
 * 发送发货通知
 */
function sendDeliverMessage($touser, $data)
{
    $post = array(
        'touser' => $touser,
        'template_id' => $_SESSION['xxzt_config']['notify_deliver'],
        'url' => '',
        'data' => array(
            'first' => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_deliver_header']),
                'color' => '#333'
            ),
            'keyword1' => array(
                'value' => urlencode($data['orderid']),
                'color' => '#333'
            ),
            'keyword2' => array(
                'value' => urlencode($data['express']),
                'color' => '#333'
            ),
            'keyword3' => array(
                'value' => urlencode($data['expressid']),
                'color' => '#333'
            ),
            'remark'   => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_deliver_footer']),
                'color' => '#333'
            )
        )
    );
    \Core\Lib\Weixin::sendMessage(getAccessToken(), $post);
}

/**
 * 发送退款通知
 */
function sendRefundMessage($touser, $data)
{
    $post = array(
        'touser' => $touser,
        'template_id' => $_SESSION['xxzt_config']['notify_refund'],
        'url' => '',
        'data' => array(
            'first' => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_refund_header']),
                'color' => '#333'
            ),
            'keyword1' => array(
                'value' => urlencode($_SESSION['xxzt_config']['shop_name']),
                'color' => '#333'
            ),
            'keyword2' => array(
                'value' => urlencode($data['orderid']),
                'color' => '#333'
            ),
            'keyword3' => array(
                'value' => urlencode($data['buyway'] == 'groups' ? '组团' : '单买'),
                'color' => '#333'
            ),
            'keyword4' => array(
                'value' => urlencode($data['fee']),
                'color' => '#333'
            ),
            'remark'   => array(
                'value' => urlencode($_SESSION['xxzt_config']['notify_refund_footer']),
                'color' => '#333'
            )
        )
    );
    \Core\Lib\Weixin::sendMessage(getAccessToken(), $post);
}

/**
 * 生成PEM证书
 */
function genPem($name, $content)
{
    $path = MODULE_ROOT.'/temp/'.$name.'.pem';
    file_put_contents($path, $content);
    return $path;
}


/**
 * 最简单的XML转数组
 * @param string $xmlstring XML字符串
 * @return array XML数组
 */
function simplest_xml_to_array($xmlstring) {
    return json_decode(json_encode((array) simplexml_load_string($xmlstring)), true);
}