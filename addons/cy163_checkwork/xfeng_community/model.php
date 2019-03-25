<?php
//execl导入
function import($excefile) {
    global $_W;
    require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel.php';
    require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel/IOFactory.php';
    require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel/Reader/Excel5.php';
    $path = IA_ROOT . "/addons/xfeng_community/template/upFile/";
    if (!is_dir($path)) {
        load()->func('file');
        mkdirs($path, '0777');
    }
    $file = time() . $_W['uniacid'] . ".xlsx";
    $filename = $_FILES[$excefile]['name'];
    $tmpname = $_FILES[$excefile]['tmp_name'];
    if (empty($tmpname)) {
        message('请选择要上传的Excel文件!', '', 'error');
    }
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $uploadfile = $path . $file;
    $result = move_uploaded_file($tmpname, $uploadfile);
    if (!$result) {
        message('上传Excel 文件失败, 请重新上传!', '', 'error');
    }
    if ($ext == 'xlsx') {
        $reader = PHPExcel_IOFactory::createReader('Excel2007');
    } else {
        $reader = PHPExcel_IOFactory::createReader('Excel5');
    }
    $excel = $reader->load($uploadfile);
    $sheet = $excel->getActiveSheet();
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $highestColumnCount = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $values = array();

    for ($row = 2; $row <= $highestRow; $row++) {
        $rowValue = array();
        for ($col = 0; $col < $highestColumnCount; $col++) {
            $d = $sheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();

            $rowValue[] = $d ? $d : 0;


        }
        $values[] = $rowValue;
    }



    return $values;
}

function nav() {
    global $_W;
    //导入微信端导航数据
    $navs = pdo_fetchall("SELECT * FROM" . tablename('xcommunity_nav') . "WHERE uniacid= '{$_W['uniacid']}'");
    if (empty($navs)) {
        $data1 = array('displayorder' => 0, 'pcate' => 0, 'title' => '物业服务', 'url' => '', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1);
        $data2 = array('displayorder' => 0, 'pcate' => 0, 'title' => '小区互动', 'url' => '', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1);
        $data3 = array('displayorder' => 0, 'pcate' => 0, 'title' => '生活服务', 'url' => '', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1);
        if ($data1) {
            pdo_insert('xcommunity_nav', $data1);
            $nid1 = pdo_insertid();
            $menu1 = array(
                array('displayorder' => 0, 'pcate' => $nid1, 'title' => '社区公告', 'do' => 'announcement', 'icon' => 'glyphicon glyphicon-bullhorn', 'bgcolor' => '#95bd38', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=announcement&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/notice.png"),
                array('displayorder' => 0, 'pcate' => $nid1, 'title' => '小区报修', 'do' => 'repair', 'icon' => 'glyphicon glyphicon-wrench', 'bgcolor' => '#3c87c8', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=repair&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/repair.png"),
                array('displayorder' => 0, 'pcate' => $nid1, 'title' => '意见建议', 'do' => 'report', 'icon' => 'fa fa-legal', 'bgcolor' => '#dd4b2b', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=report&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/report.png"),
                array('displayorder' => 0, 'pcate' => $nid1, 'title' => '缴物业费', 'do' => 'cost', 'icon' => 'glyphicon glyphicon-send', 'bgcolor' => '#3c87c8', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=cost&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/cost.png"),

                array('displayorder' => 0, 'pcate' => $nid1, 'title' => '便民号码', 'do' => 'phone', 'icon' => 'glyphicon glyphicon-earphone', 'bgcolor' => '#ab5e90', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=phone&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/phone.png"),
                array('displayorder' => 0, 'pcate' => $nid1, 'title' => '常用查询', 'do' => 'search', 'icon' => 'glyphicon glyphicon-search', 'bgcolor' => '#ec9510', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=search&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/chaxun.png"),
                array('displayorder' => 0, 'pcate' => $nid1, 'title' => '手机开门', 'do' => 'c', 'icon' => 'glyphicon glyphicon-search', 'bgcolor' => '#ec9510', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=opendoor&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/open.png"),
            );
            foreach ($menu1 as $key => $value1) {
                pdo_insert('xcommunity_nav', $value1);
            }
        }
        if ($data2) {
            pdo_insert('xcommunity_nav', $data2);
            $nid2 = pdo_insertid();
            $menu2 = array(
                array('displayorder' => 0, 'pcate' => $nid2, 'title' => '小区活动', 'do' => 'activity', 'icon' => 'glyphicon glyphicon-tasks', 'bgcolor' => '#65944e', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=activity&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/huodong.png"),
                array('displayorder' => 0, 'pcate' => $nid2, 'title' => '二手市场', 'do' => 'fled', 'icon' => 'fa fa-exchange', 'bgcolor' => '#666699', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=fled&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/ershou.png"),
                array('displayorder' => 0, 'pcate' => $nid2, 'title' => '小区家政', 'do' => 'homemaking', 'icon' => 'glyphicon glyphicon-leaf', 'bgcolor' => '#95bd38', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=homemaking&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/jiazheng.png"),
                array('displayorder' => 0, 'pcate' => $nid2, 'title' => '房屋租赁', 'do' => 'houselease', 'icon' => 'fa fa-info', 'bgcolor' => '#38bfc8', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=houselease&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/zuning.png"),
                array('displayorder' => 0, 'pcate' => $nid2, 'title' => '小区拼车', 'do' => 'car', 'icon' => 'fa fa-truck', 'bgcolor' => '#7f6000', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=car&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/pingche.png"),
            );
            foreach ($menu2 as $key => $value2) {
                pdo_insert('xcommunity_nav', $value2);
            }
        }
        if ($data3) {
            pdo_insert('xcommunity_nav', $data3);
            $nid3 = pdo_insertid();
            $menu3 = array(
                array('displayorder' => 0, 'pcate' => $nid3, 'title' => '周边商家', 'do' => 'business', 'icon' => 'glyphicon glyphicon-shopping-cart', 'bgcolor' => '#65944e', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=business&op=list&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/zhoubian.png"),
                array('displayorder' => 0, 'pcate' => $nid3, 'title' => '生活超市', 'do' => 'shopping', 'icon' => 'glyphicon glyphicon-shopping-cart', 'bgcolor' => '#65944e', 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=shopping&op=list&m=xfeng_community', 'status' => 1, 'uniacid' => $_W['uniacid'], 'enable' => 1, 'thumb' => $_W['siteroot'] . "addons/xfeng_community/template/static/image/icon/chaoshi.png"),
            );
            foreach ($menu3 as $key => $value3) {
                pdo_insert('xcommunity_nav', $value3);
            }
        }
    }
}

function column_str($key) {
    $array = array(
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z',
        'AA',
        'AB',
        'AC',
        'AD',
        'AE',
        'AF',
        'AG',
        'AH',
        'AI',
        'AJ',
        'AK',
        'AL',
        'AM',
        'AN',
        'AO',
        'AP',
        'AQ',
        'AR',
        'AS',
        'AT',
        'AU',
        'AV',
        'AW',
        'AX',
        'AY',
        'AZ',
        'BA',
        'BB',
        'BC',
        'BD',
        'BE',
        'BF',
        'BG',
        'BH',
        'BI',
        'BJ',
        'BK',
        'BL',
        'BM',
        'BN',
        'BO',
        'BP',
        'BQ',
        'BR',
        'BS',
        'BT',
        'BU',
        'BV',
        'BW',
        'BX',
        'BY',
        'BZ',
        'CA',
        'CB',
        'CC',
        'CD',
        'CE',
        'CF',
        'CG',
        'CH',
        'CI',
        'CJ',
        'CK',
        'CL',
        'CM',
        'CN',
        'CO',
        'CP',
        'CQ',
        'CR',
        'CS',
        'CT',
        'CU',
        'CV',
        'CW',
        'CX',
        'CY',
        'CZ'
    );
    return $array[$key];
}

function column($key, $columnnum = 1) {
    return column_str($key) . $columnnum;
}
//最新一条公告调用
function notice($regionid){
    global $_W;
    $notices = pdo_fetchall('SELECT title,id,regionid,createtime FROM'.tablename('xcommunity_announcement')."WHERE weid=:weid order by createtime desc limit 3",array(':weid'=> $_W['uniacid']));
    $list ='';
    foreach($notices as $key => $val){
        $regions = unserialize($val['regionid']);
        if(@in_array($regionid,$regions)){
            $list[]= array(
                'id' => $val['id'],
                'title' => $val['title'],
                'createtime' => $val['createtime'],
            );
        }
    }
    return $list;
}
//调用最新的活动
function activity($regionid){
    global $_W;
    $activities = pdo_fetchall('SELECT title,id,regionid FROM'.tablename('xcommunity_activity')."WHERE weid=:weid order by createtime desc limit 5",array(':weid'=> $_W['uniacid']));
    $list ='';
    foreach($activities as $key => $val){
        $regions = unserialize($val['regionid']);
        if(@in_array($regionid,$regions)){
            $list[]= array(
                'id' => $val['id'],
                'title' => $val['title'],
            );
        }
    }
    return $list;
}
//发送微信信息
function sendmessage($openid,$fromuser,$title,$id,$cont,$type){
    global $_W;
    $user = pdo_fetch("SELECT * FROM".tablename('xcommunity_member')."WHERE openid=:openid AND weid=:uniacid AND enable = 1",array(':uniacid' => $_W['uniacid'],':openid' => $fromuser));
    //微信通知
    $url = $type == 2  ? $_W['siteroot'] . "app/index.php?i={$_W['uniacid']}&c=entry&op=grab&id={$id}&do=report&m=xfeng_community" : $_W['siteroot'] . "app/index.php?i={$_W['uniacid']}&c=entry&op=grab&id={$id}&do=repair&m=xfeng_community";
    $tpl = pdo_fetch("SELECT * FROM" . tablename('xcommunity_wechat_tplid') . "WHERE uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
    $template_id = $type == 2 ? $tpl['report_tplid'] : $tpl['repair_tplid'];
    $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
    $content = array(
        'first'    => array(
            'value' => '新通知',
        ),
        'keyword1' => array(
            'value' => $user[realname],
        ),
        'keyword2' => array(
            'value' => $user[mobile],
        ),
        'keyword3' => array(
            'value' => $title.$user[address],
        ),
        'keyword4' => array(
            'value' => $cont,
        ),
        'keyword5' => array(
            'value' => $createtime,
        ),
        'remark'   => array(
            'value' => '请尽快联系客户。',
        ),
    );
    load()->classs('weixin.account');
    load()->func('communication');
    $obj = new WeiXinAccount();
    $access_token = $obj->fetch_available_token();
    $data = array(
        'touser' => $openid,
        'template_id' => $template_id,
        'url' => $url,
        'topcolor' => "#FF0000",
        'data' => $content,
    );
    $json = json_encode($data);
    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
    $ret = ihttp_post($url,$json);
    return $ret;

}
//小区支付调用
function xqwechat_build($params, $wechat) {
    global $_W;
    load()->func('communication');
    if (empty($wechat['version']) && !empty($wechat['signkey'])) {
        $wechat['version'] = 1;
    }
    $wOpt = array();
    if ($wechat['version'] == 1) {
        $wOpt['appId'] = $wechat['appid'];
        $wOpt['timeStamp'] = TIMESTAMP;
        $wOpt['nonceStr'] = random(8);
        $package = array();
        $package['bank_type'] = 'WX';
        $package['body'] = $params['title'];
        $package['attach'] = $_W['uniacid'];
        $package['partner'] = $wechat['partner'];
        $package['out_trade_no'] = $params['uniontid'];
        $package['total_fee'] = $params['fee'] * 100;
        $package['fee_type'] = '1';
        $package['notify_url'] = $_W['siteroot'] . "addons/xfeng_community/payment/wechat/notify.php";
        $package['spbill_create_ip'] = CLIENT_IP;
        $package['time_start'] = date('YmdHis', TIMESTAMP);
        $package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
        $package['input_charset'] = 'UTF-8';
        if (!empty($wechat['sub_mch_id'])) {
            $package['sub_mch_id'] = $wechat['sub_mch_id'];
        }
        ksort($package);
        $string1 = '';
        foreach($package as $key => $v) {
            if (empty($v)) {
                continue;
            }
            $string1 .= "{$key}={$v}&";
        }
        $string1 .= "key={$wechat['key']}";
        $sign = strtoupper(md5($string1));

        $string2 = '';
        foreach($package as $key => $v) {
            $v = urlencode($v);
            $string2 .= "{$key}={$v}&";
        }
        $string2 .= "sign={$sign}";
        $wOpt['package'] = $string2;

        $string = '';
        $keys = array('appId', 'timeStamp', 'nonceStr', 'package', 'appKey');
        sort($keys);
        foreach($keys as $key) {
            $v = $wOpt[$key];
            if($key == 'appKey') {
                $v = $wechat['signkey'];
            }
            $key = strtolower($key);
            $string .= "{$key}={$v}&";
        }
        $string = rtrim($string, '&');
        $wOpt['signType'] = 'SHA1';
        $wOpt['paySign'] = sha1($string);
        return $wOpt;
    } else {
        $package = array();
        $package['appid'] = $wechat['appid'];
        $package['mch_id'] = $wechat['mchid'];
        $package['nonce_str'] = random(8);
        $package['body'] = $params['title'];
        $package['attach'] = $_W['uniacid'];
        $package['out_trade_no'] = $params['uniontid'];
        $package['total_fee'] = $params['fee'] * 100;
        $package['spbill_create_ip'] = CLIENT_IP;
        $package['time_start'] = date('YmdHis', TIMESTAMP);
        $package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
        $package['notify_url'] = $_W['siteroot'] . "addons/xfeng_community/payment/wechat/notify.php";
        $package['trade_type'] = 'JSAPI';
        $package['openid'] = empty($wechat['openid']) ? $_W['openid'] : $wechat['openid'];
        if (!empty($wechat['sub_mch_id'])) {
            $package['sub_mch_id'] = $wechat['sub_mch_id'];
        }
        ksort($package, SORT_STRING);
        $string1 = '';
        foreach($package as $key => $v) {
            if (empty($v)) {
                continue;
            }
            $string1 .= "{$key}={$v}&";
        }
        $string1 .= "key={$wechat['signkey']}";
        $package['sign'] = strtoupper(md5($string1));
        $dat = array2xml($package);
        $response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
        if (is_error($response)) {
            return $response;
        }
        $xml = @isimplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
        if (strval($xml->return_code) == 'FAIL') {
            return error(-1, strval($xml->return_msg));
        }
        if (strval($xml->result_code) == 'FAIL') {
            return error(-1, strval($xml->err_code).': '.strval($xml->err_code_des));
        }
        $prepayid = $xml->prepay_id;
        $wOpt['appId'] = $wechat['appid'];
        $wOpt['timeStamp'] = TIMESTAMP;
        $wOpt['nonceStr'] = random(8);
        $wOpt['package'] = 'prepay_id='.$prepayid;
        $wOpt['signType'] = 'MD5';
        ksort($wOpt, SORT_STRING);
        foreach($wOpt as $key => $v) {
            $string .= "{$key}={$v}&";
        }
        $string .= "key={$wechat['signkey']}";
        $wOpt['paySign'] = strtoupper(md5($string));
        return $wOpt;
    }
}

function getRandomString($len, $chars=null)
{
    if (is_null($chars)){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    }
    mt_srand(10000000*(double)microtime());
    for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
        $str .= $chars[mt_rand(0, $lc)];
    }
    return $str;
}
function xqmenu(){
    global $_W,$_GPC;
    $menus = pdo_fetchall("SELECT * FROM".tablename('xcommunity_menu')."WHERE 1");
    if (empty($menus)) {
        $data = array(
            array('id' => 1,'pcate' => 0, 'title' => '基础设置', 'url' => './index.php?c=site&a=entry&do=manage&method=manage&m=xfeng_community', 'do'=> 'manage', 'method' => 'manage'),
            array('id' => 2,'pcate' => 0, 'title' => '物业服务', 'url' => './index.php?c=site&a=entry&do=fun&method=fun&m=xfeng_community', 'do'=> 'fun', 'method' => 'fun'),
            array('id' => 3,'pcate' => 0, 'title' => '小区超市', 'url' => './index.php?c=site&a=entry&do=shop&method=shop&m=xfeng_community','do'=> 'shop',  'method' => 'shop'),
            array('id' => 4,'pcate' => 0, 'title' => '小区商家', 'url' => './index.php?c=site&a=entry&do=seller&method=seller&m=xfeng_community', 'do'=> 'seller', 'method' => 'seller'),
            array('id' => 5,'pcate' => 0, 'title' => '分权系统', 'url' => './index.php?c=site&a=entry&do=perm&method=perm&m=xfeng_community', 'do'=> 'perm', 'method' => 'perm'),
            array('id' => 6,'pcate' => 0, 'title' => '云服务', 'url' => './index.php?c=site&a=entry&do=system&method=system&m=xfeng_community', 'do' => 'system', 'method' => 'system')
        );
        foreach ($data as $key => $value) {
            pdo_insert('xcommunity_menu', $value);
        }
        $dat = array(
            array('pcate' => 1, 'title' => '小区设置', 'url' => './index.php?c=site&a=entry&do=set&m=xfeng_community', 'do' => 'set', 'method' => 'manage'),
            array('pcate' => 1, 'title' => '通知管理', 'url' => './index.php?c=site&a=entry&op=list&do=notice&m=xfeng_community',  'do' => 'notice', 'method' => 'manage'),
            array('pcate' => 1, 'title' => '短信设置', 'url' => './index.php?c=site&a=entry&do=sms&m=xfeng_community', 'do' => 'sms', 'method' => 'manage'),
            array('pcate' => 1, 'title' => '菜单设置', 'url' => './index.php?c=site&a=entry&op=list&do=nav&m=xfeng_community',  'do' => 'nav', 'method' => 'manage'),
            array('pcate' => 1, 'title' => '模板设置', 'url' => './index.php?c=site&a=entry&op=list&do=style&m=xfeng_community', 'do' => 'style', 'method' => 'manage'),
            array('pcate' => 1, 'title' => '幻灯管理', 'url' => './index.php?c=site&a=entry&op=list&do=slide&m=xfeng_community',  'do' => 'slide', 'method' => 'manage'),
            array('pcate' => 1, 'title' => '二维码管理', 'url' => './index.php?c=site&a=entry&op=list&do=qr&m=xfeng_community',  'do' => 'qr', 'method' => 'manage'),
            array('pcate' => 1, 'title' => '打印机设置', 'url' => './index.php?c=site&a=entry&op=list&do=print&m=xfeng_community',  'do' => 'print', 'method' => 'manage'),
            array('pcate' => 1, 'title' => '模板消息设置', 'url' => './index.php?c=site&a=entry&do=tpl&m=xfeng_community',  'do' => 'tpl', 'method' => 'manage'),
            array('pcate' => 1, 'title' => '支付方式设置', 'url' => './index.php?c=site&a=entry&do=pay&m=xfeng_community',  'do' => 'pay', 'method' => 'manage'),
            array('pcate' => 1, 'title' => '独立支付接口', 'url' => './index.php?c=site&a=entry&do=payapi&m=xfeng_community',  'do' => 'payapi', 'method' => 'manage'),
            array('pcate' => 2, 'title' => '小区管理', 'url' => './index.php?c=site&a=entry&op=list&do=region&m=xfeng_community', 'do' => 'region', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '房号管理', 'url' => './index.php?c=site&a=entry&op=list&do=room&m=xfeng_community', 'do' => 'room', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '物业管理', 'url' => './index.php?c=site&a=entry&op=list&do=property&m=xfeng_community',  'do' => 'property', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '业主管理', 'url' => './index.php?c=site&a=entry&op=list&do=member&m=xfeng_community',  'do' => 'member', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '智能门禁', 'url' => './index.php?c=site&a=entry&op=list&do=building&m=xfeng_community','do' => 'building', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '小区公告', 'url' => './index.php?c=site&a=entry&op=list&do=announcement&m=xfeng_community',  'do' => 'announcement', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '小区报修', 'url' => './index.php?c=site&a=entry&op=list&do=repair&m=xfeng_community', 'do' => 'repair', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '意见建议', 'url' => './index.php?c=site&a=entry&op=list&do=report&m=xfeng_community',  'do' => 'report', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '家政服务', 'url' => './index.php?c=site&a=entry&op=list&do=homemaking&m=xfeng_community', 'do' => 'homemaking', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '租赁服务', 'url' => './index.php?c=site&a=entry&op=list&do=houselease&m=xfeng_community',  'do' => 'houselease', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '缴物业费', 'url' => './index.php?c=site&a=entry&op=list&do=cost&m=xfeng_community',  'do' => 'cost', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '小区活动', 'url' => './index.php?c=site&a=entry&op=list&do=activity&m=xfeng_community',  'do' => 'activity', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '便民查询', 'url' => './index.php?c=site&a=entry&op=list&do=search&m=xfeng_community',  'do' => 'search', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '便民号码', 'url' => './index.php?c=site&a=entry&op=list&do=phone&m=xfeng_community',  'do' => 'phone', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '二手市场', 'url' => './index.php?c=site&a=entry&op=list&do=fled&m=xfeng_community',  'do' => 'fled', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '小区拼车', 'url' => './index.php?c=site&a=entry&op=list&do=car&m=xfeng_community',  'do' => 'car', 'method' => 'fun'),
            array('pcate' => 2, 'title' => '黑名单管理', 'url' => './index.php?c=site&a=entry&op=list&do=black&m=xfeng_community',  'do' => 'black', 'method' => 'fun'),
            array('pcate' => 3, 'title' => '订单管理', 'url' => './index.php?c=site&a=entry&op=order&do=shopping&m=xfeng_community', 'do' => 'shoppingorder', 'method' => 'shop'),
            array('pcate' => 3, 'title' => '商品管理', 'url' => './index.php?c=site&a=entry&op=goods&do=shopping&m=xfeng_community', 'do' => 'shoppinggoods', 'method' => 'shop'),
            array('pcate' => 3, 'title' => '商品分类', 'url' => './index.php?c=site&a=entry&op=list&do=category&type=5&m=xfeng_community','do' => 'category', 'method' => 'shop'),
            array('pcate' => 3, 'title' => '提现审核', 'url' => './index.php?c=site&a=entry&op=cash&do=shopping&m=xfeng_community', 'do' => 'shoppingcash', 'method' => 'shop'),
            array('pcate' => 3, 'title' => '管理员管理', 'url' => './index.php?c=site&a=entry&op=notice&do=shopping&m=xfeng_community', 'do' => 'shoppingnotice', 'method' => 'shop'),
            array('pcate' => 3, 'title' => '打印机管理', 'url' => './index.php?c=site&a=entry&op=print&do=shopping&m=xfeng_community', 'do' => 'shoppingprint', 'method' => 'shop'),
            array('pcate' => 4,'title' => '店铺分类','url' => './index.php?c=site&a=entry&op=list&type=6&do=category&m=xfeng_community','do' => 'category','method' => 'seller'),
            array('pcate' => 4, 'title' => '店铺管理', 'url' => './index.php?c=site&a=entry&op=dp&do=business&m=xfeng_community', 'do' => 'businessdp', 'method' => 'seller'),
            array('pcate' => 4, 'title' => '卡券核销', 'url' => './index.php?c=site&a=entry&op=coupon&do=business&m=xfeng_community', 'do' => 'businesscoupon', 'method' => 'seller'),
            array('pcate' => 4, 'title' => '提现审核', 'url' => './index.php?c=site&a=entry&op=cash&do=business&m=xfeng_community', 'do' => 'businesscash', 'method' => 'seller'),
            array('pcate' => 4, 'title' => '订单管理', 'url' => './index.php?c=site&a=entry&op=order&do=business&m=xfeng_community','do' => 'businessorder', 'method' => 'seller'),
            array('pcate' => 4, 'title' => '管理员管理', 'url' => './index.php?c=site&a=entry&op=notice&do=business&m=xfeng_community','do' => 'businessnotice', 'method' => 'seller'),
            array('pcate' => 5, 'title' => '用户管理', 'url' => './index.php?c=site&a=entry&op=list&do=users&m=xfeng_community', 'do' => 'userslist', 'method' => 'perm'),
            array('pcate' => 5, 'title' => '小区套餐', 'url' => './index.php?c=site&a=entry&op=list&do=control&m=xfeng_community',  'do' => 'controllist', 'method' => 'perm'),
            array('pcate' => 6, 'title' => '系统授权', 'url' => './index.php?c=site&a=entry&op=display&do=system&m=xfeng_community', 'do' => 'systemdisplay', 'method' => 'system'),
        );
        foreach ($dat as $key => $val) {
            pdo_insert('xcommunity_menu', $val);
        }
    }
}
function ln_syssetting_read($regionid,$key){
    global $_W;
    $settings = pdo_get('xcommunity_setting', array('regionid'=>$regionid,'key'=> $key,'uniacid' => $_W['uniacid']), array('value'),array('value'));
    if (@is_array($settings)) {
        $settings = @iunserializer($settings['value']);
    }
    return $settings;
}
function ln_syssetting_save($data,$key, $regionid) {
    global $_W;
    if (empty($key)) {
        return FALSE;
    }

    $record = array();
    $record['value'] = iserializer($data);
    $exists = pdo_get('xcommunity_setting', array('regionid'=>$regionid,'key'=> $key,'uniacid' => $_W['uniacid']),array('id'));
    if ($exists) {
        $return = pdo_update('xcommunity_setting', $record, array('regionid' => $regionid,'key'=> $key,'uniacid' => $_W['uniacid']));
    } else {
        $record['regionid'] = $regionid;
        $record['uniacid'] = $_W['uniacid'];
        $record['key'] = $key;
        $return = pdo_insert('xcommunity_setting', $record);
    }
    return $return;
}
function upload_cert($fileinput)
{
    global $_W;
    $path = IA_ROOT . "/attachment/xfeng_community/cert_2/". $_W['uniacid'];
    load()->func('file');
    mkdirs($path, '0777');
    if($fileinput == 'sy_cert'){
        $f           = $fileinput . '_' . date('YmdHi') . random(10, 1) . '.sm2';
    }elseif($fileinput == 'gy_cert'){
        $f           = $fileinput . '_' . date('YmdHi') . random(10, 1) . '.cer';
    }

    $outfilename = $path . "/" . $f;
    $filename    = $_FILES[$fileinput]['name'];
    $tmp_name    = $_FILES[$fileinput]['tmp_name'];
    if (!empty($filename) && !empty($tmp_name)) {
        $ext = strtolower(substr($filename, strrpos($filename, '.')));
        if($fileinput == 'sy_cert'){
            if ($ext != '.sm2') {

                $errinput = "私钥证书文件格式错误";
            }
            message($errinput . ',请重新上传!', '', 'error');
        }
        if($fileinput == 'gy_cert'){
            if ($ext != '.cer') {

                $errinput = "公钥证书文件格式错误";
            }
            message($errinput . ',请重新上传!', '', 'error');
        }
        move_uploaded_file($tmp_name,$outfilename);
        return   $f;
    }
    return "";
}
function readnotice($regionid){
    global $_W;
    $row  = pdo_fetchall("select * from ".tablename("xcommunity_announcement")." where weid=:uniacid",array(':uniacid' => $_W['uniacid']));
    $nav = array();
    foreach ($row as $key => $value) {
        if($value['regionid'] != 'N;'){
            $regions = $value['regionid'];
            if (strpos($regions,$regionid) !==false) {
                $nav[] = array(
                    'id' => $value['id']
                );
            }

        }
    }
    $c1 = count($nav);
    $c2 = pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_reading_member')."WHERE uniacid =:uniacid AND openid=:openid",array(':openid' => $_W['openid'],':uniacid' => $_W['uniacid']));
    $count = ($c1-$c2) > 0 ? $c1-$c2 : 0  ;

    return $count;
}
function pdmenu($do)
{
    //判断是否游客
    global $_W;
    $menu = pdo_get('xcommunity_nav', array('do' => $do, 'uniacid' => $_W['uniacid']), array('view'));
    return $menu;
}
