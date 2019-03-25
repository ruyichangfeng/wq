<?php 

class WebCommon
{	
	
	
	//共用批量查询订单 在order list ，group info 内
	static function slelectOrder($wherea,$whereb,$str,$page,$num,$order,$by){
		$select = 'a.*,b.pic,b.title,b.idoforder,b.gid,b.buynum,b.rule';
		$info = model_order::getAllOrder($wherea,$whereb,$str,$select,$page,$num,$order.$by,true);
		$list = $info[0];
		$pager = $info[1];
		foreach((array)$list as $k=>$v){
			foreach($v as $kk=>$vv){
				$list[$k][$kk]['userinfo'] = model_user::getSingleUser($vv['openid']);
				break;
			}
		}
		return array($list,$pager);
	}	
	
	//批量发货方法 在order list ，group info 内
	static function batchToSend($_GPC,$from){
		global $_W;
		$successnum = 0;
		$failnum = 0;
		if(empty($_GPC['checkid'])) message('请选择所要发货的订单');
		foreach($_GPC['checkid'] as $k=>$v){
			if($from == 'express'){
				$name = htmlspecialchars($_GPC['batchexpressname'][$v]);
				$number = htmlspecialchars($_GPC['batchexpressnumber'][$v]);
				if(empty($name) || empty($number)) continue;
				$uparray = array('status'=>4,'sendtime'=>time(),'isneedexpress'=>2,'expressname'=>$name,'expressnumber'=>$number);
				
			}elseif($from == 'noexpress'){
				$uparray = array('status'=>4,'sendtime'=>time(),'isneedexpress'=>1);
			}
			$res = model_order::sendGood($v,$uparray,'express');
			if($res['status']) {
				$successnum ++ ;
			}else{
				$failnum ++;
			}
		}
		message('操作完成,成功发货'.$successnum.'项，失败'.$failnum.'项，失败的可能是正在组团中的团购订单',referer(),'success');
	}	
	
	//card列表页面组合url  和 卡券使用记录url  一样的关键字，所以共用一个
	static function structCardUrl($_GPC,$key,$value){
		return self::commonstructUrl($_GPC,$key,$value,array('type','order','by','status'));
	}
	
	//good列表页面组合url 
	static function structGoodUrl($_GPC,$key,$value){
		return self::commonstructUrl($_GPC,$key,$value,array('stock','activity','limit','order','by','status'));
	}	
	//order列表页面组合url
	static function structOrderUrl($_GPC,$key,$value){
		return self::commonstructUrl($_GPC,$key,$value,array('ordertype','firstcut','expresscut','cardcut','creditcut','familycut','order','by','showgood','status','id'));
	}	
	//comment页面
	static function structCommentUrl($_GPC,$key,$value){
		return self::commonstructUrl($_GPC,$key,$value,array('gid','level','order','by','status'));
	}	
	
	//共用组合url方法
	static function commonstructUrl($_GPC,$key,$value,$urlarray){
		global $_W;
			foreach($_GPC as $k=>$v){
				if(in_array($k,$urlarray) && $k != $key){
					$str .= '&'.$k.'='.$v;
				}
			}
			$str .= '&'.$key.'='.$value;
		return $_W['siteroot'].'web/index.php?c=site&a=entry&do='.$_GPC['do'].'&op='.$_GPC['op'].'&m=zofui_groupshop'.$str;
	}
	
	//删除评价数量缓存
	static function deleteCommentCache($id){
		$gid = Util::getSingelDataInSingleTable('zofui_groupshop_comment',array('id'=>$id),' gid ');
		Util::deleteCache('commentnumber',$gid['gid']);
	}
	
	
	//循环删除数据
	static function deleteDataInWeb($arrayid,$tablename){
		global $_W;
		$successnum = 0;
		$failnum = 0;
		if(empty($arrayid)) message('请选择所要删除的内容');
		foreach($arrayid as $k=>$v){
			$res = self::deleteSingleData($v,$tablename);		
			if($res) {
				$successnum ++ ;
			}else{
				$failnum ++;
			}
		}
		return array($successnum,$failnum);
	}
	
	//将商品移入垃圾站
	static function deleteGood($id){
		global $_W;		
		$id = intval($id);
		$res = pdo_update('zofui_groupshop_good',array('isdust'=>1),array('id'=>$id,'uniacid'=>$_W['uniacid']));
		if($res){
			Util::deleteCache('good',$id);
			model_good::editGoodWithEditPage($id,'delete',''); //修改前端模板里的商品				
		}
		return $res;
	}	
	
	//循环删除商品
	static function deleteAllGood($arrayid){
		global $_W;
		$successnum = 0;
		$failnum = 0;
		if(empty($arrayid)) message('请选择所要删除的商品');	
		foreach($arrayid as $k=>$v){
		
			$res = self::deleteGood($v);
			if($res) {
				$successnum ++ ;
			}else{
				$failnum ++;
			}
		}
		return array($successnum,$failnum);
	}		
	
	
	//删除单条数据
	static function deleteSingleData($id,$tablename){
		global $_W;		
		$id = intval($id);
		$res = Util::deleteData($id,$tablename);
		
		if($tablename == 'zofui_groupshop_sort'){
			Util::deleteCache('sort',$id);
			Util::deleteCache('sort','allsort');			
		
		}elseif($tablename == 'zofui_groupshop_card'){
			Util::deleteCache('card',$id);
		
		}elseif($tablename == 'zofui_groupshop_custom'){
			util::deleteCache('custompage',$id);
			util::deleteCache('custompage','index');
			
		}elseif($tablename == 'zofui_groupshop_comment'){
			self::deleteCommentCache($id);
		}
		
		return $res;
	}
	
	//编辑发布商品时插入商品分类
	static function insertGoodSort($sortarray,$id,$type){
		global $_W;	
		if($type == 'edit') pdo_delete('zofui_groupshop_goodsort',array('uniacid'=>$_W['uniacid'],'gid'=>$id),'AND');
		foreach($sortarray as $k=>$v){
			$res = pdo_insert('zofui_groupshop_goodsort',array('uniacid'=>$_W['uniacid'],'gid'=>$id,'sortid'=>$v));
		}
		return $res;
	}	
	
	//批量排序
	static function orderData($orderarray,$tablename){
		global $_W;		
		if(empty($orderarray)) message('没有数据');
		foreach($orderarray as $k=>$v){
			$id = intval($k);
			$order = intval($v);
			$res = pdo_update($tablename, array('order' => $order), array('id' => $id,'uniacid'=>$_W['uniacid']));
			
			if($tablename == 'zofui_groupshop_good'){
				Util::deleteCache('good',$id);
			}
			
			if($tablename == 'zofui_groupshop_sort'){
				Util::deleteCache('sort',$_GPC['id']);
				Util::deleteCache('sort','allsort');
			}
			
		}
		return $res;
	}
	
	
	
	//循环删除订单
	static function deleteAllOrder($arrayid){
		global $_W;
		$successnum = 0;
		$failnum = 0;
		if(empty($arrayid)) message('请选择所要删除的订单');
		foreach($arrayid as $k=>$v){
			$res = self::deleteSingleOrder($v);
			if($res) {
				$successnum ++ ;
			}else{
				$failnum ++;
			}
		}
		return array($successnum,$failnum);
	}	
	
	//删除单条订单
	static function deleteSingleOrder($id){
		global $_W;
		$id = intval($id);
		$orderinfo = Util::getSingelDataInSingleTable('zofui_groupshop_order',array('id'=>$id),' status,userid ');
		if($orderinfo['status'] == 1 || $orderinfo['status'] == 2){
			$res = pdo_delete('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'id'=>$id));
		}
		if($res){
			$res = pdo_delete('zofui_groupshop_ordergood',array('uniacid'=>$_W['uniacid'],'idoforder'=>$id));
			Util::deleteCache('order',$id);
			Util::deleteCache('ordernumber',$orderinfo['userid']);
			return true;
		}
		return false;
	}
	
	
	//单图上传
 	static function tpl_form_field_image($name, $value = '', $default = '', $options = array()) {
		global $_W;
		if (empty($default)) {
			$default = '';
		}
		$val = $default;
		if (!empty($value)) {
			$val = tomedia($value);
			$isshow = '';
		}else{
			$isshow = 'display:none;';
		}
		if (!empty($options['global'])) {
			$options['global'] = true;
		} else {
			$options['global'] = false;
		}
		if (empty($options['class_extra'])) {
			$options['class_extra'] = '';
		}
		if (isset($options['dest_dir']) && !empty($options['dest_dir'])) {
			if (!preg_match('/^\w+([\/]\w+)?$/i', $options['dest_dir'])) {
				exit('图片上传目录错误,只能指定最多两级目录,如: "deobao_store","deobao_store/d1"');
			}
		}
		$options['direct'] = true;
		$options['multiple'] = false;
		if (isset($options['thumb'])) {
			$options['thumb'] = !empty($options['thumb']);
		}
		$s = '';
		if (!defined('TPL_INIT_IMAGE')) {
			$s = '
			<script type="text/javascript">
				function showImageDialog(elm, opts, options) {
					require(["util"], function(util){
						var btn = $(elm);
						var ipt = btn.parent().prev();
						var val = ipt.val();
						var img = ipt.parent().next().children();
						options = '.str_replace('"', '\'', json_encode($options)).';
						util.image(val, function(url){
							if(url.url){
								if(img.length > 0){
									img.get(0).src = url.url;
								}
								ipt.val(url.attachment);
								ipt.attr("filename",url.filename);
								ipt.attr("url",url.url);
								img.parent().show();
							}
							if(url.media_id){
								if(img.length > 0){
									img.get(0).src = "";
								}
								ipt.val(url.media_id);
							}
						}, null, options);
					});
				}
				function deleteImage(elm){
					require(["jquery"], function($){
						$(elm).prev().parent().hide();
						$(elm).parent().prev().find("input").val("");
					});
				}
			</script>';
			define('TPL_INIT_IMAGE', true);
		}

		$s .= '
			<div class="input-group ' . $options['class_extra'] . '">
				<input type="text" name="' . $name . '" value="' . $value . '"' . ($options['extras']['text'] ? $options['extras']['text'] : '') . ' class="form-control" autocomplete="off">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="showImageDialog(this);">选择图片</button>
				</span>
			</div>
			<div class="input-group ' . $options['class_extra'] . '" style="margin-top:.5em;'.$isshow.'">
				<img src="' . $val . '"  this.title=\'图片未找到.\'" class="img-responsive img-thumbnail" ' . ($options['extras']['image'] ? $options['extras']['image'] : '') . ' width="80px" height="80px"/>
				<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
			</div>';
		return $s;
	}	

	
	
}


?>