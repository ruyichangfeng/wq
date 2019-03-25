<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$schoolid = intval($_GPC['schoolid']);
$openid = $_W['openid'];
//查询是否用户登录
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
$userInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $user['uid'], ':uniacid' => $weid));
if(!empty($_GPC['bookid'])){
    $commentLists = pdo_fetchall("SELECT * FROM " . tablename($this->table_bookcomment) . " where bookid = {$_GPC['bookid']}");
    if(!empty($commentLists)){
        $data = array();
        $users = array();
        foreach($commentLists as $commentList){
            if(empty($users[$commentList['openid']])){
                $partyb = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $commentList['openid']), 'id');
                $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $partyb['uid'], ':uniacid' => $weid));
                $users[$commentList['openid']] = array(
                    'userinfo' => unserialize($partyb['userinfo']),
                    'userImg'  => $mcInfo['avatar'],
                    'nickname' => $mcInfo['nickname'],
                );
            }
            $commentList['userData'] = $users[$commentList['openid']];
            $data[] =  $commentList;
        }
    }
    $show_url = $this->createMobileUrl("show",array('bookid' => $_GPC['bookid'],'schoolid' => $schoolid));
    $fabu_url = $this->createMobileUrl('Fabus',array('bookid' => $_GPC['bookid'],'schoolid' => $schoolid));
    $sql = "SELECT * FROM ".tablename("liuyan_website")."WHERE acid = ".$_W['uniacid'];
    $site = pdo_fetch($sql);
    include $this->template('book/commentlist1');
}else{
    include $this->template('common/404.html');
}
?>