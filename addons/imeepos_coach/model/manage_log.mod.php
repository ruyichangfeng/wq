<?php

/**
 * used: 
 * User: imeepos
 * Qq: 1037483576
 */
class manage_log extends Imeepos_coachModuleSite
{
    public $table = 'imeepos_coach_manage_log';

    public function __construct()
    {
        $this->install();
        global $_W;
        $start_time = date('Y-m-d',time()) - 60*60*24*7;
        if($start_time < 0){
            $start_time = 0;
        }

        //查询已结束课程
        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND end_time < :end_time AND status = :status AND openid = :openid";
        $params = array(':uniacid'=>$_W['uniacid'],':end_time'=>time(),':status'=>0,':openid'=>$_W['openid']);
        $list = pdo_fetchall($sql,$params);
        $setting = M('setting')->getSetting('open');
        $limit_out = intval($setting['limit_out']);
        foreach ($list as $li){
            $member = M('member')->getInfo($li['openid']);
            $member['forbid'] = 1;
            $forbid_time = $member['forbid_time'];
            if($forbid_time > time()){
                $member['forbid_time'] = $forbid_time + $limit_late*60;
            }else{
                $member['forbid_time'] = time() + $limit_late*60;
            }
            M('member')->update_or_insert($member);
            $li['status'] = 3; //旷课
            $this->update($li);
        }
    }

    public function getMy($manage_id){
        global $_W;
        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid =:uniacid AND openid =:openid AND end_time > :end_time AND manage_id =:manage_id";
        $params = array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid'],':end_time'=>time(),':manage_id'=>$manage_id);
        $item = pdo_fetchall($sql,$params);
        return $item;
    }

    public function getall($params = array()){
        global $_W,$_GPC;
        $params['uniacid'] = $_W['uniacid'];
        $list = pdo_getall($this->table,$params);
        return $list;
    }

    public function delete($id){
        global $_W;
        if(empty($id)){
            return '';
        }
        $info = $this->getInfo($id);

        M('manage')->redPost_num($info['manage_id']);

        $manage = M('manage')->getInfo($info['manage_id']);
        if($info['status'] == 0){
            $content = "恭喜您".$info['realname']."您已成功取消预约\n";
            $content .= "课程名：【".$manage['title']."】\n";
            $content .= "提交时间：".date('Y-m-d H:i',time());
            $url = murl('entry',array('do'=>'home','m'=>'imeepos_coach'));
            $url = str_replace('./','',$url);
            $url = $_W['siteroot']."/app/".$url;
            M('notice')->mc_notice_consume($_W['openid'], "课程预约取消通知", $content,$url);

            $teacher = M('teacher')->getInfo($manage['teacher_id']);
            $content = "".$info['realname']."取消了预约\n";
            $content .= "课程名:【".$manage['title']."】\n";
            $content .= "提交时间：".date('Y-m-d H:i',time());
            $url = murl('entry',array('do'=>'home','m'=>'imeepos_coach'));
            $url = str_replace('./','',$url);
            $url = $_W['siteroot']."/app/".$url;
            M('notice')->mc_notice_consume($teacher['openid'], "课程预约取消通知", $content,$url);
        }

        pdo_delete($this->table,array('id'=>$id));
    }

    public function getList($page,$where ="",$params = array()){
        global $_W,$_GPC;
        if(empty($page)){
            $page = 1;
        }
        $psize = 20;
        $total = 0;
        $params['uniacid'] = $_W['uniacid'];
        $p = trim($_GPC['manage_id']);
        if(!empty($p)){
            $where .= " AND manage_id = :manage_id";
            $params[':manage_id'] = $p;
        }
        unset($p);
        $p = trim($_GPC['start_time']);
        if(!empty($p)){
            $where .= " AND start_time = :start_time";
            $params[':start_time'] = $p;
        }
        unset($p);
        $p = trim($_GPC['end_time']);
        if(!empty($p)){
            $where .= " AND end_time = :end_time";
            $params[':end_time'] = $p;
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
            //发给老师通知
            $manage = M('manage')->getInfo($data['manage_id']);
            $teacher = M('teacher')->getInfo($manage['teacher_id']);
            $content = "".$data['realname']."预约了【".$manage['title']."】，请注意查看！";
            $content .= "提交时间：".date('Y-m-d H:i',time());
            $url = murl('entry',array('do'=>'home','m'=>'imeepos_coach'));
            $url = str_replace('./','',$url);
            $url = $_W['siteroot']."/app/".$url;
            M('notice')->mc_notice_consume($teacher['openid'], "课程预约通知", $content,$url);

            $content = "恭喜您".$data['realname']."您已成功预约【".$manage['title']."】，请注意查看！";
            $content .= "提交时间：".date('Y-m-d H:i',time());
            $url = murl('entry',array('do'=>'home','m'=>'imeepos_coach'));
            $url = str_replace('./','',$url);
            $url = $_W['siteroot']."/app/".$url;
            M('notice')->mc_notice_consume($_W['openid'], "课程预约通知", $content,$url);

            M('manage')->addPost_num($data['manage_id']);
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
        if(!pdo_fieldexists($this->table,'openid')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `openid` varchar(64) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'manage_id')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `manage_id` int(11) DEFAULT '0'");
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
        if(!pdo_fieldexists($this->table,'start_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `start_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'end_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `end_time` int(11) DEFAULT '0'");
        }
    }
}