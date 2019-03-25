<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $this->weid;
        $from_user = $this->_fromuser;
        $schoolid = intval($_GPC['schoolid']);
        $openid = $_W['openid'];
		$c_lb = !empty($_GPC['c_lb']) ? $_GPC['c_lb'] : 'children';
		switch ($c_lb){
            case 'adult':
                $cat_id = '155,176,178,179,180,182';
                break;
            default:
                $cat_id = '153';
                break;
        }
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
		
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
        $title = $item['title'];
		$user = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$ite = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $user['id']));	
		$isxz = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $ite['tid']));
		//查询科目设置
	    $km = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = '{$_W['uniacid']}' AND schoolid ={$schoolid} And type = 'subject' ORDER BY ssort DESC", array(':weid' => $_W['uniacid'], ':type' => 'subject', ':schoolid' => $schoolid));
	    $it = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $sid));
        if (empty($item)) {
            message('没有找到该学校，请联系管理员！');
        }
		$icon1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = {$weid} AND schoolid={$schoolid} AND status=1 AND place=1 AND ssort<5 ORDER BY ssort ASC");
		$icon2 = pdo_fetchall("SELECT * FROM " . tablename($this->table_icon) . " where weid = {$weid} AND schoolid={$schoolid} AND status=1 AND place=1 AND ssort>4 ORDER BY ssort ASC");
		$links = $_W['siteroot'] .'app/'.$this->createMobileUrl('detail', array('schoolid' => $schoolid));
		$imgsUrl = $_W['siteroot'].'attachment/images/9/2017/01/logo_5.png';
		//文章系统
		$articles = pdo_fetchall("SELECT * FROM " . tablename($this->table_news) . " where :schoolid = schoolid And :weid = weid And :type = type ORDER BY displayorder DESC LIMIT 0,4", array(
		         ':weid' => $_W['uniacid'],
				 ':schoolid' => $schoolid,
				 ':type' => 'bannerList'
				 ));
		if($articles){
			$list = array();
			foreach($articles as $index =>$article){
				$list[$index]['article'] = $article;
				if($article['lb_id'] >= 0){
					$km = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = '{$_W['uniacid']}' AND schoolid ={$schoolid} And type = 'subject' And parentid = {$article['cat_id']} ORDER BY ssort DESC", array(':weid' => $_W['uniacid'], ':type' => 'subject', ':schoolid' => $schoolid,':parentid' => trim($article['cat_id'])));
					if($km){
						$km_ids = array_column($km,'sid');
						$course = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND is_show = :is_show AND end > :end AND km_id in (".join(',',$km_ids).") ORDER BY ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_show' => 1,':end' => strtotime(date('Y-m-d'))));
						$list[$index]['courses'] = $course;
					}
				}

			}
		}
        $item1 = pdo_fetch("SELECT * FROM " . tablename($this->table_news) . " WHERE id = :id ", array(':id' => $id));		

		$banners = pdo_fetchall("SELECT * FROM " . tablename($this->table_banners) . " WHERE enabled = 1 AND weid = '{$_W['uniacid']}' ORDER BY leixing DESC, displayorder ASC");
		$barr = array();
		foreach ($banners as $key => $banner) {
			if ($banner['leixing'] == 1) {
				$uniarr = explode(',',$banner['arr']);
				$is = $this->uniarr($uniarr,$schoolid);
				if ($is && TIMESTAMP >= $banner['begintime'] && TIMESTAMP < $banner['endtime']) {
					$barr[$banner['leixing'].$key] = $banner;
				}
			}else{
				if ($banner['schoolid'] == $schoolid) {
					$barr[$banner['leixing'].$key] = $banner;
				}
			}
		}
		arsort($barr);
		$list1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_news) . " where :schoolid = schoolid And :weid = weid And :type = type ORDER BY displayorder DESC LIMIT 0,4", array(
			':weid' => $_W['uniacid'],
			':schoolid' => $schoolid,
			':type' => 'article'
		));
		$list2 = pdo_fetchall("SELECT * FROM " . tablename($this->table_news) . " where :schoolid = schoolid And :weid = weid And :type = type ORDER BY displayorder DESC LIMIT 0,4", array(
			':weid' => $_W['uniacid'],
			':schoolid' => $schoolid,
			':type' => 'news'
		));
		$list3 = pdo_fetchall("SELECT * FROM " . tablename($this->table_news) . " where :schoolid = schoolid And :weid = weid And :type = type ORDER BY displayorder DESC LIMIT 0,4", array(
			':weid' => $_W['uniacid'],
			':schoolid' => $schoolid,
			':type' => 'wenzhang'
		));
        $userinfo = unserialize($user['userinfo']);
        $lat = $userinfo['lat'];
        $lng = $userinfo['lng'];
        $earthRadius = '6378.137';
        if(empty($lng)){
            $lng = '121.203018';
        }
        if(empty($lat)){
            $lat = '31.055923';
        }
        if(!empty($lat) && !empty($lng)){
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
        //查询book
        $result = pdo_fetchall(" SELECT  mybook.openid,book.*
 FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where {$schoolid} = mybook.schoolid And {$weid} = mybook.weid  And 1 = mybook.is_delete And 2 = mybook.status And book.cat_id in ({$cat_id})  And mybook.openid in(SELECT A.openid from (SELECT  DISTINCT mybook.openid,round(6378.138*2*asin(sqrt(pow(sin( ({$lat}*pi()/180-mybook.lat*pi()/180)/2),2)+cos({$lat}*pi()/180)*cos(mybook.lat*pi()/180)* pow(sin( ({$lng}*pi()/180-mybook.lng*pi()/180)/2),2)))*1000) as distance
 FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where {$schoolid} = mybook.schoolid And {$weid} = mybook.weid  And 1 = mybook.is_delete And 2 = mybook.status And mybook.openid <> '{$openid}' And book.cat_id in ({$cat_id}) order by distance asc limit 10) A)");
        if($result){
            $books = array();
            $cats  = array();
            $bookCats = array();
            $userCount = array();
            foreach($result as $book){
                $books[$book['price']] = array(
                    'ownerOpenId' => $book['openid'],
                    'book'        => $book
                );
            }
            krsort($books);
            $books = array_slice($books,0,10);
        }
        }
    $this->checkBookAccount($openid,$schoolid,$weid);
include $this->template(''.$item['style1'].'/detail');
?>