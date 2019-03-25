<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
load()->model('mc');
load()->func('compat.biz');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $condition = " WHERE `uniacid` = '". $_W['uniacid'] ."'";
    
    $sql = 'SELECT COUNT(*) FROM ' . tablename('wxz_pic_staff') . $condition;
    $total = pdo_fetchcolumn($sql);
    if (!empty($total)) {
            $sql = 'SELECT * FROM ' . tablename('wxz_pic_staff') . $condition . ' ORDER BY `id` DESC
                            LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
            $list = pdo_fetchall($sql);
            if($list){
                foreach($list as $kk=>$vv){
                    $list[$kk]['createtime'] = date("Y-m-d H:i:s", $vv['createtime']);
                    //$list[$kk]['live_name'] = pdo_fetchcolumn("SELECT live_name FROM ".tablename('wxz_pic_live')." WHERE id='{$vv['lid']}'");
                }
            }
            $pager = pagination($total, $pindex, $psize);
    }
    //echo "<pre>";print_r($list);die;
    include $this->template('staff');
} elseif ($operation == 'add') {
    $searchmod = ($_GPC['searchmod']) == 2 ? 2 : 1;
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;

    $params = array(
            ':uniacid' => $_W['uniacid'],
            ':acid' => $_W['acid'],
    );
    $condition = " WHERE f.`uniacid` = :uniacid AND f.`acid` = :acid";

    if (!empty($_GPC['nickname'])) {
            //$searchmod = intval($_GPC['searchmod']);
            $nickname = $_GPC['nickname'] ? addslashes(trim($_GPC['nickname'])) : '';

            if ($searchmod == 1) {
                    $condition .= " AND ((f.`nickname` = :nickname) OR (f.`openid` = :openid))";
                    $params[':nickname'] = $nickname;
                    $params[':openid'] = $nickname;
            } else {
                    $condition .= " AND ((f.`nickname` LIKE :nickname) OR (f.`openid` LIKE :openid))";
                    $params[':nickname'] = "%{$nickname}%";
                    $params[':openid'] = "%{$nickname}%";
            }
    }
    if (!empty($_GPC['uid'])) {
            $condition .= " AND f.uid = :uid ";
            $params[':uid'] = intval($_GPC['uid']);
    }
    $orderby = " ORDER BY f.`fanid` DESC";
    //粉丝列表
    $list = array();
    if(!empty($_GPC['uid']) || !empty($_GPC['nickname'])){
        $list = pdo_fetchall("SELECT f.* FROM " .tablename('mc_mapping_fans')." AS f" . $condition . $orderby . " LIMIT " . ($pindex - 1) * $psize . "," . $psize, $params);
    }
    if (!empty($list)) {
            foreach ($list as &$v) {
                //判断是否加入
                $v['isExit'] = pdo_fetchcolumn("SELECT count(*) FROM ". tablename('wxz_pic_staff') ." WHERE fanid='{$v['fanid']}'");
                    $v['tag_show'] = mc_show_tag($v['groupid']);
                    $v['groupid'] = trim($v['groupid'], ',');
                    if (!empty($v['uid'])) {
                            $user = mc_fetch($v['uid'], array('realname', 'nickname', 'mobile', 'email', 'avatar'));
                    }
                    if (!empty($v['tag']) && is_string($v['tag'])) {
                            if (is_base64($v['tag'])) {
                                    $v['tag'] = base64_decode($v['tag']);
                            }
                                                            if (is_serialized($v['tag'])) {
                                    $v['tag'] = @iunserializer($v['tag']);
                            }
                            if (!empty($v['tag']['headimgurl'])) {
                                    $v['tag']['avatar'] = tomedia($v['tag']['headimgurl']);
                            }
                    }
                    if (empty($v['tag'])) {
                            $v['tag'] = array();
                    }

                    if (!empty($user)) {
                            $niemmo = $user['realname'];
                            if (empty($niemmo)) {
                                    $niemmo = $user['nickname'];
                            }
                            if (empty($niemmo)) {
                                    $niemmo = $user['mobile'];
                            }
                            if (empty($niemmo)) {
                                    $niemmo = $user['email'];
                            }
                            if (empty($niemmo) || (!empty($niemmo) && substr($niemmo, -6) == 'we7.cc' && strlen($niemmo) == 39)) {
                                    $niemmo_effective = 0;
                            } else {
                                    $niemmo_effective = 1;
                            }
                            $v['user'] = array('niemmo_effective' => $niemmo_effective, 'niemmo' => $niemmo, 'nickname' => $user['nickname']);
                    }
                    if (empty($v['user']['nickname']) && !empty($v['tag']['nickname'])) {
                            $v['user']['nickname'] = $v['tag']['nickname'];
                    }
                    if (empty($v['user']['avatar']) && !empty($v['tag']['avatar'])) {
                            $v['user']['avatar'] = $v['tag']['avatar'];
                    }
                    unset($user,$niemmo,$niemmo_effective);
            }
    }
    //总数
    $total = 0;
    if(!empty($_GPC['uid']) || !empty($_GPC['nickname'])){
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename('mc_mapping_fans')." AS f" . $condition, $params);
    }
    $pager = pagination($total, $pindex, $psize);

    include $this->template('staff');
    
} elseif ($operation == 'join') {
    $data = array('status' => 0, 'msg' => '');
    $fanid = intval($_GPC['fanid']);
    
    $fansRow = pdo_fetch("SELECT * FROM ". tablename('mc_mapping_fans') ." WHERE fanid = '$fanid'");
    if($fansRow['uniacid'] != $_W['uniacid']){
        $data['status'] = 100;
        $data['msg'] = '该粉丝不在当前公众号下';
        echo json_encode($data);die;
    }
    
    $staffField = array(
        'uniacid' => $_W['uniacid'],
        'fanid' => $fanid,
        'uid' => $fansRow['uid'],
        'openid' => $fansRow['openid'],
        'nickname' => $fansRow['nickname'],
        'createtime' => time()
    );
    $staffRow = pdo_fetch("SELECT * FROM ". tablename('wxz_pic_staff') ." WHERE fanid = '$fanid'");
    if(!$staffRow){
        pdo_insert('wxz_pic_staff', $staffField);
        $data['msg'] = '操作成功';
    }
    echo json_encode($data);die;
    
} elseif ($operation == 'delete') {  
    $staffId = intval($_GPC['id']);
    $row = pdo_fetch("SELECT * FROM " . tablename('wxz_pic_staff') . " WHERE id = :id", array(':id' => $staffId));
    if (empty($row)) {
            message('抱歉，信息不存在或是已经被删除！');
    }
    
    $res = pdo_delete('wxz_pic_staff', array('id' => $staffId));
    message('删除成功！', referer(), 'success');
} else {
    message('请求方式不存在');
}
