<?php
/**
 * wg call
 * @author zzq
 * @url http://bbs.we7.cc/
 */
//error_reporting(E_ALL);
//ini_set('display_errors','On');
defined('IN_IA') or exit('Access Denied');
define('APP_NAME', 'wg_call');
class Wg_CallModuleSite extends WeModuleSite {

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
        include_once ADDON_PATH.'/function/global.func.php';
        include_once ADDON_PATH.'/controller/CallBaseController.php';
        include_once ADDON_PATH.'/controller/CallMobileBaseController.php';
        include_once ADDON_PATH.'/controller/CallWebBaseController.php';
        include_once ADDON_PATH.'/model/CallBaseModel.php';

        //autoload
        include_once ADDON_PATH.'/lib/ClassLoader.php';

        $classLoader = new ClassLoader();

        //注册自动加载路径

        $classLoader->addPrefix('',ADDON_PATH.'/model');
        $classLoader->register();

    }

    //重写父类的call方法
    public function __call($name, $arguments) {


        define('STATIC_ROOT',MODULE_URL . '/recouse');
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
        if(!isset($this->$module_name)) {
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


    public function webmobileUrl($do, $query = array()) {
        $query['do'] = $do;
        $query['m']  = strtolower($this->modulename);
        return murl('entry', $query, true, true);
    }
}
