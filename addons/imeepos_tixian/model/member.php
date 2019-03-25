<?php

class ImeeposTixian_member
{
    public $table = 'imeepos_runner3_member';

    public function __construct()
    {
        global $_W;
        $this->install();
    }

    public function getall($params = array()){
        global $_W;
        $params['uniacid'] = $_W['uniacid'];
        $list = pdo_getall($this->table,$params);
        return $list;
    }

    public function delete($id){
        if(empty($id)){
            return '';
        }
        pdo_delete($this->table,array('id'=>$id));
    }

    public function getList2($page,$where=""){
        global $_W,$_GPC;
        if(empty($page)){
            $page = 1;
        }
        $psize = 20;
        $total = 0;
        $params['uniacid'] = $_W['uniacid'];
        $nickname = trim($_GPC['nickname']);
        if(!empty($nickname)){
            $where .= " AND nickname like '%{$nickname}%'";
        }
        $openid = trim($_GPC['openid']);
        if(!empty($openid)){
            $where .= " AND openid like '%{$openid}%'";
        }
        $realname = trim($_GPC['realname']);
        if(!empty($realname)){
            $where .= " AND realname like '%{$realname}%'";
        }
        $mobile = trim($_GPC['mobile']);
        if(!empty($mobile)){
            $where .= " AND mobile like '%{$mobile}%'";
        }
        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid {$where} ORDER BY time DESC limit ".(($page-1)*$psize).",".$psize;
        $result = array();
        $result['list'] = pdo_fetchall($sql,$params);
        $sql = "SELECT COUNT(*) FROM ".tablename($this->table)." WHERE uniacid = :uniacid {$where}";
        $total = pdo_fetchcolumn($sql,$params);

        $result['pager'] = pagination($total, $page, $psize);
        if(empty($result)){
            return array();
        }else{
            return $result;
        }
    }

    public function getList($page,$where="",$params){
        global $_W,$_GPC;

        $input = $_GPC['__input'];
        if(empty($page)){
            $page = 1;
        }
        $psize = 20;
        $total = 0;
        $params[':uniacid'] = $_W['uniacid'];
        $nickname = trim($_GPC['nickname']);

        if(!empty($nickname)){
            $where .= " AND nickname like '%{$nickname}%'";
        }
        $p = trim($input['keyword']);
        if(!empty($p)){
            $where .= " AND nickname like '%{$p}%'";
        }
        unset($p);
        $openid = trim($_GPC['openid']);
        if(!empty($openid)){
            $where .= " AND openid like '%{$openid}%'";
        }
        $realname = trim($_GPC['realname']);
        if(!empty($realname)){
            $where .= " AND realname like '%{$realname}%'";
        }
        $mobile = trim($_GPC['mobile']);
        if(!empty($mobile)){
            $where .= " AND mobile like '%{$mobile}%'";
        }
        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid {$where} ORDER BY time DESC limit ".(($page-1)*$psize).",".$psize;
        $result = array();
        $result['list'] = pdo_fetchall($sql,$params);
        $sql = "SELECT COUNT(*) FROM ".tablename($this->table)." WHERE uniacid = :uniacid {$where}";
        $total = pdo_fetchcolumn($sql,$params);

        $result['pager'] = pagination($total, $page, $psize);
        if(empty($result)){
            return array();
        }else{
            return $result;
        }
    }
    public function update_or_insert($data){
        global $_W;
        $data['uniacid'] = $_W['uniacid'];
        if(empty($data['id'])){
            pdo_insert($this->table,$data);
            $data['id'] = pdo_insertid();
        }else{
            //更新
            pdo_update($this->table,$data,array('uniacid'=>$_W['uniacid'],'id'=>$data['id']));
        }
        return $data;
    }
    public function update(){
        global $_W;
        if(empty($_W['openid'])){
            return '';
        }
        load()->model('mc');
        $uid = mc_openid2uid($_W['openid']);
        $user = mc_fetch($uid,array('nickname','avatar','realname','mobile','gender','residecity','resideprovince'));

        if(empty($user['avatar'])){
            $user = mc_oauth_userinfo();
        }
        $member = $this->getInfo($_W['openid']);
        if(empty($member)){
            $data = array();
            $data['uniacid'] = $_W['uniacid'];
            $data['openid'] = $_W['openid'];
            $data['nickname'] = $user['nickname'];
            $data['avatar'] = tomedia($user['avatar']);
            $data['time'] = time();
            $data['uid'] = $uid;
            if(!empty($_W['openid'])){
                pdo_insert($this->table,$data);
            }
        }else{
            $data = array();
            $data['nickname'] = $user['nickname'];
            $data['avatar'] = tomedia($user['avatar']);
            $data['uid'] = $uid;
            pdo_update($this->table,$data,array('id'=>$member['id']));
        }

        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND openid = :openid";
        $params = array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']);
        $member = pdo_fetch($sql,$params);
        $user = array_merge($user,$member);
        return $user;
    }
    public function getInfoById($id){
        global $_W;
        $item = pdo_get($this->table,array('id'=>$id));
        return $item;
    }
    public function getBastRunner($page){
        global $_W;
        $psize = 10;
        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND isrunner = :isrunner AND status = :status ORDER BY xinyu DESC limit ".(($page-1)*$psize).",".$psize;
        $params = array(':uniacid'=>$_W['uniacid'],':isrunner'=>1,':status'=>1);
        $list = pdo_fetchall($sql,$params);
        return $list;
    }
    public function getBastMember($page){
        global $_W;
        $psize = 10;
        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND isrunner = :isrunner AND status = :status ORDER BY time DESC limit ".(($page-1)*$psize).",".$psize;
        $params = array(':uniacid'=>$_W['uniacid'],':isrunner'=>0,':status'=>1);
        $list = pdo_fetchall($sql,$params);
        return $list;
    }
    public function getById($id){
        return pdo_get($this->table,array('id'=>$id));
    }
    public function getInfo($openid){
        global $_W;
        if(is_numeric($openid)){
            $uid = $openid;
            $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND uid = :uid";
            $params = array(':uniacid'=>$_W['uniacid'],':uid'=>$uid);
            $item = pdo_fetch($sql,$params);
            return $item;
        }else{
            $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND openid = :openid";
            $params = array(':uniacid'=>$_W['uniacid'],':openid'=>$openid);
            $item = pdo_fetch($sql,$params);
            return $item;
        }
    }
    public function getRunnerList(){
        global $_W;
        $sql = "SELECT * FROM ".tablename('imeepos_runner3_member')." WHERE uniacid = :uniacid AND isrunner = :isrunner";
        $params = array(':uniacid'=>$_W['uniacid'],':isrunner'=>1);
        $list = pdo_fetchall($sql,$params);
        return $list;
    }
    public function addxinyu($to_openid,$xinyu){
        global $_W;
        $info = $this->getInfo($to_openid);
        if(empty($to_openid)){
            return '';
        }
        $info['xinyu'] = floatval($info['xinyu']) + $xinyu;
        $level = $this->M('runner_level')->getInfo($info['level_id']);
        $displayorder = intval($level['displayorder'])>0?intval($level['displayorder']):0;
        $nextlevel = $this->M('runner_level')->getNext($displayorder);
        if(!empty($nextlevel)){
            if($info['xinyu'] >= $nextlevel['xinyu']){
                $info['level_id'] = $nextlevel['id'];
            }
        }
        if(empty($info['openid'])){
            return '';
        }
        $this->update_or_insert($info);
    }
    public function totalstatus(){
        global $_W,$_GPC;
        $return = array();
        $return['all'] = array();
        $params = array(':uniacid'=>$_W['uniacid']);
        $where = "";
        $p = trim($_GPC['start_time']);
        if(!empty($p)){
            $where .= " AND create_time >= :start_time";
            $params[':start_time'] = strtotime($p);
        }
        unset($p);
        $p = trim($_GPC['end_time']);
        if(!empty($p)){
            $where .= " AND create_time <= :end_time";
            $params[':end_time'] = strtotime($p);
        }
        unset($p);
        $p = trim($_GPC['isrunner']);
        if(!empty($p)){
            $where .= " AND isrunner = :isrunner";
            $params[':isrunner'] = $p;
        }
        unset($p);
        $sql = "SELECT SUM(status) FROM ".tablename($this->table)." WHERE uniacid = :uniacid {$where}";
        $return['all']['fee'] = pdo_fetchcolumn($sql,$params);
        $sql = "SELECT COUNT(*) FROM ".tablename($this->table)." WHERE uniacid = :uniacid {$where}";
        $return['all']['sum'] = pdo_fetchcolumn($sql,$params);
        if(empty($return['all']['fee'])){
            $return['all']['fee'] = 0.00;
        }
        if(empty($return['all']['sum'])){
            $return['all']['sum'] = 0;
        }
        $start_time = strtotime(date('Y-m-d',time()));
        $end_time = time();

        $return['day'] = array();
        $sql = "SELECT SUM(status) FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND `time` >=:star_time AND `time` <=:end_time {$where}";
        $params[':star_time'] = $start_time;
        $params[':end_time'] = $end_time;

        $return['day']['fee'] = pdo_fetchcolumn($sql,$params);
        $sql = "SELECT COUNT(*) FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND `time` >=:star_time AND `time` <=:end_time {$where}";
        $return['day']['sum'] = pdo_fetchcolumn($sql,$params);

        if(empty($return['day']['fee'])){
            $return['day']['fee'] = 0.00;
        }
        if(empty($return['day']['sum'])){
            $return['day']['sum'] = 0;
        }
        $start_time = strtotime(date("Y-m-d H:i:s",mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))));
        $end_time = strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))));
        $return['week'] = array();
        $params[':star_time'] = $start_time;
        $params[':end_time'] = $end_time;
        $sql = "SELECT SUM(status) FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND `time` >=:star_time AND `time` < :end_time {$where}";

        $return['week']['fee'] = pdo_fetchcolumn($sql,$params);
        $sql = "SELECT COUNT(*) FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND `time` >:star_time AND `time` < :end_time {$where}";
        $return['week']['sum'] = pdo_fetchcolumn($sql,$params);
        if(empty($return['week']['fee'])){
            $return['week']['fee'] = 0.00;
        }
        if(empty($return['week']['sum'])){
            $return['week']['sum'] = 0;
        }
        $start_time = strtotime(date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y"))));
        $end_time = strtotime(date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y"))));
        $return['month'] = array();
        $params[':star_time'] = $start_time;
        $params[':end_time'] = $end_time;
        $sql = "SELECT SUM(status) FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND time >=:star_time AND time <=:end_time {$where}";
        $return['month']['fee'] = pdo_fetchcolumn($sql,$params);
        $sql = "SELECT COUNT(*) FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND time >=:star_time AND time <=:end_time {$where}";
        $return['month']['sum'] = pdo_fetchcolumn($sql,$params);
        if(empty($return['month']['fee'])){
            $return['month']['fee'] = 0.00;
        }
        if(empty($return['month']['sum'])){
            $return['month']['sum'] = 0;
        }
        return $return;
    }
    public function install(){
        if(!pdo_tableexists($this->table)){
            $sql = "CREATE TABLE ".tablename($this->table)." (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `uid` int(11) unsigned NOT NULL,
			  `uniacid` int(11) unsigned NOT NULL,
			  `status` tinyint(2) unsigned NOT NULL,
			  `groupid` int(11) unsigned NOT NULL,
			  `time` int(11) DEFAULT NULL,
			  `openid` varchar(64) DEFAULT NULL,
			  `online` tinyint(2) DEFAULT '0',
			  `nickname` varchar(32) DEFAULT '',
			  `avatar` varchar(320) DEFAULT NULL,
			  `gender` tinyint(2) DEFAULT '0',
			  `city` varchar(32) DEFAULT '',
			  `provice` varchar(32) DEFAULT '',
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8";
            pdo_query($sql);
        }

        if(!pdo_fieldexists($this->table,'realname')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `realname` varchar(32) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'mobile')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `mobile` varchar(32) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'xinyu')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `xinyu` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'isrunner')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `isrunner` tinyint(2) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'card_image1')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `card_image1` varchar(320) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'card_image2')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `card_image2` varchar(320) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'cardnum')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `cardnum` varchar(64) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'lat')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `lat` varchar(64) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'lng')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `lng` varchar(64) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'status')){
            $sql = "ALTER TABLE ".tablename($this->table)." ADD COLUMN `status` tinyint(4) DEFAULT '1'";
            pdo_query($sql);
        }
        if(!pdo_fieldexists($this->table,'nickname')){
            $sql = "ALTER TABLE ".tablename($this->table)." ADD COLUMN `nickname` varchar(64) DEFAULT ''";
            pdo_query($sql);
        }
        if(!pdo_fieldexists($this->table,'uid')){
            $sql = "ALTER TABLE ".tablename($this->table)." ADD COLUMN `uid` int(11) DEFAULT '0'";
            pdo_query($sql);
        }
        if(!pdo_fieldexists($this->table,'oauth_code')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `oauth_code` varchar(64) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'level_id')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `level_id` int(11) DEFAULT '0'");
        }
    }
}