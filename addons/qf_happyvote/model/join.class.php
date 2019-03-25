<?php
class Join {
    /**
     * 获得分页投票信息
     * @voteid 投票标识
     * @condition 查询条件 数组类型 例： array(":title"=>$title);
     * @currpage 当前页
     * @pagesize 每页显示条数
     */
    public function getpagejoin($voteid, $condition, $currpage, $pagesize) {
        $total = 0;
        $star = ($currpage - 1) * $pagesize;

        $totalsql = "SELECT COUNT(1) FROM ".tablename('qf_vote_join')." WHERE vote_id = :voteid";
        $sql = "SELECT id,vote_id,open_id,uid,username,image,telephone,ip,check_state,poll_count,add_poll_count,create_time FROM ".tablename('qf_vote_join')." WHERE vote_id = :voteid";
        $paramarr = array(':voteid' => $voteid);
        
        //处理查询条件
        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                switch ($key) {
                    case ':username':  //查询姓名
                        $totalsql = $totalsql . " AND username LIKE :username";
                        $sql = $sql . " AND username LIKE :username";
                        $paramarr[$key] = "%" . $value . "%";
                    break;
                    case ':checkstate':  //查询审核状态
                        $totalsql = $totalsql . " AND check_state = :checkstate";
                        $sql = $sql . " AND check_state = :checkstate";
                        $paramarr[$key] = $value;
                    break;
                }
            }
        }

        $sql = $sql." ORDER BY create_time DESC LIMIT ".$star.",".$pagesize;

        $total = pdo_fetchcolumn($totalsql, $paramarr);
        $data = pdo_fetchall($sql, $paramarr);

        $pagedata = array('total' => $total,'data' => $data);

        return $pagedata;
    }

    /**
     * 根据审核状态获取活动参与者数量
     */
    public function getjoincount($voteid, $condition) {
        
        $sql = "SELECT COUNT(1) FROM ".tablename('qf_vote_join')." WHERE vote_id = :voteid";
        $paramarr = array(':voteid' => $voteid);

        //处理查询条件
        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                switch ($key) {
                    case ':username':  //查询姓名
                        $totalsql = $totalsql . " AND username LIKE :username";
                        $sql = $sql . " AND username LIKE :username";
                        $paramarr[$key] = "%" . $value . "%";
                    break;
                    case ':checkstate':  //查询审核状态
                        $totalsql = $totalsql . " AND check_state = :checkstate";
                        $sql = $sql . " AND check_state = :checkstate";
                        $paramarr[$key] = $value;
                    break;
                }
            }
        }
        
        $total = pdo_fetchcolumn($sql, $paramarr);
        return $total;
    }
    
    /**
     * 获得最新参与者信息
     */
    public function getnewjoins($voteid,$start,$limit) {
        $sql = "SELECT id,vote_id,open_id,uid,username,image,telephone,ip,check_state,(poll_count + add_poll_count) as display_poll_count,create_time FROM ".tablename('qf_vote_join')." WHERE vote_id = :voteid AND check_state = 2 ORDER BY create_time DESC LIMIT ".$start.",".$limit;
        $data = pdo_fetchall($sql, array(':voteid' => $voteid));
        return $data;
    }

    /**
     * 获得最热参与者信息
     */
    public function gethotjoins($voteid,$start,$limit) {
        $sql = "SELECT id,vote_id,open_id,uid,username,image,telephone,ip,check_state,(poll_count + add_poll_count) as display_poll_count,create_time FROM ".tablename('qf_vote_join')." WHERE vote_id = :voteid AND check_state = 2 ORDER BY display_poll_count DESC LIMIT ".$start.",".$limit;
        $data = pdo_fetchall($sql,array(':voteid'=>$voteid));
        
        return $data;
    }

    /**
     * 获得参与者信息
     */
    public function getjoin($voteid, $id) {
        $sql = "SELECT id,vote_id,open_id,uid,username,image,resume,telephone,ip,poll_count,add_poll_count,check_state,create_time FROM ".tablename('qf_vote_join')." WHERE vote_id = :voteid AND id = :id";
        $data = pdo_fetch($sql, array(':id' => $id, ':voteid' => $voteid));

        return $data;
    }

    /**
     * 根据openid获得参与者信息
     */
    public function getjoinbyopenid($voteid, $openid) {
        $sql = "SELECT id,vote_id,open_id,uid,username,image,resume,telephone,ip,poll_count,add_poll_count,check_state,create_time FROM ".tablename('qf_vote_join')." WHERE vote_id = :voteid AND open_id = :openid LIMIT 1";
        $data = pdo_fetch($sql, array(':voteid' => $voteid, ':openid' => $openid));
        return $data;
    }
    
    /**
     * 添加参与者
     * return 参与者标识 成功 0 失败
     */
    public function addjoin($data, $voteid) {
        //生成活动标识
        $data['id'] = pdo_fetchcolumn('call pro_qf_createjoinid('.$voteid.');');
        
        //新增活动
        $result = pdo_insert('qf_vote_join', $data);
        
        if(!empty($result)) {
            //更新报名人数
            $sql = "update ".tablename("qf_vote")." set join_count = join_count + 1 where id = :voteid";
            $result = pdo_query($sql, array(':voteid' => $voteid));        
            return $data['id'];
        } else {
            return 0;
        }
    }
    
    /**
     * 修改参与者信息
     */
    public function updatejoin($voteid, $id, $data) {
        pdo_update('qf_vote_join', $data, array('id' => $id,'vote_id' => $voteid));
    }
}
