<?php

/**
 * 微信排号
 *
 * @author chenyi
 */
defined('IN_IA') or exit('Access Denied');

class qk_paihaoModuleProcessor extends WeModuleProcessor {

    public function respond() {
        global $_W;
        $rid = $this->rule;
        if ($rid) {
            $reply = pdo_fetch("SELECT * FROM " . tablename('qk_paihao_reply') . " WHERE rid = :rid", array(':rid' => $rid));
            if ($reply) {
                $news = array(
                    array(
                        'title' => $reply['title'],
                        'description' => strip_tags($reply['description']),
                        'picurl' => tomedia($reply['thumb']),
                        'url' => $this->createMobileUrl('index', array('rid' =>$rid))
                ));
                return $this->respNews($news);
            }
        }
    }

}
