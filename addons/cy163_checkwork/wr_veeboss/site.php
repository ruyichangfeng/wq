<?php
/**
 * 微掌柜进销存
 *
 * 作者:景博
 *
 */
defined('IN_IA') or exit('Access Denied');
define('RES', '../addons/wr_veeboss/template/');
//error_reporting(0);
include "../addons/wr_veeboss/model.php";

class wr_veebossModuleSite extends WeModuleSite
{
    public $cur_version = '20160421';
    public $modulename = 'wr_veeboss';

    public $_weixin = '1'; //default:1
    public $_debug = 0;

    public $_appid = '';
    public $_appsecret = '';
    public $_accountlevel = '';

    public $_weid = '';
    public $_fromuser = '';
    public $_nickname = '';
    public $_headimgurl = '';


    function __construct()
    {
        global $_W, $_GPC;
        $this->_fromuser = $_W['openid'];
        if ($this->_debug==1) {
            $this->_fromuser = 'debug';
        }
        $this->_weid = $_W['uniacid'];
        $account = account_fetch($this->_weid);

       
    }
    public function doWebSetting() {
        $this->__web(__FUNCTION__);
    }
    public function doWebAccount() {
        $this->__web(__FUNCTION__);
    }
    public function doMobileIndex() {
        $this->__mobile(__FUNCTION__);
    }
    public function doMobileList() {
        $this->__mobile(__FUNCTION__);
    }
    public function doMobileInfo() {
        $this->__mobile(__FUNCTION__);
    }
    
    public function __web($f_name){
        global $_W,$_GPC;
        checklogin();
        $weid = $_W['uniacid'];
        load()->func('tpl');
        $op = $operation = $_GPC['op']?$_GPC['op']:'display';
        include_once  'web/'.strtolower(substr($f_name,5)).'.php';
    }
    public function __mobile($f_name){
        global $_W,$_GPC;
        $from_user = $this->_fromuser;
        if($this->_debug!=1 and (empty($from_user) or is_numeric($from_user))){
            exit('请使用微信登陆！');
        }
        $weid = $this->_weid;
        //$setting= $this->get_sysset($weid);
       // $this->checkIsWeixin();
        include_once 'mobile/'.strtolower(substr($f_name,8)).'.php';
    }

    private function checkAuth() {
        global $_W;
        checkauth();
    }


    
   

    

    function isWeixin()
    {
        if ($this->_weixin == 1) {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            if (!strpos($userAgent, 'MicroMessenger')) {
                include $this->template('s404');
                exit();
            }
        }
    }

    
    public function showMessage($msg, $status = 0)
    {
        $result = array('message' => $msg, 'status' => $status);
        echo json_encode($result);
        exit;
    }

    public function message($error, $url = '', $errno = -1) {
        $data = array();
        $data['errno'] = $errno;
        if (!empty($url)) {
            $data['url'] = $url;
        }
        $data['error'] = $error;
        echo json_encode($data);
        exit;
    }

    public function http_request($url, $data=NULL){
        $curl=curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output=curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}