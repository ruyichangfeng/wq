<?php
/**
 * Created by IntelliJ IDEA.
 * User: wanglu
 * Date: 2017/7/24
 * Time: 12:28
 */
/**
 * Created by wanglu on 2017/7/24.
 */

defined('IN_IA') or exit('Access Denied');
$redurls = pdo_fetchall("SELECT * FROM " . tablename(DBUtil::$TABLE_URLREDIRECT_URL) .
    "  where redid =:redid and is_enable = 1", array(':redid' => $red['id']));

if (empty($redurls)) {
    message("请先配置好请配置跳转URL");
}


$randomIndex = rand(0, count($redurls) - 1);
$redirect_url  = $redurls[$randomIndex];
$url = $redirect_url['url'];

$record_data = array(
    'weid' => $this->weid,
    'redid' => $red['id'],
    'uid' => $redirect_url['id'],
    'createtime' => TIMESTAMP,
    'url' => $redirect_url['url'],
    'ip'=>$_W['clientip']
);

if (!empty($fansInfo)) {
    $record_data['nickname'] = $fansInfo['nickname'];
    $record_data['headimgurl'] = $fansInfo['headimgurl'];
    $record_data['openid'] = $fansInfo['openid'];
}

DBUtil::create(DBUtil::$TABLE_URLREDIRECT_RECORD, $record_data);
header("location: $url ");

