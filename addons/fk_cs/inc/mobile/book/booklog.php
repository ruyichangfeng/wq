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
$ownerOpenId = $_GPC['ownerOpenId'];//图书拥有者openid
$age_id      = $_GPC['age_id'];//适合年龄id
//查询是否用户登录
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user   = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
$op = $_GPC['op'] ? $_GPC['op'] : 'display';
//if(!empty($user)){
    if($op == 'display'){
        $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
        $book_lb = $book_age = $book_distance =array();
        foreach($category as $key => $value){
            switch($value['type']){
                case 'book_lb':
                    $book_lb[$value['sid']] = $value;
                    break;
                case 'book_age':
                    $book_age[$value['sid']] = $value;
                    break;
                case 'book_distance':
                    $book_distance[$value['sid']] = $value;
                default:
                    break;
            }
        }
        //查询已完成订单
        $borrowOrder = pdo_fetchall("SELECT bookIds from " .tablename($this->table_myorder). "where bookownerid = '{$openid}' ");//and orderStatus = 3
        $transferOrder = pdo_fetchall("SELECT outBookIds from " .tablename($this->table_mytransferorder). "where openid = '{$openid}' ");//and orderStatus = 5
        $bIds = array();
        if(!empty($borrowOrder)){
            $bIds = array_column($borrowOrder,'bookIds');
        }
        $tIds = array();
        if(!empty($transferOrder)){
            $tIds = array_column($transferOrder,'outBookIds');
        }
        $bookIds = array_unique(array_merge($bIds,$tIds));
        $ids = array();
        foreach($bookIds as $id){
            if(!empty($id)){
                $ids[] = $id;
            }
        }
        $books = array();
        if(!empty($bookIds)){
            $books = pdo_fetchall("select * from ".tablename($this->table_book). "where id in (".trim(join(',',$ids),',').")");
        }
        //获取简记id
        $jianji = pdo_fetch("select * from ".tablename('junsion_simpledaily_member')." where openid = '{$ownerOpenId}'");
        $jian_url = './index.php?i='.$weid.'&c=entry&mid='.$jianji['id'].'&do=MyWorks&m=junsion_simpledaily';
        include $this->template('book/booklog');
    }elseif($op == 'comment'){
        //添加评论
        if(!empty($_GPC['bookid'])){
            $data = array(
                'bookid' => $_GPC['bookid'],
                'openid' => $openid,
                'remark' => $_GPC['remark']
            );
            pdo_insert($this->table_bookcomment,$data);
            die(json_encode(array(
                'result' => true,
                'msg'  => 'ok'
            )));
        }
    }
//}else{
//    include $this->template('bangding');
//}
?>