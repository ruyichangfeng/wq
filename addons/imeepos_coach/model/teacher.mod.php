<?php

/**
 * used: 
 * User: imeepos
 * Qq: 1037483576
 */
class teacher
{
    public $table = 'imeepos_coach_teacher';

    public function __construct()
    {
        $this->install();
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

    public function getList($page,$where =""){
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
    public function update($data){
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
    public function getInfo($id){
        global $_W;
        $item = pdo_get($this->table,array('id'=>$id));
        return $item;
    }
    public function addRead_num($id){
        $info = $this->getInfo($id);
        $read_num = intval($info['read_num']) + 1;
        pdo_update($this->table,array('read_num'=>$read_num),array('id'=>$id));
    }
    public function addShare_num($id){
        $info = $this->getInfo($id);
        $read_num = intval($info['share_num']) + 1;
        pdo_update($this->table,array('share_num'=>$read_num),array('id'=>$id));
    }
    public function addPost_num($id){
        $info = $this->getInfo($id);
        $read_num = intval($info['post_num']) + 1;
        pdo_update($this->table,array('post_num'=>$read_num),array('id'=>$id));
    }
    public function redPost_num($id){
        $info = $this->getInfo($id);
        $read_num = intval($info['post_num']) - 1;
        pdo_update($this->table,array('post_num'=>$read_num),array('id'=>$id));
    }
    public function install(){
        if(!pdo_tableexists($this->table)){
            $sql = "CREATE TABLE ".tablename($this->table)." (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `uniacid` int(11) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
            pdo_query($sql);
        }
        if(!pdo_fieldexists($this->table,'create_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `create_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'realname')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `realname` varchar(32) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'grade_id')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `grade_id` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'avatar')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `avatar` varchar(320) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'openid')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `openid` varchar(64) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'desc')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `desc` varchar(1000) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'sex')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `sex` tinyint(2) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'status')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `status` tinyint(2) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'ishot')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `ishot` tinyint(2) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'mobile')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `mobile` varchar(32) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'coach_id')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `coach_id` varchar(1000) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'images')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `images` varchar(3000) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'post_num')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `post_num` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'one_money')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `one_money` decimal(10,2) DEFAULT '0.00'");
        }
        if(!pdo_fieldexists($this->table,'read_num')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `read_num` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'share_num')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `share_num` int(11) DEFAULT '0'");
        }
    }
}