<?php 
		$class_dao_zt = D('zt');
        if($op=='display'){
			if($_GPC['status']){
				if($_GPC['status']==2){
                    $params[":status"] = 0;
				}else{
                    $params[":status"] = 1;
				}
			}
            $result = $class_dao_zt->dataList($params);
			$list   = $result['list'];
			$num    = $result['count'];
		}	
		if($op=='edit'){
			$id                 = $_GPC['id'];
		 	$result             = $class_dao_zt->dataEdit($id);
		 	$result_header      = unserialize($result['zt_head_img']);
		 	$imgs               = $result_header['img'];
		 	$urls               = $result_header['url'];
		 	$content_id         = unserialize($result['zt_content_id']);
            if($_GPC['submit']){
                $img_url                    = str_ireplace('，', ',', $_GPC['img_url']);
                $img_url                    = rtrim($img_url,',');
                $img_url                    = explode(',', $img_url);
                $arr['zt_head_img']['img']  = $_GPC['img'];
                $arr['zt_head_img']['url']  = $img_url;
                $in['zt_head_img']          = serialize($arr['zt_head_img']);
                $content_id                 = str_ireplace('，', ',', $_GPC['content_id']);
                $content_id                 = trim($content_id,',');
                $zt_content_id              = explode(',', $content_id);
                $in['zt_content_id']        = serialize($zt_content_id);
                $in['zt_order']             = intval($_GPC['zt_order']);
                $in['zt_img']               = $_GPC['zt_img'];
                $in['zt_name']              = $_GPC['zt_name'];
                $in['status']               = $_GPC['status'];
                $class_dao_zt->dataEdit($id,$in);
                message('修改成功',$this->createWebUrl('zt'),'success');
            }
		}
		if($op=='new'){
		 if($_GPC['submit']){
			$img_url                    = str_ireplace('，', ',', $_GPC['img_url']);
			$img_url                    = rtrim($img_url,',');
			$img_url                    = explode(',', $img_url);
			$arr['zt_head_img']['img']  = $_GPC['img'];
			$arr['zt_head_img']['url']  = $img_url;
			$in['zt_head_img']          = serialize($arr['zt_head_img']);
			$content_id                 = str_ireplace('，', ',', $_GPC['content_id']);
			$content_id                 = trim($content_id,',');
			$zt_content_id              = explode(',', $content_id);
			$in['zt_content_id']        = serialize($zt_content_id);
			$in['zt_order']             = intval($_GPC['zt_order']);
			$in['zt_img']               = $_GPC['zt_img'];
			$in['zt_name']              = $_GPC['zt_name'];
			$class_dao_zt->dataAdd($in);
			message('新增成功',$this->createWebUrl('zt'),'success');		
		 }	
		}
		if($op=='delete'){
            $id = $_GPC['id'];
            if($id){
                $class_dao_zt->delete(array('zt_id'=>$id));
    			message('删除成功',$this->createWebUrl('zt'),'success');		
            }
		}	