<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_GPC, $_W;
$action = 'assess';
$schoolid = intval($_GPC['schoolid']);
$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$action);
$weid = $_W['uniacid'];
$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where id = :id ORDER BY ssort DESC", array(':id' => $schoolid));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'post') {
    load()->func('tpl');
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " WHERE id = :id", array(':id' => $id));
        $member = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $_W ['uniacid'], ':uid' => $item['uid']));
        $item['nickname'] = $member['nickname'];
        $item['avatar'] = $member['avatar'];
        if(!empty($item['area_addr_location'])){
            $item['area_addr_location'] = json_decode($item['area_addr_location'],true);
        }
        if (empty($item)) {
            message('抱歉，用户不存在或是已经删除！', '', 'error');
        } else {
            if (!empty($item['thumb_url'])) {
                $item['thumbArr'] = explode('|', $item['thumb_url']);
            }
        }
    }
    if (checksubmit('submit')) {
        if(empty($_GPC['location'])){
            message('用户住址经纬度不能为空！');
        }
        $data = array(
            'weid' => $weid,
            'schoolid' => $schoolid,
            'name' => trim($_GPC['name']),
            'mobile' => trim($_GPC['mobile']),
            'area_addr' => trim($_GPC['area_addr']),
            'userAttribute' => intval($_GPC['userAttribute']) > 0 ? intval($_GPC['userAttribute']) : 1,
            'area_addr_location' => json_encode($_GPC['location'])
        );
        if (empty($data['name'])) {
            message('请输入用户姓名！');
        }
        pdo_update($this->table_parents, $data, array('id' => $id));
        message('操作成功', $this->createWebUrl('book_user', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
    }
} elseif ($operation == 'display') {

    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;
    $condition = '';
    if (!empty($_GPC['keyword'])) {
        $condition .= " AND name LIKE '%{$_GPC['keyword']}%'";
    }
    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_parents) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} AND userType = 'bookUser' $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
    foreach ($list as $key => $value) {
        $member = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $_W ['uniacid'], ':uid' => $value['uid']));
        $list[$key]['nickname'] = $member['nickname'];
        $list[$key]['avatar'] = $member['avatar'];
    }
//    var_dump($list);exit;
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_parents) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} AND userType = 'bookUser' $condition");

    $pager = pagination($total, $pindex, $psize);
    var_dump($pager);
} elseif ($operation == 'delete') {
    $tid = intval($_GPC['id']);
    $row = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " WHERE id = :id", array(':id' => $tid));
    if (empty($row)) {
        message('抱歉，用户不存在或是已经被删除！');
    }
    if (!empty($row['uid'])) {
        pdo_delete($this->table_user, array('uid' => $row['uid'],'openid' => $row['openid'] ,'weid' => $row['weid'],'schoolid' => $row['schoolid']));
    }else{
        pdo_delete($this->table_user, array('pid' => $tid, 'sid' => 0));
    }
    pdo_delete($this->table_teachers, array('id' => $tid));
    message('删除成功！', referer(), 'success');
} elseif ($operation == 'deleteall') {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $assess = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " WHERE id = :id", array(':id' => $id));
            if (empty($assess)) {
                $notrowcount++;
                continue;
            }
            pdo_delete($this->table_parents, array('id' => $id, 'weid' => $weid));
            if (!empty($assess['uid'])) {
                pdo_delete($this->table_user, array('uid' => $assess['uid'],'openid' => $assess['openid'] ,'weid' => $assess['weid'],'schoolid' => $assess['schoolid']));
            }else{
                pdo_delete($this->table_user, array('pid' => $id, 'sid' => 0));
            }
            $rowcount++;
        }
    }
    $message = "操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!";

    $data ['result'] = true;

    $data ['msg'] =  $message;

    die ( json_encode ( $data ) );
}
include $this->template ( 'web/book_user' );
?>