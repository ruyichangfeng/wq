<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$schoolid = intval($_GPC['schoolid']);
$openid = $_W['openid'];
//查询是否用户登录
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user   = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
//if(!empty($user)){
    $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
    $book_lb = $book_age =array();
    foreach($category as $key => $value){
        switch($value['type']){
            case 'book_lb':
                $book_lb[$value['sid']] = $value;
                break;
            case 'book_age':
                $book_age[$value['sid']] = $value;
                break;
            default:
                break;
        }
    }
    $book_distance = pdo_fetchall("SELECT * FROM " . tablename($this->table_bookmargin) . " WHERE type='book_distance' ORDER BY amount ASC",array(),'id');
    $userinfo = unserialize($user['userinfo']);
    $lat = $userinfo['lat'];
    $lng = $userinfo['lng'];
    $earthRadius = '6378.137';
    $condition = '';
    if(!empty($_GPC['typeName'])){
        switch($_GPC['typeName']){
            case 'age':
                $age_id = intval($_GPC['typeId']);
                $condition .= " AND book.age_id = '{$age_id}'";
                if($_COOKIE['age_id'] == null){
                    setcookie('age_id',$age_id,time()+30);
                }
                break;
            case 'lb':
                $cat_id = intval($_GPC['typeId']);
                $condition .= " AND book.cat_id  = '{$cat_id}'";
                if($_COOKIE['lb_id'] == null){
                    setcookie('lb_id',$cat_id,time()+30);
                }
                break;
            case 'keyword':
                $name = trim($_GPC['typeId']);
                if($_COOKIE['keyword'] == null){
                    setcookie('keyword',$name,time()+30);
                }
                $condition .= " AND (book.title LIKE '%{$name}%' Or book.author LIKE '%{$name}%') ";
                break;
            case 'distance':
                if($_COOKIE['distance'] == null){
                    setcookie('distance',$_GPC['typeId'],time()+30);
                }
                break;
            default:
                break;
        }
    }
    if($_COOKIE['age_id'] != null && $_GPC['typeName'] != 'age_id'){
        $condition .= " AND book.age_id = '{$_COOKIE['age_id']}'";
    }
    if($_COOKIE['keyword'] != null && $_GPC['typeName'] != 'keyword'){
        $condition .= " AND (book.title LIKE '%{$_COOKIE['keyword']}%' Or book.author LIKE '%{$_COOKIE['keyword']}%') ";
    }
    if($_COOKIE['lb_id'] != null && $_GPC['typeName'] != 'lb_id'){
        $condition .= " AND book.cat_id  = '{$_COOKIE['lb_id']}'";
    }
//    $status = $_GPC['is_accept_exchange'] == 2 ? 1 : 2;
//    $is_accept_exchange = $_GPC['is_accept_exchange'] == 2 ? $_GPC['is_accept_exchange'] : 1;
    //查询book
    $result = pdo_fetchall("SELECT mybook.openid,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :status = mybook.status And mybook.openid <> '{$openid}' $condition", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1,':status' => 2));
    if($result){
        $books = array();
        $cats  = array();
        $bookCats = array();
        $userCount = array();
        foreach($result as $book){
            if(empty($books[$book['openid']])){
                $bookOwner = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $book['openid']), 'id');
                $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $bookOwner['uid'], ':uniacid' => $weid));
                $ownerInfo = unserialize($bookOwner['userinfo']);
                $data['userImg']  = $mcInfo['avatar'];
                $data['nickname'] = $mcInfo['nickname'];
                $data['openid']   = $book['openid'];
                //距离当前距离
                $kmDistance = $this->getDistance($lat,$lng,$ownerInfo['lat'],$ownerInfo['lng']);
                $data['distance'] = $this->mToKm($kmDistance);
                if((!empty($_GPC['typeName']) && $_GPC['typeName'] == 'distance') || !empty($_COOKIE['distance'])){
                    $distance = $book_distance[$_GPC['typeId']] ? $book_distance[$_GPC['typeId']] : $book_distance[$_COOKIE['distance']];
                    $dis = intval($data['distance']);
                    if($distance['classify'] == 1){
                        if($dis > $distance['amount']){
                            continue;
                        }
                    }
                    if($distance['classify'] == 2){
                        if($dis != $distance['amount']){
                            continue;
                        }
                    }
                    if($distance['classify'] == 3){
                        if($dis < $distance['amount']){
                            continue;
                        }
                    }
                    if($distance['classify'] == 4){
                        if($dis < $distance['amount'] || $dis > $distance['maxAmount']){
                            continue;
                        }
                    }
                }
                $books[$book['openid']] = $data;
            }
            if($bookCats[$book['openid']][$book['age_id']]['count'] > 0){
                $bookCats[$book['openid']][$book['age_id']]['count'] += 1;
            }else{
                $bookCats[$book['openid']][$book['age_id']]['count'] = 1;
            }
            if(empty($cats[$book['openid']][$book['age_id']])){
                $cats[$book['openid']][$book['age_id']] = array('age_id' => $book['age_id'],'age_name' => $book_age[$book['age_id']]['sname']);
            }
            if(empty($userCount[$book['openid']][$book['id']])){
                $userCount[$book['openid']][$book['id']] = 1;
            }
            if(!empty($userCount[$book['openid']])){
                    $books[$book['openid']]['bookCount'] = count($userCount[$book['openid']]);
            }else{
                    $books[$book['openid']]['bookCount'] = 0;
            }
        }
        usort($books,function($pre,$nex){
            if ($pre['distance'] == $nex['distance']) {
                return 0;
            }
            return ($pre['distance'] < $nex['distance']) ? -1 : 1;
        });
    }
    $this->checkBookAccount($openid,$schoolid,$weid);
    $links = $_W['siteroot'] .'app/'.$this->createMobileUrl('bookmap',array('schoolid' => $schoolid));
    $imgsUrl = $_W['siteroot'].'attachment/images/9/2017/01/logo_6.png';
    include $this->template('book/bookmap');
//}else{
//    include $this->template('bangding');
//}
?>