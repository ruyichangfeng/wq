<?php
/**
 * 女神来了模块定义
 *
 * @author 幻月科技
 * @url http://bbs.fmoons.com/
 */
if (!defined('IN_IA')) { exit('Access Denied');}
global $_W, $_GPC;
if(!$_W['isfounder']){
    message('无权访问!');
}
if(!defined('FM_PHOTOSVOTE_AUTH_URL')) {define('FM_PHOTOSVOTE_AUTH_URL', 'http://www.daren007.com/wq/api/');}             
$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
load()->func('communication');
load()->func('file');
$cfg = $this->module['config'];
$setting = setting_load('site');
$id = isset($setting['site']['key']) ? $setting['site']['key'] : '0';   
if ($op == 'display') {
    $versionfile = IA_ROOT . '/addons/duola_club/inc/version.php';
    $updatedate = date('Y-m-d H:i', filemtime($versionfile));
    $version = FM_JIAOYU_VERSION;
} else if ($op == 'check') {

    set_time_limit(0);
    
    $version = defined('FM_JIAOYU_VERSION') ? FM_JIAOYU_VERSION : '1.0';
    $resp = ihttp_post(FM_PHOTOSVOTE_AUTH_URL, array(
        'type' => 'check',
        'ip' => $_W['clientip'],
        'id' => $id,
        'fmauthtoken' => $cfg['fmauthtoken'],
        'oauthurl' => $_SERVER ['HTTP_HOST'],
        'version' => $version,
        'manual'=>1
    )); 
    
    $templatefiles = "";
    $ft = "";
    $ret = @json_decode($resp['content'], true);
    
    if (is_array($ret)) {
      $templatefiles = "";
      $ft = "";
        if ($ret['result'] == 1) {
            $files = array();
         
            if (!empty($ret['files'])) {
                foreach ($ret['files'] as $file) {
                    $entry = IA_ROOT . "/addons/duola_club/" . $file['path'];
                    if (!is_file($entry) || md5_file($entry) != $file['hash']) {

                        $files[] = array('path' => $file['path'], 'download' => 0);
                        
                         if( is_file($entry) && strexists($entry, 'template/mobile') && strexists($entry, '.html') ){
                              $templatefiles.= "M   /addons/duola_club/".$file['path']."\r\n";
                         }else{
                            $ft .= "F   /addons/duola_club/".$file['path']."\r\n";
                         }
                    }
                } 
            } 
           cache_write('cloud:modules:upgrade', array('files'=>$files,'version'=>$ret['version'],'uptime'=>$ret['uptime'],'upgrade'=>$ret['upgrade']));
           $log = base64_decode($ret['log']);
           if(!empty($templatefiles)){
               $upfile ="<br/><b>模板变化:</b><br/>".$templatefiles."\r\n";
           }
           $upfile = "<br/><b>文件变化:</b><br/>".$ft."\r\n".$upfile;
           $fmdata = array(
               'result' => 1,
                'version' => $ret['version'], 
                'uptime' => $ret['uptime'], 
                'filecount' => count($files),
                'upgrade' => !empty($ret['upgrade']),
                'log' =>  str_replace("\r\n","<br/>", $log),
                'upfile' =>  str_replace("\r\n","<br/>", $upfile),
            );
            echo json_encode($fmdata);
            exit;
        }
    }
    die(json_encode(array('result' => 0, 'message' =>$ret['m'])));
} else if ($op == 'download') {
     
    $upgrade = cache_load('cloud:modules:upgrade');

    $files = $upgrade['files'];
    $version = $upgrade['version'];
    $uptime = $upgrade['uptime'];
    $path = "";
    foreach ($files as $f) {
        if (empty($f['download'])) {
            $path = $f['path'];
            break;
        }
    }
    if (!empty($path)) {
        $resp = ihttp_post(FM_PHOTOSVOTE_AUTH_URL, array(
        'type' => 'download',
        'ip' => $_W['clientip'],
        'id' => $id,
        'fmauthtoken' => $cfg['fmauthtoken'],
        'oauthurl' => $_SERVER ['HTTP_HOST'],
        'path' => $path
    )); 
 
        $ret = @json_decode($resp['content'], true);

        if (is_array($ret)) {
            $path = $ret['path'];
            $dirpath = dirname($path);
            
            if (!is_dir(IA_ROOT . "/addons/duola_club/" . $dirpath)) {
               mkdirs(IA_ROOT . "/addons/duola_club/" . $dirpath, "0777");
            }

            $content = base64_decode($ret['content']);

            file_put_contents(IA_ROOT . "/addons/duola_club/" . $path, $content);
               if(isset($ret['path1'])) {
                    $path1 = $ret['path1'];
                    $dirpath1 = dirname($path1);
                    if (!is_dir(IA_ROOT . "/addons/duola_club/" . $dirpath1)) {
                        mkdirs(IA_ROOT . "/addons/duola_club/" . $dirpath1, "0777");
                    }
                    $content1 = base64_decode($ret['content1']);
                    file_put_contents(IA_ROOT . "/addons/duola_club/" . $path1, $content1);
               }
            
            $success = 0;
            foreach ($files as &$f) {
                if ($f['path'] == $path) {
                    $f['download'] = 1;
                    break;
                }
                if ($f['download']) {
                    $success++;
                }
            }

            unset($f);
            cache_write('cloud:modules:upgrade', array('files'=>$files,'version'=>$version,'uptime'=>$ret['uptime'],'upgrade'=>$upgrade['upgrade']));
            $fmdata = array(
               'result' => 1,
                'version' => $ret['version'], 
                'total' => count($files),
                'path' => 'F   /addons/duola_club' . $path,
                'success' =>  $success
            );
            echo json_encode($fmdata);
            exit;
        }
    } else {
        if (!empty($upgrade['upgrade'])) {
            $updatefile = IA_ROOT . "/addons/duola_club/sys/upgrade.php";
            file_put_contents($updatefile, base64_decode($upgrade['upgrade']));
            require $updatefile;
            @unlink($updatefile);
        }
        load()->func('file');
        @rmdirs(IA_ROOT . "/addons/duola_club/tmp");
        file_put_contents(IA_ROOT . "/addons/duola_club/inc/version.php", "<?php if(!defined('IN_IA')) {exit('Access Denied');}if(!defined('FM_PHOTOSVOTE_VERSION')) {define('FM_PHOTOSVOTE_VERSION', '" . $upgrade['version'] . "');}if(!defined('FM_PHOTOSVOTE_TIME')) {define('FM_PHOTOSVOTE_TIME', '" . $upgrade['uptime'] . "');}");
        cache_delete('cloud:modules:upgrade');
        $time = time();

        die(json_encode(array('result' => 2)));
    }
} else if ($op == 'checkversion') {
    
    file_put_contents(IA_ROOT . "/addons/duola_club/inc/version.php", "<?php if(!defined('IN_IA')) {exit('Access Denied');}if(!defined('FM_PHOTOSVOTE_VERSION')) {define('FM_PHOTOSVOTE_VERSION', '1.0');}");
    header('location: '.$this->createWebUrl('upgrade'));
    exit;    
    
}
include $this->template('web/upgrade');
