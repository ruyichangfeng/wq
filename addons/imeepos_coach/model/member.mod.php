<?php

class member
{
    public $table = 'imeepos_coach_member';

    public function __construct()
    {
        global $_W;
        $this->install();
        //检查过期
        $time = time();
        $group = M('group')->getDefault();
        //解封账号
        $member = $this->getInfo($_W['openid']);
        if(!empty($member)){
            if($member['limit_time'] < $time){
                $member['group_id'] = $group['id'];
            }
            if($member['forbid_time'] < $time){
                $member['forbid'] = 0;
            }
            $this->update_or_insert($member);
        }
    }

    public function getall(){
        global $_W;
        $list = pdo_getall($this->table,array('uniacid'=>$_W['uniacid']));
        return $list;
    }

    public function delete($id){
        if(empty($id)){
            return '';
        }
        pdo_delete($this->table,array('id'=>$id));
    }

    public function getList($page){
        global $_W;
        if(empty($page)){
            $page = 1;
        }
        $psize = 20;
        $total = 0;
        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid {$where} ORDER BY create_time DESC limit ".(($page-1)*$psize).",".$psize;
        $params = array(':uniacid'=>$_W['uniacid']);
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
        $member = M('member')->getInfo($_W['openid']);

        if(empty($member)){
            $data = array();
            $data['uniacid'] = $_W['uniacid'];
            $data['openid'] = $_W['openid'];
            $data['nickname'] = $user['nickname'];
            $data['avatar'] = tomedia($user['avatar']);
            $data['create_time'] = time();
            $data['uid'] = $uid;
            $data['status'] = 1;
            $group = M('group')->getDefault();
            $data['group_id'] = $group['id'];
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
    public function getInfo($openid){
        global $_W;
        $item = pdo_get($this->table,array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
        return $item;
    }
    public function install(){
        if(!pdo_tableexists($this->table)){
            $sql = "CREATE TABLE ".tablename($this->table)." (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `uniacid` int(11) DEFAULT '0',
              `openid` varchar(64) DEFAULT '‘’',
              `number` int(11) DEFAULT '0' COMMENT '回答个数',
              `follow` int(11) DEFAULT '0' COMMENT '收听人数',
              `tags` varchar(20) DEFAULT '‘’' COMMENT '头衔',
              `desc` varchar(320) DEFAULT '‘’',
              `credit` decimal(10,2) DEFAULT '0.00' COMMENT '提问费用',
              `avatar` varchar(320) DEFAULT '',
              `nickname` varchar(32) DEFAULT '',
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
            pdo_query($sql);
        }
        if(!pdo_fieldexists($this->table,'create_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `create_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'uid')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `uid` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'group_id')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `group_id` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'status')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `status` tinyint(2) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'realname')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `realname` varchar(32) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'mobile')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `mobile` varchar(32) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'limit_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `limit_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'forbid_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `forbid_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'forbid')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `forbid` tinyint(2) DEFAULT '0'");
        }
        
    }
}