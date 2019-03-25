<?php

/**
 * used: 
 * User: imeepos
 * Qq: 1037483576
 */
class manage
{
    public $table = 'imeepos_coach_manage';

    public function __construct()
    {
        $this->install();
    }

    public function getall($params){
        global $_W,$_GPC;
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

    public function getList($page,$where ="",$params=array()){
        global $_W,$_GPC;
        if(empty($page)){
            $page = 1;
        }
        $psize = 20;
        $total = 0;
        $params['uniacid'] = $_W['uniacid'];
        $p = trim($_GPC['week_id']);
        if(!empty($p)){
            $where .= " AND week_id = :week_id";
            $params[':week_id'] = $p;
        }
        unset($p);
        $p = trim($_GPC['time_id']);
        if(!empty($p)){
            $where .= " AND time_id = :time_id";
            $params[':time_id'] = $p;
        }
        unset($p);
        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid {$where} ORDER BY create_time DESC limit ".(($page-1)*$psize).",".$psize;
        
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
    public function getMy(){

    }
    //post_num
    public function addPost_num($id){
        $info = $this->getInfo($id);
        $read_num = intval($info['post_num'])+1;
        pdo_update($this->table,array('post_num'=>$read_num),array('id'=>$id));
    }
    public function redPost_num($id){
        $info = $this->getInfo($id);
        $read_num = intval($info['post_num'])-1;
        pdo_update($this->table,array('post_num'=>$read_num),array('id'=>$id));
    }
    //addLike_num
    public function addGoods_num($id){
        $info = $this->getInfo($id);
        $read_num = intval($info['goods_num'])+1;
        pdo_update($this->table,array('goods_num'=>$read_num),array('id'=>$id));
    }
    public function redGoods_num($id){
        $info = $this->getInfo($id);
        $read_num = intval($info['goods_num'])-1;
        pdo_update($this->table,array('goods_num'=>$read_num),array('id'=>$id));
    }
    //collect_num
    public function addCollect_num($id){
        $info = $this->getInfo($id);
        $read_num = intval($info['collect_num'])+1;
        pdo_update($this->table,array('collect_num'=>$read_num),array('id'=>$id));
    }
    public function redCollect_num($id){
        $info = $this->getInfo($id);
        $read_num = intval($info['collect_num'])-1;
        pdo_update($this->table,array('collect_num'=>$read_num),array('id'=>$id));
    }
    public function addRead_num($id){
        $info = $this->getInfo($id);
        $read_num = intval($info['read_num'])+1;
        pdo_update($this->table,array('read_num'=>$read_num),array('id'=>$id));
    }
    public function getInfo($id){
        global $_W;
        $item = pdo_get($this->table,array('id'=>$id));
        return $item;
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
        if(!pdo_fieldexists($this->table,'title')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `title` varchar(32) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'image')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `image` varchar(320) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'desc')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `desc` varchar(1000) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'content')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `content` varchar(3000) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'teacher_id')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `teacher_id` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'status')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `status` tinyint(2) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'post_start_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `post_start_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'post_end_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `post_end_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'start_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `start_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'end_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `end_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'max_num')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `max_num` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'group_id')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `group_id` varchar(1000) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'ishot')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `ishot` tinyint(2) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'share_num')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `share_num` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'read_num')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `read_num` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'post_num')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `post_num` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'goods_num')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `goods_num` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'collect_num')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `collect_num` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'week_id')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `week_id` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'one_money')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `one_money` decimal(10,2) DEFAULT '0.00'");
        }
        if(!pdo_fieldexists($this->table,'time_id')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `time_id` int(11) DEFAULT '0'");
        }
    }
}