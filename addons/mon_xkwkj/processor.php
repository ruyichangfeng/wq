<?php

defined('IN_IA') or exit('Access Denied');
define("MON_XKWKJ", "mon_xkwkj");
require_once IA_ROOT . "/addons/" . MON_XKWKJ . "/dbutil.class.php";
require_once IA_ROOT . "/addons/" . MON_XKWKJ . "/monUtil.class.php";
require_once IA_ROOT . "/addons/" . MON_XKWKJ . "/value.class.php";

class Mon_XKWkjModuleProcessor extends WeModuleProcessor {

    public function respond() {

        global $_W;
        $this->weid = IMS_VERSION < 0.6 ? $_W['weid'] : $_W['uniacid'];

       // $json =  json_encode($this->message);
       // return   $this->respText($json);

        //二维码扫描
        if ($this->message['msgtype'] == 'event' &&
            ($this->message['event'] == 'SCAN' ||  $this->message['event'] == 'subscribe')) {
            $ticket = $this->message['ticket'];

            $poster = DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_POSTER, array(':ticket'=> $ticket));

            if (empty($poster)) {
                return   $this->respText("参数二维码已删除,或不存在!");
            } else {
                //参加活动
                if (empty($poster['uid']) && !empty($poster['kid'])) {

                    $xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $poster['kid']);

                    $news = array ();
                    $news [] = array ('title' => $xkwkj['title'], 'description' =>'',
                        'picurl' => '',
                        'url' => $this->createMobileUrl ( 'auth',array('kid'=>$poster['kid'],'au'=>Value::$REDIRECT_USER_INDEX))  );
                    return $this->respNews ( $news );
                }  else if (!empty($poster['uid']) && !empty($poster['kid'])) {
                    $user = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER, $poster['uid']);
                    $helpUrl =  $this->createMobileUrl('Auth', array('kid' => $poster['kid'], 'uid' => $poster['uid'], 'au' => 4));
                    $news = array ();
                    $news [] = array ('title' => '欢迎帮"'.$user['nickname'].'"好友砍价!', '', 'picurl' => '', 'url' => $helpUrl  );
                    return $this->respNews ( $news );
                }
            }
        }

        $rid = $this->rule;
        $reply = pdo_fetch("select * from ".tablename(DBUtil::$TABLE_XKWKJ_REPLY)." where rid=:rid",array(":rid"=>$rid));

        $xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $reply['kid']);
        if(empty($xkwkj)) {
            return   $this->respText("砍价活动删除或不存在");
        }

        if(empty($reply)){
            return   $this->respText("砍价活动删除或不存在");
        }

       // $json =  json_encode($this->message);
        //return   $this->respText($json);
        //exit;
        //var_dump($this->message);


        $content = $this->message['content'];
        $pos = strpos(strtolower($content), 'bk');
        if ($pos === false)
        {
                $news = array ();
                $news [] = array ('title' => $reply['new_title'], 'description' =>$reply['new_content'],
                    'picurl' => MonUtil::getpicurl( $reply ['new_icon'] ),
                    'url' => $this->createMobileUrl ( 'auth',array('kid'=>$reply['kid'],'au'=>Value::$REDIRECT_USER_INDEX))  );
                return $this->respNews ( $news );
        }

        else
        {

            $content = strtolower($content);
            $friend_id = substr($content, stripos($content, "bk") + 2);
            $user = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER, $friend_id);

            if (empty($user)) {
                return   $this->respText("帮砍用户不存在,或已删除,请仔细核对您的砍价关键词!!");
            }

            $msgContent = trim($xkwkj['fk_fist_tip']);
            $msg_arr = explode("\r\n", $msgContent);
            if (count($msg_arr) == 1) {
                $desc =  $msg_arr[0];
            } else {
                $desc =  $msg_arr[rand(0, count($msg_arr) - 1)];
            }

            $helpUrl =  $this->createMobileUrl('Auth', array('kid' => $reply['kid'], 'uid' => $user['id'], 'au' => 4));

            $news = array ();
            $news [] = array ('title' => '欢迎帮"'.$user['nickname'].'"好友砍价!', 'description' =>$desc, 'picurl' => MonUtil::getpicurl( $reply ['new_icon'] ), 'url' => $helpUrl  );
            return $this->respNews ( $news );

           // return   $this->respText($friend_id);
        }
    }

}
