<?php

/**
 * used: 
 * User: imeepos
 * Qq: 1037483576
 */
class teacher_log
{
    public $table = 'imeepos_coach_teacher_log';

    public function __construct()
    {
        $this->install();
        global $_W;
        //查询已结束课程
        $sql = "SELECT * FROM ".tablename($this->table)." WHERE uniacid = :uniacid AND end_time < :end_time AND status = :status";
        $params = array(':uniacid'=>$_W['uniacid'],':end_time'=>time(),':status'=>0);
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
            $li['status'] = 2;
            $this->update($li);
        }
    }

    public function getall($params = array()){
        global $_W,$_GPC;
        $params['unaicid'] = $_W['uniacid'];
        $list = pdo_getall($this->table,$params);
        return $list;
    }
    public function getMy($teacher_id){
        global $_W;
        $item = pdo_get($this->table,array('teacher_id'=>$teacher_id,'openid'=>$_W['openid']));
        return $item;
    }

    public function delete($id){
        if(empty($id)){
            return '';
        }
        $info = $this->getInfo($id);
        M('teacher')->redPost_num($info['teacher_id']);

        $teacher = M('teacher')->getInfo($info['teacher_id']);
        $member = M('member')->getInfo($info['openid']);
        if($info['status'] == 0){
            $content = "恭喜您".$member['realname']."您已成功取消私教预约\n";
            $content .= "提交时间：".date('Y-m-d H:i',time());
            $url = murl('entry',array('do'=>'home','m'=>'imeepos_coach'));
            $url = str_replace('./','',$url);
            $url = $_W['siteroot']."/app/".$url;
            M('notice')->mc_notice_consume($info['openid'], "私教预约取消通知", $content,$url);

            $content = "".$member['realname']."取消了私教预约\n";
            $content .= "提交时间：".date('Y-m-d H:i',time());
            $url = murl('entry',array('do'=>'home','m'=>'imeepos_coach'));
            $url = str_replace('./','',$url);
            $url = $_W['siteroot']."/app/".$url;
            M('notice')->mc_notice_consume($teacher['openid'], "私教预约取消通知", $content,$url);
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

            $teacher = M('teacher')->getInfo($data['teacher_id']);
            $member = M('member')->getInfo($data['openid']);

            $content = "恭喜您".$member['realname']."您已成功预约私教\n";
            $content .="老师：".$teacher['realname']."\n";
            $content .= "提交时间：".date('Y-m-d H:i',time());
            $url = murl('entry',array('do'=>'home','m'=>'imeepos_coach'));
            $url = str_replace('./','',$url);
            $url = $_W['siteroot']."/app/".$url;
            M('notice')->mc_notice_consume($info['openid'], "成功预约私教通知", $content,$url);

            $content = "".$member['realname']."预约了您\n";
            $content .= "提交时间：".date('Y-m-d H:i',time());
            $url = murl('entry',array('do'=>'home','m'=>'imeepos_coach'));
            $url = str_replace('./','',$url);
            $url = $_W['siteroot']."/app/".$url;
            M('notice')->mc_notice_consume($teacher['openid'], "新私教预约提醒", $content,$url);

            M('teacher')->addPost_num($data['teacher_id']);
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
        if(!pdo_fieldexists($this->table,'teacher_id')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `teacher_id` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'openid')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `openid` varchar(64) DEFAULT ''");
        }
        if(!pdo_fieldexists($this->table,'start_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `start_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'end_time')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `end_time` int(11) DEFAULT '0'");
        }
        if(!pdo_fieldexists($this->table,'status')){
            pdo_query("ALTER TABLE ".tablename($this->table)." ADD COLUMN `status` tinyint(2) DEFAULT '0'");
        }
    }
}