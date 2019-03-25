<?php
class VoteRecord {
    /**
     * 获得分页投票信息
     * @uniacid 公众号标识
     * @condition 查询条件 数组类型 例： array(":title"=>$title);
     * @currpage 当前页
     * @pagesize 每页显示条数
     */
    public function getpagevoterecord($voteid, $joinid, $condition, $currpage, $pagesize) {
        $total = 0;
        $star = ($currpage - 1) * $pagesize;

        $totalsql = "SELECT COUNT(1) FROM ".tablename('qf_vote_record')." WHERE vote_id = :voteid AND join_id = :joinid";
        $sql = "SELECT id,vote_id,join_id,open_id,uid,nickname,ip,create_time FROM ".tablename('qf_vote_record')." WHERE join_id = :joinid";
        $paramarr = array(':joinid' => $joinid, ':voteid' => $voteid);
        
        //处理查询条件
        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                switch ($key) {
                    case ':nickname':  //查询昵称
                        $totalsql = $totalsql . " AND nickname LIKE :nickname";
                        $sql = $sql . " AND nickname LIKE :nickname";
                        $paramarr[$key] = "%" . $value . "%";
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

    //获得活动投票次数
    public function getvoterecordcount($voteid, $condition){
        $sql = "SELECT COUNT(1) FROM ".tablename('qf_vote_record')." WHERE vote_id = :voteid and DateDiff(create_time, curdate()) = 0";
        $paramarr = array(':voteid' => $voteid);
        //处理查询条件
        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                switch ($key) {
                    case ':joinid':  //查询昵称
                        $sql = $sql . " AND join_id = :joinid";
                        $paramarr[$key] = $value;
                    break;
                    case ':ip':  //查询昵称
                        $sql = $sql . " AND ip = :ip";
                        $paramarr[$key] = $value;
                    break;
                }
            }
        }
        $count = pdo_fetchcolumn($sql, $paramarr);   
		return $count;
    }

    /**
     * 新增投票记录
     * 1 成功 0失败
     */
    public function addvoterecord($data, $voteid, $joinid, $openid) {
        
        $result = pdo_insert('qf_vote_record', $data);
		
        if(!empty($result)) {
            //判断是否新的投票人员并更新活动投票人数
            $sql = "SELECT COUNT(1) FROM ".tablename('qf_vote_record')." WHERE vote_id =:voteid AND open_id = :openid";
            $votecount = pdo_fetchcolumn($sql, array(':voteid' => $voteid, ":openid" => $openid));
            
            if($votecount == 1){ //更新活动投票人数
                pdo_query("update ".tablename("qf_vote")." set vote_count = vote_count + 1 where id = :voteid", array(':voteid' => $voteid));
            }

            //更新参与者得票数量
            pdo_query("update ".tablename("qf_vote_join")." set poll_count = poll_count + 1 where id = :joinid and vote_id = :voteid", array(':joinid' => $joinid, ':voteid' => $voteid));          
            return 1;
        } else {
            return 0;
        }
    }

    //投票

}
