<?php
/**
 *
 *
 *
 */
defined('IN_IA') or exit('Access Denied');
load()->classs('wesession');
define('EARTH_RADIUS', 6378.137);//地球半径
define('PI', 3.1415926);
!defined('XQ_PATH') && define('XQ_PATH', IA_ROOT . '/addons/xfeng_community/');
require_once IA_ROOT . '/addons/xfeng_community/model.php';
class Xfeng_communityModuleSite extends WeModuleSite
{

    function __construct()
    {
        global $_W, $_GPC;
        // 验证信息11


    }

    //后台菜单
    public function NavMenu($do, $method)
    {
        global $_W;
        if ($_W['uid'] != 1) {
            $user = pdo_fetch("SELECT * FROM" . tablename("xcommunity_users") . "WHERE uid=:uid", array(":uid" => $_W['uid']));
        }
        $condition = '';
        if ($user && ($user['type'] != 4)) {
            if (empty($user['menus'])) {
                message('没有操作权限,请联系管理员。', referer(), 'error');
                exit();
            }
            $condition .= " AND id in({$user['menus']})";
        }
        if ($method) {
            $condition .= " AND method =:method ";
            $parms[':method'] = $method;
        }
        $menu = pdo_fetchall("SELECT * FROM" . tablename('xcommunity_menu') . "WHERE pcate = 0 $condition", $parms);
        if (!$_W['isfounder']) {
            foreach ($menu as $key => $val) {
                if ($val['do'] != 'system') {
                    $menus[] = $val;
                }
            }
        }
        else {
            $menus = $menu;
        }
        $navmenus = array();
        if (!empty($menus)) {
            foreach ($menus as $key => $menu) {
                $con = " pcate =:pcate";
                $params[':pcate'] = $menu['id'];
                if ($method) {
                    $con .= " AND method =:method ";
                    $params[':method'] = $method;
                }
                if ($user['menus']) {
                    $con .= " AND id in({$user['menus']})";
                }
                $m1 = pdo_fetchall("SELECT title,url,id,do,method FROM" . tablename('xcommunity_menu') . "WHERE $con", $params);
                $m = '';
                if (!$_W['isfounder']) {
                    foreach ($m1 as $key => $val) {
                        if ($val['do'] != 'controllist') {
                            $m[] = $val;
                        }
                    }
                }
                else {
                    $m = $m1;
                }
                $navmenus[] = array(
                    'title'  => $menu['title'],
                    'items'  => $m,
                    'id'     => $menu['id'],
                    'do'     => $menu['do'],
                    'method' => $menu['method'],
                    'url'    => $menu['url'],
                    'icon'   => $menu['icon']
                );
            }
            foreach ($navmenus as $key => $menu) {
                foreach ($menu['items'] as $k => $m) {
                    if ($do == $m['do']) {
                        $navmenus[$key]['items'][$k]['active'] = ' active';
                    }
                }
            }
        }
        return $navmenus;
    }

    public function Xqmenu()
    {
        global $_W;
        if ($_W['uid'] != 1) {
            $user = pdo_fetch("SELECT * FROM" . tablename("xcommunity_users") . "WHERE uid=:uid", array(":uid" => $_W['uid']));
        }
        $condition = '';
        if ($user && ($user['type'] != 4)) {
            if (empty($user['menus'])) {
                message('没有操作权限,请联系管理员。', referer(), 'error');
                exit();
            }
            $condition .= "AND id in({$user['menus']})";
        }
        $menu = pdo_fetchall("SELECT * FROM" . tablename('xcommunity_menu') . "WHERE pcate = 0 $condition");
        if (!$_W['isfounder']) {
            foreach ($menu as $key => $val) {
                if ($val['do'] != 'system') {
                    $menus[] = $val;
                }
            }
        }
        else {
            $menus = $menu;
        }
        return $menus;
    }

    //开关控制表
    public function set($regionid, $key)
    {
        global $_W;
        $set = ln_syssetting_read($regionid, $key);
        return $set;
    }

    //判断是否是操作员管理
    public function user()
    {
        global $_W;
        $user = pdo_fetch("SELECT * FROM" . tablename("xcommunity_users") . "WHERE uid=:uid", array(":uid" => $_W['uid']));
        return $user;
    }

    //获取当前公众号所有小区信息
    public function regions()
    {
        global $_W;
        $condition = " weid = {$_W['uniacid']}";
        $user = $this->user();
        if ($user[type] == 3) {
            $condition .= " and id in({$user['regionid']})";
        }
        $regions = pdo_getall('xcommunity_region', $condition, array('id', 'title', 'keyword'));
        return $regions;
    }

    //获取当前小区名称
    public function region($regionid)
    {
        global $_W;
        $region = pdo_fetch("SELECT * FROM" . tablename('xcommunity_region') . "WHERE weid='{$_W['weid']}' AND id=:regionid", array(':regionid' => $regionid));
        return $region;
    }

    //暂时用作游客购买商品地址使用
    public function address($openid, $regionid)
    {
        global $_W;
        $address = pdo_get('xcommunity_member_address', array('openid' => $openid, 'regionid' => $regionid), array('realname', 'telephone', 'address'));
        return $address;
    }

    //获取模板名称
    public function xqtpl($tpl)
    {
        global $_W;
        $community = 'community' . $_W['uniacid'];
        $style = $_W['setting'][$community]['styleid'];
        $styleid = $style ? $style : 'style5';
        $tpl = $styleid . '/' . $tpl;
        return $tpl;
    }

    public function mreg()
    {
        global $_W;
        $member = $this->changemember();
        $region = pdo_fetch("SELECT * FROM" . tablename('xcommunity_region') . "WHERE id='{$member['regionid']}'");
        return $region;
    }

    //判断是否注册成为小区用户
    public function changemember($type,$regionid)
    {
        global $_GPC, $_W;
        if($type =='visit'&&$regionid){
            $m = pdo_get('xcommunity_member',array('openid' => $_W['fans']['from_user'],'regionid' => $regionid),array('id'));
            if(empty($m)){
                $userinfo = $this->member($_W['fans']['from_user']);
                if($userinfo){
                    pdo_update('xcommunity_member',array('enable' => 0),array('id' => $userinfo['id']));
                }
                $data = array(
                    'weid'       => $_W['uniacid'],
                    'createtime' => TIMESTAMP,
                    'regionid'   => $regionid,
                    'status'     => 1,
                    'openid'     => $_W['fans']['from_user'],
                    'memberid'   => $_W['member']['uid'],
                    'type'       => 1,
                    'enable'     => 1
                );
                pdo_insert('xcommunity_member', $data);
            }
            exit();
        }

        $member = array();
        if ($_W['openid']) {
            if($regionid){
                $condition = array(
                    'openid' => $_W['fans']['from_user'],
                    'weid'   => $_W['uniacid'],
                    'regionid' => $regionid
                );
                $member = pdo_get('xcommunity_member', $condition, array('id', 'regionid', 'openid', 'realname', 'mobile', 'build', 'room', 'address', 'remark', 'status', 'type', 'enable', 'open_status', 'createtime', 'memberid', 'openid'));
                if (empty($member)) {
                    header("Location:" . $this->createMobileUrl('register',array('op' => 'member','regionid' => $regionid)));
                    exit;
                }else{
                    if(empty($member['enable'])){
                        $userinfo = $this->member($_W['fans']['from_user']);
                        if($userinfo){
                            pdo_update('xcommunity_member',array('enable' => 0),array('id' => $userinfo['id']));
                        }
                        pdo_update('xcommunity_member',array('enable' => 1),array('id'=>$member['id']));
                    }
                }
            }else{
                $condition = array(
                    'openid' => $_W['fans']['from_user'],
                    'weid'   => $_W['uniacid'],
                    'enable' => 1
                );
                $member = pdo_get('xcommunity_member', $condition, array('id', 'regionid', 'openid', 'realname', 'mobile', 'build', 'room', 'address', 'remark', 'status', 'type', 'enable', 'open_status', 'createtime', 'memberid', 'openid'));
            }

            if ($member['mobile'] && $member['status'] == 0) {
                message('耐心等待管理员审核', '', 'success');
            }
            $xqset = $this->set($member['regionid'], 'xqset');
            if (empty($xqset['visit'])) {
                //判断是关闭游客情况下，之前已经注册过游客的用户
                if ($member && empty($member['mobile'])) {
                    header("Location:" . $this->createMobileUrl('register', array('op' => 'member', 'regionid' => $member['regionid'])));
                    exit;
                }
            }
            if (empty($member)) {
                header("Location:" . $this->createMobileUrl('register'));
                exit;
            }
            else {
                return $member;
                exit();
            }
        }
    }

    //获取会员信息
    public function member($openid)
    {
        global $_W;
        $member = pdo_fetch("SELECT * FROM" . tablename('xcommunity_member') . "WHERE openid=:openid AND weid=:uniacid AND enable = 1", array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
        return $member;
    }

    //报修投诉短信提醒
    public function Resms($content, $tpl_id, $appkey, $mmobile, $mobile)
    {
        global $_W, $_GPC;
        $tpl_value = urlencode("#content#=$content&#mobile#=$mobile");
        $params = "mobile=" . $mmobile . "&tpl_id=" . $tpl_id . "&tpl_value=" . $tpl_value . "&key=" . $appkey;
        load()->func('communication');
        $url = 'http://v.juhe.cn/sms/send';
        $content = ihttp_post($url, $params);
    }

    /**
     * 读取excel $filename 路径文件名 $indata 返回数据的编码 默认为utf8
     *以下基本都不要修改
     */
    public function read($filename, $encode = 'utf-8')
    {
        require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel = PHPExcel_IOFactory::load($filename);
        $indata = $objPHPExcel->getSheet(0)->toArray();
        return $indata;

    }

    //导出数据
    public function export($list, $params = array())
    {
        if (PHP_SAPI == 'cli') {
            die('This example should only be run from a Web Browser');
        }
        require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator("微小区")->setLastModifiedBy("微小区")->setTitle("Office 2007 XLSX Test Document")->setSubject("Office 2007 XLSX Test Document")->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("report file");
        $sheet = $excel->setActiveSheetIndex(0);
        $rownum = 1;
        foreach ($params['columns'] as $key => $column) {
            $sheet->setCellValue(column($key, $rownum), $column['title']);
            if (!empty($column['width'])) {
                $sheet->getColumnDimension(column_str($key))->setWidth($column['width']);
            }
        }
        $rownum++;
        foreach ($list as $row) {
            $len = count($row);
            for ($i = 0; $i < $len; $i++) {
                $value = $row[$params['columns'][$i]['field']];
                $sheet->setCellValue(column($i, $rownum), $value);
            }
            $rownum++;
        }
        $excel->getActiveSheet()->setTitle($params['title']);
        $filename = urlencode($params['title'] . '-' . date('Y-m-d H:i', time()));
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $writer->save('php://output');
        exit;
    }

    //处理图片上传;
    public function doMobileimgupload()
    {
        global $_W, $_GPC;
        if (!empty($_GPC['pic'])) {
            preg_match("/data\:image\/([a-z]{1,5})\;base64\,(.*)/", $_GPC['pic'], $r);
            $imgname = 'bl' . time() . rand(10000, 99999) . '.' . 'jpg';
            $path = IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/images/';
            $f = fopen($path . $imgname, 'w+');
            fwrite($f, base64_decode($r[2]));
            fclose($f);
            /** @var  $dst_path 生成图片水印 */
            $dst_path = ATTACHMENT_ROOT . 'images/' . $imgname;
            $iinfo = getimagesize($dst_path);
            $nimage = imagecreatetruecolor($iinfo[0], $iinfo[1]);//获取图片的相关信息，得到数组
            $white = imagecolorallocate($nimage, 255, 255, 255); //设置背景颜色为白色
            $black = imagecolorallocate($nimage, 255, 0, 0);  //设置背景颜色为黑色
            $red = imagecolorallocate($nimage, 255, 0, 0);  //设置背景颜色为红色
            imagefill($nimage, 0, 0, $white);     //背景填充为白色
            switch ($iinfo[2]) {
                case 1:
                    $simage = imagecreatefromgif($dst_path);
                    break;
                case 2:
                    $simage = imagecreatefromjpeg($dst_path);
                    break;
                case 3:
                    $simage = imagecreatefrompng($dst_path);
                    break;
                case 6:
                    $simage = imagecreatefromwbmp($dst_path);
                    break;
                default:
                    die("不支持的文件类型");
                    exit;
            }
            imagecopy($nimage, $simage, 0, 0, 0, 0, $iinfo['0'], $iinfo['1']);
            $watertype = 1;//水印类型(1为文字,2为图片)
            $watercontent = date('Y-m-d H:i', TIMESTAMP);//水印的内容
            switch ($watertype) {
                case 1:             //加水印字符串
                    imagestring($nimage, 5, 5, 5, $watercontent, $black);
                    break;
                case 2:            //加水印图片
                    $simage1 = imagecreatefromgif($watercontent);
                    $size = getimagesize($watercontent);
                    imagecopy($nimage, $simage1, $iinfo['0'] / 2 + 50, $iinfo['1'] - 100, 0, 0, $size[0], $size[1]);
                    imagedestroy($simage1);
                    break;
            }
            switch ($iinfo[2]) {
                case 1:
                    imagejpeg($nimage, $dst_path); //将图像$nimage以$destination文件名创建一个jpeg的格式文件
                    break;
                case 2:
                    imagejpeg($nimage, $dst_path);
                    break;
                case 3:
                    imagepng($nimage, $dst_path);
                    break;
                case 6:
                    imagewbmp($nimage, $dst_path);
                    break;
            }
            imagedestroy($nimage);    //覆盖原上传文件
            imagedestroy($simage);

            /** @var  $pathname */
            $pathname = 'images/' . $imgname;
            if (!empty($_W['setting']['remote']['type'])) { // 判断系统是否开启了远程附件
                load()->func('file');
                $remotestatus = file_remote_upload($pathname); //上传图片到远程
                if (is_error($remotestatus)) {
                    message('远程附件上传失败，请检查配置并重新上传');
                }
                else {
                    file_delete($pathname);
                    $remoteurl = tomedia($pathname);  // 远程图片的访问URL
                }

                $is = pdo_insert('xcommunity_images', array('src' => $remoteurl));
            }
            else {
                $imgurl = $_W['attachurl'] . $pathname;
                $is = pdo_insert('xcommunity_images', array('src' => $imgurl));
            }
            $id = pdo_insertid();
            if (empty($is)) {
                exit(json_encode(array(
                    'errCode' => 1,
                    'message' => '上传出现错误',
                    'data'    => array('id' => $_GPC['t'], 'picId' => $id)
                )));
            }
            else {
                exit(json_encode(array(
                    'errCode' => 0,
                    'message' => '上传成功',
                    'data'    => array('id' => $_GPC['id'], 'picId' => $id)
                )));
            }
        }

    }

    //获取购物车商品数量
    public function getCartTotal()
    {
        global $_W;
        $cartotal = pdo_fetchcolumn("select sum(total) from " . tablename('xcommunity_cart') . " where weid = '{$_W['uniacid']}' and from_user='{$_W['openid']}'");
        return empty($cartotal) ? 0 : $cartotal;
    }

    //设置订单商品的库存 minus  true 减少  false 增加
    public function setOrderStock($id = '', $minus = true)
    {
        $goods = pdo_fetchall("SELECT g.id, g.title, g.thumb, g.unit, g.marketprice,g.total as goodstotal,o.total FROM " . tablename('xcommunity_order_goods') . " o left join " . tablename('xcommunity_goods') . " g on o.goodsid=g.id "
            . " WHERE o.orderid='{$id}'");
        foreach ($goods as $item) {
            if ($minus) {

                $data = array();
                if (!empty($item['goodstotal']) && $item['goodstotal'] != -1) {
                    $data['total'] = $item['goodstotal'] - $item['total'];
                }

                pdo_update('xcommunity_goods', $data, array('id' => $item['id']));
            }
            else {

                $data = array();
                if (!empty($item['goodstotal']) && $item['goodstotal'] != -1) {
                    $data['total'] = $item['goodstotal'] + $item['total'];
                }

                pdo_update('xcommunity_goods', $data, array('id' => $item['id']));
            }
        }
    }

    //处理支付回调
    public function payResult($params)
    {
        global $_W;
        $fee = $params['fee'];
        $ordersn = $params['tid'];
        $data = array('status' => $params['result'] == 'success' ? 1 : 0);
        $paytype = array('credit' => '1', 'wechat' => '2', 'alipay' => '2', 'delivery' => '3');
        $data['paytype'] = $paytype[$params['type']];
        if ($params['type'] == 'wechat') {
            $data['transid'] = $params['tag']['transaction_id'];
        }
        $set = $this->set('', 'tyset');
        //货到付款
        if ($params['type'] == 'credit' || $params['type'] == 'delivery') {
            if (empty($params['tid'])) {
                return false;
            }
        }
        if ($params['type'] == 'delivery') {

            $data['status'] = 1;
            $data['paytype'] = 3;
            $order = pdo_fetch("SELECT * FROM" . tablename('xcommunity_order') . "WHERE ordersn=:ordersn", array(':ordersn' => $ordersn));
            $m1 = pdo_fetch("SELECT * FROM" . tablename('xcommunity_member') . "WHERE openid=:openid and regionid=:regionid", array(':openid' => $order['from_user'], 'regionid' => $order['regionid']));
            $address = pdo_get('xcommunity_member_address', array('openid' => $order['from_user'], 'regionid' => $order['regionid']), array('realname', 'address', 'telephone'));
            $m2 = array(
                'realname' => $address['realname'],
                'address'  => $address['address'],
                'mobile'   => $address['telephone'],
                'regionid' => $address['regionid']
            );
            if ($m1['mobile']) {
                $member = $m1;
            }
            else {
                $member = $m2;
            }

            if ($order['type'] == 'shopping') {

                $sql = 'SELECT * FROM ' . tablename('xcommunity_order_goods') . ' WHERE `orderid` = :orderid';
                $goods = pdo_fetch($sql, array(':orderid' => $order['id']));
                $sql = 'SELECT * FROM ' . tablename('xcommunity_goods') . ' WHERE `id` = :id';
                $goodsInfo = pdo_fetch($sql, array(':id' => $goods['goodsid']));
                // 更改库存
                if ($goodsInfo['totalcnf'] == '1' && !empty($goodsInfo['total'])) {
                    pdo_update('xcommunity_goods', array('total' => $goodsInfo['total'] - 1), array('id' => $goodsInfo['id']));
                }
                //微信提醒
               // $member = pdo_fetch("SELECT * FROM" . tablename('xcommunity_member') . "WHERE openid=:openid", array(':openid' => $order['from_user']));
                $notice = pdo_fetchall("SELECT * FROM" . tablename('xcommunity_wechat_notice') . "WHERE uniacid=:uniacid", array('uniacid' => $_W['uniacid']));

                foreach ($notice as $key => $value) {
                    $regions = unserialize($value['regionid']);

                    if (@in_array($member['regionid'], $regions)) {

                        if ($value['shopping_status'] == 2) {
                            $openid = $value['fansopenid'];
                            $region = $this->region($member['regionid']);
                            $url = '';
                            $tpl = pdo_fetch("SELECT * FROM" . tablename('xcommunity_wechat_tplid') . "WHERE uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
                            $template_id = $tpl['good_tplid'];
                            $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
                            $content = array(
                                'first'    => array(
                                    'value' => '超市新订单通知',
                                ),
                                'keyword1' => array(
                                    'value' => $goodsInfo['title'] . ',数量:' . $goods['total'],
                                ),
                                'keyword2' => array(
                                    'value' => $order['goodsprice'] . '元',
                                ),
                                'keyword3' => array(
                                    'value' => $member['realname'] . ' ' . $region['title'] . $member['address'],
                                ),
                                'keyword4' => array(
                                    'value' => $member['mobile'],
                                ),
                                'keyword5' => array(
                                    'value' => $ordersn,
                                ),
                                'remark'   => array(
                                    'value' => $order['remark'],
                                ),
                            );
                            $result = $this->sendtpl($openid, $url, $template_id, $content);

                        }

                    }


                }
                $notice = pdo_getall('xcommunity_xqnotice', array('userid' => $order['uid'], 'status' => 1, 'type' => 1), array('username'));
                foreach ($notice as $key => $val) {
                    //微信
                    $tpl = pdo_fetch("SELECT * FROM" . tablename('xcommunity_wechat_tplid') . "WHERE uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
                    $template_id = $tpl['good_tplid'];
                    $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
                    $region = $this->region($member['regionid']);
                    $url = '';
                    $content = array(
                        'first'    => array(
                            'value' => '超市商品新订单通知',
                        ),
                        'keyword1' => array(
                            'value' => "商品：" . $goodsInfo['title'] . "数量：" . $goods['total'],
                        ),
                        'keyword2' => array(
                            'value' => $order['goodsprice'] . '元',
                        ),
                        'keyword3' => array(
                            'value' => $member['realname'] . ' ' . $region['title'] . $member['address'],
                        ),
                        'keyword4' => array(
                            'value' => $member['mobile'],
                        ),
                        'keyword5' => array(
                            'value' => $createtime,
                        ),
                        'remark'   => array(
                            'value' => '请尽快联系客户。',
                        ),
                    );
                    $this->sendtpl($val['username'], $url, $template_id, $content);
                }
                $xqprint = ln_syssetting_read('', 'print');
                $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
                if ($xqprint['typrint']) {
                    if ($xqprint['shop']) {
                        if ($xqprint['api'] == 1) {
                            $yl = ln_syssetting_read('', 'printyl');

                            $content = "^N1^F1\n";
                            $content .= "^B2 超市新订单通知\n";
                            $content .= "内容：" . $goodsInfo['title'] . ',数量:' . $goods['total'] . "\n";
                            $content .= "地址：" . $member['address'] . "\n";
                            $content .= "业主：" . $member['realname'] . "\n";
                            $content .= "电话：" . $member['mobile'] . "\n";
                            $content .= "时间：" . $createtime;
                            $result = $this->sendSelfFormatOrderInfo($yl['deviceno'], $yl['key'], 1, $content);


                        }
                        else {
                            $fy = ln_syssetting_read('', 'printfy');
                            $freeMessage = array(
                                'memberCode' => $fy['code'],
                                'msgDetail'  =>
                                    '
                                                    超市新订单通知

                                                内容：' . $goodsInfo['title'] . ',数量:' . $goods['total'] . '
                                                -------------------------

                                                地址：' . $member['address'] . '
                                                业主：' . $member['realname'] . '
                                                电话：' . $member['mobile'] . '
                                                时间：' . $createtime . '
                                                ',
                                'deviceNo'   => $fy['deviceno'],
                                'msgNo'      => $fy['key'],
                            );
                            echo $this->sendFreeMessage($freeMessage, $fy['key']);
                        }
                    }
                }
                else {
                    $print = pdo_get('xcommunity_print', array('userid' => $order['uid']), array('print_status', 'api_key', 'deviceNo'));
                    if ($print) {
                        if ($print['print_status']) {
                            $content = "^N1^F1\n";
                            $content .= "^B2 超市新订单通知\n";
                            $content .= "内容：" . $goodsInfo['title'] . ',数量:' . $goods['total'] . "\n";
                            $content .= "地址：" . $member['address'] . "\n";
                            $content .= "业主：" . $member['realname'] . "\n";
                            $content .= "电话：" . $member['mobile'] . "\n";
                            $content .= "时间：" . $createtime;
                            $result = $this->sendSelfFormatOrderInfo($print['deviceNo'], $print['api_key'], 1, $content);
                        }
                    }
                }

                //增加积分
                load()->model('mc');

                $credit = $params['fee'] * $set['shop_credit'];

                $r = mc_credit_update($member['memberid'], 'credit1', $credit, array($member['memberid'], '小区超市赠送积分'));
                pdo_update('xcommunity_order', $data, array('ordersn' => $params['tid']));


            }
            elseif ($order['type'] == 'business') {
                //处理商家团购商品成功后
                $goods = pdo_fetch("SELECT sold FROM" . tablename('xcommunity_goods') . "WHERE id=:gid", array(':gid' => $order['gid']));
                pdo_update('xcommunity_goods', array('sold' => $goods['sold'] + $order['num']), array('id' => $order['gid']));
                if ($order['uid']) {
                    //判断是否开启设置提成
                    if ($set['business_cash']) {
                        //$users = pdo_fetch("SELECT * FROM".tablename('xcommunity_users')."WHERE uniacid:uniacid AND uid=:uid",array(':uniacid' => $_W['uniacid'],':uid' => $order['uid']));
                        $users = pdo_get('xcommunity_users', array('uniacid' => $_W['uniacid'], 'uid' => $order['uid']), array('commission', 'balance'));
                        $balance = $params['fee'] * (1 - $users['commission']);
                    }
                    else {
                        $balance = $params['fee'];
                    }
                    pdo_update('xcommunity_users', array('balance' => $users['balance'] + $balance), array('uid' => $order['uid']));
                }
                $notice = pdo_getall('xcommunity_xqnotice', array('userid' => $order['uid'], 'status' => 1, 'type' => 2), array('username'));
                foreach ($notice as $key => $val) {

                    //微信
                    $tpl = pdo_fetch("SELECT * FROM" . tablename('xcommunity_wechat_tplid') . "WHERE uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
                    $template_id = $tpl['good_tplid'];
                    $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
                    $region = $this->region($member['regionid']);
                    $url = '';
                    $content = array(
                        'first'    => array(
                            'value' => '商家新订单通知',
                        ),
                        'keyword1' => array(
                            'value' => "商品：" . $goods['title'] . "数量：" . $order['num'],
                        ),
                        'keyword2' => array(
                            'value' => $order['price'] . '元',
                        ),
                        'keyword3' => array(
                            'value' => $member['realname'] . ' ' . $region['title'] . $member['address'],
                        ),
                        'keyword4' => array(
                            'value' => $member['mobile'],
                        ),
                        'keyword5' => array(
                            'value' => $createtime,
                        ),
                        'remark'   => array(
                            'value' => '请尽快联系客户。',
                        ),
                    );
                    $this->sendtpl($val['username'], $url, $template_id, $content);

                }
                //增加积分
                load()->model('mc');

                $credit = $params['fee'] * $set['business_credit'];

                $r = mc_credit_update($member['memberid'], 'credit1', $credit, array($member['memberid'], '小区商家团购赠送积分'));
                pdo_update('xcommunity_order', array('couponsn' => date('md') . random(5, 1)), array('ordersn' => $params['tid']));
            }
            message('支付成功！', $this->createMobileUrl('home'), 'success');
        }
        if ($params['result'] == 'success' && $params['from'] == 'notify') {
            if ($params['type'] == 'alipay') {
                if (empty($params['transaction_id'])) {
                    return false;
                }
            }
            if ($params['type'] == 'wechat') {
                if (empty($params['tag']['transaction_id'])) {
                    return false;
                }
            }
            $order = pdo_fetch("SELECT * FROM" . tablename('xcommunity_order') . "WHERE ordersn=:ordersn", array(':ordersn' => $ordersn));
            $m1 = pdo_fetch("SELECT * FROM" . tablename('xcommunity_member') . "WHERE openid=:openid and regionid=:regionid", array(':openid' => $order['from_user'], 'regionid' => $order['regionid']));
            $address = pdo_get('xcommunity_member_address', array('openid' => $order['from_user'], 'regionid' => $order['regionid']), array('realname', 'address', 'telephone'));
            $m2 = array(
                'realname' => $address['realname'],
                'address'  => $address['address'],
                'mobile'   => $address['telephone'],
                'regionid' => $address['regionid']
            );
            if ($m1['mobile']) {
                $member = $m1;
            }
            else {
                $member = $m2;
            }
            if ($order['type'] == 'business') {
                //处理商家团购商品成功后
                $goods = pdo_fetch("SELECT sold,title FROM" . tablename('xcommunity_goods') . "WHERE id=:gid", array(':gid' => $order['gid']));
                pdo_update('xcommunity_goods', array('sold' => $goods['sold'] + $order['num']), array('id' => $order['gid']));
                if ($order['uid']) {
                    //判断是否开启设置提成

                    if ($set['business_cash']) {
                        //$users = pdo_fetch("SELECT * FROM".tablename('xcommunity_users')."WHERE uniacid:uniacid AND uid=:uid",array(':uniacid' => $_W['uniacid'],':uid' => $order['uid']));
                        $users = pdo_get('xcommunity_users', array('uniacid' => $_W['uniacid'], 'uid' => $order['uid']), array('commission', 'balance','xqcommission'));
                        $balance = $params['fee'] * (1 - $users['commission']-$users['xqcommission']);
                        $xqbalance = $params['fee']*$users['xqcommission'];
                        pdo_update('xcommunity_region',array('commission +=' => $xqbalance),array('id' => $order['regionid']));
                    }
                    else {
                        $balance = $params['fee'];
                    }
                    pdo_update('xcommunity_users', array('balance' => $users['balance'] + $balance), array('uid' => $order['uid']));
                }
                //微信提醒
                $notice = pdo_fetchall("SELECT * FROM" . tablename('xcommunity_wechat_notice') . "WHERE uniacid=:uniacid", array('uniacid' => $_W['uniacid']));
                foreach ($notice as $key => $value) {
                    $regions = unserialize($value['regionid']);
                    if (@in_array($member['regionid'], $regions)) {
                        if ($value['business_status'] == 2) {
                            $openid = $value['fansopenid'];
                            $url = '';
                            $tpl = pdo_fetch("SELECT * FROM" . tablename('xcommunity_wechat_tplid') . "WHERE uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
                            $template_id = $tpl['good_tplid'];
                            $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
                            $content = array(
                                'first'    => array(
                                    'value' => '团购新订单通知',
                                ),
                                'keyword1' => array(
                                    'value' => $goods['title'] . ',数量:' . $order['num'],
                                ),
                                'keyword2' => array(
                                    'value' => $order['price'] . '元',
                                ),
                                'keyword3' => array(
                                    'value' => $member['realname'],
                                ),
                                'keyword4' => array(
                                    'value' => $member['mobile'],
                                ),
                                'keyword5' => array(
                                    'value' => $ordersn,
                                ),
                                'remark'   => array(
                                    'value' => $order['remark'],
                                ),
                            );
                            $this->sendtpl($openid, $url, $template_id, $content);
                        }

                    }


                }
                $notice = pdo_getall('xcommunity_xqnotice', array('userid' => $order['uid'], 'status' => 1, 'type' => 2), array('username'));
                foreach ($notice as $key => $val) {

                    //微信
                    $tpl = pdo_fetch("SELECT * FROM" . tablename('xcommunity_wechat_tplid') . "WHERE uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
                    $template_id = $tpl['good_tplid'];
                    $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
                    $region = $this->region($member['regionid']);
                    $url = '';
                    $content = array(
                        'first'    => array(
                            'value' => '商家新订单通知',
                        ),
                        'keyword1' => array(
                            'value' => "商品：" . $goods['title'] . "数量：" . $order['num'],
                        ),
                        'keyword2' => array(
                            'value' => $order['price'] . '元',
                        ),
                        'keyword3' => array(
                            'value' => $member['realname'] . ' ' . $region['title'] . $member['address'],
                        ),
                        'keyword4' => array(
                            'value' => $member['mobile'],
                        ),
                        'keyword5' => array(
                            'value' => $createtime,
                        ),
                        'remark'   => array(
                            'value' => '请尽快联系客户。',
                        ),
                    );
                    $this->sendtpl($val['username'], $url, $template_id, $content);

                }
                //增加积分
                load()->model('mc');


                $credit = $params['fee'] * $set['business_credit'];

                $r = mc_credit_update($member['memberid'], 'credit1', $credit, array($member['memberid'], '小区商家团购赠送积分'));
                pdo_update('xcommunity_order', array('couponsn' => date('md') . random(5, 1)), array('ordersn' => $params['tid']));
            }
            elseif ($order['type'] == 'pfree') {
                //更新用户物业费状态
                //增加积分
                load()->model('mc');


                $credit = $params['fee'] * $set['cost_credit'];

                $r = mc_credit_update($member['memberid'], 'credit1', $credit, array($member['memberid'], '小区缴纳物业费赠送积分'));
                pdo_update('xcommunity_cost_list', array('status' => '是'), array('id' => $order['pid']));
                pdo_update('xcommunity_order', array('createtime' => TIMESTAMP), array('ordersn' => $ordersn));
                $cost = pdo_get('xcommunity_cost_list', array('id' => $order['pid']), array('username', 'homenumber', 'total'));
                // 客服消息通知
                load()->func('communication');
                $access_token = WeAccount::token();
                $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
                $text = array(
                    "touser"  => $order['from_user'],
                    "msgtype" => "text",
                    "text"    => array(
                        "content" => '您好，您的各项物业综合费已缴费成功。如果有任何疑问，请拨打物业管理处客服电话。',
                    )
                );
                $dat = json_encode($text, JSON_UNESCAPED_UNICODE);
                ihttp_post($url, $dat);
                //微信通知
                $notice = pdo_fetchall("SELECT * FROM" . tablename('xcommunity_wechat_notice') . "WHERE uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
                foreach ($notice as $key => $value) {

                    $regions = unserialize($value['regionid']);
                    if (@in_array($member['regionid'], $regions)) {
                        $region = $this->region($member['regionid']);
                        if ($value['cost_status'] == 2) {
                            if ($value['type'] == 1 || $value['type'] == 3) {
                                //模板消息通知
                                $openid = $value['fansopenid'];
                                $url = '';
                                $tpl = pdo_fetch("SELECT * FROM" . tablename('xcommunity_wechat_tplid') . "WHERE uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
                                $template_id = $tpl['property_tplid'];
                                $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
                                $content = array(
                                    'first'    => array(
                                        'value' => '您好，有新的缴费订单。',
                                    ),
                                    'userName' => array(
                                        'value' => $cost['username'],
                                    ),
                                    'address'  => array(
                                        'value' => $region['title'].$cost['homenumber'],
                                    ),
                                    'pay'      => array(
                                        'value' => $cost['total'],
                                    ),
                                    'remark'   => array(
                                        'value' => '请尽快消单处理，并开具收据发票。缴费时间:' . $createtime . '微信订单号:' . $data['transid'],
                                    ),
                                );
                                $this->sendtpl($openid, $url, $template_id, $content);
                            }
                        }
                    }


                }
            }
            elseif ($order['type'] == 'shopping') {
                //超市商品成功后处理
                $sql = 'SELECT * FROM ' . tablename('xcommunity_order_goods') . ' WHERE `orderid` = :orderid';
                $goods = pdo_fetch($sql, array(':orderid' => $order['id']));
                $sql = 'SELECT * FROM ' . tablename('xcommunity_goods') . ' WHERE `id` = :id';
                $goodsInfo = pdo_fetch($sql, array(':id' => $goods['goodsid']));
                // 更改库存
                if ($goodsInfo['totalcnf'] == '1' && !empty($goodsInfo['total'])) {
                    pdo_update('xcommunity_goods', array('total' => $goodsInfo['total'] - 1), array('id' => $goodsId));
                }
                //$users = pdo_get('xcommunity_users', array('uniacid' => $_W['uniacid'], 'uid' => $order['uid']), array('commission', 'balance','xqcommission'));
                if ($order['uid']) {
//                    if ($set['shop_cash']) {
//                        $balance = $params['fee'] * (1 - $users['commission']-$users['xqcommission']);
//                        $xqbalance = $params['fee']*$users['xqcommission'];
//                        pdo_update('xcommunity_region',array('commission +=' => $xqbalance),array('id' => $order['regionid']));
//                    }
//                    else {
//                        $balance = $params['fee'];
//                    }
//                    pdo_update('xcommunity_users', array('balance +=' => $balance), array('uniacid' => $_W['uniacid'], 'uid' => $order['uid']));
                    if ($set['shop_cash']) {
                        //$users = pdo_fetch("SELECT * FROM".tablename('xcommunity_users')."WHERE uniacid:uniacid AND uid=:uid",array(':uniacid' => $_W['uniacid'],':uid' => $order['uid']));
                        $users = pdo_get('xcommunity_users', array('uniacid' => $_W['uniacid'], 'uid' => $order['uid']), array('commission', 'balance','xqcommission'));
                        $balance = $params['fee'] * (1 - $users['commission']-$users['xqcommission']);
                        $xqbalance = $params['fee']*$users['xqcommission'];
                        pdo_update('xcommunity_region',array('commission +=' => $xqbalance),array('id' => $order['regionid']));
                    }
                    else {
                        $balance = $params['fee'];
                    }
                    pdo_update('xcommunity_users', array('balance' => $users['balance'] + $balance), array('uid' => $order['uid']));
                }
                //微信提醒
                $tpl = pdo_fetch("SELECT * FROM" . tablename('xcommunity_wechat_tplid') . "WHERE uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
                $notice = pdo_fetchall("SELECT * FROM" . tablename('xcommunity_wechat_notice') . "WHERE uniacid=:uniacid", array('uniacid' => $_W['uniacid']));
                if ($notice) {
                    foreach ($notice as $key => $value) {
                        $regions = unserialize($value['regionid']);
                        if (@in_array($member['regionid'], $regions)) {
                            if ($value['shopping_status'] == 2) {
                                $openid = $value['fansopenid'];
                                $url = '';
                                $template_id = $tpl['good_tplid'];
                                $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
                                $region = $this->region($member['regionid']);
                                $content = array(
                                    'first'    => array(
                                        'value' => '超市新订单通知',
                                    ),
                                    'keyword1' => array(
                                        'value' => $goodsInfo['title'] . ',数量:' . $goods['total'],
                                    ),
                                    'keyword2' => array(
                                        'value' => $order['goodsprice'] . '元',
                                    ),
                                    'keyword3' => array(
                                        'value' => $member['realname'] . ' ' . $region['title'] . $member['address'],
                                    ),
                                    'keyword4' => array(
                                        'value' => $member['mobile'],
                                    ),
                                    'keyword5' => array(
                                        'value' => $ordersn,
                                    ),
                                    'remark'   => array(
                                        'value' => $order['remark'],
                                    ),
                                );
                                $this->sendtpl($openid, $url, $template_id, $content);
                            }

                        }
                    }
                }
                $xqnotice = pdo_getall('xcommunity_xqnotice', array('userid' => $order['uid'], 'status' => 1, 'type' => 1), array('username'));
                if ($xqnotice) {
                    foreach ($xqnotice as $key => $val) {
                        //微信
                        if($val['username']){
                                $template_id = $tpl['good_tplid'];
                                $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
                                $region = $this->region($member['regionid']);
                                $url = '';
                                $content = array(
                                    'first'    => array(
                                        'value' => '超市商品新订单通知',
                                    ),
                                    'keyword1' => array(
                                        'value' => "商品：" . $goodsInfo['title'] . "数量：" . $goods['total'],
                                    ),
                                    'keyword2' => array(
                                        'value' => $order['goodsprice'] . '元',
                                    ),
                                    'keyword3' => array(
                                        'value' => $member['realname'] . ' ' . $region['title'] . $member['address'],
                                    ),
                                    'keyword4' => array(
                                        'value' => $member['mobile'],
                                    ),
                                    'keyword5' => array(
                                        'value' => $createtime,
                                    ),
                                    'remark'   => array(
                                        'value' => '请尽快联系客户。',
                                    ),
                                );
                                $result = $this->sendtpl($val['username'], $url, $template_id, $content);
//                            print_r($result);
                                //$this->sendtpl($val['username'], $url, $template_id, $content);
//                            echo  qqqq;exit();
                            }
                    }
                }

                $xqprint = ln_syssetting_read('', 'print');

                $createtime = date('Y-m-d H:i:s', $_W['timestamp']);

                $print = pdo_get('xcommunity_print', array('userid' => $order['uid']), array('print_status', 'api_key', 'deviceNo'));

                if ($xqprint['typrint']) {
                    if ($xqprint['shop']) {
                        if ($xqprint['api'] == 1) {
                            $yl = ln_syssetting_read('', 'printyl');

                            $content = "^N1^F1\n";
                            $content .= "^B2 超市新订单通知\n";
                            $content .= "内容：" . $goodsInfo['title'] . ',数量:' . $goods['total'] . "\n";
                            $content .= "地址：" . $member['address'] . "\n";
                            $content .= "业主：" . $member['realname'] . "\n";
                            $content .= "电话：" . $member['mobile'] . "\n";
                            $content .= "时间：" . $createtime;
                            $result = $this->sendSelfFormatOrderInfo($yl['deviceno'], $yl['key'], 1, $content);


                        }
                        else {
                            $fy = ln_syssetting_read('', 'printfy');
                            $freeMessage = array(
                                'memberCode' => $fy['code'],
                                'msgDetail'  =>
                                    '
                                                    超市新订单通知

                                                内容：' . $goodsInfo['title'] . ',数量:' . $goods['total'] . '
                                                -------------------------

                                                地址：' . $member['address'] . '
                                                业主：' . $member['realname'] . '
                                                电话：' . $member['mobile'] . '
                                                时间：' . $createtime . '
                                                ',
                                'deviceNo'   => $fy['deviceno'],
                                'msgNo'      => $fy['key'],
                            );
                            echo $this->sendFreeMessage($freeMessage, $fy['key']);
                        }
                    }
                }
                else {
                    if ($print) {
                        if ($print['print_status']) {
                            $content = "^N1^F1\n";
                            $content .= "^B2 超市新订单通知\n";
                            $content .= "内容：" . $goodsInfo['title'] . ',数量:' . $goods['total'] . "\n";
                            $content .= "地址：" . $member['address'] . "\n";
                            $content .= "业主：" . $member['realname'] . "\n";
                            $content .= "电话：" . $member['mobile'] . "\n";
                            $content .= "时间：" . $createtime;
                            $result = $this->sendSelfFormatOrderInfo($print['deviceNo'], $print['api_key'], 1, $content);
                        }
                    }
                }
                //增加积分
                load()->model('mc');

                $credit = $params['fee'] * $set['shop_credit'];

                $r = mc_credit_update($member['memberid'], 'credit1', $credit, array($member['memberid'], '小区超市赠送积分'));


            }
            elseif ($order['type'] == 'activity') {
                $r = pdo_fetch("SELECT aid,num FROM" . tablename('xcommunity_res') . "WHERE id=:id", array(':id' => $order['aid']));
                pdo_query("UPDATE " . tablename('xcommunity_res') . "SET status = 1 WHERE id=:id", array(':id' => $order['aid']));
                pdo_query("UPDATE " . tablename('xcommunity_activity') . " SET resnumber=resnumber+'{$r['num']}' WHERE id=:id", array(':id' => $r['aid']));

            }

            //更新订单状态
            pdo_update('xcommunity_order', $data, array('ordersn' => $params['tid']));
        }
        if ($params['from'] == 'return') {
            if ($params['result'] == 'success') {
                message('支付成功', $this->createMobileUrl('home'), 'success');
            }
            else {
                message('支付失败', $this->createMobileUrl('home'), 'error');
            }
        }

    }

    private function changeWechatSend($id, $status, $msg = '')
    {
        global $_W;
        $paylog = pdo_fetch("SELECT plid, openid, tag FROM " . tablename('core_paylog') . " WHERE tid = '{$id}' AND status = 1 AND type = 'wechat'");
        if (!empty($paylog['openid'])) {
            $paylog['tag'] = iunserializer($paylog['tag']);
            $acid = $paylog['tag']['acid'];
            $account = account_fetch($acid);
            $payment = uni_setting($account['uniacid'], 'payment');
            if ($payment['payment']['wechat']['version'] == '2') {
                return true;
            }
            $send = array(
                'appid'             => $account['key'],
                'openid'            => $paylog['openid'],
                'transid'           => $paylog['tag']['transaction_id'],
                'out_trade_no'      => $paylog['plid'],
                'deliver_timestamp' => TIMESTAMP,
                'deliver_status'    => $status,
                'deliver_msg'       => $msg,
            );
            $sign = $send;
            $sign['appkey'] = $payment['payment']['wechat']['signkey'];
            ksort($sign);
            $string = '';
            foreach ($sign as $key => $v) {
                $key = strtolower($key);
                $string .= "{$key}={$v}&";
            }
            $send['app_signature'] = sha1(rtrim($string, '&'));
            $send['sign_method'] = 'sha1';
            $account = WeAccount::create($acid);
            $response = $account->changeOrderStatus($send);
            if (is_error($response)) {
                message($response['message']);
            }
        }
    }

    //模板消息通知提醒
    public function sendtpl($openid, $url, $template_id, $content)
    {
        global $_GPC, $_W;
        load()->classs('weixin.account');
        load()->func('communication');
        $obj = new WeiXinAccount();
        $access_token = $obj->fetch_available_token();
        $data = array(
            'touser'      => $openid,
            'template_id' => $template_id,
            'url'         => $url,
            'topcolor'    => "#FF0000",
            'data'        => $content,
        );
        $json = json_encode($data);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;
        $ret = ihttp_post($url, $json);
        return $ret;
    }

    /**
     * 计算某个经纬度的周围某段距离的正方形的四个点
     *
     * @param lng float 经度
     * @param lat float 纬度
     * @param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
     * @return array 正方形的四个点的经纬度坐标
     */
    public function squarePoint($lng, $lat, $distance = 0.5)
    {

        $dlng = 2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);

        $dlat = $distance / EARTH_RADIUS; //EARTH_RADIUS地球半径
        $dlat = rad2deg($dlat);

        return array(
            'left-top'     => array('lat' => $lat + $dlat, 'lng' => $lng - $dlng),
            'right-top'    => array('lat' => $lat + $dlat, 'lng' => $lng + $dlng),
            'left-bottom'  => array('lat' => $lat - $dlat, 'lng' => $lng - $dlng),
            'right-bottom' => array('lat' => $lat - $dlat, 'lng' => $lng + $dlng)
        );
    }

    //测算距离
    function getDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 2)
    {
        $radLat1 = $lat1 * M_PI / 180;
        $radLat2 = $lat2 * M_PI / 180;
        $a = $lat1 * M_PI / 180 - $lat2 * M_PI / 180;
        $b = $lng1 * M_PI / 180 - $lng2 * M_PI / 180;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * EARTH_RADIUS;
        $s = round($s * 1000);
        if ($len_type > 1) {
            $s /= 1000;
        }
        return round($s, $decimal);
    }

    //飞印打印机
    function sendFreeMessage($msg, $key)
    {
        $API_KEY = $key;
        $msg['reqTime'] = number_format(1000 * time(), 0, '', '');
        $content = $msg['memberCode'] . $msg['msgDetail'] . $msg['deviceNo'] . $msg['msgNo'] . $msg['reqTime'] . $API_KEY;
        $msg['securityCode'] = md5($content);
        $msg['mode'] = 2;
        return $this->sendMessage($msg);
    }

    public function sendMessage($msgInfo)
    {
        load()->func('communication');
        $content = ihttp_post('http://my.feyin.net/api/sendMsg', $msgInfo);
    }

    //普通打印机
    function sendSelfFormatOrderInfo($device_no, $key, $times, $orderInfo)
    { // $times打印次数
        $selfMessage = array(
            'deviceNo'     => $device_no,
            'printContent' => $orderInfo,
            'key'          => $key,
            'times'        => $times
        );
        $url = "http://open.printcenter.cn:8080/addOrder";
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded ",
                'method'  => 'POST',
                'content' => http_build_query($selfMessage),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    //支付调用
    public function syspay($type)
    {
        global $_W;
        $setdata = pdo_fetch("select * from " . tablename('xcommunity_pay') . ' where uniacid=:uniacid AND type=:type limit 1', array(
            ':uniacid' => $_W['uniacid'], ':type' => $type
        ));
        return $setdata;
    }
    //选择小区

    /**
     * @return mixed|Services_JSON_Error|string
     */
    public function doWebCregion()
    {
        global $_GPC, $_W;
        if ($_W['isajax']) {
            $op = in_array($_GPC['op'], array('company')) ? $_GPC['op'] : '';
            $condition = " weid=:weid ";
            $params[':weid'] = $_W['uniacid'];
            if ($op == 'company') {
                $condition .= " AND pid=0";
            }
            if ($_GPC['province']) {
                $condition .= " AND province=:province ";
                $params[':province'] = $_GPC['province'];
            }
            if ($_GPC['city']) {
                $condition .= " AND city=:city";
                $params[':city'] = $_GPC['city'];
            }
            if ($_GPC['dist']) {
                $condition .= " AND dist=:dist ";
                $params[':dist'] = $_GPC['dist'];
            }
            //判断是否是操作员
            $user = $this->user();
            if ($user['type'] == 3) {
                $condition .= " and id in({$user['regionid']})";
            }
            $sql = "SELECT id,title FROM " . tablename('xcommunity_region') . "WHERE $condition ";
            $regions = pdo_fetchall($sql, $params);
            return json_encode($regions);
        }
    }

    //超市首页推荐商品
    public function goods($regionid, $page)
    {
        global $_W;
        $pindex = max(1, intval($page));
        $psize = 20;
        $list = pdo_fetchall("SELECT * FROM" . tablename('xcommunity_goods') . "WHERE weid='{$_W['uniacid']}' AND isrecommand = 1 AND type = 1 AND status = 1 order by displayorder desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
        $c = $this->credit();
        $g = array();
        foreach ($list as $index => $item) {
            $thumb = tomedia($item['thumb']);
            $url = $this->createMobileUrl('shopping', array('op' => 'detail', 'id' => $item['id']));
            $credit = $item['marketprice'] * $c['shop_credit'];
            $createtime = date('Y-m-d H:i', $item['createtime']);
            $regions = unserialize($item['regionid']);
            if (@in_array($regionid, $regions)) {
                $g[] = array(
                    'id'           => $item['id'],
                    'thumb'        => $thumb,
                    'title'        => $item['title'],
                    'marketprice'  => $item['marketprice'],
                    'url'          => $url,
                    'credit'       => $credit,
                    'unit'         => $item['unit'],
                    'productprice' => $item['productprice'],
                    'createtime'   => $createtime
                );
            }
        }
        return $g;
    }

    public function doMobileGz()
    {
        global $_W;
        include $this->template($this->xqtpl('gz'));
    }

    public function auth($deviceid)
    {
        global $_W;
        load()->func('communication');
        if ($deviceid) {
            $data = array(
                'id'     => $deviceid,
                'action' => 'open',
                't'      => TIMESTAMP
            );
            $url = "http://openlock.moozun.com/cooperation/openlock/servlet.jspx";
            $resp = ihttp_post($url, $data);
            $resp = $resp['content'];
            if ($resp == 'ok') {
                $content = array(
                    'code'   => 0,
                    'info'   => '成功开门',
                    'status' => 'ok'
                );
            }
            else {
                $content = array(
                    'code'   => 1,
                    'info'   => '设备离线',
                    'status' => 'no'
                );
            }
            return $content;
        }
    }

    public function doWebFun()
    {
        global $_W, $_GPC;
        $do = $_GPC['do'] ? $_GPC['do'] : 'fun';
        $method = $_GPC['method'] ? $_GPC['method'] : 'fun';
        $this->xqdo($do, $method);
    }

    public function doWebShop()
    {
        global $_W, $_GPC;
        $do = $_GPC['do'] ? $_GPC['do'] : 'shop';
        $method = $_GPC['method'] ? $_GPC['method'] : 'shop';
        $this->xqdo($do, $method);
    }

    public function doWebPerm()
    {
        global $_W, $_GPC;
        $do = $_GPC['do'] ? $_GPC['do'] : 'perm';
        $method = $_GPC['method'] ? $_GPC['method'] : 'perm';
        $this->xqdo($do, $method);
    }

    public function doWebSeller()
    {
        global $_W, $_GPC;
        $do = $_GPC['do'] ? $_GPC['do'] : 'seller';
        $method = $_GPC['method'] ? $_GPC['method'] : 'seller';
        $this->xqdo($do, $method);
    }

    public function xqdo($do, $method)
    {
        global $_GPC, $_W;
        $xqmenu = $this->xqmenu();
        $do = $do ? $do : $xqmenu[0]['do'];
        $method = $method ? $method : $xqmenu[1]['method'];
        $GLOBALS['frames'] = $this->NavMenu($do, $method);
        $url = $GLOBALS['frames'][0]['items'][0]['url'] . '&method=' . $method;
        header("location: " . $url);
    }
}



