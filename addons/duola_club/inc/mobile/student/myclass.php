<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid']; 
		$openid = $_W['openid'];
		$schoolid = intval($_GPC['schoolid']);
		$bj_id = intval($_GPC['bj_id']);
		$xq_id = intval($_GPC['xq_id']);
        
		//教师列表按教师入职时间先后顺序排列，先入职再前

		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));	

        $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND bj_id = :bj_id ORDER BY end DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':bj_id' => $bj_id));
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE schoolid = :schoolid ", array(':schoolid' => $schoolid));
        $school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
        $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid =:schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'sid');
        $parents = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where weid = :weid AND schoolid = :schoolid And openid=:openid And userType=:userType", array(':weid' => $weid, ':schoolid' => $schoolid,':openid' => $openid,':userType'=> 'parents'));
        if(!empty($parents['area_addr_location'])){
            $parents['area_addr_location'] = json_decode($parents['area_addr_location'],true);
        }
        if(!empty($it)){
            if (!empty($category)) {
                $children = '';
                foreach ($category as $cid => $cate) {
                    if (!empty($cate['parentid'])) {
                        $children[$cate['parentid']][$cate['id']] = array($cate['id'], $cate['name']);
                    }
                }
            }
            $teachers = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE weid = :weid AND schoolid =:schoolid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
            if (!empty($teachers)) {
                $child = '';
                foreach ($teachers as $pid => $pcate) {
                    if (!empty($pcate['parentid'])) {
                        $child[$pcate['parentid']][$pcate['id']] = array($pcate['id'], $pcate['name']);
                    }
                }
            }
            $kecheng = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
            $list1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " where :schoolid = schoolid And :weid = weid And :sid = sid And :type = type And :status = status ORDER BY createtime DESC", array(
                ':weid' => $weid,
                ':schoolid' => $schoolid,
                ':sid' => $it['sid'],
                ':status' => 2,
                ':type' => 1
            ));
            //type 代表3种类型  1 付费课  2不付费课程  3为缴费项目（不限制是课程列表，显示在订单中心或计划中的费用中心）
            $list2 = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " where :schoolid = schoolid And :weid = weid And :sid = sid And :type = type ORDER BY createtime DESC", array(
                ':weid' => $weid,
                ':schoolid' => $schoolid,
                ':sid' => $it['sid'],
                ':type' => 2
            ));
            $item1 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id ", array(':id' => $id));
            $item2 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id ", array(':id' => $id));

            include $this->template(''.$school['style2'].'/myclass');
        }else{
            include $this->template(''.$school['style2'].'/addchild');
        }

?>