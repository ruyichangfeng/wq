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
        
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));	
		
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
								
            //取本登录老师的群发消息（校长不取）
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = '';
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'article') {
			$condition .= " AND type = 'article'";
		}elseif ($operation == 'news') {
			$condition .= " AND type = 'news'";
		}elseif ($operation == 'wenzhang') {
			$condition .= " AND type = 'wenzhang'";
		}	
		$list = pdo_fetchall("SELECT * FROM ".tablename($this->table_news)." WHERE weid = '{$_W['uniacid']}' And schoolid = '{$schoolid}' $condition ORDER BY displayorder DESC, id DESC");
			//$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_news) . " WHERE weid = '{$_W['uniacid']}' And schoolid = '{$schoolid}' And type = 'article'");
			//$pager = pagination($total, $pindex, $psize);
				 						
		 include $this->template(''.$school['style1'].'/newslist');        
?>