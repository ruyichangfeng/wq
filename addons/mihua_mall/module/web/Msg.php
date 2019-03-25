<?php 
        $class_dao_msg = D('msg');
		if($op=='display'){
			if($_GPC['status']){
				if($_GPC['status']==2){
                    $params[":status"] = 0;
				}else{
                    $params[":status"] = 1;
				}
			}
            $result = $class_dao_msg->dataList($params);
            $list   = $result['list'];
            $num    = $result['count']; 
		}	
		if($op=='edit'){
			$id         = intval($_GPC['id']);
		 	$result     = $class_dao_msg->dataEdit($id);
            if($_GPC['submit']){
                $in  = getNewUpdateData($_GPC,$class_dao_msg);
		 	    $class_dao_msg->dataEdit($id,$in);
                message('修改成功',$this->createWebUrl('msg'),'success');
            }
		}
		if($op=='new'){
            if($_GPC['submit']){
                $in  = getNewUpdateData($_GPC,$class_dao_msg);
                $class_dao_msg->dataAdd($in);
                message('新增成功',$this->createWebUrl('msg'),'success');		
            }	
		}
		if($op=='delete'){
			$id = intval($_GPC['id']);
            if($id){
                $class_dao_msg->delete(array($class_dao_msg->msg_id=>$id));
    			message('删除成功',$this->createWebUrl('msg'),'success');		
            }
		}