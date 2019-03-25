<?php
/**
 * 人才培养系统
 * 作者:少恭的文胸
 * qq : 908634674
 */
defined('IN_IA') or exit('Access Denied');

class dh_taskModule extends WeModule
{
    public $name = 'dh_taskModule';

    public function fieldsFormDisplay($rid = 0)
    {
        global $_W;
    }

    public function fieldsFormSubmit($rid = 0)
    {
        global $_GPC, $_W;
    }

    public function welcomeDisplay()
    {
        $url = $this->createWebUrl('fans', array('op' => 'display'));
        Header("Location: " . $url);
    }
}