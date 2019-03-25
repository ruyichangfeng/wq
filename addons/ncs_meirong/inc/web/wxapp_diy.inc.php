<?php
defined('IN_IA') or exit('Access Denied');

$ops=array('edit','savemodel','savenav','del','chang_status','savemenu','delmenu','change_menu_status');

global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'edit';
$xkey='wxapp_diy';
$moduleName = $_W['current_module']['name'];
switch($op){
    case 'edit':
        $xtitle='小程序DIY';
        $url= $this->createWebUrl($xkey,['op'=>'savemodel']);
        $list = [];
        $res=pdo_getall('wq_config',array('xkey'=>$xkey,'uniacid'=>$uniacid));
        foreach ($res as $key=>$val){
            $list[$val['name']] = $val['content'];
        }
        $pagesData = [
            'index'=>['title'=>'首页','name'=>'index','path'=>$moduleName.'/pages/index/index'],
            'technicain'=>['title'=>'工作人员列表','name'=>'technicain','path'=>$moduleName.'/pages/technician/technician'],
            'technicain_detail'=>['title'=>'工作人员详情','name'=>'technicain_detail','path'=>$moduleName.'/pages/technicain_detail/technicain_detail'],
            'service_detail'=>['title'=>'服务详情','name'=>'service_detail','path'=>$moduleName.'/pages/detail/detail'],
            'user_central'=>['title'=>'会员中心','name'=>'user_central','path'=>$moduleName.'/pages/central/central'],
            'book'=>['title'=>'在线预约','name'=>'book','path'=>$moduleName.'/pages/book/book'],
            'online'=>['title'=>'我的预约','name'=>'online','path'=>$moduleName.'/pages/central/online/online'],
            'address'=>['title'=>'地址列表','name'=>'address','path'=>$moduleName.'/pages/central/address/address'],
        ];
        //保存导航栏配置url
        $nvaSaveUrl = $this->createWebUrl($xkey,['op'=>'savenav']);
        //顶部导航栏
        $navData = pdo_getall('wq_top_nav',array('uniacid'=>$uniacid),array(),'','id DESC');
        foreach ($navData as $key=>$val){
            $navData[$key]['nav_name_cn'] = $pagesData[$val['nav_name']]['title'];
        }
        //删除顶部导航栏url
        $delUrl = $this->createWebUrl($xkey,['op'=>'del']);
        //改变顶部导航栏状态 url
        $changeStatusUrl = $this->createWebUrl($xkey,['op'=>'chang_status']);

        //底部菜单
        $menuData = pdo_getall('wq_footmenu',array('uniacid'=>$uniacid),array(),'','m_sort DESC,id DESC');
        $menuSaveUrl = $this->createWebUrl($xkey,['op'=>'savemenu']);
        $delMenuUrl = $this->createWebUrl($xkey,['op'=>'delmenu']);
        $changeMenuStatusUrl = $this->createWebUrl($xkey,['op'=>'change_menu_status']);

        include $this->template("Wxapp_diy/edit");
        break;
    case 'savemodel':
        $filed = [ 'nav_fontcolor', 'nav_active_fontcolor', 'nav_bgcolor', 'nav_bordercolor'];
        //m_status 默认为1开启，2为关闭
        $condition=array();
        $condition['uniacid']=$uniacid;
        $condition['xkey']=$xkey;
        foreach ($_POST as $key=>$val){
            if(!in_array($key,$filed)){
                continue;
            }
            $condition['name']=$key;
            if(pdo_get('wq_config', $condition)){
                $request=pdo_update('wq_config',['content'=>$val],$condition);
            }
            else{
                $condition['content']=$val;
                $request=pdo_insert('wq_config',$condition);
            }
        }
          return  message('操作成功',$this->createWebUrl($xkey));
        break;
    case 'savenav':
        $id = (int)$_GPC['nav_id'];
        $condition['nav_title'] = trim($_GPC['nav_title']);
        $condition['nav_bg_color'] = trim($_GPC['nav_bg_color']);
        $condition['nav_font_color'] = trim($_GPC['nav_font_color']);
        $condition['nav_name'] = $_GPC['nav_name'];
        if($id>0){
            //更新
            $request=pdo_update('wq_top_nav',$condition,['id'=>$id,'uniacid'=>$uniacid]);
        }
        else
        {
            //添加
            $condition['uniacid'] = $uniacid;
            $request=pdo_insert('wq_top_nav',$condition);
        }
        if($request){
           return message('操作成功',$this->createWebUrl($xkey));
        }
        break;
    case 'del':
        $id = (int)$_GPC['id'];
        if($id<=0){
          return error(1, '删除失败，请检查参数');
        }
        $condition['uniacid'] = $uniacid;
        $condition['id'] = $id;
        $result = pdo_delete('wq_top_nav',$condition);
        if (!empty($result)) {
            echo json_encode(array("status"=>1,'msg'=>'删除成功',"data"=>[]));
            return ;
        }
        echo json_encode(array("status"=>0,'msg'=>'删除错误',"data"=>[]));
            return;
        break;
    case 'chang_status':
        $id = (int)$_GPC['id'];
        $status = (int)$_GPC['m_status'];
        if($id<=0){
            return error(1, '删除失败，请检查参数');
        }
        $changStatus = $status == 1 ? 0 :1;
        $condition['m_status'] = $changStatus;
        $request=pdo_update('wq_top_nav',$condition,['id'=>$id,'uniacid'=>$uniacid]);
        if($request){
            echo json_encode(array("status"=>1,'msg'=>'更改成功',"data"=>[]));
            break;
        }
        echo json_encode(array("status"=>0,'msg'=>'更改失败',"data"=>[]));
        break;
    case 'savemenu':
        $id = (int)$_GPC['menu_id'];
        $condition['name'] = trim($_GPC['name']);
        $condition['page_path'] = $_GPC['page_path'];
        $condition['icon_path'] = ($_GPC['icon_path']);
        $condition['selected_icon_path'] = trim($_GPC['selected_icon_path']);
        $condition['m_sort'] = empty($_GPC['m_sort'])?0:(int)$_GPC['m_sort'];
        if($id>0){
            //更新
            $request=pdo_update('wq_footmenu',$condition,['id'=>$id,'uniacid'=>$uniacid]);
        }
        else
        {
            //添加
            $condition['uniacid'] = $uniacid;
            $request=pdo_insert('wq_footmenu',$condition);
        }
        if($request){
            return message('操作成功',$this->createWebUrl($xkey));
            break;
        }
        error(1, '出错了');
        break;
    case 'delmenu':
        $id = (int)$_GPC['id'];
        if($id<=0){
            return error(1, '删除失败，请检查参数');
        }
        $condition['uniacid'] = $uniacid;
        $condition['id'] = $id;
        $result = pdo_delete('wq_footmenu',$condition);
        if (!empty($result)) {
            echo json_encode(array("status"=>1,'msg'=>'删除成功',"data"=>[]));
            return ;
        }
        echo json_encode(array("status"=>0,'msg'=>'删除错误',"data"=>[]));
        return;
        break;
    case 'change_menu_status':
        $id = (int)$_GPC['id'];
        $status = (int)$_GPC['m_status'];
        if($id<=0){
            return error(1, '删除失败，请检查参数');
        }
        $changStatus = $status == 1 ? 0 :1;
        $condition['m_status'] = $changStatus;
        $request=pdo_update('wq_footmenu',$condition,['id'=>$id,'uniacid'=>$uniacid]);
        if($request){
            echo json_encode(array("status"=>1,'msg'=>'更改成功',"data"=>[]));
            break;
        }
        echo json_encode(array("status"=>0,'msg'=>'更改失败',"data"=>[]));
        break;
}