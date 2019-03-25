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
$op     = $_GPC['op'] ? $_GPC['op'] : '';
$userinfo = unserialize($user['userinfo']);
if(!empty($user)){
    $item = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $user['uid'], ':uniacid' => $weid));
    $isbn = $_GPC['isbn'];
//    $isbn = 'EAN_13,9787550015432';
    if(empty($isbn)){
        die(
            json_encode(array(
                'result' => false,
                'msg'    => '条形码有误!'
            ))
        );
    }

    if($isbn){
        //查询数据库
        $data = explode(',',$isbn);
        if($data[0] == 'EAN_13'){
            $book = pdo_fetch("SELECT * FROM " . tablename($this->table_book) . " WHERE  :isbn13 = isbn13 ", array(':isbn13' => $data[1]));
        }else{
            $book = pdo_fetch("SELECT * FROM " . tablename($this->table_book) . " WHERE  :isbn10 = isbn10 ", array(':isbn10' => $data[1]));
        }
        if(empty($book)){
        //查询第三方接口
        $apiUrl =  'http://feedback.api.juhe.cn/ISBN?key=59204c5e3bff16f6fcf7a29fb59a7033&sub='.$data[1];
        $ch = curl_init();
        $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.2) Gecko/2008070208 Firefox/3.0.1';
        curl_setopt_array($ch,array(
            CURLOPT_URL            => $apiUrl,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_USERAGENT      => $userAgent,
            CURLOPT_RETURNTRANSFER => 1
        ));
        $data = curl_exec($ch);
        curl_close($ch);
        $bookinfo = json_decode($data,true);
        if($bookinfo['error_code'] == 0){
             $book = $bookinfo['result'];
            //将数据存入数据库
            $insertData = array(
                'title' => $book['title'],
                'levelNum' => $book['levelNum'],
                'subtitle' => $book['subtitle'],
                'author' => $book['author'],
                'pubdate' => $book['pubdate'],
                'origin_title' => $book['origin_title'],
                'binding' => $book['binding'],
                'pages' => $book['pages'],
                'images_medium' => $book['images_medium'],
                'images_large' => $book['images_large'],
                'publisher' => $book['publisher'],
                'isbn10' => $book['isbn10'],
                'isbn13' => $book['isbn13'],
                'summary' => $book['summary'],
                'price' => $book['price'],
            );
            pdo_insert($this->table_book,$insertData);
            $bookid = pdo_insertid();
            $book['id'] = $bookid;
        }else{
//            message('未扫描到图书信息,不能上架!');
            $isScan = 2;
        }
        }else{
            //查询是否已经扫码上架过
            $bookCount = pdo_fetch("select count(*) as bookCount from ".tablename($this->table_mybook)." where openid = :openid and bookid = :bookid  and is_delete = :is_delete ",array(':openid' => $openid,':bookid' => $book['id'],':is_delete' => 1));
            if($bookCount['bookCount'] > 0){
                message('不能重复上架!');
            }
        }
    }

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
                break;
            default:
                break;
        }
    }
    load()->func('communication');
    load()->classs('weixin.account');
    load()->func('file');
    $accObj= WeixinAccount::create($_W['account']['acid']);
    $access_token = $accObj->fetch_token();
    $token2 =  $access_token;

    if($op == 'add'){
        if (! $_GPC ['schoolid'] || ! $_GPC ['weid'] || ! $_GPC ['openid']) {
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        //获取图片
        $coverImgUrl = $_GPC ['coverImg'];
        if(!empty($coverImgUrl)) {
            $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$coverImgUrl;
            $pic_data = ihttp_request($url);
            $path = "images/";
            $coverImg = $path.random(30) .".jpg";
            file_write($coverImg,$pic_data['content']);
            if (!empty($_W['setting']['remote']['type'])) { //
                $remotestatus = file_remote_upload($coverImg); //
                if (is_error($remotestatus)) {
                    message('远程附件上传失败，请检查配置并重新上传');
                }
            }
        }

        $backImgUrl = $_GPC ['backImg'];
        if(!empty($backImgUrl)) {
            $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$backImgUrl;
            $pic_data = ihttp_request($url);
            $path = "images/";
            $backImg = $path.random(30) .".jpg";
            file_write($backImg,$pic_data['content']);
            if (!empty($_W['setting']['remote']['type'])) { //
                $remotestatus = file_remote_upload($backImg); //
                if (is_error($remotestatus)) {
                    message('远程附件上传失败，请检查配置并重新上传');
                }
            }
        }

        if(!empty($_GPC['isScan']) && $_GPC['isScan'] == 2 && empty($_GPC['id'])){
            $data = explode(',',$isbn);
            if($data[0] == 'EAN_13'){
                $isbn13 = $data[1];
            }else{
                $isbn10 = $data[1];
            }
            $insertData = array(
                'title' => $_GPC['title'],
                'author' => $_GPC['author'],
                'images_medium' => tomedia($coverImg),
                'images_large' => tomedia($coverImg),
                'isbn10' => $isbn10,
                'isbn13' => $isbn13,
                'price' => $_GPC['price'],
                'isScan' => $_GPC['isScan'],
                'cat_id' => $_GPC['cat_id'],
                'age_id' => $_GPC['age_id']
            );
            pdo_insert($this->table_book,$insertData);
            $bookid = pdo_insertid();
            $mybookData = array(
                'weid' => $weid,
                'schoolid' => $schoolid,
                'openid' => $openid,
                'bookid' => $bookid,
                'status' => 1,
                'coverImg' => $coverImg,
                'backImg' => $backImg,
                'lat' => $userinfo['lat'],
                'lng' => $userinfo['lng']
            );
        }else{
            if(!$_GPC ['id']){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！'
                ) ) );
            }
            //更新book
            $updateData = array(
                'cat_id' => $_GPC['cat_id'],
                'age_id' => $_GPC['age_id']
            );
            pdo_update($this->table_book,$updateData,array('id' => $_GPC['id']));
            $mybookData = array(
                'weid' => $weid,
                'schoolid' => $schoolid,
                'openid' => $openid,
                'bookid' => $_GPC['id'],
                'status' => 1,
                'coverImg' => $cover['img_url'],
                'backImg' => $back['img_url'],
                'lat' => $userinfo['lat'],
                'lng' => $userinfo['lng']
            );
        }
        pdo_insert($this->table_mybook,$mybookData);
        die(
            json_encode(array(
                'result' => true,
                'msg'    => '上架成功!'
            ))
        );
    }elseif($op == 'uploadImg'){
//        load()->func('communication');
//        load()->classs('weixin.account');
//        load()->func('file');
//        $accObj= WeixinAccount::create($_W['account']['acid']);
//        $access_token = $accObj->fetch_token();
//        $token2 =  $access_token;
        $photoUrl = $_GPC ['bigImage'];
        if(!empty($photoUrl)) {
            $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$token2.'&media_id='.$photoUrl;
            $pic_data = ihttp_request($url);
            $path = "images/";
            $picurl = $path.random(30) .".jpg";
            file_write($picurl,$pic_data['content']);
            if (!empty($_W['setting']['remote']['type'])) { //
                $remotestatus = file_remote_upload($picurl); //
                if (is_error($remotestatus)) {
                    message('远程附件上传失败，请检查配置并重新上传');
                }
            }
        }
        pdo_insert($this->table_booktempimg,array('openid' => $_GPC['openid'],'img_url' => $picurl,'type' => $_GPC['type']));
        //更新book类别
        $updateData = array(
            'cat_id' => $_GPC['cat_id'],
            'age_id' => $_GPC['age_id']
        );
        pdo_update($this->table_book,$updateData,array('id' => $_GPC['id']));

        die(json_encode(array(
            'result' => true,
            'msg'    => '上传成功!',
            'picUrl' => $picurl
        )));
    }elseif($isScan == 2){
        include $this->template('book/addbook2');
    }else{
        include $this->template('book/addbook');
    }
}else{
    include $this->template('bangding');
}
?>