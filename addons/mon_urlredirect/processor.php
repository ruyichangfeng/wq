<?php

defined('IN_IA') or exit('Access Denied');
require IA_ROOT. '/addons/mon_urlredirect/core/defines.php';
require MON_URLREDIRECT_CORE. "util/dbutil.class.php";
require MON_URLREDIRECT_CORE. "util/monUtil.class.php";
require MON_URLREDIRECT_CORE. "/constants.class.php";

class Mon_urlredirectModuleProcessor extends WeModuleProcessor {

    public function respond() {
        $rid = $this->rule;
        $reply  = pdo_fetch("select * from ".tablename(DBUtil::$TABLE_URLREDIRECT_REPLY)." where rid=:rid",array(":rid"=>$rid));

        if (empty($reply)) {
            return $this->respText("跳转删除或不存在！");
        }

        $news = array ();
        $news [] = array ('title' => $reply['new_title'],
            'description' =>$reply['new_content'],
            'picurl' => MonUtil::getPicUrl($reply ['new_icon'] ),

            'url' => MonUtil::getMobileUrl($this->createMobileUrl('redirectcenter', array('redid' => $reply['redid'])))  );

        return $this->respNews ( $news );

    }
}
