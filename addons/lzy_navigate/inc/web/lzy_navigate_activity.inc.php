<?php

global $_W, $_GPC;
$settings = $this->module["config"];
load()->func("tpl");
$op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
$uniacid = $_W["uniacid"];

$filename = (basename(__file__, ".inc.php"));
$data = new $filename();

if ($op == "display") {
    $pindex = max(1, intval($_GPC["page"]));
    $psize = 50;
    $con = "uniacid=$uniacid";

    $title = $_GPC["title"];
    if (!empty($title)) {
        $con .= " and title like '%$title%'";
    }

    $total = 0;
    $list = $data->getAll($con, $pindex, $psize, $total);
    $pager = pagination($total, $pindex, $psize);

    if (!empty($list)) {
        foreach ($list as $key => $value) {
            $url = $this->createMobileUrl("enter", array("a_id" => $list[$key]["id"]));
            $url = substr($url, 2);
            $url = $_W["siteroot"] . "app/" . $url;
            $list[$key]["_url"] = $url;
        }
    }

    include $this->template($filename);
    exit();
}

if ($op == "post") {
    $id = $_GPC["id"];
    if (!empty($id)) {
        $page_data = $data->getOne($id);
        if (!empty($page_data['navigate'])) {
            $page_data['navigate'] = unserialize($page_data['navigate']);
        }
        if (!empty($page_data['slide'])) {
            $page_data['slide'] = unserialize($page_data['slide']);
        }
    }

    if (checksubmit("submit")) {

        $input = array();
        $input = $_GPC["data"];
        $input["uniacid"] = $uniacid;
        $input["createtime"] = TIMESTAMP;

        $navigate = $input['navigate'];
        $navigate_list = array();
        if (is_array($navigate['img'])) {
            foreach ($navigate['img'] as $key => $value) {
                if (!empty($navigate['img'][$key])) {
                    $d = array(
                        'img' => $navigate['img'][$key],
                        'layout' => $navigate['layout'][$key],
                        'img_urls' => $navigate['img_urls'][$key],
                    );
                    $navigate_list[] = $d;
                }
            }
        }
        if (!empty($navigate_list)) {
            $input['navigate'] = serialize($navigate_list);
        } else {
            $input['navigate'] = "";
        }


        $slide = $input['slide'];
        $slide_list = array();
        if (is_array($slide['img'])) {
            foreach ($slide['img'] as $key => $value) {
                if (!empty($slide['img'][$key])) {
                    $d = array(
                        'img' => $slide['img'][$key],
                        'img_urls' => $slide['img_urls'][$key],
                    );
                    $slide_list[] = $d;
                }
            }
        }
        if (!empty($slide_list)) {
            $input['slide'] = serialize($slide_list);
        } else {
            $input['slide'] = "";
        }

        if (!empty($id)) {
            $temp = $data->modify($id, $input);
        } else {
            $temp = $data->insert($input);
        }

        message("信息更新成功", $this->createWebUrl($filename, array("op" => "display")), "success");
    }
    include $this->template($filename);
    exit();
}

if ($op == "delete") {
    $id = $_GPC["id"];
    $data->delete($id);
    message("删除成功", $this->createWebUrl($filename, array("op" => "display")), "success");
}

if ($op == "delete_all") {
    $data->deleteAll();
    message("删除成功", $this->createWebUrl($filename, array("op" => "display")), "success");
}
if ($op == "batch_del") {
    $ids = $_GPC["id"];
    if (empty($ids)) {
        message("信息不能为空.");
    }
    foreach ($ids as $id) {
        $data->delete($id);
    }
    message("删除成功", $this->createWebUrl($filename, array("op" => "display")), "success");
}


if ($op == "create") {
    pdo_query('INSERT INTO '. tablename($filename) .' ( `rid`, `uniacid`, `title`, `backcolor`, `sharetitle`, `sharedescription`, `shareimage`, `copyright`, `copyright_link`, `navigate`, `slide`, `createtime`) VALUES ( \'0\', \'11\', \'导航1\', \'\', \'\', \'\', \'\', \'\', \'\', \'a:8:{i:0;a:3:{s:3:\"img\";s:48:\"../addons/lzy_navigate/template/style/img/a2.png\";s:6:\"layout\";s:1:\"5\";s:8:\"img_urls\";s:20:\"http://www.baidu.com\";}i:1;a:3:{s:3:\"img\";s:48:\"../addons/lzy_navigate/template/style/img/a3.png\";s:6:\"layout\";s:1:\"5\";s:8:\"img_urls\";s:20:\"http://www.baidu.com\";}i:2;a:3:{s:3:\"img\";s:48:\"../addons/lzy_navigate/template/style/img/a5.png\";s:6:\"layout\";s:1:\"3\";s:8:\"img_urls\";s:20:\"http://www.baidu.com\";}i:3;a:3:{s:3:\"img\";s:48:\"../addons/lzy_navigate/template/style/img/a7.png\";s:6:\"layout\";s:1:\"3\";s:8:\"img_urls\";s:20:\"http://www.baidu.com\";}i:4;a:3:{s:3:\"img\";s:48:\"../addons/lzy_navigate/template/style/img/a8.png\";s:6:\"layout\";s:1:\"3\";s:8:\"img_urls\";s:20:\"http://www.baidu.com\";}i:5;a:3:{s:3:\"img\";s:48:\"../addons/lzy_navigate/template/style/img/a9.png\";s:6:\"layout\";s:1:\"3\";s:8:\"img_urls\";s:20:\"http://www.baidu.com\";}i:6;a:3:{s:3:\"img\";s:49:\"../addons/lzy_navigate/template/style/img/a10.png\";s:6:\"layout\";s:1:\"3\";s:8:\"img_urls\";s:20:\"http://www.baidu.com\";}i:7;a:3:{s:3:\"img\";s:49:\"../addons/lzy_navigate/template/style/img/a11.png\";s:6:\"layout\";s:1:\"3\";s:8:\"img_urls\";s:20:\"http://www.baidu.com\";}}\', \'a:2:{i:0;a:2:{s:3:\"img\";s:47:\"../addons/lzy_navigate/template/style/img/1.jpg\";s:8:\"img_urls\";s:20:\"http://www.baidu.com\";}i:1;a:2:{s:3:\"img\";s:47:\"../addons/lzy_navigate/template/style/img/2.jpg\";s:8:\"img_urls\";s:20:\"http://www.baidu.com\";}}\', \'1523859605\');
');
    message("生成成功", $this->createWebUrl($filename, array("op" => "display")), "success");
}
