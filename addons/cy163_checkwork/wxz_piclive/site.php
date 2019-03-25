<?php
/**
 * 图片直播模块微站定义
 *
 * @author male365
 * @url
 */
defined('IN_IA') or exit('Access Denied');
header('Content_Type:text/html;charset=UTF-8');

class Wxz_picliveModuleSite extends WeModuleSite
{
    public function __construct()
    {
        global $_W, $_GPC;
        define('ADDON_PATH', IA_ROOT . "/addons/wxz_piclive");
        //define('STATIC_PATH', $_W['siteroot'] . 'addons/wxz_piclive/static');

        include_once ADDON_PATH . '/func/global.func.php';
        include_once ADDON_PATH . '/lib/BaseController.php';
        include_once ADDON_PATH . '/lib/BaseModel.php';

        //autoload
        include_once ADDON_PATH . '/lib/ClassLoader.php';

        $classLoader = new ClassLoader();

        //注册自动加载路径

        $classLoader->addPrefix('', ADDON_PATH . '/model');
        $classLoader->addPrefix('', ADDON_PATH . '/lib');
        $classLoader->register();
    }

    public function __call($name, $arguments)
    {
        global $_W, $_GPC;
        $defaultName = $name;
        $name = convertUnderline($name);

        $isWeb = stripos($name, 'doWeb') === 0;
        $isMobile = stripos($name, 'doMobile') === 0;

        $action = (string)$_GPC['wdo'];
        $action = convertUnderline($action);

        $action = $action ? $action : 'index';
        $actionFunc = 'Action' . ucfirst($action);

        if ($isWeb || $isMobile) {
            //默认走微擎文件夹和微擎site.php文件
            $incDir = IA_ROOT . '/addons/' . $this->modulename . '/inc/';
            if ($isWeb) {
                $incDir .= 'web/';
                $fun = strtolower(substr($defaultName, 5));
            }
            if ($isMobile) {
                $incDir .= 'mobile/';
                $fun = strtolower(substr($defaultName, 8));
            }
            $file = $incDir . $fun . '.inc.php';

            if (file_exists($file) || method_exists($this, $defaultName)) {
                return parent::__call($defaultName, $arguments);
            }

            $controllerDir = IA_ROOT . '/addons/' . $this->modulename . '/controller/';
            if ($isWeb) {
                $controllerDir .= 'web/';
                $controller = ucfirst(substr($name, 5)) . 'Controller';
            }
            if ($isMobile) {
                $controllerDir .= 'mobile/';
                $controller = ucfirst(substr($name, 8)) . 'Controller';
            }

            $file = $controllerDir . "$controller.php";

            if (!file_exists($file)) {
                die("访问的路径 {$controller} 不存在.");
            }

            require $file;

            $controllerEntity = new $controller();

            if (!method_exists($controllerEntity, $actionFunc)) {
                die("访问的路径 {$controller} 方法{$actionFunc}不存在.");
            }

            $controllerEntity->site = $this;
            $controllerEntity->_before();
            $dispathRet = $controllerEntity->$actionFunc();
            $controllerEntity->_after($dispathRet);
            return;
        } else {
            return call_user_func_array(array($this, $name), $arguments);
        }

    }

    public function doMobileLive()
    {
        $arr = file_get_contents('http://hefei.hfwxz.com/attachment/images/22/2018/01/j3hTFlfszE59LLsTAsCvyEFh530AET.png');
        echo strlen($arr);
        //这个操作被定义用来呈现 功能封面
    }

    //大首页
    public function doMobileMain()
    {
        global $_GPC, $_W;
        require_once "../addons/wxz_piclive/func/common.func.php";
        load()->model('mc');

        $uniacid = $_W['uniacid'];
        $lid = intval($_GPC['lid']);
        $indexInfo = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_index') . " WHERE uniacid='$uniacid' AND lid='$lid'");
        $indexInfo['banner'] = tomedia($indexInfo['banner']);
        //echo "<pre>";print_r($indexInfo);
        include $this->template('main');
    }

    //点赞
    public function doMobileGoodClick()
    {

        global $_GPC, $_W;
        $aid = isset($_POST['aid']) ? intval($_POST['aid']) : 0;
        $uid = $_W['fans']['uid'];
        $type = isset($_POST['type']) ? intval($_POST['type']) : 0;
        $data_arr = array('err' => 0, 'msg' => '');
        //附件信息
        $attach = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_attach') . " WHERE aid='$aid'");
        $lid = $attach['lid'];
        $sql = "SELECT * FROM " . tablename('wxz_pic_star') . " WHERE aid='{$aid}' AND uid='$uid' AND lid='{$lid}'";
        $row = pdo_fetch($sql);

        $star_date = array(
            'aid' => $aid,
            'uid' => $uid,
            'is_good' => 1,
            'lid' => $attach['lid'],
            'uniacid' => $_W['uniacid'],
            'add_time' => time()
        );

        if (empty($row)) {
            pdo_insert('wxz_pic_star', $star_date);
            $sid = pdo_insertid();
            if ($sid) {
                //$sql = "UPDATE ". tablename('wxz_pic_attach') ." SET good_num = good_num + 1 WHERE aid='{$aid}'";
                // pdo_query($sql);
            }
        } else {
            //取消关注
            $is_good = ($row['is_good'] == 1) ? 0 : 1;
            $sql = "UPDATE " . tablename('wxz_pic_star') . " SET is_good='$is_good' WHERE aid='{$aid}' AND uid='$uid' AND lid='{$attach['lid']}'";
            pdo_query($sql);
        }

        die(json_encode($data_arr));
    }

    //评论列表
    public function doMobileCommentList()
    {
        require_once "../addons/wxz_piclive/func/common.func.php";
        global $_GPC, $_W;
        $lid = intval($_GPC['lid']);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 15;
        $condition = " WHERE is_show=1 AND is_delete=0 AND uniacid={$_W['uniacid']} AND lid='$lid'";
        $sql = 'SELECT COUNT(*) FROM ' . tablename('wxz_pic_comment') . $condition;
        $total = pdo_fetchcolumn($sql);
        $List = array();
        if (!empty($total)) {
            $sql = "SELECT c.uid,c.aid,c.content as commentText,c.add_time,m.nickname as username,m.avatar FROM " . tablename('wxz_pic_comment') . " AS c " .
                "LEFT JOIN " . tablename('mc_members') . " AS m ON c.uid=m.uid " .
                "WHERE c.is_show=1 AND c.is_delete=0 AND c.uniacid={$_W['uniacid']} AND c.lid='{$lid}' ORDER BY c.cid DESC";
            $List = pdo_fetchall($sql);
            $pager = pagination($total, $pindex, $psize);

            if ($List) {
                foreach ($List as $key => $val) {
                    $List[$key]['dateTime'] = date('Y-m-d H:i:s', $val['add_time']);
                    //附件图片信息
                    $row = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_attach') . " WHERE aid=" . $val['aid']);

                    if (!file_exists($_W['siteroot'] . "attachment/" . $row['picpath'])) {
                        $midpicpath = $_W['attachurl'] . $row['picpath'];
                    }
                    if ($_W['setting']['remote']['type'] == 3) {
                        $qiniu_sid_style = pdo_fetchcolumn("SELECT styleText FROM " . tablename('wxz_pic_qiniu_style') . " WHERE id = '{$row['qiniu_sid']}'");
                        $qiniu_sid_mid_style = pdo_fetchcolumn("SELECT styleText FROM " . tablename('wxz_pic_qiniu_style') . " WHERE id = '{$row['qiniu_sid_big']}'");
                        $List[$key]['smallUrl'] = tomedia($row['picpath']) . "?" . $qiniu_sid_style;
                        $List[$key]['midUrl'] = tomedia($row['picpath']) . "?" . $qiniu_sid_mid_style;
                        $List[$key]['bigUrl'] = tomedia($row['picpath']);
                    } else {
                        $List[$key]['smallUrl'] = $_W['siteroot'] . "attachment/" . $row['thumbimg'];
                        $List[$key]['midUrl'] = $_W['siteroot'] . "attachment/" . $row['midthumb'];
                        $List[$key]['bigUrl'] = isset($midpicpath) ? $midpicpath : tomedia($row['picpath']);
                    }
                    //文件大小
                    $List[$key]['size'] = round($row['size'] / 1024, 3) . "M";
                    $List[$key]['picId'] = $row['file_name'];
                    $piclist['bigPicUrl'] = tomedia($row['picpath']);
                    $List[$key]['isLoadBigPiced'] = true;
                    $List[$key]['isPraise'] = IsGoodstar($row['aid'], $_W['fans']['uid'], $row['lid']);
                    $List[$key]['aid'] = $row['aid'];
                    $List[$key]['show_type'] = $row['show_type'];
                    $List[$key]['praise'] = getStarNum($row['aid']);
                    $List[$key]['userPic'] = str_replace('132132', '132', $val['avatar']);
                    $commentList = getComment($row['aid']);
                    $List[$key]['commentList'] = $commentList;
                    //$List[$key] = $piclist;
                }
            }
        }

        echo json_encode($List);
        die;
    }

    //添加评论
    public function doMobileAddComment()
    {
        require_once "../addons/wxz_piclive/func/common.func.php";
        global $_GPC, $_W;
        load()->model('mc');
        $uid = $_W['fans']['uid'];
        $fan = mc_fansinfo($_W['openid']);
        if (!empty($fan) && !empty($fan['openid'])) {
            $userinfo = $fan;
        } else {
            $userinfo = mc_oauth_userinfo();
        }

        if (empty($userinfo)) {
            $data_arr['err'] = 1;
            $data_arr['msg'] = '请微信浏览器打开！';
            die(json_encode($data_arr));
        }

        $comment = isset($_GPC['commentText']) ? trim($_GPC['commentText']) : '';
        $aid = isset($_GPC['aid']) ? intval($_GPC['aid']) : 0;
        $data_arr = array('err' => 0, 'msg' => '');
        $attachmentRow = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_attach') . " WHERE aid='$aid'");
        $commentTotal = pdo_fetchcolumn("SELECT * FROM " . tablename('wxz_pic_comment') . " WHERE aid='$aid' AND uid='$uid'");
        if ($commentTotal) {
            $data_arr['err'] = 1;
            $data_arr['msg'] = '您已评价，谢谢';
            die(json_encode($data_arr));
        }
        $commentdate = array(
            'aid' => $aid,
            'uid' => $uid,
            'lid' => $attachmentRow['lid'],
            'uniacid' => $_W['uniacid'],
            'content' => $comment,
            'add_time' => time()
        );
        $result = pdo_insert('wxz_pic_comment', $commentdate);
        $cid = pdo_insertid();
        if ($cid) {
            $sql = "SELECT c.cid,c.content as commentText,c.add_time,m.nickname as username,m.avatar FROM " . tablename('wxz_pic_comment') . " AS c " .
                "LEFT JOIN " . tablename('mc_members') . " AS m ON c.uid=m.uid " .
                "WHERE c.cid='{$cid}'";
            $row = pdo_fetch($sql);
            $row['dateTime'] = date("Y-m-d H:i:s", $row['add_time']);
            $row['userPic'] = !empty($row['avatar']) ? str_replace('132132', '132', $row['avatar']) : str_replace('132132', '132', $userinfo['avatar']);

            die(json_encode($row));
        } else {
            $data_arr['err'] = 1;
            die(json_encode($data_arr));
        }
    }

    //删除评论
    public function doMobileDelcomment()
    {
        global $_GPC, $_W;
        $data_arr = array('err' => 0, 'msg' => '');
        $cid = isset($_GPC['cid']) ? intval($_GPC['cid']) : 0;
        $uid = $_W['fans']['uid'];

        $sql = "SELECT count(*) FROM " . tablename('wxz_pic_comment') . " WHERE cid='$cid' AND uid='$uid'";
        $res = pdo_fetchcolumn($sql);

        if (!$res) {
            $data_arr['err'] = 1;
            $data_arr['msg'] = '抱歉，信息不存在';
        }

        $result = pdo_query("DELETE FROM " . tablename('wxz_pic_comment') . " WHERE cid='$cid'");
        if (!$result) {
            $data_arr['err'] = 1;
            $data_arr['msg'] = '抱歉，网络异常';
        }

        echo json_encode($data_arr);
        die;
    }

    //补充用户信息
    private function addUser()
    {
        global $_W;
        if ($_W['fans']['uid']) {
            $pic_user = pdo_get('wxz_pic_user', array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
            $user_data = array(
                'uid' => $_W['fans']['uid'],
                'uniacid' => $_W['uniacid'],
                'openid' => $_W['openid'],
                'headimgurl' => $_W['fans']['headimgurl'],
                'nickname' => $_W['fans']['nickname'],
                'start_at' => time()
            );
            if (!$pic_user) {
                pdo_insert('wxz_pic_user', $user_data);
            }
        }
    }

    //首页
    public function doMobileIndex()
    {
        global $_GPC, $_W;
        require_once "../addons/wxz_piclive/func/common.func.php";
        load()->model('mc');
        $fan = mc_fansinfo($_W['openid']);
        if (!empty($fan) && !empty($fan['openid'])) {
            $userinfo = $fan;
        } else {
            $userinfo = mc_oauth_userinfo();
        }
        $this->addUser(); //自定义用户表
        $setting = $this->module['config']; //配置项

        $act = !empty($_GPC['act']) ? $_GPC['act'] : 'display';
        $lid = isset($_GPC['lid']) ? intval($_GPC['lid']) : 0;
        $share_uid = $_GPC['share_uid']; //分享uid

        if ($share_uid && $share_uid != $userinfo['uid']) {
            $this->addHelp($share_uid, $lid, $userinfo);
        }
        //默认分类
        //$default_typeid = pdo_fetchcolumn("SELECT id FROM ims_wxz_pic_live_type WHERE lid = '$lid' LIMIT 1");

        $typeid = isset($_GPC['typeid']) ? intval($_GPC['typeid']) : 0; //$default_typeid;
        $uniacid = $_W['uniacid'];
        $indexInfo = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_index') . " WHERE uniacid='$uniacid'");

        //直播间信息
        $live = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_live') . " WHERE id='$lid'");

        if ($act == 'imglist') {
            $pindex = max(1, intval($_GPC['page']));
            $psize = 15;
            $condition = " WHERE `uniacid` = " . $_W['uniacid'] . " AND lid='{$lid}' AND is_video=0 ";
            if ($typeid > 0) {
                $condition .= "AND typeid='{$typeid}'";
            }
            $params = array(':uniacid' => $_W['uniacid']);

            $sortdesc = ($_GPC['sort'] == 'true') ? true : false;
            $orderby = ($sortdesc) ? "DESC" : "ASC";

            $sql = 'SELECT COUNT(*) FROM ' . tablename('wxz_pic_attach') . $condition;
            $total = pdo_fetchcolumn($sql);
            if (!empty($total)) {
                $sql = "SELECT * FROM " . tablename('wxz_pic_attach') . $condition . " ORDER BY aid $orderby
                                                    LIMIT " . ($pindex - 1) * $psize . "," . $psize;
                $List = pdo_fetchall($sql);
                $pager = pagination($total, $pindex, $psize);
            }
            $carryTotal = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('wxz_pic_star') . " WHERE lid='$lid' AND is_good=1");
            $imageList = $newList = array();
            $imageList['imageTotal'] = $total;
            $imageList['carryTotal'] = $carryTotal;
            if ($List) {
                foreach ($List as $kk => $row) {
                    $piclist = array();

                    if ($_W['setting']['remote']['type'] == 3 && $row['qiniu_sid']) {
                        $qiniu_sid_style = pdo_fetchcolumn("SELECT styleText FROM " . tablename('wxz_pic_qiniu_style') . " WHERE id = '{$row['qiniu_sid']}'");
                        $qiniu_sid_mid_style = pdo_fetchcolumn("SELECT styleText FROM " . tablename('wxz_pic_qiniu_style') . " WHERE id = '{$row['qiniu_sid_big']}'");
                        $piclist['smallUrl'] = $_W['setting']['remote']['qiniu']['url'] . '/' . $row['picpath'] . "?" . $qiniu_sid_style;
                        $piclist['midUrl'] = $_W['setting']['remote']['qiniu']['url'] . '/' . $row['picpath'] . "?" . $qiniu_sid_mid_style;
                        $piclist['bigUrl'] = tomedia($row['picpath']);
                    } else {
                        $piclist['smallUrl'] = $_W['siteroot'] . "attachment/" . $row['thumbimg'];
                        $piclist['midUrl'] = $_W['siteroot'] . "attachment/" . $row['midthumb'];
                        $piclist['bigUrl'] = tomedia($row['picpath']); //$_W['siteroot'] . "attachment/" . $row['midthumb'];
                    }
                    $piclist['currentSize'] = 0;
                    $piclist['bigImgSize'] = $row['bigimgsize'] > 0 ? $row['bigimgsize'] : round($row['size'] / 1024, 2);
                    $piclist['picId'] = $row['file_name'];
                    $piclist['dateTime'] = date("Y-m-d H:i:s", $row['add_time']);
                    $piclist['isLoadBigPiced'] = true;
                    $piclist['isPraise'] = IsGoodstar($row['aid'], $_W['fans']['uid'], $row['lid']);
                    $piclist['aid'] = $row['aid'];
                    $piclist['praise'] = getStarNum($row['aid']);
                    $piclist['show_type'] = $row['show_type'];
                    $List[$kk] = $piclist;
                    //评论
                    $commentList = getComment($row['aid']);
                    //$commentList[0] = array('username' => 'Dave111','userPic' => '111userpic','commentText'=>'这是一条评论333。');
                    $List[$kk]['commentList'] = $commentList;
                }
            }

            $imageList['user_info'][0] = array(
                'username' => $_W['fans']['nickname'],
                'userPic' => str_replace('132132', '132', $_W['fans']['avatar']),
                'dateTime' => date('Y-m-d')
            );
            $imageList['imageList'] = $List;
            $imageList['category'] = getCategory($lid);
            $imageList['page'] = $pindex;
            $imageList['pageTotal'] = ceil($total / 15);
            $imageList['sortdesc'] = $sortdesc;
            $imageList['live_img'] = tomedia($live['live_img']);
            $imageList['live_info'][0] = $live;
            $imageList['is_invite'] = $this->module['config']['is_invite'];
            $imageList['is_video'] = $this->module['config']['is_video'];
            $imageList['typeid'] = $typeid;
            //评论数
            $sql = 'SELECT COUNT(*) FROM ' . tablename('wxz_pic_comment') . " WHERE uniacid='" . $_W['uniacid'] . "' AND is_show=1 AND is_delete=0 AND lid='$lid'";
            $imageList['commentDataCount'] = pdo_fetchcolumn($sql);

            echo json_encode($imageList);
            die;
        }

        $uniacid = $_W['uniacid'];

        //echo "<pre>";print_r($imageList);
        include $this->template('index');
        //这个操作被定义用来呈现 微站首页导航图标
    }

    public function doWebTopicManage()
    {
        global $_GPC, $_W;
        require_once IA_ROOT . "/addons/wxz_piclive/lib/Image/ThinkImage.class.php";
        require_once "../addons/wxz_piclive/func/common.func.php";
        $image = new ThinkImage();

        load()->func('tpl');
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $setting = $this->module['config'];//配置项
        $remote_type = $_W['setting']['remote']['type'];

        if ($operation == 'post') {
            $lid = intval($_GPC['lid']);
            $tid = isset($_GPC['tid']) ? intval($_GPC['tid']) : 0;
            $qiniu_sid = isset($_GPC['qiniu_sid']) ? intval($_GPC['qiniu_sid']) : 0;
            $qiniu_sid_big = isset($_GPC['qiniu_sid_big']) ? intval($_GPC['qiniu_sid_big']) : 0;

            if (!empty($tid)) {
                $item = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_topic') . " WHERE tid = $tid");

                if (empty($item)) {
                    message('抱歉，信息不存在！', '', 'error');
                }
                $attach_idArr = unserialize($item['attach_id']);
                $piclist = $multi_aid = array();
                if (is_array($attach_idArr)) {
                    foreach ($attach_idArr as $kk => $aid) {
                        $picpath = pdo_fetchcolumn("SELECT picpath FROM " . tablename('wxz_pic_attach') . " WHERE aid = '$aid'");
                        $piclist[$aid] = $picpath;
                        $multi_aid[$aid]['aid'] = $aid;
                        $multi_aid[$aid]['picpath'] = $picpath;
                    }
                }
                $piclist = array_values($piclist);
            }

            $qiniuStyleList = $this->getQiniuStyleList($item['qiniu_sid']);//七牛样式列表
            $qiniuStyleList2 = $this->getQiniuStyleList($item['qiniu_sid_big']);//七牛样式列表
            $live_type_list = $this->live_type_list($lid, $item['topic_type']);//类型分类

            if (checksubmit('submit')) {
                $live = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_live') . " WHERE id = $lid");
                if (empty($live)) {
                    message('请输入直播间编号！');
                }
                $water_img = tomedia($live['water_img']);
                $water_thumb = tomedia($live['water_thumb']);
                $data = array(
                    'lid' => $lid,
                    'uniacid' => intval($_W['uniacid']),
                    'topic_name' => $_GPC['topic_name'],
                    'topic_type' => $_GPC['topic_type'],
                    'show_type' => $_GPC['show_type'],
                    'qiniu_sid' => $qiniu_sid,
                    'qiniu_sid_big' => $qiniu_sid_big,
                    'add_time' => time()
                );
                $thumbdir = IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/wxz_piclive/' . date('Ymd') . '/thumb/';
                !is_dir($thumbdir) && @mkdir($thumbdir, 0755, true);

                if (empty($tid)) {
                    pdo_insert('wxz_pic_topic', $data);
                    $tid = pdo_insertid();

                    if (is_array($_GPC['original_img'])) {
                        $attach = array(
                            'tid' => $tid,
                            'lid' => $lid,
                            'uniacid' => intval($_W['uniacid']),
                            'typeid' => $_GPC['topic_type'],
                            'qiniu_sid' => $qiniu_sid,
                            'qiniu_sid_big' => $qiniu_sid_big,
                            'add_time' => time()
                        );
                        foreach ($_GPC['original_img'] as $val) {
                            $imginfo = pathinfo($val);
                            if ($_W['setting']['remote']['type'] != 3) {
                                $thumbname = $imginfo['filename'] . "_150." . $imginfo['extension'];
                                $midthumbname = $imginfo['filename'] . "_1920." . $imginfo['extension'];
                                $thumbPath = $thumbdir . $thumbname;
                                $midthumbPath = $thumbdir . $midthumbname;
                                $sourceimagepath = $_W['siteroot'] . "attachment/" . $val;
                                if (!file_exists($sourceimagepath)) {
                                    $sourceimagepath = $_W['attachurl'] . $val;
                                }
                                if ($live['water_thumb']) {
                                    $image->open($sourceimagepath)->thumb(250, 250, THINKIMAGE_THUMB_CENTER)->water($water_thumb, THINKIMAGE_WATER_SOUTHEAST)->save($thumbPath);
                                } else {
                                    $image->open($sourceimagepath)->thumb(250, 250, THINKIMAGE_THUMB_CENTER)->save($thumbPath);
                                }
                                $imagesize = getimagesize($sourceimagepath);
                                $ori_rate = $imagesize[0] / $imagesize[1];
                                if (empty($setting['thumb_width'])) {
                                    $width = 800;
                                } else {
                                    $width = $setting['thumb_width'];
                                }
                                $height = $width / $ori_rate;
                                if ($live['water_img']) {
                                    $image->open($sourceimagepath)->thumb($width, $height, THINKIMAGE_THUMB_SCALING)->water($water_img, THINKIMAGE_WATER_SOUTHEAST)->save($midthumbPath);
                                } else {
                                    $image->open($sourceimagepath)->thumb($width, $height, THINKIMAGE_THUMB_SCALING)->save($midthumbPath);
                                }
                                $attach['show_type'] = ($ori_rate < 1) ? 1 : 0;
                                $attach['midthumb'] = "wxz_piclive/" . date('Ymd') . "/thumb/" . $midthumbname;
                                $attach['thumbimg'] = "wxz_piclive/" . date('Ymd') . "/thumb/" . $thumbname;
                            } else {
                                $sourceimagepath = $_W['siteroot'] . "attachment/" . $val;
                                $imagesize = @getimagesize($sourceimagepath);
                                $ori_rate = $imagesize[0] / $imagesize[1];
                                $attach['show_type'] = ($ori_rate < 1) ? 1 : 0;
                            }
                            $attach['picpath'] = $val;

                            //文件大小
                            $picpath = tomedia($val);
                            $file = @file_get_contents($picpath);
                            $length = strlen($file);
                            $attach['bigimgsize'] = (getsize($length, 'mb') > 0) ? getsize($length, 'mb') : '0.01';
                            $attach['file_name'] = $imginfo['basename'];

                            pdo_insert('wxz_pic_attach', $attach);
                        }

                        //获取attench_id
                        $attach_id = array();
                        $attach = pdo_fetchall("SELECT aid FROM " . tablename('wxz_pic_attach') . " WHERE tid = $tid");
                        if ($attach) {
                            foreach ($attach as $vv) {
                                $attach_id[] = $vv['aid'];
                            }
                        }
                        $attach_id = serialize($attach_id);
                        //更新主题数据
                        $sql = "UPDATE " . tablename('wxz_pic_topic') . " SET attach_id = '" . $attach_id . "' WHERE tid = '$tid'";
                        pdo_query($sql);
                    }
                } else {
                    //删除老图片
                    //pdo_query("DELETE FROM " . tablename('wxz_pic_attach') . " WHERE tid = $tid");
                    if (is_array($_GPC['original_img'])) {
                        $attach = array(
                            'tid' => $tid,
                            'lid' => $lid,
                            'uniacid' => intval($_W['uniacid']),
                            'typeid' => $_GPC['topic_type'],
                            'show_type' => $_GPC['show_type'],
                            'qiniu_sid' => $qiniu_sid,
                            'qiniu_sid_big' => $qiniu_sid_big,
                            'update_time' => time()
                        );
                        foreach ($_GPC['original_img'] as $key => $val) {
                            //判断图片是否为空
                            if (empty($val) && $_GPC['aid'][$key]) {
                                //删除图片
                                $aid = $_GPC['aid'][$key];
                                pdo_query("DELETE FROM " . tablename('wxz_pic_attach') . " WHERE aid='{$aid}'");
                                continue;
                            }
                            $imginfo = pathinfo($val);
                            //七牛附件
                            if ($_W['setting']['remote']['type'] != 3) {
                                $thumbname = $imginfo['filename'] . "_150." . $imginfo['extension'];
                                $midthumbname = $imginfo['filename'] . "_1920." . $imginfo['extension'];
                                $thumbPath = $thumbdir . $thumbname;
                                $midthumbPath = $thumbdir . $midthumbname;
                                $sourceimagepath = $_W['siteroot'] . "attachment/" . $val;
                                if (!file_exists($sourceimagepath)) {
                                    $sourceimagepath = $_W['attachurl'] . $val;
                                }
                                if ($live['water_thumb']) {
                                    $image->open($sourceimagepath)->thumb(250, 250, THINKIMAGE_THUMB_CENTER)->water($water_thumb, THINKIMAGE_WATER_SOUTHEAST)->save($thumbPath);
                                } else {
                                    $image->open($sourceimagepath)->thumb(250, 250, THINKIMAGE_THUMB_CENTER)->save($thumbPath);
                                }
                                $imagesize = getimagesize($sourceimagepath);
                                $ori_rate = $imagesize[0] / $imagesize[1];
                                if (empty($setting['thumb_width'])) {
                                    $width = 800;
                                } else {
                                    $width = $setting['thumb_width'];
                                }
                                $height = $width / $ori_rate;
                                if ($live['water_img']) {
                                    $image->open($sourceimagepath)->thumb($width, $height, THINKIMAGE_THUMB_SCALING)->water($water_img, THINKIMAGE_WATER_SOUTHEAST)->save($midthumbPath);
                                } else {
                                    $image->open($sourceimagepath)->thumb($width, $height, THINKIMAGE_THUMB_SCALING)->save($midthumbPath);
                                }

                                $attach['midthumb'] = "wxz_piclive/" . date('Ymd') . "/" . $midthumbname;
                                $attach['thumbimg'] = "wxz_piclive/" . date('Ymd') . "/" . $thumbname;
                            }

                            $attach['picpath'] = $val;
                            //文件大小
                            $picpath = tomedia($val);
                            $file = @file_get_contents($picpath);
                            $length = strlen($file);
                            $attach['size'] = getsize($length, 'kb');
                            $attach['file_name'] = $imginfo['basename'];

                            if ($_GPC['aid'][$key]) {
                                pdo_update('wxz_pic_attach', $attach, array('aid' => $_GPC['aid'][$key]));
                            }
                        }
                        //获取attench_id
                        $attach_id = array();
                        $attach = pdo_fetchall("SELECT aid FROM " . tablename('wxz_pic_attach') . " WHERE tid = $tid");
                        if ($attach) {
                            foreach ($attach as $vv) {
                                $attach_id[] = $vv['aid'];
                            }
                        }
                        $data['attach_id'] = serialize($attach_id);
                        //更新主题数据
                        //$sql = "UPDATE ".tablename('wxz_pic_topic') ." SET attach_id = '". $attach_id ."' WHERE tid = '$tid'";
                        //pdo_query($sql);
                    }

                    pdo_update('wxz_pic_topic', $data, array('tid' => $tid));
                }

                message('更新成功！', $this->createWebUrl('topicManage', array('op' => 'display', 'tid' => $tid, 'lid' => $lid)), 'success');
            }
        } elseif ($operation == 'delete') {
            $tid = intval($_GPC['tid']);
            $row = pdo_fetch("SELECT tid  FROM " . tablename('wxz_pic_topic') . " WHERE tid = :tid", array(':tid' => $tid));
            if (empty($row)) {
                message('抱歉，主题不存在或是已经被删除！');
            }

            //删除图片
            pdo_query("DELETE FROM " . tablename('wxz_pic_topic') . " WHERE tid='$tid'");
            pdo_query("DELETE FROM " . tablename('wxz_pic_attach') . " WHERE tid='$tid'");

            message('删除成功！', referer(), 'success');
        } elseif ($operation == 'display') {
            $topic_type = isset($_GPC['topic_type']) ? intval($_GPC['topic_type']) : 0;
            $lid = isset($_GPC['lid']) ? intval($_GPC['lid']) : 0;
            $live_type_list = $this->live_type_list($lid, $topic_type);//类型分类
            $live_list = $this->live_list($lid);//直播间
            $addpic_url = $_W['siteroot'] . "app/index.php?i={$_W['uniacid']}&lid=$lid&c=entry&do=sellercentral&m=wxz_piclive";

            $pindex = max(1, intval($_GPC['page']));
            $psize = 15;
            $condition = " WHERE `uniacid` = " . $_W['uniacid'];
            $params = array(':uniacid' => $_W['uniacid']);
            if (!empty($_GPC['keyword'])) {
                $condition .= " AND `topic_name` LIKE '%" . trim($_GPC['keyword']) . "%'";
            }
            if (!empty($_GPC['lid'])) {
                $condition .= " AND `lid` = '{$lid}'";
            }
            if (!empty($_GPC['topic_type'])) {
                $condition .= " AND `topic_type` = '" . intval($_GPC['topic_type']) . "'";
            }

            $sql = 'SELECT COUNT(*) FROM ' . tablename('wxz_pic_topic') . $condition;
            $total = pdo_fetchcolumn($sql);
            if (!empty($total)) {
                $sql = "SELECT * FROM " . tablename('wxz_pic_topic') . $condition . " ORDER BY tid DESC
						LIMIT " . ($pindex - 1) * $psize . "," . $psize;
                $list = pdo_fetchall($sql);
                foreach ($list as $kk => $vv) {
                    $sql = "SELECT name FROM " . tablename('wxz_pic_live_type') . " WHERE id='{$vv[topic_type]}'";
                    $list[$kk]['type_name'] = pdo_fetchcolumn($sql);
                    $list[$kk]['live_name'] = pdo_fetchcolumn("SELECT live_name FROM " . tablename('wxz_pic_live') . " WHERE id='{$vv['lid']}'");
                    $list[$kk]['add_time'] = date("Y-m-d H:i:s", $vv['add_time']);
                }
                $pager = pagination($total, $pindex, $psize);
            }
        }

        include $this->template('topicManage');
    }

    //直播管理
    public function doWebLiveManage()
    {
        global $_GPC, $_W;
        require_once IA_ROOT . "/addons/wxz_piclive/lib/Image/ThinkImage.class.php";
        $image = new ThinkImage();

        load()->func('tpl');
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

        if ($operation == 'post') {
            $lid = intval($_GPC['lid']);
            $item = array('cron'=>'on');
            if (!empty($lid)) {
                $item = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_live') . " WHERE id = $lid");
                if (empty($item)) {
                    message('抱歉，信息不存在！', '', 'error');
                }
                $piclist1 = unserialize($item['original_img']);//echo $item['original_img'];die;
                $piclist = array();
                if (is_array($piclist1)) {
                    foreach ($piclist1 as $p) {
                        $piclist[] = is_array($p) ? $p['attachment'] : $p;
                    }
                }
            }

            if (checksubmit('submit')) {
                $lid = intval($_GPC['lid']);
                if (empty($_GPC['live_name'])) {
                    message('请输入直播名称！');
                }
                //上传缩略图
                $thumbdir = IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/wxz_piclive/' . date('Ymd') . '/';
                !is_dir($thumbdir) && @mkdir($thumbdir, 0755, true);

                if ($_GPC['original_img']) {
                    $imginfo = pathinfo($_GPC['original_img']);
                    $thumbname = $imginfo['filename'] . "_150." . $imginfo['extension'];
                    $fileFullPath = $thumbdir . $thumbname;
                    $sourceimagepath = IA_ROOT . "/attachment/" . $_GPC['original_img'];//$_W['siteroot']."attachment/".$_GPC['live_img'];
                    if (!file_exists($sourceimagepath)) {
                        $sourceimagepath = $_W['attachurl'] . $_GPC['original_img'];
                    }
                    $image->open($sourceimagepath);

                    $image->thumb(250, 250, THINKIMAGE_THUMB_CENTER)->save($fileFullPath);
                    $thumb_path = "wxz_piclive/" . date('Ymd') . "/" . $thumbname;
                }

                $data = array(
                    'uniacid' => intval($_W['uniacid']),
                    'live_name' => $_GPC['live_name'],
                    'live_img' => $_GPC['live_img'],
                    'original_img' => $_GPC['original_img'],
                    'original_thumb' => isset($thumb_path) ? $thumb_path : '',
                    'water_img' => $_GPC['water_img'],
                    'water_thumb' => $_GPC['water_thumb'],
                    'start_date' => strtotime($_GPC['start_date']),
                    'end_date' => strtotime($_GPC['end_date']),
                    'live_brief' => $_GPC['live_brief'],
                    'rule_brief' => $_GPC['rule_brief'],
                    'live_desc' => htmlspecialchars_decode($_GPC['live_desc']),
                    'video_code' => htmlspecialchars_decode($_GPC['video_code']),
                    'add_time' => time(),
                    'keywords' => $_GPC['keywords'],
                    'cron' => $_GPC['cron'],
                    'cron_imgdir' => trim($_GPC['cron_imgdir']),
                );

                if (empty($lid)) {
                    pdo_insert('wxz_pic_live', $data);
                    $lid = pdo_insertid();
                    $msg = '添加成功！';
                } else {
                    //unset($data['add_time']);
                    //$data['last_update'] = TIMESTAMP;
                    pdo_update('wxz_pic_live', $data, array('id' => $lid));
                    $msg = '更新成功！';
                }

                message('更新成功！', $this->createWebUrl('liveManage', array('op' => 'display')), 'success');
            }
        } elseif ($operation == 'display') {
            $pindex = max(1, intval($_GPC['page']));
            $psize = 15;
            $condition = " WHERE `uniacid` = " . $_W['uniacid'];
            $params = array(':uniacid' => $_W['uniacid']);
            if (!empty($_GPC['keyword'])) {
                $condition .= " AND `live_name` LIKE '%" . trim($_GPC['keyword']) . "%'";
            }

            $sql = 'SELECT COUNT(*) FROM ' . tablename('wxz_pic_live') . $condition;
            $total = pdo_fetchcolumn($sql);
            if (!empty($total)) {
                $sql = 'SELECT * FROM ' . tablename('wxz_pic_live') . $condition . ' ORDER BY `id` DESC
						LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
                $list = pdo_fetchall($sql);
                foreach ($list as $kk => $vv) {
                    $list[$kk]['live_url'] = $_W['siteroot'] . "app/index.php?i={$_W['uniacid']}&lid=" . $vv['id'] . "&c=entry&do=index&m=wxz_piclive";
                    $list[$kk]['wapupload_url'] = $_W['siteroot'] . "app/index.php?i={$_W['uniacid']}&lid=" . $vv['id'] . "&c=entry&do=addimage&m=wxz_piclive";
                    $list[$kk]['ftpupload_url'] = $_W['siteroot'] . "app/index.php?i={$_W['uniacid']}&lid=" . $vv['id'] . "&c=entry&do=ftpupload&m=wxz_piclive";
                    $list[$kk]['original_thumb'] = $_W['siteroot'] . "attachment/" . $vv['original_thumb'];
                    $list[$kk]['start_date'] = date("Y-m-d H:i", $vv['add_time']);
                    $list[$kk]['end_date'] = date("Y-m-d H:i", $vv['end_date']);
                }
                $pager = pagination($total, $pindex, $psize);
            }
        } elseif ($operation == 'delete') {
            $lid = intval($_GPC['lid']);
            $row = pdo_fetch("SELECT *  FROM " . tablename('wxz_pic_live') . " WHERE id = :lid", array(':lid' => $lid));
            if (empty($row)) {
                message('抱歉，该直播间不存在或是已经被删除！');
            }

            pdo_query("DELETE FROM " . tablename('wxz_pic_live') . " WHERE id='$lid'");
            message('删除成功！', referer(), 'success');
        }

        include $this->template('liveManage');
    }

    //首页设置
    public function doWebIndexManage()
    {
        global $_GPC, $_W;
        require_once IA_ROOT . "/addons/wxz_piclive/lib/Image/ThinkImage.class.php";
        $image = new ThinkImage();
        $uniacid = $_W['uniacid'];
        load()->func('tpl');


        //$id = !empty($_GPC['id']) ? $_GPC['id'] : 0;
        $lid = !empty($_GPC['lid']) ? $_GPC['lid'] : 0;
        $count = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wxz_pic_index') . " WHERE lid='$lid'");
        if (checksubmit('submit')) {
            $data = array(
                'uniacid' => $_W['uniacid'],
                'lid' => $lid,
                'block_t1' => $_GPC['block_t1'],
                'subtitle1' => $_GPC['subtitle1'],
                'link_url1' => $_GPC['link_url1'],
                'block_t2' => $_GPC['block_t2'],
                'subtitle2' => $_GPC['subtitle2'],
                'link_url2' => $_GPC['link_url2'],
                'block_t3' => $_GPC['block_t3'],
                'subtitle3' => $_GPC['subtitle3'],
                'link_url3' => $_GPC['link_url3'],
                'banner' => $_GPC['banner'],
                'share_title' => $_GPC['share_title'],
                'share_brief' => $_GPC['share_brief'],
                'share_img' => $_GPC['share_img'],
            );

            if (!empty($count)) {
                pdo_update('wxz_pic_index', $data, array('lid' => $lid));
            } else {
                pdo_insert('wxz_pic_index', $data);
                $id = pdo_insertid();
            }
            message('更新成功！', $this->createWebUrl('indexManage', array('op' => 'display', 'lid' => $lid)), 'success');
        }

        $item = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_index') . " WHERE lid='$lid'");
        $index_url = $_W['siteroot'] . "app/index.php?i={$_W['uniacid']}&lid=$lid&c=entry&do=main&m=wxz_piclive";

        include $this->template('indexManage');
    }

    //直播类型
    public function doWebLiveType()
    {
        global $_W, $_GPC;

        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

        $live_list = $this->live_list();//直播间列表

        if ($operation == 'display') {
            $list = pdo_fetchall("SELECT * FROM " . tablename('wxz_pic_live_type') . " WHERE enabled = 1 AND uniacid='" . $_W['uniacid'] . "' ORDER BY id ASC");
            if ($list) {
                foreach ($list as $kk => $vv) {
                    $live_name = pdo_fetchcolumn("SELECT live_name FROM " . tablename('wxz_pic_live') . " WHERE id='{$vv['lid']}'");
                    $list[$kk]['live_name'] = $live_name;
                }
            }
        } elseif ($operation == 'post') {
            $id = isset($_GPC['id']) ? intval($_GPC['id']) : 0;

            if (checksubmit('submit')) {
                if (empty($_GPC['name'])) {
                    message('分类名称不为空！', $this->createWebUrl('liveType', array('op' => 'display')), 'error');
                }
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'name' => $_GPC['name'],
                    'lid' => $_GPC['lid'],
                    'enabled' => $_GPC['enabled']
                );
                if (!empty($id)) {
                    pdo_update('wxz_pic_live_type', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
                    message('分类修改成功！', $this->createWebUrl('liveType', array('op' => 'display')), 'success');
                } else {
                    pdo_insert('wxz_pic_live_type', $data);
                    $id = pdo_insertid();
                    message('分类添加成功！', $this->createWebUrl('liveType', array('op' => 'display')), 'success');
                }

            }

            //修改
            $liveType = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_live_type') . " WHERE id = '$id' AND uniacid = '" . $_W['uniacid'] . "'");
            $live_list = $this->live_list($liveType['lid']);
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            $Type = pdo_fetch("SELECT count(*) FROM " . tablename('wxz_pic_live_type') . " WHERE id = '$id' AND uniacid = '" . $_W['uniacid'] . "'");
            if (empty($Type)) {
                message('抱歉，该分类不存在或是已经被删除！', $this->createWebUrl('liveType', array('op' => 'display')), 'error');
            }
            pdo_delete('wxz_pic_live_type', array('id' => $id, 'uniacid' => $_W['uniacid']));
            message('删除成功！', $this->createWebUrl('liveType', array('op' => 'display')), 'success');
        } else {
            message('请求方式不存在');
        }


        include $this->template('live_type', TEMPLATE_INCLUDEPATH, true);
    }

    public function doWebComment()
    {
        global $_GPC, $_W;
        load()->func('tpl');
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $lid = !empty($_GPC['lid']) ? $_GPC['lid'] : 0;

        if ($operation == 'display') {
            $pindex = max(1, intval($_GPC['page']));
            $psize = 15;
            $condition = " WHERE `uniacid` = '" . $_W['uniacid'] . "' AND lid='$lid' AND is_delete=0";
            $params = array(':uniacid' => $_W['uniacid']);
            if (!empty($_GPC['keyword'])) {
                $condition .= " AND `content` LIKE '%" . trim($_GPC['keyword']) . "%'";
            }
            if (isset($_GPC['is_show']) && $_GPC['is_show'] >= 0) {
                $condition .= " AND `is_show` = '" . intval($_GPC['is_show']) . "'";
            }

            $sql = 'SELECT COUNT(*) FROM ' . tablename('wxz_pic_comment') . $condition;
            $total = pdo_fetchcolumn($sql);
            if (!empty($total)) {
                $sql = 'SELECT * FROM ' . tablename('wxz_pic_comment') . $condition . ' ORDER BY `cid` DESC
						LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
                $list = pdo_fetchall($sql);

                foreach ($list as $kk => $vv) {
                    $avatar = pdo_fetchcolumn("SELECT avatar FROM " . tablename('mc_members') . " WHERE uid='{$vv[uid]}'");
                    $list[$kk]['avatar'] = str_replace('132132', '132', $avatar);
                    $list[$kk]['add_time'] = date('Y-m-d H:i:s', $vv['add_time']);
                }

                $pager = pagination($total, $pindex, $psize);
            }
        } elseif ($operation == 'delete') {
            $cid = intval($_GPC['cid']);
            $row = pdo_fetch("SELECT *  FROM " . tablename('wxz_pic_comment') . " WHERE cid = :cid", array(':cid' => $cid));
            if (empty($row)) {
                message('抱歉，信息不存在或是已经被删除！');
            }

            //修改成不直接删除，而设置deleted=1
            pdo_update("wxz_pic_comment", array("is_delete" => 1), array('cid' => $cid));
            message('删除成功！', referer(), 'success');
        }

        include $this->template('comment');
    }

    /**
     * 获得直播类型的列表
     *
     * @access  public
     * @param   integer $selected 选定的类型编号
     * @return  string
     */
    public function live_type_list($lid, $cat_id = 0)
    {
        global $_W;
        $sql = "SELECT id, name FROM " . tablename('wxz_pic_live_type') . " WHERE enabled = 1 AND uniacid = '" . $_W['uniacid'] . "' AND lid='$lid'";
        $res = pdo_fetchall($sql);

        $lst = '';
        foreach ($res AS $row) {
            $lst .= "<option value='$row[id]'";
            $lst .= ($cat_id == $row['id']) ? ' selected="true"' : '';
            $lst .= '>' . htmlspecialchars($row['name']) . '</option>';
        }
        return $lst;
    }

    /**
     * 获得直播间的列表
     *
     * @access  public
     * @param   integer $selected 选定的类型编号
     * @return  string
     */
    public function live_list($selected = 0)
    {
        global $_W;
        $sql = "SELECT id, live_name FROM " . tablename('wxz_pic_live') . " WHERE uniacid = '" . $_W['uniacid'] . "'";
        $res = pdo_fetchall($sql);

        $lst = '';
        foreach ($res AS $row) {
            $lst .= "<option value='$row[id]'";
            $lst .= ($selected == $row['id']) ? ' selected="true"' : '';
            $lst .= '>' . htmlspecialchars($row['live_name']) . '</option>';
        }
        return $lst;
    }

    /**
     * 获得七牛图片列表
     *
     * @access  public
     * @param   integer $selected 选定的类型编号
     * @return  string
     */
    public function getQiniuStyleList($selected = 0)
    {
        global $_W;
        $sql = "SELECT id, title FROM " . tablename('wxz_pic_qiniu_style') . " WHERE uniacid = '" . $_W['uniacid'] . "'";
        $res = pdo_fetchall($sql);

        $lst = '';
        foreach ($res AS $row) {
            $lst .= "<option value='$row[id]'";
            $lst .= ($selected == $row['id']) ? ' selected="true"' : '';
            $lst .= '>' . htmlspecialchars($row['title']) . '</option>';
        }
        return $lst;
    }

    public function doWebSetProperty()
    {
        global $_GPC, $_W;
        $cid = intval($_GPC['cid']);
        $type = $_GPC['type'];
        $data = intval($_GPC['data']);
        if (in_array($type, array('is_show', 'is_good'))) {
            $data = ($data == 1 ? '0' : '1');
            pdo_update("wxz_pic_comment", array($type => $data), array("cid" => $cid));
            die(json_encode(array("result" => 1, "data" => $data)));
        }
        die(json_encode(array("result" => 0)));
    }

    protected function addHelp($share_uid, $lid, $userinfo = array())
    {
        global $_W, $_GPC;

        $uid = !empty($_W['member']['uid']) ? $_W['member']['uid'] : $userinfo['uid'];
        if (!$uid || $uid == 0 || $lid == 0) {
            return;
        }
        //添加分享人信息
        $shareDate = array();
        $shareUserInfo = pdo_fetch('SELECT * FROM ' . tablename('wxz_pic_share') . ' WHERE `uniacid` = :uniacid AND `share_uid` = :share_uid AND `lid` = :lid', array(':uniacid' => $_W['uniacid'], ':share_uid' => $share_uid, ':lid' => $lid));
        if (!$shareUserInfo) {
            $shareDate['share_uid'] = $share_uid;
            $shareDate['uniacid'] = $_W['uniacid'];
            $shareDate['lid'] = $lid;
            $shareDate['dateline'] = time();

            pdo_insert('wxz_pic_share', $shareDate);
        }
        //分享记录
        $log = pdo_fetch('SELECT * FROM ' . tablename('wxz_pic_help') . ' WHERE `uniacid` = :uniacid AND `help_uid` = :help_uid AND `share_uid` = :share_uid AND `lid` = :lid', array(':uniacid' => $_W['uniacid'], ':share_uid' => $share_uid, ':help_uid' => $uid, ':lid' => $lid));

        if (!$log && $uid != $share_uid) {
            $data['share_uid'] = $share_uid;
            $data['uniacid'] = $_W['uniacid'];
            $data['help_uid'] = $uid;
            $data['lid'] = $lid;
            $data['dateline'] = time();

            pdo_insert('wxz_pic_help', $data);
        }
    }

    public function doWebUsers()
    {
        global $_W, $_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        $lid = isset($_GPC['lid']) ? intval($_GPC['lid']) : 0;

        if ($operation == "del") {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_share') . " WHERE id='$id'");
            if (!$row) {
                message('抱歉，信息不存在或是已经被删除！');
            }
            pdo_delete('wxz_pic_share', array('id' => $id, 'uniacid' => $_W['uniacid']));
            pdo_delete('wxz_pic_help', array('share_uid' => $row['share_uid'], 'uniacid' => $_W['uniacid'], 'lid' => $row['lid']));
            message('删除成功！', $this->createWebUrl('users', array('op' => 'display', 'lid' => $row['lid'])), 'success');
        }

        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $condition = ' where 1=1';
        if ($_GPC['nickname']) {
            $condition .= "  and b.nickname like '%" . $_GPC['nickname'] . "%'";
        }
        if ($_GPC['openid']) {
            $condition .= "  and b.openid like '%" . $_GPC['openid'] . "%'";
        }

        $total = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('wxz_pic_share') . " as a inner JOIN " . tablename('wxz_pic_user') . " AS b ON a.share_uid=b.uid " . $condition . " and b.`uniacid`=:uniacid and a.lid=:lid", array(':uniacid' => $_W['uniacid'], ':lid' => $lid));
        $start = ($pindex - 1) * $psize;

        $sql = "SELECT a.*,b.nickname,b.headimgurl,b.openid FROM " . tablename('wxz_pic_share') . " as a "
            . "LEFT JOIN " . tablename('wxz_pic_user') . " AS b ON a.share_uid=b.uid " . $condition . " and a.uniacid=" . $_W['uniacid'] . " and a.lid='$lid' order by a.id desc limit " . $start . ',' . $psize;

        $Users = pdo_fetchall($sql);
        $pager = pagination($total, $pindex, $psize);

        include $this->template('users');
    }


    public function doWebHelp()
    {
        global $_W, $_GPC;

        $uniacid = $_W['uniacid'];
        $lid = intval($_GPC['lid']);
        $uid = $_GPC['uid'];
        $user = pdo_fetch('SELECT * FROM ' . tablename('wxz_pic_user') . ' WHERE `uniacid` = :uniacid AND `uid` = :uid', array(':uniacid' => $_W['uniacid'], ':uid' => $uid));

        $sql = "SELECT h.share_uid,h.dateline,u.nickname,u.headimgurl,u.openid FROM " . tablename('wxz_pic_help') . " AS h " .
            "LEFT JOIN " . tablename('wxz_pic_user') . " AS u ON h.help_uid=u.uid " .
            "WHERE h.share_uid='$uid' AND h.lid='$lid' AND h.uniacid='$uniacid'";
        $help_user = pdo_fetchall($sql);

        include $this->template('help');
    }

    public function doMobileInvite()
    {
        global $_GPC, $_W;
        require_once "../addons/wxz_piclive/func/common.func.php";
        load()->model('mc');

        $uniacid = $_W['uniacid'];
        $lid = isset($_GPC['lid']) ? intval($_GPC['lid']) : 1;
        //直播间信息
        $live = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_live') . " WHERE id='$lid'");
        $indexInfo = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_index') . " WHERE uniacid='$uniacid'");
        $indexInfo['banner'] = tomedia($live['live_img']);
        $indexInfo['indexurl'] = $this->createMobileUrl('index', array('lid' => $lid), 'success');
        //统计
        $sql = "SELECT count(*) FROM " . tablename('wxz_pic_help') . " WHERE lid='$lid'";
        $total = pdo_fetchcolumn($sql);
        //邀请排行榜
        $sql = "SELECT COUNT(*) AS num,h.share_uid,u.nickname,u.headimgurl FROM " . tablename('wxz_pic_help') . " AS h " .
            "LEFT JOIN " . tablename('wxz_pic_user') . " AS u ON u.uid=h.share_uid " .
            "WHERE h.lid='$lid' " .
            "GROUP BY h.share_uid ORDER BY num DESC Limit 50";
        $list = pdo_fetchall($sql);

        include $this->template('invite');
    }

    function doMobileGetSourceImg()
    {
        global $_GPC, $_W;
        load()->model('mc');
        $fan = mc_fansinfo($_W['openid']);
        if (!empty($fan) && !empty($fan['openid'])) {
            $userinfo = $fan;
        } else {
            $userinfo = mc_oauth_userinfo();
        }


        load()->func('tpl');
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

        $aid = intval($_GPC['aid']);
        $sql = "SELECT * FROM " . tablename('wxz_pic_attach') . " WHERE aid='$aid'";
        $item = pdo_fetch($sql);

        $sql = "SELECT * FROM " . tablename('wxz_pic_live') . " WHERE id='{$item['lid']}'";
        $live = pdo_fetch($sql);

        include $this->template('getSourceImg');
    }

}