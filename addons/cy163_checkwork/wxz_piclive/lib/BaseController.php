<?php

/**
 * 控制器基础类
 * Created by PhpStorm.
 * User: lirui
 * Date: 2017/12/15
 * Time: 1:36
 */
class BaseController
{
    public $site;//微擎ModuleSite类实例
    public $tplVars = [];//模版变量
    public $_W;
    public $_GPC;
    public $uniacid;
    public $userId;//当前微信用户id

    public function __construct()
    {
        global $_GPC, $_W;
        $this->_GPC = $_GPC;
        $this->_W = $_W;
        $this->uniacid = $_W['uniacid'];

        $this->assign('_GPC', $this->_GPC);
        $this->assign('_W', $this->_W);
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->site, $name)) {
            return call_user_func_array([$this->site, $name], $arguments);
        } else {
            return call_user_func_array([$this, $name], $arguments);
        }
    }

    /**
     * 调用action之前执行
     *
     * @return miexd
     */
    public function _before()
    {
    }

    /**
     * 调用action之后执行
     *
     * @return miexd
     */
    public function _after()
    {

    }

    /**
     * assign 变量到模版
     *
     * @param $key
     * @param $value
     * @param $mode 模式
     */
    public function assign($key, $value, $mode = '')
    {
        $this->tplVars[$key] = $value;
    }

    /**
     * 展示模版
     *
     * @param $tpl
     */
    public function display($tpl)
    {
        extract($this->tplVars);
        if (strpos($this->_W['siteurl'], '/web/') !== false) {
            $from = 'web';
        } else {
            $from = '';
        }

        include $this->template($from . '/' . $tpl);
    }

    /**
     * 跳转链接\
     *
     * @param $url
     */
    public function redirect($url)
    {
        if (!$url) {
            $url = "/";
        }
        header("Location: {$url}");
        exit;
    }

    /**
     * ajax返回格式化
     *
     * @param type $code
     * @param type $msg
     */
    public function ajaxReturn($code, $msg = '', $data = '')
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        echo json_encode($result);
        exit;
    }

    /**
     * Ajax方式返回错误信息
     *
     * @param String $msg 提示信息
     * @param String $type ajax返回类型 JSON XML
     *
     * @return  null
     */
    public function ajaxError($msg = '', $data = '')
    {
        return $this->ajaxReturn(0, $msg, $data);
    }

    /**
     * Ajax方式返回正确信息
     *
     * @param String|array $data 返回数据
     * @param String $msg 提示信息
     * @param String $type ajax返回类型 JSON XML
     *
     * @return  null
     */
    public function ajaxSucceed($msg = '', $data = '')
    {
        return $this->ajaxReturn(1, $msg, $data);
    }


    /**
     * 构造页面URL
     *
     * @param         $do         controller/action 默认action为index
     * @param array $query 附加的查询参数
     * @param boolean $noredirect mobile 端url是否要附加 &wxref=mp.weixin.qq.com#wechat_redirect
     *
     * @return string 返回的 URL
     */
    public function genUrl($from, $do, $query = [], $noredirect = true, $addhost = false)
    {
        global $_GPC, $_W;
        $route = explode('/', $do);
        $query['do'] = $route[0];
        switch ($from) {
            case 'web':
                $segment = 'site/entry';
                break;
            case 'mobile':
                $segment = 'entry';
                break;
        }
        if (isset($route[1])) {
            $query['wdo'] = $route[1];
        } else {
            $query['wdo'] = 'index';
        }
        $query['m'] = strtolower($_GPC['m']);
        return murl($segment, $query, $noredirect, $addhost);
    }

}