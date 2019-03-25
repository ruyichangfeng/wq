<?php 
	global $_W,$_GPC;
	$op = empty($_GPC['op'])?'list':$_GPC['op'];
	$_GPC['do'] = empty($_GPC['do'])?'comment':$_GPC['do'];
	
	//批量删除
	if(checksubmit('delete')){
		$res = WebCommon::deleteDataInWeb($_GPC['checkid'],'zofui_groupshop_comment');
		message('操作完成,成功删除'.$res[0].'项，失败'.$res[1].'项',referer(),'success');
	}
	
	//批量显示
	if(checksubmit('upcomment')){
		if(empty($_GPC['checkid'])) message('先选择要处理的评价');
		dealAll(0,$_GPC['checkid']);
	}
	//批量隐藏
	if(checksubmit('downcomment')){
		if(empty($_GPC['checkid'])) message('先选择要处理的评价');
		dealAll(1,$_GPC['checkid']);
	}
	
	
	if(checksubmit('confirm_addcomment')){
		$data['uniacid'] = $_W['uniacid'];
		$data['gid'] = intval($_GPC['commentgoodid']);
		$data['text'] = htmlspecialchars($_GPC['text']);
		$data['status'] = intval($_GPC['status']);
		$data['level'] = intval($_GPC['level']);
		$data['pic'] = iserializer($_GPC['pic']);
		$data['headimg'] = htmlspecialchars($_GPC['headimg']);
		$data['nickname'] = htmlspecialchars($_GPC['nickname']);
		$data['commenttime'] = strtotime($_GPC['commenttime']);
		
		if($op == 'add'){
			$res = pdo_insert('zofui_groupshop_comment',$data);
			
		}elseif($op == 'edit'){
			$id = intval($_GPC['id']);		
			$res = pdo_update('zofui_groupshop_comment',$data,array('uniacid'=>$_W['uniacid'],'id'=>$id));
		}
		Util::deleteCache('commentnumber',$data['gid']);
		if($res) message('操作成功',referer(),'success'); message('操作失败',referer(),'error');
	}
	
	
	if($op == 'edit' || $op == 'add'){
	
		if(!empty($_GPC['gid'])){
			$good = Util::getSingelDataInSingleTable('zofui_groupshop_good',array('uniacid'=>$_W['uniacid'],'id'=>intval($_GPC['gid'])),' id,title,pic ');
			$good['pic'] = iunserializer($good['pic']);
		}
		if(!empty($_GPC['id'])){
			$comment = Util::getSingelDataInSingleTable('zofui_groupshop_comment',array('uniacid'=>$_W['uniacid'],'id'=>intval($_GPC['id'])),' * ');
			$comment['pic'] = iunserializer($comment['pic']);
		}
		
	}	
	
	
	
	if($op == 'list'){
		
		$order = ' a.`id` ';
		$by = ' DESC ';
		$where['uniacid'] = $_W['uniacid'];
		if(!empty($_GPC['gid'])) $where['gid'] = intval($_GPC['gid']);
		
		$select = ' a.*,b.title,b.pic ';
		
		if(!empty($_GPC['by'])) $by = ' ASC ';
		if(!empty($_GPC['level']))  $where['level'] = intval($_GPC['level']);
		if($_GPC['order'] == 'gid') $order = ' a.`gid` ';
		
		$comment = model_comment::getAllComment($where,intval($_GPC['page']),10,$order.$by,true,$select);
		$list = $comment[0];
		foreach($list as $k=>$v){
			$list[$k]['cpic'] = iunserializer($v['cpic']);
		}
		$pager = $comment[1];
	}
	

	if($op == 'delete'){
		$res = WebCommon::deleteSingleData($_GPC['id'],'zofui_groupshop_comment');
		if($res) message('删除成功',referer(),'success');
	}
	
	//隐藏评论
	if($op == 'downcomment'){
		$res = hideAndShowComment($_GPC['id'],1);
		if($res) message('操作成功',referer(),'success');
	}
	//显示评论
	if($op == 'upcomment'){
		$res = hideAndShowComment($_GPC['id'],0);
		if($res) message('操作成功',referer(),'success');
	}	
	
	//隐藏于显示单个
	function hideAndShowComment($id,$status){
		global $_W;
		$id = intval($id);
		$status = intval($status);
		WebCommon::deleteCommentCache($id);
		return pdo_update('zofui_groupshop_comment',array('status'=>$status),array('uniacid'=>$_W['uniacid'],'id'=>$id));
	}
	
	//批量处理
	function dealAll($status,$arrayid){
		$successnum = 0;
		$failnum = 0;	
		foreach($arrayid as $k=>$v){
			$res = hideAndShowComment($v,$status);
			if($res) {
				WebCommon::deleteCommentCache($v);
				$successnum ++ ;
			}else{
				$failnum ++;
			}
		}
		message('操作完成,成功'.$successnum.'项，失败'.$failnum.'项',referer(),'success');
	}	
	
	include $this->template('web/comment');