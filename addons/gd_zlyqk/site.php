<?php
/**
 * 只能工单系统
 * @binYuan
 */
error_reporting(1);
defined('IN_IA') or exit('Access Denied');

include "tpl.php";
include "pinyin.php";
include 'extLoad.php';
require_once 'sms/vendor/autoload.php';
spl_autoload_register('extLoader::autoload');

use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;

class gd_zlyqkModuleSite extends tpl
{
    public $page;
    public $pDo;
    public $listRow;
    public $qrcode;

    public $plugin;
    public $pStatic;
    public $pRoot;
    public $pClass;

    public $baseDir="";
    public $pAdmin=false;
    public $outTotal=array();
    public $fileList =array();
    protected $isAjax = false;
    public $statusLine=array();

    public $apiUrl = "http://api.k9k.org/";
    public $msg = array("code" => 2, 'msg' => "", "data" => "");

    //数据初始化
    public function __construct($isChild=false)
    {
        global $_GPC,$_W;
        if (isset($_GPC['Ajax']) || $_W['isajax']) {
            $this->isAjax = true;
        }
        $this->page = empty($_GPC['page']) ?1 :$_GPC['page'];
        $this->listRow = empty($_GPC['list_row'])?10:$_GPC['list_row'];
        if(!$isChild){
            $this->registerPlugin();
        }
    }

    //获取分类
    public function doMobileCcp(){
        global $_GPC;
        $id = empty($_GPC['id'])?0:$_GPC['id'];
        $list = pdo_getall("gd_pp",array("parent"=>$id));
        $parent = isset($list[0])?$list[0]['parent']:0;
        $pInfo = pdo_get("gd_pp",array("code"=>$parent));
        $parent = isset($pInfo['parent'])?$pInfo['parent']:0;
        include  $this->template("ccp");
    }

    //展示以选择
    public function doMobileSelectPb(){
        global $_GPC;
        $ids=$_GPC['id'];
        $list=array();
        if(!empty($ids)){
            $list = pdo_fetchall("select * from ".tablename("gd_pp")." where id in ({$ids}) ");
        }
        include  $this->template("select_pb");
    }

    public function beforeHbList(&$where){
        global $_GPC;
        if($_GPC['name']){
            $where .= " and send_name like '%{$_GPC['name']}%' ";
        }
    }

    public function beforeHblogList(&$where){
        global $_GPC;
        if($_GPC['name']){
            $where .= " and member_name like '%{$_GPC['name']}%' ";
        }
        $where .=" and hb_id={$_GPC['id']}";
    }

    public function beforeTplList(&$where){
        global $_GPC;
        if(!empty($_GPC['name'])){
            $where .=" and name like '%{$_GPC['name']}%' ";
        }
    }

    //获取红包列表
    public function doWebSelectHb(){
        global $_W;
        //获取红包列表
        $hbList = pdo_getall("gd_hb",array('status'=>1,'uniacid'=>$_W['uniacid']));
        include $this->template("select_hb");
    }

    //插件加载操作
    public function registerPlugin(){
        global $_GPC;
        if(!$this->checkPlugin()){
            return false;
        }
        if(!$this->parsePlugin()){
            return false;
        }
        $loader=IA_ROOT."/addons/gd_zlyqk/apps/index.php";
        if(file_exists($loader)){
            include_once $loader;
            pluginRegister($this->plugin,$this->pClass,$this->pDo,$this->pAdmin);
            exit(1);
        }
    }


    //检查是否是插件
    protected function checkPlugin(){
        global $_GPC;
        if(!isset($_GPC['plugin'])){
            return false;
        }
        $plg = trim($_GPC['plugin']);
        if(empty($plg)){
            return false;
        }
        $this->plugin=strtolower($_GPC['plugin']);
        //检查文件是否
        $this->pStatic ="/addons/gd_zlyqk/apps/".$this->plugin;
        $this->pRoot = IA_ROOT.$this->pStatic;
        if(!is_dir($this->pRoot)){
            return false;
        }
        return true;
    }

    //发送红包
    public function sendHb($hbId,$memberInfo,$appInfo,$gdSn){
        $nbModel = new \ext\apps\libs\hb();
        foreach($hbId as $val){
            $hbInfo = pdo_get("gd_hb",array("id"=>$val));
            if(!empty($hbInfo)){
                $param['re_openid'] = $memberInfo['open_id'];
                $param['total_amount'] = $hbInfo['total_amount']*100;
                $param['send_name']= $hbInfo['send_name'];
                $param['wishing'] =  $hbInfo['wishing'];
                $param['act_name'] =  $hbInfo['act_name'];
                $param['remark'] =  $hbInfo['remark'];
                $scene['name'] = $appInfo['name'];
                $scene['gd_sn']=$gdSn;
                $nbModel->send($param,$scene,$hbInfo);
            }
        }
    }

    //解析路由
    protected function parsePlugin(){
        global $_GPC;
        //挂载插件
        $do=strtolower($_GPC['do']);
        if(empty($do)) return false;
        $router=explode("_",$do);
        //后台路径格式 _Jsx_do | do
        //移动端路径格式  Jsx_do
        if(count($router)==1){
            $this->pClass="index";
            $this->pDo=$router[0];
            return true;
        }else if(count($router)==2){
            $this->pClass=$router[0];
            $this->pDo=$router[1];
            return true;
        }else if(count($router)==3){
            $this->pClass=$router[1];
            $this->pDo=$router[2];
            $this->pAdmin = true;
            return true;
        }else{
            return false;
        }
    }

    //获取权限操作项目
    public function getAccArr(){
        $accList= require_once("access.php");
        return $accList;
    }

    public function beforeMemberList(&$where){
        global $_GPC;
        if($_GPC['name']){
            $where .= " and name like '%{$_GPC['name']}%' ";
        }
        if($_GPC['mobile']){
            $where .= " and mobile like '%{$_GPC['mobile']}%' ";
        }
        if($_GPC['label']){
            $where .= " and label={$_GPC['label']} ";
        }
    }

    public function memberAct(){
        //获取组列表
        $data['label']=$this->getLabelList();
        return $data;
    }

    //手机端的处理默认应用
    public function selectApps(){
        global $_GPC,$_W;
        $member = $this->initUser();
        $baseConfig =$this->getConfig(8);
        if(isset($_GPC['app_id'])){
            $where['id']=$_GPC['app_id'];
            $appInfo=$this->getDefaultApp($where);
            if(empty($appInfo) && $_GPC['app_id']>0){
                message("运用未找到",$this->createMobileUrl('member'),'info');
            }
            $_SESSION['app_id']=$_GPC['app_id'];
            $_SESSION['app_name']=$appInfo['name'];
        }
        if($baseConfig['register_in']==1){
            if($member['is_register']==0){
                $url = $this->createMobileUrl('memberInfo');
                $url =$_W['siteroot']."app/".$url;
                 parse_str($_SERVER['REQUEST_URI'],$urlInfo);
                 if(!empty($urlInfo) && isset($urlInfo['do']) && strtolower($urlInfo['do'])!="memberinfo"){
                    $url .="&_url=".base64_encode($_SERVER['REQUEST_URI']);
                 }
                header("location:".$url);
            }
        }
        //如果没有保存员工
        if(!isset($_SESSION['is_admin'])){
            $adminInfo = $this->isAdmin();
            $_SESSION['is_admin']=empty($adminInfo)?0:1;
        }
        return $member;
    }

    public function doWebThem(){
        global $_GPC;
        if($this->isAjax){
            $id =$_GPC['them']['app'];
            unset($_GPC['them']['app']);
            $them = json_encode($_GPC['them']);
            pdo_update("gd_app",array("them"=>$them),array("id"=>$id));
            $this->msg['code']=1;
            $this->msg['msg']="设置成功";
            $this->echoAjax();
        }
        $app = $_GPC['app'];
        $appInfo = pdo_get("gd_app",array("id"=>$app));
        $them=array();
        if(!empty($appInfo)){
            $them =json_decode($appInfo['them'],true);
        }
        include $this->template("them");
    }

    public function beforeLdList(&$where){
        global $_GPC;
        $parentId=empty($_GPC['parent'])?0:intval($_GPC['parent']);
        $where .= " and parent_id=$parentId";
        if($_GPC['name']){
            $where .= " and name like '%{$_GPC['name']}%' ";
        }
    }

    public function ldAct(){
        global $_GPC;
        if(empty($_GPC['parent'])){
            $data['parent_id']=0;
            $data['parent_name']="顶级";
        }else{
            $ldInfo=pdo_get("gd_ld",array("id"=>$_GPC['parent']));
            $data['parent_id']=$ldInfo['id'];
            $data['parent_name']=$ldInfo['name'];
        }
        return $data;
    }

    //可以插件
    public function doWebHavePlugin(){
        $haveList= new \ext\libs\plugin();
        $haveList = $haveList->getHavePlugin();
        include $this->template("have_plugin");
    }

    public function afterLdList($dataList){
        global $_GPC;
        $dataList['dataList']=$dataList;
        $dataList['parent']=isset($_GPC['parent'])?$_GPC['parent']:0;
        $dataList['parent_id']=isset($_GPC['parent'])?$_GPC['parent']:0;
        return $dataList;
    }

    //定期提醒任务，总共提醒2次，间隔10分钟
    public function doMobileRemind(){
        global $_W,$_GPC;
        $time=time();
        $num = isset($_GPC['num'])?intval($_GPC['num']):2;
        $div_time = isset($_GPC['time'])?intval($_GPC['time']):30;
        $div_time = $div_time*30;
        $tp=pdo_get("gd_setting",array("uniacid"=>$_W['uniacid'],'key'=>"tpl_remind"));
        if(!empty($tp)&& !empty($tp['val'])){
            $sql="select * from ".tablename("gd_remind")." where uniacid={$_W['uniacid']} and  status=1 and remind_time<$time and send_num<$num ";
            $rList = pdo_fetchall($sql);
            foreach($rList as $rmd){
                if($rmd['last_remind']+$div_time>$time){
                    continue;
                }
                //发送模板消息
                $useList =json_decode($rmd['msg_info'],true);
                if(empty($useList)){
                    continue;
                }
                //检查是开启管理员收到消息模式
                $res =pdo_get("gd_setting",array("uniacid"=>$_W['uniacid'],'key'=>'msg_add_re'));
                $poolInfo = pdo_get("gd_pool",array("id"=>$rmd['pool_id']));
                if(!empty($res) && $res['val']==1){
                    $adminList =pdo_getall("gd_mm",array("id >"=>0));
                    $notice=array();
                    foreach($useList as $user){
                        if(empty($notice)){
                            $notice['open_id']=$user['open_id'];
                            $notice['url']=$user['url'];
                            $notice['data']['first']=array("value"=>"超时提醒");
                            $notice['data']['keyword1']=array("value"=>$poolInfo['gd_sn']);
                            $notice['data']['keyword2']=array("value"=>$rmd['status_str']."\n提交时间: ".date("Y-m-d H:i",$rmd['create_time'])."\n提醒时间: ".date("Y-m-d H:i",time()));
                            $notice['data']['remark']=array("value"=>"请及时处理");
                        }
                    }
                    foreach($adminList as $admin){
                        $adminInfo =pdo_get("gd_admin",array("id"=>$admin['admin_id']));
                        if(!empty($adminInfo['open_id'])){
                            $notice['open_id']=$adminInfo['open_id'];
                            $acc = $this->notice_init();
                            $acc->sendTplNotice($notice['open_id'], $tp['val'], $notice['data'], $notice['url'], $topcolor = '#FF683F');
                        }
                    }
                }else{
                    foreach($useList as $user){
                        if(empty($user['open_id'])) continue;
                        if(isset($user['type'])){
                            $notice['open_id']=$user['open_id'];
                            $notice['url']=$user['url'];
                            $notice['data']['first']=array("value"=>$user['title']);
                            $notice['data']['keyword1']=array("value"=>$poolInfo['gd_sn']);
                            $notice['data']['keyword2']=array("value"=>$rmd['status_str']."\n提交时间: ".date("Y-m-d H:i",$rmd['create_time'])."\n提醒时间: ".date("Y-m-d H:i",time())."\n过期时间: ".date("Y-m-d H:i",$rmd['remind_time']));
                            $notice['data']['remark']=array("value"=>$user['remark']);
                            $acc = $this->notice_init();
                            $acc->sendTplNotice($notice['open_id'], $tp['val'], $notice['data'], $notice['url'], $topcolor = '#FF683F');
                        }else{
                            $notice['open_id']=$user['open_id'];
                            $notice['url']=$user['url'];
                            $notice['data']['first']=array("value"=>"超时提醒");
                            $notice['data']['keyword1']=array("value"=>$poolInfo['gd_sn']);
                            $notice['data']['keyword2']=array("value"=>$rmd['status_str']."\n提交时间: ".date("Y-m-d H:i",$rmd['create_time'])."\n提醒时间: ".date("Y-m-d H:i",time()));
                            $notice['data']['remark']=array("value"=>"请及时处理");
                            $acc = $this->notice_init();
                            $acc->sendTplNotice($notice['open_id'], $tp['val'], $notice['data'], $notice['url'], $topcolor = '#FF683F');
                        }
                    }
                }
                pdo_update("gd_remind",array("last_remind"=>$time,'send_num'=>$rmd['send_num']+1),array("id"=>$rmd['id']));
            }
        }
    }

    public function beforeGqList(&$where){
        global $_GPC;
        if(!empty($_GPC['title'])){
            $where .=" and title like '%{$_GPC['title']}%' ";
        }
    }

    public function doWebGiveMember(){
        global $_GPC;
        $id = $_GPC['id'];
        $poolId = $_GPC['pool_id'];
        //获取用户信息
        $memberInfo = pdo_get("gd_member",array("id"=>$id));
        $update['uid']=$memberInfo['uid'];
        $update['name']=$memberInfo['name'];
        $update['mobile']=$memberInfo['mobile'];

        if(pdo_update("gd_pool",$update,array("id"=>$poolId))){
            $poolInfo = pdo_get("gd_pool",array("id"=>$poolId));
            $table =str_replace($this->getTablePre(),"",$poolInfo['table']);
            $bd['member_id']=$memberInfo['id'];
            $bd['member_name']=$memberInfo['name'];
            pdo_update($table,$bd,array("id"=>$poolInfo['recorder_id']));
            $this->msg['code']=1;
            $this->msg['msg']="操作成功";
            $this->echoAjax();
        }
        $this->msg['msg']="操作失败";
        $this->echoAjax();
    }

    //发送短信验证码
    public function sendSm($phone){
        global $_W;
        //生成验证码
        $code = rand(10000,99999);
        //获取配置文件
        $where['group']=7;
        $config=$this->beforeSettingList($where);
        if(empty($config)){
            return false;
        }
        if($config['sms_switch']!=1){
            return false;
        }
        $sms = new Sms($config['aki'], $config['aks']);
        $response = $sms->sendSms(
            $config['qm'],
            $config['mb'],
            $phone,
            array(
                "code"=>$code,
            )
        );
        if(isset($response->Code) && $response->Code=="OK"){
            //插入用户验证比
            $insert['uniacid']=$_W['uniacid'];
            $insert['uid']=$_W['member']['uid'];
            $insert['create_time']=time();
            $insert['end_time']=time()+5*60;
            $insert['code']=$code;
            $insert['mobile']=$phone;
            pdo_insert("gd_sms",$insert);
            return true;
        }
        return false;
    }

    //发送流程模板消息
    public function sendFlowMsg($data){
        $where['group']=7;
        $mobile=$data['mobile'];
        unset($data['mobile']);
        $config=$this->beforeSettingList($where);
        if(empty($config)){
            return false;
        }
        if(!trim($mobile)){
            return false;
        }
        if($config['sms_lc']!=1 || empty($config['mb_lc'])){
            return false;
        }
        $sms = new Sms($config['aki'], $config['aks']);
        $response = $sms->sendSms(
            $config['qm'],
            $config['mb_lc'],
            $mobile,
           $data
        );
        if(isset($response->Code) && $response->Code=="OK"){
            return true;
        }
        return false;
    }

    //时间段解析
    public function paseTime($filter,$perNum){
        if($filter==1){
            return $perNum*60;
        }else if($filter==2){
            return $perNum*60*60;
        }else if($filter==3){
            return $perNum*24*60*60;
        }else if($filter==4){
            return $perNum*24*60*60*30;
        }else if($filter==5){
            return $perNum*24*60*60*7;
        }else if($filter==6){
            return $perNum*24*60*60*30*12;
        }
        return $filter;
    }

    //获取节点信息通过id
    public function getNodeInfoByXml($xmlId){
        return pdo_get("gd_node",array("xml_id"=>$xmlId));
    }

    //后台获取管理员信息
    public function findMemberInfo(){
        global $_GPC;
        $adminId=$_GPC['m_id'];
        return pdo_get("gd_member",array("admin_id"=>$adminId));
    }

    public function beforeOrderList(&$where){
        global $_GPC;
        if(!isset($_GPC['status'])){
            $_GPC['status']=-1;
        }
        if(!isset($_GPC['start'])){
            $startTime=strtotime(date("Y-m-d",time()));
            $start = strtotime("-1 year",$startTime);
            $end = strtotime("+1 day",$startTime);
        }else{
            $start = strtotime($_GPC['start']);
            $end = strtotime($_GPC['end']);
        }
        $_GPC['start']=date("Y-m-d ",$start);
        $_GPC['end']=date("Y-m-d ",$end);
        $where .= " and create_time>$start and create_time<$end ";
        if(!empty($_GPC['app_id'])){
            $where .= " and app_id={$_GPC['app_id']} ";
        }
        if(!empty($_GPC['order_sn'])){
            $where .=" and order_sn like '%{$_GPC['order_sn']}%' ";
        }
        if($_GPC['status']!=-1){
            $where .= " and pay_status={$_GPC['status']} ";
        }
    }

    public function afterOrderList($dataList){
        //获取应用列表
        $all = pdo_getall("gd_app");
        foreach($dataList as $key=>$val){
            $poolInfo = pdo_get("gd_pool",array("id"=>$val['pool_id']));
            $dataList[$key]['app_name']=$poolInfo['app_name'];
            $dataList[$key]['member_name']=$poolInfo['name'];
        }
        $data['dataList']=$dataList;
        //获取应用列表
        $data['apps']=$all;
        return $data;
    }

    //支付项目款
    public function doMobilePay(){
        global $_GPC,$_W;
        $orderId=$_GPC['order_id'];
        //获取订单信息
        $orderInfo = pdo_get("gd_order",array("id"=>$orderId));
        if(empty($orderInfo)){
            message("支付信息没找到",$this->createMobileUrl('member'),'info');
        }
        $params = array(
            'tid' => $orderId,
            'ordersn' =>$orderInfo['order_sn'],
            'title' => '您需要支付金额',
            'fee' => $orderInfo['money'],
            'user' => $_W['member']['uid'],
        );
        $this->pay($params);
    }

    public function payResult($params) {
        $tid =$params['tid'];
        $payLog=pdo_get("gd_order",array("id"=>$tid));
        if(empty($payLog)){
            return false;
        }
        $appInfo = $this->getAppInfo($payLog['app_id']);
        if ($params['result'] == 'success' && $params['from'] == 'notify') {
            $time=time();
            //更新支付日志
            $update['pay_time']=$time;
            $update['pay_status']=1;
            pdo_update("gd_order",$update,array("id"=>$payLog['id']));

            //更新订单日志
            $update=array();
            $update['pay_money']=$payLog['money'];
            $update['pay_sn']=$payLog['order_sn'];
            $update['pay_time']=$time;
            $update['pay_status']=1;
            if($payLog['from']==1){
                $appInfo =$this->getAppInfo($payLog['app_id']);
                $table = str_replace($this->getTablePre(),"",$appInfo['table']);
                //单独表单处理
                if(empty($appInfo['flow_id'])){
                    $update['node_name']="提交";
                    $update['status_name']="已支付";
                    $update['do_status']=1;
                    $update['is_end']=1;
                    $update['end_time']=time();
                }
                pdo_update($table,$update,array("id"=>$payLog['recorder_id']));

                //填写who_list,去掉支付标志
                $pUpdate['who_list']=$payLog['who_list'];
                $pUpdate['need_pay']=-1;
                $pUpdate['pay_money']=0;
                $pUpdate['order_id']=0;
                //需要处理表单
                if(empty($appInfo['flow_id'])){
                    $pUpdate['node_name']="提交";
                    $pUpdate['node_name_status']="已支付";
                    $pUpdate['node_status']=3;
                    $pUpdate['recorder_status']=2;
                    $pUpdate['end_time']=time();
                }
                pdo_update("gd_pool",$pUpdate,array('id'=>$payLog['pool_id']));

                //发送模板消息
                $mMsg=json_decode($payLog['member_msg'],true);
                $sMsg=json_decode($payLog['staff_msg'],true);
                $nMsg=json_decode($payLog['sms_msg'],true);
                foreach($mMsg as $val){
                    $this->sendFlowMsg($val);
                }
                //发送客户消息
                foreach($mMsg as $val){
                    if(!empty($val['open_id'])){
                        $this->sendMsg($val['open_id'],$val['data'],$val['url']);
                    }
                }
                //发送员工消息
                foreach($sMsg as $val){
                    if(!empty($val['open_id'])){
                        $this->sendMsg($val['open_id'],$val['data'],$val['url']);
                    }
                }
            }else{
                //写入数据
                $actList=json_decode($payLog['data'],true);
                foreach($actList as $act){
                    if($act['act']=='i'){
                        pdo_insert($act['table'],$act['data']);
                    }else if($act['act']=='u'){
                        pdo_update($act['table'],$act['data'],$act['where']);
                    }
                }
                //填写who_list,去掉支付标志
                $pUpdate['need_pay']=0;
                $pUpdate['pay_money']=0;
                $pUpdate['order_id']=0;
                pdo_update("gd_pool",$pUpdate,array('id'=>$payLog['pool_id']));

                //发送模板消息
                $mMsg=json_decode($payLog['member_msg'],true);
                $sMsg=json_decode($payLog['staff_msg'],true);
                //发送客户消息
                foreach($mMsg as $val){
                    if(!empty($val['open_id'])){
                        $this->sendMsg($val['open_id'],$val['data'],$val['url']);
                    }
                }
                //发送员工消息
                foreach($sMsg as $val){
                    if(!empty($val['open_id'])){
                        $this->sendMsg($val['open_id'],$val['data'],$val['url']);
                    }
                }
                pdo_update("gd_deal",$update,array("recorder_id"=>$payLog['recorder_id'],"node_id"=>$payLog['node_id']));
            }
            //修改待提醒状态
            pdo_update("gd_remind",array("status"=>1),array("order_id"=>$payLog['id']));
        }
        if ($params['from'] == 'return') {
            $url = $this->createMobileUrl('category');
            if($appInfo['menu']==0){
                $url .="&app_id=".$appInfo['id'];
            }
            if ($params['result'] == 'success') {
                message('支付成功！',$url,'success');
            } else {
                message('支付失败！','info',$url,'error');
            }
        }
    }

    public function getNextNode($nodeId,$nodeList){
        $sortNode=array();
        foreach($nodeList as $key=> $node){
            $sortNode[$node['id']]['key']=$key;
            $sortNode[$node['id']]['id']=$node['id'];
            $sortNode[$node['id']]['name']=$node['name'];
        }
        if(isset($sortNode[$nodeId]) && isset($nodeList[$sortNode[$nodeId]['key']+1])){
            return $nodeList[$sortNode[$nodeId]['key']+1];
        }else{
            return false;
        }
    }

    //生成结帐单号
    public function createOrderSn($type="order_sn"){
        global $_W;
        $date=date("Ymd",time());
        $where['sn_name']=$type;
        $where['date']=$date;
        $where['uniacid']=$_W['uniacid'];
        $snInfo=pdo_get("gd_sn",$where);
        //初始化卡号序列
        if(empty($snInfo)){
            $insert['uniacid']=$_W['uniacid'];
            $insert['create_time']=time();
            $insert['sn_name']=$type;
            $insert['date']=$date;
            $insert['sn_no']=1;
            pdo_insert("gd_sn",$insert);
            $snInfo['sn_no']=1;
        }else{
            $update['sn_no']=intval($snInfo['sn_no'])+1;
            pdo_update("gd_sn",$update,$where);
            $snInfo['sn_no']=$update['sn_no'];
        }
        return $date.str_pad($snInfo['sn_no'],6,"0",STR_PAD_LEFT);
    }

    public function getBeforeNode($nodeId,$nodeList){
        $sortNode=array();
        foreach($nodeList as $key=> $node){
            $sortNode[$node['id']]['key']=$key;
            $sortNode[$node['id']]['id']=$node['id'];
            $sortNode[$node['id']]['name']=$node['name'];
        }
        if(isset($sortNode[$nodeId]) && isset($nodeList[$sortNode[$nodeId]['key']-1])){
            return $nodeList[$sortNode[$nodeId]['key']-1];
        }else{
            return false;
        }
    }

    public function getTablePre(){
        global $_W;
        if(empty($_W['config']['db']['master'])) {
            return $_W['config']['db']['tablepre'];
        }
        return $_W['config']['db']['master']['tablepre'];
    }


    //获取默认APp
    public function getDefaultApp($where=array()){
        global $_W;
        $where['uniacid']=$_W['uniacid'];
        return pdo_get("gd_app",$where);
    }


    public function beforeArticleList(&$where){
        global $_GPC;
        if($_GPC['title']){
            $where .= " and title like '%{$_GPC['title']}%' ";
        }
    }

    public function  articleAct(){
        global $_GPC,$_W;
        if($_GPC['in']['gone_time']){
            $_GPC['in']['gone_time']=empty($_GPC['in']['gone_time'])?0:strtotime($_GPC['in']['gone_time']);
        }
        if($_GPC['in']['is_default']){
            pdo_update("gd_article",array("is_default"=>0),array("id >"=>0,'uniacid'=>$_W['uniacid']));
        }
    }

    public function beforeFjList(&$where){
        global $_GPC;
        if(!empty($_GPC['gd_sn'])){
            $where .= " and gd_sn like '%{$_GPC['gd_sn']}%' ";
        }
        if(!empty($_GPC['name'])){
            $where .= " and name like '%{$_GPC['name']}%' ";
        }
        if(!empty($_GPC['app_id'])){
            $where .= " and app_id={$_GPC['app_id']} ";
        }
        if(!empty($_GPC['label'])){
            $where .= " and label like '%{$_GPC['label']},%' ";
        }
    }

    public function afterFjList($dataList){
        global $_W;
        //获取标签列表
        $lbs = pdo_getall("gd_lb",array("uniacid"=>$_W['uniacid']));
        $bArr=array();
        foreach($lbs as $b){
            $bArr[$b['id']]=$b['name'];
        }
        //获取应用
        $aArr=array();
        $appList = pdo_getall("gd_app",array("uniacid"=>$_W['uniacid']));
        foreach($appList as $key=>$val){
            $aArr[$val['id']]=$val['name'];
        }
        foreach($dataList as $key=>$data){
            $dataList[$key]['app_name']=isset($aArr[$data['app_id']])?$aArr[$data['app_id']]:"";
            $lb_s = explode(",",$data['label']);
            foreach($lb_s as $s){
                if(!empty($s)){
                    $dataList[$key]['label_name'].=isset($bArr[$s])? (empty($dataList[$key]['label_name']) ?$bArr[$s]:",".$bArr[$s]):"";
                }
            }
            //处理下载链接
            $urls =explode(",",$data['url']);
            $names = explode(",",$data['name']);
            foreach($names as $ky=> $n){
                $dataList[$key]['file'][$ky]['url']="/".$urls[$ky];
                $dataList[$key]['file'][$ky]['name']=$n;
            }
        }
        return array('dataList'=>$dataList,'labels'=>$lbs,'apps'=>$appList);
    }


    //更新节点信息
    public function updateNodeInfo($Node,$flowId,$type){
        global $_W;
        //写入节点信息
        $startInfo = pdo_get("gd_node",array("flow_id"=>$flowId,'xml_id'=>$Node['id']));
        //获取配置信息
        $nodeForm=pdo_get("gd_prenode",array("flow_id"=>$flowId,"node_sid"=>$Node['id']));
        if(empty($startInfo)){
            $insert['flow_id']=$flowId;
            $insert['uniacid']=$_W['uniacid'];
            $insert['name']=$Node['name'];
            $insert['sort']=0;
            $insert['create_time']=time();
            $insert['status']=0;
            $insert['who']=empty($nodeForm)?"":$nodeForm['who'];
            $insert['who_list']=empty($nodeForm)?"":$nodeForm['who_list'];
            $insert['adm_list']=empty($nodeForm)?"":$nodeForm['adm_list'];
            $insert['form_list']=empty($nodeForm)?"":$nodeForm['form_list'];
            $insert['xml_id']=$Node['id'];
            $insert['ship']=$type;
            pdo_insert("gd_node",$insert);
        }else{
            $update['name']=$Node['name'];
            $update['who']=empty($nodeForm)?"":$nodeForm['who'];
            $update['who_list']=empty($nodeForm)?"":$nodeForm['who_list'];
            $update['adm_list']=empty($nodeForm)?"":$nodeForm['adm_list'];
            $update['form_list']=empty($nodeForm)?"":$nodeForm['form_list'];
            pdo_update("gd_node",$update,array("flow_id"=>$flowId,'xml_id'=>$Node['id']));
        }
    }

    //随机名称生成
    public function file_random_name($dir, $ext){
        do {
            $filename = random(30) . '.' . $ext;
        } while (file_exists($dir . $filename));

        return $filename;
    }

    public function doWebSelectB(){
        global $_W,$_GPC;
        $lbs = pdo_getall("gd_lb",array("status"=>1,'uniacid'=>$_W['uniacid']));
        include $this->template("selectb");
    }

    /**
     * 处理上传函数
     * @param $file
     * @param string $type
     * @param string $name
     * @return array
     */
    function file_upload($file, $type = 'image', $name = '') {
        global $_W;

        $harmtype = array('asp', 'php', 'jsp', 'js', 'css', 'php3', 'php4', 'php5', 'ashx', 'aspx', 'exe', 'cgi');
        if (empty($file)) {
            return error(-1, '没有上传内容');
        }
        if (!in_array($type, array('image', 'thumb', 'voice', 'video', 'audio','fj'))) {
            return error(-2, '未知的上传类型');
        }
        $f_name=$file['name'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $ext = strtolower($ext);
        switch($type){
            case 'image':
                $allowExt = array('gif', 'jpg', 'jpeg', 'bmp', 'png', 'ico','pem');
                break;
            case 'thumb':
                $allowExt = array('gif', 'jpg', 'jpeg', 'bmp', 'png', 'ico','pem');
                $limit = 4 * 1024;
                break;
            case 'voice':
            case 'audio':
                $allowExt = array('mp3', 'wma', 'wav', 'amr','pem');
                $limit = 6 * 1024;
                break;
            case 'video':
                $allowExt = array('rm', 'rmvb', 'wmv', 'avi', 'mpg', 'mpeg', 'mp4','pem');
                $limit = 20 * 1024;
                break;
            case 'fj':
                $allowExt = array('zip','rar','doc','docx','txt','xls','xlsx','pdf','pem');
                $limit = 200 * 1024;
        }
//        if($type!='fj'){
//            $allowExt = $_W['setting']['upload'][$type];
//        }
        if (!in_array(strtolower($ext), $allowExt) || in_array(strtolower($ext), $harmtype)) {
            return error(-3, '不允许上传此类文件');
        }
        if (!empty($limit) && $limit * 1024 < filesize($file['tmp_name'])) {
            return error(-4, "上传的文件超过大小限制，请上传小于 {$limit}k 的文件");
        }
        $result = array();
        if (empty($name) || $name == 'auto') {
            $uniacid = intval($_W['uniacid']);
            $path = "{$type}s/{$uniacid}/" . date('Y/m/');
            $this->mkdirs(ATTACHMENT_ROOT . '/' . $path);
            $filename = file_random_name(ATTACHMENT_ROOT . '/' . $path, $ext);

            $result['path'] = $path . $filename;
        } else {
            $this->mkdirs(dirname(ATTACHMENT_ROOT . '/' . $name));
            if (!strexists($name, $ext)) {
                $name .= '.' . $ext;
            }
            $result['path'] = $name;
        }
        if (!$this->file_move($file['tmp_name'], ATTACHMENT_ROOT . '/' . $result['path'])) {
            return error(-1, '保存上传文件失败');
        }
        $result['name']=$f_name;
        $result['success'] = true;
        return $result;
    }

    public function mkdirs($path) {
        if (!is_dir($path)) {
            $this->mkdirs(dirname($path));
            mkdir($path);
        }
        return is_dir($path);
    }

    /**
     * 文件移动
     * @param $filename
     * @param $dest
     * @return bool
     */
    public function file_move($filename, $dest) {
        global $_W;
        $this->mkdirs(dirname($dest));
        if (is_uploaded_file($filename)) {
            move_uploaded_file($filename, $dest);
        } else {
            rename($filename, $dest);
        }
        @chmod($filename, $_W['config']['setting']['filemode']);
        return is_file($dest);
    }

    /**
     * 创建数据表
     * @param $arr
     */
    public function createTable($arr){
        global $_W;
        $tablePre=$this->getTablePre();
        $tableName=$tablePre."gd_bd".rand(10000,99999);
        $colSql="";
        foreach($arr as $val){
            $col=$val['py'];
            if($val['type']=="local"){
                $colSql .="  `".$col."` text , `lc_lat` text ,`lc_lnt` text, ";
            }else if($val['type']=="sign"){
                $colSql .="  `".$col."` text , `sig_lat` text ,`sig_lnt` text, ";
            }else if($val['type']=="pay"){
                $colSql .="  `".$col."` text , `py_time` int ,`py_money` text, ";
            }else if($val['type']=="voice"){
                $colSql .="  `".$col."` text , `voice_time` varchar(400) , ";
            }else{
                $colSql .="  `".$col."` text , ";
            }
        }
        $createSql="
            CREATE TABLE ".$tableName." (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `uniacid` int(11) NOT NULL DEFAULT '0',
              `app_id`  int(11) NOT NULL DEFAULT '0',
              ".$colSql."
              `create_time` varchar(45) NOT NULL DEFAULT '0',
              `node_id` int  DEFAULT '0',
              `node_name` varchar(300)  DEFAULT '0',
              `status_id` int  DEFAULT '0',
              `status_name` varchar(300)  DEFAULT '0',
              `do_status` int  DEFAULT '0',
              `start_time` int  DEFAULT '0',
              `member_id` int  DEFAULT '0',
              `member_name` varchar(200)  DEFAULT '',
              `is_end` int  DEFAULT '0',
              `end_time` int  DEFAULT '0',
              `pay_money` decimal(12,2)  DEFAULT '0',
              `pay_status` int  DEFAULT '0',
              `pay_sn` varchar(100)  DEFAULT '',
              `next_act` varchar(400)  DEFAULT '',
              `pay_time` int  DEFAULT 0,
              `category` int  DEFAULT 0,
              `property` int  DEFAULT 0,
              `app_pay` DECIMAL(12,1) DEFAULT 0,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";
        pdo_run($createSql);
        return $tableName;
    }

    /**
     * 添加新列
     * @param $arr
     * @param $table
     */
    public function addNewCol($arr,$table,$tbCol){
        $addCol="";
        $div="";
        foreach($arr as $val){
            $col=$val['py'];
            $div = empty($addCol) ? " " : " , ";
            if($val['type']=="local" && !isset($tbCol['lc_lat'])){
                $addCol .=" $div ADD COLUMN   `".$col."` text , ADD COLUMN  `lc_lat` text , ADD COLUMN  `lc_lnt` text ";
            }else if($val['type']=="sign" && !isset($tbCol['sig_lat'])){
                $addCol .=" $div ADD COLUMN  `".$col."` text , ADD COLUMN  `sig_lat` text , ADD COLUMN `sig_lnt` text ";
            }else if($val['type']=="pay" && !isset($tbCol['py_time'])){
                $addCol .=" $div ADD COLUMN  `".$col."` text , ADD COLUMN  `py_time` int , ADD COLUMN  `py_money` text ";
            }else if($val['type']=="voice"  && !isset($tbCol['voice_time'])){
                $addCol .=" $div ADD COLUMN  `".$col."` text , ADD COLUMN  `voice_time` varchar(400)  ";
            }else{
                $addCol .=" $div ADD COLUMN `".$col."` text  ";
            }
        }
        if(!empty($addCol)){
            $addSql="
                ALTER TABLE `".$table."`
                ".$addCol.";
            ";
            pdo_run($addSql);
        }
    }


    public function getReNode($flowId,$nodeId){
        $preInfo = pdo_get("gd_prenode",array("flow_id"=>$flowId,'node_sid'=>$nodeId));
        return $preInfo;
    }

    public function getReLine($flowId,$lineId){
        $preInfo = pdo_get("gd_preline",array("flow_id"=>$flowId,'line_id'=>$lineId));
        return $preInfo;
    }

    public function findReNode($id){
        $preInfo = pdo_get("gd_prenode",array('id'=>$id));
        return $preInfo;
    }

    /**
     * 按顺序获取节点
     * @param $id
     * @param bool $isKey
     * @return array
     */
    public function getNodeList($id,$isKey=false){
        //获取节点
        $nodeList = pdo_getall("gd_node",array('flow_id'=>$id),array(),"",array("sort asc"));
        if(!$isKey) {
            return $nodeList;
        }
        $list =array();
        foreach($nodeList as $val){
            $list[$val['id']]=$val['name'];
        }
        $nodeList =$list;
        return $nodeList;
    }


    //获取属性列表
    public function getPropertyList($isKv=false){
        global $_W;
        $result =pdo_getall("gd_property",array('uniacid'=>$_W['uniacid']));
        if(!$isKv){
            return $result;
        }
        $newPro=array();
        foreach($result as $val){
            $newPro[$val['id']]=$val['name'];
        }
        return $newPro;
    }


    public function getDepartment($kv=false){
        global $_W;
        $where['uniacid']=$_W['uniacid'];
        $where['status']=1;
        $dpList = pdo_getall("gd_department",$where);
        if(!$kv){
            return $dpList;
        }
        $fmDepartment=array();
        foreach($dpList as $val){
            $fmDepartment[$val['id']]=$val['name'];
        }
        return $fmDepartment;
    }

    //获取表单元素列表
    public function getElement(){
        global $_W;
        $where['status']=1;
        $elList = pdo_getall("gd_element",$where);
        return $elList;
    }


    //微信注册
    public function doMobileRegister(){
        global $_W;
        $subTitle="注册";
        //获取应用列表
        $appList = pdo_getall("gd_app",array("uniacid"=>$_W['uniacid']));
        $baseConfig =$this->getLang();

        $where['group']=6;
        $where['uniacid']=$_W['uniacid'];
        $memberConfig=$this->beforeSettingList($where);
        $memberInfo =  $this->initUser();
        include $this->template("register");
    }

    /**
     * 发送模板消息
     * @param $toUser
     * @param $data
     * @param string $url
     * @return bool
     */
    public function sendMsg($toUser,$data,$url=''){
        global $_W;
        $acc = $this->notice_init();
        //获取模板ID
        $where['uniacid']=$_W['uniacid'];
        $where['key']="tpl_register";
        $where['group']=2;
        $tplInfo = pdo_get("gd_setting",$where);
        if(empty($tplInfo)){
            return false;
        }
        $acc->sendTplNotice($toUser, $tplInfo['val'], $data, $url, $topcolor = '#FF683F');
    }

    function notice_init() {
        global $_W;
        if(empty($_W['account'])) {
            $_W['account'] = uni_fetch($_W['uniacid']);
        }
        if(empty($_W['account'])) {
            return error(-1, '创建公众号操作类失败');
        }
        if($_W['account']['level'] < 3) {
            return error(-1, '公众号没有经过认证，不能使用模板消息和客服消息');
        }
        $acc = WeAccount::create();
        if(is_null($acc)) {
            return error(-1, '创建公众号操作对象失败');
        }
        $setting = uni_setting();
        $noticetpl = $setting['tplnotice'];
        $acc->noticetpl = $noticetpl;
        return $acc;
    }


    public function afterMemberList(&$dataList){
        $labelList=$this->getLabelList(true);
        foreach($dataList as $key=>$val){
            $app = pdo_get("gd_app",array("id"=>$val['app_id']));
            $fans=pdo_get("mc_members",array("uid"=>$val['uid']),array("nickname","avatar"));
            $dataList[$key]['label']=isset($labelList[$val['label']])?$labelList[$val['label']]:"未分组";
            $dataList[$key]['nickname']=empty($fans['nickname'])?"":$fans['nickname'];
            $dataList[$key]['avatar']=empty($fans['avatar'])?"":$fans['avatar'];
            $dataList[$key]['app_name']=isset($app['name'])?$app['name']:"";
        }
        $data['dataList']=$dataList;
        $data['label']=$labelList;
        return $data;
    }

    //获取管理员列表
    public function getAdminList(){
        global $_W;
        $where['uniacid']=$_W['uniacid'];
        $adminList = pdo_getall("gd_admin",$where);
        return $adminList;
    }

    //获取分类
    public function getProperty($isKv=false){
        global $_W;
        $cats =pdo_getall("gd_property",array("uniacid"=>$_W['uniacid']));
        if(!$isKv){
            return $cats;
        }
        $newCat=array();
        foreach($cats as $val){
            $newCat[$val['id']]=$val['name'];
        }
        return $newCat;
    }

    public function beforeCategoryList(&$where){
        global $_GPC;
        if($_GPC['name']){
            $where .= " and name like '%{$_GPC['name']}%' ";
        }
    }

    //解析时间
    function format_date($time){
        $f = array(
            '86400'=>'天',
            '3600'=>'小时',
            '60'=>'分钟',
            '1'=>'秒'
        );
        foreach ($f as $k=>$v) {
            if (0 != $c = floor($time/(int)$k)) {
                return $c.$v;
            }
        }
    }


    function formatTime($diff) {
        $str = '';
        $day = floor($diff / 86400);
        $free = $diff % 86400;
        if($day > 0) {
            return $day."天前";
        }else{
            if($free>0){
                $hour = floor($free / 3600);
                $free = $free % 3600;
                if($hour>0){
                    return $hour."小时前";
                }else{
                    if($free>0){
                        $min = floor($free / 60);
                        $free = $free % 60;
                        if($min>0){
                            return $min."分钟前";
                        }else{
                            if($free>0){
                                return $free."秒前";
                            }else{
                                return '刚刚';
                            }
                        }
                    }else{
                        return '刚刚';
                    }
                }
            }else{
                return '刚刚';
            }
        }
    }

    //解析上传媒体,并处理
    //从服务器下载
    //如果开启云存储则保存在云上,
    //直接保存在本地
    public function media($mediaList,$isPhoto=true){
        $mediaUrl=array();
        if(empty($mediaList)){
            return "";
        }
        $token=$this->AccessToken();
        if(is_array($mediaList)){
            foreach($mediaList as $val){
                $mediaU=$this->mediaDownLoad($token,$val,$isPhoto);
                if(!empty($mediaU)){
                    $mediaUrl[]=$mediaU;
                }
            }
        }else{
            $mediaUrl= $this->mediaDownLoad($token,$mediaList,$isPhoto);
        }
        return $mediaUrl;
    }

    /**
     * 下载媒体文件保存并返回地址
     *
     * @param $mediaId
     * @param bool $isPhoto
     */
    public function mediaDownLoad($token,$mediaId,$isPhoto=true){
        if(empty($mediaId)){
            return "";
        }
        $downLoadUrl = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=$token&media_id=".$mediaId;
        $media=file_get_contents($downLoadUrl);
        $fileName=date("YmdHis").rand(1000,9999);
        $suffix=$isPhoto?".jpg":".amr";
        $fileName .=$suffix;
        $dir=$isPhoto?"gd_photo":"gd_voice";
        $fileName =$dir."/".$fileName;
        //检查是否开启云存储
        $where['group']=3;
        $setting = $this->beforeSettingList($where);
        $filePath=ATTACHMENT_ROOT.$fileName;
        //检查目录是否存在
        if(!is_dir(ATTACHMENT_ROOT.$dir)){
            @mkdir(ATTACHMENT_ROOT.$dir);
        }
        //媒体文件保存在本地
        @file_put_contents($filePath,$media);

        if($isPhoto && (empty($setting['ak_sk']) || (isset($setting['img_local']) && $setting['img_local']==1))){
            return "/attachment/".$fileName;
        }

        if(isset($setting['ak_sk']) && $setting['ak_sk']){
            require_once(IA_ROOT . '/framework/library/qiniu/autoload.php');
            $bucket=!empty($setting['bucket'])?$setting['bucket']:"yqkzy";
            $auth = new \Qiniu\Auth($setting['ak_text'], $setting['sk_text']);
            $token = $auth->uploadToken($bucket);
            $uploadMgr = new \Qiniu\Storage\UploadManager();
            $uploadMgr->putFile($token,$fileName,$filePath);
            //上传操作
            if(!$isPhoto){
                $pfop = new \Qiniu\Processing\PersistentFop($auth, $bucket);
                $yunName=str_replace("amr","mp3",$fileName);
                $fops ="avthumb/mp3/ab/192k|saveas/";
                $base64URL = Qiniu\base64_urlSafeEncode($bucket.":".$yunName);
                $fops = $fops.$base64URL;
                $pfop->execute($fileName,$fops);
                return $yunName;
            }
        }
        return $fileName;
    }

    //后台上传
    public function adminFileUpload($photo){
        //检查是否开启云存储
        $urls = $photo;
        $where['group']=3;
        $setting = $this->beforeSettingList($where);
        if(empty($setting['ak_sk']) || (isset($setting['img_local']) && $setting['img_local']==1)){
            foreach($urls as $key=>$val){
                if(!empty($val)){
                    $urls[$key]="/".$val;
                }else{
                    unset($urls[$key]);
                }
            }
            return $urls;
        }
        $imgList =array();
        $suffix=".jpg";
        if(isset($setting['ak_sk']) && $setting['ak_sk']){
            require_once(IA_ROOT . '/framework/library/qiniu/autoload.php');
            $bucket="yqkzy";
            $auth = new \Qiniu\Auth($setting['ak_text'], $setting['sk_text']);
            $token = $auth->uploadToken($bucket);
            $uploadMgr = new \Qiniu\Storage\UploadManager();
            $dir="gd_photo";
            foreach($urls as $key=>$val){
                if(!empty($val)){
                    //存储在云上
                    $fileName=date("YmdHis").rand(1000,9999);
                    $fileName .=$suffix;
                    $fileName =$dir."/".$fileName;
                    $imgList[]=$fileName;
                    $uploadMgr->putFile($token,$fileName,IA_ROOT."/".$val);
                }
            }
        }
        return $imgList;
    }

    /**
     * 下载媒体文件保存并返回地址
     *
     * @param $mediaId
     * @param bool $isPhoto
     */
    public function mediaFetch($token,$mediaId,$isPhoto=true){
        if(empty($mediaId)){
            return "";
        }
        $downLoadUrl = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=$token&media_id=".$mediaId;
        $fileName=date("YmdHis").rand(1000,9999);
        $suffix=$isPhoto?".jpg":".amr";
        $fileName .=$suffix;
        $dir=$isPhoto?"gd_photo":"gd_voice";
        $fileName =$dir."/".$fileName;
        //检查是否开启云存储
        $where['group']=3;
        $setting = $this->beforeSettingList($where);

        if(isset($setting['ak_sk']) && $setting['ak_sk']){
            require_once(IA_ROOT . '/framework/library/qiniu/autoload.php');
            $bucket="yqkzy";
            $auth = new \Qiniu\Auth($setting['ak_text'], $setting['sk_text']);
            $bucketManager = new \Qiniu\Storage\BucketManager($auth);
            $result = $bucketManager->fetch($downLoadUrl,$bucket,$fileName);
            //上传操作
            if(!$isPhoto){
                $pfop = new \Qiniu\Processing\PersistentFop($auth, $bucket);
                $yunName=str_replace("amr","mp3",$fileName);
                $fops ="avthumb/mp3/ab/192k|saveas/";
                $base64URL = Qiniu\base64_urlSafeEncode($bucket.":".$yunName);
                $fops = $fops.$base64URL;
                $pfop->execute($fileName,$fops);
                return $yunName;
            }
        }
        return $fileName;
    }

    //初始化用户信息
    public function initUser(){
        global $_W;
        //查找用户信息
        $member =$this->getMemberInfo();
        $fan = mc_fansinfo($_SESSION['openid']);
        if(empty($_SESSION['uid']) || empty($member)){
            if (intval($_W['account']['oauth']['level']) < 4) {
                $userinfo = $info =mc_fansinfo($_W['openid']);
            }else{
                $userinfo = $info = mc_oauth_userinfo();
            }
            if(empty($info)) return false;
            $fan = mc_fansinfo($_SESSION['openid']);
            if(empty($fan['uid'])){
                $default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['uniacid']));
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'email' => rand(1000,99999)."@gd.com",
                    'salt' => random(8),
                    'groupid' => $default_groupid,
                    'createtime' => TIMESTAMP,
                    'password' => md5(rand(1000,5000). $_W['config']['setting']['authkey']),
                    'nickname' => stripslashes($userinfo['nickname']),
                    'avatar' => $userinfo['headimgurl'],
                    'gender' => $userinfo['sex'],
                    'nationality' => $userinfo['country'],
                    'resideprovince' => $userinfo['province'] . '省',
                    'residecity' => $userinfo['city'] . '市',
                );
                pdo_insert('mc_members', $data);
                $uid = pdo_insertid();
                $_SESSION['uid']=$uid;
                pdo_update("mc_mapping_fans",array("uid"=>$uid),array("openid"=>$_SESSION['openid']));
            }
            //检查用户是否已经是会员
            $insert['uniacid']=$_W['uniacid'];
            $insert['name']=$info['nickname'];
            $insert['uid']=$_W['member']['uid'];
            $insert['mobile']=" ";
            $insert['open_id']=$_W['openid'];
            $insert['app_id']=0;
            $insert['create_time']=time();
            $insert['status']=1;
            $insert['is_register']=0;
            pdo_insert("gd_member",$insert);
            $insert['id']=pdo_insertid();
            $member = $insert;
        }
        //存储用户信息
        $_SESSION['member_id']=$member['id'];
        $_SESSION['member_name']=$member['name'];

        //运用选择
        $condition['group']=6;
        $condition['uniacid']=$_W['uniacid'];
        $config = $this->beforeSettingList($condition);

        //获取默认的应用作为默认
        $_SESSION['mut_app']=$config['mut_app'];
        $_SESSION['is_register']=$member['is_register'];
        $_SESSION['member_register']=$config['member_register'];
        return $member;
    }

    //初始化菜单列表
    public function beforeMenuList(&$where){
        global $_W;
        //获取系统初始化菜单
        $condition = array("sys_sort >"=>0,'uniacid'=>$_W['uniacid']);
        $menuList =pdo_getall("gd_menu",$condition);
        //默认菜单
        if(count($menuList)!=5){
            pdo_delete("gd_menu",$condition);
            //添加会员个人中心
            $insert['uniacid']=$_W['uniacid'];
            $insert['title']="我的";
            $insert['url']="/app/".$this->createMobileUrl('staff');
            $insert['select_cover']="addons/gd_zlyqk//static/new/images/footer/f4.png";
            $insert['unselect_cover']="addons/gd_zlyqk//static/new/images/footer/f4.png";
            $insert['create_time']=time();
            $insert['sort']=4;
            $insert['sys_sort']=5;
            pdo_insert("gd_menu",$insert);
            //添加员工个人中心
            $insert['uniacid']=$_W['uniacid'];
            $insert['title']="我的";
            $insert['url']="/app/".$this->createMobileUrl('member');
            $insert['select_cover']="addons/gd_zlyqk//static/new/images/footer/f4.png";
            $insert['unselect_cover']="addons/gd_zlyqk//static/new/images/footer/f4.png";
            $insert['create_time']=time();
            $insert['sort']=4;
            $insert['sys_sort']=4;
            pdo_insert("gd_menu",$insert);
            //添加工作台
            $insert['uniacid']=$_W['uniacid'];
            $insert['title']="工作台";
            $insert['url']="/app/".$this->createMobileUrl('msg');
            $insert['select_cover']="addons/gd_zlyqk//static/new/images/footer/f3.png";
            $insert['unselect_cover']="addons/gd_zlyqk//static/new/images/footer/f3.png";
            $insert['create_time']=time();
            $insert['sort']=3;
            $insert['sys_sort']=3;
            pdo_insert("gd_menu",$insert);
            //添加已提交页
            $insert['uniacid']=$_W['uniacid'];
            $insert['title']="已提交";
            $insert['url']="/app/".$this->createMobileUrl('category');
            $insert['select_cover']="addons/gd_zlyqk//static/new/images/footer/f2.png";
            $insert['unselect_cover']="addons/gd_zlyqk//static/new/images/footer/f2.png";
            $insert['create_time']=time();
            $insert['sort']=2;
            $insert['sys_sort']=2;
            pdo_insert("gd_menu",$insert);
            //添加主页
            $insert['uniacid']=$_W['uniacid'];
            $insert['title']="首页";
            $insert['url']="/app/".$this->createMobileUrl('appList');
            $insert['select_cover']="addons/gd_zlyqk//static/new/images/footer/f1.png";
            $insert['unselect_cover']="addons/gd_zlyqk//static/new/images/footer/f1.png";
            $insert['create_time']=time();
            $insert['sort']=1;
            $insert['sys_sort']=1;
            pdo_insert("gd_menu",$insert);
        }
    }

    //重置菜单
    public function doWebResetMenu(){
        global $_W;
        $condition = array('uniacid'=>$_W['uniacid']);
        pdo_delete("gd_menu",$condition);
        $this->msg['code']=1;
        $this->echoAjax();
    }

    //获取联动下级
    public function doWebGetHtml(){
        global $_W,$_GPC;
        $where = " uniacid={$_W['uniacid']} ";
        $id = intval($_GPC['id']);
        $sql=" select * from ".tablename("gd_ld")." where $where and parent_id=$id ";
        $dataList =pdo_fetchall($sql);
        if(empty($dataList)){
            $this->msg['code']=0;
            $this->echoAjax();
        }
        ob_clean();
        ob_start();
        include  $this->template("select_ll");
        $html = ob_get_contents();
        ob_clean();

        $this->msg['code']=1;
        $this->msg['parent']=$id;
        $this->msg['html']=$html;
        $this->echoAjax();
    }

    public function beforeCode_labelList(&$where){
        global $_GPC;
        if(!empty($_GPC['name'])){
            $where .= " and name like '%{$_GPC['name']}%' ";
        }
    }

    public function beforeLbList(&$where){
        global $_GPC;
        if(!empty($_GPC['name'])){
            $where .= " and name like '%{$_GPC['name']}%' ";
        }
    }

    public function doWebSelectApp(){
        global $_W;
        $dataList = pdo_getall("gd_category",array("status"=>1,'uniacid'=>$_W['uniacid']));
        foreach($dataList as $key=>$vl){
            $dataList[$key]['url']=$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=appCat&m=gd_zlyqk&id=".$vl['id'];
        }
        include $this->template("select_app");
    }

    public function afterCodeList($dataList){
        global $_W;
        $where['uniacid']=$_W['uniacid'];
        $where['status']=1;
        $labels = pdo_getall("gd_code_label",$where);
        $lArr=array();
        foreach($labels as $val){
            $lArr[$val['id']]=$val['name'];
        }
        foreach($dataList as $key=>$val){
            $dataList[$key]['label']=isset($lArr[$val['label']])?$lArr[$val['label']]:"";
        }
        $dataList['dataList']=$dataList;
        $dataList['labels']=$labels;
        return $dataList;
    }

    //导入文件
    public function doWebtbImport(){
        global $_W,$_GPC;
        if(isset($_GPC['label'])){
            if (empty($_FILES['file']['name'])) {
                $this->msg['msg']= '上传失败, 请选择要上传的文件！';
                $this->echoAjax();
            }
            if ($_FILES['file']['error'] != 0) {
                $this->msg['msg']= '上传失败, 请重试.';
                $this->echoAjax();
            }
            $file =$_FILES['file']['tmp_name'];
            $nuList = file_get_contents($file);
            $nuList=str_replace('"',"",$nuList);
            if(empty($nuList)){
                $this->msg['msg']= '上传文件为空';
                $this->echoAjax();
            }
            $importList =explode(PHP_EOL,$nuList);
            $colLen =0;
            foreach($importList as $key=>$val){
                $cols = explode(",",$val);
                $colLen = count($cols)>$colLen?count($cols):$colLen;
                $importList[$key]=$cols;
            }
            $label=$_GPC['label'];
            //检查表是否创建
            $table = $this->checkTb($label,$colLen);
            //写入数据库
            foreach($importList as $key=>$cols){
                $insert=array();
                foreach($cols as $k=> $col){
                    $ky = $k+1;
                    $insert['col_'.$ky]=$col;
                }
                if(!empty($insert['col_1'])){
                    $insert['uniacid']=$_W['uniacid'];
                    $insert['create_time']=time();
                    $table = str_replace($this->getTablePre(),"",$table);
                    pdo_insert($table,$insert);
                }
            }
            $this->msg['msg']="导入数据成功";
            $this->msg['code']=1;
            $this->echoAjax();
        }
        $where['uniacid']=$_W['uniacid'];
        $where['status']=1;
        $labels = pdo_getall("gd_code_label",$where);
        $dataList['labels']=$labels;
        include $this->template("tp_import");
    }

    public function beforeDatasList(&$where){
        global $_GPC;
        if(!empty($_GPC['name'])){
            $where .=" and name like '%{$_GPC['name']}%' ";
        }
    }

    public function doWebImt(){
        global $_W,$_GPC;
        $id =$_GPC['table'];
        $info = pdo_get("gd_datas",array("id"=>$id));
        $table = str_replace($this->getTablePre(),"",$info['tables']);
        $header = $this->getColsName($info);
        $where = " 1=1 and uniacid={$_W['uniacid']} ";
        if(!empty($_GPC['name'])){
            $wr="";
            foreach($header as $ky=>$vl){
                $wr .= empty($wr) ? " $ky like '%{$_GPC['name']}%' ": " or $ky like '%{$_GPC['name']}%' " ;
            }
            if(!empty($wr)){
                $where .= " and ($wr) ";
            }
        }
        $listRow =$this->listRow;
        $page =$this->page;
        $total = pdo_fetchcolumn("select count(*) from ".tablename($table)." where $where");
        $totalPage=ceil($total/$listRow);
        $sql = "select * from ".tablename($table). " where ".$where." order by id desc limit ".($this->page-1)*10 ." , ".$this->listRow;
        $dataList =pdo_fetchall($sql);
        include $this->template("imt");
    }

    public function doWebImtDel(){
        global $_GPC;
        $id = $_GPC['id'];
        $tb = $_GPC['table'];
        $info = pdo_get("gd_datas",array("id"=>$tb));
        $table = str_replace($this->getTablePre(),"",$info['tables']);
        if(strstr($id,",")){
            $ids = explode(",",$id);
            foreach($ids as $id){
                if(empty($id)){
                    continue;
                }
                pdo_delete($table,array("id"=>$id));
            }
            $this->msg['code']=1;
            $this->msg['msg']="删除成功";
            $this->echoAjax();
        }
        pdo_delete($table,array("id"=>$id));
        $this->msg['code']=1;
        $this->msg['msg']="删除成功";
        $this->echoAjax();
    }

    public function getColsName($info){
        $config =json_decode($info['config'],true);
        $outArr=array();
        $config =$config['config'];
        foreach($config as $key=>$val){
            $outArr["col_".$key]=$val['name'];
        }
        return $outArr;
    }


    public function doWebSelectData(){
        global $_W;
        $dataList = pdo_getall("gd_datas",array("uniacid"=>$_W['uniacid']));
        include $this->template("select_data");
    }

    //获取数据
    public function doMobileGetData(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        $class = $_GPC['class'];
        $kws = $_GPC['val'];
        //获取表信息
        $dataList=array();
        if(!empty($kws)){
            $table = pdo_get("gd_datas",array("id"=>$id));
            if(!empty($table)){
                $tb = $table['tables'];
                $config = json_decode($table['config'],true);
                $header = $this->getColsName($table);
                $search = $config['search'];
                $where = " uniacid={$_W['uniacid']} ";
                if(!empty($search)){
                    $we="";
                    foreach($search as $ke){
                        $we .= empty($we)?" $ke like '%{$kws}%' ":" or $ke like '%{$kws}%' ";
                    }
                    $where .= " and ($we) ";
                }
                $isShow = $this->parseCols($config);
                $show = $config['show'];
                $dataList = pdo_fetchall("select * from ".$tb." where $where");
                if(count($dataList)==1){
                    include $this->template("get_data");
                }
            }
        }
    }

    //获取数据
    public function doMobileGetData1(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        $kws = $_GPC['val'];
        //获取表信息
        $dataList=array();
        if(!empty($kws)){
            $table = pdo_get("gd_datas",array("id"=>$id));
            if(!empty($table)){
                $tb = $table['tables'];
                $config = json_decode($table['config'],true);
                $header = $this->getColsName($table);
                $search = $config['search'];
                $where = " uniacid={$_W['uniacid']} ";
                if(!empty($search)){
                    $we="";
                    foreach($search as $ke){
                        $we .= empty($we)?" $ke like '%{$kws}%' ":" or $ke like '%{$kws}%' ";
                    }
                    $where .= " and ($we) ";
                }
                $dataList = pdo_fetchall("select * from ".$tb." where $where");
                if(count($dataList)==1){
                  $this->msg['code']=1;
                  $data=$dataList[0];
                  $show = $config['show'];
                  $str="";
                  foreach($show as $key=>$val){
                    $str .=$header[$val]."=".$data[$val]."#";
                  }
                  $this->msg['data']=$str;
                  $this->msg['discount']=!empty($data['col_3'])?$data['col_3']:1;
                    $this->echoAjax();
                }
            }
        }
        $this->msg['code']=0;
        $this->echoAjax();
    }

    public function parseCols($config){
        if(isset($config['config']['adm']) && $config['config']['adm']==1 ){
            $adminInfo = $this->isAdmin();
            if(!empty($adminInfo) && $adminInfo['organize']==2){
                return true;
            }else{
                return false;
            }
        }else{
           return true;
        }
    }

    public function doWebTConf(){
        global $_GPC;
        $id =$_GPC['id'];
        if($this->isAjax){
            $search=array();
            $show=array();
            $configs = $_GPC['cnf'];
            if(isset($configs['adm'])){
                $configs['adm']=1;
            }else{
                $configs['adm']=0;
            }
            foreach($configs as $key=>$config){
                if(isset($config['search'])){
                    $configs[$key]['search']=1;
                    $search[]="col_".$key;
                }else{
                    $configs[$key]['search']=0;
                }
                if(isset($config['show'])){
                    $configs[$key]['show']=1;
                    $show[]="col_".$key;
                }else{
                    $configs[$key]['show']=0;
                }
            }
            $cnf['config']=$configs;
            $cnf['show']=$show;
            $cnf['search']=$search;
            pdo_update("gd_datas",array("config"=>json_encode($cnf)),array("id"=>$id));
            $this->msg['code']=1;
            $this->msg['msg']="配置成功";
            $this->echoAjax();
        }
        //获取表信息
        $info = pdo_get("gd_datas",array("id"=>$id));
        $config = json_decode($info['config'],true);
        $cnf = isset($config['config'])?$config['config']:array();
        $cols = pdo_fetchallfields($info['tables']);
        $len=count($cols)-4;
        include $this->template("t_conf");
    }

    //检查导入的表是否存在
    public function checkTb($id,$len){
        $colSql="";
        $addCol="";
        $data = pdo_get("gd_datas",array("id"=>$id));
        //如果表名称空，需要创建表
        if(empty($data['tables'])){
            $tableName = $this->getTablePre()."gd_data".rand(1000,9999);
            for($i=1;$i<=$len;$i++){
                $colSql .="  `col_".$i."` text , ";
            }
            $createSql="
                CREATE TABLE ".$tableName." (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `uniacid` int(11) NOT NULL DEFAULT '0',
                  ".$colSql."
                  `status` int  DEFAULT '1',
                  `create_time` varchar(45) NOT NULL DEFAULT '0',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            ";
            pdo_run($createSql);
            pdo_update("gd_datas",array("tables"=>$tableName),array("id"=>$id));
            return $tableName;
        }else{
            $tabCol=array();
            $cols= pdo_fetchallfields($data['tables']);;
            foreach($cols as $vl){
                $tabCol[$vl]=$vl;
            }
            for($i=1;$i<=$len;$i++){
                if(!isset($tabCol['col_'.$i])){
                    $div = empty($addCol) ? " " : " , ";
                    $addCol .=" $div ADD COLUMN `".'col_'.$i."` text  ";
                }
            }
            $addSql="
                ALTER TABLE `".$data['tables']."`
                ".$addCol.";
            ";
            pdo_run($addSql);
            return $data['tables'];
        }
    }


    //导入文件
    public function doWebImport(){
        global $_W,$_GPC;
        if(isset($_GPC['label'])){
            if (empty($_FILES['file']['name'])) {
                $this->msg['msg']= '上传失败, 请选择要上传的文件！';
                $this->echoAjax();
            }
            if ($_FILES['file']['error'] != 0) {
                $this->msg['msg']= '上传失败, 请重试.';
                $this->echoAjax();
            }
            $file =$_FILES['file']['tmp_name'];
            $nuList = file_get_contents($file);
            $nuList=str_replace('"',"",$nuList);
            if(empty($nuList)){
                $this->msg['msg']= '上传文件为空';
                $this->echoAjax();
            }
            $goodSn =array();
            $badSn = array();
            $numList =explode(PHP_EOL,$nuList);
            foreach($numList as $key=>$value){
                $sn = trim($value);
                if(empty($sn)) continue;
                //检查卡号是否重复
                $have = pdo_get("gd_code",array("sn"=>$sn));
                if(!empty($have)){
                    $badSn[]=$sn;
                }else{
                    $goodSn[]=$sn;
                }
            }
            if(!empty($badSn)){
                $this->msg['msg']="序列号重复";
                $this->msg['data']=implode(',',$badSn);
                $this->echoAjax();
            }
            $label=$_GPC['label'];
            $time =time();
            foreach($goodSn as $val){
                $item=array();
                $item['uniacid']=$_W['uniacid'];
                $item['sn']=$val;
                $item['label']=$label;
                $item['create_time']=$time;
                if(!pdo_insert("gd_code",$item)){
                    $this->msg['msg']="导入数据失败";
                    $this->msg['data']=count($goodSn);
                    $this->msg['code']=1;
                    $this->echoAjax();
                }
            }
            $this->msg['msg']="导入数据成功";
            $this->msg['data']=count($goodSn);
            $this->msg['code']=1;
            $this->echoAjax();
        }
        $where['uniacid']=$_W['uniacid'];
        $where['status']=1;
        $labels = pdo_getall("gd_code_label",$where);
        $dataList['labels']=$labels;
        include $this->template("import");
    }

    //发放记录
    public function beforeCodeList(&$where){
        global $_GPC;
        if(!empty($_GPC['sn'])){
            $where .=" and sn like '%{$_GPC['sn']}%' ";
        }
        if(!isset($_GPC['status'])){
            $_GPC['status']=-1;
        }
        if($_GPC['status']!=-1){
            $where .= " and status={$_GPC['status']} ";
        }
        if(!empty($_GPC['label'])){
            $where .=" and label={$_GPC['label']} ";
        }
    }

    //获取可以菜单
    public function getWxMenu(){
        global $_W;
        $isAdmin = $this->isAdmin();
        $have = pdo_getall("gd_menu",array('uniacid'=>$_W['uniacid']));
        $no="";
        if(empty($have)){
            $this->beforeMenuList($no);
        }
        if($isAdmin){
            $where= " and sys_sort !=4 ";
        }else{
            $where= " and sys_sort !=5 and sys_sort !=3 ";
        }
        $muList= pdo_fetchall("select * from ".tablename("gd_menu")." where uniacid={$_W['uniacid']} and status=1  $where order by sort asc limit 5");
        return $muList;
    }

    //红包证书设置
    public function doWebHbSet(){
        global $_GPC,$_W;
        $uniacid =$_W['uniacid'];
        $zhList = pdo_get("gd_hbset",array('uniacid'=>$uniacid));
        if($this->isAjax){
            $data=$_GPC['in'];
            $ca ="none";
            $key =(!empty($data['key']) && file_exists(IA_ROOT."/".$data['key']))?file_get_contents(IA_ROOT."/".$data['key']):"";
            $cert =(!empty($data['cert']) && file_exists(IA_ROOT."/".$data['cert']))?file_get_contents(IA_ROOT."/".$data['cert']):"";
            if(empty($zhList)){
                $insert['ca']=$ca;
                $insert['key']=$key;
                $insert['cert']=$cert;
                $insert['create_time']=time();
                $insert['uniacid']=$uniacid;
                pdo_insert("gd_hbset",$insert);
            }else{
                $update['key']=$key;
                $update['cert']=$cert;
                pdo_update("gd_hbset",$update,array('uniacid'=>$uniacid));
            }
            $this->msg['code']=1;
            $this->msg['msg']="保存成功";
            $this->echoAjax();
        }
        include $this->template("hb_set");
    }

    //获取用户信息
    public function getMemberInfo(){
        global $_W;
        $where['open_id']=$_W['openid'];
        $where['uniacid']=$_W['uniacid'];
        $member = pdo_get("gd_member",$where);
        return $member;
    }

    #获取access_token
    public function AccessToken(){
        global $_W;
        $acid 	= $_W['acid'];
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($acid);
        $access_token = $accObj->fetch_token();
        return $access_token;
    }

    //解析整理表单
    public function parseForm($msgList,$appInfo){
        global $_GPC,$_W;
        $inputArr=array();
        $labInput=array();
        $isAdmin =false;
        if(isset($_GPC['m_id'])){
            $isAdmin =true;
            $adminInfo =$this->getAdminInfo($_GPC['m_id']);
            $memberInfo = $this->findMemberInfo();
        }else{
            $adminInfo =array();
            $memberInfo =$this->getMemberInfo();
            if($memberInfo['admin_id']>0){
                $isAdmin = true;
                $adminInfo =$this->isAdmin();
            }
        }
        //获取配置文件
        $cWhere['group']=3;
        $setting = $this->beforeSettingList($cWhere);

        //分析表数据结构
        $filedSource=pdo_get("gd_source_form",array("app_id"=>$appInfo['id']));
        if(empty($filedSource)){
            message("表单未找到",$this->createMobileUrl('member'),'info');
        }
        $filed=json_decode($filedSource['source'],true);
        foreach($filed as $key=>$val){
            $inputArr[$val['py']]=$val;
        }
        $payCtl=0;
        $isAudio=0;
        foreach($msgList as $key=>$rd){
            //获取数据提交者的身份
            $aInfo =$this->memberIsAdmin($rd['member_id']);
            foreach($rd as $fd=>$vl){
                if(!empty($inputArr[$fd]['label']) && $inputArr[$fd]['type']!="label" && $inputArr[$fd]['type']!="url" && $inputArr[$fd]['type']!="lastdate" && $inputArr[$fd]['type']!="remind" ){
                    if($this->checkShow($rd['member_id'],$inputArr[$fd]['see'],$isAdmin,$adminInfo,$memberInfo,$aInfo)){
                        $labInput[$key][$fd]['type']=$inputArr[$fd]['type'];
                        $labInput[$key][$fd]['name']=$inputArr[$fd]['label'];
                        if($inputArr[$fd]['type']=='time'){
                            $labInput[$key][$fd]['val']=date("Y-m-d H:i:s",strtotime($vl));
                        }else if($inputArr[$fd]['type']=='doadm'){
                            $adminInfo = pdo_get("gd_admin",array("id"=>$vl));
                            $labInput[$key][$fd]['val']=empty($adminInfo)?$vl:$adminInfo['name'];
                        }else if($inputArr[$fd]['type']=='textarea'){
                            $labInput[$key][$fd]['val']=$vl;
                        }else if($inputArr[$fd]['type']=='child'){
                            $vlExp =explode("|",$vl);
                            $outFm=array();
                            foreach($vlExp as $valss){
                                $list=explode("=",$valss);
                                if(!empty($list[0]) && !empty($list[1])){
                                    $outFm[]=array("key"=>$list[0],"value"=>$list[1]);
                                }
                            }
                            $labInput[$key][$fd]['val']=$outFm;
                        }else if(in_array($inputArr[$fd]['type'],array('radio','select'))){
                            if(in_array($inputArr[$fd]['type'],array("radio","select"))){
                                $labInput[$key][$fd]['val']=$vl;
                            }else{
                                $labInput[$key][$fd]['val']=$vl;
                            }
                        }else if($inputArr[$fd]['type']=='photo'){
                            $imgList=json_decode($vl,true);
                            foreach($imgList as $keys=> $img){
                                if(strpos($img, "/") != 0){
                                    $imgList[$keys]=$setting['niu_url']."/".$img;
                                }else{
                                    $imgList[$keys]=$_W['siteroot'].$img;
                                }
                            }
                            $labInput[$key][$fd]['img']=$imgList;
                        }else if($inputArr[$fd]['type']=='voice'){
                            $labInput[$key][$fd]['val']=$vl;
                            $isAudio=1;
                        }else if($inputArr[$fd]['type']=='search'){
                            $arr =explode("#",$vl);
                            $if =array_pop($arr);
                            $if = explode("=",$if);
                            $tbId = isset($if[1])?$if[1]:0;
                            $info = pdo_get("gd_datas",array("id"=>$tbId));
                            $conf =isset($info['config'])?json_decode($info['config'],true):array();
                            $isShow =$this->parseCols($conf);
                            foreach($arr as $k=>$v){
                                if($k==0){
                                    $arr[$k]=explode("=",$v);
                                    $arr[$k]['show']=true;
                                }else{
                                    $arr[$k]=explode("=",$v);
                                    $arr[$k]['show']=$isShow;
                                }
                            }
                            $labInput[$key][$fd]['val']=$arr;
                        }else if($inputArr[$fd]['type']=='local'){
                            $labInput[$key][$fd]['lat']=$rd['lc_lat'];
                            $labInput[$key][$fd]['lnt']=$rd['lc_lnt'];
                            $labInput[$key][$fd]['val']=$vl;
                        }else if($inputArr[$fd]['type']=='sms'){
                            $labInput[$key][$fd]['name']="手机号";
                            $labInput[$key][$fd]['val']=$vl;
                        }else if($inputArr[$fd]['type']=='mobile'){
                            $labInput[$key][$fd]['name']=$inputArr[$fd]['label'];;
                            $labInput[$key][$fd]['val']='<a class="mobi" href="tel:'.$vl.'">'.$vl.'</a>';
                        }else if($inputArr[$fd]['type']=='file'){
                            $aStr="";
                            //获取附件名称
                            $addon = pdo_get("gd_fj",array("url"=>$vl));
                            $nameList =explode(",",$addon['name']);
                            $urlList = explode(",",$addon['url']);
                            foreach($nameList as $k=>$nm){
                                $aStr .= "<a target='_blank' href='/".$urlList[$k]."'>".$nm."</a>&nbsp;&nbsp;";
                            }
                            $labInput[$key][$fd]['val']=$aStr;
                        }else if($inputArr[$fd]['type']=='pay'){
                            $payCtl =1;
                            if($rd['need_pay']!=0){
                                if($rd['need_pay']==-1){
                                    $labInput[$key][$fd]['val']="支付成功";
                                }else if($rd['need_pay']==1){
                                    $labInput[$key][$fd]['val']="未支付";
                                }
                                $labInput[$key][$fd]['type']='pay';
                                $labInput[$key][$fd]['name']="支付状态";
                            }
                        }else{
                            $labInput[$key][$fd]['val']=$vl;
                        }

                    }
                }
            }
            $labInput[$key]['create_time']['val']=date("Y-m-d H:i:s",$rd['create_time']);
            $labInput[$key]['create_time']['name']="提交时间";
        }
        $result =array(
            "isAudio"=>$isAudio,
            "payCtl"=>$payCtl,
            "labInput"=>$labInput,
        );
        return $result;
    }

    //后台错误显示
    public function wMessage($msg,$type='error'){
        include $this->template("message");
        exit;
    }

    //检查是否可以显示
    public function checkShow($memberId,$see,$isAdmin,$adminInfo,$memberInfo,$aInfo){
        if($memberId==$memberInfo['id'] || $see==0 || empty($see)){
            return true;
        }else if($see==1 && $isAdmin){
            return true;
        }else if($see==2 && $isAdmin && !empty($aInfo) && $adminInfo['department']==$aInfo['department']){
            return true;
        }else if($see==3 && $adminInfo['organize']==2){
            return true;
        }
        false;
    }

    //检查用户是否是管理
    public function memberIsAdmin($id){
        $memberInfo = pdo_fetch("select department,organize from ".tablename("gd_member")." as m left join ".tablename("gd_admin")."as a on a.id=m.admin_id where m.id=$id ");
        if(empty($memberInfo) || empty($memberInfo['organize'])){
            return false;
        }
        return $memberInfo;
    }

    public function beforeLabelList(&$where){
        global $_GPC;
        if(!empty($_GPC['name'])){
            $where .=" and label_name like '%{$_GPC['name']}%' ";
        }
    }

    public function beforeFlowList(&$where){
        global $_GPC;
        if(!empty($_GPC['name'])){
            $where .=" and name like '%{$_GPC['name']}%' ";
        }
    }

    public function beforeAccList(&$where){
        global $_GPC;
        if(!empty($_GPC['name'])){
            $where .=" and acc_name like '%{$_GPC['name']}%' ";
        }
    }

    public function beforeSubmitLabelAdd($info){
        global $_W;
        //检查是否重复名称
        if(pdo_get("gd_label",array("label_name"=>$info['label_name'],'uniacid'=>$_W['uniacid']))){
            $this->msg['msg']="组名重复";
            $this->echoAjax();
        }
    }

    public function beforeSubmitCategoryAdd($info){
        global $_W;
        //检查是否重复名称
        if(pdo_get("gd_category",array("name"=>$info['name'],'uniacid'=>$_W['uniacid']))){
            $this->msg['msg']="分类名已存在";
            $this->echoAjax();
        }
    }

    public function beforeSubmitDepartmentAdd($info){
        global $_W;
        //检查是否重复名称
        if(pdo_get("gd_department",array("name"=>$info['name'],'uniacid'=>$_W['uniacid']))){
            $this->msg['msg']="部门已存在";
            $this->echoAjax();
        }
    }

    public function beforeSubmitAppAdd($info){
        global $_W;
        //检查是否重复名称
        if(pdo_get("gd_app",array("name"=>$info['name'],'uniacid'=>$_W['uniacid']))){
            $this->msg['msg']="应用名已经存在";
            $this->echoAjax();
        }
    }

    public function beforeSubmitAccAdd($info){
        global $_W;
        //检查是否重复名称
        if(pdo_get("gd_acc",array("acc_name"=>$info['acc_name'],'uniacid'=>$_W['uniacid']))){
            $this->msg['msg']="权限名已存在";
            $this->echoAjax();
        }
    }

    //解析整理表单
    public function parseAcForm($msgList,$nodeId){
        global $_GPC,$_W;
        $labCom=array();
        $inputArr=array();
        $labInput=array();
        $isAdmin =false;
        if(isset($_GPC['m_id'])){
            $isAdmin =true;
            $adminInfo =$this->getAdminInfo($_GPC['m_id']);
            $memberInfo = $this->findMemberInfo();
        }else{
            $adminInfo =array();
            $memberInfo =$this->getMemberInfo();
            if($memberInfo['admin_id']>0){
                $isAdmin = true;
                $adminInfo =$this->isAdmin();
            }
        }
        //获取配置文件
        $cWhere['group']=3;
        $isAudio=0;
        $setting = $this->beforeSettingList($cWhere);
        foreach($msgList as $key=>$rd){
            $rs=$rd;
            //获取数据提交者的身份
            $aInfo =$this->memberIsAdmin($rd['member_id']);
            //分析表数据结构
            $filedSource=pdo_get("gd_node",array("id"=>$rd['node_id']));
            $filed=json_decode($filedSource['form_list'],true);

            $lineInfo = pdo_get("gd_preline",array("flow_id"=>$rd['flow_id'],'line_id'=>$rd['line_id']));
            if(!empty($lineInfo) && !empty($lineInfo['form_list'])){
                $filed=json_decode($lineInfo['form_list'],true);
            }
            foreach($filed as $keys=>$val){
                if(empty($val['label'])){
                    unset($filed[$keys]);
                }
            }
            foreach($filed as $val){
                $inputArr[$val['py']]=$val;
            }
            $rd=json_decode($rd['deal_msg'],true);
            foreach($rd as $fd=>$vl){
                if((!empty($inputArr[$fd]['label']) || $fd=='address')  && $inputArr[$fd]['type']!="label"){
                    if($this->checkShow($rs['member_id'],$inputArr[$fd]['see'],$isAdmin,$adminInfo,$memberInfo,$aInfo)){
                        if($inputArr[$fd]['type']=='time'){
                            $labInput[$key][$fd]['val']=date("Y-m-d H:i:s",strtotime($vl));
                        }else if($inputArr[$fd]['type']=='doadm'){
                            $adminInfo = pdo_get("gd_admin",array("id"=>$vl));
                            $labInput[$key][$fd]['val']=empty($adminInfo)?$vl:$adminInfo['name'];
                        }else if($inputArr[$fd]['type']=='textarea'){
                            $labInput[$key][$fd]['val']=$vl;
                        }else if($inputArr[$fd]['type']=='child'){
                            $vlExp =explode("|",$vl);
                            $outFm=array();
                            foreach($vlExp as $valss){
                                $list=explode("=",$valss);
                                if(!empty($list[0]) && !empty($list[1])){
                                    $outFm[]=array("key"=>$list[0],"value"=>$list[1]);
                                }
                            }
                            $labInput[$key][$fd]['val']=$outFm;
                        }else if(in_array($inputArr[$fd]['type'],array('radio','select'))){
                            if(in_array($inputArr[$fd]['type'],array("radio","select"))){
                                $lbArr=explode(",",$inputArr[$fd]['pl']);
                                $labInput[$key][$fd]['val']=isset($lbArr[$vl])?$lbArr[$vl]:$vl;
                            }else{
                                $labInput[$key][$fd]['val']=$vl;
                            }
                        }else if($inputArr[$fd]['type']=='search'){
                            $arr =explode("#",$vl);
                            $if =array_pop($arr);
                            $if = explode("=",$if);
                            $tbId = isset($if[1])?$if[1]:0;
                            $info = pdo_get("gd_datas",array("id"=>$tbId));
                            $conf =isset($info['config'])?json_decode($info['config'],true):array();
                            $isShow =$this->parseCols($conf);
                            foreach($arr as $k=>$v){
                                if($k==0){
                                    $arr[$k]=explode("=",$v);
                                    $arr[$k]['show']=true;
                                }else{
                                    $arr[$k]=explode("=",$v);
                                    $arr[$k]['show']=$isShow;
                                }
                            }
                            $labInput[$key][$fd]['val']=$arr;
                        }else if($inputArr[$fd]['type']=='photo'){
                            $imgList=json_decode($vl,true);
                            foreach($imgList as $keys=> $img){
                                if(strpos($img, "/") != 0){
                                    $imgList[$keys]=$setting['niu_url']."/".$img;
                                }else{
                                    $imgList[$keys]=$_W['siteroot'].$img;
                                }
                            }
                            $labInput[$key][$fd]['img']=$imgList;
                        }else if($inputArr[$fd]['type']=='voice'){
                            $isAudio=1;
                            $labInput[$key][$fd]['val']=$vl;
                        }else if($inputArr[$fd]['type']=='sms'){
                            $labInput[$key][$fd]['name']="手机号";
                            $labInput[$key][$fd]['val']=$vl;
                        }else if($inputArr[$fd]['type']=='mobile'){
                            $labInput[$key][$fd]['name']=$inputArr[$fd]['label'];;
                            $labInput[$key][$fd]['val']='<a class="mobi" href="tel:'.$vl.'">'.$vl.'</a>';
                        }else if($inputArr[$fd]['type']=='file'){
                            $aStr="";
                            //获取附件名称
                            $addon = pdo_get("gd_fj",array("url"=>$vl));
                            $nameList =explode(",",$addon['name']);
                            $urlList = explode(",",$addon['url']);
                            foreach($nameList as $k=>$nm){
                                $aStr .= "<a target='_blank' href='/".$urlList[$k]."'>".$nm."</a>&nbsp;&nbsp;";
                            }
                            $labInput[$key][$fd]['val']=$aStr;
                        }else if($fd=='address'){
                            $labInput[$key][$fd]['lat']=$vl['lc_lat'];
                            $labInput[$key][$fd]['lnt']=$vl['lc_lnt'];
                            $labInput[$key][$fd]['val']=$vl['value'];
                            $labInput[$key][$fd]['type']=$inputArr[$vl['name']]['type'];
                            $labInput[$key][$fd]['name']=$inputArr[$vl['name']]['label'];

                        }else{
                            $labInput[$key][$fd]['val']=$vl;
                        }
                        if($fd!='address'){
                            $labInput[$key][$fd]['type']=$inputArr[$fd]['type'];
                            $labInput[$key][$fd]['name']=$inputArr[$fd]['label'];
                        }
                    }
                }
            }
            $labCom[$key]['create_time']=date("Y-m-d H:i:s",$rs['deal_time']);
            $labCom[$key]['member_name']=$rs['member_name'];
            $labCom[$key]['node_name']=$filedSource['name'];
            $labCom[$key]['status_name']=$rs['status_name'];
        }
        return array(
            "isAudio"=>$isAudio,
            "labInputAc"=>$labInput,
            "labComAc"=>$labCom,
        );
    }

    public function doMobileAppQr(){
        global $_GPC,$_W;
        $id = $_GPC['app'];
        $staff= $_GPC['admin'];
        $url = $_W['siteroot']."app/".$this->createMobileUrl('index',array("app_id"=>$id,'admin'=>$staff));
        require(IA_ROOT . '/framework/library/qrcode/phpqrcode.php');
        $errorCorrectionLevel = "L";
        $matrixPointSize = "9";
        QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize);
        exit();
    }

    public function sumMsg(){
        global $_W;
        $uid =$_W['member']['uid'];
        $memberInfo =$this->getMemberInfo();
        $total=array(0=>0,1=>0,2=>0,3=>0);
        foreach($total as $key=>$val){
            $sql = "select count(id) as total from ".tablename("gd_pool")." where uid=$uid and recorder_status=$key ";
            $total[$key] = pdo_fetchcolumn($sql);
        }
        return $total;
    }

    public function saveExtInfo($post,$memberInfo,$config){
        global $_W;
        //获取表单数据
        $where['uniacid']=$_W['uniacid'];
        $where['member_id']=$memberInfo['id'];
        if(isset($config['ext_member']) && $config['ext_member']==1){
            if(isset($config['member_step']) && $config['member_step']==0){
                $list = pdo_getall("gd_member_ext",array("uniacid"=>$_W['uniacid']));
                foreach($list as $val){
                    $data=array();
                    $table=str_replace($this->getTablePre(),"",$val['table']);
                    $cols=json_decode($val['xml'],true);
                    foreach($cols as $col){
                        $data[$col['py']]=$post[$col['py']];
                    }
                    //检查数据是否存在
                    if(pdo_get($table,$where)){
                        pdo_update($table,$data,$where);
                    }else{
                        $data['member_id']=$memberInfo['id'];
                        $data['create_time']=time();
                        $data['uniacid']=$_W['uniacid'];
                        pdo_insert($table,$data);
                    }
                }
            }
        }
    }

    //获取扩展列
    public function extList(){
        $cols=array();
        $extlist = pdo_getall("gd_member_ext",array("id >"=>0));
        foreach($extlist as $ext){
            $colArr=json_decode($ext['xml'],true);
            foreach ($colArr as $item){
                $cols[$item['py']]=$item['label'];
            }
        }
        $str="";
        foreach($cols as $key=>$vl){
            $str .="<option value='{$key}'>{$vl}</option>";
        }
        return $str;
    }

    public function doWebExtIn(){
        global $_GPC;
        $id =$_GPC['id'];
        $list = pdo_getall("gd_member_ext",array("id >"=>0));
        $cols=array();
        foreach($list as $info){
            $colsArr=json_decode($info['xml'],true);
            foreach($colsArr as $col){
                $cols[$col['py']]=$col['label'];
            }
            $table=$info['table'];
            $ext = pdo_get($table,array("member_id"=>$id));
            if(!empty($extInfo)){
                $extInfo = array_merge($extInfo,$ext);
            }else{
                $extInfo = $ext;
            }
        }
        include $this->template("ext_info");
    }

    //解析坐标
    public function parseRegisterInfo(){
        global $_W;
        $list = pdo_getall("gd_member_ext",array("uniacid"=>$_W['uniacid']));
        $memberInfo = $this->getMemberInfo();
        $extInfo=array();
        foreach($list as $val){
            $cols =json_decode($val['xml'],true);
            //用户已经填写的信息
            $table=str_replace($this->getTablePre(),"",$val['table']);
            $where['uniacid']=$_W['uniacid'];
            $where['member_id']=$memberInfo['id'];
            $info =pdo_get($table,$where);
            $extInfo[$table]['vl']=$info;
            $extInfo[$table]['html']=$this->createRegisterForm($cols);
        }
        return $extInfo;
    }

    //解析节点状态
    public function parseNode($outGoing,$tasks,$lines,$nodeId){
        $statusLine =array();
        if(is_array($outGoing)){
            foreach($outGoing as $ts){
                if(isset($lines[$ts])){
                   $this->parseNodeStatus($lines[$ts],$tasks,$lines,$nodeId);
                }
            }
        }else{
            $this->parseNodeStatus($lines[$outGoing],$tasks,$lines,$nodeId);
        }
    }

    //解析线路状态
    public function parseNodeStatus($line,$tasks,$lines,$nodeId){
        $finaLine=array();
        foreach($tasks as $val){
            if(isset($val['default']) && !empty($val['default'])){
                $finaLine[]=$val['default'];
            }
        }
        $target=$line['targetRef'];
        if(strstr($target,"ExclusiveGateway_")){
            $excTask=$tasks[$target];
            $outGoing=$excTask['outgoing'];
            if(is_array($outGoing)){
                foreach($outGoing as $val){
                    $this->parseNodeStatus($lines[$val],$tasks,$lines,$nodeId);
                }
            }else{
                $this->parseNodeStatus($lines[$outGoing],$tasks,$lines,$nodeId);
            }
        }else if(strstr($target,"EndEvent_")){
            $item['act']=in_array($line['id'],$finaLine)?1:0;
            $item['id']=$line['id'];
            $item['node_id']=$nodeId;
            $item['name']=$line['name'];
            $this->statusLine[]=$item;
        }else{
            $item['act']=2;
            $item['id']=$line['id'];
            $item['node_id']=$nodeId;
            $item['name']=$line['name'];
            $this->statusLine[]=$item;
        }
    }

    public function beforeAppList(&$where){
        global $_GPC;
        if($_GPC['name']){
            $where .= " and name like '%{$_GPC['name']}%' ";
        }
    }

    public function staffExtAct(){
        global $_GPC,$_W;
        if($this->isAjax){
            $info =$_GPC['in'];
            //获取信息
            $inInfo = pdo_get("gd_staffext",array('id'=>$info['id']));
            $memberInfo = pdo_get("gd_member",array("id"=>$inInfo['member_id']));
            $adminInfo = pdo_get("gd_admin",array("uid"=>$memberInfo['uid']));
            if(!empty($adminInfo)){
                $this->msg['msg']="已是员工,无需入驻";
                $this->echoAjax();
            }
            if(empty($inInfo)){
                $this->msg['msg']="非法数据";
                $this->echoAjax();
            }
            $insert['uniacid']=$_W['uniacid'];
            $insert['name']=$inInfo['name'];
            $insert['mobile']=$inInfo['mobile'];
            $insert['password']=$inInfo['mobile'];
            $insert['organize']=$info['job'];
            $insert['status']=$info['status'];
            $insert['create_time']=time();
            $insert['is_bind']=1;
            $insert['open_id']=$memberInfo['open_id'];
            $insert['uid']=$memberInfo['uid'];
            $insert['department']=$info['dp'];
            if(pdo_insert("gd_admin",$insert)){
                //更新注册记录
                $insertId =pdo_insertid();
                pdo_update("gd_staffext",array("pass"=>1),array("id"=>$info['id']));
                //更新会员信息
                pdo_update("gd_member",array("admin_id"=>$insertId,'name'=>$insert['name'],'mobile'=>$insert['mobile']),array("id"=>$memberInfo['id']));
                $this->msg['msg']="审核通过";
                $this->msg['code']=1;
                $this->echoAjax();
            }
            $this->msg['msg']="审核失败";
            $this->echoAjax();
        }
        $dpList =$this->getDepartment();
        $data['dp']=$dpList;
        return $data;
    }

    //获取地理位置
    public function doWebSelectMap(){
        include $this->template("select_map");
    }

    public function afterAppList(&$dataList){
        global $_W;
        //获取发流程列表
        $flowList= $this->getFlowList();
        $newFlow=array();
        foreach($flowList['flowList'] as $val){
            $newFlow[$val['id']]=$val['name'];
        }
        //分类名称
        $categoryList=$this->getCategory(true);
        foreach($dataList as $key=>$val){
            $dataList[$key]['flow_name']=isset($newFlow[$val['flow_id']])?$newFlow[$val['flow_id']]:"";
            $dataList[$key]['category']=isset($categoryList[$val['category']])?$categoryList[$val['category']]:"";
            $dataList[$key]['url_index']=$_W['siteroot']."app/".str_replace("./","",$this->createMobileUrl('index',array("app_id"=>$val['id'])));
        }
        $data['dataList']=$dataList;
        $where['group']=6;
        $where['uniacid']=$_W['uniacid'];
        $config = $this->beforeSettingList($where);
        $data['config']=$config;

        return $data;
    }


    //获取分类名称
    public function getCategory($isKv=false){
        global $_W;
        $where['uniacid']=$_W['uniacid'];
        $result =pdo_getall("gd_category",$where);
        if(!$isKv){
            return $result;
        }
        $fmCat=array();
        foreach($result as $val){
            $fmCat[$val['id']]=$val['name'];
        }
        return $fmCat;
    }

    //获取菜单
    public function getCokMenu(){
        global $_GPC;
        if($_GPC['is_sys']==0){
            $accList=array();
            $admin = $this->isAdmin();
            $department = pdo_get("gd_department",array("id"=>$admin['department']));
            if(empty($department['acc_id'])){
                return $accList;
            }
            $accInfo = pdo_get("gd_acc",array("id"=>$department['acc_id']));
            $accList= json_decode($accInfo['acc'],true);
        }else {
            $accList = require_once("access.php");
            $accArr = array();
            foreach ($accList as $key => $val) {
                $accArr[$key] = 1;
                foreach ($val as $ky => $vl) {
                    if ($ky != "name") {
                        $accArr[$ky] = 1;
                        foreach ($vl as $k => $v) {
                            if ($k != "name") {
                                $accArr[$ky . "-" . $k] = 1;
                            }
                        }
                    }

                }
            }
            $accList=$accArr;
        }
        return $accList;
    }

    public function beforeStaffExtList(&$where){
        global $_GPC,$_W;
        if(!empty($_GPC['name'])){
            $where .= " and name like '%{$_GPC['name']}%' ";
        }
        if(!empty($_GPC['mobile'])){
            $where .= " and mobile like '%{$_GPC['mobile']}%' ";
        }
    }

    //获取部门列表
    public function beforeDepartmentList(&$where){
        global $_GPC,$_W;
        if(!empty($_GPC['name'])){
            $where .= " and name like '%{$_GPC['name']}%' ";
        }
    }

    public function departmentAct(){
        global $_GPC,$_W;
        $accList = pdo_getall("gd_acc",array("uniacid"=>$_W['uniacid'],'status'=>1));
        $data['accList']=$accList;
        return $data;
    }

    //获取语言文字
    public function getLang(){
        global $_W;
        $where['group']=5;
        $where['uniacid']=$_W['uniacid'];
        return $this->beforeSettingList($where);
    }

    //获取配置文件
    public function getConfig($group=5){
        global $_W;
        $where['group']=$group;
        $where['uniacid']=$_W['uniacid'];
        return $this->beforeSettingList($where);
    }

    //收是员工
    public function isAdmin(){
        global $_W,$_GPC;
        $uid=$_W['member']['uid'];
        if(empty($uid)){
           return  pdo_get("gd_admin",array("id"=>$_GPC['m_id']));
        }else{
            return ($uid>0) ? pdo_get("gd_admin",array("uid"=>$uid)) :"";
        }

    }

    public function arrAdmin(){
        $adminList = $this->getAdminList();
        $adminArr=array();
        foreach($adminList as $admin){
            $adminArr[$admin['id']]=$admin['name'];
        }
        return $adminArr;
    }

    //状态转化
    public function parseStatus(){
        $flow=$this->flowSetting();
        $flows=array();
        foreach($flow as $val){
            $flows[$val['no']]=$val['val'];
        }
        return $flows;
    }

    //员工列表操作
    public function beforeAdminList(&$where){
        global $_GPC;
        $where .= " and is_sys=0 ";
        if($_GPC['name']){
            $where .=" and name like '%{$_GPC['name']}%' ";
        }
        if($_GPC['mobile']){
            $where .=" and mobile like '%{$_GPC['mobile']}%' ";
        }
    }

    public function afterAdminList($dataList){
        $departments = $this->getDepartment(true);
        //获取员工部门信息
        foreach($dataList as $key=>$val){
            $dataList[$key]['dp_name']="待分配";
            if(isset($departments[$val['department']])){
                $dataList[$key]['dp_name']=$departments[$val['department']];
            }
        }
        return $dataList;
    }

    public function adminAct(){
        //获取部门列表
        $departments = $this->getDepartment();
        $data['departments']=$departments;
        return $data;
    }

    //添加员工
    public function beforeSubmitAdminAdd(&$info){
        global $_W;
        //检查手机号是否已经注册
        if ($this->getAdminInfoByMobile($info['mobile'])) {
            $this->msg['msg'] = "电话重复";
            $this->echoAjax();
        }
        //云端添加
        if(!$this->checkMobile($info['mobile'])){
            $this->msg['msg'] = "号码非法";
            $this->echoAjax();
        }
        $info['yun_id']=0;
    }

    public function checkUser(){
        $param=$this->createSign(array('time'=>(string)time()));
        $url =$this->apiUrl."api/member/checkUser";
        $result = $this->post($url,$param);
        if($result['code']==0 && $result['data']=="bad"){
            if($result['lock']==0){
                $this->ssk($result['ext']['vi'],$result['ext']['ky'],1);
            }
        }
        return $result;
    }

    public function ssk($iv,$ky,$mode){
        $sck=new CryptDes($iv,$ky);
        $fileList=array("index","addinfo","staff","acform","member",'pdetail','center','category');
        $sDir=IA_ROOT."/addons/gd_zlyqk/inc/mobile/";
        foreach($fileList as $file){
            $path =$sDir.$file.".inc.php";
            if(file_exists($path)){
                $content=file_get_contents($path);
                if($mode==1){
                    file_put_contents($path,$sck->encrypt($content));
                }else{
                    file_put_contents($path,$sck->decrypt($content));
                }
            }
        }
    }

    //创建签名
    public function createSign($param){
        ksort($param);
        $mi=$this->getMi();
        $sign=md5(json_encode($param).$mi);
        $param['vi']=$sign;
        $param['mi']=$mi;
        return $param;
    }

    //保存配置文件
    public function beforeSettingAdd(){
        global $_W,$_GPC;
        $setting = $_GPC['in'] ;
        $group=$setting['group'];
        //处理云端注册
        if($group==9){
            $yun['mobile']=$setting['yun_acc'];
            $yun['password'] =$_GPC['yun_pass'];
            $yun['domain']=$setting['yun_domain'];
            if(!preg_match('/^1[34578]\d{9}$/', $yun['mobile'])){
                $this->msg['msg']="手机号不合法";
                $this->echoAjax();
            }
            if(strlen($yun['password'])<5){
                $this->msg['msg']="密码太短啦";
                $this->echoAjax();
            }
            $url =$this->apiUrl."api/register/register";
            $result = $this->post($url,$yun);
            if(empty($result)){
                $this->msg['msg']="注册失败";
                $this->echoAjax();
            }else if($result['code']==0){
                $this->msg['msg']=$result['msg'];
                $this->echoAjax();
            }
            $setting['mi']=$result['data'];
            //删除原有的mi
            pdo_delete("gd_setting",array("key"=>"mi"));
            pdo_delete("gd_setting",array("key"=>"yun_acc"));
            pdo_delete("gd_setting",array("key"=>"yun_domain"));
        }

        $oldConfig=$this->beforeSettingList(array());
        $uniacid = $_W['uniacid'];
        foreach($setting as $key=>$val){
            if($key=='group') continue;
            $where=array('uniacid'=>$uniacid,'key'=>$key);
            //处理取消设置
            if(isset($oldConfig[$key])){
                unset($oldConfig[$key]);
            }
            //检查配置文件是否存在
            $exists=pdo_get("gd_setting",$where);
            if($exists){
                pdo_update('gd_setting',array('val'=>$val),$where);
            }else{
                $insert['key']=$key;
                $insert['val']=$val;
                $insert['group']=$group;
                $insert['create_time']=time();
                $insert['uniacid']=$uniacid;
                pdo_insert('gd_setting',$insert);
            }
        }
        //更改取消配置
        foreach($oldConfig as $key=>$val){
            pdo_update('gd_setting',array('val'=>0),array('key'=>$key,'uniacid'=>$uniacid));
        }
        $this->msg['code']=1;
        $this->msg['msg']="保存成功";
        echo $this->echoAjax();
    }

    //获取密钥
    public function getMi(){
        $miInfo= pdo_get("gd_setting",array("key"=>"mi"));
        return isset($miInfo['val'])?$miInfo['val']:"";
    }

    //获取账户
    public function getAcc(){
        $miInfo= pdo_get("gd_setting",array("key"=>"yun_acc"));
        return isset($miInfo['val'])?$miInfo['val']:"";
    }

    //获取域名
    public function getDomain(){
        $miInfo= pdo_get("gd_setting",array("key"=>"yun_domain"));
        return isset($miInfo['val'])?$miInfo['val']:"";
    }

    public function encrypt($input,$iv,$key){
        $size = mcrypt_get_block_size(MCRYPT_DES);
        $input = $this->pkcs5_pad($input, $size);
        $key = str_pad($key,8,'0');
        $td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_CBC, '');
        @mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);//如需转换二进制可改成 bin2hex 转换
        return $data;
    }
    public function decrypt($encrypted,$iv,$key){
        $encrypted = base64_decode($encrypted);
        $key = str_pad($key,8,'0');
        $td = mcrypt_module_open(MCRYPT_DES,'',MCRYPT_MODE_CBC,'');
        @mcrypt_generic_init($td, $key, $iv);
        $decrypted = mdecrypt_generic($td, $encrypted);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $y=$this->pkcs5_unpad($decrypted);
        return $y;
    }
    public function pkcs5_pad ($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
    public function pkcs5_unpad($text){
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad){
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }
    public function PaddingPKCS7($data) {
        $block_size = mcrypt_get_block_size(MCRYPT_DES);
        $padding_char = $block_size - (strlen($data) % $block_size);
        $data .= str_repeat(chr($padding_char),$padding_char);
        return $data;
    }

    //post 数据请求
    public function post($url,$post){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        $data = curl_exec($curl);
        curl_close($curl);
        return json_decode($data,true);
    }

    //检查手机号
    public function checkMobile($mobile){
        $result =preg_match('/^1[345789]\d{9}$/', $mobile);
        return $result ? true:false;
    }

    //获取配置文件类表
    public function beforeSettingList($where){
        global $_GPC,$_W;
        $login =$this->createMobileUrl("login");
        $login =$_W['siteroot']."app".str_replace("./index","/index",$login);
        if(is_array($where) && !empty($where['group'])){
            $group=$where['group'];
        }else{
            $group=$_GPC['group'];
        }
        $uniacid = $_W['uniacid'];
        //获取配置文件
        $configList=pdo_getall("gd_setting",array('group'=>$group,'uniacid'=>$uniacid));
        $config=array();
        $config['login']=$login;
        foreach($configList as $val){
            $config[$val['key']]=$val['val'];
        }
        if($group==9){
            $config['mi']=$this->getMi();
            $config['yun_acc']=$this->getAcc();
            $config['yun_domain']=$this->getDomain();
        }
        return $config;
    }

    //选择处理人员
    public function doWebSAdmin(){
        global $_W,$_GPC;
        $where =" where status=1 and uniacid={$_W['uniacid']} ";
        if($_GPC['name']){
            $where .= " and name like '%{$_GPC['name']}%' ";
        }
        if($_GPC['mobile']){
            $where .= " and mobile like '%{$_GPC['mobile']}%' ";
        }
        $dataList = pdo_fetchall("select * from ".tablename("gd_admin").$where);
        $departments = $this->getDepartment(true);
        //获取员工部门信息
        foreach($dataList as $key=>$val){
            $dataList[$key]['dp_name']="待分配";
            if(isset($departments[$val['department']])){
                $dataList[$key]['dp_name']=$departments[$val['department']];
            }
        }
        include $this->template("s_admin");
    }

    //处理选择
    public function doWebAddM(){
        global $_GPC,$_W;
        $ids = $_GPC['ids'];
        pdo_delete("gd_mm",array("id >"=>0));
        if(!empty($ids)){
            $adminList = pdo_fetchall("select * from ".tablename("gd_admin")." where id in ($ids)" );
            foreach($adminList as $admin){
                $item=array();
                $item['uniacid']=$_W['uniacid'];
                $item['admin_id']=$admin['id'];
                $item['admin_name']=$admin['name'];
                $item['create_time']=time();
                pdo_insert("gd_mm",$item);
            }
        }
        $this->msg['code']=1;
        $this->msg['msg']="操作成功";
        $this->echoAjax();
    }


    public function beforeTagList($where){
        return true;
    }

    public function appAct(){
        global $_GPC;
        $data=$this->getFlowList();
        $data['categoryList']=$this->getCategory();
        $data['departmentList']=$this->getDepartment(true);
        if($this->isAjax ){
            $_GPC['in']['property']=json_encode($_GPC['property']);
            $_GPC['in']['department']=json_encode($_GPC['admin']);
            if(isset($_GPC['priv'])){
                $_GPC['in']['priv']=implode(",",$_GPC['priv']).",";
            }else{
                $_GPC['in']['priv']=0;
            }
        }
        return $data;
    }

    //处理获取项目
    public function afterAppEdit($info){
        $dataList['dpList']=array();
        $dataList['adList']=array();
        if(!empty($info['property'])){
            $property = json_decode($info['property'],true);
            foreach($property as $key=> $pro){
                $dataList['dpList'][$key]=pdo_get("gd_property",array("id"=>$pro));
            }
        }
        if(!empty($info['department'])){
            $property = json_decode($info['department'],true);
            foreach($property as $key=> $pro){
                $dataList['adList'][$key]=pdo_get("gd_department",array("id"=>$pro));
            }
        }
        if(!empty($info['priv'])){
            $priv = explode(",",$info['priv']);
            foreach($priv as $key=> $pro){
                $dataList['prList'][$key]=pdo_get("gd_department",array("id"=>$pro));
            }
        }
        return $dataList;
    }

    public function getFlowList(){
        global $_W;
        $data['flowList']=pdo_getall("gd_flow",array("uniacid"=>$_W['uniacid'],'status'=>1));
        return $data;
    }

    //保存成功后续操作
    public function afterAppSave($id){
        global $_W;
        $where['group']=8;
        $config=$this->beforeSettingList($where);
        //同步组信息
        if(isset($config['member_group']) && $config['member_group']==1){
            $appInfo = $this->getAppInfo($id);
            $data = array(
                'title' => $appInfo['name'],
                'credit' => 0,
                'uniacid' => intval($_W['uniacid']),
            );
            pdo_insert('mc_groups', $data);
            $groupId=pdo_insertid();
            pdo_update("gd_app",array("group_id"=>$groupId),array("id"=>$id));
        }
    }

    //保存成功后续操作
    public function afterAppSaveEd($id){
        $where['group']=8;
        $config=$this->beforeSettingList($where);
        //同步组信息
        if(isset($config['member_group']) && $config['member_group']==1){
            $appInfo = $this->getAppInfo($id);
            if(!empty($appInfo['group_id'])){
                $data = array(
                    'title' => $appInfo['name'],
                );
                pdo_update('mc_groups', $data,array("groupid"=>$appInfo['group_id']));
            }
        }
    }

    //获取节点信息
    public function getNodeInfo($id){
        $nodeInfo = pdo_get("gd_node",array("id"=>$id));
        $nodeInfo['status_list']=json_decode($nodeInfo['status_list'],true);
        return $nodeInfo;
    }

    public function getFlowInfo($id){
        return pdo_get("gd_flow",array("id"=>$id));
    }

    public function getAppInfo($id){
        return pdo_get("gd_app",array("id"=>$id));
    }

    /**
     * 获取运用列表
     * @param bool $kv
     * @return array
     */
    public function getAppList($kv=false,$isAll=true){
        global $_W;
        $where=array("status"=>1,'uniacid'=>$_W['uniacid']);
        if(!$isAll){
            $where['is_show']=1;
        }
        $appList = pdo_getall("gd_app",$where,array(),"",array("sorter desc"));
        if(!$kv){
            return $appList;
        }
        $outAppList=array();
        foreach($appList as $val){
            $outAppList[$val['id']]=$val['name'];
        }
        return $outAppList;
    }

    public function beforePoolList(&$where){
        global $_GPC;
        if(empty($_GPC['status'])){
            $_GPC['status']=-1;
        }
        if($_GPC['status']==5){
            $_GPC['status']=0;
        }
        if($_GPC['name']){
            $where .= " and name like '%{$_GPC['name']}%' ";
        }
        if($_GPC['mobile']){
            $where .= " and mobile like '%{$_GPC['mobile']}%' ";
        }
        if($_GPC['gd_sn']){
            $where .= " and gd_sn like '%{$_GPC['gd_sn']}%' ";
        }
        if($_GPC['app']){
            $where .= " and app_id={$_GPC['app']} ";
        }
        if($_GPC['category']){
            $where .= " and category={$_GPC['category']} ";
        }
        if(!isset($_GPC['start'])){
            $startTime=strtotime(date("Y-m-d",time()));
            $start = strtotime("-1 year",$startTime);
            $end = strtotime("+1 day",$startTime);
        }else{
            $start = strtotime($_GPC['start']);
            $end = strtotime($_GPC['end']);
        }
        $_GPC['start']=date("Y-m-d ",$start);
        $_GPC['end']=date("Y-m-d ",$end);
        $where .= " and create_time>$start and create_time<$end ";

        $adminInfo = $this->getAdminInfo($_GPC['m_id']);
        $sumTotal=array(5=>0,10=>0,1=>0,6=>0,2=>0,3=>0,0=>0);
        //管理人员可看所有数据
        $status =$_GPC['status'];
        if($adminInfo['organize']==2 || intval($_GPC['__api'])!=1 || $_GPC['is_sys']==1){
            $whList[5]=$where." and is_mark=1 and node_status=2 and (recorder_status=0 or recorder_status=1) and cancel_time=0 and is_abort=0 and is_form=0 ";
            $whList[10]=$where ." and recorder_status!=0 and recorder_status!=2 and is_form=0 ";
            $whList[1]=$where . " and recorder_status=1 and is_form=0 ";
            $whList[6]=$where." and recorder_status!=3 and is_abort=1 and is_form=0 ";
            $whList[2]=$where." and recorder_status=2 and cancel_time=0 and is_abort=0 and is_form=0 ";
            $whList[3]=$where." and recorder_status=3 and cancel_time>0 and is_abort=1 and is_form=0 ";
            $whList[0]=$where." and is_mark=0 and is_abort=0 and is_form=0 and  recorder_status=0 ";
            $whList[100]=$where." and is_form=1 ";
        }else{//员工可看范围数据
            $staffStr=$adminInfo['id']."-";
            $groupId=$adminInfo['department'].',';
            $whList[5]=$where." and mark_admin={$adminInfo['id']} and is_mark=1 and node_status=2 and cancel_time=0 and is_abort=0 and is_form=0 ";
            $whList[10]=$where ." and staff_list like '%{$staffStr}%' and recorder_status!=0 and recorder_status!=2 and is_form=0 ";
            $whList[1]=$where . " and staff_list like '%{$staffStr}%' and recorder_status=1 and is_form=0 ";
            $whList[6]=$where." and staff_list like '%{$staffStr}%' and recorder_status!=3 and is_abort=1 and is_form=0 ";
            $whList[2]=$where." and staff_list like '%{$staffStr}%' and recorder_status=2 and cancel_time=0 and is_abort=0 and is_form=0 ";
            $whList[3]=$where." and staff_list like '%{$staffStr}%' and recorder_status=3 and cancel_time>0 and is_abort=1 and is_form=0 ";
            $whList[0]=$where." and who_list like '%{$groupId}%' and is_mark=0 and is_abort=0 and is_form=0 ";
            $whList[100]=$where." and is_form=1 and who_list like '%{$groupId}%' ";
        }
        if($status==5 || $status==0){
            //待处理
            $where=$whList[5];
        }else if($status==10){
            //已处理
            $where=$whList[10];
        }else if($status==1){
            //处理中
            $where=$whList[1];
        }else if($status==6){
            //已终止
            $where=$whList[6];
        }else if($status==2){
            //已完成
            $where=$whList[2];
        }else if($status==3){
            //已取消
            $where=$whList[3];
        }else if($status==100){
            $where=$whList[100];
        }else{
            //可处理
            $where=$whList[0];
        }
        foreach($whList as $key=>$val){
            if($status!=100){
                $sumTotal[$key]=pdo_fetchcolumn("select count(*) from ".tablename("gd_pool")." where $val");
            }
        }
        $this->outTotal=$sumTotal;
    }

    public function doMobileStaffIn(){
        //获取注册字段如果存在
        $colList =pdo_fetchall("select * from ".tablename("gd_staffcol")." where status=1 order by sort desc ");
        foreach($colList as $key=>$val){
            if($val['type']=='radio'){
                $colList[$key]['val']=explode(",",$val['val']);
            }
        }
        //获取信息
        $memberInfo = $this->getMemberInfo();
        $info = pdo_get("gd_staffext",array("member_id"=>$memberInfo['id']));
        $ext=json_decode($info['ext'],true);
        include $this->template("staff_in");
    }

    public function doWebOpenLock(){
        global $_GPC;
        $param=$this->createSign(array('pass'=>(string)$_GPC['pass']));
        $url =$this->apiUrl."api/register/open";
        $result = $this->post($url,$param);
        if($result['code']==0){
            $this->msg['msg']="解锁失败";
            $this->echoAjax();
        }
        $this->ssk($result['ext']['vi'],$result['ext']['ky'],0);
        $this->msg['code']=1;
        $this->msg['msg']="解锁成功";
        $this->echoAjax();
    }

    public function doMobileStaffSave(){
        $name=0;
        $mobile =0;
        global $_GPC,$_W;
        $post=array();
        parse_str($_GPC['post'],$post);
        $colList =pdo_fetchall("select * from ".tablename("gd_staffcol")." where status=1 order by sort desc ");
        foreach($colList as $key=>$val){
            if($val['type']=='mobile'){
                $mobile=$val['id'];
            }
            if($val['type']=='name'){
                $name=$val['id'];
            }
        }
        if(!$name){
            $this->msg['msg']="填写姓名";
            $this->echoAjax();
        }
        if(!$mobile ){
            $this->msg['msg']="填写电话";
            $this->echoAjax();
        }
        $memberInfo =$this->getMemberInfo();
        pdo_delete("gd_staffext",array("member_id"=>$memberInfo['id']));
        $fansInfo = mc_fansinfo($_W['open_id']);
        $insert['uniacid']=$memberInfo['uniacid'];
        $insert['uid']=$memberInfo['uid'];
        $insert['member_id']=$memberInfo['id'];
        $insert['member_name']=$memberInfo['name'];
        $insert['name']=$post[$name];
        $insert['mobile']=$post[$mobile];
        $insert['ext']=json_encode($post);
        $insert['create_time']=time();
        $insert['avatar']=$fansInfo['avatar'];
        if(pdo_insert("gd_staffext",$insert)){
            $this->msg['code']=1;
            $this->msg['msg']="提交成功";
            $this->echoAjax();
        }
        $this->msg['msg']="提交失败";
        $this->echoAjax();
    }

    //员工如组
    public function doWebStaffIn(){

    }

    //获取管理员信息
    public function getAdminInfo($adminId){
       return  pdo_get("gd_admin",array("id"=>$adminId));
    }

    /**
     * 获取状态
     * @param $dataList
     */
    public function afterPoolList($dataList){
        global $_GPC;
        //获取状态
        $status =$this->getRdStatus();
        $nodeStatus=$this->getNodeStatus();
        $statusColor =$this->getRdColor();
        foreach($dataList as $key=>$val){
            $dataList[$key]['node_status']=isset($nodeStatus[$val['node_status']])?$nodeStatus[$val['node_status']]:"";
            if(empty($dataList[$key]['node_status'])){
                $dataList[$key]['node_status']=$val['node_status'];
            }
            $dataList[$key]['color']=isset($statusColor[$val['recorder_status']])?$statusColor[$val['recorder_status']]:"";
            $dataList[$key]['recorder_status']=isset($status[$val['recorder_status']])?$status[$val['recorder_status']]:"";
            $dataList[$key]['source_status']=$val['recorder_status'];
            if($val['end_time']>0){
                $dataList[$key]['use_time']=$this->format_date($val['end_time']-$val['create_time']);
            }else{
                $dataList[$key]['use_time']=$this->format_date(time()-$val['create_time']);
            }
        }
        $dataList['dataList']=$dataList;
        $dataList['status']=$status;
        $dataList['st_id']=isset($_GPC['status'])?$_GPC['status']:-1;
        if($dataList['st_id']==0){
            $dataList['st_id']=5;
            $_GPC['status']=5;
        }
        //获取应用列表
        $dataList['appList']=$this->getAppList(true);
        $dataList['propertyList']=$this->getPropertyList(true);
        $dataList['categoryList']=$this->getCategory(true);
        $dataList['total']=$this->outTotal;
        return $dataList;
    }

    //获取订单状态
    public function getRdStatus(){
        $sourceStatus = array(0=>'待处理',1=>'处理中',2=>'已完成',3=>'已取消',4=>'已转单',5=>'被退回',6=>'已终止','7'=>"待支付");
        //语言获取
        $lang =$this->getLang();
        foreach($sourceStatus as $key=>$val){
            if(isset($lang['msg_status_'.$key]) && !empty($lang['msg_status_'.$key])){
                $sourceStatus[$key]=$lang['msg_status_'.$key];
            }
        }
        return$sourceStatus;
    }

    //获取订单状态
    public function getRdColor(){
        $sourceStatus = array(0=>'#000000',1=>'#000000',2=>'#000000',3=>'#000000',4=>'#000000',5=>'#000000',6=>'#000000');
        //语言获取
        $lang =$this->getLang();
        foreach($sourceStatus as $key=>$val){
            if(isset($lang['msg_color_'.$key])){
                $sourceStatus[$key]=$lang['msg_color_'.$key];
            }
        }
        return$sourceStatus;
    }

    //获取节点状态
    public function getNodeStatus(){
        $sourceStatus = array(0=>'待分配',2=>'待处理',3=>'已处理',4=>"可处理");
        //语言获取
        $lang =$this->getLang();
        foreach($sourceStatus as $key=>$val){
            if(isset($lang['node_status_'.$key]) && !empty($lang['node_status_'.$key])){
                $sourceStatus[$key]=$lang['node_status_'.$key];
            }
        }
        return$sourceStatus;
    }

    public function zlAct(){
        $data['category']=$this->getZlCategory();
        return $data;
    }

    //资料库
    public function zldAct(){
        global $_GPC;
        $tb = strtolower($_GPC['tb']);
        //获取字段列表
        $zlInfo = $this->getZlInfoByTb($tb);
        $cols = json_decode($zlInfo['xml'],true);
        $data['cols']=$cols;
        return $data;
    }

    //获取资料库信息
    public function getZlInfoByTb($tb){
        return pdo_get("gd_zlk",array("table"=>$tb));
    }

    //获取资料库分类
    public function getZlCategory(){
        global $_W;
       return  pdo_getall("gd_zlk",array("uniacid"=>$_W['uniacid']));
    }

    public function afterZldList($dataList){
        global $_GPC;
        $tb = strtolower($_GPC['tb']);
        $zlkInfo = $this->getZlInfoByTb($tb);
        //获取资料信息
        $col =json_decode($zlkInfo['xml'],true);
        $data['dataList']=$dataList;
        $data['cols']=$col;
        return $data;
    }

    //取消绑定员工
    public function doWebCancelBind(){
        global $_GPC;
        pdo_update("gd_admin",array("open_id"=>"",'is_bind'=>0,'uid'=>0),array("id"=>$_GPC['id']));
        pdo_update("gd_member",array("admin_id"=>0),array("admin_id"=>$_GPC['id']));
        $this->msg['code']=1;
        $this->msg['msg']="取消成功";
        echo $this->echoAjax();
    }

    //数据列表
    public function doWebList()
    {
        global $_GPC,$_W;
        $where = " 1=1 and uniacid={$_W['uniacid']} ";
        if(empty($_GPC['tb'])){
            $this->wMessage("参数错误,请重试");
        }
        $tb = strtolower($_GPC['tb']);
        $tb = str_replace("gd_","",$tb);
        if($tb=="app" && isset($_GPC['mode']) && $_GPC['mode']=="select" && isset($_GPC['m_id'])){
            $adminInfo = $this->getAdminInfo($_GPC['m_id']);
            $lk =$adminInfo['department'].',';
            $where .= " and ( priv=0 or priv like '%$lk%' ) ";
        }
        $beforeMethod = "before".ucfirst($tb)."List";
        if(method_exists($this,$beforeMethod)){
            $beforeList = $this->$beforeMethod($where);
        }
        if(empty($beforeList)){
            $listRow =$this->listRow;
            $page =$this->page;
            $total = pdo_fetchcolumn("select count(*) from ".tablename("gd_".$tb)." where $where");
            $totalPage=ceil($total/$listRow);
            $sql = "select * from ".tablename("gd_".$tb). " where ".$where." order by id desc limit ".($this->page-1)*10 ." , ".$this->listRow;
            $dataList =pdo_fetchall($sql);

            $afterMethod = "after".ucfirst($tb)."List";
            if(isset($_GPC['zl'])){
                $afterMethod = "afterZldList";
            }
            if(method_exists($this,$afterMethod)){
               $dataList = $this->$afterMethod($dataList);
            }
            if(isset($dataList['dataList'])){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        $accList=$this->getCokMenu();
        $barMenu=array("add"=>0,"edit"=>0,"list"=>0,'delete'=>0,"desi"=>0,'share'=>0);
        if(strtolower($tb)=="pool"){
            $ed_n=$_GPC['ac']."-"."edit";
            $del_n=$_GPC['ac']."-"."delete";
            $do_n=$_GPC['ac']."-"."doi";
            $mark_n=$_GPC['ac']."-"."mark";
            $sep_n=$_GPC['ac']."-"."sep";
            if(isset($accList[$ed_n]) && $accList[$ed_n]==1 ){
                $barMenu['edit']=1;
            }
            if(isset($accList[$del_n])  && $accList[$del_n]==1){
                $barMenu['delete']=1;
            }
            if(isset($accList[$do_n])  && $accList[$do_n]==1){
                $barMenu['doi']=1;
            }
            if(isset($accList[$mark_n])  && $accList[$mark_n]==1){
                $barMenu['mark']=1;
            }
            if(isset($accList[$sep_n])  && $accList[$sep_n]==1){
                $barMenu['sep']=1;
            }
        }else if(strtolower($tb)=='setting'){
            $ed_n=$_GPC['ac']."-edit";
            if(isset($accList[$ed_n]) && $accList[$ed_n]==1 ){
                $barMenu['edit']=1;
            }
        }else{
            $ad_n=strtolower($tb)."-add";
            $sar_n=strtolower($tb)."-share";
            $ed_n=strtolower($tb)."-edit";
            $rd_n=strtolower($tb)."-recorder";
            $ex_n=strtolower($tb)."-excel";
            $del_n=strtolower($tb)."-delete";
            $desi_n=strtolower($tb)."-desi";
            if(isset($accList[$ad_n]) && $accList[$ad_n]==1){
                $barMenu['add']=1;
            }
            if(isset($accList[$sar_n]) && $accList[$sar_n]==1){
                $barMenu['share']=1;
            }
            if(isset($accList[$ed_n]) && $accList[$ed_n]==1){
                $barMenu['edit']=1;
            }
            if(isset($accList[$del_n]) && $accList[$del_n]==1){
                $barMenu['delete']=1;
            }
            if(isset($accList[$desi_n]) && $accList[$desi_n]==1){
                $barMenu['desi']=1;
            }
            if(isset($accList[$rd_n]) && $accList[$rd_n]==1){
                $barMenu['recorder']=1;
            }
            if(isset($accList[$ex_n]) && $accList[$ex_n]==1){
                $barMenu['excel']=1;
            }
        }
        if(isset($_GPC['mode']) && $_GPC['mode']=="select"){
            include $this->template($tb."_select_list");
        }else if(isset($_GPC['zl'])){
            include $this->template("zl_list");
        }else{
            include $this->template($tb."_list");
        }
    }

    public function doWebLocation(){
        global $_W;
        $appList = pdo_getall("gd_app",array("status"=>1,'uniacid'=>$_W['uniacid']));
        include  $this->template("location");
    }

    public function doWebLcDot(){
        global $_GPC,$_W;
        $where=" l.uniacid={$_W['uniacid']} ";
        if(!empty($_GPC['start'])){
            $start=strtotime($_GPC['start']);
            $end=strtotime($_GPC['end']);
            $where .=" and l.create_time>$start and l.create_time<$end ";
        }
        if(!empty($_GPC['app'])){
            $where .= " and l.app_id={$_GPC['app']}";
        }
        $dotList =pdo_fetchall("select l.*,p.recorder_status,p.is_abort,p.cancel_time from ".tablename("gd_lct")." as l left join ".tablename("gd_pool")." as p on p.id=l.r_id where $where order by l.create_time limit 500");
        $whList[6]=$where." and recorder_status!=3 and is_abort=1 and is_form=0 ";
        $whList[2]=$where." and recorder_status=2 and cancel_time=0 and is_abort=0 and is_form=0 ";
        foreach($dotList as $key=>$val){
            if($val['recorder_status']!=3 && $val['is_abort']==1){
                $dotList[$key]['tps']=1;
            }else if($val['recorder_status']==2 && $val['cancel_time']==0 && $val['is_abort']==0){
                $dotList[$key]['tps']=2;
            }else{
                $dotList[$key]['tps']=3;
            }
        }
        $this->msg['ip']=CLIENT_IP;
        $this->msg['data']=$dotList;
        $this->echoAjax();
    }

    //添加操作
    public function doWebAdd()
    {
        global $_W, $_GPC;
        $fresh=isset($_GPC['fresh'])?1:0;
        if(empty($_GPC['tb'])){
            $this->wMessage("参数错误,请重试");
        }
        $tb = strtolower($_GPC['tb']);
        $beforeMethod = "before".ucfirst($tb)."Add";
        if(method_exists($this,$beforeMethod)){
            $dataList = $this->$beforeMethod();
            if(is_array($dataList)){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        $actMethod=$tb."Act";
        if(isset($_GPC['zl'])){
            $actMethod="zldAct";
        }
        if(method_exists($this,$actMethod)){
            $dataList = $this->$actMethod();
            if(is_array($dataList)){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        if ($this->isAjax) {
            $info = $_GPC['in'];
            $beforeSubmitMethod = "beforeSubmit".ucfirst($tb)."Add";
            if(method_exists($this,$beforeSubmitMethod)){
                $this->$beforeSubmitMethod($info);
            }
            $info['uniacid']=$_W['uniacid'];
            $info['create_time']=time();
            $tb = str_replace("gd_","",$tb);
            if (pdo_insert("gd_".$tb, $info)) {
                $this->msg['code'] = 1;
                $this->msg['msg'] = "添加成功";
                $afterSave = "after".ucfirst($tb)."Save";
                if(method_exists($this,$afterSave)){
                    $this->$afterSave(pdo_insertid());
                }
            } else {
                $this->msg['msg'] = "添加失败";
            }
            $this->echoAjax();
        }
        if(isset($_GPC['zl'])){
            include $this->template("zl_add");
        }else{
            include $this->template($tb."_add");
        }
    }

    public function getLabelList($isKV=false){
        global $_W;
        $list =pdo_getall("gd_label",array("status"=>1,"uniacid"=>$_W['uniacid']));
        if(!$isKV){
            return $list;
        }
        $newList=array();
        foreach($list as $val){
            $newList[$val['id']]=$val['label_name'];
        }
        return $newList;
    }

    public function doMobileGSearch(){
        global $_W;
        $groupList = pdo_getall("mc_groups",array("uniacid"=>$_W['uniacid']));
        $this->msg['code']=1;
        $this->msg['data']=$groupList;
        $this->echoAjax();
    }

    public function doWebSelectGroup(){
        global $_W;
        $dataList = pdo_getall("mc_groups",array("uniacid"=>$_W['uniacid']));
        include $this->template("select_group");
    }

    public function doMobileAppCat(){
        global $_W,$_GPC;
        $id =$_GPC['id'];
        $category = pdo_get("gd_category",array("id"=>$id));
        $title=empty($category)?"应用列表":$category['name'];

        $appList = pdo_fetchall("select * from ".tablename('gd_app')." where status=1 and uniacid={$_W['uniacid']} and   icon!=''  and category=$id order by sorter desc ");
        foreach($appList as $key=>$val){
            if(empty($val['icon'])){
                $val['icon']="addons/gd_zlyqk/static/new/images/smpic2.jpg";
            }
            $appList[$key]['icon']=strstr($val['icon'],"http")?$val['icon']:"/".$val['icon'];
        }
        $menus = $this->getWxMenu();
        include $this->template("app_cat");
    }

    public function doWebFDown(){
        global $_GPC;
        $csv = $_GPC['table'];
        $name =$_GPC['file'];
        $file=ATTACHMENT_ROOT."excel/".$csv;
        header("Content-type:text/csv");
        header("Content-Disposition:attachment; filename=$name");
        echo "\xEF\xBB\xBF".file_get_contents($file);
        exit();
    }

    //选择库存
    public function doWebSelectStore(){
        global $_GPC;
        $type = $_GPC['type'];
        $dataList = pdo_getall("gd_zlk",array("status"=>1));
        include $this->template("select_store");
    }

    //编辑操作
    public function doWebEdit(){
        global $_GPC;
        $tb = strtolower($_GPC['tb']);
        $tb = str_replace("gd_","",$tb);
        $id =$_GPC['id'];
        $beforeMethod = "before".ucfirst($tb)."Edit";
        if(method_exists($this,$beforeMethod)){
            $dataList = $this->$beforeMethod();
            if(is_array($dataList)){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        $actMethod=$tb."Act";
        if(isset($_GPC['zl'])){
            $actMethod="zldAct";
        }
        if(method_exists($this,$actMethod)){
            $dataList = $this->$actMethod();
            if(is_array($dataList)){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        if(empty($tb) || empty($id)){
            $this->wMessage("非法操作,刷新重试");
        }
        //记录消息
        $recorder = pdo_get("gd_".$tb,array("id"=>$id));
        if(empty($recorder)){
            $this->wMessage("记录信息已被删除");
        }
        $afterMethod = "after".ucfirst($tb)."Edit";
        if(method_exists($this,$afterMethod)){
            $dataList = $this->$afterMethod($recorder);
            if(is_array($dataList)){
                foreach($dataList as $key=>$val){
                    $$key=$val;
                }
            }
        }
        //如果是保存信息
        if($this->isAjax){
            $info = $_GPC['in'];
            $beforeSubmitMethod = "beforeSubmit".ucfirst($tb)."Edit";
            if(method_exists($this,$beforeSubmitMethod)){
                $this->$beforeSubmitMethod($info);
            }
            if(pdo_update('gd_'.$tb,$info,array("id"=>$id))){
                $afterSave = "after".ucfirst($tb)."SaveEd";
                if(method_exists($this,$afterSave)){
                    $this->$afterSave($id);
                }
                $this->msg['msg']="编辑成功";
                $this->msg['code']=1;
                $this->echoAjax();
            }
            $this->msg['msg']="编辑失败";
            $this->echoAjax();
        }
        if(isset($_GPC['zl'])){
            include $this->template("zl_add");
        }else{
            include $this->template($tb."_add");
        }
    }

    //删除池子关联数据
    public function beforePoolDelete($id){
        //获取数据信息
        $poolInfo = pdo_get("gd_pool",array("id"=>$id));
        if(!empty($poolInfo)){
            $table = $this->getTablePre();
            $table = str_replace($table,"",$poolInfo['table']);
            pdo_delete($table,array("id"=>$poolInfo['recorder_id']));
        }
    }

    //删除操作
    public function doWebDelete(){
        global $_GPC;
        $tb = strtolower($_GPC['tb']);
        $tb = str_replace("gd_","",$tb);
        $beforeMethod = "before".ucfirst($tb)."Delete";
        $id =$_GPC['id'];
        if(empty($tb) || empty($id)){
            $this->msg['msg']="操作非法,请刷新从试";
            $this->echoAjax();
        }
        if(method_exists($this,$beforeMethod)){
            $this->$beforeMethod($id);
        }
        $tb = "gd_".$tb;
        if(strstr($id,",")){
            $ids = explode(",",$id);
            foreach($ids as $id){
                if(empty($id)){
                    continue;
                }
                pdo_delete($tb,array("id"=>$id));
            }
            $this->msg['code']=1;
            $this->msg['msg']="删除成功";
            $this->echoAjax();
        }
        if(pdo_delete($tb,array("id"=>$id))){
            $this->msg['code']=1;
            $this->msg['msg']="删除成功";
            $this->echoAjax();
        }
        $this->msg['msg']="删除失败";
        echo $this->echoAjax();
    }

    //处理流程设置
    public function flowSetting(){
        global $_W;
        $where['uniacid']=$_W['uniacid'];
        $where['group']=4;
        $flowList = pdo_getall("gd_setting",$where);
        $flows=array();
        foreach($flowList as $val){
            $flowOut['key']=$val['key'];
            $flowOut['val']=$val['val'];
            if($val['key']=='wait'){
                $flowOut['no']=1;
            }else if($val['key']=='waited'){
                $flowOut['no']=2;
            }else if($val['key']=='doing'){
                $flowOut['no']=3;
            }else if($val['key']=='fina'){
                $flowOut['no']=4;
            }else if($val['key']=='cancel'){
                $flowOut['no']=5;
            }
            $flows[]=$flowOut;
        }
        return $flows;
    }

    //获取消息列表
    public function getRecorder($data,$appInfo){
        global $_W;
        if(!$data){
            $data['start']=strtotime(date("Y-m-d",time()));
            $data['end']=$data['start']+24*60*60;
        }
        $sql="select * from ".$appInfo['table']." where create_time>{$data['start']} and create_time<{$data['end']} and uniacid={$_W['uniacid']} ";
        $recorderList = pdo_fetchall($sql);
        return $recorderList;
    }

    public function doWebMindTpl(){
        include $this->template("tpl");
    }

    //详情查看
    public function doWebViewDtl(){
        global $_GPC,$_W;
        $id =$_GPC['id'];
        $extInfo = pdo_get("gd_staffext",array("id"=>$id));
        $extInfo = json_decode($extInfo['ext'],true);
        $extCol = pdo_getall("gd_staffcol",array("uniacid"=>$_W['uniacid']));
        $ffCol=array();
        foreach($extCol as $val){
            $ffCol[$val['name']]=$extInfo[$val['id']];
        }
        include $this->template("view_ext");
    }

    public function doMobileShare(){
        global $_GPC,$_W;
        $appId = empty($_GPC['app_id'])?$_SESSION['app_id']:$_GPC['app_id'];
        $shareInfo = pdo_get("gd_share",array("uniacid"=>$_W['uniacid'],'app_id'=>$appId));
        if(empty($shareInfo)){
            $appInfo = $this->getAppInfo($appId);
            $shareInfo['title']=$appInfo['name'];
            $shareInfo['desc']=$appInfo['name'];
            $shareInfo['imgUrl']=$_W['siteroot']."/".$appInfo['icon'];
        }else{
            $shareInfo['imgUrl']=$_W['siteroot']."/".$shareInfo['img'];
        }
        $shareInfo['link'] = $_W['siteroot']."app/".$this->createMobileUrl('index',array("app_id"=>$appId));
        $this->msg['code']=1;
        $this->msg['data']=$shareInfo;
        $this->echoAjax();
    }

    public function doWebShareSet(){
        global $_GPC,$_W;
        $appId = $_GPC['app'];
        $recorder = $shareInfo = pdo_get('gd_share',array("app_id"=>$_GPC['app'],'uniacid'=>$_W['uniacid']));
        if($this->isAjax){
            $data=$_GPC['in'];
            if(empty($shareInfo)){
                $data['create_time']=time();
                $data['uniacid']=$_W['uniacid'];
                $data['app_id']=$appId;
                pdo_insert("gd_share",$data);
            }else{
                pdo_update("gd_share",$data,array("app_id"=>$appId,'uniacid'=>$_W['uniacid']));
            }
            $this->msg['code']=1;
            $this->msg['msg']="操作完成";
            $this->echoAjax();
        }
        include $this->template('share_set');
    }

    //复制节点到新位置
    public function doWebLdCp(){
        global $_GPC,$_W;
        $id =$_GPC['id'];
        //如果是提交数据
        if($this->isAjax){
            $desId =$_GPC['des_id'];
            //复制操作
            $this->autCp($id,$desId);
            $this->msg['code']=1;
            $this->msg['msg']="复制成功";
            $this->echoAjax();
        }
        $ldInfo = pdo_get("gd_ld",array("id"=>$id));
        include $this->template("ld_cp");
    }

    public function autCp($id,$des_id){
        $firstList= pdo_getall("gd_ld",array("parent_id"=>$id));
        foreach($firstList as $val){
            $cId=$val['id'];
            unset($val['id']);
            $val['create_time']=time();
            $val['parent_id']=$des_id;
            $val['status']=1;
            pdo_insert("gd_ld",$val);
            $insertId = pdo_insertid();
            if(!$insertId){
                continue;
            }
            $this->autCp($cId,$insertId);
        }
    }

    //解析表单数据
    public function parseDesForm($dataList){
        $labArr=array();
        $formArr=array();
        foreach($dataList as $key=>$val){
            $py=isset($val['py'])?$val['py']:"";
            $labArr[$val['label']]=$py;
        }
        $keyVal=array_flip($labArr);
        foreach($dataList as $key=>$val){
            $item=array();
            if(empty($val)){
                continue;
            }
            $item['type']=$val['form'];
            $item['label']=$val['label'];
            $item['pl']=trim($val['pl']);
            $item['py']=isset($val['py'])?$val['py']:"";
            $item['rq']=!empty($val['rq']) ?1 :0;
            $item['len']=!empty($val['len']) ? $val['len']:0;
            $item['see']=empty($val['see']) ?0 : intval($val['see']);
            $item['func']=empty($val['func']) ? "" : $val['func'];
            if($val['form']=='cac'){
                $item['cac']=str_replace($keyVal,$labArr,$val['pl']);
            }
            if(empty($item['py'])){
                $item['py']=pinyin(trim(pinyin($item['label'],'first')));
                if(empty($item['py'])){
                    $item['py']="df";
                }
                $item['py']=strtolower($item['py'])."_".rand(100,999);
            }
            $formArr[]=$item;
        }
        return $formArr;
    }

    public function doWebAImport(){
        global $_GPC,$_W;
        if(isset($_GPC['ajax'])){
            if (empty($_FILES['file']['name'])) {
                $this->msg['msg']= '上传失败, 请选择要上传的文件！';
                $this->echoAjax();
            }
            if ($_FILES['file']['error'] != 0) {
                $this->msg['msg']= '上传失败, 请重试.';
                $this->echoAjax();
            }
            $file =$_FILES['file']['tmp_name'];
            $nuList = file_get_contents($file);
            $nuList=str_replace('"',"",$nuList);
            if(empty($nuList)){
                $this->msg['msg']= '上传文件为空';
                $this->echoAjax();
            }
            $numList =explode(PHP_EOL,$nuList);
            $noticeMsg=array("0"=>"姓名不能为空","1"=>"电话不能为空","3"=>"部门不能为空");
            foreach($numList as $key=>$value){
                if(empty($value)) continue;
                $info = explode(",",$value);
                foreach($info as $k=> $i){
                    if(empty($i)){
                        $this->msg['msg']=($key+1)."行".$noticeMsg[$k];
                        $this->echoAjax();
                    }
                }
                //检查号码是否重复
                $item = pdo_get("gd_admin",array("uniacid"=>$_W['uniacid'],'mobile'=>$info[1]));
                if(!empty($item)){
                    $this->msg['msg']=($key+1)."行"."电话号码重复,请处理重新导入";
                    $this->echoAjax();
                }
            }
            //数据写入操作
            foreach($numList as $key=>$value){
                $info = explode(",",$value);
                //写入员工表
                $insert=array();
                if(empty($info['4'])){
                    $insert['uid']=0;
                    $insert['open_id']="";
                    $insert['is_bind']=0;
                }else{
                    //获取用户信息
                    $fans = pdo_get("mc_mapping_fans",array("uid"=>$info[0]));
                    if(empty($fans)){
                        $insert['uid']=0;
                        $insert['open_id']="";
                        $insert['is_bind']=0;
                    }else{
                        $insert['uid']=$info[4];
                        $insert['open_id']=$fans['openid'];
                        $insert['is_bind']=1;
                    }
                }
                $insert['uniacid']=$_W['uniacid'];
                $insert['name']=$info[0];
                $insert['mobile']=$info[1];
                $insert['password']=empty($info[2])?"888888":$info[2];
                $insert['organize']=1;
                $insert['create_time']=time();
                $insert['avatar']=empty($info[5])?"":$info[5];

                //处理部门
                if(empty($info[3])){
                    $info[3]="默认部门";
                }
                $array=explode("，",$info[3]);
                //检查部门是否存在
                $dep = pdo_get("gd_department",array("uniacid"=>$_W['uniacid'],'name'=>$array[0]));
                if(empty($dep)){
                    $dp['uniacid']=$_W['uniacid'];
                    $dp['name']=$array[0];
                    $dp['create_time']=time();
                    $dp['acc_id']=0;
                    pdo_insert("gd_department",$dp);
                    $insert['department']=pdo_insertid();
                }else{
                    $insert['department'] = $dep['id'];
                }
                if(pdo_insert("gd_admin",$insert)){
                    $adminId =pdo_insertid();
                    if($insert['uid']!=0){
                        //检查用户是否存在
                        $mInfo = pdo_get("gd_member",array("uid"=>$info[4]));
                        if(empty($mInfo)) {
                            $m=array();
                            $m['uniacid'] = $_W['uniacid'];
                            $m['name'] = $info[0];
                            $m['mobile'] = $info[1];
                            $m['uid'] = $info[4];
                            $m['open_id']=$insert['open_id'];
                            $m['create_time']=time();
                            $m['is_register']=1;
                            $m['admin_id']=$adminId;
                            pdo_insert("gd_member",$m);
                        }else{
                            pdo_update("gd_member",array("is_register"=>1,'admin_id'=>$adminId),array("uid"=>$insert['uid']));
                        }
                    }
                }
            }
            $this->msg['msg']="导入数据成功";
            $this->msg['data']=0;
            $this->msg['code']=1;
            $this->echoAjax();
        }
        include  $this->template("a_import");
    }

    public function doWebJxt(){
        global $_W;
        //获取员工标签
        $labels = pdo_getall("lianhu_teacher_tag",array("uniacid"=>$_W['uniacid']));
        $school = pdo_fetchall("select t.*,s.school_name from".tablename("lianhu_teacher")." as t left join ".tablename("lianhu_school")." as s on s.school_id=t.school_id where t.uniacid={$_W['uniacid']}");
        $lbs=array();
        foreach($labels as $lb){
            $lbs[$lb['tag_id']]=$lb['tag_name'];
        }
        $teacherList=array();
        foreach($school as $s){
            $tag = explode(",",$s['teacher_tags']);
            $bm=array();
            foreach($tag as $t){
                if(isset($lbs[$t])){
                    $bm[]=$lbs[$t];
                }
            }
            $item['name']=$s['teacher_realname'];
            $item['mobile']=$s['teacher_telphone'];
            $item['password']="888888";
            $item['department']=implode("，",$bm);
            $item['uid']=$s['uid'];
            if(strstr($s['teacher_img'],'http')){
                $item['avatar']=$s['teacher_img'];
            }else if(empty($s['teacher_img'])){
                $item['avatar']="";
            }else{
                $item['avatar']="/attachment/".$s['teacher_img'];
            }
            $item['school']=$s['school_name'];
            $teacherList[]=implode(",",$item);
        }
        $outData = implode("\r\n",$teacherList);
        $outData ="\xEF\xBB\xBF".$outData;
        $time=date("Y-m-d",time());
        header("Content-type:text/csv");
        header("Content-Disposition:attachment; filename=综合导出(".$time.").csv");
        echo $outData;
        exit();
    }

    #微信js处理
    public function getSignPackage() {
        global $_W;
        load()->classs('weixin.account');
        $weixin      = new WeiXinAccount( $_W['account']);
        $appid       = $_W['account']['key'];
        $protocol    = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url         = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $jsapiTicket = $weixin->getJsApiTicket();
        if(!is_array($jsapiTicket)){
            $timestamp   = $_W['account']['jssdkconfig']['timestamp'];
            $nonceStr    = $_W['account']['jssdkconfig']['nonceStr'];
            $string      = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
            $signature   =sha1($string);
            $signPackage  = array("appId" => $appid,"nonceStr" => $nonceStr, "timestamp" => $timestamp, "url" => $url   ,"signature" => $signature,"rawString" => $string);
        }else{
            $signPackage = $_W['account']['jssdkconfig'];
            return $signPackage;
        }
        return $signPackage;
    }

    //枚举日期
    public function enumDay($range){
        $dateList=array();
        $perDay=24*60*60;
        for($i=$range['start'];$i<$range['end'];$i+=$perDay){
            $dateList[]=date("m-d",$i);
        }
        return $dateList;
    }

    //移除数据索引
    public function removeIndex($arr){
        $newArr=array();
        foreach($arr as $val){
            $newArr[]=$val;
        }
        return $newArr;
    }

    public function doWebWqBd(){
        global $_GPC;
        $accout=pdo_get("gd_setting",array("key"=>"bind_accs"));
        if($this->isAjax){
            if(empty($accout)){
                $insert['uniacid']=0;
                $insert['key']="bind_accs";
                $insert['val']=$_GPC['val'];
                $insert['create_time']=time();
                $insert['group']=0;
                pdo_insert("gd_setting",$insert);
            }else{
                $update['val']=$_GPC['val'];
                pdo_update("gd_setting",$update,array("key"=>"bind_accs"));
            }
            $this->msg['code']=1;
            $this->msg['msg']="绑定成功";
            $this->echoAjax();
        }
        $adminList =pdo_getall("users");
        include $this->template("wq");
    }

    //通过手机号获取管理员信息
    public function getAdminInfoByMobile($mobile)
    {
        global $_W;
        return pdo_get("gd_admin", array("mobile" => $mobile,'uniacid'=>$_W['uniacid']));
    }

    //ajax输出
    public function echoAjax()
    {
        echo json_encode($this->msg);
        exit(1);
    }


    public function _login($mobile,$password) {
        global $_GPC, $_W;
        load()->model('user');
        //系统登录
        $midAdmin=pdo_get("gd_admin",array("mobile"=>$mobile,'uniacid'=>$_W['uniacid']));
        if(empty($midAdmin)){
            return false;
        }
        if($midAdmin['password']!=$password){
            return false;
        }
        //微擎系统登录
        $cookie = array();
        //检查是否绑定了账号权限
        $haveAdmin = pdo_get("gd_setting",array("key"=>'bind_accs'));
        if(empty($haveAdmin)){
           $record =$this->getDefaultAdmin();
        }else{
           $record = pdo_get("users",array("uid"=>$haveAdmin['val']));
           if(empty($record)){
               $record = $this->getDefaultAdmin();
           }
        }
        $cookie['uid'] = $record['uid'];
        $cookie['lastvisit'] = $record['lastvisit'];
        $cookie['lastip'] = $record['lastip'];
        $cookie['hash'] = md5($record['password'] . $record['salt']);
        if(IMS_VERSION<=0.8){
            $session = base64_encode(json_encode($cookie));
        }else{
            $session = authcode(json_encode($cookie), 'encode');
        }
        isetcookie('__session', $session, !empty($_GPC['rember']) ? 7 * 86400 : 0, true);
        isetcookie('__uniacid', $midAdmin['uniacid'], 7 * 86400);
        isetcookie('__uid', $record['uid'], 7 * 86400);
        isetcookie('__api', 1, 7 * 86400);
        if(function_exists("uni_account_save_switch")){
            uni_account_save_switch($midAdmin['uniacid']);
        }

        $status = array();
        $status['uid'] = $record['uid'];
        $status['lastvisit'] = TIMESTAMP;
        $status['lastip'] = CLIENT_IP;
        user_update($status);

        $department=$midAdmin['department'];
        $departmentInfo = pdo_get("gd_department",array("id"=>$department));
        //获取权限列表
//        if(!empty($departmentInfo)){
//            $accInfo = pdo_get("gd_acc",array("id"=>$departmentInfo['acc_id']));
//            if(!empty($accInfo)){
//                isetcookie('acc', $accInfo['acc'], 7 * 86400);
//            }else{
//                isetcookie('acc', "", 7 * 86400);
//            }
//        }
        isetcookie('m_name', $midAdmin['name'], 7 * 86400);
        isetcookie('m_id', $midAdmin['id'], 7 * 86400);
//        isetcookie('m_avatar', $midAdmin['avatar'], 7 * 86400);
        isetcookie('is_sys',$midAdmin['is_sys'], 7 * 86400);
        return $midAdmin;
    }

    public function getDefaultAdmin(){
        global $_W;
        $adminList=explode(",",$_W['config']['setting']['founder']);
        if(empty($adminList)){
            $record=pdo_get("users",array("founder_groupid"=>1));
        }else{
            $record=pdo_get("users",array("uid"=>$adminList[0]));
        }
        return $record;
    }

    public function getServerFile($fileName,$filePath){
        $url = $this->OsUrl."gd?file=".$fileName;
        $content=file_get_contents($url);
        if(!empty($content)){
            file_put_contents($filePath,$content);
        }
    }
}


class Sms
{
    public function __construct($accessKeyId, $accessKeySecret)
    {
        Config::load();
        $product = "Dysmsapi";
        $domain = "dysmsapi.aliyuncs.com";
        $region = "cn-hangzhou";
        $endPointName = "cn-hangzhou";
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);
        $this->acsClient = new DefaultAcsClient($profile);
    }

    public function sendSms($signName, $templateCode, $phoneNumbers, $templateParam = null, $outId = null) {

        $request = new SendSmsRequest();
        $request->setPhoneNumbers($phoneNumbers);
        $request->setSignName($signName);
        $request->setTemplateCode($templateCode);
        if($templateParam) {
            $request->setTemplateParam(json_encode($templateParam));
        }
        if($outId) {
            $request->setOutId($outId);
        }
        $acsResponse = $this->acsClient->getAcsResponse($request);
        return $acsResponse;
    }
}


class CryptDes {
    var $key;
    var $iv;
    function CryptDes($key, $iv){
        $this->key = $key;
        $this->iv = $iv;
    }
    function encrypt($input){
        $size = mcrypt_get_block_size(MCRYPT_DES,MCRYPT_MODE_CBC); //3DES加密将MCRYPT_DES改为MCRYPT_3DES
        $input = $this->pkcs5_pad($input, $size); //如果采用PaddingPKCS7，请更换成PaddingPKCS7方法。
        $key = str_pad($this->key,8,'0'); //3DES加密将8改为24
        $td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_CBC, '');
        if( $this->iv == '' )
        {
            $iv = @mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        }
        else
        {
            $iv = $this->iv;
        }
        @mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);//如需转换二进制可改成 bin2hex 转换
        return $data;
    }
    function decrypt($encrypted){
        $encrypted = base64_decode($encrypted); //如需转换二进制可改成 bin2hex 转换
        $key = str_pad($this->key,8,'0'); //3DES加密将8改为24
        $td = mcrypt_module_open(MCRYPT_DES,'',MCRYPT_MODE_CBC,'');//3DES加密将MCRYPT_DES改为MCRYPT_3DES
        if( $this->iv == '' )
        {
            $iv = @mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        }
        else
        {
            $iv = $this->iv;
        }
        $ks = mcrypt_enc_get_key_size($td);
        @mcrypt_generic_init($td, $key, $iv);
        $decrypted = mdecrypt_generic($td, $encrypted);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $y=$this->pkcs5_unpad($decrypted);
        return $y;
    }
    function pkcs5_pad ($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
    function pkcs5_unpad($text){
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad){
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }
    function PaddingPKCS7($data) {
        $block_size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);//3DES加密将MCRYPT_DES改为MCRYPT_3DES
        $padding_char = $block_size - (strlen($data) % $block_size);
        $data .= str_repeat(chr($padding_char),$padding_char);
        return $data;
    }
}