<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid'];
        $from_user = $_W['openid'];
		$openid = $_W['openid'];
		$schoolid = intval($_GPC['schoolid']);
        $school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
        $userType = $_GPC['userType'] ? $_GPC['userType'] : 'parents';
        $typeName = '家长';
        switch ($userType){
            case 'teacher':
                $typeName = '教师注册';
                break;
            case 'bookUser':
                $typeName = '闲书用户信息完善';
                break;
            case 'parents':
            default:
                $typeName = '家长注册';
                break;
        }
        //获取当前用户注册信息
        $user   = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
        if(!empty($user)){
            $userData = array();
            if($user['pid'] > 0){
                if($userType == 'parents'){
                    $p = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where weid = :weid AND openid=:openid AND schoolid=:schoolid AND :userType = userType", array(':weid' => $weid, ':openid' => $openid, ':schoolid' => $schoolid,':userType' => 'bookUser'));
                }else{
                    $p = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where weid = :weid AND openid=:openid AND schoolid=:schoolid AND :userType = userType", array(':weid' => $weid, ':openid' => $openid, ':schoolid' => $schoolid,':userType' => 'parents'));
                }
                $location = json_decode($p['area_addr_location'],true);
                $userData['name'] = $p['name'];
                $userData['mobile'] = $p['mobile'];
                $userData['area_addr'] = $p['area_addr'];
                $userData['lng'] = $location['lng'];
                $userData['lat'] = $location['lat'];
            }elseif ($user['tid'] > 0){
                $t = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $user['tid']));
                $location = json_decode($t['area_addr_location'],true);
                $userData['name'] = $t['tname'];
                $userData['mobile'] = $t['mobile'];
                $userData['area_addr'] = $t['area_addr'];
                $userData['lng'] = $location['lng'];
                $userData['lat'] = $location['lat'];
                $userData['sex'] = $t['sex'];
            }

        }
        include $this->template('bangding');
?>