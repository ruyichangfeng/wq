<?php

/*
 * 公用方法，已自动加载
 */

/**
 * 构造Web页面URL
 *
 * @param       $do    controller/action 默认action为index
 * @param array $query 附加的查询参数
 *
 * @return string 返回的 URL
 */
function createWebUrl($do, $query = [])
{
    global $_GPC;
    $route = explode('/', $do);
    $query['do'] = $route[0];

    if (isset($route[1])) {
        $query['wdo'] = $route[1];
    }
    $query['m'] = strtolower($_GPC['m']);
    return wurl('site/entry', $query);
}

/**
 * 构造手机页面URL
 *
 * @param         $do         controller/action 默认action为index
 * @param array $query 附加的查询参数
 * @param boolean $noredirect mobile 端url是否要附加 &wxref=mp.weixin.qq.com#wechat_redirect
 *
 * @return string 返回的 URL
 */
function createMobileUrl($do, $query = [], $noredirect = true)
{
    global $_GPC;
    $route = explode('/', $do);
    $query['do'] = $route[0];
    if (isset($route[1])) {
        $query['wdo'] = $route[1];
    }
    $query['m'] = strtolower($_GPC['m']);
    return murl('entry', $query, $noredirect);
}

/**
 * 构造页面URL
 *
 * @param         $do         controller/action 默认action为index
 * @param array $query 附加的查询参数
 * @param boolean $noredirect mobile 端url是否要附加 &wxref=mp.weixin.qq.com#wechat_redirect
 *
 * @return string 返回的 URL
 */
function genUrl($from, $do, $query = [], $noredirect = true, $addhost = false)
{
    global $_GPC, $_W;
    $route = explode('/', $do);
    $query['do'] = $route[0];
    switch ($from) {
        case 'web':
            $segment = 'site/entry';
            break;
        case 'mobile':
            $segment = 'entry';
            break;
    }
    if (isset($route[1])) {
        $query['wdo'] = $route[1];
    } else {
        $query['wdo'] = 'index';
    }
    $query['m'] = strtolower($_GPC['m']);
    return murl($segment, $query, $noredirect, $addhost);
}

/*
 * 下划线转驼峰
 */
function convertUnderline($str)
{
    $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
        return strtoupper($matches[2]);
    }, $str);
    return $str;
}

function convertToUTF8($text)
{
    if (is_array($text)) {
        foreach ($text as $k => $v) {
            $text[$k] = convertToUTF8($v);
        }
    } else {
        $encoding = mb_detect_encoding($text, array("UTF-8", "ASCII", "GB2312", "GBK", "BIG5"));
        if ($encoding == "UTF-8") {
            return $text;
        }
        $text = iconv("GBK", "UTF-8//IGNORE", $text);
    }
    return $text;
}

/**
 * 跳转链接
 *
 * @param $url
 */
function wxzRedirect($url)
{
    if (!$url) {
        $url = "/";
    }
    header("Location: {$url}");
    exit;
}

/**
 * 微小智url参数转换为数组  a=1&b=2
 * @param $url
 */
function wxzUrlParam2Arr($param)
{
    $result = [];
    if (!$param) {
        return;
    }
    $params = explode('&', $param);
    foreach ($params as $par) {
        list($k, $v) = explode('=', $par);
        $result[$k] = $v;
    }
    return $result;
}


/**
 * 格式化未数字索引
 * @param $list
 * @param $key
 * @return array
 */
function wxzFormatArrayByKey($list, $key)
{
    $tmp = array();
    if (!$list) {
        return array();
    }
    foreach ($list as $v) {
        $tmp[$v[$key]] = $v;
    }
    return $tmp;
}

/**
 * 生成随机字符串
 * @param int $length
 * @return string
 */
function wxzGenerateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * 小程序特殊字符反转义
 * @param $input
 * @return null|string|string[]
 */
function wxzWxEscape($input)
{
    $input = htmlspecialchars_decode($input);
    $output = preg_replace_callback("/(&#[0-9]+;)/", function ($m) {
        return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");
    }, $input);
    return $output;
}


/**************************************************************
 *
 *  使用特定function对数组中所有元素做处理
 * @param  string &$array 要处理的字符串
 * @param  string $function 要执行的函数
 * @return boolean $apply_to_keys_also     是否也应用到key上
 * @access public
 *
 *************************************************************/
function wxzArrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            wxzArrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }
        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}

/**************************************************************
 *
 *  将数组转换为JSON字符串（兼容中文）
 * @param  array $array 要转换的数组
 * @return string      转换得到的json字符串
 * @access public
 *
 *************************************************************/
function wxzJsonEncode($array)
{
    wxzArrayRecursive($array, 'urlencode', true);
    $json = json_encode($array);
    return urldecode($json);
}


/**
 * 打包下载zip
 * @param $source
 * @param $destination
 * @return bool
 */
function wxzDownloadZipData($source, $destination)
{
    if (extension_loaded('zip')) {
        if (file_exists($source)) {
            $zip = new ZipArchive();
            if ($zip->open($destination, ZIPARCHIVE::CREATE)) {
                $source = realpath($source);
                if (is_dir($source)) {
                    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
                    foreach ($files as $file) {
                        $file = realpath($file);
                        if (is_dir($file)) {
                            $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                        } else if (is_file($file)) {
                            $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                        }
                    }
                } else if (is_file($source)) {
                    $zip->addFromString(basename($source), file_get_contents($source));
                }
            }
            $zip->close();
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=$destination");
            header("Content-length: " . filesize($destination));
            header("Pragma: no-cache");
            header("Expires: 0");
            readfile("$destination");
        }
    }
    return false;
}

if (!function_exists("array_column")) {
    function array_column($array, $column_name)
    {
        return array_map(function ($element) use ($column_name) {
            return $element[$column_name];
        }, $array);
    }
}

/**
 * 清理数组空数据
 * @param $arr
 */
function wxzClearEmptyArr($arr)
{
    if (!$arr) {
        return [];
    }
    foreach ($arr as $k => $v) {
        if (is_array($v)) {
            $arr[$k] = wxzClearEmptyArr($v);
        } else {
            if (empty($v)) {
                unset($arr[$k]);
            }
        }
    }
    return $arr;
}


/**
 * 发送红包
 *
 * @param $data
 *
 * @return array
 */
function sendReward($data)
{
    global $_W, $_GPC;
    $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
    $pars = array();
    $pars['nonce_str'] = random(32);
    $pars['mch_billno'] = $data['mchid'] . date('Ymd') . sprintf('%d', time());
    $pars['mch_id'] = $data['mchid'];
    $pars['wxappid'] = $data['appid'];
    $pars['send_name'] = $data['send_name'];
    $pars['re_openid'] = $data['openid'];
    $pars['total_amount'] = $data['fee'];
    $pars['total_num'] = 1;
    $pars['wishing'] = $data['wishing'];
    $pars['client_ip'] = $data['ip'];
    $pars['act_name'] = $data['act_name'];
    $pars['remark'] = $data['remark'];
    ksort($pars, SORT_STRING);
    $string1 = '';
    foreach ($pars as $k => $v) {
        $string1 .= "{$k}={$v}&";
    }
    $string1 .= "key={$data['password']}";

    $pars['sign'] = strtoupper(md5($string1));
    $xml = array2xml($pars);
    $extras = array();
    $extras['CURLOPT_SSLCERT'] = ADDON_PATH . '/lib/cert/apiclient_cert.pem';
    $extras['CURLOPT_SSLKEY'] = ADDON_PATH . '/lib/cert/apiclient_key.pem';

    load()->func('communication');
    $resp = ihttp_request($url, $xml, $extras);

    if (is_error($resp)) {
        $procResult = $resp;
    } else {
        $arr = json_decode(json_encode((array)simplexml_load_string($resp['content'])), true);
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
        $dom = new \DOMDocument();
        if ($dom->loadXML($xml)) {
            $xpath = new \DOMXPath($dom);
            $code = $xpath->evaluate('string(//xml/return_code)');
            $ret = $xpath->evaluate('string(//xml/result_code)');
            if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
                $procResult = array('errno' => 0, 'error' => 'success');
            } else {
                $error = $xpath->evaluate('string(//xml/err_code_des)');
                $procResult = array('errno' => -2, 'error' => $error);
            }
        } else {
            $procResult = array('errno' => -1, 'error' => '未知错误');
        }
    }

    if ($procResult['errno'] != 0) {
        $res = array('s' => -1, 'msg' => $procResult['error']);
        return $res;
    } else {
        $res = array('s' => 1, 'msg' => 'ok');
        return $res;
    }
}

/**
 * 企业打款
 * @param $data
 * @return array
 */
function sendCompany($data)
{
    global $_W, $_GPC;
    $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
    $pars = array();
    $pars['nonce_str'] = random(32);
    $pars['check_name'] = 'NO_CHECK';
    $pars['partner_trade_no'] = $data['order_no'];
    $pars['mchid'] = $_W['uniaccount']['setting']['payment']['wechat']['mchid'];
    $pars['mch_appid'] = $_W['uniaccount']['key'];
    $pars['openid'] = $data['openid'];
    $pars['amount'] = $data['fee'];
    $pars['spbill_create_ip'] = '101.132.120.36';
    $pars['desc'] = $data['remark'];

    ksort($pars, SORT_STRING);
    $string1 = '';
    foreach ($pars as $k => $v) {
        $string1 .= "{$k}={$v}&";
    }

    $string1 .= "key={$_W['uniaccount']['setting']['payment']['wechat']['signkey']}";
    $pars['sign'] = strtoupper(md5($string1));
    $xml = array2xml($pars);
    $extras = array();

    $extras['CURLOPT_SSLCERT'] = ADDON_PATH . '/lib/cert/apiclient_cert.pem.' . $_W['uniacid'];
    $extras['CURLOPT_SSLKEY'] = ADDON_PATH . '/lib/cert/apiclient_key.pem.' . $_W['uniacid'];

    $baseSettingModel = new BaseModel('uni_settings');
    $setting = $baseSettingModel->getRow("uniacid={$_W['uniacid']}", 'payment');
    $payment = iunserializer($setting['payment']);

    if (!file_exists($extras['CURLOPT_SSLCERT'])) {
        file_put_contents($extras['CURLOPT_SSLCERT'], authcode($payment['wechat_refund']['cert'], 'DECODE'));
    }
    if (!file_exists($extras['CURLOPT_SSLKEY'])) {
        file_put_contents($extras['CURLOPT_SSLKEY'], authcode($payment['wechat_refund']['key'], 'DECODE'));
    }

    load()->func('communication');
    $resp = ihttp_request($url, $xml, $extras);

    if (is_error($resp)) {
        $procResult = $resp;
    } else {
        $arr = json_decode(json_encode((array)simplexml_load_string($resp['content'])), true);
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
        $dom = new \DOMDocument();
        if ($dom->loadXML($xml)) {
            $xpath = new \DOMXPath($dom);
            $code = $xpath->evaluate('string(//xml/return_code)');
            $ret = $xpath->evaluate('string(//xml/result_code)');
            if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
                $procResult = array('errno' => 0, 'error' => 'success');
            } else {
                $error = $xpath->evaluate('string(//xml/err_code_des)');
                $procResult = array('errno' => -2, 'error' => $error);
            }
        } else {
            $procResult = array('errno' => -1, 'error' => '未知错误');
        }
    }

    if ($procResult['errno'] != 0) {
        if ($procResult['error']) {
            $errorMsg = $procResult['error'];
        } else {
            $errorMsg = $procResult['message'];
        }
        $res = array('s' => -1, 'msg' => $errorMsg);
        return $res;
    } else {
        $res = array('s' => 1, 'msg' => 'ok');
        return $res;
    }
}

?>
