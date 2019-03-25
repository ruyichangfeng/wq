<?php
//error_reporting(E_ALL);
//ini_set('display_errors','On');
header("Content-type:text/html;charset=utf-8");
defined('IN_IA') or exit('Access Denied');
define('APP_NAME', 'wg_sales');

define('IMAGE_ROOT','/attachment/');
require_once dirname(__FILE__) .'/inc/SalesBaseController.php';
require_once dirname(__FILE__) .'/source/BaseModule.php';



//error_reporting(E_ALL);
//ini_set('display_errors','On');
/**
 * Class Wg_salesModuleSite
 * @property CategoryModule $categoryModule
 * @property ArticleModule $articleModule
 * @property CommentModule $commentModule
 * @property SliderModule $sliderModule
 * @property SettingModule $settingModule
 * @property TopicModule $topicModule
 * @property TopiclistModule $topiclistModule
 * @property AccountModule $accountModule
 * @property UserModule $userModule
 * @property OrderModule $orderModule
 * @property ArticleAdModule $articleAdModule
 * @property PubModule $pubModule
 * @property Page $page
 */
include_once dirname(__FILE__) . '/crontab/Index.php';
class Wg_salesModuleSite extends WeModuleSite {

    public $_web    = 'web';
    public $_mobile = 'mobile';

    private $_tpl = null;

    public $site_id = null;
    public $_GPC;
    public $_W;

    public static $_CACHE = null;
    public  $special = [
        'comment'   => 0B1,//评论
        'pay'       => 0B10,//打赏
//        'first'     => 0B100,//置顶
        'uncomment' => 0B1000,//匿名评论
    ];

    public  $article_type = [
        1 => '新闻',
        2 => '图集',
        3 => '视频',
    ];

    public $article_video_type = [
        1 => 'hls',
        2 => 'mp4',
        3 => 'iframe',
    ];
    public $video_template = [
        'iframe' => '<iframe width="100%" height="auto" src="%s" allowfullscreen></iframe>'
    ];


    //cache setting
    public static $SETTING =
        [
            'category_index' =>
                [
                    'key'     => 'category_index',
                    'default' => ['name' => '推荐', 'id' => 0 , 'display_order' => 0]
                ],
            'settings'       =>
                [
                    'name' => '微站',
                    'pic'  => '',
            ],
        ];
    //其它所有key
    public static $CATEGORY_ALL_KEY = 'category_all';

    //module 类
    public $provider = [];

    //模板变量
    public $_tpl_var = [];
    /**
     * @param $app $_web | $_mobile
     */

    public function __call($name, $arguments) {
        define('STATIC_ROOT',MODULE_URL . '/static');
        $this->_web = stripos($name, 'doWeb') === 0;
        $this->_mobile = stripos($name, 'doMobile') === 0;
        $this->loadmodule('settingModule');
        global $_W, $_GPC;
        $this->_GPC = &$_GPC;
        $this->_W   = &$_W;
        $this->site_id  = $_W['uniacid'];
        if(!$this->site_id) {
            echo 'site '.$this->site_id.' not exist';exit;
        }


        $method_name = trim($_GPC['_wg'] ?  $_GPC['_wg'] : 'index');
        $method_name = strtolower($method_name);

        $controllerDir = IA_ROOT.'/addons/'.$this->modulename.'/inc/';

        if($this->_web) {
            $class_name   = ucfirst(trim($_GPC['m']) . '_Web_' . ucfirst($_GPC['do']));
            $controllerDir.='web/';
        }else {
            $class_name   = ucfirst(trim($_GPC['m']) . '_Mobile_' . ucfirst($_GPC['do']));
            $controllerDir.='mobile/';
        }


        require_once $controllerDir.strtolower($_GPC['do']).'.inc.php';


        define('WG_CONTROLLER_NAME', $name . '_' . $_GPC['do']);
        define('WG_METHOD_NAME', $method_name);
        if($name == $this->_mobile) {
            //微信环境
            if($this->is_weixin()) {
//                if(!$_SESSION['wg']['user'][$this->site_id] && ($_SESSION['wg']['time'][$this->site_id] + 600 < time()-600)) {
                //认证订阅号
                $level = $_W['account']['level'];
                //认证方式 1、3
                $type  = $_W['account']['type'];
                if($level == 3 || $level == 4) {
                    //普通接入
                    if($type == 1) {
                        if(!$this->getUser()) {
//                        $_SESSION['wg']['time'][$this->site_id]= time();
                        }
                        //授权接入
                    }elseif($type == 3) {
                        $this->getUser3();
                    }

                }
            }
        }

//        var_dump($class_name);
        $class = new $class_name();
        $class->site = $this;
        $class->init();
        $class->$method_name();


        if($this->_web) {
            $this->display('web/' . trim($_GPC['do']) . '/' . $method_name);
        } else{
            $menu = $this->_getCache('menu');
            $this->assign('menu',$menu);
            $this->display(trim($_GPC['do']) . '/' . $method_name);
        }
    }


    /**
     * @brief allCategory
     * @return Ambigous|array
     */
    public function getCategory() {
        $this->loadmodule('categoryModule');
        return $this->categoryModule->getAllCategory(['uniacid' => $this->site_id,'del' => 0]);

    }

    public function ispost() {
        return $_SERVER['REQUEST_METHOD'] == "POST" ? true : false;
    }

    /**
     * @brief 加载module类
     * @param $module_name
     * @param $params
     * @param $new | 是否实例化
     */
    public function loadmodule($module_name, $params = [], $new = true) {
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

    public function webUrl($do, $query = array()) {
        return $this->createWebUrl($do, $query);
    }
    public function mobileUrl($do, $query = array()) {
        return $this->createMobileUrl($do, $query);
    }
    public function webmobileUrl($do, $query = array()) {
        $query['do'] = $do;
        $query['m']  = strtolower($this->modulename);
        return murl('entry', $query, true, true);
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
    public function display($filename) {
        if($this->_tpl) return;
        $this->_tpl = $filename;
        global $_W, $_GPC;
        extract($this->_tpl_var, EXTR_OVERWRITE);
        $this->__define = IA_ROOT . '/addons/wg_sales/site.php';
        include_once $this->template($this->_tpl);
    }

    public function getNewsArticles($cate) {
        $data = cache_load('wg_sales_'.$this->site_id);
        if($data) {
            return $data;
        }
        $cache = [];
        if($cate) {
            foreach($cate as $value) {
                if($value['id'] == 0) {
                    continue;
                }
                $article = $this->articleModule->getList(
                    $value['id'],
                    [],
                    ['id','type','author','title','image','kw','jump','url','time_step','special','praise'],
                    'id desc',
                    5
                    );
                if($article) {
                    $cache[] = ['category' => $value, 'article' => $article];
                }
            }
            if($cache) {
                $this->setNewsArticles($cache, 600);
            }
        }
        return $cache;
    }
    public function setNewsArticles($article, $time = 600) {
        cache_write('wg_sales_'.$this->site_id,$article,$time);
    }

    public function getSettings() {
        $setings = $this->_getCache('settings');
        $setings['pic'] = $setings['pic'] ? $setings['pic'] : self::$SETTING['settings']['pic'];
        $setings['name'] = $setings['name'] ? $setings['name'] : self::$SETTING['settings']['name'];
        return $setings;
    }
    public function setSettings($data) {
        return $this->_setCache('settings', $data);
    }

    public function setPay($data) {
        return $this->_setCache('pay', $data);
    }
    public function getPay() {
        return $this->_getCache('pay');
    }


    public function setKw($data) {
        return $this->_setCache('kw', $data);
    }
    public function getKw() {
        return $this->_getCache('kw');
    }

    //category_index 推荐key获取
    public function getCategoryIndex() {
        return $this->_getCache('category_index');
    }
    //category_index 推荐key设置
    public function setCategoryIndex($category) {
       return $this->_setCache('category_index', $category);
    }

    //s
    public function _getCache($key) {
        if(isset(self::$_CACHE[$key])) {
            return self::$_CACHE[$key];
        }
        $data = json_decode($this->settingModule->getOne(['name' => $key."_".$this->site_id])['value'], true);
        if($data) {
            self::$_CACHE[$key] = $data;
            return $data;
        } else {
            return self::$SETTING[$key]['default'];
        }
    }
    public function _setCache($key, $data) {
        $key = $key."_".$this->site_id;
        if($this->settingModule->getOne(['name' => $key])) {
            return $this->settingModule->update(['name' => $key],['value' => json_encode($data)]);
        } else {
            return $this->settingModule->add([
                'name'  => $key,
                'value' => json_encode($data),
                'create_time' => time()
            ]);
        }
    }

    public function getUser() {
        if($_SESSION['wg']['user'][$this->site_id]) {
            return true;
        }

        $this->loadmodule('userModule');
        $this->loadmodule('accountModule');
        $openid = $this->accountModule->getOpenid('snsapi_userinfo');
        if(!$openid['openid']) {
            return false;
        }
        $user = $this->userModule->getOne(['openid' => $openid['openid'],'uniacid' => $this->site_id]);
        if($user) {
            $_SESSION['wg']['user'][$this->site_id] = $user;
            return true;
        }

        $user_info = $this->accountModule->getUserInfo($openid['access_token'], $openid['openid']);
        if(!$user_info['openid']) {
            return false;
        }

        $user = [
            'uniacid'    => $this->site_id,
            'nickname'   => $user_info['nickname'],
            'headimgurl' => $user_info['headimgurl'],
            'openid'     => $user_info['openid'],
            'city'       => $user_info['city'],
            'province'   => $user_info['province'],
            'country'    => $user_info['country'],
            'sex'        => $user_info['sex'],
            'add_time'    => time(),
            'update_time' => time(),
        ];
        $user['id'] = $this->userModule->add($user);
        if($user['id']) {
            $_SESSION['wg']['user'][$this->site_id] = $user;
            return true;
        }
        return false;
    }


    public function getUser3() {

        if($_SESSION['wg']['user'][$this->site_id]) {
            return true;
        }
        $this->loadmodule('userModule');
        global $_W;
        $this->loadmodule('accountModule',$_W['account']);
        $openid = $this->accountModule->getOpenid3('snsapi_userinfo');
        if(!$openid['openid']) {
            return false;
        }
        $user = $this->userModule->getOne(['openid' => $openid['openid'],'uniacid' => $this->site_id]);
        if($user) {
            $_SESSION['wg']['user'][$this->site_id] = $user;
            return true;
        }

        $user_info = $this->accountModule->getUserInfo3($openid['access_token'], $openid['openid']);
        if(!$user_info['openid']) {
            return false;
        }

        $user = [
            'uniacid'    => $this->site_id,
            'nickname'   => $user_info['nickname'],
            'headimgurl' => $user_info['headimgurl'],
            'openid'     => $user_info['openid'],
            'city'       => $user_info['city'],
            'province'   => $user_info['province'],
            'country'    => $user_info['country'],
            'sex'        => $user_info['sex'],
            'unionid'    => $user_info['unionid'],
            'add_time'    => time(),
            'update_time' => time(),
        ];
        $user['id'] = $this->userModule->add($user);
        if($user['id']) {
            $_SESSION['wg']['user'][$this->site_id] = $user;
            return true;
        }
        return false;
    }

    /**
     * @param $image
     * @return mixed
     */
    public function formatArrImage($image) {
        global $_W;
        if($image['url_webp']) {
            $image['real_url'] = $image['url'];
//            $image['url'] = $image['url'];
            $image['attachment'] = $image['url'];
            unset($image['url_webp']);
        } elseif(substr($image['url'],0,1) == '/'){

        } elseif(strpos($image['url'],'http') === false && $image['url']) {
            $image['attachment'] = $image['url'];
            $image['url'] = $_W['attachurl'] . $image['url'];

        } else {
            $image['attachment'] = $image['url'];
        }
        return $image;
    }


    function send_http_request($url, $post = [])
    {
        $curl = curl_init();

        $ua = 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us] AppleWebKit/537.51.1 (KHTML, like Gecko] Version/7.0 Mobile/11A465 Safari/9537.53';
        if($post) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($curl, CURLOPT_USERAGENT, $ua);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function arrayIndex($arr, $key) {
        $new_arr = [];
        foreach($arr as $value) {
            $new_arr[$value[$key]] = $value;
        }
        return $new_arr;
    }

    public function formatTime($time) {
        if (!$time) return '未知';
        $t = time() - $time; //时间差 （秒）
        if ($t == 0)
            $text = '刚刚';
        elseif ($t < 60)
            $text = '1分钟前'; // 一分钟内
        elseif ($t < 60 * 60)
            $text = floor($t / 60) . '分钟前'; //一小时内
        elseif ($t < 60 * 60 * 24)
            $text = date('H:i',$time); // 一天内
        else
            $text = date('m-d',$time); //昨天和前天
        return $text;
    }

    public function getSignedData($key, array $param_data, array $exclude_data = array()){
        $sign_data  = array();
        if(!empty($exclude_data)) {
            foreach ($param_data as $key => $val) {
                if (!in_array($key, $exclude_data)) {
                    $sign_data[$key] = $val;
                }
            }
        }else{
            $sign_data  = $param_data;
        }

        krsort($sign_data);
        $sign   = implode('#', $sign_data).'#'.$key;
        $param_data['sign'] = md5($sign);
        return $param_data;
    }

    public function formatComment($list) {
        $this->loadmodule('userModule');
        $userids = $userlist = [];
        foreach($list as $value) {
            if($value['uid']) {
                $userids[] = $value['uid'];
            }
        }
        if($userids) {
            $userids = array_unique($userids);
            $userlist = $this->userModule->getList(['id' => $userids],['id','nickname','headimgurl']);
            $userlist = $this->arrayIndex($userlist,'id');
        }
        foreach($list as &$comment) {
            if($comment['uid'] && $userlist[$comment['uid']]) {
                $comment['nickname'] = $userlist[$comment['uid']]['nickname'];
                $comment['headimgurl'] = $userlist[$comment['uid']]['headimgurl'];
            }else {
                $comment['nickname'] = '匿名';
                $comment['headimgurl']  = STATIC_ROOT . '/images/default_userimg.png';
            }
            $comment['create_time'] = $this->formatTime($comment['create_time']);
        }
        return $list;
    }

    function form_field_multi_image($name, $value = array(), $options = array()) {
        global $_W;
        $options['multiple'] = true;
        $options['direct'] = false;
        $options['fileSizeLimit'] = intval($GLOBALS['_W']['setting']['upload']['image']['limit']) * 1024;
        if (isset($options['dest_dir']) && !empty($options['dest_dir'])) {
            if (!preg_match('/^\w+([\/]\w+)?$/i', $options['dest_dir'])) {
                exit('图片上传目录错误,只能指定最多两级目录,如: "we7_store","we7_store/d1"');
            }
        }
        $brief = intval($options['brief']);
        $s = '';
        if (!defined('TPL_INIT_MULTI_IMAGE')) {
            $s = '
<style>
.close {
    float: right;
    font-size: 21px;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity: .2;
}
.multi-img-details .multi-item em {
    position: absolute;
    top: 0;
    right: -14px;
}
.multi-img-details .multi-item {
    max-width: 100%;
    max-height: 150px;
    height: auto;
    margin-top: 15px;
}
.input-pic-desc {
    display: inline-block;
    padding: 6px 12px;
    margin-left: 10px;
    height: 64px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    white-space: nowrap;
    vertical-align: middle;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>
<script type="text/javascript">
	function uploadMultiImage(elm, brief) {
		var name = $(elm).next().val();
		util.image( "", function(urls){
			$.each(urls, function(idx, url){
                if(brief) {
                    $(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'./resource/images/nopic.jpg\\\'; this.title=\\\'图片未找到.\\\'" src="\'+url.url+\'" class="img-responsive img-thumbnail"><textarea name="\'+name+\'_brief[]" value="" class="input-pic-desc" placeholder="图片介绍"></textarea><input type="hidden" name="\'+name+\'[]" value="\'+url.url+\'"><em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>\');
                } else {
                    $(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'./resource/images/nopic.jpg\\\'; this.title=\\\'图片未找到.\\\'" src="\'+url.url+\'" class="img-responsive img-thumbnail"><input type="hidden" name="\'+name+\'[]" value="\'+url.url+\'"><em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>\');
                }
				});
		}, ' . json_encode($options) . ');
	}
	function deleteMultiImage(elm){
		$(elm).parent().remove();
	}
</script>';
            define('TPL_INIT_MULTI_IMAGE', true);
        }

        $s .= <<<EOF
<div class="input-group">
	<input type="text" class="form-control" readonly="readonly" value="" placeholder="批量上传图片" autocomplete="off">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button" onclick="uploadMultiImage(this,{$brief});">选择图片</button>
		<input type="hidden" value="{$name}" />
	</span>
</div>
<div class="input-group multi-img-details">
EOF;
        if (is_array($value) && count($value) > 0) {
            foreach ($value as $row) {
                $s .= '
<div class="multi-item">
	<img src="' . $row['url'] . '" onerror="this.src=\'./resource/images/nopic.jpg\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail">
	<input type="hidden" name="' . $name . '[]" value="' . $row['url'] . '" >';
	if($options['brief']) {
        $s .= '<textarea name="' . $name . '_brief[]" class="input-pic-desc" placeholder="图片介绍">' . $row['brief'] . '</textarea>';
    }
	$s.='<em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em>
</div>';
            }
        }
        $s .= '</div>';

        return $s;
    }


    function form_field_image($name, $value = '', $default = '', $options = array()) {
        global $_W;
        if (empty($default)) {
            $default = './resource/images/nopic.jpg';
        }
        $val = $default;
        if (!empty($value)) {
            $val = $value;
        }
        if (!empty($options['global'])) {
            $options['global'] = true;
        } else {
            $options['global'] = false;
        }
        if (empty($options['class_extra'])) {
            $options['class_extra'] = '';
        }
        if (isset($options['dest_dir']) && !empty($options['dest_dir'])) {
            if (!preg_match('/^\w+([\/]\w+)?$/i', $options['dest_dir'])) {
                exit('图片上传目录错误,只能指定最多两级目录,如: "we7_store","we7_store/d1"');
            }
        }
        $options['direct'] = true;
        $options['multiple'] = false;
        if (isset($options['thumb'])) {
            $options['thumb'] = !empty($options['thumb']);
        }
        $options['fileSizeLimit'] = intval($GLOBALS['_W']['setting']['upload']['image']['limit']) * 1024;
        $s = '';
        if (!defined('TPL_INIT_IMAGE')) {
            $s = '
		<script type="text/javascript">
			function showImageDialog(elm, opts, options) {
				require(["util"], function(util){
					var btn = $(elm);
					var ipt = btn.parent().prev();
					var val = ipt.val();
					var img = ipt.parent().next().children();
					options = '.str_replace('"', '\'', json_encode($options)).';
					util.image(val, function(url){
						if(url.url){
							if(img.length > 0){
								img.get(0).src = url.url;
							}
							ipt.val(url.url);
							ipt.attr("filename",url.filename);
							ipt.attr("url",url.url);
						}
						if(url.media_id){
							if(img.length > 0){
								img.get(0).src = "";
							}
							ipt.val(url.media_id);
						}
					}, options);
				});
			}
			function deleteImage(elm){
				$(elm).prev().attr("src", "./resource/images/nopic.jpg");
				$(elm).parent().prev().find("input").val("");
			}
		</script>';
            define('TPL_INIT_IMAGE', true);
        }

        $s .= '
		<div class="input-group ' . $options['class_extra'] . '">
			<input type="text" name="' . $name . '" value="' . $value . '"' . ($options['extras']['text'] ? $options['extras']['text'] : '') . ' class="form-control" autocomplete="off">
			<span class="input-group-btn">
				<button class="btn btn-default" type="button" onclick="showImageDialog(this);">选择图片</button>
			</span>
		</div>
		<div class="input-group ' . $options['class_extra'] . '" style="margin-top:.5em;">
			<img src="' . $val . '" onerror="this.src=\'' . $default . '\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail" ' . ($options['extras']['image'] ? $options['extras']['image'] : '') . ' width="150" />
			<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
		</div>';
        return $s;
    }

    function is_weixin() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        } return false;
    }

    public function payResult($params) {
        $this->loadmodule('orderModule');
        if($params['out_trade_no']) {
            $where['order_no'] = $params['out_trade_no'];
            $this->orderModule->update($where,[
                'status'      => 2,
                'mch_id'      => $params['mch_id'],
                'trade_no'    => $params['transaction_id'],
                'update_time' => time(),
            ]);
            return true;
        }
        return false;
    }

    function ajaxReturn($error_code, $error_msg, $error_data = '') {
        $result = array(
            'ec'   => $error_code,
            'em'   => $error_msg,
            'data' => $error_data,
        );
        echo json_encode($result);
        exit;
    }

    public function getVideoTemplate($value) {
        return '<iframe width="100%" height="auto" src="'.$value.'" allowfullscreen></iframe>';
    }

    public function __get($module_name)
    {
        if(substr($module_name,-5) == 'Model') {
            return $this->$module_name = new $module_name();
        } else {
            return parent::__get($module_name);
        }
    }

}