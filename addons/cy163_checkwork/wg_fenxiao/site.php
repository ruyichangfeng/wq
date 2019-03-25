<?php
/**
 * wg分销模块
 * @author zzq
 * @url http://bbs.we7.cc/
 */

error_reporting(0);

defined('IN_IA') or exit('Access Denied');
define('APP_NAME', 'wg_fenxiao');
define('STATIC_ROOT','/addons/wg_fenxiao/recouse');
class Wg_fenxiaoModuleSite extends WeModuleSite {

    public $_web    = 'web';
    public $_mobile = 'mobile';
    public $isMobile;
    public $isWeb;

    public $configs;

    //模板变量
    public $_tpl_var = [];

    public function __construct()
    {
        global $_W, $_GPC;
        define('ADDON_PATH', IA_ROOT."/addons/" . APP_NAME);
        define('STATIC_PATH',"../addons/{$_GPC['m']}/static/");

        include_once ADDON_PATH.'/function/global.func.php';
        include_once ADDON_PATH.'/lib/BaseController.php';
        include_once ADDON_PATH.'/lib/MobileBaseController.php';
        include_once ADDON_PATH.'/lib/WebBaseController.php';
        include_once ADDON_PATH.'/lib/BaseModel.php';

        //autoload
        include_once ADDON_PATH.'/lib/ClassLoader.php';

        $classLoader = new ClassLoader();

        //注册自动加载路径

        $classLoader->addPrefix('',ADDON_PATH.'/model');
        $classLoader->register();

    }

    //重写父类的call方法
    public function __call($name, $arguments) {
        $this->isWeb = stripos($name, 'doWeb') === 0;
        $this->isMobile = stripos($name, 'doMobile') === 0;
        //
        global $_W, $_GPC;
        $action = (string) $_GPC['op'];
        $action = $action ? $action : 'index';
        $controllerDir = IA_ROOT.'/addons/'.$this->modulename.'/controller/';
        $actionFunc = strtolower($action);
        $controller = '';
        //网站配置
        $this->configs = $this->module;
        if ($this->isMobile || $this->isWeb) {
            $dir = IA_ROOT . '/addons/' . $this->modulename . '/inc/';

            if ($this->isMobile) {
                $controller   = ucfirst(substr($name, 8));
                $controllerDir .= 'mobile/';
            }else{
                $controller    = ucfirst(substr($name, 5));
                $controllerDir .= 'web/';
            }

            if($this->isWeb) {
                if($controller == 'Index') {
                    $controller = 'Adv';
                }
            }


            if($this->isWeb && in_array($controller,['Orders'])) {
                if($controller == 'Orders' && in_array($actionFunc,['orderdetail','addmarket']) ) {
                }else {
                    $dir.= 'web/';
                    $fun = strtolower(substr($name, 5));
                    $file = $dir . $fun . '.inc.php';
                    if (file_exists($file)) {
                        $this->__web($file);
                    }
                }
            }elseif ($this->isWeb && !in_array($controller,['Comment','Article','Buying','Adv','Agent'])) {

                $dir.= 'web/';
                $fun = strtolower(substr($name, 5));
                $file = $dir . $fun . '.inc.php';
                if (file_exists($file)) {
                    $this->__web($file);
                }
            }

            $controllerName = $controller.'Controller';
            $file = $controllerDir."$controllerName.php";
            if (!file_exists($file)) {
                trigger_error("访问的路径 {$controllerName} 不存在.", E_USER_WARNING);
            }


            require $file;

            $controllerEntity = new $controllerName();
            if (!method_exists($controllerEntity, $actionFunc)) {
                trigger_error("访问的路径 {$controllerName} 方法{$actionFunc}不存在.", E_USER_WARNING);
            }

            define('WG_APP_MODULE', strtolower($controller));
            define('WG_APP_METHOD', $actionFunc);
            $controllerEntity->site = $this;
            if(method_exists($controllerEntity, 'init')) {
                $controllerEntity->init();
            }
            if($arguments) {
                return $controllerEntity->$actionFunc($arguments[0]);
            }else {
                return $controllerEntity->$actionFunc();
            }

            return;
        }
        trigger_error("访问的方法 {$name} 不存在.", E_USER_WARNING);
        
        return null;
    }
    /**
     * [__web web端公共函数]
     * @param  [type] $file [引入的文件名]
     * @return [type]       [description]
     */
    protected function __web($file) {

        global $_GPC, $_W;
        load()->func('tpl');
        require $file;
        exit;
    }

    /**
     * [checkHaveMember 检查是否注册了会员]
     * @param  [type] $openid [description]
     * @param  [type] $weid   [description]
     * @return [type]         [description]
     */
    protected function checkHaveMember($openid, $weid) {
        if (!empty($_SESSION['wg_member_id'])) {

            return $_SESSION['wg_member_id'];
        }
        //1.检查是否注册了会员
        $sql = "SELECT id FROM " . tablename('wg_fenxiao_member') . " where openid=:openid AND weid=:weid ORDER BY `id` ASC LIMIT 1";
        $member = pdo_fetch($sql, array(
            ':openid' => $openid,
            ':weid' => $weid
        ));
        if (!empty($member)) {
            //更新会员数据
            $acc = WeAccount::create(); //获取account
            $userinfo = $acc->fansQueryInfo($openid);
            //插入member数据
            $data = array(
                'nickname' => $userinfo['nickname'],
                'avatar' => $userinfo['headimgurl'],
                'follow' => $userinfo['subscribe'],
            );
            pdo_update('wg_fenxiao_member', $data, array(
                'id' => $member['id']
            )); //更新数据
            $_SESSION['wg_member_id'] = $member['id']; //写入session

        } else {

            return false;
        }

        return $member['id'];
    }
    /**
     * [registerMember 立即注册]
     * @param  [type] $openid [description]
     * @param  [type] $weid   [description]
     * @return [type]         [description]
     */
    protected function registerMember($openid, $weid, $father = 0) {
        $acc = WeAccount::create(); //获取account
        $userinfo = $acc->fansQueryInfo($openid);
        //插入member数据
        $data = array(
            'weid' => $weid,
            'openid' => $openid,
            'nickname' => $userinfo['nickname'],
            'avatar' => $userinfo['headimgurl'],
            'follow' => $userinfo['subscribe'],
            'parent_id' => $father
        );
        pdo_insert('wg_fenxiao_member', $data);
        $data['id'] = pdo_insertid();
        
        return $data;
    }
    /**
     * [getParents 获取三级父亲信息数组]
     * @param  [type] $parent_id [description]
     * @return [type]            [description]
     */
    protected function getParents($parent_id) {
        $arr = array();
        $parent1 = $this->getMyInfo($parent_id);
        if (!empty($parent1)) {
            $arr[1] = $parent1;
            $parent2 = $this->getMyInfo($parent1['parent_id']);
            if (!empty($parent2)) {
                $arr[2] = $parent2;
                $parent3 = $this->getMyInfo($parent2['parent_id']);
                if (!empty($parent3)) {
                    $arr[3] = $parent3;
                }
            }
        }
        
        return $arr;
    }
    /**
     * [getIsAgent description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    protected function getIsAgent($id) {
        $sql = "SELECT weid,isagent,jifen,agentlevel,level_jiang FROM " . tablename('wg_fenxiao_member') . " WHERE `id`=:id";
        $data = pdo_fetch($sql, array(
            ':id' => $id
        ));
        
        return $data;
    }
    /**
     * [getMyInfo 获取自己的id，openid,parent_id]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    protected function getMyInfo($id) {
        $sql = "SELECT id,isagent,openid,nickname,parent_id,agentlevel FROM " . tablename('wg_fenxiao_member') . " WHERE `id`=:id";
        $data = pdo_fetch($sql, array(
            ':id' => $id
        ));
        
        return $data;
    }
    /**
     * [getMyParentAndAgentInfo description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    protected function getMyParentAndAgentInfo($id) {
        $sql = "SELECT weid,isagent,jifen,agentlevel,parent_id FROM " . tablename('wg_fenxiao_member') . " WHERE `id`=:id";
        $data = pdo_fetch($sql, array(
            ':id' => $id
        ));
        
        return $data;
    }

    public function payResult($params) {


        file_put_contents(dirname(__FILE__).'/pay.txt',date('Y-m-d H:i:s').var_export($params,true)."\n",FILE_APPEND);
        $site = WeUtility::createModuleSite('wg_fenxiao');
        $method = 'doMobilepayresult';

        $result = $site->$method($params);
    }

    /*
    public function payResult($params) {


        global $_W;
        //一些业务代码
        //根据参数params中的result来判断支付是否成功
        if ($params['result'] == 'success' && $params['from'] == 'notify') {
            //此处会处理一些支付成功的业务代码
            $sql = "SELECT * FROM " . tablename('wg_fenxiao_order') . " WHERE id=:id AND weid=:weid";
            $order = pdo_fetch($sql, array(
                ':id' => $params['tid'],
                ':weid' => $params['uniacid']
            ));
            if(($order['status'] == 0 ) && ($order['orderprice'] == $params['fee'])) {
                //查询商品的类型是否是虚拟物品
                $sql_xuni = "SELECT goodstype,goodslianjie,goodspasstype,jifen FROM " . tablename('wg_fenxiao_goods') . " WHERE `id`=:goodsid AND `weid`=:weid";
                $goods_xuni = pdo_fetch($sql_xuni, array(
                    ':goodsid' => $order['goodsid'],
                    ':weid' => $params['uniacid']
                ));
                if ($goods_xuni['goodstype'] == 1) { //虚拟物品
                    $data = array(
                        'status' => 3
                    ); //支付结果
                    //1.更新订单表
                    $res = pdo_update('wg_fenxiao_order', $data, array(
                        'id' => $params['tid'],
                        'weid' => $params['uniacid']
                    ));
                    if ($res > 0) { //更新订单表成功
                        $data2 = array(
                            'paytype' => $params['type'],
                            'zhifutime' => time() ,
                            'fahuotime' => time() ,
                            'shouhuotime' => time()
                        ); //支付结果
                        if ($params['type'] == 'wechat') {
                            $data2['transid'] = $params['tag']['transaction_id']; //微信支付订单号
                            
                        } elseif ($params['type'] == 'alipay') {
                            $data2['transid'] = isset($params['transid']) ? $params['transid'] : 0; //支付宝支付订单号
                            
                        }
                        //0.更新订单表
                        pdo_update('wg_fenxiao_order', $data2, array(
                            'id' => $params['tid'],
                            'weid' => $params['uniacid']
                        ));
                        //1.改变isagent的状态  单数，钱数
                        $this->editIsAgent($order['memberid'], $params['uniacid']);
                        $userinfo = $this->getMyInfo($order['memberid']);
                        if (!empty($this->module['config']['goumaisanji'])) {
                            //2.给自己购买成功通知
                            $this->sendZijiGouMaiTongZhi($userinfo, $this->module['config']['goumaisanji'], $order, $params['uniacid'], $goods_xuni['jifen']);
                            //3.给往上3代发购买成功通知
                            $this->sendSanJiGouMai($userinfo, $this->module['config']['goumaisanji'], $order, $params['uniacid']);
                        }
                        //4.发送物品链接
                        if (!empty($goods_xuni['goodslianjie'])) {
                            $custom = array(
                                'msgtype' => 'text',
                                'text' => array(
                                    'content' => urlencode('您购买的商品的链接为：' . $goods_xuni['goodslianjie'])
                                ) ,
                                'touser' => $userinfo['openid'],
                            );
                            $acc = WeAccount::create($params['uniacid']); //获取account
                            $acc->sendCustomNotice($custom);
                        }
                        //4-2.发送卡密
                        if (!empty($goods_xuni['goodspasstype'])) {
                            //修改卡密
                            $sql = 'SELECT * FROM ' . tablename('wg_fenxiao_passwds') . ' WHERE `weid` = :weid AND `status`=0 AND `type`=:type ORDER BY `createtime` ASC LIMIT 1';
                            $list_xuni = pdo_fetch($sql, array(
                                ':weid' => $params['uniacid'],
                                ':type' => $goods_xuni['goodspasstype']
                            ));
                            if (!empty($list_xuni)) {
                                $xuni_content = $list_xuni['code'];
                                //update密码库，openid和status=1
                                $xunxi_data = array(
                                    'status' => 1,
                                    'openid' => $params['user']
                                );
                                pdo_update('wg_fenxiao_passwds', $xunxi_data, array(
                                    'id' => $list_xuni['id']
                                ));
                            }
                            //查出密码种类的名称
                            $sql_xuni_type = 'SELECT name FROM ' . tablename('wg_fenxiao_passwd_type') . ' WHERE `id`=:type AND `weid` = :weid';
                            $xuni_type = pdo_fetchcolumn($sql_xuni_type, array(
                                ':weid' => $params['uniacid'],
                                ':type' => $goods_xuni['goodspasstype']
                            ));
                            $xuni_huifu = !empty($this->module['config']['kami']) ? $this->module['config']['kami'] : '您购买的商品的卡密或者链接为：{passwd}';
                            $xuni_huifu = str_replace('{passwd}', $xuni_content, $xuni_huifu);
                            $xuni_huifu = str_replace('{type}', $xuni_type, $xuni_huifu);
                            $custom = array(
                                'msgtype' => 'text',
                                'text' => array(
                                    'content' => urlencode($xuni_huifu)
                                ) ,
                                'touser' => $userinfo['openid'],
                            );
                            $acc = WeAccount::create($params['uniacid']); //获取account
                            $acc->sendCustomNotice($custom);
                        }
                        //5.发送红包
                        $nohongbao = $this->getNoHongbao();
                        if ($order['parent1'] > 0 && $order['commision1'] >= 1) {
                            if (in_array($order['parent1'], $nohongbao)) {
                                $this->addYiFaYongJin($order['parent1'], $order['commision1']);
                            } else {
                                $parent1 = $this->getMyInfo($order['parent1']);
                                $res1 = $this->send_xjhb($order['ordersn'], 1, $parent1['openid'], $order['commision1'] * 100, $params['uniacid']);
                                $this->doResultHongBao($res1, $order['id'], 1, $order['parent1'], $order['commision1'], $order['ordersn'], $parent1['openid'], $order['weid']);
                            }
                        }
                        if ($order['parent2'] > 0 && $order['commision2'] >= 1) {
                            if (in_array($order['parent2'], $nohongbao)) {
                                $this->addYiFaYongJin($order['parent2'], $order['commision2']);
                            } else {
                                $parent2 = $this->getMyInfo($order['parent2']);
                                $res2 = $this->send_xjhb($order['ordersn'], 2, $parent2['openid'], $order['commision2'] * 100, $params['uniacid']);
                                $this->doResultHongBao($res2, $order['id'], 2, $order['parent2'], $order['commision2'], $order['ordersn'], $parent2['openid'], $order['weid']);
                            }
                        }
                        if ($order['parent3'] > 0 && $order['commision3'] >= 1) {
                            if (in_array($order['parent3'], $nohongbao)) {
                                $this->addYiFaYongJin($order['parent3'], $order['commision3']);
                            } else {
                                if($order['commision3'] >200){
                                    $parent3 = $this->getMyInfo($order['parent3']);
                                    $res3 = $this->send_xjhb($order['ordersn'], 3, $parent3['openid'], 200 * 100, $params['uniacid']);
                                    $this->doResultHongBao($res3, $order['id'], 3, $order['parent3'], 200, $order['ordersn'], $parent3['openid'], $order['weid']);
                                    sleep(10);
                                    $res32 = $this->send_xjhb($order['ordersn'], 32, $parent3['openid'], ($order['commision3']-200) * 100, $params['uniacid']);
                                    $this->doResultHongBao($res32, $order['id'], 32, $order['parent3'], $order['commision3']-200, $order['ordersn'], $parent3['openid'], $order['weid']);
                                }else{
                                    $parent3 = $this->getMyInfo($order['parent3']);
                                    $res3 = $this->send_xjhb($order['ordersn'], 3, $parent3['openid'], $order['commision3'] * 100, $params['uniacid']);
                                    $this->doResultHongBao($res3, $order['id'], 3, $order['parent3'], $order['commision3'], $order['ordersn'], $parent3['openid'], $order['weid']);
                                }
                            }
                        }
                    }
                } else { //实物不是虚拟物品
                    $data = array(
                        'status' => 1
                    ); //支付结果
                 
                    //1.更新订单表
                    $res = pdo_update('wg_fenxiao_order', $data, array(
                        'id' => $params['tid'],
                        'weid' => $params['uniacid']
                    ));
                    if ($res > 0) { //更新订单表成功
                        $data2 = array(
                            'paytype' => $params['type'],
                            'zhifutime' => time()
                        ); //支付结果
                        if ($params['type'] == 'wechat') {
                            $data2['transid'] = $params['tag']['transaction_id']; //微信支付订单号
                            
                        } elseif ($params['type'] == 'alipay') {
                            $data2['transid'] = isset($params['transid']) ? $params['transid'] : 0; //支付宝支付订单号
                            
                        }
                        //1.更新订单表
                        pdo_update('wg_fenxiao_order', $data2, array(
                            'id' => $params['tid'],
                            'weid' => $params['uniacid']
                        ));
                        //1.改变isagent的状态  单数，钱数
                        $this->editIsAgent($order['memberid'], $params['uniacid']);
                        $userinfo = $this->getMyInfo($order['memberid']);
                        if (!empty($this->module['config']['goumaisanji'])) {
                            //2.给自己购买成功通知
                            $this->sendZijiGouMaiTongZhi($userinfo, $this->module['config']['goumaisanji'], $order, $params['uniacid'], $goods_xuni['jifen']);
                            //3.给往上3代发购买成功通知
                            $this->sendSanJiGouMai($userinfo, $this->module['config']['goumaisanji'], $order, $params['uniacid']);
                        }
                    }
                }
                if (!empty($this->module['config']['seller']) && !empty($this->module['config']['dingdanshengcheng'])) {
                    //给商家发送通知
                    $this->sendSellerTongZhi($params['uniacid'], $this->module['config']['seller'], $this->module['config']['dingdanshengcheng'], $order);
                }
                //2.虚拟物品和真实物品都要减少库存
				$kucun = $this->module['config']['jkcun'];
                $sql_ku = "UPDATE " . tablename('wg_fenxiao_goods') . " SET total=total-" . $order['total'] * $kucun . " WHERE id=:id";
                pdo_query($sql_ku, array(
                    ':id' => $order['goodsid']
                ));       
                //3.新增下级购买1次，增加多少分
                if($this->module['config']['xiajirenshu'] > 0){
                    $jifen = $this->module['config']['xiajirenshu']+0;
                    $this->xiajirenshu($jifen,$order);
                }
            }
        }
        //因为支付完成通知有两种方式 notify，return,notify为后台通知,return为前台通知，需要给用户展示提示信息
        //return做为通知是不稳定的，用户很可能直接关闭页面，所以状态变更以notify为准
        //如果消息是用户直接返回（非通知），则提示一个付款成功
        if ($params['from'] == 'return') {
            if ($params['result'] == 'success') {
                message('支付成功！', $this->createMobileUrl('myorder') , 'success');
            } else {
                message('支付失败！', $this->createMobileUrl('myorder') , 'error');
            }
        }
    }
    */
    protected function editIsAgent($fenxiao_member_id, $weid) {
        $myallinfo = $this->getIsAgent($fenxiao_member_id);
        $tiaojian = $this->module['config']['dailitiaojian'];
        if ($myallinfo['isagent'] == 0) {
            if ($tiaojian == 2) { //如果是购买多少单
                $curr_goumai_sql = "SELECT count(*) FROM " . tablename('wg_fenxiao_order') . " WHERE memberid=:memberid AND status>=1 AND weid=:weid";
                $curr_goumai = pdo_fetchcolumn($curr_goumai_sql, array(
                    ':memberid' => $fenxiao_member_id,
                    ':weid' => $weid
                ));
                $yaoqiu_goumai = $this->module['config']['goumaidanshu'];
                if ($curr_goumai >= $yaoqiu_goumai) {
                    pdo_update("wg_fenxiao_member", array(
                        'isagent' => 1,
                        'agenttime' => time()
                    ) , array(
                        'id' => $fenxiao_member_id,
                        'weid' => $weid
                    ));
                }
            } elseif ($tiaojian == 3) {
                $curr_money_sql = "SELECT sum(`orderprice`) FROM " . tablename('wg_fenxiao_order') . " WHERE memberid=:memberid AND status>=1 AND weid=:weid";
                $curr_money = pdo_fetchcolumn($curr_money_sql, array(
                    ':memberid' => $fenxiao_member_id,
                    ':weid' => $weid
                ));
                $yaoqiu_money = $this->module['config']['goumaiqianshu'];
                if ($curr_money >= $yaoqiu_money) {
                    pdo_update("wg_fenxiao_member", array(
                        'isagent' => 1,
                        'agenttime' => time()
                    ) , array(
                        'id' => $fenxiao_member_id,
                        'weid' => $weid
                    ));
                }
            }
        } else {
            if ($tiaojian == 2) { //如果是购买多少单
                $curr_goumai_sql = "SELECT count(*) FROM " . tablename('wg_fenxiao_order') . " WHERE memberid=:memberid AND status>=1 AND weid=:weid";
                $curr_goumai = pdo_fetchcolumn($curr_goumai_sql, array(
                    ':memberid' => $fenxiao_member_id,
                    ':weid' => $weid
                ));
                $yaoqiu_goumai = $this->module['config']['goumaidanshu'];
                if ($curr_goumai < $yaoqiu_goumai) {
                    pdo_update("wg_fenxiao_member", array(
                        'isagent' => 0,
                        'agenttime' => time()
                    ) , array(
                        'id' => $fenxiao_member_id,
                        'weid' => $weid
                    ));
                }
            } elseif ($tiaojian == 3) {
                $curr_money_sql = "SELECT sum(`orderprice`) FROM " . tablename('wg_fenxiao_order') . " WHERE memberid=:memberid AND status>=1 AND weid=:weid";
                $curr_money = pdo_fetchcolumn($curr_money_sql, array(
                    ':memberid' => $fenxiao_member_id,
                    ':weid' => $weid
                ));
                $yaoqiu_money = $this->module['config']['goumaiqianshu'];
                if ($curr_money < $yaoqiu_money) {
                    pdo_update("wg_fenxiao_member", array(
                        'isagent' => 0,
                        'agenttime' => time()
                    ) , array(
                        'id' => $fenxiao_member_id,
                        'weid' => $weid
                    ));
                }
            }
        }
    }

    /**
     * [sendSanJiGouMai description]
     * @param  [type] $userinfo   [description]
     * @param  [type] $templateid [description]
     * @param  [type] $order      [description]
     * @param  [type] $weid       [description]
     * @return [type]             [description]
     */
    /*
    protected function sendSanJiGouMai($userinfo, $templateid, $order, $weid) {
        $acc = WeAccount::create($weid); //获取account
        $parents = $this->getParents($userinfo['parent_id']);
        
        foreach ($parents as $key => $value) {
            //增加积分
            $parent_key = 'parent' . $key;
            $order_parent = $order[$parent_key];
            if ($this->module['config']['xiajijifen'] == '$') {
                $kkk = 'commision' . $key;
                $jifen = $order[$kkk];
            } else {
                if ($order_parent == 0) {
                    $jifen = 0;
                } else {
                    $jifen = $this->module['config']['xiajijifen'];
                }
            }
				if($key == 1){
				$name = '虎将';
			}	
			if($key == 2){
				$name = '大将';
			}	
			if($key == 3){
				$name = '福将';
			}
            if ($jifen > 0) {
                $this->addJifen($value['id'], $jifen, $name . '昵称:' . $userinfo['nickname'] . '购买' . $order['ordersn'] . '获的积分' . $jifen, $weid);
            }
		
			
            $data = array(
                'first' => array(
                    'value' => '恭喜您的' . $name . ':' . $userinfo['nickname'] . ($order_parent > 0 ? '购买了商品，您将获得佣金' : '由于您当时不是正式分销商或者不在接受红包的人数范围，不能获取佣金') ,
                    'color' => '#173177'
                ) ,
                'keyword1' => array(
                    'value' => $order['ordersn'],
                    'color' => '#173177'
                ) ,
                'keyword2' => array(
                    'value' => $order['total'],
                    'color' => '#173177'
                ) ,
                'keyword3' => array(
                    'value' => $order['orderprice'],
                    'color' => '#173177'
                ) ,
                'keyword4' => array(
                    'value' => $jifen,
                    'color' => '#173177'
                ) ,
                'remark' => array(
                    'value' => '感谢您的推广',
                    'color' => '#173177'
                )
            );
            $acc->sendTplNotice($value['openid'], $templateid, $data);
        }
    }
    /**
     * [sendZijiGouMaiTongZhi description]
     * @param  [type] $openid     [description]
     * @param  [type] $templateid [description]
     * @param  [type] $order      [description]
     * @param  [type] $weid       [description]
     * @return [type]             [description]
     */
    protected function sendZijiGouMaiTongZhi($userinfo, $templateid, $order, $weid, $jifen) {
        $acc = WeAccount::create($weid); //获取account
        //增加积分
        // $res = pdo_query("SELECT * FROM ".tablename('wg_fenxiao_member')." WHERE id = :member_id", array(
        //     ':member_id' => $userinfo['id'],
        // ));
        // if($res['jifen'] == 0){
        //   $this->addJifen($userinfo['id'], $jifen, '自己 (' . $userinfo['nickname'] . ')购买' . $order['ordersn'] . '增加' . $jifen, $weid);
        // }
        $data = array(
            'first' => array(
                'value' => '您好，您购买的商品支付成功',
                'color' => '#173177'
            ) ,
            'keyword1' => array(
                'value' => $order['ordersn'],
                'color' => '#173177'
            ) ,
            'keyword2' => array(
                'value' => $order['total'],
                'color' => '#173177'
            ) ,
            'keyword3' => array(
                'value' => $order['orderprice'],
                'color' => '#173177'
            ) ,
            'keyword4' => array(
                'value' => $jifen,
                'color' => '#173177'
            ) ,
            'remark' => array(
                'value' => '欢迎再次光临',
                'color' => '#173177'
            )
        );
        $acc->sendTplNotice($userinfo['openid'], $templateid, $data);
    }
    /**
     * [fahuotongzhi description]
     * @param  [type] $openid       [description]
     * @param  [type] $weid         [description]
     * @param  [type] $templateid   [description]
     * @param  [type] $kuaidigongsi [description]
     * @param  [type] $kuaidihao    [description]
     * @param  [type] $goodsinfo    [description]
     * @param  [type] $goodsnum     [description]
     * @param  [type] $dizhiinfo    [description]
     * @return [type]               [description]
     */
    public function fahuotongzhi($openid, $weid, $templateid, $kuaidigongsi, $kuaidihao, $goodsinfo, $goodsnum, $dizhiinfo) {
        $acc = WeAccount::create($weid); //获取account
        $data = array(
            'first' => array(
                'value' => '您好，您购买的商品已发货。',
                'color' => '#173177'
            ) ,
            'keyword1' => array(
                'value' => $kuaidigongsi,
                'color' => '#173177'
            ) ,
            'keyword2' => array(
                'value' => $kuaidihao,
                'color' => '#173177'
            ) ,
            'keyword3' => array(
                'value' => $goodsinfo,
                'color' => '#173177'
            ) ,
            'keyword4' => array(
                'value' => $goodsnum,
                'color' => '#173177'
            ) ,
            'remark' => array(
                'value' => '您的收货信息是：' . $dizhiinfo,
                'color' => '#173177'
            )
        );
        $query['do'] = 'myorder';
        $query['status'] = 2;
        $query['m'] = strtolower($this->modulename);
        $url = murl('entry', $query, 1, 1);
        $acc->sendTplNotice($openid, $templateid, $data, $url);
    }
    public function sendQuXiaoFaHuo($templateid, $weid, $item) {
        $acc = WeAccount::create($weid); //获取account
        $data = array(
            'first' => array(
                'value' => '您好，您的定单已经取消',
                'color' => '#173177'
            ) ,
            'keyword1' => array(
                'value' => $item['ordersn'],
                'color' => '#173177'
            ) ,
            'keyword2' => array(
                'value' => date('Y-m-d H:i:s', time()) ,
                'color' => '#173177'
            ) ,
            'remark' => array(
                'value' => '如有疑问，请联系我们客服',
                'color' => '#173177'
            )
        );
        $acc->sendTplNotice($item['openid'], $templateid, $data);
    }


    protected function sendSellerTongZhi($weid, $seller, $templateid, $order) {
        $acc = WeAccount::create($weid); //获取account
        $sql = "SELECT goodsname,seller FROM " . tablename('wg_fenxiao_goods') . " WHERE id=:id";
        $goods = pdo_fetch($sql, array(
            ':id' => $order['goodsid']
        ));
        $data = array(
            'first' => array(
                'value' => '商家您好，有客户新下订单',
                'color' => '#173177'
            ) ,
            'keyword1' => array(
                'value' => date('Y-m-d H:i:s', time()) ,
                'color' => '#173177'
            ) ,
            'keyword2' => array(
                'value' => $goods['goodsname'],
                'color' => '#173177'
            ) ,
            'keyword3' => array(
                'value' => $order['ordersn'],
                'color' => '#173177'
            ) ,
            'remark' => array(
                'value' => '购买数量为：' . $order['total'] . ',买家已付款',
                'color' => '#173177'
            )
        );
        if (!empty($goods['seller'])) {
            $seller = $goods['seller'];
        }
        $acc->sendTplNotice($seller, $templateid, $data);
    }
	

	private function sendPost($url, $datas) {
		$temps = array();	
		foreach ($datas as $key => $value) {
			$temps[] = sprintf('%s=%s', $key, $value);		
		}	
		$post_data = implode('&', $temps);
		$url_info = parse_url($url);
		if(empty($url_info['port']))
		{
			$url_info['port']=80;	
		}
		$httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
		$httpheader.= "Host:" . $url_info['host'] . "\r\n";
		$httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
		$httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
		$httpheader.= "Connection:close\r\n\r\n";
		$httpheader.= $post_data;
		$fd = fsockopen($url_info['host'], $url_info['port']);
		fwrite($fd, $httpheader);
		$gets = "";
		$headerFlag = true;
		while (!feof($fd)) {
			if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
				break;
			}
		}
		while (!feof($fd)) {
			$gets.= fread($fd, 128);
		}
		fclose($fd);  
		
		return $gets;
	}
	
	private function arrayRecursive(&$array, $function, $apply_to_keys_also = false)  
	{  
		static $recursive_counter = 0;  
		if (++$recursive_counter > 1000) {  
			die('possible deep recursion attack');  
		}  
		foreach ($array as $key => $value) {  
			if (is_array($value)) {  
				$this->arrayRecursive($array[$key], $function, $apply_to_keys_also);  
			} else {  
				$array[$key] = $function($value);  
			}  
	   
			if ($apply_to_keys_also && is_string($key)) {  
				$new_key = $function($key);  
				if ($new_key != $key) {  
					$array[$new_key] = $array[$key];  
					unset($array[$key]);  
				}  
			}  
		}  
		$recursive_counter--;  
	} 
	
	private function JSON($array) {  
		$this->arrayRecursive($array, 'urlencode', true);  
		$json = json_encode($array);  
		return urldecode($json);  
	}
	
    /**
     * [changeWechatSend description]
     * @param  [type] $id     [description]
     * @param  [type] $status [description]
     * @param  string $msg    [description]
     * @return [type]         [description]
     */
    private function changeWechatSend($id, $status, $msg = '') {
        global $_W;
        $paylog = pdo_fetch("SELECT plid, openid, tag FROM " . tablename('core_paylog') . " WHERE tid = '{$id}' AND status = 1 AND type = 'wechat'");
        if (!empty($paylog['openid'])) {
            $paylog['tag'] = iunserializer($paylog['tag']);
            $acid = $paylog['tag']['acid'];
            $account = account_fetch($acid);
            $payment = uni_setting($account['uniacid'], 'payment');
            if ($payment['payment']['wechat']['version'] == '2') {
                
                return true;
            }
            $send = array(
                'appid' => $account['key'],
                'openid' => $paylog['openid'],
                'transid' => $paylog['tag']['transaction_id'],
                'out_trade_no' => $paylog['plid'],
                'deliver_timestamp' => TIMESTAMP,
                'deliver_status' => $status,
                'deliver_msg' => $msg,
            );
            $sign = $send;
            $sign['appkey'] = $payment['payment']['wechat']['signkey'];
            ksort($sign);
            $string = '';
            
            foreach ($sign as $key => $v) {
                $key = strtolower($key);
                $string.= "{$key}={$v}&";
            }
            $send['app_signature'] = sha1(rtrim($string, '&'));
            $send['sign_method'] = 'sha1';
            $account = WeAccount::create($acid);
            $response = $account->changeOrderStatus($send);
            if (is_error($response)) {
                message($response['message']);
            }
        }
    }
    /**
     * [addJifen 增加积分的方法]
     * @param [type] $member_id [description]
     * @param [type] $jifen     [description]
     */
    protected function addJifen($member_id, $jifen, $shuoming, $weid) {
        $jifen = $jifen + 0;
        $sql = "UPDATE " . tablename('wg_fenxiao_member') . " SET `jifen`=jifen+:jifen WHERE id=:member_id";
        $res = pdo_query($sql, array(
              ':member_id' => $member_id,
              ':jifen'     => $jifen
          ));
        if ($res) {
            $this->addJifenMingXi($member_id, $jifen, $shuoming); //写入明细
            //如果是agent，增加分销商等级
            $isagent = $this->getIsAgent($member_id);
            //如果是分销商，检查等级
            if ($isagent['isagent'] == 1) {
                $this->editAgentLevel($isagent['jifen'], $member_id, $isagent['agentlevel'], $weid);
            }
        }
    }
    /**
     * [editAgentLevel 修改member等级]
     * @param  [type] $jifen     [description]
     * @param  [type] $member_id [description]
     * @return [type]            [description]
     */
    public function editAgentLevel($jifen, $member_id, $cur_level, $weid) {
        $sql = "SELECT `jifen`,`level`,`yicijiangli` FROM " . tablename('wg_fenxiao_member_level') . " WHERE jifen<=:jifen AND weid=:weid ORDER BY level DESC LIMIT 1";
        $agentLevl = pdo_fetch($sql, array(
            ':jifen' => $jifen,
            ':weid'  => $weid + 0
        ));
        if (!empty($agentLevl)) {
            if ($cur_level != $agentLevl['level']) {
                //升级有升级奖
                if ($agentLevl['level'] > $cur_level) {
                    $data['level_jiang'] = $agentLevl['level'];
                }
                $data['agentlevel'] = $agentLevl['level'];
                pdo_update('wg_fenxiao_member', $data, array(
                    'id' => $member_id
                ));
            }
        } else {
            $data = array(
                'agentlevel' => 0
            );
            pdo_update('wg_fenxiao_member', $data, array(
                'id' => $member_id
            ));
        }
    }
    /**
     * [addJifenMingXi 增加积分明细]
     * @param [type] $memberid [description]
     * @param [type] $jifen    [description]
     * @param [type] $shuoming [description]
     */
    protected function addJifenMingXi($memberid, $jifen, $shuoming) {
        $data = array(
            'memberid'   => $memberid + 0,
            'jifen'      => $jifen + 0,
            'shuoming'   => $shuoming,
            'createtime' => time()
        );
        pdo_insert('wg_fenxiao_jifen_mingxi', $data);
    }
    /**
     * [getZheKou 获取商品折扣]
     * @param  [type] $memberid [description]
     * @return [type]           [description]
     */
    public function getZheKou($memberid) {
        $agent = $this->getIsAgent($memberid); //weid,isagent,jifen,agentlevel
        if ($agent['isagent'] == 0 || $agent['agentlevel'] == 0) {
            
            return 10;
        }
        $sql = "SELECT zhekou FROM " . tablename('wg_fenxiao_member_level') . " WHERE `level`=:level AND `weid`=:weid";
        $agentLevl = pdo_fetch($sql, array(
            ':level' => $agent['agentlevel'],
            ':weid' => $agent['weid']
        ));
        
        return $agentLevl['zhekou'];
    }
    /**
     * [getYongJinBiLi 获取佣金比例]
     * @param  [type] $getMyParentAndAgentInfo [description]
     * @return [type]                          [description]
     */
    protected function getYongJinBiLi($getMyParentAndAgentInfo) {
        if ($getMyParentAndAgentInfo['isagent'] == 0 || $getMyParentAndAgentInfo['agentlevel'] == 0) {
            $arr = array();
            $arr['yijiyongjin'] = $this->module['config']['yijiyongjin'];
            $arr['erjiyongjin'] = $this->module['config']['erjiyongjin'];
            $arr['sanjiyongjin'] = $this->module['config']['sanjiyongjin'];
            
            return $arr;
        }
        $sql = "SELECT yijiyongjin,erjiyongjin,sanjiyongjin FROM " . tablename('wg_fenxiao_member_level') . " WHERE `level`=:level AND `weid`=:weid";
        $agentLevl = pdo_fetch($sql, array(
            ':level' => $getMyParentAndAgentInfo['agentlevel'],
            ':weid' => $getMyParentAndAgentInfo['weid']
        ));
        
        return $agentLevl;
    }
    /**
     * [autofinishorder 自动完成订单]
     * @param  [type]  $weid      [description]
     * @param  boolean $needcheck [description]
     * @return [type]             [description]
     */
    protected function autofinishorder($weid, $needcheck = false) {
        if (empty($_COOKIE['myfinish' . $weid]) || $needcheck == true) {
            $autofinish = ($this->module['config']['querenshouhuo']) + 0;
            if (!empty($autofinish)) {
                $autofinishcktime = cache_load('autofinishcktime:' . $weid);
                if (empty($autofinishcktime) || $autofinishcktime <= TIMESTAMP) {
                    $autofinishtime = time() - $autofinish * 24 * 60 * 60;
                    //先查一下哪些订单满足了要求
                    $sql = "SELECT id,ordersn,parent1,commision1,parent2,commision2,parent3,commision3 FROM " . tablename('wg_fenxiao_order') . " WHERE status=2 and fahuotime>0 and fahuotime<:fahuotime and  weid = :weid LIMIT 10";
                    $orders = pdo_fetchall($sql, array(
                        ':weid' => $weid,
                        ':fahuotime' => $autofinishtime
                    ));
                    
                    foreach ($orders as $order) {
                        $data = array(
                            'status' => 3
                        );
                        $res = pdo_update('wg_fenxiao_order', $data, array(
                            'id' => $order['id']
                        ));
                        if ($res) {
                            $data2 = array(
                                'shouhuotime' => time()
                            );
                            $res = pdo_update('wg_fenxiao_order', $data2, array(
                                'id' => $order['id']
                            ));
                            //发送红包
                            $nohongbao = $this->getNoHongbao();
                            if ($order['parent1'] > 0 && $order['commision1'] >= 1) {
                                if (in_array($order['parent1'], $nohongbao)) {
                                    $this->addYiFaYongJin($order['parent1'], $order['commision1']);
                                } else {
                                    $parent1 = $this->getMyInfo($order['parent1']);
                                    $res1 = $this->send_xjhb($order['ordersn'], 1, $parent1['openid'], $order['commision1'] * 100);
                                    $this->doResultHongBao($res1, $order['id'], 1, $order['parent1'], $order['commision1'], $order['ordersn'], $parent1['openid'], $weid);
                                }
                            }
                            if ($order['parent2'] > 0 && $order['commision2'] >= 1) {
                                if (in_array($order['parent2'], $nohongbao)) {
                                    $this->addYiFaYongJin($order['parent2'], $order['commision2']);
                                } else {
                                    $parent2 = $this->getMyInfo($order['parent2']);
                                    $res2 = $this->send_xjhb($order['ordersn'], 2, $parent2['openid'], $order['commision2'] * 100);
                                    $this->doResultHongBao($res2, $order['id'], 2, $order['parent2'], $order['commision2'], $order['ordersn'], $parent2['openid'], $weid);
                                }
                            }
                            if ($order['parent3'] > 0 && $order['commision3'] >= 1) {
                                if (in_array($order['parent3'], $nohongbao)) {
                                    $this->addYiFaYongJin($order['parent3'], $order['commision3']);
                                } else {
                                    if($order['commision3'] >200){
                                        $parent3 = $this->getMyInfo($order['parent3']);
                                        $res3 = $this->send_xjhb($order['ordersn'],3,$parent3['openid'], 200*100);
                                        $this->doResultHongBao($res3, $order['id'], 3, $order['parent3'], 200, $order['ordersn'], $parent3['openid'],$weid);
                                        sleep(10);
                                        $res32 = $this->send_xjhb($order['ordersn'],32,$parent3['openid'], ($order['commision3']-200)*100);
                                        $this->doResultHongBao($res32, $order['id'], 32, $order['parent3'], $order['commision3']-200, $order['ordersn'], $parent3['openid'],$weid);
                                    }else{
                                       $parent3 = $this->getMyInfo($order['parent3']);
                                       $res3 = $this->send_xjhb($order['ordersn'],3,$parent3['openid'], $order['commision3']*100);
                                       $this->doResultHongBao($res3, $order['id'], 3, $order['parent3'], $order['commision3'], $order['ordersn'], $parent3['openid'],$weid); 
                                    }
                                }
                            }
                        }
                    }
                    /////////////////////////////////////
                    cache_write('autofinishcktime:' . $weid, TIMESTAMP + 10 * 60);
                }
            }
            if ($needcheck == false) {
                setcookie('myfinish' . $weid, 1, TIMESTAMP + 20 * 60);
            }
        }
    }
    //现金红包接口
    protected function send_xjhb($ordersn, $p, $fromUser, $amount, $weid = 0) {
        global $_W;
        if (!empty($weid)) {
            $_W['uniacid'] = $weid;
            load()->model('account');
            $accounts = uni_accounts($weid);
            $_W['account']['key'] = $accounts[$weid]['key'];
            $_W['account']['name'] = $accounts[$weid]['name'];
        }
        $payment = uni_setting($_W['uniacid'], array(
            'payment'
        ));
        $paysets = $payment['payment']['wechat'];
        $ret = array();
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        $pars = array();
        $pars['nonce_str'] = random(32); //随机字符串
        $pars['mch_billno'] = substr($ordersn . $p . date('ymdHis') . random(2, 1), 0,28); //商户订单号，想改ordersn+随机字符串
        $pars['mch_id'] = $paysets['mchid']; //商户号
        $pars['wxappid'] = $_W['account']['key'];
        $pars['send_name'] = $_W['account']['name']; //商户名称
        $pars['re_openid'] = $fromUser; //接受用户
        $pars['total_amount'] = $amount;
        $pars['total_num'] = 1;
        $pars['wishing'] = $ordersn . '的' . $p . '级红包。' . $this->module['config']['hongbaozhufu']; //红包祝福
        $pars['client_ip'] = $this->module['config']['honbaoip']; //来自配置文件
        $pars['act_name'] = $this->module['config']['act_name']; //来自配置文件
        $pars['remark'] = $this->module['config']['remark']; //来自配置文件
        ksort($pars, SORT_STRING);
        $string1 = '';
        
        foreach ($pars as $k => $v) {
            $string1.= "{$k}={$v}&";
        }
        $string1.= "key={$paysets['apikey']}"; //商户秘钥
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
        $extras['CAINFO'] = $this->module['config']['rootca'];
        $extras['SSLCERT'] = $this->module['config']['apiclient_cert'];
        $extras['SSLKEY'] = $this->module['config']['apiclient_key'];
        $response = $this->http_request($url, $xml, $extras, 'post');
        $responseObj = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
        $aMsg = (array)$responseObj;
        if (isset($aMsg['err_code'])) {
            $db_data['err_code'] = $aMsg['err_code'];
            $db_data['err_code_des'] = $aMsg['err_code_des'];
        } else {
            $db_data['err_code'] = 'SUCCESS';
            $db_data['err_code_des'] = '发送成功，领取红包';
        }
        $db_data['return_msg'] = serialize($aMsg);
        
        return $db_data;
    }
    protected function http_request($url, $fields = [], $params = [], $method = 'get', $second = 30) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if (isset($params)) {
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, $params['SSLCERT']);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, $params['SSLKEY']);
            curl_setopt($ch, CURLOPT_CAINFO, 'PEM');
            curl_setopt($ch, CURLOPT_CAINFO, $params['CAINFO']);
        }
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }
        $data = curl_exec($ch);
        curl_close($ch);
        
        return $data;
    }
    /**
     * [doResultHongBao 调用红包后的处理]
     * @param  [type]  $db_data   [description]
     * @param  [type]  $orderid   [description]
     * @param  [type]  $p         [description]
     * @param  [type]  $parent_id [description]
     * @param  [type]  $commision [description]
     * @param  [type]  $ordersn   [description]
     * @param  [type]  $fromUser  [description]
     * @param  boolean $again     [description]
     * @return [type]             [description]
     */
    protected function doResultHongBao($db_data, $orderid, $p, $parent_id, $commision, $ordersn, $fromUser, $weid, $again = false) {
        $db_data_msg = unserialize($db_data['return_msg']);
        if ($db_data['err_code'] == 'SUCCESS') {
            //1.红包改为1
            $key = 'hongbao' . $p;
            $data = array(
                $key => $db_data_msg['send_listid']
            );
            pdo_update('wg_fenxiao_order', $data, array(
                'id' => $orderid
            ));
            //2.用户已支付增加金额
            $sql = "UPDATE " . tablename('wg_fenxiao_member') . " SET `commission_pay`=`commission_pay`+:commision WHERE `id`=:id";
            pdo_query($sql, array(
                ':id' => $parent_id,
                ':commision' => $commision
            ));
            //3.查一下失败红包里面有吗
            $sql2 = "SELECT * FROM " . tablename('wg_fenxiao_hongbao_shibai') . " WHERE `orderid`=:orderid AND `p`=:p AND weid=:weid";
            $hongbao_shibai = pdo_fetch($sql2, array(
                ':orderid' => $orderid,
                ':p' => $p,
                ':weid' => $weid
            ));
            if (!empty($hongbao_shibai)) {
                $again = $hongbao_shibai['id'];
            }
            //如果again不等于false，改为已支付，或者删掉
            if (!empty($again)) {
                $id = $again + 0;
                pdo_delete('wg_fenxiao_hongbao_shibai', array(
                    'id' => $id
                ));
            }
        } else {
            $sql2 = "SELECT * FROM " . tablename('wg_fenxiao_hongbao_shibai') . " WHERE `orderid`=:orderid AND `p`=:p AND weid=:weid";
            $hongbao_shibai = pdo_fetch($sql2, array(
                ':orderid' => $orderid,
                ':p' => $p,
                ':weid' => $weid
            ));
            if (empty($hongbao_shibai)) {
                $data = array(
                    'weid' => $weid,
                    'orderid' => $orderid,
                    'ordersn' => $ordersn,
                    'p' => $p,
                    'parent_id' => $parent_id,
                    'fromuser' => $fromUser,
                    'amount' => $commision,
                    'status' => 0,
                    'err_code' => $db_data['err_code'],
                    'err_code_des' => $db_data['err_code_des'],
                    'createtime' => time(),
                    'billno'=>$db_data_msg['mch_billno']
                );
                pdo_insert('wg_fenxiao_hongbao_shibai', $data);
            }else{
                $data_shibai = array(
                    'err_code' => $db_data['err_code'],
                    'err_code_des' => $db_data['err_code_des'],
                    'createtime' => time(),
                    'billno'=>$db_data_msg['mch_billno']
                );
                pdo_update('wg_fenxiao_hongbao_shibai', $data_shibai, array(
                    'id' => $hongbao_shibai['id']
                ));
            }
        }
    }
     //现金红包查询接口
    protected function chaxun_xjhb($mch_billno) {
        global $_W;
        $payment = uni_setting($_W['uniacid'], array(
            'payment'
        ));
        $paysets = $payment['payment']['wechat'];
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo';
        $pars = array();
        $pars['nonce_str'] = random(32); //随机字符串
        $pars['mch_billno'] = $mch_billno; //商户订单号，想改ordersn+随机字符串
        $pars['mch_id'] = $paysets['mchid']; //商户号
        $pars['appid'] = $_W['account']['key'];
        $pars['bill_type'] = 'MCHT'; //来自配置文件
        ksort($pars, SORT_STRING);
        $string1 = '';
        
        foreach ($pars as $k => $v) {
            $string1.= "{$k}={$v}&";
        }
        $string1.= "key={$paysets['apikey']}"; //商户秘钥
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();
        $extras['CAINFO'] = $this->module['config']['rootca'];
        $extras['SSLCERT'] = $this->module['config']['apiclient_cert'];
        $extras['SSLKEY'] = $this->module['config']['apiclient_key'];
        $response = $this->http_request($url, $xml, $extras, 'post');
        $responseObj = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
        $aMsg = (array)$responseObj;
        //如果查询出来了，且不是发送失败好====这个已经发送了
        if($aMsg['return_code'] == 'SUCCESS' && $aMsg['result_code'] == 'SUCCESS'){//如果查询出来了
            if($aMsg['status'] != 'FAILED'){//发送失败了
                return false;
            }
        }
        return true;
    }
    /**
     * [getAllMembers description]
     * @param  [type] $weid [description]
     * @return [type]       [description]
     */
    protected function getAllMembers($weid) {
        //$read_cache_time = cache_load('all_members_cache_time:' . $weid);
        //$read_cache_members = cache_load('all_members:' . $weid);
        //if (empty($read_cache_time) || $read_cache_time < time() || empty($read_cache_members)) {
        $sql = "SELECT id,nickname,parent_id from " . tablename('wg_fenxiao_member') . ' WHERE `weid`=:weid';
        $allMembers = pdo_fetchall($sql, array(
            ':weid' => $weid
        ) , 'id');
        //cache_write('all_members:' . $weid, $allMembers);
        //$cache_time = time() + 3600*24;
        //cache_write('all_members_cache_time:' . $weid, $cache_time);
        
        return $allMembers;
        //}
        
        return $read_cache_members;
    }
    /**
     * [subtree 子孙树]
     * @param  [type]  $arr [description]
     * @param  integer $id  [description]
     * @param  integer $lev [description]
     * @return [type]       [description]
     */
    // protected function subtree($arr, $id = 0, $limt = 0, $lev = 1) {
    //     $subs = array(); // 子孙数组
    //     foreach ($arr as $k => $v) {
    //         if ($v['parent_id'] == $id) {
    //             $v['lev'] = $lev;
    //             if (empty($limt) || (!empty($limt) && $lev < $limt)) {
    //                 $sons = $this->subtree($arr, $v['id'], $limt, $lev + 1);
    //                 if (!empty($sons)) {
    //                     $v['sons'] = $sons;
    //                 }
    //             }
    //             $subs[] = $v; // 举例说找到array('id'=>1,'name'=>'安徽','parent'=>0),
    //         }
    //     }
    //     return $subs;
    // }
    protected function subtree($weid, $id = 0, $limt = 0, $lev = 1) {
        $sql = "SELECT id,nickname,parent_id from " . tablename('wg_fenxiao_member') . ' WHERE `weid`=:weid AND `parent_id`=:parent';
        $arr = pdo_fetchall($sql, array(
            ':weid' => $weid,
            ':parent' => $id
        ));
        $subs = array(); // 子孙数组
        
        foreach ($arr as $k => $v) {
            $v['lev'] = $lev;
            if (empty($limt) || (!empty($limt) && $lev < $limt)) {
                $sons = $this->subtree($weid, $v['id'], $limt, $lev + 1);
                if (!empty($sons)) {
                    $v['sons'] = $sons;
                }
            }
            $subs[] = $v; // 举例说找到array('id'=>1,'name'=>'安徽','parent'=>0),
            
        }
        
        return $subs;
    }
    protected function subtree2($weid, $id = 0, $lev = 1) {
        $sql = "SELECT id,nickname,parent_id from " . tablename('wg_fenxiao_member') . ' WHERE `weid`=:weid AND `parent_id`=:parent';
        $arr = pdo_fetchall($sql, array(
            ':weid' => $weid,
            ':parent' => $id
        ));
        $subs = array(); // 子孙数组
        
        foreach ($arr as $v) {
            $v['lev'] = $lev;
            $subs[] = $v; // 举例说找到array('id'=>1,'name'=>'安徽','parent'=>0),
            if ($lev < 3) {
                $subs = array_merge($subs, $this->subtree2($weid, $v['id'], $lev + 1));
            }
        }
        
        return $subs;
    }
    /**
     * [subtree3 用于计算1代、2代、3代的人数]
     * @param  [type]  $weid       [description]
     * @param  integer $id         [description]
     * @param  [type]  $lev_mubiao [目标代数]
     * @param  integer $lev        [description]
     * @return [type]              [description]
     */
    protected function subtree3($weid, $id, $lev_mubiao) {
        $parent = 'parent'.$lev_mubiao.'='.$id;
        $sql = 'SELECT count(*) FROM ' . tablename('wg_fenxiao_order') . ' as o LEFT JOIN '.tablename('wg_fenxiao_goods').' AS g ON o.goodsid=g.id WHERE g.limitnum=1 AND o.status>=1 AND '.$parent;
        $list = pdo_fetchcolumn($sql);
        return $list;
    }
    /**
     * [getHtmlUl description]
     * @param  [type] $arr [description]
     * @return [type]      [description]
     */
    protected function getHtmlUl($arr) {
        $str = "<ul>";
        
        foreach ($arr as $key => $value) {
            $str.= '<li>';
            $str.= '<span><i class="glyphicon glyphicon-minus-sign"></i> ' . $value['nickname'] . '</span>';
            if (isset($value['sons'])) {
                $str.= $this->getHtmlUl($value['sons']);
            }
            $str.= '</li>';
        }
        $str.= '</ul>';
        
        return $str;
    }
    protected function getLevelName($level, $weid) {
        $level = $level + 0;
        $sql = "SELECT `levelname` FROM " . tablename('wg_fenxiao_member_level') . " WHERE `level`=:level AND `weid`=:weid";
        $levelname = pdo_fetchcolumn($sql, array(
            ':level' => $level,
            ':weid' => $weid
        ));
        
        return $levelname;
    }
    /**
     * [getAddressSignInfo 获取微信地址]
     * @param  [type] $code [description]
     * @param  [type] $url  [description]
     * @return [type]       [description]
     */
    protected function getAddressSignInfo($code, $url) {
        global $_W;
        $oauth_account = WeAccount::create($_W['uniacid']);
        $oauth = $oauth_account->getOauthInfo($code);
        $accesstoken = $oauth['access_token'];
        $noncestr = random(6);
        $Parameters = array();
        $Parameters['accesstoken'] = $accesstoken;
        $Parameters['appid'] = $_W['account']['key'];
        $Parameters['noncestr'] = $noncestr;
        $Parameters['timestamp'] = TIMESTAMP;
        $Parameters['url'] = $url;
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        $addrSign = sha1($String);
        $infoarray = array(
            'appId' => $_W['account']['key'],
            'scope' => 'jsapi_address',
            'signType' => 'sha1',
            'addrSign' => $addrSign,
            'timeStamp' => TIMESTAMP,
            'nonceStr' => $noncestr
        );
        $result_ = json_encode($infoarray);
        
        return $result_;
    }
    private function formatBizQueryParaMap($paraMap, $urlencode) {
        $buff = '';
        ksort($paraMap);
        
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff.= $k . '=' . $v . '&';
        }
        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        
        return $reqPar;
    }
    protected function createPoster($poster, $member, $qr, $upload = true) {
        global $_W;
        load()->func('communication');
        load()->func('file');
        $path = IA_ROOT . "/addons/wg_fenxiao/data/poster/" . $_W['uniacid'] . "/" . substr($_W['openid'], 0, 2) . "/";
        if (!is_dir($path)) {
            load()->func('file');
            mkdirs($path);
        }
        $file = 'qr-' . $_W['openid'] . '.jpg';
        //如果后来编辑了poster，需要删除图片
        if (($poster['createtime'] > $qr['createtime']) || !is_file($path . $file)) {
            file_delete($path . $file);
            $qr['createtime'] = 0;
        }
        if (!is_file($path . $file)) {
            set_time_limit(0);
            @ini_set('memory_limit', '256M');
            $target = imagecreatetruecolor(640, 1008);
            $bg = $this->createImage(tomedia($poster['bg']));
            imagecopy($target, $bg, 0, 0, 0, 0, 640, 1008);
            imagedestroy($bg);
            $data = json_decode(str_replace('&quot;', "'", $poster['data']) , true);
            
            foreach ($data as $d) {
                $d = $this->getRealData($d);
                if ($d['type'] == 'head') {
                    $avatar = preg_replace('/\/0$/i', '/96', $member['avatar']);
                    $target = $this->mergeImage($target, $d, $avatar);
                } else if ($d['type'] == 'img') {
                    $target = $this->mergeImage($target, $d, $d['src']);
                } else if ($d['type'] == 'qr') {
                    $target = $this->mergeImage($target, $d, tomedia($qr['qrimg']));
                } else if ($d['type'] == 'nickname') {
                    $target = $this->mergeText($target, $d, $member['nickname']);
                }
            }
            imagejpeg($target, $path . $file);
            imagedestroy($target);
        }
        $img = $_W['siteroot'] . "addons/wg_fenxiao/data/poster/" . $_W['uniacid'] . "/" . substr($_W['openid'], 0, 2) . "/" . $file;
        if (!$upload) {
            
            return $img;
        }
        if (empty($qr['mediaid']) || empty($qr['createtime']) || $qr['createtime'] + 3600 * 24 * 3 - 7200 < time()) {
            $mediaid = $this->uploadImage($path . $file);
            $qr['mediaid'] = $mediaid;
            pdo_update('wg_fenxiao_poster_qr', array(
                'mediaid' => $mediaid,
                'createtime' => time()
            ) , array(
                'id' => $qr['id']
            ));
        }
    }
    protected function createImage($imgurl) {
        load()->func('communication');
        $resp = ihttp_request($imgurl);
        
        return imagecreatefromstring($resp['content']);
    }
    protected function getRealData($data) {
        $data['left'] = intval(str_replace('px', '', $data['left'])) * 2;
        $data['top'] = intval(str_replace('px', '', $data['top'])) * 2;
        $data['width'] = intval(str_replace('px', '', $data['width'])) * 2;
        $data['height'] = intval(str_replace('px', '', $data['height'])) * 2;
        $data['size'] = intval(str_replace('px', '', $data['size'])) * 2;
        $data['src'] = tomedia($data['src']);
        
        return $data;
    }
    protected function mergeImage($target, $data, $imgurl) {
        $img = $this->createImage($imgurl);
        $w = imagesx($img);
        $h = imagesy($img);
        imagecopyresized($target, $img, $data['left'], $data['top'], 0, 0, $data['width'], $data['height'], $w, $h);
        imagedestroy($img);
        
        return $target;
    }
    protected function mergeText($target, $data, $text) {
        $font = IA_ROOT . "/addons/wg_fenxiao/recouse/font/msyh.ttf";
        $colors = $this->hex2rgb($data['color']);
        $color = imagecolorallocate($target, $colors['red'], $colors['green'], $colors['blue']);
        imagettftext($target, $data['size'], 0, $data['left'], $data['top'] + $data['size'], $color, $font, $text);
        
        return $target;
    }
    protected function hex2rgb($colour) {
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = array(
                $colour[0] . $colour[1],
                $colour[2] . $colour[3],
                $colour[4] . $colour[5]
            );
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array(
                $colour[0] . $colour[0],
                $colour[1] . $colour[1],
                $colour[2] . $colour[2]
            );
        } else {
            
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        
        return array(
            'red' => $r,
            'green' => $g,
            'blue' => $b
        );
    }
    /**
     * 不发红包列表
     * [getNoHongbao description]
     * @return [type] [description]
     */
    protected function getNoHongbao() {
        $config = $this->module['config']['nohongbao'];
        $config = str_replace('，', ',', $config);
        $config = explode(',', $config);
        
        return $config;
    }
    protected function addYiFaYongJin($id, $commision) {
        //2.用户已支付增加金额
        $sql = "UPDATE " . tablename('wg_fenxiao_member') . " SET `commission_pay`=`commission_pay`+:commision WHERE `id`=:id";
        pdo_query($sql, array(
            ':id' => $id,
            ':commision' => $commision
        ));
    }

    protected function getLevelInfo($level,$weid){
        $sql = "SELECT * FROM " . tablename('wg_fenxiao_member_level') . " WHERE level=:level AND weid=:weid";
        $agent = pdo_fetch($sql, array(
            ':level' => $level,
            ':weid' => $weid
        ));
        return $agent;
    }


      /**
     * [xiajirenshu 新增下级人数增加积分]
     * @param  [type] $jifen [description]
     * @param  [type] $order [description]
     * @return [type]        [description]
     */
    protected function xiajirenshu($jifen,$order){
        //0.存在父亲
        if($order['parent1']  == 0){
            return false;
        }
        //1.查出自己购买的单数，如果为0，增加
        $sql = "SELECT COUNT(*) FROM " .tablename('wg_fenxiao_order'). " WHERE `memberid`=:memberid AND `status`>=:status AND `weid`=:weid";
        $goumaicishu = pdo_fetchcolumn($sql,array(':memberid'=>$order['memberid'],':status'=>1,':weid'=>$order['weid']));
        if($goumaicishu == 1){
            $parent_info = $this->getMyInfo($order['parent1']);
            $this->addJifen($parent_info['id'], $jifen, '1级会员' . $parent_info['nickname'] . '购买' . $order['ordersn'] . '获的积分' . $jifen, $order['weid']);
            $data = array(
                'xiaji_one_dingdan' => 1
            ); //支付结果
            //1.更新订单表
            $res = pdo_update('wg_fenxiao_order', $data, array(
                'id' => $order['id']
            ));
        }
        
    }


    public function __get($module_name)
    {
        if(substr($module_name,-5) == 'Model') {
            return $this->$module_name = new $module_name();
        } else {
            return parent::__get($module_name);
        }
    }

    /**
     * @brief 加载module类
     * @param $module_name
     * @param $params
     * @param $new | 是否实例化
     */
    private function loadmodule($module_name, $params = [], $new = true) {
        if(!$this->$module_name) {
            $module_file = dirname(__FILE__) .'/source/'.ucfirst($module_name).'.class.php';
            if(is_file($module_file)) {
                include_once $module_file;
                if($new) {
                    if($params) {
                        $this->$module_name = new $module_name($params);
                    } else {
                        $this->$module_name = new $module_name();
                    }
                }
            } else {
                trigger_error("文件不存在 {$module_file}", E_USER_WARNING);
            }
        }
    }

    /**
     * @brief 模板变量赋值
     * @param        $name
     * @param string $value
     */
    public function assign($name,$value=''){
        if(is_array($name)) {
            $this->_tpl_var   =  array_merge($this->_tpl_var,$name);
        }elseif(is_object($name)){
            foreach($name as $key =>$val)
                $this->_tpl_var[$key] = $val;
        }else {
            $this->_tpl_var[$name] = $value;
        }
    }

    /**
     * @param $filename
     */
    public function display($filename = '') {
        if(!$filename) {
            if($this->isMobile) {
                $filename = strtolower(WG_APP_MODULE) . '/' . WG_APP_METHOD;
            } else {
                $filename = $this->_web . '/' . strtolower(WG_APP_MODULE) . '/' . WG_APP_METHOD;
            }
        }
        global $_W, $_GPC;
        extract($this->_tpl_var, EXTR_OVERWRITE);
        include_once $this->template($filename);
        exit;
    }

    public function getAuth($method) {
        global $_W;
        $notice = cache_read('fenxiao_business'.$method);

        if(!$notice || $notice['time']+3600*12 < time()) {
            $url = 'http://api.datougou.cn/auth/?method=%s&ip='.$_SERVER['SERVER_ADDR'].'&module=wg_fenxiao&url=%s&type=business';
            $host = parse_url($_W['siteroot']);
            $url = sprintf($url,$method,$host['host']);
            $notice = json_decode(file_get_contents($url),true);
        }
        if($notice['ec'] && $notice['ec']!= 200) {
            echo "请加QQ群：344923749，或联系开发者：838591688获取授权信息";exit;
        }else {
            $notice['time'] = time();
            cache_write('fenxiao_business'.$method,$notice);
        }
        return $notice;
    }



}
