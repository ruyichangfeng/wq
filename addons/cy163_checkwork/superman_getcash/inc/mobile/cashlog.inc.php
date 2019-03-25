<?php
/**
 * 【超人】提现模块定义
 *
 * @author 超人
 * @url
 */
defined('IN_IA') or exit('Access Denied');
class Superman_getcash_doMobileCashlog extends Superman_getcashModuleSite {

    public function __construct() {
        parent::__construct();
    }

    public function exec() {
        global $_W, $_GPC;
        $style = in_array($_GPC['style'], array('default', 'weui'))?$_GPC['style']:'weui';
        $title = '提现记录';
        checkauth();
        load()->func('tpl');
        $conf = $this->module['config'];
        $pindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $start = ($pindex - 1) * $pagesize;
        $starttime =  strtotime('-1 month');
        $endtime = time();
        $uid = $_W['member']['uid'];
        $where = ' WHERE `uid` = :uid';
        $param[':uid'] = $uid;
        if ($_GPC['time']) {
            $starttime = strtotime($_GPC['time']['start']);
            $endtime = strtotime($_GPC['time']['end']) + 86399;
            $where .= ' AND `insert_time` >= :starttime AND `insert_time` < :endtime';
            $param[':starttime'] = $starttime;
            $param[':endtime'] = $endtime;
        }
        if (isset($_GPC['status'])) {
            $status = intval($_GPC['status']);
            $where .= ' AND `status`=:status';
            $param[':status'] = $status;
        }

        $sql = "SELECT * FROM ".tablename('superman_getcash')." {$where} ORDER BY id DESC LIMIT $start,$pagesize";
        //echo $sql;
        $list = pdo_fetchall($sql, $param);
        //echo pdo_debug(true);
        $cash = array(
            'get' => $this->_getcash_total($uid, 1),
            'unget' => $this->_getcash_total($uid, 0),
        );
        if ($list) {
            foreach ($list as &$item) {
                $item['insert_time'] = $item['insert_time']?date('Y-m-d H:i:s', $item['insert_time']):'';
                $item['update_time'] = $item['update_time']?date('Y-m-d H:i:s', $item['update_time']):'';
            }
            //print_r($list);
            $sql = "SELECT COUNT(*) FROM ".tablename('superman_getcash')." {$where}";
            $total = pdo_fetchcolumn($sql, $param);
            $pager = pagination($total, $pindex, $pagesize);
        }
        if ($_W['isajax'] && $_GPC['load'] == 'infinite') {
            die(json_encode($list));
        }
        $member = mc_fetch($uid, array('avatar', 'nickname', 'realname'));
        if ($style == 'default') {
            include $this->template('cashlog');
        } else {
            include $this->template($style.'/cashlog');
        }
    }

    private function _getcash_total($uid, $status) {
        $sql = 'SELECT SUM(money) FROM '.tablename('superman_getcash').' WHERE uid=:uid AND status=:status';
        $param = array(
            ':uid' => $uid,
            ':status' => $status,
        );
        $ret = pdo_fetchcolumn($sql, $param);
        return $ret?$ret:'0.00';
    }
}

$obj = new Superman_getcash_doMobileCashlog;
$obj->exec();
