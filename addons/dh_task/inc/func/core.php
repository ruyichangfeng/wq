<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
defined('IN_IA') or exit ('Access Denied');

class Core extends WeModuleSite
{
    //模板路径
    public $mobile_tpl = 'style1';

    public $dh_appid = '';
    public $dh_appsecret = '';
    public $dh_accountlevel = '';
    public $dh_account = '';

    public $dh_weid = '';
    public $dh_fromuser = '';

    public $dh_auth2_openid = '';
    public $dh_auth2_nickname = '';
    public $dh_auth2_headimgurl = '';

    //表
    public $table_fans = 'dh_task_fans';
	public $table_points = 'dh_task_points';
	public $table_task_cate = 'dh_task_task_cate';
	public $table_task = 'dh_task_task';
	public $table_receive = 'dh_task_receive';
	public $table_setting = 'dh_task_setting';
    public $table_ad = 'dh_task_ad';
    public $table_field = 'dh_task_field';
    public $table_fieldset = 'dh_task_fieldset';
    public $table_recharge = 'dh_task_recharge';
    public $table_task_nav = 'dh_task_task_nav';
    public $table_mobile_admin = 'dh_task_mobile_admin';

    public function getMainMenu()
    {
        global $_W, $_GPC;

        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = ' style="color:#d9534f;" ';
        if($_W['isfounder'] || $_W['role'] == 'manager' || $_W['role'] == 'operator') {
            $navemenu[0] = array(
                'title' => '<icon style="color:#8d8d8d;" class="fa fa-user"></icon>  用户',
                'items' => array(
                    0 => $this->createMainMenu('用户管理', $do, 'fans', ''),
                    //1 => $this->createMainMenu('前台管理员', $do, 'mobile_admin', '')
                )
            );
            $navemenu[1] = array(
                'title' => '<icon style="color:#8d8d8d;" class="fa fa-th"></icon>  任务',
                'items' => array(
                    1 => $this->createMainMenu('任务管理', $do, 'task', ''),
					2 => $this->createMainMenu('领取记录', $do, 'task_review', ''),
					5 => $this->createMainMenu('任务标签', $do, 'task_category', ''),
                    6 => $this->createMainMenu('分类导航', $do, 'task_nav', '')
                )
            );
            $navemenu[2] = array(
                'title' => '<icon style="color:#8d8d8d;" class="fa fa-usd"></icon>  资金',
                'items' => array(
                    1 => $this->createMainMenu('资金记录 ', $do, 'points_record', '')
                )
            );
            if($this->getSetting('is_propor')){
                 $navemenu[2]['items'][2] = $this->createMainMenu('提现管理', $do, 'point_propor', '');
            }
            $navemenu[3] = array(
                'title' => '<icon style="color:#8d8d8d;" class="fa fa-plus"></icon>  功能',
                'items' => array(
                    6 => $this->createMainMenu('广告管理', $do, 'ad', ''),
                    7 => $this->createMainMenu('表单管理', $do, 'field', '')
                )
            );
            $navemenu[4] = array(
                'title' => '<icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  系统',
                'items' => array(
                    8 => $this->createMainMenu('设置系统', $do, 'settings', '')
                )
            );
			$navemenu[5] = array(
                'title' => '<icon style="color:#8d8d8d;" class="fa fa-share-alt"></icon>  入口',
                'items' => array(
                    0 => $this->createCoverMenu('首页 ', 'cover', 'task', ''),
                    1 => $this->createCoverMenu('用户中心 ', 'cover', 'me', '')
                )
            );
        }
        return $navemenu;
    }

    function createCoverMenu($title, $method, $op, $icon = "fa-image", $color = '#d9534f')
    {
        global $_GPC, $_W;
        $cur_op = $_GPC['op'];
        $color = ' style="color:'.$color.';" ';
        return array('title' => $title, 'url' => $op != $cur_op ? $this->createWebUrl($method, array('op' => $op)) : '',
            'active' => $op == $cur_op ? ' active' : '',
            'append' => array(
                'title' => '<i class="fa fa-angle-right"></i>',
            )
        );
    }

    function createMainMenu($title, $do, $method, $icon = "fa-image", $color = '')
    {
        $color = ' style="color:'.$color.';" ';

        return array('title' => $title, 'url' => $do != $method ? $this->createWebUrl($method, array('op' => 'display')) : '',
            'active' => $do == $method ? ' active' : '',
            'append' => array(
                'title' => '<i '.$color.' class="fa fa-angle-right"></i>',
            )
        );
    }



    /**
     *    功能 二维码创建函数；
     * @param string $value 内容（可以是：链接、文字等）
     * @param string $filename 文件名字
     * @param string $pathname 路径名字
     * @param string $errorCorrectionLevel 容错率 L M Q H
     * @return $fileurllogo 中间带logo的二维码；
     * @Author Fmoons
     * @Time 2015.06.04 01:27
     **/
    public function fm_qrcode($value = 'http://www.dhoyun.com', $filename = '', $pathname = '', $logo = '', $scqrcode = array('errorCorrectionLevel' => 'M', 'matrixPointSize' => '4', 'margin' => '5'))
    {
        global $_W;
        $uniacid = !empty($_W['uniacid']) ? $_W['uniacid'] : $_W['acid'];
        require_once IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
        load()->func('file');

//        $filename = empty($filename) ? date("YmdHis") . '' . random(10) : date("YmdHis") . '' . random(istrlen($filename));
        $filename = empty($filename) ? date("YmdHis") . '' . random(10) : $filename;

        if (!empty($pathname)) {
            $dfileurl = 'attachment/images/' . $uniacid . '/qrcode/cache/' . date("Ymd") . '/' . $pathname;
            if (defined('IN_WEISRC_DISH_ADMIN')) {
                $fileurl = '../../../' . $dfileurl;
            } else {
                $fileurl = '../' . $dfileurl;
            }
        } else {
            $dfileurl = 'attachment/images/' . $uniacid . '/qrcode/cache/' . date("Ymd");
            if (defined('IN_WEISRC_DISH_ADMIN')) {
                $fileurl = '../../../' . $dfileurl;
            } else {
                $fileurl = '../' . $dfileurl;
            }
        }
        mkdirs($fileurl);
        $fileurl = empty($pathname) ? $fileurl . '/' . $filename . '.png' : $fileurl . '/' . $filename . '.png';
        QRcode::png($value, $fileurl, $scqrcode['errorCorrectionLevel'], $scqrcode['matrixPointSize'], $scqrcode['margin']);
        return $_W['siteroot']. str_replace('../', '', $fileurl);

        $dlogo = $_W['attachurl'] . 'headimg_' . $uniacid . '.jpg?uniacid=' . $uniacid;

        if (!$logo) {
            $logo = toimage($dlogo);
        }

        $QR = $_W['siteroot'] . $dfileurl . '/' . $filename . '.png';
        if ($logo !== FALSE) {
            $QR = imagecreatefromstring(file_get_contents($QR));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);
            $QR_height = imagesy($QR);
            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
        }
        if (!empty($pathname)) {
            $dfileurllogo = 'attachment/images/' . $uniacid . '/qrcode/fm_qrcode/' . date("Ymd") . '/' . $pathname;
            $fileurllogo = '../' . $dfileurllogo;
        } else {
            $dfileurllogo = 'attachment/images/' . $uniacid . '/qrcode/fm_qrcode';
            $fileurllogo = '../' . $dfileurllogo;
        }
        mkdirs($fileurllogo);
        $fileurllogo = empty($pathname) ? $fileurllogo . '/' . $filename . '_logo.png' : $fileurllogo . '/' . $filename . '_logo.png';;

        imagepng($QR, $fileurllogo);
        return $fileurllogo;
    }

    public function getSetting($field = "")
    {
        global $_W, $_GPC;
        $weid = $this->dh_weid;
        $field = $field?$field:"*";
        $setting = pdo_fetch("SELECT ".$field." FROM " . tablename($this->table_setting) . " where weid = :weid LIMIT 1", array(':weid' => $this->dh_weid));
        if(count($setting) == 1){
            return $setting[$field];
        }
        return $setting;
    }

    //对提交的get post参数进行过滤
    protected function zaddslashes($string, $force = 0, $strip = FALSE)
    {   
        if (!defined('MAGIC_QUOTES_GPC'))
        {   
         define('MAGIC_QUOTES_GPC', '');
        }   
        if (!MAGIC_QUOTES_GPC || $force)
        {   
         if (is_array($string)) {
             foreach ($string as $key => $val)
             {   
                 $string[$key] = $this->zaddslashes($val, $force, $strip);
             }   
         }   
         else
         {   
             $string = ($strip ? stripslashes($string) : $string);
             $string = htmlspecialchars($string);
         }   
        }   
        return $string;
     }
}