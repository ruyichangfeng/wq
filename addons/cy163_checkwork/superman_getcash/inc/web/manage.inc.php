<?php
/**
 * 【超人】提现模块定义
 *
 * @author 超人
 * @url
 */
defined('IN_IA') or exit('Access Denied');
class Superman_getcash_doWebManage extends Superman_getcashModuleSite {
    public function __construct() {
        parent::__construct();
    }

    public function exec() {
        global $_W, $_GPC;
        $conf = $this->module['config'];
        $act = in_array($_GPC['act'], array('display', 'post', 'delete', 'pay'))?$_GPC['act']:'display';
        load()->model('mc');
        if ($act == 'display') {
            $keyword = $_GPC['keyword'];
            $pindex = max(1, intval($_GPC['page']));
            $pagesize = 25;
            $start = ($pindex - 1) * $pagesize;
            $param = array();
            $param[':uniacid'] = $_W['uniacid'];
            $where = " WHERE a.uniacid=:uniacid AND a.uid=b.uid";
            if (is_numeric($keyword)) {
                $where .= " AND a.uid=:keyword";
                $param[':keyword'] = intval($keyword);
            } else {
                $where .= " AND b.nickname LIKE '%{$keyword}%'";
            }
            if ($_GPC['status'] > -99) {
                $where .= " AND a.status=:status";
                $param[':status'] = $_GPC['status'];
            }
            $sql = "SELECT a.*,b.nickname,b.avatar FROM ".tablename('superman_getcash')." AS a,".tablename('mc_members')." AS b {$where} ORDER BY a.id DESC LIMIT $start,$pagesize";
            $list = pdo_fetchall($sql, $param);
            if ($list) {
                $users = array();
                foreach ($list as &$item) {
                    $item['insert_time'] = $item['insert_time']?date('Y-m-d H:i:s', $item['insert_time']):'';
                    $item['update_time'] = $item['update_time']?date('Y-m-d H:i:s', $item['update_time']):'';
                    if (!isset($users[$item['user_id']])) {
                        $item['user'] = $users[$item['user_id']] = pdo_fetch("SELECT username FROM ".tablename('users')." WHERE uid=:uid", array(
                            ':uid' => $item['user_id'],
                        ));
                    } else {
                        $item['user'] = $users[$item['user_id']];
                    }
                }
                //print_r($list);
                $sql = "SELECT COUNT(*) FROM ".tablename('superman_getcash')." AS a,".tablename('mc_members')." AS b {$where}";
                $total = pdo_fetchcolumn($sql, $param);
                $pager = pagination($total, $pindex, $pagesize);
            }
        }

        if ($act == 'post') {
            $id = intval($_GPC['id']);
            if (empty($id)) {
                message('参数错误');
            }
            $sql = "SELECT a.*,b.nickname,b.avatar FROM ".tablename('superman_getcash')." AS a,".tablename('mc_members')." AS b WHERE a.id=:id AND a.uid=b.uid";
            $param = array(
                ':id' => $id,
            );
            $item = pdo_fetch($sql, $param);
            if (empty($item)) {
                message('数据不存在或已删除');
            }
            $credit_title = $this->_get_credits($item['credit_type']);
            $users = array();
            if (!isset($users[$item['user_id']])) {
                $item['user'] = $users[$item['user_id']] = pdo_fetch("SELECT username FROM ".tablename('users')." WHERE uid=:uid", array(
                    ':uid' => $item['user_id'],
                ));
            } else {
                $item['user'] = $users[$item['user_id']];
            }
            if (checksubmit('submit')) {
                if ($item['status'] == -1 || $item['status'] == -2 || $item['status'] == 1 ) {
                    message('不正当操作，提交失败', '', 'error');
                }
                if ($item['status'] == 0 && $_GPC['status'] == -1 || $_GPC['status'] == -2) {
                    $credits = mc_credit_fetch($item['uid'], '*');
                    $conf = $this->module['config'];
                    if ($this->module['config']['getcash']['ratio']) {
                        $money_credits = $this->module['config']['getcash']['ratio'] * $item['money'];
                        $credits[$conf['getcash']['type']] = str_replace('.00', '', $credits[$conf['getcash']['type']]) + $money_credits;
                    }
                    mc_update($item['uid'], $credits);
                }
                $data = array(
                    'user_id' => $_W['user']['uid'],
                    'realname' => $_GPC['realname'],
                    'remark' => $_GPC['remark'],
                    'status' => $_GPC['status'],
                    'message' => $_GPC['message'],
                    'reason' => $_GPC['reason'],
                );
                $condition = array(
                    'id' => $id,
                );
                pdo_update('superman_getcash', $data, $condition);
                message('更新成功', $this->createWebUrl('manage', array('act' => 'display')), 'success');
            }
        }

        if ($act == 'delete') {
            $id = intval($_GPC['id']);
            if (empty($id)) {
                message('参数错误');
            }
            $condition = array(
                'id' => $id,
            );
            $sql = 'SELECT * FROM '.tablename('superman_getcash').' WHERE id=:id';
            $param = array(
                ':id' => $id,
            );
            $item = pdo_fetch($sql, $param);
            if (isset($item['status']) && $item['status'] == 0) {
                $credits = mc_credit_fetch($item['uid'], '*');
                $conf = $this->module['config'];
                if (empty($this->module['config']['getcash']['ratio'])) {
                    message('提现比率不存在！', '', 'error');
                }
                $money_credits = $this->module['config']['getcash']['ratio'] * $item['money'];
                $credits[$conf['getcash']['type']] = str_replace('.00', '', $credits[$conf['getcash']['type']]) + $money_credits;
                mc_update($item['uid'], $credits);
            }
            pdo_delete('superman_getcash', $condition);
            message('删除成功', referer(), 'success');
        }

        if ($act == 'pay') {
            $this->getcash_pay();
        }
        include $this->template('manage');
    }
    private function _get_credits($credit_type) {
        global $_W, $_GPC;
        $credits = array();
        $list = pdo_fetch("SELECT creditnames FROM ".tablename('uni_settings') . " WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
        if(!empty($list['creditnames'])) {
            $list = iunserializer($list['creditnames']);
            if(is_array($list)) {
                foreach($list as $k => $v) {
                    $credits[$k] = $v;
                }
            }
        }
        return $credits[$credit_type]['title'];
    }
}

$obj = new Superman_getcash_doWebManage;
$obj->exec();
