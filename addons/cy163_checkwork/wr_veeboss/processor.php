<?php
defined('IN_IA') or exit('Access Denied');

class wr_veebossModuleProcessor extends WeModuleProcessor
{

    public function isNeedInitContext()
    {
        return 0;
    }

    public function respond()
    {
        global $_W;
        $content = $this->message['content'];
    }

    public function isNeedSaveContext()
    {
        return false;
    }
}
