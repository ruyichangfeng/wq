<?php
class Vote {
    /**
     * 获得分页投票信息
     * @uniacid 公众号标识
     * @condition 查询条件 数组类型 例： array(":title"=>$title);
     * @currpage 当前页
     * @pagesize 每页显示条数
     */
    public function getpagevote($uniacid, $condition, $currpage, $pagesize) {
        $total = 0;
        $star = ($currpage - 1) * $pagesize;

        $totalsql = "SELECT COUNT(1) FROM ".tablename('qf_vote')." WHERE is_delete = 0 AND uniacid = :uniacid";
        $sql = "SELECT id,title,picture,introduce,start_time,end_time,max_count,single_max_count,ip_max_count FROM ".tablename('qf_vote')." WHERE is_delete = 0 AND  uniacid = :uniacid";
        $paramarr = array(':uniacid' => $uniacid);
        
        //处理查询条件
        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                switch ($key) {
                    case ':title':  //查询活动标题
                        $totalsql = $totalsql . " AND title LIKE :title";
                        $sql = $sql . " AND title LIKE :title";
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

    /**
     * 获得投票活动信息
     */
    public function getvote($id) {
        $sql = "SELECT `id`,`title`,`picture`,`introduce`,`start_time`,`end_time`,`max_count`,`single_max_count`,`ip_max_count`,`join_integral`,`vote_integral`,`is_check`,`add_access_count`,`add_join_count`,`add_vote_count`,`access_count`,`join_count`,`vote_count`,`is_delete`,`uniacid`,`create_time` FROM ".tablename('qf_vote')." WHERE id = :id LIMIT 1";
        $data = pdo_fetch($sql, array(':id' => $id));

        return $data;
    }

    /**
     * 更新访问次数
     */
    public function addaccesscount($id) {
        $sql = "update ".tablename("qf_vote")." set access_count = access_count + 1 where id = :id";
		$result = pdo_query($sql, array(':id' => $id));
    }
    
    /**
     * 更新参与次数
     */
    public function addjoincount($id) {
        $sql = "update ".tablename("qf_vote")." set join_count = join_count + 1 where id = :id";
        $result = pdo_query($sql, array(':id' => $id));
    }
    
    /**
     * 发布投票
     * @data 投票信息
     * return 1 成功 0 失败
     */
    public function addvote($data) {
        //新增活动
        $result = pdo_insert('qf_vote', $data);
        
        if(!empty($result)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * 修改投票
     * @data 投票信息
     */
    public function updatevote($id, $data) {
        pdo_update('qf_vote', $data, array('id' => $id));
    }

    /**
     * 删除投票
     * @data 投票信息
     * return 1 成功 0 失败
     */
    public function deletevote($id) {
        $data = array(
            'is_delete' => 1,
        );

        $result = pdo_update('qf_vote', $data, array('id' => $id));

        if (!empty($result)) {
            return 1;
        }else{
            return 0;
        }
    }
}
