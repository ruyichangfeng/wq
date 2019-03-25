<?php
//一个小时执行一次 
//命令    php /www/微擎安装绝对路径/addons/zsk_market/core/task/run.php
ini_set("display_errors", "off");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$sys=explode('addons',__FILE__);
!defined('ROOT') && define('ROOT',$sys[0]);
!defined('ZSK_MODULE') && define('ZSK_MODULE',"zsk_market");
!defined('ZSK_PATH') && define('ZSK_PATH',ROOT."addons/zsk_market/");
!defined('ZSK_PREFIX') && define('ZSK_PREFIX','azsk_shop'); 
//订单结算时间，天数
!defined('CLOSE_DAY') && define('CLOSE_DAY',7); 
//订单结算时间，自动确认收货
!defined('AUTO_REACH') && define('AUTO_REACH',7); 
 
define('IN_IA', true);
define('IN_API', true);
if(intval($_GET['indebug'])==1){
    define('IN_DEBUG', true);
     ini_set("display_errors","OFF"); 
}else{
    define('IN_DEBUG', false); 
     ini_set("display_errors","ON");
}
  
 
 
require_once ROOT."data/config.php";//微擎配置文件
require_once ZSK_PATH."core/task/function.php";
require_once ZSK_PATH."core/task/pdo.class.php";
require_once ZSK_PATH."core/task/weapp.class.php"; 
require_once ZSK_PATH."core/task/wechat.class.php"; 
require_once ZSK_PATH."core/task/wxpush.func.php"; 
require_once ZSK_PATH."core/task/wxpay.class.php";

$model=Model("order");
//获取所有小程序的配置
$wxapps=Model("setting")->getall("*");
if(empty($wxapps)){
    echo "no wxapps";die();
};
//清空过期表单id
Model("formid")->where("ceratetime<".$day7before)->delete();

$timestart=time()-86400*3;
$timestop=time(); 
$day7before=time()-86400*7;
$day1before=time()-86400;
$tab_wxapp=$model->table("account_wxapp")->gettable();
$tab_setting=$model->tablename("setting");
$tab_dis=$model->tablename("discount");
$tab_disgroup=$model->tablename("discountgroup"); 
$tab_agent=$model->tablename("agent"); 

$day3_before=date("Y-m-d H:i:s",time()-86400*3);

foreach ($wxapps as $k0 => $v0) {
    $uniacid=intval($v0['uniacid']);
    
    $v0['wx_conf']=json_decode($v0['wx_conf'],true);
    $v0['wxpay']=json_decode($v0['wxpay'],true);
    $v0['wxapp_conf']=json_decode($v0['wxapp_conf'],true);
    $v0['agent']=json_decode($v0['agent'],true);
//  $we7app=$model->table("account_wxapp")->where("uniacid=$uniacid")->get("`key` as appid,");
    
    $setting=$v0;
    //秒杀提醒
    $model=Model("discountnotice");
    $time=time();
    $notices=$model->where("status=0 and uniacid=".$uniacid." and createtime>".$day1before." and limittime-700<".$time." and limittime>".$time)->getall(); 
    if(count($notices)){ 
        $notices=get_form_id($notices);  
        $res=miaosha_start($notices); 
        plog($res);
        $ids="";
       
        if(count($res)){
            foreach ($res as $key => $val) {
                $ids.=$val['id'].",";
                if(intval($val['result']['errcode'])>0){
                    $notcase="WHEN ".$val['id']." THEN -1 ";
                }else{
                    $notcase="WHEN ".$val['id']." THEN 1 ";
                }
               
            }
        }  
        if(strlen($ids)){
            $tab0=$model->tablename("discountnotice");
            $ids=substr($ids,0,strlen($ids)-1);
            $sql="UPDATE $tab0 SET status=CASE id $notcase END WHERE id in ($ids)";
            $model->query($sql);
        }   
    }
//$timestart="1545198603";
    //获取过去时间段内未处理的订单
    $groups=$model->tablemodel("order")->where("discountstatus=2 and discounttype=4 and discountgroup>0 and limittime>$timestart  and `date`>'$day3_before' and uniacid=$uniacid")->order('`date` asc')->group("discountgroup")->getall("id,uniacid,discountid,order_no,pay_status,discounttype,discountstatus,discountgroup,money_pay,money,city,contact,mobile");
    plog($groups);
  // var_dump(count($groups));
    if(count($groups)){
        foreach ($groups as $k1 => $v1) {
        //支付成功人数 
            $pay_status_ok=$model->where("pay_way=1 and pay_status=1 and uniacid=$uniacid and discountgroup=".intval($v1['discountgroup']))->count();
            $sql="SELECT $tab_dis.starttime,$tab_dis.stoptime,$tab_dis.group_start,$tab_dis.group_limit,$tab_dis.price_kanjia,$tab_disgroup.owner_nick,$tab_dis.now_people,$tab_dis.casejson,$tab_dis.limit_hour,$tab_dis.limit_once,$tab_dis.seconds,$tab_disgroup.* FROM $tab_disgroup LEFT JOIN $tab_dis ON $tab_dis.id=$tab_disgroup.discount_id WHERE $tab_disgroup.id=".intval($v1['discountgroup'])." limit 1";
            
            $disc=$model->fetch($sql); 
           // var_dump($disc['group_start']); 
            //var_dump($pay_status_ok); 

            if(intval($disc['group_start'])<=intval($pay_status_ok)){

                //通知买家
                $orders= $model->tablemodel("order")->order("uniacid asc")->where("discountgroup=".intval($v1['discountgroup'])."  and uniacid=$uniacid and pay_status=1")->getall("openid,order_no,abstract,`date`,money_pay,'拼团成功，等待卖家发货，点击查看详情' as remark");
                $touser=get_form_id($orders);
                $res=pintuan_tpl_ok($touser,$orders); 
               
                 //通知卖家
                $pusher=$model->tablemodel("pusher")->group("openid")->where("uniacid=$uniacid and status>0 and type=2")->getall("id ,shopid,openid,nickname");
                $res2=pintuan_tpl_send($pusher,array("order_count"=>count($orders)."笔","remark"=>"拼团发起人：".$disc['owner_nick']."，\r\n参与人数：".count($orders)."人"));
                 
                 $model->tablemodel("discountgroup")->where("id=".intval($v1['discountgroup'])." and uniacid=$uniacid")->save(array("status"=>2));
                 $model->tablemodel("order")->where("discountgroup=".intval($v1['discountgroup'])." and pay_status=1 and uniacid=$uniacid")->save(array("discountstatus"=>3));

            }else{
                //拼团失败
                $orders= $model->tablemodel("order")->order("uniacid asc")->where("discountgroup=".intval($v1['discountgroup'])." and pay_status=1  and uniacid=$uniacid")->getall("openid,order_no,abstract,wxpay_no,refund_no,money_pay,`date`,'拼团失败，未达到拼团人数' as remark");

                $touser=get_form_id($orders);
                $res=pintuan_tpl_fail($touser,$orders);
                 $model->tablemodel("discountgroup")->where("id=".intval($v1['discountgroup'])." and uniacid=$uniacid")->save(array("status"=>-1));
                $model->tablemodel("order")->where("discountgroup=".intval($v1['discountgroup']))->save(array("discountstatus"=>-1));
            }

        }
    }
    



    $agentgroup=$model->tablemodel("agentgroup")->where("uniacid=$uniacid")->getall();
    if(count($agentgroup)){
        //进行分销和平台提成结算
        $start="1";
        $day_before=date("Y-m-d H:i:s",time()-86400*intval(CLOSE_DAY));
        $orders=$model->tablemodel("order")->where("uniacid=$uniacid and pay_status=1 and ( discounttype<>4  or (discounttype=4 and discountstatus=3)) and pay_way=1 and money_pay>=1 and agent_status=0 and `date`<'".$day_before."'")->getall();
       
        foreach ($orders as $key => $order) {
            plog("分销订单：".$order['order_no']);
            $agent0=null;$agent1=null;$agent2=null;$meney_agent=0;
            if(intval($order['agent_p0'])>1){
               $agent0=$model->tablemodel("agent")->where("code='".$order['agent_p0']."' and status=1")->get();
               
               if(!empty($agent0)){
                    $group=getAgentGroupByID($agentgroup,$agent0['groupid']);//代理组分成信息
                   
                    $income0=floor(floatval($order['money_pay'])*floatval($group['percent0'])*100)/100;//向下保留2位有效数字
                    if(floatval($income0)>0){ 
                        $meney_agent=$income0;
                        $freezing="";
                        if(floatval($agent0['freezing'])<$income0){
                            $freezing=",balance_freezing=0";
                        }else{
                            $freezing=",balance_freezing=balance_freezing-$income0";
                        }
                        $sql="UPDATE $tab_agent set balance=balance+$income0,moneytotal=moneytotal+$income0 $freezing WHERE code='".$agent0['code']."' and uniacid=$uniacid and status=1";
                        plog($sql); 
                        $model->query($sql);
                    }
               }
            }  
            if(intval($order['agent_p1'])>1){
               $agent1=$model->tablemodel("agent")->where("code='".$order['agent_p1']."' and status=1 and uniacid=".$uniacid)->get();
               if(!empty($agent1)){
                    $group=getAgentGroupByID($agentgroup,$agent1['groupid']);//代理组分成信息
                    $income1=floor(floatval($order['money_pay'])*floatval($group['percent1'])*100)/100;//向下保留2位有效数字
                    if(floatval($income1)>0){ 
                        $meney_agent=$income1;
                         $freezing="";
                        if(floatval($agent1['freezing'])<$income1){
                            $freezing=",balance_freezing=0";
                        }else{
                            $freezing=",balance_freezing=balance_freezing-$income1";
                        }
                        $sql="UPDATE $tab_agent set balance=balance+$income1,moneytotal=moneytotal+$income1 $freezing WHERE code='".$agent1['code']."' and uniacid=$uniacid and status=1";
                        $model->query($sql);
                        plog($sql); 
                    }
               }
            }  
            if(intval($order['agent_p2'])>1){
                $agent2=$model->tablemodel("agent")->where("code='".$order['agent_p2']."' and status=1 and uniacid=".$uniacid)->get();
                    if(!empty($agent2)){
                        $group=getAgentGroupByID($agentgroup,$agent2['groupid']);//代理组分成信息
                        $income2=floor(floatval($order['money_pay'])*floatval($group['percent2'])*100)/100;//向下保留2位有效数字
                        if(floatval($income2)>0){
                            $meney_agent=$income2;
                            $freezing="";
                        if(floatval($agent2['freezing'])<$income2){
                            $freezing=",balance_freezing=0";
                        }else{
                            $freezing=",balance_freezing=balance_freezing-$income2";
                        }
                        $sql="UPDATE $tab_agent set balance=balance+$income2,moneytotal=moneytotal+$income2 $freezing WHERE code='".$agent2['code']."' and uniacid=$uniacid and status=1";
                        $model->query($sql);
                        plog($sql);
                    }
                }
            }  
            $orders=$model->tablemodel("order")->where("id=".$order['id'])->limit(1)->save(array("agent_status"=>1));
        }
    }
    //处理自动收货
    //发货大于15天自动收货，确认收货7天内可申请退款、换货
    //关闭退款， 
    

    //处理代理等级 
    if($setting['agent']['auto_levelup']=="on"){
         $model=Model("agentgroup");
        $agentgroup=$model->where("moneytotal>0 and status>0 and uniacid=".$uniacid)->order("moneytotal asc")->getall();
         
        if(count($agentgroup)){
            $tab2=$model->tablename("agent");
            foreach ($agentgroup as $key => $val) {
                $sql="UPDATE $tab2 SET $tab2.groupid=".$val['id']." WHERE uniacid=".$val['uniacid']." and $tab2.moneytotal>=".floatval($val['moneytotal']);
                $model->query($sql);
            }
        }
    }

   
    //处理代理提现银行接口
    if((strlen($setting['keypem'])>500&& strlen($setting['certpem'])>500)&&(strlen($setting['wxpay']['mchid'])>10&& strlen($setting['wxpay']['key'])>10)){
        $pay=new Wxpay($setting); 
        $before=date("Y-m-d H:i:s",time()-86400*7);
        $model=Model("agentwithdraw");
        $applys=$model->where("type='bank' and bankcode>0 and status=1 and `datetime`>'".$before."'  and uniacid=".$uniacid)->getall();
        foreach ($applys as $key => $apply) {
            $data=array(
                "partner_trade_no"=>$apply['order_no'] 
            );
            $apires=$pay->queryBank($data); 
            $model->where("id=".$apply['id'])->limit(1)->save(array("status_api"=>$apires['status']));
            switch ($apires['status']) { 
                case 'FAILED':
                    $apply['reply']="付款失败，请检测姓名和账户";
                    withdraw_fail($apply['openid'],$apply);
                    break;
                case 'BANK_FAIL':
                    $apply['reply']="付款失败，银行退票";
                     withdraw_fail($apply['openid'],$apply);
                    break;
                default:
                    # code...
                    break;
            }    
        }  
    }

    //获取微信公众号小程序端的用户访问数据
    $visit=$model->tablemodel("visit")->where("uniacid=$uniacid")->order('id desc')->get();
    $time = date('Ymd')-1;
    if($visit['ref_date'] < $time){
        $settingModel=Model("setting");
        $where = 'uniacid = '.$uniacid;
        $setting = $settingModel->where($where)->get();
        $WeixinJS = new WeixinJS($setting['appid'],$setting['secret']);
        var_dump($WeixinJS);die;
        $accessToken = $WeixinJS->getAccessToken();
        $url = 'https://api.weixin.qq.com/datacube/getweanalysisappidvisitpage?access_token='.$accessToken['access_token'];
        $data = array(
            'begin_date' => $time,
            'end_date' => $time,
        );
        $data = json_encode($data);
        $dtis = json_decode(request_post($url,$data));
        foreach ($dtis as $k => $v){
            if(is_array($v)){
                foreach ($v as $kone => $vone){
                    $d = array(
                        'page_path' => $vone->page_path,
                        'page_visit_pv' => $vone->page_visit_pv,
                        'page_visit_uv' => $vone->page_visit_uv,
                        'page_staytime_pv' => $vone->page_staytime_pv,
                        'entrypage_pv' => $vone->entrypage_pv,
                        'exitpage_pv' => $vone->exitpage_pv,
                        'page_share_pv' => $vone->page_share_pv,
                        'page_share_uv' => $vone->page_share_uv,
                        'ref_date' => $time,
                        'uniacid' => $uniacid,
                    );
                    $res = $model->add($d);
                }
            }
        }
    }

}
echo ("处理完成");
