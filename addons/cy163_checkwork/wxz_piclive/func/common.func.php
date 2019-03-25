<?php

global $_W;

/**
 * 评论列表
 * @param type $id
 */
function getComment($id){
    global $_W;
    //$userinfo = mc_oauth_userinfo();
    load()->model('mc');
    $sql = "SELECT c.cid,c.uid,c.content as commentText,c.add_time,m.nickname as username,m.avatar FROM ". tablename('wxz_pic_comment') . " AS c ".
            "LEFT JOIN ". tablename('mc_members') . " AS m ON c.uid=m.uid ".
            "WHERE c.aid='{$id}' AND c.is_show=1 ORDER BY c.cid DESC limit 50";
    $list = pdo_fetchall($sql);
	foreach($list as $kk=>$vv){
		$list[$kk]['dateTime'] = date('Y-m-d H:i:s', $vv['add_time']);
		$list[$kk]['userPic'] = !empty($vv['avatar']) ? str_replace('132132','132',$vv['avatar']) : str_replace('132132','132',$userinfo['avatar']);
                if($_W['fans']['uid'] == $vv['uid']){
                    $list[$kk]['myself'] = 1;
                }else{
                    $list[$kk]['myself'] = 0;
                }
	}
	
    return $list;
}

/**
 * 获取关注数
 * @param type $aid
 */
function getStarNum($aid){
    global $_W;
    $sql = "SELECT count(*) FROM ". tablename('wxz_pic_star') ."WHERE aid='{$aid}' AND is_good=1";
    $count = pdo_fetchcolumn($sql);
    return $count;
}

/**
 * 获取直播类型分类
 * @global type $_W
 * @return type
 */
function getCategory($lid=1){
    global $_W;
    $uniacid = $_W['uniacid'];
    $sql = "SELECT * FROM ". tablename('wxz_pic_live_type') ."WHERE uniacid='{$uniacid}' AND lid='{$lid}' AND enabled=1";
    $cateArr = pdo_fetchall($sql);
    $arr = array();
    if($cateArr){
        foreach($cateArr as $kk=>$vv){
            $arr[$vv['id']] = $vv['name'];
        }
    }
    return $arr;
}

/**
 * 是否关注
 * @param type $aid
 */
function IsGoodstar($aid,$uid,$lid){
    global $_W;
    $uniacid = $_W['uniacid'];
    
    $where = "WHERE uniacid='$uniacid' AND aid='{$aid}' AND uid='{$uid}' AND lid='{$lid}' AND is_good=1";
    $sql = "SELECT count(*) FROM ". tablename('wxz_pic_star') .$where;
    $count = pdo_fetchcolumn($sql);
    if($count){
        return true;
    }else{
        return false;
    }
}
/**
 * 文件大小
 * @param type $size
 * @param type $format
 * @return type
 */
function getsize($size, $format = 'kb') {
    $p = 0;
    if ($format == 'kb') {
        $p = 1;
    } elseif ($format == 'mb') {
        $p = 2;
    } elseif ($format == 'gb') {
        $p = 3;
    }
    $size /= pow(1024, $p);
    return number_format($size, 2);
}

function jsonReturn($data='',$info='',$status=1) {
    $data = converNullToString($data); // 将数据中的null 转成空字符串
    $result  =  array();
    $result['boolen']  =  is_numeric($status) ? "".$status."" : $status;
    $result['message'] =  is_numeric($info) ? "".$info."":$info;
    $result['data'] = is_numeric($data) ? "".$data."":$data;
    //header("Content-Type:text/html; charset=utf-8");
    //tag('exit_end');
    if(phpversion() >= '5.4') exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    else exit(json_encode($result));
}


// 把数组中的null全部转化成空字符串
function converNullToString(&$o) {
    if(!is_array($o) && is_null($o)) return '';
    foreach($o as $k => $v) {
        $o[$k] = is_array($v) ? converNullToString($v) : (is_null($v) ? '' : $v);
    }

    return $o;
}
/**
 * 发送短信
 * @global type $_W
 * @param type $mobile
 * @return boolean
 */
function send_code($mobile, $fan_info) {
    global $_W;
    require_once WXZ_SHOPPINGMALL . '/source/Fans.class.php';
    $fan = new Fans();
    $max_send_num = $_W['module_setting']['sms_max_send_msg_num'] ? $_W['module_setting']['sms_max_send_msg_num'] : 3; //一天最多发送短信次数
    if (!$mobile) {
        return error(-1, "手机号不能为空");
    }
    if (!$fan_info) {
        return error(-2, "获取公众号信息错误");
    }
    $fans_update_data = array();
    //是否超过限制
    $today_begin = strtotime(date("Y-m-d 00:00:00"));
    $today_end = strtotime(date("Y-m-d 23:59:59"));
    $update_verify_count = 0; //今天是否发送过验证码
    if ($fan_info['mobile_verify']) {
        $verify_info = explode("_", $fan_info['mobile_verify']);
        $verify_time = $verify_info[2];
        $verify_count = $verify_info[3];
        //一天一个用户只能发送短信三次
        if ($verify_time >= $today_begin && $verify_time <= $today_end) {
            if ($verify_count >= $max_send_num) {
                return error(-4, "今日发送短息验证码已经超过限制");
            }
            $update_verify_count = $verify_count;
        }
    }

    //发送短息
    require_once WXZ_SHOPPINGMALL . '/func/sms_t.php';
    $sms = new sms_t($_W['module_setting']);
    $sms_res = $sms->send_code($mobile);
    if (!$sms_res) {
        return error(-4, "发送短息错误");
    }
    $verify_code = $sms->get_send_code();
    $fans_update_data['mobile_verify'] = $mobile . "_" . $verify_code . "_" . time() . "_" . ($update_verify_count + 1);
    $fan->update_by_id($fan_info['uid'], $fans_update_data);
    return true;
}

/**
 * 检验短信验证码
 * @param type $code
 */
function check_verify_code($fan_info, $code) {
    global $_W;
    require_once WXZ_SHOPPINGMALL . '/source/Fans.class.php';
    $fan = new Fans();
    if (!$fan_info) {
        return error(-2, "获取公众号信息错误");
    }
    $verify_info = explode("_", $fan_info['mobile_verify']);
    $verify_code = $verify_info[1];
    $verify_time = $verify_info[2];
    if ($verify_time + 3600 <= time()) {
        return error(-2, "短信验证码已过期");
    }
    if (!$verify_code || $verify_code != $code) {
        return error(-2, "短信验证码错误");
    }
    $verify_info[1] = '';
    $fans_update_data['mobile_verify'] = implode("_", $verify_info);
    $fan->update_by_id($fan_info['uid'], $fans_update_data);
    return true;
}

/**
 * 获取自定义分享数据
 */
function getShareData() {
    global $_W, $_GPC;
    $info_sql = "SELECT * FROM " . tablename('wxz_shoppingmall_share') . " WHERE uniacid={$_W['uniacid']} AND type='{$_GPC['do']}'";
    $info = pdo_fetch($info_sql);
    if ($info) {
        return $info;
    }

    $info_sql = "SELECT * FROM " . tablename('wxz_shoppingmall_share') . " WHERE uniacid={$_W['uniacid']} AND type='default'";
    $info = pdo_fetch($info_sql);
    return $info;
}

if (!function_exists('array_column')) {

    function array_column($input, $column_key, $index_key = null) {
        $arr = array_map(function($d) use ($column_key, $index_key) {
            if (!isset($d[$column_key])) {
                return null;
            }
            if ($index_key !== null) {
                return array($d[$index_key] => $d[$column_key]);
            }
            return $d[$column_key];
        }, $input);

        if ($index_key !== null) {
            $tmp = array();
            foreach ($arr as $ar) {
                $tmp[key($ar)] = current($ar);
            }
            $arr = $tmp;
        }
        return $arr;
    }

}