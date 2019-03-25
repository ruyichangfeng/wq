<?php
defined('IN_IA') or exit('Access Denied');
class Xuan_js_Member
{
   function get_uidopenid(){
       global $_W;
       if (empty($_W['fans']['nickname'])) {
            mc_oauth_userinfo();
            }
       /* if (empty($_W['fans']['nickname'])) {
             die("<!DOCTYPE html>
                        <html>
                            <head>
                                <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
                                <title>抱歉，出错了</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
                            </head>
                            <body>
                            <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请使用微信访问！</h4></div></div></div>
                            </body>
                        </html>");
            }*/
            
       $a= array('uid'=>$_W['fans']['uid'],
                'openid'=>$_W['fans']['openid']);
       return $a;
   }
   function getconfig(){
        global $_W;
        $sql = 'SELECT `settings` FROM ' . tablename('uni_account_modules') . ' WHERE `uniacid` = :uniacid AND `module` = :module';
        $settings = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':module' => 'xuan_js'));
        $settings = iunserializer($settings);
        return $settings;
   }
   public function gettouxiang(){
       global $_W;

       $user = pdo_fetchall("SELECT avatar FROM ".tablename('mc_members')." WHERE  uniacid=:uniacid order by uid desc LIMIT 5", array('uniacid'=>$_W['uniacid']));
       return $user;
   }
   public function getinfo($uid,$field){
       global $_W;

       if ($field=="") {
           $field="*";
       }

       $user = pdo_fetch("SELECT ".$field." FROM ".tablename('mc_members')." WHERE uid = :uid and uniacid=:uniacid LIMIT 1", array(':uid' => $uid,'uniacid'=>$_W['uniacid']));
       return $user;
   }

    public function checkMember(){
        global $_W;
        if (strexists($_SERVER['REQUEST_URI'], '/web/')) {
            return;
        }
        if (empty($_W['fans']['nickname'])) {
            mc_oauth_userinfo();
            }
        if (empty($_W['fans']['nickname'])) {
             die("<!DOCTYPE html>
                        <html>
                            <head>
                                <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
                                <title>抱歉，出错了</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
                            </head>
                            <body>
                            <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请使用微信访问！</h4></div></div></div>
                            </body>
                        </html>");
            }
    }
    /*******获取此人是否点赞*********/
   public function getzan($uid,$fid){

        $sql = "SELECT id FROM " . tablename('xuan_js_zan') . " where fid=:fid and uid=:uid";
        //获取点赞
        $count = pdo_fetch($sql, array('fid'=>$fid,'uid'=>$uid));
       
        if ($count) {
            return 1;
        }else{
            return 0;
        }
   }
}