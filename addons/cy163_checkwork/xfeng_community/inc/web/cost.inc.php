<?php
/**
 * 微小区模块
 *
 * [晓锋] Copyright (c) 2013 qfinfo.cn
 */
/**
 * 后台小区物业费
 */

global $_GPC,$_W;
$do = $_GPC['do'];
$method = 'fun';
$GLOBALS['frames'] = $this->NavMenu($do,$method);
$xqmenu = $this->xqmenu();
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
$id = intval($_GPC['id']);
$user = $this->user();
$regions = $this->regions();
if ($op == 'list') {
    $pindex = max(1, intval($_GPC['page']));
    $psize  =20;
    $condition = '';
    if ($user[type] == 3) {
        //小区管理员
        $condition .=" and r.id in({$user['regionid']})";
    }else{
        if($_GPC['regionid']){
            $condition .= " and regionid =:regionid";
            $params[':regionid'] = $_GPC['regionid'];
        }
    }
    $list = pdo_fetchall("SELECT c.* , r.title as title,r.city,r.dist  FROM".tablename('xcommunity_cost')."as c left join".tablename('xcommunity_region')."as r on c.regionid = r.id WHERE c.weid='{$_W['weid']}' $condition order by c.createtime desc LIMIT ".($pindex - 1) * $psize.','.$psize,$params);
    $total  = pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_cost')."as c left join".tablename('xcommunity_region')."as r on c.regionid = r.id WHERE c.weid='{$_W['weid']}' $condition order by c.createtime desc",$params);
    $pager  = pagination($total, $pindex, $psize);
    // AJAX是否显示
    if($_W['isajax'] && $id ){
        $data = array();
        $data['enable'] = intval($_GPC['enable']);
        if(pdo_update('xcommunity_cost', $data, array('id' => $_GPC['id'])) !== false) {
            exit('success');
        }

    }
    load()->func('file');
    include $this->template('web/cost/list');
}elseif ($op == 'add') {
    //判断是否是操作员

    $regions = $this->regions();

    if ($_W['isajax']) {

        $costtime = $_GPC['costtime'];
        if (!empty($_FILES['uploadExcel']['name'])) {
//			$tmp_file   = $_FILES['uploadExcel']['tmp_name'];
//			$file_types = explode(".",$_FILES['uploadExcel']['name']);
//			$file_type  = $file_types[count($file_types)-1];
//			/*判别是不是.xls文件，判别是不是excel文件*/
//			if (strtolower ( $file_type ) !="xls" && strtolower ( $file_type ) !="xlsx")
//			{
//				message('类型不正确，请重新上传',referer(),'error');
//			}
//		  /*设置上传路径*/
//		   $savePath = IA_ROOT.'/addons/xfeng_community/template/upFile/';
//		  /*以时间来命名上传的文件*/
//		   $str = date('Ymdhis');
//		   $file_name = $str.".".$file_type;
//		   /*是否上传成功*/
//		   if (!copy($tmp_file,$savePath.$file_name)) {
//		   		message('上传失败');
//
//		   }

            $regionid = intval($_GPC['regionid']);
            $insert['costtime']    = $costtime;
            $insert['regionid'] = $regionid;
//		  $res = $this->read($savePath.$file_name);
//		  print_r($res);exit();
            $result = pdo_fetch("SELECT * FROM".tablename('xcommunity_cost')."WHERE costtime='{$insert['costtime']}' AND weid='{$_W['weid']}' AND regionid=:regionid",array(':regionid' => $insert['regionid']));
//	  	  if ($result) {
//	  	  	message('该时间中已存在数据',referer(),'success');exit();
//	  	  }
            if(!$result){
                $insert['weid']		= $_W['weid'];
                $insert['createtime'] = TIMESTAMP;
                $insert['enable'] = 1;
                //print_r($res);exit();
                pdo_insert('xcommunity_cost',$insert);
                $cid = pdo_insertid();
            }else{
                $cid = $result['id'];
            }


            $category = pdo_fetch("SELECT name FROM".tablename('xcommunity_category')."WHERE regionid=:regionid",array(':regionid' => $regionid));
            $c = explode('|', $category['name']);

            $count = count($c);
            $res = import('uploadExcel');
//          print_r($res);exit();
            foreach ( $res as $k => $v ) {
                $leng = 7+count($c);

                $r = '';
                for ($i=5; $i < $count+5; $i++) {
                    //判断变量类型是否为浮点数类型
                    $vi = sprintf("%.2f", $v[$i]) ? sprintf("%.2f", $v[$i]) : '0.00';
                    $r .= $vi.'|';
                }
                $data['username']    = $v[0];
                $data['mobile']      = $v[1];
                $data['homenumber']  = $v[2];
                $data['area']    = sprintf("%.2f", $v[3]);
                $data['costtime'] = $v[4];
                $data['fee'] = $r;
                $data['total']       = sprintf("%.2f",$v[$leng-2]);
                $data['status']      = $v[$leng-1];
                $data['weid']        = $_W['weid'];
                $data['cid']         = $cid;
                $data['regionid']    = $regionid;
                $data['createtime']  = TIMESTAMP;
                if($data['username'] && $data['homenumber'] && $data['total'] ){
                    $result              = pdo_insert('xcommunity_cost_list',$data);
                }

            }

//          if($result){
//                message('导入成功',referer(),'success');
//          }
        }
        echo json_encode(array('result' => 1,'content' => '导入完成！'));exit();
    }

    include $this->template('web/cost/add');
}elseif ($op == 'delete') {
    if (empty($id)) {
        message('缺少参数',referer(),'error');
    }
    $res       = pdo_delete('xcommunity_cost_list',array('cid' => $id));
    $result    = pdo_delete('xcommunity_cost',array('id' => $id,'weid' => $_W['weid']));


    message('删除成功',referer(),'success');

}elseif($op == 'detail'){
    if (empty($id)) {
        message('缺少参数',referer(),'error');
    }
    if(checksubmit('update')){
        $status = $_GPC['status'];
        if (empty($data)) {
            $status = '否';
        }
        $status = ($status=='是'?'否':'是');
        $data= array(
            'status' => $status,
            'remark' => $_GPC['remark']
        );
        $costid = intval($_GPC['costid']);
        $r = pdo_update("xcommunity_cost_list", $data, array("id" => $costid, "weid" => $_W['uniacid']));
        if($r){
            message('提交成功',referer(),'success');
        }
//        die(json_encode(array("result" => 1, "data" => $data)));
    }
    $condition = '' ;
    if($_GPC['mobile']){
        $condition .= "AND mobile='{$_GPC['mobile']}'";
    }
    if($_GPC['username']){
        $condition .= " AND username='{$_GPC['username']}'";
    }
    if($_GPC['homenumber']){
        $condition .= " AND homenumber='{$_GPC['homenumber']}'";
    }
    if ($_GPC['status']) {
        $condition .= " AND status='{$_GPC['status']}'";
    }
    //物业费微信通知提醒
    if (checksubmit('export')) {
        $list   = pdo_fetchall("SELECT * FROM".tablename('xcommunity_cost_list')."where weid=:weid AND cid =:id and regionid =:regionid $condition ",array(':weid' => $_W['uniacid'],':id' => $id,':regionid' => $_GPC['regionid']));
        foreach ($list as $k => $val){
            $member = pdo_fetch("SELECT * FROM".tablename('xcommunity_member')."WHERE address='{$val['homenumber']}' and regionid='{$_GPC['regionid']}'");
            $region = $this->region($member['regionid']);
            $openid = $member['openid'];
            $url = $_W['siteroot']."app/index.php?i={$_W['uniacid']}&c=entry&op=detail&do=cost&id={$val['id']}&m=xfeng_community";
            $tpl = pdo_fetch("SELECT * FROM".tablename('xcommunity_wechat_tplid')."WHERE uniacid=:uniacid",array(':uniacid' => $_W['uniacid']));
            $template_id = trim($tpl['property_tplid']);
            $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
            $content = array(
                'first' => array(
                    'value' => '您好，您本月物业费已出。',
                ),
                'userName' => array(
                    'value' => $member['realname'],
                ),
                'address' => array(
                    'value' => $region['title'].$member['address'],
                ),
                'pay'    => array(
                    'value' => $val['total'].'元',
                ),
                'remark'    => array(
                    'value' => '请尽快缴纳，如有疑问，请咨询.',
                ),
            );
            $result = $this->sendtpl($openid,$url,$template_id,$content);
        }
        message('发送成功！',referer(), 'success');
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize  = 10;
    $list   = pdo_fetchall("SELECT * FROM".tablename('xcommunity_cost_list')."where weid=:weid AND cid =:id $condition LIMIT ".($pindex - 1) * $psize.','.$psize,array(':weid' => $_W['uniacid'],':id' => $id));
    $total  = pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_cost_list')."WHERE weid=:weid AND cid =:id $condition",array(':weid' => $_W['uniacid'],':id' => $id));
    $pager  = pagination($total, $pindex, $psize);
    // $regionid = intval($_GPC['regionid']);
    // if ($regionid) {
    // 	$region = $this->region($regionid);
    // }
    //物业费短信通知提醒
    if(checksubmit('sms')){
        $cids=$_GPC['cid'];
        // print_r($cids);exit();
        if(!empty($cids)){
            foreach ($cids as $cid) {
                if(!empty($cid)){
                    $cost = pdo_fetch("SELECT * FROM".tablename('xcommunity_cost_list')."WHERE id='{$cid}' and regionid='{$_GPC['regionid']}'");
                    $members = pdo_fetchall("SELECT * FROM".tablename('xcommunity_member')."WHERE address='{$cost['homenumber']}' AND weid=:weid and regionid='{$_GPC['regionid']}'",array(':weid'=> $_W['uniacid']));

                    $price 		= $cost['total'];
                    foreach($members as $key => $member){
                        $region = $this->region($member['regionid']);
                        $phone = $region['linkway'];
                        $key = 'sms';
                        $set = ln_syssetting_read('',$key);
                        if($set['tysms']){
                            if($set['cost']){
                                if($set['api'] == 1){
                                    //微网通
                                    $sms = ln_syssetting_read('','smswwt');
                                    $sdst = $member['mobile'];
                                    $smsg = "您好,您本月物业费已出。物业费金额".$price ."。请尽快缴纳，如有疑问，请咨询。".$phone;
                                    $sname = $sms['account'];
                                    $spwd = $sms['pwd'];
                                    $sign = $sms['sign'];
                                    $scorpid ='';
                                    $sprdid ='1012888';
                                    $smsg = $smsg.'【'.$sign.'】';
                                    $params = 'sname='.$sname."&spwd=".$spwd."&scorpid=".$scorpid."&sprdid=".$sprdid."&sdst=".$sdst."&smsg=".rawurlencode($smsg);
                                    $url = 'http://cf.51welink.com/submitdata/Service.asmx/g_Submit';
                                    load()->func('communication');
                                    $content   = ihttp_post($url,$params);
                                }elseif($set['api'] == 2){
                                    //聚合
                                    $sms = ln_syssetting_read('','smsjh');
                                    $mobile    = $cost['mobile'];
                                    $tpl_id    = $sms['property_id'];
                                    $tpl_value = urlencode("#price#=$price&#phone#=$phone");
                                    $appkey    = $sms['sms_account'];
                                    $params    = "mobile=".$mobile."&tpl_id=".$tpl_id."&tpl_value=".$tpl_value."&key=".$appkey;
                                    $url       = 'http://v.juhe.cn/sms/send';
                                    load()->func('communication');
                                    $content   = ihttp_post($url,$params);
                                    return $content;
                                }
                            }
                        }else{
                            $xqset = ln_syssetting_read(intval($_GPC['regionid']),'xqsms');
                            if($xqset['cost']){
                                if($xqset['api'] == 1){
                                    //微网通
                                    $sdst = $member['mobile'];
                                    $smsg = "您好,您本月物业费已出。物业费金额".$price ."。请尽快缴纳，如有疑问，请咨询。".$phone;
                                    $sname = $xqset['account'];
                                    $spwd = $xqset['pwd'];
                                    $sign = $xqset['sign'];
                                    $scorpid ='';
                                    $sprdid ='1012888';
                                    $smsg = $smsg.'【'.$sign.'】';
                                    $params = 'sname='.$sname."&spwd=".$spwd."&scorpid=".$scorpid."&sprdid=".$sprdid."&sdst=".$sdst."&smsg=".rawurlencode($smsg);
                                    $url = 'http://cf.51welink.com/submitdata/Service.asmx/g_Submit';
                                    load()->func('communication');
                                    $content   = ihttp_post($url,$params);
                                }elseif($set['api'] == 2){
                                    //聚合
                                    $mobile    = $cost['mobile'];
                                    $tpl_id    = $xqset['property_id'];
                                    $tpl_value = urlencode("#price#=$price&#phone#=$phone");
                                    $appkey    = $xqset['sms_account'];
                                    $params    = "mobile=".$mobile."&tpl_id=".$tpl_id."&tpl_value=".$tpl_value."&key=".$appkey;
                                    $url       = 'http://v.juhe.cn/sms/send';
                                    load()->func('communication');
                                    $content   = ihttp_post($url,$params);
                                    return $content;
                                }
                            }
                        }



                    }

                }

            }
            message('发送成功！',referer(), 'success');
        }else{
            message('请选择要发送的用户！');
        }
    }
    //物业费微信通知提醒
    if (checksubmit('wechat')) {
        $cids=$_GPC['cid'];
        if (!empty($cids)) {
            foreach ($cids as $cid) {
                $cost = pdo_fetch("SELECT * FROM".tablename('xcommunity_cost_list')."WHERE id='{$cid}' and regionid='{$_GPC['regionid']}'");
                $members = pdo_fetchall("SELECT * FROM".tablename('xcommunity_member')."WHERE address='{$cost['homenumber']}' and regionid='{$_GPC['regionid']}'");
//				print_r($cost);
//				print_r($members);
//				exit();
                foreach($members as $member => $item){
                    $region = $this->region($item['regionid']);
                    $openid = $item['openid'];
                    $url = $_W['siteroot']."app/index.php?i={$_W['uniacid']}&c=entry&op=detail&do=cost&id={$cid}&m=xfeng_community";
                    $tpl = pdo_fetch("SELECT * FROM".tablename('xcommunity_wechat_tplid')."WHERE uniacid=:uniacid",array(':uniacid' => $_W['uniacid']));
                    $template_id = trim($tpl['property_tplid']);
                    $createtime = date('Y-m-d H:i:s', $_W['timestamp']);
                    $content = array(
                        'first' => array(
                            'value' => '您好，您本月物业费已出。',
                        ),
                        'userName' => array(
                            'value' => $item['realname'],
                        ),
                        'address' => array(
                            'value' => $region['title'].$item['address'],
                        ),
                        'pay'    => array(
                            'value' => $cost['total'].'元',
                        ),
                        'remark'    => array(
                            'value' => '请尽快缴纳，如有疑问，请咨询.',
                        ),
                    );
                    $result = $this->sendtpl($openid,$url,$template_id,$content);
//					print_r($result);exit();
                }
            }
        }
    }
    //删除用户
    if (checksubmit('delete')) {
        $cids=$_GPC['cid'];
        if (!empty($cids)) {
            foreach ($cids as $key => $cid) {
                pdo_delete('xcommunity_cost_list',array('id' => $cid));
            }
            message('删除成功',referer(),'success');
        }
    }
    include $this->template('web/cost/detail');
}elseif ($op == 'setgoodsproperty') {
    $data = $_GPC['data'];
    if (empty($data)) {
        $data = '否';
    }
    $data = ($data=='是'?'否':'是');
    pdo_update("xcommunity_cost_list", array('status' => $data), array("id" => $id, "weid" => $_W['uniacid']));
    die(json_encode(array("result" => 1, "data" => $data)));



}elseif($op == 'order'){
    //物业订单
    if (empty($id)) {
        message('缺少参数',referer(),'error');
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize  = 20;
    $condition = '';
    if($_GPC['mobile']){
        $condition .= " AND p.mobile='{$_GPC['mobile']}'";
    }
    if($_GPC['realname']){
        $condition .= " AND p.username='{$_GPC['realname']}'";
    }
    if($_GPC['homenumber']){
        $condition .= " AND p.homenumber='{$_GPC['homenumber']}'";
    }
    $status = intval($_GPC['status']);
    if($status == 1){
        $condition .= " AND o.status=1";
    }elseif ($status == 2){
        $condition .= " AND o.status=0";
    }
    $starttime = strtotime($_GPC['birth']['start']) ;
    $endtime   = strtotime($_GPC['birth']['end']) ;
    if (!empty($starttime) && $starttime==$endtime) {
        $endtime = $endtime+86400-1;
    }
    if ($starttime && $endtime) {
        $condtion .=" AND o.createtime between '{$starttime}' and '{$endtime}'";
    }
    $list = pdo_fetchall("SELECT o.* ,p.username as username ,p.mobile as mobile,p.homenumber as homenumber FROM".tablename('xcommunity_order')."as o left join (".tablename('xcommunity_cost_list')."as p left join ".tablename('xcommunity_cost')."as r on p.cid = r.id) on o.pid = p.id WHERE o.weid=:weid AND r.id = :id $condition order by o.createtime desc LIMIT ".($pindex - 1) * $psize.','.$psize,array(':id' => $id,':weid' => $_W['weid']));
    foreach ($list as $key => $value) {
        $list[$key]['cctime'] = date('Y-m-d H:i',$value['createtime']);
        $list[$key]['s'] = empty($value['status']) ? '未支付' : '已支付';
    }
    $total =pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_order')."as o left join (".tablename('xcommunity_cost_list')."as p left join ".tablename('xcommunity_cost')."as r on p.cid = r.id) on o.pid = p.id  WHERE o.weid=:weid AND r.id = :id $condition order by o.createtime desc ",array(':id' => $id,':weid' => $_W['weid']));
    $pager  = pagination($total, $pindex, $psize);
    if ($_GPC['export'] == 1) {
        $li = pdo_fetchall("SELECT o.* ,p.username as username ,p.mobile as mobile,p.homenumber as homenumber FROM".tablename('xcommunity_order')."as o left join (".tablename('xcommunity_cost_list')."as p left join ".tablename('xcommunity_cost')."as r on p.cid = r.id) on o.pid = p.id WHERE o.weid=:weid AND r.id = :id $condition order by o.createtime desc ",array(':id' => $id,':weid' => $_W['weid']));
        foreach ($li as $key => $value) {
            $li[$key]['cctime'] = date('Y-m-d H:i',$value['createtime']);
            $li[$key]['s'] = empty($value['status']) ? '未支付' : '已支付';
        }
        $this->export($li,array(
            "title" => "缴费订单-" . date('Y-m-d-H-i', time()),
            "columns" => array(
                array(
                    'title' => '姓名',
                    'field' => 'username',
                    'width' => 12
                ),
                array(
                    'title' => '手机号',
                    'field' => 'mobile',
                    'width' => 12
                ),
                array(
                    'title' => '房号',
                    'field' => 'homenumber',
                    'width' => 18
                ),
                array(
                    'title' => '缴费金额',
                    'field' => 'price',
                    'width' => 20
                ),
                array(
                    'title' => '微信订单号',
                    'field' => 'transid',
                    'width' => 20
                ),
                array(
                    'title' => '支付状态',
                    'field' => 's',
                    'width' => 18
                ),
                array(
                    'title' => '时间',
                    'field' => 'cctime',
                    'width' => 22
                ),
            )
        ));
    }
    include $this->template('web/cost/order');
}elseif($op == 'del') {
    //物业费订单删除
    if ($_W['isajax']) {
        if (empty($id)) {
            exit('缺少参数');
        }
        $order = pdo_fetch("SELECT * FROM".tablename('xcommunity_order')."WHERE id=:id",array(':id' => $id));
        if (empty($order)) {
            exit('订单不存在');
        }
        $r = pdo_delete("xcommunity_order",array('id' => $id));
        if ($r) {
            $result = array(
                'status' => 1,
            );
            echo json_encode($result);exit();
        }
    }
}elseif ($op == 'edit') {
    //编辑用户
//	if (empty($id)) {
//		message('缺少参数',referer().'error');
//	}

    if($id){
        $item = pdo_fetch("SELECT * FROM".tablename('xcommunity_cost_list')."WHERE id=:id",array(':id' => $id));
        if ($item['fee']) {
            $fee = explode('|', $item['fee']);
        }
        if (empty($item)) {
            message('数据不存在或已被删除',referer(),'error');
        }
        $regionid = $item['regionid'];
    }else{
        $regionid = intval($_GPC['regionid']);
    }
//	echo $regionid;
    $category = pdo_fetch("SELECT * FROM".tablename('xcommunity_category')."WHERE regionid=:regionid AND type =7 AND weid=:weid",array(':regionid' => $regionid,':weid' => $_W['uniacid']));
    $cate = explode('|', $category['name']);
//	print_r($cate);exit();
    if (checksubmit('submit')) {
        $fee = implode("|", $_GPC['fee']);

        $data = array(
            'username' => $_GPC['username'],
            'area' => $_GPC['area'],
            'mobile' => $_GPC['mobile'],
            'homenumber' => $_GPC['homenumber'],
            'costtime' => $_GPC['costtime'],
            'total' => $_GPC['total'],
            'fee' => $fee
        );
        if ($id) {
            $r = pdo_update('xcommunity_cost_list',$data,array('id' => $id));
        }else{
            $data['weid'] = $_W['uniacid'];
            $data['regionid'] = $regionid;
            $data['cid'] = intval($_GPC['cid']);
            $data['status'] = '否';
            $data['createtime'] = TIMESTAMP;
            $r = pdo_insert('xcommunity_cost_list',$data);
        }
        if ($r) {
            message('修改成功',referer(),'success');
        }
    }
    include $this->template('web/cost/edit');
}elseif ($op == 'category') {
    $operation = !empty($_GPC['operation']) ? $_GPC['operation'] : 'add';
    if ($operation == 'add') {
        //增加费用类型

        $regions = $this->regions();

        if ($id) {
            $item = pdo_fetch("SELECT * FROM".tablename('xcommunity_category')."WHERE id=:id AND weid=:weid",array(':id' => $id,':weid' => $_W['uniacid']));
        }
        if (checksubmit('submit')) {
            $data = array(
                'weid' => $_W['uniacid'],
                'type' => 7,
                'name' => $_GPC['name'],

            );
            $regionid = intval($_GPC['regionid']);
            if ($id) {
                pdo_update('xcommunity_category',$data,array('id' => $id));
            }else{
                $data['regionid'] = $regionid;
                $category = pdo_fetch("SELECT * FROM".tablename('xcommunity_category')."WHERE regionid=:regionid",array(':regionid' => $regionid));
                if ($category) {
                    message('该小区费用类型已存在,无需在增加',referer(),'error');exit();
                }
                pdo_insert('xcommunity_category',$data);
            }
            message('提交成功',referer(),'success');
        }



        include $this->template('web/cost/category/add');
    }elseif ($operation == 'list') {
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 10;
        $condition = '';
        if ($user[type] == 3) {
            $condition .=" and r.id in({$user['regionid']})";
        }
        $list = pdo_fetchall("SELECT c.*,r.title,r.city,r.dist FROM".tablename('xcommunity_category')."as c left join".tablename('xcommunity_region')."as r on c.regionid = r.id WHERE c.weid='{$_W['weid']}' AND c.type=7 $condition",$params);
        $total  = pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_category')."as c left join".tablename('xcommunity_region')."as r on c.regionid = r.id WHERE c.weid='{$_W['weid']}' AND c.type=7 $condition",$params);
        $pager  = pagination($total, $pindex, $psize);
        include $this->template('web/cost/category/list');
    }elseif ($operation == 'del') {
        if (empty($id)) {
            message('缺少参数',referer(),'error');
        }
        $result    = pdo_delete('xcommunity_category',array('id' => $id,'weid' => $_W['weid']));
        message('删除成功',referer(),'success');
    }
}elseif ($op == 'ajax') {
    $regionid = intval($_GPC['regionid']);
    if ($regionid) {
        $cate = pdo_fetch("SELECT * FROM".tablename('xcommunity_category')."WHERE regionid=:regionid",array(':regionid' => $regionid));
        print_r(json_encode($cate));exit();
    }else{
        $cate = 0;
        print_r(json_encode($cate));exit();
    }
}elseif($op == 'verify'){
    //审核用户
    $id = intval($_GPC['id']);
    $type = $_GPC['type'];
    $data = intval($_GPC['data']);
    if (in_array($type, array('status','open_status'))) {
        $data = ($data==1?'0':'1');
        pdo_update("xcommunity_cost", array($type => $data), array("id" => $id, "weid" => $_W['uniacid']));
        die(json_encode(array("result" => 1, "data" => $data)));
    }
}elseif ($op =='xqprint'){
    $id = intval($_GPC['id']);
    if($id){
        $item = pdo_get('xcommunity_cost_list',array('id' => $id),array('username','homenumber','total'));
        if(empty($item)){
            message('非法访问',referer(),'error');exit();
        }
        $set = ln_syssetting_read('','print');
        $xqset = ln_syssetting_read(trim(intval($_GPC['regionid'])),'xqprint');
        if($set['typrint']){
            $createtime = date("Y-m-d H:i",TIMESTAMP);
            if($set['api'] == 1){
                $yl = ln_syssetting_read('','printyl');

                $content = "^N1^F1\n";
                $content .= "^B2 收费小票\n";
                $content .="姓名：".$item['username']."\n";
                $content .="房号：".$item['homenumber']."\n";
                $content .="费用：".$item['total'].'元'."\n";
                $content .="时间：".$createtime;
                $result = $this->sendSelfFormatOrderInfo($yl['deviceno'], $yl['key'], 1,$content);
                echo $result;exit();
            }else{
                $fy = ln_syssetting_read('','printfy');
                $freeMessage = array(
                    'memberCode' => $fy['code'],
                    'msgDetail'  =>
                        '
												        收费小票

												姓名：' . $item['username'] . '
												-------------------------

												房号：' . $item['homenumber'] . '
												费用：' . $item['total'] . '
												时间：' . $createtime . '
												',
                    'deviceNo'   => $fy['deviceno'],
                    'msgNo'      => $fy['key'],
                );
                echo $this->sendFreeMessage($freeMessage, $fy['key']);
            }

        }elseif($xqset['cost']){

            $createtime = date("Y-m-d H:i",TIMESTAMP);
            if($xqset['api'] == 1){
                $content = "^N1^F1\n";
                $content .= "^B2 收费小票\n";
                $content .="姓名：".$item['username']."\n";
                $content .="房号：".$item['homenumber']."\n";
                $content .="费用：".$item['total'].'元'."\n";
                $content .="时间：".$createtime;
                $result = $this->sendSelfFormatOrderInfo($xqset['yldeviceno'], $xqset['ylkey'], 1,$content);
                echo $result;exit();

            }else{
                $freeMessage = array(
                    'memberCode' => $xqset['fycode'],
                    'msgDetail'  =>
                        '
												        收费小票

												姓名：' . $item['username'] . '
												-------------------------

												房号：' . $item['homenumber'] . '
												费用：' . $item['total'] . '
												时间：' . $createtime . '
												',
                    'deviceNo'   => $xqset['fydeviceno'],
                    'msgNo'      => $xqset['fykey'],
                );
                echo $this->sendFreeMessage($freeMessage, $xqset['fykey']);
            }
        }else{
           echo json_encode(array('status' => 1,'content' => '未开启打印机接口'));exit();
        }
    }
}










